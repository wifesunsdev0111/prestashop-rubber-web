
<!-- @file modules\appagebuilder\views\templates\admin\ap_page_builder_theme_configuration\helpers\form\form.tpl -->
{extends file="helpers/form/form.tpl"}
{block name="input"}
	{if $input.type == 'tabConfig'}
		<div class="row">
			{assign var=tabList value=$input.values}
			<ul class="nav nav-tabs" role="tablist">
			{foreach $tabList as $key => $value name="tabList"}
				<li role="presentation" class="{if $smarty.foreach.tabList.first}active{/if}"><a href="#{$key|escape:'html':'UTF-8'}" class="aptab-config" role="tab" data-toggle="tab">{$value|escape:'html':'UTF-8'}</a></li>
			{/foreach}
			</ul>
		</div>
	{else}
		{$smarty.block.parent}
	{/if}
	
{/block}