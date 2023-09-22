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
 * Braintree AndroidPayCard module
 * Creates and manages Braintree Android Pay cards
 *
 * <b>== More information ==</b>
 *
 * See {@link https://developers.braintreepayments.com/javascript+php}<br />
 *
 * @package    Braintree
 * @category   Resources
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 *
 * @property-read string $bin
 * @property-read string $cardType
 * @property-read string $createdAt
 * @property-read string $customerId
 * @property-read string $default
 * @property-read string $expirationMonth
 * @property-read string $expirationYear
 * @property-read string $googleTransactionId
 * @property-read string $imageUrl
 * @property-read string $last4
 * @property-read string $sourceCardLast4
 * @property-read string $sourceCardType
 * @property-read string $sourceDescription
 * @property-read string $token
 * @property-read string $updatedAt
 * @property-read string $virtualCardLast4
 * @property-read string $virtualCardType
 */
class AndroidPayCard extends Base
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
     *  factory method: returns an instance of AndroidPayCard
     *  to the requesting method, with populated properties
     *
     * @ignore
     * @return AndroidPayCard
     */
    public static function factory($attributes)
    {
        $defaultAttributes = [
            'expirationMonth'    => '',
            'expirationYear'    => '',
            'last4'  => $attributes['virtualCardLast4'],
            'cardType'  => $attributes['virtualCardType'],
        ];

        $instance = new self();
        $instance->_initialize(array_merge($defaultAttributes, $attributes));
        return $instance;
    }

    /**
     * sets instance properties from an array of values
     *
     * @access protected
     * @param array $androidPayCardAttribs array of Android Pay card properties
     * @return void
     */
    protected function _initialize($androidPayCardAttribs)
    {
        // set the attributes
        $this->_attributes = $androidPayCardAttribs;

        $subscriptionArray = [];
        if (isset($androidPayCardAttribs['subscriptions'])) {
            foreach ($androidPayCardAttribs['subscriptions'] AS $subscription) {
                $subscriptionArray[] = Subscription::factory($subscription);
            }
        }

        $this->_set('subscriptions', $subscriptionArray);
    }
}
class_alias('Braintree\AndroidPayCard', 'Braintree_AndroidPayCard');
