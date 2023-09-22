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
<div class="panel" id="ingenicoOrder">
  <h3><img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/picto_cb.png"/> {l s='Ingenico ePayments' mod='ogone'}</h3>
  <div> {l s='Ingenico order reference' mod='ogone'} : {if $orderid}<span class="badge">{$orderid|escape:'htmlall':'UTF-8'}</span>{/if}</div><br /><br />
  <div> {l s='Ingenico PAYID' mod='ogone'} : {if $payid}<span class="badge">{$payid|escape:'htmlall':'UTF-8'}</span>{/if}</div><br />
  <hr/>
  {if $can_use_direct_link}

  {if isset($scoring) && $scoring}
    <fieldset class="third-block">
      <div class="fieldset-wrapper">
      <legend>{l s='Fraud scoring' mod='ogone'}</legend>
      <div class="ogone_scoring">
        <div class="ogone_score_{$scoring.category|escape:'htmlall':'UTF-8'}"><span class="badge">
        {if $scoring.category == 'R'}
        {l s='Attention! There is high risk of fraud!' mod='ogone'}
        {elseif $scoring.category == 'O'}
        {l s='Attention! There is moderate risk of fraud!' mod='ogone'}
        {elseif $scoring.category == 'G'}
        {l s='Security rating of this order is good' mod='ogone'}
        {else}
        {l s='We are unable to rate the security of this order.' mod='ogone'}
        {/if}
        </span></div>
      </div>
      </div>
    </fieldset>
    {/if}

    {if $can_capture}
    <fieldset class="third-block">
      <div class="fieldset-wrapper">
      <legend>{l s='Confirm payment' mod='ogone'}</legend>
      <form action="{$capture_link|escape:'htmlall':'UTF-8'}" method="post">
      <label>{l s='Amount (leave empty to capture whole amount due)' mod='ogone'}</label>
      <div class="input-group">
        <span class="input-group-addon">{$currency_code|escape:'htmlall':'UTF-8'}</span>
        <input type="number" name="capture_amount" id="capture_amount" style="width: 160px" value="{$max_capture_amount|escape:'htmlall':'UTF-8'}" min="0" max="{$max_capture_amount|escape:'htmlall':'UTF-8'}"  step="any">
        <button  class="btn btn-primary" href="#" id="ogone_capture" title="{$cc_title|escape:'htmlall':'UTF-8'}">{l s='Confirm payment' mod='ogone'}</button>
      </div>
      <input type="hidden" name="action" value="capture" />
      <input type="hidden" name="return_link" value="{$return_link|escape:'htmlall':'UTF-8'}" />
      </form>
      <br />
      {if $captured}
        {$captured|escape:'htmlall':'UTF-8'} {$currency_code|escape:'htmlall':'UTF-8'} {l s='captured so far' mod='ogone'}
        {if $captured_pending}<br />{/if}
      {/if}
      {if $captured_pending}
         {$captured_pending|escape:'htmlall':'UTF-8'} {$currency_code|escape:'htmlall':'UTF-8'} {l s='being currently processed' mod='ogone'}
      {/if}
      <br />{$max_capture_amount|escape:'htmlall':'UTF-8'} {$currency_code|escape:'htmlall':'UTF-8'} {l s='can be captured' mod='ogone'}
      </div>
    </fieldset>
    {else}
    <fieldset class="third-block">
     <div class="fieldset-wrapper">
      <legend>{l s='Confirm payment' mod='ogone'}</legend>
      <ul class="list-unstyled">
        <li>{l s='Unable to confirm payment for this order' mod='ogone'}</li>
      </ul>
      </div>
      </fieldset>
    {/if}

    {if $can_refund}
    <fieldset class="third-block">
    <div class="fieldset-wrapper">
      <legend>{l s='Refund' mod='ogone'}</legend>
      <form action="{$refund_link|escape:'htmlall':'UTF-8'}" method="post">
      <label>{l s='Amount (leave empty to refund whole amount paid)' mod='ogone'}</label>  <br />

      <div class="input-group">
        <span class="input-group-addon">{$currency_code|escape:'htmlall':'UTF-8'}</span>
        <input type="number" name="refund_amount" id="refund_amount" style="width: 160px" value="{$max_refund_amount|escape:'htmlall':'UTF-8'}" min="0" max="{$max_refund_amount|escape:'htmlall':'UTF-8'}" step="any">
        <button  class="btn btn-primary" href="#" id="ogone_refund" title="{$refund_title|escape:'htmlall':'UTF-8'}">{l s='Refund' mod='ogone'}</button>
        </div>

        <input type="hidden" name="action" value="refund" />
        <input type="hidden" name="return_link" value="{$return_link|escape:'htmlall':'UTF-8'}" />
      </form>
      <br />
      {if $refunded}
        {$refunded|escape:'htmlall':'UTF-8'} {$currency_code|escape:'htmlall':'UTF-8'} {l s='refunded so far' mod='ogone'}
        {if $refunded_pending}<br />{/if}
      {/if}
      {if $refunded_pending}
         {$refunded_pending|escape:'htmlall':'UTF-8'} {$currency_code|escape:'htmlall':'UTF-8'} {l s='being currently processed' mod='ogone'}
      {/if}
        <br />{$max_refund_amount|escape:'htmlall':'UTF-8'} {$currency_code|escape:'htmlall':'UTF-8'} {l s='can be refunded' mod='ogone'}
      </div>
    </fieldset>
    {else}
     <fieldset class="third-block">
     <div class="fieldset-wrapper">
      <legend>{l s='Refund' mod='ogone'}</legend>
      <ul class="list-unstyled">
        <li>{l s='Unable to refund this order' mod='ogone'}</li>
      </ul>
      </div>
      </fieldset>
    {/if}


  {else}
    <div class="bootstrap">
    <div class="alert alert-warning">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <ul class="list-unstyled">
        <li>{l s='In order to use advanced features you need to activate and configure DirectLink' mod='ogone'}</li>
      </ul>
    </div>
    </div>
  {/if}



<div class="clear"></div>

</div>

{if isset($subscription_data)}
<div class="panel">
   <div id="subscribe_resume" class="subscribe-resume subscribe-info-list col-sm-12">
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
  <div class="clearfix"></div>
</div>
  {/if}