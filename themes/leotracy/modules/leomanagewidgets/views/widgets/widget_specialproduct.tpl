{*
* 2007-2012 PrestaShop
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
*  @copyright  2007-2012 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}


<div class="products_block exclusive leomanagerwidgets special-hover block nopadding ">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="widget-heading page-subheading">
		 <span>{$widget_heading}</span>
	</h4>
	{/if}
	<div class="block_content">	
		{$tabname="{$tab}"}
		{if !empty($products)}
			{if !empty($products)}
				<div class="carousel slide" id="{$tabname}">
					{if count($products)>$itemsperpage}	 
					 	<a class="carousel-control left" href="#{$tabname}"   data-slide="prev">&lsaquo;</a>
						<a class="carousel-control right" href="#{$tabname}"  data-slide="next">&rsaquo;</a>
					{/if}

					<div class="carousel-inner">
						{$mproducts=array_chunk($products,$itemsperpage)}
						{foreach from=$mproducts item=products name=mypLoop}
							<div class="item {if $smarty.foreach.mypLoop.first}active{/if}">
								<div class="product_list grid">
									{foreach from=$products item=product name=products}
										{if $product@iteration%$columnspage==1&&$columnspage>1}
											<div class="row">
										{/if}
											<div class="ajax_block_product product_block col-md-2 col-sm-6 col-xs-6 col-sp-12 {if $smarty.foreach.products.last}last_item{/if}">
											
												{include file="$tpl_dir./special-product-item.tpl"}
											</div>		
										{if ($product@iteration%$columnspage==0||$smarty.foreach.products.last)&&$columnspage>1}
											</div>
										{/if}	
									{/foreach}
								</div>
						</div>		
					{/foreach}
					</div>
				</div>
			{/if}
		{/if}
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#{$tabname}').each(function(){
        $(this).carousel({
            pause: 'hover',
            interval: {$interval}
        });
    });
});
</script>
 