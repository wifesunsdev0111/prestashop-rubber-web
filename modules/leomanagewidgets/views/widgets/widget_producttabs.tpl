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
			<ul id="productTabs" class="nav nav-tabs">
			  {if $special}	
              <li><a href="#{$myTab}special" data-toggle="tab">{l s='Special' mod='leomanagewidgets'}</a></li>
			  {/if}
               {if $newproducts}	
              <li><a href="#{$myTab}newproducts" data-toggle="tab"><span></span>{l s='New Arrivals' mod='leomanagewidgets'}</a></li>
			  {/if}
			  {if $bestseller}	
              <li><a href="#{$myTab}bestseller" data-toggle="tab"><span></span>{l s='Best Seller' mod='leomanagewidgets'}</a></li>
			  {/if}
			  {if $featured}	
              <li><a href="#{$myTab}featured" data-toggle="tab"><span></span>{l s='Featured Products' mod='leomanagewidgets'}</a></li>
			  {/if}
            </ul>
			
            <div id="product_tab_content"><div class="product_tab_content tab-content">
			   {if $special}	
					<div class="tab-pane" id="{$myTab}special">
					{$products=$special}{$tabname="{$myTab}-special"}
					{include file='./products.tpl'}
	              </div>
			   {/if}
			  {if $newproducts}		  
              <div class="tab-pane" id="{$myTab}newproducts">
					{$products=$newproducts} {$tabname="{$myTab}-newproducts"}
					{include file='./products.tpl'}
              </div>
			 {/if}	
			 {if $bestseller}		  
              <div class="tab-pane" id="{$myTab}bestseller">
					{$products=$bestseller} {$tabname="{$myTab}-bestseller"}
					{include file='./products.tpl'}
              </div>   
			 {/if}	
			 {if $featured}		  
              <div class="tab-pane" id="{$myTab}featured">
					{$products=$featured} {$tabname="{$myTab}-featured"}
					{include file='./products.tpl'}
              </div>   
			  {/if}	
			 
			</div></div>
        
		
	</div>
</div>
<!-- /MODULE Block specials -->
<script>
$(document).ready(function() {
    $('#{$myTab} .carousel').each(function(){
        $(this).carousel({
            pause: 'hover',
            interval: {$interval}
        });
    });
 
	$("#{$myTab} .nav-tabs li", this).first().addClass("active");
	$("#{$myTab} .tab-content .tab-pane", this).first().addClass("active");
 
});
</script>
 