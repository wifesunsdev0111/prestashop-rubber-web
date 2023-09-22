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
 *
 */

class AdminOgoneSubscriptionsController extends ModuleAdminController
{

    public $lang = false;

    public $table = 'ogone_subscription';

    public $className = 'OgoneSubscription';

    public $bootstrap = true;

    public $allow_export = false;

    public $actions_available = array(
        'edit'
    );

    public $edit = 1;

    public $view = 0;

    public $delete = 0;

    public $bulk_actions = array();




    /**
     *
     * @var Ogone
     */
    public $module;

    public function __construct()
    {
        $this->list_no_link = true;

        parent::__construct();

        $this->_conf[5] = $this->l('The status has been successfully updated. You need to modify corresponding subscription in your Ingenico backoffice');

        $this->actions = array(
            'view'
        );
        $this->title = $this->module->l('Subscriptions');
        $this->toolbar_title = array(
            $this->title
        );
        $this->setFieldsListDefinition();

        if (!$this->module->canUseSubscription()) {
            $this->warnings[] = $this->l('Subscriptions are desactivated. Visit module configuration page to activate them');
        }
        $this->_select .= ' CONCAT(c.firstname, " ",  c.lastname) AS customer_name';
        $this->_join .= ' JOIN ' . _DB_PREFIX_ . 'customer c ON c.id_customer = a.id_customer';
    }

    public function initToolbar()
    {
        parent::initToolbar();
        unset($this->toolbar_btn['new']);
    }

    public function getTemplateListVars()
    {
        $tpl_vars = parent::getTemplateListVars();
        $tpl_vars['title'] = $this->title;
        return $tpl_vars;
    }

    public function renderList()
    {
        return parent::renderList();
    }

    public function renderView()
    {
        $this->setTplViewVars();
        return parent::renderView();
    }

    public function processAdd()
    {
        parent::processAdd();
        if (!$this->errors) {
            // $this->redirect_after = $this->getProductLink($this->object->id_product);
        }
    }

    public function processUpdate()
    {
        parent::processUpdate();
        if (!$this->errors) {
            $this->redirect_after = $this->getProductLink($this->object->id_product);
        }
    }

    protected function setTplViewVars()
    {
        $this->tpl_view_vars = array(
            'subscription' => null
        );

        $this->tpl_view_vars['title'] = $this->module->l('Subscriptions');

        $this->tpl_view_vars['toolbar_btn'] = array(
            'list' => array(
                'href' => $this->context->link->getAdminLink('AdminOgoneProductSubscriptions'),
                'desc' => $this->l('List'),
                'class' => 'process icon-list-ul'
            )
        );

        $subscription = $this->loadObject();

        if (Validate::isLoadedObject($subscription)) {
            $this->tpl_view_vars['toolbar_btn']['edit'] = array(
                'href' => $this->context->link->getAdminLink('AdminOgoneProductSubscriptions') . '&updateogone_product_subscription&id_ogone_product_subscription=' . $subscription->id,
                'desc' => $this->l('Edit')
            );

            $this->tpl_view_vars['subscription'] = $subscription;
            $this->tpl_view_vars['customer'] = new Customer($subscription->id_customer);
            $this->tpl_view_vars['customer_link'] = $this->context->link->getAdminLink('AdminCustomers') . '&viewcustomer&id_customer=' . $subscription->id_customer;

            $cart = new Cart($subscription->id_cart);

            $this->tpl_view_vars['total_paid'] = $this->module->formatPrice($subscription->getTotalPaid(), new Currency($cart->id_currency));

            $amount = $this->module->getSubscriptionTotal($cart);

            $data = $this->module->getCurrentSubscriptionReadableDetails($subscription, $amount);

            foreach ($data['orders'] as &$order) {
                $order['link'] = $this->context->link->getAdminLink('AdminOrders') . '&vieworder&id_order=' . $order['id_order'];
            }
            $this->tpl_view_vars['subscription_data'] = $data;

            $this->tpl_view_vars['product_url'] = $this->getProductLink($subscription->id_product);
        } // if
    }

    protected function getProductLink($id)
    {
        return $this->context->link->getAdminLink('AdminProducts', true, array(
            'id_product' => $id,
            'updateproduct' => 1
        )) . '#tab-hooks';
    }

    public function getFieldsValue($obj)
    {
        $result = parent::getFieldsValue($obj);
        return $result;
    }

    public function initProcess()
    {
        parent::initProcess();
        if (version_compare(_PS_VERSION_, '1.6', 'lt') && Tools::getValue('action') && empty($this->action)) {
            $this->action = Tools::getValue('action');
        }
    }

    protected function setFieldsListDefinition()
    {
        $this->fields_list['customer_name'] = array(
            'type' => 'text',
            'title' => $this->l('Customer'),
            'name' => 'customer_name',
            'search' => true,
            'orderby' => true,
            // 'callback' => 'printCustomer',
            'havingFilter' => true

        );
        $this->fields_list['id_product'] = array(
            'class' => 'fixed-width-s',
            'type' => 'text',
            'title' => $this->l('Product'),
            'name' => 'id_product',
            'search' => false,
            'orderby' => true,
            'callback' => 'printProduct',
            'havingFilter' => true
        );

        $this->fields_list['start_date'] = array(
            'class' => 'fixed-width-sm',
            'title' => $this->l('Start date'),
            'type' => 'date',
            'search' => true,
            'orderby' => true
        );

        $this->fields_list['end_date'] = array(
            'class' => 'fixed-width-sm',
            'title' => $this->l('End date'),
            'type' => 'date',
            'search' => true,
            'orderby' => true
        );

        $this->fields_list['installments'] = array(
            'class' => 'fixed-width-sm',
            'title' => $this->l('Installments'),
            'type' => 'text',
            'search' => false,
            'orderby' => true
        );

        /*
         * $this->fields_list['period_number'] = array(
         * 'class' => 'fixed-width-sm',
         * 'title' => $this->l('Period number'),
         * 'type' => 'text',
         * 'search' => true,
         * 'orderby' => true,
         * );
         */
        $this->fields_list['period_unit'] = array(
            'class' => 'fixed-width-sm',
            'title' => $this->l('Period unit'),
            'type' => 'text',
            'search' => false,
            'orderby' => true,
            'callback' => 'printPeriodInfo',
            'havingFilter' => true
        );

        /*
         * $this->fields_list['first_amount'] = array(
         * 'class' => 'fixed-width-sm',
         * 'title' => $this->l('First amount'),
         * 'type' => 'text',
         * 'callback' => 'printFirstAmount',
         * l
         * 'search' => true,
         * 'orderby' => true,
         * );
         */
        /*
         * $this->fields_list['first_payment_delay'] = array(
         * 'class' => 'fixed-width-sm',
         * 'title' => $this->l('First payment Delay'),
         * 'type' => 'text',
         * 'search' => true,
         * 'orderby' => true,
         * );
         */

        $this->fields_list['id_ogone_subscription'] = array(
            'type' => 'text',
            'title' => $this->l('Total paid'),
            'name' => 'id_customer',
            'search' => false,
            'orderby' => false,
            'callback' => 'printTotalPaid',
            'havingFilter' => true
        );

        $this->fields_list['active'] = array(
            'title' => $this->l('Active'),
            'align' => 'center',
            'active' => 'status',
            'type' => 'bool',
            'orderby' => false,
            'filter_key' => 'a!active',
            'class' => 'fixed-width-sm'

        );
    }

    public function printProduct($id_product, $row = null)
    {
        return $this->module->getProductName($id_product, $row['id_product_attribute']);
    }

    public function printCustomer($id_customer, $row = null)
    {
        $customer = new Customer($id_customer);
        return $customer->lastname . ' ' . $customer->firstname;
    }

    public function printPeriodInfo($period_unit, $row = null)
    {
        return $this->module->getSubscriptionFrequency($row['period_moment'], $row['period_number'], $row['period_unit']);
    }

    public function printFirstAmount($first_amount, $row = null)
    {
        return $first_amount > 0 ? $this->module->formatPrice($first_amount) : '---';
    }

    public function printTotalPaid($id_ogone_subscription, $row = null)
    {
        $s = new OgoneSubscription($id_ogone_subscription);
        $c = new Cart($s->id_cart);
        return $this->module->formatPrice($s->getTotalPaid(), new Currency($c->id_currency));
    }
}
