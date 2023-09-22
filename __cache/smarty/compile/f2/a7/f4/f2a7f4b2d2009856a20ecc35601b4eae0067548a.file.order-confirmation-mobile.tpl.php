<?php /* Smarty version Smarty-3.1.19, created on 2022-06-26 16:50:45
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal/views/templates/front/order-confirmation-mobile.tpl" */ ?>
<?php /*%%SmartyHeaderCode:170402882562b87245d1b8f2-63643640%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f2a7f4b2d2009856a20ecc35601b4eae0067548a' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal/views/templates/front/order-confirmation-mobile.tpl',
      1 => 1641581521,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '170402882562b87245d1b8f2-63643640',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOOK_ORDER_CONFIRMATION' => 0,
    'HOOK_PAYMENT_RETURN' => 0,
    'order' => 0,
    'price' => 0,
    'is_guest' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b87245da6860_59033604',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b87245da6860_59033604')) {function content_62b87245da6860_59033604($_smarty_tpl) {?>

<div data-role="content" id="content" class="cart">
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


	<h2><?php echo smartyTranslate(array('s'=>'Order confirmation','mod'=>'paypal'),$_smarty_tpl);?>
</h2>
	
	<?php $_smarty_tpl->tpl_vars['current_step'] = new Smarty_variable('payment', null, 0);?>

	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


	<?php echo $_smarty_tpl->tpl_vars['HOOK_ORDER_CONFIRMATION']->value;?>

	<?php echo $_smarty_tpl->tpl_vars['HOOK_PAYMENT_RETURN']->value;?>


	<br />

	<?php if ($_smarty_tpl->tpl_vars['order']->value) {?>
		<p><?php echo smartyTranslate(array('s'=>'Total of the transaction (taxes incl.) :','mod'=>'paypal'),$_smarty_tpl);?>
 <span class="paypal-bold"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['price']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span></p>
		<p><?php echo smartyTranslate(array('s'=>'Your order ID is :','mod'=>'paypal'),$_smarty_tpl);?>
 
			<span class="paypal-bold">
			<?php if (@constant('_PS_VERSION_')>=1.5) {?>
				<?php echo mb_convert_encoding(htmlspecialchars(Order::getUniqReferenceOf($_smarty_tpl->tpl_vars['order']->value['id_order']), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

			<?php } else { ?>
				<?php echo intval($_smarty_tpl->tpl_vars['order']->value['id_order']);?>

			<?php }?>
			</span>
		</p>
		<p><?php echo smartyTranslate(array('s'=>'Your PayPal transaction ID is :','mod'=>'paypal'),$_smarty_tpl);?>
 <span class="paypal-bold"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['order']->value['id_transaction'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span></p>
	<?php }?>
	
	<br />
	
	<?php if (!$_smarty_tpl->tpl_vars['is_guest']->value) {?>
		<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('index',true), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-role="button" data-theme="a" data-icon="back" data-ajax="false"><?php echo smartyTranslate(array('s'=>'Continue shopping','mod'=>'paypal'),$_smarty_tpl);?>
</a>
	<?php } else { ?>
		<ul data-role="listview" data-inset="true" id="list_myaccount">
			<li data-theme="a" data-icon="check">
				<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('index',true), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" data-ajax="false"><?php echo smartyTranslate(array('s'=>'Continue shopping','mod'=>'paypal'),$_smarty_tpl);?>
</a>
			</li>
			<li data-theme="b" data-icon="back">
				<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('history.php',true,null);?>
" data-ajax="false"><?php echo smartyTranslate(array('s'=>'Back to orders','mod'=>'paypal'),$_smarty_tpl);?>
</a>
			</li>
		</ul>
	<?php }?>
	<br />
</div><!-- /content -->
<?php }} ?>
