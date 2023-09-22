{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\front\products\description -->
<p class="product-desc" itemprop="description">
	{$product.description_short|strip_tags:'UTF-8'|truncate:360:'...'}
</p>


