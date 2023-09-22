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
<!-- MODULE st easy content -->
{if $easy_content|@count > 0}
    {foreach $easy_content as $ec}
        {if isset($ec.is_full_width) && $ec.is_full_width}<div id="easycontent_container_{$ec.id_st_easy_content}" class="easycontent_container full_container {if $ec.hide_on_mobile == 1}hidden-xs{elseif $ec.hide_on_mobile == 2}visible-xs visible-xs-block{/if} {if !isset($is_inline_content)}block{/if}">{if !$ec.stretched}<div class="container">{/if}<div class="row"><div class="col-xs-12">{/if}
            <aside id="easycontent_{$ec.id_st_easy_content}" class="easycontent_{$ec.id_st_easy_content} container {if $ec.text_align==2} text-center{/if }{if $ec.hide_on_mobile == 1}hidden-xs{elseif $ec.hide_on_mobile == 2}visible-xs visible-xs-block{/if} {if !isset($is_inline_content) && (!isset($ec.is_full_width) || !$ec.is_full_width)}block{/if} easycontent {if isset($is_column) && $is_column} column_block {/if} section" style="margin-bottom: 0px;">
                {if $ec.title}
                <h3>
                    {if $ec.url}<a href="{$ec.url|escape:html}" title="{$ec.title|escape:html:'UTF-8'}">{else}<span>{/if}
                    {$ec.title|escape:html:'UTF-8'}
                    {if $ec.url}</a>{else}</span>{/if}
                </h3>
                {/if}
            	<div class="style_content {if $ec.text_align==2} text-center {elseif $ec.text_align==3} text-right {/if} {if $ec.width} center_width_{$ec.width} {/if} block_content">
                    {$ec.text|stripslashes}
            	</div>
            </aside> 
        {if isset($ec.is_full_width) && $ec.is_full_width}</div>{if !$ec.stretched}</div>{/if}</div></div>{/if}
    {/foreach}
{/if}
<!-- MODULE st easy content -->