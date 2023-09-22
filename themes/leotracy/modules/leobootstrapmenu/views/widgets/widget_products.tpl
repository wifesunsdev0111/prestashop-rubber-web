 {if isset($products) && !empty($products)}
<div class="widget-products">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<div class="menu-title">
		{$widget_heading}
	</div>
	{/if}
	<div class="widget-inner">
		
		{if isset($products) AND $products}
		<div class="product-block">
			{assign var='liHeight' value=140}
			{assign var='nbItemsPerLine' value=3}
			{assign var='nbLi' value=$limit}
			{math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
			{math equation="nbLines*liHeight" nbLines=$nbLines|ceil liHeight=$liHeight assign=ulHeight}
			 

			{$mproducts=array_chunk($products,$limit)}
			 

 
			{foreach from=$products item=product name=homeFeaturedProducts}
				{math equation="(total%perLine)" total=$smarty.foreach.homeFeaturedProducts.total perLine=$nbItemsPerLine assign=totModulo}
				{if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
			 
  
			 <div class="product-container clearfix" itemscope itemtype="http://schema.org/Product">	
					<div class="image ">
							<a class="product_img_link"	href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
								<img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} itemprop="image" />
						</a>
							{if isset($product.new) && $product.new == 1}
								<span class="new-box product-label">
									<span class="new-label">{l s='New' mod='leobootstrapmenu'}</span>
								</span>
							{/if}
					</div>
					<div class="product-meta">
							<h5 itemprop="name" class="name">
								{if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}
								<a class="product-name" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
									{$product.name|truncate:45:'...'|escape:'html':'UTF-8'}
								</a>
							</h5>
							<p class="product-desc" itemprop="description">
								{$product.description_short|strip_tags:'UTF-8'|truncate:60:'...'}
							</p>	
							{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
								<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="content_price">
									{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
										<span itemprop="price" class="price product-price">
											{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
										</span>
										<meta itemprop="priceCurrency" content="{$priceDisplay}" />
										{if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction}
											<span class="old-price product-price">
												{displayWtPrice p=$product.price_without_reduction}
											</span>
											{if $product.specific_prices.reduction_type == 'percentage'}
												<span class="price-percent-reduction">-{$product.specific_prices.reduction * 100}%</span>
											{/if}
										{/if}
									{/if}
				</div>
							{/if}
						</div>
				</div>					
			{/foreach}
						
		 
		</div>
 
		{/if}


	</div>
</div>
{/if}