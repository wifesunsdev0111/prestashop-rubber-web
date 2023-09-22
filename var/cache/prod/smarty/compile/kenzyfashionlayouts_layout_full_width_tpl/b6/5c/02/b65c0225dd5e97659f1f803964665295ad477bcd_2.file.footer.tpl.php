<?php
/* Smarty version 3.1.47, created on 2023-05-15 14:54:58
  from '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/themes/kenzyfashion/templates/_partials/footer.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64622ba2130ac2_54123026',
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
function content_64622ba2130ac2_54123026 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>

<div class="footer-before">
  <div class="container">
    <div class="row">
      <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_9236144364622ba212bc68_63648700', 'hook_footer_before');
?>

    </div>
  </div>
</div>

<div class="footer-container">
  <div class="container">
    <div class="row">
      <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_75167646564622ba212c919_74929839', 'hook_footer');
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
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_85144110364622ba212d412_64300911', 'copyright_link');
?>

            </div>
            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_209502102364622ba21300b6_24251703', 'hook_footer_after');
?>

        </div>
      </div>
  </div>
</div>
<a class="ax-back-to-top" href="#" style="">&nbsp;</a>

<?php }
/* {block 'hook_footer_before'} */
class Block_9236144364622ba212bc68_63648700 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'hook_footer_before' => 
  array (
    0 => 'Block_9236144364622ba212bc68_63648700',
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
class Block_75167646564622ba212c919_74929839 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'hook_footer' => 
  array (
    0 => 'Block_75167646564622ba212c919_74929839',
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
class Block_85144110364622ba212d412_64300911 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'copyright_link' => 
  array (
    0 => 'Block_85144110364622ba212d412_64300911',
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
class Block_209502102364622ba21300b6_24251703 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'hook_footer_after' => 
  array (
    0 => 'Block_209502102364622ba21300b6_24251703',
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
