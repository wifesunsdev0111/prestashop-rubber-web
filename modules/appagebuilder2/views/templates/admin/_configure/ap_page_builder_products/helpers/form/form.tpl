{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\admin\_configure\ap_page_builder_products\helpers\form\form -->
{extends file="helpers/form/form.tpl"}
{block name="field"}
    
    {if $input.type == 'ap_proGrid'}
        <div class="col-lg-9 {$input.type|escape:'html':'UTF-8'}">
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="panel product-container">
                        <div class="desc-box">product-container</div>
                            {foreach $input.blockList key=kBlock item=vblock}
                                <div class="{$vblock|escape:'html':'UTF-8'}">
                                    <div class="panel-heading">{$vblock|escape:'html':'UTF-8'}</div>
                                    <div class="content {$kBlock|escape:'html':'UTF-8'}-block-content">
                                    {assign var=blockElement value=$input.params[$kBlock]}
                                    {foreach $blockElement item=gridElement}
                                        {if $gridElement.name == 'functional_buttons'}
                                            {assign var=iconVal value='icon-puzzle-piece'}
                                            {assign var=NameVal value=$gridElement.name}
                                        {else if $gridElement.name == 'code'}
                                            {assign var=iconVal value='icon-code'}
                                            {assign var=NameVal value='code'}
                                        {else}
                                            {assign var=iconVal value=$input.elements[$gridElement.name]['icon']}
                                            {assign var=NameVal value=$input.elements[$gridElement.name]['name']}
                                        {/if}
                                        <div class="{$gridElement.name|escape:'html':'UTF-8'} plist-element" data-element='{$gridElement.name|escape:'html':'UTF-8'}'><i class="{$iconVal|escape:'html':'UTF-8'}"></i> {$NameVal|escape:'html':'UTF-8'}
                                            {if $gridElement.name == 'code'}
                                            <div class="desc-box"><i class="icon-code"></i> tpl code</div>
                                            {/if}
                                            <div class="pull-right">
                                                <a class="plist-eremove"><i class="icon-trash"></i></a>
                                                <a class="plist-eedit" data-element='{$gridElement.name|escape:'html':'UTF-8'}'><i class="icon-edit"></i></a>
                                            </div>
                                            {if $gridElement.name == 'functional_buttons'}
                                                <div class="content">
                                                    {if isset($gridElement.element)}
                                                    {foreach $gridElement.element item=gridSubElement}
                                                        {if $gridSubElement.name == 'code'}
                                                            {assign var=iconVal value='icon-code'}
                                                            {assign var=NameVal value='code'}
                                                        {else}
                                                            {assign var=iconVal value=$input.elements[$gridSubElement.name]['icon']}
                                                            {assign var=NameVal value=$input.elements[$gridSubElement.name]['name']}
                                                        {/if}
                                                        <div class="{$gridSubElement.name|escape:'html':'UTF-8'} plist-element" data-element='{$gridSubElement.name|escape:'html':'UTF-8'}'><i class="{$iconVal|escape:'html':'UTF-8'}"></i> {$NameVal|escape:'html':'UTF-8'}
                                                            {if $gridSubElement.name == 'code'}
                                                            <div class="desc-box"><i class="icon-code"></i> tpl code</div>
                                                            {/if}
                                                            <div class="pull-right">
                                                                <a class="plist-eremove"><i class="icon-trash"></i></a>
                                                                <a class="plist-eedit" data-element='{$gridSubElement.name|escape:'html':'UTF-8'}'><i class="icon-edit"></i></a>
                                                            </div>
                                                            {if $gridSubElement.name == 'code'}
                                                                <div class="content-code">
                                                                    <textarea name="filecontent" id="filecontent" rows="5" value="" class="">{$gridSubElement.code}{*contain html, no need escape*}</textarea>
                                                                </div>
                                                            {/if}
                                                        </div>
                                                    {/foreach}
                                                    {/if}
                                                </div>
                                            {/if}
                                            {if $gridElement.name == 'code'}
																								
                                                <div class="content-code">
                                                    <textarea name="filecontent" rows="5" class="">{$gridElement.code}{*contain html, no need escape*}</textarea>
                                                </div>
                                            {/if}
                                        </div>
                                    {/foreach}
                                    </div>
                                </div>
                            {/foreach}
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 element-list content">
                    {foreach from=$input.elements key=eKey item=eItem}
                    <div class="{$eKey|escape:'html':'UTF-8'} plist-element" data-element='{$eKey|escape:'html':'UTF-8'}'><i class="{$eItem.icon|escape:'html':'UTF-8'}"></i> {$eItem.name|escape:'html':'UTF-8'}
                        <div class="pull-right">
                            <a class="plist-eremove"><i class="icon-trash"></i></a>
                            <a class="plist-eedit" data-element='{$eKey|escape:'html':'UTF-8'}'><i class="icon-edit"></i></a>
                        </div>
                    </div>
                    {/foreach}
                    <div class="code plist-element" data-element='code'>
                        <div class="desc-box"><i class="icon-code"></i> tpl code</div>
                        <div class="pull-right">
                            <a class="plist-code"><i class="icon-code"></i></a>
                            <a class="plist-eremove"><i class="icon-trash"></i></a>
                        </div>
                        <div class="content-code">
                            <textarea name="filecontent" rows="5" class=""></textarea>
                        </div>
                    </div>
                    
                    <div class="functional_buttons plist-element" data-element='functional_buttons'>
                        <div class="desc-box"><i class="icon-puzzle-piece"></i> functional-buttons</div>
                        <div class="pull-right">
                            <a class="plist-eremove"><i class="icon-trash"></i></a>
                        </div>
                        <div class="content"></div>
                    </div>
                </div>
            </div>
        </div>
    {/if}
    
    {$smarty.block.parent}
{/block}