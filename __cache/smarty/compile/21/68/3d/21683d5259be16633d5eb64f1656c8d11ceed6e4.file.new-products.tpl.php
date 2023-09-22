<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 19:42:43
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/new-products.tpl" */ ?>
<?php /*%%SmartyHeaderCode:143978234362b5f793f13b72-15804355%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '21683d5259be16633d5eb64f1656c8d11ceed6e4' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/new-products.tpl',
      1 => 1470857956,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '143978234362b5f793f13b72-15804355',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b5f793f3f964_53584385',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b5f793f3f964_53584385')) {function content_62b5f793f3f964_53584385($_smarty_tpl) {?>

<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><?php echo smartyTranslate(array('s'=>'New products'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<h1 class="page-heading product-listing"><?php echo smartyTranslate(array('s'=>'New products'),$_smarty_tpl);?>
</h1>

<?php if ($_smarty_tpl->tpl_vars['products']->value) {?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./sub/product/product-list-form.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	<?php } else { ?>
	<p class="alert alert-warning"><?php echo smartyTranslate(array('s'=>'No new products.'),$_smarty_tpl);?>
</p>
<?php }?>
<?php }} ?>
