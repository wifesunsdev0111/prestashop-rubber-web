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
{if $subscription_data.has_ended}
  {l s='This is subscription has ended' mod='ogone'}
{/if}
{l s='This is subscription for' mod='ogone'} : {$subscription_data.product_name|escape:'htmlall':'UTF-8'}
{l s='Your subscription start at' mod='ogone'} : {$subscription_data.start_date|escape:'htmlall':'UTF-8'}
{l s='Your subscription end at ' mod='ogone'} : {$subscription_data.end_date|escape:'htmlall':'UTF-8'}
{l s='The amount of' mod='ogone'} : {$subscription_data.amount|escape:'htmlall':'UTF-8'}
{l s='Number of installments' mod='ogone'} : {$subscription_data.installments|escape:'htmlall':'UTF-8'}
{l s='Frequency' mod='ogone'} : {$subscription_data.hr_frequency|escape:'htmlall':'UTF-8'}
{l s='Billing will occur on' mod='ogone'} : {$subscription_data.hr_billing|escape:'htmlall':'UTF-8'}

{if isset($subscription_data.orders) &&count($subscription_data.orders)>0}
{foreach $subscription_data.orders as $order}

  {l s='Order' mod='ogone'} : {$order.reference|escape:'htmlall':'UTF-8'}
  {l s='PayID' mod='ogone'} : {$order.payid|escape:'htmlall':'UTF-8'}
  {l s='Date' mod='ogone'} : {$order.date|escape:'htmlall':'UTF-8'}
  {l s='Amount' mod='ogone'} : {$order.amount|escape:'htmlall':'UTF-8'}
  {l s='Order status' mod='ogone'} : {$order.status|escape:'htmlall':'UTF-8'}
  {/foreach}
{/if}