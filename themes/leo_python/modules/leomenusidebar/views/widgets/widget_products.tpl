 {if isset($products) && !empty($products)}
<div class="widget-products">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<div class="widget-heading">
		{$widget_heading}
	</div>
	{/if}
	<div class="widget-inner">
		
		{if isset($products) AND $products}
			{assign var='liHeight' value=140}
			{assign var='nbItemsPerLine' value=3}
			{assign var='nbLi' value=$limit}
			{math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
			{math equation="nbLines*liHeight" nbLines=$nbLines|ceil liHeight=$liHeight assign=ulHeight}
			 

			{$mproducts=array_chunk($products,$limit)}
			 

 
			{foreach from=$products item=product name=homeFeaturedProducts}
				{math equation="(total%perLine)" total=$smarty.foreach.homeFeaturedProducts.total perLine=$nbItemsPerLine assign=totModulo}
				{if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
			 
  				{include file="$tpl_dir./sub/product-item/product-item.tpl"}				

			{/foreach}
 
		{/if}


	</div>
</div>
{addJsDefL name=min_item}{l s='Please select at least one product' js=1}{/addJsDefL}
{addJsDefL name=max_item}{l s='You cannot add more than %d product(s) to the product comparison' sprintf=$comparator_max_item js=1}{/addJsDefL}
{addJsDef comparator_max_item=$comparator_max_item}
{addJsDef comparedProductsIds=$compared_products}
{/if}