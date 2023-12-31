{*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<!-- MODULE Block specials -->
<div id="special_block_right" class="block nopadding black">
	<h4 class="title_block">
        <a href="{$link->getPageLink('prices-drop')|escape:'html':'UTF-8'}" title="{l s='Specials' mod='blockspecials'}">
            {l s='Specials' mod='blockspecials'}
        </a>
    </h4>
	<div class="block_content products-block">
    {if $special}
        {$products=array($special)} 
		{include file="$tpl_dir./sub/product/sidebar.tpl" products=$products mod='blockspecials'}  
		<div class="lnk">
			<a 
            class="btn-outline button btn-sm" 
            href="{$link->getPageLink('prices-drop')|escape:'html':'UTF-8'}" 
            title="{l s='All specials' mod='blockspecials'}">
                <span>{l s='All specials' mod='blockspecials'}</span>
            </a>
		</div>
    {else}
		<div>{l s='No specials at this time.' mod='blockspecials'}</div>
    {/if}
	</div>
</div>
<!-- /MODULE Block specials -->