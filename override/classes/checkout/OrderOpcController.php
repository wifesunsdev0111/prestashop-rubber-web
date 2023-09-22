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

class OrderOpcController extends OrderOpcControllerCore
{



    public $php_self = 'order-opc';
    public $isLogged;

    private $opc_templates_path;
    private $opc_config;

    private $inv_first_on;
    private $default_ps_carriers;

    private function _assignOpcSettings()
    {
        // verification keys: VK##2
        $opc_module_file = _PS_MODULE_DIR_ . "onepagecheckout/onepagecheckout.php";
        if (file_exists($opc_module_file)) {
            require_once($opc_module_file);
            $opc_mod          = new OnePageCheckout();
            $this->opc_config = $opc_mod->_getAllOptionsValues();
            $this->context->smarty->assign("opc_config", $this->opc_config);
        }
    }

    private function _setExtraDivPaymentBlock()
    {
        // count opening divs versus closing ones in order-payment.tpl and add one
        // more div tag in payment if necessary - to fix layout issues on some themes (e.g. matrice)

//        $header_file_content = @file_get_contents(_PS_THEME_DIR_ . 'order-payment.tpl');
//        $opening_divs = substr_count($header_file_content, "<div");
//        $closing_divs = substr_count($header_file_content, "</div");
//        $this->context->smarty->assign("add_extra_div", ($opening_divs < $closing_divs)?$closing_divs-$opening_divs:false);
        $this->context->smarty->assign("add_extra_div", false);
    }

    private $opcModuleActive = -1; // -1 .. not set, 0 .. inactive, 1 .. active

    private function isOpcModuleActive()
    {
        // fallback for mobile-enabled theme
        if (Configuration::get('OPC_MOBILE_FALLBACK') && $this->context->getMobileDevice())
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

    private function isPS15() {
        return version_compare(_PS_VERSION_, "1.6") < 0;
    }


    public function init()
    {
        if (!$this->isOpcModuleActive())
            return parent::init();

        // Estonian smartpost and post24 support
        if (Tools::getIsset('id_carrier') && strpos(Tools::getValue('id_carrier'), ",")>0) {
            $_POST['id_carrier'] = Cart::intifier(Tools::getValue('id_carrier'));
        }    
            
        $this->opc_templates_path = _PS_MODULE_DIR_ . 'onepagecheckout/views/templates/front';
        //parent::init();
        $this->origInit();

        $this->_assignOpcSettings();

        $this->context->cart->setNoMultishipping(); // Multishipping is not supported and causes problems with state/zone switching


        // German law, goods return link
        if ($this->opc_config != null && $this->opc_config['goods_return_cms'] > 0) {
            $cms = new CMS((int)($this->opc_config['goods_return_cms']), (int)($this->context->language->id));
            $link_goods_return = $this->context->link->getCMSLink($cms, $cms->link_rewrite, true);
            if (!strpos($link_goods_return, '?'))
                $link_goods_return .= '?content_only=1';
            else
                $link_goods_return .= '&content_only=1';
            $this->context->smarty->assign("link_goods_return", $link_goods_return);
        }


        // OPCKT info block (below blockcart)
        $this->_setInfoBlockContent();

        $this->_setExtraDivPaymentBlock();

        if ($this->nbProducts)
            $this->context->smarty->assign('virtual_cart', false);

        $this->context->smarty->assign('is_multi_address_delivery', $this->context->cart->isMultiAddressDelivery() || ((int)Tools::getValue('multi-shipping') == 1));
        $this->context->smarty->assign('open_multishipping_fancybox', (int)Tools::getValue('multi-shipping') == 1);
        $this->context->smarty->assign('order_process_type', Configuration::get('PS_ORDER_PROCESS_TYPE'));
        $this->context->smarty->assign('one_phone_at_least', (int)Configuration::get('PS_ONE_PHONE_AT_LEAST'));

        $this->inv_first_on = isset($this->opc_config) && isset($this->opc_config["invoice_first"]) && $this->opc_config["invoice_first"] == "1";
        $this->default_ps_carriers =isset($this->opc_config) && isset($this->opc_config["default_ps_carriers"]) && $this->opc_config["default_ps_carriers"] == "1";

        if (version_compare(_PS_VERSION_, "1.5.2.0") <= 0)
            $this->isLogged = (bool)($this->context->customer->id && Customer::customerIdExistsStatic((int)$this->context->cookie->id_customer));

        if ($this->context->cart->nbProducts()) {
            if (Tools::isSubmit('ajax')) {
                if (Tools::isSubmit('method')) {
                    switch (Tools::getValue('method')) {
                        case 'updateMessage':
                            if (Tools::isSubmit('message')) {
                                $txtMessage = urldecode(Tools::getValue('message'));
                                $this->_updateMessage($txtMessage);
                                if (count($this->errors))
                                    die('{"hasError" : true, "errors" : ["' . implode('\',\'', $this->errors) . '"]}');
                                die(true);
                            }
                            break;

                        case 'updateCarrierAndGetPayments':
                            if ((Tools::isSubmit('delivery_option') || Tools::isSubmit('id_carrier')) && Tools::isSubmit('recyclable') && Tools::isSubmit('gift') && Tools::isSubmit('gift_message')) {
                                $this->_assignWrappingAndTOS();

                                // Address has changed, so we check if the cart rules still apply
                                CartRule::autoRemoveFromCart($this->context);
                                CartRule::autoAddToCart($this->context);

                                if ($this->_processCarrier()) {
                                    $carriers = $this->context->cart->simulateCarriersOutput();
                                    $return   = array_merge(array(
                                        'HOOK_TOP_PAYMENT'   => Hook::exec('displayPaymentTop'),
                                        'HOOK_PAYMENT'       => $this->_getPaymentMethods(),
                                        'carrier_data'       => $this->_getCarrierList(),
                                        'HOOK_BEFORECARRIER' => Hook::exec('displayBeforeCarrier', array('carriers' => $carriers))
                                    ),$this->getFormatedSummaryDetail());
                                    Cart::addExtraCarriers($return);
                                    die(Tools::jsonEncode($return));
                                } else
                                    $this->errors[] = Tools::displayError('Error occurred while updating cart.');
                                if (count($this->errors))
                                    die('{"hasError" : true, "errors" : ["' . implode('\',\'', $this->errors) . '"]}');
                                exit;
                            }
                            break;

                        case 'updateTOSStatusAndGetPayments':
                            if (Tools::isSubmit('checked')) {
                                $this->context->cookie->checkedTOS = (int)(Tools::getValue('checked'));
                                die(Tools::jsonEncode(array(
                                    //'HOOK_TOP_PAYMENT' => Hook::exec('displayPaymentTop'),
                                    //'HOOK_PAYMENT'     => $this->_getPaymentMethods()
                                )));
                            }
                            break;
                        case 'updatePaymentsOnly':
                            die(Tools::jsonEncode(array(
                                'HOOK_TOP_PAYMENT' => Hook::exec('displayPaymentTop'),
                                'HOOK_PAYMENT'     => self::_getPaymentMethods()
                            )));
                            break;
                        case 'getCarrierList':
                            $this->context->smarty->assign('isVirtualCart', $this->context->cart->isVirtualCart());
                            $result = $this->_getCarrierList();
                            $result = array_merge($result, array(
                                //opckt
                                'HOOK_TOP_PAYMENT'      => Hook::exec('displayPaymentTop'),
                                'HOOK_PAYMENT'          => $this->_getPaymentMethods(),
                            ), $this->getFormatedSummaryDetail());
                            die(Tools::jsonEncode($result));
                            break;

                        case 'editCustomer':
                            if (!$this->isLogged)
                                exit;
                            if (Tools::getValue('years'))
                                $this->context->customer->birthday = (int)Tools::getValue('years') . '-' . (int)Tools::getValue('months') . '-' . (int)Tools::getValue('days');
                            // opckt
                            if (trim(Tools::getValue('customer_lastname')) == "")
                                $_POST['customer_lastname'] = ($this->inv_first_on)? Tools::getValue('lastname_invoice') : Tools::getValue('lastname');
                            if (trim(Tools::getValue('customer_firstname')) == "")
                                $_POST['customer_firstname'] = ($this->inv_first_on)? Tools::getValue('firstname_invoice') : Tools::getValue('firstname');

                            $this->errors                        = $this->context->customer->validateController();
                            $this->context->customer->newsletter = (int)Tools::isSubmit('newsletter');
                            $this->context->customer->optin      = (int)Tools::isSubmit('optin');
                            $return                              = array(
                                'hasError'    => !empty($this->errors),
                                'errors'      => $this->errors,
                                'id_customer' => (int)$this->context->customer->id,
                                'token'       => Tools::getToken(false)
                            );
                            if (!count($this->errors))
                                $return['isSaved'] = (bool)$this->context->customer->update();
                            else
                                $return['isSaved'] = false;
                            die(Tools::jsonEncode($return));
                            break;

                        case 'getAddressBlockAndCarriersAndPayments':
                            if ($this->context->customer->isLogged()) {
                                // check if customer have addresses
                                if (!Customer::getAddressesTotalById($this->context->customer->id))
                                    die(Tools::jsonEncode(array('no_address' => 1)));
                                if (file_exists(_PS_MODULE_DIR_ . 'blockuserinfo/blockuserinfo.php')) {
                                    include_once(_PS_MODULE_DIR_ . 'blockuserinfo/blockuserinfo.php');
                                    $blockUserInfo = new BlockUserInfo();
                                }
                                $this->context->smarty->assign('isVirtualCart', $this->context->cart->isVirtualCart());
                                $customer      = $this->context->customer;
                                $customer_info = array(
                                    "id"         => $customer->id,
                                    "email"      => $customer->email,
                                    "id_gender"  => $customer->id_gender,
                                    "birthday"   => $customer->birthday,
                                    "newsletter" => $customer->newsletter,
                                    "optin"      => $customer->optin,
                                    "is_guest"   => $customer->is_guest
                                );

                                $this->_processAddressFormat();
                                $this->_assignAddress();

                                //opckt
                                $address_delivery = $this->context->smarty->tpl_vars['delivery']->value;
                                $address_invoice  = $this->context->smarty->tpl_vars['invoice']->value;


                                if (Configuration::get('VATNUMBER_MANAGEMENT') &&
                                    file_exists(_PS_MODULE_DIR_ . '/vatnumber/vatnumber.php') &&
                                    !class_exists("VatNumber", false)
                                ) {
                                    include_once (_PS_MODULE_DIR_ . '/vatnumber/vatnumber.php');
                                }

                                if (isset($address_delivery) && Configuration::get('VATNUMBER_MANAGEMENT') AND
                                    file_exists(dirname(__FILE__) . '/../../modules/vatnumber/vatnumber.php') &&
                                        VatNumber::isApplicable($address_delivery->id_country) &&
                                        Configuration::get('VATNUMBER_COUNTRY') != $address_delivery->id_country
                                )
                                    $allow_eu_vat_delivery = 1;
                                else
                                    $allow_eu_vat_delivery = 0;

                                if (isset($address_invoice) && Configuration::get('VATNUMBER_MANAGEMENT') AND
                                    file_exists(dirname(__FILE__) . '/../../modules/vatnumber/vatnumber.php') &&
                                        VatNumber::isApplicable($address_invoice->id_country) &&
                                        Configuration::get('VATNUMBER_COUNTRY') != $address_invoice->id_country
                                )
                                    $allow_eu_vat_invoice = 1;
                                else
                                    $allow_eu_vat_invoice = 0;


                                // Wrapping fees
                                $wrapping_fees_tax = new Tax((int)(Configuration::get('PS_GIFT_WRAPPING_TAX')));
                                if (version_compare(_PS_VERSION_, "1.5.2.0") <= 0) {
                                    $wrapping_fees = (float)(Configuration::get('PS_GIFT_WRAPPING_PRICE'));
                                    $wrapping_fees_tax_inc = $wrapping_fees * (1 + (((float)($wrapping_fees_tax->rate) / 100)));
                                } else {
                                    $wrapping_fees = $this->context->cart->getGiftWrappingPrice(false);
                                    $wrapping_fees_tax_inc = $wrapping_fees = $this->context->cart->getGiftWrappingPrice();
                                }


                                $return                = array_merge(array(
                                    // opckt
                                    'customer_info'         => $customer_info,
                                    'allow_eu_vat_delivery' => $allow_eu_vat_delivery,
                                    'allow_eu_vat_invoice'  => $allow_eu_vat_invoice,
                                    'customer_addresses'    => $this->context->smarty->tpl_vars['addresses']->value,
                                    //'order_opc_adress' => $this->context->smarty->fetch($this->opc_templates_path.'/order-address.tpl'),
                                    'block_user_info'       => (isset($blockUserInfo) ? (method_exists($blockUserInfo,'hookTop') ? $blockUserInfo->hookTop(array()):$blockUserInfo->hookDisplayTop(array())) : ''),
                                    'carrier_data'          => $this->_getCarrierList(),
                                    'HOOK_TOP_PAYMENT'      => Hook::exec('displayPaymentTop'),
                                    'HOOK_PAYMENT'          => $this->_getPaymentMethods(),
                                    'no_address'            => 0,
                                    'gift_price'            => Tools::displayPrice(Tools::convertPrice(Product::getTaxCalculationMethod() == 1 ? $wrapping_fees : $wrapping_fees_tax_inc, new Currency((int)($this->context->cookie->id_currency))))
                                ), $this->getFormatedSummaryDetail());
                                die(Tools::jsonEncode($return));
                            }
                            die(Tools::displayError("Customer is not logged in, while he should be. Check please AuthController and cookies."));
                            break;

                        case 'makeFreeOrder':
                            /* Bypass payment step if total is 0 */
                            if (($id_order = $this->_checkFreeOrder()) && $id_order) {
                                $order = new Order((int)$id_order);
                                $email = $this->context->customer->email;
                                if ($this->context->customer->is_guest)
                                    $this->context->customer->logout(); // If guest we clear the cookie for security reason
                                die('freeorder:' . $order->reference . ':' . $email);
                            }
                            exit;
                            break;

                        case 'updateAddressesSelected':
                            // opckt
                            $id_address_delivery = (int)(Tools::getValue('id_address_delivery'));
                            $id_address_invoice  = (int)(Tools::getValue('id_address_invoice'));
                            $address_delivery    = new Address((int)(Tools::getValue('id_address_delivery')));
                            $address_invoice     = ((int)(Tools::getValue('id_address_delivery')) == (int)(Tools::getValue('id_address_invoice')) ? $address_delivery : new Address((int)(Tools::getValue('id_address_invoice'))));

                            if (Configuration::get('VATNUMBER_MANAGEMENT') &&
                                file_exists(_PS_MODULE_DIR_ . '/vatnumber/vatnumber.php') &&
                                !class_exists("VatNumber", false)
                            ) {
                                include_once (_PS_MODULE_DIR_ . '/vatnumber/vatnumber.php');
                            }

                            if (isset($address_delivery) && Configuration::get('VATNUMBER_MANAGEMENT') &&
                                file_exists(_PS_MODULE_DIR_.'/vatnumber/vatnumber.php') &&
                                    VatNumber::isApplicable($address_delivery->id_country) &&
                                    Configuration::get('VATNUMBER_COUNTRY') != $address_delivery->id_country
                            )
                                $allow_eu_vat_delivery = 1;
                            else
                                $allow_eu_vat_delivery = 0;

                            if (isset($address_invoice) && Configuration::get('VATNUMBER_MANAGEMENT') AND
                                file_exists(_PS_MODULE_DIR_.'/vatnumber/vatnumber.php') &&
                                    VatNumber::isApplicable($address_invoice->id_country) &&
                                    Configuration::get('VATNUMBER_COUNTRY') != $address_invoice->id_country
                            )
                                $allow_eu_vat_invoice = 1;
                            else
                                $allow_eu_vat_invoice = 0;

                            $address_delivery = new Address((int)(Tools::getValue('id_address_delivery')));
                            $this->context->smarty->assign('isVirtualCart', $this->context->cart->isVirtualCart());
                            $address_invoice = ((int)(Tools::getValue('id_address_delivery')) == (int)(Tools::getValue('id_address_invoice')) ? $address_delivery : new Address((int)(Tools::getValue('id_address_invoice'))));
                            if (($address_delivery->id_customer && $address_delivery->id_customer != $this->context->customer->id) || ($address_invoice->id_customer && $address_invoice->id_customer != $this->context->customer->id))
                            {
                                 //$this->errors[] = Tools::displayError('This address is not yours.');
                                $this->errors = "not_your_address";
                            }
                            if (!Address::isCountryActiveById((int)(Tools::getValue('id_address_delivery'))))
                                $this->errors[] = Tools::displayError('This address is not in a valid area.');
                            elseif (!Validate::isLoadedObject($address_delivery) || !Validate::isLoadedObject($address_invoice) || $address_invoice->deleted || $address_delivery->deleted)
                                $this->errors[] = Tools::displayError('This address is invalid.');
                            else {

                                // Update delivery option if we had to create new address
                                if ($id_address_delivery != (int)($this->context->cart->id_address_delivery))
                                {
                                    $delivery_option = Tools::unSerialize($this->context->cart->delivery_option);
                                    $delivery_option[$id_address_delivery] = $delivery_option[(int)($this->context->cart->id_address_delivery)];
                                    unset($delivery_option[(int)($this->context->cart->id_address_delivery)]);
                                    $this->context->cart->delivery_option = serialize($delivery_option);
                                }

                                $this->context->cart->id_address_delivery = (int)(Tools::getValue('id_address_delivery'));
                                $this->context->cart->id_address_invoice  = Tools::isSubmit('same') ? $this->context->cart->id_address_delivery : (int)(Tools::getValue('id_address_invoice'));
                                if (!$this->context->cart->update())
                                    $this->errors[] = Tools::displayError('An error occurred while updating your cart.');

                                // Address has changed, so we check if the cart rules still apply
                                CartRule::autoRemoveFromCart($this->context);
                                CartRule::autoAddToCart($this->context);

                                // we will force NoMultishipping setting, as that's not very well done yet and causes problems with carriers,
                                // let alone the complex UI for customer.
                                //if (!$this->context->cart->isMultiAddressDelivery())
                                    $this->context->cart->setNoMultishipping(); // As the cart is no multishipping, set each delivery address lines with the main delivery address

                                if (!count($this->errors)) {
                                    $result = $this->_getCarrierList();

                                    $wrapping_fees_tax = new Tax((int)(Configuration::get('PS_GIFT_WRAPPING_TAX')));
                                    if (version_compare(_PS_VERSION_, "1.5.2.0") <= 0) {
                                        $wrapping_fees = (float)(Configuration::get('PS_GIFT_WRAPPING_PRICE'));
                                        $wrapping_fees_tax_inc = $wrapping_fees * (1 + (((float)($wrapping_fees_tax->rate) / 100)));
                                    } else {
                                        $wrapping_fees = $this->context->cart->getGiftWrappingPrice(false);
                                        $wrapping_fees_tax_inc = $wrapping_fees = $this->context->cart->getGiftWrappingPrice();
                                    }


                                    $result                = array_merge($result, array(
                                        //opckt
                                        'allow_eu_vat_delivery' => $allow_eu_vat_delivery,
                                        'allow_eu_vat_invoice'  => $allow_eu_vat_invoice,
                                        'HOOK_TOP_PAYMENT'      => Hook::exec('displayPaymentTop'),
                                        'HOOK_PAYMENT'          => $this->_getPaymentMethods(),
                                        'gift_price'            => Tools::displayPrice(Tools::convertPrice(Product::getTaxCalculationMethod() == 1 ? $wrapping_fees : $wrapping_fees_tax_inc, new Currency((int)($this->context->cookie->id_currency)))),
                                        'carrier_data'          => $this->_getCarrierList()
                                    ), $this->getFormatedSummaryDetail());
                                    die(Tools::jsonEncode($result));
                                }
                            }
                            if (count($this->errors))
                                die(Tools::jsonEncode(array(
                                    'hasError' => true,
                                    'errors'   => $this->errors
                                )));
                            break;

                        case 'multishipping':
                            $this->_assignSummaryInformations();
                            $this->context->smarty->assign('product_list', $this->context->cart->getProducts());

                            if ($this->context->customer->id)
                                $this->context->smarty->assign('address_list', $this->context->customer->getAddresses($this->context->language->id));
                            else
                                $this->context->smarty->assign('address_list', array());
                            $this->setTemplate(_PS_THEME_DIR_ . 'order-address-multishipping-products.tpl');
                            $this->display();
                            die();
                            break;

                        case 'cartReload':
                            $this->_assignSummaryInformations();
                            if ($this->context->customer->id)
                                $this->context->smarty->assign('address_list', $this->context->customer->getAddresses($this->context->language->id));
                            else
                                $this->context->smarty->assign('address_list', array());
                            $this->context->smarty->assign('opc', true);
                            $this->setTemplate(_PS_THEME_DIR_ . 'shopping-cart.tpl');
                            $this->display();
                            die();
                            break;

                        case 'noMultiAddressDelivery':
                            $this->context->cart->setNoMultishipping();
                            die();
                            break;

                        // OPCKT added:
                        case 'emailCheck':
                            if (Tools::isSubmit('cust_email')) {
                                $customer_email = Tools::getValue('cust_email');
                                $is_registered  = (Validate::isEmail($customer_email)) ? Customer::customerExists($customer_email) : 0;
                                $return         = array(
                                    'is_registered' => $is_registered
                                );
                                die(Tools::jsonEncode($return));
                            }
                            break;
                        case 'zipCheck':
                            if (Tools::isSubmit('id_country')) {

                                $id_country = Tools::getValue('id_country');
                                if ($id_country > 0) {
                                    $errors = array();

                                    $country         = new Country($id_country);
                                    $zip_code_format = $country->zip_code_format;
                                    if ($country->need_zip_code) {
                                        if (($postcode = Tools::getValue('postcode')) AND $zip_code_format) {
                                            $zip_regexp = '/^' . $zip_code_format . '$/ui';
                                            $zip_regexp = str_replace(' ', '( |)', $zip_regexp);
                                            $zip_regexp = str_replace('-', '(-|)', $zip_regexp);
                                            $zip_regexp = str_replace('N', '[0-9]', $zip_regexp);
                                            $zip_regexp = str_replace('L', '[a-zA-Z]', $zip_regexp);
                                            $zip_regexp = str_replace('C', $country->iso_code, $zip_regexp);
                                            if (!preg_match($zip_regexp, $postcode))
                                                $errors[] = '<strong>' . Tools::displayError('Zip/ Postal code') . '</strong> ' . Tools::displayError('is invalid.') . '<br />' . Tools::displayError('Must be typed as follows:') . ' ' . str_replace('C', $country->iso_code, str_replace('N', '0', str_replace('L', 'A', $zip_code_format)));
                                        } elseif ($zip_code_format)
                                            $errors[] = '<strong>' . Tools::displayError('Zip/ Postal code') . '</strong> ' . Tools::displayError('is required.');
                                        elseif ($postcode AND !preg_match('/^[0-9a-zA-Z -]{4,9}$/ui', $postcode))
                                            $errors[] = '<strong>' . Tools::displayError('Zip/ Postal code') . '</strong> ' . Tools::displayError('is invalid.') . '<br />' . Tools::displayError('Must be typed as follows:') . ' ' . str_replace('C', $country->iso_code, str_replace('N', '0', str_replace('L', 'A', $zip_code_format)));
                                    }

                                } //if($id_country>0)

                                $return = array(
                                    'is_ok'  => empty($errors),
                                    'errors' => $errors
                                );
                                die(Tools::jsonEncode($return));
                            }
                            break;
//                        case 'opcAddDiscount':
//
//                            if (CartRule::isFeatureActive()) {
//                                if (!($code = trim(Tools::getValue('discount_name'))))
//                                    $this->errors[] = Tools::displayError('You must enter a voucher code');
//                                elseif (!Validate::isCleanHtml($code))
//                                    $this->errors[] = Tools::displayError('Voucher code invalid');
//                                else {
//                                    if (($cartRule = new CartRule(CartRule::getIdByCode($code))) && Validate::isLoadedObject($cartRule)) {
//                                        if ($error = $cartRule->checkValidity($this->context, false, true))
//                                            $this->errors[] = $error;
//                                        else {
//                                            $this->context->cart->addCartRule($cartRule->id);
//                                            // je tu redirect preto, ze tak je to aj v defaulte a naviac, v cart-summary.js sa location.reload
//                                            // opat vynucuje ak vouchery neboli zobrazene.
//                                            Tools::redirect('index.php?controller=order-opc');
//                                        }
//                                    } else
//                                        $this->errors[] = Tools::displayError('This voucher does not exists');
//                                }
//
//                                if (sizeof($this->errors)) {
//                                    die('{"hasError" : true, "discount_name" : "'.Tools::safeOutput($code).'", "errors" : ["' . implode('\',\'', $this->errors) . '"]}');
//                                }
//                            }
//                            break;
//
//                        case 'opcDeleteDiscount':
//                            if (CartRule::isFeatureActive()) {
//                                if (($id_cart_rule = (int)Tools::getValue('discountId')) && Validate::isUnsignedId($id_cart_rule)) {
//                                    $this->context->cart->removeCartRule($id_cart_rule);
//                                    Tools::redirect('index.php?controller=order-opc');
//                                }
//                            }
//                            break;

                        default:
                            throw new PrestaShopException('Unknown method "' . Tools::getValue('method') . '"');
                    }
                } else
                    throw new PrestaShopException('Method is not defined');
            }
        } elseif (Tools::isSubmit('ajax'))
            throw new PrestaShopException('Method is not defined');
    }

    private function addCssIfExists($path) {
        if (file_exists(_PS_MODULE_DIR_ . 'onepagecheckout/views/css/' . $path )) {
            $this->addCSS(_MODULE_DIR_ . 'onepagecheckout/views/css/' . $path );
            return true;
        } else {
            return false;
        }
    }

    public function setMedia()
    {
        if (!$this->isOpcModuleActive())
            return parent::setMedia();

        $this->origSetMedia();
        //parent::setMedia();

        // mobilne zariadenia budu momentalne supportovane v rezime takom,
        // ze sa pouzije standardny obj. formular, bez aktivneho modulu.
        //if ($this->context->getMobileDevice() == false)
        //{
        // Adding CSS style sheet

        // If custom styling is ON, template related styles and also default "transparent" styles are not used.
        $custom_suffix = ($this->opc_config['use_custom_styling'] > 0)?"-custom":"";

        if ($this->opc_config['use_custom_styling'] == 0)
          $this->addCSS(_THEME_CSS_DIR_ . 'order-opc.css'); // Prestashop's default checkout styling

        // opckt: Adding CSS style sheet - mostly empty, customization possible; with custom suffix, all styles are overriden
        $this->addCssIfExists('base'.$custom_suffix.'.css');

        // base theme specific styling
        if ($this->opc_config['use_custom_styling'] == 0 || !$this->addCssIfExists('themes/'. _THEME_NAME_ . '/base'.$custom_suffix.'.css'))
            $this->addCssIfExists('themes/'. _THEME_NAME_ . '/base.css');


        // opckt: 2/3-column OPC checkout stylesheet
        if ($this->opc_config['three_column_opc'] > 0) {
            $this->addCSS(_MODULE_DIR_ . 'onepagecheckout/views/css/three-column'.$custom_suffix.'.css');
            if ($this->opc_config['use_custom_styling'] == 0 || !$this->addCssIfExists('themes/'. _THEME_NAME_ . '/three-column'.$custom_suffix.'.css'))
                $this->addCssIfExists('themes/'. _THEME_NAME_ . '/three-column.css');
        } elseif ($this->opc_config['two_column_opc'] > 0) {
            $this->addCSS(_MODULE_DIR_ . 'onepagecheckout/views/css/two-column'.$custom_suffix.'.css');
            if ($this->opc_config['use_custom_styling'] == 0 || !$this->addCssIfExists('themes/'. _THEME_NAME_ . '/two-column'.$custom_suffix.'.css'))
                $this->addCssIfExists('themes/'. _THEME_NAME_ . '/two-column.css');
        } else {
            $this->addCSS(_MODULE_DIR_ . 'onepagecheckout/views/css/single-column'.$custom_suffix.'.css');
            if ($this->opc_config['use_custom_styling'] == 0 || !$this->addCssIfExists('themes/'. _THEME_NAME_ . '/single-column'.$custom_suffix.'.css'))
                $this->addCssIfExists('themes/'. _THEME_NAME_ . '/single-column.css');
        }

        if ($this->opc_config['responsive_layout'] > 0)
            $this->addCssIfExists('responsive.css');

        // opckt: Adding JS files
        $this->addJS(_MODULE_DIR_ . 'onepagecheckout/views/js/jquery_cookie.js');

        $this->addJS(_MODULE_DIR_ . 'onepagecheckout/views/js/order-opc.js');
        $this->addJqueryPlugin('scrollTo');
        //}
        //else
        //    $this->addJS(_THEME_MOBILE_JS_DIR_.'opc.js');
        //$this->addJS(_THEME_JS_DIR_ . 'tools/statesManagement.js');
        $this->addJS(_MODULE_DIR_ . 'onepagecheckout/views/js/statesManagement.js');

    }


    private function _setInfoBlockContent()
    {
        if (file_exists($this->opc_templates_path . "/info-block-content.tpl")) {
            $info_block_content = $this->context->smarty->fetch($this->opc_templates_path . "/info-block-content.tpl");
        } else {
            $info_block_content = "";
        }
        $this->context->smarty->assign("info_block_content", $info_block_content);
    }

    private function _setCarrierSelection($checked = null)
    {
        if ($checked == null)
            $checked = $this->context->cart->simulateCarrierSelectedOutput();
        $checked                         = ((int)Cart::desintifier($checked));
        $this->context->cart->id_carrier = $checked;
        $this->context->cart->update();
        CartRule::autoRemoveFromCart($this->context);
        CartRule::autoAddToCart($this->context);
    }

    public function initContent()
    {
        // Upsell integration
        $internal_referrer = isset($_SERVER['HTTP_REFERER']) && (strstr($_SERVER['HTTP_REFERER'], Dispatcher::getInstance()->createUrl('order-opc', $this->context->cookie->id_lang)));
        $upsell = @Module::getInstanceByName('upsell');
        if ($upsell && $upsell->active && !(Tools::getValue('skip_offers') == 1 || $internal_referrer)) {
            ParentOrderController::initContent(); // We need this to display the page properly (parent of overriden controller)
            $upsell->getUpsells();
            $this->template = $upsell->setTemplate('upsell-products.tpl');
        } else {

            if (!$this->isOpcModuleActive())
                return parent::initContent();

// Fix dummyvalue when checkout visited prior to log-in from default PS
if ($this->context->cart->id_address_delivery > 0)
    $address_c = new Address($this->context->cart->id_address_delivery);


if ($this->isLogged && is_object($address_c) && $address_c->firstname == 'dummyvalue' && $address_c->lastname == 'dummyvalue') {
    $addresses_c = Customer::getLastTwoCustomerAddressIds( $this->context->customer->id);
    if (count($addresses_c)) {
        $address_new_id = array_shift($addresses_c);
        if ($address_new_id > 0) {

            // Update delivery option if we had to create new address
            if ($address_new_id != (int)($this->context->cart->id_address_delivery))
            {
                $delivery_option = Tools::unSerialize($this->context->cart->delivery_option);
                $delivery_option[$address_new_id] = $delivery_option[(int)($this->context->cart->id_address_delivery)];
                unset($delivery_option[(int)($this->context->cart->id_address_delivery)]);
                $this->context->cart->delivery_option = serialize($delivery_option);
            }
    

            $this->context->cart->id_address_delivery = $address_new_id;
            $this->context->cart->id_address_invoice = $address_new_id;
            $this->context->cart->update();
        }
    }
}


            
            // parent::initContent(); - toto by volalo celu metodu aj s volanim sablony z default themy
            $this->origInitContent();

            $this->_setCarrierSelection();

            // SHOPPING CART
            $this->_assignSummaryInformations();
            // WRAPPING AND TOS
            $this->_assignWrappingAndTOS();

            $selectedCountry = (int)(Configuration::get('PS_COUNTRY_DEFAULT'));

            if (Configuration::get('PS_RESTRICT_DELIVERED_COUNTRIES'))
                $countries = Carrier::getDeliveredCountries($this->context->language->id, true, true);
            else
                $countries = Country::getCountries($this->context->language->id, true);

            // If a rule offer free-shipping, force hidding shipping prices
            $free_shipping = false;
            foreach ($this->context->cart->getCartRules() as $rule)
                if ($rule['free_shipping'] && !$rule['carrier_restriction'])
                {
                    $free_shipping = true;
                    break;
                }

            $this->context->smarty->assign(array(
                'free_shipping' => $free_shipping,
                'isLogged' => $this->isLogged,
                'isGuest' => isset($this->context->cookie->is_guest) ? $this->context->cookie->is_guest : 0,
                'countries' => $countries,
                'sl_country' => isset($selectedCountry) ? $selectedCountry : 0,
                'PS_GUEST_CHECKOUT_ENABLED' => Configuration::get('PS_GUEST_CHECKOUT_ENABLED'),
                'errorCarrier' => Tools::displayError('You must choose a carrier before', false),
                'errorTOS' => Tools::displayError('You must accept the Terms of Service before', false),
                'isPaymentStep' => (bool)(Tools::getIsset('isPaymentStep') && Tools::getValue('isPaymentStep')),
                'genders' => Gender::getGenders(),
            ));
            /* Call a hook to display more information on form */
            $this->context->smarty->assign(array(
                'HOOK_CREATE_ACCOUNT_FORM' => Hook::exec('displayCustomerAccountForm'),
                'HOOK_CREATE_ACCOUNT_TOP' => Hook::exec('displayCustomerAccountFormTop')
            ));
            $years = Tools::dateYears();
            $months = Tools::dateMonths();
            $days = Tools::dateDays();
            $this->context->smarty->assign(array(
                'years' => $years,
                'months' => $months,
                'days' => $days,
            ));

            /* Load guest informations */
            //if ($this->isLogged && $this->context->cookie->is_guest) // opckt changed.
            if ($this->isLogged)
                $this->context->smarty->assign('guestInformations', $this->_getGuestInformations());


            // OPCKT default address update - in case customer is not yet logged-in and address is not
            // yet entered and refresh happens
            if ($this->context->cart->id_address_delivery > 0) {
                $def_address = new Address($this->context->cart->id_address_delivery);
                $def_country = $def_address->id_country;
                $def_state = $def_address->id_state;
            } else {
                $def_country = 0;
                $def_state = 0;
            }
            if ($this->context->cart->id_address_invoice > 0) {
                $def_address_invoice = new Address($this->context->cart->id_address_invoice);
                $def_country_invoice = $def_address_invoice->id_country;
                $def_state_invoice = $def_address_invoice->id_state;
            } else {
                $def_country_invoice = 0;
                $def_state_invoice = 0;
            }

            if ($this->context->cart->id_address_delivery > 0 && $this->context->cart->id_address_invoice > 0 &&
                $this->context->cart->id_address_delivery != $this->context->cart->id_address_invoice
            )
                $def_different_billing = 1;
            else
                $def_different_billing = 0;

            $this->context->smarty->assign('def_different_billing', $def_different_billing);
            $this->context->smarty->assign('def_country', $def_country);
            $this->context->smarty->assign('def_state', $def_state);
            $this->context->smarty->assign('def_country_invoice', $def_country_invoice);
            $this->context->smarty->assign('def_state_invoice', $def_state_invoice);


            if ($this->isLogged)
                $this->_assignAddress(); // ADDRESS
            // CARRIER
            $this->_assignCarrier();
            // PAYMENT
            $this->_assignPayment();
            Tools::safePostVars();

            if (!$this->context->cart->isMultiAddressDelivery())
                $this->context->cart->setNoMultishipping(); // As the cart is no multishipping, set each delivery address lines with the main delivery address
            // cart-summary
            $summary = $this->context->cart->getSummaryDetails(null, true); // to force refresh on product.id_address_delivery
            $this->_assignSummaryInformations();

            $blocknewsletter = Module::getInstanceByName('blocknewsletter');
            $this->context->smarty->assign('newsletter', (bool)($blocknewsletter && $blocknewsletter->active));


            //$this->_processAddressFormat(); - v OPC module to nepotrebujeme, to je len format
            // "offline" needitovatelnej adresy


            //$this->setTemplate(_PS_THEME_DIR_.'order-opc.tpl');
            $this->context->smarty->assign('opc_templates_path', $this->opc_templates_path);
            $this->context->smarty->assign('twoStepCheckout', false); // TODO: hardcoded value!
            //$this->context->smarty->assign('paypal_express_checkout_on', isset($this->context->cookie->express_checkout));

            $online_country = new Country($this->opc_config['online_country_id']);
            if ($online_country->active)
                $this->context->smarty->assign('onlineCountryActive', true);


            if (Tools::isSubmit('cart-only')) {
                $this->context->smarty->assign('onlyCartSummary', '1');
                $this->context->smarty->assign('order_process_type', Configuration::get('PS_ORDER_PROCESS_TYPE'));
                $this->setTemplate('shopping-cart.tpl');
            } else {
                $this->setTemplate('order-opc.tpl');
            }
        }
    }

    public function _getTemplatePath() {
        return $this->opc_templates_path . '/';
    }

    public function setTemplate($template)
    {
        if (Tools::file_exists_cache(_PS_THEME_DIR_.'modules/onepagecheckout/'.$template))
            $this->template = _PS_THEME_DIR_.'modules/onepagecheckout/'.$template;
        elseif (Tools::file_exists_cache($this->_getTemplatePath().$template))
            $this->template = $this->_getTemplatePath().$template;
        else
            throw new PrestaShopException("Template '$template'' not found");
    }

    protected function _getGuestInformations()
    {
        if (!$this->isOpcModuleActive())
            return parent::_getGuestInformations();

        $customer         = $this->context->customer;
        $address_delivery = new Address($this->context->cart->id_address_delivery);

        if ($customer->birthday)
            $birthday = explode('-', $customer->birthday);
        else
            $birthday = array('0', '0', '0');

        $ret = array(
            'use_another_invoice_address' => (bool)((int)$this->context->cart->id_address_invoice != (int)$this->context->cart->id_address_delivery), # opc added
            'id_address_invoice'          => (int)$this->context->cart->id_address_invoice, # opc added
            'id_customer'                 => (int)$customer->id,
            'email'                       => Tools::htmlentitiesUTF8($customer->email),
            'customer_lastname'           => Tools::htmlentitiesUTF8($customer->lastname),
            'customer_firstname'          => Tools::htmlentitiesUTF8($customer->firstname),
            'newsletter'                  => (int)$customer->newsletter,
            'optin'                       => (int)$customer->optin,
            'id_address_delivery'         => (int)$this->context->cart->id_address_delivery,
            'company'                     => Tools::htmlentitiesUTF8($address_delivery->company),
            'lastname'                    => Tools::htmlentitiesUTF8($address_delivery->lastname),
            'firstname'                   => Tools::htmlentitiesUTF8($address_delivery->firstname),
            'vat_number'                  => Tools::htmlentitiesUTF8($address_delivery->vat_number),
            'dni'                         => Tools::htmlentitiesUTF8($address_delivery->dni),
            'address1'                    => Tools::htmlentitiesUTF8($address_delivery->address1),
            'address2'                    => Tools::htmlentitiesUTF8($address_delivery->address2),
            'postcode'                    => Tools::htmlentitiesUTF8($address_delivery->postcode),
            'city'                        => Tools::htmlentitiesUTF8($address_delivery->city),
            'other'                       => Tools::htmlentitiesUTF8($address_delivery->other),
            'phone'                       => Tools::htmlentitiesUTF8($address_delivery->phone),
            'phone_mobile'                => Tools::htmlentitiesUTF8($address_delivery->phone_mobile),
            'alias'                       => Tools::htmlentitiesUTF8($address_delivery->alias),
            'id_country'                  => (int)($address_delivery->id_country),
            'id_state'                    => (int)($address_delivery->id_state),
            'id_gender'                   => (int)$customer->id_gender,
            'sl_year'                     => $birthday[0],
            'sl_month'                    => $birthday[1],
            'sl_day'                      => $birthday[2]
        );

        if ($this->inv_first_on || ((int)$this->context->cart->id_address_invoice != (int)$this->context->cart->id_address_delivery)) {
            $address_invoice   = new Address((int)$this->context->cart->id_address_invoice);
            $customers_address = ((int)($this->context->cookie->id_customer) == $address_invoice->id_customer) ? true : false;
            $invoice           = array(
                'id_country_invoice' => (int)($address_invoice->id_country),
                'id_state_invoice'   => (int)($address_invoice->id_state),
            );

            if (Configuration::get('VATNUMBER_MANAGEMENT') &&
                file_exists(_PS_MODULE_DIR_ . '/vatnumber/vatnumber.php') &&
                !class_exists("VatNumber", false)
            ) {
                include (_PS_MODULE_DIR_ . '/vatnumber/vatnumber.php');
            }

            if (Configuration::get('VATNUMBER_MANAGEMENT') AND
                file_exists(dirname(__FILE__) . '/../../modules/vatnumber/vatnumber.php') &&
                    VatNumber::isApplicable($address_invoice->id_country) &&
                    Configuration::get('VATNUMBER_COUNTRY') != $address_invoice->id_country
            )
                $allow_eu_vat = 1;
            else
                $allow_eu_vat = 0;

            // fill in customer's invoice address fields only when this address is "created"
            // otherwise, it's only estimation address with "temp" fields.
            if ($customers_address) {
                $addr = array(
                    'company_invoice'      => Tools::htmlentitiesUTF8($address_invoice->company),
                    'lastname_invoice'     => Tools::htmlentitiesUTF8($address_invoice->lastname),
                    'firstname_invoice'    => Tools::htmlentitiesUTF8($address_invoice->firstname),
                    'vat_number_invoice'   => Tools::htmlentitiesUTF8($address_invoice->vat_number),
                    'dni_invoice'          => Tools::htmlentitiesUTF8($address_invoice->dni),
                    'address1_invoice'     => Tools::htmlentitiesUTF8($address_invoice->address1),
                    'address2_invoice'     => Tools::htmlentitiesUTF8($address_invoice->address2),
                    'postcode_invoice'     => Tools::htmlentitiesUTF8($address_invoice->postcode),
                    'city_invoice'         => Tools::htmlentitiesUTF8($address_invoice->city),
                    'other_invoice'        => Tools::htmlentitiesUTF8($address_invoice->other),
                    'phone_invoice'        => Tools::htmlentitiesUTF8($address_invoice->phone),
                    'phone_mobile_invoice' => Tools::htmlentitiesUTF8($address_invoice->phone_mobile),
                    'alias_invoice'        => Tools::htmlentitiesUTF8($address_invoice->alias),
                    'allow_eu_vat_invoice' => $allow_eu_vat
                );
            } else {
                $addr = array(

                );
            }

            $invoice = array_merge($invoice, $addr);
            $ret     = array_merge($ret, $invoice);
        }

        return $ret;
    }

    protected function _assignCarrier()
    {
        if (!$this->isOpcModuleActive())
            return parent::_assignCarrier();

        //$carriers = Carrier::getCarriersForOrder(Country::getIdZone((int) Configuration::get('PS_COUNTRY_DEFAULT')));
        $carriers = $this->context->cart->simulateCarriersOutput();
        if ($this->isLogged) {
            $address_delivery = new Address((int)($this->context->cart->id_address_delivery));
            if (!Address::isCountryActiveById((int)($this->context->cart->id_address_delivery)))
                unset($address_delivery);
            elseif (!Validate::isLoadedObject($address_delivery) OR $address_delivery->deleted)
                unset($address_delivery);
        }

        // zatial sa nevyplatil tento default sposob, nezohladnuje uz vybratehe "kosikoveho" carriera
//        $checked_arr = $this->context->cart->getDeliveryOption(null,false);
//        if (is_array($checked_arr))
//            $checked_carrier = (int)array_pop($checked_arr);
//        else
//            $checked_carrier = 0;
        $oldMessage = Message::getMessageByCartId((int)($this->context->cart->id));

        $vars = array(
            //'checked' => $this->_setDefaultCarrierSelection($carriers),
            //'checked' => $checked_carrier,
            'carriers'               => $carriers,
            'default_carrier'        => (int)(Configuration::get('PS_CARRIER_DEFAULT')),
            'oldMessage' => isset($oldMessage['message'])? $oldMessage['message'] : '',
            'HOOK_BEFORECARRIER'     => Hook::exec('displayBeforeCarrier', array(
                'carriers'             => $carriers,
                'checked'              => $this->context->cart->simulateCarrierSelectedOutput(),
                'delivery_option_list' => $this->context->cart->getDeliveryOptionList(),
                'delivery_option'      => $this->context->cart->getDeliveryOption(null, true)
            ))
        );

        Cart::addExtraCarriers($vars);

        $this->context->smarty->assign($vars); 
    }

    protected function _assignPayment()
    {
        if (!$this->isOpcModuleActive())
            return parent::_assignPayment();

        $this->context->smarty->assign(array(
            'HOOK_TOP_PAYMENT' => ($this->isLogged ? Hook::exec('displayPaymentTop') : ''),
            'HOOK_PAYMENT'     => $this->_getPaymentMethods()
        ));
    }

    private $payment_mod_id = 0;

    private function _genPaymentModId($matches)
    {
        return $matches[1] . ' id="opc_pid_' . $this->payment_mod_id++ . '"' . $matches[3];
    }

    protected function _getPaymentMethods()
    {
        if (!$this->isOpcModuleActive())
            return parent::_getPaymentMethods();

        if ($this->context->cart->OrderExists()) {
            $ret = '<p class="warning">' . Tools::displayError('Error: this order has already been validated') . '</p>';
            return array("orig_hook" => $ret, "parsed_content" => $ret);
        }

        $ret              = "";
        $address_delivery = new Address($this->context->cart->id_address_delivery);
        $address_invoice  = ($this->context->cart->id_address_delivery == $this->context->cart->id_address_invoice ? $address_delivery : new Address($this->context->cart->id_address_invoice));
        if (!$this->context->cart->id_address_delivery || !$this->context->cart->id_address_invoice || !Validate::isLoadedObject($address_delivery) || !Validate::isLoadedObject($address_invoice) || $address_invoice->deleted || $address_delivery->deleted)
            $ret = '<p class="warning">' . Tools::displayError('Error: please choose an address') . '</p>';
        if (count($this->context->cart->getDeliveryOptionList()) == 0 && !$this->context->cart->isVirtualCart()) {
            if ($this->context->cart->isMultiAddressDelivery())
                $ret .= '<p class="warning">' . Tools::displayError('Error: There are no carriers available that deliver to some of your addresses') . '</p>';
            else
                $ret .= '<p class="warning">' . Tools::displayError('Error: There are no carriers available that deliver to this address') . '</p>';
        }
        if (!$this->context->cart->getDeliveryOption(null, false) && !$this->context->cart->isVirtualCart())
            $ret = '<p class="warning">' . Tools::displayError('Error: please choose a carrier') . '</p>';
        if (!$this->context->cart->id_currency)
            $ret .= '<p class="warning">' . Tools::displayError('Error: no currency has been selected') . '</p>';
        //if (!$this->context->cookie->checkedTOS && Configuration::get('PS_CONDITIONS'))
        //	return '<p class="warning">'.Tools::displayError('Please accept the Terms of Service').'</p>';

        /* If some products have disappear */
        if (!$this->context->cart->checkQuantities())
            $ret .= '<p class="warning">' . Tools::displayError('An item in your cart is no longer available, you cannot proceed with your order.') . '</p>';

        /* Check minimal amount */
        $currency = Currency::getCurrency((int)$this->context->cart->id_currency);

        $minimalPurchase = Tools::convertPrice((float)Configuration::get('PS_PURCHASE_MINIMUM'), $currency);
        if ($this->context->cart->getOrderTotal(false, Cart::ONLY_PRODUCTS) < $minimalPurchase)
            $ret .= '<p class="warning">' . sprintf(
                Tools::displayError('A minimum purchase total of %s is required in order to validate your order.'),
                Tools::displayPrice($minimalPurchase, $currency)
            ) . '</p>';

        /* Bypass payment step if total is 0 */
        //if ($this->context->cart->getOrderTotal() <= 0)
        //    $ret .= '<p class="center"><input type="button" class="exclusive_large" name="confirmOrder" id="confirmOrder" value="' . Tools::displayError('I confirm my order') . '" onclick="confirmFreeOrder();" /></p>';

        if (trim($ret) != "") {
            return array("orig_hook" => $ret, "parsed_content" => $ret);
        }


        $opc_config        = $this->context->smarty->tpl_vars["opc_config"]->value;
        $tmp_customer_id_1 = (isset($opc_config) && isset($opc_config["payment_customer_id"])) ? (int)$opc_config["payment_customer_id"] : 0;

        $reset_id_customer = false;

        if (!$this->context->cookie->id_customer) {
            // if no customer set yet, use OPCKT default customer - created during installation
            $simulated_customer_id              = ($tmp_customer_id_1 > 0) ? $tmp_customer_id_1 : Customer::getFirstCustomerId();
            $this->context->cookie->id_customer = $simulated_customer_id;
            $reset_id_customer                  = true;

            if (!$this->context->customer->id) {
                $this->context->customer->id = $simulated_customer_id;
            }
        }

        $orig_context_country = $this->context->country;
        if (isset($address_invoice) && $address_invoice != null)
            $this->context->country = new Country($address_invoice->id_country);

        /* Bypass payment step if total is 0 */
        if ($this->context->cart->getOrderTotal() <= 0) {
            $return = $this->context->smarty->fetch($this->opc_templates_path . '/free-order-payment.tpl');
        } else {

            $ship2pay_support = (isset($opc_config) && isset($opc_config["ship2pay"]) && $opc_config["ship2pay"] == "1") ? true : false;
            if ($ship2pay_support) {
                $orig_id_carrier = $this->context->cart->id_carrier;
                $selected_carrier = Cart::desintifier($this->context->cart->simulateCarrierSelectedOutput());
                $selected_carrier = explode(",", $selected_carrier);
                $selected_carrier = $selected_carrier[0];

                $this->context->cart->id_carrier = $selected_carrier;
                $this->context->cart->update();
                //$return         = $this->_hookExecPaymentShip2pay($tmp_id_carrier);
                $return = Hook::exec('displayPayment');
                //$this->context->cart->id_carrier = $orig_id_carrier;
            } else
                $return = Hook::exec('displayPayment');
            //$return = Module::hookExecPayment();
        }

        $this->context->country = $orig_context_country;

        # restore cookie's id_customer
        if ($reset_id_customer) {
            unset($this->context->cookie->id_customer);
            $this->context->customer->id        = null;
        }

        # fix Moneybookers relative path to images
        $return = preg_replace('|src="modules\/|', 'src="' . __PS_BASE_URI__ . 'modules/', $return);

        # OPCKT fix Paypal relative path to redirect script
        $return = preg_replace('|href="modules\/|', 'href="' . __PS_BASE_URI__ . 'modules/', $return);

        if (!$return) {
            $ret = '<p class="warning">' . Tools::displayError('No payment method is available') . '</p>';
            return array("orig_hook" => $ret, "parsed_content" => $ret);
        }

        $non_parsed_payments = $return;
        // if radio buttons as payment turned on, parse payment methods, generate radio buttons and
        // hide original buttons; add large green checkout / submit button and also ensure on onepage.js
        // that after clicking that button appropriate payment button is pressed.
        $parsed_payments        = "";
        $parse_payment_methods = (isset($opc_config) && isset($opc_config["payment_radio_buttons"]) && $opc_config["payment_radio_buttons"] == "1") ? true : false;

        if ($parse_payment_methods) {

            $payment_modules_list = Hook::getHookModuleExecList('displayPayment');
         //print_r($payment_modules_list);

            $i = 0;
            $payment_methods = array();

            foreach ($payment_modules_list as $payment_module) {
                $orig_hook_content = Hook::exec('displayPayment', array(), $payment_module['id_module']);
                $parsed_hook_content = $orig_hook_content;

                if ($payment_module['module'] == 'stripejs') {


                    $whichMod = Module::getInstanceByName('stripejs');
                    if ($whichMod->author == 'Bellini Services')
                    {
                        // Stripejs by M.Bellini (gosh, both Stripejs modules with same name)
                        $re = "/(.*?img.*?src=\"(.*?)\".*?>\\s*(.*?)<\\/.*?<)a href.*?(.*?)<\\/a>(.*<input type=\"submit\")(.*)/ms";
                        $subst = "<div class=\"payment_module\"><a href=\"javascript:$('#stripe-form-container #stripe-payment-form-cc, #stripe-form-container #stripe-payment-form').submit()\"><img src=\"$2\" />$3<div id=\"stripe-form-container\"></div>     </a> </div>$1div href$4</div>$5 style=\"display:none\"$6";
                        $subst_styles = "<style>
                        .stripe-card-cvc-info {    font-style: italic;    display: inline-block;    cursor: pointer;    position: relative;    padding-bottom: 19px;}
                        .stripe-card-cvc-info div.cvc-info {	background-color: #BDE5F8;	border: #00529B solid 1px;	-moz-border-radius: 3px;	-webkit-border-radius: 3px;	border-radius: 3px;	color: #00529B!important;	display: none;	font-style: normal;	padding: 8px;	position: absolute;	right: -320px; top: -10px;	text-decoration: none;	width: 300px;}
                        .stripe-card-cvc-info:hover div.cvc-info { display: block; }
                        #paymentMethodsTable td {    vertical-align: baseline;}
                        #paymentMethodsTable #stripe-form-container label {    width: auto;    padding: 0.1em;}
                        </style>";
                        $orig_hook_content = preg_replace($re, $subst_styles.$subst, $orig_hook_content, 1);
                        // Don't skip further parsing, this was just pre-processing
                    } else {
                        // Stripejs by NTS (gosh, both Stripejs modules with same name) 

                        $isEmb = preg_match('/doEverySec()/i', $orig_hook_content);

                        // No-popup version (emb_payment.tpl):
                        if ($isEmb) {
                            //echo $orig_hook_content; exit;

                            $re = "/.*?stripe_title\"><img.*?>(.*?)<\\/h3>/ms";    
                            preg_match($re, $orig_hook_content, $matches);
                            $payment_methods[$i]['img']  = "modules/stripejs/views/img/stripe-cc.png";
                            $payment_methods[$i]['desc'] = $matches[1]."</label></td></tr><tr class=\"cc-form stripejs-nts-form-radio\"><td></td><td colspan=\"2\"><div id=\"stripejs-nts-form-container\"></div><label></a> </div>";
                            $payment_methods[$i]['link'] = "opc_pid_$i";
                            $i++;

                            $subst_styles = "<style>
                            button.stripe-submit-button { display: none!important; }
                            a.stripe-card-cvc-info div.cvc-info {right: auto !important;top: auto !important;}
                            #payments_section h3.stripe_title {background: none;color: black;text-shadow: none;box-shadow: none;margin-bottom: -15px!important;}
                            #stripejs-nts-form-container .stripe-payment-16 {border: medium none;}
                            #stripejs-nts-form-container #stripe-payment-form input[type=\"text\"] {margin-bottom: 0px;}
                            #paymentMethodsTable label.lowercase {width: auto;}
                            </style>";

                            $parsed_hook_content = str_replace('<a id="data_stripe_processing"', '<div class="payment_module hidden"><a id="opc_pid_' . $this->payment_mod_id++ . '" onclick="$(\'#stripe-payment-form\').submit()">Submit me</a></div><a id="data_stripe_processing"', $orig_hook_content);

                            $parsed_payments .= $subst_styles.$parsed_hook_content;
                            // Skip further parsing - parsing for radio buttons was done here
                            continue;
                        } else {
                            // Popup version (payment_tpl):
                            $re = "/.*?stripe_title\">(.*?)\\s*<.*?cc_btc_img.*?<img src=\"(.*?)\"/msi";
                            preg_match($re, $orig_hook_content, $matches);

                            $payment_methods[$i]['img']  = $matches[2];
                            $payment_methods[$i]['desc'] = $matches[1];
                            $payment_methods[$i]['link'] = "opc_pid_$i";
                            $i++;

                            $parsed_hook_content = str_replace('<h3 class="stripe_title">', '<a id="opc_pid_' . $this->payment_mod_id++ . '" onclick="$(\'#stripe-proceed-button\').click()" /><h3 class="stripe_title">', $orig_hook_content);

                            $parsed_payments .= $parsed_hook_content;
                            // Skip further parsing - parsing for radio buttons was done here
                            continue; 
                        }
                    }
                }
                if ($payment_module['module'] == 'paypalusa') {
                    // Paypal USA, Canada
                    $re = "/<form (action=\"https?:\\/\\/www.*?.paypal.com\\/cgi-bin\\/webscr\" method=\"post\">)\\s*<p class=\"payment_module\">(.*)(<input.*?src=\")(.*?)(\")(.*>)\\s*(.*?)\\s*<\\/p>(.*)/ms";
                    $subst = "<p class=\"payment_module\"><a href=\"javascript:$('form#paypalusa_payment').submit();\" title=\"$7\"><img src=\"$4\" alt=\"$7\" />$7</a></p><form id=\"paypalusa_payment\" $1$2$8";
                    $subst_styles="<style>#paymentMethodsTable img {max-height: 80px}</style>";
                    $orig_hook_content = preg_replace($re, $subst_styles.$subst, $orig_hook_content, 1);

                    // Paypal Mexico (same module name - 'paypalusa', but different layout template)
                  //  $re = "/.*src=\"(.*?)\".*/ms";
                    //$subst = "<p class=\"payment_module\"><a href=\"javascript:$('form#paypal-express-checkout-form').submit();\"><img src=\"modules/onepagecheckout/views/img/transparent.gif\" /><img style=\"max-height:80px\" src=\"$1\" /></a></p>";
                  //  $subst = "<p class=\"payment_module\"><a href=\"javascript:$('form#paypal-express-checkout-form').submit();\"><img src=\"$1\" />Paypal</a></p>";
                  //  $orig_hook_content = preg_replace($re, $subst, $orig_hook_content, 1);
                    
                    // Don't skip further parsing, this was just pre-processing
                }

                if ($payment_module['module'] == 'authorizeaim') {

                    $re = "/(.*?)<p class=\"payment_module\"\\s*>\\s+(<p style.*?<\\/p>)?\\s*(<form.*?>)(.*?)<a.*?>(.*?)([^>]*?)<\\/a>(.*aut2.*?src=\"(.*?)\".*\\/form>)\\s*<\\/p>(.*)/ms";
                    $subst = "<div class=\"payment_module\"><a href=\"javascript:$('#authorizeaim_form').submit()\"><img src=\"$8\" />$6</label></td></tr><tr class=\"cc-form authorizeaim-form-radio\"><td></td><td colspan=\"2\"><div id=\"authorizeaim-form-container\"></div><label></a> </div>$1$3$2$4$5$7$9";
                    $subst_styles = "<style>
                        #asubmit {display: none}
                        /*#aut2 {display: block!important}*/
                        #aut2 > div {display: none}
                        #aut2 > label { width: 110px !important; }
                        </style>
                        <script>
                           \$(document).on('click', 'tr.authorizeaim-form-radio', function() {
                                   \$('#aut2').show(); 
                                   \$(this).closest('tr').prev().find('input[name=id_payment_method]').first().prop('checked', true); 
                               });
                            \$('#payments_section').on('click', '#paymentMethodsTable tr', function() {
                                if(\$(this).next('tr.authorizeaim-form-radio').length) {
                                    \$('#aut2').show();
                                    \$(this).closest('tr').find('input[name=id_payment_method]').first().prop('checked', true);
                                }
                            });
                        </script>";
                    $orig_hook_content = preg_replace($re, $subst_styles.$subst, $orig_hook_content, 1);
                    // Don't skip further parsing, this was just pre-processing
                }

                if ($payment_module['module'] == 'atos') {
                    
                    $matches = array();
                    $re = "/.*?\"bold teaser\">(.*?)<\\/p>/msi";

                    $title = '';
                    preg_match($re, $orig_hook_content, $matches);
                    if (count($matches) && isset($matches[1]))
                        $title = $matches[1];

                    // Get list of payment card images (name + src)
                    $matches = array();
                    $re = "/<input type=image name=(.*?) .*? src=\"(.*?)\"/msi";
                    preg_match_all($re, $orig_hook_content, $matches);

                    if (count($matches) && isset($matches[1]) && isset($matches[2]))
                    {
                        $preHook = '';
                        for ($j=0;$j<count($matches[1]);$j++) {
                            $preHook .= '<p class="payment_module">
                                         <a title="'.$title.' '.$matches[1][$j].'" href="javascript:$(\'#atos_form input[name='.$matches[1][$j].']\').click();">
                                         <img src="'.$matches[2][$j].'" />
                                            '.$title.' '.$matches[1][$j].'
                                         </a>
                                         </p>';
                        } 
                    }

                    $re = "/(.*?\"bold teaser\">.*?<form )(.*)/msi";
                    $subst = $preHook."$1id=\"atos_form\" $2";
                    $orig_hook_content = preg_replace($re, $subst, $orig_hook_content, 1);
                }

                // pre-process, remove duplicated styles (class attributes when <img> is tag present):
                $preg_result = preg_replace(
                    '/(<a[^>]*?)(?:class="[^>]*?")([^>]*?>(?:(?!<\/a>).)*?<img(?:(?!<\/a>).)*?<\/a>)/msi',
                    "\\1 \\2",
                    $orig_hook_content
                );

                if ($preg_result != null) // NULL can be returned on backtrace limit exhaustion
                {
                    $orig_hook_content   = $preg_result;
                    $parsed_hook_content = $preg_result;
                }


                // regular payment modules
                preg_match_all(
                    '/<a.*?>(?:(?!<\/a>).)*?<img[^>]*?src="(.*?)".*?\/?>((?:(?!<\/a>).)*?)<\/a>/ms',
                    $orig_hook_content,
                    $matches1,
                    PREG_SET_ORDER
                );
                // Mark original payment modules with special id (regular payments)
                $preg_result = preg_replace_callback(
                    '/(<(a))([^>]*?>(?:(?!<\/a>).)*?<img(?:(?!<\/a>).)*?<\/a>)/ms',
                    array($this, "_genPaymentModId"),
                    $parsed_hook_content
                );
                if ($preg_result == null) {
                    //echo "ERRoR!";
                    //do nothing
                }
                if ($preg_result != null) // NULL can be returned on backtrace limit exhaustion
                {
                    $parsed_hook_content = $preg_result;
                }

                // moneybookers
                preg_match_all(
                    '/<input [^>]*?type="image".*?src="(.*?)".*?>.*?<span.*?>(.*?)<\/span>/ms',
                    $orig_hook_content,
                    $matches2,
                    PREG_SET_ORDER
                );
                // Mark original payment modules with special id (moneybookers)
                $preg_result = preg_replace_callback(
                    '/(<(input)[^>]*?type="image")(.*?<span.)/ms',
                    array($this, "_genPaymentModId"),
                    $parsed_hook_content
                );
                if ($preg_result != null)
                    $parsed_hook_content = $preg_result;

                // PS 1.6 bootstrap payments
                preg_match_all(
                    '/<a[^>]*?class=["\'](.*?)["\'].*?>(.*?)<\/a>/ms',
                    $orig_hook_content,
                    $matches3,
                    PREG_SET_ORDER
                );
                // Mark original payment modules with special id (PS1.6 bootstrap 'style' type payments)
                $preg_result = preg_replace_callback(
                    '/(<a[^>]*?class=["\'](.*?)["\'])([^>]*?>)/ms',
                    array($this, "_genPaymentModId"),
                    $parsed_hook_content
                );
                if ($preg_result != null)
                    $parsed_hook_content = $preg_result;



                $non_parsed_payments .= $orig_hook_content;
                $parsed_payments .= $parsed_hook_content;

                // Construct payments-radio buttons table

                // set class + special class name, then in JS handler get all such styles and set CSS background from original payments
                for ($k = 0; $k < count($matches3); $k++) {
                    $matches3[$k][3] = $matches3[$k][1]; // IMG class of original module
                    $matches3[$k][1] = preg_replace(
                            '|.*?themes\/|',
                            'themes/',
                            _THEME_IMG_DIR_
                        ) . $matches3[$k][1] . ".png";
                }

                $matches = array_merge($matches1, $matches2, $matches3);
                //print_r($matches);

                foreach ($matches as $match) {
                    $payment_methods[$i]['img']  = preg_replace('/(\r)?\n/m', " ", trim($match[1]));
                    $payment_methods[$i]['desc'] = preg_replace(
                        '/\s/m',
                        " ",
                        trim($match[2])
                    ); // fixed for Auriga payment
                    $payment_methods[$i]['link'] = "opc_pid_$i";
                    if (isset($match[3])) {
                        $payment_methods[$i]['class'] = trim($match[3]);
                    }
                    $i++;
                }

            } // foreach ($payment_modules_list as $payment_module)

//            echo "Parsed: ".$parsed_payments;
//            echo "Non-parsed: ".$non_parsed_payments;
//            print_r($payment_methods);
//            exit;

            $this->context->smarty->assign("payment_methods", $payment_methods);
            $radio_buttons = $this->context->smarty->fetch($this->opc_templates_path . "/payment-methods.tpl");
            $radio_buttons = str_replace("&amp;", "&", $radio_buttons);
        }//if ($parse_payment_methods)
        else {
            $parsed_payments = $non_parsed_payments;
        }


        return array("orig_hook" => $parsed_payments, "parsed_content" => $radio_buttons);
    }

    protected function _getCarrierList()
    {
        if (!$this->isOpcModuleActive())
            return parent::_getCarrierList();

        $address_delivery = new Address($this->context->cart->id_address_delivery);

        $cms             = new CMS(Configuration::get('PS_CONDITIONS_CMS_ID'), $this->context->language->id);
        $link_conditions = $this->context->link->getCMSLink($cms, $cms->link_rewrite, true);
        if (!strpos($link_conditions, '?'))
            $link_conditions .= '?content_only=1';
        else
            $link_conditions .= '&content_only=1';

        // If a rule offer free-shipping, force hidding shipping prices
        $free_shipping = false;
        foreach ($this->context->cart->getCartRules() as $rule)
            if ($rule['free_shipping'] && !$rule['carrier_restriction'])
            {
                $free_shipping = true;
                break;
            }

        $carriers              = $this->context->cart->simulateCarriersOutput();
        $delivery_option       = $this->context->cart->getDeliveryOption(null, false, false);

        $wrapping_fees_tax = new Tax((int)(Configuration::get('PS_GIFT_WRAPPING_TAX')));
        if (version_compare(_PS_VERSION_, "1.5.2.0") <= 0) {
            $wrapping_fees = (float)(Configuration::get('PS_GIFT_WRAPPING_PRICE'));
            $wrapping_fees_tax_inc = $wrapping_fees * (1 + (((float)($wrapping_fees_tax->rate) / 100)));
        } else {
            $wrapping_fees = $this->context->cart->getGiftWrappingPrice(false);
            $wrapping_fees_tax_inc = $wrapping_fees = $this->context->cart->getGiftWrappingPrice();
        }

        $oldMessage = Message::getMessageByCartId((int)($this->context->cart->id));

        $checked_carrier = $this->context->cart->simulateCarrierSelectedOutput();

        $this->_setCarrierSelection($checked_carrier);

        $vars                  = array(
            'free_shipping'               => $free_shipping,
            'checkedTOS'                  => (int)($this->context->cookie->checkedTOS),
            'recyclablePackAllowed'       => (int)(Configuration::get('PS_RECYCLABLE_PACK')),
            'giftAllowed'                 => (int)(Configuration::get('PS_GIFT_WRAPPING')),
            'cms_id'                      => (int)(Configuration::get('PS_CONDITIONS_CMS_ID')),
            'conditions'                  => (int)(Configuration::get('PS_CONDITIONS')),
            'link_conditions'             => $link_conditions,
            'recyclable'                  => (int)($this->context->cart->recyclable),
            'gift_wrapping_price'         => (float)(Configuration::get('PS_GIFT_WRAPPING_PRICE')),
            'total_wrapping_cost'         => Tools::convertPrice($wrapping_fees_tax_inc, $this->context->currency),
            'total_wrapping_tax_exc_cost' => Tools::convertPrice($wrapping_fees, $this->context->currency),
            'delivery_option_list'        => $this->context->cart->getDeliveryOptionList(),
            'carriers'                    => $carriers,
            'checked'                     => $checked_carrier,
            'delivery_option'             => $delivery_option,
            'address_collection'          => $this->context->cart->getAddressCollection(),
            'opc'                         => true,
            'oldMessage'                  => isset($oldMessage['message'])? $oldMessage['message'] : '',
            'HOOK_BEFORECARRIER'          => Hook::exec('displayBeforeCarrier', array(
                'carriers'             => $carriers,
                'delivery_option_list' => $this->context->cart->getDeliveryOptionList(),
                'delivery_option'      => $delivery_option
            ))
        );

        Cart::addExtraCarriers($vars);

        $this->context->smarty->assign($vars);
        $order_carrier_tpl = ($this->default_ps_carriers)?'/order-carrier-def.tpl':'/order-carrier.tpl';

        if (!Address::isCountryActiveById((int)($this->context->cart->id_address_delivery)) && $this->context->cart->id_address_delivery != 0)
            $this->errors[] = Tools::displayError('This address is not in a valid area.');
        elseif ((!Validate::isLoadedObject($address_delivery) || $address_delivery->deleted) && $this->context->cart->id_address_delivery != 0)
            $this->errors[] = Tools::displayError('This address is invalid.');
        else {
            $result = array(
                'HOOK_BEFORECARRIER' => Hook::exec('displayBeforeCarrier', array(
                    'carriers'             => $carriers,
                    'delivery_option_list' => $this->context->cart->getDeliveryOptionList(),
                    'delivery_option'      => $this->context->cart->getDeliveryOption(null, true)
                )),
                'carrier_block'      => $this->context->smarty->fetch($this->opc_templates_path . $order_carrier_tpl)
            );
            Cart::addExtraCarriers($result);
            return $result;
        }
        if (count($this->errors))
            return array(
                'hasError'      => true,
                'errors'        => $this->errors,
                'carrier_block' => $this->context->smarty->fetch($this->opc_templates_path . $order_carrier_tpl)
            );
    }

    protected function _processAddressFormat()
    {
        if (!$this->isOpcModuleActive())
            return parent::_processAddressFormat();

        $selectedCountry = (int)(Configuration::get('PS_COUNTRY_DEFAULT'));

        $address_delivery = new Address((int)$this->context->cart->id_address_delivery);
        $address_invoice  = new Address((int)$this->context->cart->id_address_invoice);

        $inv_adr_fields = AddressFormat::getOrderedAddressFields((int)$address_delivery->id_country, false, true);
        $dlv_adr_fields = AddressFormat::getOrderedAddressFields((int)$address_invoice->id_country, false, true);

        $inv_all_fields = array();
        $dlv_all_fields = array();

        foreach (array('inv', 'dlv') as $adr_type) {
            foreach (${$adr_type . '_adr_fields'} as $fields_line)
                foreach (explode(' ', $fields_line) as $field_item)
                    ${$adr_type . '_all_fields'}[] = trim($field_item);

            $this->context->smarty->assign($adr_type . '_adr_fields', ${$adr_type . '_adr_fields'});
            $this->context->smarty->assign($adr_type . '_all_fields', ${$adr_type . '_all_fields'});
        }
    }

    protected function getFormatedSummaryDetail()
    {
        $result               = array('summary'         => $this->context->cart->getSummaryDetails(),
                                      'customizedDatas' => Product::getAllCustomizedDatas($this->context->cart->id, null, true)
        );
        $cart_product_context = Context::getContext()->cloneContext();
        foreach ($result['summary']['products'] as $key => &$product) {
            $product['quantity_without_customization'] = $product['quantity'];
            $product['quantity']                       = $product['cart_quantity']; // for compatibility with 1.2 themes

            if ($cart_product_context->shop->id != $product['id_shop'])
                $cart_product_context->shop = new Shop((int)$product['id_shop']);
            $null = null;
            $product['price_without_specific_price'] = Product::getPriceStatic($product['id_product'],
                !Product::getTaxCalculationMethod(),
                $product['id_product_attribute'],
                2, null, false, false, 1, false, null, null, null, $null, true, true, $cart_product_context);
            if (Product::getTaxCalculationMethod())
                $product['is_discounted'] = $product['price_without_specific_price'] != $product['price'];
            else
                $product['is_discounted'] = $product['price_without_specific_price'] != $product['price_wt'];
            $product['price_without_quantity_discount'] = $product['price_without_specific_price'];

            if ($product['reduction_type'] == 'amount')
            {
                $reduction = (float)$product['price_wt'] - (float)$product['price_without_quantity_discount'];
                $product['reduction_formatted'] = Tools::displayPrice($reduction);
            }

            if ($result['customizedDatas']) {
                if (isset($result['customizedDatas'][(int)$product['id_product']]))
                    foreach ($result['customizedDatas'][(int)$product['id_product']][(int)$product['id_product_attribute']] as $addresses)
                        foreach ($addresses as $customization)
                            $product['quantity_without_customization'] -= (int)$customization['quantity'];
            }
        }

        if ($result['customizedDatas'])
            Product::addCustomizationPrice($result['summary']['products'], $result['customizedDatas']);
        return $result;
    }

    private function _hookExecPaymentShip2pay($carrier)
    {
        // ship2pay function, get only active for current shiping payment modules
        $sql    = 'SELECT * FROM `' . _DB_PREFIX_ . 'shiptopay`';
        $result = Db::getInstance()->ExecuteS($sql);

        if (count($result) == 0) {
            return Module::hookExecPayment();
        } else {
            $hookArgs = array('cookie' => $this->context->cookie, 'cart' => $this->context->cart);
            $billing  = new Address((int)$this->context->cart->id_address_invoice);
            $output   = '';
            $sql      = '
    		SELECT distinct(stp.id_carrier),h.`id_hook`, m.`name`, hm.`position`
    		FROM `' . _DB_PREFIX_ . 'module_country` mc
    		LEFT JOIN `' . _DB_PREFIX_ . 'module` m ON m.`id_module` = mc.`id_module`
    		LEFT JOIN `' . _DB_PREFIX_ . 'hook_module` hm ON hm.`id_module` = m.`id_module`
    		LEFT JOIN `' . _DB_PREFIX_ . 'hook` h ON hm.`id_hook` = h.`id_hook`
    		LEFT JOIN `' . _DB_PREFIX_ . 'shiptopay` stp ON hm.`id_module` = stp.`id_payment`
    		WHERE h.`name` = \'displayPayment\'
    		AND stp.id_carrier=' . (int)$carrier . '
    		AND mc.id_country = ' . (int)$billing->id_country . '
    		AND m.`active` = 1
    		ORDER BY hm.`position`, m.`name` DESC';
            $result = Db::getInstance()->ExecuteS($sql);
            if ($result)
                foreach ($result AS $k => $module)
                    if (($moduleInstance = Module::getInstanceByName($module['name'])) AND is_callable(array($moduleInstance, 'hookpayment'))) {
                        $paymentCurrencies = Currency::checkPaymentCurrencies($moduleInstance->id);
                        $actualCurrencies = array();
                        foreach ($paymentCurrencies as $curr)
                            $actualCurrencies[] = $curr['id_currency'];
                        if (!$moduleInstance->currencies OR ($moduleInstance->currencies AND sizeof($paymentCurrencies) AND in_array((int)$this->context->currency->id, $actualCurrencies)))
                            $output .= call_user_func(array($moduleInstance, 'hookpayment'), $hookArgs);
                    }
            return $output;
        }
    }
    //_hookExecPaymentShip2pay()
}


