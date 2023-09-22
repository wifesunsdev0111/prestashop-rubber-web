<?php
/* Smarty version 3.1.47, created on 2023-05-15 14:58:06
  from '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/themes/kenzyfashion/templates/_partials/footer.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64622c5e7cb604_15471256',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b65c0225dd5e97659f1f803964665295ad477bcd' => 
    array (
      0 => '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/themes/kenzyfashion/templates/_partials/footer.tpl',
      1 => 1680526196,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64622c5e7cb604_15471256 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>

<div class="footer-before">
  <div class="container">
    <div class="row">
      <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_76746032764622c5e7c66f5_54277186', 'hook_footer_before');
?>

    </div>
  </div>
</div>

<div class="footer-container">
  <div class="container">
    <div class="row">
      <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_84463469764622c5e7c7459_94365898', 'hook_footer');
?>

    </div>
    
  </div>
</div>
<div class="footer-after">
   <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="copyright">
              <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_124067137464622c5e7c7f39_09874821', 'copyright_link');
?>

            </div>
            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_13156404364622c5e7cac05_12308100', 'hook_footer_after');
?>

        </div>
      </div>
  </div>
</div>
<a class="ax-back-to-top" href="#" style="">&nbsp;</a>

<?php }
/* {block 'hook_footer_before'} */
class Block_76746032764622c5e7c66f5_54277186 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'hook_footer_before' => 
  array (
    0 => 'Block_76746032764622c5e7c66f5_54277186',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayFooterBefore'),$_smarty_tpl ) );?>

      <?php
}
}
/* {/block 'hook_footer_before'} */
/* {block 'hook_footer'} */
class Block_84463469764622c5e7c7459_94365898 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'hook_footer' => 
  array (
    0 => 'Block_84463469764622c5e7c7459_94365898',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayFooter'),$_smarty_tpl ) );?>

      <?php
}
}
/* {/block 'hook_footer'} */
/* {block 'copyright_link'} */
class Block_124067137464622c5e7c7f39_09874821 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'copyright_link' => 
  array (
    0 => 'Block_124067137464622c5e7c7f39_09874821',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

                <a class="_blank copyright" href="http://www.prestashop.com" target="_blank">
                  <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'%copyright% %year% - Ecommerce software by %prestashop%','sprintf'=>array('%prestashop%'=>'PrestaShop™','%year%'=>date('Y'),'%copyright%'=>'©'),'d'=>'Shop.Theme.Global'),$_smarty_tpl ) );?>

                </a>
              <?php
}
}
/* {/block 'copyright_link'} */
/* {block 'hook_footer_after'} */
class Block_13156404364622c5e7cac05_12308100 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'hook_footer_after' => 
  array (
    0 => 'Block_13156404364622c5e7cac05_12308100',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

              <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayFooterAfter'),$_smarty_tpl ) );?>

            <?php
}
}
/* {/block 'hook_footer_after'} */
}
