<?php
/* Smarty version 3.1.47, created on 2023-05-17 14:29:54
  from '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/themes/kenzyfashion/templates/checkout/_partials/cart-detailed-totals.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_6464c8c21cead4_17632548',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '559611f80283cdc0cfca865c0bf2c8913d9e64e6' => 
    array (
      0 => '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/themes/kenzyfashion/templates/checkout/_partials/cart-detailed-totals.tpl',
      1 => 1680526196,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:checkout/_partials/cart-summary-totals.tpl' => 1,
    'file:checkout/_partials/cart-voucher.tpl' => 1,
  ),
),false)) {
function content_6464c8c21cead4_17632548 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2995729666464c8c21c2fe5_91598881', 'cart_detailed_totals');
?>

<?php }
/* {block 'cart_summary_totals'} */
class Block_6836320706464c8c21cce63_58701875 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php $_smarty_tpl->_subTemplateRender('file:checkout/_partials/cart-summary-totals.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('cart'=>$_smarty_tpl->tpl_vars['cart']->value), 0, false);
?>
  <?php
}
}
/* {/block 'cart_summary_totals'} */
/* {block 'cart_voucher'} */
class Block_17247832206464c8c21cdba8_66619653 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php $_smarty_tpl->_subTemplateRender('file:checkout/_partials/cart-voucher.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
  <?php
}
}
/* {/block 'cart_voucher'} */
/* {block 'cart_detailed_totals'} */
class Block_2995729666464c8c21c2fe5_91598881 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'cart_detailed_totals' => 
  array (
    0 => 'Block_2995729666464c8c21c2fe5_91598881',
  ),
  'cart_summary_totals' => 
  array (
    0 => 'Block_6836320706464c8c21cce63_58701875',
  ),
  'cart_voucher' => 
  array (
    0 => 'Block_17247832206464c8c21cdba8_66619653',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="cart-detailed-totals js-cart-detailed-totals">

  <div class="card-block cart-detailed-subtotals js-cart-detailed-subtotals">
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cart']->value['subtotals'], 'subtotal');
$_smarty_tpl->tpl_vars['subtotal']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['subtotal']->value) {
$_smarty_tpl->tpl_vars['subtotal']->do_else = false;
?>
      <?php if ($_smarty_tpl->tpl_vars['subtotal']->value && preg_match_all('/[^\s]/u',$_smarty_tpl->tpl_vars['subtotal']->value['value'], $tmp) > 0 && $_smarty_tpl->tpl_vars['subtotal']->value['type'] !== 'tax') {?>
        <div class="cart-summary-line" id="cart-subtotal-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['subtotal']->value['type'], ENT_QUOTES, 'UTF-8');?>
">
          <span class="label<?php if ('products' === $_smarty_tpl->tpl_vars['subtotal']->value['type']) {?> js-subtotal<?php }?>">
            <?php if ('products' == $_smarty_tpl->tpl_vars['subtotal']->value['type']) {?>
              <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart']->value['summary_string'], ENT_QUOTES, 'UTF-8');?>

            <?php } else { ?>
              <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['subtotal']->value['label'], ENT_QUOTES, 'UTF-8');?>

            <?php }?>
          </span>
          <span class="value">
            <?php if ('discount' == $_smarty_tpl->tpl_vars['subtotal']->value['type']) {?>-&nbsp;<?php }
echo htmlspecialchars($_smarty_tpl->tpl_vars['subtotal']->value['value'], ENT_QUOTES, 'UTF-8');?>

          </span>
          <?php if ($_smarty_tpl->tpl_vars['subtotal']->value['type'] === 'shipping') {?>
              <div><small class="value"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayCheckoutSubtotalDetails','subtotal'=>$_smarty_tpl->tpl_vars['subtotal']->value),$_smarty_tpl ) );?>
</small></div>
          <?php }?>
        </div>
      <?php }?>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  </div>

  <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6836320706464c8c21cce63_58701875', 'cart_summary_totals', $this->tplIndex);
?>


  <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17247832206464c8c21cdba8_66619653', 'cart_voucher', $this->tplIndex);
?>

</div>
<?php
}
}
/* {/block 'cart_detailed_totals'} */
}
