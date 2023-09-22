{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\admin\ap_page_builder_home\position -->
<div class="header-cover">
    <strong>Position {$position|escape:'html':'UTF-8'}</strong>
    <div class="fr">
        <div class="dropdown">
            <div class="hide box-edit-position">
                <div class="form-group">
                    <label>{l s='Position name:' mod='appagebuilder'}</label>
                    <input class="edit-name" value="" type="text" placeholder="{l s='Enter position name ' mod='appagebuilder'}"/>
                </div>
                <button type="button" class="btn btn-primary btn-save">{l s='Save' mod='appagebuilder'}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{l s='Close' mod='appagebuilder'}</button>
            </div>
            
            <a class="btn btn-default" id="dropdown-{$position|lower|escape:'html':'UTF-8'}" role="button" data-toggle="dropdown" data-target="#">
                <i class="icon-columns"></i> 
                <span class="lbl-name">{l s='Current Position:' mod='appagebuilder'} 
                    {if $default.name}{$default.name|escape:'html':'UTF-8'}{else}{l s=' Blank' mod='appagebuilder'}{/if}
                </span>
                {if $listPositions} <span class="caret"></span>{/if}
            </a>
            <ul class="dropdown-menu dropdown-menu-right list-position" role="menu" aria-labelledby="dLabel" 
                data-position="{$position|lower|escape:'html':'UTF-8'}" id="position-{$position|lower|escape:'html':'UTF-8'}"
                data-id="{$default.id|escape:'html':'UTF-8'}" data-blank-error="{l s=' Please choose or create new a position ' mod='appagebuilder'}{$position|escape:'html':'UTF-8'}">
                <li>
                    <a href="javascript:;" class="add-new-position" data-id="0">
                        <span>{l s='New ' mod='appagebuilder'}{$position|escape:'html':'UTF-8'}</span>
                    </a>
                </li>
                
                {if $listPositions}
                {foreach from=$listPositions item=val}
                    {if isset($val.id_appagebuilder_positions)}
                <li>
                    <a href="javascript:;" class="position-name" data-id="{$val.id_appagebuilder_positions|escape:'html':'UTF-8'}">
                        <span title="{$val.name|escape:'html':'UTF-8'}">{$val.name|escape:'html':'UTF-8'}</span>
                        <i class="icon-edit label-tooltip" data-id="{$val.id_appagebuilder_positions|escape:'html':'UTF-8'}" title="{l s='Edit name' mod='appagebuilder'}"></i>
                        <i class="icon-paste label-tooltip" data-id="{$val.id_appagebuilder_positions|escape:'html':'UTF-8'}" title="{l s='Duplicate' mod='appagebuilder'}" data-temp="{l s='Duplicate' mod='appagebuilder'}"></i>
                    </a>
                </li>
                    {/if}
                {/foreach}
                {/if}
            </ul>
        </div>
    </div>
</div>
<br/>
<div class="position-area">
{foreach from=$config key=hookKey item=hookData}
	{if $hookKey == "displayHome"}
    <div class="col-md-6 home-content-wrapper">
	{/if}
	{* remove 4 hook tab - move to tab controller*}
	{if $hookKey != "displayHomeTab" && $hookKey != "displayHomeTabContent" && $hookKey != "productTab" && $hookKey != "productTabContent"}
        <div class="hook-wrapper {$hookKey|escape:'html':'UTF-8'} {$hookData.class|escape:'html':'UTF-8'}" data-hook="{$hookKey|escape:'html':'UTF-8'}">
            <div class="hook-top">
                <div class="pull-left hook-desc">{*{$hookData.hook_name}*}</div>
                <div class="hook-info text-center">
                    <a href="javascript:;" tabindex="0" class="open-group label-tooltip" title="{l s='Expand Hook' mod='appagebuilder'}" id="{$hookKey|escape:'html':'UTF-8'}" name="{$hookKey|escape:'html':'UTF-8'}">
                        {$hookKey|escape:'html':'UTF-8'} <i class="icon-circle-arrow-down"></i>
                    </a>
                </div>
            </div>
            <div class="hook-content">
                {if isset($hookData.content)}
                {$hookData.content}{* HTML form , no escape necessary *}
                {/if}
                <div class="hook-content-footer text-center">
                    <a href="javascript:void(0)" tabindex="0" class="btn-new-widget-group" title="{l s='Add Widget in new Group' mod='appagebuilder'}" data-container="body" data-toggle="popover" data-placement="top" data-trigger="focus">
                        <i class="icon-plus"></i>
                    </a>
                </div>
            </div>
        </div>
	{/if}
	{if $hookKey == "displayHomeTabContent"}
		</div>
	{/if}
{/foreach}
</div>
