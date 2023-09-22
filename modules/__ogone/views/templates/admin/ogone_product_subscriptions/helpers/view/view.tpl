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
<div class="panel">
{if isset($subscription) && subscription}
  <table class="table">
  <thead>
    <tr>
      {*<th>{l s='Reference' mod='ogone'}</th>
      <th>{l s='Name' mod='ogone'}</th>*}
      <th>{l s='First amount' mod='ogone'}</th>
      <th>{l s='First payment delay' mod='ogone'}</th>
      <th>{l s='Installments' mod='ogone'}</th>
      <th>{l s='Period unit' mod='ogone'}</th>
      <th>{l s='Period moment' mod='ogone'}</th>
      <th>{l s='Period number' mod='ogone'}</th>
      <th>{l s='Description' mod='ogone'}</th>
      <th>{l s='Active' mod='ogone'}</th>
      <th colspan="2">{l s='Actions' mod='ogone'}</th>

    </tr>
  </thead>
    <tr class="ogone-subscription-{*$s.type|escape:'htmlall':'UTF-8'} {if $idx%2==0}odd{else}even{/if*}">
     {* <td>{$s.reference|escape:'htmlall':'UTF-8'}</td>
      <td>{$s.name|escape:'htmlall':'UTF-8'}</td> *}
        <td class="first_amount">{$subscription->first_amount|escape:'htmlall':'UTF-8'}</td>
        <td class="first_payment_delay">{$subscription->first_payment_delay|escape:'htmlall':'UTF-8'}</td>
        <td class="installments">{$subscription->installments|escape:'htmlall':'UTF-8'}</td>
        <td class="period_unit">{$subscription->period_unit|escape:'htmlall':'UTF-8'}</td>
        <td class="period_moment">{$subscription->period_moment|escape:'htmlall':'UTF-8'}</td>
        <td class="period_number">{$subscription->period_number|escape:'htmlall':'UTF-8'}</td>
        <td class="description">{$subscription->description[{$employee->id_lang|escape:'htmlall':'UTF-8'}]|escape:'htmlall':'UTF-8'}</td>
        <td class="active">{$subscription->active|escape:'htmlall':'UTF-8'}</td>
        <td class="actions">
          {*if $s.edit_link}<a href="{$s.edit_link}" class="btn primary">{l s='Edit' mod='ogone'}</a>{/if}
        </td>
         <td class="actions">
          {if $s.delete_link}<a href="{$s.delete_link}" class="btn danger">{l s='Delete' mod='ogone'}</a>{/if}
        </td>
      {else }
        <td colspan="10" class="ogone-no-subscription">{l s='There is no subscription for this' mod='ogone'}
        {if $s.type=='product'}{l s='product' mod='ogone'}{else}{l s='declination' mod='ogone'}{/if}
        {if $s.create_link}<a href="{$s.create_link}" class="btn success">{l s='Create' mod='ogone'}</a>{/if*}
        </td>
    </tr>
  </table>
{/if}
</div>