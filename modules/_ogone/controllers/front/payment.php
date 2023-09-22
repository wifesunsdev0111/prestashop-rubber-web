<?php
/**
* 2007-2014 PrestaShop
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2014 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class OgonePaymentModuleFrontController extends ModuleFrontController
{
    public $ssl = true;
    public $display_column_left = false;

    public function setTemplate($template, $params = array(), $locale = null)
    {
        return $this->module->isPS17x() ?
        parent::setTemplate('module:ogone/views/templates/front/' . $template, $params, $locale) :
        parent::setTemplate($template);
    }

/**
   * @see FrontController::initContent()
   */
    public function initContent()
    {
        parent::initContent();
        try {
            if (!isset($this->context->smarty->registered_plugins['function']['displayPrice'])) {
                smartyRegisterFunction($this->context->smarty, 'function', 'displayPrice', array('Tools', 'displayPriceSmarty'));
            }
        } catch (Exception $ex) {
            // displayPrice already registered, can ignore
        }
        $cart = $this->context->cart;

        $alias = new OgoneAlias(Tools::getValue('id_alias'));

        if (!Validate::isLoadedObject($alias) || $alias->id_customer != $cart->id_customer) {
              Tools::redirect('index.php?controller=order');
        }

        $alias_data = $alias->toArray();
        $alias_data['logo'] = $this->module->getAliasLogoUrl($alias_data, 'cc_medium.png');

        $this->context->smarty->assign(array(
            'nbProducts' => $cart->nbProducts(),
            'alias_data' => $alias_data,
            'expiry_date' => date('m/Y', strtotime($alias_data['expiry_date'])),
            'return_order_link' => $this->module->isPs17x() ? $this->context->link->getPageLink('order', true, $this->context->language->id, array('step'=> 3)) : $this->context->link->getPageLink('order', true, array('step'=> 3)),
            'validate_link' => $this->context->link->getModuleLink('ogone', 'validation'),
            'alias_link' => $this->context->link->getModuleLink('ogone', 'aliases'),
            'total' => $cart->getOrderTotal(true, Cart::BOTH),
            'this_path' => $this->module->getPathUri(),
            'this_path_bw' => $this->module->getPathUri(),
            'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->module->name.'/',
            '3ds_active' => $this->module->use3DSecureForDL(),
        ));
        $this->setTemplate($this->module->isPs17x()  ? 'payment_execution-17.tpl' :'payment_execution.tpl');
    }
}
