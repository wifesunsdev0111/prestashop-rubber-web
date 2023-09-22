{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApGeneral -->
<div{if isset($formAtts.id) && $formAtts.id} id="{$formAtts.id|escape:'html':'UTF-8'}"{/if}{if isset($formAtts.class)} 
    class="{$formAtts.class|escape:'html':'UTF-8'} block"{/if}>
	{($apLiveEdit)?$apLiveEdit:''}{* HTML form , no escape necessary *}
    {if isset($formAtts.title) && $formAtts.title}
    <h4 class="title_block">{$formAtts.title|escape:'html':'UTF-8'}</h4>
    {/if}
    {if isset($formAtts.content_html)}
        {$formAtts.content_html}{* HTML form , no escape necessary *}
    {else}
        {$apContent}{* HTML form , no escape necessary *}
    {/if}
	{($apLiveEditEnd)?$apLiveEditEnd:''}{* HTML form , no escape necessary *}
</div>