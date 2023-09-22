{*
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApBlockLink -->
{$apLiveEdit}


<div id="blockLink-{$formAtts.form_id}" class="ApBlockLink">
    <div class="block footer-block">
        <h4 class="title_block">{$formAtts.name}</h4>
        <ul class="toggle-footer list-group bullet">
        {foreach from=$formAtts.links item=item}
            {if $item.title && $item.link}
                <li><a href="{$item.link}">{$item.title|escape:'html':'UTF-8'}</a></li>
            {/if}
        {/foreach}
        </ul>
    </div>
</div>

{$apLiveEditEnd}