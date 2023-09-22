<div id="idTab68">
{if $leoGroup}
    {foreach from=$leoGroup item=groups key=typeGroup}
        {if $groups}
            {foreach from=$groups item=group}
                {if $typeGroup==1}
<div class="row {$group.class}" {if isset($group.background) && $group.background}style="background-color: {$group.background}"{/if}>
                    {if isset($group.title) && $group.title}
				<h4 class="title_block">{$group.title}</h4>
                    {/if}
                {/if}
                {if isset($group.columns) && $group.columns}
                    {foreach from=$group.columns item=column}
                        {if $column.active}
    <div class="widget{$column.col_value}{if $column.class} {$column.class}{/if}" {if isset($column.background) && $column.background}style="background-color: {$column.background}"{/if}>
        {if isset($column.content)}{$column.content}{/if}
    </div>
                        {/if}
                    {/foreach}
                {/if}
                {if $typeGroup==1}
</div>
                {/if}
            {/foreach}
        {/if}
    {/foreach}
{/if}
</div>