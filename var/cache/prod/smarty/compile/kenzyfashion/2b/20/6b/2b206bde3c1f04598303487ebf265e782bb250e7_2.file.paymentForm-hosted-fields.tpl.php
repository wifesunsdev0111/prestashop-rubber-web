<?php
/* Smarty version 3.1.47, created on 2023-07-30 01:12:09
  from '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/modules/hipay_enterprise/views/templates/hook/paymentForm-hosted-fields.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64c59cc90d31d0_42058592',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2b206bde3c1f04598303487ebf265e782bb250e7' => 
    array (
      0 => '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/modules/hipay_enterprise/views/templates/hook/paymentForm-hosted-fields.tpl',
      1 => 1680526194,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64c59cc90d31d0_42058592 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!--[if IE 9]>
<div class="ie9 hipayHF-container" id="hipayHF-container">
<![endif]-->
<!--[if gt IE 9]><!-->
<div class="hipayHF-container" id="hipayHF-container">
    <!--<![endif]-->
    <div class="hipayHF-row">
        <div class="hipayHF-field-container">
            <div class="hipayHF-field" id="hipayHF-card-holder"></div>
            <label class="hipayHF-label" for="hipayHF-card-holder"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Fullname','mod'=>'hipay_enterprise'),$_smarty_tpl ) );?>
</label>
            <div class="hipayHF-baseline"></div>
            <div class="hipay-field-error" data-hipay-id='hipay-card-field-error-cardHolder'></div>
        </div>
    </div>
    <div class="hipayHF-row">
        <div class="hipayHF-field-container">
            <div class="hipayHF-field" id="hipayHF-card-number"></div>
            <label class="hipayHF-label" for="hipayHF-card-number"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Card Number','mod'=>'hipay_enterprise'),$_smarty_tpl ) );?>
</label>
            <div class="hipayHF-baseline"></div>
            <div class="hipay-field-error" data-hipay-id='hipay-card-field-error-cardNumber'></div>
        </div>
    </div>
    <div class="hipayHF-row">
        <div class="hipayHF-field-container hipayHF-field-container-half">
            <div class="hipayHF-field" id="hipayHF-date-expiry"></div>
            <label class="hipayHF-label" for="hipayHF-date-expiry"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Expiry date','mod'=>'hipay_enterprise'),$_smarty_tpl ) );?>
</label>
            <div class="hipayHF-baseline"></div>
            <div class="hipay-field-error" data-hipay-id='hipay-card-field-error-expiryDate'></div>
        </div>
        <div class="hipayHF-field-container hipayHF-field-container-half">
            <div class="hipayHF-field" id="hipayHF-cvc"></div>
            <label class="hipayHF-label" for="hipayHF-cvc"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'CVC','mod'=>'hipay_enterprise'),$_smarty_tpl ) );?>
</label>
            <div class="hipayHF-baseline"></div>
            <div class="hipay-field-error" data-hipay-id='hipay-card-field-error-cvc'></div>
        </div>
    </div>

    <div class="hipayHF-elements-container">
        <div id="hipayHF-help-cvc"></div>
    </div>
</div>
<?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['hipay_enterprise_tpl_dir']->value)."/front/partial/cc.hidden.inputs.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
}
}
