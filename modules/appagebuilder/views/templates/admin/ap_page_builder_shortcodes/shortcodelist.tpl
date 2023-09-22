{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\admin\ap_page_builder_shortcodes\shortcodelist -->
{if isset($importData)}
    
{else}
<ul class="nav nav-tabs" role="tablist" id="tab-new-widget">
    <li role="presentation" class="active"><a href="#widget" aria-controls="widget" role="tab" data-toggle="tab">Widget</a></li>
    <li role="presentation"><a href="#module" aria-controls="module" role="tab" data-toggle="tab">Module</a></li>
</ul>

<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="widget">
        <ol class="breadcrumb in-widget filters for-widget" data-for="widget">
            <li><a href="javascript:;"><button data-filter="*" class="btn is-checked">Show all</button></a></li>
            <li><a href="javascript:;"><button data-filter="content" class="btn">Content</button></a></li>
            <li><a href="javascript:;"><button data-filter="slider" class="btn">Slider</button></a></li>
            <li><a href="javascript:;"><button data-filter="social" class="btn">Social</button></a></li>
            <li><a href="javascript:;"><button data-filter="structure" class="btn">Structure</button></a></li>
        </ol>
        <div class="row" id="widget_container">
            {foreach from=$shortCodeList key=kshort item=shortCode}
                {if $kshort != 'ApModule'}
                <div class="item col-md-3 col-sm-4 col-xs-6 " data-tag="{$shortCode.tag|escape:'html':'UTF-8'}">
                    <div class="cover-short-code">
                        <a href="javascript:void(0)" title="{$shortCode.desc|escape:'html':'UTF-8'}" class="shortcode new-shortcode" data-type='{$kshort|escape:'html':'UTF-8'}'>
                            <i class="icon {if isset($shortCode.icon_class)}{$shortCode.icon_class|escape:'html':'UTF-8'}{/if}"> </i>
                            <span class="label">{$shortCode.label|escape:'html':'UTF-8'}</span>
                            <small class="clearfix"><i>{$shortCode.desc|escape:'html':'UTF-8'}</i></small>
                        </a>
                    </div>
                </div>
                {/if}
            {/foreach}
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="module">
        <ol class="breadcrumb in-widget filters for-module" data-for="module">
            <li><a href="javascript:;"><button data-filter="*" class="btn is-checked">{l s='Show all' mod='appagebuilder'}</button></a></li>
            {foreach from=$author item=item}
            <li><a href="javascript:;"><button data-filter="{$item|escape:'html':'UTF-8'}" class="btn">{$item|escape:'html':'UTF-8'}</button></a></li>
            {/foreach}
            <li><a href="javascript:;"><button data-filter="other" class="btn">{l s='Other' mod='appagebuilder'}</button></a></li>
        </ol>
        <div class="row" id="module_container">
            {foreach from=$listModule key=kshort item=item}
                <div class="item col-md-3 col-sm-4 col-xs-6 " data-tag="{if $item.author}{$item.author|escape:'html':'UTF-8'}{else}other{/if}">
                    <div class="cover-short-code">
                        <a href="javascript:void(0)" title="{if $item.description_short}{$item.description|escape:'html':'UTF-8'}{else}{$item.name|escape:'html':'UTF-8'}{/if}" 
                           class="shortcode new-shortcode module" data-type="{$item.name|escape:'html':'UTF-8'}">
                            <img class="icon" src="../modules/{$item.name|escape:'html':'UTF-8'}/logo.png"/>
                            <span class="label">{$item.name|escape:'html':'UTF-8'}</span>
                            <small class="clearfix"><i>{$item.description_short|escape:'html':'UTF-8'}</i></small>
                        </a>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
		var tab = $(".btn-back-to-list").attr("tab");
        $("#tab-new-widget a").each(function() {
			if($(this).attr("aria-controls") == tab) {
				$(this).tab("show");
			}
		});
		//$("#tab-new-widget a:first").tab("show");
    })
</script>
{/if}