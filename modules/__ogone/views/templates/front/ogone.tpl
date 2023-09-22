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

<p class="payment_module">
	<a onclick="document.forms['ogone_form'].submit(); return false;" href="#" title="{l s='Pay with Ingenico ePayments' mod='ogone'}">
		<span><img src="{$default_option_logo|escape:'htmlall':'UTF-8'}" alt="{l s='Ingenico ePayments logo' mod='ogone'}" style="padding-right: 2px; width: 86px; height: 49px"/></span>
		{if isset($default_option_name) && $default_option_name}
			{$default_option_name|escape:'htmlall':'UTF-8'}
		{else}
			{l s='Pay with Ingenico ePayments' mod='ogone'}<span> ({l s='Pay safely on the next page with Ingenico ePayments using your preferred payment method' mod='ogone'})</span>
		{/if}
	</a>
</p>
<form name="ogone_form" action="https://secure.ogone.com/ncol/{if $OGONE_MODE}prod{else}test{/if}/orderstandard_utf8.asp" method="post">
{foreach from=$ogone_params key=ogone_key item=ogone_value}
	<input type="hidden" name="{$ogone_key|escape:'htmlall':'UTF-8'}" value="{$ogone_value|escape:'htmlall':'UTF-8'}" />
{/foreach}
</form>
