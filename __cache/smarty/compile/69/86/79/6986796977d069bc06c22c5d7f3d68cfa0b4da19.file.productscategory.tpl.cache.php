<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:09
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/modules/productscategory/productscategory.tpl" */ ?>
<?php /*%%SmartyHeaderCode:94054708762b578696d6ea9-73457899%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6986796977d069bc06c22c5d7f3d68cfa0b4da19' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/modules/productscategory/productscategory.tpl',
      1 => 1470857882,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '94054708762b578696d6ea9-73457899',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'categoryProducts' => 0,
    'tabname' => 0,
    'products' => 0,
    'itemsperpage' => 0,
    'mproducts' => 0,
    'columnspage' => 0,
    'productClassWidget' => 0,
    'productProfileDefault' => 0,
    'tpl_dir' => 0,
    'class' => 0,
    'comparator_max_item' => 0,
    'compared_products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b578697351e5_06150405',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b578697351e5_06150405')) {function content_62b578697351e5_06150405($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/tools/smarty/plugins/modifier.replace.php';
?>
<?php if (count($_smarty_tpl->tpl_vars['categoryProducts']->value)>0&&$_smarty_tpl->tpl_vars['categoryProducts']->value!==false) {?>
<div class="page-product-box blockproductscategory products_block block">
	<h4 class="title_block productscategory_h3"><?php echo smartyTranslate(array('s'=>'Related Products','mod'=>'productscategory'),$_smarty_tpl);?>
</h4>
	<div id="productscategory_list" class="clearfix product_list grid">
		<?php $_smarty_tpl->tpl_vars['tabname'] = new Smarty_variable('blockproductscategory', null, 0);?>
		<?php $_smarty_tpl->tpl_vars['itemsperpage'] = new Smarty_variable('4', null, 0);?>
		<?php $_smarty_tpl->tpl_vars['columnspage'] = new Smarty_variable('4', null, 0);?>
		<?php $_smarty_tpl->tpl_vars['products'] = new Smarty_variable($_smarty_tpl->tpl_vars['categoryProducts']->value, null, 0);?>
		<div class="block_content">
		<div class=" carousel slide" id="<?php echo $_smarty_tpl->tpl_vars['tabname']->value;?>
">
			<?php if (count($_smarty_tpl->tpl_vars['products']->value)>$_smarty_tpl->tpl_vars['itemsperpage']->value) {?>	
			<a class="carousel-control left" href="#<?php echo $_smarty_tpl->tpl_vars['tabname']->value;?>
"   data-slide="prev">&lsaquo;</a>
			<a class="carousel-control right" href="#<?php echo $_smarty_tpl->tpl_vars['tabname']->value;?>
"  data-slide="next">&rsaquo;</a>
			<?php }?>
			<div class="carousel-inner">
			<?php $_smarty_tpl->tpl_vars['mproducts'] = new Smarty_variable(array_chunk($_smarty_tpl->tpl_vars['products']->value,$_smarty_tpl->tpl_vars['itemsperpage']->value), null, 0);?>
			<?php  $_smarty_tpl->tpl_vars['products'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['products']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['mproducts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['products']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['products']->key => $_smarty_tpl->tpl_vars['products']->value) {
$_smarty_tpl->tpl_vars['products']->_loop = true;
 $_smarty_tpl->tpl_vars['products']->index++;
 $_smarty_tpl->tpl_vars['products']->first = $_smarty_tpl->tpl_vars['products']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['mypLoop']['first'] = $_smarty_tpl->tpl_vars['products']->first;
?>
				<div class="item <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['mypLoop']['first']) {?>active<?php }?>">
					<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['product']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['product']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
 $_smarty_tpl->tpl_vars['product']->iteration++;
 $_smarty_tpl->tpl_vars['product']->last = $_smarty_tpl->tpl_vars['product']->iteration === $_smarty_tpl->tpl_vars['product']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['last'] = $_smarty_tpl->tpl_vars['product']->last;
?>
						<?php if ($_smarty_tpl->tpl_vars['product']->iteration%$_smarty_tpl->tpl_vars['columnspage']->value==1&&$_smarty_tpl->tpl_vars['columnspage']->value>1) {?>
						  <div class="row clearfix">
						<?php }?>
							<div class="col-sm-<?php echo smarty_modifier_replace((12/$_smarty_tpl->tpl_vars['columnspage']->value),".","-");?>
 col-xs-12 product_block ajax_block_product<?php if (isset($_smarty_tpl->tpl_vars['productClassWidget']->value)) {?> <?php echo $_smarty_tpl->tpl_vars['productClassWidget']->value;?>
<?php }?>">
								<?php if (isset($_smarty_tpl->tpl_vars['productProfileDefault']->value)&&$_smarty_tpl->tpl_vars['productProfileDefault']->value) {?>
                <?php $_smarty_tpl->_capture_stack[0][] = array('productPath', null, null); ob_start(); ?><?php echo $_smarty_tpl->tpl_vars['tpl_dir']->value;?>
./profiles/<?php echo $_smarty_tpl->tpl_vars['productProfileDefault']->value;?>
.tpl<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
                <?php echo $_smarty_tpl->getSubTemplate (((string)Smarty::$_smarty_vars['capture']['productPath']), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array('callFromModule'=>isset($_smarty_tpl->tpl_vars['class']->value)), 0);?>

            <?php } else { ?>
                <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./sub/product-item/product-item.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array('callFromModule'=>isset($_smarty_tpl->tpl_vars['class']->value)), 0);?>

            <?php }?>
							</div>
						<?php if (($_smarty_tpl->tpl_vars['product']->iteration%$_smarty_tpl->tpl_vars['columnspage']->value==0||$_smarty_tpl->getVariable('smarty')->value['foreach']['products']['last'])&&$_smarty_tpl->tpl_vars['columnspage']->value>1) {?>
							</div>
						<?php }?>
					<?php } ?>
				</div>
			<?php } ?>
			</div>
		</div>
		</div>
	</div>
</div>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('addJsDefL', array('name'=>'min_item')); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'min_item'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<?php echo smartyTranslate(array('s'=>'Please select at least one product','js'=>1),$_smarty_tpl);?>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'min_item'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php $_smarty_tpl->smarty->_tag_stack[] = array('addJsDefL', array('name'=>'max_item')); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'max_item'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<?php echo smartyTranslate(array('s'=>'You cannot add more than %d product(s) to the product comparison','sprintf'=>$_smarty_tpl->tpl_vars['comparator_max_item']->value,'js'=>1),$_smarty_tpl);?>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'max_item'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('comparator_max_item'=>$_smarty_tpl->tpl_vars['comparator_max_item']->value),$_smarty_tpl);?>

<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('comparedProductsIds'=>$_smarty_tpl->tpl_vars['compared_products']->value),$_smarty_tpl);?>

<?php }?>
<?php }} ?>
