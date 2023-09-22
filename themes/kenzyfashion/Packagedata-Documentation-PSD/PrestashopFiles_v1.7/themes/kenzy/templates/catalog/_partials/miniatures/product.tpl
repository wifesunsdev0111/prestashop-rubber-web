{**
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
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
 * @copyright 2007-2018 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
{block name='product_miniature_item'}
 
  <article class="product-miniature js-product-miniature" data-id-product="{$product.id_product}" data-id-product-attribute="{$product.id_product_attribute}" itemscope itemtype="http://schema.org/Product">
    <div class="thumbnail-container">
      <div class="product-image-block">
      {block name='product_thumbnail'}
        {if $product.cover}
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
        {else}
          <a href="{$product.url}" class="thumbnail product-thumbnail">
            <img
              src = "{$urls.no_picture_image.bySize.home_default.url}"
            >
          </a>
        {/if}
       
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

      <div class="product-description">
        {block name='product_reviews'}
          {hook h='displayProductListReviews' product=$product}
        {/block}
        {block name='product_name'}
          {if $page.page_name == 'index'}
            <h3 class="h3 product-title" itemprop="name"><a href="{$product.url}">{$product.name|truncate:25:'...'}</a></h3>
          {else}
            <h2 class="h3 product-title" itemprop="name"><a href="{$product.url}">{$product.name|truncate:25:'...'}</a></h2>
          {/if}
        {/block}

        {block name='product_price_and_shipping'}
          {if $product.show_price}
            <div class="product-price-and-shipping">
              <span itemprop="price" class="price">{$product.price}</span>
              {if $product.has_discount}
                {hook h='displayProductPriceBlock' product=$product type="old_price"}

                <span class="sr-only">{l s='Regular price' d='Shop.Theme.Catalog'}</span>
                <span class="regular-price">{$product.regular_price}</span>
                
              {/if}

              {hook h='displayProductPriceBlock' product=$product type="before_price"}

              <span class="sr-only">{l s='Price' d='Shop.Theme.Catalog'}</span>
              

              {hook h='displayProductPriceBlock' product=$product type='unit_price'}

              {hook h='displayProductPriceBlock' product=$product type='weight'}
               {if $product.discount_type === 'percentage'}
                  <span class="discount-percentage discount-product">{$product.discount_percentage}</span>
                {elseif $product.discount_type === 'amount'}
                  <span class="discount-amount discount-product">{$product.discount_amount_to_display}</span>
                {/if}
            </div>
          {/if}
        {/block}
        {block name='product_description_short'}
        <div class="product-detail" itemprop="description">{$product.description_short nofilter}</div>
        {/block}
        
        <div class="highlighted-informations{if !$product.main_variants} no-variants{/if} hidden-sm-down">
        
        {block name='product_variants'}
          {if $product.main_variants}
            {include file='catalog/_partials/variant-links.tpl' variants=$product.main_variants}
          {/if}
        {/block}
      </div>
        

      </div>

    </div>
  </article>
{/block}
