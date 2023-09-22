{*
 *               
 * @license   GNU General Public License version 2
*}

{extends file=$layout}

{block name='content'}

	{if isset($error)}
			<div id="blogpage">
				<div class="blog-detail">
					<div class="alert alert-warning">{l s='Sorry, We are updating data, please come back later!!!!' mod='psblog'}</div>
				</div>
			</div>
		{else}	
		<div id="blogpage">
			<article class="blog-detail">
				{if $is_active}
				<h1 class="blog-title">{$blog->meta_title|escape:'html':'UTF-8'}</h1>
				

				{if $blog->preview_url && $config->get('item_show_image','1')}
					<div class="blog-image">
						<img src="{$blog->preview_url|escape:'html':'UTF-8'}" alt="{$blog->meta_title|escape:'html':'UTF-8'}" class="img-fluid" />
					</div>
				{/if}
				<div class="blog-meta">
					{if $config->get('item_show_author','1')}
					<span class="blog-author">
						<span class="fa fa-user"> {l s='' mod='psblog'} </span>
						<a href="{$blog->author_link|escape:'html':'UTF-8'}" title="{$blog->author|escape:'html':'UTF-8'}">{$blog->author|escape:'html':'UTF-8'}</a>
					</span>
					{/if}

					{if $config->get('item_show_category','1')}
					<span class="blog-cat"> 
						<i class="fa fa-list"></i>{l s='In' mod='psblog'}: 
						<a href="{$blog->category_link|escape:'html':'UTF-8'}" title="{$blog->category_title|escape:'html':'UTF-8'}">{$blog->category_title|escape:'html':'UTF-8'}</a>
					</span>
					{/if}

					{if $config->get('item_show_created','1')}
					<span class="blog-created">
						<i class="fa fa-calendar"></i> {l s='On' mod='psblog'}:
						<time class="date" datetime="{strtotime($blog->date_add)|date_format:"%Y"|escape:'html':'UTF-8'}">
							{l s=strtotime($blog->date_add)|date_format:"%A"|escape:'html':'UTF-8' mod='psblog'},	<!-- day of week -->
							{l s=strtotime($blog->date_add)|date_format:"%B"|escape:'html':'UTF-8' mod='psblog'}		<!-- month-->
							{l s=strtotime($blog->date_add)|date_format:"%e"|escape:'html':'UTF-8' mod='psblog'},	<!-- day of month -->
							{l s=strtotime($blog->date_add)|date_format:"%Y"|escape:'html':'UTF-8' mod='psblog'}		<!-- year -->
						</time>
					</span>
					{/if}
					
					{if isset($blog_count_comment)&&$config->get('item_show_counter','1')}
					<span class="blog-ctncomment">
						<i class="fa fa-comments-o"></i>{l s='Comment' mod='psblog'}: 
						{$blog_count_comment|intval}
					</span>
					{/if}
					{if isset($blog->hits)&&$config->get('item_show_hit','1')}
					<span class="blog-hit">
						<i class="fa fa-heart"></i>{l s='Hit' mod='psblog'}:
						{$blog->hits|intval}
					</span>
					{/if}
				</div>
				<div class="blog-description">
					{if $config->get('item_show_description',1)}
						{$blog->description nofilter}{* HTML form , no escape necessary *}
					{/if}
					{$blog->content nofilter}{* HTML form , no escape necessary *}
				</div>
				
				

				{if trim($blog->video_code)}
				<div class="blog-video-code">
					<div class="inner ">
						{$blog->video_code nofilter}{* HTML form , no escape necessary *}
					</div>
				</div>
				{/if}

				<div class="social-share">
					 {include file="module:psblog/views/templates/front/default/_social.tpl"}
				</div>
				{if $tags}
				<div class="blog-tags">
					<span>{l s='Tags:' mod='psblog'}</span>
				 
					{foreach from=$tags item=tag name=tag}
						 <a href="{$tag.link|escape:'html':'UTF-8'}" title="{$tag.tag|escape:'html':'UTF-8'}"><span>{$tag.tag|escape:'html':'UTF-8'}</span></a>
					{/foreach}
					 
				</div>
				{/if}

				{if !empty($samecats)||!empty($tagrelated)}
				<div class="extra-blogs row">
				{if !empty($samecats)}
					<div class="col-lg-6 col-md-6 col-xs-12">
						<h4>{l s='In Same Category' mod='psblog'}</h4>
						<ul>
						{foreach from=$samecats item=cblog name=cblog}
							<li><a href="{$cblog.link|escape:'html':'UTF-8'}">{$cblog.meta_title|escape:'html':'UTF-8'}</a></li>
						{/foreach}
						</ul>
					</div>
					<div class="col-lg-6 col-md-6 col-xs-12">
						<h4>{l s='Related by Tags' mod='psblog'}</h4>
						<ul>
						{foreach from=$tagrelated item=cblog name=cblog}
							<li><a href="{$cblog.link|escape:'html':'UTF-8'}">{$cblog.meta_title|escape:'html':'UTF-8'}</a></li>
						{/foreach}
						</ul>
					</div>
				{/if}
				</div>
				{/if}

				{if $productrelated}

				{/if}
				<div class="blog-comment-block">
				{if $config->get('item_comment_engine','local')=='facebook'}
					{include file="module:psblog/views/templates/front/default/_facebook_comment.tpl"}
				{elseif $config->get('item_comment_engine','local')=='diquis'}
					{include file="module:psblog/views/templates/front/default/_diquis_comment.tpl"}
				
				{else}
					{include file="module:psblog/views/templates/front/default/_local_comment.tpl"}
				{/if}
				</div>	
				{else}
				<div class="alert alert-warning">{l s='Sorry, This blog is not avariable. May be this was unpublished or deleted.' mod='psblog'}</div>
				{/if}

			</article>
		</div>
		{/if}

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
{/block}