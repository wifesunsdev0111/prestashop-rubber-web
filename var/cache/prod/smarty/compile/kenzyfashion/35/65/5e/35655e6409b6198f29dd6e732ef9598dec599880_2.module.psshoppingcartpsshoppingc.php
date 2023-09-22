<?php
/* Smarty version 3.1.47, created on 2023-05-15 14:54:57
  from 'module:psshoppingcartpsshoppingc' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64622ba1efd9e6_63581725',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '35655e6409b6198f29dd6e732ef9598dec599880' => 
    array (
      0 => 'module:psshoppingcartpsshoppingc',
      1 => 1680526196,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
    'module:ps_shoppingcart/ps_shoppingcart-product-line.tpl' => 1,
  ),
),false)) {
function content_64622ba1efd9e6_63581725 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="_desktop_cart">
  <div class="dropdown js-dropdown shopping-cart">
  <div class="blockcart cart-preview <?php if ($_smarty_tpl->tpl_vars['cart']->value['products_count'] > 0) {?>active<?php } else { ?>inactive<?php }?>" data-refresh-url="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['refresh_url']->value, ENT_QUOTES, 'UTF-8');?>
">
    <div class="header" data-toggle="dropdown">
      <div class="blockcart-inner">
        <?php if ($_smarty_tpl->tpl_vars['cart']->value['products_count'] > 0) {?>
          <a rel="nofollow" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart_url']->value, ENT_QUOTES, 'UTF-8');?>
">
        <?php }?>
          
		  <div class="shopping-cart-icon"></div>
          <span class="cart-products-count"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart']->value['products_count'], ENT_QUOTES, 'UTF-8');?>
</span>
          <span class="hidden-sm-down shopping-cart-name"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'My Cart','d'=>'Shop.Theme.Checkout'),$_smarty_tpl ) );?>
</span>
          
        <?php if ($_smarty_tpl->tpl_vars['cart']->value['products_count'] > 0) {?>
          </a>
        <?php }?>
      </div>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['cart']->value['products_count'] > 0) {?>
            <div class="ax_cart cart-hover-content  dropdown-menu">
                <ul>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cart']->value['products'], 'product');
$_smarty_tpl->tpl_vars['product']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->do_else = false;
?>
                        <li class="cart-wishlist-item">
                            <?php $_smarty_tpl->_subTemplateRender('module:ps_shoppingcart/ps_shoppingcart-product-line.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('product'=>$_smarty_tpl->tpl_vars['product']->value), 0, true);
?>
                        </li>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                </ul>
                <div class="cart-summary">
                    <div class="cart-subtotals">
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
					
                    
					<div class="cart-total">
                        <span class="label"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart']->value['totals']['total']['label'], ENT_QUOTES, 'UTF-8');?>
</span>
                        <span class="value"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart']->value['totals']['total']['value'], ENT_QUOTES, 'UTF-8');?>
</span>
                    </div>
					
                </div>
                <div class="cart-wishlist-action">
                    <a rel="nofollow" class="cart-wishlist-viewcart btn btn-primary" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cart_url']->value, ENT_QUOTES, 'UTF-8');?>
">view cart</a>
                  
                </div>
            </div> 
        <?php } else { ?>
            <div class="ax_cart cart-hover-content dropdown-menu no-item">
                <span class="no-item">There is no itme in your cart.</span>
            </div>
  <?php }?>
  </div>
</div>
</div>
<?php }
}
