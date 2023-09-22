{*
* 2007-2022 ETS-Soft
*
* NOTICE OF LICENSE
*
* This file is not open source! Each license that you purchased is only available for 1 wesite only.
* If you want to use this file on more websites (or projects), you need to purchase additional licenses.
* You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs, please contact us for extra customization service at an affordable price
*
*  @author ETS-Soft <etssoft.jsc@gmail.com>
*  @copyright  2007-2022 ETS-Soft
*  @license    Valid for 1 website (or project) for each purchase of license
*  International Registered Trademark & Property of ETS-Soft
*}
{if $tag}
<{$tag|escape:'html':'UTF-8'}
    {if $class} class="{$class|escape:'html':'UTF-8'}"{/if}
    {if $id} id="{$id|escape:'html':'UTF-8'}"{/if}
    {if $rel} rel="{$rel|escape:'html':'UTF-8'}"{/if}
    {if $type} type="{$type|escape:'html':'UTF-8'}"{/if}
    {if $data_id_product} data-id_product="{$data_id_product|escape:'html':'UTF-8'}"{/if}
    {if $value} value="{$value|escape:'html':'UTF-8'}"{/if}
    {if $href} href="{$href nofilter}"{/if}{if $tag=='a' && $blank} target="_blank"{/if}
    {if $tag=='img' && $src} src="{$src nofilter}"{/if}
    {if $name} name="{$name|escape:'html':'UTF-8'}"{/if}
    {if $attr_datas}
        {foreach from=$attr_datas item='data'}
            {$data.name|escape:'html':'UTF-8'}="{$data.value|escape:'html':'UTF-8'}"
        {/foreach}
    {/if}
    {if $tag=='img' || $tag=='br' || $tag=='input'} /{/if}
    
>
    {/if}{if $tag && $tag!='img' && $tag!='input' && $tag!='br' && !is_null($content)}{$content nofilter}{/if}{if $tag && $tag!='img' && $tag!='input' && $tag!='br'}</{$tag|escape:'html':'UTF-8'}>{/if}