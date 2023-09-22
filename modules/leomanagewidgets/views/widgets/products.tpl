{if !empty($products)}
<div class="carousel slide" id="{$tabname}">
	{if count($products)>$itemsperpage}	 
	 	<a class="carousel-control left" href="#{$tabname}"   data-slide="prev">&lsaquo;</a>
		<a class="carousel-control right" href="#{$tabname}"  data-slide="next">&rsaquo;</a>
	{/if}

	<div class="carousel-inner">
		{$mproducts=array_chunk($products,$itemsperpage)}
		{foreach from=$mproducts item=products name=mypLoop}
			<div class="item {if $smarty.foreach.mypLoop.first}active{/if}">
				<div class="product_list grid">
					{foreach from=$products item=product name=products}
					{if $product@iteration%$columnspage==1&&$columnspage>1}
						<div class="row">
					{/if}
						<div class="ajax_block_product product_block {if $columnspage == 5}col-md-2-4 col-lg-2-4{else}col-md-{$scolumn}{/if} col-xs-6 col-sp-12 {if $smarty.foreach.products.first}first_item{elseif $smarty.foreach.products.last}last_item{/if}">
							<div class="product-container" itemscope itemtype="http://schema.org/Product">
								<div class="left-block">
									<div class="product-image-container">
										<a class="product_img_link"	href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
											<img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} itemprop="image" />
										</a>
										{if isset($quick_view) && $quick_view}
											<a class="quick-view" href="{$product.link|escape:'html':'UTF-8'}" rel="{$product.link|escape:'html':'UTF-8'}">
												<span>{l s='Quick view'}</span>
											</a>
										{/if}
										{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
											<div class="content_price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
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
										{if isset($product.new) && $product.new == 1}
											<span class="new-box">
												<span class="new-label product-label">{l s='New'}</span>
											</span>
										{/if}
										{if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
											<span class="sale-box">
												<span class="sale-label product-label">{l s='Sale!'}</span>
											</span>
										{/if}
									</div>
								</div>
								<div class="right-block">
									<h5 itemprop="name">
										{if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}
										<a class="product-name" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
											{$product.name|truncate:45:'...'|escape:'html':'UTF-8'}
										</a>
									</h5>
									{hook h='displayProductListReviews' product=$product}
									<p class="product-desc" itemprop="description">
										{$product.description_short|strip_tags:'UTF-8'|truncate:360:'...'}
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
									<div class="button-container">
										{if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.minimal_quantity <= 1 && $product.customizable != 2 && !$PS_CATALOG_MODE}
											{if ($product.allow_oosp || $product.quantity > 0)}
												{if isset($static_token)}
													<a class="button ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, "add=1&amp;id_product={$product.id_product|intval}&amp;token={$static_token}", false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product="{$product.id_product|intval}">
														<span>{l s='Add to cart'}</span>
													</a>
												{else}
													<a class="button ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart',false, NULL, 'add=1&amp;id_product={$product.id_product|intval}', false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart'}" data-id-product="{$product.id_product|intval}">
														<span>{l s='Add to cart'}</span>
													</a>
												{/if}						
											{else}
												<span class="button ajax_add_to_cart_button btn btn-default disabled">
													<span>{l s='Add to cart'}</span>
												</span>
											{/if}
										{/if}
										<a itemprop="url" class="button lnk_view btn btn-default" href="{$product.link|escape:'html':'UTF-8'}" title="{l s='View'}">
											<span>{l s='More'}</span>
										</a>
									</div>
									{if isset($product.color_list)}
										<div class="color-list-container">{$product.color_list} </div>
									{/if}
									<div class="product-flags">
										{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
											{if isset($product.online_only) && $product.online_only}
												<span class="online_only">{l s='Online only'}</span>
											{/if}
										{/if}
										{if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
											{elseif isset($product.reduction) && $product.reduction && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
												<span class="discount">{l s='Reduced price!'}</span>
											{/if}
									</div>
									{if (!$PS_CATALOG_MODE && $PS_STOCK_MANAGEMENT && ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
										{if isset($product.available_for_order) && $product.available_for_order && !isset($restricted_country_mode)}
											<span itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="availability">
												{if ($product.allow_oosp || $product.quantity > 0)}
													<span class="available-now">
														<link itemprop="availability" href="http://schema.org/InStock" />{l s='In Stock'}
													</span>
												{elseif (isset($product.quantity_all_versions) && $product.quantity_all_versions > 0)}
													<span class="available-dif">
														<link itemprop="availability" href="http://schema.org/LimitedAvailability" />{l s='Product available with different options'}
													</span>
												{else}
													<span class="out-of-stock">
														<link itemprop="availability" href="http://schema.org/OutOfStock" />{l s='Out of stock'}
													</span>
												{/if}
											</span>
										{/if}
									{/if}
								</div>
								{if $page_name != 'index'}
									<div class="functional-buttons clearfix">
										{hook h='displayProductListFunctionalButtons' product=$product}
										{if isset($comparator_max_item) && $comparator_max_item}
											<div class="compare">
												<a class="add_to_compare" href="{$product.link|escape:'html':'UTF-8'}" data-id-product="{$product.id_product}">{l s='Add to Compare'}</a>
											</div>
										{/if}
									</div>
								{/if}
							</div>
						</div>	
					{if ($product@iteration%$columnspage==0||$smarty.foreach.products.last)&&$columnspage>1}
						</div>
					{/if}	
					{/foreach}
				</div>
		</div>		
	{/foreach}
	</div>
</div>
{/if}