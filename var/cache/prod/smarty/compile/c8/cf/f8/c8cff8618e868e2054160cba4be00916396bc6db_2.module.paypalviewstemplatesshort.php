<?php
/* Smarty version 3.1.47, created on 2023-07-30 01:09:49
  from 'module:paypalviewstemplatesshort' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64c59c3d2ce6b2_54258134',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c8cff8618e868e2054160cba4be00916396bc6db' => 
    array (
      0 => 'module:paypalviewstemplatesshort',
      1 => 1680764080,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64c59c3d2ce6b2_54258134 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>

<!-- Start shortcut. Module Paypal -->
<?php ob_start();
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['psPaypalDir']->value)."/views/templates/_partials/javascript.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
$_smarty_tpl->assign('javascriptBlock', ob_get_clean());
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_68256167864c59c3d2cc4b7_81281638', 'head');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_12534162464c59c3d2cd169_47900201', 'content');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_35442297564c59c3d2cd7f9_34750533', 'js');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_23397344864c59c3d2cddf2_68067381', 'init-button');
?>

<!-- End shortcut. Module Paypal -->



<?php }
/* {block 'head'} */
class Block_68256167864c59c3d2cc4b7_81281638 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'head' => 
  array (
    0 => 'Block_68256167864c59c3d2cc4b7_81281638',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <?php echo $_smarty_tpl->tpl_vars['javascriptBlock']->value;?>

<?php
}
}
/* {/block 'head'} */
/* {block 'content'} */
class Block_12534162464c59c3d2cd169_47900201 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_12534162464c59c3d2cd169_47900201',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'content'} */
/* {block 'js'} */
class Block_35442297564c59c3d2cd7f9_34750533 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'js' => 
  array (
    0 => 'Block_35442297564c59c3d2cd7f9_34750533',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'js'} */
/* {block 'init-button'} */
class Block_23397344864c59c3d2cddf2_68067381 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'init-button' => 
  array (
    0 => 'Block_23397344864c59c3d2cddf2_68067381',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <?php echo '<script'; ?>
>
      function waitPaypalIsLoaded() {
          if (typeof totPaypalSdkButtons === 'undefined' || typeof Shortcut === 'undefined') {
              setTimeout(waitPaypalIsLoaded, 200);
              return;
          }

          Shortcut.init();

          if (typeof PAYPAL_MOVE_BUTTON_AT_END != 'undefined') {
            Shortcut.isMoveButtonAtEnd = PAYPAL_MOVE_BUTTON_AT_END;
          }

          Shortcut.initButton();
      }

      waitPaypalIsLoaded();
  <?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'init-button'} */
}
