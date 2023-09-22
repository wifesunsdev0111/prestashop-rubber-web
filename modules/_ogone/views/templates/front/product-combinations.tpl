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

<!-- PRODUCT COMBINATION  -->
{if $subscription_datas}
  {assign var="subscription_block_displayed" value=0}
  {foreach $subscription_datas as $id_subscription =>$subscription_data}
    <div class="subscription_presentation_product"  id="subscribe_info_{$subscription_data.id_product_attribute|escape:'htmlall':'UTF-8'}"
    style="{if $id_product_attribute!=$subscription_data.id_product_attribute}{assign var="subscription_block_displayed" value=1}
display:none;{/if}">
      <p class="subscribe-title"><strong>{l s='Subscription details' mod='ogone'} :</strong></p>
      {include './subscription_presentation_before.tpl'}
        <div class="row">
      <div class="col-xs-12">
        <a href="{$subscribe_link|escape:'htmlall':'UTF-8'}&id_subscription={$id_subscription|escape:'htmlall':'UTF-8'}&action=add" class="bt-subscribe btn btn-primary pull-xs-left"> {l s='Subscribe' mod='ogone'}</a>
        <div class="clearfix"></div>
      </div>
    </div>
    </div>
  {/foreach}

  <p class="info-subscribe no-combination" style="{if $subscription_block_displayed==1}display:none;{/if}">{l s='There is no subscription for this combination.' mod='ogone'}</p>
  <script defer="true">
    var delete_add_to_cart = {if $delete_add_to_cart}true{else}false{/if}
  </script>
{/if}


