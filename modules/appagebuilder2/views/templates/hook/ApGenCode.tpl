{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApGenCode -->

{if isset($formAtts.tpl_file) && !empty($formAtts.tpl_file)}
	{include file=$formAtts.tpl_file}
{/if}

{if isset($formAtts.error_file) && !empty($formAtts.error_file)}
	{$formAtts.error_message}{*contain html can not escape*}
{/if}
