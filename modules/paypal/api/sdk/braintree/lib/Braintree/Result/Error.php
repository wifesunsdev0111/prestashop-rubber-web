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

use Braintree\Base;
use Braintree\Transaction;
use Braintree\Subscription;
use Braintree\MerchantAccount;
use Braintree\Util;
use Braintree\Error\ErrorCollection;

/**
 * Braintree Error Result
 *
 * An Error Result will be returned from gateway methods when
 * the gateway responds with an error. It will provide access
 * to the original request.
 * For example, when voiding a transaction, Error Result will
 * respond to the void request if it failed:
 *
 * <code>
 * $result = Transaction::void('abc123');
 * if ($result->success) {
 *     // Successful Result
 * } else {
 *     // Result\Error
 * }
 * </code>
 *
 * @package    Braintree
 * @subpackage Result
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 *
 * @property-read array $params original passed params
 * @property-read Braintree\Error\ErrorCollection $errors
 * @property-read Braintree\Result\CreditCardVerification $creditCardVerification credit card verification data
 */
class Error extends Base
{
    /**
    * @var bool always false
    */
   public $success = false;

    /**
     * return original value for a field
     * For example, if a user tried to submit 'invalid-email' in the html field transaction[customer][email],
     * $result->valueForHtmlField("transaction[customer][email]") would yield "invalid-email"
     *
     * @param string $field
     * @return string
     */
   public function valueForHtmlField($field)
   {
       $pieces = preg_split("/[\[\]]+/", $field, 0, PREG_SPLIT_NO_EMPTY);
       $params = $this->params;
       foreach(array_slice($pieces, 0, -1) as $key) {
           $params = $params[Util::delimiterToCamelCase($key)];
       }
       if ($key != 'custom_fields') {
           $finalKey = Util::delimiterToCamelCase(end($pieces));
       } else {
           $finalKey = end($pieces);
       }
       $fieldValue = isset($params[$finalKey]) ? $params[$finalKey] : null;
       return $fieldValue;
   }

   /**
    * overrides default constructor
    * @ignore
    * @param array $response gateway response array
    */
   public function  __construct($response)
   {
       $this->_attributes = $response;
       $this->_set('errors',  new ErrorCollection($response['errors']));

       if(isset($response['verification'])) {
           $this->_set('creditCardVerification', new CreditCardVerification($response['verification']));
       } else {
           $this->_set('creditCardVerification', null);
       }

       if(isset($response['transaction'])) {
           $this->_set('transaction', Transaction::factory($response['transaction']));
       } else {
           $this->_set('transaction', null);
       }

       if(isset($response['subscription'])) {
           $this->_set('subscription', Subscription::factory($response['subscription']));
       } else {
           $this->_set('subscription', null);
       }

       if(isset($response['merchantAccount'])) {
           $this->_set('merchantAccount', MerchantAccount::factory($response['merchantAccount']));
       } else {
           $this->_set('merchantAccount', null);
       }

       if(isset($response['verification'])) {
           $this->_set('verification', new CreditCardVerification($response['verification']));
       } else {
           $this->_set('verification', null);
       }
   }

   /**
     * create a printable representation of the object as:
     * ClassName[property=value, property=value]
     * @ignore
     * @return string
     */
    public function  __toString()
    {
        $output = Util::attributesToString($this->_attributes);
        if (isset($this->_creditCardVerification)) {
            $output .= sprintf('%s', $this->_creditCardVerification);
        }
        return __CLASS__ .'[' . $output . ']';
    }
}
class_alias('Braintree\Result\Error', 'Braintree_Result_Error');
