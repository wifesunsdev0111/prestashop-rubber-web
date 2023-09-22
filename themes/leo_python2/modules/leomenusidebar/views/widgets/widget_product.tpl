{if isset($product)}
<div class="widget-product">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<div class="widget-heading">
		{$widget_heading}
	</div>
	{/if}
	<div class="widget-inner">
		{include file="$tpl_dir./sub/product/sidebar.tpl" products=$product mod='leomenusidebar'}     
		
	</div>
</div>
{/if} 