<?php /* Smarty version Smarty-3.1.19, created on 2022-07-19 16:40:19
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal/views/templates/front/order-summary.tpl" */ ?>
<?php /*%%SmartyHeaderCode:101951090862d6c253819cc7-79240604%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '60671dada0efbb57f3a4bb8a87bfc608714bde2b' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal/views/templates/front/order-summary.tpl',
      1 => 1641581521,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '101951090862d6c253819cc7-79240604',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'use_mobile' => 0,
    'navigationPipe' => 0,
    'form_action' => 0,
    'paypal_cart_summary' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62d6c2538f2555_81858749',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d6c2538f2555_81858749')) {function content_62d6c2538f2555_81858749($_smarty_tpl) {?>
<?php if (@constant('_PS_VERSION_')<1.5&&isset($_smarty_tpl->tpl_vars['use_mobile']->value)&&$_smarty_tpl->tpl_vars['use_mobile']->value) {?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./modules/paypal/views/templates/front/order-summary.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php } else { ?>
	<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><a href="order.php"><?php echo smartyTranslate(array('s'=>'Your shopping cart','mod'=>'paypal'),$_smarty_tpl);?>
</a><span class="navigation-pipe"> <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['navigationPipe']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 </span> <?php echo smartyTranslate(array('s'=>'PayPal','mod'=>'paypal'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
	<?php if (@constant('_PS_VERSION_')<1.6) {?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./breadcrumb.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	<?php }?>
	<h1><?php echo smartyTranslate(array('s'=>'Order summary','mod'=>'paypal'),$_smarty_tpl);?>
</h1>

	<?php $_smarty_tpl->tpl_vars['current_step'] = new Smarty_variable('payment', null, 0);?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./order-steps.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


	<h3><?php echo smartyTranslate(array('s'=>'PayPal payment','mod'=>'paypal'),$_smarty_tpl);?>
</h3>
	<form action="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['form_action']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" method="post" data-ajax="false">
        <?php echo $_smarty_tpl->tpl_vars['paypal_cart_summary']->value;?>

		<p>
			<b><?php echo smartyTranslate(array('s'=>'Please confirm your order by clicking \'I confirm my order\'','mod'=>'paypal'),$_smarty_tpl);?>
.</b>
		</p>
		<p class="cart_navigation">
			<input type="submit" name="confirmation" value="<?php echo smartyTranslate(array('s'=>'I confirm my order','mod'=>'paypal'),$_smarty_tpl);?>
" class="exclusive_large" />
		</p>
	</form>
<?php }?>

<?php }} ?>
