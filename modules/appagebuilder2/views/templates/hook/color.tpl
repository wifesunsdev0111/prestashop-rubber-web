{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}

{if $product}
	{if $colors}
		{if isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction}
			{if $product.specific_prices.reduction_type == 'percentage'}
					{math assign='sale' equation='x*100' x=$product.specific_prices.reduction}
			{else}
					{math assign='sale' equation='(x/y)*100' x=$product.specific_prices.reduction y=$product.price_without_reduction}
			{/if}
			{foreach from=$colors item=color key=k}	
				{if $k >= $sale }
					<div>
						{$color}{* HTML form , no escape necessary *}
					</div>
					{break}
				{/if}
			{/foreach}
		{/if}
	{/if}		
{/if}