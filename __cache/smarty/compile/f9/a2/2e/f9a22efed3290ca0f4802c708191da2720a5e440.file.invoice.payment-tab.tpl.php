<?php /* Smarty version Smarty-3.1.19, created on 2022-06-25 17:22:55
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/pdf/invoice.payment-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:105727700362b7284f603558-84496059%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f9a22efed3290ca0f4802c708191da2720a5e440' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/pdf/invoice.payment-tab.tpl',
      1 => 1575969844,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '105727700362b7284f603558-84496059',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order_invoice' => 0,
    'payment' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b7284f61a1a9_03949919',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b7284f61a1a9_03949919')) {function content_62b7284f61a1a9_03949919($_smarty_tpl) {?>
<table id="payment-tab" width="100%">
	<tr>
		<td class="payment center small grey bold" width="44%"><?php echo smartyTranslate(array('s'=>'Payment Method','pdf'=>'true'),$_smarty_tpl);?>
</td>
		<td class="payment left white" width="56%">
			<table width="100%" border="0">
				<?php  $_smarty_tpl->tpl_vars['payment'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['payment']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['order_invoice']->value->getOrderPaymentCollection(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['payment']->key => $_smarty_tpl->tpl_vars['payment']->value) {
$_smarty_tpl->tpl_vars['payment']->_loop = true;
?>
					<tr>
						<td class="right small"><?php echo $_smarty_tpl->tpl_vars['payment']->value->payment_method;?>
</td>
						<td class="right small"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('currency'=>$_smarty_tpl->tpl_vars['payment']->value->id_currency,'price'=>$_smarty_tpl->tpl_vars['payment']->value->amount),$_smarty_tpl);?>
</td>
					</tr>
				<?php } ?>
			</table>
		</td>
	</tr>
</table>
<?php }} ?>
