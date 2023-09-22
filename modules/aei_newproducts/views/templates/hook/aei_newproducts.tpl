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

<section class="newproduct">
	<!-- <div class="container"> -->
   <div class="products tab-container">
   	<!-- <h1 class="h1 ax-product-title">{l s='Newest Products' d='Shop.Theme.Catalog' mod='aei_newproducts'}</h1> -->
	   <div class="homeproducts-row row">
		  {assign var='sliderFor' value=9} <!-- Define Number of product for SLIDER -->
		  {if $slider == 1 && $no_prod >= $sliderFor}
		  <div class="product-carousel">
		  <ul id="aeinewproduct-slider" class="aeinewproduct-slider">
			 {assign var='newproductcount' value=0}
			 {assign var='newproductltotalcount' value=0}
			 {foreach from=$products item=product name=homenewproductProducts}
			 {$newproductltotalcount = $newproductcount++}
			 {/foreach}
			 {if $newproductcount > 4 && $slider == 1}
			 {foreach from=$products item="product" name=homenewproductProducts}
			 {if $smarty.foreach.homenewproductProducts.index % 2 == 0}
			 <li class="newproductlistitem">
				<ul>
					
			 	{/if}
				   <li class="{if $slider == 1 && $no_prod >= $sliderFor}item{else}product_item col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3{/if}">
					  {include file="catalog/_partials/miniatures/product.tpl" product=$product}
				   </li>
				   {if $smarty.foreach.homenewproductProducts.index % 2 != 0}
				</ul>
			 </li>
			 {/if}
			 {/foreach}
			 {/if}
		  </ul>
		   </div>
		  {else}
		  <ul id="newproduct-grid" class="newproduct-grid">
			 {foreach from=$products item="product"}
			 <li class="{if $slider == 1 && $no_prod >= $sliderFor}item{else}product_item col-xs-12 col-sm-6 col-md-4  col-xl-3{/if}">
				{include file="catalog/_partials/miniatures/product.tpl" product=$product}
			 </li>
			 {/foreach} 
		  </ul>
		  <a class="all-product-link float-xs-left pull-md-right h4" href="{$allNewProductsLink}">
		  {l s='View more products' mod='aei_newproducts'}
		  </a>			
		  {/if}						
	   </div>
		{if $slider == 1 && $no_prod >= $sliderFor}
			<div id="aeinewproduct-arrows" class="arrows">
         	</div>
		{/if}			
	   </div>	
	   <!-- </div> -->
</section>