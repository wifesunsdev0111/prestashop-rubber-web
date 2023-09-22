{*
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApBlockLink -->
{($apLiveEdit)?$apLiveEdit:''}{* HTML form , no escape necessary *}


<div id="blockLink-{$formAtts.form_id|escape:'html':'UTF-8'}" class="ApBlockLink">
    <div class="block">
        {if isset($formAtts.name) && !empty($formAtts.name)}
				<h4 class="title_block">
					{$formAtts.name|escape:'html':'UTF-8'}
				</h4>
				{/if}
        <ul class="toggle-footer list-group bullet">
        {foreach from=$formAtts.links item=item}
            {if $item.title && $item.link}
                <li><a href="{$item.link}">{$item.title|escape:'html':'UTF-8'}</a></li>
            {/if}
        {/foreach}
        </ul>
    </div>
</div>

{($apLiveEditEnd)?$apLiveEditEnd:''}{* HTML form , no escape necessary *}