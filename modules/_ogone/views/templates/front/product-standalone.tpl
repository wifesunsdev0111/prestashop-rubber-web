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
<p class="subscribe-title"><strong>{l s='Subscription details' mod='ogone'} :</strong></p>
<!--  <p class="info-subscribe">{l s='You may unsubscribe at any moment.' mod='ogone' }</p> //-->

<div class="subscription_presentation_product">
  {include file='./subscription_presentation_before.tpl'}
</div>

<div class="row">
  <div class="col-xs-12">
    <a href="{$subscribe_link|escape:'htmlall':'UTF-8'}&id_subscription={$subscription->id|escape:'htmlall':'UTF-8'}&action=add" class="bt-subscribe btn btn-primary pull-xs-left"> {l s='Subscribe' mod='ogone'}</a>
    <div class="clearfix"></div>
  </div>
</div>

 <script defer="true">
   var delete_add_to_cart = {if $delete_add_to_cart}true{else}false{/if}
 </script>
