<?php
/**
* NOTICE OF LICENSE
*
* This source file is subject to the Software License Agreement
* that is bundled with this package in the file LICENSE.txt.
* 
*  @author    Peter Sliacky
*  @copyright 2009-2016 Peter Sliacky
*  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0) 
*/

class AuthController extends AuthControllerCore
{
    private $opcModuleActive = -1; // -1 .. not set, 0 .. inactive, 1 .. active

    private function isOpcModuleActive()
    {
        // fallback for mobile-enabled theme
        if (Configuration::get('OPC_MOBILE_FALLBACK') && $this->context->getMobileDevice())
            return false;

        // fallback when 5-step checkout is enabled
        if (Configuration::get('PS_ORDER_PROCESS_TYPE') == '0')
            return false;

        // fallback for paypal express checkout
        if (isset($this->context->cookie->express_checkout) && Configuration::get('OPC_PAYPAL_EXPRESS_FALLBACK'))
            return false;

        if ($this->opcModuleActive > -1)
            return $this->opcModuleActive;

        $opc_mod_script = _PS_MODULE_DIR_ . 'onepagecheckout/onepagecheckout.php';
        if (file_exists($opc_mod_script)) {
            require_once($opc_mod_script);
            $opc_mod               = new OnePageCheckout();
            $this->opcModuleActive = (Tools::getValue('opc-debug') == 1900)?true:((Tools::getValue('opc-debug') == 1901)?false:$opc_mod->active);
        } else {
            $this->opcModuleActive = 0;
        }
        return $this->opcModuleActive;
    }

    protected function processSubmitAccount()
    {
        if (!$this->isOpcModuleActive())
            return parent::processSubmitAccount();

        // Entire override is here just because of rigid address set-up. Original PS do not expect
        // address being set to cart prior to processSubmitAccount call and thus always creates new Address
        $inv_first_on = (Configuration::get('OPC_INVOICE_FIRST') == "1");
        Hook::exec('actionBeforeSubmitAccount');
        $this->create_account = true;
        if (Tools::isSubmit('submitAccount'))
            $this->context->smarty->assign('email_create', 1);
        // New Guest customer
        if (!Tools::getValue('is_new_customer', 1) && !Configuration::get('PS_GUEST_CHECKOUT_ENABLED'))
            $this->errors[] = Tools::displayError('You cannot create a guest account.');

        // Customer (not-guest) checkout, password field is hidden and password is automatically generated
        if ((!Tools::getIsset('passwd') || trim(Tools::getValue('passwd')) == "") &&
            trim(Tools::getValue('email')) != "" &&
            Configuration::get('OPC_CREATE_CUSTOMER_PASSWORD') &&
            !CustomerCore::customerExists(Tools::getValue('email'))
        ) {
            $_POST['is_new_customer'] = 1;
            $_POST['passwd'] = Tools::passwdGen(5);
        }
        elseif (!Tools::getValue('is_new_customer', 1))
            $_POST['passwd'] = md5(time()._COOKIE_KEY_);

        if (Tools::getIsset('guest_email') && Tools::getValue('guest_email'))
            $_POST['email'] = Tools::getValue('guest_email');
        // Checked the user address in case he changed his email address
        if (Validate::isEmail($email = Tools::getValue('email')) && !empty($email))
            if (Customer::customerExists($email))
                $this->errors[] = Tools::displayError('An account is already registered with this e-mail.', false);
        // Preparing customer
        $customer = new Customer();
        $_POST['lastname'] = Tools::getValue('customer_lastname');
        $_POST['firstname'] = Tools::getValue('customer_firstname');

//        if (Configuration::get('PS_ONE_PHONE_AT_LEAST') && !Tools::getValue('phone') && !Tools::getValue('phone_mobile') &&
//            (Configuration::get('PS_REGISTRATION_PROCESS_TYPE') || Configuration::get('PS_GUEST_CHECKOUT_ENABLED')))
//            $this->errors[] = Tools::displayError('You must register at least one phone number');

        $error_phone = false;
        if (Configuration::get('PS_ONE_PHONE_AT_LEAST'))
        {
            $inv_suffix = ($inv_first_on)?"_invoice":"";
            if (Tools::isSubmit('submitGuestAccount') || !Tools::getValue('is_new_customer'))
            {
                if (!Tools::getValue('phone'.$inv_suffix) && !Tools::getValue('phone_mobile'.$inv_suffix))
                    $error_phone = true;
            }
            elseif (((Configuration::get('PS_REGISTRATION_PROCESS_TYPE') || Configuration::get('PS_ORDER_PROCESS_TYPE'))
                && (Configuration::get('PS_ORDER_PROCESS_TYPE') && !Tools::getValue('email_create')))
                && (!Tools::getValue('phone'.$inv_suffix) && !Tools::getValue('phone_mobile'.$inv_suffix)))
                $error_phone = true;
            elseif (((Configuration::get('PS_REGISTRATION_PROCESS_TYPE') && Configuration::get('PS_ORDER_PROCESS_TYPE') && Tools::getValue('email_create')))
                && (!Tools::getValue('phone'.$inv_suffix) && !Tools::getValue('phone_mobile'.$inv_suffix)))
                $error_phone = true;
        }

        if ($error_phone)
            $this->errors[] = Tools::displayError('You must register at least one phone number.');


        $this->errors = array_unique(array_merge($this->errors, $customer->validateController()));

        // Check the requires fields which are settings in the BO
        $this->errors = array_merge($this->errors, $customer->validateFieldsRequiredDatabase());

        if (!Configuration::get('PS_REGISTRATION_PROCESS_TYPE') && !$this->ajax && !Tools::isSubmit('submitGuestAccount'))
        {

            if (!count($this->errors))
            {
                if (Tools::isSubmit('newsletter'))
                    $this->processCustomerNewsletter($customer);
                $customer->birthday = (!Tools::getValue('years') ? '' : (int)Tools::getValue('years').'-'.(int)Tools::getValue('months').'-'.(int)Tools::getValue('days'));
                if (!Validate::isBirthDate($customer->birthday))
                    $this->errors[] = Tools::displayError('Invalid birthday.');
                $customer->active = 1;
                // New Guest customer
                if (Tools::isSubmit('is_new_customer'))
                    $customer->is_guest = !Tools::getValue('is_new_customer', 1);
                else
                    $customer->is_guest = 0;
                if (!count($this->errors))
                    if (!$customer->add())
                        $this->errors[] = Tools::displayError('An error occurred while creating your account.');
                    else
                    {
                        if (!$customer->is_guest)
                            if (!$this->sendConfirmationMail($customer))
                                $this->errors[] = Tools::displayError('Cannot send e-mail');

                        $this->updateContext($customer);

                        $this->context->cart->update();
                        Hook::exec('actionCustomerAccountAdd', array(
                            '_POST' => $_POST,
                            'newCustomer' => $customer
                        ));
                        if ($this->ajax)
                        {
                            $return = array(
                                'hasError' => !empty($this->errors),
                                'errors' => $this->errors,
                                'isSaved' => true,
                                'id_customer' => (int)$this->context->cookie->id_customer,
                                'id_address_delivery' => $this->context->cart->id_address_delivery,
                                'id_address_invoice' => $this->context->cart->id_address_invoice,
                                'token' => Tools::getToken(false)
                            );
                            die(Tools::jsonEncode($return));
                        }
                        // redirection: if cart is not empty : redirection to the cart
                        if (count($this->context->cart->getProducts(true)) > 0)
                            Tools::redirect('index.php?controller=order&multi-shipping='.(int)Tools::getValue('multi-shipping'));
                        // else : redirection to the account
                        else
                            Tools::redirect('index.php?controller=my-account');
                    }
            }

        }
        else // if registration type is in one step, we save the address
        {



            $lastnameAddress = ($inv_first_on) ? Tools::getValue('lastname_invoice') : Tools::getValue('lastname');
            $firstnameAddress = ($inv_first_on) ? Tools::getValue('firstname_invoice') : Tools::getValue('firstname');

            // Preparing address

            $id_address = isset($this->context->cart->id_address_delivery) ? (int)$this->context->cart->id_address_delivery : 0;
            if ($id_address > 0)
                $address = new Address($id_address);
            else
                $address = new Address();

            $_POST['lastname'] = $lastnameAddress;
            $_POST['firstname'] = $firstnameAddress;
            $address->id_customer = 1;
            $this->errors = array_unique(array_merge($this->errors, $address->validateController()));

            // US customer: normalize the address
            if (version_compare(_PS_VERSION_, "1.6.0") < 0 && $address->id_country == Country::getByIso('US'))
            {
                include_once(_PS_TAASC_PATH_.'AddressStandardizationSolution.php');
                $normalize = new AddressStandardizationSolution;
                $address->address1 = $normalize->AddressLineStandardization($address->address1);
                $address->address2 = $normalize->AddressLineStandardization($address->address2);
            }

            $inv_suffix = ($inv_first_on)?"_invoice":"";
            $country = new Country((int)Tools::getValue('id_country'.$inv_suffix));
            if ($country->need_zip_code)
            {
                if (($postcode = Tools::getValue('postcode'.$inv_suffix)) && $country->zip_code_format)
                {
                    if (!$country->checkZipCode($postcode))
                        $this->errors[] = sprintf(
                            Tools::displayError('Zip/Postal code is invalid. Must be typed as follows: %s'),
                            str_replace('C', $country->iso_code, str_replace('N', '0', str_replace('L', 'A', $country->zip_code_format)))
                        );
                }
                elseif ($country->zip_code_format && !$this->context->cart->isVirtualCart())
                    $this->errors[] = Tools::displayError('Zip/Postal code is required.');
                elseif ($postcode && !preg_match('/^[0-9a-zA-Z -]{4,9}$/ui', $postcode))
                    $this->errors[] = Tools::displayError('Zip/Postal code is invalid.');
            }

            /*if ($country->need_identification_number && (!Tools::getValue('dni') || !Validate::isDniLite(Tools::getValue('dni'))))
                $this->errors[] = Tools::displayError('Identification number is incorrect or has already been used.');
            elseif (!$country->need_identification_number)
		    $address->dni = null;*/
        }

        if (!@checkdate(Tools::getValue('months'), Tools::getValue('days'), Tools::getValue('years')) && !(Tools::getValue('months') == '' && Tools::getValue('days') == '' && Tools::getValue('years') == ''))
            $this->errors[] = Tools::displayError('Invalid date of birth');

        if (!count($this->errors))
        {
            if (Customer::customerExists(Tools::getValue('email')))
                $this->errors[] = Tools::displayError('An account is already registered with this e-mail, please enter your password or request a new one.', false);
            if (Tools::isSubmit('newsletter'))
                $this->processCustomerNewsletter($customer);

            $customer->birthday = (!Tools::getValue('years') ? '' : (int)Tools::getValue('years').'-'.(int)Tools::getValue('months').'-'.(int)Tools::getValue('days'));
            if (!Validate::isBirthDate($customer->birthday))
                $this->errors[] = Tools::displayError('Invalid birthday.');

            if (!count($this->errors))
            {
                // if registration type is in one step, we save the address
                if (Configuration::get('PS_REGISTRATION_PROCESS_TYPE'))
                    if (!($country = new Country($address->id_country, Configuration::get('PS_LANG_DEFAULT'))) || !Validate::isLoadedObject($country))
                        die(Tools::displayError());
                $contains_state = isset($country) && is_object($country) ? (int)$country->contains_states: 0;
                $id_state = isset($address) && is_object($address) ? (int)$address->id_state: 0;
                if (/*Configuration::get('PS_REGISTRATION_PROCESS_TYPE') &&*/ $contains_state && !$id_state)
                    $this->errors[] = Tools::displayError('This country requires a state selection.');
                else
                {
                    $customer->active = 1;
                    // New Guest customer
                    if (Tools::isSubmit('is_new_customer'))
                        $customer->is_guest = !Tools::getValue('is_new_customer', 1);
                    else
                        $customer->is_guest = 0;
                    if (!$customer->add())
                        $this->errors[] = Tools::displayError('An error occurred while creating your account.');
                    else
                    {
                        $address->id_customer = (int)$customer->id;

                        if (Tools::getValue('alias') == Tools::getValue('default_alias') && Tools::getValue('address1') && trim(Tools::getValue('address1')) != "")
                                                     $_POST['alias'] = Tools::substr(preg_replace('/[;#]/', '_', Tools::getValue('address1')),0,32);

                        $this->errors = array_unique(array_merge($this->errors, $address->validateController()));
                        if (!count($this->errors) && (Configuration::get('PS_REGISTRATION_PROCESS_TYPE') || $this->ajax || Tools::isSubmit('submitGuestAccount')))
                            if (($address->id > 0 && !$address->update()) || (!($address->id > 0) && !$address->add()))
                            $this->errors[] = Tools::displayError('An error occurred while creating your address.');
                        else
                        {
                            if (!$customer->is_guest)
                            {
                                $this->context->customer = $customer;
                                $customer->cleanGroups();
                                // we add the guest customer in the default customer group
                                $customer->addGroups(array((int)Configuration::get('PS_CUSTOMER_GROUP')));
                                if (!$this->sendConfirmationMail($customer))
                                    $this->errors[] = Tools::displayError('Cannot send e-mail');
                            }
                            else
                            {
                                $customer->cleanGroups();
                                // we add the guest customer in the guest customer group
                                $customer->addGroups(array((int)Configuration::get('PS_GUEST_GROUP')));
                            }
                            $this->updateContext($customer);
                            $this->context->cart->id_address_delivery = Address::getFirstCustomerAddressId((int)$customer->id);
                            if ($this->context->cart->id_address_invoice == 0)
                              $this->context->cart->id_address_invoice = Address::getFirstCustomerAddressId((int)$customer->id);

                            // If a logged guest logs in as a customer, the cart secure key was already set and needs to be updated
                            $this->context->cart->update();

                            // Avoid articles without delivery address on the cart
                            $this->context->cart->autosetProductAddress();

                            Hook::exec('actionCustomerAccountAdd', array(
                                '_POST' => $_POST,
                                'newCustomer' => $customer
                            ));
                            if ($this->ajax)
                            {
                                $return = array(
                                    'hasError' => !empty($this->errors),
                                    'errors' => $this->errors,
                                    'isSaved' => true,
                                    'id_customer' => (int)$this->context->cookie->id_customer,
                                    'id_address_delivery' => $this->context->cart->id_address_delivery,
                                    'id_address_invoice' => $this->context->cart->id_address_invoice,
                                    'token' => Tools::getToken(false)
                                );
                                die(Tools::jsonEncode($return));
                            }
                            // if registration type is in two steps, we redirect to register address
                            if (!Configuration::get('PS_REGISTRATION_PROCESS_TYPE') && !$this->ajax && !Tools::isSubmit('submitGuestAccount'))
                                Tools::redirect('index.php?controller=address');
                            if ($back = Tools::getValue('back'))
                                Tools::redirect($back);
                            Tools::redirect('index.php?controller=my-account');
                            // redirection: if cart is not empty : redirection to the cart
                            if (count($this->context->cart->getProducts(true)) > 0)
                                Tools::redirect('index.php?controller=order&multi-shipping='.(int)Tools::getValue('multi-shipping'));
                            // else : redirection to the account
                            else
                                Tools::redirect('index.php?controller=my-account');
                        }
                    }
                }
            }
        }

        if (count($this->errors))
        {
            //for retro compatibility to display guest account creation form on authentication page
            if (Tools::getValue('submitGuestAccount'))
                $_GET['display_guest_checkout'] = 1;

            if (!Tools::getValue('is_new_customer'))
                unset($_POST['passwd']);
            if ($this->ajax)
            {
                $return = array(
                    'hasError' => !empty($this->errors),
                    'errors' => $this->errors,
                    'isSaved' => false,
                    'id_customer' => 0
                );
                die(Tools::jsonEncode($return));
            }
            $this->context->smarty->assign('account_error', $this->errors);
        }
    }
}
