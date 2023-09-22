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

class OgoneSubscribeModuleFrontController extends ModuleFrontController
{

    public $name = 'subscribe';
    const CONFLICT_ANOTHER_SUBSCRIPTION = 4;

    public function initContent()
    {
        parent::initContent();
        $this->dispatch();
    }

    public function setTemplate($template, $params = array(), $locale = null)
    {
        return $this->module->isPS17x() ? parent::setTemplate('module:ogone/views/templates/front/' . str_replace('.tpl', '-17.tpl', $template), $params, $locale) : parent::setTemplate($template, $params, $locale);
    }

    protected function dispatch()
    {
        if ($this->context->customer && $this->context->customer->isLogged() && Tools::getValue('action') === 'add') {
            return $this->processAddSubscription();
        }
        $this->setTemplate('subscriptions-disabled.tpl');
        return '';
    }

    protected function cleanConcurrentSubscriptions($id_customer)
    {
        foreach (OgoneSubscription::getCustomerActiveSubscriptions($id_customer) as $subscription) {
            if (!Order::getOrderByCartId((int)$subscription['id_cart'])) {
                $subscription = new OgoneSubscription($subscription['id_ogone_subscription']);
                $subscription->delete();
            }
        }
    }

    protected function processAddSubscription()
    {
        $id_subscription = Tools::getValue('id_subscription');
        $cart = $this->context->cart;
        if (!isset($cart) || !$cart->id) {
            $cart = new Cart();
            $cart->id_lang = (int)($this->context->cookie->id_lang);
            $cart->id_currency = (int)($this->context->cookie->id_currency);
            $cart->id_guest = (int)($this->context->cookie->id_guest);
            $cart->id_shop_group = (int)$this->context->shop->id_shop_group;
            $cart->id_shop = $this->context->shop->id;
            if ($this->context->cookie->id_customer) {
                $cart->id_customer = (int)($this->context->cookie->id_customer);
                $cart->id_address_delivery = (int)(Address::getFirstCustomerAddressId($cart->id_customer));
                $cart->id_address_invoice = $cart->id_address_delivery;
            } else {
                $cart->id_address_delivery = 0;
                $cart->id_address_invoice = 0;
            }
            // Needed if the merchant want to give a free product to every visitors
            $this->context->cart = $cart;
            $this->context->cart->add();
            $this->context->cookie->id_cart = (int)$this->context->cart->id;
            CartRule::autoAddToCart($this->context);
        }

        $tpl_vars = array();
        $errors = array();
        $tpl_vars['subscription_data'] = null;
        $subscription_product = new OgoneProductSubscription($id_subscription);
        $product = new Product($subscription_product->id_product);
        $tpl_vars['subscription_data'] =  $this->module->getFutureSubscriptionReadableDetails($subscription_product, $product->getPrice(true, $subscription_product->id_product_attribute));
        list ($can_add, $errors) = $this->verifySubscriptionPrerequisites($subscription_product, $cart);
        if ($can_add) {
            $conflicts = $this->listConflicts($subscription_product, $cart);
            $conflicts = $this->resolveConflicts($conflicts, $cart);
            if (!empty($conflicts)) {
                $can_add = false;
                $errors = $conflicts;
            }
        }
        if ($can_add) {
            if (!$cart->updateQty(1, $subscription_product->id_product, $subscription_product->id_product_attribute ? $subscription_product->id_product_attribute : null)) {
                $errors[] = $this->module->l('Unable to add item to cart');
            }
            $this->cleanConcurrentSubscriptions($cart->id_customer);
            $subscription = OgoneSubscription::createFromSubscriptionProduct($subscription_product);
            $subscription->id_cart = $cart->id;
            $subscription->id_customer = $cart->id_customer;

            if (!$subscription->add()) {
                $errors[] = $this->module->l('Unable to  create subscription cart');
            }
        }
        if (!$errors) {
            $tpl_vars['errors'] = $tpl_vars['oerrors'] = null;

            $actions = array();
            $actions[] = array(
                'link' => $this->context->link->getPageLink('cart', null, null, array(
                    'action' => 'show'
                )),
                'name' => $this->module->l('Go to cart', 'subscribe')
            );
            $actions[] = array(
                'link' => $this->context->link->getPageLink('order'),
                'name' => $this->module->l('Go to checkout page', 'subscribe')
            );
            $tpl_vars['actions'] = $actions;
            $this->context->smarty->assign($tpl_vars);
            $this->setTemplate('subscription-add-confirm.tpl');
            // $this->redirectToCartPage();
        } else {
            $tpl_vars['errors'] = $tpl_vars['oerrors'] = $errors;
            $actions = array();
            if (isset($errors[4])) {
                $actions[] = array(
                    'link' => $this->context->link->getPageLink('order', null, null, array(
                        'action' => 'show'
                    )),
                    'name' => $this->module->l('Go to cart', 'subscribe')
                );
                $actions[] = array(
                    'link' => $this->context->link->getModuleLink('ogone', 'subscribe', array(
                        'action' => 'add',
                        'id_subscription' => $id_subscription,
                        'force' => 1
                    )),
                    'name' => $this->module->l('Clear cart', 'subscribe')
                );
            }

            $tpl_vars['actions'] = $actions;
            $this->context->smarty->assign($tpl_vars);
            Context::getContext()->smarty->assign($tpl_vars);
            $this->setTemplate('subscription-add-errors.tpl');
        }
    }

    protected function verifySubscriptionPrerequisites($subscription_product, $cart)
    {
        $errors = array();
        if ($this->context->customer && !$this->context->customer->isLogged()) {
            $errors[1] = $this->module->l('You need to be connected in order to use subscription');
        }
        if (!Validate::isLoadedObject($cart)) {
            $errors[1] = $this->module->l('Unable to load cart');
        }
        if (!$subscription_product) {
            $errors[2] = $this->module->l('Impossible to load subscription data');
        }
        if ($subscription_product && !$subscription_product->active) {
            $errors[3] = $this->module->l('Subscription is invalid');
        }

        return array(
            empty($errors),
            $errors
        );
    }

    protected function listConflicts($subscription_product, $cart)
    {
        $result = array();
        if (count($this->module->getSubscriptionArticlesFromCart($cart)) > 0) {
            $result[self::CONFLICT_ANOTHER_SUBSCRIPTION] = $this->module->l('You cannot add two subscriptions to cart', 'subscribe');
        }
        return $result;
    }

    protected function resolveConflicts($conflicts, $cart)
    {
        if (isset($conflicts[self::CONFLICT_ANOTHER_SUBSCRIPTION]) && Tools::getValue('force')) {
            foreach ($this->module->getSubscriptionArticlesFromCart($cart) as $subscription) {
                $cart->deleteProduct($subscription->id_product, $subscription->id_product_attribute);
            }
            $this->cleanConcurrentSubscriptions($cart->id_customer);
            if (count($this->module->getSubscriptionArticlesFromCart($cart)) == 0) {
                unset($conflicts[self::CONFLICT_ANOTHER_SUBSCRIPTION]);
            }
        }
        return $conflicts;
    }

    protected function redirectToCartPage()
    {
        Tools::redirect($this->context->link->getPageLink('cart'));
    }
}
