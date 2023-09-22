<?php
/* Smarty version 3.1.47, created on 2023-07-30 01:12:09
  from '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/modules/hipay_enterprise/views/templates/front/partial/cc.hidden.inputs.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64c59cc90d99c4_71166456',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5156a487673af205bd15e66ca425cba04f4fde91' => 
    array (
      0 => '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/modules/hipay_enterprise/views/templates/front/partial/cc.hidden.inputs.tpl',
      1 => 1680526194,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64c59cc90d99c4_71166456 (Smarty_Internal_Template $_smarty_tpl) {
?><input id="card-token" type='hidden' name='card-token' value=''/>
<input id="card-brand" type='hidden' name='card-brand' value=''/>
<input id="card-pan" type='hidden' name='card-pan' value=''/>
<input id="card-holder" type='hidden' name='card-holder' value=''/>
<input id="card-expiry-month" type='hidden' name='card-expiry-month' value=''/>
<input id="card-expiry-year" type='hidden' name='card-expiry-year' value=''/>
<input id="card-issuer" type='hidden' name='card-issuer' value=''/>
<input id="card-country" type='hidden' name='card-country' value=''/>
<input id="ioBB" type="hidden" name="ioBB">
<input id="browserInfo" type="hidden" name="browserInfo">
<?php }
}
