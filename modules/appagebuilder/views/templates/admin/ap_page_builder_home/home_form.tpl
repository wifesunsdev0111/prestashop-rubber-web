{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\admin\ap_page_builder_home\home_form -->
{*form for group*}
<div id="form_content" style="display:none;" data-select="{l s='You are sure data saved, before select other profile?' mod='appagebuilder'}" data-delete="{l s='Are you sure you want to delete?' mod='appagebuilder'}" data-reduce="{l s='Minimum value of width is 1' mod='appagebuilder'}" data-increase="{l s='Maximum value of width is 12' mod='appagebuilder'}">
    <a id="export_process" href="" title="{l s='Export Process' mod='appagebuilder'}" download='group.txt' target="_blank" >{l s='Export Process' mod='appagebuilder'}</a>
    <div id="addnew-group-form">
        <ul class="list-group dropdown-menu">
            {foreach from=$widthList item=itemWidth}
                <li>
                    <a href="javascript:void(0);" data-width="{$itemWidth|escape:'html':'UTF-8'}" class="number-column">
                        <span class="width-val ap-w-{if $itemWidth|strpos:"."|escape:'html':'UTF-8'}{$itemWidth|replace:'.':'-'|escape:'html':'UTF-8'}{else}{$itemWidth|escape:'html':'UTF-8'}{/if}">{$itemWidth|escape:'html':'UTF-8'}/12 - ( {math equation="x/y*100" x=$itemWidth y=12 format="%.2f"} % )</span>
                    </a>
                </li>
            {/foreach}
        </ul>
    </div>
    <div id="addnew-column-form">
        <ul class="list-group dropdown-menu">
            {for $i=1 to 6}
                  <li>
                      <a href="javascript:void(0);" data-col="{$i|escape:'html':'UTF-8'}" data-width="{(12/$i)|replace:'.':'-'|escape:'html':'UTF-8'}" class="column-add">
                          <span class="width-val ap-w-{$i|escape:'html':'UTF-8'}">{$i|escape:'html':'UTF-8'} {l s='column per row' mod='appagebuilder'} - ( {math equation="100/$i" x=$i format="%.2f"} % )</span>
                      </a>
                  </li>
            {/for}
        </ul>
    </div>
    <div id="addnew-widget-group-form">
        <ul class="list-group dropdown-menu">
            <li>
                <a href="javascript:void(0);" data-col="0" data-width="0" class="group-add">
                    <span class="width-val ap-w-0">{l s='Create a group blank' mod='appagebuilder'}</span>
                </a>
            </li>
            {for $i=1 to 6}
              <li>
                  <a href="javascript:void(0);" data-col="{$i|escape:'html':'UTF-8'}" data-width="{(12/$i)|escape:'html':'UTF-8'}" class="group-add">
                      <span class="width-val ap-w-{$i|escape:'html':'UTF-8'}">{$i|escape:'html':'UTF-8'} {l s='column per row' mod='appagebuilder'} - ( {math equation="100/$i" x=$i format="%.2f"} % )</span>
                  </a>
              </li>
            {/for}
        </ul>
    </div>
    {foreach from=$shortcodeForm item=sform}
        {include file=$sform}
    {/foreach}
</div>


<div class="modal fade" id="modal_form"  data-backdrop="0" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
        <span class="sr-only">{l s='Close' mod='appagebuilder'}</span></button>
        
        <div class="box-search-widget">
            <input type="text" id="txt-search" placeholder="{l s='Search' mod='appagebuilder'}"/>
        </div>
        <h4 class="modal-title" id="myModalLabel" data-addnew="{l s='Add new Widget' mod='appagebuilder'}" data-edit="{l s='Editting' mod='appagebuilder'}"></h4>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-back-to-list pull-left">{l s='Back to List' mod='appagebuilder'}</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">{l s='Close' mod='appagebuilder'}</button>
        <button type="button" class="btn btn-primary btn-savewidget">{l s='Save changes' mod='appagebuilder'}</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modal_select_image" data-backdrop="0" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
        <span class="sr-only">{l s='Close' mod='appagebuilder'}</span></button>
        <h4 class="modal-title2">{l s='Image manager' mod='appagebuilder'}</h4>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{l s='Close' mod='appagebuilder'}</button>
      </div>
    </div>
  </div>
</div>