{*
 * @license   GNU General Public License version 2
*}

{if $warning}
 <div class="alert alert-danger">{$warning|escape:'html':'UTF-8'}</div>
 {/if}
 {if $widget_selected}
	{$form}{* HTML form , no escape necessary *}
	 <script type="text/javascript">
		$('#widget_type').change( function(){
			location.href = '{html_entity_decode($fb_widget_action|escape:'html':'UTF-8')}&wtype='+$(this).val();
		} );
	</script>	
 {else}
	<div class="widgets">
		{$i=0} <div class="row">
		{foreach $types as $widget => $text}
			
	 
			<div class="col-md-4 col-sm-4">
				<div class="widget-item">
					<h4><a href="{html_entity_decode($fb_widget_action|escape:'html':'UTF-8')}&wtype={$widget|escape:'html':'UTF-8'}">{$text.label|escape:'html':'UTF-8'}</a></h4>
					<p><i>{$text.explain}{* HTML form , no escape necessary *}</i></p>
				</div>
			</div>	

		{/foreach} <div class="row">
	</div>
{/if}