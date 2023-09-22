<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 18:05:45
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal//views/templates/admin/admin_order/refund.tpl" */ ?>
<?php /*%%SmartyHeaderCode:207243293762b5e0d96e0cd2-81235580%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b664bfa216928fbda1f638bd541270945de1dde' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal//views/templates/admin/admin_order/refund.tpl',
      1 => 1641581521,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '207243293762b5e0d96e0cd2-81235580',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'base_url' => 0,
    'module_name' => 0,
    'order_payment' => 0,
    'params' => 0,
    'ps_version' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b5e0d9723653_96924070',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b5e0d9723653_96924070')) {function content_62b5e0d9723653_96924070($_smarty_tpl) {?>
<?php if (@constant('_PS_VERSION_')>=1.6) {?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-heading"><img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['base_url']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
modules/<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['module_name']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/<?php if ($_smarty_tpl->tpl_vars['order_payment']->value=='paypal') {?>logo.gif<?php } else { ?>views/img/braintree.png<?php }?>" alt="" /> <?php if ($_smarty_tpl->tpl_vars['order_payment']->value=='paypal') {?><?php echo smartyTranslate(array('s'=>'PayPal Refund','mod'=>'paypal'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Braintree Refund','mod'=>'paypal'),$_smarty_tpl);?>
<?php }?></div>
			<form method="post" action="<?php echo mb_convert_encoding(htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">
				<input type="hidden" name="id_order" value="<?php echo intval($_smarty_tpl->tpl_vars['params']->value['id_order']);?>
" />
				<p><b><?php echo smartyTranslate(array('s'=>'Information:','mod'=>'paypal'),$_smarty_tpl);?>
</b> <?php echo smartyTranslate(array('s'=>'Payment accepted','mod'=>'paypal'),$_smarty_tpl);?>
</p>
				<p><b><?php echo smartyTranslate(array('s'=>'Information:','mod'=>'paypal'),$_smarty_tpl);?>
</b> <?php echo smartyTranslate(array('s'=>'When you refund a product, a partial refund is made unless you select "Generate a voucher".','mod'=>'paypal'),$_smarty_tpl);?>
</p>
				<p class="center">
					<button type="submit" class="btn btn-default" name="submitPayPalRefund" onclick="if (!confirm('<?php echo smartyTranslate(array('s'=>'Are you sure?','mod'=>'paypal'),$_smarty_tpl);?>
'))return false;">
						<i class="icon-undo"></i>
						<?php echo smartyTranslate(array('s'=>'Refund total transaction','mod'=>'paypal'),$_smarty_tpl);?>

					</button>
				</p>
			</form>
		</div>
	</div>
</div>
<?php } else { ?>
<br />
<fieldset <?php if (isset($_smarty_tpl->tpl_vars['ps_version']->value)&&($_smarty_tpl->tpl_vars['ps_version']->value<'1.5')) {?>style="width: 400px"<?php }?>>
	<legend><img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['base_url']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
modules/<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['module_name']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/<?php if ($_smarty_tpl->tpl_vars['order_payment']->value=='paypal') {?>logo.gif<?php } else { ?>views/img/braintree.png<?php }?>" alt="" /><?php if ($_smarty_tpl->tpl_vars['order_payment']->value=='paypal') {?><?php echo smartyTranslate(array('s'=>'PayPal Refund','mod'=>'paypal'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Braintree Refund','mod'=>'paypal'),$_smarty_tpl);?>
<?php }?></legend>
	<p><b><?php echo smartyTranslate(array('s'=>'Information:','mod'=>'paypal'),$_smarty_tpl);?>
</b> <?php echo smartyTranslate(array('s'=>'Payment accepted','mod'=>'paypal'),$_smarty_tpl);?>
</p>
	<p><b><?php echo smartyTranslate(array('s'=>'Information:','mod'=>'paypal'),$_smarty_tpl);?>
</b> <?php echo smartyTranslate(array('s'=>'When you refund a product, a partial refund is made unless you select "Generate a voucher".','mod'=>'paypal'),$_smarty_tpl);?>
</p>
	<form method="post" action="<?php echo mb_convert_encoding(htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">
		<input type="hidden" name="id_order" value="<?php echo intval($_smarty_tpl->tpl_vars['params']->value['id_order']);?>
" />
		<p class="center">
			<input type="submit" class="button" name="submitPayPalRefund" value="<?php echo smartyTranslate(array('s'=>'Refund total transaction','mod'=>'paypal'),$_smarty_tpl);?>
" onclick="if (!confirm('<?php echo smartyTranslate(array('s'=>'Are you sure?','mod'=>'paypal'),$_smarty_tpl);?>
'))return false;" />
		</p>
	</form>
</fieldset>

<?php }?>
<?php }} ?>
