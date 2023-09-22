<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:05
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/blocksearch/blocksearch.tpl" */ ?>
<?php /*%%SmartyHeaderCode:26882438262b57865566dd3-95921041%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6a387f4c839a83dc22a65e951d5e60a33cbcfc4d' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/blocksearch/blocksearch.tpl',
      1 => 1575969891,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26882438262b57865566dd3-95921041',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'search_query' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b57865575a95_16606717',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b57865575a95_16606717')) {function content_62b57865575a95_16606717($_smarty_tpl) {?>

<!-- Block search module -->
<div id="search_block_left" class="block exclusive">
	<h4 class="title_block"><?php echo smartyTranslate(array('s'=>'Search','mod'=>'blocksearch'),$_smarty_tpl);?>
</h4>
	<form method="get" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('search',true), ENT_QUOTES, 'UTF-8', true);?>
" id="searchbox">
		<p class="block_content">
			<label for="search_query_block"><?php echo smartyTranslate(array('s'=>'Search products:','mod'=>'blocksearch'),$_smarty_tpl);?>
</label>
			<input type="hidden" name="controller" value="search" />
			<input type="hidden" name="orderby" value="position" />
			<input type="hidden" name="orderway" value="desc" />
			<input class="search_query" type="text" id="search_query_block" name="search_query" value="<?php echo stripslashes(htmlspecialchars($_smarty_tpl->tpl_vars['search_query']->value, ENT_QUOTES, 'UTF-8', true));?>
" />
			<input type="submit" id="search_button" class="button_mini" value="<?php echo smartyTranslate(array('s'=>'Go','mod'=>'blocksearch'),$_smarty_tpl);?>
" />
		</p>
	</form>
</div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['self']->value)."/blocksearch-instantsearch.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<!-- /Block search module -->
<?php }} ?>
