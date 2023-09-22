{*
* 2007-2014 PrestaShop
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
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{if count($categoryProducts) > 0 && $categoryProducts !== false}
<section class="page-product-box blockproductscategory products_block">
	<h4 class="productscategory_h3 page-subheading"><span>{l s='Related Products' mod='productscategory'}</span></h4>
	<div id="productscategory_list" class="clearfix product_list grid">
		{assign var ='tabname' value='blockproductscategory'}
		{assign var='itemsperpage' value='4' }
		{assign var='columnspage' value='4' }
		{$products = $categoryProducts}
		<div class="block_content">
		<div class=" carousel slide" id="{$tabname}">
			{if count($products)>$itemsperpage}	
			<a class="carousel-control left" href="#{$tabname}"   data-slide="prev">&lsaquo;</a>
			<a class="carousel-control right" href="#{$tabname}"  data-slide="next">&rsaquo;</a>
			{/if}
			<div class="carousel-inner">
			{$mproducts=array_chunk($products,$itemsperpage)}
			{foreach from=$mproducts item=products name=mypLoop}
				<div class="item {if $smarty.foreach.mypLoop.first}active{/if}">
					{foreach from=$products item=product name=products}
						{if $product@iteration%$columnspage==1&&$columnspage>1}
						  <div class="row clearfix ">
						{/if}
							<div class="col-sm-4 col-sm-{12/$columnspage} col-xs-12 product_block ajax_block_product">
								{include file="$tpl_dir./product-item.tpl"}
							</div>
						{if ($product@iteration%$columnspage==0||$smarty.foreach.products.last)&&$columnspage>1}
							</div>
						{/if}
					{/foreach}
				</div>
			{/foreach}
			</div>
		</div>
		</div>
	</div>
</section>
{addJsDefL name=min_item}{l s='Please select at least one product' js=1}{/addJsDefL}
{addJsDefL name=max_item}{l s='You cannot add more than %d product(s) to the product comparison' sprintf=$comparator_max_item js=1}{/addJsDefL}
{addJsDef comparator_max_item=$comparator_max_item}
{addJsDef comparedProductsIds=$compared_products}
{/if}