{*
* 2007-2018 PrestaShop
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2018 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div id="modulecontent" class="clearfix">
    <div id="menu">
        <div class="col-lg-2">
            <div class="list-group" v-on:click.prevent>
                <a href="#" class="list-group-item" v-bind:class="{ 'active': isActive('conf') }" v-on:click="makeActive('conf')"><i class="fa fa-picture-o"></i> {l s='Configuration' mod='psagechecker'}</a>
                {if ($apifaq != '')}
                    <a href="#" class="list-group-item" v-bind:class="{ 'active': isActive('faq') }" v-on:click="makeActive('faq')"><i class="fa fa-question-circle"></i> {l s='Help' mod='psagechecker'}</a>
                {/if}
            </div>
            <div class="list-group" v-on:click.prevent>
                <a class="list-group-item" style="text-align:center"><i class="icon-info"></i> {l s='Version' mod='psagechecker'} {$module_version|escape:'htmlall':'UTF-8'} | <i class="icon-info"></i> PrestaShop {$ps_version|escape:'htmlall':'UTF-8'}</a>
            </div>
        </div>
    </div>

    <div id="conf" class="giftcards_menu addons-hide">
        {include file="./tabs/configuration.tpl"}
    </div>

    <div id="faq" class="giftcards_menu addons-hide">
        {if ($apifaq != '')}
            {include file="./tabs/help.tpl"}
        {/if}
    </div>

    {if $showRateModule == true }
        <div id="rateThisModule">
            <p>
                <img src="{$img_path}star_img.png" alt="Shinning Star">
                {l s='Enjoy this module ?' mod='psagechecker'}
                <a target="_blank" href="https://addons.prestashop.com/{$currentLangIsoCode}/ratings.php">
                    {l s='Leave a review on Addons Marketplace' mod='psagechecker'}
                </a>
            </p>
        </div>
    {/if}

</div>

{* Use this if you want to send php var to your js *}
{literal}
<script type="text/javascript">
    var isPs17 = "{/literal}{$isPs17|escape:'htmlall':'UTF-8'}{literal}";
    var currentPage = "{/literal}{$currentPage|escape:'htmlall':'UTF-8'}{literal}";
    var moduleAdminLink = "{/literal}{$moduleAdminLink|escape:'htmlall':'UTF-8'}{literal}";
    var controller_url = "{/literal}{$controller_url|escape:'htmlall':'UTF-8'}{literal}";
    var ps_version = "{/literal}{$isPs17|escape:'htmlall':'UTF-8'}{literal}";
    var enableGiftcard = "{/literal}{l s='The gift card has been enabled !' mod='psagechecker'}{literal}";
    var disableGiftcard = "{/literal}{l s='The gift card has been disabled !' mod='psagechecker'}{literal}";
    var untagProduct = "{/literal}{l s='The product has been untagged as gift card.' mod='psagechecker'}{literal}";

    var sweetAlertTitle = "{/literal}{l s='Are you sure?' mod='psagechecker'}{literal}";
    var sweetAlertMessage = "{/literal}{l s='The product will be disabled and untagged.' mod='psagechecker'}{literal}";
    var select2placeholder = "{/literal}{l s='Select a product' mod='psagechecker'}{literal}";
    var select2noResult = "{/literal}{l s='No results found' mod='psagechecker'}{literal}";
    var tradSmthWrongHappenedTryAgain = "{/literal}{l s='Something wrong happened. Please try again.' mod='psagechecker'}{literal}";
</script>
{/literal}
