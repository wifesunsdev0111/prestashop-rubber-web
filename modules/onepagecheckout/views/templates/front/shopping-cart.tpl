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
*  @version  Release: $Revision: 1.4 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{capture name=path}{l s='Your shopping cart' mod='onepagecheckout'}{/capture}


{if !isset($opc_config.compact_form) || !$opc_config.compact_form}
{include file="$tpl_dir./breadcrumb.tpl"}
<h1 id="cart_title">{l s='Shopping cart summary' mod='onepagecheckout'}</h1>
{/if}


{assign var='current_step' value='summary'}
{*include file="$tpl_dir./order-steps.tpl"*}
{include file="$tpl_dir./errors.tpl"}


{if !$productNumber}
<p class="warning">{l s='Your shopping cart is empty.' mod='onepagecheckout'}</p>
    {elseif $PS_CATALOG_MODE}
<p class="warning">{l s='This store has not accepted your new order.' mod='onepagecheckout'}</p>
    {else}
<script type="text/javascript">
    // <![CDATA[
    var baseDir = '{$base_dir_ssl}';
    var currencySign = '{$currencySign|html_entity_decode:2:"UTF-8"}';
    var currencyRate = '{$currencyRate|floatval}';
    var currencyFormat = '{$currencyFormat|intval}';
    var currencyBlank = '{$currencyBlank|intval}';
    var txtProduct = "{l s='product' mod='onepagecheckout'}";
    var txtProducts = "{l s='products' mod='onepagecheckout'}";
    var txtFreePrice = "{l s='Free!' mod='onepagecheckout'}";
    var deliveryAddress = {$cart->id_address_delivery|intval};
	if (typeof countriesNeedIDNumber == "undefined")
      var countriesNeedIDNumber = new Array();
    if (typeof countriesNeedZipCode == "undefined")
	  var countriesNeedZipCode = new Array();



        {if isset($onlyCartSummary)}
        var orderOpcUrl = '{$link->getPageLink("order-opc", true)|escape:"html":"UTF-8"}';
        var addressUrl = '{$link->getPageLink("address.php", true)|escape:"html":"UTF-8"}';
        var taxEnabled = {$use_taxes|intval};
        var displayPrice = {$priceDisplay|intval};
        var txtWithTax = "{l s='(tax incl.)' mod='onepagecheckout'}";
        var txtWithoutTax = "{l s='(tax excl.)' mod='onepagecheckout'}";
        var opc_hide_carrier = '{$opc_config.hide_carrier|intval}';
        var onlyCartSummary = '1';
            {else}
        var onlyCartSummary = '0';
        {/if}

    // ]]>
</script>
    {if !isset($opc_config.remove_ref) || !$opc_config.remove_ref}
        {assign var="colspan" value="5"}
		{assign var="colspan2" value="3"}
        {else}
        {literal}
        <style type="text/css">
            #cart_summary .cart_ref {
                display: none;
            }
        </style>
        {/literal}
        {assign var="colspan" value="4"}
		{assign var="colspan2" value="2"}
    {/if}

<p style="display:none" id="emptyCartWarning"
   class="warning">{l s='Your shopping cart is empty.' mod='onepagecheckout'}</p>
    {if isset($lastProductAdded) AND $lastProductAdded}
        {foreach from=$products item=product}
            {if $product.id_product == $lastProductAdded.id_product AND (!$product.id_product_attribute OR ($product.id_product_attribute == $lastProductAdded.id_product_attribute))}
            <div class="cart_last_product">
                <div class="cart_last_product_header">
                    <div class="left">{l s='Last added product' mod='onepagecheckout'}</div>
                </div>
                <a class="cart_last_product_img"
                   href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category)|escape:'htmlall':'UTF-8'}"><img
                        src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'small_default')|escape:'htmlall':'UTF-8'}"
                        alt="{$product.name|escape:'htmlall':'UTF-8'}"/></a>

                <div class="cart_last_product_content">
                    <h5>
                        <a href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category)|escape:'htmlall':'UTF-8'}">{$product.name|escape:'htmlall':'UTF-8'}</a>
                    </h5>
                    {if isset($product.attributes) && $product.attributes}<a
                            href="{$link->getProductLink($product.id_product, $product.link_rewrite, $product.category)|escape:'htmlall':'UTF-8'}">{$product.attributes|escape:'htmlall':'UTF-8'}</a>{/if}
                </div>
                <br class="clear"/>
            </div>
            {/if}
        {/foreach}
    {/if}
    {if !isset($opc_config.compact_form) || !$opc_config.compact_form}
    <p>{l s='Your shopping cart contains' mod='onepagecheckout'} <span
            id="summary_products_quantity">{$productNumber} {if $productNumber == 1}{l s='product' mod='onepagecheckout'}{else}{l s='products' mod='onepagecheckout'}{/if}</span>
    </p>
    {/if}
<div id="order-detail-content" class="table_block{if isset($addClass)}{$addClass|escape:'html':'UTF-8'}{/if}">
<table id="cart_summary" class="std">
<thead>
<tr>
    <th class="cart_product first_item">{l s='Product' mod='onepagecheckout'}</th>
    <th class="cart_description item">{l s='Description' mod='onepagecheckout'}</th>
    <th class="cart_ref item">{l s='Ref.' mod='onepagecheckout'}</th>
    <th class="cart_unit item">{l s='Unit price' mod='onepagecheckout'}</th>
    <th class="cart_quantity item">{l s='Qty' mod='onepagecheckout'}</th>
    <th class="cart_total last_item">{l s='Total' mod='onepagecheckout'}</th>
    {*<th class="cart_delete last_item">&nbsp;</th>*}
</tr>
</thead>
<tbody>
    {foreach $products as $product}
        {assign var='productId' value=$product.id_product}
        {assign var='productAttributeId' value=$product.id_product_attribute}
        {assign var='quantityDisplayed' value=0}
        {assign var='odd' value=$product@iteration%2}
        {assign var='ignoreProductLast' value=isset($customizedDatas.$productId.$productAttributeId) || count($gift_products)}
    {* Display the product line *}
    {include file="$opc_templates_path/shopping-cart-product-line.tpl"}
    {* Then the customized datas ones*}
        {if isset($customizedDatas.$productId.$productAttributeId)}
            {foreach $customizedDatas.$productId.$productAttributeId[$product.id_address_delivery] as $id_customization=>$customization}
            <tr id="product_{$product.id_product}_{$product.id_product_attribute}_{$id_customization}_{$product.id_address_delivery|intval}"
                class="product_customization_for_{$product.id_product}_{$product.id_product_attribute}_{$product.id_address_delivery|intval} {if $odd}odd{else}even{/if} customization alternate_item {if $product@last && $customization@last && !count($gift_products)}last_item{/if}">
                <td></td>
                <td colspan="{$colspan2|intval}">
                    {foreach $customization.datas as $type => $custom_data}
                        {if $type == $CUSTOMIZE_FILE}
                            <div class="customizationUploaded">
                                <ul class="customizationUploaded">
                                    {foreach $custom_data as $picture}
                                        <li><img src="{$pic_dir}{$picture.value}_small" alt=""
                                                 class="customizationUploaded"/></li>
                                    {/foreach}
                                </ul>
                            </div>
                            {elseif $type == $CUSTOMIZE_TEXTFIELD}
                            <ul class="typedText">
                                {foreach $custom_data as $textField}
                                    <li>
                                        {if $textField.name}
                                            {$textField.name}
                                            {else}
                                            {l s='Text #' mod='onepagecheckout'}{$textField@index+1}
                                        {/if}
												{l s=':' mod='onepagecheckout'} {$textField.value}
                                    </li>
                                {/foreach}

                            </ul>
                        {/if}

                    {/foreach}
                </td>
                <td class="cart_quantity" colspan="1">
                    {if isset($cannotModify) AND $cannotModify == 1}
                        <span style="float:left">{if $quantityDisplayed == 0 AND isset($customizedDatas.$productId.$productAttributeId)}{$customizedDatas.$productId.$productAttributeId|@count}{else}{$product.cart_quantity-$quantityDisplayed}{/if}</span>
                        {else}
                        <div id="cart_quantity_button" class="cart_quantity_button" style="float:left">
                            <a rel="nofollow" class="cart_quantity_up"
                               id="cart_quantity_up_{$product.id_product}_{$product.id_product_attribute}_{$id_customization}_{$product.id_address_delivery|intval}"
                               href="{$link->getPageLink('cart', true, NULL, "add&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;id_address_delivery={$product.id_address_delivery}&amp;id_customization={$id_customization}&amp;token={$token_cart}")|escape:'htmlall':'UTF-8'}"
                               title="{l s='Add' mod='onepagecheckout'}"></a>
                             <input size="2" type="text" value="{$customization.quantity}" class="cart_quantity_input"
                               name="quantity_{$product.id_product}_{$product.id_product_attribute}_{$id_customization}_{$product.id_address_delivery|intval}"/>                           
                            {if $product.minimal_quantity < ($customization.quantity -$quantityDisplayed) OR $product.minimal_quantity <= 1}
                                <a rel="nofollow" class="cart_quantity_down"
                                   id="cart_quantity_down_{$product.id_product}_{$product.id_product_attribute}_{$id_customization}_{$product.id_address_delivery|intval}"
                                   href="{$link->getPageLink('cart', true, NULL, "add&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;id_address_delivery={$product.id_address_delivery}&amp;id_customization={$id_customization}&amp;op=down&amp;token={$token_cart}")|escape:'htmlall':'UTF-8'}"
                                   title="{l s='Subtract' mod='onepagecheckout'}">
                                </a>
                                {else}
                                <a class="cart_quantity_down" style="opacity: 0.3;"
                                   id="cart_quantity_down_{$product.id_product}_{$product.id_product_attribute}_{$id_customization}"
                                   href="#" title="{l s='Subtract' mod='onepagecheckout'}">
                                </a>
                            {/if}
                        </div>
                        <input type="hidden" value="{$customization.quantity}"
                               name="quantity_{$product.id_product}_{$product.id_product_attribute}_{$id_customization}_hidden"/>
                        
                    {/if}
                </td>
                <td class="cart_delete">
                    {if isset($cannotModify) AND $cannotModify == 1}
                        {else}
                        <div>
                            <a rel="nofollow" class="cart_quantity_delete"
                               id="{$product.id_product}_{$product.id_product_attribute}_{$id_customization}_{$product.id_address_delivery|intval}"
                               href="{$link->getPageLink('cart', true, NULL, "delete&amp;id_product={$product.id_product|intval}&amp;ipa={$product.id_product_attribute|intval}&amp;id_customization={$id_customization}&amp;id_address_delivery={$product.id_address_delivery}&amp;token={$token_cart}")|escape:'htmlall':'UTF-8'}">&nbsp;</a>
                        </div>
                    {/if}
                </td>
            </tr>
                {assign var='quantityDisplayed' value=$quantityDisplayed+$customization.quantity}
            {/foreach}
        {* If it exists also some uncustomized products *}
            {if $product.quantity-$quantityDisplayed > 0}{include file="$opc_templates_path/shopping-cart-product-line.tpl" productLast=$product@last productFirst=$product@first}{/if}
        {/if}
    {/foreach}
    {assign var='last_was_odd' value=$product@iteration%2}
    {foreach $gift_products as $product}
        {assign var='productId' value=$product.id_product}
        {assign var='productAttributeId' value=$product.id_product_attribute}
        {assign var='quantityDisplayed' value=0}
        {assign var='odd' value=($product@iteration+$last_was_odd)%2}
        {assign var='ignoreProductLast' value=isset($customizedDatas.$productId.$productAttributeId)}
        {assign var='cannotModify' value=1}
    {* Display the gift product line *}
    {include file="$opc_templates_path/shopping-cart-product-line.tpl" productLast=$product@last productFirst=$product@first}
    {/foreach}
</tbody>
    {if sizeof($discounts)}
    <tbody>
        {foreach $discounts as $discount}
        <tr class="cart_discount {if $discount@last}last_item{elseif $discount@first}first_item{else}item{/if}"
            id="cart_discount_{$discount.id_discount}">
            <td class="cart_discount_name" colspan="{$colspan2|intval}">{$discount.name}</td>
            <td class="cart_discount_price"><span class="price-discount">
                {if !$priceDisplay}{displayPrice price=$discount.value_real*-1}{else}{displayPrice price=$discount.value_tax_exc*-1}{/if}
            </span></td>
            <td class="cart_discount_delete">1</td>
            <td class="cart_discount_price">
                {if strlen($discount.code)}<a
                    href="{if $opc}{$link->getPageLink('order-opc', true)|escape:'htmlall':'UTF-8'}{else}{$link->getPageLink('order', true)|escape:'htmlall':'UTF-8'}{/if}?deleteDiscount={$discount.id_discount}"
                    class="cart_quantity_delete_discount" title="{l s='Delete' mod='onepagecheckout'}"></a>{/if}<br />
                <span class="price-discount price">{if !$priceDisplay}{displayPrice price=$discount.value_real*-1}{else}{displayPrice price=$discount.value_tax_exc*-1}{/if}</span>
            </td>
        </tr>
        {/foreach}
    </tbody>
    {/if}
<div id="tfoot_static_underlay" class="sticky_underlay"></div>
<tfoot id="tfoot_static">
<tr class="cart_voucher_block">
    <td colspan="{$colspan+1}" id="cart_voucher" class="cart_voucher">
        {if $voucherAllowed}
            {if isset($errors_discount) && $errors_discount}
                <ul class="error">
                    {foreach $errors_discount as $k=>$error}
                        <li>{$error|escape:'htmlall':'UTF-8'}</li>
                    {/foreach}
                </ul>
            {/if}
            <div id="opc_voucher_errors" class="perm-error" style="display: none"></div>
            <form action="{if $opc}{$link->getPageLink('order-opc.php', true)|escape:'htmlall':'UTF-8'}{else}{$link->getPageLink('order.php', true)|escape:'htmlall':'UTF-8'}{/if}"
                  method="post" id="voucher">
                <fieldset>
                    <h4><label for="discount_name">{l s='Vouchers' mod='onepagecheckout'}</label></h4>

                    <input type="text" class="discount_name" id="discount_name" name="discount_name"
                           value="{if isset($discount_name) && $discount_name}{$discount_name}{/if}"/>

                    <input type="hidden" name="submitDiscount"/><input type="submit"
                                                                       name="submitAddDiscount"
                                                                       value="{l s='OK' mod='onepagecheckout'}"
                                                                       class="button"/>
                    {if $displayVouchers}
                        <br />
                        <h4 class="title_offers">{l s='Take advantage of our offers:' mod='onepagecheckout'}</h4>

                        <div id="display_cart_vouchers">
                            {foreach $displayVouchers as $voucher}
                                {if $voucher.code != ''}
                                    <span onclick="$('#discount_name').val('{$voucher.code|escape:'html':'UTF-8'}');return false;"
                                          class="voucher_name_opc">{$voucher.code|escape:'html':'UTF-8'}</span> - {/if}{$voucher.name|escape:'html':'UTF-8'}<br />
                            {/foreach}
                        </div>
                    {/if}
                </fieldset>
            </form>
        {/if}
        {if $show_option_allow_separate_package}
            <p style="margin-top: 10px">
                <input type="checkbox" name="allow_seperated_package" id="allow_seperated_package" {if $cart->allow_seperated_package}checked="checked"{/if} autocomplete="off"/>
                <label for="allow_seperated_package">{l s='Send available products first' mod='onepagecheckout'}</label>
            </p>
        {/if}
    </td>
</tr>
{if $use_taxes}
    {if $priceDisplay}
        <tr class="cart_total_products summary-line">
            <td colspan="{$colspan|intval}">{if $display_tax_label}{l s='Total products (tax excl.):' mod='onepagecheckout'}{else}{l s='Total products:' mod='onepagecheckout'}{/if}</td>
            <td class="price" id="total_product">{displayPrice price=$total_products}</td>
        </tr>
    {else}
        <tr class="cart_total_products summary-line">
            <td colspan="{$colspan|intval}">{if $display_tax_label}{l s='Total products (tax incl.):' mod='onepagecheckout'}{else}{l s='Total products:' mod='onepagecheckout'}{/if}</td>
            <td class="price" id="total_product">{displayPrice price=$total_products_wt}</td>
        </tr>
    {/if}
{else}
    <tr class="cart_total_products summary-line">
        <td colspan="{$colspan|intval}">{l s='Total products:' mod='onepagecheckout'}</td>
        <td class="price" id="total_product">{displayPrice price=$total_products}</td>
    </tr>
{/if}
<tr class="cart_total_voucher summary-line" {if $total_discounts == 0}style="display:none"{/if}>
    <td colspan="{$colspan|intval}">
        {if $use_taxes && $display_tax_label}
            {l s='Total vouchers (tax excl.):' mod='onepagecheckout'}
        {else}
            {l s='Total vouchers:' mod='onepagecheckout'}
        {/if}
    </td>
    <td class="price-discount price" id="total_discount">
        {if $use_taxes && !$priceDisplay}
            {assign var='total_discounts_negative' value=$total_discounts * -1}
        {else}
            {assign var='total_discounts_negative' value=$total_discounts_tax_exc * -1}
        {/if}
        {displayPrice price=$total_discounts_negative}
    </td>
</tr>
<tr class="cart_total_wrapping summary-line" {if $total_wrapping == 0}style="display: none;"{/if}>
    <td colspan="{$colspan|intval}">
        {if $use_taxes}
            {if $display_tax_label}{l s='Total gift-wrapping (tax incl.):' mod='onepagecheckout'}{else}{l s='Total gift-wrapping:' mod='onepagecheckout'}{/if}
        {else}
            {l s='Total gift-wrapping:' mod='onepagecheckout'}
        {/if}
    </td>
    <td class="price-discount price" id="total_wrapping">
        {if $use_taxes}
            {if $priceDisplay}
                {displayPrice price=$total_wrapping_tax_exc}
            {else}
                {displayPrice price=$total_wrapping}
            {/if}
        {else}
            {displayPrice price=$total_wrapping_tax_exc}
        {/if}
    </td>
</tr>
{if $total_shipping_tax_exc <= 0 && !isset($virtualCart)}
    <tr class="cart_total_delivery summary-line">
        <td colspan="{$colspan|intval}">{l s='Shipping:' mod='onepagecheckout'}</td>
        <td class="price" id="total_shipping">{l s='Free Shipping!' mod='onepagecheckout'}</td>
    </tr>
{else}
    {if $use_taxes}
        {if $priceDisplay}
            <tr class="cart_total_delivery summary-line" {if $total_shipping_tax_exc <= 0} style="display:none;"{/if}>
                <td colspan="{$colspan|intval}">{if $display_tax_label}{l s='Total shipping (tax excl.):' mod='onepagecheckout'}{else}{l s='Total shipping:' mod='onepagecheckout'}{/if}</td>
                <td class="price" id="total_shipping">{displayPrice price=$total_shipping_tax_exc}</td>
            </tr>
        {else}
            <tr class="cart_total_delivery summary-line"{if $total_shipping <= 0} style="display:none;"{/if}>
                <td colspan="{$colspan|intval}">{if $display_tax_label}{l s='Total shipping (tax incl.):' mod='onepagecheckout'}{else}{l s='Total shipping:' mod='onepagecheckout'}{/if}</td>
                <td class="price" id="total_shipping">{displayPrice price=$total_shipping}</td>
            </tr>
        {/if}
    {else}
        <tr class="cart_total_delivery summary-line"{if $total_shipping_tax_exc <= 0} style="display:none;"{/if}>
            <td colspan="{$colspan|intval}">{l s='Total shipping:' mod='onepagecheckout'}</td>
            <td class="price" id="total_shipping">{displayPrice price=$total_shipping_tax_exc}</td>
        </tr>
    {/if}
{/if}
{if $use_taxes}
    <tr class="cart_tax_exc_price summary-line">
        <td colspan="{$colspan|intval}">{l s='Total (tax excl.):' mod='onepagecheckout'}</td>
        <td class="price" id="total_price_without_tax">{displayPrice price=$total_price_without_tax}</td>
    </tr>
    <tr class="cart_total_tax summary-line">
        <td colspan="{$colspan|intval}">{l s='Total tax:' mod='onepagecheckout'}</td>
        <td class="price" id="total_tax">{displayPrice price=$total_tax}</td>
    </tr>
{/if}


{* Fee: payment fee update *}

<tr class="cart_payment_fee summary-line" style="display: none;">
    <td colspan="{$colspan|intval}">{l s='Payment fee' mod='onepagecheckout'}</td>
            <td colspan="2" class="price" id="total_payment_fee"></td> 
</tr>

<tr class="cart_final_price with_fee summary-line" style="display: none;">
    <td colspan="{$colspan|intval}">{l s='Total:' mod='onepagecheckout'}</td>
        <td class="price total_price_container" id="total_price_container">
            {if $use_taxes}
            <span id="total_price_with_fee">{displayPrice price=$total_price}</span>
            {else}
                <span id="total_price_with_fee">{displayPrice price=$total_price_without_tax}</span>                
            {/if}
        </td>
</tr>
{* end of payment fee update *}

<tr class="cart_final_price orig summary-line"> {* Fee: added orig class *}
    <td colspan="{$colspan|intval}">{l s='Total:' mod='onepagecheckout'}</td>
        <td class="price total_price_container" id="total_price_container">
            {if $use_taxes}
            <span id="total_price">{displayPrice price=$total_price}</span>
            {else}
                <span id="total_price">{displayPrice price=$total_price_without_tax}</span>
            {/if}
        </td>
</tr>
</tfoot>
</table>
</div>



<div id="HOOK_SHOPPING_CART">{$HOOK_SHOPPING_CART}</div>

    {if !$opc_config.two_column_opc && (!$opc_config.cart_summary_bottom || ($order_process_type==0 && (!$smarty.get.step || $smarty.get.step != '1')))}
            <p class="cart_navigation">
        <b>
            {if isset($onlyCartSummary)}<a
                    href="{$link->getPageLink('order.php', true)|escape:'htmlall':'UTF-8'}?step=1{if $back}&amp;back={$back}{/if}"
                    class="exclusive" title="{l s='Next' mod='onepagecheckout'}">{l s='Next' mod='onepagecheckout'} &raquo;</a>{/if}
            <a href="{if (isset($smarty.server.HTTP_REFERER) && strstr($smarty.server.HTTP_REFERER, '{$opckt_script_name}')) || !isset($smarty.server.HTTP_REFERER)}{$link->getPageLink('index.php')|escape:'htmlall':'UTF-8'}{else}{$smarty.server.HTTP_REFERER|escape:'htmlall':'UTF-8'|secureReferrer}{/if}"
               title="{l s='Continue shopping' mod='onepagecheckout'}">
                &laquo; {l s='Continue shopping' mod='onepagecheckout'}</a>{if !isset($onlyCartSummary)}
            &nbsp; {l s='or fill in the form below to finish your order.' mod='onepagecheckout'}{/if}
        </b>
    </p>
    <p class="clear"></p>
    {/if}
    <p class="cart_navigation_extra">
        <span id="HOOK_SHOPPING_CART_EXTRA">{$HOOK_SHOPPING_CART_EXTRA}</span>
    </p>


    {if isset($onlyCartSummary)}
    <script type="text/javascript">
        // <![CDATA[
        var countries = new Array();
        idSelectedCountry = {if isset($guestInformations) && $guestInformations.id_state}{$guestInformations.id_state|intval}{else}{if ($def_state>0)}{$def_state|intval}{else}false{/if}{/if};
        idSelectedCountry_invoice = {if isset($guestInformations) && isset($guestInformations.id_state_invoice)}{$guestInformations.id_state_invoice|intval}{else}{if ($def_state_invoice>0)}{$def_state_invoice|intval}{else}false{/if}{/if};
            {if isset($countries)}
                {foreach from=$countries item='country'}
                    {if isset($country.states) && $country.contains_states}
                    countries[{$country.id_country|intval}] = new Array();
                        {foreach from=$country.states item='state' name='states'}
                        countries[{$country.id_country|intval}].push({ldelim}'id':'{$state.id_state|intval}', 'name':'{$state.name|escape:'htmlall':'UTF-8'}'{rdelim});
                        {/foreach}
                    {/if}
                {/foreach}
            {/if}
        //]]>
    </script>

        {if $isVirtualCart && $opc_config.virtual_no_delivery}
        <input type="hidden" name="id_country" id="id_country"
               value="{if isset($opc_config.online_country_id) && $opc_config.online_country_id > 0}{$opc_config.online_country_id|intval}{else}8{/if}"/> {* 8=France, we choose some non-states country *}
            {else}
        <p class="required select"
           {if !isset($opc_config.country_delivery) || !$opc_config.country_delivery}style="display: none;"{/if}>
            <label for="id_country">{l s='Country' mod='onepagecheckout'}</label>
            <select name="id_country" id="id_country">
                <option value="">-</option>
                {foreach from=$countries item=v}
                    <option value="{$v.id_country}" {if (isset($guestInformations) AND $guestInformations.id_country == $v.id_country) OR ($def_country == $v.id_country ) OR (!isset($guestInformations) && ($def_country==0) && $sl_country == $v.id_country)}
                            selected="selected"{/if}>{$v.name|escape:'htmlall':'UTF-8'}</option>
                {/foreach}
            </select>
        </p>

        {/if}

    <p class="required id_state select">
        <label for="id_state">{l s='State' mod='onepagecheckout'}</label>
        <select name="id_state" id="id_state">
            <option value="">-</option>
        </select>
    </p>


    {include file="$opc_templates_path/order-carrier.tpl"} {*TODO: check this!*}
    {/if}



{/if}

