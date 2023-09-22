{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
<div{if isset($formAtts.id) && $formAtts.id} id="{$formAtts.id|escape:'html':'UTF-8'}"{/if}
    class="{(isset($formAtts.class)) ? $formAtts.class : ''|escape:'html':'UTF-8'} {(isset($formAtts.animation) && $formAtts.animation != 'none'|escape:'html':'UTF-8') ? 'has-animation' : ''}"
	{if isset($formAtts.animation) && $formAtts.animation != 'none'} data-animation="{$formAtts.animation|escape:'html':'UTF-8'}" {/if}
	{if $formAtts.animation_delay != ''} data-animation-delay="{$formAtts.animation_delay|escape:'html':'UTF-8'}" {/if}
    >
    {if isset($formAtts.title) && $formAtts.title}
    <h4 class="title_block">{$formAtts.title}{*contain html, no escape necessary*}</h4>
    {/if}
    {if isset($formAtts.content_html)}
        {$formAtts.content_html|escape:'html':'UTF-8'}
    {else}
        {$apContent}
    {/if}
</div>