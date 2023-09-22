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
{extends file='page.tpl'}
{block name='content'}
{capture name=path}
{if isset($navigationPipe)}
  <a title="{l s='My account' mod='ogone'}" href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}">{l s='My account' mod='ogone'}</a>
  <span class="navigation-pipe">{$navigationPipe|escape:'html':'UTF-8'}</span>
  {l s='My payment methods' mod='ogone'}
{/if}
{/capture}
  <h1 class="page-heading bottom-indent">{l s='My payment methods' mod='ogone'}</h1>

{if isset($errors) && $errors}
  {foreach $errors as $error}
    <p class="ogone-fo-message alert alert-success">{$error|escape:'html':'UTF-8'}</p>
  {/foreach}
{/if}
{if isset($messages) && $messages}
  {foreach $messages as $message}
    <p class="ogone-fo-error alert alert-danger">{$message|escape:'html':'UTF-8'}</p>
  {/foreach}
{/if}
{if $aliases}
  <p class="cards-title"><i class="icon-credit-card"></i> {l s='My active payment methods' mod='ogone'}</p>
  <p class="info-title"></p>
  <div class="ogone-aliases row clearfix">
  {foreach $aliases as $alias}
    {if $alias.is_temporary}
      {continue}
    {/if}
    <div class="card col-lg-4 col-md-6">
      <div class="inner-card">
        <img class="picto-card" src="{$alias.logo|escape:'htmlall':'UTF-8'}" title="{$alias.brand|escape:'htmlall':'UTF-8'}"/>
        <p class="ogone-alias-cardno">
          <span class="card-info-title">
            {if $alias.expiry_date != '0000-00-00'}
            {l s='Card number' mod='ogone'}
            {else}
            {l s='Account number' mod='ogone'}
            {/if}
          </span>
          {$alias.cardno|escape:'html':'UTF-8'}
        </p>
        <p class="ogone-alias-cn">
          <span class="card-info-title">
            {l s='Card owner' mod='ogone'}
          </span>
          {$alias.cn|escape:'html':'UTF-8'}
        </p>
        {if $alias.expiry_date != '0000-00-00'}
        <span class="ogone-alias-ed">
          <span class="card-info-title">
            {l s='Expiration date' mod='ogone'}
          </span>
          {$alias.expiry_date|escape:'html':'UTF-8'}
        </span>
        {/if}
        <span class="ogone-alias-delete"><a href="{$alias.delete_link|escape:'html':'UTF-8'}"><i class="icon-trash"></i></a></span>
      </div>
    </div>
  {/foreach}
  </div>
{/if}
<script>
  var confirm_msg  = "{l s='Are you sure?' mod='ogone'}";
</script>
<p class="new-card-title"><i class="icon-plus-square-o"></i> {l s='Add a new payment method' mod='ogone'}</p>
<p class="info-title">{l s='Data will be securely stored on Ingenico ePayments servers.' mod='ogone'}</p>
{foreach $htp_urls as $k=>$htp_url}
 <div class='{$k|strtolower|escape:'htmlall':'UTF-8'} ogone_pm_holder {$k|escape:'htmlall':'UTF-8'} '>
   <div class="ogone_payment_method_title"><h4 style='border 1px solid #333; padding: 10px; margin:10px; cursor:pointer; text-decoration: underline'
   data-textopen="{l s='Fill this form to add new ' mod='ogone'} {$htp_urls_names[$k]|escape:'quotes':'UTF-8'}"
   data-textclose="{l s='Click here to add new ' mod='ogone'} {$htp_urls_names[$k]|escape:'quotes':'UTF-8'}"


   >{l s='Click to add' mod='ogone'} {$htp_urls_names[$k]|escape:'quotes':'UTF-8'}</h4></div>
   <div class="ogone_iframe_container" style="display:none">
   <iframe src="{$htp_url|escape:'quotes':'UTF-8'}" style="min-width: 400px; min-height: {if $k=='CreditCard'}500px{else}300px{/if}"></iframe>
   </div>
</div>
{/foreach}
{/block}