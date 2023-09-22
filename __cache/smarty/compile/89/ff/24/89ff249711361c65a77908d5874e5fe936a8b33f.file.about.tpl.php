<?php /* Smarty version Smarty-3.1.19, created on 2022-06-30 17:42:29
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal/views/templates/front/about.tpl" */ ?>
<?php /*%%SmartyHeaderCode:147489600262bdc4651fcb83-64919056%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '89ff249711361c65a77908d5874e5fe936a8b33f' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal/views/templates/front/about.tpl',
      1 => 1641581521,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '147489600262bdc4651fcb83-64919056',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'iso_code' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62bdc4652716e8_35897253',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62bdc4652716e8_35897253')) {function content_62bdc4652716e8_35897253($_smarty_tpl) {?>

<h1><?php echo smartyTranslate(array('s'=>'What Is PayPal?','mod'=>'paypal'),$_smarty_tpl);?>
</h1>

<div class="paypalapi_about">
	<p><?php echo smartyTranslate(array('s'=>'PayPal, the trusted leader in online payments, enables buyers and businesses to send and receive money online. PayPal has over 100 million member accounts in 190 countries and regions. It\'s accepted by merchants everywhere, both on and off eBay.','mod'=>'paypal'),$_smarty_tpl);?>
</p>
	<p><b><?php echo smartyTranslate(array('s'=>'Is it safe to use?','mod'=>'paypal'),$_smarty_tpl);?>
</b></p>
	<p><?php echo smartyTranslate(array('s'=>'PayPal helps protect your credit card information with industry-leading security and fraud prevention systems. When you use PayPal, your financial information is never shared with the merchant.','mod'=>'paypal'),$_smarty_tpl);?>
</p>
	<p><b><?php echo smartyTranslate(array('s'=>'Why use PayPal?','mod'=>'paypal'),$_smarty_tpl);?>
</b></p>
	<p>
		<ul>
			<li><?php echo smartyTranslate(array('s'=>'Make purchases or send money with PayPal - it\'s free','mod'=>'paypal'),$_smarty_tpl);?>
</li>
			<li><?php echo smartyTranslate(array('s'=>'Shop and pay conveniently by saving your information with PayPal','mod'=>'paypal'),$_smarty_tpl);?>
</li>
			<li><?php echo smartyTranslate(array('s'=>'PayPal is accepted by millions of businesses worldwide and is the preferred payment method on eBay','mod'=>'paypal'),$_smarty_tpl);?>
</li>
		</ul>
	</p>
	<p><a href="https://www.paypal.com/<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['iso_code']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/cgi-bin/webscr?cmd=_registration-run&pal=TWJHHUL9AEP9C"><?php echo smartyTranslate(array('s'=>'Start using PayPal today!','mod'=>'paypal'),$_smarty_tpl);?>
</a></p>
</div><?php }} ?>
