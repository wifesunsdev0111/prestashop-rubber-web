 {if isset($video_code)}
<div class="widget-video">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="title_block">
		{$widget_heading}
	</h4>
	{/if}
	<div class="block_content">
		{$video_code}
	</div>
</div>
{/if}