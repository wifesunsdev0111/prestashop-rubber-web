<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:42:49
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal/views/templates/hook/express_checkout_shortcut_button.tpl" */ ?>
<?php /*%%SmartyHeaderCode:151463571862b57909379592-52256143%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4eb4f727fad14391f89f14deb4f74f52410ac34d' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal/views/templates/hook/express_checkout_shortcut_button.tpl',
      1 => 1641581521,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '151463571862b57909379592-52256143',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'use_mobile' => 0,
    'base_dir_ssl' => 0,
    'PayPal_lang_code' => 0,
    'paypal_express_checkout_shortcut_logo' => 0,
    'include_form' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b579093bc9e6_46179489',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b579093bc9e6_46179489')) {function content_62b579093bc9e6_46179489($_smarty_tpl) {?>

<div id="container_express_checkout" style="float:right; margin: 10px 40px 0 0">
	<?php if (isset($_smarty_tpl->tpl_vars['use_mobile']->value)&&$_smarty_tpl->tpl_vars['use_mobile']->value) {?>
		<div style="margin-left:30px">
			<img id="payment_paypal_express_checkout" src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['base_dir_ssl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
modules/paypal/views/img/logos/express_checkout_mobile/CO_<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_lang_code']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
_orange_295x43.png" alt="" />
		</div>
	<?php } else { ?>
		<?php if ($_smarty_tpl->tpl_vars['paypal_express_checkout_shortcut_logo']->value!=false) {?>
		<img id="payment_paypal_express_checkout" src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['paypal_express_checkout_shortcut_logo']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" alt="" />
		<?php } else { ?>
		<img id="payment_paypal_express_checkout" src="https://www.paypal.com/<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_lang_code']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/i/btn/btn_xpressCheckout.gif" alt="" />
		<?php }?>
	<?php }?>
	<?php if (isset($_smarty_tpl->tpl_vars['include_form']->value)&&$_smarty_tpl->tpl_vars['include_form']->value) {?>
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['template_dir']->value)."./express_checkout_shortcut_form.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	<?php }?>
</div>
<div class="clearfix"></div>
<?php }} ?>
