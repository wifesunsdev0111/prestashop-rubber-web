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

class CreditCardVerification extends Result\CreditCardVerification
{
    public static function factory($attributes)
    {
        $instance = new self($attributes);
        return $instance;
    }

    // static methods redirecting to gateway
    //
    public static function create($attributes)
    {
        Util::verifyKeys(self::createSignature(), $attributes);
        return Configuration::gateway()->creditCardVerification()->create($attributes);
    }

    public static function fetch($query, $ids)
    {
        return Configuration::gateway()->creditCardVerification()->fetch($query, $ids);
    }

    public static function search($query)
    {
        return Configuration::gateway()->creditCardVerification()->search($query);
    }

    public static function createSignature()
    {
        return [
                ['options' => ['amount', 'merchantAccountId']],
                ['creditCard' =>
                    [
                        'cardholderName', 'cvv', 'number',
                        'expirationDate', 'expirationMonth', 'expirationYear',
                        ['billingAddress' => CreditCardGateway::billingAddressSignature()]
                    ]
                ]];
    }
}
class_alias('Braintree\CreditCardVerification', 'Braintree_CreditCardVerification');
