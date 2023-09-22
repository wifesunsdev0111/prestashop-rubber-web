{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ProductCarousel -->
<div class="carousel slide" id="{$carouselName}">
	{$apLiveEdit}
    {if count($products)>$itemsperpage}
        <a class="carousel-control left" href="#{$carouselName}"   data-slide="prev">&lsaquo;</a>
        <a class="carousel-control right" href="#{$carouselName}"  data-slide="next">&rsaquo;</a>
    {/if}
    <div class="carousel-inner">
        {$mproducts=array_chunk($products,$itemsperpage)}
        {foreach from=$mproducts item=products name=mypLoop}
            <div class="item {if $smarty.foreach.mypLoop.first}active{/if}">
                <ul class="product_list row products-special grid {if isset($productClassWidget)}{$productClassWidget}{/if}">
                {foreach from=$products item=product name=products}
                    <li class="{if ($smarty.foreach.products.iteration -1 ) is div by 5}product-default-li{/if} ajax_block_product product_block {$scolumn} {if $smarty.foreach.products.first}first_item{elseif $smarty.foreach.products.last}last_item{/if}">
						{if ($smarty.foreach.products.iteration -1 ) is div by 5}
							{include file='./ProductItem.tpl'}
						{else}
							{if isset($profile) && $profile}	
								{assign var="tplPath" value="$tpl_dir./profiles/$profile.tpl"}
								{include file="$tplPath"}
							{else}
								{include file='./ProductItem.tpl'}
							{/if}
						{/if}
                    </li>
                {/foreach}
                </ul>
            </div>		
        {/foreach}
    </div>
	{$apLiveEditEnd}
{addJsDefL name=min_item}{l s='Please select at least one product' mod='appagebuilder' js=1}{/addJsDefL}
{addJsDefL name=max_item}{l s='You cannot add more than %d product(s) to the product comparison' mod='appagebuilder' sprintf=$comparator_max_item js=1}{/addJsDefL}
{addJsDef comparator_max_item=$comparator_max_item}
{addJsDef comparedProductsIds=$compared_products}
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#{$carouselName}').each(function(){
        $(this).carousel({
            pause: 'hover',
            interval: {$formAtts.interval}
        });
    });
});
</script>