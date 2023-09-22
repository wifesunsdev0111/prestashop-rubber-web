{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApSlideShow -->
{if isset($formAtts.active) && $formAtts.active == 1}
	<div  id="countdown-{$formAtts.form_id|escape:'html':'UTF-8'}" class="ApCountdown">
		
		{if isset($formAtts.title) && !empty($formAtts.title)}
			<h4 class="title_block">
				{$formAtts.title}{* HTML form , no escape necessary *}
			</h4>
		{/if}

		<ul class="ap-countdown-time deal-clock lof-clock-11-detail list-inline"></ul>

		<p class="ap-countdown-link">
			{if isset($formAtts.link) && $formAtts.link}
				{if isset($formAtts.new_tab) && $formAtts.new_tab == 1}
					<a href="{$formAtts.link|escape:'html':'UTF-8'}" target="_blank">{$formAtts.link_label|escape:'html':'UTF-8'}</a>
				{/if}	
				{if isset($formAtts.new_tab) && $formAtts.new_tab == 0}
					<a href="{$formAtts.link|escape:'html':'UTF-8'}">{$formAtts.link_label|escape:'html':'UTF-8'}</a>
				{/if}			
			{/if}
		</p>
	</div>

	{if isset($formAtts.addJS) && !empty($formAtts.addJS)}
		<script type="text/javascript" src="{$formAtts.countdown}"></script>
	{/if}
	<script type="text/javascript">
		{literal}
		jQuery(document).ready(function($){{/literal}
			var text_d = '{l s='days' mod='appagebuilder'}';
			var text_h = '{l s='hours' mod='appagebuilder'}';
			var text_m = '{l s='min' mod='appagebuilder'}';
			var text_s = '{l s='sec' mod='appagebuilder'}';
			$(".lof-clock-11-detail").lofCountDown({literal}{{/literal}
				TargetDate:"{$formAtts.time_to|escape:'html':'UTF-8'}",
				DisplayFormat:'<li class="z-depth-1">%%D%%<span>'+text_d+'</span></li class="z-depth-1"><li class="z-depth-1">%%H%%<span>'+text_h+'</span></li><li class="z-depth-1">%%M%%<span>'+text_m+'</span></li><li class="z-depth-1">%%S%%<span>'+text_s+'</span></li>',
				//FinishMessage: "Expired"
			{literal}
			});
		});
		{/literal}
	</script>
{/if}