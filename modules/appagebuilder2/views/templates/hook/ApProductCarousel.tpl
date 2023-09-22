{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApProductCarousel -->
<div class="block products_block exclusive appagebuilder {if isset($formAtts.class)}{$formAtts.class|escape:'html':'UTF-8'}{/if}">
	{($apLiveEdit)?$apLiveEdit:''}{* HTML form , no escape necessary *}
	{if isset($formAtts.title)&&!empty($formAtts.title)}
	<h4 class="title_block">
		{$formAtts.title|rtrim|escape:'html':'UTF-8'}
	</h4>
	{/if}
	<div class="block_content">	
            {if !empty($products)}
                {if $formAtts.carousel_type == "boostrap"}
                    {include file='./ProductCarousel.tpl'}
                {else}
                    {include file='./ProductOwlCarousel.tpl'}
                {/if}
            {else}
                <p class="alert alert-info">{l s='No products at this time.' mod='appagebuilder'}</p>	
            {/if}
	</div>
	{($apLiveEditEnd)?$apLiveEditEnd:''}{* HTML form , no escape necessary *}
</div>