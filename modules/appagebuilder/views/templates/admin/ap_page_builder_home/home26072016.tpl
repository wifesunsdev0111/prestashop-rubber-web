{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\admin\ap_page_builder_home\home -->
{if isset($errorText) && $errorText}
<div class="error alert alert-danger">
    {$errorText|escape:'html':'UTF-8'}
</div>
{/if}
<div id="top_wrapper">
    <a class="btn btn-default btn-form-toggle" title="{l s='Expand or Colapse' mod='appagebuilder'}">
        <i class="icon-resize-small"></i>
    </a>
    <a class="btn btn-default btn-fwidth width-default" data-width="auto">{l s='Default' mod='appagebuilder'}</a>
    <a class="btn btn-default btn-fwidth width-large" data-width="1200">{l s='Large' mod='appagebuilder'}</a>
    <a class="btn btn-default btn-fwidth width-medium" data-width="992">{l s='Medium' mod='appagebuilder'}</a>
    <a class="btn btn-default btn-fwidth width-small" data-width="768">{l s='Small' mod='appagebuilder'}</a>
    <a class="btn btn-default btn-fwidth width-extra-small" data-width="603">{l s='Extra Small' mod='appagebuilder'}</a>
    <a class="btn btn-default btn-fwidth width-mobile" data-width="480">{l s='Mobile' mod='appagebuilder'}</a>
    <div class="pull-right control-right">
        <div class="dropdown">
            <a id="current_profile" class="btn btn-default" role="button" data-toggle="dropdown" data-target="#" data-id='{$currentProfile.id_appagebuilder_profiles|escape:'html':'UTF-8'}'>
              <i class="icon-file-text"></i> {l s='Current Profile:' mod='appagebuilder'} {$currentProfile.name|escape:'html':'UTF-8'}{if $profilesList} <span class="caret"></span>{/if}
            </a>
            {if $profilesList}
            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                {foreach from=$profilesList item=profile}
                <li><a class="btn btn-select-profile" href="{$ajaxHomeUrl|escape:'html':'UTF-8'}&id_appagebuilder_profiles={$profile.id_appagebuilder_profiles|escape:'html':'UTF-8'}">{$profile.name|escape:'html':'UTF-8'}</a></li>
                {/foreach}
            </ul>
            {/if}
        </div>
        
        <a class="btn btn-default btn-form-action btn-import" data-text="{l s='Import Form' mod='appagebuilder'}"><i class="icon-cloud-upload"></i> {l s='Import' mod='appagebuilder'}</a>
        <div class="dropdown">
            <a class="btn btn-default export_button" role="button" data-toggle="dropdown" data-target="#" href="/page.html">
              <i class="icon-cloud-download"></i> {l s='Export Data' mod='appagebuilder'} <span class="caret"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dLabel">
                <li><a class="btn export-from btn-export" data-type="all"><strong>{l s='Profile' mod='appagebuilder'}</strong></a></li>
                {foreach from=$exportItems key=position item=hookData}
                <li><a class="btn export-from btn-export" data-type="position" data-position="{$position|lower|escape:'html':'UTF-8'}"><strong>{l s='Position' mod='appagebuilder'} {$position|escape:'html':'UTF-8'}</strong></a></li>
                    {foreach from=$hookData item=hook}
                <li><a class="btn export-from btn-export" data-type="{$hook|escape:'html':'UTF-8'}">-------- Hook {$hook|escape:'html':'UTF-8'}</a></li>
                    {/foreach}
                {/foreach}
            </ul>
        </div>
    </div>
</div>
<div id="home_wrapper" class="default">
    <div class="position-cover row" id="position-header">
    {include file='./position.tpl' position='Header' config=$positions.header listPositions=$listPositions.header default=$currentPosition.header}
    </div>
    <div class="position-cover row" id="position-content">
    {include file='./position.tpl' position='Content' config=$positions.content listPositions=$listPositions.content default=$currentPosition.content}
    </div>
    <div class="position-cover row" id="position-footer">
    {include file='./position.tpl' position='Footer' config=$positions.footer listPositions=$listPositions.footer default=$currentPosition.footer}
    </div>
    <div class="position-cover row" id="position-product">
    {include file='./position.tpl' position='Product' config=$positions.product listPositions=$listPositions.product default=$currentPosition.product}
    </div>
    
</div>
<div id="bottom_wrapper">
    <a class="btn btn-default btn-form-toggle" title="{l s='Expand or Colapse' mod='appagebuilder'}">
        <i class="icon-resize-small"></i>
    </a>
    <a class="btn btn-default btn-fwidth width-default" data-width="auto">{l s='Default' mod='appagebuilder'}</a>
    <a class="btn btn-default btn-fwidth width-large" data-width="1200">{l s='Large' mod='appagebuilder'}</a>
    <a class="btn btn-default btn-fwidth width-medium" data-width="992">{l s='Medium' mod='appagebuilder'}</a>
    <a class="btn btn-default btn-fwidth width-small" data-width="768">{l s='Small' mod='appagebuilder'}</a>
    <a class="btn btn-default btn-fwidth width-extra-small" data-width="603">{l s='Extra Small' mod='appagebuilder'}</a>
    <a class="btn btn-default btn-fwidth width-mobile" data-width="480">{l s='Mobile' mod='appagebuilder'}</a>
    
    <div class="pull-right control-right">
        <div class="dropdown">
            <a class="btn btn-default" role="button" data-toggle="dropdown" data-target="#" data-id='{$currentProfile.id_appagebuilder_profiles|escape:'html':'UTF-8'}'>
              <i class="icon-file-text"></i> {l s='Current Profile:' mod='appagebuilder'} {$currentProfile.name|escape:'html':'UTF-8'}{if $profilesList}<span class="caret"></span>{/if}
            </a>
            {if $profilesList}
            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                {foreach from=$profilesList item=profile}
                <li><a class="btn btn-select-profile" href="{$ajaxHomeUrl|escape:'html':'UTF-8'}&id_appagebuilder_profiles={$profile.id_appagebuilder_profiles|escape:'html':'UTF-8'}">{$profile.name|escape:'html':'UTF-8'}</a></li>
                {/foreach}
            </ul>
            {/if}
        </div>
        
        <a class="btn btn-default btn-form-action btn-import" data-text="{l s='Import Form' mod='appagebuilder'}"><i class="icon-cloud-upload"></i> {l s='Import' mod='appagebuilder'}</a>
        <div class="dropdown dropup">
            <a class="btn btn-default export_button" role="button" data-toggle="dropdown" data-target="#">
              <i class="icon-cloud-download"></i> {l s='Export Data' mod='appagebuilder'} <span class="caret"></span>
            </a>

            <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dLabel">
                <li><a class="btn export-from btn-export" data-type="all"><strong>{l s='Profile' mod='appagebuilder'}</strong></a></li>
                {foreach from=$exportItems key=position item=hookData}
                <li><a class="btn export-from btn-export" data-type="position" data-position="{$position|lower|escape:'html':'UTF-8'}"><strong>{l s='Position' mod='appagebuilder'} {$position|escape:'html':'UTF-8'}</strong></a></li>
                    {foreach from=$hookData item=hook}
                <li><a class="btn export-from btn-export" data-type="{$hook|escape:'html':'UTF-8'}">-------- Hook {$hook|escape:'html':'UTF-8'}</a></li>
                    {/foreach}
                {/foreach}
            </ul>
        </div>
    </div>
</div>
<div id="ap_loading" class="ap-loading">
    <div class="spinner">
        <div class="cube1"></div>
        <div class="cube2"></div>
    </div>
</div>
{include file="$tplPath/ap_page_builder_home/home_form.tpl"}
<script type="text/javascript">
		{addJsDef imgModuleLink=$imgModuleLink}
		{addJsDef apAjaxShortCodeUrl=$ajaxShortCodeUrl}
		{addJsDef apAjaxHomeUrl=$ajaxHomeUrl}
		{addJsDef apImgController=$imgController}
				
    $(document).ready(function(){
        var $apHomeBuilder = $(document).apPageBuilder();
        $apHomeBuilder.process('{$dataForm}{* HTML form , no escape necessary *}','{$shortcodeInfos}{* HTML form , no escape necessary *}','{$languages}{* HTML form , no escape necessary *}');
        $apHomeBuilder.ajaxShortCodeUrl = apAjaxShortCodeUrl;
        $apHomeBuilder.ajaxHomeUrl = apAjaxHomeUrl;
        $apHomeBuilder.lang_id = '{$lang_id|escape:'html':'UTF-8'}';
        $apHomeBuilder.imgController = apImgController;
        $apHomeBuilder.profileId = '{$idProfile|escape:'html':'UTF-8'}';
    });
</script>