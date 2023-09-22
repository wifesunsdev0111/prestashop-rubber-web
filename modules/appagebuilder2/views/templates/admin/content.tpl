{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\admin\content -->
{extends file="helpers/form/form.tpl"}
{block name="field"}
    {if $input.type == 'ApRow'}
        {include file='./ApRow.tpl'}
    {/if}
    {if $input.type == 'tabConfig'}
        <div class="row">
            {assign var=tabList value=$input.values}
            <ul class="nav nav-tabs" role="tablist">
            {foreach $tabList as $key => $value name="tabList"}
                <li role="presentation" class="{if $smarty.foreach.tabList.first}active{/if}"><a href="#{$key|escape:'html':'UTF-8'}" class="aptab-config" role="tab" data-toggle="tab">{$value|escape:'html':'UTF-8'}</a></li>
            {/foreach}
            </ul>
        </div>
    {/if}
    {if $input.type == 'bg_img'}
        <div class="col-lg-9 ">
            <input type="text" name="bg_img" id="bg_img" value="" class=""><a href="javascript:void(0)" class="select-img">{l s='Select image ' mod='appagebuilder'}</a>
            <p class="help-block">{l s='Please put image link or select image' mod='appagebuilder'}</p>
        </div>
    {/if}    
    {if $input.type == 'apExceptions'}
        <div class="well">
                <div>
                        {l s='Please specify the files for which you do not want it to be displayed.' mod='appagebuilder'}<br />
                        {l s='Please input each filename, separated by a comma (",").' mod='appagebuilder'}<br />
                        {l s='You can also click the filename in the list below, and even make a multiple selection by keeping the Ctrl key pressed while clicking, or choose a whole range of filename by keeping the Shift key pressed while clicking.' mod='appagebuilder'}<br />
                        {$exception_list}{* HTML form , no escape necessary *}
                </div>
        </div>
    {/if}
    {if $input.type == 'ApColumnclass' || $input.type == 'ApRowclass'}
        <div class="">
            <div class="well">
                <div class="row">
                   {if $input.type == 'ApRowclass'} 
                   <label class="choise-class col-lg-12"><input type="checkbox" class="select-class" data-value="row" value="1"> {l s='Use class row' mod='appagebuilder'}</label>
                   {/if}
                   <label class="control-label col-lg-1">{l s='Class:' mod='appagebuilder'}</label>
                    <div class="col-lg-11"><input type="text" class="element_class" value="{$fields_value['class']|escape:'html':'UTF-8'}" name="class"></div>
                </div><br/>
                <div class="desc-bottom">
                {l s='Insert new or select classes for toggling content across viewport breakpoints' mod='appagebuilder'}<br>
                <ul class="ap-col-class">
                    <li>
                        <label class="choise-class"><input class="select-class" type="checkbox" data-value="hidden-lg" value="1"> {l s='Hidden in Large devices' mod='appagebuilder'}</label>
                    </li>
                    <li>
                        <label class="choise-class"><input class="select-class" type="checkbox" data-value="hidden-md" value="1"> {l s='Hidden in Medium devices' mod='appagebuilder'}</label>
                    </li>
                    <li>    
                        <label class="choise-class"><input class="select-class" type="checkbox" data-value="hidden-sm" value="1"> {l s='Hidden in Small devices' mod='appagebuilder'}</label>
                    </li>
                    <li>
                        <label class="choise-class"><input class="select-class" type="checkbox" data-value="hidden-xs" value="1"> {l s='Hidden in Extra small devices' mod='appagebuilder'}</label>
                    </li>
                    <li>
                        <label class="choise-class"><input class="select-class" type="checkbox" data-value="hidden-sp" value="1"> {l s='Hidden in Smart Phone' mod='appagebuilder'}</label>
                    </li>
                </ul>
                </div>
            </div>
        </div>
    {/if}
    
    {if $input.type == 'bg_select'}
        {$image_uploader}{* HTML form , no escape necessary *}
    {/if}
    {if $input.type == 'column_width'}
        <div class="panel panel-default">
            <div class="panel-body">
                <p>{l s='Responsive: You can config width for each Devices' mod='appagebuilder'}</p>
            </div>
            <table class="table">
                <thead><tr>
                      <th>{l s='Devices' mod='appagebuilder'}</th>
                      <th>{l s='Width' mod='appagebuilder'}</th>
                </tr></thead>
                <tbody>
                    {foreach $input.columnGrids as $gridKey=>$gridValue}
                    <tr>
                        <td>
                            <span class="col-{$gridKey|escape:'html':'UTF-8'}"></span>
                            {$gridValue|escape:'html':'UTF-8'}
                        </td>
                        <td>
                            <div class="btn-group">
                                <input type='hidden' class="col-val" name='{$gridKey|escape:'html':'UTF-8'}' value="{$fields_value[$gridKey]|escape:'html':'UTF-8'}"/>
                                <button type="button" class="btn btn-default apbtn-width dropdown-toggle" tabindex="-1" data-toggle="dropdown">
                                    <span class="width-val ap-w-{$fields_value[$gridKey]|replace:'.':'-'|escape:'html':'UTF-8'}">{$fields_value[$gridKey]|escape:'html':'UTF-8'}/12 - ( {math equation="x/y*100" x=$fields_value[$gridKey] y=12 format="%.2f"} % )</span><span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    {foreach from=$widthList item=itemWidth}
                                    <li>
                                        <a class="width-select" href="javascript:void(0);" tabindex="-1">                                          
                                            <span data-width="{$itemWidth|escape:'html':'UTF-8'}" class="width-val ap-w-{if $itemWidth|strpos:"."|escape:'html':'UTF-8'}{$itemWidth|replace:'.':'-'|escape:'html':'UTF-8'}{else}{$itemWidth|escape:'html':'UTF-8'}{/if}">{$itemWidth|escape:'html':'UTF-8'}/12 - ( {math equation="x/y*100" x=$itemWidth y=12 format="%.2f"} % )</span>
                                        </a>
                                    </li>
                                    {/foreach}
                                </ul>
                            </div>
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    {/if}
    {$smarty.block.parent}
{/block}