 {if isset($raw_html)}
<div class="widget-raw-html">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<div class="widget-heading">
		{$widget_heading}
	</div>
	{/if}
	<div class="widget-inner">
		{$raw_html}
	</div>
</div>
{/if}