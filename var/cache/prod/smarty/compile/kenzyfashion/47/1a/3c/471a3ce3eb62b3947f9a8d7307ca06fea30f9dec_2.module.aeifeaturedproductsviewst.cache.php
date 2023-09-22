<?php
/* Smarty version 3.1.47, created on 2023-05-15 14:58:06
  from 'module:aeifeaturedproductsviewst' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64622c5e5f7698_27551660',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '471a3ce3eb62b3947f9a8d7307ca06fea30f9dec' => 
    array (
      0 => 'module:aeifeaturedproductsviewst',
      1 => 1680526194,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
    'file:catalog/_partials/miniatures/product.tpl' => 2,
  ),
),false)) {
function content_64622c5e5f7698_27551660 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '211397359464622c5e5eb7a9_50948944';
?>

<section class="feature-products">
   <!-- <div class="container"> -->
   <div class="products tab-container">
      <!-- <h1 class="h1 ax-product-title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'feature products','d'=>'Shop.Theme.Catalog','mod'=>'aei_featuredproducts'),$_smarty_tpl ) );?>
</h1> -->
   <div class="homeproducts-row row">
      <?php $_smarty_tpl->_assignInScope('sliderFor', 9);?> <!-- Define Number of product for SLIDER -->
      <?php if ($_smarty_tpl->tpl_vars['slider']->value == 1 && $_smarty_tpl->tpl_vars['no_prod']->value >= $_smarty_tpl->tpl_vars['sliderFor']->value) {?>
	  <div class="product-carousel">
      <ul id="aeifeature-slider" class="aeifeature-slider">
         <?php $_smarty_tpl->_assignInScope('featurecount', 0);?>
         <?php $_smarty_tpl->_assignInScope('featureltotalcount', 0);?>
         <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['products']->value, 'product', false, NULL, 'homefeatureProducts', array (
  'index' => true,
));
$_smarty_tpl->tpl_vars['product']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->do_else = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_homefeatureProducts']->value['index']++;
?>
         <?php $_smarty_tpl->_assignInScope('featureltotalcount', $_smarty_tpl->tpl_vars['featurecount']->value++);?>
         <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
         <?php if ($_smarty_tpl->tpl_vars['featurecount']->value > 4 && $_smarty_tpl->tpl_vars['slider']->value == 1) {?>
         <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['products']->value, 'product', false, NULL, 'homefeatureProducts', array (
  'index' => true,
));
$_smarty_tpl->tpl_vars['product']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->do_else = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_homefeatureProducts']->value['index']++;
?>
		 <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_homefeatureProducts']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_homefeatureProducts']->value['index'] : null)%2 == 0) {?>
         <li class="featuredlistitem">
            <ul>
			<?php }?>
               <li class="<?php if ($_smarty_tpl->tpl_vars['slider']->value == 1 && $_smarty_tpl->tpl_vars['no_prod']->value >= $_smarty_tpl->tpl_vars['sliderFor']->value) {?>item<?php } else { ?>product_item col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3<?php }?>">
                  <?php $_smarty_tpl->_subTemplateRender("file:catalog/_partials/miniatures/product.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('product'=>$_smarty_tpl->tpl_vars['product']->value), 0, true);
?>
               </li>
			   <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_homefeatureProducts']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_homefeatureProducts']->value['index'] : null)%2 != 0) {?>
            </ul>
         </li>
		 <?php }?>
         <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
         <?php }?>
      </ul>
	  </div>
      <?php } else { ?>
      <ul id="aeifeature-grid" class="aeifeature-grid">
         <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['products']->value, 'product');
$_smarty_tpl->tpl_vars['product']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->do_else = false;
?>
         <li class="<?php if ($_smarty_tpl->tpl_vars['slider']->value == 1 && $_smarty_tpl->tpl_vars['no_prod']->value >= $_smarty_tpl->tpl_vars['sliderFor']->value) {?>item<?php } else { ?>product_item col-xs-12 col-sm-6 col-md-4 col-xl-3<?php }?>">
            <?php $_smarty_tpl->_subTemplateRender("file:catalog/_partials/miniatures/product.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('product'=>$_smarty_tpl->tpl_vars['product']->value), 0, true);
?>
         </li>
         <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?> 
      </ul>
      <a class="all-product-link float-xs-left pull-md-right h4" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['allProductsLink']->value, ENT_QUOTES, 'UTF-8');?>
">
      <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'View more products','mod'=>'aei_featuredproducts'),$_smarty_tpl ) );?>

      </a>			
      <?php }?>	
      <?php if ($_smarty_tpl->tpl_vars['slider']->value == 1 && $_smarty_tpl->tpl_vars['no_prod']->value >= $_smarty_tpl->tpl_vars['sliderFor']->value) {?>
         <div id="aeifeature-arrows" class="arrows">
         </div>
      <?php }?> 
   </div>	
   </div>
<!-- </div> -->
</section><?php }
}
