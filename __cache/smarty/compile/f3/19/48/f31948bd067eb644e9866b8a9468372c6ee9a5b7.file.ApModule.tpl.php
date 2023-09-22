<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:05
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/appagebuilder/views/templates/hook/ApModule.tpl" */ ?>
<?php /*%%SmartyHeaderCode:105080778162b578650dff23-41766010%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f31948bd067eb644e9866b8a9468372c6ee9a5b7' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/appagebuilder/views/templates/hook/ApModule.tpl',
      1 => 1470858213,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '105080778162b578650dff23-41766010',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'apLiveEdit' => 0,
    'apContent' => 0,
    'apLiveEditEnd' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b578650e8b37_36905152',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b578650e8b37_36905152')) {function content_62b578650e8b37_36905152($_smarty_tpl) {?>
<!-- @file modules\appagebuilder\views\templates\hook\ApModule -->
<?php echo $_smarty_tpl->tpl_vars['apLiveEdit']->value ? $_smarty_tpl->tpl_vars['apLiveEdit']->value : '';?>

<?php echo $_smarty_tpl->tpl_vars['apContent']->value;?>

<?php echo $_smarty_tpl->tpl_vars['apLiveEditEnd']->value ? $_smarty_tpl->tpl_vars['apLiveEditEnd']->value : '';?>
<?php }} ?>
