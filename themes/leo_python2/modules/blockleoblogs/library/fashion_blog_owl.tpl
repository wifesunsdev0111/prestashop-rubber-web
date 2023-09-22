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
<div class="block blogs_block exclusive blockleoblogs">
	<h3 class="title-block">{l s='Latest Blogs' mod='blockleoblogs'}</h3>
	<div class="block_content">	
		{if !empty($blogs )}
			<div class="carousel slide">
				<div class="carousel-inner" id="{$mytab}">
				{$mblogs=array_chunk($blogs,$owl_rows)}
				{foreach from=$mblogs item=blogs name=mypLoop}
					<div class="item {if $smarty.foreach.mypLoop.first}active{/if}">
							{foreach from=$blogs item=blog name=blogs}
					 
								<article class="blog-item clearfix">
										{if $blog.image && $config->get('blockleo_blogs_img',1)}
											<div class="image">
												{if $owl_lazyLoad}
													<img data-src="{$blog.preview_url}" title="{$blog.title}" class="img-responsive lazyOwl" alt="{$blog.title}" />
												{else}
													<img src="{$blog.preview_url}" title="{$blog.title}" class="img-responsive" alt="{$blog.title}" />
												{/if}
											</div>
										{/if}
										<div class="border-blog">	
											<div class="clearfix">
												<div class="left-blog">
													{*<p class="text-center">
														<a href="{$blog.link}" title="{$blog.title|escape:'html':'UTF-8'}" class="more btn btn-default"><i class="fa fa-external-link"></i></a>
													</p>*}
													<div class="meta">
														{if $config->get('blockleo_blogs_cat',1)}
														<span class="category"> <span class="icon-list">{l s='In' mod='blockleoblogs'}</span> 
															<a href="{$blog.category_link}" title="{$blog.category_title|escape:'html':'UTF-8'}">{$blog.category_title}</a>
														</span>
														{/if}

														{if $config->get('blockleo_blogs_cre',1)} 
															<span class="created"><span class=""></span>
															<time class="date"><span>{strtotime($blog.date_add)|date_format:"%d"}</span>{strtotime($blog.date_add)|date_format:" %b"}</time>
															</span>
														{/if} 

														{if $config->get('blockleo_blogs_cout',1)} 
														<span class="nbcomment">
															<span> {$blog.comment_count} </span>
														</span>
														{/if}  

														{if $config->get('blockleo_blogs_aut',1)} 
														<span class="author">
															<span class="icon-author"> {l s='Author' mod='blockleoblogs'}:</span> {$blog.author}
														</span>
														{/if}
														{if $config->get('blockleo_blogs_hits',1)} 
														<span class="hits">
															<span class="icon-hits"> {l s='Hits' mod='blockleoblogs'}:</span> {$blog.hits}
														</span>	
														{/if}
													</div>

												</div>
												<div class="right-blog">
													{if $config->get('blockleo_blogs_title',1)}
														<h4 class="title"><a href="{$blog.link}" title="{$blog.title}">{$blog.title}</a></h4>
													{/if}
													<div class="shortinfo">
														{if $config->get('blockleo_blogs_des',1)} 
														{$blog.description}
														{/if}  
													</div>
												</div>
											</div>
										</div>
									</article> 
 

							{/foreach}
					</div>		
				{/foreach}
				</div>
			</div>
		{/if}
	</div>
		{if $config->get('blockleo_blogs_show',1)}
		<div><a class="pull-right" href="{$view_all_link}" title="{l s='View All' mod='blockleoblogs'}">{l s='View All' mod='blockleoblogs'}</a></div>
		{/if}	
</div>
<!-- /MODULE Block blockleoblogstabs -->
