<?php
/**
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*    @author    PrestaShop SA <contact@prestashop.com>
*    @copyright 2007-2017 PrestaShop SA
*    @license   http://opensource.org/licenses/afl-3.0.php    Academic Free License (AFL 3.0)
*    International Registered Trademark & Property of PrestaShop SA
*/

/**
 * @since 1.5.0
 */
class OgoneValidationModuleFrontController extends ModuleFrontController
{

    public function setTemplate($template, $params = array(), $locale = null)
    {
        return $this->module->isPS17x() ?
        parent::setTemplate('module:ogone/views/templates/front/' . $template, $params, $locale) :
        parent::setTemplate($template);
    }

    /**
     * @see FrontController::postProcess()
     */
    public function postProcess()
    {
        $ogone = new Ogone();

        $cart = $this->context->cart;

        if ($cart->id_customer == 0 ||
            $cart->id_address_delivery == 0 ||
            $cart->id_address_invoice == 0 ||
            !$this->module->active) {
                $ogone->log('Invalid cart');
                $ogone->log($cart->id_customer);
                $ogone->log($this->module->active);
                $ogone->log('index.php?controller=order&step=1');
                Tools::redirect('index.php?controller=order&step=1&why=ac');
        }

        $authorized = false;
        foreach (Module::getPaymentModules() as $module) {
            if ($module['name'] == 'ogone') {
                $authorized = true;
                break;
            }
        }

        if (!$authorized) {
            die($this->module->l('This payment method is not available.', 'validation'));
        }

        $customer = new Customer($cart->id_customer);
        if (!Validate::isLoadedObject($customer)) {
            $ogone->log('Invalid customer');
            Tools::redirect('index.php?controller=order&step=1&why=ic');
        }
        $ogone = new Ogone();
        $ogone->log('CART: ' . $cart->id . ' ' . (Validate::isLoadedObject($cart) ? 'OK' : 'NOT LOADED'));

        if (Tools::getValue('id_alias') && (int)Tools::getValue('id_alias') > 0) {
            $alias = new OgoneAlias((int)Tools::getValue('id_alias'));
        } else {
            die($this->module->l('This alias is not available.', 'validation'));
        }

        if (!$this->module->canUseDirectLink()) {
            $ogone->log('No DirectLink configured');
            Tools::redirect('index.php?controller=order&step=3');
        }

        $ogone->log('doDirectLinkAliasPayment');

        list($result, $message) = $ogone->doDirectLinkAliasPayment($cart, $alias);
        $ogone->log($result);
        switch ($result) {
            /* Payment done without 3dsecure */
            case Ogone::DL_ALIAS_RET_PAYMENT_DONE:
                $ogone->log('DL_ALIAS_RET_PAYMENT_DONE');

                $redirect = 'index.php?controller=order-confirmation&id_cart='.$cart->id.'&id_module='.
                    $this->module->id.'&id_order='.$this->module->currentOrder.'&key='.$customer->secure_key;
                Tools::redirect($redirect);
                break;
            /* Payment via 3-D Secure, need to inject 3-D secure HTML */
            case Ogone::DL_ALIAS_RET_INJECT_HTML:
                $ogone->log('DL_ALIAS_RET_INJECT_HTML');
                $tpl_vars = array(
                    'result' => true,
                    'message'    => $message,
                    'inject_3ds' => true,
                    'inject_3ds_mode' => $this->module->getWin3DSOption()
                );
                $ogone->log($message);
                print $message;
                die();
                $this->context->smarty->assign($tpl_vars);
                $this->setTemplate('validation-message.tpl');
                $ogone->log('validation-message.tpl');

                break;
            /* Error has occured */
            case Ogone::DL_ALIAS_RET_ERROR:
                $ogone->log('DL_ALIAS_RET_ERROR');
                $ogone->log($message);

                $tpl_vars = array(
                    'result' => false,
                    'error'    => $message,
                    'return_url' => $this->context->link->getPageLink('order', null, null, array('step', '3'))
                );
                $this->context->smarty->assign($tpl_vars);
                $this->setTemplate('validation-error.tpl');
                break;
            /* Any other return */
            default:
                $ogone->log($result);
                Tools::redirect('index.php?controller=order&step=3');
                break;
        }
    }
}
