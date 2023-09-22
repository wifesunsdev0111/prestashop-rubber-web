<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:42:33
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/profiles/plist1447445083.tpl" */ ?>
<?php /*%%SmartyHeaderCode:67838994662b578f99b9699-81454256%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e499915e0494172199e27a2b3ca78961cbdc7b0b' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/profiles/plist1447445083.tpl',
      1 => 1470857966,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '67838994662b578f99b9699-81454256',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'product' => 0,
    'link' => 0,
    'homeSize' => 0,
    'PS_CATALOG_MODE' => 0,
    'restricted_country_mode' => 0,
    'priceDisplay' => 0,
    'add_prod_display' => 0,
    'static_token' => 0,
    'comparator_max_item' => 0,
    'quick_view' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b578f9a4f2b7_95230643',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b578f9a4f2b7_95230643')) {function content_62b578f9a4f2b7_95230643($_smarty_tpl) {?><div class="product-container product-block" itemscope itemtype="http://schema.org/Product"><div class="left-block">
<!-- @file modules\appagebuilder\views\templates\front\products\image_container -->
<div class="product-image-container image">
	<div class="leo-more-info hidden-xs" data-idproduct="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
"></div>
	<a class="product_img_link"	href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" itemprop="url">
		<img class="replace-2x img-responsive" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['id_image'],'home_default'), ENT_QUOTES, 'UTF-8', true);?>
" alt="<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['legend'])) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['legend'], ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" title="<?php if (!empty($_smarty_tpl->tpl_vars['product']->value['legend'])) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['legend'], ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>" <?php if (isset($_smarty_tpl->tpl_vars['homeSize']->value)) {?> width="<?php echo $_smarty_tpl->tpl_vars['homeSize']->value['width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['homeSize']->value['height'];?>
"<?php }?> itemprop="image" />
		<span class="product-additional" data-idproduct="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
"></span>
	</a>
	<?php if (isset($_smarty_tpl->tpl_vars['product']->value['new'])&&$_smarty_tpl->tpl_vars['product']->value['new']==1) {?>
		<a class="new-box" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
">
			<span class="label-new product-label label-info label"><?php echo smartyTranslate(array('s'=>'New'),$_smarty_tpl);?>
</span>
		</a>
	<?php }?>
	<?php if (isset($_smarty_tpl->tpl_vars['product']->value['on_sale'])&&$_smarty_tpl->tpl_vars['product']->value['on_sale']&&isset($_smarty_tpl->tpl_vars['product']->value['show_price'])&&$_smarty_tpl->tpl_vars['product']->value['show_price']&&!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
		<a class="sale-box" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
">
			<span class="label-sale product-label label-warning label"><?php echo smartyTranslate(array('s'=>'Sale!'),$_smarty_tpl);?>
</span>
		</a>
	<?php }?>
</div>


</div><div class="right-block"><div class="product-meta">
<!-- @file modules\appagebuilder\views\templates\front\products\name -->
<h5 itemprop="name" class="name">
	<?php if (isset($_smarty_tpl->tpl_vars['product']->value['pack_quantity'])&&$_smarty_tpl->tpl_vars['product']->value['pack_quantity']) {?><?php echo (intval($_smarty_tpl->tpl_vars['product']->value['pack_quantity'])).(' x ');?>
<?php }?>
	<a class="product-name" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" itemprop="url" >
		<?php echo htmlspecialchars($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['product']->value['name'],45,'...'), ENT_QUOTES, 'UTF-8', true);?>

	</a>
</h5>



<!-- @file modules\appagebuilder\views\templates\front\products\price -->
<?php if ((!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value&&((isset($_smarty_tpl->tpl_vars['product']->value['show_price'])&&$_smarty_tpl->tpl_vars['product']->value['show_price'])||(isset($_smarty_tpl->tpl_vars['product']->value['available_for_order'])&&$_smarty_tpl->tpl_vars['product']->value['available_for_order'])))) {?>
	<div class="content_price">
		<?php if (isset($_smarty_tpl->tpl_vars['product']->value['show_price'])&&$_smarty_tpl->tpl_vars['product']->value['show_price']&&!isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)) {?>
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"displayProductPriceBlock",'product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>'before_price'),$_smarty_tpl);?>

			<span class="price product-price">
				<?php if (!$_smarty_tpl->tpl_vars['priceDisplay']->value) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price']),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price_tax_exc']),$_smarty_tpl);?>
<?php }?>
			</span>
			<?php if (isset($_smarty_tpl->tpl_vars['product']->value['specific_prices'])&&$_smarty_tpl->tpl_vars['product']->value['specific_prices']&&isset($_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction'])&&$_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction']>0) {?>
				<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"displayProductPriceBlock",'product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>"old_price"),$_smarty_tpl);?>

				<span class="old-price product-price">
					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPrice'][0][0]->displayWtPrice(array('p'=>$_smarty_tpl->tpl_vars['product']->value['price_without_reduction']),$_smarty_tpl);?>

				</span>
				<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"displayProductPriceBlock",'id_product'=>$_smarty_tpl->tpl_vars['product']->value['id_product'],'type'=>"old_price"),$_smarty_tpl);?>

				<?php if ($_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction_type']=='percentage') {?>
					<span class="price-percent-reduction">-<?php echo $_smarty_tpl->tpl_vars['product']->value['specific_prices']['reduction']*100;?>
%</span>
				<?php }?>
			<?php }?>
			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"displayProductPriceBlock",'product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>"price"),$_smarty_tpl);?>

			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"displayProductPriceBlock",'product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>"unit_price"),$_smarty_tpl);?>

			<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"displayProductPriceBlock",'product'=>$_smarty_tpl->tpl_vars['product']->value,'type'=>'after_price'),$_smarty_tpl);?>

		<?php }?>
	</div>
<?php }?>
<!-- @file modules\appagebuilder\views\templates\front\products\description -->
<p class="product-desc" itemprop="description">
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate(strip_tags($_smarty_tpl->tpl_vars['product']->value['description_short']),360,'...');?>

</p>


<div class="functional-buttons clearfix">
<!-- @file modules\appagebuilder\views\templates\front\products\add_to_cart -->
<?php if (($_smarty_tpl->tpl_vars['product']->value['id_product_attribute']==0||(isset($_smarty_tpl->tpl_vars['add_prod_display']->value)&&($_smarty_tpl->tpl_vars['add_prod_display']->value==1)))&&$_smarty_tpl->tpl_vars['product']->value['available_for_order']&&!isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)&&$_smarty_tpl->tpl_vars['product']->value['customizable']!=2&&!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
	<?php if ((!isset($_smarty_tpl->tpl_vars['product']->value['customization_required'])||!$_smarty_tpl->tpl_vars['product']->value['customization_required'])&&($_smarty_tpl->tpl_vars['product']->value['allow_oosp']||$_smarty_tpl->tpl_vars['product']->value['quantity']>0)) {?>
		<?php $_smarty_tpl->_capture_stack[0][] = array('default', null, null); ob_start(); ?>add=1&amp;id_product=<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
<?php if (isset($_smarty_tpl->tpl_vars['product']->value['id_product_attribute'])&&$_smarty_tpl->tpl_vars['product']->value['id_product_attribute']) {?>&amp;ipa=<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product_attribute']);?>
<?php }?><?php if (isset($_smarty_tpl->tpl_vars['static_token']->value)) {?>&amp;token=<?php echo $_smarty_tpl->tpl_vars['static_token']->value;?>
<?php }?><?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
		<a class="button ajax_add_to_cart_button btn btn-outline" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('cart',true,null,Smarty::$_smarty_vars['capture']['default'],false), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Add to cart'),$_smarty_tpl);?>
" data-id-product-attribute="<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product_attribute']);?>
" data-id-product="<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
" data-minimal_quantity="<?php if (isset($_smarty_tpl->tpl_vars['product']->value['product_attribute_minimal_quantity'])&&$_smarty_tpl->tpl_vars['product']->value['product_attribute_minimal_quantity']>=1) {?><?php echo intval($_smarty_tpl->tpl_vars['product']->value['product_attribute_minimal_quantity']);?>
<?php } else { ?><?php echo intval($_smarty_tpl->tpl_vars['product']->value['minimal_quantity']);?>
<?php }?>">
			<i class="fa fa-shopping-cart"></i><span><?php echo smartyTranslate(array('s'=>'Add to cart'),$_smarty_tpl);?>
</span>
		</a>
	<?php } else { ?>
		<span class="button ajax_add_to_cart_button btn btn-outline disabled">
			<i class="fa fa-shopping-cart"></i><span><?php echo smartyTranslate(array('s'=>'Add to cart'),$_smarty_tpl);?>
</span>
		</span>
	<?php }?>
<?php }?>



<!-- @file modules\appagebuilder\views\templates\front\products\wishlist -->

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayProductListFunctionalButtons','product'=>$_smarty_tpl->tpl_vars['product']->value),$_smarty_tpl);?>



<!-- @file modules\appagebuilder\views\templates\front\products\compare -->
<?php if (isset($_smarty_tpl->tpl_vars['comparator_max_item']->value)&&$_smarty_tpl->tpl_vars['comparator_max_item']->value) {?>

		<a class="add_to_compare compare" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" data-id-product="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
"><i class="fa fa-refresh"></i><span><?php echo smartyTranslate(array('s'=>'Add Compare'),$_smarty_tpl);?>
</span></a>

<?php }?>



<!-- @file modules\appagebuilder\views\templates\front\products\quick_view -->
<?php if (isset($_smarty_tpl->tpl_vars['quick_view']->value)&&$_smarty_tpl->tpl_vars['quick_view']->value) {?>
	<a class="quick-view" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" data-link="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
">
		<i class="fa fa-eye"></i>
	</a>
<?php }?>


</div></div></div></div><?php }} ?>
