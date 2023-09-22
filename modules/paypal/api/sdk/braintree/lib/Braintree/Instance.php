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
 * Braintree Class Instance template
 *
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 * @abstract
 */
abstract class Instance
{
    protected $_attributes = [];

    /**
     *
     * @param array $attributes
     */
    public function  __construct($attributes)
    {
        if (!empty($attributes)) {
            $this->_initializeFromArray($attributes);
        }
    }

    /**
     * returns private/nonexistent instance properties
     * @access public
     * @param string $name property name
     * @return mixed contents of instance properties
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->_attributes)) {
            return $this->_attributes[$name];
        } else {
            trigger_error('Undefined property on ' . get_class($this) . ': ' . $name, E_USER_NOTICE);
            return null;
        }
    }

    /**
     * used by isset() and empty()
     * @access public
     * @param string $name property name
     * @return boolean
     */
    public function __isset($name)
    {
        return array_key_exists($name, $this->_attributes);
    }

    /**
     * create a printable representation of the object as:
     * ClassName[property=value, property=value]
     * @return string
     */
    public function  __toString()
    {
        $objOutput = Util::implodeAssociativeArray($this->_attributes);
        return get_class($this) .'[' . $objOutput . ']';
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
        $this->_attributes = $attributes;
    }

}
class_alias('Braintree\Instance', 'Braintree_Instance');
