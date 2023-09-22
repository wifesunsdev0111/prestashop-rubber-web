{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\front\products\image_container -->
<div class="product-image-container">
	<div class="leo-more-info hidden-xs" data-idproduct="{$product.id_product|intval}"></div>
		<a class="product_img_link" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
			<img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} itemprop="image" />
			<span class="product-additional" data-idproduct="{$product.id_product|intval}"></span>
		</a>
		{if isset($product.new) && $product.new == 1}
			<a class="new-box" href="{$product.link|escape:'html':'UTF-8'}">
				<span class="new-label">{l s='New' mod='appagebuilder'}</span>
			</a>
		{/if}
		{if (!$PS_CATALOG_MODE && ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
			<div class="content_price" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
				{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
					<span itemprop="price" class="price product-price">
						{hook h="displayProductPriceBlock" product=$product type="before_price"}
						{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
					</span>
					<meta itemprop="priceCurrency" content="{$currency->iso_code}" />
					{if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
						{hook h="displayProductPriceBlock" product=$product type="old_price"}
						<span class="old-price product-price">
							{displayWtPrice p=$product.price_without_reduction}
						</span>
						{if $product.specific_prices.reduction_type == 'percentage'}
							<span class="price-percent-reduction">-{$product.specific_prices.reduction * 100}%</span>
						{/if}
					{/if}
					{if $PS_STOCK_MANAGEMENT && isset($product.available_for_order) && $product.available_for_order && !isset($restricted_country_mode)}
						<span class="unvisible">
							{if ($product.allow_oosp || $product.quantity > 0)}
									<link itemprop="availability" href="https://schema.org/InStock" />{if $product.quantity <= 0}{if $product.allow_oosp}{if isset($product.available_later) && $product.available_later}{$product.available_later}{else}{l s='In Stock' mod='appagebuilder'}{/if}{else}{l s='Out of stock' mod='appagebuilder'}{/if}{else}{if isset($product.available_now) && $product.available_now}{$product.available_now}{else}{l s='In Stock'}{/if}{/if}
							{elseif (isset($product.quantity_all_versions) && $product.quantity_all_versions > 0)}
									<link itemprop="availability" href="https://schema.org/LimitedAvailability" />{l s='Product available with different options' mod='appagebuilder'}

							{else}
									<link itemprop="availability" href="https://schema.org/OutOfStock" />{l s='Out of stock mod='appagebuilder''}
							{/if}
						</span>
					{/if}
					{hook h="displayProductPriceBlock" product=$product type="price"}
					{hook h="displayProductPriceBlock" product=$product type="unit_price"}
				{/if}
			</div>
		{/if}
		{if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
			<a class="sale-box" href="{$product.link|escape:'html':'UTF-8'}">
				<span class="sale-label">{l s='Sale!' mod='appagebuilder'}</span>
			</a>
		{/if}
</div>