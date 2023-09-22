<div class="col-1">
	{assign var='images' value=$product.images}
	{if isset($images) && count($images) > 0}
		<!-- thumbnails -->
		<div class="views_block" class="clearfix {if isset($images) && count($images) < 2}hidden{/if}">
		{if isset($images) && count($images) > 3}<span class="view_scroll_spacer">
		<a class="view_scroll_left view_scroll_left_{$product.id_product}" rel="{$product.id_product}" class="hidden" title="{l s='Other views' mod='leocustomajax'}" href="javascript:{ldelim}{rdelim}"><em class="fa fa-chevron-up"></em></a></span>{/if}
		<div class="thumbs_list thumbs_list_{$product.id_product}">
			<ul class="thumbs_list_frame">
				{if isset($images)}
					{foreach from=$images item=image name=thumbnails}
						{assign var=imageIds value="`$product.id_product`-`$image.id_image`"}
						<li id="thumbnail_{$image.id_image}">
							<a href="{$link->getImageLink($product.link_rewrite, $imageIds, 'thickbox_default')|escape:'html'}" data-idproduct="{$product.id_product}" rel="other-views" class="thickbox-ajax-{$product.id_product}{if $smarty.foreach.thumbnails.first} shown{/if}" title="{$image.legend|htmlspecialchars}">
								<img id="thumb_{$image.id_image}" src="{$link->getImageLink($product.link_rewrite, $imageIds, 'medium_default')|escape:'html'}" alt="{$image.legend|htmlspecialchars}" height="{$mediumSize.height}" width="{$mediumSize.width}" rel="{$link->getImageLink($product.link_rewrite, $imageIds, 'home_default')}" class="leo-hover-image"/>
							</a>
						</li>
					{/foreach}
				{/if}
			</ul>
		</div>
	{if isset($images) && count($images) > 3}<a class="view_scroll_right view_scroll_right_{$product.id_product}" rel="{$product.id_product}" title="{l s='Other views' mod='leocustomajax'}" href="javascript:{ldelim}{rdelim}"><em class="fa fa-chevron-down"></em></a>{/if}
	</div>
	{/if}
</div>