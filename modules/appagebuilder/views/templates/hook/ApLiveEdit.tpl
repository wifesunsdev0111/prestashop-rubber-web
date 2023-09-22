{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApLiveEdit -->
{if isset($isLive)}
	{if isset($isEnd)}
	</div>
	{else}
	<div class="cover-live-edit">
		{if isset($formAtts) && isset($formAtts.form_id) && $formAtts.form_id}
		<a class='link-to-back-end' href="{$urlEditProfile}{*full link can not escape*}#{$formAtts.form_id|escape:'html':'UTF-8'}" target="_blank">
		{else}
		<a class='link-to-back-end' href="{$urlEditProfile}{*full link can not escape*}" target="_blank">
		{/if}
			<i class="icon-pencil"></i> <span>{l s='Edit' mod='appagebuilder'}</span>
		</a>
	{/if}
{/if}