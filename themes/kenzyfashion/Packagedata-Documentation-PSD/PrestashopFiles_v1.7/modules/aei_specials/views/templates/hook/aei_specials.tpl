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

<section class="special-products">
<div class="container">
<div class="special-product-inner">
<div class="h1 ax-product-title"><span>{l s='special products'  mod='aei_specials'}</span></div>
<div class="row">
	<div class="products">
		{assign var='sliderFor' value=1} <!-- Define Number of product for SLIDER -->
		{if $slider == 1 && $no_prod >= $sliderFor}
			<div class="product-carousel">	
			<ul id="aeispecial-slider" class="aeispecial-slider ">
		{else}
			<ul id="aeispecial-grid" class="aeispecial-grid">
		{/if}
		{foreach from=$products item="product"}
			<li class="{if $slider == 1 && $no_prod >= $sliderFor}item{else}product_item  col-sm-6 col-md-4 col-xl-3 {/if} ">				
				 {include file="catalog/_partials/miniatures/aeispecialproduct.tpl" product=$product}
			</li>
		{/foreach}
		</ul>
		{if $slider == 0 && $no_prod >= $sliderFor}
		<a class="all-product-link float-xs-left pull-md-right h4" href="{$allSpecialProductsLink}">
			{l s='View More Products' mod='aei_specials'}
		</a>
		{/if}
		{if $slider == 1 && $no_prod >= $sliderFor}
	  </div>
	  {/if}
	</div>
</div>
		
		{if $slider == 1 && $no_prod >= $sliderFor}
			<div id="aeispecialarrows" class="arrows"></div>
		{/if}
		</div>
</div>
</section>