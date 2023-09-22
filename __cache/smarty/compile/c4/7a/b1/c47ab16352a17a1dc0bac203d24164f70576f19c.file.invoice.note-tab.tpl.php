<?php /* Smarty version Smarty-3.1.19, created on 2022-06-25 17:22:55
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/pdf/invoice.note-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:112034896562b7284f64afa3-74252951%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c47ab16352a17a1dc0bac203d24164f70576f19c' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/pdf/invoice.note-tab.tpl',
      1 => 1575969844,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '112034896562b7284f64afa3-74252951',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order_invoice' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b7284f65ee63_66246687',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b7284f65ee63_66246687')) {function content_62b7284f65ee63_66246687($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['order_invoice']->value->note)&&$_smarty_tpl->tpl_vars['order_invoice']->value->note) {?>
	<tr>
		<td colspan="12" height="10">&nbsp;</td>
	</tr>
	
	<tr>
		<td colspan="6" class="left">
			<table id="note-tab" style="width: 100%">
				<tr>
					<td class="grey"><?php echo smartyTranslate(array('s'=>'Note','pdf'=>'true'),$_smarty_tpl);?>
</td>
				</tr>
				<tr>
					<td class="note"><?php echo nl2br($_smarty_tpl->tpl_vars['order_invoice']->value->note);?>
</td>
				</tr>
			</table>
		</td>
		<td colspan="1">&nbsp;</td>
	</tr>
<?php }?>
<?php }} ?>
