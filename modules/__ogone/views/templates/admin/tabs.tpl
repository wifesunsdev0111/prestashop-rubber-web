{*
* 2007-2017 PrestaShop
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
*  @copyright  2007-2017 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<div class="ogone-messages">
  {if $notify_url}
    <div class="alert alert-warning alert-notify-url">
      <p>
        <span>{l s='Important:' mod='ogone'}</span>
        {l s='From 1.7.6 version, validation URL has changed. Please update your configuration on Ogone portal in the Configuration > Technical information > Transaction feedback menu.' mod='ogone'}
      </p>
      <p>
        {l s='New notify URL:' mod='ogone'}
        {$validation_url|escape:'htmlall':'UTF-8'}
      </p>
    </div>
  {/if}
  {if $messages}
    {foreach $messages as $type=>$list}
      {if $list}
        <div class="alert alert-{$type|escape:'htmlall':'UTF-8'}">
          {foreach $list as $message}
            <p>{$message|escape:'quotes':'UTF-8'}</p>
          {/foreach}
        </div>
      {/if}
    {/foreach}
  {/if}
</div>

<div class="ogone-tabs">
  {if $tabs}
    <nav>
      {foreach $tabs as $tab}
        <a class="tab-title {if isset($selected_tab) && $tab.id==$selected_tab}active{/if}"
           href="#"
           id="{$tab.id|escape:'htmlall':'UTF-8'}"
           data-target="#ogone-tabs-{$tab.id|escape:'htmlall':'UTF-8'}">{$tab.title|escape:'htmlall':'UTF-8'}</a>
      {/foreach}
    </nav>
    <div class="content">
      {foreach $tabs as $tab}
        <div class="tab-content"
             id="ogone-tabs-{$tab.id|escape:'htmlall':'UTF-8'}"
             style="display:{if isset($selected_tab) && $tab.id==$selected_tab}block{else}none{/if}">
          {$tab.content}{* HTML, cannot escape *}
        </div>
      {/foreach}
    </div>
  {/if}
</div>

{if $ps_tracker_url}
  <img src="{$ps_tracker_url|escape:'html':'UTF-8'}" style="display:none"/>
{/if}