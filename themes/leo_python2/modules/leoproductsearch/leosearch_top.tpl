{*
 *  Leo Theme for Prestashop 1.6.x
 *
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
*}

<!-- Block search module -->
<div id="leo_search_block_top" class="block exclusive">
	<h4 class="title_block">{l s='Search any products' mod='leoproductsearch'}</h4>
	<form method="get" action="{$link->getPageLink('productsearch', true)|escape:'html':'UTF-8'}" id="leosearchtopbox">
		<input type="hidden" name="fc" value="module" />
		<input type="hidden" name="module" value="leoproductsearch" />
		<input type="hidden" name="controller" value="productsearch" />
		<input type="hidden" name="orderby" value="position" />
		<input type="hidden" name="orderway" value="desc" />
    	{*<label for="search_query_block">{l s='Search any products' mod='leoproductsearch'}</label>*}
		<p class="block_content clearfix">
			<select class="form-control form-select" name="cate" id="cate">
				<option value="">{l s='All Categories' mod='leoproductsearch'}</option>
			     {foreach $cates item = cate key= "key"}
			     <option value="{$cate.id_category|escape:'htmlall':'UTF-8'|stripslashes}" {if isset($selectedCate) && $cate.id_category eq $selectedCate}selected{/if} >{$cate.name}</option>
			     {/foreach}
            </select>
			<input class="search_query form-control grey" type="text" id="leo_search_query_top" name="search_query" value="{$search_query|escape:'htmlall':'UTF-8'|stripslashes}" />
			<button type="submit" id="leo_search_top_button" class="btn btn-default button button-small"><span><i class="fa fa-search"></i></span></button> 
		</p>
	</form>
</div>
<!-- /Block search module -->
