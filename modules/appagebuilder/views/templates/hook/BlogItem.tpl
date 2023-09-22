{*
 *  @Module Name: AP Page Builder
 *  @Website: apollotheme.com - prestashop template provider
 *  @author Apollotheme <apollotheme@gmail.com>
 *  @copyright  2007-2015 Apollotheme
 *  @description: ApPageBuilder is module help you can build content for your  
*}
<!-- @file modules\appagebuilder\views\templates\hook\BlogItem -->
<div class="blog-container" itemscope itemtype="https://schema.org/Blog">
    <div class="left-block">
        <div class="blog-image-container">
            <a class="blog_img_link" href="{$blog.link|escape:'html':'UTF-8'}" title="{$blog.title|escape:'html':'UTF-8'}" itemprop="url">
			{if isset($formAtts.bleoblogs_sima) && $formAtts.bleoblogs_sima}
				<img class="replace-2x img-responsive" src="{$blog.preview_url}{*full url can not escape*}" 
					 alt="{if !empty($blog.legend)}{$blog.legend|escape:'html':'UTF-8'}{else}{$blog.title|escape:'html':'UTF-8'}{/if}" 
					 title="{if !empty($blog.legend)}{$blog.legend|escape:'html':'UTF-8'}{else}{$blog.title|escape:'html':'UTF-8'}{/if}" 
					 {if isset($formAtts.bleoblogs_width)}width="{$formAtts.bleoblogs_width|escape:'html':'UTF-8'}" {/if}
					 {if isset($formAtts.bleoblogs_height)} height="{$formAtts.bleoblogs_height|escape:'html':'UTF-8'}"{/if}
					 itemprop="image" />
			{/if}
            </a>
        </div>
    </div>
    <div class="right-block">
        {if isset($formAtts.show_title) && $formAtts.show_title}
        <h5 class="blog-title" itemprop="name"><a href="{$blog.link}{*full url can not escape*}" title="{$blog.title|escape:'html':'UTF-8'}">{$blog.title|strip_tags:'UTF-8'|truncate:80:'...'}</a></h5>
        {/if}
		
		{if isset($formAtts.bleoblogs_saut) && $formAtts.bleoblogs_saut}
		<span class="author">
			<span class="icon-author"> {l s='Author' mod='appagebuilder'}:</span> {$blog.author|escape:'html':'UTF-8'}
		</span>
		{/if}
		
		{if isset($formAtts.bleoblogs_scat) && $formAtts.bleoblogs_scat}
		<span class="cat"> <span class="icon-list">{l s='In' mod='appagebuilder'}</span> 
			<a href="{$blog.category_link}{*full url can not escape*}" title="{$blog.category_title|escape:'html':'UTF-8'}">{$blog.category_title|escape:'html':'UTF-8'}</a>
		</span>
		{/if}
		
		{if isset($formAtts.bleoblogs_scre) && $formAtts.bleoblogs_scre}
		<span class="created"><span class=""></span>
			<span class="icon-calendar"> {l s='On' mod='appagebuilder'} </span> 
			<time class="date" datetime="{strtotime($blog.date_add)|date_format:"%Y"}{*convert to date time*}">
				{l s=strtotime($blog.date_add)|date_format:"%A" mod='appagebuilder'},	<!-- day of week -->
				{l s=strtotime($blog.date_add)|date_format:"%B" mod='appagebuilder'}		<!-- month-->
				{l s=strtotime($blog.date_add)|date_format:"%e" mod='appagebuilder'},	<!-- day of month -->
				{l s=strtotime($blog.date_add)|date_format:"%Y" mod='appagebuilder'}		<!-- year -->
			</time>
		</span>
		{/if}
		
		{if isset($formAtts.bleoblogs_scoun) && $formAtts.bleoblogs_scoun}
		<span class="nbcomment">
			<span class="icon-comment"> {l s='Comment' mod='appagebuilder'}:</span> {$blog.comment_count|intval}
		</span>
		{/if}
		
		{if isset($formAtts.bleoblogs_shits) && $formAtts.bleoblogs_shits}
		<span class="hits">
			<span class="icon-hits"> {l s='Hits' mod='appagebuilder'}:</span> {$blog.hits|intval}
		</span>	
		{/if}
		
		{if isset($formAtts.show_desc) && $formAtts.show_desc}
        <p class="blog-desc" itemprop="description">
            {$blog.description|strip_tags:'UTF-8'|truncate:160:'...'}
        </p>
        {/if}
    </div>
</div>

<!---
	Translation Day of Week - NOT REMOVE
	{l s='Sunday' mod='appagebuilder'}
	{l s='Monday' mod='appagebuilder'}
	{l s='Tuesday' mod='appagebuilder'}
	{l s='Wednesday' mod='appagebuilder'}
	{l s='Thursday' mod='appagebuilder'}
	{l s='Friday' mod='appagebuilder'}
	{l s='Saturday' mod='appagebuilder'}
-->
<!---
	Translation Month - NOT REMOVE
		{l s='January' mod='appagebuilder'}
		{l s='February' mod='appagebuilder'}
		{l s='March' mod='appagebuilder'}
		{l s='April' mod='appagebuilder'}
		{l s='May' mod='appagebuilder'}
		{l s='June' mod='appagebuilder'}
		{l s='July' mod='appagebuilder'}
		{l s='August' mod='appagebuilder'}
		{l s='September' mod='appagebuilder'}
		{l s='October' mod='appagebuilder'}
		{l s='November' mod='appagebuilder'}
		{l s='December' mod='appagebuilder'}
-->