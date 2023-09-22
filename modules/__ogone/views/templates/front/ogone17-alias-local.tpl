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
<div class="row">
  <div class="col-xs-12">
    <div class="payment_module local-alias">
    <div class="ogone alias   {if isset($immediate_payment) && $immediate_payment}oaip{/if}" href="#" title="{l s='Pay with Ingenico ePayments' mod='ogone'}">
        <img src="{$alias_data.logo|escape:'htmlall':'UTF-8'}"/>
          <span class="card-item">
            <span class="left-card">
              <span class="card-name">{$alias_data.cn|escape:'htmlall':'UTF-8'}</span>
              <span class="card-number">{$alias_data.cardno|escape:'htmlall':'UTF-8'}</span>
            </span>
            <span class="right-card">
      {if $expiry_date}
              <span class="card-expiration">{l s='Expiration date' mod='ogone'}</span>
              <span class="card-date">{$expiry_date|escape:'htmlall':'UTF-8'}</span>
      {/if}
            </span>
          </span>
       </div>
    </div>

  </div>

</div>
