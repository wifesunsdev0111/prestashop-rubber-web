<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:06
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/modules/appagebuilder/views/templates/hook/footer_links/ApBlockLink.tpl" */ ?>
<?php /*%%SmartyHeaderCode:27251497462b5786643f198-08456994%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ffdf18aa6010ea7a35fc5f6c17b7b4828df6ff2b' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/modules/appagebuilder/views/templates/hook/footer_links/ApBlockLink.tpl',
      1 => 1470857701,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27251497462b5786643f198-08456994',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'apLiveEdit' => 0,
    'formAtts' => 0,
    'item' => 0,
    'apLiveEditEnd' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b578664609d6_44266375',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b578664609d6_44266375')) {function content_62b578664609d6_44266375($_smarty_tpl) {?>
<!-- @file modules\appagebuilder\views\templates\hook\ApBlockLink -->
<?php echo $_smarty_tpl->tpl_vars['apLiveEdit']->value;?>



<div id="blockLink-<?php echo $_smarty_tpl->tpl_vars['formAtts']->value['form_id'];?>
" class="ApBlockLink">
    <div class="block footer-block">
        <h4 class="title_block"><?php echo $_smarty_tpl->tpl_vars['formAtts']->value['name'];?>
</h4>
        <ul class="toggle-footer list-group bullet">
        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['formAtts']->value['links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
            <?php if ($_smarty_tpl->tpl_vars['item']->value['title']&&$_smarty_tpl->tpl_vars['item']->value['link']) {?>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['link'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['title'], ENT_QUOTES, 'UTF-8', true);?>
</a></li>
            <?php }?>
        <?php } ?>
        </ul>
    </div>
</div>

<?php echo $_smarty_tpl->tpl_vars['apLiveEditEnd']->value;?>
<?php }} ?>
