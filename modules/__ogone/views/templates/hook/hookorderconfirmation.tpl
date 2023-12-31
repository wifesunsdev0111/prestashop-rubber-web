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

{if $status == 'ok'}
  <p>{l s='Your order on' mod='ogone'} <span class="bold">{if isset($shop.name)}{$shop.name|escape:'htmlall':'UTF-8'}{else}{$shop_name|escape:'htmlall':'UTF-8'}{/if}</span> {l s='is complete.' mod='ogone'}
    <br /><br /><span class="bold">
      {if $operation=="SAL"}
        {l s='Your order will be sent as soon as possible.' mod='ogone'}
      {else}
        {l s='Your order will be sent as soon as it will be processed by merchant.' mod='ogone'}
      {/if}
    </span>
    <br /><br />{l s='For any questions or for further information, please contact our' mod='ogone'} <a href="{$ogone_link|escape:'htmlall':'UTF-8'}">{l s='customer support' mod='ogone'}</a>.
  </p>
{else}
  <p class="warning">
    {l s='We noticed a problem with your order. If you think this is an error, you can contact our' mod='ogone'}
    <a href="{$ogone_link|escape:'htmlall':'UTF-8'}">{l s='customer support' mod='ogone'}</a>.
  </p>
{/if}