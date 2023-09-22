<?php /* Smarty version Smarty-3.1.19, created on 2022-07-28 18:11:20
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/bankwire/views/templates/hook/infos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:55565336062e2b528780286-22777628%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '488c771e1465a352514913089c8784d68ae7a8c1' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/bankwire/views/templates/hook/infos.tpl',
      1 => 1575969875,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '55565336062e2b528780286-22777628',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62e2b5287b6eb4_65531882',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62e2b5287b6eb4_65531882')) {function content_62e2b5287b6eb4_65531882($_smarty_tpl) {?>

<div class="alert alert-info">
<img src="../modules/bankwire/bankwire.jpg" style="float:left; margin-right:15px;" width="86" height="49">
<p><strong><?php echo smartyTranslate(array('s'=>"This module allows you to accept secure payments by bank wire.",'mod'=>'bankwire'),$_smarty_tpl);?>
</strong></p>
<p><?php echo smartyTranslate(array('s'=>"If the client chooses to pay by bank wire, the order's status will change to 'Waiting for Payment.'",'mod'=>'bankwire'),$_smarty_tpl);?>
</p>
<p><?php echo smartyTranslate(array('s'=>"That said, you must manually confirm the order upon receiving the bank wire.",'mod'=>'bankwire'),$_smarty_tpl);?>
</p>
</div>
<?php }} ?>
