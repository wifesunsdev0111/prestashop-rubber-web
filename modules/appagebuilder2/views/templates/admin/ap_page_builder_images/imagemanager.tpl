{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\admin\ap_page_builder_images\imagemanager -->
{if isset($reloadBack) && $reloadBack==1}
	{foreach $images as $image}
		<div style="background:url('{$image.link|escape:'html':'UTF-8'}') no-repeat center center;" class="pull-left" data-image="{$image.link|escape:'html':'UTF-8'}" data-val="../../img/patterns/{$image.name|escape:'html':'UTF-8'}">

		</div>
	{/foreach}
{else}
{if !(isset($reloadSliderImage) && $reloadSliderImage==1)}
<div class="bootstrap image-manager">
<div class="panel product-tab">
<h3 class="tab" >
	{l s='Images Manager' mod='appagebuilder'}
	<span class="badge" id="countImage">{$countImages|escape:'html':'UTF-8'}</span>
	<label class="control-label col-lg-3 file_upload_label">
			{l s='Format:' mod='appagebuilder'} JPG, GIF, PNG. {l s='Filesize:' mod='appagebuilder'} {$max_image_size|string_format:"%.2f"|escape:'html':'UTF-8'} {l s='MB max.' mod='appagebuilder'}
	</label>
</h3>

<div class="row">
	<div class="form-group">
		<div class="col-lg-12">
			{$image_uploader}{* HTML form , no escape necessary *}
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group">
		<ul id="list-imgs">
{/if}
{foreach from=$images item=image name=myLoop}
	<li>
		<div class="row img-row">
			<a class="label-tooltip img-link" data-toggle="tooltip" href="{$image.link|escape:'html':'UTF-8'}" title="{$image.name|escape:'html':'UTF-8'}" style="height:70px;overflow: hidden">
				<img class="select-img" data-name="{$image.name|escape:'html':'UTF-8'}" title="" width="70" alt="" src="{$image.link|escape:'html':'UTF-8'}"/>
			</a>
		 </div>
		<div class="row">
			<a class="fancybox" data-toggle="tooltip" href="{$image.link|escape:'html':'UTF-8'}" title="{l s='Click to view' mod='appagebuilder'}">
				<i class="icon-eye-open"></i>
				{l s='View' mod='appagebuilder'}
			</a>
			<a href="{$link->getAdminLink('AdminApPageBuilderImages')|escape:'html':'UTF-8'}&imgName={$image.name|rtrim|escape:'html':'UTF-8'}" class="text-danger delete-image" title="{l s='Delete Selected Image?' mod='appagebuilder'}" onclick="if (confirm('{l s='Delete Selected Image?' mod='appagebuilder'}')) {
					return deleteImage($(this));
				} else {
					return false;
				}
				;">
				<i class="icon-remove"></i>
				{l s='Delete' mod='appagebuilder'}
			</a>
		</div>
	</li>
{/foreach}
{if !(isset($reloadSliderImage) && $reloadSliderImage==1)}
		</ul>
	</div>
</div>
<script type="text/javascript">
{addJsDef imgManUrl=$imgManUrl}
var upbutton = "{l s='Upload an image' mod='appagebuilder'}";
{literal}
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});

	function deleteImage(element){
		$.ajax({
			type: 'GET',
			url: element.attr("href") + '&reloadSliderImage=1&sortBy=name',
			data: '',
			dataType: 'json',
			cache: false, // @todo see a way to use cache and to add a timestamps parameter to refresh cache each 10 minutes for example
			success: function(data) {
				 $("#list-imgs").html(data);
				 $("#countImage").text($("#list-imgs li").length);
				 $('.label-tooltip').tooltip();
				 $('.fancybox').fancybox();
			}
		});

		return false;
	}

	function getUrlVars()
	{
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++)
		{
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
	}
{/literal}
</script>
</div>
</div>
{/if}
{/if}
