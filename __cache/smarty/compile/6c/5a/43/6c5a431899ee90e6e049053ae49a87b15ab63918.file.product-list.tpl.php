<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:24
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/product-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:160740103162b578783deb60-77397336%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6c5a431899ee90e6e049053ae49a87b15ab63918' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/product-list.tpl',
      1 => 1470857963,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '160740103162b578783deb60-77397336',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'productClassWidget' => 0,
    'productProfileDefault' => 0,
    'products' => 0,
    'class' => 0,
    'LISTING_PRODUCT_COLUMN_MODULE' => 0,
    'LISTING_PRODUCT_MOBILE' => 0,
    'LISTING_PRODUCT_TABLET' => 0,
    'LISTING_PRODUCT_COLUMN' => 0,
    'nbLi' => 0,
    'nbItemsPerLine' => 0,
    'nbItemsPerLineTablet' => 0,
    'id' => 0,
    'LISTING_GRIG_MODE' => 0,
    'nbItemsPerLineMobile' => 0,
    'totModulo' => 0,
    'totModuloTablet' => 0,
    'totModuloMobile' => 0,
    'colValue' => 0,
    'tpl_dir' => 0,
    'comparator_max_item' => 0,
    'compared_products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b5787841aaf1_40186378',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b5787841aaf1_40186378')) {function content_62b5787841aaf1_40186378($_smarty_tpl) {?><?php if (!is_callable('smarty_function_math')) include '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/tools/smarty/plugins/function.math.php';
?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./layout/setting.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php if (!isset($_smarty_tpl->tpl_vars['productClassWidget']->value)) {?>
    <?php ob_start();?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"pagebuilderConfig",'configName'=>"productClass"),$_smarty_tpl);?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars["productClassWidget"] = new Smarty_variable($_tmp1, null, 0);?>
<?php }?>
<?php if (!isset($_smarty_tpl->tpl_vars['productProfileDefault']->value)) {?>
    <?php ob_start();?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>"pagebuilderConfig",'configName'=>"productKey"),$_smarty_tpl);?>
<?php $_tmp2=ob_get_clean();?><?php $_smarty_tpl->tpl_vars["productProfileDefault"] = new Smarty_variable($_tmp2, null, 0);?>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['products']->value)&&$_smarty_tpl->tpl_vars['products']->value) {?>
	
        <?php if (isset($_smarty_tpl->tpl_vars['class']->value)) {?>
            
            <?php $_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"] = new Smarty_variable("grid", null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars["LISTING_GRIG_MODE"] = clone $_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"]; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars["LISTING_GRIG_MODE"] = clone $_smarty_tpl->tpl_vars["LISTING_GRIG_MODE"];?>
            <?php $_smarty_tpl->tpl_vars['nbItemsPerLine'] = new Smarty_variable($_smarty_tpl->tpl_vars['LISTING_PRODUCT_COLUMN_MODULE']->value, null, 0);?>
            <?php if ($_smarty_tpl->tpl_vars['LISTING_PRODUCT_COLUMN_MODULE']->value=="5") {?>
                <?php $_smarty_tpl->tpl_vars["colValue"] = new Smarty_variable("col-xs-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_MOBILE']->value))." col-sm-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_TABLET']->value))." col-md-2-4 col-sp-12", null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars["colValue"] = clone $_smarty_tpl->tpl_vars["colValue"]; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars["colValue"] = clone $_smarty_tpl->tpl_vars["colValue"];?>
            <?php } else { ?>
                <?php $_smarty_tpl->tpl_vars["colValue"] = new Smarty_variable("col-sp-12 col-xs-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_MOBILE']->value))." col-sm-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_TABLET']->value))." col-md-".((string)(12/$_smarty_tpl->tpl_vars['LISTING_PRODUCT_COLUMN_MODULE']->value)), null, 3);
$_ptr = $_smarty_tpl->parent; while ($_ptr != null) {$_ptr->tpl_vars["colValue"] = clone $_smarty_tpl->tpl_vars["colValue"]; $_ptr = $_ptr->parent; }
Smarty::$global_tpl_vars["colValue"] = clone $_smarty_tpl->tpl_vars["colValue"];?>
            <?php }?>
        <?php } else { ?>
            <?php $_smarty_tpl->tpl_vars['nbItemsPerLine'] = new Smarty_variable($_smarty_tpl->tpl_vars['LISTING_PRODUCT_COLUMN']->value, null, 0);?>
	<?php }?>
        <?php $_smarty_tpl->tpl_vars['nbItemsPerLineTablet'] = new Smarty_variable($_smarty_tpl->tpl_vars['LISTING_PRODUCT_TABLET']->value, null, 0);?>
        <?php $_smarty_tpl->tpl_vars['nbItemsPerLineMobile'] = new Smarty_variable($_smarty_tpl->tpl_vars['LISTING_PRODUCT_MOBILE']->value, null, 0);?>
	
	<?php $_smarty_tpl->tpl_vars['nbLi'] = new Smarty_variable(count($_smarty_tpl->tpl_vars['products']->value), null, 0);?>
	<?php echo smarty_function_math(array('equation'=>"nbLi/nbItemsPerLine",'nbLi'=>$_smarty_tpl->tpl_vars['nbLi']->value,'nbItemsPerLine'=>$_smarty_tpl->tpl_vars['nbItemsPerLine']->value,'assign'=>'nbLines'),$_smarty_tpl);?>

	<?php echo smarty_function_math(array('equation'=>"nbLi/nbItemsPerLineTablet",'nbLi'=>$_smarty_tpl->tpl_vars['nbLi']->value,'nbItemsPerLineTablet'=>$_smarty_tpl->tpl_vars['nbItemsPerLineTablet']->value,'assign'=>'nbLinesTablet'),$_smarty_tpl);?>

	<!-- Products list -->
	<div <?php if (isset($_smarty_tpl->tpl_vars['id']->value)&&$_smarty_tpl->tpl_vars['id']->value) {?> id="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
"<?php }?> class="product_list <?php echo $_smarty_tpl->tpl_vars['LISTING_GRIG_MODE']->value;?>
 row <?php if (isset($_smarty_tpl->tpl_vars['class']->value)&&$_smarty_tpl->tpl_vars['class']->value) {?> <?php echo $_smarty_tpl->tpl_vars['class']->value;?>
<?php }?><?php if (isset($_smarty_tpl->tpl_vars['productClassWidget']->value)) {?> <?php echo $_smarty_tpl->tpl_vars['productClassWidget']->value;?>
<?php }?>">
	<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['product']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['total'] = $_smarty_tpl->tpl_vars['product']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['products']['iteration']++;
?>
		<?php echo smarty_function_math(array('equation'=>"(total%perLine)",'total'=>$_smarty_tpl->getVariable('smarty')->value['foreach']['products']['total'],'perLine'=>$_smarty_tpl->tpl_vars['nbItemsPerLine']->value,'assign'=>'totModulo'),$_smarty_tpl);?>

		<?php echo smarty_function_math(array('equation'=>"(total%perLineT)",'total'=>$_smarty_tpl->getVariable('smarty')->value['foreach']['products']['total'],'perLineT'=>$_smarty_tpl->tpl_vars['nbItemsPerLineTablet']->value,'assign'=>'totModuloTablet'),$_smarty_tpl);?>

		<?php echo smarty_function_math(array('equation'=>"(total%perLineT)",'total'=>$_smarty_tpl->getVariable('smarty')->value['foreach']['products']['total'],'perLineT'=>$_smarty_tpl->tpl_vars['nbItemsPerLineMobile']->value,'assign'=>'totModuloMobile'),$_smarty_tpl);?>

		<?php if ($_smarty_tpl->tpl_vars['totModulo']->value==0) {?><?php $_smarty_tpl->tpl_vars['totModulo'] = new Smarty_variable($_smarty_tpl->tpl_vars['nbItemsPerLine']->value, null, 0);?><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['totModuloTablet']->value==0) {?><?php $_smarty_tpl->tpl_vars['totModuloTablet'] = new Smarty_variable($_smarty_tpl->tpl_vars['nbItemsPerLineTablet']->value, null, 0);?><?php }?>
		<?php if ($_smarty_tpl->tpl_vars['totModuloMobile']->value==0) {?><?php $_smarty_tpl->tpl_vars['totModuloMobile'] = new Smarty_variable($_smarty_tpl->tpl_vars['nbItemsPerLineMobile']->value, null, 0);?><?php }?>	
		<div class="ajax_block_product col-sp-12 <?php echo $_smarty_tpl->tpl_vars['colValue']->value;?>
<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['iteration']%$_smarty_tpl->tpl_vars['nbItemsPerLine']->value==0) {?> last-in-line
		<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['iteration']%$_smarty_tpl->tpl_vars['nbItemsPerLine']->value==1) {?> first-in-line<?php }?>
		<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['iteration']>($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['total']-$_smarty_tpl->tpl_vars['totModulo']->value)) {?> last-line<?php }?>
		<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['iteration']%$_smarty_tpl->tpl_vars['nbItemsPerLineTablet']->value==0) {?> last-item-of-tablet-line
		<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['iteration']%$_smarty_tpl->tpl_vars['nbItemsPerLineTablet']->value==1) {?> first-item-of-tablet-line<?php }?>
		<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['iteration']%$_smarty_tpl->tpl_vars['nbItemsPerLineMobile']->value==0) {?> last-item-of-mobile-line
		<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['iteration']%$_smarty_tpl->tpl_vars['nbItemsPerLineMobile']->value==1) {?> first-item-of-mobile-line<?php }?>
		<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['iteration']>($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['total']-$_smarty_tpl->tpl_vars['totModuloMobile']->value)) {?> last-mobile-line<?php }?>">
			<?php if (isset($_smarty_tpl->tpl_vars['productProfileDefault']->value)&&$_smarty_tpl->tpl_vars['productProfileDefault']->value) {?>
                <?php $_smarty_tpl->_capture_stack[0][] = array('productPath', null, null); ob_start(); ?><?php echo $_smarty_tpl->tpl_vars['tpl_dir']->value;?>
./profiles/<?php echo $_smarty_tpl->tpl_vars['productProfileDefault']->value;?>
.tpl<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
                <?php echo $_smarty_tpl->getSubTemplate (((string)Smarty::$_smarty_vars['capture']['productPath']), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('callFromModule'=>isset($_smarty_tpl->tpl_vars['class']->value)), 0);?>

            <?php } else { ?>
                <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./sub/product-item/product-item.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('callFromModule'=>isset($_smarty_tpl->tpl_vars['class']->value)), 0);?>

            <?php }?>
		</div>

	<?php } ?>
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
