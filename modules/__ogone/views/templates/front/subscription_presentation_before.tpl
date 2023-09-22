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

<div id="subscribe_info_list" class="subscribe-info-list definition-list">
  <dl>
    <dt><strong>{l s='This is subscription for' mod='ogone'}</strong></dt><dd><strong>{$subscription_data.product_name|escape:'htmlall':'UTF-8'}</strong></dd>
    {if isset($first_amount_real)}
        <dt><strong>{l s='The amount of first payment' mod='ogone'}</strong></dt><dd><strong>{$first_amount_real|escape:'htmlall':'UTF-8'}</strong></dd>
        <dt><strong>{l s='The amount of subsequent payments' mod='ogone'}</strong></dt><dd><strong>{$subscription_data.amount|escape:'htmlall':'UTF-8'}</strong></dd>
    {else}
        <dt><strong>{l s='The amount of' mod='ogone'}</strong></dt><dd><strong>{$subscription_data.amount|escape:'htmlall':'UTF-8'}</strong></dd>

    {/if}
    <dt><strong>{l s='Number of installments' mod='ogone'}</strong></dt><dd><strong>{$subscription_data.installments|escape:'htmlall':'UTF-8'}</strong></dd>

    <dt><strong>{l s='Frequency' mod='ogone'}</strong></dt><dd><strong>{$subscription_data.hr_frequency|escape:'htmlall':'UTF-8'}</strong></dd>
    <dt><strong>{l s='Billing will occur on' mod='ogone'}</strong></dt><dd><strong>{$subscription_data.hr_billing|escape:'htmlall':'UTF-8'}</strong></dd>

    <dt><strong>{l s='Start date' mod='ogone'}</strong></dt><dd><strong>{$subscription_data.start_date|escape:'htmlall':'UTF-8'}</strong></dd>
    <dt><strong>{l s='End date' mod='ogone'}</strong></dt><dd><strong>{$subscription_data.end_date|escape:'htmlall':'UTF-8'}</strong></dd>
  </dl>
</div>