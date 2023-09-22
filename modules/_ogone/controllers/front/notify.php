<?php
/**
 * 2007-2019 PrestaShop
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   http://opensource.org/licenses/afl-3.0.php    Academic Free License (AFL 3.0)
 *    International Registered Trademark & Property of PrestaShop SA
 */

/**
 * Class OgoneNotifyModuleFrontController
 */
class OgoneNotifyModuleFrontController extends ModuleFrontController
{
    /** @var bool $display_column_left */
    public $display_column_left = false;

    /** @var Ogone $module */
    public $module;

    /**
     *
     */
    public function postProcess()
    {
        parent::postProcess();

        if (Tools::getValue('ogone_check_url')) {
            die('uok');
        }
        $this->module->log('Validation.php called : '.var_export($_GET, true).' '.var_export($_POST, true));
        $this->module->log($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

        $secureKey = Tools::getIsset('secure_key') ? Tools::getValue('secure_key') : '';
        $this->module->log('secure_key : '.$secureKey);

        $shaSignReceived = Tools::getIsset('SHASIGN') ? Tools::getValue('SHASIGN') : '';

        if (!$this->module->verifyReturnArgs()) {
            $this->module->logAndDie(
                sprintf(
                    '%s : %s',
                    $this->module->l('Missing parameters'),
                    implode(', ', $this->module->listMissingReturnArgs())
                )
            );
        }

        $ogoneParams = $this->module->getOgoneParams($_GET);
        if (empty($ogoneParams['ORDERID'])) {
            $ogoneParams = $this->module->getOgoneParams($_POST);
        }

        $idCart = (int) $this->module->extractCartId($ogoneParams['ORDERID']);
        $this->module->log(sprintf('ORDERID : %s, ID CART : %d', $ogoneParams['ORDERID'], $idCart));
        $cart = new Cart($idCart);
        if ($this->module->setShopContext($cart)) {
            $this->module->log('Shop context switched to : '.Context::getContext()->shop->id);
        }

        $this->module->setEmployee();

        if (!$this->module->active) {
            $this->module->logAndDie($this->module->l('Module is desactivated'));
        }

        if (!Validate::isLoadedObject($cart)) {
            $this->module->logAndDie($this->module->l('Unable to load cart'));
        }
        if (!Configuration::get('OGONE_SHA_OUT')) {
            $this->module->logAndDie($this->module->l('Invalid value of variable OGONE_SHA_OUT'));
        }

        $sha1 = $this->module->calculateShaSign($ogoneParams, Configuration::get('OGONE_SHA_OUT'));

        if (!$shaSignReceived || $sha1 !== $shaSignReceived) {
            $this->module->logAndDie(sprintf('SHA_OUT ERROR - received %s, calculated %s ', $shaSignReceived, $sha1));
        }

        if ($shaSignReceived && $sha1 === $shaSignReceived) {
            if ($this->module->isSubscription($idCart)) {
                $this->module->log('SUBSCRIPTION');
                $this->module->handleSubscription($idCart, $ogoneParams);
                $this->module->logAndDie('Subscription handled');
            }

            $ogoneReturnCode = (int) $ogoneParams['STATUS'];
            $this->module->log('ogone_return_code : '.$ogoneReturnCode);

            $existingOrderId = (int) Order::getOrderByCartId($idCart);
            $this->module->log('existing_id_order : '.$existingOrderId);

            $ogoneState = $this->module->getCodePaymentStatus($ogoneReturnCode);
            $this->module->log('ogone_state : '.$ogoneState);

            $ogoneStateDescription = $this->module->getCodeDescription($ogoneReturnCode);
            $this->module->log('ogone_state_description : '.$ogoneStateDescription);

            $paymentStateId = $this->module->getPaymentStatusId($ogoneState);
            $this->module->log('payment_state_id : '.$paymentStateId);

            $amountPaid = ($ogoneState === Ogone::PAYMENT_ACCEPTED || $ogoneState === Ogone::PAYMENT_AUTHORIZED
                           || $ogoneState === Ogone::PAYMENT_IN_PROGRESS || $ogoneState === Ogone::SCHEDULED_PAYMENT_IN_PROGRESS ?
                (float) $ogoneParams['AMOUNT'] :
                0);

            if ((int) Configuration::get('PS_CURRENCY_DEFAULT') !== (int) $cart->id_currency) {
                $defaultCurrency = new Currency((int) Configuration::get('PS_CURRENCY_DEFAULT'));
                $currency = new Currency((int) $cart->id_currency);
                $amountPaidConverted = Tools::convertPrice($amountPaid, $currency, $defaultCurrency);
                $this->module->log(
                    sprintf(
                        'amount_paid : %s %s (%s %s)',
                        $amountPaidConverted,
                        $defaultCurrency->iso_code,
                        $amountPaid,
                        $currency->iso_code
                    )
                );
            } else {
                $this->module->log('amount_paid : '.$amountPaid);
            }
            $tl = $this->module->addTransactionLog($idCart, $existingOrderId, 0, $ogoneParams);

            // adding alias
            if (Configuration::get('OGONE_PROPOSE_ALIAS')) {
                $aliasData = $this->module->getAliasReturnVariables();
                if ($aliasData['ALIAS']) {
                    list($alias_result, $alias_message) = $this->module->createAlias(
                        $cart->id_customer,
                        $aliasData,
                        true
                    );
                    $this->module->log('Alias creation : '.$alias_result.' '.$alias_message);
                } // if ($alias_data['ALIAS'])
            } // if (Configuration::get('OGONE_PROPOSE_ALIAS'))

            if (!$existingOrderId && in_array(
                    $paymentStateId,
                    array(Configuration::get(Ogone::PAYMENT_ERROR), Configuration::get(Ogone::PAYMENT_CANCELLED))
                )) {
                $this->module->logAndDie(
                    sprintf(
                        'No existing order id, ogone status %s mapped to %s, leaving validation script',
                        $ogoneReturnCode,
                        $paymentStateId
                    )
                );
            } // if (!$existing_id_order && in_array($payment_state_id, array(Configuration::get(Ogone::PAYMENT_ERROR), Configuration::get(Ogone::PAYMENT_CANCELLED)))) {

            if ($existingOrderId) {
                $order = new Order($existingOrderId);
                if (!Validate::isLoadedObject($order)) {
                    $this->module->logAndDie('Invalid order');
                } //  if (!Validate::isLoadedObject($order))
                $currency = new Currency($order->id_currency);
                $refundCodes = array(
                    DirectLink::STATUS_REFUND,
                    DirectLink::STATUS_REFUND_HANDLED_BY_MERCHANT,
                    DirectLink::STATUS_REFUND_INTERMEDIARY,
                    DirectLink::STATUS_REFUND_PENDING,
                    DirectLink::STATUS_REFUND_REFUSED,
                    DirectLink::STATUS_REFUND_UNCERTAIN,
                );

                if (in_array($ogoneReturnCode, $refundCodes)) {
                    $refund_msg = $this->module->l('Refund performed : ').$this->module->convertArrayToReadableString(
                            $ogoneParams,
                            ' ; <br/>'
                        );
                    $this->module->log($refund_msg);

                    $this->module->addMessage($existingOrderId, $refund_msg);

                    $this->module->log(
                        sprintf(
                            'Refund: %s %s %s',
                            $ogoneReturnCode,
                            (float) $ogoneParams['AMOUNT'],
                            $order->total_paid_real
                        )
                    );

                    if ((int) $ogoneReturnCode === (int) DirectLink::STATUS_REFUND) {
                        $refundAmount = (float) $ogoneParams['AMOUNT'];
                        if ($refundAmount > 0) {
                            $this->module->addMessage(
                                $existingOrderId,
                                sprintf(
                                    $this->module->l('Refunded %s %s'),
                                    $ogoneParams['AMOUNT'],
                                    $currency->iso_code
                                )
                            );
                        } // if ($refund_amount > 0)

                        if (round($refundAmount * 100, 0) === round($order->total_paid_real * 100, 0)) {
                            $this->module->log('Total refund');
                            $this->module->addHistory(
                                (int) $existingOrderId,
                                (int) Configuration::get('PS_OS_REFUND'),
                                false
                            );
                        } //  if (round($refund_amount*100, 0) ===  round($order->total_paid_real*100, 0)
                    } else {
                        $this->module->addMessage(
                            $this->module->l(
                                'Refund step without amount change : '
                            ).$this->module->convertArrayToReadableString(
                                $ogoneParams,
                                ' ; <br/>'
                            )
                        );
                    } //  if ((int)$ogone_return_code === (int)DirectLink::STATUS_REFUND)
                } else {
                    if ($order->total_paid_real == $amountPaid && (int) $order->getCurrentState() === $paymentStateId) {
                        $this->module->log(
                            sprintf(
                                'Order %d in state %d yet and paid, ignoring this call',
                                $paymentStateId,
                                $existingOrderId
                            )
                        );
                        //PrestaShopLogger::addLog(sprintf('Order %d in state %d yet and paid, ignoring this call', $payment_state_id, $existing_id_order));
                    } elseif (!$order->getCurrentState()) {
                        $this->module->log(
                            sprintf(
                                'Order %d in train of creation, state not defined, ignoring this call with state %d',
                                $existingOrderId,
                                $paymentStateId
                            )
                        );
                        //PrestaShopLogger::addLog(sprintf('Order %d in train of creation, state not defined, ignoring this call with state %d', $existing_id_order, $payment_state_id));
                    } else {
                        /* Update the amount really paid */
                        if ($amountPaid >= 0 && $order->total_paid_real !== $order->total_paid) {
                            $this->module->log(
                                sprintf(
                                    'BEFORE order->total_paid_real : %s order->total_paid:  %s ',
                                    $order->total_paid_real,
                                    $order->total_paid
                                )
                            );
                            $order->total_paid_real = $order->total_paid_real + $amountPaid;
                            if ($order->update()) {
                                $this->module->log(
                                    sprintf(
                                        'AFTER order->total_paid_real : %s order->total_paid:  %s ',
                                        $order->total_paid_real,
                                        $order->total_paid
                                    )
                                );
                            } else {
                                $this->module->logAndDie('Unable to update order');
                            }
                        }

                        if (version_compare(_PS_VERSION_, '1.5', 'ge')) {
                            $this->module->addPayment($order, $amountPaid, $ogoneParams);
                        }
                        // final payment, we can capture
                        if ($order->total_paid_real == $order->total_paid) {
                            $this->module->addHistory((int) $existingOrderId, (int) $paymentStateId, true);
                        }
                    }// if ($order->total_paid_real == $amount_paid && (int)$order->getCurrentState() === $payment_state_id)
                } // if (in_array($ogone_return_code, $refund_codes))

                /* Add message */
                $message = sprintf(
                    '%s: %d %s %s %f',
                    $this->module->l('Ogone update'),
                    $ogoneReturnCode,
                    $ogoneState,
                    $ogoneStateDescription,
                    $amountPaid
                );
                $this->module->addMessage($existingOrderId, $message);
                $this->module->logAndDie($message);
            } else {
                $message = sprintf(
                    '%s %s %s',
                    $ogoneStateDescription,
                    Tools::safeOutput($ogoneState),
                    $this->module->getParamsListAsHtml($ogoneParams)
                );
                $this->module->log($message);
                $this->module->log('Validating order, state '.$paymentStateId);
                $result = $this->module->validate(
                    $idCart,
                    $paymentStateId,
                    $amountPaid,
                    $message,
                    $secureKey ? Tools::safeOutput($secureKey) : false
                );
                if ($tl && !$existingOrderId && $tl->id_order == 0) {
                    $tl->id_order = $this->module->currentOrder;
                    $tl->save();
                }
                $this->module->addMessage($this->module->currentOrder, $message);

                if ($ogoneState === Ogone::SCHEDULED_PAYMENT_IN_PROGRESS) {
                    if ($ogoneState === Ogone::SCHEDULED_PAYMENT_IN_PROGRESS) {
                        $schedules = $this->module->getScheduledPaymentVars($amountPaid);
                        if ($schedules) {
                            $amount_paid_real = round($schedules[sprintf('AMOUNT%d', 1)] / 100, 2);
                            $order = new Order($this->module->currentOrder);
                            $payments = OrderPayment::getByOrderReference($order->reference);
                            if ($payments && $amount_paid_real) {
                                $payments[0]->amount = $amount_paid_real;
                                $payments[0]->update();
                            }
                        }
                    }
                }

                $this->module->logAndDie('Order validate result '.($result ? 'OK' : 'FAIL'));
            } // if ($existing_id_order)
        } else {
            $message = $this->module->l('Invalid SHA-1 signature').'<br />'.$this->module->l('SHA-1 given:').' '.
                       Tools::safeOutput($shaSignReceived).'<br />'.$this->module->l('SHA-1 calculated:').' '.
                       Tools::safeOutput($sha1).'<br />'.$this->module->l(
                    'Params: '
                ).' '.$this->module->getParamsListAsHtml(
                    $ogoneParams
                );
            $this->module->log($message);
            $this->module->log($ogoneParams);
            $this->module->log('Validating order, state '.Configuration::get('PS_OS_ERROR'));
            $result = $this->module->validate(
                $idCart,
                Configuration::get('PS_OS_ERROR'),
                0,
                $message.'<br />'.$this->module->getParamsListAsHtml($ogoneParams),
                $secureKey ? Tools::safeOutput($secureKey) : false
            );
            $this->module->logAndDie('Order validate result '.($result ? 'OK' : 'FAIL'));
        }
    }

    /**
     * @return bool
     */
    public function display()
    {
        return true;
    }
}
