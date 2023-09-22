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

class Address extends AddressCore
{

    public function isDifferent($address_new, $ignore_null = false)
    {
        // verification keys: VK##2
        $result = false;
        if (
            ($this->firstname != $address_new->firstname && !($ignore_null && $address_new->firstname == null)) ||
            ($this->lastname != $address_new->lastname && !($ignore_null && $address_new->lastname == null)) ||
            ($this->address1 != $address_new->address1 && !($ignore_null && $address_new->address1 == null)) ||
            ($this->postcode != $address_new->postcode && !($ignore_null && $address_new->postcode == null)) ||
            ($this->city != $address_new->city && !($ignore_null && $address_new->city == null))
        )
            $result = true;
        return $result;
    }

}
