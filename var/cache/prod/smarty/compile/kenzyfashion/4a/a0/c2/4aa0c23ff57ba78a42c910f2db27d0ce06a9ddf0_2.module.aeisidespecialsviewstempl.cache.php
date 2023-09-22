<?php
/* Smarty version 3.1.47, created on 2023-05-15 14:58:06
  from 'module:aeisidespecialsviewstempl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64622c5e2a7e87_11690714',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4aa0c23ff57ba78a42c910f2db27d0ce06a9ddf0' => 
    array (
      0 => 'module:aeisidespecialsviewstempl',
      1 => 1680526194,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64622c5e2a7e87_11690714 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
$_smarty_tpl->compiled->nocache_hash = '149415616164622c5e29b7e5_11253751';
?>

<div class="sidebar-specials block">
<h4 class="block_title hidden-md-down"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Special Products','mod'=>'aei_sidespecials'),$_smarty_tpl ) );?>
</h4>
<h4 class="block_title hidden-lg-up" data-target="#block_specials_toggle" data-toggle="collapse"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Special Products','mod'=>'aei_sidespecials'),$_smarty_tpl ) );?>

    <span class="float-xs-right">
      <span class="navbar-toggler collapse-icons">
      <i class="material-icons add">&#xE313;</i>
      <i class="material-icons remove">&#xE316;</i>
      </span>
    </span>
  </h4>
 <div class="block_content collapse" id="block_specials_toggle">
  <div class="products clearfix">
   
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['products']->value, 'product');
$_smarty_tpl->tpl_vars['product']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->do_else = false;
?>
    <div class="product-item">
    <div class="left-part">
      <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_175640366264622c5e29d518_66970197', 'product_thumbnail');
?>

    </div>


<div class="right-part">
  <div class="product-description">
      <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_73758968464622c5e29f072_66230670', 'product_name');
?>


      <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14310675964622c5e2a06a6_34073660', 'product_price_and_shipping');
?>

  </div>

  <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8352428664622c5e2a5a03_00230265', 'product_buy');
?>

</div>
    </div>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
  </div>
  <div class="clearfix">
  <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['allSpecialProductsLink']->value, ENT_QUOTES, 'UTF-8');?>
" class="allproducts"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'All Products','mod'=>'aei_sidespecials'),$_smarty_tpl ) );?>
</a>
  </div>
  </div>
</div>
<?php }
/* {block 'product_thumbnail'} */
class Block_175640366264622c5e29d518_66970197 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'product_thumbnail' => 
  array (
    0 => 'Block_175640366264622c5e29d518_66970197',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['url'], ENT_QUOTES, 'UTF-8');?>
" class="thumbnail product-thumbnail">
        <img
          src = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['cover']['bySize']['cart_default']['url'], ENT_QUOTES, 'UTF-8');?>
"
          alt = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['cover']['legend'], ENT_QUOTES, 'UTF-8');?>
"
        >
      </a>
    <?php
}
}
/* {/block 'product_thumbnail'} */
/* {block 'product_name'} */
class Block_73758968464622c5e29f072_66230670 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'product_name' => 
  array (
    0 => 'Block_73758968464622c5e29f072_66230670',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <h1 class="h3 product-title" itemprop="name"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['url'], ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'truncate' ][ 0 ], array( $_smarty_tpl->tpl_vars['product']->value['name'],30,'...' )), ENT_QUOTES, 'UTF-8');?>
</a></h1>
      <?php
}
}
/* {/block 'product_name'} */
/* {block 'product_reviews'} */
class Block_205879873864622c5e2a4764_79203652 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

			<div class="product_reviews">
				<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayProductListReviews','product'=>$_smarty_tpl->tpl_vars['product']->value),$_smarty_tpl ) );?>

			</div>
	  	  <?php
}
}
/* {/block 'product_reviews'} */
/* {block 'product_price_and_shipping'} */
class Block_14310675964622c5e2a06a6_34073660 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'product_price_and_shipping' => 
  array (
    0 => 'Block_14310675964622c5e2a06a6_34073660',
  ),
  'product_reviews' => 
  array (
    0 => 'Block_205879873864622c5e2a4764_79203652',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <?php if ($_smarty_tpl->tpl_vars['product']->value['show_price']) {?>
          <div class="product-price-and-shipping">
		    <span itemprop="price" class="price"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['price'], ENT_QUOTES, 'UTF-8');?>
</span>
            <?php if ($_smarty_tpl->tpl_vars['product']->value['has_discount']) {?>
              <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayProductPriceBlock','product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>"old_price"),$_smarty_tpl ) );?>


              <span class="regular-price"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['regular_price'], ENT_QUOTES, 'UTF-8');?>
</span>
              <?php if ($_smarty_tpl->tpl_vars['product']->value['discount_type'] === 'percentage') {?>
                <span class="discount-percentage"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['discount_percentage'], ENT_QUOTES, 'UTF-8');?>
</span>
              <?php }?>
            <?php }?>

            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayProductPriceBlock','product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>"before_price"),$_smarty_tpl ) );?>


          

            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayProductPriceBlock','product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>'unit_price'),$_smarty_tpl ) );?>


            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayProductPriceBlock','product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>'weight'),$_smarty_tpl ) );?>

          </div>
		    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_205879873864622c5e2a4764_79203652', 'product_reviews', $this->tplIndex);
?>

		  
		  
        <?php }?>
      <?php
}
}
/* {/block 'product_price_and_shipping'} */
/* {block 'product_buy'} */
class Block_8352428664622c5e2a5a03_00230265 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'product_buy' => 
  array (
    0 => 'Block_8352428664622c5e2a5a03_00230265',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

			<?php if (!$_smarty_tpl->tpl_vars['configuration']->value['is_catalog']) {?>
				<div class="product-actions">
					  <form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['urls']->value['pages']['cart'], ENT_QUOTES, 'UTF-8');?>
" method="post" class="add-to-cart-or-refresh">
						<input type="hidden" name="token" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['static_token']->value, ENT_QUOTES, 'UTF-8');?>
">
						<input type="hidden" name="id_product" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id'], ENT_QUOTES, 'UTF-8');?>
" class="product_page_product_id">
						<input type="hidden" name="id_customization" value="0" class="product_customization_id">						
					</form>
				</div>
			<?php }?>
	<?php
}
}
/* {/block 'product_buy'} */
}
