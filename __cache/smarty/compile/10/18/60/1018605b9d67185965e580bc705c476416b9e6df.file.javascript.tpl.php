<?php /* Smarty version Smarty-3.1.19, created on 2022-07-28 17:55:33
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal/views/templates/_partials/javascript.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21519284962e2b175c7c670-53678424%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1018605b9d67185965e580bc705c476416b9e6df' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal/views/templates/_partials/javascript.tpl',
      1 => 1641581521,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21519284962e2b175c7c670-53678424',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'JSvars' => 0,
    'varName' => 0,
    'varValue' => 0,
    'JSscripts' => 0,
    'keyScript' => 0,
    'JSscriptAttributes' => 0,
    'attrName' => 0,
    'attrVal' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62e2b175c9bac8_60136837',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62e2b175c9bac8_60136837')) {function content_62e2b175c9bac8_60136837($_smarty_tpl) {?>

<script>
    <?php  $_smarty_tpl->tpl_vars['varValue'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['varValue']->_loop = false;
 $_smarty_tpl->tpl_vars['varName'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['JSvars']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['varValue']->key => $_smarty_tpl->tpl_vars['varValue']->value) {
$_smarty_tpl->tpl_vars['varValue']->_loop = true;
 $_smarty_tpl->tpl_vars['varName']->value = $_smarty_tpl->tpl_vars['varValue']->key;
?>
      var <?php echo $_smarty_tpl->tpl_vars['varName']->value;?>
 = <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['json_encode'][0][0]->jsonEncode($_smarty_tpl->tpl_vars['varValue']->value);?>
;
    <?php } ?>
</script>

<?php if (isset($_smarty_tpl->tpl_vars['JSscripts']->value)&&is_array($_smarty_tpl->tpl_vars['JSscripts']->value)&&false===empty($_smarty_tpl->tpl_vars['JSscripts']->value)) {?>
    <?php  $_smarty_tpl->tpl_vars['JSscriptAttributes'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['JSscriptAttributes']->_loop = false;
 $_smarty_tpl->tpl_vars['keyScript'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['JSscripts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['JSscriptAttributes']->key => $_smarty_tpl->tpl_vars['JSscriptAttributes']->value) {
$_smarty_tpl->tpl_vars['JSscriptAttributes']->_loop = true;
 $_smarty_tpl->tpl_vars['keyScript']->value = $_smarty_tpl->tpl_vars['JSscriptAttributes']->key;
?>
      <script>
          var script = document.querySelector('script[data-key="<?php echo $_smarty_tpl->tpl_vars['keyScript']->value;?>
"]');

          if (null == script) {
              var newScript = document.createElement('script');
              <?php  $_smarty_tpl->tpl_vars['attrVal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attrVal']->_loop = false;
 $_smarty_tpl->tpl_vars['attrName'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['JSscriptAttributes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attrVal']->key => $_smarty_tpl->tpl_vars['attrVal']->value) {
$_smarty_tpl->tpl_vars['attrVal']->_loop = true;
 $_smarty_tpl->tpl_vars['attrName']->value = $_smarty_tpl->tpl_vars['attrVal']->key;
?>
                newScript.setAttribute('<?php echo $_smarty_tpl->tpl_vars['attrName']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['attrVal']->value;?>
');
              <?php } ?>

              newScript.setAttribute('data-key', '<?php echo $_smarty_tpl->tpl_vars['keyScript']->value;?>
');
              document.body.appendChild(newScript);
          }
      </script>
    <?php } ?>
<?php }?>

<?php }} ?>
