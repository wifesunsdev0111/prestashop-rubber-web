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
  <div id="ogone_subscriptions_list">
    <header class="page-header">
      <h1>
        {l s='Your subscriptions info' mod='ogone'}
      </h1>
    </header>
    {if isset($messages)}
      {foreach $messages as $message}
        <p class="message">{$message|escape:'htmlall':'UTF-8'}</p>
      {/foreach}
    {/if}
    {if isset($errors)}
      {foreach $errors as $error}
        <p class="error">{$error|escape:'htmlall':'UTF-8'}</p>
      {/foreach}
    {/if}

    <section id="content" class="page-content">
      <div class="ogone-subscriptions-list">
        {if !$subscriptions}
          <p>{l s='You don\'t have any subscriptions' mod='ogone'}</p>
        {/if}
        <div class="row subscribe-resume-container">
          {foreach $subscriptions as $id_subscription=>$subscription_data}

            <div id="subscribe_resume_{$id_subscription|escape:'htmlall':'UTF-8'}" class="subscribe-resume subscribe-info-list col-sm-12 {if $subscription_data.has_ended}ended{/if}">
            {if $subscription_data.has_ended}<div class="subscription-end">{l s='This is subscription has ended' mod='ogone'}</div>{/if}
              <dl>
                <dt><strong>{l s='This is subscription for' mod='ogone'}</strong></dt><dd><strong>{$subscription_data.product_name|escape:'htmlall':'UTF-8'}</strong></dd>
                <dt><strong>{l s='Your subscription start at' mod='ogone'}</strong></dt><dd><strong>{$subscription_data.start_date|escape:'htmlall':'UTF-8'}</strong></dd>
                <dt><strong>{l s='Your subscription end at ' mod='ogone'}</strong></dt><dd><strong>{$subscription_data.end_date|escape:'htmlall':'UTF-8'}</strong></dd>
                <dt><strong>{l s='The amount of' mod='ogone'}</strong></dt><dd><strong>{$subscription_data.amount|escape:'htmlall':'UTF-8'}</strong></dd>
                <dt><strong>{l s='Number of installments' mod='ogone'}</strong></dt><dd><strong>{$subscription_data.installments|escape:'htmlall':'UTF-8'}</strong></dd>
                <dt><strong>{l s='Frequency' mod='ogone'}</strong></dt><dd><strong>{$subscription_data.hr_frequency|escape:'htmlall':'UTF-8'}</strong></dd>
                <dt><strong>{l s='Billing will occur on' mod='ogone'}</strong></dt><dd><strong>{$subscription_data.hr_billing|escape:'htmlall':'UTF-8'}</strong></dd>
              </dl>
              <div class="actions_container">
                 {if !($subscription_data.has_ended)}
                  <form id="subscription_form_{$id_subscription|escape:'htmlall':'UTF-8'}" name="subscription_form" method="post" action="{$stop_link|escape:'htmlall':'UTF-8'}" class="subscription_form">
                    <input type="hidden" name="id_subscription" value ="{$id_subscription|escape:'htmlall':'UTF-8'}">
                    <input type="submit" class="btn btn-primary danger alert" value="{l s='Stop subscription' mod='ogone'}" name="submitStopSubscription">
                  </form>
                 {/if}
                 {*if isset($subscription_data.orders) &&count($subscription_data.orders)>0}
                  <input type="button" class="btn-toggle btn btn-primary alert mo_wrapper" value="{l s='Hide info' mod='ogone'}" data-target="subscribe_order_wrapper_{$id_subscription|escape:'htmlall':'UTF-8'}" data-hide-txt="{l s='Hide info' mod='ogone'}"  data-show-txt="{l s='Show info' mod='ogone'}">
                  {/if*}
          </div>
           {if isset($subscription_data.orders) &&count($subscription_data.orders)>0}

              <div class="data-info-wrapper" id="subscribe_order_wrapper_{$id_subscription|escape:'htmlall':'UTF-8'}">
                  <table id="subscribe_order_{$id_subscription|escape:'htmlall':'UTF-8'}" class="data-info clearfix">
                  <thead>
                    <tr class="datas">
                      <th>{l s='Order' mod='ogone'}</th>
                      <th>{l s='PayID' mod='ogone'}</th>
                      <th>{l s='Date' mod='ogone'}</th>
                      <th>{l s='Amount' mod='ogone'}</th>
                      <th>{l s='Order status' mod='ogone'}</th>
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
          {/foreach}
        </div>
      </div>
    </section>
  </div>
