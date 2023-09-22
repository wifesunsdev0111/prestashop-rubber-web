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
<div class="limit results">
    <label class="" for="paginator_select_limit">{l s='Items per page:' mod='ets_htmlbox'}</label>
    <div>
        <select id="paginator_{$pageName|escape:'html':'UTF-8'}_select_limit" class="pagination-link custom-select paginator_select_limit" name="paginator_{$pageName|escape:'html':'UTF-8'}_select_limit" >
            <option value="10" {if $limit==10} selected="selected"{/if}>10</option>
            <option value="20" {if $limit==20} selected="selected"{/if}>20</option>
            <option value="50" {if $limit==50} selected="selected"{/if}>50</option>
            <option value="100" {if $limit==100} selected="selected"{/if}>100</option>
            <option value="300" {if $limit==300} selected="selected"{/if}>300</option>
        </select>
    </div>
</div>