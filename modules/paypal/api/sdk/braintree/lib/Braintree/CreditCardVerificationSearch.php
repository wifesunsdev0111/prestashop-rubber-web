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

class CreditCardVerificationSearch
{
    public static function id() {
	    return new TextNode('id');
    }

    public static function creditCardCardholderName() {
	    return new TextNode('credit_card_cardholder_name');
    }

    public static function billingAddressDetailsPostalCode() {
        return new TextNode('billing_address_details_postal_code');
    }

    public static function customerEmail() {
        return new TextNode('customer_email');
    }

    public static function customerId() {
        return new TextNode('customer_id');
    }

    public static function paymentMethodToken(){
        return new TextNode('payment_method_token');
    }

    public static function creditCardExpirationDate() {
	    return new EqualityNode('credit_card_expiration_date');
    }

    public static function creditCardNumber() {
	    return new PartialMatchNode('credit_card_number');
    }

    public static function ids() {
        return new MultipleValueNode('ids');
    }

    public static function createdAt() {
	    return new RangeNode("created_at");
    }

    public static function creditCardCardType()
    {
        return new MultipleValueNode("credit_card_card_type", CreditCard::allCardTypes());
    }

    public static function status()
    {
        return new MultipleValueNode("status", Result\CreditCardVerification::allStatuses());
    }
}
class_alias('Braintree\CreditCardVerificationSearch', 'Braintree_CreditCardVerificationSearch');
