<?php
/* Smarty version 3.1.47, created on 2023-07-30 01:09:49
  from '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/themes/kenzyfashion/templates/checkout/_partials/login-form.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64c59c3d212839_59286803',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5c55f1de268c3a7f6bcb2739435d4089aab1256e' => 
    array (
      0 => '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/themes/kenzyfashion/templates/checkout/_partials/login-form.tpl',
      1 => 1680526196,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64c59c3d212839_59286803 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_164203418764c59c3d211c20_31378974', 'form_buttons');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, 'customer/_partials/login-form.tpl');
}
/* {block 'form_buttons'} */
class Block_164203418764c59c3d211c20_31378974 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'form_buttons' => 
  array (
    0 => 'Block_164203418764c59c3d211c20_31378974',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <button
    class="continue btn btn-primary float-xs-right"
    name="continue"
    data-link-action="sign-in"
    type="submit"
    value="1"
  >
    <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Continue','d'=>'Shop.Theme.Actions'),$_smarty_tpl ) );?>

  </button>
<?php
}
}
/* {/block 'form_buttons'} */
}
