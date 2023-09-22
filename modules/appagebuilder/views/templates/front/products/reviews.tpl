{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\front\products\reviews -->
{if $page_name  != "product"}
	{capture name='displayProductListReviews'}{hook h='displayProductListReviews' product=$product}{/capture}
	{if $smarty.capture.displayProductListReviews}
		<div class="hook-reviews">
		{hook h='displayProductListReviews' product=$product}
		</div>
	{/if}
{/if}

