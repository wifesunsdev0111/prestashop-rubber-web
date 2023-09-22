{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\admin\ap_page_builder_shortcodes\ApRow -->
<div {if !isset($apInfo)}id="default_row"{/if} class="row group-row{if isset($formAtts)} {$formAtts.form_id|escape:'html':'UTF-8'}{/if}">
    <div class="group-controll-left pull-left">
		<a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Drag to sort group' mod='appagebuilder'}" class="group-action gaction-drag label-tooltip"><i class="icon-move"></i> </a>
		&nbsp;
		<div class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
				<span>{l s='Group' mod='appagebuilder'}</span> <span class="caret"></span>
			</button>
			<ul class="dropdown-menu for-group-row" role="menu">
				<li><a href="javascript:void(0)" title="{l s='Edit Group' mod='appagebuilder'}" class="group-action btn-edit" data-type="ApRow"><i class="icon-edit"></i> {l s='Edit Group' mod='appagebuilder'}</a></li>
				<li><a href="javascript:void(0)" title="{l s='Delete Group' mod='appagebuilder'}"  class="group-action btn-delete"><i class="icon-trash"></i> {l s='Delete Group' mod='appagebuilder'}</a></li>
				<li><a href="javascript:void(0)" title="{l s='Export Group' mod='appagebuilder'}" class="group-action btn-export" data-type="group"><i class="icon-cloud-download"></i> {l s='Export Group' mod='appagebuilder'}</a></li>
				<li><a href="javascript:void(0)" title="{l s='Duplicate Group' mod='appagebuilder'}" class="group-action btn-duplicate "><i class="icon-paste"></i> {l s='Duplicate Group' mod='appagebuilder'}</a></li>
				<li><a href="javascript:void(0)" title="{l s='Disable or Enable Group' mod='appagebuilder'}" class="group-action btn-status {if isset($formAtts.active) && $formAtts.active==0} deactive{else} active{/if}"><i class="icon-ok"></i> {l s='Disable or Enable Group' mod='appagebuilder'}</a></li>
			</ul>
		</div>        
    </div>
    <div class="group-controll-right pull-right">
        <a href="javascript:void(0)" title="{l s='Add New Column' mod='appagebuilder'}" class="group-action btn-add-column" tabindex="0" data-container="body" data-toggle="popover" data-placement="left" data-trigger="focus"><i class="icon-plus"></i></a>
        <a href="javascript:void(0)" title="{l s='Set width for all column' mod='appagebuilder'}" class="group-action btn-custom" tabindex="0" data-container="body" data-toggle="popover" data-placement="left" data-trigger="focus" ><i class="icon-th"></i></a>
        <a href="javascript:void(0)" title="{l s='Expand or collapse Group' mod='appagebuilder'}" class="group-action gaction-toggle label-tooltip"><i class="icon-circle-arrow-down"></i></a>
    </div>
    <div class="group-content">
        {if isset($apInfo)}{$apContent}{* HTML form , no escape necessary *}{/if}
    </div>
</div>