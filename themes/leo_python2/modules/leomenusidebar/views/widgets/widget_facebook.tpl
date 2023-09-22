 
		<div class="facebook-wrapper" style="width:{$width}" >
		{if isset($application_id)&&$application_id}
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/{$displaylanguage}/all.js#xfbml=1&appId={$application_id}";
			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
		{else}
			<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/{$displaylanguage}/all.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
		{/if}

		<div class="fb-like-box" data-href="{$page_url}" data-colorscheme="{$color}" data-height="{$height}" data-width="{$width}" data-show-faces="{$show_faces}" data-stream="{$show_stream}" data-show-border="{$show_border}" data-header="{$show_header}"></div>
	</div>
 