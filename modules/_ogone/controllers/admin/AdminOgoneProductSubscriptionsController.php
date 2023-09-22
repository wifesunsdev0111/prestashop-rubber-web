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

class AdminOgoneProductSubscriptionsController extends ModuleAdminController
{

    public $lang = true;

    public $table = 'ogone_product_subscription';

    public $className = 'OgoneProductSubscription';

    public $bootstrap = true;

    public $allow_export = false;

    public $actions_available = array(
        'edit',
        'view',
        'delete'
    );

    public $edit = 1;

    public $view = 1;

    public $delete = 1;

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

        $this->actions = array(
            'view',
            'edit',
            'delete'
        );

        $this->setFieldsListDefinition();
        $this->setFieldsFormDefinition();

        if (!$this->module->canUseSubscription()) {
            $this->warnings[] = $this->l('Subscriptions are desactivated. Visit module configuration page to activate them');
        }
    }

    public function initToolbar()
    {
        parent::initToolbar();
        unset($this->toolbar_btn['new']);
    }

    public function getFieldValue($obj, $key, $id_lang = null)
    {
        $value = parent::getFieldValue($obj, $key, $id_lang);
        if ($value === false) {
            switch ($key) {
                case 'installments':
                    $value = Configuration::get('OGONE_SUB_INSTALLMENTS');
                    break;
                case 'period_unit':
                    $value = Configuration::get('OGONE_SUB_PERIOD_UNIT');
                    break;
                case 'period_number':
                    $value = Configuration::get('OGONE_SUB_PERIOD_NUMBER');
                    break;
                case 'period_moment':
                    $value = Configuration::get('OGONE_SUB_PERIOD_MOMENT');
                    break;
                case 'first_amount':
                    $value = Configuration::get('OGONE_SUB_FIRST_AMOUNT');
                    break;
                case 'first_payment_delay':
                    $value = Configuration::get('OGONE_SUB_FIRST_PAYMENT_DELAY');
                    break;
            }
        }
        return $value;
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
            $this->redirect_after = $this->getProductLink($this->object->id_product);
        }
    }

    public function processUpdate()
    {

        parent::processUpdate();
        if (!$this->errors) {
            $this->redirect_after = $this->getProductLink($this->object->id_product);
        }
    }

    public function renderForm()
    {
        $tpl_var = array(
        'ogone_periods_ww' => Tools::jsonEncode($this->module->getPeriodMoments(Ogone::PERIOD_WEEK)),
        'ogone_periods_m' => Tools::jsonEncode($this->module->getPeriodMoments(Ogone::PERIOD_MONTH))
        );
        $this->context->smarty->assign($tpl_var);
        return $this->context->smarty->fetch(dirname(__FILE__) . '/../../views/templates/admin/ogone_bo_vars.tpl') . parent::renderForm();
    }

    protected function setTplViewVars()
    {
        $this->tpl_view_vars = array(
            'subscription' => null
        );

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

    protected function setFieldsFormDefinition()
    {
        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Subscription')
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            )
        );

        $object = $this->loadObject(true);
        $id_product = $object && $object->id_product ? $object->id_product : Tools::getValue('id_product');
        $id_product_attribute = $object && $object->id_product_attribute ? $object->id_product_attribute : Tools::getValue('id_product_attribute');
        $name = $id_product ? $this->module->getProductName($id_product, $id_product_attribute) : null;

        if ($name !== null) {
            $this->fields_form['input'][] = array(
                'type' => 'html',
                'name' => $name . ' [<a href="' . $this->getProductLink($id_product) . '" target="blank">' . $this->module->l('See') . '</a>]',
                'label' => $this->l('Produit')
            );
        }

        $this->fields_form['input'][] = array(
            'type' => $name !== null ? 'hidden' : 'text',
            'label' => $this->l('Id product :'),
            'name' => 'id_product',
            'lang' => false,
            'required' => true,
            'description' => $this->l('Id product')
        );

        $this->fields_form['input'][] = array(
            'type' => $name !== null ? 'hidden' : 'text',
            'label' => $this->l('Id product attribute:'),
            'name' => 'id_product_attribute',
            'lang' => false,
            'required' => true,
            'description' => $this->l('Id product attribute')
        );

        $this->fields_form['input'][] = array(
            'type' => 'text',
            'label' => $this->l('Installments :'),
            'name' => 'installments',
            'lang' => false,
            'required' => true,
            'description' => $this->l('Installments')
        );

        $units = array(
            array(
                'id_unit' => Ogone::PERIOD_DAY,
                'name' => $this->module->l('Day')
            ),
            array(
                'id_unit' => Ogone::PERIOD_WEEK,
                'name' => $this->module->l('Week')
            ),
            array(
                'id_unit' => Ogone::PERIOD_MONTH,
                'name' => $this->module->l('Month')
            )
        );

        $this->fields_form['input'][] = array(
            'type' => 'select',
            'label' => $this->l('Period unit :'),
            'name' => 'period_unit',
            'lang' => false,
            'required' => true,
            'description' => $this->l('Period unit'),
            'options' => array(
                'query' => $units,
                'id' => 'id_unit',
                'name' => 'name'
            )
        );

        $moments = array();
        foreach ($this->module->getPeriodMoments(Ogone::PERIOD_MONTH) as $k => $v) {
            $moments[] = array(
                'id_moment' => $k,
                'name' => $v
            );
        }

        $this->fields_form['input'][] = array(
            'type' => 'select',
            'label' => $this->l('Period moment :'),
            'name' => 'period_moment',
            'lang' => false,
            'required' => true,
            'description' => $this->l('Period moment'),
            'options' => array(
                'query' => $moments,
                'id' => 'id_moment',
                'name' => 'name'
            )
        );

        $this->fields_form['input'][] = array(
            'type' => 'text',
            'label' => $this->l('Period number :'),
            'name' => 'period_number',
            'lang' => false,
            'required' => true,
            'description' => $this->l('Period number')
        );

        /*
         * $this->fields_form['input'][] = array(
         * 'type' => 'text',
         * 'label' => $this->l('First amount :'),
         * 'name' => 'first_amount',
         * 'lang' => false,
         * 'required' => true,
         * 'description' => $this->l('First amount'),
         * );
         */

        /*
         * $this->fields_form['input'][] = array(
         * 'type' => 'text',
         * 'label' => $this->l('First payment delay :'),
         * 'name' => 'first_payment_delay',
         * 'lang' => false,
         * 'required' => true,
         * 'description' => $this->l('First payment delay'),
         * );
         */

        if ($this->module->isPS15x()) {
            $this->fields_form['input'][] = array(
                'type' => 'radio',
                'class' => 't',
                'label' => $this->l('Active'),
                'name' => 'active',
                'required' => false,
                'is_bool' => true,
                'values' => array(
                    array(
                        'id' => 'active_on',
                        'value' => 1,
                        'label' => $this->l('Enabled')
                    ),
                    array(
                        'id' => 'active_off',
                        'value' => 0,
                        'label' => $this->l('Disabled')
                    )
                ),
            );
        } else {
            $this->fields_form['input'][] = array(
                'type' => 'switch',
                'label' => $this->l('Active'),
                'name' => 'active',
                'required' => false,
                'is_bool' => true,
                'values' => array(
                    array(
                        'id' => 'active_on',
                        'value' => 1,
                        'label' => $this->l('Enabled')
                    ),
                    array(
                        'id' => 'active_off',
                        'value' => 0,
                        'label' => $this->l('Disabled')
                    )
                ),
            );
        }
    }

    /*
     * public function initPageHeaderToolbar()
     * {
     * if (empty($this->display)) {
     * $this->page_header_toolbar_btn['new_order_message'] = array(
     * 'href' => self::$currentIndex.'&addorder_message&token='.$this->token,
     * 'desc' => $this->trans('Add new order message', array(), 'Admin.Orderscustomers.Feature'),
     * 'icon' => 'process-icon-new'
     * );
     * }
     *
     * parent::initPageHeaderToolbar();
     * }
     */
    public function initProcess()
    {
        parent::initProcess();
        if (version_compare(_PS_VERSION_, '1.6', 'lt') && Tools::getValue('action') && empty($this->action)) {
            $this->action = Tools::getValue('action');
        }
    }

    protected function setFieldsListDefinition()
    {
        /*
         * $this->fields_list['id_ogone_product_subscription'] = array(
         * 'class' => 'fixed-width-s',
         * 'type' => 'text',
         * 'title' => $this->l('Id'),
         * 'name' => 'id_order',
         * 'search' => true,
         * 'orderby' => true,
         * );
         */
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

        $this->fields_list['installments'] = array(
            'class' => 'fixed-width-sm',
            'title' => $this->l('Installments'),
            'type' => 'text',
            'search' => false,
            'orderby' => false
        );
        /*
         * $this->fields_list['period_unit'] = array(
         * 'class' => 'fixed-width-sm',
         * 'title' => $this->l('Period unit'),
         * 'type' => 'text',
         * 'search' => true,
         * 'orderby' => true,
         * );
         * $this->fields_list['period_moment'] = array(
         * 'class' => 'fixed-width-sm',
         * 'title' => $this->l('Period moment'),
         * 'type' => 'text',
         * 'search' => true,
         * 'orderby' => true,
         * );
         * $this->fields_list['period_number'] = array(
         * 'class' => 'fixed-width-sm',
         * 'title' => $this->l('Period number'),
         * 'type' => 'text',
         * 'search' => true,
         * 'orderby' => true,
         * );
         * $this->fields_list['first_amount'] = array(
         * 'class' => 'fixed-width-sm',
         * 'title' => $this->l('First amount'),
         * 'type' => 'text',
         * 'search' => true,
         * 'orderby' => true,
         * );
         * $this->fields_list['first_payment_delay'] = array(
         * 'class' => 'fixed-width-sm',
         * 'title' => $this->l('First payment Delay'),
         * 'type' => 'text',
         * 'search' => true,
         * 'orderby' => true,
         * );
         */
        $this->fields_list['period_unit'] = array(
            'class' => 'fixed-width-l',
            'title' => $this->l('Period unit'),
            'type' => 'text',
            'search' => false,
            'orderby' => false,
            'callback' => 'printPeriodInfo',
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

    public function printPeriodInfo($period_unit, $row = null)
    {
        return $this->module->getSubscriptionFrequency($row['period_moment'], $row['period_number'], $period_unit);
    }
}
