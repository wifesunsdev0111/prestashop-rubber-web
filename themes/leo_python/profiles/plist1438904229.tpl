<div class="product-container product-block" itemscope itemtype="http://schema.org/Product"><div class="left-block">
<!-- @file modules\appagebuilder\views\templates\front\products\image_container -->
<div class="product-image-container image">
	<div class="leo-more-info hidden-xs" data-idproduct="{$product.id_product}"></div>
		<a class="product_img_link"	href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
			<img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} itemprop="image" />
			<span class="product-additional" data-idproduct="{$product.id_product}"></span>
		</a>
		{if isset($product.new) && $product.new == 1}
			<a class="new-box" href="{$product.link|escape:'html':'UTF-8'}">
				<span class="label-new label">{l s='New'}</span>
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
				<span class="label-sale label">{l s='Sale!'}</span>
			</a>
		{/if}
</div>


</div><div class="right-block"><div class="product-meta">
<!-- @file modules\appagebuilder\views\templates\front\products\name -->
<h5 itemprop="name" class="name">
	{if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}
	<a class="product-name" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
		{$product.name|truncate:45:'...'|escape:'html':'UTF-8'}
	</a>
</h5>



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
{if $page_name  != "product"}
{hook h='displayProductListReviews' product=$product}
{/if}


<!-- @file modules\appagebuilder\views\templates\front\products\description -->
<p class="product-desc" itemprop="description">
	{$product.description_short|strip_tags:'UTF-8'|truncate:360:'...'}
</p>


<div class="functional-buttons clearfix">
<!-- @file modules\appagebuilder\views\templates\front\products\add_to_cart -->
{if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.minimal_quantity <= 1 && $product.customizable != 2 && !$PS_CATALOG_MODE}
	{if ($product.allow_oosp || $product.quantity > 0)}
		{if isset($static_token)}
			<a class="button ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, "add=1&amp;id_product={$product.id_product|intval}&amp;token={$static_token}", false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product="{$product.id_product|intval}">
				<i class="fa fa-shopping-cart"></i><span>{l s='Add to cart'}</span>
			</a>
		{else}
			<a class="button ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, 'add=1&amp;id_product={$product.id_product|intval}', false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product="{$product.id_product|intval}">
				<i class="fa fa-shopping-cart"></i><span>{l s='Add to cart'}</span>
			</a>
		{/if}
	{else}
		<span class="button ajax_add_to_cart_button btn btn-default disabled">
			<i class="fa fa-shopping-cart"></i><span>{l s='Add to cart'}</span>
		</span>
	{/if}
{/if}



<!-- @file modules\appagebuilder\views\templates\front\products\wishlist -->

{hook h='displayProductListFunctionalButtons' product=$product}


<!-- @file modules\appagebuilder\views\templates\front\products\compare -->
{if isset($comparator_max_item) && $comparator_max_item}

		<a class="add_to_compare compare" href="{$product.link|escape:'html':'UTF-8'}" data-id-product="{$product.id_product}"><i class="fa fa-refresh"></i><span>{l s='Add Compare'}</span></a>

{/if}



<!-- @file modules\appagebuilder\views\templates\front\products\quick_view -->
{if isset($quick_view) && $quick_view}
	<a class="quick-view" href="{$product.link|escape:'html':'UTF-8'}" data-link="{$product.link|escape:'html':'UTF-8'}">
		<i class="fa fa-eye"></i>
	</a>
{/if}


</div></div></div></div>