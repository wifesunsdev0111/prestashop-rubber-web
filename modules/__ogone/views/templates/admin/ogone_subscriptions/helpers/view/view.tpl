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

{if $subscription_data}
   <div id="subscribe_resume" class="subscribe-resume subscribe-info-list col-sm-12">
   <p><strong>{l s='Total paid' mod='ogone'}</strong> : {$total_paid}</p>
   {if $customer}
           <p><strong>{l s='Customer' mod='ogone'}</strong> : <a href="{$customer_link|escape:'htmlall':'UTF-8'}">{$customer->lastname|escape:'htmlall':'UTF-8'} {$customer->firstname|escape:'htmlall':'UTF-8'}</a></p>
  {/if}
        <p><strong>{l s='This is subscription for' mod='ogone'}</strong> : <a href="{$product_url|escape:'htmlall':'UTF-8'}">{$subscription_data.product_name|escape:'htmlall':'UTF-8'}</a></p>
        <p><strong>{l s='This subscription start at' mod='ogone'}</strong> : {$subscription_data.start_date|escape:'htmlall':'UTF-8'}</p>
        <p><strong>{l s='This subscription end at ' mod='ogone'}</strong> : {$subscription_data.end_date|escape:'htmlall':'UTF-8'}</p>
        <p><strong>{l s='The amount of' mod='ogone'}</strong> : {$subscription_data.amount|escape:'htmlall':'UTF-8'}</p>
        <p><strong>{l s='Number of installments' mod='ogone'}</strong> : {$subscription_data.installments|escape:'htmlall':'UTF-8'}</p>
        <p><strong>{l s='Frequency' mod='ogone'}</strong> : {$subscription_data.hr_frequency|escape:'htmlall':'UTF-8'}</p>
        <p><strong>{l s='Billing will occur on' mod='ogone'}</strong>  : {$subscription_data.hr_billing|escape:'htmlall':'UTF-8'}</p>
   {if isset($subscription_data.orders) &&count($subscription_data.orders)>0}

      <div class="data-info-wrapper" id="subscribe_order_wrapper">
          <table id="subscribe_order" class="table data-info clearfix">
          <thead>
            <tr class="datas">
              <th>{l s='Order' mod='ogone'}</th>
              <th>{l s='PayID' mod='ogone'}</th>
              <th>{l s='Date' mod='ogone'}</th>
              <th>{l s='Amount' mod='ogone'}</th>
              <th>{l s='Status' mod='ogone'}</th>
            </tr>
            </thead>
            <tbody>
            {foreach $subscription_data.orders as $order}
              <tr class="datas">
                  <td class="item-order"><a href="{$order.link|escape:'htmlall':'UTF-8'}">{$order.reference|escape:'htmlall':'UTF-8'}</a></td>
                  <td class="item-order">{$order.payid|escape:'htmlall':'UTF-8'}</td>
                  <td class="item-order">{$order.date|escape:'htmlall':'UTF-8'}</td>
                  <td class="item-order">{$order.amount|escape:'htmlall':'UTF-8'}</td>
                  <td class="item-order">
                    <span class="label label-pill bright" style="background-color:{$order.status_color|escape:'htmlall':'UTF-8'}">
                  {$order.status|escape:'htmlall':'UTF-8'}</span>
                  </td>
                </tr>
            {/foreach}
          </tbody>
         </table>
      </div>
    {/if}
   </div>
  {/if}
  <div class="clearfix"></div>
</div>