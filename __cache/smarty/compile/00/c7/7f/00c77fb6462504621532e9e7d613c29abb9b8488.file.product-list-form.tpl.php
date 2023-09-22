<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:24
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/sub/product/product-list-form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:214625163962b57878255538-57905564%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '00c77fb6462504621532e9e7d613c29abb9b8488' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/sub/product/product-list-form.tpl',
      1 => 1470858040,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '214625163962b57878255538-57905564',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'products' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b5787827f270_19978013',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b5787827f270_19978013')) {function content_62b5787827f270_19978013($_smarty_tpl) {?><div class="content_sortPagiBar clearfix">
	<div class="sortPagiBar clearfix row">					
			<div class="col-md-10 col-sm-8 col-xs-6">				
				<div class="sort">
				<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-sort.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

				<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./nbr-product-page.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
									
				</div>
			</div>
			<div class="product-compare col-md-2 col-sm-4 col-xs-6">
				<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-compare.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			</div>
    </div>
</div>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('products'=>$_smarty_tpl->tpl_vars['products']->value), 0);?>


<div class="content_sortPagiBar bottom-pagination-content">
	<div class="clearfix row">
		<div class="col-md-10 col-sm-8 col-xs-6">
			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./pagination.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('no_follow'=>1,'paginationId'=>'bottom'), 0);?>

		</div>
		<div class="product-compare col-md-2 col-sm-4 col-xs-6">
			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./product-compare.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('paginationId'=>'bottom'), 0);?>

		</div>
	</div>
</div><?php }} ?>
