{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\front\products\quick_view -->
{if isset($quick_view) && $quick_view}

	<a class="quick-view" href="{$product.link|escape:'html':'UTF-8'}" data-link="{$product.link|escape:'html':'UTF-8'}">
		<span>{l s='Quick view' mod='appagebuilder'}</span>
	</a>
{/if}


