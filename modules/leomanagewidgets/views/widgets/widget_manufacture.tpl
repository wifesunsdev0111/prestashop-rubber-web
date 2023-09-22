 <div class="widget-manufacture block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="title_block">
		{$widget_heading}
	</h4>
	{/if}
	<div class="block_content">
		{if $manufacturers}
		<div class="manu-logo">
			{foreach from=$manufacturers item=manufacturer name=manufacturers}
			<a  href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'htmlall':'UTF-8'}" title="{l s='view products' mod='leomanagewidgets'}">
				<img src="{$manufacturer.image|escape:'htmlall':'UTF-8'}" alt=""> </a>
			{/foreach}

		</div>
		{else}
   			<p class="alert alert-info">{l s='No image logo at this time.'}</p>
		{/if}
	</div>
</div>
 