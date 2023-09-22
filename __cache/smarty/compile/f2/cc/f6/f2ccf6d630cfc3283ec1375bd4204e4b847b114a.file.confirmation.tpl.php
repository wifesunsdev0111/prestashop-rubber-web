<?php /* Smarty version Smarty-3.1.19, created on 2022-06-25 17:22:57
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal/views/templates/hook/confirmation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:100055162362b728512867f6-17107311%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f2ccf6d630cfc3283ec1375bd4204e4b847b114a' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal/views/templates/hook/confirmation.tpl',
      1 => 1641581521,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '100055162362b728512867f6-17107311',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'shop_name' => 0,
    'PayPal_payment_mode' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b72851295b14_34557176',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b72851295b14_34557176')) {function content_62b72851295b14_34557176($_smarty_tpl) {?>

<p><?php echo smartyTranslate(array('s'=>'Your order on','mod'=>'paypal'),$_smarty_tpl);?>
 <span class="paypal-bold"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['shop_name']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span> <?php echo smartyTranslate(array('s'=>'is complete.','mod'=>'paypal'),$_smarty_tpl);?>

	<br /><br />
	<?php echo smartyTranslate(array('s'=>'You have chosen the PayPal method.','mod'=>'paypal'),$_smarty_tpl);?>

	<br /><br /><span class="paypal-bold">
		<?php if ($_smarty_tpl->tpl_vars['PayPal_payment_mode']->value) {?>
			<?php echo smartyTranslate(array('s'=>'Your order will be sent to you as soon as the payment is captured.','mod'=>'paypal'),$_smarty_tpl);?>

		<?php } else { ?>
            <?php echo smartyTranslate(array('s'=>'Your order will be sent very soon.','mod'=>'paypal'),$_smarty_tpl);?>

        <?php }?>
	</span>
	<br /><br /><?php echo smartyTranslate(array('s'=>'For any questions or for further information, please contact our','mod'=>'paypal'),$_smarty_tpl);?>

	<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('contact',true), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-ajax="false" target="_blank"><?php echo smartyTranslate(array('s'=>'customer support','mod'=>'paypal'),$_smarty_tpl);?>
</a>.
</p>
<?php }} ?>
