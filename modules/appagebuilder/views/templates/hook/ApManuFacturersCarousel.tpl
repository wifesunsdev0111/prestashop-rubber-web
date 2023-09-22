{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApManuFacturersCarousel -->
<div class="block manufacturers_block exclusive appagebuilder">
	{($apLiveEdit)?$apLiveEdit:''}{* HTML form , no escape necessary *}
	{if isset($formAtts.title)&&!empty($formAtts.title)}
	<h4 class="title_block">
		{$formAtts.title|escape:'html':'UTF-8'}
	</h4>
	{/if}
	<div class="block_content">
		{if !empty($manufacturers)}
			{if $formAtts.carousel_type == "boostrap"}
				{include file='./manufacturers_carousel.tpl'}
			{else}
				{include file='./manufacturers_owl_carousel.tpl'}
			{/if}
		{else}
			<p class="alert alert-info">{l s='No manufacturer at this time.' mod='appagebuilder'}</p>
		{/if}
	</div>
	{($apLiveEditEnd)?$apLiveEditEnd:''}{* HTML form , no escape necessary *}
</div>