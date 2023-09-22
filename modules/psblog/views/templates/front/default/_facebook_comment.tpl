{*
 *               
 * @license   GNU General Public License version 2
*}

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {   
  	return;
  }
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId={$config->get('item_facebook_appid')|escape:'html':'UTF-8'}";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-comments" data-href="{$blog_link|escape:'html':'UTF-8'}" 
		data-num-posts="{$config->get("item_limit_comments",10)|escape:'html':'UTF-8'}" data-width="{$config->get('facebook_width',600)|escape:'html':'UTF-8'}">
</div>