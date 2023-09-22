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
 * Braintree VenmoAccount module
 * Creates and manages Braintree Venmo accounts
 *
 * <b>== More information ==</b>
 *
 * See {@link https://developers.braintreepayments.com/javascript+php}<br />
 *
 * @package    Braintree
 * @category   Resources
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 *
 * @property-read string $createdAt
 * @property-read string $default
 * @property-read string $updatedAt
 * @property-read string $customerId
 * @property-read string $sourceDescription
 * @property-read string $token
 * @property-read string $imageUrl
 * @property-read string $username
 * @property-read string $venmoUserId
 */
class VenmoAccount extends Base
{
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
     *  factory method: returns an instance of VenmoAccount
     *  to the requesting method, with populated properties
     *
     * @ignore
     * @return VenmoAccount
     */
    public static function factory($attributes)
    {

        $instance = new self();
        $instance->_initialize($attributes);
        return $instance;
    }

    /**
     * sets instance properties from an array of values
     *
     * @access protected
     * @param array $venmoAccountAttribs array of Venmo account properties
     * @return void
     */
    protected function _initialize($venmoAccountAttribs)
    {
        $this->_attributes = $venmoAccountAttribs;

        $subscriptionArray = array();
        if (isset($venmoAccountAttribs['subscriptions'])) {
            foreach ($venmoAccountAttribs['subscriptions'] AS $subscription) {
                $subscriptionArray[] = Subscription::factory($subscription);
            }
        }

        $this->_set('subscriptions', $subscriptionArray);
    }
}
class_alias('Braintree\VenmoAccount', 'Braintree_VenmoAccount');
