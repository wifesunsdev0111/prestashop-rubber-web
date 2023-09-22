{**
 * 2007-2016 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
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
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2016 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
 {block name='product_miniature_item'}
<div class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
  <div class="thumbnail-container">
   <div class="product-image-block">
    {block name='product_thumbnail'}
      <a href="{$product.url}" class="thumbnail product-thumbnail">
            <span class="main_image">
            <img
            src = "{$product.cover.bySize.home_default.url}"
            alt = "{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
            data-full-size-image-url = "{$product.cover.large.url}"
            >
            </span>
          {if isset($product.images[1])}
            <span class="next_image">
            <img 
            src = "{$product.images[1].bySize.home_default.url}"
            alt = "{if !empty($product.cover.legend)}{$product.cover.legend}{else}{$product.name|truncate:30:'...'}{/if}"
            data-full-size-image-url = "{$product.images[1].bySize.home_default.url}" 
            /> 
            </span>
          {/if}
          </a>
	  <div class="mask"></div>
    {/block}
		{block name='product_flags'}
		  <ul class="product-flags">
			{foreach from=$product.flags item=flag}
			  <li class="product-flag {$flag.type}">{$flag.label}</li>
			{/foreach}
		  </ul>
		{/block}
		
		{block name='product_buy'}
		{if !$configuration.is_catalog}				
			 <div class="product-add-to-cart">
            <form action="{$urls.pages.cart}" method="post" class="add-to-cart-or-refresh">
              <input type="hidden" name="token" value="{$static_token}">
              <input type="hidden" name="id_product" value="{$product.id}" class="product_page_product_id">
              <input type="hidden" name="id_customization" value="0" class="product_customization_id">
              <button class="btn btn-primary add-to-cart" data-button-action="add-to-cart" type="submit" {if $product.availability == 'unavailable'}disabled{/if} title="{l s='Add to cart' d='Shop.Theme.Actions'}">           
              {l s='Add to cart' d='Shop.Theme.Actions'}
              <!-- <span class="addtocart-tooltip">{l s='Add to cart' d='Shop.Theme.Actions'}</span> -->
              </button>
            </form> 
            {block name='quick_view'}
              <a class="quick-view" href="#" data-link-action="quickview">
                {l s='Quick view' d='Shop.Theme.Actions'}
                <span class="quickview-tooltip">{l s='Quick View' d='Shop.Theme.Actions'}</span>
              </a>
            {/block}
          </div>

		{/if}
	{/block}
	</div>
	<!--<div class="product-counter">
	{hook h='PSProductCountdown' id_product=$product.id_product}
	</div>-->
	
	<div class="product-description">
		{block name='product_reviews'}
    <div class="product_reviews">
        {hook h='displayProductListReviews' product=$product}
    </div>
      {/block}  
      {block name='product_name'}
        <span class="h3 product-title" itemprop="name"><a href="{$product.url}" title="{$product.name}">{$product.name|truncate:25:''}</a></span>
      {/block}
	  
	  {block name='product_price_and_shipping'}
        {if $product.show_price}
          <div class="product-price-and-shipping">
		  	<span itemprop="price" class="price">{$product.price}</span>
            {if $product.has_discount}
              {hook h='displayProductPriceBlock' product=$product type="old_price"}

              <span class="regular-price">{$product.regular_price}</span>
              {if $product.discount_type === 'percentage'}
                <span class="discount-percentage">{$product.discount_percentage}</span>
              {/if}
            {/if}

            {hook h='displayProductPriceBlock' product=$product type="before_price"}           
            {hook h='displayProductPriceBlock' product=$product type='unit_price'}
            {hook h='displayProductPriceBlock' product=$product type='weight'}
          </div>
        {/if}
      {/block}
	  
	  
	
		<!--<div class="highlighted-informations{if !$product.main_variants} no-variants{/if} hidden-sm-down">
	
		  {block name='product_variants'}
			{if $product.main_variants}
			  {include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
			{/if}
		  {/block}
		</div>-->
		
	</div>
 </div> 
 
	
	
</div>
{/block}