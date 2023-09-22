<!-- {$smallimage}	 -->
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
						<a class="fancybox" rel="leogallery{$id_leowidgets}" href= "{$link->getImageLink($image.link_rewrite, $image.id_image, $thickimage)|escape:'html':'UTF-8'}">
						<img class="replace-2x img-responsive" src="{$link->getImageLink($image.link_rewrite, $image.id_image, $smallimage)|escape:'html':'UTF-8'}" alt=""/>
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
