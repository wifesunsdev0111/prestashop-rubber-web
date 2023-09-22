{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApSlideShow -->
{if isset($formAtts.isEnabled) && $formAtts.isEnabled == true}
<div id="slideshow-{$formAtts.form_id|escape:'html':'UTF-8'}" class="ApSlideShow">
	{if isset($content_slider)}
		{$content_slider}{* HTML form , no escape necessary *}
	{/if}
</div>
{/if}