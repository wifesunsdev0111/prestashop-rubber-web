{*
 *  Leo Prestashop SliderShow for Prestashop 1.6.x
 *
 * @package   leosliderlayer
 * @version   3.0
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
*}

<!-- MODULE Block blockleoblogstabs -->
{$tabname="blockleoblogs"}
<div id="blockleoblogstabs" class="icenter blogs">
	<h3>{l s='Latest Blogs' mod='blockleoblogs'}</h3>
	<div class="block_content">	
		{if !empty($blogs )}
			{if !empty($blogs)}
<div class="carousel slide" id="{$tabname}">
	 {if count($blogs)>$itemsperpage}	
	 	<a class="carousel-control left" href="#{$tabname}"   data-slide="prev">&lsaquo;</a>
		<a class="carousel-control right" href="#{$tabname}"  data-slide="next">&rsaquo;</a>
	{/if}
	<div class="carousel-inner">
	{$mblogs=array_chunk($blogs,$itemsperpage)}
	{foreach from=$mblogs item=blogs name=mypLoop}
		<div class="item {if $smarty.foreach.mypLoop.first}active{/if}">
				{foreach from=$blogs item=blog name=blogs}
				{if $blog@iteration%$columnspage==1&&$columnspage>1}
				  <div class="row">
				{/if}
				<div class="blog-item media {if $columnspage>1} col-sp-12 col-xs-12 col-sm-12 col-md-{$scolumn} col-lg-{$scolumn} {/if} blog_block ajax_block_blog {if $smarty.foreach.blogs.first}first_item{elseif $smarty.foreach.blogs.last}last_item{/if}">
					<div class="media-body clearfix">
							{if $config->get('blockleo_blogs_title',1)}
							<h4><a href="{$blog.link}" title="{$blog.title}">{$blog.title|truncate:30:'...'|escape:'html':'UTF-8'}</a></h4>
							{/if}	
							<div class="blog-meta">								 
								{if $config->get('blockleo_blogs_cat',1)}
								<span class="blog-cat"> <span class="icon-list">{l s='In' mod='blockleoblogs'}</span> 
									<a href="{$blog.category_link}" title="{$blog.category_title|escape:'html':'UTF-8'}">{$blog.category_title}</a>
								</span>
								{/if}
								
								{if $config->get('blockleo_blogs_cre',1)} 
								<span class="blog-created"><span class=""></span>
									<span class="icon-calendar"> {l s='On' mod='blockleoblogs'} </span> {strtotime($blog.date_add)|date_format:"%A, %B %e, %Y"}
								</span>
								{/if} 
								
								{if $config->get('blockleo_blogs_cout',1)} 
								<span class="blog-ctncomment">
									<span class="icon-comment"> {l s='Comment' mod='blockleoblogs'}:</span> {$blog.comment_count}
								</span>
								{/if}  
								
								{if $config->get('blockleo_blogs_aut',1)} 
								<span class="blog-author">
									<span class="icon-author"> {l s='Author' mod='blockleoblogs'}:</span> {$blog.author}
								</span>
								{/if}
								{if $config->get('blockleo_blogs_hits',1)} 
								<span class="blog-hits">
									<span class="icon-hits"> {l s='Hits' mod='blockleoblogs'}:</span> {$blog.hits}
								</span>	
								{/if}
							</div>

							<div class="blog-shortinfo">
								{if $config->get('blockleo_blogs_des',1)} 
								{$blog.description}
								{/if}   						 
							</div>
						</div>

						{if $blog.image && $config->get('blockleo_blogs_img',1)}
						<div class="image pull-left">
							<img src="{$blog.preview_url}" title="{$blog.title}" class="img-responsive" alt="{$blog.title}" />
						</div>
						{/if}
				</div>
				
				{if ($blog@iteration%$columnspage==0||$smarty.foreach.blogs.last)&&$columnspage>1}
				</div>
				{/if}
					
				{/foreach}
		</div>		
	{/foreach}
	</div>
</div>
{/if}
		{/if}
	</div>
		{if $config->get('blockleo_blogs_show',1)}
		<div><a class="pull-right" href="{$view_all_link}" title="{l s='View All' mod='blockleoblogs'}">{l s='View All' mod='blockleoblogs'}</a></div>
		{/if}	
</div>
<!-- /MODULE Block blockleoblogstabs -->
<script type="text/javascript">
{literal}
$(document).ready(function() {
    $('#{/literal}{$tabname}{literal}').each(function(){
        $(this).carousel({
            pause: 'hover',
            interval: {/literal}{$interval}{literal}
        });
    });
});
{/literal}
</script>
 