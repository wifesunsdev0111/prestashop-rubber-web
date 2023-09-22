{*
 *               
 * @license   GNU General Public License version 2
*}

<article class="blog-item clearfix">
	{if $blog.image && $config->get('listing_show_image',1)}
		<div class="blog-image col-xs-12">
			<img src="{$blog.preview_url|escape:'html':'UTF-8'}" title="{$blog.title|escape:'html':'UTF-8'}" alt="" class="img-fluid" />
		</div>
	{/if}
	<div class="col-xs-12 blog-content-wrap">
		{if $config->get('listing_show_title','1')}
		<h4 class="title media-heading"><a href="{$blog.link|escape:'html':'UTF-8'}" title="{$blog.title|escape:'html':'UTF-8'}">{$blog.title|escape:'html':'UTF-8'}</a></h4>
		{/if}
		<div class="blog-meta">
			{if $config->get('listing_show_author','1')&&!empty($blog.author)}
			<span class="blog-author">
				<span class="fa fa-user"> {l s='' mod='psblog'}</span> 
				<a href="{$blog.author_link|escape:'html':'UTF-8'}" title="{$blog.author|escape:'html':'UTF-8'}">{$blog.author|escape:'html':'UTF-8'}</a> 
			</span>
			{/if}
			
			{if $config->get('listing_show_category','1')}
			<span class="blog-cat"> 
				<span class="fa fa-list"> {l s='In' mod='psblog'}:</span> 
				<a href="{$blog.category_link|escape:'html':'UTF-8'}" title="{$blog.category_title|escape:'html':'UTF-8'}">{$blog.category_title|escape:'html':'UTF-8'}</a>
			</span>
			{/if}
			
			{if $config->get('listing_show_created','1')}
			<span class="blog-created">
				<span class="fa fa-calendar"> {l s='On' mod='psblog'}: </span> 
				<time class="date" datetime="{strtotime($blog.date_add)|date_format:"%Y"|escape:'html':'UTF-8'}">
					{l s=strtotime($blog.date_add)|date_format:"%A"|escape:'html':'UTF-8' mod='psblog'},	<!-- day of week -->
					{l s=strtotime($blog.date_add)|date_format:"%B"|escape:'html':'UTF-8' mod='psblog'}		<!-- month-->
					{l s=strtotime($blog.date_add)|date_format:"%e"|escape:'html':'UTF-8' mod='psblog'},	<!-- day of month -->
					{l s=strtotime($blog.date_add)|date_format:"%Y"|escape:'html':'UTF-8' mod='psblog'}		<!-- year -->
				</time>
			</span>
			{/if}
			
			{if isset($blog.comment_count)&&$config->get('listing_show_counter','1')}	
			<span class="blog-ctncomment">
				<span class="fa fa-comments-o"> {l s='Comment' mod='psblog'}:</span> 
				{$blog.comment_count|intval}
			</span>
			{/if}

			{if $config->get('listing_show_hit','1')}	
			<span class="blog-hit">
				<span class="fa fa-heart"> {l s='Hit' mod='psblog'}:</span> 
				{$blog.hits|intval}
			</span>
			{/if}
		</div>


		<div class="blog-shortinfo">
			{if $config->get('listing_show_description','1')}
			{$blog.description|strip_tags:'UTF-8'|truncate:160:'...' nofilter}{* HTML form , no escape necessary *}
			{/if}
			{if $config->get('listing_show_readmore',1)}
			<p>
				<a href="{$blog.link|escape:'html':'UTF-8'}" title="{$blog.title|escape:'html':'UTF-8'}" class="more btn btn-default">{l s='Read more' mod='psblog'}</a>
			</p>
			{/if}
		</div>
	</div>
</article>
	
<!---
	Translation Day of Week - NOT REMOVE
	{l s='Sunday' mod='psblog'}
	{l s='Monday' mod='psblog'}
	{l s='Tuesday' mod='psblog'}
	{l s='Wednesday' mod='psblog'}
	{l s='Thursday' mod='psblog'}
	{l s='Friday' mod='psblog'}
	{l s='Saturday' mod='psblog'}
-->
<!---
	Translation Month - NOT REMOVE
		{l s='January' mod='psblog'}
		{l s='February' mod='psblog'}
		{l s='March' mod='psblog'}
		{l s='April' mod='psblog'}
		{l s='May' mod='psblog'}
		{l s='June' mod='psblog'}
		{l s='July' mod='psblog'}
		{l s='August' mod='psblog'}
		{l s='September' mod='psblog'}
		{l s='October' mod='psblog'}
		{l s='November' mod='psblog'}
		{l s='December' mod='psblog'}
-->