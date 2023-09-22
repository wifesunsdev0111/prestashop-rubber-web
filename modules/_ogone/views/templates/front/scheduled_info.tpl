{*
* 2007-2017 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2017 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<strong>{l s='Your scheduled payment details' mod='ogone'} :</strong>

<dl>
<dt><strong>{l s='Date' mod='ogone'}</strong></dt><dd><strong>{l s='Amount' mod='ogone'}</strong></dd>
{foreach $scheduled as $key=>$payment name="scheduled"}
<dt>{$payment.date|escape:'htmlall':'UTF-8'}</dt><dd>{$payment.amount|escape:'htmlall':'UTF-8'} {$payment.currency_sign|escape:'htmlall':'UTF-8'}</dd>
{/foreach}
</dl>