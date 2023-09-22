{*
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
*}

<script type="text/javascript">
    var popupDisplaySelectedCategories = {$popupDisplaySelectedCategories|@json_encode};
</script>

<form method="post" action="{$moduleAdminLink|escape:'htmlall':'UTF-8'}&page=conf" class="form-horizontal" enctype="multipart/form-data">

<div class="panel col-lg-10 right-panel">
    <h3>
        <i class="fa fa-tasks"></i> {l s='Configuration' mod='psagechecker'} <small>{$module_display|escape:'htmlall':'UTF-8'}</small>
    </h3>

    {* PS AGE CHECKER STATUS *}
    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
            <div class="text-right">
                <label class="boldtext control-label">{l s='Display age verification pop up' mod='psagechecker'}</label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
            <span class="switch prestashop-switch fixed-width-lg">
                <input class="yes" type="radio" name="PS_AGE_CHECKER_SHOW_POPUP" id="album_title_on" data-toggle="collapse" data-target="#" value="1" {if $show_popup eq 1}checked="checked"{/if}>
                <label for="album_title_on" class="radioCheck">{l s='YES' mod='psagechecker'}</label>

                <input class="no" type="radio" name="PS_AGE_CHECKER_SHOW_POPUP" id="album_title_off" data-toggle="collapse" data-target="#" value="0" {if $show_popup eq 0}checked="checked"{/if}>
                <label for="album_title_off" class="radioCheck">{l s='NO' mod='psagechecker'}</label>
                <a class="slide-button btn"></a>
            </span>
        </div>
    </div>
    {* PS AGE CHECKER STATUS *}

    {* PS AGE CHECKER POPUP DISPLAY LOCATION *}
    <div id="PsAgeCheckerPopupDisplayLocation" class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
            <div class="text-right">
                <label class="control-label">
                    {l s='Where do you want to display your popup' mod='psagechecker'}
                </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-4">
            <input id="PS_AGE_CHECKER_POPUP_DISPLAY_EVERYWHERE" class="hide" type="text" name="PS_AGE_CHECKER_POPUP_DISPLAY_EVERYWHERE"  value="{$popupDisplaySelectedEverywhere}">
            <input id="PS_AGE_CHECKER_POPUP_DISPLAY_CATEGORIES" class="hide" type="text" name="PS_AGE_CHECKER_POPUP_DISPLAY_CATEGORIES"  value="{$configDisplaySelectedCategories}">
            <input id="PS_AGE_CHECKER_POPUP_DISPLAY_PRODUCTS" class="hide" type="text" name="PS_AGE_CHECKER_POPUP_DISPLAY_PRODUCTS"  value="{$configDisplaySelectedProducts}">

            <label>
                <input {if $popupDisplaySelectedEverywhere == 'true'}checked{/if} class="PopupDisplaySelector" type="checkbox" name="{l s='All shop' mod='psagechecker'}" value="all">
                {l s='All shop' mod='psagechecker'}
            </label>
            <br>

            <label>
                <input {if $popupDisplaySelectedCategories|@count > 0}checked{/if} class="PopupDisplaySelector" type="checkbox" name="{l s='Specific Category' mod='psagechecker'}" value="categories">
                {l s='Specific Category' mod='psagechecker'}
            </label>
            <div id="PopupDisplaySelectCategories" {if $popupDisplaySelectedCategories|@count == 0}class="hide"{/if}>
                <div id="jstreecategories"><ul></ul></div>
            </div>
            <br>

            <label>
                <input {if $popupDisplaySelectedProducts|@count > 0}checked{/if} class="PopupDisplaySelector" type="checkbox" name="{l s='Specific Product' mod='psagechecker'}" value="products">
                {l s='Specific Product' mod='psagechecker'}
            </label>
            <div id="PopupDisplaySelectProducts" class="table-responsive {if $popupDisplaySelectedProducts|@count == 0}hide{/if}" >
                <input type="text" name="{l s='Specific Product' mod='psagechecker'}" value="">
                <ul id="resultProducts" class="hide"></ul>

                <table class="table table-bordered" id="selectedProducts">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{l s='Image' mod='psagechecker'}</th>
                            <th>{l s='Name' mod='psagechecker'}</th>
                            <th>{l s='Action' mod='psagechecker'}</th>
                        </tr>
                    </thead>
                    <tbody class="table-hover">
                        {foreach from=$popupDisplaySelectedProducts key='key' item='product'}
                            <tr id="{$product->id}">
                                <td>{$product->id}</td>
                                <td><img class="img-fluid img-thumbnail" src="{$product->imgLink}"></td>
                                <td>{$product->name}</td>
                                <td><i class="material-icons" data-id="{$product->id}">delete</i></td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {* PS AGE CHECKER POPUP DISPLAY LOCATION *}

    {* PS AGE CHECKER MINIMUM AGE *}
    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
            <div class="text-right">
                <label class="control-label">
                    {l s='Minimum age' mod='psagechecker'}
                </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-3">
            <input class="addons-number-fields addons-inline-block" required="required" value="{$minimum_age|escape:'htmlall':'UTF-8'}" type="number" name="PS_AGE_CHECKER_AGE_MINIMUM">
        </div>
    </div>
    {* PS AGE CHECKER MINIMUM AGE *}

    {* PS AGE CHECKER VERIFICATION METHOD *}
    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
            <div class="text-right">
                <label class="control-label">
                    {l s='Verification method' mod='psagechecker'}
                </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-9">
            <label>
                <input type="radio" class="input_img js-show-all" name="PS_AGE_CHECKER_VERIFICATION_METHOD" value="0" {if $verification_method eq 0}checked="checked"{/if}/>
                <img src="{$img_path}birth.png" width="150" height="150">
                <div class="help-block">
                    <p>{l s='confirm/Deny buttons' mod='psagechecker'}</p>
                </div>

            </label>
            <label>
                <input type="radio" class="input_img" name="PS_AGE_CHECKER_VERIFICATION_METHOD" value="1" {if $verification_method eq 1}checked="checked"{/if}/>
                <img src="{$img_path}confirm.png" width="150" height="150">
                <div class="help-block">
                    <p>{l s='birth date check' mod='psagechecker'}</p>
                </div>
            </label>
        </div>
    </div>
    {* PS AGE CHECKER VERIFICATION METHOD *}
    <div id="PS_AGE_CHECKER_SHOW_POPUP" {if $show_popup eq 0}class="hide"{/if}>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item active">
            <a class="nav-link active" id="jason-tab" data-toggle="tab" href="#jason" role="tab" aria-controls="jason" aria-selected="true">{l s='Text settings' mod='psagechecker'}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="billy-tab" data-toggle="tab" href="#billy" role="tab" aria-controls="billy" aria-selected="false">{l s='Design setup' mod='psagechecker'}</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">

    <div id="jason" class="tab-pane active" role="tabpanel" aria-labelledby="jason-tab">

        {* PS AGE CHECKER FONT *}
        <div class="form-group" style="margin-top:20px;">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                <div class="text-right">
                    <label class="control-label">
                            {l s='Text font' mod='psagechecker'}
                    </label>
                </div>
            </div>
            <div class="col-xs-6 col-sm-5 col-md-2 col-lg-1">
                <select name="PS_AGE_CHECKER_FONTS">
                    {foreach from=$fonts key='key' item='font'}
                        <option style="font-family: '{$font|escape:'htmlall':'UTF-8'}'" value="{$font|escape:'htmlall':'UTF-8'}" {if $select_fonts eq $font}selected{/if}>{$font|escape:'htmlall':'UTF-8'}</option>
                    {/foreach}
                </select>
            </div>
        </div>
        {* PS AGE CHECKER FONT *}

        {* PS AGE CHECKER CUSTOM TITLE *}
        {foreach from=$languages item=language}
            {if $languages|count > 1}
                <div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
            {/if}
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                    <div class="text-right">
                        <label class="control-label">
                                {l s='Custom title' mod='psagechecker'}
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-6">
                    <textarea
                        class="autoload_rte {if $language.id_lang == $defaultFormLanguage}loadTinyMce{/if}"
                        name="PS_AGE_CHECKER_CUSTOM_TITLE_{$language.id_lang|escape:'htmlall':'UTF-8'}"
                        text="" cols="80" rows="2"
                    >
                        {$custom_title[$language.id_lang]|escape:'htmlall':'UTF-8'}
                    </textarea>
                </div>
                {if $languages|count > 1}
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-3">
                        <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                            {$language.iso_code|escape:'htmlall':'UTF-8'}
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            {foreach from=$languages item=lang}
                            <li>
                                <a class="currentLang" data-id="{$lang.id_lang|escape:'htmlall':'UTF-8'}" href="javascript:hideOtherLanguage('{$lang.id_lang|escape:'javascript'}');" tabindex="-1">
                                    {$lang.name|escape:'htmlall':'UTF-8'}
                                </a>
                            </li>
                            {/foreach}
                        </ul>
                    </div>
                {/if}
            </div>
            {if $languages|count > 1}
                </div>
            {/if}
        {/foreach}
        {* PS AGE CHECKER CUSTOM TITLE *}

        {* PS AGE CHECKER CUSTOM MESSAGE *}
        {foreach from=$languages item=language}
            {if $languages|count > 1}
                <div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
            {/if}
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                    <div class="text-right">
                        <label  class="control-label">
                            {l s='Custom message' mod='psagechecker'}
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-6">
                    <textarea
                        class="autoload_rte {if $language.id_lang == $defaultFormLanguage}loadTinyMce{/if}"
                        name="PS_AGE_CHECKER_CUSTOM_MSG_{$language.id_lang|escape:'htmlall':'UTF-8'}"
                        text="" rows="4" cols="80"
                    >
                        {$custom_msg[$language.id_lang]|escape:'htmlall':'UTF-8'}
                    </textarea>
                </div>
                {if $languages|count > 1}
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-3">
                        <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                            {$language.iso_code|escape:'htmlall':'UTF-8'}
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            {foreach from=$languages item=lang}
                                <li>
                                    <a class="currentLang" data-id="{$lang.id_lang|escape:'htmlall':'UTF-8'}" href="javascript:hideOtherLanguage('{$lang.id_lang|escape:'javascript'}');" tabindex="-1">
                                        {$lang.name|escape:'htmlall':'UTF-8'}
                                    </a>
                                </li>
                            {/foreach}
                        </ul>
                    </div>
                {/if}
            </div>
            {if $languages|count > 1}
                </div>
            {/if}
        {/foreach}
        {* PS AGE CHECKER CUSTOM MESSAGE *}

        {* PS AGE CHECKER DENY MESSAGE *}
        {foreach from=$languages item=language}
            {if $languages|count > 1}
                <div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
            {/if}
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                    <div class="text-right">
                        <label  class="control-label">
                                {l s='Deny message' mod='psagechecker'}
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-6">
                    <textarea
                        class="autoload_rte {if $language.id_lang == $defaultFormLanguage}loadTinyMce{/if}"
                        name="PS_AGE_CHECKER_DENY_MSG_{$language.id_lang|escape:'htmlall':'UTF-8'}"
                        text="" rows="2" cols="80"
                    >
                        {$deny_msg[$language.id_lang]|escape:'htmlall':'UTF-8'}
                    </textarea>
                    <div class="help-block">
                        <p>{l s='This message will appear if the minimum age is not acquired' mod='psagechecker'}</p>
                    </div>
                </div>
                {if $languages|count > 1}
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-3">
                        <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                            {$language.iso_code|escape:'htmlall':'UTF-8'}
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            {foreach from=$languages item=lang}
                                <li>
                                    <a class="currentLang" data-id="{$lang.id_lang|escape:'htmlall':'UTF-8'}" href="javascript:hideOtherLanguage('{$lang.id_lang|escape:'javascript'}');" tabindex="-1">
                                        {$lang.name|escape:'htmlall':'UTF-8'}
                                    </a>
                                </li>
                            {/foreach}
                        </ul>
                    </div>
                {/if}
            </div>

            {if $languages|count > 1}
                </div>
            {/if}
        {/foreach}
        {* PS AGE CHECKER DENY MESSAGE *}

        {* PS AGE CHECKER CONFIRM BUTTON *}
        {foreach from=$languages item=language}
            {if $languages|count > 1}
                <div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
            {/if}
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                    <div class="text-right">
                        <label class="control-label">
                            {l s='Confirm button text' mod='psagechecker'}
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-2">
                    <input class="" maxlength="20" type="text" value="{if isset($confirm_button_text)}{$confirm_button_text[$language.id_lang]|escape:'htmlall':'UTF-8'}{/if}" name="PS_AGE_CHECKER_CONFIRM_BUTTON_TEXT_{$language.id_lang|escape:'htmlall':'UTF-8'}" placeholder="{l s='Title' mod='psagechecker'}">
                    <div class="help-block">
                        <p>{l s='Character limit : 20' mod='psagechecker'}</p>
                    </div>
                </div>
                {if $languages|count > 1}
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-3">
                        <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                            {$language.iso_code|escape:'htmlall':'UTF-8'}
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            {foreach from=$languages item=lang}
                                <li>
                                    <a class="currentLang" data-id="{$lang.id_lang|escape:'htmlall':'UTF-8'}" href="javascript:hideOtherLanguage('{$lang.id_lang|escape:'javascript'}');" tabindex="-1">
                                        {$lang.name|escape:'htmlall':'UTF-8'}
                                    </a>
                                </li>
                            {/foreach}
                        </ul>
                    </div>
                {/if}
            </div>
            {if $languages|count > 1}
                </div>
            {/if}
        {/foreach}
        {* PS AGE CHECHER CONFIRM BUTTON *}

        {* PS AGE CHECKER DENY BUTTON *}
        {foreach from=$languages item=language}
            {if $languages|count > 1}
                <div class="translatable-field lang-{$language.id_lang|escape:'htmlall':'UTF-8'}" {if $language.id_lang != $defaultFormLanguage}style="display:none"{/if}>
            {/if}
            <div class="form-group confirm_deny ">
                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                    <div class="text-right">
                        <label class="control-label">
                            {l s='Deny button text' mod='psagechecker'}
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-2">
                    <input class="" maxlength="20" type="text" value="{if isset($deny_button_text)}{$deny_button_text[$language.id_lang]|escape:'htmlall':'UTF-8'}{/if}" name="PS_AGE_CHECKER_DENY_BUTTON_TEXT_{$language.id_lang|escape:'htmlall':'UTF-8'}" placeholder="{l s='Title' mod='psagechecker'}">
                    <div class="help-block">
                        <p>{l s='Character limit : 20' mod='psagechecker'}</p>
                    </div>
                </div>
                {if $languages|count > 1}
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-3">
                        <button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                            {$language.iso_code|escape:'htmlall':'UTF-8'}
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            {foreach from=$languages item=lang}
                                <li>
                                    <a class="currentLang" data-id="{$lang.id_lang|escape:'htmlall':'UTF-8'}" href="javascript:hideOtherLanguage('{$lang.id_lang|escape:'javascript'}');" tabindex="-1">
                                        {$lang.name|escape:'htmlall':'UTF-8'}
                                    </a>
                                </li>
                            {/foreach}
                        </ul>
                    </div>
                {/if}
            </div>
            {if $languages|count > 1}
                </div>
            {/if}
        {/foreach}
        {* PS AGE CHECHER DENY BUTTON *}
    </div>
    <div class="tab-pane" id="billy" role="tabpanel" aria-labelledby="billy-tab">

        {* PS AGE CHECKER POP UP HEIGHT *}
        <div class="form-group" style="margin-top:20px">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                <div class="text-right">
                    <label class="control-label">
                            {l s='Popup height' mod='psagechecker'}
                    </label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-3">
                <input class="addons-number-fields addons-inline-block" required="required" value="{$popup_height|escape:'htmlall':'UTF-8'}" type="number" name="PS_AGE_CHECKER_POPUP_HEIGHT">
                {l s='px' mod='psagechecker'}
            </div>
        </div>
        {* PS AGE CHECKER POP UP HEIGHT *}

        {* PS AGE CHECKER POP UP WIDTH *}
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                <div class="text-right">
                    <label class="control-label">
                            {l s='Popup width' mod='psagechecker'}
                    </label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-3">
                <input class="addons-number-fields addons-inline-block" required="required" value="{$popup_width|escape:'htmlall':'UTF-8'}" type="number" name="PS_AGE_CHECKER_POPUP_WIDTH">
                {l s='px' mod='psagechecker'}
            </div>
        </div>
        {* PS AGE CHECKER POP UP WIDTH *}

        {* PS AGE CHECKER BG COLOR *}
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                <div class="text-right">
                    <label class="control-label">
                        {l s='Background color' mod='psagechecker'}
                    </label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-2">
                <div class="input-group">
                    <input type="text" data-hex="true" class="color mColorPickerInput mColorPicker" name="PS_AGE_CHECKER_BACKGROUND_COLOR" value="{if isset($background_color)}{$background_color|escape:'htmlall':'UTF-8'}{/if}" id="color_1" style="background-color:{if isset($background_color)}{$background_color|escape:'htmlall':'UTF-8'}{/if}; color: back;"><span style="cursor:pointer;" id="icp_color_1" class="mColorPickerTrigger input-group-addon" data-mcolorpicker="true"><img src="../img/admin/color.png" style="border:0;margin:0 0 0 3px" align="absmiddle"></span>
                </div>
            </div>
        </div>
        {* PS AGE CHECKER BG COLOR *}

        {* PS AGE CHECKER POP UP OPACITY *}
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                <div class="text-right">
                    <label class="control-label">
                        {l s='Opacity' mod='psagechecker'}
                    </label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-3">
                <div class="input-group">
                    <input id="CB-OPACITY" name="CB-BG-OPACITY-SLIDER" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="{$opacity_slider|escape:'htmlall':'UTF-8'}"/>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                <div class="input-group">
                    <input class="cookiebanner-number" required="required" value="{$opacity_slider|escape:'htmlall':'UTF-8'}" type="number" name="PS_AGE_CHECKER_OPACITY" min="0" max="100">
                </div>
            </div>
        </div>
        {* PS AGE CHECKER POP UP OPACITY *}

        {* PS AGE CHECKER DISPLAY IMAGE *}
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                <div class="text-right">
                    <label class="boldtext control-label">{l s='Display a custom image on your pop up' mod='psagechecker'}</label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                <span class="switch prestashop-switch fixed-width-lg">
                    <input class="yes input_upload_img js-upload-img" type="radio" name="PS_AGE_CHECKER_SHOW_IMAGE" id="display_image_on" data-toggle="collapse" data-target="#" value="1" {if $show_image eq 1}checked="checked"{/if}>
                    <label for="display_image_on" class="radioCheck">{l s='YES' mod='psagechecker'}</label>

                    <input class="no input_upload_img" type="radio" name="PS_AGE_CHECKER_SHOW_IMAGE" id="display_image_off" data-toggle="collapse" data-target="#" value="0" {if $show_image eq 0}checked="checked"{/if}>
                    <label for="display_image_off" class="radioCheck">{l s='NO' mod='psagechecker'}</label>
                    <a class="slide-button btn"></a>
                </span>
            </div>
        </div>
        {* PS AGE CHECKER DISPLAY IMAGE *}

        {* PS AGE CHECKER UPLOAD IMAGE *}
        <div id="upload-image" class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                <div class="text-right">
                    <label class="boldtext control-label">{l s='Upload an image' mod='psagechecker'}</label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-3">
                <div class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-default">
                            <i class="icon-file"></i>
                        </span>
                    </label>
                    <input type="text" class="slide_url" value="{if isset($slide)}{$slide->image|escape:'htmlall':'UTF-8'}{/if}" name="slide-image" class="form-control" readonly>
                    <label class="input-group-btn">
                        <span class="btn btn-default">
                            <i class="icon-folder-open"></i> {l s='Choose a file' mod='psagechecker'}<input type="file" id="slide_image" class="slide_image" data-preview="image-preview" name="image" style="display: none;">
                        </span>
                    </label>
                </div>
                {if isset($slide)}
                    <img id="image-preview" class="img-thumbnail" src="{$baseUrl|escape:'htmlall':'UTF-8'}{$slide->image}" alt="" />
                {else}
                    <img id="image-preview" class="img-thumbnail hide" src="" alt=""/>
                {/if}


            </div>
        </div>
        {* PS AGE CHECKER UPLOAD IMAGE *}

        {* PS AGE CHECKER CONFIRM BUTTON BG COLOR *}
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                <div class="text-right">
                    <label class="control-label">
                        {l s='Confirm button background color' mod='psagechecker'}
                    </label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-2">
                <div class="input-group">
                    <input type="text" data-hex="true" class="color mColorPickerInput mColorPicker" name="PS_AGE_CHECKER_CONFIRM_BUTTON_BACKGROUND_COLOR" value="{if isset($confirm_button_bground_color)}{$confirm_button_bground_color|escape:'htmlall':'UTF-8'}{/if}" id="color_4" style="background-color:{if isset($confirm_button_bground_color)}{$confirm_button_bground_color|escape:'htmlall':'UTF-8'}{/if}; color: back;"><span style="cursor:pointer;" id="icp_color_4" class="mColorPickerTrigger input-group-addon" data-mcolorpicker="true"><img src="../img/admin/color.png" style="border:0;margin:0 0 0 3px" align="absmiddle"></span>
                </div>
            </div>
        </div>
        {* PS AGE CHECKER CONFIRM BUTTON BG COLOR *}

        {* PS AGE CHECKER CONFIRM BUTTON TXT COLOR *}
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                <div class="text-right">
                    <label class="control-label">
                        {l s='Confirm button text color' mod='psagechecker'}
                    </label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-2">
                <div class="input-group">
                    <input type="text" data-hex="true" class="color mColorPickerInput mColorPicker" name="PS_AGE_CHECKER_CONFIRM_BUTTON_TXT_COLOR" value="{if isset($confirm_button_text_color)}{$confirm_button_text_color|escape:'htmlall':'UTF-8'}{/if}" id="color_2" style="background-color:{if isset($confirm_button_text_color)}{$confirm_button_text_color|escape:'htmlall':'UTF-8'}{/if}; color: back;"><span style="cursor:pointer;" id="icp_color_2" class="mColorPickerTrigger input-group-addon" data-mcolorpicker="true"><img src="../img/admin/color.png" style="border:0;margin:0 0 0 3px" align="absmiddle"></span>
                </div>
            </div>
        </div>
        {* PS AGE CHECKER CONFIRM BUTTON TXT COLOR *}

        {* PS AGE CHECKER DENY BUTTON BG COLOR *}
        <div class="form-group confirm_deny">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                <div class="text-right">
                    <label class="control-label">
                        {l s='Deny button background color' mod='psagechecker'}
                    </label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-2">
                <div class="input-group">
                    <input type="text" data-hex="true" class="color mColorPickerInput mColorPicker" name="PS_AGE_CHECKER_DENY_BUTTON_BACKGROUND_COLOR" value="{if isset($deny_button_bground_color)}{$deny_button_bground_color|escape:'htmlall':'UTF-8'}{/if}" id="color_3" style="background-color:{if isset($deny_button_bground_color)}{$deny_button_bground_color|escape:'htmlall':'UTF-8'}{/if}; color: back;"><span style="cursor:pointer;" id="icp_color_3" class="mColorPickerTrigger input-group-addon" data-mcolorpicker="true"><img src="../img/admin/color.png" style="border:0;margin:0 0 0 3px" align="absmiddle"></span>
                </div>
            </div>
        </div>
        {* PS AGE CHECKER DENY BUTTON BG COLOR *}

        {* PS AGE CHECKER DENY BUTTON TXT COLOR *}
        <div class="form-group confirm_deny">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-3">
                <div class="text-right">
                    <label class="control-label">
                        {l s='Deny button text color' mod='psagechecker'}
                    </label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-2">
                <div class="input-group">
                    <input type="text" data-hex="true" class="color mColorPickerInput mColorPicker" name="PS_AGE_CHECKER_DENY_BUTTON_TXT_COLOR" value="{if isset($deny_button_text_color)}{$deny_button_text_color|escape:'htmlall':'UTF-8'}{/if}" id="color_5" style="background-color:{if isset($deny_button_text_color)}{$deny_button_text_color|escape:'htmlall':'UTF-8'}{/if}; color: back;"><span style="cursor:pointer;" id="icp_color_5" class="mColorPickerTrigger input-group-addon" data-mcolorpicker="true"><img src="../img/admin/color.png" style="border:0;margin:0 0 0 3px" align="absmiddle"></span>
                </div>
            </div>
        </div>
        {* PS AGE CHECKER DENY BUTTON TXT COLOR *}
    </div>
    </div>
    </div>
    {* PS AGE CHECKER SUBMIT BUTTON *}
    <div class="panel-footer">
        <button type="submit" value="1" name="submitpsagecheckerModule" class="btn btn-default pull-right">
            <i class="process-icon-save"></i> {l s='Save' mod='psagechecker'}
        </button>
    </div>
    {* PS AGE CHECKER SUBMIT BUTTON *}
</div>
</form>
