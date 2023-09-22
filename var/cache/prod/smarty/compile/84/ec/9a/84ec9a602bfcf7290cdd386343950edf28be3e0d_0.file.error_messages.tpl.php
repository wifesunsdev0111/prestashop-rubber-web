<?php
/* Smarty version 3.1.47, created on 2023-05-15 14:54:54
  from '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/Backoffice/themes/new-theme/template/components/layout/error_messages.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64622b9e56afa1_29252384',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '84ec9a602bfcf7290cdd386343950edf28be3e0d' => 
    array (
      0 => '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/Backoffice/themes/new-theme/template/components/layout/error_messages.tpl',
      1 => 1680526184,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64622b9e56afa1_29252384 (Smarty_Internal_Template $_smarty_tpl) {
if (count($_smarty_tpl->tpl_vars['errors']->value) && current($_smarty_tpl->tpl_vars['errors']->value) != '' && (!(isset($_smarty_tpl->tpl_vars['disableDefaultErrorOutPut']->value)) || $_smarty_tpl->tpl_vars['disableDefaultErrorOutPut']->value == false)) {?>
  <div class="bootstrap">
    <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <?php if (count($_smarty_tpl->tpl_vars['errors']->value) == 1) {?>
        <?php echo reset($_smarty_tpl->tpl_vars['errors']->value);?>

      <?php } else { ?>
        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'There are %d errors.','sprintf'=>array(count($_smarty_tpl->tpl_vars['errors']->value)),'d'=>'Admin.Notifications.Error'),$_smarty_tpl ) );?>

        <br/>
        <ol>
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['errors']->value, 'error');
$_smarty_tpl->tpl_vars['error']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['error']->value) {
$_smarty_tpl->tpl_vars['error']->do_else = false;
?>
            <li><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</li>
          <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </ol>
      <?php }?>
    </div>
  </div>
<?php }
}
}
