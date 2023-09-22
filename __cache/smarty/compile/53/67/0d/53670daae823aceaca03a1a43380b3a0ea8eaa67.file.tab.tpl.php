<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:09
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/modules/productcomments//tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:40211725762b57869c3b9b1-13168348%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '53670daae823aceaca03a1a43380b3a0ea8eaa67' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/modules/productcomments//tab.tpl',
      1 => 1470857877,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '40211725762b57869c3b9b1-13168348',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'USE_PTABS' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b57869c59841_26658962',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b57869c59841_26658962')) {function content_62b57869c59841_26658962($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['USE_PTABS']->value)&&$_smarty_tpl->tpl_vars['USE_PTABS']->value) {?>
    <li><a id="link_idTab5" href="#idTab5" data-toggle="tab"><?php echo smartyTranslate(array('s'=>'Reviews','mod'=>'productcomments'),$_smarty_tpl);?>
</a></li>
<?php } else { ?>
    <h3 id="#idTab5" class="idTabHrefShort page-subheading"><?php echo smartyTranslate(array('s'=>'Reviews','mod'=>'productcomments'),$_smarty_tpl);?>
</h3>
<?php }?><?php }} ?>
