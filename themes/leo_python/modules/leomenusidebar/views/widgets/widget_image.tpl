{if isset($images)}
<div class="widget-images">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<div class="widget-heading">
		{$widget_heading}
	</div>
	{/if}
	<div class="widget-inner clearfix">
		<div class="images-list clearfix">	
			<div class="row">
				{foreach from=$images item=image name=images}
				<div class="image-item col-md-{$columns} col-xs-12">
					<img class="replace-2x img-responsive" src="{$image}"/>
				</div>
				{/foreach}
			</div>
		</div>
	</div>
</div>
{/if} 