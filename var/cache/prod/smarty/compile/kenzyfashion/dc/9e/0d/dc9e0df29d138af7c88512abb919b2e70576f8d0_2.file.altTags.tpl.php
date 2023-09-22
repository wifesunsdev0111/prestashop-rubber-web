<?php
/* Smarty version 3.1.47, created on 2023-05-15 14:54:57
  from '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/modules/bablic/views/templates/front/altTags.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64622ba17f3106_56277246',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dc9e0df29d138af7c88512abb919b2e70576f8d0' => 
    array (
      0 => '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/modules/bablic/views/templates/front/altTags.tpl',
      1 => 1680526195,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64622ba17f3106_56277246 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!-- start Bablic Head <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['version']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 -->
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['locales']->value, 'locale');
$_smarty_tpl->tpl_vars['locale']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['locale']->value) {
$_smarty_tpl->tpl_vars['locale']->do_else = false;
?>
    <link rel="alternate" href="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['locale']->value[0],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" hreflang="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['locale']->value[1],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
">
<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
if ($_smarty_tpl->tpl_vars['subdir']->value == true) {?>
  <?php echo '<script'; ?>
>
    var bablic = {};
    bablic.localeURL = 'subdir';
    bablic.folders = <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['folders_json']->value, ENT_QUOTES, 'UTF-8');?>
; 
    bablic.subDirBase = '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['subdir_base']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
';
<?php echo '</script'; ?>
>
<?php }
echo '<script'; ?>
 data-cfasync="false"<?php if ($_smarty_tpl->tpl_vars['async']->value == true) {?> async<?php }?> src="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['snippet_url']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"><?php echo '</script'; ?>
>
<!-- end Bablic Head -->
<?php }
}
