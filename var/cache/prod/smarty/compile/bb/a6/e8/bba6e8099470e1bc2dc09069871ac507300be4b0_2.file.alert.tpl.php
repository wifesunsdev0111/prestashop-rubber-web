<?php
/* Smarty version 3.1.47, created on 2023-07-30 01:09:49
  from '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/modules/paypal/views/templates/admin/_partials/alert.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64c59c3d2f63a7_96753072',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bba6e8099470e1bc2dc09069871ac507300be4b0' => 
    array (
      0 => '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/modules/paypal/views/templates/admin/_partials/alert.tpl',
      1 => 1680764080,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64c59c3d2f63a7_96753072 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="alert alert-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['type']->value, ENT_QUOTES, 'UTF-8');?>
 <?php if ((isset($_smarty_tpl->tpl_vars['widthByContent']->value)) && $_smarty_tpl->tpl_vars['widthByContent']->value) {?>d-inline-block<?php }?> <?php if ((isset($_smarty_tpl->tpl_vars['class']->value)) && $_smarty_tpl->tpl_vars['class']->value) {?> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['class']->value, ENT_QUOTES, 'UTF-8');?>
 <?php }?>">
    <?php if ((isset($_smarty_tpl->tpl_vars['btnClose']->value)) && $_smarty_tpl->tpl_vars['btnClose']->value) {?>
        <button type="button" class="close" data-dismiss="alert">×</button>
    <?php }?>
    <?php echo $_smarty_tpl->tpl_vars['message']->value;?>

</div>
<?php }
}
