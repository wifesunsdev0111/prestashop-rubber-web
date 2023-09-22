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
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2017 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */

require_once dirname(__FILE__) . '/../../config/config.inc.php';

if (Tools::getValue('ogone_check_url')) {
    die('uok');
}

/**
 * @var ogone
 */
$ogone = Module::getInstanceByName('ogone');
$ogone->log('Validation.php called : ' . var_export($_GET, true) . ' ' . var_export($_POST, true));
$ogone->log($_SERVER['REQUEST_SCHEME'] . '://' .  $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

$secure_key = Tools::getIsset('secure_key') ? Tools::getValue('secure_key') : '';
$ogone->log('secure_key : ' . $secure_key);

$sha_sign_received = Tools::getIsset('SHASIGN') ? Tools::getValue('SHASIGN') : '';

if (!$ogone->verifyReturnArgs()) {
    $ogone->logAndDie(sprintf('%s : %s', $ogone->l('Missing parameters'), implode(', ', $ogone->listMissingReturnArgs())));
}

/* Fist, check for a valid SHA-1 signature */
$ogone_params = $ogone->getOgoneParams($_GET);
if (empty($ogone_params['ORDERID'])) {
    // Failback
    $ogone_params = $ogone->getOgoneParams($_POST);
}

$id_cart = (int) $ogone->extractCartId($ogone_params['ORDERID']);
$ogone->log(sprintf('ORDERID : %s, ID CART : %d', $ogone_params['ORDERID'], $id_cart));

/* Then, load the customer cart and perform some checks */
$cart = new Cart($id_cart);

if ($ogone->setShopContext($cart)) {
    $ogone->log('Shop context switched to : ' . Context::getContext()->shop->id);
}

// necessary for cart::duplicate
$ogone->setEmployee();

if (!$ogone->active) {
    $ogone->logAndDie($ogone->l('Module is desactivated'));
}

if (!Validate::isLoadedObject($cart)) {
    $ogone->logAndDie($ogone->l('Unable to load cart'));
}
if (!Configuration::get('OGONE_SHA_OUT')) {
    $ogone->logAndDie($ogone->l('Invalid value of variable OGONE_SHA_OUT'));
}

$sha1 = $ogone->calculateShaSign($ogone_params, Configuration::get('OGONE_SHA_OUT'));

if (!$sha_sign_received || $sha1 !== $sha_sign_received) {
    $ogone->logAndDie(sprintf('SHA_OUT ERROR - received %s, calculated %s ', $sha_sign_received, $sha1));
}

if ($sha_sign_received && $sha1 === $sha_sign_received) {
    if ($ogone->isSubscription($id_cart)) {
        $ogone->log('SUBSCRIPTION');
        $ogone->handleSubscription($id_cart, $ogone_params);
        $ogone->logAndDie('Subscription handled');
    }

    $ogone_return_code = (int) $ogone_params['STATUS'];
    $ogone->log('ogone_return_code : ' . $ogone_return_code);

    $existing_id_order = (int) Order::getOrderByCartId($id_cart);
    $ogone->log('existing_id_order : ' . $existing_id_order);

    $ogone_state = $ogone->getCodePaymentStatus($ogone_return_code);
    $ogone->log('ogone_state : ' . $ogone_state);

    $ogone_state_description = $ogone->getCodeDescription($ogone_return_code);
    $ogone->log('ogone_state_description : ' . $ogone_state_description);

    $payment_state_id = $ogone->getPaymentStatusId($ogone_state);
    $ogone->log('payment_state_id : ' . $payment_state_id);

    $amount_paid = ($ogone_state === Ogone::PAYMENT_ACCEPTED || $ogone_state === Ogone::PAYMENT_AUTHORIZED
        || $ogone_state === Ogone::PAYMENT_IN_PROGRESS   || $ogone_state === Ogone::SCHEDULED_PAYMENT_IN_PROGRESS ?
        (float) $ogone_params['AMOUNT'] :
        0);

    if ((int)Configuration::get('PS_CURRENCY_DEFAULT') !== (int)$cart->id_currency) {
        $default_currency = new Currency((int)Configuration::get('PS_CURRENCY_DEFAULT'));
        $currency = new Currency((int)$cart->id_currency);
        $amount_paid_converted = Tools::convertPrice($amount_paid, $currency, $default_currency);
        $ogone->log(sprintf('amount_paid : %s %s (%s %s)', $amount_paid_converted, $default_currency->iso_code, $amount_paid, $currency->iso_code));
       //  $amount_paid = $amount_paid_converted;
    } else {
        $ogone->log('amount_paid : ' . $amount_paid);
    } //  if ((int)Configuration::get('PS_CURRENCY_DEFAULT') !== (int)$cart->id_currency)

    $tl = $ogone->addTransactionLog($id_cart, $existing_id_order, 0, $ogone_params);

    // adding alias
    if (Configuration::get('OGONE_PROPOSE_ALIAS')) {
        $alias_data = $ogone->getAliasReturnVariables();
        if ($alias_data['ALIAS']) {
            list($alias_result, $alias_message) = $ogone->createAlias($cart->id_customer, $alias_data, true);
            $ogone->log('Alias creation : ' . $alias_result . ' ' .$alias_message);
        } // if ($alias_data['ALIAS'])
    } // if (Configuration::get('OGONE_PROPOSE_ALIAS'))

    if (!$existing_id_order && in_array($payment_state_id, array(Configuration::get(Ogone::PAYMENT_ERROR), Configuration::get(Ogone::PAYMENT_CANCELLED)))) {
        $ogone->logAndDie(sprintf('No existing order id, ogone status %s mapped to %s, leaving validation script', $ogone_return_code, $payment_state_id));
    } // if (!$existing_id_order && in_array($payment_state_id, array(Configuration::get(Ogone::PAYMENT_ERROR), Configuration::get(Ogone::PAYMENT_CANCELLED)))) {

    if ($existing_id_order) {
        $order = new Order($existing_id_order);
        if (!Validate::isLoadedObject($order)) {
            $ogone->logAndDie('Invalid order');
        } //  if (!Validate::isLoadedObject($order))
        $currency = new Currency($order->id_currency);
        $refund_codes = array(
            DirectLink::STATUS_REFUND,
            DirectLink::STATUS_REFUND_HANDLED_BY_MERCHANT,
            DirectLink::STATUS_REFUND_INTERMEDIARY,
            DirectLink::STATUS_REFUND_PENDING,
            DirectLink::STATUS_REFUND_REFUSED,
            DirectLink::STATUS_REFUND_UNCERTAIN
        );

        if (in_array($ogone_return_code, $refund_codes)) {
            $refund_msg = $ogone->l('Refund performed : ') . $ogone->convertArrayToReadableString($ogone_params, ' ; <br/>');
            $ogone->log($refund_msg);

            $ogone->addMessage($existing_id_order, $refund_msg);

            $ogone->log(sprintf('Refund: %s %s %s', $ogone_return_code, (float)$ogone_params['AMOUNT'], $order->total_paid_real));

            if ((int)$ogone_return_code === (int)DirectLink::STATUS_REFUND) {
                $refund_amount = (float)$ogone_params['AMOUNT'];
                if ($refund_amount > 0) {
                    $ogone->addMessage($existing_id_order, sprintf($ogone->l('Refunded %s %s'), $ogone_params['AMOUNT'], $currency->iso_code));
                } // if ($refund_amount > 0)

                if (round($refund_amount*100, 0) ===  round($order->total_paid_real*100, 0)) {
                    $ogone->log('Total refund');
                    $ogone->addHistory((int)$existing_id_order, (int) Configuration::get('PS_OS_REFUND'), false);
                } //  if (round($refund_amount*100, 0) ===  round($order->total_paid_real*100, 0)
            } else {
                 $ogone->addMessage($ogone->l('Refund step without amount change : ') . $ogone->convertArrayToReadableString($ogone_params, ' ; <br/>'));
            } //  if ((int)$ogone_return_code === (int)DirectLink::STATUS_REFUND)
        } else {
            if ($order->total_paid_real == $amount_paid && (int)$order->getCurrentState() === $payment_state_id) {
                $ogone->log(sprintf('Order %d in state %d yet and paid, ignoring this call', $payment_state_id, $existing_id_order));
                //PrestaShopLogger::addLog(sprintf('Order %d in state %d yet and paid, ignoring this call', $payment_state_id, $existing_id_order));
            } elseif (!$order->getCurrentState()) {
                $ogone->log(sprintf('Order %d in train of creation, state not defined, ignoring this call with state %d', $existing_id_order, $payment_state_id));
                //PrestaShopLogger::addLog(sprintf('Order %d in train of creation, state not defined, ignoring this call with state %d', $existing_id_order, $payment_state_id));
            } else {
                /* Update the amount really paid */
                if ($amount_paid >= 0 && $order->total_paid_real !== $order->total_paid) {
                    $ogone->log(sprintf('BEFORE order->total_paid_real : %s order->total_paid:  %s ', $order->total_paid_real, $order->total_paid));
                    $order->total_paid_real = $order->total_paid_real + $amount_paid;
                    if ($order->update()) {
                        $ogone->log(sprintf('AFTER order->total_paid_real : %s order->total_paid:  %s ', $order->total_paid_real, $order->total_paid));
                    } else {
                        $ogone->logAndDie('Unable to update order');
                    }
                }

                if (version_compare(_PS_VERSION_, '1.5', 'ge')) {
                    $ogone->addPayment($order, $amount_paid, $ogone_params);
                }
                // final payment, we can capture
                if ($order->total_paid_real == $order->total_paid) {
                    $ogone->addHistory((int)$existing_id_order, (int)$payment_state_id, true);
                }
            }// if ($order->total_paid_real == $amount_paid && (int)$order->getCurrentState() === $payment_state_id)
        } // if (in_array($ogone_return_code, $refund_codes))

        /* Add message */
        $message = sprintf(
            '%s: %d %s %s %f',
            $ogone->l('Ogone update'),
            $ogone_return_code,
            $ogone_state,
            $ogone_state_description,
            $amount_paid
        );
        $ogone->addMessage($existing_id_order, $message);
        $ogone->logAndDie($message);
    } else {
        $message = sprintf('%s %s %s', $ogone_state_description, Tools::safeOutput($ogone_state), $ogone->getParamsListAsHtml($ogone_params));
        $ogone->log($message);
        $ogone->log('Validating order, state ' . $payment_state_id);
        $result = $ogone->validate(
            $id_cart,
            $payment_state_id,
            $amount_paid,
            $message,
            $secure_key ? Tools::safeOutput($secure_key) : false
        );
        if ($tl && !$existing_id_order && $tl->id_order == 0) {
            $tl->id_order = $ogone->currentOrder;
            $tl->save();
        }
        $ogone->addMessage($ogone->currentOrder, $message);

        if ($ogone_state === Ogone::SCHEDULED_PAYMENT_IN_PROGRESS) {
            if ($ogone_state === Ogone::SCHEDULED_PAYMENT_IN_PROGRESS) {
                $schedules = $ogone->getScheduledPaymentVars($amount_paid);
                if ($schedules) {
                    $amount_paid_real = round($schedules[sprintf('AMOUNT%d', 1)] / 100, 2);
                    $order = new Order($ogone->currentOrder);
                    $payments = OrderPayment::getByOrderReference($order->reference);
                    if ($payments && $amount_paid_real) {
                        $payments[0]->amount = $amount_paid_real;
                        $payments[0]->update();
                    }
                }
            }
        }

        $ogone->logAndDie('Order validate result ' . ($result ? 'OK' : 'FAIL'));
    } // if ($existing_id_order)
} else {
    $message = $ogone->l('Invalid SHA-1 signature') . '<br />' . $ogone->l('SHA-1 given:') . ' ' .
        Tools::safeOutput($sha_sign_received) . '<br />' .$ogone->l('SHA-1 calculated:') . ' ' .
        Tools::safeOutput($sha1) . '<br />' . $ogone->l('Params: ') . ' ' . $ogone->getParamsListAsHtml($ogone_params);
    $ogone->log($message);
    $ogone->log($ogone_params);
    $ogone->log('Validating order, state ' . Configuration::get('PS_OS_ERROR'));
    $result = $ogone->validate(
        $id_cart,
        Configuration::get('PS_OS_ERROR'),
        0,
        $message . '<br />' .  $ogone->getParamsListAsHtml($ogone_params),
        $secure_key ? Tools::safeOutput($secure_key) : false
    );
    $ogone->logAndDie('Order validate result ' . ($result ? 'OK' : 'FAIL'));
} // ($sha_sign_received && $sha1 == $sha_sign_received)
