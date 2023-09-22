{**
* NOTICE OF LICENSE
*
* This source file is subject to the Software License Agreement
* that is bundled with this package in the file LICENSE.txt.
* 
*  @author Peter Sliacky
*  @copyright 2009-2016 Peter Sliacky
*  @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0) 
*}

{if isset($opc_config.invoice_first) && $opc_config.invoice_first}
    {assign "invoice_first" "1"}
{else}
    {assign "invoice_first" "0"}
{/if}


{**********************************************************************************************************************}
{capture name=password_checkbox}
    {if !isset($opc_config.create_customer_password) || !$opc_config.create_customer_password}
        {if !isset($guestInformations) || !$guestInformations.id_customer || $isGuest}
            <p class="checkbox" id="p_registerme"
               {if !$PS_GUEST_CHECKOUT_ENABLED && !$opc_config.display_password_msg}style="display: none"{/if}>
                <input type="checkbox"
                       {if !$PS_GUEST_CHECKOUT_ENABLED}disabled="disabled"{/if} {if !$PS_GUEST_CHECKOUT_ENABLED || $opc_config.password_checked}checked="checked"{/if}
                       name="registerme" id="registerme" value="1" onclick="toggle_password_box();"/>
                <label for="registerme">{l s='Create an account and enjoy benefits of registered customers.' mod='onepagecheckout'}</label>
            </p>
        {/if}
    {/if}
{/capture}



{**********************************************************************************************************************}
{capture name=invoice_checkbox_block}

    <p class="checkbox is_customer_param{if !isset($opc_config.invoice_checkbox) || !$opc_config.invoice_checkbox} no_show{/if}" id="invoice_address_checkbox">
        <input type="checkbox" name="invoice_address" id="invoice_address"
               {if ((isset($guestInformations) && $guestInformations.use_another_invoice_address) OR (!isset($guestInformations) && $def_different_billing == 1))}checked="checked"{/if}/>
        <label for="invoice_address"><b>{if $isVirtualCart && $opc_config.virtual_no_delivery}{l s='I would like to provide billing address' mod='onepagecheckout'}{else}{l s='Please use another address for invoice' mod='onepagecheckout'}{/if}</b></label>
    </p>

{/capture}

{**********************************************************************************************************************}
{capture name=delivery_checkbox_block}

    <p class="checkbox is_customer_param{if !isset($opc_config.invoice_checkbox) || !$opc_config.invoice_checkbox} no_show{/if}" id="delivery_address_checkbox">
        <input type="checkbox" name="delivery_address" id="delivery_address"
               {if ((isset($guestInformations) && $guestInformations.use_another_invoice_address) OR (!isset($guestInformations) && $def_different_billing == 1))}checked="checked"{/if}/>
        <label for="delivery_address"><b>{if $isVirtualCart && $opc_config.virtual_no_delivery}{l s='I would like to provide billing address' mod='onepagecheckout'}{else}{l s='Delivery to another address' mod='onepagecheckout'}{/if}</b></label>
    </p>

{/capture}


{**********************************************************************************************************************}
{capture name=account_block}

   <div class="account_fields">

        <!-- Error return block -->
        <div id="opc_account_errors" class="error" style="display:none;"></div>
        <!-- END Error return block -->

    {$HOOK_CREATE_ACCOUNT_TOP}

    <!-- Account -->
    <input type="hidden" id="is_new_customer" name="is_new_customer"
           value="{if !$PS_GUEST_CHECKOUT_ENABLED || $opc_config.password_checked}1{else}0{/if}"/>
    <input type="hidden" id="opc_id_customer" name="opc_id_customer"
           value="{if isset($guestInformations) && $guestInformations.id_customer}{$guestInformations.id_customer}{else}0{/if}"/>
    <input type="hidden" id="opc_id_address_delivery" name="opc_id_address_delivery"
           value="{if isset($guestInformations) && $guestInformations.id_address_delivery}{$guestInformations.id_address_delivery}{else}0{/if}"/>
    <input type="hidden" id="opc_id_address_invoice" name="opc_id_address_invoice"
           value="{if isset($guestInformations) && $guestInformations.id_address_delivery}{$guestInformations.id_address_delivery}{else}0{/if}"/>
    <input type="hidden" id="opc_cart_id_address_delivery" value="{if isset($cart) && isset($cart->id_address_delivery)}{$cart->id_address_delivery}{else}0{/if}" />


    {if isset($opc_config.offer_password_top) && $opc_config.offer_password_top}{$smarty.capture.password_checkbox}{/if}

    <p class="required text">
        <label for="email">{l s='E-mail' mod='onepagecheckout'}<sup>*</sup></label>
        <input type="text"
               {if isset($guestInformations) && $guestInformations.id_customer && !$isGuest}readonly="readonly"{/if}
               class="ttp text{if isset($guestInformations) && $guestInformations.id_customer && !$isGuest} readonly{/if}"
               id="email" name="email"
               value="{if isset($guestInformations) && $guestInformations.email}{$guestInformations.email}{/if}"/>{*<span class="hint"><img class="callout" src="{$modules_dir|escape:'html':'UTF-8'}onepagecheckout/views/img/callout.gif" />We do not send out tons of emails.</span>*}{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
        <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
            <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='jack@gmail.com' mod='onepagecheckout'})</span>{/if}


    </p>

    {if isset($opc_config.email_verify) && $opc_config.email_verify}
        <p class="required text" id="email_verify_cont"
           {if isset($guestInformations) && $guestInformations.id_customer}style="display: none"{/if}>
            <label for="email_verify">{l s='E-mail (repeat)' mod='onepagecheckout'}<sup>*</sup></label>
            <input type="text" class="text" id="email_verify" name="email_verify"/>
        </p>
    {/if}

    <div id="existing_email_msg">{l s='This email is already registered, you can either' mod='onepagecheckout'} <a href="#"
                                                                                                                   class="existing_email_login">{l s='log-in' mod='onepagecheckout'}</a> {l s='or just fill in details below.' mod='onepagecheckout'}
    </div>
    <div id="must_login_msg">{l s='This email is already registered, please' mod='onepagecheckout'} <a href="#"
                                                                                                       class="existing_email_login">{l s='log-in' mod='onepagecheckout'}</a>.
    </div>

    {capture name="password_field"}
        {if !isset($opc_config.create_customer_password) || !$opc_config.create_customer_password}
            <p class="text required password is_customer_param" id="opc_password" style="display: none">
                <label for="passwd">{l s='Password' mod='onepagecheckout'}<sup>*</sup></label>
                <input type="password" class="text" name="passwd"
                       id="passwd"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
                <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                    <span class="sample_text ex_blur">{l s='(5 characters min.)' mod='onepagecheckout'}</span>{/if}
            </p>
        {/if}
    {/capture}

    {if isset($opc_config.offer_password_top) && $opc_config.offer_password_top}{$smarty.capture.password_field}{/if}



    <p class="radio required" {if !isset($opc_config.gender) || !$opc_config.gender}style="display: none;"{/if}>
        <label>{l s='Title' mod='onepagecheckout'}</label>
        <input type="radio" name="id_gender" id="id_gender1" value="1"
               {if isset($guestInformations) && $guestInformations.id_gender == 1}checked="checked"{/if} />
        <label for="id_gender1" class="top">{l s='Mr.' mod='onepagecheckout'}</label>
        <input type="radio" name="id_gender" id="id_gender2" value="2"
               {if isset($guestInformations) && $guestInformations.id_gender == 2}checked="checked"{/if} />
        <label for="id_gender2" class="top">{l s='Ms.' mod='onepagecheckout'}</label>
    </p>

    <p class="select" {if !isset($opc_config.birthday) || !$opc_config.birthday}style="display: none;"{/if}>
        <label>{l s='Date of Birth' mod='onepagecheckout'}</label>
        <select id="days" name="days">
            <option value="">-</option>
            {foreach from=$days item=day}
                <option value="{$day|escape:'htmlall':'UTF-8'}" {if isset($guestInformations) && ($guestInformations.sl_day == $day)}
                    selected="selected"{/if}>{$day|escape:'htmlall':'UTF-8'}&nbsp;&nbsp;</option>
            {/foreach}
        </select>
        {*
        {l s='January' mod='onepagecheckout'}
        {l s='February' mod='onepagecheckout'}
        {l s='March' mod='onepagecheckout'}
        {l s='April' mod='onepagecheckout'}
        {l s='May' mod='onepagecheckout'}
        {l s='June' mod='onepagecheckout'}
        {l s='July' mod='onepagecheckout'}
        {l s='August' mod='onepagecheckout'}
        {l s='September' mod='onepagecheckout'}
        {l s='October' mod='onepagecheckout'}
        {l s='November' mod='onepagecheckout'}
        {l s='December' mod='onepagecheckout'}
        *}
        <select id="months" name="months">
            <option value="">-</option>
            {foreach from=$months key=k item=month}
                <option value="{$k|escape:'htmlall':'UTF-8'}" {if isset($guestInformations) && ($guestInformations.sl_month == $k)}
                    selected="selected"{/if}>{l s="$month"}&nbsp;</option>
            {/foreach}
        </select>
        <select id="years" name="years">
            <option value="">-</option>
            {foreach from=$years item=year}
                <option value="{$year|escape:'htmlall':'UTF-8'}" {if isset($guestInformations) && ($guestInformations.sl_year == $year)}
                    selected="selected"{/if}>{$year|escape:'htmlall':'UTF-8'}&nbsp;&nbsp;</option>
            {/foreach}
        </select>
    </p>
    <p class="checkbox" {if !isset($opc_config.newsletter) || !$opc_config.newsletter}style="display: none;"{/if}>
        <input type="checkbox" name="newsletter" id="newsletter" value="1"
               {if (isset($guestInformations) && $guestInformations.newsletter) || (!isset($guestInformations) && isset($opc_config.newsletter_checked) && $opc_config.newsletter_checked)}checked="checked"{/if} />
        <label for="newsletter">{l s='Sign up for our newsletter' mod='onepagecheckout'}</label>
    </p>

    <p class="checkbox" {if !isset($opc_config.special_offers) || !$opc_config.special_offers}style="display: none;"{/if}>
        <input type="checkbox" name="optin" id="optin" value="1"
               {if (isset($guestInformations) && $guestInformations.optin) || (!isset($guestInformations) && isset($opc_config.special_offers_checked) && $opc_config.special_offers_checked)}checked="checked"{/if} />
        <label for="optin">{l s='Receive special offers from our partners' mod='onepagecheckout'}</label>
    </p>

   </div> {*div class="account_fields*}

{/capture} {*account_block*}

{**********************************************************************************************************************}
{capture name=delivery_address_block}

    <fieldset id="opc_delivery_address" style="display: {if (isset($guestInformations) && $guestInformations.use_another_invoice_address) OR (!isset($guestInformations) && $def_different_billing == 1) OR !$invoice_first}block{else}none{/if}">
        <h3>
            <span id="dlv_label" class="{if ($isLogged && !$isGuest)}logged-l{else}new-l{/if}">{l s='Delivery & Personal information' mod='onepagecheckout'}</span><span id="new_label" class="{if ($isLogged && !$isGuest)}logged-l{else}new-l{/if}">{if $invoice_first}{l s='Delivery & Personal information' mod='onepagecheckout'}{else}{l s='New customer - account & address' mod='onepagecheckout'}{/if}</span>
        </h3>

        {if !$invoice_first}{$smarty.capture.account_block}{/if}


        <div class="address-type-header delivery{if $isVirtualCart && $opc_config.virtual_no_delivery} hidden{/if}">{l s='Delivery address' mod='onepagecheckout'}
        <div id="dlv_addresses_div"
             style="float: right;{if !isset($addresses) || $addresses|@count == 0}display:none;{elseif $addresses|@count == 1 AND $addresses[0].id_address==$cart->id_address_delivery}display:none;{else}display:block;{/if}">
            <span style="font-size: 0.7em;">{l s='Choose another address' mod='onepagecheckout'}:</span>
            <select id="dlv_addresses" style="width: 100px; margin-left: 0px;" onchange="updateAddressSelection_1();" title="{l s='Choose another address' mod='onepagecheckout'}">
                {if isset($addresses)}
                    {foreach from=$addresses item=address}
                        <option value="{$address.id_address|intval}"
                                {if $address.id_address == $cart->id_address_delivery}{assign "selOk" "1"}selected="selected"{elseif $address.id_address == $cart->id_address_invoice}disabled="disabled"{/if}>{$address.alias|regex_replace:"/^dlv\-/":""}</option>
                    {/foreach}
                    {if !$selOk}
                        <option value="{$addresses[0].id_address|intval}" selected="selected"> -- </option>
                    {/if}
                {/if}
            </select>
        </div>
        </div>



      <div class="address_fields">



        <p class="text" {if !isset($opc_config.company_delivery) || !$opc_config.company_delivery}style="display: none;"{/if}>
            <label for="company">{l s='Company' mod='onepagecheckout'}<sup>&nbsp;&nbsp;</sup></label>
            <input type="text" class="text" id="company" name="company"
                   value="{if isset($guestInformations) && isset($guestInformations.company) &&  $guestInformations.company}{$guestInformations.company}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
            <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='Google, Inc.' mod='onepagecheckout'})</span>{/if}
        </p>

        <div id="vat_number_block" style="display:none;">
            <p class="text">
                <label for="vat_number">{l s='VAT number' mod='onepagecheckout'}<sup>&nbsp;&nbsp;</sup></label>
                <input type="text" class="text" name="vat_number" id="vat_number"
                       value="{if isset($guestInformations) && isset($guestInformations.vat_number) &&  $guestInformations.vat_number}{$guestInformations.vat_number}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
                <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                    <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='FR101202303' mod='onepagecheckout'})</span>{/if}
            </p>
        </div>
        <p class="required text dni" {if $isVirtualCart && $opc_config.virtual_no_delivery}style="display: none;"{/if}>
            <label for="dni">{l s='Identification number' mod='onepagecheckout'}<sup>*</sup></label>
            <input type="text" class="text" name="dni" id="dni"
                   value="{if isset($guestInformations) && isset($guestInformations.dni) &&  $guestInformations.dni}{$guestInformations.dni}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
            <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                <span class="sample_text ex_blur">({l s='DNI / NIF / NIE' mod='onepagecheckout'})</span>{/if}
        </p>

        <p class="required text" {if $isVirtualCart && $opc_config.virtual_no_delivery}style="display: none;"{/if}>
            <label for="firstname">{l s='First name' mod='onepagecheckout'}<sup>*</sup></label>
            <input type="text" class="text" id="firstname" name="firstname"
                   value="{if isset($guestInformations) && isset($guestInformations.firstname) &&  $guestInformations.firstname}{$guestInformations.firstname}{else}{if $isVirtualCart && true} {/if}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
            <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='Jack' mod='onepagecheckout'})</span>{/if}
        </p>

        <p class="required text" {if $isVirtualCart && $opc_config.virtual_no_delivery}style="display: none;"{/if}>
            <label for="lastname">{l s='Last name' mod='onepagecheckout'}<sup>*</sup></label>
            <input type="text" class="text" id="lastname" name="lastname"
                   value="{if isset($guestInformations) && isset($guestInformations.lastname) &&  $guestInformations.lastname}{$guestInformations.lastname}{else}{if $isVirtualCart && true} {/if}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
            <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='Thompson' mod='onepagecheckout'})</span>{/if}
        </p>

        <p class="required text" {if $isVirtualCart && $opc_config.virtual_no_delivery}style="display: none;"{/if}>
            <label for="address1">{l s='Address' mod='onepagecheckout'}<sup>*</sup></label>
            <input type="text" class="text" name="address1" id="address1"
                   value="{if isset($guestInformations) && isset($guestInformations.address1) &&  $guestInformations.address1}{$guestInformations.address1}{else}{if $isVirtualCart && true} {/if}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
            <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='15 High Street' mod='onepagecheckout'})</span>{/if}
        </p>

        <p class="text is_customer_param" id="p_address2"
           {if !isset($opc_config.address2_delivery) || !$opc_config.address2_delivery || ($isVirtualCart && $opc_config.virtual_no_delivery)}style="display: none;"{/if}>
            <label for="address2">{l s='Address (Line 2)' mod='onepagecheckout'}<sup>&nbsp;&nbsp;</sup></label>
            <input type="text" class="text" name="address2" id="address2"
                   value="{if isset($guestInformations) && isset($guestInformations.address2) &&  $guestInformations.address2}{$guestInformations.address2}{else}{if $isVirtualCart && true} {/if}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
            <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='Room no.304' mod='onepagecheckout'})</span>{/if}
        </p>

        <p class="required postcode text" {if $isVirtualCart && $opc_config.virtual_no_delivery}style="display: none;"{/if}>
            <label for="postcode">{l s='Zip / Postal code' mod='onepagecheckout'}<sup>*</sup></label>
            <input type="text" class="text" name="postcode" id="postcode"
                   value="{if isset($guestInformations) && isset($guestInformations.postcode) &&  $guestInformations.postcode}{$guestInformations.postcode}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
            <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='90104' mod='onepagecheckout'})</span>{/if}
        </p>

        <p class="required text" {if $isVirtualCart && $opc_config.virtual_no_delivery}style="display: none;"{/if}>
            <label for="city">{l s='City' mod='onepagecheckout'}<sup>*</sup></label>
            <input type="text" class="text" name="city" id="city"
                   value="{if isset($guestInformations) && isset($guestInformations.city) &&  $guestInformations.city}{$guestInformations.city}{else}{if $isVirtualCart && true} {/if}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
            <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='Paris' mod='onepagecheckout'})</span>{/if}
        </p>


        {if $isVirtualCart && $opc_config.virtual_no_delivery}
            <input type="hidden" name="id_country" id="id_country"
                   value="{if isset($onlineCountryActive) && $opc_config.online_country_id > 0}{$opc_config.online_country_id|intval}{else}{$sl_country|intval}{/if}"/>
        {else}
            <p class="required select"
               {if !isset($opc_config.country_delivery) || !$opc_config.country_delivery}style="display: none;"{/if}>
                <label for="id_country">{l s='Country' mod='onepagecheckout'}<sup>*</sup></label>
                <select name="id_country" id="id_country">
                    <option value="">-</option>
                    {foreach from=$countries item=v}
                        {if isset($opc_config.online_country_id) && $opc_config.online_country_id > 0 && $opc_config.online_country_id == $v.id_country}{else}
                            <option value="{$v.id_country|intval}" {if (isset($guestInformations) AND isset($guestInformations.id_country) AND $guestInformations.id_country == $v.id_country) OR ($def_country == $v.id_country ) OR (!isset($guestInformations) && ($def_country==0) && $sl_country == $v.id_country)}
                                selected="selected"{/if}>{$v.name|escape:'htmlall':'UTF-8'}</option>
                        {/if}
                    {/foreach}
                </select>
                {if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}<span
                    class="validity valid_blank"></span>{/if}
            </p>

        {/if}


        <p class="required id_state select">
            <label for="id_state">{l s='State' mod='onepagecheckout'}<sup>*</sup></label>
            <select name="id_state" id="id_state">
                <option value="">-</option>
            </select>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
            <span class="validity valid_blank"></span>{/if}
        </p>

        <p class="text is_customer_param" {if !isset($opc_config.phone_delivery) || !$opc_config.phone_delivery}style="display: none;"{/if}>
            <label for="phone">{l s='Home phone' mod='onepagecheckout'}<sup>{if isset($one_phone_at_least) && $one_phone_at_least}*{else}&nbsp;&nbsp;{/if}</sup></label>
            <input type="text" class="text" name="phone" id="phone"
                   value="{if isset($guestInformations) && isset($guestInformations.phone) &&  $guestInformations.phone}{$guestInformations.phone}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
            <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='555-100200' mod='onepagecheckout'})</span>{/if}
        </p>

        <p class="text" {if !isset($opc_config.phone_mobile_delivery) || !$opc_config.phone_mobile_delivery}style="display: none;"{/if}>
            <label for="phone_mobile">{l s='Mobile phone' mod='onepagecheckout'}<sup>&nbsp;&nbsp;</sup></label>
            <input type="text" class="text" name="phone_mobile" id="phone_mobile"
                   value="{if isset($guestInformations) && isset($guestInformations.phone_mobile) &&  $guestInformations.phone_mobile}{$guestInformations.phone_mobile}{else}{if $isVirtualCart && true} {/if}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
            <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='555-100200' mod='onepagecheckout'})</span>{/if}
        </p>

        <p class="textarea is_customer_param"
           {if !isset($opc_config.additional_info_delivery) || !$opc_config.additional_info_delivery}style="display: none;"{/if}>
            <label for="other">{l s='Additional information' mod='onepagecheckout'}</label>
            <textarea name="other" id="other" cols="26"
                      rows="3">{if isset($guestInformations) && isset($guestInformations.other) &&  $guestInformations.other}{$guestInformations.other}{/if}</textarea>
        </p>
        <input type="hidden" name="alias" id="alias"
               value="{if isset($guestInformations) && isset($guestInformations.alias) &&  $guestInformations.alias}{$guestInformations.alias}{else}{l s='My address' mod='onepagecheckout'}{/if}"/>
        <input type="hidden" name="default_alias" id="default_alias" value="{l s='My address' mod='onepagecheckout'}"/>

        {if !$invoice_first}{$smarty.capture.invoice_checkbox_block}{/if}

        {if !isset($opc_config.compact_form) || !$opc_config.compact_form}
            <p style="clear: both;">
                <sup>*</sup>{l s='Required field' mod='onepagecheckout'}
            </p>
        {/if}

      </div> {*div class=address_fields*}
    </fieldset>

{/capture} {*delivery_address_block*}







{**********************************************************************************************************************}
{capture name=invoice_address_block}

    <div id="opc_invoice_address" class="is_customer_param"
         style="display: {if (isset($guestInformations) && $guestInformations.use_another_invoice_address) OR (!isset($guestInformations) && $def_different_billing == 1) OR $invoice_first}block{else}none{/if}">
        <fieldset>
            {if $invoice_first}{$smarty.capture.account_block}{/if}


            {*addreses count: {$addresses|@count}<br />*}
            {*address[0].id: {$addresses[0].id_address}<br />*}
            {*cart id address delivery: {$cart->id_address_delivery}<br />*}
            {*cart id address invoice: {$cart->id_address_invoice}<br />*}
            <div class="address-type-header invoice">{l s='Invoice address' mod='onepagecheckout'}
            <div id="inv_addresses_div"
                 style="float: right;{if !isset($addresses) || $addresses|@count == 0}display:none;{elseif $addresses|@count == 1 AND ($addresses[0].id_address==$cart->id_address_invoice || $addresses[0].id_address==$cart->id_address_delivery)}display:none;{else}display:block;{/if}">
                <span style="font-size: 0.7em;">{l s='Choose another address' mod='onepagecheckout'}:</span>
                <select id="inv_addresses" style="width: 100px; margin-left: 0px;"
                        onchange="updateAddressSelection_1_invoice();" title="{l s='Choose another address' mod='onepagecheckout'}">
                    {if isset($addresses)}
                        {foreach from=$addresses item=address}
                            <option value="{$address.id_address|intval}"
                                    {if $address.id_address == $cart->id_address_invoice}selected="selected"{elseif $address.id_address == $cart->id_address_delivery}disabled="disabled"{/if}>{$address.alias}</option>
                        {/foreach}
                    {/if}
                </select>
            </div>
            </div>




          <div class="address_fields">

            <!-- Error return block -->
            <div id="opc_account_errors_invoice" class="error" style="display:none;"></div>
            <!-- END Error return block -->
            <p class="text is_customer_param"
               {if !isset($opc_config.company_invoice) || !$opc_config.company_invoice}style="display: none;"{/if}>
                <label for="company_invoice">{l s='Company' mod='onepagecheckout'}<sup>&nbsp;&nbsp;</sup></label>
                <input type="text" class="text" id="company_invoice" name="company_invoice"
                       value="{if isset($guestInformations) && isset($guestInformations.company_invoice)}{$guestInformations.company_invoice}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
                <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                    <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='Google, Inc.' mod='onepagecheckout'})</span>{/if}
            </p>

            <div id="vat_number_block_invoice" class="is_customer_param"
                 style="display:{if isset($guestInformations) && isset($guestInformations.allow_eu_vat_invoice) && $guestInformations.allow_eu_vat_invoice == 1}block{else}none{/if};">
                <p class="text">
                    <label for="vat_number_invoice">{l s='VAT number' mod='onepagecheckout'}<sup>&nbsp;&nbsp;</sup></label>
                    <input type="text" class="text" id="vat_number_invoice" name="vat_number_invoice"
                           value="{if isset($guestInformations) && isset($guestInformations.vat_number_invoice)}{$guestInformations.vat_number_invoice}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
                    <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                        <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='FR101202303' mod='onepagecheckout'})</span>{/if}
                </p>
            </div>
            <p class="required text dni_invoice">
                <label for="dni">{l s='Identification number' mod='onepagecheckout'}<sup>*</sup></label>
                <input type="text" class="text" name="dni_invoice" id="dni_invoice"
                       value="{if isset($guestInformations) && isset($guestInformations.dni_invoice)}{$guestInformations.dni_invoice}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
                <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                    <span class="sample_text ex_blur">({l s='DNI / NIF / NIE' mod='onepagecheckout'})</span>{/if}
            </p>

            <p class="required text{if $opc_config.hidden_fields|strpos:'inv_firstname' > -1} hidden_field{/if}">
                <label for="firstname_invoice">{l s='First name' mod='onepagecheckout'}<sup>*</sup></label>
                <input type="text" class="text" id="firstname_invoice" name="firstname_invoice"
                       value="{if $opc_config.hidden_fields|strpos:'inv_firstname' > -1} {elseif isset($guestInformations) && isset($guestInformations.firstname_invoice)}{$guestInformations.firstname_invoice}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
                <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                    <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='Jack' mod='onepagecheckout'})</span>{/if}
            </p>

            <p class="required text">
                <label for="lastname_invoice">{l s='Last name' mod='onepagecheckout'}<sup>*</sup></label>
                <input type="text" class="text" id="lastname_invoice" name="lastname_invoice"
                       value="{if isset($guestInformations) && isset($guestInformations.lastname_invoice)}{$guestInformations.lastname_invoice}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
                <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                    <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='Thompson' mod='onepagecheckout'})</span>{/if}
            </p>

            <p class="required text">
                <label for="address1_invoice">{l s='Address' mod='onepagecheckout'}<sup>*</sup></label>
                <input type="text" class="text" name="address1_invoice" id="address1_invoice"
                       value="{if isset($guestInformations) && isset($guestInformations.address1_invoice)}{$guestInformations.address1_invoice}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
                <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                    <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='15 High Street' mod='onepagecheckout'})</span>{/if}
            </p>

            <p class="text is_customer_param" id="p_address2_invoice"
               {if !isset($opc_config.address2_invoice) || !$opc_config.address2_invoice}style="display: none;"{/if}>
                <label for="address2_invoice">{l s='Address (Line 2)' mod='onepagecheckout'}<sup>&nbsp;&nbsp;</sup></label>
                <input type="text" class="text" name="address2_invoice" id="address2_invoice"
                       value="{if isset($guestInformations) && isset($guestInformations.address2_invoice)}{$guestInformations.address2_invoice}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
                <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                    <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='Room no.304' mod='onepagecheckout'})</span>{/if}
            </p>

            <p class="required postcode_invoice text">
                <label for="postcode_invoice">{l s='Zip / Postal Code' mod='onepagecheckout'}<sup>*</sup></label>
                <input type="text" class="text" name="postcode_invoice" id="postcode_invoice"
                       value="{if isset($guestInformations) && isset($guestInformations.postcode_invoice)}{$guestInformations.postcode_invoice}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
                <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                    <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='90104' mod='onepagecheckout'})</span>{/if}
            </p>

            <p class="required text">
                <label for="city_invoice">{l s='City' mod='onepagecheckout'}<sup>*</sup></label>
                <input type="text" class="text" name="city_invoice" id="city_invoice"
                       value="{if isset($guestInformations) && isset($guestInformations.city_invoice)}{$guestInformations.city_invoice}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
                <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                    <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='Paris' mod='onepagecheckout'})</span>{/if}
            </p>

            <p class="required select"
               {if !isset($opc_config.country_invoice) || !$opc_config.country_invoice}style="display: none;"{/if}>
                <label for="id_country_invoice">{l s='Country' mod='onepagecheckout'}<sup>*</sup></label>
                <select name="id_country_invoice" id="id_country_invoice">
                    <option value="">-</option>
                    {foreach from=$countries item=v}
                        {if isset($opc_config.online_country_id) && $opc_config.online_country_id > 0 && $opc_config.online_country_id == $v.id_country}{else}
                            <option value="{$v.id_country|intval}" {if (isset($guestInformations) AND isset($guestInformations.id_country_invoice) AND $guestInformations.id_country_invoice == $v.id_country) OR ($def_country_invoice == $v.id_country ) OR (!isset($guestInformations) && ($def_country_invoice==0) && $sl_country == $v.id_country)}
                                selected="selected"{/if}>{$v.name|escape:'htmlall':'UTF-8'}</option>
                        {/if}
                    {/foreach}
                </select>
                {if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}<span
                    class="validity valid_blank"></span>{/if}
            </p>
            <p class="required id_state_invoice select" style="display:none;">
                <label for="id_state_invoice">{l s='State' mod='onepagecheckout'}<sup>*</sup></label>
                <select name="id_state_invoice" id="id_state_invoice">
                    <option value="">-</option>
                </select>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
                <span class="validity valid_blank"></span>{/if}
            </p>

            <p class="text" {if !isset($opc_config.phone_invoice) || !$opc_config.phone_invoice}style="display: none;"{/if}>
                <label for="phone_invoice">{l s='Home phone' mod='onepagecheckout'}<sup>{if isset($one_phone_at_least) && $one_phone_at_least}*{else}&nbsp;&nbsp;{/if}</sup></label>
                <input type="text" class="text" name="phone_invoice" id="phone_invoice"
                       value="{if isset($guestInformations) && isset($guestInformations.phone_invoice)}{$guestInformations.phone_invoice}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
                <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                    <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='555-100200' mod='onepagecheckout'})</span>{/if}
            </p>

            <p class="text is_customer_param" {if !isset($opc_config.phone_mobile_invoice) || !$opc_config.phone_mobile_invoice}style="display: none;"{/if}>
                <label for="phone_mobile_invoice">{l s='Mobile phone' mod='onepagecheckout'}<sup>&nbsp;&nbsp;</sup></label>
                <input type="text" class="text" name="phone_mobile_invoice" id="phone_mobile_invoice"
                       value="{if isset($guestInformations) && isset($guestInformations.phone_mobile_invoice)}{$guestInformations.phone_mobile_invoice}{/if}"/>{if isset($opc_config.validation_checkboxes) && $opc_config.validation_checkboxes}
                <span class="validity valid_blank"></span>{/if}{if isset($opc_config.sample_values) && $opc_config.sample_values}
                    <span class="sample_text ex_blur">({l s='e.g.' mod='onepagecheckout'} {l s='555-100200' mod='onepagecheckout'})</span>{/if}
            </p>


            <p class="textarea is_customer_param"
               {if !isset($opc_config.additional_info_invoice) || !$opc_config.additional_info_invoice}style="display: none;"{/if}>
                <label for="other_invoice">{l s='Additional information' mod='onepagecheckout'}</label>
                <textarea name="other_invoice" id="other_invoice" cols="26"
                          rows="3">{if isset($guestInformations) && isset($guestInformations.other_invoice)}{$guestInformations.other_invoice}{/if}</textarea>
            </p>
            {if !isset($opc_config.compact_form) || !$opc_config.compact_form}
                <p style="clear: both;">
                    <sup>*</sup>{l s='Required field' mod='onepagecheckout'}
                </p>
            {/if}
            <input type="hidden" name="alias_invoice" id="alias_invoice"
                   value="{if isset($guestInformations) && isset($guestInformations.alias_invoice)}{$guestInformations.alias_invoice}{else}{l s='My Invoice address' mod='onepagecheckout'}{/if}"/>
            <input type="hidden" name="default_alias_invoice" id="default_alias_invoice"
                   value="{l s='My Invoice address' mod='onepagecheckout'}"/>

            {if $invoice_first}{$smarty.capture.delivery_checkbox_block}{/if}
          </div> {*div class=address_fields*}
        </fieldset>
    </div>
{/capture} {*invoice_address_block*}


{**********************************************************************************************************************}
{capture name='login_block'}
    <form action="{$link->getPageLink('authentication.php', true)|escape:'htmlall':'UTF-8'}?back=order-opc.php" method="post" id="login_form"
          class="std" {if ($isLogged && !$isGuest)}style="display:none;"{/if}>
        <fieldset>
            <h3><div id="closeLoginFormContainer"><img src="{$modules_dir|escape:'html':'UTF-8'}onepagecheckout/views/img/close_icon.png" id="closeLoginFormBlock" /></div>{l s='Already registered?' mod='onepagecheckout'} <a href="#"
                                                                                                                                                                                                          id="openLoginFormBlock">{l s='Log-in' mod='onepagecheckout'}</a>
            </h3>

            <div id="login_form_content" style="display:none;" class="address_fields">
                <!-- Error return block -->
                <div id="opc_login_errors" class="error" style="display:none;"></div>
                <!-- END Error return block -->

                <p class="required text">
                    <label for="login_email">{l s='E-mail address' mod='onepagecheckout'}</label>
                    <input type="text" class="text" id="login_email" name="email" value=""/>
                </p>

                <p class="required text">
                    <label for="login_passwd">{l s='Password' mod='onepagecheckout'}</label>
                    <input type="password" class="text" id="login_passwd" name="login_passwd" value=""/>
                </p>

                <p class="submit">
                    {if isset($back)}<input type="hidden" class="hidden" name="back"
                                            value="{$back|escape:'htmlall':'UTF-8'}"/>{/if}
                    <label>&nbsp;</label>
                    <input type="submit" id="SubmitLoginOpc" name="SubmitLogin" class="button"
                           value="{l s='Log in' mod='onepagecheckout'}"/>
                </p>

                <p class="lost_password"><a
                            href="{$link->getPageLink('password.php', true)|escape:'htmlall':'UTF-8'}">{l s='Forgot your password?' mod='onepagecheckout'}</a>
                </p>
            </div>
        </fieldset>
    </form>
{/capture} {* login_block *}


{**********************************************************************************************************************}
{*****   CONTENT START   ******}
{**********************************************************************************************************************}



<div id="opc_new_account" class="opc-main-block">

<div id="opc_new_account-overlay" class="opc-overlay" style="display: none;"></div>

{$smarty.capture.login_block}

<div id="opc_account_form">
<form action="#" method="post" id="new_account_form" class="std">

<script type="text/javascript">
    // <![CDATA[
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
            {if $country.need_identification_number}
            countriesNeedIDNumber.push({$country.id_country|intval});
            {/if}
            {if isset($country.need_zip_code)}
            countriesNeedZipCode[{$country.id_country|intval}] = {$country.need_zip_code|intval};
            {/if}
        {/foreach}
    {/if}
    //]]>
    {*if $vat_management}
    {literal}
    function vat_number()
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

    $(document).ready(function() {
    $('#company').blur(function(){
    vat_number();
    });
    $('#company_invoice').blur(function(){
    vat_number_invoice();
    });
    vat_number();
    vat_number_invoice();
    });
    {/literal}
    {/if*}
    {literal}
    function toggle_password_box() {
        if ($('#is_new_customer').val() == 0) {
            $('p.password').slideDown('slow');
            $('#is_new_customer').val(1);
        } else {
            $('p.password').slideUp('slow');
            $('#is_new_customer').val(0);
        }
    }//toggle_password_box()
    {/literal}
</script>



{if !$invoice_first}
    {$smarty.capture.delivery_address_block}
    {$smarty.capture.invoice_address_block}
{else}
    {$smarty.capture.invoice_address_block}
    {$smarty.capture.delivery_address_block}
{/if}





{$HOOK_CREATE_ACCOUNT_FORM}
<!-- END Account -->

</form>
</div>
<!-- END div#opc_account_form -->
<div class="clear"></div>
</div>
