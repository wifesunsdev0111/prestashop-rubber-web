<?php /* Smarty version Smarty-3.1.19, created on 2022-07-28 18:05:36
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/Backoffice/themes/default/template/helpers/tree/tree_toolbar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:173215187562e2b3d0a2a185-86358693%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ab0f2b9a493eb4469d4a52aa74442b8bd7b4a2d' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/Backoffice/themes/default/template/helpers/tree/tree_toolbar.tpl',
      1 => 1575969816,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '173215187562e2b3d0a2a185-86358693',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'actions' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62e2b3d0a55d04_75912645',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62e2b3d0a55d04_75912645')) {function content_62e2b3d0a55d04_75912645($_smarty_tpl) {?>
<div class="tree-actions pull-right">
	<?php if (isset($_smarty_tpl->tpl_vars['actions']->value)) {?>
	<?php  $_smarty_tpl->tpl_vars['action'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['action']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['actions']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['action']->key => $_smarty_tpl->tpl_vars['action']->value) {
$_smarty_tpl->tpl_vars['action']->_loop = true;
?>
		<?php echo $_smarty_tpl->tpl_vars['action']->value->render();?>

	<?php } ?>
	<?php }?>
</div>
<?php }} ?>
