{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\admin\_configure\helpers\form\form -->
{extends file="helpers/form/form.tpl"}
{block name="field"}
	{if $input.type == 'blockLink'}
		<div class="col-lg-9 cover-block-link">
			<div class="col-lg-1 fr"><button type="button" class="fr btn btn-warning btn-remove-block-link">{l s='Remove' mod='appagebuilder'}</button></div>
			{foreach from=$languages item=language}
					<div class="translatable-field lang-{$language.id_lang|escape:'html':'UTF-8'}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
						<div class="col-lg-6">
							<input type="text" class="" value=""/>
						</div>
						<div class="col-lg-1 {if $languages|count <= 1}hide{/if}">
							<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
								{$language.iso_code|escape:'html':'UTF-8'}
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								{foreach from=$languages item=lang}
								<li><a href="javascript:hideOtherLanguage({$lang.id_lang|escape:'html':'UTF-8'});" tabindex="-1">{$lang.name|escape:'html':'UTF-8'}</a></li>
								{/foreach}
							</ul>
						</div>
					</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$('#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|escape:'html':'UTF-8'}-selectbutton').click(function(e){
							$('#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|escape:'html':'UTF-8'}').trigger('click');
						});
						$('#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|escape:'html':'UTF-8'}').change(function(e){
							var val = $(this).val();
							var file = val.split(/[\\/]/);
							$('#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|escape:'html':'UTF-8'}-name').val(file[file.length-1]);
						});
					});
				</script>
			{/foreach}
		</div>
		<p style="margin-bottom: 10px; float: left; width: 100%;"></p>
		<label class="control-label col-lg-3">{l s='Link' mod='appagebuilder'}</label>
		<div class="col-lg-9 cover-link">
			{foreach from=$languages item=language}
					<div class="translatable-field lang-{$language.id_lang|escape:'html':'UTF-8'}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
						<div class="col-lg-6">
							<input type="text" class="" value=""/>
						</div>
						<div class="col-lg-1 {if $languages|count <= 1}hide{/if}">
							<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
								{$language.iso_code|escape:'html':'UTF-8'}
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								{foreach from=$languages item=lang}
								<li><a href="javascript:hideOtherLanguage({$lang.id_lang|escape:'html':'UTF-8'});" tabindex="-1">{$lang.name|escape:'html':'UTF-8'}</a></li>
								{/foreach}
							</ul>
						</div>
					</div>
				<script type="text/javascript">
					$(document).ready(function(){
						$('#{$input.name|escape:'html':'UTF-8'}_link_{$language.id_lang|escape:'html':'UTF-8'}-selectbutton').click(function(e){
							$('#{$input.name|escape:'html':'UTF-8'}_link_{$language.id_lang|escape:'html':'UTF-8'}').trigger('click');
						});
						$('#{$input.name|escape:'html':'UTF-8'}_link_{$language.id_lang|escape:'html':'UTF-8'}').change(function(e){
							var val = $(this).val();
							var file = val.split(/[\\/]/);
							$('#{$input.name|escape:'html':'UTF-8'}_link_{$language.id_lang|escape:'html':'UTF-8'}-name').val(file[file.length-1]);
						});
					});
				</script>
			{/foreach}
		</div>
	{/if}
	{if $input.type == 'tabConfig'}
		<div class="row">
			{assign var=tabList value=$input.values}
			<ul class="nav nav-tabs" role="tablist">
			{foreach $tabList as $key => $value name="tabList"}
				<li role="presentation" class="{if $smarty.foreach.tabList.first}active{/if}"><a href="#{$key|escape:'html':'UTF-8'}" class="aptab-config" role="tab" data-toggle="tab">{$value|escape:'html':'UTF-8'}</a></li>
			{/foreach}
			</ul>
		</div>
	{/if}
	{if $input.type == 'selectImg'}

		<div class="row">
			{foreach from=$languages item=language}
				{if $languages|count > 1}
					<div class="translatable-field lang-{$language.id_lang|escape:'html':'UTF-8'}" data-lang="{$language.id_lang|escape:'html':'UTF-8'}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
				{/if}
					<div class="col-lg-6">
						{if isset($fields_value[$input.name][$language.id_lang]) && $fields_value[$input.name][$language.id_lang]}
						<img src="{$path_image|escape:'html':'UTF-8'}{$fields_value[$input.name][$language.id_lang]|escape:'html':'UTF-8'}" class="img-thumbnail" data-img="">
						{/if}
						<a class="field-link choose-img {if isset($input.class)}{$input.class|escape:'html':'UTF-8'}{/if}" data-fancybox-type="iframe" href="{$input.href|escape:'html':'UTF-8'}" data-for="#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|escape:'html':'UTF-8'}">{l s='Select image' mod='appagebuilder'}</a>
						<input id="{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|escape:'html':'UTF-8'}" type="text" name="{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|escape:'html':'UTF-8'}" class="hide" value="{$fields_value[$input.name][$language.id_lang]|escape:'html':'UTF-8'}"/>

					</div>
				{if $languages|count > 1}
					<div class="col-lg-2">
						<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
							{$language.iso_code|escape:'html':'UTF-8'}
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							{foreach from=$languages item=lang}
							<li><a href="javascript:hideOtherLanguage({$lang.id_lang|escape:'html':'UTF-8'});" tabindex="-1">{$lang.name|escape:'html':'UTF-8'}</a></li>
							{/foreach}
						</ul>
					</div>
				{/if}
				{if $languages|count > 1}
					</div>
				{/if}
				<script type="text/javascript">
				$(document).ready(function(){
					$('#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|escape:'html':'UTF-8'}-selectbutton').click(function(e){
						$('#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|escape:'html':'UTF-8'}').trigger('click');
					});
					$('#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|escape:'html':'UTF-8'}').change(function(e){
						var val = $(this).val();
						var file = val.split(/[\\/]/);
						$('#{$input.name|escape:'html':'UTF-8'}_{$language.id_lang|escape:'html':'UTF-8'}-name').val(file[file.length-1]);
					});
				});
			</script>
			{/foreach}
		</div>
	{/if}
	{if $input.type == 'img_cat'}
		{assign var=tree value=$input.tree}
			{assign var=imageList value=$input.imageList}
			{assign var=selected_images value=$input.selected_images}
		<div class="form-group form-select-icon">
			<label class="control-label col-lg-3 " for="categories"> {l s='Categories' mod='appagebuilder'} </label>
			<div class="col-lg-9">
			{$tree}{* HTML form , no escape necessary *}
			</div>
			<input type="hidden" name="category_img" id="category_img" value='{$selected_images|escape:'html':'UTF-8'}'/>
			<div id="list_image_wrapper" style="display:none">
				<div class="list-image">
					<img id="apci" src="" class="hidden" path="{$input.path_image|escape:'html':'UTF-8'}" widget="ApCategoryImage"/>
					<a data-for="#apci" href="{$input.href_image|escape:'html':'UTF-8'}" class="apcategoryimage field-link choose-img"> [{l s='Select image' mod='appagebuilder'}]</a>
					<a href="javascript:;" class="apcategoryimage field-link remove-img hidden"> [{l s='Remove image' mod='appagebuilder'}]</a>
				  </div>
			</div>
			<script type="text/javascript">
				full_loaded = true;
			</script>
		</div>
	{/if}
	{if $input.type == 'categories'}
		<script type="text/javascript">
			var full_loaded = undefined;
		</script>
	{/if}
	{if $input.type == 'bg_img'}
		<div class="col-lg-9 ">
			<input type="text" name="bg_img" id="bg_img" value="{$fields_value['bg_img']|escape:'html':'UTF-8'}" class="">
          {if strpos($fields_value['bg_img'], "/") !== false}
              <img id="s-image"{if !$fields_value['bg_img']} class="hidden"{/if} src="{$fields_value['img_link']|escape:'html':'UTF-8'}{$fields_value['bg_img']|escape:'html':'UTF-8'}"/>
          {else}
              <img id="s-image"{if !$fields_value['bg_img']} class="hidden"{/if} src="{$input.img_link|escape:'html':'UTF-8'}{$fields_value['bg_img']|escape:'html':'UTF-8'}"/>
          {/if}
			<div>
				<a class="choose-img" data-fancybox-type="iframe" href="{$link->getAdminLink('AdminApPageBuilderImages')|escape:'html':'UTF-8'}&imgDir=images&is_ajax=true" data-for="#bg_img">{l s='Select image' mod='appagebuilder'}</a> -
				<a class="reset-img" href="javascript:void(0)" onclick="resetBgImage();">{l s='Reset' mod='appagebuilder'}</a>
			</div>
			<p class="help-block">{l s='Please put image link or select image' mod='appagebuilder'}</p>
		</div>
		<script type="text/javascript">
			function resetBgImage(){
				// Reset img and hidden input
				$("#s-image").addClass('hiden');
				$("#s-image").attr('src','');
				$("#bg_img").val('');
			}
		</script>
	{/if}    
	{if $input.type == 'apExceptions'}
		<div class="well">
				<div>
						{l s='Please specify the files for which you do not want it to be displayed.' mod='appagebuilder'}<br />
						{l s='Please input each filename, separated by a comma (",").' mod='appagebuilder'}<br />
						{l s='You can also click the filename in the list below, and even make a multiple selection by keeping the Ctrl key pressed while clicking, or choose a whole range of filename by keeping the Shift key pressed while clicking.' mod='appagebuilder'}<br />
						{$exception_list}{* HTML form , no escape necessary *}
				</div>
		</div>
	{/if}
	{if $input.type == 'ApColumnclass' || $input.type == 'ApRowclass'}
		<div class="">
			<div class="well">
				<div class="row">
				   {if $input.type == 'ApRowclass'} 
				   <label class="choise-class col-lg-12"><input type="checkbox" class="select-class" data-value="row" value="1"> {l s='Use class row' mod='appagebuilder'}</label>
				   {/if}
				   <label class="control-label col-lg-1">{l s='Class:' mod='appagebuilder'}</label>
					<div class="col-lg-11"><input type="text" class="element_class" value="{$fields_value['class']|escape:'html':'UTF-8'}" name="class"></div>
				</div><br/>
				<div class="desc-bottom">
				{l s='Insert new or select classes for toggling content across viewport breakpoints' mod='appagebuilder'}<br>
				<ul class="ap-col-class">
					<li>
						<label class="choise-class"><input class="select-class" type="checkbox" data-value="hidden-lg" value="1"> {l s='Hidden in Large devices' mod='appagebuilder'}</label>
					</li>
					<li>
						<label class="choise-class"><input class="select-class" type="checkbox" data-value="hidden-md" value="1"> {l s='Hidden in Medium devices' mod='appagebuilder'}</label>
					</li>
					<li>    
						<label class="choise-class"><input class="select-class" type="checkbox" data-value="hidden-sm" value="1"> {l s='Hidden in Small devices' mod='appagebuilder'}</label>
					</li>
					<li>
						<label class="choise-class"><input class="select-class" type="checkbox" data-value="hidden-xs" value="1"> {l s='Hidden in Extra small devices' mod='appagebuilder'}</label>
					</li>
					<li>
						<label class="choise-class"><input class="select-class" type="checkbox" data-value="hidden-sp" value="1"> {l s='Hidden in Smart Phone' mod='appagebuilder'}</label>
					</li>
				</ul>
				</div>
			</div>
		</div>
	{/if}

	{if $input.type == 'bg_select'}
		{$image_uploader}{* HTML form , no escape necessary *}
	{/if}
	{if $input.type == 'column_width'}
		<div class="panel panel-default">
			<div class="panel-body">
				<p>{l s='Responsive: You can config width for each Devices' mod='appagebuilder'}</p>
			</div>
			<table class="table">
				<thead><tr>
					  <th>{l s='Devices' mod='appagebuilder'}</th>
					  <th>{l s='Width' mod='appagebuilder'}</th>
				</tr></thead>
				<tbody>
					{foreach $input.columnGrids as $gridKey=>$gridValue}
					<tr>
						<td>
							<span class="col-{$gridKey|escape:'html':'UTF-8'}"></span>
							{$gridValue|escape:'html':'UTF-8'}
						</td>
						<td>
							<div class="btn-group">
								<input type='hidden' class="col-val" name='{$gridKey|escape:'html':'UTF-8'}' value="{$fields_value[$gridKey]|escape:'html':'UTF-8'}"/>
								<button type="button" class="btn btn-default apbtn-width dropdown-toggle" tabindex="-1" data-toggle="dropdown">
									<span class="width-val ap-w-{$fields_value[$gridKey]|replace:'.':'-'|escape:'html':'UTF-8'}">{$fields_value[$gridKey]|escape:'html':'UTF-8'}/12 - ( {math equation="x/y*100" x=$fields_value[$gridKey]|replace:'-':'.' y=12 format="%.2f"} % )</span><span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									{foreach from=$widthList item=itemWidth}
									<li>
										<a class="width-select" href="javascript:void(0);" tabindex="-1">
											<span data-width="{$itemWidth|replace:'.':'-'|escape:'html':'UTF-8'}" class="width-val ap-w-{if $itemWidth|strpos:"."|escape:'html':'UTF-8'}{$itemWidth|replace:'.':'-'|escape:'html':'UTF-8'}{else}{$itemWidth|escape:'html':'UTF-8'}{/if}">{$itemWidth|escape:'html':'UTF-8'}/12 - ( {math equation="x/y*100" x=$itemWidth|replace:'-':'.' y=12 format="%.2f"} % )</span>
										</a>
									</li>
									{/foreach}
								</ul>
							</div>
						</td>
					</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	{/if}
	{$smarty.block.parent}
{/block}