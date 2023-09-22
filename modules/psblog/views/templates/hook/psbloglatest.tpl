{*
 *  Ps Prestashop SliderShow for Prestashop 1.6.x
 *
 * @package   pssliderlayer
 * @version   3.0
 * @author    http://www.prestabrain.com
 * @copyright Copyright (C) October 2013 PrestaBrain.com <@emai:prestabrain@gmail.com>
 *               
 * @license   GNU General Public License version 2
*}

<!-- Block Last post-->
<div class="homeblog block">
<div class="lastest_block block">
	<div class="title_block ax-product-title"><span>{l s='Latest posts' d="Modules.PsBlog.Shop"}</span></div>
	<div class="row">
	<div class="block_content ">
		
		{assign var='no_blog' value=count($blogs)}
		{assign var='sliderFor' value=4} 
		{if $no_blog >= $sliderFor}
			<ul id="psblog-slider" class="blog_list">
		{else}
			<ul id="psblog-grid" class="blog_grid">
		{/if}
	
		{foreach from=$blogs item=blog name="item_name" }
			
			<li class="blog-post hb-animate-element right-to-left {if $no_blog >= $sliderFor}item{else}product_item col-xs-12 col-sm-6 col-md-4 col-lg-4{/if}">
			<div class="blog_container">
				{if $blog.image}
					<div class="blog-image text-xs-center">
						<a href="{$blog.link|escape:'html':'UTF-8'}" title="{$blog.title|escape:'html':'UTF-8'}" class="link">
							<img src="{$blog.preview_url|escape:'html':'UTF-8'}" alt="{$blog.title|escape:'html':'UTF-8'}" class="img-fluid"/>
						</a>
					</div>
				{/if}
				<div class="blog-inner">
					<div class="blog-meta">
						<!-- <span class="blog-author">
							<span class="fa fa-user"> {l s='Posted By' mod='psblog'}:</span> 
							<a href="{$blog.author_link|escape:'html':'UTF-8'}" title="{$blog.author|escape:'html':'UTF-8'}">{$blog.author|escape:'html':'UTF-8'}</a> 
						</span>	 -->				
						<!-- <span class="blog-cat"> 
							<span class="fa fa-list"> {l s='In' mod='psblog'}:</span> 
							<a href="{$blog.category_link|escape:'html':'UTF-8'}" title="{$blog.category_title|escape:'html':'UTF-8'}">{$blog.category_title|escape:'html':'UTF-8'}</a>
						</span> -->
						<span class="blog-created">
							<!-- <span class="fa fa-calendar"> {l s='On' mod='psblog'}: </span>  -->
							<time class="date" datetime="{strtotime($blog.date_add)|date_format:"%Y"|escape:'html':'UTF-8'}">
								<!-- {l s=strtotime($blog.date_add)|date_format:"%A"|escape:'html':'UTF-8' mod='psblog'}, -->	<!-- day of week -->
								{l s=strtotime($blog.date_add)|date_format:"%d"|escape:'html':'UTF-8' mod='psblog'} /	<!-- day of month -->
								{l s=strtotime($blog.date_add)|date_format:"%m"|escape:'html':'UTF-8' mod='psblog'} /	<!-- month-->
								{l s=strtotime($blog.date_add)|date_format:"%Y"|escape:'html':'UTF-8' mod='psblog'}		<!-- year -->
							</time>
						</span>

						<span class="blog-hit">
							{$blog.hits|intval}
						</span>
					</div>
					<h2 class="blog-title">
						<a href="{$blog.link|escape:'html':'UTF-8'}" title="{$blog.title|escape:'html':'UTF-8'}">{$blog.title|escape:'html':'UTF-8'|truncate:25:'...'}</a>
					</h2>
					
					<div class="blog-homedesc">
							<div class="shortdesc">{$blog.description|strip_tags:'UTF-8'|truncate:90:'' nofilter}{* HTML form , no escape necessary *}</div>
							<div class="readmore">
								<a href="{$blog.link|escape:'html':'UTF-8'}" title="{$blog.title|escape:'html':'UTF-8'}" class="btn">{l s='Read more' mod='psblog'}</a>
							</div>
						</div>
									
				</div>
			</div>
			</li>	
		{/foreach}
		</ul>	
		{if $no_blog >= $sliderFor}
         <div id="blog-arrows" class="arrows">
         </div>
      {/if}
		
	</div>
</div>
</div>
</div>
<!-- /Block Last Post -->
