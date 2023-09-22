{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\admin\ap_page_builder_shortcodes\ApColumn -->
<div {if !isset($apInfo)}id="default_column"{/if} class="column-row{if !isset($apInfo)} col-sp-12 col-xs-12 col-sm-12 col-md-12 col-lg-12{/if}{if isset($colClass)} {$colClass|replace:'.':'-'|escape:'html':'UTF-8'}{/if}{if isset($formAtts)} {$formAtts.form_id|escape:'html':'UTF-8'}{if isset($formAtts.active) && !$formAtts.active} deactive{else} active{/if}{/if}">
	<div class="cover-column">
		<div class="column-controll-top">
			<a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Drag to sort Column' mod='appagebuilder'}" class="column-action caction-drag label-tooltip"><i class="icon-move"></i> </a>
			&nbsp;
			<div class="btn-group">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
					<span>{l s='Column' mod='appagebuilder'}</span> <span class="caret"></span>
				</button>
				<ul class="dropdown-menu for-column-row" role="menu">
					<li><a href="javascript:void(0)" title="{l s='Add new Widget' mod='appagebuilder'}" class="column-action btn-new-widget "><i class="icon-plus-sign"></i> {l s='Add new Widget' mod='appagebuilder'}</a></li>
					<li><a href="javascript:void(0)" title="{l s='Edit Column' mod='appagebuilder'}" class="column-action btn-edit " data-type="ApColumn" data-for=".column-row"><i class="icon-pencil"></i> {l s='Edit Column' mod='appagebuilder'}</a></li>
					<li><a href="javascript:void(0)" title="{l s='Delete Column' mod='appagebuilder'}" class="column-action btn-delete "><i class="icon-trash"></i> {l s='Delete Column' mod='appagebuilder'}</a></li>
					<li><a href="javascript:void(0)" title="{l s='Duplicate Group' mod='appagebuilder'}" class="column-action btn-duplicate "><i class="icon-paste"></i> {l s='Duplicate Column' mod='appagebuilder'}</a></li>
					<li><a href="javascript:void(0)" title="{l s='Disable or Enable Column' mod='appagebuilder'}" class="column-action btn-status {if isset($formAtts.active) && !$formAtts.active} deactive{else} active{/if}"><i class="icon-ok"></i> {l s='Disable or Enable Column' mod='appagebuilder'}</a></li>
				</ul>
			</div> 
		</div>
		<div class="column-controll-right pull-right">
			<a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Reduce size' mod='appagebuilder'}" class="column-action btn-change-colwidth" data-value="-1"><i class="icon-minus-sign-alt"></i></a>
			<div class="btn-group">
				<button type="button" class="btn" tabindex="-1" data-toggle="dropdown">
					<span class="width-val ap-w-6"></span>
				</button>
				<ul class="dropdown-menu dropdown-menu-right">
					{foreach from=$widthList item=itemWidth}
					<li class="col-{$itemWidth|replace:'.':'-'|escape:'html':'UTF-8'}">
						<a class="change-colwidth" data-width="{$itemWidth|replace:'.':'-'|escape:'html':'UTF-8'}" href="javascript:void(0);" tabindex="-1">                                          
							<span data-width="{$itemWidth|replace:'.':'-'|escape:'html':'UTF-8'}" class="width-val ap-w-{if $itemWidth|strpos:"."|escape:'html':'UTF-8'}{$itemWidth|replace:'.':'-'|escape:'html':'UTF-8'}{else}{$itemWidth|escape:'html':'UTF-8'}{/if}">{$itemWidth|escape:'html':'UTF-8'}/12 - ( {math equation="x/y*100" x=$itemWidth y=12 format="%.2f"} % )</span>
						</a>
					</li>
					{/foreach}
				</ul>
			</div>
			<a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Increase size' mod='appagebuilder'}" class="column-action btn-change-colwidth" data-value="1"><i class="icon-plus-sign-alt"></i></a>
		</div>
		<div class="column-content">
			{if isset($apInfo)}{$apContent}{* HTML form , no escape necessary *}{/if}
		</div>
		<div class="column-controll-bottom">
			<a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Add new Widget' mod='appagebuilder'}" class="column-action btn-new-widget label-tooltip"><i class="icon-plus-sign"></i></a>
			<a href="javascript:void(0)" data-toggle="tooltip" title="{l s='Edit Column' mod='appagebuilder'}" class="column-action btn-edit label-tooltip" data-type="ApColumn"><i class="icon-pencil"></i></a>
		</div>
	</div>
</div>