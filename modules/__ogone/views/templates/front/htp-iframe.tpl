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
<div class="row alias_block">
  <div class="col-xs-12">
    <div class="payment_module">
      <div class="ogone">
        <div class="info-title" id="alias_trigger">
          <img src="/modules/ogone/views/img/cc_medium.png">
          {if $has_aliases}
              {if isset($immediate_payment) && $immediate_payment}
                  {l s='Click here to finalise your payment.' mod='ogone'}
              {else}
                  {l s='Click here to add another alias.' mod='ogone'}
              {/if}
          {else}
            {if isset($immediate_payment) && $immediate_payment}
                {l s='Click here to finalise your payment.' mod='ogone'}
            {else}
                  {l s='By filling this form, you will be storing your card data on secure Ingenico ePayments server' mod='ogone'}
            {/if}
          {/if}
        </div>
        {if $alias_page_url}
        <div class="alias-link">{l s='You can manage aliases on' mod='ogone'} <a target="_blank" href="{$alias_page_url|escape:'quotes':'UTF-8'}">{l s='alias page' mod='ogone'}</a></div>
        {/if}
        <div id="alias_holder" style="display:{if $has_aliases}none{else}block{/if}">
        {foreach $htp_urls as $k=>$htp_url}
         <div class='{$k|strtolower|escape:'htmlall':'UTF-8'}  col-lg-4 col-md-6'>
          <iframe src="{$htp_url|escape:'quotes':'UTF-8'}" style="min-width: 400px; min-height: 500px; border: none;"></iframe>
         </div>
        {/foreach}
        </div>
      </div>
    </div>
  </div>
</div>
<script  defer="defer">
  var alias_holder_displayed_txt = "{if isset($immediate_payment) && $immediate_payment}{l s='Fill this form to finalise the payment' mod='ogone'}{else}{l s='By filling this form, you will be storing your card data on secure Ingenico ePayments server' mod='ogone'}{/if}";
  var alias_holder_hidden_txt = "{if $has_aliases}{l s='Click here to add another alias.' mod='ogone'}{else}{l s='Click here to create an alias.' mod='ogone'}{/if}";
  {literal}
  $(function(){
    $("#alias_trigger").click(function(){
      if ($("#alias_holder:visible").length == 1){
         $("#alias_trigger").text(alias_holder_hidden_txt);
         $("#alias_holder").hide();
      } else {
         $("#alias_trigger").text(alias_holder_displayed_txt);
         $("#alias_holder").show();
      }

    });
  });
{/literal}
</script>
