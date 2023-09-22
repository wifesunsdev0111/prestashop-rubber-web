{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApProductList -->
{if !isset($apAjax)}
    <div class="block {$formAtts.class|escape:'html':'UTF-8'}">
		{($apLiveEdit)?$apLiveEdit:''}{* HTML form , no escape necessary *}
		<input type="hidden" class="apconfig" value='{$apPConfig}{* HTML form , no escape necessary *}'/>
		{if isset($formAtts.title) && !empty($formAtts.title)}
		<h4 class="title_block">
			{$formAtts.title|escape:'html':'UTF-8'}
		</h4>
		{/if}
{/if}
{if isset($products) && $products}
    {if !isset($apAjax)}
    <!-- Products list -->
    <ul{if isset($id) && $id} id="{$id|intval}"{/if} class="product_list grid row{if isset($class) && $class} {$class|escape:'html':'UTF-8'}{/if} {if isset($productClassWidget)}{$productClassWidget|escape:'html':'UTF-8'}{/if}">
    {/if}
        {foreach from=$products item=product name=products}
            <li class="ajax_block_product product_block 
                {if $scolumn == 5} col-md-2-4 {else} col-md-{12/$scolumn|intval}{/if} 
                col-xs-12 {if $smarty.foreach.products.first}first_item{elseif $smarty.foreach.products.last}last_item{/if}">
                {if isset($profile) && $profile}
                    {assign var="tplPath" value="$tpl_dir./profiles/$profile.tpl"}
                    {include file="$tplPath"}
                {else}
                    {include file='./ProductItem.tpl'}
                {/if}
            </li>
        {/foreach}
    {if !isset($apAjax)}
    </ul>
    <!-- End Products list -->
    {if isset($formAtts.use_showmore) && $formAtts.use_showmore && $products|@count >= $formAtts.nb_products}
    <div class="box-show-more open">
        <a href="javascript:void(0)" class="btn btn-default btn-show-more" data-page="{$p|intval}" data-loading-text="{l s='Loading...' mod='appagebuilder'}">
            <span>{l s='Show more' mod='appagebuilder'}</span></a>
    </div>
    {/if}
    {addJsDefL name=min_item}{l s='Please select at least one product' js=1 mod='appagebuilder'}{/addJsDefL}
    {addJsDefL name=max_item}{l s='You cannot add more than %d product(s) to the product comparison' mod='appagebuilder' sprintf=$comparator_max_item js=1}{/addJsDefL}
    {addJsDef comparator_max_item=$comparator_max_item}
    {addJsDef comparedProductsIds=$compared_products}
    </div>
	{($apLiveEditEnd)?$apLiveEditEnd:''}{* HTML form , no escape necessary *}
    {/if}
	{else}
</div>
{/if}
