<?php /* Smarty version Smarty-3.1.19, created on 2022-07-28 17:51:40
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/gamification/views/templates/admin/gamification/helpers/view/filters_bt.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13323126762e2b08c0df4b3-36607918%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6fddfb20a4d38eb4c30e6721aa71afe8f57a6392' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/gamification/views/templates/admin/gamification/helpers/view/filters_bt.tpl',
      1 => 1579509749,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13323126762e2b08c0df4b3-36607918',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'type' => 0,
    'groups' => 0,
    'id_group' => 0,
    'group' => 0,
    'levels' => 0,
    'id_level' => 0,
    'level' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62e2b08c110973_50076717',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62e2b08c110973_50076717')) {function content_62e2b08c110973_50076717($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['type']->value)) {?>
<form class="form-horizontal well" role="form">
    <?php if ($_smarty_tpl->tpl_vars['type']->value=='badges_feature'||$_smarty_tpl->tpl_vars['type']->value=='badges_achievement') {?>
        <div class="form-group">
            <label><?php echo smartyTranslate(array('s'=>'Type:','mod'=>'gamification'),$_smarty_tpl);?>
</label>
            <select id="group_select_<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" onchange="filterBadge('<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
');">
                    <option value="badge_all"><?php echo smartyTranslate(array('s'=>'All','mod'=>'gamification'),$_smarty_tpl);?>
</option>
                <?php if (isset($_smarty_tpl->tpl_vars['groups']->value[$_smarty_tpl->tpl_vars['type']->value])) {?>
                <?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group']->_loop = false;
 $_smarty_tpl->tpl_vars['id_group'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['groups']->value[$_smarty_tpl->tpl_vars['type']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value) {
$_smarty_tpl->tpl_vars['group']->_loop = true;
 $_smarty_tpl->tpl_vars['id_group']->value = $_smarty_tpl->tpl_vars['group']->key;
?>
                    <option value="group_<?php echo $_smarty_tpl->tpl_vars['id_group']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['group']->value;?>
</option>
                <?php } ?>
                <?php }?>
            </select>
        </div>
    <?php }?>
        <div class="form-group">
            <label><?php echo smartyTranslate(array('s'=>'Status:','mod'=>'gamification'),$_smarty_tpl);?>
</label>
            <select id="status_select_<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" onchange="filterBadge('<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
');">
                <option value="badge_all"><?php echo smartyTranslate(array('s'=>'All','mod'=>'gamification'),$_smarty_tpl);?>
</option>
                <option value="validated"><?php echo smartyTranslate(array('s'=>'Validated','mod'=>'gamification'),$_smarty_tpl);?>
</option>
                <option value="not_validated"><?php echo smartyTranslate(array('s'=>'Not Validated','mod'=>'gamification'),$_smarty_tpl);?>
</option>
            </select>
        </div>
    <?php if ($_smarty_tpl->tpl_vars['type']->value=='badges_feature'||$_smarty_tpl->tpl_vars['type']->value=='badges_achievement') {?>
        <div class="form-group">
            <label><?php echo smartyTranslate(array('s'=>'Level:','mod'=>'gamification'),$_smarty_tpl);?>
</label>
                <select id="level_select_<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" onchange="filterBadge('<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
');">
                        <option value="badge_all"><?php echo smartyTranslate(array('s'=>'All','mod'=>'gamification'),$_smarty_tpl);?>
</option>
                    <?php if (isset($_smarty_tpl->tpl_vars['levels']->value)) {?>
                    <?php  $_smarty_tpl->tpl_vars['level'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['level']->_loop = false;
 $_smarty_tpl->tpl_vars['id_level'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['levels']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['level']->key => $_smarty_tpl->tpl_vars['level']->value) {
$_smarty_tpl->tpl_vars['level']->_loop = true;
 $_smarty_tpl->tpl_vars['id_level']->value = $_smarty_tpl->tpl_vars['level']->key;
?>
                        <option value="level_<?php echo $_smarty_tpl->tpl_vars['id_level']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['level']->value;?>
</option>
                    <?php } ?>
                    <?php }?>
                </select>
        </div>
    <?php }?>
</form>
<div class="clear"></div>
<?php }?>
<?php }} ?>
