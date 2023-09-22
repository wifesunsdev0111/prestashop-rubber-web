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

class MultipleValueOrTextNode extends MultipleValueNode
{
    public function __construct($name)
    {
        parent::__construct($name);
        $this->textNode = new TextNode($name);
    }

    public function contains($value)
    {
        $this->textNode->contains($value);
        return $this;
    }

    public function endsWith($value)
    {
        $this->textNode->endsWith($value);
        return $this;
    }

    public function is($value)
    {
        $this->textNode->is($value);
        return $this;
    }

    public function isNot($value)
    {
        $this->textNode->isNot($value);
        return $this;
    }

    public function startsWith($value)
    {
        $this->textNode->startsWith($value);
        return $this;
    }

    public function toParam()
    {
        return array_merge(parent::toParam(), $this->textNode->toParam());
    }
}
class_alias('Braintree\MultipleValueOrTextNode', 'Braintree_MultipleValueOrTextNode');
