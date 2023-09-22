<div class="row group-row{if !isset($type) || $type == 1} label-tooltip{/if}"  {if !isset($type) || $type == 1}data-original-title="{l s='You can drag this group to other hook'}"{/if} {if isset($item_group)}id="group_{$item_group.id}"{/if} data-type="{$type}">
    {*add + edit + insert column for group*}
    <div class="group-panel col-lg-12">
        {if !isset($type) || $type == 1}
        <div class="pull-left">
            <a title="{l s='Click here to change group status'}" class="leo-group-status label-tooltip" data-value="{$item_group.active}">
                <img src="{$img_admin_url}{if $item_group.active == 1}enabled.gif{else}disabled.gif{/if}" alt="" />
            </a>
            <a href="javascript:void(0);" class="leo-group-btn leo-edit-group label-tooltip" data-original-title="{l s='Click here to Edit group'}">
                <i class="icon-edit"></i>
            </a>
            <a style="color:#D9534F" class="leo-group-btn leo-remove-group label-tooltip" data-confirm="{l s='Are you sure you want to delete this group?'}" data-original-title="{l s='Click here to delete group'}" href="javascript:void(0)"><i class="icon-remove-sign"></i></a>
        </div>
        {/if}
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
    <div class="column-list col-lg-12">
        {if isset($item_group) && isset($item_group.columns)}
            {foreach $item_group.columns item="itemColumn"}
                <div id="column_{$itemColumn.id}" class="column-row{if isset($itemColumn.col_value)}{$itemColumn.col_value}{/if}">
                    <div class="leo-column{if !$itemColumn.name} unset-widget{/if}">
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
                        <span class="leo-column_title">{if $itemColumn.name}{$itemColumn.name}{else if isset($itemColumn.module) && $itemColumn.module}{$itemColumn.module}{else}<a class="leo-disable leo-edit-column" href="javascript:void(0)">{l s='Click to assign a widget or module'}</a>{/if}</span>
                        <div class="leo-column-action">
                            <a title="{l s='Click here to change column status'}" class="leo-column-status" data-value="{$itemColumn.active}">
                                <img src="{$img_admin_url}{if $itemColumn.active == 1}enabled.gif{else}disabled.gif{/if}" alt="" />
                            </a>
                            <div class="btn-group" title="{l s='Click to edit column configuration, edit widget or remove this column'}">
                                <button class="leo-cog dropdown-toggle" type="button" data-toggle="dropdown">
                                    <i class="icon-cog"></i><span class="caret"></span></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="btn leo-edit-column"><i class="icon-columns"></i> {l s='Column Configuration'}</a></li>
                                    <li class="divider"></li>
                                    <!-- is a widget -->
                                    {if $itemColumn.key_widget neq  0}
                                    <li><a class="btn leo-edit-widget {if !$itemColumn.name}disabled{/if}" data-for="widget" href="javascript:void(0);"><i class="icon-cog"></i> {l s='Widget Configuration'}</a></li>
                                    {else} 
                                        {if isset($itemColumn.module)} <!-- is a module -->
                                            <li><a class="btn leo-edit-widget {if !$itemColumn.module}disabled{/if}" data-for="module" href="javascript:void(0);"><i class="icon-cog"></i> {l s='Module Configuration'}</a></li>
                                        {else} <!-- not assign widget or module -->
                                            <li><a class="btn leo-edit-widget disabled" data-for="module" href="javascript:void(0);"><i class="icon-cog"></i> {l s='Widget or Module Configuration'}</a></li>
                                        {/if}
                                    {/if}
                                    <li class="divider"></li>
                                    <li><a style="color:#fff" class="btn leo-delete-column btn-danger" data-for="delete" data-confirm="{l s='Are you sure you want to delete this column?'}" href="javascript:void(0)"><i class="icon-remove-sign"></i> {l s='Delete'}</a></li>
                                </ul>
                           </div>
                        </div>
                    </div>
                </div>
            {/foreach}
        {/if}
    </div>
</div>