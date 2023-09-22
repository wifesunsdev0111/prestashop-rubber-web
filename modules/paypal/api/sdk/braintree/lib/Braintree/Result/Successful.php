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

use Braintree\Instance;
use Braintree\Util;

/**
 * Braintree Successful Result
 *
 * A Successful Result will be returned from gateway methods when
 * validations pass. It will provide access to the created resource.
 *
 * For example, when creating a customer, Successful will
 * respond to <b>customer</b> like so:
 *
 * <code>
 * $result = Customer::create(array('first_name' => "John"));
 * if ($result->success) {
 *     // Successful
 *     echo "Created customer {$result->customer->id}";
 * } else {
 *     // Error
 * }
 * </code>
 *
 *
 * @package    Braintree
 * @subpackage Result
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 */
class Successful extends Instance
{
    /**
     *
     * @var boolean always true
     */
    public $success = true;
    /**
     *
     * @var string stores the internal name of the object providing access to
     */
    private $_returnObjectNames;

    /**
     * @ignore
     * @param array|null $objsToReturn
     * @param array|null $propertyNames
     */
    public function __construct($objsToReturn = [], $propertyNames = [])
    {
        // Sanitize arguments (preserves backwards compatibility)
        if (!is_array($objsToReturn)) { $objsToReturn = [$objsToReturn]; }
        if (!is_array($propertyNames)) { $propertyNames = [$propertyNames]; }

        $objects = $this->_mapPropertyNamesToObjsToReturn($propertyNames, $objsToReturn);
        $this->_attributes = [];
        $this->_returnObjectNames = [];

        foreach ($objects as $propertyName => $objToReturn) {

            // save the name for indirect access
            array_push($this->_returnObjectNames, $propertyName);

            // create the property!
            $this->$propertyName = $objToReturn;
        }
    }

   /**
    *
    * @ignore
    * @return string string representation of the object's structure
    */
   public function __toString()
   {
       $objects = [];
       foreach ($this->_returnObjectNames as $returnObjectName) {
           array_push($objects, $this->$returnObjectName);
       }
       return __CLASS__ . '[' . implode(', ', $objects) . ']';
   }

   private function _mapPropertyNamesToObjsToReturn($propertyNames, $objsToReturn) {
       if(count($objsToReturn) != count($propertyNames)) {
           $propertyNames = [];
           foreach ($objsToReturn as $obj) {
               array_push($propertyNames, Util::cleanClassName(get_class($obj)));
           }
       }
       return array_combine($propertyNames, $objsToReturn);
   }
}
class_alias('Braintree\Result\Successful', 'Braintree_Result_Successful');
