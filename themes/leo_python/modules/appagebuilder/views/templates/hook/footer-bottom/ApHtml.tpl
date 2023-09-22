{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApGeneral -->
<div{if isset($formAtts.id) && $formAtts.id} id="{$formAtts.id}"{/if}{if isset($formAtts.class)} 
    class="{$formAtts.class} footer-block block"{/if}>
	{$apLiveEdit}
    {if isset($formAtts.title) && $formAtts.title}
		<h4 class="title_block">{$formAtts.title|rtrim}</h4>
    {/if}
	<div class="block_content toggle-footer">
		{if isset($formAtts.content_html)}
			{$formAtts.content_html}
		{else}
			{$apContent}
		{/if}
	</div>
	{$apLiveEditEnd}
</div>