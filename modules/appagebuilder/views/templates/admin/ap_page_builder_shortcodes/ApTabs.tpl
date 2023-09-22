{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\admin\ap_page_builder_shortcodes\ApTabs -->
{if !isset($isSubTab)}
<div {if !isset($apInfo)}id="default_ApTabs"{/if} class="widget-row clearfix ApTabs{if isset($formAtts)} {$formAtts.form_id|escape:'html':'UTF-8'}{/if}" data-type='ApTabs'>
    <div class="float-center-control text-center">
        <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Drag to sort group' mod='appagebuilder'}" class="tab-action waction-drag label-tooltip"><i class="icon-move"></i> </a>
        <span>{l s='Widget Tab' mod='appagebuilder'}</span>
        
        <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Edit Tabs' mod='appagebuilder'}" class="tab-action btn-edit label-tooltip" data-type="ApTabs"><i class="icon-edit"></i></a>
        <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Delete Tabs' mod='appagebuilder'}" class="tab-action btn-delete label-tooltip"><i class="icon-trash"></i></a>
        <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Duplicate Tabs' mod='appagebuilder'}" class="tab-action btn-duplicate label-tooltip"><i class="icon-paste"></i></a>
        <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Disable or Enable Tab' mod='appagebuilder'}" class="tab-action btn-status label-tooltip{if isset($formAtts.active) && !$formAtts.active} deactive{else} active{/if}"><i class="icon-ok"></i></a>
    </div>
{if !isset($apInfo)}
    <ul class="widget-container-heading nav nav-tabs" role="tablist">
        {for $foo=1 to 3}
            <li {if $foo ==3}id="default_tabnav"{/if} class="{if $foo==1}active{/if}">
                <a href="#tab{$foo|escape:'html':'UTF-8'}" role="tab" data-toggle="tab">{if $foo ==3}{l s='New Tab' mod='appagebuilder'}{else}{l s='Tab' mod='appagebuilder'} {$foo|escape:'html':'UTF-8'}{/if}</a></li>
        {/for}
        <li class="tab-button"><a href="javascript:void(0)" class="btn-add-tab"><i class="icon-plus"></i> {l s='Add' mod='appagebuilder'}</a></li>
    </ul>
    
    <div class="tab-content widget-container-content">
        {for $foo=1 to 3}
            <div {if $foo ==3}id="default_tabcontent"{else}id="tab{$foo|escape:'html':'UTF-8'}"{/if} class="tab-pane{if $foo==1} active{/if} widget-wrapper-content">
                <div class="text-center tab-content-control">
                    <span>{l s='Tab' mod='appagebuilder'}</span>
                    <a href="javascript:void(0)" class="tabcontent-action btn-new-widget label-tooltip" title=""><i class="icon-plus-sign"></i></a>
                    <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Edit Tab' mod='appagebuilder'}" class="tabcontent-action btn-edit label-tooltip" data-type="apSubTabs"><i class="icon-edit"></i></a>
                    <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Delete Tab' mod='appagebuilder'}" class="tabcontent-action btn-delete label-tooltip tab"><i class="icon-trash"></i></a>
                    <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Duplicate Tab' mod='appagebuilder'}" class="tabcontent-action btn-duplicate label-tooltip"><i class="icon-paste"></i></a>
                </div>
                <div class="subwidget-content">
                    
                </div>
            </div>
        {/for}
    </div>
{else}
    <ul class="widget-container-heading nav nav-tabs" role="tablist">
        {foreach from=$subTabContent item=subTab}
            <li class="">
                <a href="#{$subTab.id|escape:'html':'UTF-8'}" class="{$subTab.form_id|escape:'html':'UTF-8'}" role="tab" data-toggle="tab">
                    <span>{$subTab.title|escape:'html':'UTF-8'}</span>
                </a>
            </li>
        {/foreach}
        <li class="tab-button"><a href="javascript:void(0)" class="btn-add-tab"><i class="icon-plus"></i> {l s='Add' mod='appagebuilder'}</a></li>
    </ul>

    <div class="tab-content">
        {$apContent}{* HTML form , no escape necessary *}
    </div>
{/if}
</div>
{else}
    <div id="{$tabID|escape:'html':'UTF-8'}" class="tab-pane widget-wrapper-content">
        <div class="text-center tab-content-control">
            <span>{l s='Tab' mod='appagebuilder'}</span>
            <a href="javascript:void(0)" class="tabcontent-action btn-new-widget label-tooltip" title=""><i class="icon-plus-sign"></i></a>
            <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Edit Tab' mod='appagebuilder'}" class="tabcontent-action btn-edit label-tooltip" data-type="apSubTabs"><i class="icon-edit"></i></a>
            <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Delete Tab' mod='appagebuilder'}" class="tabcontent-action btn-delete label-tooltip tab"><i class="icon-trash"></i></a>
            <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Duplicate Tab' mod='appagebuilder'}" class="tabcontent-action btn-duplicate label-tooltip"><i class="icon-paste"></i></a>
        </div>
        <div class="subwidget-content">
            {$apContent}{* HTML form , no escape necessary *}
        </div>
    </div>
{/if}
