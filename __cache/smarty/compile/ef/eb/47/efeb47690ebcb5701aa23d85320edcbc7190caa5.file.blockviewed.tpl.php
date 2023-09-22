<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:23
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/modules/blockviewed/blockviewed.tpl" */ ?>
<?php /*%%SmartyHeaderCode:198078805162b578771d4ba4-54721789%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'efeb47690ebcb5701aa23d85320edcbc7190caa5' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/modules/blockviewed/blockviewed.tpl',
      1 => 1470857796,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '198078805162b578771d4ba4-54721789',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'productsViewedObj' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b578771f7092_94445386',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b578771f7092_94445386')) {function content_62b578771f7092_94445386($_smarty_tpl) {?>

<!-- Block Viewed products -->
<div id="viewed-products_block_left" class="block">
	<h4 class="title_block"><?php echo smartyTranslate(array('s'=>'Viewed products','mod'=>'blockviewed'),$_smarty_tpl);?>
</h4>
	<div class="block_content">
			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./sub/product/sidebar-obj.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('products'=>$_smarty_tpl->tpl_vars['productsViewedObj']->value,'mod'=>'blockspecials'), 0);?>
 
	</div>
</div>
<?php }} ?>
