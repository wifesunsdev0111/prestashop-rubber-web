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

class AdminOgoneOrdersController extends ModuleAdminController
{

    public $lang = false;
    public $table = 'order';
    public $className = 'Order';
    public $bootstrap = true;
    public $allow_export = true;
    public $actions_available = array('capture', 'view');
    public $capture = 1;
    public $edit = 1;
    public $view = 0;
    public $delete = 0;
    public $bulk_actions = array();
    /**
     *
     * @var Ogone
     */
    public $module;


    protected $return_code_list = null;
    protected $order_statuses = array();

    public function __construct()
    {
        parent::__construct();

        $this->_conf[1001] = $this->l('Order was captured succesfully');
        $this->_conf[1002] = $this->l('All orders were captured succesfully');

        foreach (OrderState::getOrderStates((int) $this->context->language->id) as $status) {
            $this->order_statuses[$status['id_order_state']] = $status['name'];
        }
        $this->actions = array('view');

        $this->setFieldsListDefinition();
        $this->setQueryDefault();

        if ($this->module->canUseDirectLink()) {
            $this->addRowAction('capture');
            $this->bulk_actions['capture'] = array(
                'text' => $this->l('Capture'),
                'icon' => 'icon-cc',
                'confirm' => $this->l('Do you want capture selected orders?'),
            );
        } else {
            $this->warnings[] = $this->l('In order to use some options you need to activate and configure DirectLink');
        }
    }

    public function renderView()
    {
        if (Tools::getValue('id_order')) {
            Tools::redirectAdmin('index.php?tab=AdminOrders&id_order='.Tools::getValue('id_order').'&vieworder&token='.Tools::getAdminTokenLite('AdminOrders'));
        } else {
            $this->renderList();
        }
    }

    public function initProcess()
    {
        parent::initProcess();
        if (version_compare(_PS_VERSION_, '1.6', 'lt') && Tools::getValue('action') && empty($this->action)) {
            $this->action =  Tools::getValue('action');
        }
    }

    protected function setQueryDefault()
    {
        $this->_select .= 'tl.payid, tl.status,';
        $this->_select .= 'os.color, osl.name AS osname';

        $this->_join .= ' INNER JOIN ' . _DB_PREFIX_ . 'ogone_tl tl ON tl.id_cart = a.id_cart';
        $this->_join .= ' LEFT OUTER JOIN  ' . _DB_PREFIX_ .
        'ogone_tl tl2 ON tl2.id_cart = tl.id_cart AND tl.id_ogone_tl < tl2.id_ogone_tl';
        $this->_join .= ' LEFT JOIN `' . _DB_PREFIX_ . 'order_state` os ON (os.`id_order_state` = a.`current_state`)';
        $this->_join .= ' LEFT JOIN `' . _DB_PREFIX_ . 'order_state_lang` osl';
        $this->_join .= ' ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = ' .
        (int) $this->context->language->id . ')';

        $this->_where .= ' AND ISNULL(tl2.id_ogone_tl) ';
    }

    protected function setFieldsListDefinition()
    {
        $this->fields_list['id_order'] = array(
            'class' => 'fixed-width-s',
            'type' => 'text',
            'title' => $this->l('Id order'),
            'name' => 'id_order',
            'search' => true,
            'orderby' => true,
        );
        $this->fields_list['reference'] = array(
            'class' => 'fixed-width-sm',
            'title' => $this->l('Order reference'),
            'type' => 'text',
            'search' => true,
            'orderby' => true,
        );
        $this->fields_list['date_add'] = array(
            'class' => 'fixed-width-s',
            'title' => $this->l('Date'),
            'type' => 'date',
            'search' => true,
            'orderby' => true,
        );
        $this->fields_list['id_cart'] = array(
            'class' => 'fixed-width-s',
            'type' => 'text',
            'title' => $this->l('Id cart'),
            'name' => 'id_cart',
            'filter_key' => 'a!id_cart',
            'search' => true,
            'orderby' => true,
        );
        $this->fields_list['payid'] = array(
            'type' => 'text',
            'title' => $this->l('Ingenico PAYID'),
            'name' => 'payid',
            'search' => true,
            'orderby' => true,
        );
        $this->fields_list['osname'] = array(
            'title' => $this->l('Status'),
            'type' => 'select',
            'color' => 'color',
            'list' => $this->order_statuses,
            'filter_key' => 'os!id_order_state',
            'filter_type' => 'int',
            'order_key' => 'osname',
            'search' => true,
            'orderby' => true,
        );
        $this->fields_list['status'] = array(
            'title' => $this->l('Platform payment status'),
            'type' => 'select',
            'list' => $this->module->getReturnCodesList(),
            'filter_key' => 'tl!status',
            'filter_type' => 'int',
            'order_key' => 'tl!status',
            'callback' => 'printPaymentStatus',
            'search' => true,
            'orderby' => true,
        );
    }

    public function displayCaptureLink($token, $id, $name = null)
    {
        $tpl = $this->createTemplate('helpers/list/list_action_capture.tpl');
        list($can_capture, $error) = $this->module->canCapture(new Order($id));
        $tpl->assign(array(
            'href' => 'index.php?controller=AdminOgoneOrders&id_order=' . (int) $id . '&action=capture&token=' .
            Tools::getAdminTokenLite('AdminOgoneOrders'),
            'action' => $this->l('Capture', 'Helper'),
            'disable' => !$can_capture,
            'title' => $can_capture ? $this->l('Capture order', 'Helper') : $error,
            'icon' => 'icon-cc',
        ));
        return $tpl->fetch();
    }

    public function processCapture()
    {
        $id_order = Tools::getValue('id_order');
        if ($this->tabAccess['edit'] != 1 && !$this->context->employee->isSuperAdmin()) {
            $this->errors[] = Tools::displayError('You do not have permission to edit this.');
            return false;
        }

        if (!$id_order) {
            $this->errors[] = Tools::displayError('Invalid order id.');
            return false;
        }

        $order = new Order((int) $id_order);
        $currency = new Currency($order->id_currency);

        if (Tools::getValue('capture_amount') && (float)Tools::getValue('capture_amount') > 0) {
            $capture_amount = (float)preg_replace("/[^0-9,.]/", "", str_replace(',', '.', Tools::getValue('capture_amount')));
        } else {
            $capture_amount = null;
        }

        $capture_amount = max(0, min($order->total_paid -  $order->total_paid_real, $capture_amount ? $capture_amount : $order->total_paid));

        list($result, $message) = $this->module->capture($order, $capture_amount);

        if ($result) {
            $order_id = OgoneTransactionLog::getOgoneOrderIdByOrderId($order->id);
            $confirmation = Tools::getValue('return_link') ?
            sprintf(
                '<a href="%s">'.$this->module->l('Order %s') . '</a>' . $this->module->l(' capture request of amount of %s %s successfully sent. Processing can take a while.'),
                Tools::getValue('return_link'),
                $order_id,
                number_format($capture_amount, 2),
                $currency->iso_code
            )
            :
            sprintf(
                $this->module->l('Order %d  capture request of amount of %s %s successfully sent. Processing can take a while.'),
                $order->id,
                number_format($capture_amount, 2),
                $currency->iso_code
            );
            $this->confirmations[] = $confirmation;
        } else {
            $this->errors[] = sprintf($this->module->l('Error sending capture request for order %d : %s'), $order->id, $message);
        }

        return true;
    }

    public function processBulkCapture()
    {
        if ($this->tabAccess['edit'] != 1 && !$this->context->employee->isSuperAdmin()) {
            $this->errors[] = Tools::displayError('You do not have permission to edit this.');
            return false;
        }

        if (!is_array($this->boxes) || empty($this->boxes)) {
            return false;
        }

        $errors = array();
        $successes = array();
        foreach ($this->boxes as $id_order) {
            $order = new Order((int) $id_order);
            list($result, $message) = $this->module->capture($order);
            if ($result) {
                $successes[] = sprintf($this->module->l('Order %d captured successfully'), $order->id);
            } else {
                $errors[] = sprintf($this->module->l('Error capturing order %d : %s'), $order->id, $message);
            }
        }
        $this->confirmations = $successes;
        $this->errors = $errors;
        if (!empty($this->confirmations) && empty($this->errors)) {
            Tools::redirectAdmin($this->module->getCurrentIndex() . '&conf=1001&token=' . $this->token);
        }

        return true;
    }

    public function processRefund()
    {
        $id_order = Tools::getValue('id_order');
        if ($this->tabAccess['edit'] != 1 && !$this->context->employee->isSuperAdmin()) {
            $this->errors[] = Tools::displayError('You do not have permission to edit this.');
            return false;
        }

        if (!$id_order) {
            $this->errors[] = Tools::displayError('Invalid order id.');
            return false;
        }

        $order = new Order((int) $id_order);
        $currency = new Currency($order->id_currency);
        if (Tools::getValue('refund_amount') && (float)Tools::getValue('refund_amount') > 0) {
            $refund_amount = (float)preg_replace("/[^0-9,.]/", "", str_replace(',', '.', Tools::getValue('refund_amount')));
        } else {
            $refund_amount = null;
        }

        $max_refund_amount =  $this->module->getRefundMaxAmount($order->id);
        if ($refund_amount === null) {
            $refund_amount = $max_refund_amount;
        }
        $refund_amount = max(0, min($max_refund_amount, $refund_amount));

        list($result, $message) = $this->module->refund($order, $refund_amount);
        if ($result) {
            $order_id = OgoneTransactionLog::getOgoneOrderIdByOrderId($order->id);

            $confirmation = Tools::getValue('return_link') ?
            sprintf(
                '<a href="%s">'.$this->module->l('Order %s') . '</a>' . $this->module->l(' refund request of amount of %s %s successfully sent. Processing can take a while.'),
                Tools::getValue('return_link'),
                $order_id,
                number_format($refund_amount, 2),
                $currency->iso_code
            )
                :
            sprintf(
                $this->module->l('Order %s  refund request of amount of %s %s successfully sent. Processing can take a while.'),
                $order_id,
                number_format($refund_amount, 2),
                $currency->iso_code
            );

                $this->confirmations[] = $confirmation;
        } else {
            $this->errors[] = sprintf($this->module->l('Error refunding order %d : %s'), $order->id, $message);
        }
        return true;
    }

    public function printPaymentStatus($status, $row)
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
