{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\front\products\price -->
{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
	<div class="content_price">
		{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
			{hook h="displayProductPriceBlock" product=$product type='before_price'}
			<span class="price product-price">
				{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
			</span>
			{if $product.price_without_reduction > 0 && isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
				{hook h="displayProductPriceBlock" product=$product type="old_price"}
				<span class="old-price product-price">
					{displayWtPrice p=$product.price_without_reduction}
				</span>
				{hook h="displayProductPriceBlock" id_product=$product.id_product type="old_price"}
				{if $product.specific_prices.reduction_type == 'percentage'}
					<span class="price-percent-reduction">-{$product.specific_prices.reduction * 100}%</span>
				{/if}
			{/if}
			{hook h="displayProductPriceBlock" product=$product type="price"}
			{hook h="displayProductPriceBlock" product=$product type="unit_price"}
			{hook h="displayProductPriceBlock" product=$product type='after_price'}
		{/if}
	</div>
{/if}