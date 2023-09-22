{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<div class="product-container product-block" itemscope itemtype="http://schema.org/Product"><div class="left-block">
<!-- @file modules\appagebuilder\views\templates\front\products\image_container -->
<div class="product-image-container">
	<div class="leo-more-info hidden-xs" data-idproduct="{$product.id_product}"></div>
		<a class="product_img_link"	href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
			<img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} itemprop="image" />
			<span class="product-additional" data-idproduct="{$product.id_product}"></span>
		</a>
		{if isset($product.new) && $product.new == 1}
			<a class="new-box" href="{$product.link|escape:'html':'UTF-8'}">
				<span class="new-label">{l s='New' mod='appagebuilder'}</span>
			</a>
		{/if}
		{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
			<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
					<meta itemprop="priceCurrency" content="{$currency->iso_code}" />
					{if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
						{hook h="displayProductPriceBlock" product=$product type="old_price"}
						
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



<!-- @file modules\appagebuilder\views\templates\front\products\quick_view -->
{if isset($quick_view) && $quick_view}

	<a class="quick-view" href="{$product.link|escape:'html':'UTF-8'}" rel="{$product.link|escape:'html':'UTF-8'}">
		<span>{l s='Quick view' mod='appagebuilder'}</span>
	</a>
{/if}


</div><div class="right-block"><div class="product-meta">
<!-- @file modules\appagebuilder\views\templates\front\products\price -->
{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="content_price">
        {if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
            <span itemprop="price" class="price product-price">
                {if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
            </span>
                    <meta itemprop="priceCurrency" content="{$currency->iso_code}" />
            {if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
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
        {/if}
    </div>
{/if}



<!-- @file modules\appagebuilder\views\templates\front\products\reviews -->
{hook h='displayProductListReviews' product=$product}



<!-- @file modules\appagebuilder\views\templates\front\products\name -->
<h5 itemprop="name">
	{if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}
	<a class="product-name" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
		{$product.name|truncate:45:'...'|escape:'html':'UTF-8'}
	</a>
</h5>


<div class="functional-buttons clearfix">
<!-- @file modules\appagebuilder\views\templates\front\products\wishlist -->
{hook h='displayProductListFunctionalButtons' product=$product}



<!-- @file modules\appagebuilder\views\templates\front\products\add_to_cart -->
<div class="cart">
{if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.minimal_quantity <= 1 && $product.customizable != 2 && !$PS_CATALOG_MODE}
	{if ($product.allow_oosp || $product.quantity > 0)}
		{if isset($static_token)}
			<a class="ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, "add=1&amp;id_product={$product.id_product|intval}&amp;token={$static_token}", false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart' mod='appagebuilder'}" data-id-product="{$product.id_product|intval}">
				<span><i class="icon-shopping-cart"></i>{l s='Add to cart' mod='appagebuilder'}</span>
			</a>
		{else}
			<a class="ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, 'add=1&amp;id_product={$product.id_product|intval}', false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart' mod='appagebuilder'}" data-id-product="{$product.id_product|intval}">
				<span><i class="icon-shopping-cart"></i>{l s='Add to cart' mod='appagebuilder'}</span>
			</a>
		{/if}
	{else}
		<span class="ajax_add_to_cart_button btn btn-default disabled">
			<span><i class="icon-shopping-cart"></i>{l s='Add to cart' mod='appagebuilder'}</span>
		</span>
	{/if}
{/if}
</div>


<!-- @file modules\appagebuilder\views\templates\front\products\compare -->
 {if isset($comparator_max_item) && $comparator_max_item}
	<div class="compare">
		<a class="add_to_compare btn" href="{$product.link|escape:'html':'UTF-8'}" data-id-product="{$product.id_product}">
			<i class="icon icon-exchange"></i>
		</a>
	</div>
{/if}


</div></div></div></div>