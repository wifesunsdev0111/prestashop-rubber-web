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
{if $transaction}
<ul class="ogone-transaction-view" style="list-style:none">
  <h2>{l s='Transaction' mod='ogone'}</h2>
  <li><strong>{l s='PAYID' mod='ogone'}</strong>: {$transaction->payid|escape:'htmlall':'UTF-8'} </li>
  <li><strong>{l s='Cart id' mod='ogone'}</strong>: {$transaction->id_cart|escape:'htmlall':'UTF-8'} </li>
  <li><strong>{l s='Order id' mod='ogone'}</strong>: {$transaction->id_order|escape:'htmlall':'UTF-8'} </li>
  <li><strong>{l s='Customer id' mod='ogone'}</strong>: {$transaction->id_customer|escape:'htmlall':'UTF-8'} </li>
  <li><strong>{l s='Status' mod='ogone'}</strong>: {$transaction->status|escape:'htmlall':'UTF-8'} </li>
  <li><strong>{l s='Response' mod='ogone'}</strong>: {$transaction->response|escape:'htmlall':'UTF-8'} </li>
  <li><strong>{l s='Date' mod='ogone'}</strong>:  {$transaction->date_add|escape:'htmlall':'UTF-8'} </li>
 </ul>
{/if}
</div>