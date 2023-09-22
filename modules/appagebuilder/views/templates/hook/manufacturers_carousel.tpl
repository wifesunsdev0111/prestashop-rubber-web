{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\manufacturers_carousel -->
<div data-ride="carousel" class="carousel slide" id="{$carouselName|escape:'html':'UTF-8'}">
	{$NumManu = count($manufacturers)}
	{if $NumManu > $itemsperpage}
		<a class="carousel-control left" href="#{$carouselName|escape:'html':'UTF-8'}" data-slide="prev">&lsaquo;</a>
		<a class="carousel-control right" href="#{$carouselName|escape:'html':'UTF-8'}" data-slide="next">&rsaquo;</a>
	{/if}
	<div class="carousel-inner">

	{if array_key_exists('select_by_manufacture',$formAtts) && $formAtts.select_by_manufacture eq '1'}
		{$Num=array_chunk($manuselect,$itemsperpage)}
	{else}
		{$Num=array_chunk($manuselect,$itemsperpage)}
	{/if}
		{foreach from=$Num item=manuselect name=manuloop}
			<div class="item {if $smarty.foreach.manuloop.first}active{/if}">
				{$i = 0}
				{foreach from=$manuselect item=manu}
					{$i = $i+1}
					{if ($i mod $nbItemsPerLine) eq 1 || $i eq 1}
						<div class="row">
					{elseif ($i mod $nbItemsPerLine) eq 0 and $i gt $nbItemsPerLine}
						<div class="row">
					{/if}
					<div class="{$scolumn|escape:'html':'UTF-8'}">
						<a title="{l s='%s' sprintf=[$manu.name] mod='appagebuilder'}" 
						   href="{$link->getmanufacturerLink($manu.id_manufacturer, $manu.link_rewrite)|escape:'html':'UTF-8'}">
							<img class="img-responsive" src="{$img_manu_dir|escape:'html':'UTF-8'}{$manu.id_manufacturer|escape:'html':'UTF-8'}-{$image_type|escape:'html':'UTF-8'}.jpg" alt="{$manu.name|escape:'html':'UTF-8'}" />
							{$manu.name|escape:'html':'UTF-8'}
						</a>
					</div>
					{if ($i mod $nbItemsPerLine) eq 0}
						</div>
					{/if}
				{/foreach}
				{if ($i mod $nbItemsPerLine) gt 0}
					</div>
				{/if}
			</div>
		{/foreach}
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