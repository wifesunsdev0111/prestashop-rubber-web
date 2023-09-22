{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\front\products\image_container -->
<div class="product-image-container image">
	<div class="leo-more-info hidden-xs" data-idproduct="{$product.id_product}"></div>
	<a class="product_img_link"	href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
		<img class="replace-2x img-responsive" src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} itemprop="image" />
		<span class="product-additional" data-idproduct="{$product.id_product}"></span>
	</a>
	{if isset($product.new) && $product.new == 1}
		<a class="new-box" href="{$product.link|escape:'html':'UTF-8'}">
			<span class="label-new product-label label-info label">{l s='New' mod='appagebuilder'}</span>
		</a>
	{/if}
	{if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
		<a class="sale-box" href="{$product.link|escape:'html':'UTF-8'}">
			<span class="label-sale product-label label-warning label">{l s='Sale!' mod='appagebuilder'}</span>
		</a>
	{/if}
</div>


