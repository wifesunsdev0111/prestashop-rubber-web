{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApAlert -->
<div id="alert-{$formAtts.form_id|escape:'html':'UTF-8'}" class="block">
	{($apLiveEdit)?$apLiveEdit:''}{* HTML form , no escape necessary *}
	{if isset($formAtts.title) && !empty($formAtts.title)}
	<h4 class="title_block">
		{$formAtts.title|rtrim|escape:'html':'UTF-8'}
	</h4>
	{/if}
	<div class="alert {$formAtts.alert_type|escape:'html':'UTF-8'}">
	{if isset($formAtts.content_html)}
		{$formAtts.content_html}{* HTML form , no escape necessary *}
	{/if}
	</div>
	{($apLiveEditEnd)?$apLiveEditEnd:''}{* HTML form , no escape necessary *}
</div>