<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:09
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/leomanagewidgets//views/widgets/producttabcontent/group.tpl" */ ?>
<?php /*%%SmartyHeaderCode:48146784562b57869d95522-53507056%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3e6851763fd8450916a469d95111ab0fcd019f36' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/leomanagewidgets//views/widgets/producttabcontent/group.tpl',
      1 => 1446714798,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '48146784562b57869d95522-53507056',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'leoGroup' => 0,
    'groups' => 0,
    'typeGroup' => 0,
    'group' => 0,
    'column' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b57869df5489_61419140',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b57869df5489_61419140')) {function content_62b57869df5489_61419140($_smarty_tpl) {?><div id="idTab68">
<?php if ($_smarty_tpl->tpl_vars['leoGroup']->value) {?>
    <?php  $_smarty_tpl->tpl_vars['groups'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['groups']->_loop = false;
 $_smarty_tpl->tpl_vars['typeGroup'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['leoGroup']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['groups']->key => $_smarty_tpl->tpl_vars['groups']->value) {
$_smarty_tpl->tpl_vars['groups']->_loop = true;
 $_smarty_tpl->tpl_vars['typeGroup']->value = $_smarty_tpl->tpl_vars['groups']->key;
?>
        <?php if ($_smarty_tpl->tpl_vars['groups']->value) {?>
            <?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['groups']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value) {
$_smarty_tpl->tpl_vars['group']->_loop = true;
?>
                <?php if ($_smarty_tpl->tpl_vars['typeGroup']->value==1) {?>
<div class="row <?php echo $_smarty_tpl->tpl_vars['group']->value['class'];?>
" <?php if (isset($_smarty_tpl->tpl_vars['group']->value['background'])&&$_smarty_tpl->tpl_vars['group']->value['background']) {?>style="background-color: <?php echo $_smarty_tpl->tpl_vars['group']->value['background'];?>
"<?php }?>>
                    <?php if (isset($_smarty_tpl->tpl_vars['group']->value['title'])&&$_smarty_tpl->tpl_vars['group']->value['title']) {?>
				<h4 class="title_block"><?php echo $_smarty_tpl->tpl_vars['group']->value['title'];?>
</h4>
                    <?php }?>
                <?php }?>
                <?php if (isset($_smarty_tpl->tpl_vars['group']->value['columns'])&&$_smarty_tpl->tpl_vars['group']->value['columns']) {?>
                    <?php  $_smarty_tpl->tpl_vars['column'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['column']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group']->value['columns']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['column']->key => $_smarty_tpl->tpl_vars['column']->value) {
$_smarty_tpl->tpl_vars['column']->_loop = true;
?>
                        <?php if ($_smarty_tpl->tpl_vars['column']->value['active']) {?>
    <div class="widget<?php echo $_smarty_tpl->tpl_vars['column']->value['col_value'];?>
<?php if ($_smarty_tpl->tpl_vars['column']->value['class']) {?> <?php echo $_smarty_tpl->tpl_vars['column']->value['class'];?>
<?php }?>" <?php if (isset($_smarty_tpl->tpl_vars['column']->value['background'])&&$_smarty_tpl->tpl_vars['column']->value['background']) {?>style="background-color: <?php echo $_smarty_tpl->tpl_vars['column']->value['background'];?>
"<?php }?>>
        <?php if (isset($_smarty_tpl->tpl_vars['column']->value['content'])) {?><?php echo $_smarty_tpl->tpl_vars['column']->value['content'];?>
<?php }?>
    </div>
                        <?php }?>
                    <?php } ?>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['typeGroup']->value==1) {?>
</div>
                <?php }?>
            <?php } ?>
        <?php }?>
    <?php } ?>
<?php }?>
</div><?php }} ?>
