{if isset($accordions)}
<div class="widget-accordion">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<div class="widget-heading">
		{$widget_heading}
	</div>
	{/if}
	<div class="widget-inner">	<div id="accordion{$id}" class="panel-group">
	 	{foreach $accordions as $key => $ac}
		
				<div class="panel panel-default">
				  <div class="panel-heading">
				    <h4 class="panel-title">
				      <a href="#collapseAc{$id}{$key}" data-parent="#accordion{$id}" data-toggle="collapse" class="accordion-toggle collapsed">
				       	{$ac.header}  
				      </a>
				    </h4>
				  </div>
				  <div class="panel-collapse collapse {if $key==0} in {else} out{/if}" id="collapseAc{$id}{$key}"  >
				    <div class="panel-body">
				      {$ac.content}
				    </div>
				  </div>
				</div>
			
	 	{/foreach}
	</div>	</div>
</div>
{/if}


