{*
 *  Leo Theme for Prestashop 1.6.x
 *
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
*}
<div id="livethemeeditor">
    <form  enctype="multipart/form-data" action="{$actionURL|escape:'html':'UTF-8'}" id="form" method="post">
        <div id="leo-customize" class="leo-customize">
            <div class="btn-show">{l s='Customize' mod='leotempcp'}<span class="icon-wrench"></span></div>
            <div class="wrapper"><div id="customize-form">
                    <p>  
                        <span class="badge">{l s='Theme' mod='leotempcp'}{$themeName|escape:'html':'UTF-8'}</span>   <a class="label label-default pull-right" href="{$backLink|escape:'html':'UTF-8'}">{l s='Back' mod='leotempcp'}</a>  
                    </p>        

                    <div class="buttons-group">
                        <input type="hidden" id="action-mode" name="action-mode">   
                        <a onclick="$('#action-mode').val('save-edit');
                                $('#form').submit();" class="btn btn-primary btn-xs" href="#" type="submit">{l s='Submit' mod='leotempcp'}</a>
                        <a onclick="$('#action-mode').val('save-delete');
                                $('#form').submit();" class="btn btn-danger btn-xs show-for-existed" href="#" type="submit">{l s='Delete' mod='leotempcp'}</a>
                    </div>
                    <hr>
                    <div class="groups">
                        <div class="form-group clearfix">
                            <label>{l s='Edit for' mod='leotempcp'}</label> 
                            <select id="saved-files" name="saved_file" class="form-control">
                                <option value="">{l s='create new' mod='leotempcp'}</option>
                                {foreach $profiles as $profile}
                                    <option value="{$profile|escape:'html':'UTF-8'}">{$profile|escape:'html':'UTF-8'}</option>
                                {/foreach}
                            </select> 
                        </div>
                        <div class="form-group clearfix">
                            <label class="show-for-notexisted pull-left">{l s='Or  Save New' mod='leotempcp'}&nbsp;&nbsp;&nbsp;</label><label class="show-for-existed">{l s='And Rename File To' mod='leotempcp'}</label>
                            <input type="text" name="newfile">
                        </div>  
                        <div class="form-group clearfix">
                        <a href="{$imgLink|escape:'html':'UTF-8'}" class="btn btn btn-default btn-xs" id="upload_pattern">{l s='Upload other pattern' mod='leotempcp'}</a>
                        </div>
                    <hr>
                        <div class="clearfix" id="customize-body">
                            <ul id="myCustomTab" class="nav nav-tabs">
                                {foreach $xmlselectors as $for => $output}
                                    <li><a href="#tab-{$for|escape:'html':'UTF-8'}">{$for|escape:'html':'UTF-8'}</a></li> 
                                    {/foreach}  
                            </ul>
                            <div class="tab-content" > 
                                {foreach $xmlselectors as $for => $items}
                                    <div class="tab-pane" id="tab-{$for|escape:'html':'UTF-8'}">

                                        {if !empty($items)}
                                            <div class="accordion"  id="custom-accordion">
                                                {foreach $items as $group}
                                                    <div class="accordion-group panel panel-default">
                                                        <div class="accordion-heading panel-heading">
                                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#custom-accordion" href="#collapse{$group.match|escape:'html':'UTF-8'}">
                                                                {$group.header}{* HTML form , no escape necessary *}
                                                            </a>
                                                        </div>

                                                        <div id="collapse{$group.match|escape:'html':'UTF-8'}" class="accordion-body collapse">
                                                            <div class="accordion-inner panel-body clearfix">
                                                                {foreach $group.selector as $item}

                                                                    {if isset($item.type)&&$item.type=="image"} 
                                                                        <div class="form-group background-images cleafix"> 
                                                                            <label>{$item.label|escape:'html':'UTF-8'}</label>
                                                                            <a class="clear-bg label label-success" href="#">{l s='Clear' mod='leotempcp'}</a>
                                                                            <input value="" type="hidden" name="customize[{$group.match|escape:'html':'UTF-8'}][]" data-match="{$group.match|escape:'html':'UTF-8'}" class="input-setting" data-selector="{$item.selector|escape:'html':'UTF-8'}" data-attrs="background-image">

                                                                            <div class="clearfix"></div>
                                                                            <p><em style="font-size:10px">{l s='Those Images in folder YOURTHEME/img/patterns/' mod='leotempcp'}</em></p>
                                                                            <div class="bi-wrapper clearfix">
                                                                                {foreach $patterns as $pattern}
                                                                                    <div style="background:url('{$backgroundImageURL|escape:'html':'UTF-8'}{$pattern|escape:'html':'UTF-8'}') no-repeat center center;" class="pull-left" data-image="{$backgroundImageURL|escape:'html':'UTF-8'}{$pattern|escape:'html':'UTF-8'}" data-val="../../img/patterns/{$pattern|escape:'html':'UTF-8'}">

                                                                                    </div>
                                                                                {/foreach}
                                                                            </div>
                                                                            <ul class="bg-config">
                                                                                <li>
                                                                                    <div>{l s='Attachment' mod='leotempcp'}</div>
                                                                                    <select data-attrs="background-attachment" name="customize[{$group.match|escape:'html':'UTF-8'}][]" data-selector="{$item.selector|escape:'html':'UTF-8'}" data-match="{$group.match|escape:'html':'UTF-8'}">
                                                                                        <option value="">{l s='Not set' mod='leotempcp'}</option>
                                                                                        {foreach $backGroundValue.attachment as $attachment}
                                                                                            <option value="{$attachment|escape:'html':'UTF-8'}">{$attachment|escape:'html':'UTF-8'}</option>
                                                                                        {/foreach}
                                                                                    </select>
                                                                                </li>
                                                                                <li>
                                                                                    <div>{l s='Position' mod='leotempcp'}</div>
                                                                                    <select data-attrs="background-position" name="customize[{$group.match|escape:'html':'UTF-8'}][]" data-selector="{$item.selector|escape:'html':'UTF-8'}" data-match="{$group.match|escape:'html':'UTF-8'}">
                                                                                        <option value="">{l s='Not set' mod='leotempcp'}</option>
                                                                                        {foreach $backGroundValue.position as $position}
                                                                                            <option value="{$position|escape:'html':'UTF-8'}">{$position|escape:'html':'UTF-8'}</option>
                                                                                        {/foreach}
                                                                                    </select>
                                                                                </li>
                                                                                <li>
                                                                                    <div>{l s='Repeat' mod='leotempcp'}</div>
                                                                                    <select data-attrs="background-repeat" name="customize[{$group.match|escape:'html':'UTF-8'}][]" data-selector="{$item.selector|escape:'html':'UTF-8'}" data-match="{$group.match|escape:'html':'UTF-8'}">
                                                                                        <option value="">{l s='Not set' mod='leotempcp'}</option>
                                                                                        {foreach $backGroundValue.repeat as $repeat}
                                                                                            <option value="{$repeat|escape:'html':'UTF-8'}">{$repeat|escape:'html':'UTF-8'}</option>
                                                                                        {/foreach}
                                                                                    </select>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    {elseif $item.type=="fontsize"}
                                                                        <div class="form-group cleafix">
                                                                            <label>{$item.label|escape:'html':'UTF-8'}</label>
                                                                            <select name="customize[{$group.match|escape:'html':'UTF-8'}][]" data-match="{$group.match|escape:'html':'UTF-8'}" type="text" class="input-setting" data-selector="{$item.selector|escape:'html':'UTF-8'}" data-attrs="{$item.attrs|escape:'html':'UTF-8'}">
                                                                                <option value="">Inherit</option>
                                                                                {for $i=9 to 16}
                                                                                    <option value="{$i|escape:'html':'UTF-8'}">{$i|escape:'html':'UTF-8'}</option>
                                                                                {/for}
                                                                            </select>   <a href="#" class="clear-bg label label-success">{l s='Clear' mod='leotempcp'}</a>
                                                                        </div>
                                                                    {else}
                                                                        <div class="form-group cleafix">
                                                                            <label>{$item.label|escape:'html':'UTF-8'}</label>
                                                                            <input value="" size="10" name="customize[{$group.match|escape:'html':'UTF-8'}][]" data-match="{$group.match|escape:'html':'UTF-8'}" type="text" class="input-setting" data-selector="{$item.selector|escape:'html':'UTF-8'}" data-attrs="{$item.attrs|escape:'html':'UTF-8'}"><a href="#" class="clear-bg label label-success">{l s='Clear' mod='leotempcp'}</a>
                                                                        </div>
                                                                    {/if}


                                                                {/foreach}
                                                            </div>
                                                        </div>
                                                    </div>              
                                                {/foreach}
                                            </div>
                                        {/if}
                                    </div>
                                {/foreach}
                            </div>      
                        </div>    
                    </div>
                </div></div></div>
    </form>
    <div id="main-preview">
        <iframe src="{$siteURL|escape:'html':'UTF-8'}" ></iframe> 
    </div>
</div>
        <script>
        var customizeFolderURL = '{$customizeFolderURL|escape:'html':'UTF-8'}';
        </script>