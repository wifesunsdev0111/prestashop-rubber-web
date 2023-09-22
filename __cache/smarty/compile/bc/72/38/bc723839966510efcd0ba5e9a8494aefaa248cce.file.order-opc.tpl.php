<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 16:30:27
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/onepagecheckout/views/templates/front/order-opc.tpl" */ ?>
<?php /*%%SmartyHeaderCode:22634680762b5ca83372533-81794521%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bc723839966510efcd0ba5e9a8494aefaa248cce' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/onepagecheckout/views/templates/front/order-opc.tpl',
      1 => 1470858411,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '22634680762b5ca83372533-81794521',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'PS_CATALOG_MODE' => 0,
    'base_dir_ssl' => 0,
    'img_dir' => 0,
    'link' => 0,
    'PS_GUEST_CHECKOUT_ENABLED' => 0,
    'currencySign' => 0,
    'currencyRate' => 0,
    'currencyFormat' => 0,
    'currencyBlank' => 0,
    'priceDisplay' => 0,
    'use_taxes' => 0,
    'conditions' => 0,
    'vat_management' => 0,
    'errorCarrier' => 0,
    'errorTOS' => 0,
    'checked' => 0,
    'onlyCartSummary' => 0,
    'isLogged' => 0,
    'isGuest' => 0,
    'isVirtualCart' => 0,
    'isPaymentStep' => 0,
    'opc_config' => 0,
    'productNumber' => 0,
    'info_block_content' => 0,
    'twoStepCheckout' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b5ca83424908_59962385',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b5ca83424908_59962385')) {function content_62b5ca83424908_59962385($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_regex_replace')) include '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/tools/smarty/plugins/modifier.regex_replace.php';
?>

<?php if ($_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
<h2 id="cart_title"><?php echo smartyTranslate(array('s'=>'Your shopping cart','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</h2>
<p class="warning"><?php echo smartyTranslate(array('s'=>'This store has not accepted your new order.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</p>
    <?php } else { ?>
<script type="text/javascript">
    // <![CDATA[
    var baseDir = '<?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
';
    var imgDir = '<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
';
    var authenticationUrl = '<?php echo addslashes($_smarty_tpl->tpl_vars['link']->value->getPageLink("authentication",true));?>
';
    
    var orderOpcUrl = '<?php echo addslashes($_smarty_tpl->tpl_vars['link']->value->getPageLink("order-opc",true));?>
';
    var historyUrl = '<?php echo addslashes($_smarty_tpl->tpl_vars['link']->value->getPageLink("history",true));?>
';
    var guestTrackingUrl = '<?php echo addslashes($_smarty_tpl->tpl_vars['link']->value->getPageLink("guest-tracking",true));?>
';
    var addressUrl = '<?php echo addslashes($_smarty_tpl->tpl_vars['link']->value->getPageLink("address",true,null,"back=order-opc.php"));?>
';
    var orderProcess = 'order-opc';
    var guestCheckoutEnabled = <?php echo intval($_smarty_tpl->tpl_vars['PS_GUEST_CHECKOUT_ENABLED']->value);?>
;
    var currencySign = '<?php echo html_entity_decode($_smarty_tpl->tpl_vars['currencySign']->value,2,"UTF-8");?>
';
    var currencyRate = '<?php echo floatval($_smarty_tpl->tpl_vars['currencyRate']->value);?>
';
    var currencyFormat = '<?php echo intval($_smarty_tpl->tpl_vars['currencyFormat']->value);?>
';
    var currencyBlank = '<?php echo intval($_smarty_tpl->tpl_vars['currencyBlank']->value);?>
';
    var displayPrice = <?php echo intval($_smarty_tpl->tpl_vars['priceDisplay']->value);?>
;
    var taxEnabled = <?php echo intval($_smarty_tpl->tpl_vars['use_taxes']->value);?>
;
    var conditionEnabled = <?php echo intval($_smarty_tpl->tpl_vars['conditions']->value);?>
;
    var countries = new Array();
    var countriesNeedIDNumber = new Array();
    var countriesNeedZipCode = new Array();
    var vat_management = <?php echo intval($_smarty_tpl->tpl_vars['vat_management']->value);?>
;


    var txtWithTax = "<?php echo smartyTranslate(array('s'=>'(tax incl.)','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var txtWithoutTax = "<?php echo smartyTranslate(array('s'=>'(tax excl.)','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var txtHasBeenSelected = "<?php echo smartyTranslate(array('s'=>'has been selected','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var txtNoCarrierIsSelected = "<?php echo smartyTranslate(array('s'=>'No carrier has been selected','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var txtNoCarrierIsNeeded = "<?php echo smartyTranslate(array('s'=>'No carrier is needed for this order','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var txtConditionsIsNotNeeded = "<?php echo smartyTranslate(array('s'=>'No terms of service must be accepted','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var txtTOSIsAccepted = "<?php echo smartyTranslate(array('s'=>'Terms of service is accepted','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var txtTOSIsNotAccepted = "<?php echo smartyTranslate(array('s'=>'Terms of service have not been accepted','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var txtThereis = "<?php echo smartyTranslate(array('s'=>'There is','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var txtErrors = "<?php echo smartyTranslate(array('s'=>'error(s)','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var txtDeliveryAddress = "<?php echo smartyTranslate(array('s'=>'Delivery address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var txtInvoiceAddress = "<?php echo smartyTranslate(array('s'=>'Invoice address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var txtModifyMyAddress = "<?php echo smartyTranslate(array('s'=>'Modify my address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var txtInstantCheckout = "<?php echo smartyTranslate(array('s'=>'Instant checkout','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var errorCarrier = "<?php echo addcslashes($_smarty_tpl->tpl_vars['errorCarrier']->value,'\'');?>
";
    var errorTOS = "<?php echo addcslashes($_smarty_tpl->tpl_vars['errorTOS']->value,'\'');?>
";
    var errorPayment = "<?php echo smartyTranslate(array('s'=>'Please select payment method.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var checkedCarrier = "<?php if (isset($_smarty_tpl->tpl_vars['checked']->value)) {?><?php echo $_smarty_tpl->tpl_vars['checked']->value;?>
<?php } else { ?>0<?php }?>";

    var txtProduct = "<?php echo smartyTranslate(array('s'=>'product','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var txtProducts = "<?php echo smartyTranslate(array('s'=>'products','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var txtFreePrice = "<?php echo smartyTranslate(array('s'=>'Free!','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    <?php if (isset($_smarty_tpl->tpl_vars['onlyCartSummary']->value)) {?>
      var onlyCartSummary = '1';
    <?php } else { ?>
      var onlyCartSummary = '0';
    <?php }?>

    var addresses = new Array();
    var isLogged = <?php echo intval($_smarty_tpl->tpl_vars['isLogged']->value);?>
;
    var isGuest = <?php echo intval($_smarty_tpl->tpl_vars['isGuest']->value);?>
;
    var isVirtualCart = <?php echo intval($_smarty_tpl->tpl_vars['isVirtualCart']->value);?>
;
    var isPaymentStep = <?php echo intval($_smarty_tpl->tpl_vars['isPaymentStep']->value);?>
;


    var opc_scroll_cart = "<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['scroll_cart'])&&intval($_smarty_tpl->tpl_vars['productNumber']->value);?>
";
    var opc_scroll_header_cart = "<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['scroll_header_cart'])&&intval($_smarty_tpl->tpl_vars['productNumber']->value);?>
";
    var opc_scroll_info = "1"; 
    var opc_scroll_summary = "<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['scroll_summary'])&&intval($_smarty_tpl->tpl_vars['productNumber']->value);?>
";
    var opc_scroll_products = "<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['scroll_products']);?>
";
    var opc_page_fading = "<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['page_fading'])&&intval($_smarty_tpl->tpl_vars['productNumber']->value);?>
";
    var opc_fading_duration = "<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['fading_duration']);?>
";
    var opc_fading_opacity = "<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['fading_opacity']);?>
";
    var opc_sample_values = "<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['sample_values']);?>
";
    var opc_sample_to_placeholder = ('<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['sample_to_placeholder']);?>
' == '1') ? true: false;
    var opc_inline_validation = "<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['inline_validation']);?>
";
    var opc_validation_checkboxes = "<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']);?>
";
    var opc_display_info_block = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['display_info_block']);?>
';
    var opc_info_block_content = '<?php echo smarty_modifier_regex_replace(smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['info_block_content']->value,"/[\r\t\n]/"," "),"/\'/","\\'");?>
';
    var opc_before_info_element = '<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['opc_config']->value['before_info_element'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
';
    var opc_check_number_in_address = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['check_number_in_address']);?>
';
    var opc_capitalize_fields = '<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['opc_config']->value['capitalize_fields'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
';
    var opc_relay_update = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['update_payments_relay']);?>
';
    var opc_hide_carrier = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['hide_carrier']);?>
';
    var opc_hide_payment = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['hide_payment']);?>
';
    var opc_override_checkout_btn = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['override_checkout_btn']);?>
';
    var ps_guest_checkout_enabled = '<?php echo intval($_smarty_tpl->tpl_vars['PS_GUEST_CHECKOUT_ENABLED']->value);?>
'
    var opc_display_password_msg = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['display_password_msg']);?>
';
    var opc_live_zip = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['live_zip']);?>
';
    var opc_live_city = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['live_city']);?>
';
    var opc_cart_summary_bottom = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['cart_summary_bottom']);?>
';
    var opc_above_confirmation_message = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['above_confirmation_message']);?>
';
    var opc_order_detail_review = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['order_detail_review']);?>
';
    var opc_animate_fields_padding = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['animate_fields_padding']);?>
';
    var opc_two_column_opc = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['two_column_opc']);?>
';
    var opc_three_column_opc = ('<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['three_column_opc']);?>
' == '1') ? true: false;
    var opc_cookie_cache = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['cookie_cache']);?>
';
    var opc_move_cgv = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['move_cgv']);?>
';
    var opc_move_message = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['move_message']);?>
';
    var opc_responsive_layout = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['responsive_layout']);?>
';
    var opc_company_based_vat = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['company_based_vat']);?>
';
    var opc_save_account_overlay = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['save_account_overlay']);?>
';
    var opc_payment_radio_buttons = '<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['payment_radio_buttons']);?>
';
    var opc_invoice_first = false; 
    var opc_default_ps_carriers = ('<?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['default_ps_carriers']);?>
' == '1') ? true : false;

    // Some more translations
    var ntf_close = "<?php echo smartyTranslate(array('s'=>'Close','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var ntf_number_in_address_missing = "<?php echo smartyTranslate(array('s'=>'Number in address is missing, are you sure you don\'t have one?','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var freeShippingTranslation = "<?php echo smartyTranslate(array('s'=>'Free shipping!','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    var freeProductTranslation = "<?php echo smartyTranslate(array('s'=>'Free!','mod'=>'onepagecheckout'),$_smarty_tpl);?>
";
    //]]>
</script>

    <div id="opc_checkout" class="<?php if (version_compare(@constant('_PS_VERSION_'),'1.6','>')) {?>ps16<?php } else { ?>ps15<?php }?>">
    <?php if ($_smarty_tpl->tpl_vars['productNumber']->value) {?>
    <!-- Shopping Cart -->
        <?php if (!$_smarty_tpl->tpl_vars['twoStepCheckout']->value&&!$_smarty_tpl->tpl_vars['opc_config']->value['cart_summary_bottom']) {?>
            <span class="summary-top"></span>
            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['opc_templates_path']->value)."/shopping-cart.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <?php }?>
    <!-- END Shopping Cart -->
    <!-- Create account / Guest account / Login block -->
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['opc_templates_path']->value)."/order-opc-new-account.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <!-- END Create account / Guest account / Login block -->

    <div id="shipping-payment-block"> 
        <div class="inner-table"> 
    <!-- Carrier -->
        <?php if ($_smarty_tpl->tpl_vars['opc_config']->value['default_ps_carriers']) {?>
            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['opc_templates_path']->value)."/order-carrier-def.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <?php } else { ?>
            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['opc_templates_path']->value)."/order-carrier.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <?php }?>

    <!-- END Carrier -->

    <!-- Payment -->
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['opc_templates_path']->value)."/order-payment.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <!-- END Payment -->
        <?php } else { ?>
    <h2><?php echo smartyTranslate(array('s'=>'Your shopping cart','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</h2>
    <p class="warning"><?php echo smartyTranslate(array('s'=>'Your shopping cart is empty.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</p>
    <?php }?>
        </div>
<?php }?>
<?php }} ?>
