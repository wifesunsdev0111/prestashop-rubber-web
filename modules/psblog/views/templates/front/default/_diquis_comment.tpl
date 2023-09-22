{*               
 * @license   GNU General Public License version 2
*}

<div id="disqus_thread"></div>
<script type="text/javascript">
var disqus_shortname = '{$config->get('item_diquis_account','demo4pstheme')|escape:'html':'UTF-8'}';
var disqus_url = '{$blog_link|escape:'html':'UTF-8'}';
(function() {
	var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
	dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
	(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
})();
</script>
<noscript>{l s='Please enable JavaScript to view the.' mod='psblog'} <a href="http://disqus.com/?ref_noscript">{l s='Comments powered by Disqus.' mod='psblog'}.</a></noscript>