<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:15
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/appagebuilder/views/templates/hook/htab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3882986362b5786f95f6e9-81917364%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3b1d1bd356a5982815b7ec2ae0b81a2ced6762d8' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/appagebuilder/views/templates/hook/htab.tpl',
      1 => 1470858216,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3882986362b5786f95f6e9-81917364',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ap_header_config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b5786f969036_84395100',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b5786f969036_84395100')) {function content_62b5786f969036_84395100($_smarty_tpl) {?>
<!-- @file modules\appagebuilder\views\templates\hook\htab -->
<?php if (isset($_smarty_tpl->tpl_vars['ap_header_config']->value)) {?>
<script type='text/javascript'>
	<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ap_header_config']->value, ENT_QUOTES, 'UTF-8', true);?>

</script>
<?php }?><?php }} ?>
