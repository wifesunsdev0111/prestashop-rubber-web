<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:04
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/modules/appagebuilder/views/templates/hook/ApColumn.tpl" */ ?>
<?php /*%%SmartyHeaderCode:150883272762b57864ee44a9-25300570%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '470ada4d02ccf2b58e2a6e81636c1cc707faa14e' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/modules/appagebuilder/views/templates/hook/ApColumn.tpl',
      1 => 1470857697,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '150883272762b57864ee44a9-25300570',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'formAtts' => 0,
    'apContent' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b57864f0c631_47873454',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b57864f0c631_47873454')) {function content_62b57864f0c631_47873454($_smarty_tpl) {?>
<!-- @file modules\appagebuilder\views\templates\hook\ApColumn -->
<div<?php if (isset($_smarty_tpl->tpl_vars['formAtts']->value['id'])&&$_smarty_tpl->tpl_vars['formAtts']->value['id']) {?> id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['formAtts']->value['id'], ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>
    class="<?php echo isset($_smarty_tpl->tpl_vars['formAtts']->value['class']) ? $_smarty_tpl->tpl_vars['formAtts']->value['class'] : htmlspecialchars('', ENT_QUOTES, 'UTF-8', true);?>
 <?php echo isset($_smarty_tpl->tpl_vars['formAtts']->value['animation'])&&$_smarty_tpl->tpl_vars['formAtts']->value['animation']!=htmlspecialchars('none', ENT_QUOTES, 'UTF-8', true) ? 'has-animation' : '';?>
"
	<?php if (isset($_smarty_tpl->tpl_vars['formAtts']->value['animation'])&&$_smarty_tpl->tpl_vars['formAtts']->value['animation']!='none') {?> data-animation="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['formAtts']->value['animation'], ENT_QUOTES, 'UTF-8', true);?>
" <?php }?>
	<?php if ($_smarty_tpl->tpl_vars['formAtts']->value['animation_delay']!='') {?> data-animation-delay="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['formAtts']->value['animation_delay'], ENT_QUOTES, 'UTF-8', true);?>
" <?php }?>
    >
    <?php if (isset($_smarty_tpl->tpl_vars['formAtts']->value['title'])&&$_smarty_tpl->tpl_vars['formAtts']->value['title']) {?>
     <h4 class="title_block"><?php echo $_smarty_tpl->tpl_vars['formAtts']->value['title'];?>
</h4>
    <?php }?>
    <?php if (isset($_smarty_tpl->tpl_vars['formAtts']->value['content_html'])) {?>
        <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['formAtts']->value['content_html'], ENT_QUOTES, 'UTF-8', true);?>

    <?php } else { ?>
        <?php echo $_smarty_tpl->tpl_vars['apContent']->value;?>

    <?php }?>
</div><?php }} ?>
