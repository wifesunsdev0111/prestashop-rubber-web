<?php
/**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *          International Registered Trademark & Property of PrestaShop SA
 */

class OgoneAliasesModuleFrontController extends ModuleFrontController
{

    public $display_column_left = false;

    public function setMedia()
    {
        if ($this->module->isPS17x()) {
            $this->context->controller->registerJavascript($this->module->name . '-aliases', 'modules/' . $this->module->name . '/views/js/aliases.js');
        }
        return parent::setMedia();
    }

    public function initContent()
    {
        parent::initContent();

        $this->dispatch();
    }

    public function setTemplate($template, $params = array(), $locale = null)
    {
        return $this->module->isPS17x() ? parent::setTemplate('module:ogone/views/templates/front/' . str_replace('.tpl', '-17.tpl', $template), $params, $locale) : parent::setTemplate($template);
    }

    protected function dispatch()
    {
        if ((!$this->context->customer || !$this->context->customer->isLogged()) && Tools::getValue('alias_full')) {
            // handling special case for our dear Internet Explorer
            // For some unspecified versions IE (ie. IE 11.0 on Win 7, probably lot more)
            // If there is no P3P header, IE with default privacy settings deletes all cookies
            // Ingenico HTP page do not send P3P header (which is obsolete since ~2010), so when returning from HTP (in iframe)
            // all cookies are deleted by IE
            // So Prestashop loses notion of cookie, customer etc, so redirection is made and user is disconnected
            // Not the very best outcome.
            // So we will try to force customer login
            $this->forceUserConnectionFromAlias();
        }

        if (!$this->context->customer || !$this->context->customer->isLogged()) {
            $url = 'index.php?controller=authentication&back=' . urlencode($this->context->link->getModuleLink('ogone', 'aliases'));
            Tools::redirect($url);
        } elseif (Tools::getValue('result')) {
            return $this->processAliasCreationReturn();
        } elseif (Tools::getValue('action') === 'delete' && Tools::getValue('id_alias')) {
            $this->processDelete();
        }

        $this->assignList();
    }

    protected function forceUserConnectionFromAlias()
    {
        if (!Tools::getValue('alias_full')) {
            return false;
        }
        if (!Tools::getValue('Alias_AliasId') || Tools::getValue('Alias_AliasId') !== Tools::getValue('alias_full')) {
            return false;
        }
        if (!$this->module->verifyShaSignatureFromGet()) {
            return false;
        }
        $alias = Tools::getValue('alias_full');
        $alias_elements = explode('_', $alias);
        if (count($alias_elements) !== 2 || count(array_filter($alias_elements)) !== 2) {
            return false;
        }
        $id_customer = (int)$alias_elements[0];
        $customer = new Customer($id_customer);
        if (!Validate::isLoadedObject($customer)) {
            return false;
        }
        if (version_compare(_PS_VERSION_, '1.6', 'ge')) {
            $this->authenticate16($customer);
        } elseif (version_compare(_PS_VERSION_, '1.5', 'ge')) {
            $this->authenticate15($customer);
        } else {
            return false;
        }
    }

    // code copied from processSubmitLogin
    // omitting
    protected function authenticate16($customer)
    {
        Hook::exec('actionBeforeAuthentication');

        $this->context->cookie->id_compare = isset($this->context->cookie->id_compare) ? $this->context->cookie->id_compare : CompareProduct::getIdCompareByIdCustomer($customer->id);
        $this->context->cookie->id_customer = (int)($customer->id);
        $this->context->cookie->customer_lastname = $customer->lastname;
        $this->context->cookie->customer_firstname = $customer->firstname;
        $this->context->cookie->logged = 1;
        $customer->logged = 1;
        $this->context->cookie->is_guest = $customer->isGuest();
        $this->context->cookie->passwd = $customer->passwd;
        $this->context->cookie->email = $customer->email;

        // Add customer to the context
        $this->context->customer = $customer;
        $id_cart = (int)Cart::lastNoneOrderedCart($this->context->customer->id);

        if ($id_cart) {
            $this->context->cart = new Cart($id_cart);
        }

        $this->context->cart->id_customer = (int)$customer->id;
        $this->context->cart->secure_key = $customer->secure_key;
        $id_carrier = null;
        if ($this->ajax && isset($id_carrier) && $id_carrier && Configuration::get('PS_ORDER_PROCESS_TYPE')) {
            $delivery_option = array(
                $this->context->cart->id_address_delivery => $id_carrier . ','
            );
            $this->context->cart->setDeliveryOption($delivery_option);
        }

        $this->context->cart->save();
        $this->context->cookie->id_cart = (int)$this->context->cart->id;
        $this->context->cookie->write();
        $this->context->cart->autosetProductAddress();

        Hook::exec('actionAuthentication');

        // Login information have changed, so we check if the cart rules still apply
        CartRule::autoRemoveFromCart($this->context);
        CartRule::autoAddToCart($this->context);
    }

    protected function authenticate15($customer)
    {
        Hook::exec('actionBeforeAuthentication');

        $this->context->cookie->id_compare = isset($this->context->cookie->id_compare) ? $this->context->cookie->id_compare : CompareProduct::getIdCompareByIdCustomer($customer->id);
        $this->context->cookie->id_customer = (int)($customer->id);
        $this->context->cookie->customer_lastname = $customer->lastname;
        $this->context->cookie->customer_firstname = $customer->firstname;
        $this->context->cookie->logged = 1;
        $customer->logged = 1;
        $this->context->cookie->is_guest = $customer->isGuest();
        $this->context->cookie->passwd = $customer->passwd;
        $this->context->cookie->email = $customer->email;

        // Add customer to the context
        $this->context->customer = $customer;
        $id_cart = (int)Cart::lastNoneOrderedCart($this->context->customer->id);
        if (Configuration::get('PS_CART_FOLLOWING') && (empty($this->context->cookie->id_cart) || Cart::getNbProducts($this->context->cookie->id_cart) == 0) && $id_cart) {
            $this->context->cart = new Cart($id_cart);
        } else {
            $this->context->cart->id_carrier = 0;
            $this->context->cart->setDeliveryOption(null);
            $this->context->cart->id_address_delivery = Address::getFirstCustomerAddressId((int)($customer->id));
            $this->context->cart->id_address_invoice = Address::getFirstCustomerAddressId((int)($customer->id));
        }

        $this->context->cart->id_customer = (int)$customer->id;
        $this->context->cart->secure_key = $customer->secure_key;
        $this->context->cart->save();
        $this->context->cookie->id_cart = (int)$this->context->cart->id;
        $this->context->cookie->write();
        $this->context->cart->autosetProductAddress();

        Hook::exec('actionAuthentication');

        // Login information have changed, so we check if the cart rules still apply
        CartRule::autoRemoveFromCart($this->context);
        CartRule::autoAddToCart($this->context);
    }

    protected function processAliasCreationReturn()
    {
        $tpl_vars = array();
        $this->display_header = false;
        $this->display_footer = false;
        if (Tools::getValue('result') == 'ok' && Tools::getValue('alias_full') && $this->module->verifyShaSignatureFromGet()) {
            $this->module->log($this->module->convertArrayToReadableString($_GET, PHP_EOL));
            $data = $this->module->getAliasReturnVariables();
            list ($result, $message) = $this->module->createAlias($this->context->customer->id, $data, true);
            if ($result) {
                if ($this->module->makeImmediateAliasPayment() && Tools::getValue('aip')) {
                    $tpl_vars['payment_url'] = $this->module->getLocalAliasPaymentLink(array(
                        'id_alias' => (int)$message
                    ));
                } else {
                    $tpl_vars['payment_url'] = null;
                }
                $this->context->smarty->assign($tpl_vars);
                $this->setTemplate('parent-reload.tpl');
                return true;
            } else {
                $tpl_vars['error'] = $message;
            }
        } else {
            $tpl_vars['error'] = Tools::getValue('Alias.NCError') ? Tools::getValue('Alias.NCError') : $this->module->l('Alias creation error');
        }

        $this->context->smarty->assign($tpl_vars);
        $this->setTemplate('aliases-error.tpl');
    }

    protected function assignList()
    {
        $customer = $this->context->customer;
        $module_url = $this->context->link->getModuleLink('ogone', 'aliases');
        if (!$customer || !$customer->isLogged()) {
            Tools::redirect('index.php?controller=authentication&back=' . urlencode($module_url));
        }

        if ($this->module->canUseAliases()) {
            $aliases = array();
            foreach (OgoneAlias::getCustomerActiveAliases($customer->id) as $alias) {
                if ($alias['is_temporary'] == 1) {
                    continue;
                }
                $alias['delete_link'] = $this->context->link->getModuleLink('ogone', 'aliases', array(
                    'action' => 'delete',
                    'id_alias' => $alias['id_ogone_alias']
                ));
                $alias['logo'] = $this->module->getAliasLogoUrl($alias, 'cc_small.png');
                $aliases[] = $alias;
            }
            $htp_urls = $this->module->getHostedTokenizationPageRegistrationUrls($customer->id);
            $htp_urls_names = array();
            foreach ($htp_urls as $k => $v) {
                $htp_urls_names[$k] = $this->module->getHTPPaymentMethodName($k);
            }
            $tpl_vars = array(
                'url' => $module_url,
                'aliases' => $aliases,
                'htp_urls' => $htp_urls,
                'htp_urls_names' => $htp_urls_names

            );
            $this->context->smarty->assign($tpl_vars);
            $this->setTemplate('aliases.tpl');
        } else {
            $this->setTemplate('aliases-disabled.tpl');
        }
    }

    public function processDelete()
    {
        $id_alias = (int)Tools::getValue('id_alias');
        $alias = new OgoneAlias((int)$id_alias);
        if (!Validate::isLoadedObject($alias) || (int)$alias->id_customer !== (int)$this->context->customer->id) {
            $this->context->smarty->assign('errors', array(
                $this->module->l('Invalid customer')
            ));
            return false;
        } else {
            if ($alias->delete()) {
                $this->context->smarty->assign('messages', array(
                    $this->module->l('Alias deleted')
                ));
                return true;
            }
        }

        $this->context->smarty->assign('errors', array(
            $this->module->l('Unable delete alias')
        ));
        return false;
    }
}
