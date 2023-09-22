{if isset($links)}
<div class="widget-links">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<div class="widget-heading">
		{$widget_heading}
	</div>
	{/if}
	<div class="widget-inner">	
		<div id="tabs{$id}" class="panel-group">
			

			<ul class="nav-links" >
			  {foreach $links as $key => $ac}  
			  <li ><a href="{$ac.link}" >{$ac.text}</a></li>
			  {/foreach}
			</ul>


	</div></div>
</div>
{/if}


