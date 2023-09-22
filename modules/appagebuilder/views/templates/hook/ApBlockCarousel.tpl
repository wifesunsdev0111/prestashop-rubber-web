{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApBlockCarousel -->
<div class="block block_carousel exclusive appagebuilder">
	{($apLiveEdit)?$apLiveEdit:''}{* HTML form , no escape necessary *}
	<div class="block_content">
		{if !empty($formAtts.slides)}
			{if $formAtts.carousel_type == 'boostrap'}
				{include file='./ApBlockCarouselItem.tpl'}
			{else}
				{include file='./ApBlockOwlCarouselItem.tpl'}
			{/if}
		{else}
			<p class="alert alert-info">{l s='No slide at this time.' mod='appagebuilder'}</p>
		{/if}
	</div>
	{($apLiveEditEnd)?$apLiveEditEnd:''}{* HTML form , no escape necessary *}
</div>