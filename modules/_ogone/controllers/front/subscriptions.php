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
 * @author PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2014 PrestaShop SA
 * @license http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 *          International Registered Trademark & Property of PrestaShop SA
 *
 */

class OgoneSubscriptionsModuleFrontController extends ModuleFrontController
{

    public $name = 'subscriptions';
    public $display_column_left = false;

    public function setMedia()
    {
        if ($this->module->isPS17x()) {
            $this->context->controller->registerJavascript($this->module->name . '-aliases', 'modules/' . $this->module->name . '/views/js/subscriptions.js');
        }
        return parent::setMedia();
    }

    public function initContent()
    {
        parent::initContent();
        $this->dispatch();
    }

    public function getControllerUrl()
    {
        return $this->context->link->getModuleLink('ogone', 'subscriptions');
    }

    public function setTemplate($template, $params = array(), $locale = null)
    {
        return $this->module->isPS17x() ? parent::setTemplate('module:ogone/views/templates/front/' . str_replace('.tpl', '-17.tpl', $template), $params, $locale) : parent::setTemplate($template);
    }

    protected function isAuthenticated()
    {
        return $this->context->customer && $this->context->customer->isLogged();
    }

    protected function assertCustomerIsAuthenticated()
    {
        if (!$this->isAuthenticated()) {
            Tools::redirect('index.php?controller=authentication&back=' . urlencode($this->getControllerUrl()));
        }
    }

    protected function dispatch()
    {
        $this->assertCustomerIsAuthenticated();

        if (Tools::isSubmit('submitStopSubscription') && Tools::getValue('id_subscription')) {
            $this->processStopSubscription();
        }

        $this->assignList();
    }

    protected function assignList()
    {
        $this->assertCustomerIsAuthenticated();

        $customer = $this->context->customer;

        if ($this->module->canUseSubscription()) {
            $subscriptions = array();
            foreach (OgoneSubscription::getCustomerSubscriptionsInstances($customer->id) as $subscription) {
                if (!$subscription->id_cart) {
                    continue;
                }

                $cart = new Cart($subscription->id_cart);
                $subscription_data = $this->module->getCurrentSubscriptionReadableDetails($subscription, $this->module->getSubscriptionTotal($cart));
                $subscriptions[$subscription->id] = $subscription_data;
            }

            $tpl_vars = array(
                'url' => $this->getControllerUrl(),
                'stop_link' => $this->getControllerUrl(),
                'subscriptions' => $subscriptions
            );
            $this->context->smarty->assign($tpl_vars);
            $this->setTemplate('subscriptions.tpl');
        } else {
            $this->setTemplate('subscriptions-disabled.tpl');
        }
    }

    public function processStopSubscription()
    {
        $this->assertCustomerIsAuthenticated();
        $id_subscription = (int)Tools::getValue('id_subscription');
        $subscription = new OgoneSubscription($id_subscription);
        if (!Validate::isLoadedObject($subscription) || (int)$subscription->id_customer !== (int)$this->context->customer->id) {
            $this->context->smarty->assign('errors', array(
                $this->module->l('Invalid customer', 'subscriptions')
            ));
            return false;
        } else {
            try {
                if ($this->module->stopSubscription($subscription)) {
                    $this->context->smarty->assign('messages', array(
                        $this->module->l('Request for subscription deactivation was sent. It may take a while to process your demand.', 'subscriptions')
                    ));
                    return true;
                }
            } catch (Exception $ex) {
                $this->context->smarty->assign('errors', array(
                    $ex->getMessage()
                ));
                return false;
            }
        }
        $this->context->smarty->assign('errors', array(
            $this->module->l('Unable to delete subscription', 'subscriptions')
        ));
        return false;
    }
}
