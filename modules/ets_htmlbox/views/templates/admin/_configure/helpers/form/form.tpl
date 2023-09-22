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
{extends file="helpers/form/form.tpl"}

{block name="field"}
    {if $input.type == 'checkbox'}
        <div class="col-lg-9">
            <div class="row html_column_2_col">
                {if sizeof($input.values.query) > 0}
                    {foreach $input.values.query as $position}
                        <div class="checkbox col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="position_{$position.id|escape:'html':'UTF-8'}">
                                <input type="checkbox" name="position[]"
                                       id="position_{$position.id|escape:'html':'UTF-8'}" class=""
                                       value="{$position.id|escape:'html':'UTF-8'}"
                                       {if isset($fields_value.position) && is_array($fields_value.position) && in_array($position.id,$fields_value.position)}checked{/if}>
                                {$position.name|escape:'html':'UTF-8'}
                                <span>
                                ({$position.hook|escape:'html':'UTF-8'})
                                {if $position.hook=='displayCustomHTMLBox'}
                                    <div class="desc-hooks">
                                        <p>{l s='Copy the hook below the paste into the .tpl file where you want display the HTML' mod='ets_htmlbox'}</p>
                                        <span title="Click to copy" style="position: relative;display: inline-block; vertical-align: middle;width: 240px;">
                                            <input class="ctf-short-code" value="{literal}{hook h='displayCustomHTMLBox'}{/literal}" type="text" />
                                            <span class="text-copy">{l s='Copied' mod='ets_htmlbox'}</span>
                                        </span>
                                    </div>
                                {/if}
                                </span>
                            </label>
                        </div>
                    {/foreach}
                {/if}
            </div>
        </div>
    {else}
        {$smarty.block.parent}
    {/if}
{/block}