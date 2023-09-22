<?php
/* Smarty version 3.1.47, created on 2023-07-30 01:09:49
  from '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/themes/kenzyfashion/templates/checkout/_partials/footer.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64c59c3d384aa1_77185729',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f0ec1f0cd82e20ea550cec0fec2795ca0ac78e0b' => 
    array (
      0 => '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/themes/kenzyfashion/templates/checkout/_partials/footer.tpl',
      1 => 1680526196,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64c59c3d384aa1_77185729 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
 
<div class="footer-before">
  <div class="container">
    <div class="row">
      <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_55906029264c59c3d37fc60_66456965', 'hook_footer_before');
?>

    </div>
  </div>
</div>

<div class="footer-container">
  <div class="container">
    <div class="row">
      <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_132069425964c59c3d380924_65590297', 'hook_footer');
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
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_151079904664c59c3d381421_17925915', 'copyright_link');
?>

            </div>
            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_62496970464c59c3d384087_15636037', 'hook_footer_after');
?>

        </div>
      </div>
  </div>
</div>
<a class="ax-back-to-top" href="#" style="">&nbsp;</a>

<?php }
/* {block 'hook_footer_before'} */
class Block_55906029264c59c3d37fc60_66456965 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'hook_footer_before' => 
  array (
    0 => 'Block_55906029264c59c3d37fc60_66456965',
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
class Block_132069425964c59c3d380924_65590297 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'hook_footer' => 
  array (
    0 => 'Block_132069425964c59c3d380924_65590297',
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
class Block_151079904664c59c3d381421_17925915 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'copyright_link' => 
  array (
    0 => 'Block_151079904664c59c3d381421_17925915',
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
class Block_62496970464c59c3d384087_15636037 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'hook_footer_after' => 
  array (
    0 => 'Block_62496970464c59c3d384087_15636037',
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
