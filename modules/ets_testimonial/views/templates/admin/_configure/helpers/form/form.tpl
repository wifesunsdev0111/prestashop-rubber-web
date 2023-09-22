{*
* 2007-2022 ETS-Soft
*
* NOTICE OF LICENSE
*
* This file is not open source! Each license that you purchased is only available for 1 wesite only.
* If you want to use this file on more websites (or projects), you need to purchase additional licenses. 
* You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
* 
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs, please contact us for extra customization service at an affordable price
*
*  @author ETS-Soft <etssoft.jsc@gmail.com>
*  @copyright  2007-2022 ETS-Soft
*  @license    Valid for 1 website (or project) for each purchase of license
*  International Registered Trademark & Property of ETS-Soft
*}
{extends file="helpers/form/form.tpl"}

{block name="input"}
    {if $input.type == 'file_lang'}
        {if isset($is15) && $is15}
            <div class="translatable">
				{foreach $languages as $language}
					<div class="lang_{$language.id_lang|escape:'html':'UTF-8'}" id="{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|escape:'html':'UTF-8'}" style="display:{if $language.id_lang == $defaultFormLanguage}block{else}none{/if}; float: left;">
						<input type="file" name="{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}" {if isset($input.id)}id="{$input.id|escape:'html':'UTF-8'}_{$language.id_lang|escape:'html':'UTF-8'}"{/if} />
		                {if isset($fields_value[$input.name]) && $fields_value[$input.name] && $fields_value[$input.name][$language.id_lang]}
                            <label class="control-label col-lg-3 uploaded_image_label" style="font-style: italic;">{l s='Uploaded image: ' mod='ets_testimonial'}</label>
                            <div class="col-lg-9 uploaded_img_wrapper">
                        		<img style="display: inline-block; max-width: 200px;" src="{$image_baseurl|escape:'html':'UTF-8'}{$fields_value[$input.name][$language.id_lang]|escape:'html':'UTF-8'}" />
                                {if !(isset($input.required) && $input.required)}
                                    <a onclick="return confirm('{l s='Do you want to delete this image?' mod='ets_testimonial' js=1}');" class="delete_url"  style="display: inline-block; text-decoration: none!important;" href="{$image_del_link|escape:'html':'UTF-8'}&id_lang={$language.id_lang|intval}&field={$input.name|escape:'html':'UTF-8'}"><span style="color: #666"><i style="font-size: 20px;" class="process-icon-delete"></i></span></a>
                                {/if}
                            </div>
						{/if}  
					</div>
				{/foreach}
			</div>
        {else}
    		{if $languages|count > 1}
    		  <div class="form-group">
    		{/if}
    			{foreach from=$languages item=language}
    				{if $languages|count > 1}
    					<div class="translatable-field lang-{$language.id_lang|intval}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
    				{/if}
    					<div class="col-lg-9">
    						<div class="dummyfile input-group sass">
    							<input id="{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}" type="file" name="{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}" class="hide-file-upload" />
    							<span class="input-group-addon"><i class="icon-file"></i></span>
    							<input id="{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}-name" type="text" class="disabled" name="filename" readonly />
    							<span class="input-group-btn">
    								<button id="{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}-selectbutton" type="button" name="submitAddAttachments" class="btn btn-default">
    									<i class="icon-folder-open"></i> {l s='Choose a file' d='Admin.Actions'}
    								</button>
    							</span>
    						</div>
                            {if isset($fields_value[$input.name]) && $fields_value[$input.name] && $fields_value[$input.name][$language.id_lang]}
                                <label class="control-label col-lg-3 uploaded_image_label" style="font-style: italic;">{l s='Uploaded image: ' mod='ets_testimonial'}</label>
                                <div class="col-lg-9 uploaded_img_wrapper">
                            		<img style="display: inline-block; max-width: 200px;" src="{$image_baseurl|escape:'html':'UTF-8'}{$fields_value[$input.name][$language.id_lang]|escape:'html':'UTF-8'}" />
                                    {if !(isset($input.required) && $input.required)}
                                        <a onclick="return confirm('{l s='Do you want to delete this image?' mod='ets_testimonial' js=1}');" class="delete_url"  style="display: inline-block; text-decoration: none!important;" href="{$image_del_link|escape:'html':'UTF-8'}&id_lang={$language.id_lang|intval}&field={$input.name|escape:'html':'UTF-8'}"><span style="color: #666"><i style="font-size: 20px;" class="process-icon-delete"></i></span></a>
                                    {/if}
                                </div>
    						{/if}
    					</div>
    				{if $languages|count > 1}
    					<div class="col-lg-2">
    						<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
    							{$language.iso_code|escape:'html':'UTF-8'}
    							<span class="caret"></span>
    						</button>
    						<ul class="dropdown-menu">
    							{foreach from=$languages item=lang}
    							<li><a href="javascript:hideOtherLanguage({$lang.id_lang|intval});" tabindex="-1">{$lang.name|escape:'html':'UTF-8'}</a></li>
    							{/foreach}
    						</ul>
    					</div>
    				{/if}
    				{if $languages|count > 1}
    					</div>
    				{/if}
    				<script>
    				$(document).ready(function(){
    					$("#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}-selectbutton,#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}-name").click(function(e){
    						$("#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}").trigger('click');
    					});
    					$("#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}").change(function(e){
    						var val = $(this).val();
    						var file = val.split(/[\\/]/);
    						$("#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|intval}-name").val(file[file.length-1]);
    					});
    				});
    			</script>
    			{/foreach}
    		{if $languages|count > 1}
    		  </div>
    		{/if}
        {/if}
    {elseif $input.type == 'switch'}
    	{if isset($is15) && $is15}
            <span class="switch prestashop-switch fixed-width-lg">
        		{foreach $input.values as $value}
        		<input type="radio" name="{$input.name|escape:'html':'UTF-8'}"{if $value.value == 1} id="{$input.name|escape:'html':'UTF-8'}_on"{else} id="{$input.name|escape:'html':'UTF-8'}_off"{/if} value="{$value.value|escape:'html':'UTF-8'}"{if $fields_value[$input.name] == $value.value} checked="checked"{/if}{if (isset($input.disabled) && $input.disabled) or (isset($value.disabled) && $value.disabled)} disabled="disabled"{/if}/>
        		{strip}
        		<label {if $value.value == 1} for="{$input.name|escape:'html':'UTF-8'}_on"{else} for="{$input.name|escape:'html':'UTF-8'}_off"{/if}>
        			{if $value.value == 1}
        				{l s='Yes' mod='ets_testimonial'}
        			{else}
        				{l s='No' mod='ets_testimonial'}
        			{/if}
        		</label>
        		{/strip}
        		{/foreach}
        		<a class="slide-button btn"></a>
        	</span>
        {else}
            {$smarty.block.parent}  
        {/if}
    {elseif $input.type=='rate'}
        <div class="ets_ttn_star_content">
    		<input class="star not_uniform" type="radio" name="{$input.name|escape:'html':'UTF-8'}" value="1" title="{l s='Terrible' mod='ets_testimonial'}" {if $fields_value[$input.name]==1}checked="checked"{/if} />
    		<input class="star not_uniform" type="radio" name="{$input.name|escape:'html':'UTF-8'}" value="2" title="{l s='Acceptable' mod='ets_testimonial'}" {if $fields_value[$input.name]==2}checked="checked"{/if}/>
    		<input class="star not_uniform" type="radio" name="{$input.name|escape:'html':'UTF-8'}" value="3" title="{l s='Fairly Good' mod='ets_testimonial'}" {if $fields_value[$input.name]==3}checked="checked"{/if}/>
    		<input class="star not_uniform" type="radio" name="{$input.name|escape:'html':'UTF-8'}" value="4" title="{l s='Good' mod='ets_testimonial'}" {if $fields_value[$input.name]==4}checked="checked"{/if} />
    		<input class="star not_uniform" type="radio" name="{$input.name|escape:'html':'UTF-8'}" value="5" title="{l s='Excellent' mod='ets_testimonial'}" {if $fields_value[$input.name]==5}checked="checked"{/if}/>
    	</div>
    {else}
        {if isset($is15) && $is15 && isset($input.form_group_class) && $input.form_group_class}
            <div class="form-group {$input.form_group_class|escape:'html':'UTF-8'}">
        {/if}
        {$smarty.block.parent}  
        {if isset($is15) && $is15 && isset($input.form_group_class) && $input.form_group_class}
            </div>
        {/if}             
    {/if}            
{/block}