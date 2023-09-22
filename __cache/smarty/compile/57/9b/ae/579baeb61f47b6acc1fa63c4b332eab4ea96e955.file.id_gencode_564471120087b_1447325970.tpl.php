<?php /* Smarty version Smarty-3.1.19, created on 2022-07-29 13:08:55
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/profiles/profile1447334881/id_gencode_564471120087b_1447325970.tpl" */ ?>
<?php /*%%SmartyHeaderCode:113490090162b57864e90f95-25639261%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '579baeb61f47b6acc1fa63c4b332eab4ea96e955' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/profiles/profile1447334881/id_gencode_564471120087b_1447325970.tpl',
      1 => 1659092935,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '113490090162b57864e90f95-25639261',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b57864e9aa05_21798736',
  'variables' => 
  array (
    'base_dir' => 0,
    'shop_name' => 0,
    'logo_url' => 0,
    'logo_image_width' => 0,
    'logo_image_height' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b57864e9aa05_21798736')) {function content_62b57864e9aa05_21798736($_smarty_tpl) {?>                                    <a href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_name']->value, ENT_QUOTES, 'UTF-8', true);?>
">                                        <img class="logo img-responsive" src="<?php echo $_smarty_tpl->tpl_vars['logo_url']->value;?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop_name']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php if (isset($_smarty_tpl->tpl_vars['logo_image_width']->value)&&$_smarty_tpl->tpl_vars['logo_image_width']->value) {?> width="<?php echo $_smarty_tpl->tpl_vars['logo_image_width']->value;?>
"<?php }?><?php if (isset($_smarty_tpl->tpl_vars['logo_image_height']->value)&&$_smarty_tpl->tpl_vars['logo_image_height']->value) {?> height="<?php echo $_smarty_tpl->tpl_vars['logo_image_height']->value;?>
"<?php }?>/>                                    </a><?php }} ?>
