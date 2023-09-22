<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:05
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/modules/blockbestsellers/blockbestsellers.tpl" */ ?>
<?php /*%%SmartyHeaderCode:170110795162b57865ae9389-92918727%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e4d5d111dc129d43deaf38e9796f1f9d62ead2a3' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/modules/blockbestsellers/blockbestsellers.tpl',
      1 => 1470857717,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '170110795162b57865ae9389-92918727',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'best_sellers' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b57865b199e7_44808583',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b57865b199e7_44808583')) {function content_62b57865b199e7_44808583($_smarty_tpl) {?>

<!-- MODULE Block best sellers -->
<div id="best-sellers_block_right" class="block products_block  block-highlighted">
	<h4 class="title_block">
    	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('best-sales'), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'View a top sellers products','mod'=>'blockbestsellers'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Top sellers','mod'=>'blockbestsellers'),$_smarty_tpl);?>
</a>
    </h4>
	<div class="block_content products-block">
	<?php if ($_smarty_tpl->tpl_vars['best_sellers']->value&&count($_smarty_tpl->tpl_vars['best_sellers']->value)>0) {?>
	  	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./sub/product/sidebar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array('products'=>$_smarty_tpl->tpl_vars['best_sellers']->value,'mod'=>'blockbestsellers'), 0);?>
  
		<div class="lnk">
        	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('best-sales'), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'All best sellers','mod'=>'blockbestsellers'),$_smarty_tpl);?>
"  class="btn btn-outline button button-small btn-sm"><span><?php echo smartyTranslate(array('s'=>'All best sellers','mod'=>'blockbestsellers'),$_smarty_tpl);?>
</span></a>
        </div>
	<?php } else { ?>
		<p><?php echo smartyTranslate(array('s'=>'No best sellers at this time','mod'=>'blockbestsellers'),$_smarty_tpl);?>
</p>
	<?php }?>
	</div>
</div>
<!-- /MODULE Block best sellers --><?php }} ?>
