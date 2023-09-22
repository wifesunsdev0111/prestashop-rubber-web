{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\front\products\status -->
{if (!$PS_CATALOG_MODE && $PS_STOCK_MANAGEMENT && ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
	{if isset($product.available_for_order) && $product.available_for_order && !isset($restricted_country_mode)}
		<span class="availability">
			{if ($product.allow_oosp || $product.quantity > 0)}
				<span class="{if $product.quantity <= 0 && isset($product.allow_oosp) && !$product.allow_oosp} label-danger{elseif $product.quantity <= 0} label-warning{else} label-success{/if}">
					{if $product.quantity <= 0}{if $product.allow_oosp}{if isset($product.available_later) && $product.available_later}{$product.available_later}{else}{l s='In Stock' mod='appagebuilder'}{/if}{else}{l s='Out of stock' mod='appagebuilder'}{/if}{else}{if isset($product.available_now) && $product.available_now}{$product.available_now}{else}{l s='In Stock' mod='appagebuilder'}{/if}{/if}
				</span>
			{elseif (isset($product.quantity_all_versions) && $product.quantity_all_versions > 0)}
				<span class="label-warning">
					{l s='Product available with different options' mod='appagebuilder'}
				</span>
			{else}
				<span class="label-danger">
					{l s='Out of stock' mod='appagebuilder'}
				</span>
			{/if}
		</span>
	{/if}
{/if}

