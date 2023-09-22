 {if isset($raw_html)}
<div class="widget-raw-html block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="title_block">
		{$widget_heading}
	</h4>
	{/if}
	<div class="block_content">
		{$raw_html}
	</div>
</div>
{/if}