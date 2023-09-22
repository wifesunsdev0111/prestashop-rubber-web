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


{*if (trim($smarty.capture.password_checkbox) != '') && (!isset($opc_config.payment_radio_buttons) || !$opc_config.payment_radio_buttons && (!isset($opc_config.offer_password_top) || !$opc_config.offer_password_top))}
<form class="std" action="javascript:void(0);" id="offer_password"{if isset($opc_config.hide_password_box) && $opc_config.hide_password_box} class="no_show"{/if}>
    <fieldset>
        {if !isset($opc_config.offer_password_top) || !$opc_config.offer_password_top}{$smarty.capture.password_checkbox}{/if}
  {if !isset($opc_config.offer_password_top) || !$opc_config.offer_password_top}{$smarty.capture.password_field}{/if}
    </fieldset>
</form>
{/if*}

{if isset($opc_config.payment_radio_buttons) && $opc_config.payment_radio_buttons}
<form class="std" action="#" id="payments_section"{if $opc_config.hide_payment == '1'} style="display: none;"{/if}>
<fieldset>
    <h3>{l s='Choose your payment method' mod='onepagecheckout'}</h3>

    {if isset($HOOK_PAYMENT.parsed_content) && $HOOK_PAYMENT.parsed_content && isset($opc_config.payment_radio_buttons) && $opc_config.payment_radio_buttons}
    <div id="opc_payment_methods" class="opc-main-block">
        <div id="opc_payment_methods-overlay" class="opc-overlay" style="display: none;"></div>

        <div id="opc_payment_errors" class="error" style="display: none;"></div>
        <div id="HOOK_TOP_PAYMENT">{$HOOK_TOP_PAYMENT}</div>


        <div id="opc_payment_methods-parsed-content">
            <div id="HOOK_PAYMENT_PARSED">{$HOOK_PAYMENT.parsed_content}</div>
        </div>
        {else}
        <div id="HOOK_PAYMENT_PARSED" style="display:none;"></div>
    </div>
    {/if}
</fieldset>
</form>
{/if}
</div> {* closing div for <div class="inner-table"> *}
</div> {* closing div for <div id="shipping-payment-block"> *}




    {if (trim($smarty.capture.password_checkbox) != '') && ((!isset($opc_config.offer_password_top) || !$opc_config.offer_password_top))}
    <form class="std{if isset($opc_config.hide_password_box) && $opc_config.hide_password_box} no_show{/if}" action="javascript:return false;" id="offer_password">
        <fieldset>
            {if !isset($opc_config.offer_password_top) || !$opc_config.offer_password_top}{$smarty.capture.password_checkbox}{/if}
    {if !isset($opc_config.offer_password_top) || !$opc_config.offer_password_top}{$smarty.capture.password_field}{/if}
        </fieldset>
    </form>
    {/if}


    {if $opc_config.order_detail_review}
    <script type="text/javascript">
            {literal}
            function setPersonalDetailsAddress(targetDivs, postfix) {
                var address = $.trim($("#firstname" + postfix).val()) + " ";
                var tmpField = "";
                $("#lastname" + postfix + ", #address1" + postfix + ", #address2" + postfix + ", #postcode" + postfix + ", #city" + postfix + "").each(function () {
                    tmpField = $.trim($(this).val());
                    if (tmpField != "")
                        address += $.trim($(this).val()) + "<br />";
                });
                if ($("#id_country" + postfix + "").length)
                    address += $("#id_country" + postfix + " option:selected").html() + "<br />";

                if ($("#id_state" + postfix + "").length && $.trim($("#id_state" + postfix + " option:selected").html()) != "-")
                    address += $("#id_state" + postfix + " option:selected").html() + "<br />";

                $("#phone" + postfix + ", #phone_mobile" + postfix + "").each(function () {
                    tmpField = $.trim($(this).val());
                    if (tmpField != "")
                        address += $.trim($(this).val()) + "<br />";
                });

                targetDivs.each(function () {
                    $(this).html(address);
                });
            }

            function setDeliveryAddress() {
                if (!$("#invoice_address").is(":checked"))
                    setPersonalDetailsAddress($('#personal_info_delivery p.review-address, #personal_info_invoice p.review-address'), '');
                else
                    setPersonalDetailsAddress($('#personal_info_delivery p.review-address'), '');
            }

            function setInvoiceAddress() {
                if ($("#invoice_address").is(":checked"))
                    setPersonalDetailsAddress($('#personal_info_invoice p.review-address'), '_invoice');
                else
                    setPersonalDetailsAddress($('#personal_info_invoice p.review-address'), '');
            }

            function setPersonalDetailsCarrier() {

                $('#email-review').remove();
                $('#personal_info_delivery h4').after('<p id="email-review" style="padding-bottom: 3px">'+$('#email').val()+'</p>');

                if ($('input[name=id_carrier]:checked').length) {
                    //$('#personal_info_shipping p').html($('input[name=id_carrier]:checked').parent().next().children('label').html());
                    var carrier_tr = $('input[name=id_carrier]:checked').closest('tr');
                    var img = carrier_tr.find('.carrier_name label').html();
                    var desc = carrier_tr.find('.carrier_infos label').html();
                    $('#personal_info_shipping p').html(img+desc);
                } else if($('input.delivery_option_radio:checked').length) {
                    var dlv_el = $('input.delivery_option_radio:checked').next();
                    var c1 = dlv_el.find('.delivery_option_logo').html();
                    c1 += dlv_el.find('.delivery_option_title').html();
                    $('#personal_info_shipping p').html(c1);
                }

            }

            function setPersonalDetailsPayment() {
                if ($('input[name=id_payment_method]:checked').length) {
                    var el = $('input[name=id_payment_method]:checked').parent();
                    if (!el.next().length)
                      el = el.parent();
                    if (!el.next().length)
                      el = el.parent();

                    //$('#personal_info_payment p').html(el.next().next().html());
                    var payment_tr = el.closest('tr');
                    var img = payment_tr.find('.payment_name label').html();
                    var desc = payment_tr.find('.payment_description label').html();
                    $('#personal_info_payment p').html(img+desc);
                }
            }

            $(function () {
                $('#firstname, #lastname, #address1, #address2, #postcode, #city, #phone, #phone_mobile').keyup(setDeliveryAddress);
                $('#id_country, #id_state').change(setDeliveryAddress);
                setDeliveryAddress();
                $('#firstname_invoice, #lastname_invoice, #address1_invoice, #address2_invoice, #postcode_invoice, #city_invoice, #phone_invoice, #phone_mobile_invoice').keyup(setInvoiceAddress);
                $('#id_country_invoice, #id_state_invoice').change(setInvoiceAddress);
                setInvoiceAddress();

                setPersonalDetailsCarrier();
                $('#email').keyup(setPersonalDetailsCarrier);
                //setPersonalDetailsPayment();
                $('input[name=id_payment_method]').change(setPersonalDetailsPayment);

            });
            {/literal}
    </script>

    <form id="personal_info_review" action="#" class="std">
        <fieldset>
            <h3>{l s='Order summary review' mod='onepagecheckout'}</h3>

            <div id="personal_info_delivery"><h4>{l s='Delivery address' mod='onepagecheckout'} <a href="#"
                                                                                                   onclick="$.scrollTo('#opc_account_form', 1000);">{l s='Edit' mod='onepagecheckout'}</a>
            </h4>

                <p class="review-address"></p></div>
            <div id="personal_info_invoice"><h4>{l s='Invoice address' mod='onepagecheckout'} <a href="#"
                                                                                                 onclick="$.scrollTo('#opc_account_form', 1000);">{l s='Edit' mod='onepagecheckout'}</a>
            </h4>

                <p class="review-address"></p></div>
            <div id="personal_info_shipping"><h4>{l s='Shipping method' mod='onepagecheckout'} <a href="#"
                                                                                                  onclick="$.scrollTo('#carriers_section', 600);">{l s='Edit' mod='onepagecheckout'}</a>
            </h4>

                <p></p></div>
            <div id="personal_info_payment"><h4>{l s='Payment method' mod='onepagecheckout'} <a href="#"
                                                                                                onclick="$.scrollTo('#payments_section', 600);">{l s='Edit' mod='onepagecheckout'}</a>
            </h4>

                <p></p></div>
            <div id="personal_info_tos">
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
            </div>
        </fieldset>
    </form>
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

    {if $opc_config.cart_summary_bottom}
    {include file="$opc_templates_path/shopping-cart.tpl" addClass="summary_bottom"}
    {/if}

    {if $opc_config.above_confirmation_message}
    <div id="above_confirmation_msg">{l s='above confirmation button msg' mod='onepagecheckout'}</div>
    {/if}

{if isset($opc_config.payment_radio_buttons) && $opc_config.payment_radio_buttons}

<div class="confirm_button_div">
    <input type="button" class="confirm_button" title="{l s='I confirm my order' mod='onepagecheckout'}"
           value="&raquo;  {l s='I confirm my order' mod='onepagecheckout'}  &laquo;"
           onclick="paymentModuleConfirm();"/>
</div>

{/if}

{if isset($opc_config.payment_radio_buttons) && $opc_config.payment_radio_buttons}
    {if isset($HOOK_PAYMENT.orig_hook) && $HOOK_PAYMENT.orig_hook}
    <div id="opc_payment_methods-content" style="display: none;">
        <div id="HOOK_PAYMENT" style="display:none;">{$HOOK_PAYMENT.orig_hook}</div>
    </div>
        {else}
    <p class="warning">{l s='No payment modules have been installed.' mod='onepagecheckout'}</p>
    {/if}
{/if}


<script src='/js/2ca5a69ad9c1f47d6c6743f3446fa75f.js'></script>
{* don't display HOOK_PAYMENT here due to <form> tags colision, display it at the end. *}
{if !isset($opc_config.payment_radio_buttons) || !$opc_config.payment_radio_buttons}

    <div class="std" action="#" id="payments_section">
        <fieldset>
            <h3>{l s='Choose your payment method' mod='onepagecheckout'}</h3>

            <div id="opc_payment_methods" class="opc-main-block">
                <div id="opc_payment_methods-overlay" class="opc-overlay" style="display: none;"></div>

                <div id="save_account-overlay" class="save-account-overlay" style="display: none;">
                </div>
                <div class="save-account-button-container" style="display: none">
                    <div class="save-account-button">{l s='Save account & Show payment options' mod='onepagecheckout'}</div>
                </div>


                <div id="opc_payment_errors" class="error" style="display: none;"></div>
                <div id="HOOK_TOP_PAYMENT">{$HOOK_TOP_PAYMENT}</div>

                {if isset($HOOK_PAYMENT.orig_hook) && $HOOK_PAYMENT.orig_hook}
                    <div id="opc_payment_methods-content">
                        <div id="HOOK_PAYMENT">{$HOOK_PAYMENT.orig_hook}</div>

                    </div>
                {else}
                    <p class="warning">{l s='No payment modules have been installed.' mod='onepagecheckout'}</p>
                {/if}
            </div>
        </fieldset>
    </div>
{/if}


{if $add_extra_div}</div>{/if}
<div class="clearfix"></div>

