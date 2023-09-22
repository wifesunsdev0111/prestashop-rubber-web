{if isset($images)}
<div class="widget-images block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="title_block">
		{$widget_heading}
	</h4>
	{/if}
	<div class="block_content clearfix">
			<div class="images-list clearfix">	
			<div class="row">
		 	{foreach from=$images item=image name=images}
				<div class="image-item {if $columns == 5} col-md-2-4 {else} col-md-{12/$columns}{/if} col-xs-12">
					<a class="fancybox" href= "{$image}">
						<img class="replace-2x img-responsive"  width='{$width}' src="{$image}" alt=""/>
				</a>
				</div>
				{/foreach}
			</div>
		</div>
	</div>
</div>
{/if} 
<script type="text/javascript">
	$(document).ready(function() {
	$(".fancybox").fancybox({
		openEffect	: 'none',
		closeEffect	: 'none'
	});
});
</script>