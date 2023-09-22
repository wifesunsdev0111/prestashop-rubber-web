<?php
/**
 *
 *  2007-2021 PayPal
 *
 *  NOTICE OF LICENSE
 *
 *  This source file is subject to the Academic Free License (AFL 3.0)
 *  that is bundled with this package in the file LICENSE.txt.
 *  It is also available through the world-wide-web at this URL:
 *  http://opensource.org/licenses/afl-3.0.php
 *  If you did not receive a copy of the license and are unable to
 *  obtain it through the world-wide-web, please send an email
 *  to license@prestashop.com so we can send you a copy immediately.
 *
 *  DISCLAIMER
 *
 *  Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 *  versions in the future. If you wish to customize PrestaShop for your
 *  needs please refer to http://www.prestashop.com for more information.
 *
 *  @author 2007-2021 PayPal
 *  @author 202 ecommerce <tech@202-ecommerce.com>
 *  @copyright PayPal
 *  @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 */

namespace Braintree;

class SubscriptionSearch
{
    public static function billingCyclesRemaining()
    {
        return new RangeNode('billing_cycles_remaining');
    }

    public static function daysPastDue()
    {
        return new RangeNode('days_past_due');
    }

    public static function id()
    {
        return new TextNode('id');
    }

    public static function inTrialPeriod()
    {
        return new MultipleValueNode('in_trial_period', [true, false]);
    }

    public static function merchantAccountId()
    {
        return new MultipleValueNode('merchant_account_id');
    }

    public static function nextBillingDate()
    {
        return new RangeNode('next_billing_date');
    }

    public static function planId()
    {
        return new MultipleValueOrTextNode('plan_id');
    }

    public static function price()
    {
        return new RangeNode('price');
    }

    public static function status()
    {
        return new MultipleValueNode('status', [
            Subscription::ACTIVE,
            Subscription::CANCELED,
            Subscription::EXPIRED,
            Subscription::PAST_DUE,
            Subscription::PENDING,
        ]);
    }

    public static function transactionId()
    {
        return new TextNode('transaction_id');
    }

    public static function ids()
    {
        return new MultipleValueNode('ids');
    }
}
class_alias('Braintree\SubscriptionSearch', 'Braintree_SubscriptionSearch');
