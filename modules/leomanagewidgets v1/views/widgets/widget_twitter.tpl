{if isset($username)}
<div class="widget-twitter block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="title_block">
		{$widget_heading}
	</h4>
	{/if}
	<div class="block_content">
		<div id="leo-twitter{$twidget_id}" class="leo-twitter">
			<a class="twitter-timeline" data-dnt="true" data-theme="{$theme}" data-link-color="{$link_color}" data-chrome="{$chrome}" data-border-color="{$border_color}" lang="{$iso_code}" data-tweet-limit="{$count}" data-show-replies="{$show_replies}" href="https://twitter.com/{$username}" data-widget-id="{$twidget_id}">Tweets by @{$username}</a>
			{$js}
		</div>	
	</div>
</div>
{/if} 
<script type="text/javascript">
{literal}
// Customize twitter feed
var hideTwitterAttempts = 0;
function hideTwitterBoxElements() {
 setTimeout( function() {
  if ( $('[id*=leo-twitter{/literal}{$twidget_id}{literal}]').length ) {
   $('#leo-twitter{/literal}{$twidget_id}{literal} iframe').each( function(){
    var ibody = $(this).contents().find( 'body' );
	var show_scroll =  {/literal}{$show_scrollbar}{literal}; 
	var height =  {/literal}{$height}{literal}+'px'; 
    if ( ibody.find( '.timeline .stream .h-feed li.tweet' ).length ) {
		ibody.find( '.e-entry-title' ).css( 'color', '{/literal}{$text_color}{literal}' );
		ibody.find( '.header .p-nickname' ).css( 'color', '{/literal}{$mail_color}{literal}' );
		ibody.find( '.p-name' ).css( 'color', '{/literal}{$name_color}{literal}' );
		if(show_scroll == 1){
			ibody.find( '.timeline .stream' ).css( 'max-height', height );
			ibody.find( '.timeline .stream' ).css( 'overflow-y', 'auto' );	
			ibody.find( '.timeline .twitter-timeline' ).css( 'height', 'inherit !important' );	
		}
    } else {
     $(this).hide();
    }
   });
  }
  hideTwitterAttempts++;
  if ( hideTwitterAttempts < 3 ) {
   hideTwitterBoxElements();
  }
 }, 1500);
}
// somewhere in your code after html page load
hideTwitterBoxElements();
{/literal}
</script>
