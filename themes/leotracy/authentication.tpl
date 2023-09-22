{*
* 2007-2014 PrestaShop
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
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{capture name=path}
	{if !isset($email_create)}{l s='Authentication'}{else}
		<a href="{$link->getPageLink('authentication', true)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Authentication'}">{l s='Authentication'}</a>
		<span class="navigation-pipe">{$navigationPipe}</span>{l s='Create your account'}
	{/if}
{/capture}
<h1 class="page-heading">{if !isset($email_create)}{l s='Authentication'}{else}{l s='Create an account'}{/if}</h1>
{if isset($back) && preg_match("/^http/", $back)}{assign var='current_step' value='login'}{include file="$tpl_dir./order-steps.tpl"}{/if}
{include file="$tpl_dir./errors.tpl"}
{assign var='stateExist' value=false}
{assign var="postCodeExist" value=false}
{assign var="dniExist" value=false}
{if !isset($email_create)}
	<!--{if isset($authentification_error)}
	<div class="alert alert-danger">
		{if {$authentification_error|@count} == 1}
			<p>{l s='There\'s at least one error'} :</p>
			{else}
			<p>{l s='There are %s errors' sprintf=[$account_error|@count]} :</p>
		{/if}
		<ol>
			{foreach from=$authentification_error item=v}
				<li>{$v}</li>
			{/foreach}
		</ol>
	</div>
	{/if}-->
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<form action="{$link->getPageLink('authentication', true)|escape:'html':'UTF-8'}" method="post" id="create-account_form" class="box">
				<h3 class="page-subheading"><span>{l s='Create an account'}</span></h3>
				<div class="form_content clearfix">
					<p>{l s='Please enter your email address to create an account.'}</p>
					<div class="alert alert-danger" id="create_account_error" style="display:none"></div>
					<div class="form-group">
						<label for="email_create">{l s='Email address'}</label>
						<input type="text" class="is_required validate account_input form-control" data-validate="isEmail" id="email_create" name="email_create" value="{if isset($smarty.post.email_create)}{$smarty.post.email_create|stripslashes}{/if}" />
					</div>
					<div class="submit">
						{if isset($back)}<input type="hidden" class="hidden" name="back" value="{$back|escape:'html':'UTF-8'}" />{/if}
						<button class="btn btn-outline button button-medium exclusive" type="submit" id="SubmitCreate" name="SubmitCreate">
							<span>
								<i class="fa fa-user left"></i>&nbsp;
								{l s='Create an account'}
							</span>
						</button>
						<input type="hidden" class="hidden" name="SubmitCreate" value="{l s='Create an account'}" />
					</div>
				</div>
			</form>
		</div>
		<div class="col-xs-12 col-sm-6">
			<form action="{$link->getPageLink('authentication', true)|escape:'html':'UTF-8'}" method="post" id="login_form" class="box">
				<h3 class="page-subheading"><span>{l s='Already registered?'}</span></h3>
				<div class="form_content clearfix">
					<div class="form-group">
						<label for="email">{l s='Email address'}</label>
						<input class="is_required validate account_input form-control" data-validate="isEmail" type="text" id="email" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email|stripslashes}{/if}" />
					</div>
					<div class="form-group">
						<label for="passwd">{l s='Password'}</label>
						<span><input class="is_required validate account_input form-control" type="password" data-validate="isPasswd" id="passwd" name="passwd" value="{if isset($smarty.post.passwd)}{$smarty.post.passwd|stripslashes}{/if}" /></span>
					</div>
					<p class="lost_password form-group"><a href="{$link->getPageLink('password')|escape:'html':'UTF-8'}" title="{l s='Recover your forgotten password'}" rel="nofollow">{l s='Forgot your password?'}</a></p>
					<p class="submit">
						{if isset($back)}<input type="hidden" class="hidden" name="back" value="{$back|escape:'html':'UTF-8'}" />{/if}
						<button type="submit" id="SubmitLogin" name="SubmitLogin" class="button btn btn-outline button-medium">
							<span>
								<i class="fa fa-lock left"></i>&nbsp;
								{l s='Sign in'}
							</span>
						</button>
					</p>
				</div>
			</form>
		</div>
	</div>
	{if isset($inOrderProcess) && $inOrderProcess && $PS_GUEST_CHECKOUT_ENABLED}
		<form action="{$link->getPageLink('authentication', true, NULL, "back=$back")|escape:'html':'UTF-8'}" method="post" id="new_account_form" class="std clearfix form-horizontal">
			<div class="box">
				<div id="opc_account_form" style="display: block; ">
					<h3 class="page-subheading bottom-indent">{l s='Instant checkout'}</h3>
					<!-- Account -->
					<div class="required form-group">
						<label class="control-label col-sm-4" for="guest_email">{l s='Email address'} <sup>*</sup></label>
						<div class="col-sm-6">
							<input type="text" class="is_required validate form-control" data-validate="isEmail" id="guest_email" name="guest_email" value="{if isset($smarty.post.guest_email)}{$smarty.post.guest_email}{/if}" />
						</div>
					</div>
					<div class="cleafix gender-line">
						<label class="control-label col-sm-4">{l s='Title'}</label>
						<div class="col-sm-6">
							{foreach from=$genders key=k item=gender}
								<div class="radio-inline">
									<label for="id_gender{$gender->id}" class="top">
										<input type="radio" name="id_gender" id="id_gender{$gender->id}" value="{$gender->id}"{if isset($smarty.post.id_gender) && $smarty.post.id_gender == $gender->id} checked="checked"{/if} />
										{$gender->name}
									</label>
								</div>
							{/foreach}
						</div>
					</div>
					<div class="required form-group">
						<label class="control-label col-sm-4" for="firstname">{l s='First name'} <sup>*</sup></label>
						<div class="col-sm-6">
							<input type="text" class="is_required validate form-control" data-validate="isName" id="firstname" name="firstname" onblur="$('#customer_firstname').val($(this).val());" value="{if isset($smarty.post.firstname)}{$smarty.post.firstname}{/if}" />
							<input type="hidden" id="customer_firstname" name="customer_firstname" value="{if isset($smarty.post.firstname)}{$smarty.post.firstname}{/if}" />
						</div>
					</div>
					<div class="required form-group">
						<label class="control-label col-sm-4" for="lastname">{l s='Last name'} <sup>*</sup></label>
						<div class="col-sm-6">
							<input type="text" class="is_required validate form-control" data-validate="isName" id="lastname" name="lastname" onblur="$('#customer_lastname').val($(this).val());" value="{if isset($smarty.post.lastname)}{$smarty.post.lastname}{/if}" />
							<input type="hidden" id="customer_lastname" name="customer_lastname" value="{if isset($smarty.post.lastname)}{$smarty.post.lastname}{/if}" />
						</div>
					</div>
					<div class="form-group date-select">
						<label class="control-label col-sm-4">{l s='Date of Birth'}</label>
						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-3 col-xs-3">
									<select class="form-control" id="days" name="days" >
										<option value="">-</option>
										{foreach from=$days item=day}
											<option value="{$day}" {if ($sl_day == $day)} selected="selected"{/if}>{$day}&nbsp;&nbsp;</option>
										{/foreach}
									</select>
									{*
										{l s='January'}
										{l s='February'}
										{l s='March'}
										{l s='April'}
										{l s='May'}
										{l s='June'}
										{l s='July'}
										{l s='August'}
										{l s='September'}
										{l s='October'}
										{l s='November'}
										{l s='December'}
									*}
								</div>
								<div class="col-sm-6 col-xs-6">
									<select class="form-control" id="months" name="months" >
										<option value="">-</option>
										{foreach from=$months key=k item=month}
											<option value="{$k}" {if ($sl_month == $k)} selected="selected"{/if}>{l s=$month}&nbsp;</option>
										{/foreach}
									</select>
								</div>
								<div class="col-sm-3 col-xs-3">
									<select class="form-control" id="years" name="years" >
										<option value="">-</option>
										{foreach from=$years item=year}
											<option value="{$year}" {if ($sl_year == $year)} selected="selected"{/if}>{$year}&nbsp;&nbsp;</option>
										{/foreach}
									</select>
								</div>
							</div>
						</div>
					</div>
					{if isset($newsletter) && $newsletter}
						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-8">
								<div class="checkbox">
									<label class="col-sm-8" for="newsletter">
									<input type="checkbox" name="newsletter" id="newsletter" value="1" {if isset($smarty.post.newsletter) && $smarty.post.newsletter == '1'}checked="checked"{/if} />
									{l s='Sign up for our newsletter!'}</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-8">
								<div class="checkbox">
									<label class="col-sm-8" for="optin">
									<input type="checkbox" name="optin" id="optin" value="1" {if isset($smarty.post.optin) && $smarty.post.optin == '1'}checked="checked"{/if} />
									{l s='Receive special offers from our partners!'}</label>
								</div>
							</div>
						</div>
					{/if}
					<h3 class="page-subheading bottom-indent top-indent"><span>{l s='Delivery address'}</span></h3>
					{foreach from=$dlv_all_fields item=field_name}
						{if $field_name eq "company" && $b2b_enable}
							<div class="form-group">
								<label class="control-label col-sm-4" for="company">{l s='Company'}</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" id="company" name="company" value="{if isset($smarty.post.company)}{$smarty.post.company}{/if}" />
								</div>
							</div>
						{elseif $field_name eq "vat_number"}
							<div id="vat_number" style="display:none;">
								<div class="form-group">
									<label class="control-label col-sm-4" for="vat-number">{l s='VAT number'}</label>
									<div class="col-sm-6">
										<input id="vat-number" type="text" class="form-control" name="vat_number" value="{if isset($smarty.post.vat_number)}{$smarty.post.vat_number}{/if}" />
									</div>
								</div>
							</div>
							{elseif $field_name eq "dni"}
							{assign var='dniExist' value=true}
							<div class="required dni form-group">
								<label class="control-label col-sm-4" for="dni">{l s='Identification number'} <sup>*</sup></label>
								<div class="col-sm-6">
									<input type="text" name="dni" id="dni" value="{if isset($smarty.post.dni)}{$smarty.post.dni}{/if}" />
									<span class="form_info">{l s='DNI / NIF / NIE'}</span>
								</div>
							</div>
						{elseif $field_name eq "address1"}
							<div class="required form-group">
								<label class="control-label col-sm-4" for="address1">{l s='Address'} <sup>*</sup></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="address1" id="address1" value="{if isset($smarty.post.address1)}{$smarty.post.address1}{/if}" />
								</div>
							</div>
						{elseif $field_name eq "address2"}
							<div class="form-group is_customer_param">
								<label class="control-label col-sm-4" for="address2">{l s='Address (Line 2)'} <sup>*</sup></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="address2" id="address2" value="{if isset($smarty.post.address2)}{$smarty.post.address2}{/if}" />
								</div>
							</div>
						{elseif $field_name eq "postcode"}
							{assign var='postCodeExist' value=true}
							<div class="required postcode form-group">
								<label class="control-label col-sm-4" for="postcode">{l s='Zip / Postal Code'} <sup>*</sup></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="postcode" id="postcode" value="{if isset($smarty.post.postcode)}{$smarty.post.postcode}{/if}" onblur="$('#postcode').val($('#postcode').val().toUpperCase());" />
								</div>
							</div>
						{elseif $field_name eq "city"}
							<div class="required form-group">
								<label class="control-label col-sm-4" for="city">{l s='City'} <sup>*</sup></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="city" id="city" value="{if isset($smarty.post.city)}{$smarty.post.city}{/if}" />
								</div>
							</div>
							<!-- if customer hasn't update his layout address, country has to be verified but it's deprecated -->
						{elseif $field_name eq "Country:name" || $field_name eq "country"}
							<div class="required select form-group">
								<label class="control-label col-sm-4" for="id_country">{l s='Country'} <sup>*</sup></label>
								<div class="col-sm-6">
									<select class="form-control" name="id_country" id="id_country" >
										{foreach from=$countries item=v}
											<option value="{$v.id_country}"{if (isset($smarty.post.id_country) AND  $smarty.post.id_country == $v.id_country) OR (!isset($smarty.post.id_country) && $sl_country == $v.id_country)} selected="selected"{/if}>{$v.name}</option>
										{/foreach}
									</select>
								</div>
							</div>
						{elseif $field_name eq "State:name"}
							{assign var='stateExist' value=true}
							<div class="required id_state select form-group">
								<label class="control-label col-sm-4" for="id_state">{l s='State'} <sup>*</sup></label>
								<div class="col-sm-6">
									<select class="form-control" name="id_state" id="id_state"  >
										<option value="">-</option>
									</select>
								</div>
							</div>
						{/if}
					{/foreach}
					{if $stateExist eq false}
						<div class="required id_state select unvisible form-group">
							<label class="control-label col-sm-4" for="id_state">{l s='State'} <sup>*</sup></label>
							<div class="col-sm-6">
								<select class="form-control" name="id_state" id="id_state"  >
									<option value="">-</option>
								</select>
							</div>
						</div>
					{/if}
					{if $postCodeExist eq false}
						<div class="required postcode unvisible form-group">
							<label class="control-label col-sm-4" for="postcode">{l s='Zip / Postal Code'} <sup>*</sup></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="postcode" id="postcode" value="{if isset($smarty.post.postcode)}{$smarty.post.postcode}{/if}" onblur="$('#postcode').val($('#postcode').val().toUpperCase());" />
							</div>
						</div>
					{/if}
					{if $dniExist eq false}
						<div class="required form-group dni_invoice">
							<label class="control-label col-sm-4" for="dni">{l s='Identification number'} <sup>*</sup></label>
							<div class="col-sm-6">
								<input type="text" class="text form-control" name="dni_invoice" id="dni_invoice" value="{if isset($guestInformations) && $guestInformations.dni_invoice}{$guestInformations.dni_invoice}{/if}" />
								<span class="form_info">{l s='DNI / NIF / NIE'}</span>
							</div>
						</div>
					{/if}
					<div class="{if isset($one_phone_at_least) && $one_phone_at_least}required {/if}form-group">
						<label class="control-label col-sm-4" for="phone_mobile">{l s='Mobile phone'}{if isset($one_phone_at_least) && $one_phone_at_least} <sup>*</sup>{/if}</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="phone_mobile" id="phone_mobile" value="{if isset($smarty.post.phone_mobile)}{$smarty.post.phone_mobile}{/if}" />
						</div>
					</div>
					<input type="hidden" name="alias" id="alias" value="{l s='My address'}" />
					<input type="hidden" name="is_new_customer" id="is_new_customer" value="0" />
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-7">
							<div class="checkbox">
								<label class="col-sm-8" for="invoice_address">
								<input type="checkbox" name="invoice_address" id="invoice_address"{if (isset($smarty.post.invoice_address) && $smarty.post.invoice_address) || (isset($guestInformations) && $guestInformations.invoice_address)} checked="checked"{/if} autocomplete="off"/>
								{l s='Please use another address for invoice'}</label>
							</div>
						</div>
					</div>
					<div id="opc_invoice_address"  class="unvisible">
						{assign var=stateExist value=false}
						{assign var=postCodeExist value=false}
						<h3 class="page-subheading top-indent"><span>{l s='Invoice address'}</span></h3>
						{foreach from=$inv_all_fields item=field_name}
						{if $field_name eq "company" && $b2b_enable}
						<div class="form-group">
							<label class="control-label col-sm-4" for="company_invoice">{l s='Company'}</label>
							<div class="col-sm-6">
								<input type="text" class="text form-control" id="company_invoice" name="company_invoice" value="" />
							</div>
						</div>
						{elseif $field_name eq "vat_number"}
						<div id="vat_number_block_invoice" class="is_customer_param" style="display:none;">
							<div class="form-group">
								<label class="control-label col-sm-4" for="vat_number_invoice">{l s='VAT number'}</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" id="vat_number_invoice" name="vat_number_invoice" value="" />
								</div>
							</div>
						</div>
						{elseif $field_name eq "dni"}
						{assign var=dniExist value=true}
						<div class="required form-group dni_invoice">
							<label class="control-label col-sm-4" for="dni">{l s='Identification number'} <sup>*</sup></label>
							<div class="col-sm-6">
								<input type="text" class="text form-control" name="dni_invoice" id="dni_invoice" value="{if isset($guestInformations) && $guestInformations.dni_invoice}{$guestInformations.dni_invoice}{/if}" />
								<span class="form_info">{l s='DNI / NIF / NIE'}</span>
							</div>
						</div>
						{elseif $field_name eq "firstname"}
						<div class="required form-group">
							<label class="control-label col-sm-4" for="firstname_invoice">{l s='First name'} <sup>*</sup></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="firstname_invoice" name="firstname_invoice" value="{if isset($guestInformations) && $guestInformations.firstname_invoice}{$guestInformations.firstname_invoice}{/if}" />
							</div>
						</div>
						{elseif $field_name eq "lastname"}
						<div class="required form-group">
							<label class="control-label col-sm-4" for="lastname_invoice">{l s='Last name'} <sup>*</sup></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="lastname_invoice" name="lastname_invoice" value="{if isset($guestInformations) && $guestInformations.lastname_invoice}{$guestInformations.lastname_invoice}{/if}" />
							</div>
						</div>
						{elseif $field_name eq "address1"}
						<div class="required form-group">
							<label class="control-label col-sm-4" for="address1_invoice">{l s='Address'} <sup>*</sup></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="address1_invoice" id="address1_invoice" value="{if isset($guestInformations) && $guestInformations.address1_invoice}{$guestInformations.address1_invoice}{/if}" />
							</div>
						</div>
						{elseif $field_name eq "address2"}
						<div class="form-group is_customer_param">
							<label class="control-label col-sm-4" for="address2_invoice">{l s='Address (Line 2)'}</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="address2_invoice" id="address2_invoice" value="{if isset($guestInformations) && $guestInformations.address2_invoice}{$guestInformations.address2_invoice}{/if}" />
							</div>
						</div>
						{elseif $field_name eq "postcode"}
						{$postCodeExist = true}
						<div class="required postcode_invoice form-group">
							<label class="control-label col-sm-4" for="postcode_invoice">{l s='Zip / Postal Code'} <sup>*</sup></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="postcode_invoice" id="postcode_invoice" value="{if isset($guestInformations) && $guestInformations.postcode_invoice}{$guestInformations.postcode_invoice}{/if}" onkeyup="$('#postcode_invoice').val($('#postcode_invoice').val().toUpperCase());" />
							</div>
						</div>
						{elseif $field_name eq "city"}
						<div class="required form-group">
							<label class="control-label col-sm-4" for="city_invoice">{l s='City'} <sup>*</sup></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="city_invoice" id="city_invoice" value="{if isset($guestInformations) && $guestInformations.city_invoice}{$guestInformations.city_invoice}{/if}" />
							</div>
						</div>
						{elseif $field_name eq "country" || $field_name eq "Country:name"}
						<div class="required form-group">
							<label class="control-label col-sm-4" for="id_country_invoice">{l s='Country'} <sup>*</sup></label>
							<div class="col-sm-6">
								<select class="form-control" name="id_country_invoice" id="id_country_invoice" >
									<option value="">-</option>
									{foreach from=$countries item=v}
										<option value="{$v.id_country}"{if (isset($guestInformations) AND $guestInformations.id_country_invoice == $v.id_country) OR (!isset($guestInformations) && $sl_country == $v.id_country)} selected="selected"{/if}>{$v.name|escape:'html':'UTF-8'}</option>
									{/foreach}
								</select>
							</div>
						</div>
						{elseif $field_name eq "state" || $field_name eq 'State:name'}
						{$stateExist = true}
						<div class="required id_state_invoice form-group" style="display:none;">
							<label class="control-label col-sm-4" for="id_state_invoice">{l s='State'} <sup>*</sup></label>
							<div class="col-sm-6">
								<select class="form-control" name="id_state_invoice" id="id_state_invoice" >
									<option value="">-</option>
								</select>
							</div>
						</div>
						{/if}
						{/foreach}
						{if !$postCodeExist}
						<div class="required postcode_invoice form-group unvisible">
							<label class="control-label col-sm-4" for="postcode_invoice">{l s='Zip / Postal Code'} <sup>*</sup></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="postcode_invoice" id="postcode_invoice" value="" onkeyup="$('#postcode').val($('#postcode').val().toUpperCase());" />
							</div>
						</div>
						{/if}					
						{if !$stateExist}
						<div class="required id_state_invoice form-group unvisible">
							<label class="control-label col-sm-4" for="id_state_invoice">{l s='State'} <sup>*</sup></label>
							<div class="col-sm-6">
								<select class="form-control" name="id_state_invoice" id="id_state_invoice" >
									<option value="">-</option>
								</select>
							</div>
						</div>
						{/if}
						<div class="form-group is_customer_param">
							<label class="control-label col-sm-4" for="other_invoice">{l s='Additional information'}</label>
							<div class="col-sm-6">
								<textarea class="form-control" name="other_invoice" id="other_invoice" cols="26" rows="3"></textarea>
							</div>
						</div>
						{if isset($one_phone_at_least) && $one_phone_at_least}
							<div class="inline-infos required is_customer_param"><label class="col-sm-offset-4 col-sm-6">{l s='You must register at least one phone number.'}</label></div>
						{/if}					
						<div class="form-group is_customer_param">
							<label class="control-label col-sm-4" for="phone_invoice">{l s='Home phone'}</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="phone_invoice" id="phone_invoice" value="{if isset($guestInformations) && $guestInformations.phone_invoice}{$guestInformations.phone_invoice}{/if}" />
							</div>
						</div>
						<div class="{if isset($one_phone_at_least) && $one_phone_at_least}required {/if}form-group">
							<label class="control-label col-sm-4" for="phone_mobile_invoice">{l s='Mobile phone'}{if isset($one_phone_at_least) && $one_phone_at_least} <sup>*</sup>{/if}</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="phone_mobile_invoice" id="phone_mobile_invoice" value="{if isset($guestInformations) && $guestInformations.phone_mobile_invoice}{$guestInformations.phone_mobile_invoice}{/if}" />
							</div>
						</div>
						<input type="hidden" name="alias_invoice" id="alias_invoice" value="{l s='My Invoice address'}" />
					</div>
					<!-- END Account -->
				</div>
				{$HOOK_CREATE_ACCOUNT_FORM}
			</div>
			<p class="cart_navigation required submit clearfix">
				<span><sup>*</sup>{l s='Required field'}</span>
				<input type="hidden" name="display_guest_checkout" value="1" />
				<button type="submit" class="button btn btn-outline button-medium btn-sm" name="submitGuestAccount" id="submitGuestAccount">
					<span>
						{l s='Proceed to checkout'}						
					</span>
				</button>
			</p>
		</form>
	{/if}
{else}
	<!--{if isset($account_error)}
	<div class="error">
		{if {$account_error|@count} == 1}
			<p>{l s='There\'s at least one error'} :</p>
			{else}
			<p>{l s='There are %s errors' sprintf=[$account_error|@count]} :</p>
		{/if}
		<ol>
			{foreach from=$account_error item=v}
				<li>{$v}</li>
			{/foreach}
		</ol>
	</div>
	{/if}-->
	<form action="{$link->getPageLink('authentication', true)|escape:'html':'UTF-8'}" method="post" id="account-creation_form" class="std box form-horizontal">
		{$HOOK_CREATE_ACCOUNT_TOP}
		<div class="account_creation">
			<h3 class="page-subheading"><span>{l s='Your personal information'}</span></h3>
			<div class="clearfix form-group">
				<label class="control-label col-sm-4">{l s='Title'}</label>
				<div class="col-sm-6">
					{foreach from=$genders key=k item=gender}
						<div class="radio-inline">
							<label for="id_gender{$gender->id}" class="top">
								<input type="radio" name="id_gender" id="id_gender{$gender->id}" value="{$gender->id}" {if isset($smarty.post.id_gender) && $smarty.post.id_gender == $gender->id}checked="checked"{/if} />
							{$gender->name}
							</label>
						</div>
					{/foreach}
				</div>
			</div>
			<div class="required form-group">
				<label class="control-label col-sm-4" for="customer_firstname">{l s='First name'} <sup>*</sup></label>
				<div class="col-sm-6">
					<input onkeyup="$('#firstname').val(this.value);" type="text" class="is_required validate form-control" data-validate="isName" id="customer_firstname" name="customer_firstname" value="{if isset($smarty.post.customer_firstname)}{$smarty.post.customer_firstname}{/if}" />
				</div>
			</div>
			<div class="required form-group">
				<label class="control-label col-sm-4" for="customer_lastname">{l s='Last name'} <sup>*</sup></label>
				<div class="col-sm-6">
					<input onkeyup="$('#lastname').val(this.value);" type="text" class="is_required validate form-control" data-validate="isName" id="customer_lastname" name="customer_lastname" value="{if isset($smarty.post.customer_lastname)}{$smarty.post.customer_lastname}{/if}" />
				</div>
			</div>
			<div class="required form-group">
				<label class="control-label col-sm-4" for="email">{l s='Email'} <sup>*</sup></label>
				<div class="col-sm-6">
					<input type="text" class="is_required validate form-control" data-validate="isEmail" id="email" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email}{/if}" />
				</div>
			</div>
			<div class="required password form-group">
				<label class="control-label col-sm-4" for="passwd">{l s='Password'} <sup>*</sup></label>
				<div class="col-sm-6">
					<input type="password" class="is_required validate form-control" data-validate="isPasswd" name="passwd" id="passwd" />
					<span class="form_info">{l s='(Five characters minimum)'}</span>
				</div> 
			</div> 
			<div class="form-group">
				<label class="control-label col-sm-4">{l s='Date of Birth'}</label>
				<div class="col-sm-6">
					<div class="row">
						<div class="col-sm-3 col-xs-3">
							<select class="form-control" id="days" name="days" >
								<option value="">-</option>
								{foreach from=$days item=day}
									<option value="{$day}" {if ($sl_day == $day)} selected="selected"{/if}>{$day}&nbsp;&nbsp;</option>
								{/foreach}
							</select>
							{*
								{l s='January'}
								{l s='February'}
								{l s='March'}
								{l s='April'}
								{l s='May'}
								{l s='June'}
								{l s='July'}
								{l s='August'}
								{l s='September'}
								{l s='October'}
								{l s='November'}
								{l s='December'}
							*}
						</div>
						<div class="col-sm-6 col-xs-6">
							<select class="form-control" id="months" name="months" >
								<option value="">-</option>
								{foreach from=$months key=k item=month}
									<option value="{$k}" {if ($sl_month == $k)} selected="selected"{/if}>{l s=$month}&nbsp;</option>
								{/foreach}
							</select>
						</div>
						<div class="col-sm-3 col-xs-3">
							<select class="form-control" id="years" name="years" >
								<option value="">-</option>
								{foreach from=$years item=year}
									<option value="{$year}" {if ($sl_year == $year)} selected="selected"{/if}>{$year}&nbsp;&nbsp;</option>
								{/foreach}
							</select>
						</div>
					</div>
				</div>
			</div>
			{if $newsletter}
			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-8">
					<div class="checkbox">
						<input type="checkbox" name="newsletter" id="newsletter" value="1" {if isset($smarty.post.newsletter) AND $smarty.post.newsletter == 1} checked="checked"{/if} />
						<label for="newsletter">{l s='Sign up for our newsletter!'}</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-8">
					<div class="checkbox">
						<input type="checkbox"name="optin" id="optin" value="1" {if isset($smarty.post.optin) AND $smarty.post.optin == 1} checked="checked"{/if} />
						<label for="optin">{l s='Receive special offers from our partners!'}</label>
					</div>
				</div>
			</div>
			{/if}
		</div>
		{if $b2b_enable}
			<div class="account_creation">
				<h3 class="page-subheading"><span>{l s='Your company information'}</span></h3>
				<div class="form-group">
					<label class="control-label col-sm-4" for="">{l s='Company'}</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="company" name="company" value="{if isset($smarty.post.company)}{$smarty.post.company}{/if}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-4" for="siret">{l s='SIRET'}</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="siret" name="siret" value="{if isset($smarty.post.siret)}{$smarty.post.siret}{/if}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-4" for="ape">{l s='APE'}</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="ape" name="ape" value="{if isset($smarty.post.ape)}{$smarty.post.ape}{/if}" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-4" for="website">{l s='Website'}</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="website" name="website" value="{if isset($smarty.post.website)}{$smarty.post.website}{/if}" />
					</div>
				</div>
			</div>
		{/if}
		{if isset($PS_REGISTRATION_PROCESS_TYPE) && $PS_REGISTRATION_PROCESS_TYPE}
			<div class="account_creation">
				<h3 class="page-subheading"><span>{l s='Your address'}</span></h3>
				{foreach from=$dlv_all_fields item=field_name}
					{if $field_name eq "company"}
						{if !$b2b_enable}
							<div class="form-group">
								<label class="control-label col-sm-4" for="company">{l s='Company'}</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" id="company" name="company" value="{if isset($smarty.post.company)}{$smarty.post.company}{/if}" />
								</div>
							</div>
						{/if}
					{elseif $field_name eq "vat_number"}
						<div id="vat_number" style="display:none;">
							<div class="form-group">
								<label class="control-label col-sm-4" for="vat_number">{l s='VAT number'}</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="vat_number" value="{if isset($smarty.post.vat_number)}{$smarty.post.vat_number}{/if}" />
								</div>
							</div>
						</div>
					{elseif $field_name eq "firstname"}
						<div class="required form-group">
							<label class="control-label col-sm-4" for="firstname">{l s='First name'} <sup>*</sup></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="firstname" name="firstname" value="{if isset($smarty.post.firstname)}{$smarty.post.firstname}{/if}" />

							</div>
						</div>
					{elseif $field_name eq "lastname"}
						<div class="required form-group">
							<label class="control-label col-sm-4" for="lastname">{l s='Last name'} <sup>*</sup></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="lastname" name="lastname" value="{if isset($smarty.post.lastname)}{$smarty.post.lastname}{/if}" />
							</div>
						</div>
					{elseif $field_name eq "address1"}
						<div class="required form-group">
							<label class="control-label col-sm-4" for="address1">{l s='Address'} <sup>*</sup></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="address1" id="address1" value="{if isset($smarty.post.address1)}{$smarty.post.address1}{/if}" />
								<span class="inline-infos">{l s='Street address, P.O. Box, Company name, etc.'}</span>
							</div>
						</div>
					{elseif $field_name eq "address2"}
						<div class="form-group is_customer_param">
							<label class="control-label col-sm-4" for="address2">{l s='Address (Line 2)'}</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="address2" id="address2" value="{if isset($smarty.post.address2)}{$smarty.post.address2}{/if}" />
								<span class="inline-infos">{l s='Apartment, suite, unit, building, floor, etc...'}</span>
							</div>
						</div>
					{elseif $field_name eq "postcode"}
						{assign var='postCodeExist' value=true}
						<div class="required postcode form-group">
							<label class="control-label col-sm-4" for="postcode">{l s='Zip / Postal Code'} <sup>*</sup></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="postcode" id="postcode" value="{if isset($smarty.post.postcode)}{$smarty.post.postcode}{/if}" onkeyup="$('#postcode').val($('#postcode').val().toUpperCase());" />
							</div>
						</div>
					{elseif $field_name eq "city"}
						<div class="required form-group">
							<label class="control-label col-sm-4" for="city">{l s='City'} <sup>*</sup></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="city" id="city" value="{if isset($smarty.post.city)}{$smarty.post.city}{/if}" />
							</div>
						</div>
						<!-- if customer hasn't update his layout address, country has to be verified but it's deprecated -->
					{elseif $field_name eq "Country:name" || $field_name eq "country"}
						<div class="required select form-group">
							<label class="control-label col-sm-4" for="id_country">{l s='Country'} <sup>*</sup></label>
							<div class="col-sm-6">
								<select class="form-control" name="id_country" id="id_country" >
									<option value="">-</option>
									{foreach from=$countries item=v}
									<option value="{$v.id_country}"{if (isset($smarty.post.id_country) AND $smarty.post.id_country == $v.id_country) OR (!isset($smarty.post.id_country) && $sl_country == $v.id_country)} selected="selected"{/if}>{$v.name}</option>
									{/foreach}
								</select>
							</div>
						</div>
					{elseif $field_name eq "State:name" || $field_name eq 'state'}
						{assign var='stateExist' value=true}
						<div class="required id_state select form-group">
							<label class="control-label col-sm-4" for="id_state">{l s='State'} <sup>*</sup></label>
							<div class="col-sm-6">
								<select class="form-control" name="id_state" id="id_state"  >
									<option value="">-</option>
								</select>
							</div>
						</div>
					{/if}
				{/foreach}
				{if $postCodeExist eq false}
					<div class="required postcode form-group unvisible">
						<label class="control-label col-sm-4" for="postcode">{l s='Zip / Postal Code'} <sup>*</sup></label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="postcode" id="postcode" value="{if isset($smarty.post.postcode)}{$smarty.post.postcode}{/if}" onkeyup="$('#postcode').val($('#postcode').val().toUpperCase());" />
						</div>
					</div>
				{/if}		
				{if $stateExist eq false}
					<div class="required id_state select unvisible form-group">
						<label class="control-label col-sm-4" for="id_state">{l s='State'} <sup>*</sup></label>
						<div class="col-sm-6">
							<select class="form-control" name="id_state" id="id_state" >
								<option value="">-</option>
							</select>
						</div>
					</div>
				{/if}
				<div class="textarea form-group">
					<label class="control-label col-sm-4" for="other">{l s='Additional information'}</label>
					<div class="col-sm-6">
						<textarea class="form-control" name="other" id="other" cols="26" rows="3">{if isset($smarty.post.other)}{$smarty.post.other}{/if}</textarea>
					</div>
				</div>
				{if isset($one_phone_at_least) && $one_phone_at_least}
					<div class="inline-infos"><label class="col-sm-offset-4 col-sm-6">{l s='You must register at least one phone number.'}</label></div>
				{/if}
				<div class="form-group">
					<label class="control-label col-sm-4" for="phone">{l s='Home phone'}</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="phone" id="phone" value="{if isset($smarty.post.phone)}{$smarty.post.phone}{/if}" />
					</div>
				</div>
				<div class="{if isset($one_phone_at_least) && $one_phone_at_least}required {/if}form-group">
					<label class="control-label col-sm-4" for="phone_mobile">{l s='Mobile phone'}{if isset($one_phone_at_least) && $one_phone_at_least} <sup>*</sup>{/if}</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="phone_mobile" id="phone_mobile" value="{if isset($smarty.post.phone_mobile)}{$smarty.post.phone_mobile}{/if}" />
					</div>
				</div>
				<div class="required form-group" id="address_alias">
					<label class="control-label col-sm-4" for="alias">{l s='Assign an address alias for future reference.'} <sup>*</sup></label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="alias" id="alias" value="{if isset($smarty.post.alias)}{$smarty.post.alias}{else}{l s='My address'}{/if}" />
					</div>
				</div>
			</div>
			<div class="account_creation dni">
				<h3 class="page-subheading"><span>{l s='Tax identification'}</span></h3>
				<div class="required form-group">
					<label class="control-label col-sm-4" for="dni">{l s='Identification number'} <sup>*</sup></label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="dni" id="dni" value="{if isset($smarty.post.dni)}{$smarty.post.dni}{/if}" />
						<span class="form_info">{l s='DNI / NIF / NIE'}</span>
					</div>
				</div>
			</div>
		{/if}
		{$HOOK_CREATE_ACCOUNT_FORM}
		<div class="submit clearfix">
			<input type="hidden" name="email_create" value="1" />
			<input type="hidden" name="is_new_customer" value="1" />
			{if isset($back)}<input type="hidden" class="hidden" name="back" value="{$back|escape:'html':'UTF-8'}" />{/if}
			<button type="submit" name="submitAccount" id="submitAccount" class="btn btn-outline button button-medium">
				<span>{l s='Register'}</span>
			</button>
			<p class="pull-right required"><span><sup>*</sup>{l s='Required field'}</span></p>
		</div>
	</form>
{/if}
{strip}
{if isset($smarty.post.id_state) && $smarty.post.id_state}
	{addJsDef idSelectedState=$smarty.post.id_state|intval}
{else if isset($address->id_state) && $address->id_state}
	{addJsDef idSelectedState=$address->id_state|intval}
{else}
	{addJsDef idSelectedState=false}
{/if}
{if isset($smarty.post.id_country) && $smarty.post.id_country}
	{addJsDef idSelectedCountry=$smarty.post.id_country|intval}
{else if isset($address->id_country) && $address->id_country}
	{addJsDef idSelectedCountry=$address->id_country|intval}
{else}
	{addJsDef idSelectedCountry=false}
{/if}
{if isset($countries)}
	{addJsDef countries=$countries}
{/if}
{if isset($vatnumber_ajax_call) && $vatnumber_ajax_call}
	{addJsDef vatnumber_ajax_call=$vatnumber_ajax_call}
{/if}
{if isset($email_create) && $email_create}
	{addJsDef email_create=$email_create|boolval}
{else}
	{addJsDef email_create=false}
{/if}
{/strip}
