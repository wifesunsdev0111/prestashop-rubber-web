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

/**
 * Braintree PaymentMethodNonce module
 *
 * @package    Braintree
 * @category   Resources
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 */

/**
 * Creates and manages Braintree PaymentMethodNonces
 *
 * <b>== More information ==</b>
 *
 *
 * @package    Braintree
 * @category   Resources
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 *
 */
class PaymentMethodNonce extends Base
{
    // static methods redirecting to gateway

    public static function create($token)
    {
        return Configuration::gateway()->paymentMethodNonce()->create($token);
    }

    public static function find($nonce)
    {
        return Configuration::gateway()->paymentMethodNonce()->find($nonce);
    }

    public static function factory($attributes)
    {
        $instance = new self();
        $instance->_initialize($attributes);
        return $instance;
    }

    protected function _initialize($nonceAttributes)
    {
        $this->_attributes = $nonceAttributes;
        $this->_set('nonce', $nonceAttributes['nonce']);
        $this->_set('type', $nonceAttributes['type']);

        if(isset($nonceAttributes['threeDSecureInfo'])) {
            $this->_set('threeDSecureInfo', ThreeDSecureInfo::factory($nonceAttributes['threeDSecureInfo']));
        }
    }
}
class_alias('Braintree\PaymentMethodNonce', 'Braintree_PaymentMethodNonce');
