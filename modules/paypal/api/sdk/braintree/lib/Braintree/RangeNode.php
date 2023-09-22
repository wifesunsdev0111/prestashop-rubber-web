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

class RangeNode
{
    public function __construct($name)
    {
        $this->name = $name;
        $this->searchTerms = [];
    }

    public function greaterThanOrEqualTo($value)
    {
        $this->searchTerms['min'] = $value;
        return $this;
    }

    public function lessThanOrEqualTo($value)
    {
        $this->searchTerms['max'] = $value;
        return $this;
    }

    public function is($value)
    {
        $this->searchTerms['is'] = $value;
        return $this;
    }

    public function between($min, $max)
    {
		return $this->greaterThanOrEqualTo($min)->lessThanOrEqualTo($max);
    }

    public function toParam()
    {
        return $this->searchTerms;
    }
}
class_alias('Braintree\RangeNode', 'Braintree_RangeNode');
