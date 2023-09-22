<?php
/* Smarty version 3.1.47, created on 2023-05-15 14:54:57
  from '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/modules/ets_htmlbox/views/templates/hook/display-hooks.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64622ba180a5f6_96220851',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2812a495b764b812fe2017cd6c6d6554eec43d61' => 
    array (
      0 => '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/modules/ets_htmlbox/views/templates/hook/display-hooks.tpl',
      1 => 1680526194,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64622ba180a5f6_96220851 (Smarty_Internal_Template $_smarty_tpl) {
if ((isset($_smarty_tpl->tpl_vars['hooks']->value)) && sizeof($_smarty_tpl->tpl_vars['hooks']->value) > 0) {?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['hooks']->value, 'hook');
$_smarty_tpl->tpl_vars['hook']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['hook']->value) {
$_smarty_tpl->tpl_vars['hook']->do_else = false;
?>
        <style>
            <?php echo $_smarty_tpl->tpl_vars['hook']->value['style'];?>

        </style>
        <?php echo $_smarty_tpl->tpl_vars['hook']->value['html'];?>

    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
}
}
