<?php /* Smarty version Smarty-3.1.19, created on 2022-06-28 22:40:06
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/discount.tpl" */ ?>
<?php /*%%SmartyHeaderCode:74810209062bb6726df9b53-12208460%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd13ab5079edae0abcf1a9173b539538cf2fb1eba' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/discount.tpl',
      1 => 1470857594,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '74810209062bb6726df9b53-12208460',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'navigationPipe' => 0,
    'cart_rules' => 0,
    'nb_cart_rules' => 0,
    'discountDetail' => 0,
    'force_ssl' => 0,
    'base_dir_ssl' => 0,
    'base_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62bb6726ec32d4_08751586',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62bb6726ec32d4_08751586')) {function content_62bb6726ec32d4_08751586($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_regex_replace')) include '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/tools/smarty/plugins/modifier.regex_replace.php';
?>
<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
"><?php echo smartyTranslate(array('s'=>'My account'),$_smarty_tpl);?>
</a><span class="navigation-pipe"><?php echo $_smarty_tpl->tpl_vars['navigationPipe']->value;?>
</span><span class="navigation_page"><?php echo smartyTranslate(array('s'=>'My vouchers'),$_smarty_tpl);?>
</span><?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<h1 class="page-heading">
	<?php echo smartyTranslate(array('s'=>'My vouchers'),$_smarty_tpl);?>

</h1>

<?php if (isset($_smarty_tpl->tpl_vars['cart_rules']->value)&&count($_smarty_tpl->tpl_vars['cart_rules']->value)&&$_smarty_tpl->tpl_vars['nb_cart_rules']->value) {?>
<div class="table-responsive">
	<table class="discount table table-bordered footab">
		<thead>
			<tr>
				<th data-sort-ignore="true" class="discount_code first_item"><?php echo smartyTranslate(array('s'=>'Code'),$_smarty_tpl);?>
</th>
				<th data-sort-ignore="true" class="discount_description item"><?php echo smartyTranslate(array('s'=>'Description'),$_smarty_tpl);?>
</th>
				<th class="discount_quantity item"><?php echo smartyTranslate(array('s'=>'Quantity'),$_smarty_tpl);?>
</th>
				<th data-sort-ignore="true" data-hide="phone,tablet" class="discount_value item"><?php echo smartyTranslate(array('s'=>'Value'),$_smarty_tpl);?>
*</th>
				<th data-hide="phone,tablet" class="discount_minimum item"><?php echo smartyTranslate(array('s'=>'Minimum'),$_smarty_tpl);?>
</th>
				<th data-sort-ignore="true" data-hide="phone,tablet" class="discount_cumulative item"><?php echo smartyTranslate(array('s'=>'Cumulative'),$_smarty_tpl);?>
</th>
				<th data-hide="phone" class="discount_expiration_date last_item"><?php echo smartyTranslate(array('s'=>'Expiration date'),$_smarty_tpl);?>
</th>
			</tr>
		</thead>
		<tbody>
			<?php  $_smarty_tpl->tpl_vars['discountDetail'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['discountDetail']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cart_rules']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['discountDetail']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['discountDetail']->iteration=0;
 $_smarty_tpl->tpl_vars['discountDetail']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['discountDetail']->key => $_smarty_tpl->tpl_vars['discountDetail']->value) {
$_smarty_tpl->tpl_vars['discountDetail']->_loop = true;
 $_smarty_tpl->tpl_vars['discountDetail']->iteration++;
 $_smarty_tpl->tpl_vars['discountDetail']->index++;
 $_smarty_tpl->tpl_vars['discountDetail']->first = $_smarty_tpl->tpl_vars['discountDetail']->index === 0;
 $_smarty_tpl->tpl_vars['discountDetail']->last = $_smarty_tpl->tpl_vars['discountDetail']->iteration === $_smarty_tpl->tpl_vars['discountDetail']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['first'] = $_smarty_tpl->tpl_vars['discountDetail']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['index']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['last'] = $_smarty_tpl->tpl_vars['discountDetail']->last;
?>
				<tr class="<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['first']) {?>first_item<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['last']) {?>last_item<?php } else { ?>item<?php }?> <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['index']%2) {?>alternate_item<?php }?>">
					<td class="discount_code"><?php echo $_smarty_tpl->tpl_vars['discountDetail']->value['code'];?>
</td>
					<td class="discount_description"><?php echo $_smarty_tpl->tpl_vars['discountDetail']->value['name'];?>
</td>
					<td data-value="<?php echo $_smarty_tpl->tpl_vars['discountDetail']->value['quantity_for_user'];?>
" class="discount_quantity"><?php echo $_smarty_tpl->tpl_vars['discountDetail']->value['quantity_for_user'];?>
</td>
					<td class="discount_value">
						<?php if ($_smarty_tpl->tpl_vars['discountDetail']->value['id_discount_type']==1) {?>
							<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['discountDetail']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
%
						<?php } elseif ($_smarty_tpl->tpl_vars['discountDetail']->value['id_discount_type']==2) {?>
							<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['discountDetail']->value['value']),$_smarty_tpl);?>
 (<?php if ($_smarty_tpl->tpl_vars['discountDetail']->value['reduction_tax']==1) {?><?php echo smartyTranslate(array('s'=>'Tax included'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Tax excluded'),$_smarty_tpl);?>
<?php }?>)
						<?php } elseif ($_smarty_tpl->tpl_vars['discountDetail']->value['id_discount_type']==3) {?>
							<?php echo smartyTranslate(array('s'=>'Free shipping'),$_smarty_tpl);?>

						<?php } else { ?>
							-
						<?php }?>
					</td>
					<td class="discount_minimum" data-value="<?php if ($_smarty_tpl->tpl_vars['discountDetail']->value['minimal']==0) {?>0<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['discountDetail']->value['minimal'];?>
<?php }?>">
						<?php if ($_smarty_tpl->tpl_vars['discountDetail']->value['minimal']==0) {?>
							<?php echo smartyTranslate(array('s'=>'None'),$_smarty_tpl);?>

						<?php } else { ?>
							<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['discountDetail']->value['minimal']),$_smarty_tpl);?>

						<?php }?>
					</td>
					<td class="discount_cumulative">
						<?php if ($_smarty_tpl->tpl_vars['discountDetail']->value['cumulable']==1) {?>
							<i class="fa fa-ok"></i> <?php echo smartyTranslate(array('s'=>'Yes'),$_smarty_tpl);?>

						<?php } else { ?>
							<i class="fa fa-trash-o"></i> <?php echo smartyTranslate(array('s'=>'No'),$_smarty_tpl);?>

						<?php }?>
					</td>
					<td class="discount_expiration_date" data-value="<?php echo smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['discountDetail']->value['date_to'],"/[\-\:\ ]/",'');?>
">
						<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['discountDetail']->value['date_to']),$_smarty_tpl);?>

					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<?php } else { ?>
	<p class="alert alert-warning"><?php echo smartyTranslate(array('s'=>'You do not have any vouchers.'),$_smarty_tpl);?>
</p>
<?php }?>

<ul class="footer_links clearfix">
	<li class="pull-left">
		<a class="btn btn-outline button button-small btn-sm" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
">
			<span>
				<i class="fa fa-user"></i> <?php echo smartyTranslate(array('s'=>'Back to your account'),$_smarty_tpl);?>

			</span>
		</a>
	</li>
	<li class="pull-right">
		<a class="btn btn-outline button button-small btn-sm" href="<?php if (isset($_smarty_tpl->tpl_vars['force_ssl']->value)&&$_smarty_tpl->tpl_vars['force_ssl']->value) {?><?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
<?php }?>">
			<span>
				<i class="fa fa-home"></i> <?php echo smartyTranslate(array('s'=>'Home'),$_smarty_tpl);?>

			</span>
		</a>
	</li>
</ul>
<?php }} ?>
