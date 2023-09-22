<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:04
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/appagebuilder/views/templates/hook/ApGenCode.tpl" */ ?>
<?php /*%%SmartyHeaderCode:113298427362b57864e275c8-93142450%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c93e54ef157fc489a1506464c671256457841efb' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/appagebuilder/views/templates/hook/ApGenCode.tpl',
      1 => 1470858211,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '113298427362b57864e275c8-93142450',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'formAtts' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b57864e55310_05536300',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b57864e55310_05536300')) {function content_62b57864e55310_05536300($_smarty_tpl) {?>
<!-- @file modules\appagebuilder\views\templates\hook\ApGenCode -->

<?php if (isset($_smarty_tpl->tpl_vars['formAtts']->value['tpl_file'])&&!empty($_smarty_tpl->tpl_vars['formAtts']->value['tpl_file'])) {?>
	<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['formAtts']->value['tpl_file'], $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['formAtts']->value['error_file'])&&!empty($_smarty_tpl->tpl_vars['formAtts']->value['error_file'])) {?>
	<?php echo $_smarty_tpl->tpl_vars['formAtts']->value['error_message'];?>

<?php }?>
<?php }} ?>
