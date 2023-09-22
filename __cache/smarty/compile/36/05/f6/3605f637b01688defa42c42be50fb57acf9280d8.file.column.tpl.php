<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:06
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal/views/templates/hook/column.tpl" */ ?>
<?php /*%%SmartyHeaderCode:25122779362b57866329fe0-32543987%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3605f637b01688defa42c42be50fb57acf9280d8' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal/views/templates/hook/column.tpl',
      1 => 1641581521,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25122779362b57866329fe0-32543987',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'base_dir_ssl' => 0,
    'logo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b5786634d970_53085833',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b5786634d970_53085833')) {function content_62b5786634d970_53085833($_smarty_tpl) {?>

<div id="paypal-column-block">
	<p><a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['base_dir_ssl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
modules/paypal/about.php" rel="nofollow"><img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['logo']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" alt="PayPal" title="<?php echo smartyTranslate(array('s'=>'Pay with PayPal','mod'=>'paypal'),$_smarty_tpl);?>
" style="max-width: 100%" /></a></p>
</div>
<?php }} ?>
