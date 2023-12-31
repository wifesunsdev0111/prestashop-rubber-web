{*
* 2007-2015 PrestaShop
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
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{capture name=path}{l s='Contact'}{/capture}

{if isset($confirmation)}
	<p class="alert alert-success">{l s='Your message has been successfully sent to our team.' mod='apcontactform'}</p>
	<ul class="footer_links clearfix">
		<li>
			<a class="btn btn-default button button-small" href="{$base_dir}">
				<span>
					<i class="icon-chevron-left"></i>{l s='Home' mod='apcontactform'}
				</span>
			</a>
		</li>
	</ul>
{elseif isset($alreadySent)}
	<p class="alert alert-warning">{l s='Your message has already been sent.' mod='apcontactform'}</p>
	<ul class="footer_links clearfix">
		<li>
			<a class="btn btn-default button button-small" href="{$base_dir}">
				<span>
					<i class="icon-chevron-left"></i>{l s='Home' mod='apcontactform'}
				</span>
			</a>
		</li>
	</ul>
{else}
	{include file="$tpl_dir./errors.tpl"}
	<form action="{$request_uri}" method="post" class="contact-box" enctype="multipart/form-data">
		<fieldset>
			{*<h3 class="title_block"><span>{l s='Contact Us' mod='apcontactform'}</span></h3>*}
			<div class="contact-content row">
				<div class="col-xs-12 col-md-12">
					<div class="row">
					<div class="form-group selector1">
						<label for="id_contact">{l s='Subject Heading' mod='apcontactform'}</label>
					{if isset($customerThread.id_contact) && $customerThread.id_contact && $contacts|count}
							{assign var=flag value=true}
							{foreach from=$contacts item=contact}
								{if $contact.id_contact == $customerThread.id_contact}
									<input type="text" class="form-control" id="contact_name" name="contact_name" value="{$contact.name|escape:'html':'UTF-8'}" readonly="readonly" />
									<input type="hidden" name="id_contact" value="{$contact.id_contact|intval}" />
									{$flag=false}
								{/if}
							{/foreach}
							{if $flag && isset($contacts.0.id_contact)}
									<input type="text" class="form-control" id="contact_name" name="contact_name" value="{$contacts.0.name|escape:'html':'UTF-8'}" readonly="readonly" />
									<input type="hidden" name="id_contact" value="{$contacts.0.id_contact|intval}" />
							{/if}
					</div>
					</div>
					{else}
						<select id="id_contact" class="form-control" name="id_contact">
							<option value="0">{l s='-- Choose --' mod='apcontactform'}</option>
							{foreach from=$contacts item=contact}
								<option value="{$contact.id_contact|intval}"{if isset($smarty.request.id_contact) && $smarty.request.id_contact == $contact.id_contact} selected="selected"{/if}>{$contact.name|escape:'html':'UTF-8'}</option>
							{/foreach}
						</select>
					</div>
						{foreach from=$contacts item=contact}
							<p id="desc_contact{$contact.id_contact|intval}" class="desc_contact contact-title{if !isset($smarty.request.id_contact) || $smarty.request.id_contact|intval != $contact.id_contact|intval} unvisible{/if}">
								<i class="icon-comment-alt"></i>{$contact.description|escape:'html':'UTF-8'}
							</p>
						{/foreach}
					{/if}
					<p class="form-group">
						<label for="email">{l s='Email address' mod='apcontactform'}</label>
						{if isset($customerThread.email)}
							<input class="form-control grey" type="text" id="email" name="from" value="{$customerThread.email|escape:'html':'UTF-8'}" readonly="readonly" />
						{else}
							<input class="form-control grey validate" type="text" id="email" name="from" data-validate="isEmail" value="{$email|escape:'html':'UTF-8'}" />
						{/if}
					</p>
					{if !$PS_CATALOG_MODE}
						{if (!isset($customerThread.id_order) || $customerThread.id_order > 0)}
							<div class="form-group selector1">
								<label>{l s='Order reference' mod='apcontactform'}</label>
								{if !isset($customerThread.id_order) && isset($is_logged) && $is_logged}
									<select name="id_order" class="form-control">
										<option value="0">{l s='-- Choose --' mod='apcontactform'}</option>
										{foreach from=$orderList item=order}
											<option value="{$order.value|intval}"{if $order.selected|intval} selected="selected"{/if}>{$order.label|escape:'html':'UTF-8'}</option>
										{/foreach}
									</select>
								{elseif !isset($customerThread.id_order) && empty($is_logged)}
									<input class="form-control grey" type="text" name="id_order" id="id_order" value="{if isset($customerThread.id_order) && $customerThread.id_order|intval > 0}{$customerThread.id_order|intval}{else}{if isset($smarty.post.id_order) && !empty($smarty.post.id_order)}{$smarty.post.id_order|escape:'html':'UTF-8'}{/if}{/if}" />
								{elseif $customerThread.id_order|intval > 0}
									<input class="form-control grey" type="text" name="id_order" id="id_order" value="{if isset($customerThread.reference) && $customerThread.reference}{$customerThread.reference|escape:'html':'UTF-8'}{else}{$customerThread.id_order|intval}{/if}" readonly="readonly" />
								{/if}
							</div>
						{/if}
						{if isset($is_logged) && $is_logged}
							<div class="form-group selector1">
								<label class="unvisible">{l s='Product' mod='apcontactform'}</label>
								{if !isset($customerThread.id_product)}
									{foreach from=$orderedProductList key=id_order item=products name=products}
										<select name="id_product" id="{$id_order}_order_products" class="unvisible product_select form-control"{if !$smarty.foreach.products.first} style="display:none;"{/if}{if !$smarty.foreach.products.first} disabled="disabled"{/if}>
											<option value="0">{l s='-- Choose --'}</option>
											{foreach from=$products item=product}
												<option value="{$product.value|intval}">{$product.label|escape:'html':'UTF-8'}</option>
											{/foreach}
										</select>
									{/foreach}
								{elseif $customerThread.id_product > 0}
									<input  type="hidden" name="id_product" id="id_product" value="{$customerThread.id_product|intval}" readonly="readonly" />
								{/if}
							</div>
						{/if}
					{/if}
					{if $fileupload == 1}
						<p class="form-group">
							<label for="fileUpload">{l s='Attach File' mod='apcontactform'}</label>
							<input type="hidden" name="MAX_FILE_SIZE" value="{if isset($max_upload_size) && $max_upload_size}{$max_upload_size|intval}{else}2000000{/if}" />
							<input type="file" name="fileUpload" id="fileUpload" class="form-control" />
						</p>
					{/if}
				</div>
				<div class="row">
					<div class="form-group fmessage">
							<label for="message">{l s='Message' mod='apcontactform'}</label>
							<textarea class="form-control" id="message" name="message">{if isset($message)}{$message|escape:'html':'UTF-8'|stripslashes}{/if}</textarea>
					</div>
				</div>
				<div class="submit">
					<button type="submit" name="submitMessage" id="submitMessage" class="button btn btn-outline button-medium"><span>{l s='submit message' mod='apcontactform'}<i class="icon-chevron-right right"></i></span></button>
				</div>
			</div>
			
		</fieldset>
	</form>
{/if}
{addJsDefL name='contact_fileDefaultHtml'}{l s='No file selected' mod='apcontactform' js=1}{/addJsDefL}
{addJsDefL name='contact_fileButtonHtml'}{l s='Choose File' mod='apcontactform' js=1}{/addJsDefL}
{addJsDefL name='contact_form_error'}{l s='Please input all data before submit' mod='apcontactform' js=1}{/addJsDefL}
