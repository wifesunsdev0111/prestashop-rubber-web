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

<p class="ogone validation-message	">
  {if isset($inject_3ds)}
    <div class="ogone_3dsinfo">
      {l s='Please fill 3D-Secure info' mod='ogone'}.<br />
      {if $inject_3ds_mode=='MAINW'}
      {l s='Form will open in this window' mod='ogone'}
      {elseif  $inject_3ds_mode=='POPUP' || $inject_3ds_mode=='POPIX'}
      {l s='Form will open in separate window' mod='ogone'}
    {/if}
    </div>
  {/if}
  {$message} {* HTML, cannot escape *}
</p>