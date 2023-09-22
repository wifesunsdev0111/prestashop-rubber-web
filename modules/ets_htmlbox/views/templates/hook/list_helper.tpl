{*
* Copyright ETS Software Technology Co., Ltd
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future.
 *
 * @author ETS Software Technology Co., Ltd
 * @copyright  ETS Software Technology Co., Ltd
 * @license    Valid for 1 website (or project) for each purchase of license
*}
<script type="text/javascript">
var text_update_position='{l s='Successfully updated' mod='ets_htmlbox' js=1}';
</script>
<div class="panel ets_htmlbox-panel{if isset($class)} {$class|escape:'html':'UTF-8'}{/if}">
    <div class="panel-heading">{*if isset($icon) && $icon}<i class="{$icon|escape:'html':'UTF-8'}"></i>&nbsp;{/if*}{$title nofilter}
        {if isset($totalRecords) && $totalRecords>0}<span class="badge">{$totalRecords|intval}</span>{/if}
        <span class="panel-heading-action">
            {if isset($show_add_new) && $show_add_new}            
                <a class="btn btn-default add_new_link" href="{if isset($link_new)}{$link_new|escape:'html':'UTF-8'}{else}{$currentIndex|escape:'html':'UTF-8'}{/if}">  
        		     <i class="ets_icon">
                            <svg width="14" height="14" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1600 736v192q0 40-28 68t-68 28h-416v416q0 40-28 68t-68 28h-192q-40 0-68-28t-28-68v-416h-416q-40 0-68-28t-28-68v-192q0-40 28-68t68-28h416v-416q0-40 28-68t68-28h192q40 0 68 28t28 68v416h416q40 0 68 28t28 68z"/></svg>
                        </i> {if isset($add_new_text)}{$add_new_text|escape:'html':'UTF-8'}{else} {l s='Add new' mod='ets_htmlbox'}{/if}
                </a>            
            {/if}
        </span>
    </div>
    {if $fields_list}
        <div class="table-responsive clearfix">
            <form method="post" action="{if isset($postIndex)}{$postIndex|escape:'html':'UTF-8'}{else}{$currentIndex|escape:'html':'UTF-8'}{/if}">
                {if isset($bulk_action_html)}
                    {$bulk_action_html nofilter}
                {/if}
                <table class="table configuration list-{$name|escape:'html':'UTF-8'}">
                    <thead>
                        <tr class="nodrag nodrop">
                            {assign var ='i' value=1}
                            {foreach from=$fields_list item='field' key='index'}
                                <th class="{$index|escape:'html':'UTF-8'}{if isset($field.class)} {$field.class|escape:'html':'UTF-8'}{/if}" {if $show_action && !$actions && count($fields_list)==$i}colspan="2"{/if}>
                                    <span class="title_box">
                                        {$field.title|escape:'html':'UTF-8'}
                                        {if isset($field.sort) && $field.sort}
                                            <span class="soft">
                                            <a href="{$currentIndex|escape:'html':'UTF-8'}&sort={$index|escape:'html':'UTF-8'}&sort_type=desc{$filter_params nofilter}" {if isset($sort)&& $sort==$index && isset($sort_type) && $sort_type=='desc'} class="active"{/if}><i class="icon-caret-down"></i></a>
                                            <a href="{$currentIndex|escape:'html':'UTF-8'}&sort={$index|escape:'html':'UTF-8'}&sort_type=asc{$filter_params nofilter}" {if isset($sort)&& $sort==$index && isset($sort_type) && $sort_type=='asc'} class="active"{/if}><i class="icon-caret-up"></i></a>
                                            </span>
                                         {/if}
                                    </span>
                                </th>  
                                {assign var ='i' value=$i+1}                          
                            {/foreach}
                            {if $show_action && $actions}
                                <th class="table_action" style="text-align: right;">{l s='Action' mod='ets_htmlbox'}</th>
                            {/if}
                        </tr>
                        {if $show_toolbar}
                            <tr class="nodrag nodrop filter row_hover">
                                {foreach from=$fields_list item='field' key='index'}
                                    <th class="{$index|escape:'html':'UTF-8'}{if isset($field.class)} {$field.class|escape:'html':'UTF-8'}{/if}">
                                        {if isset($field.filter) && $field.filter}
                                            {if $field.type=='text'}
                                                <input class="filter" name="{$index|escape:'html':'UTF-8'}" type="text" {if isset($field.width)}style="width: {$field.width|intval}px;"{/if} {if isset($field.active)}value="{$field.active|escape:'html':'UTF-8'}"{/if}/>
                                            {/if}
                                            {if $field.type=='select' || $field.type=='active'}
                                                <select  {if isset($field.width)}style="width: {$field.width|intval}px;"{/if}  name="{$index|escape:'html':'UTF-8'}">
                                                    <option value=""> -- </option>
                                                    {if isset($field.filter_list.list) && $field.filter_list.list}
                                                        {assign var='id_option' value=$field.filter_list.id_option}
                                                        {assign var='value' value=$field.filter_list.value}
                                                        {foreach from=$field.filter_list.list item='option'}
                                                            <option {if ($field.active!=='' && $field.active==$option.$id_option) || ($field.active=='' && $index=='has_post' && $option.$id_option==1 )} selected="selected"{/if} value="{$option.$id_option|escape:'html':'UTF-8'}">{$option.$value|escape:'html':'UTF-8'}</option>
                                                        {/foreach}
                                                    {/if}
                                                </select>                                            
                                            {/if}
                                            {if $field.type=='int'}
                                                <label for="{$index|escape:'html':'UTF-8'}_min"><input type="text" placeholder="{l s='Min' mod='ets_htmlbox'}" name="{$index|escape:'html':'UTF-8'}_min" value="{$field.active.min|escape:'html':'UTF-8'}" /></label>
                                                <label for="{$index|escape:'html':'UTF-8'}_max"><input type="text" placeholder="{l s='Max' mod='ets_htmlbox'}" name="{$index|escape:'html':'UTF-8'}_max" value="{$field.active.max|escape:'html':'UTF-8'}" /></label>
                                            {/if}
                                            {if $field.type=='date'}
                                                <fieldset class="form-group"> 
                                                    <div class="input-group ets_htmlbox_datepicker">
                                                        <input id="{$index|escape:'html':'UTF-8'}_min" autocomplete="off" class="form-control" name="{$index|escape:'html':'UTF-8'}_min" placeholder="{l s='From' mod='ets_htmlbox'}" value="{$field.active.min|escape:'html':'UTF-8'}" type="text" autocomplete="off" />
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <i class="icon icon-date"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="form-group"> 
                                                    <div class="input-group ets_htmlbox_datepicker">
                                                        <input id="{$index|escape:'html':'UTF-8'}_max" autocomplete="off" class="form-control" name="{$index|escape:'html':'UTF-8'}_max" placeholder="{l s='To' mod='ets_htmlbox'}" value="{$field.active.max|escape:'html':'UTF-8'}" type="text" autocomplete="off" />
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <i class="icon icon-date"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            {/if}
                                        {elseif ( ($name == 'mp_front_products' || $name == 'mp_products') && $field.type == 'text' && isset($index) && $index == 'input_box') }
                                            <div class="md-checkbox">
                                                <label>
                                                  <input id="bulk_action_select_all" onclick="$('table').find('td input:checkbox').prop('checked', $(this).prop('checked')); ets_htmlbox_updateBulkMenu();" value="" type="checkbox" />
                                                  <i class="md-checkbox-control"></i>
                                                </label>
                                            </div>
                                        {elseif ( $field.type == 'text' && isset($index) && $index == 'input_box') }
                                            <div class="md-checkbox">
                                                <label>
                                                  <input id="bulk_action_select_all" onclick="$('table').find('td input:checkbox').prop('checked', $(this).prop('checked')); ets_htmlbox_updateBulkMenu();" value="" type="checkbox" />
                                                  <i class="md-checkbox-control"></i>
                                                </label>
                                            </div>
                                        {else}
                                           {l s=' -- ' mod='ets_htmlbox'}
                                        {/if}
                                    </th>
                                {/foreach}
                                {if $show_action}
                                    <th class="actions">
                                        <span class="pull-right flex">
                                            <input type="hidden" name="post_filter" value="yes" />
                                            {if $show_reset}<a  class="btn btn-warning"  href="{$currentIndex|escape:'html':'UTF-8'}"><i class="icon-eraser"></i> {l s='Reset' mod='ets_htmlbox'}</a> &nbsp;{/if}
                                            <button class="btn btn-default" name="ets_htmlbox_submit_{$name|escape:'html':'UTF-8'}" id="ets_htmlbox_submit_{$name|escape:'html':'UTF-8'}" type="submit">
            									<i class="icon-search"></i> {l s='Filter' mod='ets_htmlbox'}
            								</button>
                                        </span>
                                    </th>
                                {/if}
                            </tr>
                        {/if}
                    </thead>
                    <tbody id="list-{$name|escape:'html':'UTF-8'}">
                        {if $field_values}
                        {foreach from=$field_values item='row'}
                            <tr {if isset($row.read) && !$row.read}class="no-read"{/if} data-id="{$row.$identifier|intval}">
                                {assign var='i' value=1}
                                {foreach from=$fields_list item='field' key='key'}                             
                                    <td class="{$key|escape:'html':'UTF-8'} {if isset($sort)&& $sort==$key && isset($sort_type) && $sort_type=='asc' && isset($field.update_position) && $field.update_position}pointer dragHandle center{/if}{if isset($field.class)} {$field.class|escape:'html':'UTF-8'}{/if}" {if $show_action && !$actions && count($fields_list)==$i}colspan="2"{/if} >
                                        {if isset($field.rating_field) && $field.rating_field}
                                            {if isset($row.$key) && $row.$key > 0}
                                                {for $i=1 to (int)$row.$key}
                                                    <div class="star star_on"></div>
                                                {/for}
                                                {if (int)$row.$key < 5}
                                                    {for $i=(int)$row.$key+1 to 5}
                                                        <div class="star"></div>
                                                    {/for}
                                                {/if}
                                            {else}
                                            
                                                {l s=' -- ' mod='ets_htmlbox'}
                                            {/if}
                                        {elseif $field.type != 'active'}
                                            {if $field.type=='date'}
                                                {if !$row.$key}
                                                --
                                                {else}
                                                    {if $key!='date_from' && $key!='date_to'}
                                                        {dateFormat date=$row.$key full=1}
                                                    {else}
                                                        {dateFormat date=$row.$key full=0}
                                                    {/if}
                                                {/if}
                                            {elseif $field.type=='checkbox'}
                                                <input type="checkbox" name="{$name|escape:'html':'UTF-8'}_boxs[]" value="{$row.$identifier|escape:'html':'UTF-8'}" class="{$name|escape:'html':'UTF-8'}_boxs" />
                                            {elseif $field.type=='input_number'}
                                                {assign var='field_input' value=$field.field}
                                                <div class="qty edit_quantity" data-v-599c0dc5="">
                                                    <div class="ps-number edit-qty hover-buttons" data-{$identifier|escape:'html':'UTF-8'}="{$row.$identifier|escape:'html':'UTF-8'}">
                                                        <input class="form-control {$name|escape:'html':'UTF-8'}_{$field_input|escape:'html':'UTF-8'}" type="number" name="{$name|escape:'html':'UTF-8'}_{$field_input|escape:'html':'UTF-8'}[{$row.$identifier|escape:'html':'UTF-8'}]" value="" placeholder="0" />
                                                        <div class="ps-number-spinner d-flex">
                                                            <span class="ps-number-up"></span>
                                                            <span class="ps-number-down"></span>
                                                        </div>
                                                    </div>
                                                    <button class="check-button" disabled="disabled"><i class="fa fa-check icon-check"></i></button>
                                                </div>
                                            {else}
                                                {if isset($field.update_position) && $field.update_position}
                                                    <div class="dragGroup">
                                                    <span class="positions">
                                                {/if}
                                                {if isset($row.$key) && $row.$key!=='' && !is_array($row.$key)}{if isset($field.strip_tag) && !$field.strip_tag}{$row.$key nofilter}{else}{$row.$key|strip_tags:'UTF-8'|truncate:120:'...'|escape:'html':'UTF-8'}{/if}{else}--{/if}
                                                {if isset($row.$key) && is_array($row.$key) && isset($row.$key.image_field) && $row.$key.image_field}
                                                    <a class="ets_htmlbox_fancy" href="{$row.$key.img_url|escape:'html':'UTF-8'}"><img style="{if isset($row.$key.height) && $row.$key.height}max-height: {$row.$key.height|intval}px;{/if}{if isset($row.$key.width) && $row.$key.width}max-width: {$row.$key.width|intval}px;{/if}" src="{$row.$key.img_url|escape:'html':'UTF-8'}" /></a>
                                                {/if} 
                                                {if isset($field.update_position) && $field.update_position}
                                                    </div>
                                                    </span>
                                                {/if}  
                                            {/if}                                     
                                        {else}
                                            {if isset($row.$key) && $row.$key}
                                                {if (!isset($row.action_edit) || $row.action_edit)}
                                                    <a name="{$name|escape:'html':'UTF-8'}"  href="{$currentIndex|escape:'html':'UTF-8'}&{$identifier|escape:'html':'UTF-8'}={$row.$identifier|escape:'html':'UTF-8'}&change_enabled=0&field={$key|escape:'html':'UTF-8'}" class="list-action field-{$key|escape:'html':'UTF-8'} list-action-enable action-enabled list-item-{$row.$identifier|escape:'html':'UTF-8'}" data-id="{$row.$identifier|escape:'html':'UTF-8'}" title="{if $key=='reported'}{l s='Click to unreport' mod='ets_htmlbox'}{else}{l s='Click to disable' mod='ets_htmlbox'}{/if}">
                                                        <i class="icon icon-check fa fa-check"></i>
                                                    </a>
                                                {else}
                                                    <span class="list-action-enable action-enabled" title="{l s='Enabled' mod='ets_htmlbox'}">
                                                        <i class="icon icon-check fa fa-check"></i>
                                                    </span>
                                                {/if}
                                            {else}
                                                {if (!isset($row.action_edit) || $row.action_edit)}
                                                    <a name="{$name|escape:'html':'UTF-8'}" href="{$currentIndex|escape:'html':'UTF-8'}&{$identifier|escape:'html':'UTF-8'}={$row.$identifier|escape:'html':'UTF-8'}&change_enabled=1&field={$key|escape:'html':'UTF-8'}" class="list-action field-{$key|escape:'html':'UTF-8'} list-action-enable action-disabled  list-item-{$row.$identifier|escape:'html':'UTF-8'}" data-id="{$row.$identifier|escape:'html':'UTF-8'}" title="{if $key=='reported'}{l s='Click to mark as reported' mod='ets_htmlbox'}{else}{l s='Click to enable' mod='ets_htmlbox'}{/if}">
                                                        <i class="icon icon-remove fa fa-remove"></i>
                                                    </a>
                                                {else}
                                                    <span class="list-action-enable action-disabled" title="{l s='Disabled' mod='ets_htmlbox'}">
                                                        <i class="icon icon-remove fa fa-remove"></i>
                                                    </span>
                                                {/if}
                                            {/if}
                                        {/if}
                                    </td>
                                    {assign var='i' value=$i+1}
                                {/foreach}
                                {if $show_action}
                                    {if $actions}  
                                        <td class="text-right">                            
                                            <div class="btn-group-action">
                                                <div class="btn-group pull-right">
                                                        {if $actions[0]=='view'}
                                                            {if isset($row.child_view_url) && $row.child_view_url}
                                                                <a class="btn btn-default link_view" href="{$row.child_view_url|escape:'html':'UTF-8'}" {if isset($view_new_tab) && $view_new_tab} target="_blank" {/if}><i class="icon-search-plus fa fa-search-plus"></i> {l s='View' mod='ets_htmlbox'}</a>
                                                            {elseif !isset($row.action_edit) || $row.action_edit}
                                                                <a class="btn btn-default link_edit" href="{$currentIndex|escape:'html':'UTF-8'}&edit{$name|escape:'html':'UTF-8'}=1&{$identifier|escape:'html':'UTF-8'}={$row.$identifier|escape:'html':'UTF-8'}" ><i class="icon icon-pencil fa fa-pencil"></i> {l s='Edit' mod='ets_htmlbox'}</a>
                                                            {/if}
                                                        {/if}
                                                        {if $actions[0]=='delete'}
                                                            <a class="btn btn-default" onclick="return confirm('{l s='Do you want to delete this item?' mod='ets_htmlbox' js=1}');" href="{$currentIndex|escape:'html':'UTF-8'}&{$identifier|escape:'html':'UTF-8'}={$row.$identifier|escape:'html':'UTF-8'}&del=yes"><i class="icon icon-trash fa fa-trash"></i> {l s='Delete' mod='ets_htmlbox'}</a>
                                                        {/if}
                                                        {if $actions[0]=='send_mail'}
                                                            <a class="btn btn-default btn-send-mail" href="{$currentIndex|escape:'html':'UTF-8'}&{$identifier|escape:'html':'UTF-8'}={$row.$identifier|escape:'html':'UTF-8'}&submitSendMail=1"><i class="icon icon-envelope fa fa-envelope"></i> {l s='Send mail' mod='ets_htmlbox'}</a>
                                                        {/if}
                                                        {if $actions|count >=2 && (!isset($row.action_edit) || $row.action_edit || in_array('action',$actions) || (isset($row.action_delete) &&$row.action_delete) )}
                                                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">
                                        						<i class="icon-caret-down"></i>&nbsp;
                                        					</button>
                                                            <ul class="dropdown-menu">
                                                                {foreach from=$actions item='action' key='key'}
                                                                    {if $key!=0}
                                                                        {if $action=='delete' && (!isset($row.view_order_url) || (isset($row.view_order_url) && !$row.view_order_url) )}
                                                                            <li><a class="btn btn-default" onclick="return confirm('{l s='Do you want to delete this item?' mod='ets_htmlbox' js=1}');" href="{$currentIndex|escape:'html':'UTF-8'}&{$identifier|escape:'html':'UTF-8'}={$row.$identifier|escape:'html':'UTF-8'}&del=yes{if isset($row.type)}&type={$row.type|escape:'html':'UTF-8'}{/if}"><i class="fa fa-trash icon icon-trash"></i> {l s='Delete' mod='ets_htmlbox'}</a></li>
                                                                        {/if}
                                                                        
                                                                        {if $action=='delete_all'}
                                                                            <li><a class="btn btn-default" onclick="return confirm('{l s='Do you want to delete this shop and all of its data?' mod='ets_htmlbox' js=1}');" href="{$currentIndex|escape:'html':'UTF-8'}&{$identifier|escape:'html':'UTF-8'}={$row.$identifier|escape:'html':'UTF-8'}&delall=yes{if isset($row.type)}&type={$row.type|escape:'html':'UTF-8'}{/if}"><i class="fa fa-trash icon icon-trash"></i> {l s='Delete all' mod='ets_htmlbox'}</a></li>
                                                                        {/if}
                                                                        {if $action=='view'}
                                                                            {if isset($row.child_view_url) && $row.child_view_url}
                                                                                <li><a class="btn btn-default" href="{$row.child_view_url|escape:'html':'UTF-8'}"><i class="fa fa-search-plus icon icon-search-plus"></i> {l s='View' mod='ets_htmlbox'}</a></li>
                                                                            {else}
                                                                                <li><a class="btn btn-default" href="{$currentIndex|escape:'html':'UTF-8'}&{$identifier|escape:'html':'UTF-8'}={$row.$identifier|escape:'html':'UTF-8'}"><i class="fa fa-pencil icon icon-pencil"></i> {l s='Edit' mod='ets_htmlbox'}</a></li>
                                                                            {/if}
                                                                        {/if}
                                                                        {if $action =='edit'}
                                                                            <li><a class="btn btn-default" href="{$currentIndex|escape:'html':'UTF-8'}&edit{$name|escape:'html':'UTF-8'}=1&{$identifier|escape:'html':'UTF-8'}={$row.$identifier|escape:'html':'UTF-8'}"><i class="fa fa-pencil icon icon-pencil"></i> {l s='Edit' mod='ets_htmlbox'}</a></li>
                                                                        {/if}
                                                                    {/if}
                                                                {/foreach}
                                                            </ul>
                                                        {/if}
                                                </div>
                                            </div>
                                        </td>
                                    {/if}
                                {/if}
                            </tr>
                        {/foreach}  
                        {/if}  
                        {if !$field_values}
                           <tr class="no-record not_items_found list-empty">
                               <td colspan="100%">
                                   <p class="list-empty-msg">
                                       <i class="icon-warning-sign list-empty-icon"></i>
                                       {l s='No items found' mod='ets_htmlbox'}</p>
                               </td>
                           </tr>
                        {/if}                
                    </tbody>
                </table>
                {if isset($show_bulk_action) && $show_bulk_action}
                    <div id="catalog-actions" class="col order-first">
                        <div class="row">
                            <div class="col">
                                <div class="d-inline-block hide">
                                    <div class="btn-group dropdown bulk-catalog">
                                        <button id="product_bulk_menu" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="true" style="color:black;">
                                            {l s='Bulk actions' mod='ets_htmlbox'}
                                            <i class="icon-caret-up"></i>
                                        </button>
                                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 35px, 0px); top: 0px; left: 0px; will-change: transform;">
                                            <div class="dropdown-divider"></div>
                                            <button class="dropdown-item" name="submitBulkEnable" type="submit" style="border:none;background:none">
                                                <i class="icon-power-off text-success"></i>
                                                {l s='Enable selection' mod='ets_htmlbox'}
                                            </button>
                                            <button class="dropdown-item" name="submitBulkDisable" type="submit" style="border:none;background:none">
                                                <i class="icon-power-off text-danger"></i>
                                                {l s='Disable selection ' mod='ets_htmlbox'}
                                            </button>
                                            <button class="dropdown-item" name="submitBulkDelete" type="submit" style="border:none;background:none" onclick="return confirm('{l s='Do you want to delete selected item?' mod='ets_htmlbox' js=1}');">
                                                <i class="icon-trash-o" aria-hidden="true"></i>
                                                {l s='Delete selected' mod='ets_htmlbox'}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {/if}
                {if $paggination}
                    <div class="ets_htmlbox_paggination" style="margin-top: 10px;">
                        {$paggination nofilter}
                    </div>
                {/if}
            </form>
        </div>
    {/if}
</div>
<script type="text/javascript">
    function ets_htmlbox_updateBulkMenu()
    {
        $('tbody input[type="checkbox"]').parent().removeClass('checked');
        $('tbody input[type="checkbox"]:checked').parent().addClass('checked');
        if($('tbody input[type="checkbox"]:checked').length) {
            $('#product_bulk_menu').removeAttr('disabled').parents('.d-inline-block').removeClass('hide');
        } else {
            $('#product_bulk_menu').attr('disabled','disabled').parents('.d-inline-block').addClass('hide');
        }
    }
    $(document).ready(function(){
       $(document).on('click','tbody input[type="checkbox"]',function(){
            ets_htmlbox_updateBulkMenu();
        }); 
    });
$(document).on('change','.paginator_select_limit',function(e){
    $(this).parents('form').submit();
});
</script>