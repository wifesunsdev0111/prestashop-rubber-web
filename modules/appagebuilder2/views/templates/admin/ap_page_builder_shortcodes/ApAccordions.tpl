{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\admin\ap_page_builder_shortcodes\ApAccordions -->
{if !isset($isSubTab)}
<div id="{if !isset($apInfo)}default_ApAccordions{else}{$formAtts.id|escape:'html':'UTF-8'}{/if}" class="widget-row clearfix ApAccordions{if isset($formAtts)} {$formAtts.form_id|escape:'html':'UTF-8'}{/if}" data-type='ApAccordions'>
    <div class="float-center-control text-center">
        <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Drag to sort accordion' mod='appagebuilder'}" class="accordions-action waction-drag label-tooltip"><i class="icon-move"></i> </a>
        <span>{l s='Widget Accordions' mod='appagebuilder'}</span>
        
        <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Edit Accordions' mod='appagebuilder'}" class="accordions-action btn-edit label-tooltip " data-type="ApAccordions"><i class="icon-edit"></i></a>
        <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Delete Accordions' mod='appagebuilder'}" class="accordions-action btn-delete label-tooltip"><i class="icon-trash"></i></a>
        <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Duplicate Accordions' mod='appagebuilder'}" class="accordions-action btn-duplicate label-tooltip"><i class="icon-paste"></i></a>
        <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Disable or Enable Accordions' mod='appagebuilder'}" class="accordions-action btn-status label-tooltip{if isset($formAtts.active) && !$formAtts.active} deactive{else} active{/if}"><i class="icon-ok"></i></a>
    </div>
    <div class="panel-group" id="{if isset($formAtts.id)}{$formAtts.id|escape:'html':'UTF-8'}{else}accordion{/if}">
        {if !isset($formAtts.form_id)}
        {for $foo=1 to 2}
            <div class="panel panel-default">
                <div class="panel-heading widget-container-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapse{$foo|escape:'html':'UTF-8'}">Accordion {$foo|escape:'html':'UTF-8'}</a>
                    </h4>
                </div>
                <div id="collapse{$foo|escape:'html':'UTF-8'}" class="panel-collapse collapse in widget-container-content">
                    <div class="panel-body">
                        <div class="text-center tab-content-control">
                            <span>{l s='Accordion' mod='appagebuilder'}</span>
                            <a href="javascript:void(0)" class="tabcontent-action accordion btn-new-widget label-tooltip" title=""><i class="icon-plus-sign"></i></a>
                            <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Edit Tab' mod='appagebuilder'}" class="tabcontent-action accordions btn-edit label-tooltip" data-type="apSubAccordions"><i class="icon-edit"></i></a>
                            <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Delete Tab' mod='appagebuilder'}" class="tabcontent-action accordions btn-delete label-tooltip"><i class="icon-trash"></i></a>
                            <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Duplicate Tab' mod='appagebuilder'}" class="tabcontent-action accordions btn-duplicate label-tooltip"><i class="icon-paste"></i></a>
                        </div>
                        <div class="subwidget-content">

                        </div>
                    </div>
                </div>
            </div>    
        {/for}
        {else}
            {$apContent}{* HTML form , no escape necessary *}
        {/if}
            <a href="javascript:void(0)" class="btn-add-accordion"><i class="icon-plus"></i> {l s='Add' mod='appagebuilder'}</a>
    </div>
</div>    
{else}
        <div class="panel panel-default">
            <div class="panel-heading widget-container-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" class="{$formAtts.form_id|escape:'html':'UTF-8'}" data-parent="#{$formAtts.parent_id|escape:'html':'UTF-8'}" href="#{$formAtts.id|escape:'html':'UTF-8'}">{$formAtts.title|escape:'html':'UTF-8'}</a>
                </h4>
            </div>
            <div id="{$formAtts.id|escape:'html':'UTF-8'}" class="panel-collapse collapse widget-wrapper-content widget-container-content">
                <div class="panel-body">
                    <div class="text-center tab-content-control">
                        <span>{l s='Content' mod='appagebuilder'}</span>
                        <a href="javascript:void(0)" class="tabcontent-action accordion btn-new-widget label-tooltip" title=""><i class="icon-plus-sign"></i></a>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Edit Tab' mod='appagebuilder'}" class="tabcontent-action accordions btn-edit label-tooltip" data-type="apSubAccordions"><i class="icon-edit"></i></a>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Delete Tab' mod='appagebuilder'}" class="tabcontent-action accordions btn-delete label-tooltip"><i class="icon-trash"></i></a>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Duplicate Tab' mod='appagebuilder'}" class="tabcontent-action accordions btn-duplicate label-tooltip"><i class="icon-paste"></i></a>
                    </div>
                    <div class="subwidget-content">
                        {$apContent}{* HTML form , no escape necessary *}
                    </div>
                </div>
            </div>
        </div> 
{/if}