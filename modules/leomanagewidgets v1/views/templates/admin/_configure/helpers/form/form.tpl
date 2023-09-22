{*
*}

{extends file="helpers/form/form.tpl"}
{block name="field"}
    {if $input.type == 'hook_list'}
        <div class="col-md-12">
            <div class="alert alert-success">
                <a href="http://www.leotheme.com/support/prestashop-16x-guides.html">{l s='Click Here to see Module Guide' mod='leoblog'}</a>
            </div>
        </div>
        <div class="col-md-8 leo-redirect">
            <div class="alert alert-success">{l s="Click on hook you want to config"}</div>
            <ol class="breadcrumb">
                <li class="active">HEADER</li>
                <li><a data-element="displaynav" href="#">displayNav</a></li>
                <li><a data-element="displaytop" href="#">displayTop</a></li>
                <li><a data-element="topnavigation" href="#">topNavigation</a></li>
                <li><a data-element="displayslideshow" href="#">displaySlideshow</a></li>
                <li><a data-element="displaytopcolumn" href="#">displayTopColumn</a></li>
            </ol>
            <ol class="breadcrumb" href="#">
                <li class="active" href="#">CONTENT</li>
                <li><a data-element="displayleftcolumn" href="#">displayLeftColumn</a></li>
                <li><a data-element="displayhome" href="#">displayHome</a></li>
                <li><a data-element="displaycontentbottom" href="#">displayContentBottom</a></li>
                <li><a data-element="displayrightcolumn" href="#">displayRightColumn</a></li>
            </ol>
            <ol class="breadcrumb" href="#">
                <li class="active" href="#">FOOTER</li>
                <li><a data-element="displaybottom" href="#">displayBottom</a></li>
                <li><a data-element="displayfootertop" href="#">displayFooterTop</a></li>
                <li><a data-element="displayfooter" href="#">displayFooter</a></li>
                <li><a data-element="displayfooterbottom" href="#">displayFooterBottom</a></li>
                <li><a data-element="displayfootnav" href="#">displayFootNav</a></li>
            </ol>
            <br>
            <ol class="breadcrumb" href="#">
                <li class="active" href="#">PRODUCT DETAIL PAGE</li>
                <li><a data-element="displayrightcolumnproduct" href="#">displayRightColumnProduct</a></li>
                <li><a data-element="producttabcontent" href="#">productTabContent</a></li>
                <li><a data-element="productfooter" href="#">productFooter</a></li>
            </ol>
            
            <input type="hidden" id="data_forms" name="data_form" value=""/>
            <input type="hidden" id="data_delete" name="data_delete" value=""/>
        </div>
        <div class="col-md-4 leo-guide">
            <div class="alert alert-success">{l s="How to use non-group and group"}</div>
            <div class="form">
                <div class="row"><b class="title">{l s='Non-group in Top'}</b></div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="other-module">
                            <span>{l s='OTHER MODULE...'}</span>
                            <span>{l s='display inline and float left'}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="column-widget">
                            <span>{l s='COLUMN IN NON-GROUP'}</span>
                            <span>{l s='display in-line and float right'}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form">
                <div class="row"><b class="title">{l s='Group'}</b></div>
                <div class="row group-wrap">
                    <div class="col-md-6">
                        <div class="column-widget">
                            <span>{l s='COLUMN IN GROUP'}</span>
                            <span>{l s='display in-line with other column of group'}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="column-widget">
                            <span>{l s='COLUMN IN GROUP'}</span>
                            <span>{l s='display in-line with other column of group'}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form">
                <div class="row"><b class="title">{l s='Non-group in Bottom'}</b></div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="column-widget">
                            <span>{l s='COLUMN IN NON-GROUP'}</span>
                            <span>{l s='display in-line and float left'}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="other-module">
                            <span>{l s='OTHER MODULE...'}</span>
                            <span>{l s='display in-line and float right'}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="alert alert-success leo-alert">{l s="Please Select monitor size to configuration"}</div>
            <div class="leo-explain">
                <b>{l s='Default'}</b>
                {l s='Default monitor'} <br><i>{l s='Use current monitor size'}</i><br>
                <b>{l s='Large'}</b>
                {l s='Large devices Desktops (≥1200px)'} <br><i>{l s='27in Monitor'} - {l s='17in Workstation'} - {l s='15in Macbook Pro'} - {l s='11in Macbook Air'}</i><br>
                <b>{l s='Medium'}</b>
                {l s='Medium devices Desktops (≥992px)'} <br><i>{l s='iPad (Landscape)'}</i><br>
                <b>{l s='Small'}</b>
                {l s='Small devices Tablets (≥768px)'} <br><i>{l s='Nexus7 (Landscape)'} - {l s='iPad (Portrait)'}</i><br>
                <b>{l s='Extra small'}</b>
                {l s='Extra small devices Phones (≥481px)'} <br><i>{l s='Nexus7 (Portrait)'}</i><br>
                <b>{l s='Mobile'}</b>
                {l s='Smart Phones (<481px)'} <br><i>{l s='iPhone (Landscape)'}-{l s='iPhone (Portrait)'}</i><br>
            </div>
            <div class="btn-toolbar" role="toolbar">
                <div class="btn-group btn-group-lg leo-resize">
                  <button type="button" data-class="reset" data-width="auto" class="btn btn-default btn-success">{l s='Default'}</button>
                  <button type="button" data-class="col-lg" data-width="1200" class="btn btn-default">{l s='Large'}</button>
                  <button type="button" data-class="col-md" data-width="992" class="btn btn-default">{l s='Medium'}</button>
                  <button type="button" data-class="col-sm" data-width="768" class="btn btn-default">{l s='Small'}</button>
                  <button type="button" data-class="col-xs" data-width="603" class="btn btn-default">{l s='Extra small'}</button>
                  <button type="button" data-class="col-sp" data-width="480" class="btn btn-default">{l s='Mobile'}</button>
                </div>
            </div>
            <div style="display:none;" id="leo-mess" data-reduce="{l s='Minimum value of width is 1'}" data-increase="{l s='Maximum value of width is 12'}"></div>
        </div>
    {/if}
    {if $input.type == 'hook_data'}
        <div class="leo-heading">
            <div class="col-lg-6">
                <a href="#" id="{$input.name}"><i class="icon-cog"></i> {$input.name}</a>
            </div>
            
            <div class="col-lg-6 hwidget-form">
                <a title="" class="pull-right leo-close-open label-tooltip" data-toggle="tooltip" data-original-title="{l s='Click here to close or open this form'}" data-status="1" href="javascript:void(0)" >
                    <i class="icon-sort-up"></i>
                </a>
            </div>
        </div>
        <div class="leo-content">
            <div id="{$input.name}_container" class="leohook" data-hook="{$input.name}">
                <div class="row leo-static-group">
                    <div class="static-title col-lg-12"><h4>{l s='Non-Group Top.'}</h4></div>
                    <div class="static-desc col-lg-12"><p>{l s='Columns will be displayed in-line and float on the right with other modules of prestashop.'}</p></div>
                    <div class="static-content col-lg-12">
                        <div class="top-container static-container">
                            {if isset($leo_group_list[$input.name]) && isset($leo_group_list[$input.name]["0"])}
                                {include file='./form_grouplist.tpl' type="0" hook_name=$input.name item_group=$leo_group_list[$input.name]["0"]["0"]}
                            {else}
                                {include file='./form_grouplist.tpl' type="0" hook_name=$input.name}
                            {/if}
                        </div>
                    </div>
                </div>
                <div class="row leo-dm-group">
                    <div class="col-lg-12 dmgroup-container">
                        <div class="group-top row">
                            <div class="col-lg-12"><h4>{l s='GROUP WIDGET FORM.'}</h4>
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-tasks"></i> {l s='Insert A Group'} <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            {for $foo=0 to 6}
                                            <li>
                                                <a href="javascript:void(0);" data-hook="{$input.name}" data-cols="{$foo}" class="leo-add-group">
                                                    {if $foo ==0}
                                                        {l s='Empty Group'}
                                                    {else if $foo==1}
                                                        {l s='%s column' sprintf=$foo}
                                                    {else}
                                                        {l s='%s columns' sprintf=$foo}
                                                    {/if}
                                                </a>
                                            </li>
                                            {/for} 
                                        </ul>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-lg-12"><p>{l s='You can create one or more group then insert one or more widget in it.'}</p></div>
                        </div>
                            
                        <div class="group-content">
                            <div class="group-list" data-hook="{$input.name}">
                                {if isset($leo_group_list[$input.name]) && isset($leo_group_list[$input.name]["1"])}
                                    {foreach $leo_group_list[$input.name]["1"] item=itemGroup}
                                        {include file='./form_grouplist.tpl' type="1" hook_name=$input.name item_group=$itemGroup}
                                    {/foreach}
                                {/if}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row leo-static-group">
                    <div class="static-title col-lg-12"><h4>{l s='Non-Group Bottom.'}</h4></div>
                    <div class="static-desc col-lg-12"><p>{l s='Columns will be displayed in-line and float on the left with other modules of prestashop.'}</p></div>
                    <div class="static-content col-lg-12">
                        <div class="bottom-container static-container">
                            {if isset($leo_group_list[$input.name]) && isset($leo_group_list[$input.name]["2"])}
                                {include file='./form_grouplist.tpl' type="2" hook_name=$input.name item_group=$leo_group_list[$input.name]["2"]["0"]}
                            {else}
                                {include file='./form_grouplist.tpl' type="2" hook_name=$input.name}
                            {/if}
                        </div>
                    </div>
                </div>            
            </div>
        </div>
    {/if}
    
    {if $input.type == 'setting_form'}
        
           
        {*it will show default form or default group + row*}
        <div id="data_form" style="display:none;">
            {*Pop up for group*}
            <div class="group_form bootstrap" data-title="{l s='Group Form'}">
                
                <div class="row form-group">
                <label class="control-label col-lg-3" for="">{l s='Group Title'}</label>
                {foreach from=$languages item=language}
                    {if $languages|count > 1}
                            <div class="translatable-field lang-{$language.id_lang}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
                    {/if}
                            <div class="col-lg-6">
                                    <input id="group_title_{$language.id_lang}" type="text" name="group_title_{$language.id_lang}"/>
                            </div>
                    {if $languages|count > 1}
                            <div class="col-lg-2">
                                    <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                                            {$language.iso_code}
                                            <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                            {foreach from=$languages item=lang}
                                            <li><a href="javascript:hideOtherLanguage({$lang.id_lang});" tabindex="-1">{$lang.name}</a></li>
                                            {/foreach}
                                    </ul>
                            </div>
                    {/if}
                    {if $languages|count > 1}
                            </div>
                    {/if}
                {/foreach}
                </div>
                <div class="row form-group">
                    <label class="control-label col-lg-3" for="">{l s='Group Class'}</label>
                    <div class="col-lg-6">
                        <input type="text" class="" value="" class="group_class" name="group_class">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="control-label col-lg-3" for="">{l s='Background-color'}</label>
                    <div class="col-lg-6">
                        <div class="input-group">
                            <input data-hex="true" class="leo-color" name="group_background" value="" />
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="control-label col-lg-3" for="">{l s='Active'}</label>
                    <div class="col-lg-9">
                        <input class="groupactive_on" type="radio" checked="checked" value="1" name="group_active">
                        <label for="groupactive_on"> {l s='Yes'}</label>
                        <input class="groupactive_off" type="radio" value="0" name="group_active">
                        <label for="groupactive_off"> {l s='No'}</label>
                    </div>
                </div>
                <div class="row">
                    <button name="submitOptionsmodule" class="btn btn-defaults btn-savegroup btn-success" type="button">
                        <i class="icon-save"></i> {l s='Save'}
                    </button>
                </div>
                
            </div>
                
            {*popup for column*}
            <div class="column-form bootstrap" data-title="{l s='Column Form'}">
                <div class="panel">
                    <div class="row">
                        <button name="submitOptionsColumn" data-action="1" class="btn btn-defaults btn-savecolumn btn-success" type="button">
                            <i class="icon-save"></i> {l s='Save'}
                        </button>
                        {*<button name="submitOptionsColumn" class="btn btn-defaults btn-savecolumn btn-success" type="button">
                            <i class="icon-save"></i> {l s='Save and Stay'}
                        </button>*}
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="leo-form">
                                <div class="row">
                                    <label class="control-label col-lg-3" for="">{l s='Column Type:'} <sub class="required">*</sub></label>
                                    <select name="column_type" class="column_type">
                                        <option value="widget">{l s='Widget'}</option>
                                        <option value="module">{l s='Override Module'}</option>
                                    </select>
                                </div>
                                <div class="row column_type_val column_type_widget">
                                    <label class="control-label col-lg-12" for="">{l s='Select a Widget:'} <sub class="required">*</sub></label>

                                    <div class="col-lg-12">
                                        <select name="column_key_widget" data-text="{l s='Please Select a widget'}">
                                        <option value="">{l s='--------- Select a widget ---------'}</option>
                                        {foreach $leo_widgets item=widgetTypeItem key="widgetTypeKey"}
                                            <optgroup label="{$widgetTypeKey}">
                                                {foreach $widgetTypeItem item=widgetItem}
                                                    <option value="{$widgetItem.id}">{$widgetItem.name}</option>
                                                {/foreach}
                                            </optgroup>
                                        {/foreach}
                                        </select>
                                    </div>
                                </div>
                                <div class="row column_type_val column_type_module" style="display: none">
                                    <label class="control-label col-lg-12" for="">{l s='Select a Module:'} <sub class="required">*</sub></label>
                                    <div class="col-lg-12">
                                        <select class= "column_module" name="column_module" data-text="{l s='Please Select a module'}">
					                       <option value="">{l s='--------- Select a Module ---------'}</option>
                                                {foreach $leo_modules item=moduleItem}
                                                    {if $moduleItem.hook_list}
                                                    <option value="{$moduleItem.name}" data-hook={$moduleItem.hook_list}>{$moduleItem.name}</option>
                                                    {/if}
                                                {/foreach}
                                        </select>
                                    </div>
                                </div>
                                <div class="row column_type_val column_type_module" style="display: none">
                                    <label class="control-label col-lg-12" for="">{l s='Select hook of module:'} <sub class="required">*</sub></label>
                                    <div class="col-lg-12">
                                        <select class="list_hook" name="column_module_hook" data-text="{l s='Please Select a hook'}">
                                            <option value="">{l s='--------- Select a Hook ---------'}</option>
                                        </select>
                                            <!-- here -->                                   
                                    </div>
                                </div>
                                <div class="row column_type_val column_type_module" style="display: none">
                                    <div class="col-lg-12 checkbox">
                                    <label class = "control-label">
                                        <input type="checkbox" name="delete_module" value="0">
                                        {l s='Delete module in this hook'}</label>
                                    </div>
                                </div>
                                <div class="alert alert-danger" style="margin-top: 10px">{l s='Please consider using this function. This function is only for advance user, It will load other module and display in column of leomanagewidget. With some module have ID in wrapper DIV, your site will have Javascript Conflicts. We will not support this error'}</div>
                                <div class="row">
                                <hr/>
                                </div>        
                                <div class="row">
                                    <label class="control-label col-lg-3 col-md-3" for="">{l s='Active'}</label>
                                    <input type="radio" class="default-on" checked="checked" value="1" name="column_active">
                                    <label for="columnactive_on"> {l s='Yes'}</label>
                                    <input type="radio" class="default-off" value="0" name="column_active">
                                    <label for="columnactive_off"> {l s='No'}</label>
                                </div>
                                <div class="row">
                                    <label class="control-label col-lg-12" for="">{l s='Large devices Desktops'} <sub class="required">*</sub></label>
                                    <div class="col-lg-12">
                                        <input type='hidden' class="col-val" name='column_lg' value='6'/>
                                        <button type="button" class="btn btn-default leobtn-width dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                                            <span class="leo-width-val">6/12</span><span class="leo-width leo-w-6"> </span><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            {foreach from=$leo_width item=itemWidth}
                                            <li>
                                                <a class="leo-w-option" data-width="{$itemWidth}" href="javascript:void(0);" tabindex="-1">                                          
                                                    <span class="leo-width-val">{$itemWidth}/12</span><span class="leo-width leo-w-{if $itemWidth|strpos:"."}{$itemWidth|replace:'.':'-'}{else}{$itemWidth}{/if}"> </span>
                                                </a>
                                            </li>
                                            {/foreach}
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <p>
                                            {l s='Large devices Desktops (≥1200px)'}
                                            {l s='27in Monitor - 17in Workstation - 15in Macbook Pro - 11in Macbook Air'}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="control-label col-lg-12" for="">{l s='Medium devices Desktops'} <sub class="required">*</sub></label>
                                    <div class="col-lg-12">
                                        <input type='hidden' class="col-val" name='column_md' value='6'/>
                                        <button type="button" class="btn btn-default leobtn-width dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                                            <span class="leo-width-val">6/12</span><span class="leo-width leo-w-6"> </span><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            {foreach from=$leo_width item=itemWidth}
                                            <li>
                                                <a class="leo-w-option" data-width="{$itemWidth}" href="javascript:void(0);" tabindex="-1">                                          
                                                    <span class="leo-width-val">{$itemWidth}/12</span><span class="leo-width leo-w-{if $itemWidth|strpos:"."}{$itemWidth|replace:'.':'-'}{else}{$itemWidth}{/if}"> </span>
                                                </a>
                                            </li>
                                            {/foreach}
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <p>
                                            {l s='Medium devices Desktops (≥992px)'}
                                            {l s='Nexus7 (Landscape) - iPad (Portrait)'}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="control-label col-lg-12" for="">{l s='Small devices Tablets'} <sub class="required">*</sub></label>
                                    <div class="col-lg-12">
                                        <input type='hidden' class="col-val" data-width="{$itemWidth}" name='column_sm' value='6'/>
                                        <button type="button" class="btn btn-default leobtn-width dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                                            <span class="leo-width-val">6/12</span><span class="leo-width leo-w-6"> </span><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            {foreach from=$leo_width item=itemWidth}
                                            <li>
                                                <a class="leo-w-option" data-width="{$itemWidth}" href="javascript:void(0);" tabindex="-1">                                          
                                                    <span class="leo-width-val">{$itemWidth}/12</span><span class="leo-width leo-w-{if $itemWidth|strpos:"."}{$itemWidth|replace:'.':'-'}{else}{$itemWidth}{/if}"> </span>
                                                </a>
                                            </li>
                                            {/foreach}
                                        </ul>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <p>
                                            {l s='Small devices Tablets (≥768px)'}
                                            {l s='iPad (Landscape)'}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="control-label col-lg-12" for="">{l s='Extra small devices'} <sub class="required">*</sub></label>
                                    <div class="col-lg-12">
                                        <input type='hidden' class="col-val" data-width="{$itemWidth}" name='column_xs' value='6'/>
                                        <button type="button" class="btn btn-default leobtn-width dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                                            <span class="leo-width-val">6/12</span><span class="leo-width leo-w-6"> </span><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            {foreach from=$leo_width item=itemWidth}
                                            <li>
                                                <a class="leo-w-option" data-width="{$itemWidth}" href="javascript:void(0);" tabindex="-1">                                          
                                                    <span class="leo-width-val">{$itemWidth}/12</span><span class="leo-width leo-w-{if $itemWidth|strpos:"."}{$itemWidth|replace:'.':'-'}{else}{$itemWidth}{/if}"> </span>
                                                </a>
                                            </li>
                                            {/foreach}
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <p>
                                            {l s='Extra small devices Phones (≥481px)'}
                                            {l s='Nexus7 (Portrait)'}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="control-label col-lg-12" for="">{l s='Smart Phone'} <sub class="required">*</sub></label>
                                    <div class="col-lg-12">
                                        <input type='hidden' class="col-val" name='column_sp' value='6'/>
                                        <button type="button" class="btn btn-default leobtn-width dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                                            <span class="leo-width-val">12/12</span><span class="leo-width leo-w-12"> </span><span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            {foreach from=$leo_width item=itemWidth}
                                            <li>
                                                <a class="leo-w-option" data-width="{$itemWidth}" href="javascript:void(0);" tabindex="-1">                                          
                                                    <span class="leo-width-val">{$itemWidth}/12</span><span class="leo-width leo-w-{if $itemWidth|strpos:"."}{$itemWidth|replace:'.':'-'}{else}{$itemWidth}{/if}"> </span>
                                                </a>
                                            </li>
                                            {/foreach}
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <p>
                                            {l s='Smart Phones (<481px)'}
                                            {l s='iPhone (Landscape)-iPhone (Portrait)'}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="control-label col-lg-12" for="">{l s='Background-color:'}</label>
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <input type="text" data-hex="true" class="leo-color" value="" class="column_background" name="column_background"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row"><label class="control-label col-lg-4" for="">{l s='Column Class:'}</label></row></div>
                            <div class="well">
                                <p> 
                                    <input type="text" class="" value="" class="column_class" name="column_class"/><br />
                                    {l s='insert new or select classes for toggling content across viewport breakpoints'}<br />
                                    <ul class="leo-col-class">
                                        {foreach from=$hidden_config key=keyHidden item=itemHidden}
                                        <li>
                                            <input type="checkbox" name="col_{$keyHidden}" value="1">
                                            <label class="choise-class">{$itemHidden}</label>
                                        </li>
                                        {/foreach}
                                    </ul>
                                </p>
                            </div>
                        </div>
                                    
                        <div class="col-lg-12">
                            <div class="row"><label class="control-label col-lg-4 " for="">{l s='Exceptions Page:'}</label></div>
                            <div class="well">
                                <p>
                                    {l s='Please specify the files for which you do not want the widget to be displayed.'}<br />
                                    {$exception_list}
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <button name="submitOptionsColumn" data-action="1" class="btn btn-defaults btn-savecolumn btn-success" type="button">
                            <i class="icon-save"></i> {l s='Save'}
                        </button>
                        {*<button name="submitOptionsColumn" class="btn btn-defaults btn-savecolumn btn-success" type="button">
                            <i class="icon-save"></i> {l s='Save and Stay'}
                        </button>*}
                    </div>
                </div>
            </div>                       
                                    
            {*Default Column*}
            <div id="default_column" class="column-row">
                <div class="leo-column unset-widget">
                    <div class="leo-action-top">
                        <a class="width-action" href="#" data-action="-1"><i class="icon-minus-sign-alt"></i></a>
                        <button type="button" class="leo-cog dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                            <div class="width-val"></div><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right">
                            {foreach from=$leo_width item=itemWidth}
                            <li>
                                <a class="leo-change-width" data-width="{$itemWidth}" href="javascript:void(0);" tabindex="-1">                                          
                                    <span class="leo-width-val">{$itemWidth}/12</span>
                                </a>
                            </li>
                            {/foreach}
                        </ul>
                        <a class="width-action" href="#" data-action="1"><i class="icon-plus-sign-alt"></i></a>
                    </div>
                    <span class="leo-column_title"><a class="leo-disable leo-edit-column" href="javascript:void(0)">{l s='Click to assign a widget or module'}</a></span>
                    <div class="leo-column-action">
                        <a title="{l s='Click here to change column status'}" class="leo-column-status label-tooltip" data-value="1">
                            <img src="{$img_admin_url}enabled.gif" alt="" />
                        </a>
                        <div class="btn-group" title="{l s='Click to edit column configuration, edit widget or remove this column'}">
                            <button class="leo-cog dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="icon-cog"></i><span class="caret"></span></span>
                            </button>
                            <ul class="dropdown-menu">
                              <li><a class="btn leo-edit-column" href="javascript:void(0)"><i class="icon-columns"></i> {l s='Column Configuration'}</a></li>
                              <li class="divider"></li>
                              <li><a class="btn leo-edit-widget" data-for="widget" href="javascript:void(0);"><i class="icon-cog"></i> {l s='Widget or Module Configuration'}</a></li>
                              <li class="divider"></li>
                              <li><a style="color:#fff" class="btn leo-delete-column btn-danger" data-confirm="{l s='Are you sure you want to delete this column?'}" data-for="delete" href="javascript:void(0)"><i class="icon-remove-sign"></i> {l s='Delete'}</a></li>
                            </ul>
                       </div>

                    </div>
                </div>
            </div>
            
            {*Default group*}
            <div id="default_group" class="row group-row label-tooltip" data-original-title="{l s='You can drag this group to other hook'}" data-type="1">
                <div class="group-panel col-lg-12">
                    <div class="pull-left">
                        <a title="{l s='Click here to change group status'}" class="leo-group-status label-tooltip" data-value="1">
                            <img src="{$img_admin_url}enabled.gif" alt="" />
                        </a>
                        <a class="leo-group-btn leo-edit-group label-tooltip" data-original-title="{l s='Click here to Edit group'}">
                            <i class="icon-edit"></i>
                        </a>
                        <a style="color:#D9534F" class="leo-group-btn leo-remove-group label-tooltip" data-confirm="{l s='Are you sure you want to delete this group?'}" data-original-title="{l s='Click here to delete group'}" href="javascript:void(0)"><i class="icon-remove-sign"></i></a>
                    </div>
                    <div class="pull-right">
                        <button type="button" class="btn btn-default leobtn-width dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                            <i class="icon-columns"></i> {l s='Insert A Column'} <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            {foreach from=$leo_width item=itemWidth}
                            <li>
                                <a class="leo-add-column" data-width="{$itemWidth}" href="javascript:void(0);" tabindex="-1">                                          
                                    <span class="leo-width-val">{$itemWidth}/12</span><span class="leo-width leo-w-{if $itemWidth|strpos:"."}{$itemWidth|replace:'.':'-'}{else}{$itemWidth}{/if}"> </span>
                                </a>
                            </li>
                            {/foreach}
                        </ul>
                    </div>
                </div>
                <div class="column-list col-lg-12"></div>
            </div>
            <script type="text/javascript">
                $(document).ready(function(){
                    var $leoManage = $(document).leomanagewidgets();
                    $leoManage.groupField = {$leo_groupField};
                    $leoManage.columnField = {$leo_columnField};
                    $leoManage.setData('{$leo_json_data}');
                    $leoManage.submitLink = '{$leo_submit_link}';
                    $leoManage.widgetLink = '{$widget_link}&addleowidgets&type=popup';
                    $leoManage.moduleLink = '{$module_link}';
                });
            </script>
        </div>
    {/if}
    {$smarty.block.parent}
{/block}