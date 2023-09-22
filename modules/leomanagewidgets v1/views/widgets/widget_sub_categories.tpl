{if isset($subcategories)}
<div class="widget-subcategories block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="title_block">
		{$widget_heading}
	</h4>
	{/if}
	<div class="block_content">
		<div class="widget-heading">{$title}</div>
		<ul>
			{foreach from=$subcategories item=subcategory}
				<li class="clearfix">
					<a href="{$link->getCategoryLink($subcategory.id_category, $subcategory.link_rewrite)|escape:'htmlall':'UTF-8'}" title="{$subcategory.name|escape:'htmlall':'UTF-8'}" class="img">
						{$subcategory.name|escape:'htmlall':'UTF-8'} 
					</a>
				</li>
			{/foreach}

		</ul>
	</div>
</div>
{/if} 