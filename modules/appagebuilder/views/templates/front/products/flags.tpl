{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\front\products\flags -->
<div class="product-flags">
	{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
		{if isset($product.online_only) && $product.online_only}
			<span class="online_only">{l s='Online only' mod='appagebuilder'}</span>
		{/if}
	{/if}
	{if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
		{elseif isset($product.reduction) && $product.reduction && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
			<span class="discount">{l s='Reduced price!' mod='appagebuilder'}</span>
		{/if}
</div>


