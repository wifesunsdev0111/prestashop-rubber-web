<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:16
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/appagebuilder/views/templates/hook/ApSlideShow.tpl" */ ?>
<?php /*%%SmartyHeaderCode:55426852562b578707f4a80-41241261%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a8c0a99c7894345768d42c80b57c5b0f71132c12' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/appagebuilder/views/templates/hook/ApSlideShow.tpl',
      1 => 1470858214,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '55426852562b578707f4a80-41241261',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'formAtts' => 0,
    'content_slider' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b57870822b49_80406494',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b57870822b49_80406494')) {function content_62b57870822b49_80406494($_smarty_tpl) {?>
<!-- @file modules\appagebuilder\views\templates\hook\ApSlideShow -->
<?php if (isset($_smarty_tpl->tpl_vars['formAtts']->value['isEnabled'])&&$_smarty_tpl->tpl_vars['formAtts']->value['isEnabled']==true) {?>
<div id="slideshow-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['formAtts']->value['form_id'], ENT_QUOTES, 'UTF-8', true);?>
" class="ApSlideShow">
	<?php if (isset($_smarty_tpl->tpl_vars['content_slider']->value)) {?>
		<?php echo $_smarty_tpl->tpl_vars['content_slider']->value;?>

	<?php }?>
</div>
<?php }?><?php }} ?>
