{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<div class="group-input group-{$ap_cf} clearfix">
		<label class="col-sm-12 control-label">
				<i class="fa fa-tags"></i>
				{if $ap_cf == 'profile'}
						{l s='Home version' mod='appagebuilder'}
				{else if $ap_cf == 'header'}
						{l s='Header version' mod='appagebuilder'}
				{else if $ap_cf == 'footer'}
						{l s='Footer version' mod='appagebuilder'}
				{else if $ap_cf == 'product'}
						{l s='Product version' mod='appagebuilder'}
				{else if $ap_cf == 'content'}
						{l s='Content Home' mod='appagebuilder'}
				{else if $ap_cf == 'product_builder'}
						{l s='Product Builder' mod='appagebuilder'}
				{/if}
		</label>
		<div class="col-sm-12">
				{foreach from=$ap_cfdata item=cfdata}
						<a class="apconfig apconfig-{$ap_cf}{if $cfdata.active} active{/if}" data-type="{$ap_type}" data-id='{$cfdata.id}' href="index.php?{$ap_type}={$cfdata.id}">{$cfdata.name}</a>
				{/foreach}
		</div>
</div>