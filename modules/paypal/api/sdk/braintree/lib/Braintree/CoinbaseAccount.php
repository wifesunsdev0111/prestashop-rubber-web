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
 * Braintree CoinbaseAccount module
 *
 * @package    Braintree
 * @category   Resources
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 */

/**
 * Manages Braintree CoinbaseAccounts
 *
 * <b>== More information ==</b>
 *
 *
 * @package    Braintree
 * @category   Resources
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 *
 * @property-read string $customerId
 * @property-read string $token
 * @property-read string $userId
 * @property-read string $userName
 * @property-read string $userEmail
 */
class CoinbaseAccount extends Base
{
    /**
     *  factory method: returns an instance of CoinbaseAccount
     *  to the requesting method, with populated properties
     *
     * @ignore
     * @return CoinbaseAccount
     */
    public static function factory($attributes)
    {
        $instance = new self();
        $instance->_initialize($attributes);
        return $instance;
    }

    /* instance methods */

    /**
     * returns false if default is null or false
     *
     * @return boolean
     */
    public function isDefault()
    {
        return $this->default;
    }

    /**
     * sets instance properties from an array of values
     *
     * @access protected
     * @param array $coinbaseAccountAttribs array of coinbaseAccount data
     * @return void
     */
    protected function _initialize($coinbaseAccountAttribs)
    {
        // set the attributes
        $this->_attributes = $coinbaseAccountAttribs;

        $subscriptionArray = [];
        if (isset($coinbaseAccountAttribs['subscriptions'])) {
            foreach ($coinbaseAccountAttribs['subscriptions'] AS $subscription) {
                $subscriptionArray[] = Subscription::factory($subscription);
            }
        }

        $this->_set('subscriptions', $subscriptionArray);
    }

    /**
     * create a printable representation of the object as:
     * ClassName[property=value, property=value]
     * @return string
     */
    public function  __toString()
    {
        return __CLASS__ . '[' .
                Util::attributesToString($this->_attributes) .']';
    }


    // static methods redirecting to gateway

    public static function find($token)
    {
        return Configuration::gateway()->coinbaseAccount()->find($token);
    }

    public static function update($token, $attributes)
    {
        return Configuration::gateway()->coinbaseAccount()->update($token, $attributes);
    }

    public static function delete($token)
    {
        return Configuration::gateway()->coinbaseAccount()->delete($token);
    }

    public static function sale($token, $transactionAttribs)
    {
        return Configuration::gateway()->coinbaseAccount()->sale($token, $transactionAttribs);
    }
}
class_alias('Braintree\CoinbaseAccount', 'Braintree_CoinbaseAccount');
