{*
* 2007-2014 PrestaShop
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
*  @author     PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2017 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{extends file='page.tpl'}
{capture name=path}
{if isset($navigationPipe)}
<a href="{$link->getPageLink('order', true, NULL, "step=3")|escape:'html':'UTF-8'}" title="{l s='Go back to the Checkout' mod='ogone'}">{l s='Checkout' mod='ogone'}</a><span class="navigation-pipe">{$navigationPipe|escape:'htmlall':'UTF-8'}</span>{l s='Payment confirmation' mod='ogone'}
{/if}
{/capture}
{block name='content'}


<h1 class="page-heading">{l s='Order summary' mod='ogone'}</h1>

{assign var='current_step' value='payment'}
{*include file="$tpl_dir./order-steps.tpl"*}

{if $nbProducts <= 0}
<p class="warning">{l s='Your shopping cart is empty.' mod='ogone'}</p>
{else}
<form action="{$validate_link|escape:'htmlall':'UTF-8'}" method="post">
<div class="box">
<input type="hidden" name="id_alias" value="{$alias_data.id_ogone_alias|escape:'htmlall':'UTF-8'}" />
<h3 class="page-subheading">{l s='Payment confirmation' mod='ogone'}</h3>
<p class="">
  {l s='The total amount of your order is' mod='ogone'}
  <span id="amount" class="price">{displayPrice price=$total}</span>
  {if isset($use_taxes) && $use_taxes == 1}{l s='(tax incl.)' mod='ogone'}{/if}
  <br/><br />
  {l s='You are going to pay using your stored card data.' mod='ogone'}
  ({l s='You can edit your stored card data on' mod='ogone'}
  <a href="{$alias_link|escape:'htmlall':'UTF-8'}" ><strong>{l s='on this page' mod='ogone'}</strong></a>)

  {if isset($3ds_active) && $3ds_active}
  <br />{l s='Depending on payment method used you may be asked for an additional 3-D secure authentication.' mod='ogone'}
  {/if}
  <br/>
  <div class="alias-selected">
    <div class="inner-card {if isset($3ds_active) && $3ds_active}inner-card-cvc-adjust{/if}">
    <img class="picto-card" src="{$alias_data.logo|escape:'htmlall':'UTF-8'}" title="{$alias_data.brand|escape:'htmlall':'UTF-8'}"/>
    <p class="ogone-alias-cardno">
      <span class="card-info-title">
      {l s='Card number' mod='ogone'}
      </span>
      {$alias_data.cardno|escape:'html':'UTF-8'}
    </p>
    <p class="ogone-alias-cn">
      <span class="card-info-title">
      {l s='Card owner' mod='ogone'}
      </span>
      {$alias_data.cn|escape:'html':'UTF-8'}
    </p>
    <span class="ogone-alias-ed">
      <span class="card-info-title">
      {l s='Expiration date' mod='ogone'}
      </span>
      {$alias_data.expiry_date|escape:'html':'UTF-8'}
    </span>
      {if isset($3ds_active) && $3ds_active}
  <div class="ogone-cvc-container clearfix clear">
      <div class="ogone-cvc-input-container">
        <label>{l s='CVC' mod='ogone'} : </label>
        <input class="ogone-cvc-input" type="text" name="CVC" value="" placeholder="" size="4" maxsize="4" id="OGONE_CVC" />
      </div>
      <span class="ogone-cvc-info">
        {l s="The Card Verification Code is a 3 or 4 digit number on your credit card or debit card" mod="ogone"}
      </span>
    </div>
  {/if}
    </div>
  </div>

</p>
</div>

<p class="cart_navigation clearfix" id="cart_navigation">
  <a href="{$return_order_link|escape:'htmlall':'UTF-8'}" class="button-exclusive btn btn-default">
  <i class="icon-chevron-left"></i>{l s='Other payment methods' mod='ogone'}
  </a>
  <button type="submit" class="button btn btn-default button-medium">
  <span>{l s='I confirm my order' mod='ogone'}<i class="icon-chevron-right right"></i></span>
  </button>
</p>
</form>
{/if}

{/block}