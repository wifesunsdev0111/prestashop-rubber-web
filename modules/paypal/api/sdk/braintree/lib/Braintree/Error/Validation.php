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

namespace Braintree\Error;

use Braintree\Util;

/**
 * error object returned as part of a validation error collection
 * provides read-only access to $attribute, $code, and $message
 *
 * <b>== More information ==</b>
 *
 * For more detailed information on Validation errors, see {@link http://www.braintreepayments.com/gateway/validation-errors http://www.braintreepaymentsolutions.com/gateway/validation-errors}
 *
 * @package    Braintree
 * @subpackage Error
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 *
 * @property-read string $attribute
 * @property-read string $code
 * @property-read string $message
 */
class Validation
{
    private $_attribute;
    private $_code;
    private $_message;

    /**
     * @ignore
     * @param array $attributes
     */
    public function  __construct($attributes)
    {
        $this->_initializeFromArray($attributes);
    }
    /**
     * initializes instance properties from the keys/values of an array
     * @ignore
     * @access protected
     * @param array $attributes array of properties to set - single level
     * @return void
     */
    private function _initializeFromArray($attributes)
    {
        foreach($attributes AS $name => $value) {
            $varName = "_$name";
            $this->$varName = Util::delimiterToCamelCase($value, '_');
        }
    }

    /**
     *
     * @ignore
     */
    public function  __get($name)
    {
        $varName = "_$name";
        return isset($this->$varName) ? $this->$varName : null;
    }
}
class_alias('Braintree\Error\Validation', 'Braintree_Error_Validation');
