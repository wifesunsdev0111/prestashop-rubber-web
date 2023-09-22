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

<!-- MODULE Block specials -->
<div id="{$myTab}" class="block products_block exclusive">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="title_block">
		{$widget_heading}
	</h4>
	{/if}
	<div class="block_content">	
		{if !empty($leocategories )}
			<ul class="nav nav-tabs">
			  {foreach $leocategories as $category}
				<li><a href="#{$myTab}{$category.id}" data-toggle="tab">{$category.name}</a></li>
			  {/foreach}
			</ul>
			<div class="tab-content">
			 {foreach $leocategories as $category}
				<div class="tab-pane" id="{$myTab}{$category.id}">
					{$products=$category.products}  
					{assign var="tabname" value="{$myTab}_{$category.id}"} 
					{include file='./products.tpl'}
				</div>
			{/foreach}
			</div>
		{/if}
	</div>
</div>
<!-- /MODULE Block specials -->
<script type="text/javascript">

$(document).ready(function() {
    $('#{$myTab} .carousel').each(function(){
        $(this).carousel({
            pause: true,
            interval: false
        });
    });
    
    $("#{$myTab} .nav-tabs li", this).first().addClass("active");
    $("#{$myTab} .tab-content .tab-pane", this).first().addClass("active");
});

</script>
 