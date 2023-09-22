{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}

<div class="col-1">
	{assign var='images' value=$product.images}
	{if isset($images) && count($images) > 0}
		<!-- thumbnails -->
		<div class="views_block" class="clearfix {if isset($images) && count($images) < 2}hidden{/if}">
		{if isset($images) && count($images) > 3}<span class="view_scroll_spacer">
		<a class="view_scroll_left view_scroll_left_{$product.id_product|intval}" rel="{$product.id_product|intval}" class="hidden" title="{l s='Other views' mod='appagebuilder'}" href="javascript:{ldelim}{rdelim}"><em class="fa fa-chevron-up"></em></a></span>{/if}
		<div class="thumbs_list thumbs_list_{$product.id_product|intval}">
			<ul class="thumbs_list_frame">
				{if isset($images)}
					{foreach from=$images item=image name=thumbnails}
						{assign var=imageIds value="`$product.id_product`-`$image.id_image`"}
						<li id="thumbnail_{$image.id_image|intval}">
							<a href="{$link->getImageLink($product.link_rewrite, $imageIds, 'thickbox_default')|escape:'html':'UTF-8'}" data-idproduct="{$product.id_product|intval}" rel="other-views" class="thickbox-ajax-{$product.id_product|intval}{if $smarty.foreach.thumbnails.first} shown{/if}" title="{$image.legend|htmlspecialchars}">
								<img id="thumb_{$image.id_image|intval}" src="{$link->getImageLink($product.link_rewrite, $imageIds, 'medium_default')|escape:'html':'UTF-8'}" alt="{$image.legend|htmlspecialchars}" height="{$mediumSize.height|escape:'html':'UTF-8'}" width="{$mediumSize.width|escape:'html':'UTF-8'}" rel="{$link->getImageLink($product.link_rewrite, $imageIds, 'home_default')}" class="leo-hover-image"/>
							</a>
						</li>
					{/foreach}
				{/if}
			</ul>
		</div>
	{if isset($images) && count($images) > 3}<a class="view_scroll_right view_scroll_right_{$product.id_product|escape:'html':'UTF-8'}" rel="{$product.id_product|escape:'html':'UTF-8'}" title="{l s='Other views' mod='appagebuilder'}" href="javascript:{ldelim}{rdelim}"><em class="fa fa-chevron-down"></em></a>{/if}
	</div>
	{/if}
</div>