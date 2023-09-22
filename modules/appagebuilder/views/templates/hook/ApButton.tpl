{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApButton -->
{($apLiveEdit)?$apLiveEdit:''}{* HTML form , no escape necessary *}
{if isset($formAtts.title) && !empty($formAtts.title)}
<h4 class="title_block">
	{$formAtts.title|escape:'html':'UTF-8'}
</h4>
{/if}
{if isset($formAtts.name) && $formAtts.name}
	{if isset($formAtts.url) && $formAtts.url}
	<a href="{$formAtts.url}{*full link can not escape*}" {if isset($formAtts.is_blank)}target="_blank"{/if}>
	{/if}
	<span class="btn {$formAtts.class|escape:'html':'UTF-8'} {$formAtts.button_type|escape:'html':'UTF-8'} {$formAtts.button_size|escape:'html':'UTF-8'} {if isset($formAtts.is_block) && $formAtts.is_block} btn-block{/if}">{$formAtts.name|escape:'html':'UTF-8'}</span>
	{if isset($formAtts.url) && $formAtts.url}
	</a>
	{/if}
{/if}
{($apLiveEditEnd)?$apLiveEditEnd:''}{* HTML form , no escape necessary *}
