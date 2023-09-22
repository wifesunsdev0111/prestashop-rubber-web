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

class CustomerSearch
{
    public static function addressCountryName()               { return new TextNode('address_country_name'); }
    public static function addressExtendedAddress()           { return new TextNode('address_extended_address'); }
    public static function addressFirstName()                 { return new TextNode('address_first_name'); }
    public static function addressLastName()                  { return new TextNode('address_last_name'); }
    public static function addressLocality()                  { return new TextNode('address_locality'); }
    public static function addressPostalCode()                { return new TextNode('address_postal_code'); }
    public static function addressRegion()                    { return new TextNode('address_region'); }
    public static function addressStreetAddress()             { return new TextNode('address_street_address'); }
    public static function cardholderName()                   { return new TextNode('cardholder_name'); }
    public static function company()                          { return new TextNode('company'); }
    public static function email()                            { return new TextNode('email'); }
    public static function fax()                              { return new TextNode('fax'); }
    public static function firstName()                        { return new TextNode('first_name'); }
    public static function id()                               { return new TextNode('id'); }
    public static function lastName()                         { return new TextNode('last_name'); }
    public static function paymentMethodToken()               { return new TextNode('payment_method_token'); }
    public static function paymentMethodTokenWithDuplicates() { return new IsNode('payment_method_token_with_duplicates'); }
    public static function paypalAccountEmail()               { return new IsNode('paypal_account_email'); }
    public static function phone()                            { return new TextNode('phone'); }
    public static function website()                          { return new TextNode('website'); }

    public static function creditCardExpirationDate()         { return new EqualityNode('credit_card_expiration_date'); }
    public static function creditCardNumber()                 { return new PartialMatchNode('credit_card_number'); }

    public static function ids()                              { return new MultipleValueNode('ids'); }

    public static function createdAt()                        { return new RangeNode("created_at"); }
}
class_alias('Braintree\CustomerSearch', 'Braintree_CustomerSearch');
