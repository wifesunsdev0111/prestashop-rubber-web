<?php
/* Smarty version 3.1.47, created on 2023-05-15 14:54:57
  from 'module:pslanguageselectorpslangu' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64622ba1ee4cf9_78588963',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1c00f78dace25d509ec3a1f54176b7ae2000accf' => 
    array (
      0 => 'module:pslanguageselectorpslangu',
      1 => 1680526196,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64622ba1ee4cf9_78588963 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="_desktop_language_selector">
  <div class="language-selector-wrapper">
    <span id="language-selector-label" class="hidden-md-up"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Language:','d'=>'Shop.Theme.Global'),$_smarty_tpl ) );?>
</span>
    <div class="language-selector dropdown js-dropdown">
      <button data-toggle="dropdown" class="hidden-sm-down btn-unstyle" aria-haspopup="true" aria-expanded="false" aria-label="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Language dropdown','d'=>'Shop.Theme.Global'),$_smarty_tpl ) );?>
">
        <span class="expand-more"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current_language']->value['name_simple'], ENT_QUOTES, 'UTF-8');?>
</span>
        <i class="material-icons expand-more"></i>
      </button>
      <ul class="dropdown-menu hidden-sm-down" aria-labelledby="language-selector-label">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['languages']->value, 'language');
$_smarty_tpl->tpl_vars['language']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->do_else = false;
?>
          <li <?php if ($_smarty_tpl->tpl_vars['language']->value['id_lang'] == $_smarty_tpl->tpl_vars['current_language']->value['id_lang']) {?> class="current" <?php }?>>
            <a href="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('entity'=>'language','id'=>$_smarty_tpl->tpl_vars['language']->value['id_lang']),$_smarty_tpl ) );?>
" class="dropdown-item"><img class="lang-flag" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['urls']->value['img_lang_url'], ENT_QUOTES, 'UTF-8');
echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['id_lang'], ENT_QUOTES, 'UTF-8');?>
.jpg"/></a>
          </li>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      </ul>
      <select class="link hidden-md-up" aria-labelledby="language-selector-label">
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['languages']->value, 'language');
$_smarty_tpl->tpl_vars['language']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->do_else = false;
?>
          <option value="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('entity'=>'language','id'=>$_smarty_tpl->tpl_vars['language']->value['id_lang']),$_smarty_tpl ) );?>
"<?php if ($_smarty_tpl->tpl_vars['language']->value['id_lang'] == $_smarty_tpl->tpl_vars['current_language']->value['id_lang']) {?> selected="selected"<?php }?>></option>
        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
      </select>
    </div>
  </div>
</div><?php }
}
