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
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2017 PrestaShop SA
 *  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

class AdminOgoneTransactionsController extends ModuleAdminController
{

    public $lang = false;
    public $table = 'ogone_tl';
    public $className = 'OgoneTransactionLog';
    public $bootstrap = true;
    public $allow_export = true;

    protected $return_code_list = null;

    public function __construct()
    {
        parent::__construct();
        $this->actions = array('view');
        $this->setFieldsListDefinition();
    }

    public function renderList()
    {
        $this->setQueryDefault();
        return parent::renderList();
    }


    public function renderView()
    {
        if (Tools::getValue('id_ogone_tl')) {
            $transaction = new OgoneTransactionLog(Tools::getValue('id_ogone_tl'));
            $this->tpl_view_vars['transaction']= $transaction;
        }
        return parent::renderView();
    }


    protected function setFieldsListDefinition()
    {
        $this->fields_list['reference'] = array(
            'class' => 'fixed-width-sm',
            'title' => $this->l('Order'),
            'type' => 'text',
            'search' => true,
            'orderby' => true,
            'filter_key' => 'o!reference',
            'order_key' => 'o!reference',
        );
        $this->fields_list['id_cart'] = array(
            'class' => 'fixed-width-s',
            'title' => $this->l('Id cart'),
            'type' => 'text',
            'search' => true,
            'filter_key' => 'a!id_cart',
            'orderby' => true,
        );
        $this->fields_list['id_order'] = array(
            'class' => 'fixed-width-s',
            'title' => $this->l('Id order'),
            'type' => 'text',
            'filter_key' => 'a!id_order',

            'search' => true,
            'orderby' => true,
        );
        $this->fields_list['date_add'] = array(
            'class' => 'fixed-width-s',
            'title' => $this->l('Date'),
            'type' => 'text',
            'search' => true,
            'orderby' => true,
            'filter_key' => 'a!date_add',
            'order_key' => 'a!date_add',
        );
        $this->fields_list['payid'] = array(
            'class' => 'fixed-width-s',
            'title' => $this->l('Ingenico PAYID'),
            'type' => 'text',
            'search' => true,
            'orderby' => true,
        );
        $this->fields_list['status'] = array(
            'title' => $this->l('Platform payment status'),
            'type' => 'select',
            'list' => $this->module->getReturnCodesList(),
            'filter_key' => 'status',
            'filter_type' => 'int',
            'order_key' => 'status',
            'callback' => 'printPaymentStatus',
            'search' => true,
            'orderby' => true,
        );
    }

    protected function setQueryDefault()
    {
        $this->_select .= 'o.reference';
        $this->_join .= ' LEFT OUTER JOIN ' . _DB_PREFIX_ . 'cart c ON c.id_cart = a.id_cart';
        $this->_join .= ' LEFT OUTER JOIN ' . _DB_PREFIX_ . 'orders o ON o.id_cart = a.id_cart';
    }

    public function printPaymentStatus($status, $row = null)
    {
        if ($this->return_code_list === null) {
            $this->return_code_list = $this->module->getReturnCodesList();
        }

        $name = isset($this->return_code_list[$status]) ? $this->return_code_list[$status] : $status;
        list($background_color, $color) = $this->module->getPaymentStatusColor($status);
        $pattern = '<span class="label color_field" style="background-color:%s;color:%s">%s</status>';
        return sprintf($pattern, $background_color, $color, $name);
    }
}
