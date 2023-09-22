{*
* 2007-2016 PrestaShop
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
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{if !$opc}
    <script type="text/javascript">
        //<![CDATA[
        var orderProcess = 'order';
        var currencySign = '{$currencySign|html_entity_decode:2:"UTF-8"}';
        var currencyRate = '{$currencyRate|floatval}';
        var currencyFormat = '{$currencyFormat|intval}';
        var currencyBlank = '{$currencyBlank|intval}';
        var txtProduct = "{l s='Product' mod='onepagecheckout' js=1}";
        var txtProducts = "{l s='Products' mod='onepagecheckout' js=1}";
        var orderUrl = '{$link->getPageLink("order", true)|addslashes}';

        var msg = "{l s='You must agree to the terms of service before continuing.' mod='onepagecheckout' js=1}";
        {literal}
        function acceptCGV() {
            if ($('#cgv').length && !$('input#cgv:checked').length) {
                alert(msg);
                return false;
            }
            else
                return true;
        }
        {/literal}
        //]]>
    </script>
{else}
    <script type="text/javascript">
        var txtFree = "{l s='Free' mod='onepagecheckout'}";
    </script>
{/if}

{if isset($virtual_cart) && !$virtual_cart && $giftAllowed && $cart->gift == 1}
    <script type="text/javascript">
        {literal}
        // <![CDATA[
        $('document').ready(function () {
            if ($('input#gift').is(':checked'))
                $('p#gift_div').show();
        });
        //]]>
        {/literal}
    </script>
{/if}

{if !$opc}
    {capture name=path}{l s='Shipping:' mod='onepagecheckout'}{/capture}
    {include file="$tpl_dir./breadcrumb.tpl"}
{/if}

<div id="carriers_section" class="std{if isset($isVirtualCart) && $isVirtualCart} no_carriers{/if}" action="#">
<fieldset>
{if !isset($isVirtualCart) || !$isVirtualCart}
    <h3 id="choose_delivery">{l s='Choose your delivery method' mod='onepagecheckout'}</h3>
{/if}

<div class="order_carrier_content">

    {if isset($virtual_cart) && $virtual_cart}
        <input id="input_virtual_carrier" class="hidden" type="hidden" name="id_carrier" value="0"/>
    {else}
        <div id="HOOK_BEFORECARRIER">
            {if isset($carriers) && isset($HOOK_BEFORECARRIER)}
                {$HOOK_BEFORECARRIER}
            {/if}
        </div>
        {if isset($isVirtualCart) && $isVirtualCart}
            <p class="warning">{l s='No carrier is needed for this order.' mod='onepagecheckout'}</p>
        {else}
            {if $recyclablePackAllowed}
                <p class="checkbox">
                    <input type="checkbox" name="recyclable" id="recyclable" value="1"
                           {if $recyclable == 1}checked="checked"{/if} autocomplete="off"/>
                    <label for="recyclable">{l s='I would like to receive my order in recycled packaging.' mod='onepagecheckout'}.</label>
                </p>
            {/if}
            <div class="delivery_options_address">
                {if isset($delivery_option_list)}
                    {foreach $delivery_option_list as $id_address => $option_list}
                        <div class="delivery_options">
                            {foreach $option_list as $key => $option}
                                <div class="delivery_option {if ($option@index % 2)}alternate_{/if}item">
                                <table class="delivery_option_line">
                                <tr><td>
                                    <input class="delivery_option_radio" type="radio"
                                           name="delivery_option[{$id_address|intval}]"
                                           onchange="{if $opc}updateCarrierSelectionAndGift();{else}updateExtraCarrier('{$key}', {$id_address|intval});{/if}"
                                           id="delivery_option_{$id_address|intval}_{$option@index}" value="{$key}"
                                           {if isset($delivery_option[$id_address]) && $delivery_option[$id_address] == $key}checked="checked"{/if} />
                                </td><td>
                                    <label for="delivery_option_{$id_address|intval}_{$option@index}">
                                        <table class="resume">
                                            <tr>
                                                <td class="delivery_option_logo">
                                                    {foreach $option.carrier_list as $carrier}
                                                        {if $carrier.logo}
                                                            <img src="{$carrier.logo|escape:'htmlall':'UTF-8'}" alt="{$carrier.instance->name|escape:'htmlall':'UTF-8'}"/>
                                                        {else if !$option.unique_carrier}
                                                            {$carrier.instance->name|escape:'htmlall':'UTF-8'}
                                                            {if !$carrier@last} - {/if}
                                                        {/if}
                                                    {/foreach}
                                                </td>
                                                <td>
                                                    {if $option.unique_carrier}
                                                        {foreach $option.carrier_list as $carrier}
                                                            <div class="delivery_option_title">{$carrier.instance->name|escape:'htmlall':'UTF-8'}</div>
                                                        {/foreach}
                                                        {if isset($carrier.instance->delay[$cookie->id_lang])}
                                                            <div class="delivery_option_delay">{$carrier.instance->delay[$cookie->id_lang]|escape:'htmlall':'UTF-8'}</div>
                                                        {/if}
                                                    {/if}
                                                    {if count($option_list) > 1}
                                                        {if $option.is_best_grade}
                                                            {if $option.is_best_price}
                                                                <div class="delivery_option_best delivery_option_icon">{l s='The best price and speed' mod='onepagecheckout'}</div>
                                                            {else}
                                                                <div class="delivery_option_fast delivery_option_icon">{l s='The fastest' mod='onepagecheckout'}</div>
                                                            {/if}
                                                        {else}
                                                            {if $option.is_best_price}
                                                                <div class="delivery_option_best_price delivery_option_icon">{l s='The best price' mod='onepagecheckout'}</div>
                                                            {/if}
                                                        {/if}
                                                    {/if}
                                                </td>
                                                <td>
                                                    <div class="delivery_option_price">
                                                        {if $option.total_price_with_tax && (!isset($free_shipping) || (isset($free_shipping) && !$free_shipping))}
                                                            {if $use_taxes == 1}
                                                                {if $priceDisplay == 1}
                                                                    {convertPrice price=$option.total_price_without_tax} {l s='(tax excl.)' mod='onepagecheckout'}
                                                                {else}
                                                                    {convertPrice price=$option.total_price_with_tax} {l s='(tax incl.)' mod='onepagecheckout'}
                                                                {/if}
                                                            {else}
                                                                {convertPrice price=$option.total_price_without_tax}
                                                            {/if}
                                                        {else}
                                                            {l s='Free' mod='onepagecheckout'}
                                                        {/if}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="delivery_option_carrier {if isset($delivery_option[$id_address]) && $delivery_option[$id_address] == $key}selected{/if} {if $option.unique_carrier}not-displayable{/if}">
                                            {foreach $option.carrier_list as $carrier}
                                                <tr>
                                                    {if !$option.unique_carrier}
                                                        <td class="first_item">
                                                            <input type="hidden" value="{$carrier.instance->id|intval}"
                                                                   name="id_carrier"/>
                                                            {if $carrier.logo}
                                                                <img src="{$carrier.logo|escape:'htmlall':'UTF-8'}"
                                                                     alt="{$carrier.instance->name|escape:'htmlall':'UTF-8'}"/>
                                                            {/if}
                                                        </td>
                                                        <td>
                                                            {$carrier.instance->name|escape:'htmlall':'UTF-8'}
                                                        </td>
                                                    {/if}
                                                    <td {if $option.unique_carrier}class="first_item" colspan="2"{/if}>
                                                        <input type="hidden" value="{$carrier.instance->id|intval}"
                                                               name="id_carrier"/>
                                                        {if isset($carrier.instance->delay[$cookie->id_lang])}
                                                            {$carrier.instance->delay[$cookie->id_lang]|escape:'htmlall':'UTF-8'}
                                                            <br/>
                                                            {if count($carrier.product_list) <= 1}
                                                                ({l s='Product concerned:' mod='onepagecheckout'}
                                                            {else}
                                                                ({l s='Products concerned:' mod='onepagecheckout'}
                                                            {/if}
                                                            {* This foreach is on one line, to avoid tabulation in the title attribute of the acronym *}
                                                            {foreach $carrier.product_list as $product}
                                                                {if $product@index == 4}<acronym title="{/if}{if $product@index >= 4}{$product.name}{if isset($product.attributes) && $product.attributes} {$product.attributes|escape:'htmlall':'UTF-8'}{/if}{if !$product@last}, {else}">...</acronym>){/if}{else}{$product.name|escape:'htmlall':'UTF-8'}{if isset($product.attributes) && $product.attributes} {$product.attributes|escape:'htmlall':'UTF-8'}{/if}{if !$product@last}, {else}){/if}{/if}{/foreach}
                                                        {/if}
                                                    </td>
                                                </tr>
                                            {/foreach}
                                        </table>
                                    </label>
                                    </td></tr></table>
                                </div>
                            {/foreach}
                        </div>
                        <div class="hook_extracarrier"
                             id="HOOK_EXTRACARRIER">{if isset($HOOK_EXTRACARRIER_ADDR) &&  isset($HOOK_EXTRACARRIER_ADDR.$id_address)}{$HOOK_EXTRACARRIER_ADDR.$id_address}{elseif isset($HOOK_EXTRACARRIER)}{$HOOK_EXTRACARRIER}{/if}</div>
                        {foreachelse}
                        <p class="warning" id="noCarrierWarning">
                            {foreach $cart->getDeliveryAddressesWithoutCarriers(true) as $address}
                                {if empty($address->alias)}
                                    {l s='No carriers available.' mod='onepagecheckout'}
                                {else}
                                    {l s='No carriers available for the address "%s".' sprintf=$address->alias mod='onepagecheckout'}
                                {/if}
                                {if !$address@last}
                                    <br/>
                                {/if}
                                {foreachelse}
                                {l s='No carriers available.' mod='onepagecheckout'}
                            {/foreach}
                        </p>
                    {/foreach}
                {/if}

            </div>
            <div style="display: none;" id="extra_carrier"></div>
            {if $giftAllowed}
                <h3 class="gift_title">{l s='Gift' mod='onepagecheckout'}</h3>
                <p class="checkbox">
                    <input type="checkbox" name="gift" id="gift" value="1" {if $cart->gift == 1}checked="checked"{/if}
                           autocomplete="off"/>
                    <label for="gift">{l s='I would like my order to be gift wrapped.' mod='onepagecheckout'}</label>
                    <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    {if $gift_wrapping_price > 0}
                        ({l s='Additional cost of' mod='onepagecheckout'}
                        <span class="price" id="gift-price">
					{if $priceDisplay == 1}{convertPrice price=$total_wrapping_tax_exc_cost}{else}{convertPrice price=$total_wrapping_cost}{/if}
				</span>
                        {if $use_taxes}{if $priceDisplay == 1} {l s='(tax excl.)' mod='onepagecheckout'}{else} {l s='(tax incl.)' mod='onepagecheckout'}{/if}{/if})
                    {/if}
                </p>
                <p id="gift_div" class="textarea">
                    <label for="gift_message">{l s='If you\'d like, you can add a note to the gift:' mod='onepagecheckout'}</label>
                    <textarea rows="5" cols="35" id="gift_message"
                              name="gift_message">{$cart->gift_message|escape:'htmlall':'UTF-8'}</textarea>
                </p>
            {/if}
        {/if}
    {/if}


</div>
<div class="below-carrier-content">
<div id="message_container">

{if isset($opc_config.order_msg) && $opc_config.order_msg && !isset($onlyCartSummary)}
    {if !isset($opc_config.compact_form) || !$opc_config.compact_form}
        <h4>{l s='Leave a message' mod='onepagecheckout'}</h4>
    {/if}
    <div>
        <p id="order_msg_placeholder_fallback">{l s='If you would like to add a comment about your order, please write it below.' mod='onepagecheckout'}</p>

        <p><div class="textarea-wrapper"><textarea rows="3" name="message" id="message"
                     placeholder="{l s='If you would like to add a comment about your order, please write it here.' mod='onepagecheckout'}">{if isset($oldMessage)}{$oldMessage|escape:'htmlall':'UTF-8'}{/if}</textarea></div>
        </p>
    </div>
{/if}
  </div>


{if $conditions AND $cms_id && !isset($onlyCartSummary)}
    {if !isset($opc_config.compact_form) || !$opc_config.compact_form}
        <h4 class="condition_title">{l s='Terms of service' mod='onepagecheckout'}</h4>
    {/if}
    {if !$opc_config.order_detail_review}
        <div id="opc_tos_errors" class="error" style="display: none;"></div>
        <p class="checkbox">
            <input type="checkbox" name="cgv" id="cgv" value="1" {if $checkedTOS}checked="checked"{/if} />
            <label for="cgv">{l s='I agree to the terms of service and adhere to them unconditionally.' mod='onepagecheckout'}</label>
            <a href="{$link_conditions|escape:'html':'UTF-8'}" class="iframe">{l s='(read)' mod='onepagecheckout'}</a>
            <sup>*</sup>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}<span
            class="validity valid_{if $checkedTOS}ok{else}nok{/if}"></span>{/if}
        </p>
        {if $opc_config.goods_return_cms > 0}
            <div id="goods_return">
                <p>{l s='You are entitled to cancel your order within 7 Working Days upon goods receive.' mod='onepagecheckout'}
                    <a href="{$link_goods_return|escape:'html':'UTF-8'}" class="iframe">{l s='(read)' mod='onepagecheckout'}</a></p>
            </div>
        {/if}
    {/if}
    <script type="text/javascript">
        $(document).ready(function() {
            $("a.iframe").fancybox({
                'type' : 'iframe',
                'width':600,
                'height':600
            });
        });
    </script>
    <!--script type="text/javascript">$('a.iframe').fancybox();</script-->
{/if}

</div>

</fieldset>
</div> <!-- div#carriers_section -->