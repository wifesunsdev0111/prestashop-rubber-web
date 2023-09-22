{*
* 2007-2012 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2012 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}


<div class="block products_block exclusive leomanagerwidgets special-hover">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="widget-heading title_block">
		{$widget_heading}
	</h4>
	{/if}
	<div class="block_content">	
		{$tabname="{$tab}"}
		{if !empty($products)}
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
											<div class="ajax_block_product product_block {if $smarty.foreach.products.first}list col-md-6{else}col-md-2{/if} col-sm-6 col-xs-6 col-sp-12 {if $smarty.foreach.products.last}last_item{/if}">
											<!-- special-product-item.tpl -->
												<div class="product-container {if $product.specific_prices.reduction >= 0.75} red_bg{elseif $product.specific_prices.reduction >= 0.50 } green_bg{elseif $product.specific_prices.reduction >= 0.25 } yellow_bg{/if}" itemscope itemtype="http://schema.org/Product">
													{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
														{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
															{if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction}
																{if $product.specific_prices.reduction_type == 'percentage'}
																	<span class="hot product-label ">{l s='Save'}<br />-{$product.specific_prices.reduction * 100}<sup>%</sup></span>
																{/if}
															{/if}
														{/if}
													{/if}
													<div class="left-block">
														<div class="product-image-container">
															<a class="product_img_link"	href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
																<img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" itemprop="image" />
															</a>			
														</div>
													</div>
													<div class="right-block">
														{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
														<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="content_price price_fix">
															{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
																{if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction}
																	<span class="old-price product-price">
																		{displayWtPrice p=$product.price_without_reduction}
																	</span>
																{/if}
																<span itemprop="price" class="price product-price">
																	{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
																</span>
																<meta itemprop="priceCurrency" content="{$priceDisplay}" />
															{/if}
														</div>
														{/if}
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
														<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="content_price">
															{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
																{if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction}
																	<span class="old-price product-price">
																		{displayWtPrice p=$product.price_without_reduction}
																	</span>
																{/if}
																<span itemprop="price" class="price product-price">
																	{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
																</span>
																<meta itemprop="priceCurrency" content="{$priceDisplay}" />
															{/if}
														</div>
														<div class="leo-more-cdown" rel="{$product.id_product}"></div>
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
															{hook h='displayProductListFunctionalButtons' product=$product}				
															{if isset($quick_view) && $quick_view}
																<a class="quick-view button btn-tooltip" href="{$product.link|escape:'html':'UTF-8'}" rel="{$product.link|escape:'html':'UTF-8'}" data-original-title="{l s='Quick view'}">
																	<i class="icon-exchange"></i>
																</a>
															{/if}
														</div>
														{if isset($product.color_list)}
															<div class="color-list-container">{$product.color_list} </div>
														{/if}
														<span class="btn-line"></span>
													</div>		
												</div>
												<!-- End -->
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
		{/if}
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#{$tabname}').each(function(){
        $(this).carousel({
            pause: 'hover',
            interval: {$interval}
        });
    });
});
</script>
 