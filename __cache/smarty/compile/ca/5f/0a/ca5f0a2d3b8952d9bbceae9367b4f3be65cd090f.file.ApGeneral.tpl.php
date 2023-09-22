<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:06
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/modules/appagebuilder/views/templates/hook/ApGeneral.tpl" */ ?>
<?php /*%%SmartyHeaderCode:34345604562b578663d9be4-33399660%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ca5f0a2d3b8952d9bbceae9367b4f3be65cd090f' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/modules/appagebuilder/views/templates/hook/ApGeneral.tpl',
      1 => 1470857697,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '34345604562b578663d9be4-33399660',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'formAtts' => 0,
    'apLiveEdit' => 0,
    'apContent' => 0,
    'apLiveEditEnd' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b57866407de3_52068437',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b57866407de3_52068437')) {function content_62b57866407de3_52068437($_smarty_tpl) {?>
<!-- @file modules\appagebuilder\views\templates\hook\ApGeneral -->
<div<?php if (isset($_smarty_tpl->tpl_vars['formAtts']->value['id'])&&$_smarty_tpl->tpl_vars['formAtts']->value['id']) {?> id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['formAtts']->value['id'], ENT_QUOTES, 'UTF-8', true);?>
"<?php }?><?php if (isset($_smarty_tpl->tpl_vars['formAtts']->value['class'])) {?> 
    class="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['formAtts']->value['class'], ENT_QUOTES, 'UTF-8', true);?>
 block"<?php }?>>
	<?php echo $_smarty_tpl->tpl_vars['apLiveEdit']->value ? $_smarty_tpl->tpl_vars['apLiveEdit']->value : '';?>

    <?php if (isset($_smarty_tpl->tpl_vars['formAtts']->value['title'])&&$_smarty_tpl->tpl_vars['formAtts']->value['title']) {?>
    <h4 class="title_block"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['formAtts']->value['title'], ENT_QUOTES, 'UTF-8', true);?>
</h4>
    <?php }?>
    <?php if (isset($_smarty_tpl->tpl_vars['formAtts']->value['content_html'])) {?>
        <?php echo $_smarty_tpl->tpl_vars['formAtts']->value['content_html'];?>

    <?php } else { ?>
        <?php echo $_smarty_tpl->tpl_vars['apContent']->value;?>

    <?php }?>
	<?php echo $_smarty_tpl->tpl_vars['apLiveEditEnd']->value ? $_smarty_tpl->tpl_vars['apLiveEditEnd']->value : '';?>

</div><?php }} ?>
