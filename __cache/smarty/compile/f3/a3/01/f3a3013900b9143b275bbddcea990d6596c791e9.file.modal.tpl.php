<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:39:42
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/Backoffice/themes/default/template/helpers/modules_list/modal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:204684052862b5784ead6e40-02627150%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f3a3013900b9143b275bbddcea990d6596c791e9' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/Backoffice/themes/default/template/helpers/modules_list/modal.tpl',
      1 => 1575969816,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '204684052862b5784ead6e40-02627150',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b5784eadb712_24877121',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b5784eadb712_24877121')) {function content_62b5784eadb712_24877121($_smarty_tpl) {?><div class="modal fade" id="modules_list_container">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title"><?php echo smartyTranslate(array('s'=>'Recommended Modules and Services'),$_smarty_tpl);?>
</h3>
			</div>
			<div class="modal-body">
				<div id="modules_list_container_tab_modal" style="display:none;"></div>
				<div id="modules_list_loader"><i class="icon-refresh icon-spin"></i></div>
			</div>
		</div>
	</div>
</div>
<?php }} ?>
