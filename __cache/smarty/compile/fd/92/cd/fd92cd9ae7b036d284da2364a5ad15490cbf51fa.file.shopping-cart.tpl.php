<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 16:30:27
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/onepagecheckout/views/templates/front/shopping-cart.tpl" */ ?>
<?php /*%%SmartyHeaderCode:101066082162b5ca834759b3-97779859%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fd92cd9ae7b036d284da2364a5ad15490cbf51fa' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/onepagecheckout/views/templates/front/shopping-cart.tpl',
      1 => 1470858411,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '101066082162b5ca834759b3-97779859',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'opc_config' => 0,
    'productNumber' => 0,
    'PS_CATALOG_MODE' => 0,
    'base_dir_ssl' => 0,
    'currencySign' => 0,
    'currencyRate' => 0,
    'currencyFormat' => 0,
    'currencyBlank' => 0,
    'cart' => 0,
    'onlyCartSummary' => 0,
    'link' => 0,
    'use_taxes' => 0,
    'priceDisplay' => 0,
    'lastProductAdded' => 0,
    'products' => 0,
    'product' => 0,
    'addClass' => 0,
    'productId' => 0,
    'productAttributeId' => 0,
    'customizedDatas' => 0,
    'gift_products' => 0,
    'id_customization' => 0,
    'odd' => 0,
    'colspan2' => 0,
    'customization' => 0,
    'type' => 0,
    'CUSTOMIZE_FILE' => 0,
    'custom_data' => 0,
    'pic_dir' => 0,
    'picture' => 0,
    'CUSTOMIZE_TEXTFIELD' => 0,
    'textField' => 0,
    'cannotModify' => 0,
    'quantityDisplayed' => 0,
    'token_cart' => 0,
    'last_was_odd' => 0,
    'discounts' => 0,
    'discount' => 0,
    'opc' => 0,
    'colspan' => 0,
    'voucherAllowed' => 0,
    'errors_discount' => 0,
    'error' => 0,
    'discount_name' => 0,
    'displayVouchers' => 0,
    'voucher' => 0,
    'show_option_allow_separate_package' => 0,
    'display_tax_label' => 0,
    'total_products' => 0,
    'total_products_wt' => 0,
    'total_discounts' => 0,
    'total_discounts_tax_exc' => 0,
    'total_discounts_negative' => 0,
    'total_wrapping' => 0,
    'total_wrapping_tax_exc' => 0,
    'total_shipping_tax_exc' => 0,
    'virtualCart' => 0,
    'total_shipping' => 0,
    'total_price_without_tax' => 0,
    'total_tax' => 0,
    'total_price' => 0,
    'HOOK_SHOPPING_CART' => 0,
    'order_process_type' => 0,
    'back' => 0,
    'HOOK_SHOPPING_CART_EXTRA' => 0,
    'guestInformations' => 0,
    'def_state' => 0,
    'def_state_invoice' => 0,
    'countries' => 0,
    'country' => 0,
    'state' => 0,
    'isVirtualCart' => 0,
    'v' => 0,
    'def_country' => 0,
    'sl_country' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b5ca835fbe39_32372325',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b5ca835fbe39_32372325')) {function content_62b5ca835fbe39_32372325($_smarty_tpl) {?>

<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><?php echo smartyTranslate(array('s'=>'Your shopping cart','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>


<?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['compact_form'])||!$_smarty_tpl->tpl_vars['opc_config']->value['compact_form']) {?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./breadcrumb.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<h1 id="cart_title"><?php echo smartyTranslate(array('s'=>'Shopping cart summary','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</h1>
<?php }?>


<?php $_smarty_tpl->tpl_vars['current_step'] = new Smarty_variable('summary', null, 0);?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>



<?php if (!$_smarty_tpl->tpl_vars['productNumber']->value) {?>
<p class="warning"><?php echo smartyTranslate(array('s'=>'Your shopping cart is empty.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</p>
    <?php } elseif ($_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
<p class="warning"><?php echo smartyTranslate(array('s'=>'This store has not accepted your new order.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</p>
    <?php } else { ?>
<script type="text/javascript">
    // <![CDATA[
    var baseDir = '<?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
';
    var currencySign = '<?php echo html_entity_decode($_smarty_tpl->tpl_vars['currencySign']->value,2,"UTF-8");?>
';
    var currencyRate = '<?php echo floatval($_smarty_tpl->tpl_vars['currencyRate']->value);?>
';
    var currencyFormat = '<?php echo intval($_smarty_tpl->tpl_vars['currencyFormat']->value);?>
';
    var currencyBlank = '<?php echo intval($_smarty_tpl->tpl_vars['currencyBlank']->value);?>
';
    var txtProduct = "<?php echo smartyTranslate(array('s'=>'product','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var txtProducts = "<?php echo smartyTranslate(array('s'=>'products','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var txtFreePrice = "<?php echo smartyTranslate(array('s'=>'Free!','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var deliveryAddress = <?php echo intval($_smarty_tpl->tpl_vars['cart']->value->id_address_delivery);?>
;
	if (typeof countriesNeedIDNumber == "undefined")
      var countriesNeedIDNumber = new Array();
    if (typeof countriesNeedZipCode == "undefined")
	  var countriesNeedZipCode = new Array();



        <?php if (isset($_smarty_tpl->tpl_vars['onlyCartSummary']->value)) {?>
        var orderOpcUrl = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink("order-opc",true), ENT_QUOTES, 'UTF-8', true);?>
';
        var addressUrl = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink("address.php",true), ENT_QUOTES, 'UTF-8', true);?>
';
        var taxEnabled = <?php echo intval($_smarty_tpl->tpl_vars['use_taxes']->value);?>
;
        var displayPrice = <?php echo intval($_smarty_tpl->tpl_vars['priceDisplay']->value);?>
;
        var txtWithTax = "<?php echo smartyTranslate(array('s'=>'(tax incl.)','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
        var txtWithoutTax = "<?php echo smartyTranslate(array('s'=>'(tax excl.)','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
        var opc_hide_carrier = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['hide_carrier']);?>
';
        var onlyCartSummary = '1';
            <?php } else { ?>
        var onlyCartSummary = '0';
        <?php }?>

    // ]]>
</script>
    <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['remove_ref'])||!$_smarty_tpl->tpl_vars['opc_config']->value['remove_ref']) {?>
        <?php $_smarty_tpl->tpl_vars["colspan"] = new Smarty_variable("5", null, 0);?>
		<?php $_smarty_tpl->tpl_vars["colspan2"] = new Smarty_variable("3", null, 0);?>
        <?php } else { ?>
        
        <style type="text/css">
            #cart_summary .cart_ref {
                display: none;
            }
        </style>
        
        <?php $_smarty_tpl->tpl_vars["colspan"] = new Smarty_variable("4", null, 0);?>
		<?php $_smarty_tpl->tpl_vars["colspan2"] = new Smarty_variable("2", null, 0);?>
    <?php }?>

<p style="display:none" id="emptyCartWarning"
   class="warning"><?php echo smartyTranslate(array('s'=>'Your shopping cart is empty.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</p>
    <?php if (isset($_smarty_tpl->tpl_vars['lastProductAdded']->value)&&$_smarty_tpl->tpl_vars['lastProductAdded']->value) {?>
        <?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['product']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['product']->iteration=0;
 $_smarty_tpl->tpl_vars['product']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
 $_smarty_tpl->tpl_vars['product']->iteration++;
 $_smarty_tpl->tpl_vars['product']->index++;
 $_smarty_tpl->tpl_vars['product']->first = $_smarty_tpl->tpl_vars['product']->index === 0;
 $_smarty_tpl->tpl_vars['product']->last = $_smarty_tpl->tpl_vars['product']->iteration === $_smarty_tpl->tpl_vars['product']->total;
?>
            <?php if ($_smarty_tpl->tpl_vars['product']->value['id_product']==$_smarty_tpl->tpl_vars['lastProductAdded']->value['id_product']&&(!$_smarty_tpl->tpl_vars['product']->value['id_product_attribute']||($_smarty_tpl->tpl_vars['product']->value['id_product_attribute']==$_smarty_tpl->tpl_vars['lastProductAdded']->value['id_product_attribute']))) {?>
            <div class="cart_last_product">
                <div class="cart_last_product_header">
                    <div class="left"><?php echo smartyTranslate(array('s'=>'Last added product','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</div>
                </div>
                <a class="cart_last_product_img"
                   href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getProductLink($_smarty_tpl->tpl_vars['product']->value['id_product'],$_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['category']), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"><img
                        src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['id_image'],'small_default'), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"
                        alt="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"/></a>

                <div class="cart_last_product_content">
                    <h5>
                        <a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getProductLink($_smarty_tpl->tpl_vars['product']->value['id_product'],$_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['category']), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</a>
                    </h5>
                    <?php if (isset($_smarty_tpl->tpl_vars['product']->value['attributes'])&&$_smarty_tpl->tpl_vars['product']->value['attributes']) {?><a
                            href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getProductLink($_smarty_tpl->tpl_vars['product']->value['id_product'],$_smarty_tpl->tpl_vars['product']->value['link_rewrite'],$_smarty_tpl->tpl_vars['product']->value['category']), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['attributes'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</a><?php }?>
                </div>
                <br class="clear"/>
            </div>
            <?php }?>
        <?php } ?>
    <?php }?>
    <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['compact_form'])||!$_smarty_tpl->tpl_vars['opc_config']->value['compact_form']) {?>
    <p><?php echo smartyTranslate(array('s'=>'Your shopping cart contains','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <span
            id="summary_products_quantity"><?php echo $_smarty_tpl->tpl_vars['productNumber']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['productNumber']->value==1) {?><?php echo smartyTranslate(array('s'=>'product','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'products','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php }?></span>
    </p>
    <?php }?>
<div id="order-detail-content" class="table_block<?php if (isset($_smarty_tpl->tpl_vars['addClass']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['addClass']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>">
<table id="cart_summary" class="std">
<thead>
<tr>
    <th class="cart_product first_item"><?php echo smartyTranslate(array('s'=>'Product','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</th>
    <th class="cart_description item"><?php echo smartyTranslate(array('s'=>'Description','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</th>
    <th class="cart_ref item"><?php echo smartyTranslate(array('s'=>'Ref.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</th>
    <th class="cart_unit item"><?php echo smartyTranslate(array('s'=>'Unit price','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</th>
    <th class="cart_quantity item"><?php echo smartyTranslate(array('s'=>'Qty','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</th>
    <th class="cart_total last_item"><?php echo smartyTranslate(array('s'=>'Total','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</th>
    
</tr>
</thead>
<tbody>
    <?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['product']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['product']->iteration=0;
 $_smarty_tpl->tpl_vars['product']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
 $_smarty_tpl->tpl_vars['product']->iteration++;
 $_smarty_tpl->tpl_vars['product']->index++;
 $_smarty_tpl->tpl_vars['product']->first = $_smarty_tpl->tpl_vars['product']->index === 0;
 $_smarty_tpl->tpl_vars['product']->last = $_smarty_tpl->tpl_vars['product']->iteration === $_smarty_tpl->tpl_vars['product']->total;
?>
        <?php $_smarty_tpl->tpl_vars['productId'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['id_product'], null, 0);?>
        <?php $_smarty_tpl->tpl_vars['productAttributeId'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['id_product_attribute'], null, 0);?>
        <?php $_smarty_tpl->tpl_vars['quantityDisplayed'] = new Smarty_variable(0, null, 0);?>
        <?php $_smarty_tpl->tpl_vars['odd'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->iteration%2, null, 0);?>
        <?php $_smarty_tpl->tpl_vars['ignoreProductLast'] = new Smarty_variable(isset($_smarty_tpl->tpl_vars['customizedDatas']->value[$_smarty_tpl->tpl_vars['productId']->value][$_smarty_tpl->tpl_vars['productAttributeId']->value])||count($_smarty_tpl->tpl_vars['gift_products']->value), null, 0);?>
    
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['opc_templates_path']->value)."/shopping-cart-product-line.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    
        <?php if (isset($_smarty_tpl->tpl_vars['customizedDatas']->value[$_smarty_tpl->tpl_vars['productId']->value][$_smarty_tpl->tpl_vars['productAttributeId']->value])) {?>
            <?php  $_smarty_tpl->tpl_vars['customization'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['customization']->_loop = false;
 $_smarty_tpl->tpl_vars['id_customization'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['customizedDatas']->value[$_smarty_tpl->tpl_vars['productId']->value][$_smarty_tpl->tpl_vars['productAttributeId']->value][$_smarty_tpl->tpl_vars['product']->value['id_address_delivery']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['customization']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['customization']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['customization']->key => $_smarty_tpl->tpl_vars['customization']->value) {
$_smarty_tpl->tpl_vars['customization']->_loop = true;
 $_smarty_tpl->tpl_vars['id_customization']->value = $_smarty_tpl->tpl_vars['customization']->key;
 $_smarty_tpl->tpl_vars['customization']->iteration++;
 $_smarty_tpl->tpl_vars['customization']->last = $_smarty_tpl->tpl_vars['customization']->iteration === $_smarty_tpl->tpl_vars['customization']->total;
?>
            <tr id="product_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
_<?php echo $_smarty_tpl->tpl_vars['id_customization']->value;?>
_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_address_delivery']);?>
"
                class="product_customization_for_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_address_delivery']);?>
 <?php if ($_smarty_tpl->tpl_vars['odd']->value) {?>odd<?php } else { ?>even<?php }?> customization alternate_item <?php if ($_smarty_tpl->tpl_vars['product']->last&&$_smarty_tpl->tpl_vars['customization']->last&&!count($_smarty_tpl->tpl_vars['gift_products']->value)) {?>last_item<?php }?>">
                <td></td>
                <td colspan="<?php echo intval($_smarty_tpl->tpl_vars['colspan2']->value);?>
">
                    <?php  $_smarty_tpl->tpl_vars['custom_data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['custom_data']->_loop = false;
 $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['customization']->value['datas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['custom_data']->key => $_smarty_tpl->tpl_vars['custom_data']->value) {
$_smarty_tpl->tpl_vars['custom_data']->_loop = true;
 $_smarty_tpl->tpl_vars['type']->value = $_smarty_tpl->tpl_vars['custom_data']->key;
?>
                        <?php if ($_smarty_tpl->tpl_vars['type']->value==$_smarty_tpl->tpl_vars['CUSTOMIZE_FILE']->value) {?>
                            <div class="customizationUploaded">
                                <ul class="customizationUploaded">
                                    <?php  $_smarty_tpl->tpl_vars['picture'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['picture']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['custom_data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['picture']->key => $_smarty_tpl->tpl_vars['picture']->value) {
$_smarty_tpl->tpl_vars['picture']->_loop = true;
?>
                                        <li><img src="<?php echo $_smarty_tpl->tpl_vars['pic_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['picture']->value['value'];?>
_small" alt=""
                                                 class="customizationUploaded"/></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php } elseif ($_smarty_tpl->tpl_vars['type']->value==$_smarty_tpl->tpl_vars['CUSTOMIZE_TEXTFIELD']->value) {?>
                            <ul class="typedText">
                                <?php  $_smarty_tpl->tpl_vars['textField'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['textField']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['custom_data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['textField']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['textField']->key => $_smarty_tpl->tpl_vars['textField']->value) {
$_smarty_tpl->tpl_vars['textField']->_loop = true;
 $_smarty_tpl->tpl_vars['textField']->index++;
?>
                                    <li>
                                        <?php if ($_smarty_tpl->tpl_vars['textField']->value['name']) {?>
                                            <?php echo $_smarty_tpl->tpl_vars['textField']->value['name'];?>

                                            <?php } else { ?>
                                            <?php echo smartyTranslate(array('s'=>'Text #','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php echo $_smarty_tpl->tpl_vars['textField']->index+1;?>

                                        <?php }?>
												<?php echo smartyTranslate(array('s'=>':','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['textField']->value['value'];?>

                                    </li>
                                <?php } ?>

                            </ul>
                        <?php }?>

                    <?php } ?>
                </td>
                <td class="cart_quantity" colspan="1">
                    <?php if (isset($_smarty_tpl->tpl_vars['cannotModify']->value)&&$_smarty_tpl->tpl_vars['cannotModify']->value==1) {?>
                        <span style="float:left"><?php if ($_smarty_tpl->tpl_vars['quantityDisplayed']->value==0&&isset($_smarty_tpl->tpl_vars['customizedDatas']->value[$_smarty_tpl->tpl_vars['productId']->value][$_smarty_tpl->tpl_vars['productAttributeId']->value])) {?><?php echo count($_smarty_tpl->tpl_vars['customizedDatas']->value[$_smarty_tpl->tpl_vars['productId']->value][$_smarty_tpl->tpl_vars['productAttributeId']->value]);?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['product']->value['cart_quantity']-$_smarty_tpl->tpl_vars['quantityDisplayed']->value;?>
<?php }?></span>
                        <?php } else { ?>
                        <div id="cart_quantity_button" class="cart_quantity_button" style="float:left">
                            <a rel="nofollow" class="cart_quantity_up"
                               id="cart_quantity_up_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
_<?php echo $_smarty_tpl->tpl_vars['id_customization']->value;?>
_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_address_delivery']);?>
"
                               href="<?php ob_start();?><?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product_attribute']);?>
<?php $_tmp2=ob_get_clean();?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('cart',true,null,"add&amp;id_product=".$_tmp1."&amp;ipa=".$_tmp2."&amp;id_address_delivery=".((string)$_smarty_tpl->tpl_vars['product']->value['id_address_delivery'])."&amp;id_customization=".((string)$_smarty_tpl->tpl_vars['id_customization']->value)."&amp;token=".((string)$_smarty_tpl->tpl_vars['token_cart']->value)), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"
                               title="<?php echo smartyTranslate(array('s'=>'Add','mod'=>'onepagecheckout'),$_smarty_tpl);?>
"></a>
                             <input size="2" type="text" value="<?php echo $_smarty_tpl->tpl_vars['customization']->value['quantity'];?>
" class="cart_quantity_input"
                               name="quantity_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
_<?php echo $_smarty_tpl->tpl_vars['id_customization']->value;?>
_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_address_delivery']);?>
"/>                           
                            <?php if ($_smarty_tpl->tpl_vars['product']->value['minimal_quantity']<($_smarty_tpl->tpl_vars['customization']->value['quantity']-$_smarty_tpl->tpl_vars['quantityDisplayed']->value)||$_smarty_tpl->tpl_vars['product']->value['minimal_quantity']<=1) {?>
                                <a rel="nofollow" class="cart_quantity_down"
                                   id="cart_quantity_down_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
_<?php echo $_smarty_tpl->tpl_vars['id_customization']->value;?>
_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_address_delivery']);?>
"
                                   href="<?php ob_start();?><?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product_attribute']);?>
<?php $_tmp4=ob_get_clean();?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('cart',true,null,"add&amp;id_product=".$_tmp3."&amp;ipa=".$_tmp4."&amp;id_address_delivery=".((string)$_smarty_tpl->tpl_vars['product']->value['id_address_delivery'])."&amp;id_customization=".((string)$_smarty_tpl->tpl_vars['id_customization']->value)."&amp;op=down&amp;token=".((string)$_smarty_tpl->tpl_vars['token_cart']->value)), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"
                                   title="<?php echo smartyTranslate(array('s'=>'Subtract','mod'=>'onepagecheckout'),$_smarty_tpl);?>
">
                                </a>
                                <?php } else { ?>
                                <a class="cart_quantity_down" style="opacity: 0.3;"
                                   id="cart_quantity_down_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
_<?php echo $_smarty_tpl->tpl_vars['id_customization']->value;?>
"
                                   href="#" title="<?php echo smartyTranslate(array('s'=>'Subtract','mod'=>'onepagecheckout'),$_smarty_tpl);?>
">
                                </a>
                            <?php }?>
                        </div>
                        <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['customization']->value['quantity'];?>
"
                               name="quantity_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
_<?php echo $_smarty_tpl->tpl_vars['id_customization']->value;?>
_hidden"/>
                        
                    <?php }?>
                </td>
                <td class="cart_delete">
                    <?php if (isset($_smarty_tpl->tpl_vars['cannotModify']->value)&&$_smarty_tpl->tpl_vars['cannotModify']->value==1) {?>
                        <?php } else { ?>
                        <div>
                            <a rel="nofollow" class="cart_quantity_delete"
                               id="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product_attribute'];?>
_<?php echo $_smarty_tpl->tpl_vars['id_customization']->value;?>
_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_address_delivery']);?>
"
                               href="<?php ob_start();?><?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
<?php $_tmp5=ob_get_clean();?><?php ob_start();?><?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product_attribute']);?>
<?php $_tmp6=ob_get_clean();?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('cart',true,null,"delete&amp;id_product=".$_tmp5."&amp;ipa=".$_tmp6."&amp;id_customization=".((string)$_smarty_tpl->tpl_vars['id_customization']->value)."&amp;id_address_delivery=".((string)$_smarty_tpl->tpl_vars['product']->value['id_address_delivery'])."&amp;token=".((string)$_smarty_tpl->tpl_vars['token_cart']->value)), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">&nbsp;</a>
                        </div>
                    <?php }?>
                </td>
            </tr>
                <?php $_smarty_tpl->tpl_vars['quantityDisplayed'] = new Smarty_variable($_smarty_tpl->tpl_vars['quantityDisplayed']->value+$_smarty_tpl->tpl_vars['customization']->value['quantity'], null, 0);?>
            <?php } ?>
        
            <?php if ($_smarty_tpl->tpl_vars['product']->value['quantity']-$_smarty_tpl->tpl_vars['quantityDisplayed']->value>0) {?><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['opc_templates_path']->value)."/shopping-cart-product-line.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('productLast'=>$_smarty_tpl->tpl_vars['product']->last,'productFirst'=>$_smarty_tpl->tpl_vars['product']->first), 0);?>
<?php }?>
        <?php }?>
    <?php } ?>
    <?php $_smarty_tpl->tpl_vars['last_was_odd'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->iteration%2, null, 0);?>
    <?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['gift_products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['product']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['product']->iteration=0;
 $_smarty_tpl->tpl_vars['product']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
 $_smarty_tpl->tpl_vars['product']->iteration++;
 $_smarty_tpl->tpl_vars['product']->index++;
 $_smarty_tpl->tpl_vars['product']->first = $_smarty_tpl->tpl_vars['product']->index === 0;
 $_smarty_tpl->tpl_vars['product']->last = $_smarty_tpl->tpl_vars['product']->iteration === $_smarty_tpl->tpl_vars['product']->total;
?>
        <?php $_smarty_tpl->tpl_vars['productId'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['id_product'], null, 0);?>
        <?php $_smarty_tpl->tpl_vars['productAttributeId'] = new Smarty_variable($_smarty_tpl->tpl_vars['product']->value['id_product_attribute'], null, 0);?>
        <?php $_smarty_tpl->tpl_vars['quantityDisplayed'] = new Smarty_variable(0, null, 0);?>
        <?php $_smarty_tpl->tpl_vars['odd'] = new Smarty_variable(($_smarty_tpl->tpl_vars['product']->iteration+$_smarty_tpl->tpl_vars['last_was_odd']->value)%2, null, 0);?>
        <?php $_smarty_tpl->tpl_vars['ignoreProductLast'] = new Smarty_variable(isset($_smarty_tpl->tpl_vars['customizedDatas']->value[$_smarty_tpl->tpl_vars['productId']->value][$_smarty_tpl->tpl_vars['productAttributeId']->value]), null, 0);?>
        <?php $_smarty_tpl->tpl_vars['cannotModify'] = new Smarty_variable(1, null, 0);?>
    
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['opc_templates_path']->value)."/shopping-cart-product-line.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('productLast'=>$_smarty_tpl->tpl_vars['product']->last,'productFirst'=>$_smarty_tpl->tpl_vars['product']->first), 0);?>

    <?php } ?>
</tbody>
    <?php if (sizeof($_smarty_tpl->tpl_vars['discounts']->value)) {?>
    <tbody>
        <?php  $_smarty_tpl->tpl_vars['discount'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['discount']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['discounts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['discount']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['discount']->iteration=0;
 $_smarty_tpl->tpl_vars['discount']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['discount']->key => $_smarty_tpl->tpl_vars['discount']->value) {
$_smarty_tpl->tpl_vars['discount']->_loop = true;
 $_smarty_tpl->tpl_vars['discount']->iteration++;
 $_smarty_tpl->tpl_vars['discount']->index++;
 $_smarty_tpl->tpl_vars['discount']->first = $_smarty_tpl->tpl_vars['discount']->index === 0;
 $_smarty_tpl->tpl_vars['discount']->last = $_smarty_tpl->tpl_vars['discount']->iteration === $_smarty_tpl->tpl_vars['discount']->total;
?>
        <tr class="cart_discount <?php if ($_smarty_tpl->tpl_vars['discount']->last) {?>last_item<?php } elseif ($_smarty_tpl->tpl_vars['discount']->first) {?>first_item<?php } else { ?>item<?php }?>"
            id="cart_discount_<?php echo $_smarty_tpl->tpl_vars['discount']->value['id_discount'];?>
">
            <td class="cart_discount_name" colspan="<?php echo intval($_smarty_tpl->tpl_vars['colspan2']->value);?>
"><?php echo $_smarty_tpl->tpl_vars['discount']->value['name'];?>
</td>
            <td class="cart_discount_price"><span class="price-discount">
                <?php if (!$_smarty_tpl->tpl_vars['priceDisplay']->value) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['discount']->value['value_real']*-1),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['discount']->value['value_tax_exc']*-1),$_smarty_tpl);?>
<?php }?>
            </span></td>
            <td class="cart_discount_delete">1</td>
            <td class="cart_discount_price">
                <?php if (strlen($_smarty_tpl->tpl_vars['discount']->value['code'])) {?><a
                    href="<?php if ($_smarty_tpl->tpl_vars['opc']->value) {?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('order-opc',true), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php } else { ?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('order',true), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>?deleteDiscount=<?php echo $_smarty_tpl->tpl_vars['discount']->value['id_discount'];?>
"
                    class="cart_quantity_delete_discount" title="<?php echo smartyTranslate(array('s'=>'Delete','mod'=>'onepagecheckout'),$_smarty_tpl);?>
"></a><?php }?><br />
                <span class="price-discount price"><?php if (!$_smarty_tpl->tpl_vars['priceDisplay']->value) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['discount']->value['value_real']*-1),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['discount']->value['value_tax_exc']*-1),$_smarty_tpl);?>
<?php }?></span>
            </td>
        </tr>
        <?php } ?>
    </tbody>
    <?php }?>
<div id="tfoot_static_underlay" class="sticky_underlay"></div>
<tfoot id="tfoot_static">
<tr class="cart_voucher_block">
    <td colspan="<?php echo $_smarty_tpl->tpl_vars['colspan']->value+1;?>
" id="cart_voucher" class="cart_voucher">
        <?php if ($_smarty_tpl->tpl_vars['voucherAllowed']->value) {?>
            <?php if (isset($_smarty_tpl->tpl_vars['errors_discount']->value)&&$_smarty_tpl->tpl_vars['errors_discount']->value) {?>
                <ul class="error">
                    <?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['error']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['errors_discount']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value) {
$_smarty_tpl->tpl_vars['error']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['error']->key;
?>
                        <li><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['error']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</li>
                    <?php } ?>
                </ul>
            <?php }?>
            <div id="opc_voucher_errors" class="perm-error" style="display: none"></div>
            <form action="<?php if ($_smarty_tpl->tpl_vars['opc']->value) {?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('order-opc.php',true), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php } else { ?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('order.php',true), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>"
                  method="post" id="voucher">
                <fieldset>
                    <h4><label for="discount_name"><?php echo smartyTranslate(array('s'=>'Vouchers','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</label></h4>

                    <input type="text" class="discount_name" id="discount_name" name="discount_name"
                           value="<?php if (isset($_smarty_tpl->tpl_vars['discount_name']->value)&&$_smarty_tpl->tpl_vars['discount_name']->value) {?><?php echo $_smarty_tpl->tpl_vars['discount_name']->value;?>
<?php }?>"/>

                    <input type="hidden" name="submitDiscount"/><input type="submit"
                                                                       name="submitAddDiscount"
                                                                       value="<?php echo smartyTranslate(array('s'=>'OK','mod'=>'onepagecheckout'),$_smarty_tpl);?>
"
                                                                       class="button"/>
                    <?php if ($_smarty_tpl->tpl_vars['displayVouchers']->value) {?>
                        <br />
                        <h4 class="title_offers"><?php echo smartyTranslate(array('s'=>'Take advantage of our offers:','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</h4>

                        <div id="display_cart_vouchers">
                            <?php  $_smarty_tpl->tpl_vars['voucher'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['voucher']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['displayVouchers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['voucher']->key => $_smarty_tpl->tpl_vars['voucher']->value) {
$_smarty_tpl->tpl_vars['voucher']->_loop = true;
?>
                                <?php if ($_smarty_tpl->tpl_vars['voucher']->value['code']!='') {?>
                                    <span onclick="$('#discount_name').val('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['voucher']->value['code'], ENT_QUOTES, 'UTF-8', true);?>
');return false;"
                                          class="voucher_name_opc"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['voucher']->value['code'], ENT_QUOTES, 'UTF-8', true);?>
</span> - <?php }?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['voucher']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
<br />
                            <?php } ?>
                        </div>
                    <?php }?>
                </fieldset>
            </form>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['show_option_allow_separate_package']->value) {?>
            <p style="margin-top: 10px">
                <input type="checkbox" name="allow_seperated_package" id="allow_seperated_package" <?php if ($_smarty_tpl->tpl_vars['cart']->value->allow_seperated_package) {?>checked="checked"<?php }?> autocomplete="off"/>
                <label for="allow_seperated_package"><?php echo smartyTranslate(array('s'=>'Send available products first','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</label>
            </p>
        <?php }?>
    </td>
</tr>
<?php if ($_smarty_tpl->tpl_vars['use_taxes']->value) {?>
    <?php if ($_smarty_tpl->tpl_vars['priceDisplay']->value) {?>
        <tr class="cart_total_products summary-line">
            <td colspan="<?php echo intval($_smarty_tpl->tpl_vars['colspan']->value);?>
"><?php if ($_smarty_tpl->tpl_vars['display_tax_label']->value) {?><?php echo smartyTranslate(array('s'=>'Total products (tax excl.):','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Total products:','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php }?></td>
            <td class="price" id="total_product"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total_products']->value),$_smarty_tpl);?>
</td>
        </tr>
    <?php } else { ?>
        <tr class="cart_total_products summary-line">
            <td colspan="<?php echo intval($_smarty_tpl->tpl_vars['colspan']->value);?>
"><?php if ($_smarty_tpl->tpl_vars['display_tax_label']->value) {?><?php echo smartyTranslate(array('s'=>'Total products (tax incl.):','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Total products:','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php }?></td>
            <td class="price" id="total_product"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total_products_wt']->value),$_smarty_tpl);?>
</td>
        </tr>
    <?php }?>
<?php } else { ?>
    <tr class="cart_total_products summary-line">
        <td colspan="<?php echo intval($_smarty_tpl->tpl_vars['colspan']->value);?>
"><?php echo smartyTranslate(array('s'=>'Total products:','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</td>
        <td class="price" id="total_product"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total_products']->value),$_smarty_tpl);?>
</td>
    </tr>
<?php }?>
<tr class="cart_total_voucher summary-line" <?php if ($_smarty_tpl->tpl_vars['total_discounts']->value==0) {?>style="display:none"<?php }?>>
    <td colspan="<?php echo intval($_smarty_tpl->tpl_vars['colspan']->value);?>
">
        <?php if ($_smarty_tpl->tpl_vars['use_taxes']->value&&$_smarty_tpl->tpl_vars['display_tax_label']->value) {?>
            <?php echo smartyTranslate(array('s'=>'Total vouchers (tax excl.):','mod'=>'onepagecheckout'),$_smarty_tpl);?>

        <?php } else { ?>
            <?php echo smartyTranslate(array('s'=>'Total vouchers:','mod'=>'onepagecheckout'),$_smarty_tpl);?>

        <?php }?>
    </td>
    <td class="price-discount price" id="total_discount">
        <?php if ($_smarty_tpl->tpl_vars['use_taxes']->value&&!$_smarty_tpl->tpl_vars['priceDisplay']->value) {?>
            <?php $_smarty_tpl->tpl_vars['total_discounts_negative'] = new Smarty_variable($_smarty_tpl->tpl_vars['total_discounts']->value*-1, null, 0);?>
        <?php } else { ?>
            <?php $_smarty_tpl->tpl_vars['total_discounts_negative'] = new Smarty_variable($_smarty_tpl->tpl_vars['total_discounts_tax_exc']->value*-1, null, 0);?>
        <?php }?>
        <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total_discounts_negative']->value),$_smarty_tpl);?>

    </td>
</tr>
<tr class="cart_total_wrapping summary-line" <?php if ($_smarty_tpl->tpl_vars['total_wrapping']->value==0) {?>style="display: none;"<?php }?>>
    <td colspan="<?php echo intval($_smarty_tpl->tpl_vars['colspan']->value);?>
">
        <?php if ($_smarty_tpl->tpl_vars['use_taxes']->value) {?>
            <?php if ($_smarty_tpl->tpl_vars['display_tax_label']->value) {?><?php echo smartyTranslate(array('s'=>'Total gift-wrapping (tax incl.):','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Total gift-wrapping:','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php }?>
        <?php } else { ?>
            <?php echo smartyTranslate(array('s'=>'Total gift-wrapping:','mod'=>'onepagecheckout'),$_smarty_tpl);?>

        <?php }?>
    </td>
    <td class="price-discount price" id="total_wrapping">
        <?php if ($_smarty_tpl->tpl_vars['use_taxes']->value) {?>
            <?php if ($_smarty_tpl->tpl_vars['priceDisplay']->value) {?>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total_wrapping_tax_exc']->value),$_smarty_tpl);?>

            <?php } else { ?>
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total_wrapping']->value),$_smarty_tpl);?>

            <?php }?>
        <?php } else { ?>
            <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total_wrapping_tax_exc']->value),$_smarty_tpl);?>

        <?php }?>
    </td>
</tr>
<?php if ($_smarty_tpl->tpl_vars['total_shipping_tax_exc']->value<=0&&!isset($_smarty_tpl->tpl_vars['virtualCart']->value)) {?>
    <tr class="cart_total_delivery summary-line">
        <td colspan="<?php echo intval($_smarty_tpl->tpl_vars['colspan']->value);?>
"><?php echo smartyTranslate(array('s'=>'Shipping:','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</td>
        <td class="price" id="total_shipping"><?php echo smartyTranslate(array('s'=>'Free Shipping!','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</td>
    </tr>
<?php } else { ?>
    <?php if ($_smarty_tpl->tpl_vars['use_taxes']->value) {?>
        <?php if ($_smarty_tpl->tpl_vars['priceDisplay']->value) {?>
            <tr class="cart_total_delivery summary-line" <?php if ($_smarty_tpl->tpl_vars['total_shipping_tax_exc']->value<=0) {?> style="display:none;"<?php }?>>
                <td colspan="<?php echo intval($_smarty_tpl->tpl_vars['colspan']->value);?>
"><?php if ($_smarty_tpl->tpl_vars['display_tax_label']->value) {?><?php echo smartyTranslate(array('s'=>'Total shipping (tax excl.):','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Total shipping:','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php }?></td>
                <td class="price" id="total_shipping"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total_shipping_tax_exc']->value),$_smarty_tpl);?>
</td>
            </tr>
        <?php } else { ?>
            <tr class="cart_total_delivery summary-line"<?php if ($_smarty_tpl->tpl_vars['total_shipping']->value<=0) {?> style="display:none;"<?php }?>>
                <td colspan="<?php echo intval($_smarty_tpl->tpl_vars['colspan']->value);?>
"><?php if ($_smarty_tpl->tpl_vars['display_tax_label']->value) {?><?php echo smartyTranslate(array('s'=>'Total shipping (tax incl.):','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Total shipping:','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php }?></td>
                <td class="price" id="total_shipping"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total_shipping']->value),$_smarty_tpl);?>
</td>
            </tr>
        <?php }?>
    <?php } else { ?>
        <tr class="cart_total_delivery summary-line"<?php if ($_smarty_tpl->tpl_vars['total_shipping_tax_exc']->value<=0) {?> style="display:none;"<?php }?>>
            <td colspan="<?php echo intval($_smarty_tpl->tpl_vars['colspan']->value);?>
"><?php echo smartyTranslate(array('s'=>'Total shipping:','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</td>
            <td class="price" id="total_shipping"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total_shipping_tax_exc']->value),$_smarty_tpl);?>
</td>
        </tr>
    <?php }?>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['use_taxes']->value) {?>
    <tr class="cart_tax_exc_price summary-line">
        <td colspan="<?php echo intval($_smarty_tpl->tpl_vars['colspan']->value);?>
"><?php echo smartyTranslate(array('s'=>'Total (tax excl.):','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</td>
        <td class="price" id="total_price_without_tax"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total_price_without_tax']->value),$_smarty_tpl);?>
</td>
    </tr>
    <tr class="cart_total_tax summary-line">
        <td colspan="<?php echo intval($_smarty_tpl->tpl_vars['colspan']->value);?>
"><?php echo smartyTranslate(array('s'=>'Total tax:','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</td>
        <td class="price" id="total_tax"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total_tax']->value),$_smarty_tpl);?>
</td>
    </tr>
<?php }?>




<tr class="cart_payment_fee summary-line" style="display: none;">
    <td colspan="<?php echo intval($_smarty_tpl->tpl_vars['colspan']->value);?>
"><?php echo smartyTranslate(array('s'=>'Payment fee','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</td>
            <td colspan="2" class="price" id="total_payment_fee"></td> 
</tr>

<tr class="cart_final_price with_fee summary-line" style="display: none;">
    <td colspan="<?php echo intval($_smarty_tpl->tpl_vars['colspan']->value);?>
"><?php echo smartyTranslate(array('s'=>'Total:','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</td>
        <td class="price total_price_container" id="total_price_container">
            <?php if ($_smarty_tpl->tpl_vars['use_taxes']->value) {?>
            <span id="total_price_with_fee"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total_price']->value),$_smarty_tpl);?>
</span>
            <?php } else { ?>
                <span id="total_price_with_fee"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total_price_without_tax']->value),$_smarty_tpl);?>
</span>                
            <?php }?>
        </td>
</tr>


<tr class="cart_final_price orig summary-line"> 
    <td colspan="<?php echo intval($_smarty_tpl->tpl_vars['colspan']->value);?>
"><?php echo smartyTranslate(array('s'=>'Total:','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</td>
        <td class="price total_price_container" id="total_price_container">
            <?php if ($_smarty_tpl->tpl_vars['use_taxes']->value) {?>
            <span id="total_price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total_price']->value),$_smarty_tpl);?>
</span>
            <?php } else { ?>
                <span id="total_price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total_price_without_tax']->value),$_smarty_tpl);?>
</span>
            <?php }?>
        </td>
</tr>
</tfoot>
</table>
</div>



<div id="HOOK_SHOPPING_CART"><?php echo $_smarty_tpl->tpl_vars['HOOK_SHOPPING_CART']->value;?>
</div>

    <?php if (!$_smarty_tpl->tpl_vars['opc_config']->value['two_column_opc']&&(!$_smarty_tpl->tpl_vars['opc_config']->value['cart_summary_bottom']||($_smarty_tpl->tpl_vars['order_process_type']->value==0&&(!$_GET['step']||$_GET['step']!='1')))) {?>
            <p class="cart_navigation">
        <b>
            <?php if (isset($_smarty_tpl->tpl_vars['onlyCartSummary']->value)) {?><a
                    href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('order.php',true), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
?step=1<?php if ($_smarty_tpl->tpl_vars['back']->value) {?>&amp;back=<?php echo $_smarty_tpl->tpl_vars['back']->value;?>
<?php }?>"
                    class="exclusive" title="<?php echo smartyTranslate(array('s'=>'Next','mod'=>'onepagecheckout'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Next','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 &raquo;</a><?php }?>
            <a href="<?php if ((isset($_SERVER['HTTP_REFERER'])&&strstr($_SERVER['HTTP_REFERER'],'{$opckt_script_name}'))||!isset($_SERVER['HTTP_REFERER'])) {?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('index.php'), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['secureReferrer'][0][0]->secureReferrer(mb_convert_encoding(htmlspecialchars($_SERVER['HTTP_REFERER'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'));?>
<?php }?>"
               title="<?php echo smartyTranslate(array('s'=>'Continue shopping','mod'=>'onepagecheckout'),$_smarty_tpl);?>
">
                &laquo; <?php echo smartyTranslate(array('s'=>'Continue shopping','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</a><?php if (!isset($_smarty_tpl->tpl_vars['onlyCartSummary']->value)) {?>
            &nbsp; <?php echo smartyTranslate(array('s'=>'or fill in the form below to finish your order.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php }?>
        </b>
    </p>
    <p class="clear"></p>
    <?php }?>
    <p class="cart_navigation_extra">
        <span id="HOOK_SHOPPING_CART_EXTRA"><?php echo $_smarty_tpl->tpl_vars['HOOK_SHOPPING_CART_EXTRA']->value;?>
</span>
    </p>


    <?php if (isset($_smarty_tpl->tpl_vars['onlyCartSummary']->value)) {?>
    <script type="text/javascript">
        // <![CDATA[
        var countries = new Array();
        idSelectedCountry = <?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['guestInformations']->value['id_state']) {?><?php echo intval($_smarty_tpl->tpl_vars['guestInformations']->value['id_state']);?>
<?php } else { ?><?php if (($_smarty_tpl->tpl_vars['def_state']->value>0)) {?><?php echo intval($_smarty_tpl->tpl_vars['def_state']->value);?>
<?php } else { ?>false<?php }?><?php }?>;
        idSelectedCountry_invoice = <?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['id_state_invoice'])) {?><?php echo intval($_smarty_tpl->tpl_vars['guestInformations']->value['id_state_invoice']);?>
<?php } else { ?><?php if (($_smarty_tpl->tpl_vars['def_state_invoice']->value>0)) {?><?php echo intval($_smarty_tpl->tpl_vars['def_state_invoice']->value);?>
<?php } else { ?>false<?php }?><?php }?>;
            <?php if (isset($_smarty_tpl->tpl_vars['countries']->value)) {?>
                <?php  $_smarty_tpl->tpl_vars['country'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['country']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['countries']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['country']->key => $_smarty_tpl->tpl_vars['country']->value) {
$_smarty_tpl->tpl_vars['country']->_loop = true;
?>
                    <?php if (isset($_smarty_tpl->tpl_vars['country']->value['states'])&&$_smarty_tpl->tpl_vars['country']->value['contains_states']) {?>
                    countries[<?php echo intval($_smarty_tpl->tpl_vars['country']->value['id_country']);?>
] = new Array();
                        <?php  $_smarty_tpl->tpl_vars['state'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['state']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['country']->value['states']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['state']->key => $_smarty_tpl->tpl_vars['state']->value) {
$_smarty_tpl->tpl_vars['state']->_loop = true;
?>
                        countries[<?php echo intval($_smarty_tpl->tpl_vars['country']->value['id_country']);?>
].push({'id':'<?php echo intval($_smarty_tpl->tpl_vars['state']->value['id_state']);?>
', 'name':'<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['state']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
'});
                        <?php } ?>
                    <?php }?>
                <?php } ?>
            <?php }?>
        //]]>
    </script>

        <?php if ($_smarty_tpl->tpl_vars['isVirtualCart']->value&&$_smarty_tpl->tpl_vars['opc_config']->value['virtual_no_delivery']) {?>
        <input type="hidden" name="id_country" id="id_country"
               value="<?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['online_country_id'])&&$_smarty_tpl->tpl_vars['opc_config']->value['online_country_id']>0) {?><?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['online_country_id']);?>
<?php } else { ?>8<?php }?>"/> 
            <?php } else { ?>
        <p class="required select"
           <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['country_delivery'])||!$_smarty_tpl->tpl_vars['opc_config']->value['country_delivery']) {?>style="display: none;"<?php }?>>
            <label for="id_country"><?php echo smartyTranslate(array('s'=>'Country','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</label>
            <select name="id_country" id="id_country">
                <option value="">-</option>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['countries']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id_country'];?>
" <?php if ((isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['guestInformations']->value['id_country']==$_smarty_tpl->tpl_vars['v']->value['id_country'])||($_smarty_tpl->tpl_vars['def_country']->value==$_smarty_tpl->tpl_vars['v']->value['id_country'])||(!isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&($_smarty_tpl->tpl_vars['def_country']->value==0)&&$_smarty_tpl->tpl_vars['sl_country']->value==$_smarty_tpl->tpl_vars['v']->value['id_country'])) {?>
                            selected="selected"<?php }?>><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</option>
                <?php } ?>
            </select>
        </p>

        <?php }?>

    <p class="required id_state select">
        <label for="id_state"><?php echo smartyTranslate(array('s'=>'State','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</label>
        <select name="id_state" id="id_state">
            <option value="">-</option>
        </select>
    </p>


    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['opc_templates_path']->value)."/order-carrier.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 
    <?php }?>



<?php }?>

<?php }} ?>
