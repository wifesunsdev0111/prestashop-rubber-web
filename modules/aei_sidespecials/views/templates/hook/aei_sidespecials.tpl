{*
* 2007-2018 PrestaShop
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
*  @copyright  2007-2018 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="sidebar-specials block">
<h4 class="block_title hidden-md-down">{l s='Special Products' mod='aei_sidespecials'}</h4>
<h4 class="block_title hidden-lg-up" data-target="#block_specials_toggle" data-toggle="collapse">{l s='Special Products' mod='aei_sidespecials'}
    <span class="float-xs-right">
      <span class="navbar-toggler collapse-icons">
      <i class="material-icons add">&#xE313;</i>
      <i class="material-icons remove">&#xE316;</i>
      </span>
    </span>
  </h4>
 <div class="block_content collapse" id="block_specials_toggle">
  <div class="products clearfix">
   
    {foreach from=$products item="product"}
    <div class="product-item">
    <div class="left-part">
      {block name='product_thumbnail'}
      <a href="{$product.url}" class="thumbnail product-thumbnail">
        <img
          src = "{$product.cover.bySize.cart_default.url}"
          alt = "{$product.cover.legend}"
        >
      </a>
    {/block}
    </div>


<div class="right-part">
  <div class="product-description">
      {block name='product_name'}
        <h1 class="h3 product-title" itemprop="name"><a href="{$product.url}">{$product.name|truncate:30:'...'}</a></h1>
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
		    {block name='product_reviews'}
			<div class="product_reviews">
				{hook h='displayProductListReviews' product=$product}
			</div>
	  	  {/block}
		  
		  
        {/if}
      {/block}
  </div>

  {block name='product_buy'}
			{if !$configuration.is_catalog}
				<div class="product-actions">
					  <form action="{$urls.pages.cart}" method="post" class="add-to-cart-or-refresh">
						<input type="hidden" name="token" value="{$static_token}">
						<input type="hidden" name="id_product" value="{$product.id}" class="product_page_product_id">
						<input type="hidden" name="id_customization" value="0" class="product_customization_id">						
					</form>
				</div>
			{/if}
	{/block}
</div>
    </div>
    {/foreach}
  </div>
  <div class="clearfix">
  <a href="{$allSpecialProductsLink}" class="allproducts">{l s='All Products' mod='aei_sidespecials'}</a>
  </div>
  </div>
</div>
