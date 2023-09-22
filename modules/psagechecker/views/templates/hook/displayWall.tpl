<!--
* 2007-2018 PrestaShop
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
* @author    PrestaShop SA <contact@prestashop.com>
* @copyright 2007-2018 PrestaShop SA
* @license   http://addons.prestashop.com/en/content/12-terms-and-conditions-of-use
* International Registered Trademark & Property of PrestaShop SA
-->
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css" media="all">
<link href="https://fonts.googleapis.com/css?family=Hind" rel="stylesheet" type="text/css" media="all">
<link href="https://fonts.googleapis.com/css?family=Maven+Pro" rel="stylesheet" type="text/css" media="all">
<link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet" type="text/css" media="all">
<link href="https://fonts.googleapis.com/css?family=Bitter" rel="stylesheet" type="text/css" media="all">
<link href="https://fonts.googleapis.com/css?family=Forum" rel="stylesheet" type="text/css" media="all">

<div id="psagechecker_block" class="preload psagechecker-hide">
    <div id="psagechecker-lightbox" class="lightbox">
        <div class="lightbox-content">
            <div style="height:100%">
                {if $show_img == 1}
                    <div class="logo_age_verify">
                            <img src="{$img_upload}" /><br />
                    </div>
                {/if}
                <div class="{if $show_img != 1}age_verify_text_content{/if}">
                    <div class="age_verify" style="font-family: {$font_family|escape:'htmlall':'UTF-8'} !important;">
                        {$custom_tit nofilter}
                    </div>
                    <div class="blockAgeVerify">
                        <div class="custom_msg_age_verify">
                            {$custom_msg nofilter}
                        </div>
                        {if $method == 0}
                            <div class="age_verify_buttons">
                                <button id="deny_button" class="btn btn_deny" >{$deny_button|escape:'htmlall':'UTF-8'}</button>
                                <button id="confirm_button" class="btn btn_confirm" >{$confirm_button|escape:'htmlall':'UTF-8'}</button>
                            </div>
                        {else}
                            <div class="age_verify_input">
                                <input id="day" class="form-control day" type="number" name="day" placeholder="DD" size="2" min="1" max="31" required>
                                <input id="month" class="form-control month" type="number" name="month" size="2" placeholder="MM" min="1" max="12" required>
                                <input id="year" class="form-control year" type="number" name="year" placeholder="YYYY" min="1940"required>
                                <br /><br />
                                <button id="submitAge" class="btn btn_confirm" >{$confirm_button|escape:'htmlall':'UTF-8'}</button>
                            </div>
                        {/if}
                    </div>
                </div>
                <div class="deny_msg_age_verify psagechecker-hide">
                    {$deny_msg nofilter}
                </div>
            </div>
        </div>
    </div>
    <div id="overlay" class="psagechecker-hide"></div>
</div>
<style>

    #psagechecker-lightbox{
        background-color: {$popup_bg_color|escape:'htmlall':'UTF-8'} !important;
    }
    #psagechecker-lightbox, #psagechecker-lightbox *{
        font-family: {$font_family|escape:'htmlall':'UTF-8'} !important;
    }

    .btn_deny{
        background-color: {$deny_bg_color|escape:'htmlall':'UTF-8'} !important;
        color: {$deny_txt_color|escape:'htmlall':'UTF-8'} !important;
    }
    .btn_confirm{
        background-color: {$confirm_bg_color|escape:'htmlall':'UTF-8'} !important;
        color: {$confirm_txt_color|escape:'htmlall':'UTF-8'} !important;
    }
    #psagechecker_block .lightbox{
        width : {$popup_width|escape:'htmlall':'UTF-8'}px ;
        height : {$popup_height|escape:'htmlall':'UTF-8'}px !important;
    }
    #psagechecker_block #overlay {
        background-color: rgba(0,0,0,{$opacity|escape:'htmlall':'UTF-8'});
        height: 100%;
        left: 0;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 9999;
    }
</style>
{literal}
<script>
var display_popup = "{/literal}{$display_popup|escape:'htmlall':'UTF-8'}{literal}";
var age_required = "{/literal}{$age_required|escape:'htmlall':'UTF-8'}{literal}";
</script>
{/literal}
