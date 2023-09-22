/*
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
 */

$.browser.chrome = /chrome/.test(navigator.userAgent.toLowerCase());

jQuery.fn.idle = function (time) {
    return this.each(function () {
        var i = $(this);
        i.queue(function () {
            setTimeout(function () {
                i.dequeue();
            }, time);
        });
    });
};

$.support.placeholder = (function () {
    var i = document.createElement("input");
    return typeof i.placeholder !== 'undefined';
}());

$.fn.scrollToElement = function (element, time, force_scroll) {
    var scroll_pos = $(element).offset().top
    if (isFixedSummary)
        scroll_pos -= $('#tfoot_static').height();
    if ((typeof force_scroll !== "undefined" && force_scroll) || (window.pageYOffset > scroll_pos))
    {
        if ($.browser.chrome) {
            $('body').animate({
                scrollTop: scroll_pos - 5
            }, time);
        } else {
            $.scrollTo(scroll_pos - 5, time); // <-- doesn't seem to work in Chrome
        }
    }
}

var scroll_cart, scroll_summary, scroll_products, scroll_info, scroll_header_cart;

function initSettings() {
    // opc_scroll_cart - global JS variable set in order-opc.tpl
    scroll_cart = (typeof opc_scroll_cart !== "undefined" && opc_scroll_cart == "1");
    scroll_summary = (typeof opc_scroll_summary !== "undefined" && opc_scroll_summary == "1");
    scroll_products = (typeof opc_scroll_products !== "undefined" && opc_scroll_products == "1");
    scroll_info = (typeof opc_scroll_info !== "undefined" && opc_scroll_info == "1") && _isInfoBlockEnabled();
    scroll_header_cart = (typeof opc_scroll_header_cart !== "undefined" && opc_scroll_header_cart == "1" && $("#header_user ul#header_nav").length > 0);
}

function str_repeat (input, multiplier) {
    var y = '';
    while (true) {
        if (multiplier & 1) {
            y += input;
        }
        multiplier >>= 1;
        if (multiplier) {
            input += input;
        }
        else {
            break;
        }
    }
    return y;
}

/**
 * Translate a string option_delivery identifier ('24,3,') in a int (3240002000)
 *
 * The  option_delivery identifier is a list of integers separated by a ','.
 * This method replace the delimiter by a sequence of '0'.
 * The size of this sequence is fixed by the first digit of the return
 *
 * @return int
 */
function Cart_intifier(carrier_str)
{
    elm = carrier_str.split(",");
    mmax = Math.max.apply( Math, elm );
    mmax_str_len = (mmax+"").length;
    return mmax_str_len + elm.join(str_repeat('0', mmax_str_len + 1));
}

/**
 * Translate a int option_delivery identifier (3240002000) in a string ('24,3,')
 */
function Cart_desintifier(carrier_int)
{
    delimiter_len = carrier_int[0]*1;
    carrier_int = carrier_int.substr(1);
    elm = carrier_int.split(str_repeat('0', delimiter_len + 1));
    return elm.join();
}


function moveTosAndMessage() {
    if (typeof opc_move_cgv !== 'undefined' && jQuery.trim(opc_move_cgv) == "1") {
        //$('form#offer_password + #opc_tos_errors').remove();
        //$('form#offer_password + input#cgv').remove();
        $('#tos_moved').html('');
        $('#tos_moved').append($('#opc_delivery_methods #opc_tos_errors'));
        $('#tos_moved').append($('#opc_delivery_methods input#cgv').closest('p'));
    }

    if (typeof opc_move_message !== 'undefined' && jQuery.trim(opc_move_message) == "1") {
        $('#message_moved').html('');
        $('#message_moved').append($('#carriers_section #message_container'));
    }
}

function updateCarrierList(json) {
    var html = json.carrier_block;

    $('form#carriers_section').replaceWith(html);
    if ($.support.placeholder) {
      $("#order_msg_placeholder_fallback").hide();
    }
    bindInputs();
    /* update hooks for carrier module */
    $('#HOOK_BEFORECARRIER').html(json.HOOK_BEFORECARRIER);

    moveTosAndMessage();
}

// Definition of fields on payment form, which need to be saved across payment methods refresh (e.g. offline credit card)
var payment_fields = [
    'input.stripe-card-number',
    'input.stripe-card-cvc',
    'select.stripe-card-expiry-month',
    'select.stripe-card-expiry-year',
    '#authorizeaim_form #fullname',
    '#authorizeaim_form #cardType',
    '#authorizeaim_form #cardnum',
    '#authorizeaim_form #x_exp_date_m',
    '#authorizeaim_form select[name=x_exp_date_y]',
    '#authorizeaim_form #x_card_code',
    'input#braintree-card-number',
    'input#braintree-card-cvc',
    'select#braintree-card-expiry-month',
    'select#braintree-card-expiry-year',
    '#paypalpro_cardnum',
    'select#paypalpro_cardType',
    'select#paypalpro_exp_date_m',
    '#paypalpro_form select[name=x_exp_date_m]',
    '#paypalpro_form select[name=x_exp_date_y]',
    '#paypalpro_card_code'
];

// This one would store text-value-selector : original (prior to refresh) value
var payment_fields_values = {};

function savePaymentFormValues() {
    $.each(payment_fields, function (index, value) {
        payment_fields_values[value] = $(value).val();
    });
}

function restorePaymentFormValues() {
    $.each(payment_fields_values, function (index, value) {
        $(index).val(value);
    });
}

function moveComplexPaymentForms() {
    // StripeJS by M.Bellini
    if ($('#stripe-form-container').length && $('#stripe-payment-form').length)
        $('#stripe-form-container').append($('#stripe-payment-form'));
    // AuthorizeAIM by Prestashop
    if ($('#authorizeaim-form-container').length && $('#authorizeaim_form').length)
        $('#authorizeaim-form-container').append($('#authorizeaim_form'));
    // StripeJS by NTS - no popup version (emb_payment.tpl)
    if ($('#stripejs-nts-form-container').length && $('#stripe-payment-form').length)
        $('#stripejs-nts-form-container').append($('#stripe-payment-form').closest('div'));

}

function updatePaymentsHooks(json) {
    $('#HOOK_TOP_PAYMENT').html(json.HOOK_TOP_PAYMENT);

    var isPaymentParsing = $('input[name=id_payment_method]').length;
    if (isPaymentParsing) {
        var link_id_1 = $('input[name=id_payment_method]:checked').val();
    }

    if (typeof link_id_1 === "undefined")
        link_id_1 = 'opc_pid_0';

    savePaymentFormValues();

    $('#opc_payment_methods-parsed-content div#HOOK_PAYMENT_PARSED').html(json.HOOK_PAYMENT.parsed_content);
    $('#opc_payment_methods-content div#HOOK_PAYMENT').html(json.HOOK_PAYMENT.orig_hook);
    
    moveComplexPaymentForms();
    restorePaymentFormValues();

    // select lastly used (just by its order ID)
    if (isPaymentParsing && $('input[value=' + link_id_1 + ']').length) {
        $('input[value=' + link_id_1 + ']').attr("checked", "checked");
        var selected_line = $('input[name=id_payment_method]:checked').closest('tr'); 
        selected_line.next('.cc-form').show();
    }

    setPaymentModuleHandler();
}

function updatePaymentMethods(json) {

    updatePaymentsHooks(json);

    // if free order or (single payment method + config option turned on), hide whole block
    var paymentStr = json.HOOK_PAYMENT.orig_hook;
    if (paymentStr !== undefined && ((paymentStr.indexOf("javascript:confirmFreeOrder") > 0 && opc_payment_radio_buttons == "1") ||
        (paymentStr.indexOf("opc_pid_0") > 0 && paymentStr.indexOf("opc_pid_1") < 0 && opc_hide_payment == "1")))
        $('#payments_section:visible').hide();
    else {
        $('#payments_section:hidden').show();
        $('#opc_payment_methods-overlay').fadeOut('slow');
    }
    
    $('#opc_payment_methods').html($('#opc_payment_methods-content').html());
    $('#HOOK_PAYMENT').show();
    $('.confirm_button').click(function() {
        alert("Please click one of the Payment Method buttons in order to confirm and proceed to payment.");
    })
    
    //setPaymentModuleHandler();
    processing_payment = false;// Enable payment buttons - for ePay modal window
}

function setField(fieldname, value) {
    $(fieldname).val(value);
}

function fadeAndSet(fieldname, duration, opacity, value) {
    $(fieldname).fadeTo(duration, opacity, function () {
        $(fieldname).val(value);
        if (opc_inline_validation == "1" && value != "")
            validateFieldAndDisplayInline($(this));
    });
}

function animateDlvAddress(address, dont_pre_save_address) {
    var start = 600;
    var inc = 70;
    var i = 0;
    var opacity = 0.2;
    var fields = ["#company", "#vat_number", "#dni", "#firstname", "#lastname", "#address1", "#address2", "#postcode",
        "#city", "#id_country", "#id_state", "#other", "#phone", "#phone_mobile"];

    $("#id_country").val(address['id_country']);  // pre-cache id_country for zipCheck method in animate method

    if (jQuery.trim(address['address2']) != '') {
        $('#p_address2').show();
    }

    for (var j = 0; j < fields.length; j++)
        if ($(fields[j]).is(":visible"))
            fadeAndSet(fields[j], start + inc * i++, opacity, address[fields[j].substring(1)]);


    // slower refresh for country / state to give a bit more time to ajax request
    if (!dont_pre_save_address) {
        $('#id_country').fadeTo(start + inc * i++, opacity, function () {
            $('#id_country').change();
        });

        $('#id_state').fadeTo(start + inc * i++, opacity, function () {
            $('#id_state').change();
        });
    }

    $(fields.join(",")).fadeTo(300, 1);

    if (typeof setDeliveryAddress == 'function')
        $('#firstname').fadeTo(start + inc * i++, 1, setDeliveryAddress); // handle order review detail boxes (German law since 1.8.2012)

    if (dont_pre_save_address) {
        // wait callback, so that state combo shows
        $('#id_country').fadeTo(300, 1, function () {
            idSelectedCountry = address['id_state'];
            updateState(); // USA states
            updateNeedIDNumber(); // Spanish DNI
            if ($('#dni').is(":visible"))
                fadeAndSet('#dni', 0, 1, address['dni']);
            if ($('#vat_number').is(":visible"))
                fadeAndSet('#vat_number', 0, 1, address['vat_number']);
            updateZipCode();
        });
    }


    $('#alias').val(address['alias']);

    return false;

}//animateDlvAddress()

function animateInvAddress(address, dont_pre_save_address) {
    var start = 1000;
    var inc = 70;
    var i = 0;
    var opacity = 0.2;
    var fields = ["#company", "#vat_number", "#dni", "#firstname", "#lastname", "#address1", "#address2", "#postcode",
        "#city", "#id_country", "#id_state", "#other", "#phone", "#phone_mobile"];

    $("#id_country_invoice").val(address['id_country']);  // pre-cache id_country for zipCheck method in animate method    


    if (address['address2'] != '') {
        $('#p_address2_invoice').show();
    }

    for (var j = 0; j < fields.length; j++)
        if ($(fields[j] + "_invoice").is(":visible"))
            fadeAndSet(fields[j] + "_invoice", start + inc * i++, opacity, address[fields[j].substring(1)]);

    if (!dont_pre_save_address) {
        $('#id_country_invoice').fadeTo(start + inc * i++, opacity, function () {
            $('#id_country_invoice').change();
        });

        $('#id_state_invoice').fadeTo(start + inc * i++, opacity, function () {
            $('#id_state_invoice').change();
        });
    }

    var fields_invoice = [];
    $.each(fields, function (i, f) {
        fields_invoice.push(f + "_invoice");
    });

    $(fields_invoice.join(",")).fadeTo(300, 1);
    if (typeof setInvoiceAddress == 'function')
        $('#firstname').fadeTo(start + inc * i++, 1, setInvoiceAddress); // handle order review detail boxes (German law since 1.8.2012)

    if (dont_pre_save_address) {
        // wait callback, so that state combo shows
        $('#id_country_invoice').fadeTo(300, 1, function () {
            idSelectedCountry_invoice = address['id_state'];
            updateState('invoice'); // USA states
            updateNeedIDNumber('invoice'); // Spanish DNI
            if ($('#dni_invoice').is(":visible"))
                fadeAndSet('#dni_invoice', 0, 1, address['dni']);
            if ($('#vat_number_invoice').is(":visible"))
                fadeAndSet('#vat_number_invoice', 0, 1, address['vat_number']);
            updateZipCode('invoice');
        });
    }


    $('#alias_invoice').val(address['alias']);
    return false;


}//animateInvAddress()

var nextTimeAnimateInv = false;
var nextTimeAnimateDlv = false;
// dont_pre_save_address = called from choose another address and in that case we don't need to pre_saveAddress as it's already set properly
function updateAddressesForms(json, dont_pre_save_address) {
    if (typeof(dont_pre_save_address) == undefined)
        dont_pre_save_address = false;

    if ($('#opc_id_address_delivery').val() != json.summary.delivery.id && $('#opc_delivery_address:visible').length>0) {
        animateDlvAddress(json.summary.delivery, dont_pre_save_address);
        $('#opc_id_address_delivery').val(json.summary.delivery.id);
    }

    if ($('#opc_id_address_invoice').val() != json.summary.invoice.id && $('#opc_invoice_address:visible').length>0) {
        animateInvAddress(json.summary.invoice, dont_pre_save_address);
        $('#opc_id_address_invoice').val(json.summary.invoice.id);
    }


        if (json.summary.delivery.id == json.summary.invoice.id) {
        if (!opc_invoice_first) {
            $('#invoice_address').removeAttr('checked');
            $('#opc_invoice_address').slideUp();
        } else {
            $('#delivery_address').removeAttr('checked');
            $('#opc_delivery_address').slideUp();
        }

        if ($('#dlv_addresses:visible').length > 0) nextTimeAnimateInv = true;
        if ($('#inv_addresses:visible').length > 0) nextTimeAnimateDlv = true;
        if (typeof setInvoiceAddress == 'function')
            setInvoiceAddress(); // handle order review detail boxes (German law since 1.8.2012)
    } else {
        // update also invoice address form
        if (!opc_invoice_first && ($('#opc_id_address_invoice').val() != json.summary.invoice.id || (json.summary.invoice.address1 != "" && $('#address1_invoice').val() == "") || nextTimeAnimateInv))
            if (json.summary.invoice.lastname != 'dummyvalue' && json.summary.invoice.city != 'dummyvalue')
                animateInvAddress(json.summary.invoice, dont_pre_save_address);
        if (opc_invoice_first && ($('#opc_id_address_delivery').val() != json.summary.delivery.id || (json.summary.delivery.address1 != "" && $('#address1_delivery').val() == "") || nextTimeAnimateDlv))
            if (json.summary.delivery.lastname != 'dummyvalue' && json.summary.delivery.city != 'dummyvalue')
                animateDlvAddress(json.summary.delivery, dont_pre_save_address);
        nextTimeAnimateInv = false;
        nextTimeAnimateDlv = false;
    }
    $('#opc_id_address_delivery').val(json.summary.delivery.id);
    $('#opc_id_address_invoice').val(json.summary.invoice.id);
    if (dont_pre_save_address) {
        updateEuVatField(json);
    }
}


function setAddressFields(address, type) {

    var fields = ["#company", "#vat_number", "#dni", "#firstname", "#lastname", "#address1", "#address2", "#postcode",
        "#city", "#id_country", "#other", "#phone", "#phone_mobile"];

    var suffix = '';
    if (type == 'invoice')
        suffix = '_invoice';

    var field_val = "";
    for (var j = 0; j < fields.length; j++)
        if ($(fields[j]).is(":visible")) {
            field_val = address[fields[j].substring(1)];
            $(fields[j] + suffix).val(field_val);
            if (opc_inline_validation == "1" && field_val != "")
                validateFieldAndDisplayInline($(fields[j]));
            field_val = ""; // reset temp var
        }

    if (address['address2'] != '') {
        $('#p_address2' + suffix).show();
    }
    $('#alias' + suffix).val(address['alias']);

    if (type == 'invoice') {
        // just a little more time to allow country / vat / dni fields to show up
        $('#id_country_invoice').fadeTo(300, 1, function () {
            updateState('invoice'); // USA states
            updateNeedIDNumber('invoice'); // Spanish DNI
            if ($('#dni_invoice').is(":visible"))
                fadeAndSet('#dni_invoice', 0, 1, address['dni']);
            if ($('#vat_number_invoice').is(":visible"))
                fadeAndSet('#vat_number_invoice', 0, 1, address['vat_number']);
            updateZipCode('invoice');
            $('#opc_id_address_invoice').val(address['id']);
        });
    } else {
        $('#id_country').fadeTo(300, 1, function () {
            updateState(); // USA states
            updateNeedIDNumber(); // Spanish DNI
            if ($('#dni').is(":visible"))
                fadeAndSet('#dni', 0, 1, address['dni']);
            if ($('#vat_number').is(":visible"))
                fadeAndSet('#vat_number', 0, 1, address['vat_number']);
            updateZipCode();
            $('#opc_id_address_delivery').val(address['id']);
        });
    }

    $('#id_state' + suffix).fadeTo(400, 1, function () {
        $('#id_state' + suffix).val(address['id_state']); // because we don't have it in template and updateState would overwrite it otherwise if it was called earlier
    });

}

function updateChooseAnotherAddress(addresses, dlv_address_id, inv_address_id) {
    if (addresses.length > 1) {
        $('select#dlv_addresses').empty();
        $('select#inv_addresses').empty();
        $(addresses).each(function (key, item) {
            $('select#dlv_addresses').append('<option value="' + item.id_address + '"' + (dlv_address_id == item.id ? ' selected="selected' : '') + '">' + item.alias + '</option>');
            $('select#inv_addresses').append('<option value="' + item.id_address + '"' + (inv_address_id == item.id ? ' selected="selected' : '') + '">' + item.alias + '</option>');
        });

        $('div#dlv_addresses_div').slideDown('slow');
        $('div#inv_addresses_div').slideDown('slow');
    }
    else {
        $('div#dlv_addresses_div').slideUp('fast');
        $('div#inv_addresses_div').slideUp('fast');
    }
	updateAddressSelection(dlv_address_id,inv_address_id);
}

function updateEuVatField(json) {
    if (typeof opc_company_based_vat !== 'undefined' && jQuery.trim(opc_company_based_vat) == "1")
        return;

    if (json.allow_eu_vat_delivery == 1)
        $('#vat_number_block').show();
    else
        $('#vat_number_block').hide();

    if (json.allow_eu_vat_invoice == 1)
        $('#vat_number_block_invoice').show();
    else
        $('#vat_number_block_invoice').hide();
}

function updateCustomerInfo(customer_info) {
    // email
    $("#opc_account_form input#email").val(customer_info.email);

    // birthday
    if (customer_info.birthday != null && customer_info.birthday != "") {
        var birthdayArr = customer_info.birthday.split("-");
        if (birthdayArr[0] !== undefined)
            $("#opc_account_form select#years").val(parseInt(birthdayArr[0]));
        if (birthdayArr[1] !== undefined)
            $("#opc_account_form select#months").val(parseInt(birthdayArr[1]));
        if (birthdayArr[2] !== undefined)
            $("#opc_account_form select#days").val(parseInt(birthdayArr[2]));
    } else {
        $("#opc_account_form select#years").val('');
        $("#opc_account_form select#months").val('');
        $("#opc_account_form select#days").val('');
    }

    // optin - special offers
    if (customer_info.optin == 1)
        $("#opc_account_form input#optin").attr('checked', 'checked');
    else
        $("#opc_account_form input#optin").removeAttr('checked');

    // newsletter
    if (customer_info.newsletter == 1)
        $("#opc_account_form input#newsletter").attr('checked', 'checked');
    else
        $("#opc_account_form input#newsletter").removeAttr('checked');

    // gender
    if (customer_info.id_gender == 1)
        $("input[name=id_gender]").filter("[value=1]").attr("checked", "checked");
    else if (customer_info.id_gender == 2)
        $("input[name=id_gender]").filter("[value=2]").attr("checked", "checked");
    else
        $("input[name=id_gender]").removeAttr("checked");

    // opc_id_customer
    $('input#opc_id_customer').val(customer_info.id);
    if (typeof opc_save_account_overlay !== 'undefined' && jQuery.trim(opc_save_account_overlay) == "1") {
        $('div.save-account-button-container, div.save-account-overlay').fadeOut('fast');
    }

    // "password" definition checkbox
    if (customer_info.is_guest == 0) {
        $("p#p_registerme, form#offer_password, #new_account_form p.password, #email_verify_cont").hide();
        $("#email").attr("readonly", "readonly");
        $("#email").addClass("readonly");
    }
    else {
        $("p#p_registerme, form#offer_password, #new_account_form p.password, #email_verify_cont").show();
        $("#email").removeAttr("readonly");
        $("#email").removeClass("readonly");
    }


}

function updateFormsAfterLogin(json) {
    $('form#login_form').hide();
    updateCustomerInfo(json.customer_info);

    //setAddressFields(json.summary.delivery, 'delivery');
    //if (json.summary.delivery.id != json.summary.invoice.id)
    //  setAddressFields(json.summary.invoice, 'invoice');
    updateAddressesForms(json, true);

    updateChooseAnotherAddress(json.customer_addresses, json.summary.delivery.id, json.summary.invoice.id);

    var x = $('#registerme').attr('checked', false);
    if (typeof $.uniform !== 'undefined')
        $.uniform.update(x);

    updateEuVatField(json);
}

function updateAddressSelection_1() {
    var idAddress_delivery = $('select#dlv_addresses').val();
    var idAddress_invoice = ($('select#inv_addresses:visible').length == 1 ? $('select#inv_addresses').val() : idAddress_delivery);
    updateAddressSelection(idAddress_delivery, idAddress_invoice);

}

function updateAddressSelection_1_invoice() {
    var idAddress_invoice = $('select#inv_addresses').val();
    var idAddress_delivery = ($('select#dlv_addresses:visible').length == 1 ? $('select#dlv_addresses').val() : idAddress_invoice);
    updateAddressSelection(idAddress_delivery, idAddress_invoice);
}

var address_fields = ["#company", "#vat_number", "#dni", "#firstname", "#lastname", "#address1", "#address2", "#postcode",
    "#city", "#id_country", "#id_state", "#other", "#phone", "#phone_mobile"];
var other_fields = ["#email", "#passwd", "#days", "#months", "#years"];

function saveToCheckoutCookie() {
    var dlv_cookie = new Array();
    var inv_cookie = new Array();
    var other_cookie = new Array();

    for (var j = 0; j < address_fields.length; j++) {
        if ($(address_fields[j]).is(":visible"))
            dlv_cookie.push([address_fields[j], $(address_fields[j]).val()].join('":"'));
        if ($(address_fields[j] + "_invoice").is(":visible"))
            inv_cookie.push([address_fields[j] + "_invoice", $(address_fields[j] + "_invoice").val()].join('":"'));
    }
    for (var j = 0; j < other_fields.length; j++) {
        if ($(other_fields[j]).is(":visible"))
            other_cookie.push([other_fields[j], $(other_fields[j]).val()].join('":"'));
    }

    $.cookie("opcform", '{"' + dlv_cookie.concat(inv_cookie).concat(other_cookie).join('","') + '"}', {expires:1 / 24 / 60 * 10}); // expires in 10 minutes.
}

$.cookie.json = true;


function preFillFromCheckoutCookie() {

    if ($.cookie("opcform") == null)
        return;

    for (var j = 0; j < address_fields.length; j++) {
        if ($(address_fields[j]).is(":visible") && jQuery.trim($(address_fields[j]).val()) == "" && $.cookie("opcform")[address_fields[j]] !== undefined)
            $(address_fields[j]).val($.cookie("opcform")[address_fields[j]]);
        if ($(address_fields[j] + "_invoice").is(":visible") && jQuery.trim($(address_fields[j] + "_invoice").val()) == "" && $.cookie("opcform")[address_fields[j] + "_invoice"] !== undefined)
            $(address_fields[j] + "_invoice").val($.cookie("opcform")[address_fields[j] + "_invoice"]);
    }

    for (var j = 0; j < other_fields.length; j++) {
        if ($(other_fields[j]).is(":visible") && jQuery.trim($(other_fields[j]).val()) == "" && $.cookie("opcform")[other_fields[j]] !== undefined)
            $(other_fields[j]).val($.cookie("opcform")[other_fields[j]]);
    }

}

function _getAdditionalUrlParams() {
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    var excluded = ["controller"];
    var result = "";

    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split("=");
        if ($.inArray(pair[0], excluded) < 0)
            result += '&' + vars[i];
    }

    return result;
}

function updateAddressSelection(idAddress_delivery, idAddress_invoice) {
    // poriesi volania default metody v orig. checkoute
    if (typeof idAddress_delivery === "undefined")
        idAddress_delivery = $('select#dlv_addresses').val();
    if (typeof idAddress_invoice === "undefined")
        idAddress_invoice = ($('input[type=checkbox]#invoice_address:checked').length == 0 ? idAddress_delivery : ($('select#inv_addresses').length == 1 ? $('select#inv_addresses').val() : idAddress_delivery));

    $('#opc_account-overlay').fadeIn('slow');
    $('#opc_delivery_methods-overlay').fadeIn('slow');
    $('#opc_payment_methods-overlay').fadeIn('slow');

    var additionalParams = _getAdditionalUrlParams();
    if (orderOpcUrl.match(/\?/) === null)
        additionalParams = '?' + additionalParams.substr(1);

    $.ajax({
        type:'POST',
        url:orderOpcUrl + additionalParams,
        async:true,
        cache:false,
        dataType:"json",
        data:'ajax=true&method=updateAddressesSelected&id_address_delivery=' + idAddress_delivery + '&id_address_invoice=' + idAddress_invoice + '&token=' + static_token,
        success:function (jsonData) {
            if (jsonData.hasError) {
                var errors = '';
                for (error in jsonData.errors)
                    //IE6 bug fix
                    if (error != 'indexOf')
                        errors += jsonData.errors[error] + "\n";
                if ($.inArray("not_your_address", errors)) {
                    $('#opc_delivery_methods-overlay').hide();
                    $('#opc_payment_methods-overlay').hide();
                } else {
                    alert(errors);
                }
            }
            else {
                // Update all product keys with the new address id, so that cart-summary.js works properly changing dynamically in cart summary section
                $('#cart_summary tr[class*=address_], #cart_summary tr[class*=product_customization_]').each(function () {
                //$('#cart_summary .address_' + deliveryAddress).each(function () {
                    $(this)
                        .removeClass('address_0')
                        .removeClass('address_' + deliveryAddress)
                        .addClass('address_' + idAddress_delivery);
                    $(this).attr('id', $(this).attr('id').replace(/_\d+$/, '_' + idAddress_delivery));
                    if ($(this).find('.cart_unit span.price').length > 0 && $(this).find('.cart_unit span.price').attr('id').length > 0)
                        $(this).find('.cart_unit span.price').attr('id', $(this).find('.cart_unit span.price').attr('id').replace(/_\d+$/, '_' + idAddress_delivery));
                    if ($(this).find('.cart_total span.price').length > 0 && $(this).find('.cart_total span.price').attr('id').length > 0)
                        $(this).find('.cart_total span.price').attr('id', $(this).find('.cart_total span.price').attr('id').replace(/_\d+$/, '_' + idAddress_delivery));
                    if ($(this).find('.cart_quantity_input').length > 0 && $(this).find('.cart_quantity_input').attr('name').length > 0) {
                        name = $(this).find('.cart_quantity_input').attr('name') + '_hidden';
                        $(this).find('.cart_quantity_input').attr('name', $(this).find('.cart_quantity_input').attr('name').replace(/_\d+$/, '_' + idAddress_delivery));
                        if ($(this).find('[name=' + name + ']').length > 0)
                            $(this).find('[name=' + name + ']').attr('name', name.replace(/_\d+_hidden$/, '_' + idAddress_delivery + '_hidden'));
                    }
                    if ($(this).find('.cart_quantity_delete').length > 0 && $(this).find('.cart_quantity_delete').attr('id').length > 0) {
                        $(this).find('.cart_quantity_delete')
                            .attr('id', $(this).find('.cart_quantity_delete').attr('id').replace(/_\d+$/, '_' + idAddress_delivery))
                            .attr('href', $(this).find('.cart_quantity_delete').attr('href').replace(/id_address_delivery=\d+&/, 'id_address_delivery=' + idAddress_delivery + '&'))
                    }
                    if ($(this).find('.cart_quantity_down').length > 0 && $(this).find('.cart_quantity_down').attr('id').length > 0) {
                        $(this).find('.cart_quantity_down')
                            .attr('id', $(this).find('.cart_quantity_down').attr('id').replace(/_\d+$/, '_' + idAddress_delivery))
                            .attr('href', $(this).find('.cart_quantity_down').attr('href').replace(/id_address_delivery=\d+&/, 'id_address_delivery=' + idAddress_delivery + '&'))
                    }
                    if ($(this).find('.cart_quantity_up').length > 0 && $(this).find('.cart_quantity_up').attr('id').length > 0) {
                        $(this).find('.cart_quantity_up')
                            .attr('id', $(this).find('.cart_quantity_up').attr('id').replace(/_\d+$/, '_' + idAddress_delivery))
                            .attr('href', $(this).find('.cart_quantity_up').attr('href').replace(/id_address_delivery=\d+&/, 'id_address_delivery=' + idAddress_delivery + '&'))
                    }
                    if ($(this).find('span[id*=cart_quantity_custom]').length > 0) {
                        $(this).find('span[id*=cart_quantity_custom]').attr('id', $(this).find('span[id*=cart_quantity_custom]').attr('id').replace(/_\d+$/, '_' + idAddress_delivery));
                    }
                });

                var wrapper_el = $('#shopping_cart, .shopping_cart, #cart_block');
                wrapper_el.find('dd:not([id*=_'+idAddress_delivery+']), dt:not([id*=_'+idAddress_delivery+'])').remove();

                // Update global var deliveryAddress
                deliveryAddress = idAddress_delivery;

                if (window.ajaxCart !== undefined)
                {
                    $('#cart_block_list dd, #cart_block_list dt').each(function(){
                        if (typeof($(this).attr('id')) != 'undefined')
                            $(this).attr('id', $(this).attr('id').replace(/_\d+$/, '_' + idAddress_delivery));
                    });
                    ajaxCart.refresh();
                }
    
                updateCarrierList(jsonData);
                if (typeof updateCartSummary == 'function') updateCartSummary(jsonData.summary);
                if (typeof updateCustomizedDatas == 'function') updateCustomizedDatas(jsonData.customizedDatas);
                if (onlyCartSummary == '0') {
                    updatePaymentMethods(jsonData);
                    updateHookShoppingCart(jsonData.HOOK_SHOPPING_CART);
                    updateHookShoppingCartExtra(jsonData.HOOK_SHOPPING_CART_EXTRA);
                    // OPCKT added
                    var dont_pre_save_address = 1;
                    updateAddressesForms(jsonData, dont_pre_save_address);
                    //if ($('#gift-price').length == 1)
                    //    $('#gift-price').html(jsonData.gift_price);
                    $('#opc_account-overlay').fadeOut('slow');
                }
                $('#opc_delivery_methods-overlay').fadeOut('slow');
                $('#opc_payment_methods-overlay').fadeOut('slow');
                if (onlyCartSummary == '0') {
                    setPaymentModuleHandler();
                }

                // Uncomment this to enable Invoice address to be visible when visiting checkout form
                // TODO: dat do configu
                /*if (invoice_address_on_ready_call && !$('#invoice_address').is(":checked") && !$('div#opc_invoice_address').is(":visible") && $('#new_account_form input#email').val() == "")
                 {
                 invoice_address_on_ready_call = false;
                 $('#invoice_address').attr("checked", "checked").click();
                 }*/
                 
                 /* Uncomment to have above confirmation message displayed only for tax free shipping
                 if (typeof opc_above_confirmation_message !== 'undefined' && jQuery.trim(opc_above_confirmation_message) == "1")
                 {
                   if (jsonData.summary.total_tax > 0)
                      $('div#above_confirmation_msg').hide();
                   else
                      $('div#above_confirmation_msg').show();
                 }
                 */

                 $('#dlv_addresses option[value='+idAddress_delivery+']').prop('selected', true);
                 $('#inv_addresses option[value='+idAddress_invoice+']').prop('selected', true);

                 $('#dlv_addresses option, #inv_addresses option').attr('disabled', false);
                 $('#dlv_addresses option[value='+idAddress_invoice+']').attr('disabled', true);
                 $('#inv_addresses option[value='+idAddress_delivery+']').attr('disabled', true);

            }
        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
            if (textStatus != 'abort' && XMLHttpRequest.status != 0)
                alert("TECHNICAL ERROR: unable to save adresses \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
            $('#opc_account-overlay').fadeOut('slow');
            $('#opc_delivery_methods-overlay').fadeOut('slow');
            $('#opc_payment_methods-overlay').fadeOut('slow');
        }
    });
}

function getCarrierListAndUpdate() {
    $('#opc_delivery_methods-overlay').fadeIn('slow');
    $.ajax({
        type:'POST',
        url:orderOpcUrl,
        async:true,
        cache:false,
        dataType:"json",
        data:'ajax=true&method=getCarrierList&token=' + static_token,
        success:function (jsonData) {
            if (jsonData.hasError) {
                var errors = '';
                for (error in jsonData.errors)
                    //IE6 bug fix
                    if (error != 'indexOf')
                        errors += jsonData.errors[error] + "\n";
                alert(errors);
            }
            else {
                updateCarrierList(jsonData);
                updatePaymentMethods(jsonData);
            }
            $('#opc_delivery_methods-overlay').fadeOut('slow');
        }
    });
}

function updateCarrierSelectionAndGift() {
    var recyclablePackage = 0;
    var gift = 0;
    var giftMessage = '';
    var idCarrier = 0;

    if ($('input#recyclable:checked').length)
        recyclablePackage = 1;
    if ($('input#gift:checked').length) {
        gift = 1;
        giftMessage = encodeURIComponent($('textarea#gift_message').val());
    }

    // If ps default carrier selection is ON
    if (opc_default_ps_carriers) {
        var delivery_option_radio = $('.delivery_option_radio');
        var delivery_option_params = '';
        $.each(delivery_option_radio, function (i) {
            if ($(this).prop('checked'))
                delivery_option_params = $(delivery_option_radio[i]).val();
        });
        if (delivery_option_params != '') {
            idCarrier = Cart_intifier(delivery_option_params);
        }
    }else if ($('input[name=id_carrier]:checked').length) {
        idCarrier = $('input[name=id_carrier]:checked').val();
        checkedCarrier = idCarrier;
    }

    if (typeof setPersonalDetailsCarrier == 'function')
        setPersonalDetailsCarrier(); // handle order review detail boxes (German law since 1.8.2012)

    var additionalParams = _getAdditionalUrlParams();
    if (orderOpcUrl.match(/\?/) === null)
        additionalParams = '?' + additionalParams.substr(1);

    $('#opc_delivery_methods-overlay').show();//fadeIn('fast');
    $('#opc_payment_methods-overlay').fadeIn();
    $.ajax({
        type:'POST',
        url:orderOpcUrl + additionalParams,
        async:true,
        cache:false,
        dataType:"json",
        data:'ajax=true&method=updateCarrierAndGetPayments&id_carrier=' + idCarrier + '&recyclable=' + recyclablePackage + '&gift=' + gift + '&gift_message=' + giftMessage + '&token=' + static_token,
        success:function (jsonData) {
            if (jsonData.hasError) {
                var errors = '';
                for (error in jsonData.errors)
                    //IE6 bug fix
                    if (error != 'indexOf')
                        errors += jsonData.errors[error] + "\n";
                alert(errors);
            }
            else {
                if (typeof updateCartSummary == 'function') updateCartSummary(jsonData.summary);
                // Estonian post24 and smartpost update
                updateCarrierList(jsonData.carrier_data); 
                
                if (onlyCartSummary == '0') {
                    updatePaymentMethods(jsonData);
                    updateHookShoppingCart(jsonData.summary.HOOK_SHOPPING_CART);
                    updateHookShoppingCartExtra(jsonData.summary.HOOK_SHOPPING_CART_EXTRA);
                }
                // todo: v pov. checkoute sa tu este updatuje carrierList a deliveryOptions, je to potrebne vobec??
                $('#opc_payment_methods-overlay').fadeOut('slow');
                $('#opc_delivery_methods-overlay').fadeOut('slow');

                if (onlyCartSummary == '0') {
                    setPaymentModuleHandler();
                }
            }
        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
            if (textStatus != 'abort' && XMLHttpRequest.status != 0)
                alert("TECHNICAL ERROR: unable to save carrier \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
            $('#opc_payment_methods-overlay').fadeOut('slow');
            $('#opc_delivery_methods-overlay').fadeOut('slow');
        }
    });
}

function confirmFreeOrder() {
    if ($('#opc_new_account-overlay').length != 0)
        $('#opc_new_account-overlay').fadeIn('slow');
    else
        $('#opc_account-overlay').fadeIn('slow');
    $('#opc_delivery_methods-overlay').fadeIn('slow');
    $('#opc_payment_methods-overlay').fadeIn('slow');
    $.ajax({
        type:'POST',
        url:orderOpcUrl,
        async:true,
        cache:false,
        dataType:"html",
        data:'ajax=true&method=makeFreeOrder&token=' + static_token,
        success:function (html) {
            var array_split = html.split(':');
            if (array_split[0] === 'freeorder') {
                if (isGuest)
                    document.location.href = guestTrackingUrl + '?id_order=' + encodeURIComponent(array_split[1]) + '&email=' + encodeURIComponent(array_split[2]);
                else
                    document.location.href = historyUrl;
            }
        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
            if (textStatus != 'abort' && XMLHttpRequest.status != 0)
                alert("TECHNICAL ERROR: unable to confirm the order \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
        }
    });
}

// cela ajaxova praca s disounts je zrusena, lebo location.reload sa vynucuje uz na urovni PS1.5 template
// takze nema zmysel riesit ajaxovost v OPC module

//function submitDiscount(method, id_discount) {
//    var req_str = '';
//    if (method == 'add')
//        req_str = '&method=opcAddDiscount';
//    else // method == 'delete'
//        req_str = '&method=opcDeleteDiscount&discountId=' + id_discount;
//    $.ajax({
//        type:'POST',
//        url:orderOpcUrl,
//        async:true,
//        cache:false,
//        dataType:"json",
//        data:'ajax=true' + req_str + '&discount_name=' + $('input#discount_name').val() + '&token=' + static_token,
//        success:function (jsonData) {
//            if (jsonData.hasError) {
//                var tmp = '';
//                var i = 0;
//                for (error in jsonData.errors)
//                    //IE6 bug fix
//                    if (error != 'indexOf') {
//                        i = i + 1;
//                        tmp += '<li>' + jsonData.errors[error] + '</li>';
//                    }
//                tmp += '</ol>';
//                var errors = '<b>' + txtThereis + ' ' + i + ' ' + txtErrors + ':</b><ol>' + tmp;
//                $('#opc_voucher_errors').html(errors).slideDown('slow');
//                // $.scrollTo('#opc_voucher_errors', 800);
//                result = false;
//            } else {
//                $('#opc_voucher_errors').slideUp('slow');
////                if (jsonData.last_discount) {
////                    var last_discount = jsonData.last_discount;
////                    // cart summary (checkout page)
////                    $('table#cart_summary > tbody:last').append(
////                        '<tr id="cart_discount_' + last_discount["id"] + '" class="cart_discount last_item">' +
////                            '<td class="cart_discount_name" colspan="2">' + last_discount["name"] + '</td>' +
////                            '<td class="cart_discount_description" colspan="3">' + last_discount["description"][jsonData.id_lang] + '</td>' +
////                            '<td class="cart_discount_delete">' +
////                            '<a title="Delete" href="' + baseDir + 'modules/onepagecheckout/order-opc.php?deleteDiscount=' + last_discount["id"] + '">' +
////                            '<img class="icon" width="11" height="13" alt="Delete" src="' + imgDir + 'icon/delete.gif">' +
////                            '</a>' +
////                            '</td>' +
////                            '<td class="cart_discount_price">' +
////                            '<span class="price-discount">' + (last_discount["value_real"] * -1) + '</span>' +
////                            '</td>' +
////                            '</tr>'
////                    );
////                    // blockcart
////                    if (window.ajaxCart !== undefined) {
////                        if ($('#cart_block_list table#vouchers').length == 0) {
////                            // first append table definition
////                            $('#cart_block_list > dl').append(
////                                '<table id="vouchers"><tbody></tbody></table>'
////                            );
////                        }
////                        $('#cart_block_list table#vouchers > tbody:last').append(
////                            '<tr id="bloc_cart_voucher_' + last_discount["id"] + '" class="bloc_cart_voucher">' +
////                                '<td class="name" title="' + last_discount["description"][jsonData.id_lang] + '">' + last_discount["name"] + ' : ' + last_discount["description"][jsonData.id_lang] + '</td>' +
////                                '<td class="price">' + (last_discount["value_real"] * -1) + '</td>' +
////                                '<td class="delete">' +
////                                '<a title="Delete" href="' + baseDir + 'modules/onepagecheckout/order-opc.php?deleteDiscount=' + last_discount["id"] + '">' +
////                                '<img class="icon" width="11" height="13" alt="Delete" src="' + imgDir + 'icon/delete.gif">' +
////                                '</a>' +
////                                '</td>' +
////                                '</tr>'
////                        );
////                    }
////                    overrideDeleteDiscount();
////                }
//
//                if (typeof updateCartSummary == 'function') updateCartSummary(jsonData.summary);
//                updateCarrierSelectionAndGift();
//            }
//        },
//        error:function (XMLHttpRequest, textStatus, errorThrown) {
//            alert("TECHNICAL ERROR: unable to confirm the order \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
//        }
//    });
//}

function saveAddress(type) {
    if (type != 'delivery' && type != 'invoice')
        return false;

    var params = 'firstname=' + encodeURIComponent($('#firstname' + (type == 'invoice' ? '_invoice' : '')).val()) + '&lastname=' + encodeURIComponent($('#lastname' + (type == 'invoice' ? '_invoice' : '')).val()) + '&';
    params += 'company=' + encodeURIComponent($('#company' + (type == 'invoice' ? '_invoice' : '')).val()) + '&';
    params += 'vat_number=' + encodeURIComponent($('#vat_number' + (type == 'invoice' ? '_invoice' : '')).val()) + '&';
    params += 'dni=' + encodeURIComponent($('#dni' + (type == 'invoice' ? '_invoice' : '')).val()) + '&';
    params += 'address1=' + encodeURIComponent($('#address1' + (type == 'invoice' ? '_invoice' : '')).val()) + '&';
    params += 'address2=' + encodeURIComponent($('#address2' + (type == 'invoice' ? '_invoice' : '')).val()) + '&';
    params += 'postcode=' + encodeURIComponent($('#postcode' + (type == 'invoice' ? '_invoice' : '')).val()) + '&';
    params += 'city=' + encodeURIComponent($('#city' + (type == 'invoice' ? '_invoice' : '')).val()) + '&';
    params += 'id_country=' + encodeURIComponent($('#id_country' + (type == 'invoice' ? '_invoice' : '')).val()) + '&';
    var id_state_p = $('#id_state' + (type == 'invoice' ? '_invoice' : '')).val();
    if (id_state_p != null)
        params += 'id_state=' + encodeURIComponent(id_state_p) + '&';
    params += 'other=' + encodeURIComponent($('#other' + (type == 'invoice' ? '_invoice' : '')).val()) + '&';
    params += 'phone=' + encodeURIComponent($('#phone' + (type == 'invoice' ? '_invoice' : '')).val()) + '&';
    params += 'phone_mobile=' + encodeURIComponent($('#phone_mobile' + (type == 'invoice' ? '_invoice' : '')).val()) + '&';
    params += 'alias=' + encodeURIComponent($('#alias' + (type == 'invoice' ? '_invoice' : '')).val()) + '&';
    params += 'default_alias=' + encodeURIComponent($('#default_alias' + (type == 'invoice' ? '_invoice' : '')).val()) + '&';
    params += 'id_address=' + encodeURIComponent($('input#opc_id_address' + (type == 'invoice' ? '_invoice' : '_delivery')).val()) + '&';
    // Clean the last &
    params = params.substr(0, params.length - 1);

    var result = false;

    $.ajax({
        type:'POST',
        url:addressUrl,
        async:false,
        cache:false,
        dataType:"json",
        data:'ajax=true&submitAddress=true&type=' + type + '&' + params + '&token=' + static_token,
        success:function (jsonData) {
            if (jsonData.hasError) {
                var tmp = '';
                var i = 0;
                for (error in jsonData.errors)
                    //IE6 bug fix
                    if (error != 'indexOf') {
                        i = i + 1;
                        tmp += '<li>' + jsonData.errors[error] + '</li>';
                    }
                tmp += '</ol>';
                var errors = '<b>' + txtThereis + ' ' + i + ' ' + txtErrors + ':</b><ol>' + tmp;
                if (type == "invoice") {
                    $('#opc_account_errors_invoice').html(errors).slideDown('slow');
                    $.fn.scrollToElement('#opc_account_errors_invoice', 800);
                    //$.scrollTo('#opc_account_errors_invoice', 800);
                } else {
                    $('#opc_account_errors').html(errors).slideDown('slow');
                    $.fn.scrollToElement('#opc_account_errors', 800);
                    //$.scrollTo('#opc_account_errors', 800);
                }
                $('#opc_new_account-overlay').fadeOut('slow');
                $('#opc_delivery_methods-overlay').fadeOut('slow');
                $('#opc_payment_methods-overlay').fadeOut('slow');
                setPaymentModuleHandler();
                result = false;
            }
            else {
                // update addresses id
                $('input#opc_id_address_delivery').val(jsonData.id_address_delivery);
                $('input#opc_id_address_invoice').val(jsonData.id_address_invoice);

                result = true;
            }
        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
            if (textStatus != 'abort' && XMLHttpRequest.status != 0)
                alert("TECHNICAL ERROR: unable to save adresses \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
            $('#opc_new_account-overlay').fadeOut('slow');
            $('#opc_delivery_methods-overlay').fadeOut('slow');
            $('#opc_payment_methods-overlay').fadeOut('slow');
        }
    });

    return result;
}

// OPCKT pre-save address (weak save, due to dynamic carrier / tax / payment behavior)
function pre_saveAddress(type, skip_refresh, callback) {
    if (type != 'delivery' && type != 'invoice')
        return false;
    // save delivery address even when delivery address block is not visible
    var addr_field_type = (opc_invoice_first && $('#opc_delivery_address').length == 0 && type == 'delivery') ? 'invoice' : type;

    var params = 'postcode=' + encodeURIComponent($('#postcode' + (addr_field_type == 'invoice' ? '_invoice' : '')).val()) + '&';
    //params += 'city='+encodeURIComponent($('#city'+(addr_field_type == 'invoice' ? '_invoice' : '')).val())+'&';
    params += 'id_country=' + encodeURIComponent($('#id_country' + (addr_field_type == 'invoice' ? '_invoice' : '')).val()) + '&';
    params += 'city=' + encodeURIComponent($('#city' + (addr_field_type == 'invoice' ? '_invoice' : '')).val()) + '&';
    params += 'firstname=' + encodeURIComponent($('#firstname' + (addr_field_type == 'invoice' ? '_invoice' : '')).val()) + '&';
    params += 'lastname=' + encodeURIComponent($('#lastname' + (addr_field_type == 'invoice' ? '_invoice' : '')).val()) + '&';
    params += 'address1=' + encodeURIComponent($('#address1' + (addr_field_type == 'invoice' ? '_invoice' : '')).val()) + '&';
    var id_state_p = $('#id_state' + (addr_field_type == 'invoice' ? '_invoice' : '')).val();
    if (id_state_p != null)
        params += 'id_state=' + encodeURIComponent(id_state_p) + '&';
    params += 'type=' + encodeURIComponent(type) + '&';
    if ($('#invoice_address').is(':checked'))
        params += 'invoice_address=1' + '&';
    else
        params += 'invoice_address=0' + '&';
    if ($('#delivery_address').is(':checked'))
        params += 'delivery_address=1' + '&';
    else
        params += 'delivery_address=0' + '&';


    //	params += 'id_country_invoice='+encodeURIComponent($('#id_country_invoice'+(type == 'invoice' ? '_invoice' : '')).val())+'&';
    //params += 'id_state_invoice='+encodeURIComponent($('#id_state_invoice'+(type == 'invoice' ? '_invoice' : '')).val())+'&';
    // Clean the last &
    params = params.substr(0, params.length - 1);

    var result = false;

    $.ajax({
        type:'POST',
        url:addressUrl,
        async:true,
        cache:false,
        dataType:"json",
        data:'ajax=true&partialSubmitAddress=true&type=' + type + '&' + params + '&token=' + static_token,
        success:function (jsonData) {
            if (jsonData.hasError) {
                var tmp = '';
                var i = 0;
                for (error in jsonData.errors)
                    //IE6 bug fix
                    if (error != 'indexOf') {
                        i = i + 1;
                        tmp += '<li>' + jsonData.errors[error] + '</li>';
                    }
                tmp += '</ol>';
                var errors = '<b>' + txtThereis + ' ' + i + ' ' + txtErrors + ':</b><ol>' + tmp;
                if (addr_field_type == "invoice") {
                    $('#opc_account_errors_invoice').html(errors).slideDown('slow');
                    $.fn.scrollToElement('#opc_account_errors_invoice', 800);
                    //$.scrollTo('#opc_account_errors_invoice', 800);
                } else {
                    $('#opc_account_errors').html(errors).slideDown('slow');
                    $.fn.scrollToElement('#opc_account_errors', 800);
                    //$.scrollTo('#opc_account_errors', 800);
                }
                $('#opc_new_account-overlay').fadeOut('slow');
                $('#opc_delivery_methods-overlay').fadeOut('slow');
                $('#opc_payment_methods-overlay').fadeOut('slow');
                setPaymentModuleHandler();
                result = false;
            }
            else {
                if (typeof callback === 'function') {
                    //console.log('callback call');
                    callback();
                }

                // update addresses id
                $('input#opc_id_address_delivery').val(jsonData.id_address_delivery);
                $('input#opc_id_address_invoice').val(jsonData.id_address_invoice);

                if (typeof skip_refresh === 'undefined') {

                    // update choose another address
                    if (type == 'invoice') {
                        $('#inv_addresses').val(jsonData.id_address_invoice);
                    }

                    if (type == 'delivery') {
                        $('#dlv_addresses').val(jsonData.id_address_delivery);
                    }

                    updateAddressSelection(jsonData.id_address_delivery, jsonData.id_address_invoice);
                    // EU VAT management
                    if (typeof opc_company_based_vat !== 'undefined' && jQuery.trim(opc_company_based_vat) == "1") {
                        // do nothing
                    } else {
                        if (addr_field_type == 'delivery')
                            if (jsonData.allow_eu_vat == 1)
                                $('#vat_number_block').show();
                            else
                                $('#vat_number_block').hide();

                        if (addr_field_type == 'invoice')
                            if (jsonData.allow_eu_vat == 1)
                                $('#vat_number_block_invoice').show();
                            else
                                $('#vat_number_block_invoice').hide();
                    }

                } //else console.log('refresh skipped');
                result = true;
            }
        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
            if (textStatus != 'abort' && XMLHttpRequest.status != 0)
                alert("TECHNICAL ERROR: unable to save adresses \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
        }
    });

}

function updateNewAccountToAddressBlock() {
    $('#opc_new_account-overlay').fadeIn('slow');
    $('#opc_delivery_methods-overlay').fadeIn('slow');
    $('#opc_payment_methods-overlay').fadeIn('slow');
    $.ajax({
        type:'POST',
        url:orderOpcUrl,
        async:true,
        cache:false,
        dataType:"json",
        data:'ajax=true&method=getAddressBlockAndCarriersAndPayments&token=' + static_token,
        success:function (jsonData) {
            if (jsonData.no_address == 1)
                document.location.href = addressUrl;
            // update block user info
            if (jsonData.block_user_info != '' && $('#header_user').length == 1) {
                $('#header_user').fadeOut('slow', function () {
                    $(this).attr('id', 'header_user_old').after(jsonData.block_user_info).fadeIn('slow', function() {
                        $('#header_user_old').remove();
                        isFixedCart = false;
                        isFixedHeaderCart = false;
                        isFixedInfo = false;
                        isFixedSummary = false;
                        setScrollHandler();
                        scroll_handler();
                        if (window.ajaxCart !== undefined)
                        {
                            setCartHoveringAgain();
                        }
                    });
                });
            }
            if (typeof updateCartSummary == 'function') updateCartSummary(jsonData.summary);
            updateFormsAfterLogin(jsonData);
            $('#opc_new_account-overlay').fadeOut('slow');

            updateCarrierList(jsonData.carrier_data);
            updatePaymentMethods(jsonData);
            //if ($('#gift-price').length == 1)
            //    $('#gift-price').html(jsonData.gift_price);
            $('#opc_delivery_methods-overlay').fadeOut('slow');
            $('#opc_payment_methods-overlay').fadeOut('slow');
            $('#existing_email_msg').fadeOut('slow');
            $('#must_login_msg').fadeOut('slow');
            setPaymentModuleHandler();
            validateFieldAndDisplayInline($('#new_account_form #email'));
            nextTimeAnimateInv = true;
            nextTimeAnimateDlv = true;

        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
            if (textStatus != 'abort' && XMLHttpRequest.status != 0)
                alert("TECHNICAL ERROR: unable to send login informations \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
            $('#opc_delivery_methods-overlay').fadeOut('slow');
            $('#opc_payment_methods-overlay').fadeOut('slow');
        }
    });
}

function setCartHoveringAgain() {
    /* roll over cart */
    var cart_block = new HoverWatcher('#cart_block');
    var shopping_cart = new HoverWatcher('#shopping_cart');

    $("#shopping_cart a:first").hover(
        function() {
            $(this).css('border-radius', '3px 3px 0px 0px');
            if (ajaxCart.nb_total_products > 0 || cart_qty > 0)
                $("#cart_block").stop(true, true).slideDown(450);
        },
        function() {
            $('#shopping_cart a').css('border-radius', '3px');
            setTimeout(function() {
                if (!shopping_cart.isHoveringOver() && !cart_block.isHoveringOver())
                    $("#cart_block").stop(true, true).slideUp(450);
            }, 200);
        }
    );

    $("#cart_block").hover(
        function() {
            $('#shopping_cart a').css('border-radius', '3px 3px 0px 0px');
        },
        function() {
            $('#shopping_cart a').css('border-radius', '3px');
            setTimeout(function() {
                if (!shopping_cart.isHoveringOver())
                    $("#cart_block").stop(true, true).slideUp(450);
            }, 200);
        }
    );


}

function submitAccount(payment_module_button) {
    //$('#opc_new_account-overlay').show();
    //$('#opc_delivery_methods-overlay').show();
    //$('#opc_payment_methods-overlay').show();

    // TOS active and checked?
    var tos_nok = ($('input#cgv').length && $('input#cgv:checked').length == 0);
    if (tos_nok) {
        errors = '<b>' + txtTOSIsNotAccepted + '</b>';
        $('#opc_tos_errors').html(errors).slideUp('fast').slideDown('slow');
        $.fn.scrollToElement('#opc_tos_errors', 600);
        processing_payment = false;// Enable payment buttons again
        return false;
    }

    if ($('#email_verify:visible').length) {
        if ($('#email').val() != $('#email_verify').val()) {
            errors = '<b>' + 'Emails do not match' + '</b>';
            $('#opc_account_errors').html(errors).slideUp('fast').slideDown('slow');

	    $.fn.scrollToElement('#opc_account_errors', 800);

            processing_payment = false;// Enable payment buttons again
            return false;
        }
    }


    $('#opc_new_account-overlay').fadeIn('slow');
    $('#opc_delivery_methods-overlay').fadeIn('slow');
    $('#opc_payment_methods-overlay').fadeIn('slow');

    // RESET ERROR(S) MESSAGE(S)
    $('#opc_account_errors').html('').hide();
    $('#opc_account_errors_invoice').html('').hide();

    //isGuest = ($('#is_new_customer').val() == 1 ? 0 : 1);
    if ($('input#opc_id_customer').val() == 0 || $('#registerme').is(':checked')) {
        var callingFile = authenticationUrl;
        var params = 'submitAccount=true&';
    }
    else {
        var callingFile = orderOpcUrl;
        var params = 'method=editCustomer&';
    }

    $('#opc_account_form input:visible, #offer_password input:visible').each(function () {
        if ($(this).is('input[type=checkbox]')) {
            if ($(this).is(':checked'))
                params += encodeURIComponent($(this).attr('name')) + '=1&';
        }
        else if ($(this).is('input[type=radio]')) {
            if ($(this).is(':checked'))
                params += encodeURIComponent($(this).attr('name')) + '=' + encodeURIComponent($(this).val()) + '&';
        }
        else
            params += encodeURIComponent($(this).attr('name')) + '=' + encodeURIComponent($(this).val()) + '&';
    });
    $('#opc_account_form select:visible').each(function () {
        params += encodeURIComponent($(this).attr('name')) + '=' + encodeURIComponent($(this).val()) + '&';
    });

    // Fix for country ID when field is hidden
    $('#opc_account_form select#id_country:hidden, #opc_account_form select#id_country_invoice:hidden').each(function () {
        params += encodeURIComponent($(this).attr('name')) + '=' + encodeURIComponent($(this).val()) + '&';
    });


    if (isVirtualCart) {
        $('#opc_account_form input[name=firstname], #opc_account_form input[name=lastname], #opc_account_form input[name=address1], #opc_account_form input[name=city], #opc_account_form input[name=phone_mobile], #opc_account_form input[name=id_country]').each(function () {
            params += encodeURIComponent($(this).attr('name')) + '=' + encodeURIComponent($(this).val()) + '&';
        });

    }

    var inv1 = (opc_invoice_first) ? '_invoice' : '';

    params += 'customer_lastname=' + encodeURIComponent($('#lastname'+inv1).val()) + '&';
    params += 'customer_firstname=' + encodeURIComponent($('#firstname'+inv1).val()) + '&';
    params += 'alias=' + encodeURIComponent($('#alias'+inv1).val()) + '&';
    params += 'default_alias=' + encodeURIComponent($('#default_alias'+inv1).val()) + '&';
    params += 'other=' + encodeURIComponent($('#other').val()) + '&';
    params += 'is_new_customer=' + encodeURIComponent($('#is_new_customer').val()) + '&';
    // Clean the last &
    params = params.substr(0, params.length - 1);

    var ret_value = true;
    $.ajax({
        type:'POST',
        url:callingFile,
        async:true,
        cache:false,
        dataType:"json",
        data:'ajax=true&' + params + '&token=' + static_token,
        success:function (jsonData) {
            if (jsonData.hasError) {
                var tmp = '';
                var i = 0;
                for (error in jsonData.errors)
                    //IE6 bug fix
                    if (error != 'indexOf') {
                        i = i + 1;
                        tmp += '<li>' + jsonData.errors[error] + '</li>';
                    }
                tmp += '</ol>';
                var errors = '<b>' + txtThereis + ' ' + i + ' ' + txtErrors + ':</b><ol>' + tmp;
                $('#opc_account_errors'+((opc_invoice_first)?'_invoice':'')).html(errors).slideDown('slow');
                $.fn.scrollToElement('#opc_account_errors'+((opc_invoice_first)?'_invoice':''), 800);
                ret_value = false;
                // Inline validation including empty fields
                var skipEmpty = false;
                if (opc_inline_validation == "1")
                    validateAllFieldsNow(skipEmpty);
            }

            isGuest = ($('#is_new_customer').val() == 1 ? 0 : 1);

            if (jsonData.id_customer != undefined && jsonData.id_customer != 0 && jsonData.isSaved) {
                // update token
                static_token = jsonData.token;

                // update addresses id
                // if (jsonData.id_address_delivery != undefined)
                //     $('input#opc_id_address_delivery').val(jsonData.id_address_delivery);
                // if (jsonData.id_address_invoice != undefined)
                //     $('input#opc_id_address_invoice').val(jsonData.id_address_invoice);

                // It's not a new customer
                if ($('input#opc_id_customer').val() != '0' && (!opc_invoice_first || $('#delivery_address:checked').length != 0)) {
                    if (!saveAddress('delivery')) {
                        processing_payment = false;// Enable payment buttons again
                        ret_value = false;
                        return false;
                    }
                }

                // update id_customer
                $('input#opc_id_customer').val(jsonData.id_customer);

                if (opc_invoice_first || $('#invoice_address:checked').length != 0) {
                    if (!saveAddress('invoice')) {
                        processing_payment = false;// Enable payment buttons again
                        ret_value = false;
                        return false;
                    }
                }



                // update id_customer
                $('input#opc_id_customer').val(jsonData.id_customer);

                // force to refresh carrier list
                /*	if (isGuest)
                 {
                 $('#opc_account_saved').fadeIn('slow');
                 $('#submitAccount').hide();
                 updateAddressSelection();
                 }
                 */
                //else
                //	updateNewAccountToAddressBlock();

            }
            $('#opc_new_account-overlay').fadeOut('slow');
            $('#opc_delivery_methods-overlay').fadeOut('slow');
            $('#opc_payment_methods-overlay').fadeOut('slow');
            setPaymentModuleHandler();

            if (ret_value && payment_module_button != null) {
                if (opc_relay_update == "1") {
                    updatePaymentsOnly();
                    if (payment_module_button.attr('id') != undefined)
                        payment_module_button = $('#' + payment_module_button.attr('id'));
                }
                var link_href = payment_module_button.attr("href");
                if (link_href !== undefined) {
                    // eval link_href
                    if (link_href.indexOf('javascript') == 0) {
                        if (link_href.indexOf('stripe-payment-form')<0) {
                            programatically_clicked = true;
                        }
                        eval(link_href);
                    }
                    else
                      window.location.href = link_href; 
                } else {
                    programatically_clicked = true;
                    payment_module_button.click();
                }
            } else if (ret_value && payment_module_button == null) {
                processing_payment = false;// Enable payment buttons again
                updatePaymentsOnly();
                $('div.save-account-button-container, div.save-account-overlay').fadeOut('fast');
            } else {
                processing_payment = false;// Enable payment buttons again
            }//if (ret_value)


        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
            if (textStatus != 'abort' && XMLHttpRequest.status != 0)
                alert("TECHNICAL ERROR: unable to save account \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
            ret_value = false;
        }
    });
    return ret_value;

}//submitAccount()

var isFixedCart = false;
var isFixedInfo = false;
var isFixedSummary = false;
var isFixedHeaderCart = false;
var cart_block, cart_block_anchor, info_block_anchor;
var topOffsetCart, topOffsetSummary, topOffsetInfoBlock, topOffsetBeforeInfoBlock, staticWidth;
var tfoot_static, tfoot_static_underlay, order_detail_content;
var info_below_cart = true;
var info_below_header_cart = false;
var cart_position = "static"; // set to actual position when changing to fixed
var cart_top = 0; // set to actual top position when changing to fixed
var topOffsetHeaderCart, header_cart_nav, header_cart_block, cart_nav_anchor, cart_nav_position, cart_nav_top, header_cart_block_position, header_cart_block_top;



function setScrollHandler() {
    info_below_cart = (typeof opc_before_info_element !== 'undefined' && opc_before_info_element == '#cart_block' && scroll_cart && scroll_info);
    info_below_header_cart = (typeof opc_before_info_element !== 'undefined' && opc_before_info_element == '#cart_block .block_content' && scroll_header_cart && scroll_info);

    if (scroll_cart || scroll_header_cart || scroll_summary || scroll_info) {
        if (scroll_cart /*&& (window.ajaxCart !== undefined)*/) {
            // cart scrolling
            if (info_below_cart)
                cart_block = $("#cart_scroll_section");
            else
                cart_block = $("#cart_block");

            if (cart_block.length > 0) {
                cart_block.css('z-index', 100);
                cart_block.before("<div id=\"cart_block_anchor\" style=\"display:none; height:1px;\">&nbsp;</div>");
                cart_block_anchor = $("#cart_block_anchor");

                topOffsetCart = cart_block.offset().top;
            } else {
                scroll_cart = false;
            }
        }

        if (scroll_header_cart) {
            header_cart_nav = $("#header_user ul#header_nav");
            header_cart_block = $("#cart_block");
            header_cart_block_top = header_cart_block.css("top");
            header_cart_nav.before("<div id=\"cart_nav_anchor\" style=\"display:none; border: 1px solid red;  float: right;\"></div>");
            cart_nav_anchor = $("#cart_nav_anchor");
            cart_nav_anchor.css('width', header_cart_nav.width()).css('margin-bottom', header_cart_nav.height());
            topOffsetHeaderCart = header_cart_nav.offset().top;
        }

        if (scroll_info && !info_below_cart && !info_below_header_cart) {
            info_block = $("#opc_info_block");
            info_block.css('z-index', 100);
            info_block.before("<div id=\"info_block_anchor\" style=\"display:none; height:1px;\">&nbsp;</div>");
            info_block_anchor = $("#info_block_anchor");

            if ($(opc_before_info_element).length > 0)
                topOffsetBeforeInfoBlock = $(opc_before_info_element).offset().top;
        }

        if (scroll_summary) {
            // sumary scrolling
            tfoot_static = $("#tfoot_static");
            tfoot_static_underlay = $("#tfoot_static_underlay");
            order_detail_content = $("#order-detail-content");

            if (scroll_products && $("#cart_summary").height() < 370)
                tfoot_static = $("#cart_summary");

            topOffsetSummary = tfoot_static.offset().top - parseFloat(tfoot_static.css('margin-top').replace(/auto/, 0));
            staticWidth = tfoot_static.width();
            tfoot_static_underlay.width(tfoot_static.width());
            tfoot_static_underlay.height(tfoot_static.height());
        }


        $(window).scroll(scroll_handler);
    }//if(scroll_cart||scroll_summary)
}//setScrollHandler()

function scroll_handler() {
    var y = $(this).scrollTop();
//console.info('scrolled to '+y+', isFixed: cart, info, summary'+isFixedCart+isFixedInfo+isFixedSummary+', topOffsetInfo='+topOffsetInfoBlock);
    if (scroll_cart) {
        if (!isFixedCart && y >= topOffsetCart) {
            cart_block_anchor.show();
            cart_position = cart_block.css("position");
            if (cart_position != "absolute" && cart_position != "static")
                cart_position = "static";
            cart_top = cart_block.css("top");
            if (cart_top == "")
                cart_top = 0;

            cart_block.css("position", "fixed").css("top", 0);
            cart_block_anchor.css("margin-bottom", cart_block.height() + parseFloat(cart_block.css('margin-bottom').replace(/auto/, 0)));
            isFixedCart = true;
            if (!info_block_displayed && info_below_cart) displayInfoBlock();
        } else {
            if (isFixedCart && y < topOffsetCart) {
                cart_block_anchor.hide();
                cart_block.css("position", cart_position);
                cart_block.css("top", cart_top);
                cart_block_anchor.css("margin-bottom", 0);
                isFixedCart = false;
                //if (info_block_displayed) hideInfoBlock();
            }
        }
    }//if(scroll_cart)

    if (scroll_header_cart) {

        if (!isFixedHeaderCart && y >= topOffsetHeaderCart) {
            var left_offset = header_cart_nav.offset().left;
            cart_nav_anchor.show();
            cart_nav_position = header_cart_nav.css("position");
            header_cart_block_position = header_cart_block.css("position");
            //cart_nav_top = header_cart_nav.css("top");
            //header_cart_block_left = header_cart_block

            header_cart_nav.css('position', 'fixed').css("top", 0).css('left', left_offset);
            header_cart_block.css('position', 'fixed').css("top", header_cart_nav.height()).css('left', left_offset);

            cart_nav_anchor.css("margin-bottom", header_cart_nav.height() + parseFloat(header_cart_nav.css('margin-bottom').replace(/auto/, 0)));
            header_cart_block.slideDown();
            isFixedHeaderCart = true;
            if (!info_block_displayed && info_below_header_cart) displayInfoBlock();
        } else {
            if (isFixedHeaderCart && y < topOffsetHeaderCart) {
                cart_nav_anchor.hide();
                header_cart_nav.css("position", cart_nav_position);
                header_cart_block.css("top", header_cart_block_top);
                //header_cart_block.css("position", header_cart_block_position);
                //header_cart_nav.css("top", cart_nav_top);
                //cart_nav_anchor.css("margin-bottom", 0);
                header_cart_block.slideUp();
                isFixedHeaderCart = false;
                //if (info_block_displayed) hideInfoBlock();
            }
        }
    }


    if (scroll_info && !info_below_cart && !info_below_header_cart) {

        if (!isFixedInfo && y >= topOffsetBeforeInfoBlock && !info_block_displayed) {
            displayInfoBlock();
            topOffsetInfoBlock = $("#opc_info_block").offset().top;
        }
        if (!isFixedInfo && y >= topOffsetInfoBlock && topOffsetInfoBlock !== undefined) {
            info_block_anchor.show();
            info_block.css("position", "fixed").css("top", 0);
            info_block_anchor.css("margin-bottom", info_block.height() + parseFloat(info_block.css('margin-bottom').replace(/auto/, 0)));
            isFixedInfo = true;
            //if (!info_block_displayed) displayInfoBlock();
        } else {
            if (isFixedInfo && y < topOffsetInfoBlock) {
                info_block_anchor.hide();
                info_block.css("position", "static");
                info_block_anchor.css("margin-bottom", 0);
                isFixedInfo = false;
                //if (info_block_displayed) hideInfoBlock();
            }
        }
    }//if(scroll_cart)
    if (scroll_summary) {
        if (!isFixedSummary && y >= topOffsetSummary/* && tfoot_static.height() < 300*/) {
            tfoot_static_underlay.show();
            tfoot_static.css("position", "fixed").css("top", 0).width(staticWidth);
            order_detail_content.css("margin-bottom", tfoot_static.height());
            tfoot_static.addClass('floating-summary');
            tfoot_static_underlay.height(tfoot_static.height());
            isFixedSummary = true;
        } else {
            if (isFixedSummary && y < topOffsetSummary) {
                tfoot_static_underlay.hide();
                tfoot_static.css("position", "static");
                order_detail_content.css("margin-bottom", 0);
                tfoot_static.removeClass('floating-summary');
                isFixedSummary = false;
            }
        }
    }//if(scroll_summary)

}


function _sanitizePaymentOnClick(link_el) {
    // fix parsing issues with certain payment mods which has onclick handler hardcoded (like Paypal in PS 1.5)
    var onclick = link_el.attr('onclick');
    if (onclick !== undefined)
    {
        onclick = onclick.replace(/\ *javascript\ *:/gi,'');
        link_el.attr('href', 'javascript:'+onclick);
        link_el.removeAttr('onclick');
        //console.info('yes, removed on ');
        //console.info(link_el);
    }
}

function sanitizePaymentOnClicks() {
    $('.payment_module a').each(function() {_sanitizePaymentOnClick($(this));})
}


function _payment_module_handler(e) {
    if (programatically_clicked) {
        programatically_clicked = false;
        // Let the default payment action proceed
        return true;
    } else {
        // Interrupt payment attempt, save account and trigger payment action again from submitAccount - if successful
        e.stopImmediatePropagation();
    }
    // disable repeated click, if it's in 5 sec. time frame
    if (processing_payment && (new Date().getTime() < processing_since + 5000)) {
        alert("Please wait 5 seconds before next try.");
        return false;
    }
    processing_payment = true;
    processing_since = new Date().getTime();

    var el = $(e.target);
    var levels = 3; // search for clickable parent this much levels

    while (levels > 0 && !el.is("input") && !el.is("a") && !el.is("button")) {
        el = el.parent();
        levels--;
    }

    if (levels == 0) // we haven't found payment link, restore;
    {
        processing_payment = false;
        return false;
    }

    var ret = submitAccount(el);
    if (ret) {
        $('registerme').hide();
    }
    return false;
}


function updatePaymentFee() {
   /*     // COD+Fee payment?
        var codFeeEl = $('input[name=id_payment_method]:checked').closest('tr').find('#pscodfee-id')
        if (codFeeEl.length) 
        {
            // Add Fee to summary; also fee addition is necessary in cart-summary script
            //origTotal = parseFloat($('#total_price').html().replace(',', '.'));
            var codfeeAmount = parseFloat(codFeeEl.html().replace(',', '.').replace('$','').replace('£',''));
            var total_price_with_fee = origTotal + codfeeAmount;
            $('#total_price').html(formatCurrency(total_price_with_fee, currencyFormat, currencySign, currencyBlank));
            $('tr.codfee td#total_codefee').html(formatCurrency(codfeeAmount, currencyFormat, currencySign, currencyBlank));
            $('tr.codfee').show();
        } else {
            if (origTotal > -1 && $('tr.codfee').is(":visible")) {
                $('#total_price').html(formatCurrency(origTotal, currencyFormat, currencySign, currencyBlank));
                $('tr.codfee').hide();
            }
        }
        */
}

function paymentChange() {
    var selected_line = $('input[name=id_payment_method]:checked').closest('tr');
    $('#paymentMethodsTable .cc-form').hide();
    selected_line.next('.cc-form').show();

    updatePaymentFee();
}

var payment_ret_val = true;
var programatically_clicked = false;
var processing_payment = false;
var processing_since = 0;

function setPaymentModuleHandler() {

    sanitizePaymentOnClicks();

    fixPaymentImageCss();


    // Add submitAccount handler first, on top of click handler queue - for special payment options only
    // CC payments: add selector here and also .not() selector bellow
    var sel = $('form#paypalpro_form input#paypalpro_submit, form[name=cs_cardsave_direct_form] input#asubmit, form#stripe-payment-form .stripe-submit-button, form#authorizeaim_form input#asubmit, form#braintree-payment-form input[name=submitPayment], form#braintree-payment-form input[name=submitCardPayment]');
    var handlers = new Array();
    var s1 = "";

    sel.each(function() {
        handlers = new Array();
//        console.info($(this));
        if ($(this).data("events") !== undefined)
          handlers = $(this).data("events")['click'];
        s1 = "";
//        console.info("handlers length: "+handlers.length);
        for (var i=0;i<handlers.length;i++)
            s1+=handlers[i].handler.toString();
//        console.info(s1);
        if (s1.match(/_payment_module_handler/) === null)
        {
            $(this).click(_payment_module_handler);
            var handler = handlers.pop();
            handlers.splice(0, 0, handler);
        }
    });


    // Payment modules - safe mode (OPCKT), including .not() selector for CC .payment_module containers
    $('.payment_module').not($('a#click_cs_cardsave_direct').parent()).not($('form#stripe-payment-form').parent()).not($('div#braintree-form').parent()).not($('#authorizeaim_form').parent()).unbind('click').click(_payment_module_handler);

    // Payment modules error message hide (OPCKT)
    $('input[name=id_payment_method]').unbind('change').change(function () {
        $('#opc_payment_errors').slideUp('slow');
        if (typeof setPersonalDetailsPayment == 'function')
            setPersonalDetailsPayment(); // handle order review detail boxes (German law since 1.8.2012)
    });
    if (typeof setPersonalDetailsPayment == 'function')
        setPersonalDetailsPayment();

    $('input[name=id_payment_method]').change(paymentChange);
}//setPaymentModuleHandler()

function paymentModuleConfirm() {
    var errors = '';
    var link_id = $('input[name=id_payment_method]:checked').val();
    if (link_id === undefined) {
        errors = '<b>' + errorPayment + '</b>';
        $('#opc_payment_errors').html(errors).slideUp('fast').slideDown('slow');
        $.fn.scrollToElement('#opc_payment_errors', 500);
    } else {
        link_id = '#' + link_id;
        var link_el = $(link_id);

        /*
        // fix parsing issues with certain payment mods which has onclick handler hardcoded (like Paypal in PS 1.5)
        var onclick = link_el.attr('onclick');
        if (onclick !== undefined)
        {
            onclick = onclick.replace(/\ *javascript\ *:/gi,'');
            link_el.attr('href', 'javascript:'+onclick);
            link_el.removeAttr('onclick');
        }*/

        setPaymentModuleHandler(); // to restore handlers after ePay modal window has been closed
        link_el.click();
        // var link_href = $(link_id).attr("href");
        // if (link_href !== undefined && payment_ret_val) {
        //     window.location.href = link_href;
        // }
    }
}


function cartBlockCheckoutButtonHandler() {


    $.fn.scrollToElement('#opc_payment_methods', 1200, true);

    //$("#opc_payment_methods").prev("div")
    $('#opc_payment_methods').fadeTo(800, 0.2, function () {
        $('#opc_payment_methods').fadeTo(400, 0.9, function () {
            $('#opc_payment_methods').fadeTo(400, 0.4, function () {
                $('#opc_payment_methods').fadeTo(400, 1);
            });
        });
    });
    return false;

}

function country_change_handler(force_display) {
    pre_saveAddress('delivery');
    if (onlyCartSummary == '0') {
        validateFieldAndDisplayInline($('#postcode'));
    }
    return false;
}//country_change_handler()


function state_change_handler(force_display) {
    pre_saveAddress('delivery');
}//state_change_handler()

function postcode_change_handler(force_display) {
    pre_saveAddress('delivery');
    if (confirmButtonPressed) {
        confirmButtonPressed = false;
        //$('#postcode').fadeIn('1000',paymentModuleConfirm);
        paymentModuleConfirm();
    }
}//postcode_change_handler()

function invoice_country_change_handler(force_display) {
    pre_saveAddress('invoice');
    validateFieldAndDisplayInline($('#postcode_invoice'));
    return false;
}
function invoice_state_change_handler(force_display) {
    pre_saveAddress('invoice');
}

function overrideCountryCombo(without_DNI_and_Zip) {
    $('#id_country').unbind('change').change(function () {
        updateState(); // USA states
        if (!without_DNI_and_Zip) {
            updateNeedIDNumber(); // Spanish DNI
            updateZipCode();
        }
        country_change_handler(false);
    });
}

function overrideStateCombo() {
    $('#id_state').unbind('change').change(function () {
        state_change_handler(false);
        // updateState(); // USA states
    });
}

function overridePostcode() {
    $('#postcode').unbind('change').change(function () {
        postcode_change_handler(false);
    });
}

function overrideCity() {
    $('#city').unbind('change').change(function () {
        postcode_change_handler(false); // Yes, same handler is used here as in overridePostcode
    });
}

function overrideItemHandlers() {

    overrideCountryCombo();
    overrideStateCombo();

    //$('#postcode').unbind('keyup').keyup(function() {$('#postcode').val($('#postcode').val().toUpperCase())});
    if (opc_live_zip == "1" || opc_live_city == "1") {
        if (opc_live_zip == "1")
            overridePostcode();
        if (opc_live_city == "1")
            overrideCity();
        $('div.confirm_button_div input.confirm_button').mousedown(function() {confirmButtonPressed = true;})
        $('div.confirm_button_div input.confirm_button').mouseup(function() {confirmButtonPressed = false;})
    }

    $('#id_country_invoice').unbind('change').change(function () {
        updateState('invoice'); // USA states
        updateNeedIDNumber('invoice'); // Spanish DNI
        updateZipCode('invoice');
        invoice_country_change_handler(false);
    });

    $('#id_state_invoice').unbind('change').change(function () {
        invoice_state_change_handler(false);
        // updateState(); // USA states
    });
//    $('input[name=submitAddDiscount]').unbind('click').click(function () {
//        submitDiscount('add');
//        return false;
//    });
//    overrideDeleteDiscount();

    $('a.existing_email_login').click(function () {
        $('#login_form_content #login_email').val($('#new_account_form #email').val());
        if (!$('#login_form_content').is(':visible')) {
            _openLoginFormBlock(function() {$('#login_form_content #login_passwd').focus();});
        }
        return false;
    });

}//overrideItemHandlers()


//function overrideDeleteDiscount() {
//    $('td.cart_discount_delete a, #cart_block_list table#vouchers td.delete a').unbind('click').click(function () {
//        var orig_link = $(this).attr('href');
//        var id_discount = orig_link.match(/deleteDiscount=(\d+)/);
//        submitDiscount('delete', id_discount[1]);
//        return false;
//    });
//}

function setSampleHints() {
    if (typeof opc_sample_values !== 'undefined' && opc_sample_values == "1") {
        $('form#new_account_form input, form#offer_password input').focus(function () {
            $(this).nextAll('span.sample_text').removeClass('ex_blur').addClass('ex_focus');
            return false;
        });
        $('form#new_account_form input, form#offer_password input').blur(function () {
            $(this).nextAll('span.sample_text').removeClass('ex_focus').addClass('ex_blur');
            return false;
        });
    }//if(opc_sample_values)
}//setSampleHints()


// required, validation_method, min_length
var fields_definition = {
    'email':[true, 'isEmail', 3],
    'passwd':[true, 'isPassword', 5],
//  'days': [false, 'isNumber', 1],
//  'months': [false, 'isNumber', 1],
//  'years': [false, 'isNumber', 4],
    'company':[false, 'isCompany', 2],
    'dni':[true, 'isText', 8],
    'vat_number':[false, 'isText', 8],
    'firstname':[true, 'isText', 2],
    'lastname':[true, 'isText', 2],
    'address1':[true, 'isAddress', 3],
    'address2':[false, 'isText', 2],
    'postcode':[true, 'isPostcode', 3],
    'city':[true, 'isText', 2],
    'id_country':[true, 'isNumber', 1],
    'id_state':[true, 'isNumber', 1],
    'phone_mobile':[true, 'isPhone', 6],
    'phone':[false, 'isPhone', 6],
    'other':[false, 'isText', 2],
    'company_invoice':[false, 'isCompanyInvoice', 2],
    'dni_invoice':[true, 'isText', 8],
    'vat_number_invoice':[false, 'isText', 8],
    'firstname_invoice':[true, 'isText', 2],
    'lastname_invoice':[true, 'isText', 2],
    'address1_invoice':[true, 'isAddress', 3],
    'address2_invoice':[false, 'isText', 2],
    'postcode_invoice':[true, 'isPostcode', 3],
    'city_invoice':[true, 'isText', 2],
    'id_country_invoice':[true, 'isNumber', 1],
    'id_state_invoice':[true, 'isNumber', 1],
    'phone_mobile_invoice':[true, 'isPhone', 6],
    'phone_invoice':[false, 'isPhone', 6],
    'other_invoice':[false, 'isText', 2]
}

function showVatNumberBlock(field_value, invoice)
{
    var inv = (invoice)?"_invoice":"";

    if (field_value != '')
        $('#vat_number_block'+inv).show();
    else
        $('#vat_number_block'+inv).hide();
    return true;
}

function isCompany(field_value, min_length) {
    if (typeof opc_company_based_vat !== 'undefined' && jQuery.trim(opc_company_based_vat) == "1")
        return showVatNumberBlock(field_value, false);
    else
        return isText(field_value, min_length);
}

function isCompanyInvoice(field_value, min_length) {
    if (typeof opc_company_based_vat !== 'undefined' && jQuery.trim(opc_company_based_vat) == "1")
        return showVatNumberBlock(field_value, true);
    else
        return isText(field_value, min_length);
}

function isText(field_value, min_length) {
    return (field_value.length >= min_length)
}

function isAddress(field_name, field_value, min_length) {

    if (field_value.length < min_length)
        return false;
    if (opc_check_number_in_address == "1") {
        var pattern = /\d/;
        if (!field_value.match(pattern)) {
            notificationMessage($('#' + field_name).parent(), ntf_number_in_address_missing);
            return false;
        }
        else {
            closeNotificationMessage($('#' + field_name).parent());
            return true;
        }
    } else {
        return true;
    }
}//isAddress()

function isEmail(field_value, min_length) {
    // ajax query - is this email already used? Offer log-in
    var password_shown = $('#login_form').css('display') === 'block'; //$('#login_form').is(':visible');

    if (password_shown) {
        var email_field = $('#new_account_form #email');
        var email = email_field.val();
        if (email != '') {
            $.ajax({
                type:'POST',
                url:orderOpcUrl,
                async:true,
                cache:false,
                dataType:"json",
                data:'ajax=true&method=emailCheck&cust_email=' + email,
                success:function (jsonData) {
                    if (jsonData.is_registered == 1) {
                        $('p#p_registerme, form#offer_password, p#opc_password, #email_verify_cont').hide();
                        if (ps_guest_checkout_enabled == "1") {
                            $('#existing_email_msg').show();
                            // untick create account
                            if ($('#is_new_customer').val() == 1) {
                                $('#is_new_customer').val(0);
                                var x = $('#registerme').attr('checked', false);
                                if (typeof $.uniform !== 'undefined')
                                    $.uniform.update(x);
                            }
                        } else {
                            $('#must_login_msg').show();
                        }
                    }
                    else {

                        $('form#offer_password, #email_verify_cont').show();

                        if (ps_guest_checkout_enabled == "1" || opc_display_password_msg == "1") {
                            $('p#p_registerme').show();

                            if ($('#is_new_customer').val() == "1") {
                                var x = $('#registerme').attr('checked', 'checked');
                                if (typeof $.uniform !== 'undefined')
                                    $.uniform.update(x);
                            }
                        }

                        if ($('#registerme').is(':checked'))
                            $('p#opc_password').show();

                        if (ps_guest_checkout_enabled == "1") {
                            $('#existing_email_msg').hide();
                        } else {
                            $('#must_login_msg').hide();
                        }
                    }
                    var formatOk = (/^.+@.+\..+$/i.test(field_value) && field_value.length >= min_length)
                    if (formatOk) {
                        email_field.removeClass("error_field").addClass("ok_field");
                    } else {
                        email_field.removeClass("ok_field").addClass("error_field");
                    }
                    if (opc_validation_checkboxes == "1")
                        if (formatOk) {
                            email_field.nextAll('span.validity').removeClass('valid_loading').addClass('valid_ok');
                        } else {
                            email_field.nextAll('span.validity').removeClass('valid_loading').addClass('valid_nok');
                        }
                }//sucess:
            });
            return 3; // loader
        }//if(email!='')
        //console.info('blur: '+$(this).val()+','+$(this).attr('name'));

    }//if(password_shown)
    return (/^.+@.+\..+$/i.test(field_value) && field_value.length >= min_length);
}//isEmail()

function isPostcode(field_name, field_value, min_length) {

    // field_name can be postcode or postcode_invoice, depending on that we'll pass correct id_country
    var id_country = (field_name == 'postcode') ? $('#id_country').val() : $('#id_country_invoice').val();
    var postcode_field = $('#' + field_name);
    var result_ok = false;

    var additionalParams = _getAdditionalUrlParams();

    if (field_value != "" && id_country != "") {
        $.ajax({
            type:'POST',
            url:orderOpcUrl,
            async:true,
            cache:false,
            dataType:"json",
            data:'ajax=true&method=zipCheck&id_country=' + id_country + '&postcode=' + field_value + additionalParams,
            success:function (jsonData) {
                if (jsonData.is_ok) {
                    result_ok = true;
                    if (typeof opc_inline_validation !== 'undefined' && opc_inline_validation == "1")
                    { postcode_field.removeClass("error_field").addClass("ok_field"); }
                } else {
                    if (typeof opc_inline_validation !== 'undefined' && opc_inline_validation == "1")
                    { postcode_field.removeClass("ok_field").addClass("error_field"); }
                }

                if (typeof opc_inline_validation !== 'undefined' && opc_inline_validation == "1" && opc_validation_checkboxes == "1")
                    if (jsonData.is_ok) {
                        postcode_field.nextAll('span.validity').removeClass('valid_loading').addClass('valid_ok');
                    } else {
                        postcode_field.nextAll('span.validity').removeClass('valid_loading').addClass('valid_nok');
                    }

            }//sucess:
        });
        return 3; // loader
    }//if(field_value!=''&&id_country!='')
    //console.info('blur: '+$(this).val()+','+$(this).attr('name'));

    return (field_value.length >= min_length);
}//isPostcode()

function isPassword(field_value, min_length) {
    return (field_value.length >= min_length)
}

function isNumber(field_value, min_length) {
    return (/^\d+$/i.test(field_value) && field_value.length >= min_length)
}

function isPhone(field_value, min_length) {
    return (/^[0-9-. _+,]+$/i.test(field_value) && field_value.length >= min_length)
}

// returns: 0: invalid/required, 1: valid, 2: invalid/not-required
function validateField(field_name, field_value) {
    var field_def = fields_definition[field_name];
    field_value = jQuery.trim(field_value);
    var validity_check = 1;
    if (field_def !== undefined) {
        var valid = true;
        if (field_def[1] == 'isText')
            valid = isText(field_value, field_def[2]);
        else if (field_def[1] == 'isEmail')
            valid = isEmail(field_value, field_def[2]);
        else if (field_def[1] == 'isAddress')
            valid = isAddress(field_name, field_value, field_def[2]);
        else if (field_def[1] == 'isPostcode')
            valid = isPostcode(field_name, field_value, field_def[2]);
        else if (field_def[1] == 'isPassword')
            valid = isPassword(field_value, field_def[2]);
        else if (field_def[1] == 'isNumber')
            valid = isNumber(field_value, field_def[2]);
        else if (field_def[1] == 'isPhone')
            valid = isPhone(field_value, field_def[2]);
        else if (field_def[1] == 'isCompany')
            valid = isCompany(field_value, field_def[2]);
        else if (field_def[1] == 'isCompanyInvoice')
            valid = isCompanyInvoice(field_value, field_def[2]);

        if (valid) {
            if (valid == 3)
                validity_check = 3; // just display loader and wait for ajax
            else
                validity_check = 1;
        } else {
            if (field_def[0]) // is required?
                validity_check = 0;
            else {
                if (field_value == '') // is empty?
                    validity_check = 1;
                else
                    validity_check = 2;
            }
        }
    }
    return validity_check;
}


function validateFieldAndDisplayInline(_this, dont_highlight) {
    var validity_check = validateField(_this.attr('name'), _this.val());
    if (typeof dont_highlight !== 'undefined' && dont_highlight == true)
        return;

    if (typeof opc_inline_validation === 'undefined' || opc_inline_validation == "0")
        return;
    
    //console.info(_this.val()+' on name='+_this.attr('name')+'validity_check='+validity_check);
    if (validity_check == 0) { // invalid & required
        _this.removeClass("ok_field").addClass("error_field");
        // and display red triangle or exclamation mark
        if (opc_validation_checkboxes == "1")
            _this.nextAll('span.validity').removeClass('valid_ok').removeClass('valid_blank').removeClass('valid_loading').removeClass('valid_warn').addClass('valid_nok');
    }
    else if (validity_check == 1) { // valid
        _this.removeClass("error_field").addClass("ok_field");
        // and display green check
        if (opc_validation_checkboxes == "1")
            _this.nextAll('span.validity').removeClass('valid_nok').removeClass('valid_blank').removeClass('valid_loading').removeClass('valid_warn').addClass('valid_ok');
    }
    else if (validity_check == 2) { // invalid but not required
        // remove green check
        _this.removeClass("ok_field").addClass("error_field");
        if (opc_validation_checkboxes == "1")
            _this.nextAll('span.validity').removeClass('valid_nok').removeClass('valid_ok').removeClass('valid_loading').removeClass('valid_blank').addClass('valid_warn');
    }
    else if (validity_check == 3) { // display ajax loader, result will be set in ajax call "success"
        // remove green check
        if (opc_validation_checkboxes == "1")
            _this.nextAll('span.validity').removeClass('valid_nok').removeClass('valid_ok').removeClass('valid_loading').removeClass('valid_blank').removeClass('valid_warn').addClass('valid_loading');
    }

}

function validateAllFieldsNow(skipEmpty) {
    $('form#new_account_form input[type=text], form#new_account_form input[type=password], form#new_account_form select , form#new_account_form textarea, form#offer_password input[type=password]').each(function () {
        if (!skipEmpty || jQuery.trim($(this).val()) != "")
            validateFieldAndDisplayInline($(this));
    });
}

function setFieldValidation() {
    // set Blur validation
    $('form#new_account_form input[type=text], form#new_account_form input[type=password], form#new_account_form select , form#new_account_form textarea, form#offer_password input[type=password]').blur(function () {
        validateFieldAndDisplayInline($(this));
    });

    $('#company, #company_invoice').keyup(function () {
        validateFieldAndDisplayInline($(this));
    });

    // validate on page load - only for non-empty fields!
    var skipEmpty = true;
    validateAllFieldsNow(skipEmpty);
}

function setFieldCookieCache() {
    $('form#new_account_form input[type=text], form#new_account_form input[type=password], form#new_account_form select , form#new_account_form textarea, form#offer_password input[type=password]').blur(function () {
        saveToCheckoutCookie();
    });
}

var info_block_displayed = false;

function _isInfoBlockEnabled() {
    return (typeof opc_display_info_block !== "undefined" && opc_display_info_block == '1' && $('div#cart_block').length && jQuery.trim(opc_info_block_content) != '');
}
function addInfoBlock() {
    if (_isInfoBlockEnabled()) {
//	  $('div#cart_block').wrap('<div id="cart_scroll_section" />');
        if (typeof opc_before_info_element !== 'undefined' && opc_before_info_element == '#cart_block' && opc_scroll_cart == "1") {
            $('div#cart_block').wrap('<div id="cart_scroll_section" />');
            $('div#cart_block').after('<div id="opc_info_block" class="block">' + opc_info_block_content + '</div>');
            $('div#opc_info_block').css('width', $('#cart_block').css('width'));
        } else {
            if (typeof opc_before_info_element !== 'undefined' && $(opc_before_info_element).length > 0)
                $(opc_before_info_element).after('<div id="opc_info_block" class="block">' + opc_info_block_content + '</div>');
        }

        if (isFixedCart)
            displayInfoBlock();
    }
}

function displayInfoBlock() {
    if (_isInfoBlockEnabled()) {
        $('div#opc_info_block').slideDown(800).fadeTo(1000, 1); //, function() {$(this).fadeIn(2000);});
        info_block_displayed = true;
    }
}

function hideInfoBlock() {
    // Disabled for now
    /*if (_isInfoBlockEnabled()) {
     $('div#opc_info_block').slideUp();
     info_block_displayed = false;
     }*/
}

function toggle_info_block(collapseStr, expandStr) {
    if ($('#opc_info_block .block_content:visible').length > 0) {
        $('#opc_info_block .block_content').slideToggle('slow');
        $('#toggle_link').html(expandStr);
    } else {
        $('#opc_info_block .block_content').slideToggle('slow');
        $('#toggle_link').html(collapseStr);
    }
}

// override method with same name in themes/prestashop/js/cart-summary.js
function updateHookShoppingCartExtra(html) {
    $('#HOOK_SHOPPING_CART_EXTRA').html(html);
    if ($('#emptyCartWarning').is(":visible")) {
        // reload page so that all opc related JS tunings (page fading, sticky cart, info box) disappear
        location.reload();
    }
}


// container = element to put message into
// text = what you want the message to say
function notificationMessage(container, text) {
    var notificationDiv = $('div.uniqueNotification', container);

    if (notificationDiv.length == 0) {
        var msg = $('<div class="uniqueNotification"/>').addClass('classic tooltip').html('<a class="x" title="' + ntf_close + '">[x]</a><div class="msg">' + text + '</div>').bind('click', function () {
            $(this).hide();
            $(this).prevAll('input').removeClass("error_field").addClass("ok_field");
            if (opc_validation_checkboxes == "1")
                $(this).prevAll('span.validity').removeClass('valid_nok').removeClass('valid_blank').removeClass('valid_loading').removeClass('valid_warn').addClass('valid_ok');
        });
        container.append(msg);
        msg.slideDown();
    } else if (!notificationDiv.is("visible")) {
        notificationDiv.slideDown();
    }
}

function closeNotificationMessage(parent_element) {
    $('div.uniqueNotification', parent_element).slideUp();
}

function updatePaymentsOnly() {
    $.ajax({
        type:'POST',
        url:orderOpcUrl,
        async:false,
        cache:false,
        dataType:"json",
        data:'ajax=true&method=updatePaymentsOnly&token=' + static_token,
        success:function (json) {

            updatePaymentsHooks(json);

            //sanitizePaymentOnClicks();

            //  $('#opc_payment_methods-parsed-content div#HOOK_PAYMENT_PARSED').html(json.HOOK_PAYMENT.parsed_content);
            //   $('#opc_payment_methods-overlay').fadeOut('slow');
            //    setPaymentModuleHandler();
        }
    });
}

String.prototype.toCapitalize = function () {
    return this.toLowerCase().replace(/^.|\s\S/g, function (a) {
        return a.toUpperCase();
    });
}

var invoice_address_on_ready_call = true;

function bindInputs() {
    // Order message update
    $('#message').unbind('blur').blur(function () {
        //$('#opc_delivery_methods-overlay').fadeIn('slow');
        $.ajax({
            type:'POST',
            url:orderOpcUrl,
            async:true,
            cache:false,
            dataType:"json",
            data:'ajax=true&method=updateMessage&message=' + encodeURIComponent($('#message').val()) + '&token=' + static_token,
            success:function (jsonData) {
                if (jsonData.hasError) {
                    var errors = '';
                    for (error in jsonData.errors)
                        //IE6 bug fix
                        if (error != 'indexOf')
                            errors += jsonData.errors[error] + "\n";
                    alert(errors);
                }
                //else
                   // $('#opc_delivery_methods-overlay').fadeOut('slow');
            },
            error:function (XMLHttpRequest, textStatus, errorThrown) {
                if (textStatus != 'abort' && XMLHttpRequest.status != 0)
                    alert("TECHNICAL ERROR: unable to save message \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
                $('#opc_delivery_methods-overlay').fadeOut('slow');
            }
        });
    });

    // Recyclable checkbox
    $('input#recyclable').unbind('click').click(function () {
        updateCarrierSelectionAndGift();
    });

    // Gift checkbox update
    $('input#gift').unbind('click').click(function () {
        if ($('input#gift').is(':checked'))
            $('p#gift_div').show();
        else
            $('p#gift_div').hide();
        updateCarrierSelectionAndGift();
    });

    if ($('input#gift').is(':checked'))
        $('p#gift_div').show();
    else
        $('p#gift_div').hide();

    if ($('input#registerme').is(':checked'))
        $('p.password').show();
    else
        $('p.password').hide();
        
    //$('#email').trigger('blur'); // restore password field based on input address 
    validateFieldAndDisplayInline($('#email'), true); // restore password field based on input address

    // Gift message update
    $('textarea#gift_message').unbind('change').change(function () {
        updateCarrierSelectionAndGift();
    });

    // Term Of Service (TOS)
    $('#cgv').unbind('click').click(function () {
            if ($('#cgv:checked').length != 0) {
                var checked = 1;
                var x = $('#cgv').attr('checked', 'checked');
                if (typeof $.uniform !== 'undefined')
                    $.uniform.update(x);
                // display green check in place of red exclamation
                $('#opc_tos_errors').slideUp('slow');
                if (typeof opc_inline_validation !== 'undefined' && opc_inline_validation == "1" && opc_validation_checkboxes == "1")
                    //$('#cgv').nextAll('span.validity').removeClass('valid_nok').removeClass('valid_blank').removeClass('valid_loading').removeClass('valid_warn').addClass('valid_ok');
                    $('#cgv').closest('p.checkbox').children('span.validity').removeClass('valid_nok').removeClass('valid_blank').removeClass('valid_loading').removeClass('valid_warn').addClass('valid_ok');
            }
            else {
                var checked = 0;
                var x = $('#cgv').attr('checked', false);
                if (typeof $.uniform !== 'undefined')
                    $.uniform.update(x);
                if (typeof opc_inline_validation !== 'undefined' && opc_inline_validation == "1" && opc_validation_checkboxes == "1")
                    //$('#cgv').nextAll('span.validity').removeClass('valid_ok').removeClass('valid_blank').removeClass('valid_loading').removeClass('valid_warn').addClass('valid_nok');
                    $('#cgv').closest('p.checkbox').children('span.validity').removeClass('valid_ok').removeClass('valid_blank').removeClass('valid_loading').removeClass('valid_warn').addClass('valid_nok');
                // display red exclamation
            }


        // $('#opc_payment_methods-overlay').fadeIn('slow');
        $.ajax({
            type:'POST',
            url:orderOpcUrl,
            async:true,
            cache:false,
            dataType:"json",
            data:'ajax=true&method=updateTOSStatusAndGetPayments&checked=' + checked + '&token=' + static_token,
            success:function (json) {
                //updateCarrierSelectionAndGift();
                //$('div#HOOK_TOP_PAYMENT').html(json.HOOK_TOP_PAYMENT);
                //$('#opc_payment_methods-content div#HOOK_PAYMENT').html(json.HOOK_PAYMENT);
                //$('#opc_payment_methods-overlay').fadeOut('slow');
            }
        });
    });
}

function animateFieldsPadding() {
    if (typeof opc_animate_fields_padding !== "undefined" && opc_animate_fields_padding == "1") {
        var selector = $("#new_account_form p.text,#new_account_form p.password, #new_account_form p.select, #new_account_form p.textarea");
        var paddingSmall = '1px';
        var paddingLarge = '9px';
        var duration = 500;
        if ($('#invoice_address:checked').length > 0) {
            selector.animate({'padding-top':paddingSmall}, duration);
        }
        else {
            selector.animate({'padding-top':paddingLarge}, duration);
        }
    }
}

var confirmButtonPressed = false;

function _closeLoginFormBlock() {
    $('#login_form_content').slideUp('slow');
    $('#closeLoginFormBlock').fadeOut(800);
    $('#openLoginFormBlock').fadeIn('slow');
}

function _openLoginFormBlock(callback) {
    $('#login_form_content').slideDown('slow');
    $('#closeLoginFormBlock').fadeIn(1500);
    if (typeof callback !== "undefined")
        $('#openLoginFormBlock').fadeOut('slow', callback);
    else
        $('#openLoginFormBlock').fadeOut('slow');
}

function addResponsiveLayoutHeaders() {
    var headers = new Array();
    $("table#cart_summary th").each(function() {headers.push($(this).html())});
    for (var i = 0; i < headers.length; i++)
        headers[i] = 'tr.cart_item td:nth-of-type('+(i+1)+'):before{content: "'+headers[i]+'"}';

    var style = $('<style>@media only screen and (max-width:500px){ '+headers.join("\n")+'"}</style>');
    $('html > head').append(style);
}

function saveAccountAndShowPayments() {
    var ret = submitAccount(null);
}

function sampleTextToPlaceholder() {
    if ($.support.placeholder && opc_sample_to_placeholder) {

        $('#opc_checkout p.text input').prop('placeholder', function () {
            var t = $(this).nextAll('.sample_text').text();
            return t.substr(1, t.length - 2);
        });

        $('span.sample_text').hide()
    }
}

//var supportsClassList = (document.body != null) && ({}).toString.call(document.body.classList) == "[object DOMTokenList]";

var getClasses = function(element) {
    // if (supportsClassList)
    //   return element.classList.toString();
    // else
      return element.className.split(/\s+/);
};

function fixPaymentImageCss() {
    if (!window.getComputedStyle)
      return false;
    $('#paymentMethodsTable img.cssback').each(function() {
        //if (typeof this.classList !== 'undefined' && this.classList !== null)
        //    var clName = this.classList[1];
        var clName = getClasses(this).slice(1).join('.'); // <-- for multiple classes style definition
        if (clName !== 'undefined' && $('a.'+clName).length) {
            var clImage = window.getComputedStyle($('a.'+clName).get(0)).backgroundImage;
            if (clImage !== 'undefined')
                $(this).attr('src', clImage .replace(/url\(['"]?(.*?)['"]?\).*/,'$1'));
        }
    });
}


$(document).ready(function () {
    {
        if (typeof opc_move_message !== 'undefined' && jQuery.trim(opc_move_message) == "1") {
            $('<div id="message_moved"></div>').insertBefore('div.confirm_button_div');
        }
        
        if (typeof opc_move_cgv !== 'undefined' && jQuery.trim(opc_move_cgv) == "1") {
            $('<div id="tos_moved"></div>').insertBefore('div.confirm_button_div'); 
            if (isVirtualCart) {
                $('form.no_carriers').hide();
            }
        }
        moveTosAndMessage();
        sampleTextToPlaceholder();

        fixPaymentImageCss();

        if ($.support.placeholder) {
            $("#order_msg_placeholder_fallback").hide();
        }

        initSettings();

        if (typeof onlyCartSummary !== 'undefined' && onlyCartSummary == '1') {
            if ($('#id_country').length > 0) {
                overrideCountryCombo(1);
                overrideStateCombo();
                updateState();
                country_change_handler(false);
            }
            return;
        }

        // LOGIN FORM - efektiky login bloku, X-tlacitko a skryvanie textu
        $('#openLoginFormBlock').click(function () {
            if ($('#login_form_content').is(':visible')) {
                _closeLoginFormBlock();
            } else {
                _openLoginFormBlock();
            }
            return false;
        });
	$('#closeLoginFormBlock').click(function () {
	     $('#openLoginFormBlock').trigger('click');
	     return false;
        });

        // LOGIN FORM SENDING (already registered block)
        $('#SubmitLoginOpc').click(function () {
            $.ajax({
                type:'POST',
                url:authenticationUrl,
                async:false,
                cache:false,
                dataType:"json",
                data:'SubmitLogin=true&ajax=true&email=' + encodeURIComponent($('#login_email').val()) + '&passwd=' + encodeURIComponent($('#login_passwd').val()) + '&token=' + static_token,
                success:function (jsonData) {
                    if (jsonData.hasError) {
                        var errors = '<b>' + txtThereis + ' ' + jsonData.errors.length + ' ' + txtErrors + ':</b><ol>';
                        for (error in jsonData.errors)
                            //IE6 bug fix
                            if (error != 'indexOf')
                                errors += '<li>' + jsonData.errors[error] + '</li>';
                        errors += '</ol>';
                        $('#opc_login_errors').html(errors).slideDown('slow');
                    }
                    else {
                        // update token
                        static_token = jsonData.token;

                        $('#dlv_label, #new_label').removeClass('new-l').addClass('logged-l'); // change label on delivery address section

                        updateNewAccountToAddressBlock();

                        // RESET ERROR(S) MESSAGE(S)
                        $('#opc_account_errors').html('').hide();
                        $('#opc_account_errors_invoice').html('').hide();


                        // Uncomment if you have blockslides module
                        /*
                         $('#toppanel').empty();
                         $('#toppanel').load(authenticationUrl + ' #toppanel> *',function() {
                         // Expand Panel
                         $("#open").click(function(){
                         $("div#panel").slideDown("slow");
                         });
                         // Collapse Panel
                         $("#close").click(function(){
                         $("div#panel").slideUp("slow");
                         });
                         // Switch buttons from "Log In | Register" to "Close Panel" on click
                         $("#toggle a").click(function () {
                         $("#toggle a").toggle();
                         });
                         });
                         */
                    }

                },
                error:function (XMLHttpRequest, textStatus, errorThrown) {
                    if (textStatus != 'abort' && XMLHttpRequest.status != 0)
                        alert("TECHNICAL ERROR: unable to send login informations \n\nDetails:\nError thrown: " + XMLHttpRequest + "\n" + 'Text status: ' + textStatus);
                }
            });
            return false;
        });


        // only for non-empty cart
        if ($('#id_country').length > 0 || $('#new_account_form input#email').length > 0) {

            addInfoBlock();
            setScrollHandler();
            setPaymentModuleHandler();
            overrideItemHandlers();


            if ($('#invoice_address:checked').length != 0) {
                //	pre_saveAddress('invoice');
            }

            updateState(); // USA states
            updateNeedIDNumber(); // Spanish DNI
            updateZipCode();
            // OPCKT initial order page render
            if (!($('#opc_cart_id_address_delivery').val() > 0)) {
                pre_saveAddress('delivery'); // we need to save address at the very beginning to allow shipping / payment work immediately
            }
            if ($('#invoice_address:checked').length != 0) {
                updateState('invoice');
                updateNeedIDNumber('invoice');
                updateZipCode('invoice');
            }
        }

        if (typeof opc_override_checkout_btn !== 'undefined' && opc_override_checkout_btn == '1')
            $("a#button_order_cart").click(cartBlockCheckoutButtonHandler);

        // INVOICE ADDRESS
        $('#invoice_address').click(function () {
            if ($('#invoice_address:checked').length > 0) {
                // OPCKT added - pre_saveAddress() - to refresh correct id_address_invoice / delivery model state
                $('#invoice_address').attr('disabled', true);
                $('#opc_invoice_address').slideDown('slow', function () {
                    pre_saveAddress('delivery', true, function() {pre_saveAddress('invoice');}); // 2nd parameter says, don't refresh forms after saving address
                    $('#invoice_address').removeAttr('disabled');
                });
                updateState('invoice');
                updateNeedIDNumber('invoice');
                updateZipCode('invoice');
            }
            else {
                $('#invoice_address').attr('disabled', true);
                $('#opc_invoice_address').slideUp('slow', function () {
                    pre_saveAddress('delivery');
                    $('#invoice_address').removeAttr('disabled');
                });
            }
            animateFieldsPadding();
        });


        // DELIVERY ADDRESS - if opc_invoice_first is turned on
        $('#delivery_address').click(function () {
            if ($('#delivery_address:checked').length > 0) {
                // OPCKT added - pre_saveAddress() - to refresh correct id_address_delivery / invoice model state
                $('#delivery_address').attr('disabled', true);
                $('#opc_delivery_address').slideDown('slow', function () {
                    pre_saveAddress('invoice', true, function() {pre_saveAddress('delivery');}); // 2nd parameter says, don't refresh forms after saving address
                    $('#delivery_address').removeAttr('disabled');
                });
                updateState('delivery');
                updateNeedIDNumber('delivery');
                updateZipCode('delivery');
            }
            else {
                $('#delivery_address').attr('disabled', true);
                $('#opc_delivery_address').slideUp('slow', function () {
                    pre_saveAddress('invoice');
                    $('#delivery_address').removeAttr('disabled');
                });
            }
            animateFieldsPadding();
        });

        /*                                function vat_number()
         {
         if ($('#company').val() != '')
         $('#vat_number_block').show();
         else
         $('#vat_number_block').hide();
         }
         function vat_number_invoice()
         {
         if ($('#company_invoice').val() != '')
         $('#vat_number_block_invoice').show();
         else
         $('#vat_number_block_invoice').hide();
         }
         $('#company').blur(function(){
         vat_number();
         });
         $('#company_invoice').blur(function(){
         vat_number_invoice();
         });
         vat_number();
         vat_number_invoice();
         */
    }

    bindInputs();

    $('#opc_account_form input,select,textarea').change(function () {
        if ($(this).is(':visible')) {
            $('#opc_account_saved').fadeOut('slow');
            $('#submitAccount').show();
        }
    });

    if (typeof opc_page_fading !== 'undefined' && opc_page_fading == "1") {
        var fading_duration = parseInt(opc_fading_duration);
        var fading_opacity = parseInt(opc_fading_opacity);
        if (isNaN(fading_duration) || fading_duration < 0)
            fading_duration = 3000;
        if (isNaN(fading_opacity) || fading_opacity < 0 || fading_opacity > 100)
            fading_opacity = 40;
        $('#header, #footer, #left_column div, #right_column div').not("div#cart_block, div#cart_block_anchor, div#cart_scroll_section, div#opc_info_block").not($("div#cart_block, div#cart_scroll_section, div#opc_info_block").find('div')).fadeTo(fading_duration, fading_opacity / 100);
    }

    if (typeof opc_cookie_cache !== 'undefined' && jQuery.trim(opc_cookie_cache) == "1") {
        preFillFromCheckoutCookie();
        setFieldCookieCache();
    }

    setSampleHints();
    if (typeof opc_inline_validation !== 'undefined' && opc_inline_validation == "1")
        setFieldValidation();



// This juggling is because of PS 1.4.4 tied togeter page_id with php_self variable (unlucky choice)
    $("#modules\\/onepagecheckout\\/order-opc").attr("id", "order-opc");

// Close notification below field, when field is focused
    $("#address1, #address1_invoice").focus(function () {
        closeNotificationMessage($(this).parent());
    });

//closeNotificationMessage($('#'+field_name).parent());
//$('input[title]').qtip();

// Capitalize letters as customer types for configurable fields
    if (typeof opc_capitalize_fields !== 'undefined' && jQuery.trim(opc_capitalize_fields) != "") {
        $(opc_capitalize_fields).css('text-transform', 'capitalize');
        $(opc_capitalize_fields).blur(function () {
            $(this).val($(this).val().toCapitalize());
        });
    }

    // add required asterix to customerprivacy block
    if ($('fieldset.customerprivacy label').length)
        $('fieldset.customerprivacy label').append('<sup>*</sup>');

    animateFieldsPadding();
	
	if($.browser.chrome && !opc_three_column_opc){
        $(".confirm_button").css('clear', 'both');
    }



    if (typeof opc_responsive_layout !== 'undefined' && jQuery.trim(opc_responsive_layout) == "1") {
        addResponsiveLayoutHeaders();
    }

    if (typeof opc_company_based_vat !== 'undefined' && jQuery.trim(opc_company_based_vat) == "1") {
        if ($('#company').is(':visible'))
            showVatNumberBlock($('#company').val(), false);
        if ($('#company_invoice').is(':visible'))
            showVatNumberBlock($('#company_invoice').val(), true);
    }


    $('div.save-account-button').click(saveAccountAndShowPayments);

    // If save-account-overlay option turned on AND account is not yet saved, display $('div.save-account-button-container, div.save-account-overlay').fadeIn('fast');
    if ($('input#opc_id_customer').val() == "0" && (typeof opc_save_account_overlay !== 'undefined' && jQuery.trim(opc_save_account_overlay) == "1")) {
        $('div.save-account-button-container, div.save-account-overlay').fadeIn('fast');
    }

    // Move order-detail-content block before carriers_section - uncomment below to use this
    //$('#carriers_section').before($('#order-detail-content'));
    //$('.summary-top').remove();

    //$.uniform.restore("#opc_checkout input[type=radio]");

    // Click selected carrier, in case of using payments to carriers module
    $('.carrier_action.radio input:checked').click();

    // var wrapper_el = $('#shopping_cart, #cart_block, #cart_block_list');
    // wrapper_el.find('dd:not([id$=_'+deliveryAddress+']), dt:not([id$=_'+deliveryAddress+'])').remove();

});//end of ready()

