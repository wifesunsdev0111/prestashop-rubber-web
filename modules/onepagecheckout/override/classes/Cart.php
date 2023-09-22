<?php
/**
* NOTICE OF LICENSE
*
* This source file is subject to the Software License Agreement
* that is bundled with this package in the file LICENSE.txt.
* 
*  @author    Peter Sliacky
*  @copyright 2009-2016 Peter Sliacky
*  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0) 
*/

class Cart extends CartCore
{

    public function resetCartDiscountCache()
    {
        // verification keys: VK##2
        // reset discount cache so that discount can be added and new results retrieved in single HTTP request
        self::$_discounts     = NULL;
        self::$_discountsLite = NULL;
    }
}
