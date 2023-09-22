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

use InvalidArgumentException;

class MultipleValueNode
{
    public function __construct($name, $allowedValues = [])
    {
        $this->name = $name;
        $this->items = [];
		$this->allowedValues = $allowedValues;
    }

    public function in($values)
    {
		$bad_values = array_diff($values, $this->allowedValues);
		if (count($this->allowedValues) > 0 && count($bad_values) > 0) {
			$message = 'Invalid argument(s) for ' . $this->name . ':';
			foreach ($bad_values AS $bad_value) {
				$message .= ' ' . $bad_value;
			}

			throw new InvalidArgumentException($message);
		}

        $this->items = $values;
        return $this;
    }

    public function is($value)
    {
        return $this->in([$value]);
    }

    public function toParam()
    {
        return $this->items;
    }
}
class_alias('Braintree\MultipleValueNode', 'Braintree_MultipleValueNode');
