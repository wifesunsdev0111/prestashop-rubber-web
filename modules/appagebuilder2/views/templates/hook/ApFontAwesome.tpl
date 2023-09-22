{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApFontAwesome -->
{($apLiveEdit)?$apLiveEdit:''}{* HTML form , no escape necessary *}
{if isset($formAtts.title) && !empty($formAtts.title)}
<h4 class="title_block">
	{$formAtts.title|escape:'html':'UTF-8'}
</h4>
{/if}
{if isset($formAtts.font_name) && $formAtts.font_name}
	<i class="icon 
		{if isset($formAtts.font_size)}{$formAtts.font_size|escape:'html':'UTF-8'}{/if} 
		{if isset($formAtts.font_type)}{$formAtts.font_type|escape:'html':'UTF-8'}{/if} 
		{if isset($formAtts.is_spin)}{$formAtts.is_spin|escape:'html':'UTF-8'}{/if} 
		{$formAtts.font_name|escape:'html':'UTF-8'}"></i>
{/if}
{($apLiveEditEnd)?$apLiveEditEnd:''}{* HTML form , no escape necessary *}
