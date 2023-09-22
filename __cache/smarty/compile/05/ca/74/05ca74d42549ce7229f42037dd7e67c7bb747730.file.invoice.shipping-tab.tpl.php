<?php /* Smarty version Smarty-3.1.19, created on 2022-06-25 17:22:55
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/pdf/invoice.shipping-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:72518556062b7284f721831-81952840%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '05ca74d42549ce7229f42037dd7e67c7bb747730' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/pdf/invoice.shipping-tab.tpl',
      1 => 1575969844,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '72518556062b7284f721831-81952840',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'carrier' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b7284f745b48_24607821',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b7284f745b48_24607821')) {function content_62b7284f745b48_24607821($_smarty_tpl) {?>
<table id="shipping-tab" width="100%">
	<tr>
		<td class="shipping center small grey bold" width="44%"><?php echo smartyTranslate(array('s'=>'Carrier','pdf'=>'true'),$_smarty_tpl);?>
</td>
		<td class="shipping center small white" width="56%"><?php echo $_smarty_tpl->tpl_vars['carrier']->value->name;?>
</td>
	</tr>
</table>
<?php }} ?>
