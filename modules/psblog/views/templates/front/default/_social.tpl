{*
 *               
 * @license   GNU General Public License version 2
*}

		<div class="social-wrap">
			<div class="social-heading"> <b>{l s='Like This' mod='psblog'}</b> </div>
			{if $config->get('social_code','')}
				{$config->get('social_code','')|escape:'html':'UTF-8'}
			{else}
			<!-- Twitter Button -->
			<div class="itemTwitterButton">
				<a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal" >
					{l s='Twitter' mod='psblog'}
				</a>
				<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
			</div>

			 
			<!-- Facebook Button -->
			<div class="itemFacebookButton">
				<div id="fb-root"></div>
				<script type="text/javascript">
					(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));
				</script>
				<div class="fb-like" data-send="false" data-width="200" data-show-faces="true"></div>
			</div>

			 
			 	<!-- Google +1 Button -->
			<div class="itemGooglePlusOneButton">
				<g:plusone annotation="inline" width="120"></g:plusone>
				<script type="text/javascript">
				  (function() {
				  	window.___gcfg = { lang: 'en' }; // Define button default language here
				    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				    po.src = 'https://apis.google.com/js/plusone.js';
				    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				  })();
				</script>
			</div>
			{/if}
		</div>	 




