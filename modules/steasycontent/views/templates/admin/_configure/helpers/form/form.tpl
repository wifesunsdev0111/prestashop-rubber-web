{*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{extends file="helpers/form/form.tpl"}{block name="autoload_tinyMCE"}
    {literal}
	tinySetup({
		editor_selector :"autoload_rte",
		plugins : "colorpicker link image paste pagebreak table contextmenu filemanager table code media autoresize textcolor template",
		toolbar1 : "code,|,bold,italic,underline,strikethrough,|,alignleft,aligncenter,alignright,alignfull,formatselect,|,blockquote,colorpicker,pasteword,|,bullist,numlist,|,outdent,indent,|,link,unlink,|,cleanup,|,media,image,|,template",
        templates : "{/literal}{$smarty.const._MODULE_DIR_}{literal}steasycontent/template_list.php",
        verify_html : false
	});
    {/literal}
{/block}

{block name="field"}
	{if $input.type == 'fontello'}
		<div class="col-lg-{if isset($input.col)}{$input.col|intval}{else}9{/if} {if !isset($input.label)}col-lg-offset-3{/if} fontello_wrap">
			<a id="btn_{$input.name}" class="btn btn-default" data-toggle="modal" href="#" data-target="#modal_fontello">
				{l s='Click here'}
			</a>
			<div class="modal fade" id="modal_fontello" tabindex="-1">
				<div class="modal-dialog">
					<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">{l s="Icon"}</h4>
					</div>
					<div class="modal-body">
						<p><code>&lt;em class="icon-diamond icon-1x"&gt;&lt;span class="unvisible"&gt;&amp;nbsp;&lt;/span&gt;&lt;/em&gt;</code></p>
						<p>{l s='You can use this code to add a icon to your custom content, put it in cource code.'} <a href="javascript:;" onclick="{literal}$('#how_to_put_icons').toggle();return false;{/literal}">{l s='Here is a screenshot'}</a>. {l s='Alert icon-diamond as you needed. "icon-1x" is used to change the size of icons, here are some other classes:'} icon-small,icon-large,icon-0x,icon-1x,icon-2x...</p>
						<p id="how_to_put_icons" style="display:none;">
							<img src="{$smarty.const._MODULE_DIR_}steasycontent/views/img/how_to_put_icons.jpg" />
						</p>
						<ul class="fontello_list clearfix">
							{foreach $input.values.classes AS $class}
								<li>
									<i class="{$class}"></i>{$class}
								</li>
							{/foreach}
						</ul>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">{l s="OK"}</button>
					</div>
					</div>
				</div>
			</div>
			<style type="text/css">
				@font-face {
				  font-family: 'fontello';
				  src: url('{$input.values.module_name}../../themes/{$input.values.theme_name}/font/fontello.eot');
				  src: url('{$input.values.module_name}../../themes/{$input.values.theme_name}/font/fontello.eot#iefix') format('embedded-opentype'),
				       url('{$input.values.module_name}../../themes/{$input.values.theme_name}/font/fontello.woff') format('woff'),
				       url('{$input.values.module_name}../../themes/{$input.values.theme_name}/font/fontello.ttf') format('truetype'),
				       url('{$input.values.module_name}../../themes/{$input.values.theme_name}/font/fontello.svg#fontello') format('svg');
				  font-weight: normal;
				  font-style: normal;
				}
				{$input.values.css}
			</style>
		</div>
	{else}
		{$smarty.block.parent}
	{/if}
{/block}