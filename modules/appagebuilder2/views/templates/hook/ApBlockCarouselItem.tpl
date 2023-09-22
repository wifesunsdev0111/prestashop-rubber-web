{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApBlockCarouselItem -->
{if isset($formAtts.title) && $formAtts.title}
	<h4 class="title_block">{$formAtts.title|escape:'html':'UTF-8'}</h4>
{/if}
<div class="block_content">
{if isset($formAtts.descript)}
	<div>{$formAtts.descript|escape:'html':'UTF-8'}</div>
{/if}
<div data-ride="carousel" class="carousel slide" id="{$carouselName|escape:'html':'UTF-8'}">
	{$NumCount = count($formAtts.slides)}
	{if $NumCount > $itemsperpage}
		<a class="carousel-control left" href="#{$carouselName|escape:'html':'UTF-8'}" data-slide="prev">&lsaquo;</a>
		<a class="carousel-control right" href="#{$carouselName|escape:'html':'UTF-8'}" data-slide="next">&rsaquo;</a>
	{/if}
	<div class="carousel-inner">
	{$Num=array_chunk($formAtts.slides, $itemsperpage)}
	{foreach from=$Num item=sliders name=val}
		<div class="item {if $smarty.foreach.val.first}active{/if}">

			{foreach from=$sliders item=slider name="sliders"}

				{if $nbItemsPerLine == 1 || $smarty.foreach.sliders.first || $smarty.foreach.sliders.iteration%$nbItemsPerLine == 1}
					<div class="row">
				{/if}
				<div class="{$scolumn|escape:'html':'UTF-8'}">
					{if $slider.link}
					<a title="{l s='%s' sprintf=[$slider.title] mod='appagebuilder'}" {if $formAtts.is_open}target="_blank"{/if} href="{$slider.link}{*full link can not escape*}">
					{/if}
					
					{if isset($slider.image) && !empty($slider.image)}
						<img class="img-responsive" src="{$slider.image|escape:'html':'UTF-8'}" alt="{if isset($slider.title)}{$slider.title|escape:'html':'UTF-8'}{/if}"/>
					{/if}
					{if isset($slider.title) && !empty($slider.title)}
						<div class="title">{$slider.title|escape:'html':'UTF-8'}</div>
					{/if}
					{if isset($slider.descript) && !empty($slider.descript)}
						<div class="descript">{$slider.descript}{* HTML form , no escape necessary *}</div>
					{/if}
					{if $slider.link}
					</a>
					{/if}
				</div>
				{if $nbItemsPerLine == 1 || $smarty.foreach.sliders.last || $smarty.foreach.sliders.iteration%$nbItemsPerLine == 0}
					</div>
				{/if}
			{/foreach}
		</div>
	{/foreach}
</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('#{$carouselName|escape:'html':'UTF-8'}').each(function(){
		$(this).carousel({
			pause: 'hover',
			interval: {$formAtts.interval|escape:'html':'UTF-8'}
		});
	});
});
</script>