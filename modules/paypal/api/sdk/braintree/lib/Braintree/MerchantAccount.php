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

final class MerchantAccount extends Base
{
    const STATUS_ACTIVE = 'active';
    const STATUS_PENDING = 'pending';
    const STATUS_SUSPENDED = 'suspended';

    const FUNDING_DESTINATION_BANK = 'bank';
    const FUNDING_DESTINATION_EMAIL = 'email';
    const FUNDING_DESTINATION_MOBILE_PHONE = 'mobile_phone';

    public static function factory($attributes)
    {
        $instance = new self();
        $instance->_initialize($attributes);
        return $instance;
    }

    protected function _initialize($merchantAccountAttribs)
    {
        $this->_attributes = $merchantAccountAttribs;

        if (isset($merchantAccountAttribs['individual'])) {
            $individual = $merchantAccountAttribs['individual'];
            $this->_set('individualDetails', MerchantAccount\IndividualDetails::Factory($individual));
        }

        if (isset($merchantAccountAttribs['business'])) {
            $business = $merchantAccountAttribs['business'];
            $this->_set('businessDetails', MerchantAccount\BusinessDetails::Factory($business));
        }

        if (isset($merchantAccountAttribs['funding'])) {
            $funding = $merchantAccountAttribs['funding'];
            $this->_set('fundingDetails', new MerchantAccount\FundingDetails($funding));
        }

        if (isset($merchantAccountAttribs['masterMerchantAccount'])) {
            $masterMerchantAccount = $merchantAccountAttribs['masterMerchantAccount'];
            $this->_set('masterMerchantAccount', self::Factory($masterMerchantAccount));
        }
    }


    // static methods redirecting to gateway

    public static function create($attribs)
    {
        return Configuration::gateway()->merchantAccount()->create($attribs);
    }

    public static function find($merchant_account_id)
    {
        return Configuration::gateway()->merchantAccount()->find($merchant_account_id);
    }

    public static function update($merchant_account_id, $attributes)
    {
        return Configuration::gateway()->merchantAccount()->update($merchant_account_id, $attributes);
    }
}
class_alias('Braintree\MerchantAccount', 'Braintree_MerchantAccount');
