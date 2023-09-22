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
      <img src='{$ogone_htp_logo|escape:'htmlall':'UTF-8'}' class="ogone_htp_logo" style="max-width: 64px">
      <div class="ogone">
        <div class="info-htp-title alias_trigger_{$type_class|escape:'quotes':'UTF-8'}">
          {if $has_aliases}
              {if isset($immediate_payment) && $immediate_payment}
                  {l s='Click here to finalise your payment using' mod='ogone'} {$type_name|escape:'htmlall':'UTF-8'}
              {else}
                  {l s='Click here to add another' mod='ogone'} {$type_name|escape:'htmlall':'UTF-8'}
              {/if}
          {else}
            {if isset($immediate_payment) && $immediate_payment}
                {l s='Click here to finalise your payment using' mod='ogone'} {$type_name|escape:'htmlall':'UTF-8'}
            {else}
                  {l s='By filling this form, you will be storing your payment data on secure Ingenico ePayments server' mod='ogone'}
            {/if}
          {/if}
        </div>
        {if $alias_page_url}
        <div class="alias-link">{l s='You can manage payment methods on' mod='ogone'} <a target="_blank" href="{$alias_page_url|escape:'quotes':'UTF-8'}">{l s='this page' mod='ogone'}</a></div>
        {/if}
        <div class="alias_holder_{$type_class|escape:'htmlall':'UTF-8'}">
          <iframe src="{$htp_url|escape:'quotes':'UTF-8'}" style="min-width: 400px;  border: none; min-height: {if $type_class=='creditcard'}500px{else}400px{/if}"></iframe>
         </div>
        </div>
      </div>
    </div>
  </div>
<script >
    var alias_holder_displayed_txt = "{if isset($immediate_payment) && $immediate_payment}{l s='Fill this form to finalise the payment using' mod='ogone'}  {$type_name|escape:'javascript':'UTF-8'}{else}{l s='By filling this form, you will be storing data on secure Ingenico ePayments server' mod='ogone'}{/if}";
    var alias_holder_hidden_txt = "{if isset($immediate_payment) && $immediate_payment}{l s='Click here to finalise your payment using' mod='ogone'} {$type_name|escape:'javascript':'UTF-8'}{else}{if $has_aliases}{l s='Click here to add another payment method.' mod='ogone'}{else}{l s='Click here to create an payment method.' mod='ogone'}{/if}{/if}";
    var accept_conditions_txt = "{l s='You need to accept terms and conditions' mod='ogone'}";

</script>
