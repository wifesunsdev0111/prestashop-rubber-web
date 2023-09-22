{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
{assign var="scolum_special_wrapper" value="col-lg-6 col-md-6 col-sm-12 col-sm-12"}
{assign var="scolum_special" value="col-lg-12 col-md-12 col-sm-12 col-sm-12"}
{assign var="tplPath_special" value="$tpl_dir./profiles/plist1429768372.tpl"}
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
                <ul class="product_list grid row {if isset($productClassWidget)}{$productClassWidget}{/if}">
                {assign var="count_item" value="0"}
                {foreach from=$products item=product name=products}

                    <li class="ajax_block_product product_block {if $product@iteration<3}{$scolumn}{else if $product@iteration==3}{$scolum_special_wrapper}{else}{$scolum_special}{/if} {if $smarty.foreach.products.first}first_item{elseif $smarty.foreach.products.last}last_item{/if}">
                        {if $product@iteration == 3}
                        <ul>
                        <li class="ajax_block_product product_block {$scolum_special}">
                        {/if}
                        {if $product@iteration >= 3}
                            {include file="$tplPath_special"}
                        {else}
                            {if isset($profile) && $profile}
                                {assign var="tplPath" value="$tpl_dir./profiles/$profile.tpl"}
                                {include file="$tplPath"}
                            {else}
                                {include file='./ProductItem.tpl'}
                            {/if}
                        {/if}
                        {if $product@iteration == 3}
                        </li>
                        {/if}
                        {if $product@iteration == 5}
                            </ul></li>
                        {/if}
                    {if $product@iteration != 3}
                    </li>
                    {/if}
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