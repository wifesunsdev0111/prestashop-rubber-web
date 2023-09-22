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

{if $PS_CATALOG_MODE}
<h2 id="cart_title">{l s='Your shopping cart' mod='onepagecheckout'}</h2>
<p class="warning">{l s='This store has not accepted your new order.' mod='onepagecheckout'}</p>
    {else}
<script type="text/javascript">
    // <![CDATA[
    var baseDir = '{$base_dir_ssl}';
    var imgDir = '{$img_dir}';
    var authenticationUrl = '{$link->getPageLink("authentication", true)|addslashes}';
    {*var orderOpcUrl = '{$opckt_script}';*}
    var orderOpcUrl = '{$link->getPageLink("order-opc", true)|addslashes}';
    var historyUrl = '{$link->getPageLink("history", true)|addslashes}';
    var guestTrackingUrl = '{$link->getPageLink("guest-tracking", true)|addslashes}';
    var addressUrl = '{$link->getPageLink("address", true, NULL, "back=order-opc.php")|addslashes}';
    var orderProcess = 'order-opc';
    var guestCheckoutEnabled = {$PS_GUEST_CHECKOUT_ENABLED|intval};
    var currencySign = '{$currencySign|html_entity_decode:2:"UTF-8"}';
    var currencyRate = '{$currencyRate|floatval}';
    var currencyFormat = '{$currencyFormat|intval}';
    var currencyBlank = '{$currencyBlank|intval}';
    var displayPrice = {$priceDisplay|intval};
    var taxEnabled = {$use_taxes|intval};
    var conditionEnabled = {$conditions|intval};
    var countries = new Array();
    var countriesNeedIDNumber = new Array();
    var countriesNeedZipCode = new Array();
    var vat_management = {$vat_management|intval};


    var txtWithTax = "{l s='(tax incl.)' mod='onepagecheckout'}";
    var txtWithoutTax = "{l s='(tax excl.)' mod='onepagecheckout'}";
    var txtHasBeenSelected = "{l s='has been selected' mod='onepagecheckout'}";
    var txtNoCarrierIsSelected = "{l s='No carrier has been selected' mod='onepagecheckout'}";
    var txtNoCarrierIsNeeded = "{l s='No carrier is needed for this order' mod='onepagecheckout'}";
    var txtConditionsIsNotNeeded = "{l s='No terms of service must be accepted' mod='onepagecheckout'}";
    var txtTOSIsAccepted = "{l s='Terms of service is accepted' mod='onepagecheckout'}";
    var txtTOSIsNotAccepted = "{l s='Terms of service have not been accepted' mod='onepagecheckout'}";
    var txtThereis = "{l s='There is' mod='onepagecheckout'}";
    var txtErrors = "{l s='error(s)' mod='onepagecheckout'}";
    var txtDeliveryAddress = "{l s='Delivery address' mod='onepagecheckout'}";
    var txtInvoiceAddress = "{l s='Invoice address' mod='onepagecheckout'}";
    var txtModifyMyAddress = "{l s='Modify my address' mod='onepagecheckout'}";
    var txtInstantCheckout = "{l s='Instant checkout' mod='onepagecheckout'}";
    var errorCarrier = "{$errorCarrier|@addcslashes:'\''}";
    var errorTOS = "{$errorTOS|@addcslashes:'\''}";
    var errorPayment = "{l s='Please select payment method.' mod='onepagecheckout'}";
    var checkedCarrier = "{if isset($checked)}{$checked}{else}0{/if}";

    var txtProduct = "{l s='product' mod='onepagecheckout'}";
    var txtProducts = "{l s='products' mod='onepagecheckout'}";
    var txtFreePrice = "{l s='Free!' mod='onepagecheckout'}";
    {if isset($onlyCartSummary)}
      var onlyCartSummary = '1';
    {else}
      var onlyCartSummary = '0';
    {/if}

    var addresses = new Array();
    var isLogged = {$isLogged|intval};
    var isGuest = {$isGuest|intval};
    var isVirtualCart = {$isVirtualCart|intval};
    var isPaymentStep = {$isPaymentStep|intval};


    var opc_scroll_cart = "{$opc_config.scroll_cart|intval && $productNumber|intval}";
    var opc_scroll_header_cart = "{$opc_config.scroll_header_cart|intval && $productNumber|intval}";
    var opc_scroll_info = "1"; {*allways turned on-configurable option removed; if scrolling would be turned off, any addStuff module would be sufficient*}
    var opc_scroll_summary = "{$opc_config.scroll_summary|intval && $productNumber|intval}";
    var opc_scroll_products = "{$opc_config.scroll_products|intval}";
    var opc_page_fading = "{$opc_config.page_fading|intval && $productNumber|intval}";
    var opc_fading_duration = "{$opc_config.fading_duration|intval}";
    var opc_fading_opacity = "{$opc_config.fading_opacity|intval}";
    var opc_sample_values = "{$opc_config.sample_values|intval}";
    var opc_sample_to_placeholder = ('{$opc_config.sample_to_placeholder|intval}' == '1') ? true: false;
    var opc_inline_validation = "{$opc_config.inline_validation|intval}";
    var opc_validation_checkboxes = "{$opc_config.validation_checkboxes|intval}";
    var opc_display_info_block = '{$opc_config.display_info_block|intval}';
    var opc_info_block_content = '{$info_block_content|regex_replace:"/[\r\t\n]/":" "|regex_replace:"/\'/":"\\'"}';
    var opc_before_info_element = '{$opc_config.before_info_element|escape:"htmlall":"UTF-8"}';
    var opc_check_number_in_address = '{$opc_config.check_number_in_address|intval}';
    var opc_capitalize_fields = '{$opc_config.capitalize_fields|escape:"htmlall":"UTF-8"}';
    var opc_relay_update = '{$opc_config.update_payments_relay|intval}';
    var opc_hide_carrier = '{$opc_config.hide_carrier|intval}';
    var opc_hide_payment = '{$opc_config.hide_payment|intval}';
    var opc_override_checkout_btn = '{$opc_config.override_checkout_btn|intval}';
    var ps_guest_checkout_enabled = '{$PS_GUEST_CHECKOUT_ENABLED|intval}'
    var opc_display_password_msg = '{$opc_config.display_password_msg|intval}';
    var opc_live_zip = '{$opc_config.live_zip|intval}';
    var opc_live_city = '{$opc_config.live_city|intval}';
    var opc_cart_summary_bottom = '{$opc_config.cart_summary_bottom|intval}';
    var opc_above_confirmation_message = '{$opc_config.above_confirmation_message|intval}';
    var opc_order_detail_review = '{$opc_config.order_detail_review|intval}';
    var opc_animate_fields_padding = '{$opc_config.animate_fields_padding|intval}';
    var opc_two_column_opc = '{$opc_config.two_column_opc|intval}';
    var opc_three_column_opc = ('{$opc_config.three_column_opc|intval}' == '1') ? true: false;
    var opc_cookie_cache = '{$opc_config.cookie_cache|intval}';
    var opc_move_cgv = '{$opc_config.move_cgv|intval}';
    var opc_move_message = '{$opc_config.move_message|intval}';
    var opc_responsive_layout = '{$opc_config.responsive_layout|intval}';
    var opc_company_based_vat = '{$opc_config.company_based_vat|intval}';
    var opc_save_account_overlay = '{$opc_config.save_account_overlay|intval}';
    var opc_payment_radio_buttons = '{$opc_config.payment_radio_buttons|intval}';
    var opc_invoice_first = false; {*('{$opc_config.invoice_first|intval}' == '1') ? true : false;*}
    var opc_default_ps_carriers = ('{$opc_config.default_ps_carriers|intval}' == '1') ? true : false;

    // Some more translations
    var ntf_close = "{l s='Close' mod='onepagecheckout'}";
    var ntf_number_in_address_missing = "{l s='Number in address is missing, are you sure you don\'t have one?' mod='onepagecheckout'}";
    var freeShippingTranslation = "{l s='Free shipping!' mod='onepagecheckout'}";
    var freeProductTranslation = "{l s='Free!' mod='onepagecheckout'}";
    //]]>
</script>

    <div id="opc_checkout" class="{if version_compare($smarty.const._PS_VERSION_,'1.6','>')}ps16{else}ps15{/if}">
    {if $productNumber}
    <!-- Shopping Cart -->
        {if !$twoStepCheckout && !$opc_config.cart_summary_bottom}
            <span class="summary-top"></span>
            {include file="$opc_templates_path/shopping-cart.tpl"}
        {/if}
    <!-- END Shopping Cart -->
    <!-- Create account / Guest account / Login block -->
    {include file="$opc_templates_path/order-opc-new-account.tpl"}
    <!-- END Create account / Guest account / Login block -->

    <div id="shipping-payment-block"> {* closing div in order-payment *}
        <div class="inner-table"> {* closing div in order-payment *}
    <!-- Carrier -->
        {if $opc_config.default_ps_carriers}
            {include file="$opc_templates_path/order-carrier-def.tpl"}
        {else}
            {include file="$opc_templates_path/order-carrier.tpl"}
        {/if}

    <!-- END Carrier -->

    <!-- Payment -->
    {include file="$opc_templates_path/order-payment.tpl"}
    <!-- END Payment -->
        {else}
    <h2>{l s='Your shopping cart' mod='onepagecheckout'}</h2>
    <p class="warning">{l s='Your shopping cart is empty.' mod='onepagecheckout'}</p>
    {/if}
        </div>
{/if}
