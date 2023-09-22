{*
 *  Ps Prestashop SliderShow for Prestashop 1.7.x
 *
 * @package   pssliderlayer
 * @version   3.0
 * @author    http://www.prestabrain.com
 * @copyright Copyright (C) October 2017 prestabrain.com <@emai:prestabrain@gmail.com>
 *               
 * @license   GNU General Public License version 2
*}

<!-- Block RSS module-->
<div id="rss_block_left" class="block">
	<h4 class="title_block">{$title|escape:'html':'UTF-8'}</h4>
	<div class="block_content">
		{if $rss_links}
			<ul>
				{foreach from=$rss_links item='rss_link'}
					<li><a href="{$rss_link.url|escape:'html':'UTF-8'}" title="{$rss_link.title|escape:'html':'UTF-8'}">{$rss_link.title|escape:'html':'UTF-8'}</a></li>
				{/foreach}
			</ul>
		{else}
			<p>{l s='No RSS feed added' mod='psblog'}</p>
		{/if}
	</div>
</div>
<!-- /Block RSS module-->
