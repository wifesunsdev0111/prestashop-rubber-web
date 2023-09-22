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

namespace Braintree\Result;

use Braintree\RiskData;
use Braintree\Util;

/**
 * Braintree Credit Card Verification Result
 *
 * This object is returned as part of an Error Result; it provides
 * access to the credit card verification data from the gateway
 *
 *
 * @package    Braintree
 * @subpackage Result
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 *
 * @property-read string $avsErrorResponseCode
 * @property-read string $avsPostalCodeResponseCode
 * @property-read string $avsStreetAddressResponseCode
 * @property-read string $cvvResponseCode
 * @property-read string $status
 *
 */
class CreditCardVerification
{
    // Status
    const FAILED                   = 'failed';
    const GATEWAY_REJECTED         = 'gateway_rejected';
    const PROCESSOR_DECLINED       = 'processor_declined';
    const VERIFIED                 = 'verified';

    private $_attributes;
    private $_avsErrorResponseCode;
    private $_avsPostalCodeResponseCode;
    private $_avsStreetAddressResponseCode;
    private $_cvvResponseCode;
    private $_gatewayRejectionReason;
    private $_status;

    /**
     * @ignore
     */
    public function  __construct($attributes)
    {
        $this->_initializeFromArray($attributes);
    }

    /**
     * initializes instance properties from the keys/values of an array
     * @ignore
     * @access protected
     * @param <type> $aAttribs array of properties to set - single level
     * @return void
     */
    private function _initializeFromArray($attributes)
    {
        if(isset($attributes['riskData']))
        {
            $attributes['riskData'] = RiskData::factory($attributes['riskData']);
        }

        $this->_attributes = $attributes;
        foreach($attributes AS $name => $value) {
            $varName = "_$name";
            $this->$varName = $value;
        }
    }

    /**
     * @ignore
     */
    public function  __get($name)
    {
        $varName = "_$name";
        return isset($this->$varName) ? $this->$varName : null;
    }

    /**
     * returns a string representation of the customer
     * @return string
     */
    public function  __toString()
    {
        return __CLASS__ . '[' .
                Util::attributesToString($this->_attributes) . ']';
    }

    public static function allStatuses()
    {
        return [
            CreditCardVerification::FAILED,
            CreditCardVerification::GATEWAY_REJECTED,
            CreditCardVerification::PROCESSOR_DECLINED,
            CreditCardVerification::VERIFIED
        ];
    }
}
class_alias('Braintree\Result\CreditCardVerification', 'Braintree_Result_CreditCardVerification');
