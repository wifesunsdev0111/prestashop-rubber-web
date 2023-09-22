<?php
/* Smarty version 3.1.47, created on 2023-07-30 01:12:09
  from 'module:hipayenterpriseviewstempl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64c59cc90b4158_17387189',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '80e2e907f8af777355e44d56c085aa51b3bb6090' => 
    array (
      0 => 'module:hipayenterpriseviewstempl',
      1 => 1680526194,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64c59cc90b4158_17387189 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['hipay_enterprise_tpl_dir']->value)."/front/partial/js.strings.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
<form id="tokenizerForm" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8');?>
" enctype="application/x-www-form-urlencoded"
    class="form-horizontal hipay-form-17" method="post" name="tokenizerForm" autocomplete="off">
    <?php if ($_smarty_tpl->tpl_vars['confHipay']->value['payment']['global']['card_token']) {?>
        <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['hipay_enterprise_tpl_dir']->value)."/front/partial/ps17/oneclick.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
    <?php }?>
    <div id="error-js" style="display:none" class="alert alert-danger">
        <ul>
            <li class="error"></li>
        </ul>
    </div>

    <?php if ($_smarty_tpl->tpl_vars['savedCC']->value && $_smarty_tpl->tpl_vars['confHipay']->value['payment']['global']['card_token']) {?>
        <div class="option_payment">
            <span class="custom-radio">
                <input type="radio" id="radio-no-token" name="ccTokenHipay" value="noToken" />
                <span></span>
            </span>
            <label for="radio-no-token"><strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Pay with a new credit card','mod'=>'hipay_enterprise'),$_smarty_tpl ) );?>
</strong></label>
        </div>
    <?php }?>
    <div id="credit-card-group"
        class="form-group group-card  <?php if ($_smarty_tpl->tpl_vars['savedCC']->value && $_smarty_tpl->tpl_vars['confHipay']->value['payment']['global']['card_token']) {?>collapse<?php }?>">
        <div class="row">
            <?php if ($_smarty_tpl->tpl_vars['savedCC']->value && $_smarty_tpl->tpl_vars['confHipay']->value['payment']['global']['card_token']) {?>
                <div class="col-md-1"></div>
            <?php }?>
            <div class="col-md-11">
                <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['hipay_enterprise_tpl_dir']->value)."/hook/paymentForm-hosted-fields.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>
                <?php if ($_smarty_tpl->tpl_vars['confHipay']->value['payment']['global']['card_token'] && !$_smarty_tpl->tpl_vars['is_guest']->value) {?>
                    <div class="row">
                        <span class="custom-checkbox" id="save-credit-card">
                            <input id="saveTokenHipay" type="checkbox" name="saveTokenHipay">
                            <span><i class="material-icons checkbox-checked"></i></span>
                            <label
                                for="saveTokenHipay"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Save credit card (One click payment)','mod'=>'hipay_enterprise'),$_smarty_tpl ) );?>
</label>
                        </span>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
</form>
<div id="payment-loader-hp" style='text-align: center; display:none;'>
    <div><strong><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Your payment is being processed. Please wait.','mod'=>'hipay_enterprise'),$_smarty_tpl ) );?>
</strong></div>
    <img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['this_path_ssl']->value, ENT_QUOTES, 'UTF-8');?>
/views/img/loading.gif" alt="loading payment">
</div>

<?php echo '<script'; ?>
>
    //Support module One Page Checkout PS - PresTeamShop - v4.1.1 - PrestaShop >= 1.7.6.X
    //--------------------------------
    if (window.opc_dispatcher && window.opc_dispatcher.events) {
        window.opc_dispatcher.events.addEventListener('payment-getPaymentList-complete', setSelectedPaymentMethod);
    } else {
        document.addEventListener('DOMContentLoaded', setSelectedPaymentMethod, false);
    }
    //--------------------------------

    <?php if ($_smarty_tpl->tpl_vars['confHipay']->value['account']['global']['sandbox_mode']) {?>
        var api_tokenjs_mode = "stage";
        var api_tokenjs_username = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['confHipay']->value['account']['sandbox']['api_tokenjs_username_sandbox'], ENT_QUOTES, 'UTF-8');?>
";
        var api_tokenjs_password_publickey = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['confHipay']->value['account']['sandbox']['api_tokenjs_password_publickey_sandbox'], ENT_QUOTES, 'UTF-8');?>
";
    <?php } else { ?>
        var api_tokenjs_mode = "production";
        var api_tokenjs_username = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['confHipay']->value['account']['production']['api_tokenjs_username_production'], ENT_QUOTES, 'UTF-8');?>
";
        var api_tokenjs_password_publickey = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['confHipay']->value['account']['production']['api_tokenjs_password_publickey_production'], ENT_QUOTES, 'UTF-8');?>
";
    <?php }?>

    var cardHolderFirstName = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['customerFirstName']->value, ENT_QUOTES, 'UTF-8');?>
";
    var cardHolderLastName = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['customerLastName']->value, ENT_QUOTES, 'UTF-8');?>
";

    var style = <?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'json_encode' ][ 0 ], array( $_smarty_tpl->tpl_vars['confHipay']->value['payment']['global']['hosted_fields_style'] ));?>
;

    var activatedCreditCard = [];
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['activatedCreditCard']->value, 'cc');
$_smarty_tpl->tpl_vars['cc']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['cc']->value) {
$_smarty_tpl->tpl_vars['cc']->do_else = false;
?>
        activatedCreditCard.push("<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cc']->value, ENT_QUOTES, 'UTF-8');?>
");
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
    var activatedCreditCardError = "<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'This credit card type or the order currency is not supported. Please choose an other payment method.','mod'=>'hipay_enterprise'),$_smarty_tpl ) );?>
";
    var oneClick = !!<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['confHipay']->value['payment']['global']['card_token'], ENT_QUOTES, 'UTF-8');?>
;

    var lang = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['languageIsoCode']->value, ENT_QUOTES, 'UTF-8');?>
";

    var myPaymentMethodSelected = false;

    function setSelectedPaymentMethod() {
        myPaymentMethodSelected = $(".payment-options").find(
            "input[data-module-name='credit_card']").is(
            ":checked");
        $(document).on("change", ".payment-options", function() {
            myPaymentMethodSelected = $(".payment-options").find(
                "input[data-module-name='credit_card']").is(
                ":checked");
        });
    }
<?php echo '</script'; ?>
>
<?php }
}
