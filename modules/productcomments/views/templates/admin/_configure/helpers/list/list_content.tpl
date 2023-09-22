<tbody>
{if count($list)}
    {foreach $list AS $index => $tr}
        <tr{if $position_identifier} id="tr_{$position_group_identifier}_{$tr.$identifier}_{if isset($tr.position['position'])}{$tr.position['position']}{else}0{/if}"{/if} class="{if isset($tr.class)}{$tr.class}{/if} {if $tr@iteration is odd by 1}odd{/if}"{if isset($tr.color) && $color_on_bg} style="background-color: {$tr.color}"{/if} >
            {if $bulk_actions && $has_bulk_actions}
                <td class="row-selector text-center">
                    {if isset($list_skip_actions.delete)}
                        {if !in_array($tr.$identifier, $list_skip_actions.delete)}
                            <input type="checkbox" name="{$list_id}Box[]" value="{$tr.$identifier}"{if isset($checked_boxes) && is_array($checked_boxes) && in_array({$tr.$identifier}, $checked_boxes)} checked="checked"{/if} class="noborder"/>
                        {/if}
                    {else}
                        <input type="checkbox" name="{$list_id}Box[]" value="{$tr.$identifier}"{if isset($checked_boxes) && is_array($checked_boxes) && in_array({$tr.$identifier}, $checked_boxes)} checked="checked"{/if} class="noborder"/>
                    {/if}
                </td>
            {/if}
            {foreach $fields_display AS $key => $params}
                {block name="open_td"}
                    <td
                    {if isset($params.position)}
                        id="td_{if !empty($position_group_identifier)}{$position_group_identifier}{else}0{/if}_{$tr.$identifier}{if $smarty.capture.tr_count > 1}_{($smarty.capture.tr_count - 1)|intval}{/if}"
                    {/if}
                    class="{strip}{if !$no_link}pointer{/if}
					{if isset($params.position) && $order_by == 'position'  && $order_way != 'DESC'} dragHandle{/if}
					{if isset($params.class)} {$params.class}{/if}
					{if isset($params.align)} {$params.align}{/if}{/strip}"
                    {if (!isset($params.position) && !$no_link && !isset($params.remove_onclick))}
                        onclick="document.location = '{$current_index|escape:'html':'UTF-8'}&amp;{$identifier|escape:'html':'UTF-8'}={$tr.$identifier|escape:'html':'UTF-8'}{if $view}&amp;view{else}&amp;update{/if}{$table|escape:'html':'UTF-8'}{if $page > 1}&amp;page={$page|intval}{/if}&amp;token={$token|escape:'html':'UTF-8'}'">
                    {else}
                        >
                    {/if}
                {/block}
                {block name="td_content"}
                    {if isset($params.prefix)}{$params.prefix}{/if}
                    {if isset($params.badge_success) && $params.badge_success && isset($tr.badge_success) && $tr.badge_success == $params.badge_success}<span class="badge badge-success">{/if}
                {if isset($params.badge_warning) && $params.badge_warning && isset($tr.badge_warning) && $tr.badge_warning == $params.badge_warning}<span class="badge badge-warning">{/if}
                {if isset($params.badge_danger) && $params.badge_danger && isset($tr.badge_danger) && $tr.badge_danger == $params.badge_danger}<span class="badge badge-danger">{/if}
                {if isset($params.color) && isset($tr[$params.color])}
                    <span class="label color_field" style="background-color:{$tr[$params.color]};color:{if Tools::getBrightness($tr[$params.color]) < 128}white{else}#383838{/if}">
                {/if}
                    {if isset($tr.$key)}
                        {if isset($params.active)}
                            {$tr.$key}
                        {elseif isset($params.callback)}
                            {if isset($params.maxlength) && Tools::strlen($tr.$key) > $params.maxlength}
                                <span title="{$tr.$key}">{$tr.$key|truncate:$params.maxlength:'...'}</span>
                            {else}
                                {$tr.$key}
                            {/if}
					{elseif isset($params.activeVisu)}
						{if $tr.$key}
                            <i class="icon-check-ok"></i>



{l s='Enabled' d='Admin.Global'}
						{else}




                            <i class="icon-remove"></i>
                            {l s='Disabled' d='Admin.Global'}
                        {/if}
					{elseif isset($params.position)}
						{if !$filters_has_value && $order_by == 'position' && $order_way != 'DESC'}
                            <div class="dragGroup">
								<div class="positions">
									{$tr.$key.position + 1}
								</div>
							</div>
                        {else}
                            {$tr.$key.position + 1}
                        {/if}
					{elseif isset($params.image)}
						{$tr.$key}
					{elseif isset($params.icon)}
						{if is_array($tr[$key])}
                            {if isset($tr[$key]['class'])}
                                <i class="{$tr[$key]['class']}"></i>




{else}




                                <img src="../img/admin/{$tr[$key]['src']}" alt="{$tr[$key]['alt']}" title="{$tr[$key]['alt']}"/>
                            {/if}
                        {/if}
					{elseif isset($params.type) && $params.type == 'price'}
						{displayPrice price=$tr.$key}
					{elseif isset($params.float)}
						{$tr.$key}
					{elseif isset($params.type) && $params.type == 'date'}
						{dateFormat date=$tr.$key full=0}
					{elseif isset($params.type) && $params.type == 'datetime'}
						{dateFormat date=$tr.$key full=1}
					{elseif isset($params.type) && $params.type == 'decimal'}
						{$tr.$key|string_format:"%.2f"}
					{elseif isset($params.type) && $params.type == 'percent'}
						{$tr.$key} {l s='%'}
					{elseif isset($params.type) && $params.type == 'bool'}
            {if $tr.$key == 1}
                            {l s='Yes' d='Admin.Global'}
                        {elseif $tr.$key == 0 && $tr.$key != ''}
                            {l s='No' d='Admin.Global'}
                        {/if}
					{* If type is 'editable', an input is created *}
					{elseif isset($params.type) && $params.type == 'editable' && isset($tr.id)}




                            <input type="text" name="{$key}_{$tr.id}" value="{$tr.$key|escape:'html':'UTF-8'}" class="{$key}"/>




{elseif $key == 'color'}
						{if !is_array($tr.$key)}
                            <div style="background-color: {$tr.$key};" class="attributes-color-container"></div>




{else}
                        {*TEXTURE*}




                            <img src="{$tr.$key.texture}" alt="{$tr.name}" class="attributes-color-container"/>
                        {/if}
					{elseif isset($params.maxlength) && Tools::strlen($tr.$key) > $params.maxlength}




                            <span title="{$tr.$key|escape:'html':'UTF-8'}">{$tr.$key|truncate:$params.maxlength:'...'|escape:'html':'UTF-8'}</span>
                        {else}
                            {$tr.$key|escape:'html':'UTF-8'}
                        {/if}
                    {else}
                        {block name="default_field"}--{/block}
                    {/if}
                    {if isset($params.suffix)}{$params.suffix}{/if}
                {if isset($params.color) && isset($tr.color)}
                    </span>
                {/if}
                {if isset($params.badge_danger) && $params.badge_danger && isset($tr.badge_danger) && $tr.badge_danger == $params.badge_danger}</span>{/if}
                {if isset($params.badge_warning) && $params.badge_warning && isset($tr.badge_warning) && $tr.badge_warning == $params.badge_warning}</span>{/if}
                    {if isset($params.badge_success) && $params.badge_success && isset($tr.badge_success) && $tr.badge_success == $params.badge_success}</span>{/if}
                {/block}
                {block name="close_td"}
                    </td>
                {/block}
            {/foreach}

            {if $multishop_active && $shop_link_type}
                <td title="{$tr.shop_name}">
                    {if isset($tr.shop_short_name)}
                        {$tr.shop_short_name}
                    {else}
                        {$tr.shop_name}
                    {/if}
                </td>
            {/if}
            {if $has_actions}
                <td class="text-right">
                    {assign var='compiled_actions' value=array()}
                    {foreach $actions AS $key => $action}
                        {if isset($tr.$action)}
                            {if $key == 0}
                                {assign var='action' value=$action}
                            {/if}
                            {if $action == 'delete' && $actions|@count > 2}
                                {$compiled_actions[] = 'divider'}
                            {/if}
                            {$compiled_actions[] = $tr.$action}
                        {/if}
                    {/foreach}
                    {if $compiled_actions|count > 0}
                        {if $compiled_actions|count > 1}<div class="btn-group-action">{/if}
                        <div class="btn-group pull-right">
                            {$compiled_actions[0]}
                            {if $compiled_actions|count > 1}
                                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-caret-down"></i>&nbsp;
                                </button>
                                <ul class="dropdown-menu">
                                    {foreach $compiled_actions AS $key => $action}
                                        {if $key != 0}
                                            <li{if $action == 'divider' && $compiled_actions|count > 3} class="divider"{/if}>
                                                {if $action != 'divider'}{$action}{/if}
                                            </li>
                                        {/if}
                                    {/foreach}
                                </ul>
                            {/if}
                        </div>
                        {if $compiled_actions|count > 1}</div>{/if}
                    {/if}
                    {if Module::getInstanceByName('reviewsreply') != false}
                        {if isset(Module::getInstanceByName('reviewsreply')->active)}
                            {if Module::getInstanceByName('reviewsreply')->active == true && $identifier == 'id_product_comment'}
                                <div class="pull-right">
                                    <a onclick="$(this).closest('tr').next('tr').show();" class="btn btn-small btn-default"><i class="icon-pencil"></i> {l s='Reply'}</a>
                                </div>
                            {/if}
                        {/if}
                    {/if}
                </td>
            {/if}
        </tr>
        {if Module::getInstanceByName('reviewsreply') != false}
            {if isset(Module::getInstanceByName('reviewsreply')->active)}
                {if Module::getInstanceByName('reviewsreply')->active == true && $identifier == 'id_product_comment'}
                    <tr style="display:none;">
                        <td colspan="8" class="center" style="padding:8px">
                            {assign var='reply' value=rreply::getByIdProductCommentAll($tr.id_product_comment)}
                            <form method="post">
                                <input type="hidden" name="action" value="addreply"/>
                                <input type="hidden" name="id_product_comment" value="{$tr.id_product_comment}"/>
                                {if isset($reply.0)}
                                    {if isset($reply.0->body)}
                                        <input type="hidden" name="id_rreply" value="{$reply.0->id_rreply}"/>
                                    {/if}
                                {/if}
                                <textarea name="body" style="height:100px; margin-bottom:20px;" class="col-lg-12">{if Tools::getValue('action') == 'addreply' && Tools::getValue('id_product_comment') == $tr.id_product_comment}{Tools::getValue('body')}{elseif isset($reply.0)}{if isset($reply.0->body)}{$reply.0->body}{/if}{/if}</textarea>
                                <div class="col-lg-12">
                                    <button class="btn btn-large btn-success">
                                        <i class="icon-save"></i> {if isset($reply.0)}{l s='Save reply'}{else}{l s='Add reply'}{/if}
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>
                {/if}
            {/if}
        {/if}
    {/foreach}
{else}
    <tr>
        <td class="list-empty" colspan="{count($fields_display)+1}">
            <div class="list-empty-msg">
                <i class="icon-warning-sign list-empty-icon"></i>
                {l s='No records found'}
            </div>
        </td>
    </tr>
{/if}
</tbody>