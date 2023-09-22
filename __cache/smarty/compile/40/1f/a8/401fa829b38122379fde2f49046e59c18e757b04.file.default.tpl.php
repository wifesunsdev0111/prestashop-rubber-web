<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:10
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/sub/product_info/default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:23937584362b5786ae81bb4-30618330%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '401fa829b38122379fde2f49046e59c18e757b04' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/sub/product_info/default.tpl',
      1 => 1470858042,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '23937584362b5786ae81bb4-30618330',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'quantity_discounts' => 0,
    'display_discount_price' => 0,
    'quantity_discount' => 0,
    'productPriceWithoutReduction' => 0,
    'discountPrice' => 0,
    'qtyProductPrice' => 0,
    'features' => 0,
    'feature' => 0,
    'product' => 0,
    'HOOK_PRODUCT_TAB' => 0,
    'HOOK_PRODUCT_TAB_CONTENT' => 0,
    'accessories' => 0,
    'accessory' => 0,
    'restricted_country_mode' => 0,
    'link' => 0,
    'accessoryLink' => 0,
    'PS_CATALOG_MODE' => 0,
    'priceDisplay' => 0,
    'static_token' => 0,
    'quick_view' => 0,
    'HOOK_PRODUCT_FOOTER' => 0,
    'attachments' => 0,
    'attachment' => 0,
    'customizationFormTarget' => 0,
    'customizationFields' => 0,
    'field' => 0,
    'key' => 0,
    'pictures' => 0,
    'pic_dir' => 0,
    'img_dir' => 0,
    'customizationField' => 0,
    'textFields' => 0,
    'img_ps_dir' => 0,
    'packItems' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b5786af34828_88543487',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b5786af34828_88543487')) {function content_62b5786af34828_88543487($_smarty_tpl) {?><?php if (!is_callable('smarty_function_cycle')) include '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/tools/smarty/plugins/function.cycle.php';
if (!is_callable('smarty_function_counter')) include '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/tools/smarty/plugins/function.counter.php';
?><?php if ((isset($_smarty_tpl->tpl_vars['quantity_discounts']->value)&&count($_smarty_tpl->tpl_vars['quantity_discounts']->value)>0)) {?>
			<!-- quantity discount -->
			<section class="page-product-box">
				<h3 class="page-subheading"><?php echo smartyTranslate(array('s'=>'Volume discounts'),$_smarty_tpl);?>
</h3>
				<div id="quantityDiscount" class="table-responsive">
					<table class="std table-product-discounts ">
						<thead>
							<tr>
								<th><?php echo smartyTranslate(array('s'=>'Quantity'),$_smarty_tpl);?>
</th>
								<th><?php if ($_smarty_tpl->tpl_vars['display_discount_price']->value) {?><?php echo smartyTranslate(array('s'=>'Price'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Discount'),$_smarty_tpl);?>
<?php }?></th>
								<th><?php echo smartyTranslate(array('s'=>'You Save'),$_smarty_tpl);?>
</th>
							</tr>
						</thead>
						<tbody>
							<?php  $_smarty_tpl->tpl_vars['quantity_discount'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['quantity_discount']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['quantity_discounts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['quantity_discount']->key => $_smarty_tpl->tpl_vars['quantity_discount']->value) {
$_smarty_tpl->tpl_vars['quantity_discount']->_loop = true;
?>
							<tr id="quantityDiscount_<?php echo $_smarty_tpl->tpl_vars['quantity_discount']->value['id_product_attribute'];?>
" class="quantityDiscount_<?php echo $_smarty_tpl->tpl_vars['quantity_discount']->value['id_product_attribute'];?>
" data-discount-type="<?php echo $_smarty_tpl->tpl_vars['quantity_discount']->value['reduction_type'];?>
" data-discount="<?php echo floatval($_smarty_tpl->tpl_vars['quantity_discount']->value['real_value']);?>
" data-discount-quantity="<?php echo intval($_smarty_tpl->tpl_vars['quantity_discount']->value['quantity']);?>
">
								<td>
									<?php echo intval($_smarty_tpl->tpl_vars['quantity_discount']->value['quantity']);?>

								</td>
								<td>
									<?php if ($_smarty_tpl->tpl_vars['quantity_discount']->value['price']>=0||$_smarty_tpl->tpl_vars['quantity_discount']->value['reduction_type']=='amount') {?>
										<?php if ($_smarty_tpl->tpl_vars['display_discount_price']->value) {?>
											<?php if ($_smarty_tpl->tpl_vars['quantity_discount']->value['reduction_tax']==0&&!$_smarty_tpl->tpl_vars['quantity_discount']->value['price']) {?>
												<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>floatval($_smarty_tpl->tpl_vars['productPriceWithoutReduction']->value)-floatval(($_smarty_tpl->tpl_vars['productPriceWithoutReduction']->value*$_smarty_tpl->tpl_vars['quantity_discount']->value['reduction_with_tax']))),$_smarty_tpl);?>

											<?php } else { ?>
												<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>floatval($_smarty_tpl->tpl_vars['productPriceWithoutReduction']->value)-floatval($_smarty_tpl->tpl_vars['quantity_discount']->value['real_value'])),$_smarty_tpl);?>

											<?php }?>
										<?php } else { ?>
											<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>floatval($_smarty_tpl->tpl_vars['quantity_discount']->value['real_value'])),$_smarty_tpl);?>

										<?php }?>
									<?php } else { ?>
										<?php if ($_smarty_tpl->tpl_vars['display_discount_price']->value) {?>
											<?php if ($_smarty_tpl->tpl_vars['quantity_discount']->value['reduction_tax']==0) {?>
												<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>floatval($_smarty_tpl->tpl_vars['productPriceWithoutReduction']->value)-floatval(($_smarty_tpl->tpl_vars['productPriceWithoutReduction']->value*$_smarty_tpl->tpl_vars['quantity_discount']->value['reduction_with_tax']))),$_smarty_tpl);?>

											<?php } else { ?>
												<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>floatval($_smarty_tpl->tpl_vars['productPriceWithoutReduction']->value)-floatval(($_smarty_tpl->tpl_vars['productPriceWithoutReduction']->value*$_smarty_tpl->tpl_vars['quantity_discount']->value['reduction']))),$_smarty_tpl);?>

											<?php }?>
										<?php } else { ?>
											<?php echo floatval($_smarty_tpl->tpl_vars['quantity_discount']->value['real_value']);?>
%
										<?php }?>
									<?php }?>
								</td>
								<td>
									<span><?php echo smartyTranslate(array('s'=>'Up to'),$_smarty_tpl);?>
</span>
									<?php if ($_smarty_tpl->tpl_vars['quantity_discount']->value['price']>=0||$_smarty_tpl->tpl_vars['quantity_discount']->value['reduction_type']=='amount') {?>
										<?php $_smarty_tpl->tpl_vars['discountPrice'] = new Smarty_variable(floatval($_smarty_tpl->tpl_vars['productPriceWithoutReduction']->value)-floatval($_smarty_tpl->tpl_vars['quantity_discount']->value['real_value']), null, 0);?>
									<?php } else { ?>
										<?php $_smarty_tpl->tpl_vars['discountPrice'] = new Smarty_variable(floatval($_smarty_tpl->tpl_vars['productPriceWithoutReduction']->value)-floatval(($_smarty_tpl->tpl_vars['productPriceWithoutReduction']->value*$_smarty_tpl->tpl_vars['quantity_discount']->value['reduction'])), null, 0);?>
									<?php }?>
									<?php $_smarty_tpl->tpl_vars['discountPrice'] = new Smarty_variable($_smarty_tpl->tpl_vars['discountPrice']->value*$_smarty_tpl->tpl_vars['quantity_discount']->value['quantity'], null, 0);?>
									<?php $_smarty_tpl->tpl_vars['qtyProductPrice'] = new Smarty_variable(floatval($_smarty_tpl->tpl_vars['productPriceWithoutReduction']->value)*$_smarty_tpl->tpl_vars['quantity_discount']->value['quantity'], null, 0);?>
									<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['qtyProductPrice']->value-$_smarty_tpl->tpl_vars['discountPrice']->value),$_smarty_tpl);?>

								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</section>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['features']->value)&&$_smarty_tpl->tpl_vars['features']->value) {?>
			<!-- Data sheet -->
			<section class="page-product-box">
				<h3 class="page-subheading"><?php echo smartyTranslate(array('s'=>'Data sheet'),$_smarty_tpl);?>
</h3>
				<table class="table-data-sheet">			
					<?php  $_smarty_tpl->tpl_vars['feature'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['feature']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['features']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['feature']->key => $_smarty_tpl->tpl_vars['feature']->value) {
$_smarty_tpl->tpl_vars['feature']->_loop = true;
?>
					<tr class="<?php echo smarty_function_cycle(array('values'=>"odd,even"),$_smarty_tpl);?>
">
						<?php if (isset($_smarty_tpl->tpl_vars['feature']->value['value'])) {?>			    
						<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['feature']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</td>
						<td><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['feature']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
</td>
						<?php }?>
					</tr>
					<?php } ?>
				</table>
			</section>
			<!--end Data sheet -->
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['product']->value)&&$_smarty_tpl->tpl_vars['product']->value->description) {?>
			<!-- More info -->
			<section class="page-product-box">
				<h3 class="page-subheading"><?php echo smartyTranslate(array('s'=>'More info'),$_smarty_tpl);?>
</h3>
				<!-- full description -->
				<div  class="rte"><?php echo $_smarty_tpl->tpl_vars['product']->value->description;?>
</div>
			</section>
			<!--end  More info -->
		<?php }?>
		<!--HOOK_PRODUCT_TAB -->
		<section class="page-product-box">
			<?php echo $_smarty_tpl->tpl_vars['HOOK_PRODUCT_TAB']->value;?>

			<?php if (isset($_smarty_tpl->tpl_vars['HOOK_PRODUCT_TAB_CONTENT']->value)&&$_smarty_tpl->tpl_vars['HOOK_PRODUCT_TAB_CONTENT']->value) {?><?php echo $_smarty_tpl->tpl_vars['HOOK_PRODUCT_TAB_CONTENT']->value;?>
<?php }?>
		</section>
		<!--end HOOK_PRODUCT_TAB -->
		<?php if (isset($_smarty_tpl->tpl_vars['accessories']->value)&&$_smarty_tpl->tpl_vars['accessories']->value) {?>
			<!--Accessories -->
			<section class="page-product-box">
				
				<div class="block products_block accessories-block clearfix">
					<h3 class="page-subheading"><?php echo smartyTranslate(array('s'=>'Accessories'),$_smarty_tpl);?>
</h3>
						<div class="product_list grid row produst_list_default">
							<?php  $_smarty_tpl->tpl_vars['accessory'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['accessory']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['accessories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['accessory']->key => $_smarty_tpl->tpl_vars['accessory']->value) {
$_smarty_tpl->tpl_vars['accessory']->_loop = true;
?>
								<?php if (($_smarty_tpl->tpl_vars['accessory']->value['allow_oosp']||$_smarty_tpl->tpl_vars['accessory']->value['quantity_all_versions']>0||$_smarty_tpl->tpl_vars['accessory']->value['quantity']>0)&&$_smarty_tpl->tpl_vars['accessory']->value['available_for_order']&&!isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)) {?>
									<?php $_smarty_tpl->tpl_vars['accessoryLink'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getProductLink($_smarty_tpl->tpl_vars['accessory']->value['id_product'],$_smarty_tpl->tpl_vars['accessory']->value['link_rewrite'],$_smarty_tpl->tpl_vars['accessory']->value['category']), null, 0);?>
									<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 product_block" itemscope itemtype="https://schema.org/Product">
										<div class="product-container product-block">
											<div class="left-block">
												<div class="product-image-container image ">
													<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['accessoryLink']->value, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['accessory']->value['legend'], ENT_QUOTES, 'UTF-8', true);?>
" class="product-image product_image">
														<img class="lazyOwl" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['accessory']->value['link_rewrite'],$_smarty_tpl->tpl_vars['accessory']->value['id_image'],'home_default'), ENT_QUOTES, 'UTF-8', true);?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['accessory']->value['legend'], ENT_QUOTES, 'UTF-8', true);?>
" />
													</a>
												</div>
											</div>
											<div class="right-block">	
												<div class="product-meta">
													<h5 class="product-name name">
														<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['accessoryLink']->value, ENT_QUOTES, 'UTF-8', true);?>
">
															<?php echo htmlspecialchars($_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['accessory']->value['name'],45,'...',true), ENT_QUOTES, 'UTF-8', true);?>

														</a>
													</h5>
														<?php if ($_smarty_tpl->tpl_vars['accessory']->value['show_price']&&!isset($_smarty_tpl->tpl_vars['restricted_country_mode']->value)&&!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
															<div class="content_price">
																<span class="price">
																	<?php if ($_smarty_tpl->tpl_vars['priceDisplay']->value!=1) {?>
																	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPrice'][0][0]->displayWtPrice(array('p'=>$_smarty_tpl->tpl_vars['accessory']->value['price']),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayWtPrice'][0][0]->displayWtPrice(array('p'=>$_smarty_tpl->tpl_vars['accessory']->value['price_tax_exc']),$_smarty_tpl);?>

																	<?php }?>
																</span>
															</div>
														<?php }?>	
													<div class="product-desc block_description">
														<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['accessoryLink']->value, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'More'),$_smarty_tpl);?>
" class="product_description">
															<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['accessory']->value['description_short']),25,'...');?>

														</a>
													</div>
													<div class="clearfix functional-buttons" style="margin-top:5px">
														<?php if (!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value&&($_smarty_tpl->tpl_vars['accessory']->value['allow_oosp']||$_smarty_tpl->tpl_vars['accessory']->value['quantity']>0)) {?>
																<a class="exclusive button ajax_add_to_cart_button btn btn-outline" href="<?php ob_start();?><?php echo intval($_smarty_tpl->tpl_vars['accessory']->value['id_product']);?>
<?php $_tmp1=ob_get_clean();?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('cart',true,null,"qty=1&amp;id_product=".$_tmp1."&amp;token=".((string)$_smarty_tpl->tpl_vars['static_token']->value)."&amp;add"), ENT_QUOTES, 'UTF-8', true);?>
" data-id-product="<?php echo intval($_smarty_tpl->tpl_vars['accessory']->value['id_product']);?>
" title="<?php echo smartyTranslate(array('s'=>'Add to cart'),$_smarty_tpl);?>
">
																	<i class="fa fa-shopping-cart"></i><span><?php echo smartyTranslate(array('s'=>'Add to cart'),$_smarty_tpl);?>
</span>
																</a>
														<?php }?>
														<?php if (isset($_smarty_tpl->tpl_vars['quick_view']->value)&&$_smarty_tpl->tpl_vars['quick_view']->value) {?>
																<a class="quick-view" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['accessory']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" rel="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['accessory']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" data-original-title="<?php echo smartyTranslate(array('s'=>'Quick view'),$_smarty_tpl);?>
">
																	<i class="fa fa-eye"></i>
																</a>
															<?php }?>
															
															<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayProductListFunctionalButtons','product'=>$_smarty_tpl->tpl_vars['accessory']->value),$_smarty_tpl);?>

													</div>
												</div>
											</div>
										</div>
									</div>
								<?php }?>
							<?php } ?>
						</div>
				</div>	
			</section>
			<!--end Accessories -->
		<?php }?>
                <?php if (isset($_smarty_tpl->tpl_vars['HOOK_PRODUCT_FOOTER']->value)&&$_smarty_tpl->tpl_vars['HOOK_PRODUCT_FOOTER']->value) {?><?php echo $_smarty_tpl->tpl_vars['HOOK_PRODUCT_FOOTER']->value;?>
<?php }?>
		<!-- description & features -->
		<?php if ((isset($_smarty_tpl->tpl_vars['product']->value)&&$_smarty_tpl->tpl_vars['product']->value->description)||(isset($_smarty_tpl->tpl_vars['features']->value)&&$_smarty_tpl->tpl_vars['features']->value)||(isset($_smarty_tpl->tpl_vars['accessories']->value)&&$_smarty_tpl->tpl_vars['accessories']->value)||(isset($_smarty_tpl->tpl_vars['HOOK_PRODUCT_TAB']->value)&&$_smarty_tpl->tpl_vars['HOOK_PRODUCT_TAB']->value)||(isset($_smarty_tpl->tpl_vars['attachments']->value)&&$_smarty_tpl->tpl_vars['attachments']->value)||isset($_smarty_tpl->tpl_vars['product']->value)&&$_smarty_tpl->tpl_vars['product']->value->customizable) {?>
			<?php if (isset($_smarty_tpl->tpl_vars['attachments']->value)&&$_smarty_tpl->tpl_vars['attachments']->value) {?>
			<!--Download -->
			<section class="page-product-box">
				<h3 class="page-subheading"><?php echo smartyTranslate(array('s'=>'Download'),$_smarty_tpl);?>
</h3>
				<?php  $_smarty_tpl->tpl_vars['attachment'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attachment']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['attachments']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['attachment']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['attachment']->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['attachements']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['attachment']->key => $_smarty_tpl->tpl_vars['attachment']->value) {
$_smarty_tpl->tpl_vars['attachment']->_loop = true;
 $_smarty_tpl->tpl_vars['attachment']->iteration++;
 $_smarty_tpl->tpl_vars['attachment']->last = $_smarty_tpl->tpl_vars['attachment']->iteration === $_smarty_tpl->tpl_vars['attachment']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['attachements']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['attachements']['last'] = $_smarty_tpl->tpl_vars['attachment']->last;
?>
					<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['attachements']['iteration']%3==1) {?><div class="row"><?php }?>
						<div class="col-lg-4">
							<h4><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('attachment',true,null,"id_attachment=".((string)$_smarty_tpl->tpl_vars['attachment']->value['id_attachment'])), ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['attachment']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</a></h4>
							<p class="text-muted"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['attachment']->value['description'], ENT_QUOTES, 'UTF-8', true);?>
</p>
							<a class="btn btn-outline btn-block" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('attachment',true,null,"id_attachment=".((string)$_smarty_tpl->tpl_vars['attachment']->value['id_attachment'])), ENT_QUOTES, 'UTF-8', true);?>
">
								<i class="fa fa-download"></i>
								<?php echo smartyTranslate(array('s'=>"Download"),$_smarty_tpl);?>
 (<?php echo Tools::formatBytes($_smarty_tpl->tpl_vars['attachment']->value['file_size'],2);?>
)
							</a>
							<hr>
						</div>
					<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['attachements']['iteration']%3==0||$_smarty_tpl->getVariable('smarty')->value['foreach']['attachements']['last']) {?></div><?php }?>
				<?php } ?>
			</section>
			<!--end Download -->
			<?php }?>
			<?php if (isset($_smarty_tpl->tpl_vars['product']->value)&&$_smarty_tpl->tpl_vars['product']->value->customizable) {?>
			<!--Customization -->
			<section class="page-product-box">
				<h3 class="page-subheading"><?php echo smartyTranslate(array('s'=>'Product customization'),$_smarty_tpl);?>
</h3>
				<!-- Customizable products -->
				<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['customizationFormTarget']->value;?>
" enctype="multipart/form-data" id="customizationForm" class="clearfix">
					<p class="infoCustomizable">
						<?php echo smartyTranslate(array('s'=>'After saving your customized product, remember to add it to your cart.'),$_smarty_tpl);?>

						<?php if ($_smarty_tpl->tpl_vars['product']->value->uploadable_files) {?>
						<br />
						<?php echo smartyTranslate(array('s'=>'Allowed file formats are: GIF, JPG, PNG'),$_smarty_tpl);?>
<?php }?>
					</p>
					<?php if (intval($_smarty_tpl->tpl_vars['product']->value->uploadable_files)) {?>
						<div class="customizableProductsFile">
							<h5 class="product-heading-h5"><?php echo smartyTranslate(array('s'=>'Pictures'),$_smarty_tpl);?>
</h5>
							<ul id="uploadable_files" class="clearfix">
								<?php echo smarty_function_counter(array('start'=>0,'assign'=>'customizationField'),$_smarty_tpl);?>

								<?php  $_smarty_tpl->tpl_vars['field'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['customizationFields']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field']->key => $_smarty_tpl->tpl_vars['field']->value) {
$_smarty_tpl->tpl_vars['field']->_loop = true;
?>
									<?php if ($_smarty_tpl->tpl_vars['field']->value['type']==0) {?>
										<li class="customizationUploadLine<?php if ($_smarty_tpl->tpl_vars['field']->value['required']) {?> required<?php }?>"><?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable(((('pictures_').($_smarty_tpl->tpl_vars['product']->value->id)).('_')).($_smarty_tpl->tpl_vars['field']->value['id_customization_field']), null, 0);?>
											<?php if (isset($_smarty_tpl->tpl_vars['pictures']->value[$_smarty_tpl->tpl_vars['key']->value])) {?>
												<div class="customizationUploadBrowse">
													<img src="<?php echo $_smarty_tpl->tpl_vars['pic_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['pictures']->value[$_smarty_tpl->tpl_vars['key']->value];?>
_small" alt="" />
														<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getProductDeletePictureLink($_smarty_tpl->tpl_vars['product']->value,$_smarty_tpl->tpl_vars['field']->value['id_customization_field']), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Delete'),$_smarty_tpl);?>
" >
															<img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
icon/delete.gif" alt="<?php echo smartyTranslate(array('s'=>'Delete'),$_smarty_tpl);?>
" class="customization_delete_icon" width="11" height="13" />
														</a>
												</div>
											<?php }?>
											<div class="customizationUploadBrowse form-group">
												<label class="customizationUploadBrowseDescription">
													<?php if (!empty($_smarty_tpl->tpl_vars['field']->value['name'])) {?>
														<?php echo $_smarty_tpl->tpl_vars['field']->value['name'];?>

													<?php } else { ?>
														<?php echo smartyTranslate(array('s'=>'Please select an image file from your computer'),$_smarty_tpl);?>

													<?php }?>
													<?php if ($_smarty_tpl->tpl_vars['field']->value['required']) {?><sup>*</sup><?php }?>
												</label>
												<input type="file" name="file<?php echo $_smarty_tpl->tpl_vars['field']->value['id_customization_field'];?>
" id="img<?php echo $_smarty_tpl->tpl_vars['customizationField']->value;?>
" class="form-control customization_block_input <?php if (isset($_smarty_tpl->tpl_vars['pictures']->value[$_smarty_tpl->tpl_vars['key']->value])) {?>filled<?php }?>" />
											</div>
										</li>
										<?php echo smarty_function_counter(array(),$_smarty_tpl);?>

									<?php }?>
								<?php } ?>
							</ul>
						</div>
					<?php }?>
					<?php if (intval($_smarty_tpl->tpl_vars['product']->value->text_fields)) {?>
						<div class="customizableProductsText">
							<h5 class="product-heading-h5"><?php echo smartyTranslate(array('s'=>'Text'),$_smarty_tpl);?>
</h5>
							<ul id="text_fields">
							<?php echo smarty_function_counter(array('start'=>0,'assign'=>'customizationField'),$_smarty_tpl);?>

							<?php  $_smarty_tpl->tpl_vars['field'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['customizationFields']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field']->key => $_smarty_tpl->tpl_vars['field']->value) {
$_smarty_tpl->tpl_vars['field']->_loop = true;
?>
								<?php if ($_smarty_tpl->tpl_vars['field']->value['type']==1) {?>
									<li class="customizationUploadLine<?php if ($_smarty_tpl->tpl_vars['field']->value['required']) {?> required<?php }?>">
										<label for ="textField<?php echo $_smarty_tpl->tpl_vars['customizationField']->value;?>
">
											<?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable(((('textFields_').($_smarty_tpl->tpl_vars['product']->value->id)).('_')).($_smarty_tpl->tpl_vars['field']->value['id_customization_field']), null, 0);?>
											<?php if (!empty($_smarty_tpl->tpl_vars['field']->value['name'])) {?>
												<?php echo $_smarty_tpl->tpl_vars['field']->value['name'];?>

											<?php }?>
											<?php if ($_smarty_tpl->tpl_vars['field']->value['required']) {?><sup>*</sup><?php }?>
										</label>
										<textarea name="textField<?php echo $_smarty_tpl->tpl_vars['field']->value['id_customization_field'];?>
" class="form-control customization_block_input" id="textField<?php echo $_smarty_tpl->tpl_vars['customizationField']->value;?>
" rows="3" cols="20"><?php if (isset($_smarty_tpl->tpl_vars['textFields']->value[$_smarty_tpl->tpl_vars['key']->value])) {?><?php echo stripslashes($_smarty_tpl->tpl_vars['textFields']->value[$_smarty_tpl->tpl_vars['key']->value]);?>
<?php }?></textarea>
									</li>
									<?php echo smarty_function_counter(array(),$_smarty_tpl);?>

								<?php }?>
							<?php } ?>
							</ul>
						</div>
					<?php }?>
					<p id="customizedDatas">
						<input type="hidden" name="quantityBackup" id="quantityBackup" value="" />
						<input type="hidden" name="submitCustomizedDatas" value="1" />
						<button class="button btn btn-outline button button-small btn-sm" name="saveCustomization">
							<span><?php echo smartyTranslate(array('s'=>'Save'),$_smarty_tpl);?>
</span>
						</button>
						<span id="ajax-loader" class="unvisible">
							<img src="<?php echo $_smarty_tpl->tpl_vars['img_ps_dir']->value;?>
loader.gif" alt="loader" />
						</span>
					</p>
				</form>
				<p class="clear required"><sup>*</sup> <?php echo smartyTranslate(array('s'=>'required fields'),$_smarty_tpl);?>
</p>	
			</section>
			<!--end Customization -->
			<?php }?>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['packItems']->value)&&count($_smarty_tpl->tpl_vars['packItems']->value)>0) {?>
		<section id="blockpack">
			<h3 class="page-subheading"><?php echo smartyTranslate(array('s'=>'Pack content'),$_smarty_tpl);?>
</h3>
			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('products'=>$_smarty_tpl->tpl_vars['packItems']->value), 0);?>

		</section>
		<?php }?><?php }} ?>
