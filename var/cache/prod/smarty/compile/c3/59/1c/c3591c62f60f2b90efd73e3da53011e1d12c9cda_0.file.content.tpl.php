<?php
/* Smarty version 3.1.47, created on 2023-05-15 14:57:33
  from '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/Backoffice/themes/default/template/content.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64622c3d5c9d14_28496745',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c3591c62f60f2b90efd73e3da53011e1d12c9cda' => 
    array (
      0 => '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/Backoffice/themes/default/template/content.tpl',
      1 => 1680526184,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64622c3d5c9d14_28496745 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="ajax_confirmation" class="alert alert-success hide"></div>
<div id="ajaxBox" style="display:none"></div>

<div class="row">
	<div class="col-lg-12">
		<?php if ((isset($_smarty_tpl->tpl_vars['content']->value))) {?>
			<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

		<?php }?>
	</div>
</div>
<?php }
}
