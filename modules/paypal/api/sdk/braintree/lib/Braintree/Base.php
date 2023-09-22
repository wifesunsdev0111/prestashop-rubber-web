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
 * Braintree PHP Library.
 *
 * Braintree base class and initialization
 * Provides methods to child classes. This class cannot be instantiated.
 *
 *  PHP version 5
 *
 * @copyright  2015 Braintree, a division of PayPal, Inc.
 */
abstract class Base
{
    protected $_attributes = [];

    /**
     * @ignore
     * don't permit an explicit call of the constructor!
     * (like $t = new Transaction())
     */
    protected function __construct()
    {
    }

    /**
     * Disable cloning of objects
     *
     * @ignore
     */
    protected function __clone()
    {
    }

    /**
     * Accessor for instance properties stored in the private $_attributes property
     *
     * @ignore
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->_attributes)) {
            return $this->_attributes[$name];
        }
        else {
            trigger_error('Undefined property on ' . get_class($this) . ': ' . $name, E_USER_NOTICE);
            return null;
        }
    }

    /**
     * Checks for the existance of a property stored in the private $_attributes property
     *
     * @ignore
     * @param string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return array_key_exists($name, $this->_attributes);
    }

    /**
     * Mutator for instance properties stored in the private $_attributes property
     *
     * @ignore
     * @param string $key
     * @param mixed $value
     */
    public function _set($key, $value)
    {
        $this->_attributes[$key] = $value;
    }
}
