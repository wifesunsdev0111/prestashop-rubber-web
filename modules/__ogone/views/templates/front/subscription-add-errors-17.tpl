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
{extends file='page.tpl'}
{block name='content'}
<p>{l s='Subscription info' mod='ogone'}</p>
{if $errors}
{foreach $errors as $error}
  <p class="alert danger ogone-subscription-error">{$error|escape:'htmlall':'UTF-8'}</p>
{/foreach}
  {if $actions}
  <div class="actions">
    {foreach $actions as $action}
      <a href="{$action.link|escape:'htmlall':'UTF-8'}"  class="btn btn-primary">{$action.name|escape:'htmlall':'UTF-8'}</a>

    {/foreach}
  </div>
  {/if}

{/if}

{/block}


