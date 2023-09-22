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
{if isset($opc_config) && isset($opc_config.hide_carrier)}
    {assign var=singleCarrier value=$opc_config.hide_carrier=="1" && isset($carriers) && $carriers && count($carriers)==1}
{else}
    {assign var=singleCarrier value=isset($carriers) && $carriers && count($carriers)==1}
{/if}


{assign var=displayForm value=(!$singleCarrier && (!isset($isVirtualCart) || !$isVirtualCart)) || (isset($opc_config.order_msg) && $opc_config.order_msg) || ($conditions AND $cms_id) || isset($onlyCartSummary)}


<form id="carriers_section" class="std{if isset($isVirtualCart) && $isVirtualCart} no_carriers{/if}" action="#"
      {if !$displayForm}style="display:none"{/if}>
    <fieldset>

        {if !isset($isVirtualCart) || !$isVirtualCart}
            <h3 id="choose_delivery"
                {if $singleCarrier}style="display:none;"{/if}>{l s='Choose your delivery method' mod='onepagecheckout'}</h3>
        {/if}

        <div id="opc_delivery_methods" class="opc-main-block">
            <div id="opc_delivery_methods-overlay" class="opc-overlay" style="display: none;"></div>

            {if $virtual_cart}
                <input id="input_virtual_carrier" class="hidden" type="hidden" name="id_carrier" value="0"/>
            {else}
                <div id="HOOK_BEFORECARRIER">{if isset($carriers)}{$HOOK_BEFORECARRIER}{/if}</div>
                {if isset($isVirtualCart) && $isVirtualCart}
                {*	<p class="warning">{l s='No carrier needed for this order' mod='onepagecheckout'}</p> *}
                {else}
                    <p class="warning" id="noCarrierWarning"
                       {if isset($carriers) && $carriers && count($carriers)}style="display:none;"{/if}>{l s='There are no carriers available that deliver to this address.' mod='onepagecheckout'}</p>
                    <table id="carrierTable" class="std"
                           {if !isset($carriers) || !$carriers || !count($carriers) || $singleCarrier}style="display:none;"{/if}>
                        {*<thead>
                        <tr>
                            <th class="carrier_action first_item"></th>
                            <th class="carrier_name item">{l s='Carrier' mod='onepagecheckout'}</th>
                            <th class="carrier_infos item">{l s='Information' mod='onepagecheckout'}</th>
                            <th class="carrier_price last_item">{l s='Price' mod='onepagecheckout'}</th>
                        </tr>
                        </thead>*}
                        <tbody>
                        {if isset($carriers)}
                            {foreach from=$carriers item=carrier name=myLoop}
                                <tr class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{/if} {if $smarty.foreach.myLoop.index % 2}alternate_item{else}item{/if}">
                                    <td class="carrier_action radio">
                                        <input type="radio" name="id_carrier" value="{$carrier.id_carrier|intval}"
                                               id="id_carrier{$carrier.id_carrier|intval}"
                                               onclick="updateCarrierSelectionAndGift();"
                                               {if $carrier.id_carrier == $checked || $carriers|@count == 1}checked="checked"{/if} />
                                    </td>
                                    <td class="carrier_name">
                                        <label for="id_carrier{$carrier.id_carrier|intval}">
                                            {if $carrier.img}<img src="{$carrier.img|escape:'htmlall':'UTF-8'}"
                                                                  alt="{$carrier.name|escape:'htmlall':'UTF-8'}"/>{else}{$carrier.name|escape:'htmlall':'UTF-8'}{/if}
                                        </label>
                                    </td>
                                    <td class="carrier_infos">
                                        <label for="id_carrier{$carrier.id_carrier|intval}">
                                            {$carrier.delay|escape:'htmlall':'UTF-8'}
                                        </label>
                                    </td>
                                    <td class="carrier_price">
                                        <label for="id_carrier{$carrier.id_carrier|intval}">
                                            {if $carrier.price && (!isset($free_shipping) || (isset($free_shipping) && !$free_shipping))}
                                                <span class="price">
                                                {if $priceDisplay == 1}{convertPrice price=$carrier.price_tax_exc}{else}{convertPrice price=$carrier.price}{/if}
                                                 </span>
                                                {if $use_taxes}{if $priceDisplay == 1} {l s='(tax excl.)' mod='onepagecheckout'}{else} {l s='(tax incl.)' mod='onepagecheckout'}{/if}{/if}
                                            {else}
                                                {l s='Free!' mod='onepagecheckout'}
                                            {/if}
                                        </label>
                                    </td>
                                </tr>
                            {/foreach}
                            <tr id="HOOK_EXTRACARRIER">{if isset($HOOK_EXTRACARRIER)}{$HOOK_EXTRACARRIER}{/if}</tr>
                        {/if}
                        </tbody>
                    </table>
                    <div style="display: none;" id="extra_carrier"></div>
                    {if $recyclablePackAllowed && !isset($onlyCartSummary)}
                        <p class="checkbox">
                            <input type="checkbox" name="recyclable" id="recyclable" value="1"
                                   {if $recyclable == 1}checked="checked"{/if} />
                            <label for="recyclable">{l s='I agree to receive my order in recycled packaging' mod='onepagecheckout'}
                                .</label>
                        </p>
                    {/if}
                    {if $giftAllowed && !isset($onlyCartSummary)}
                        {if !isset($opc_config.compact_form) || !$opc_config.compact_form}<h4
                                class="gift_title">{l s='Gift' mod='onepagecheckout'}</h4>{/if}
                        <p class="checkbox">
                            <input type="checkbox" name="gift" id="gift" value="1"
                                   {if $cart->gift == 1}checked="checked"{/if} />
                            <label for="gift">{l s='I would like the order to be gift-wrapped.' mod='onepagecheckout'}</label>
                            {if $gift_wrapping_price > 0}
                                ({l s='Additional cost of' mod='onepagecheckout'}
                                <strong class="price" id="gift-price">
                                    {if $priceDisplay == 1}{convertPrice price=$total_wrapping_tax_exc_cost}{else}{convertPrice price=$total_wrapping_cost}{/if}
                                </strong>
                                {if $use_taxes}{if $priceDisplay == 1} {l s='(tax excl.)' mod='onepagecheckout'}{else} {l s='(tax incl.)' mod='onepagecheckout'}{/if}{/if}
                                )
                            {/if}
                        </p>
                        <p id="gift_div" class="textarea">
                            <label for="gift_message"
                                   style="text-align: left;">{l s='If you wish, you can add a note to the gift:' mod='onepagecheckout'}</label>
                            <textarea rows="5" cols="35" id="gift_message"
                                      name="gift_message">{$cart->gift_message|escape:'htmlall':'UTF-8'}</textarea>
                        </p>
                    {/if}
                {/if}
            {/if}
            <div id="message_container">
            {if isset($opc_config.order_msg) && $opc_config.order_msg && !isset($onlyCartSummary)}
                {if !isset($opc_config.compact_form) || !$opc_config.compact_form}
                    <h4>{l s='Leave a message' mod='onepagecheckout'}</h4>
                {/if}
                <div>
                    <p id="order_msg_placeholder_fallback">{l s='If you would like to add a comment about your order, please write it below.' mod='onepagecheckout'}</p>

                    <p><div class="textarea-wrapper"><textarea rows="3" name="message" id="message"
                                 placeholder="{l s='If you would like to add a comment about your order, please write it here.' mod='onepagecheckout'}">{if isset($oldMessage)}{$oldMessage|escape:'html':'UTF-8'}{/if}</textarea></div>
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
</form>

