<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:15
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/modules/blockwishlist/blockwishlist_button.tpl" */ ?>
<?php /*%%SmartyHeaderCode:166396450262b5786f7f6427-33181382%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cae6ecb34e6fd93dc60bdc51ac758cbcf400d5b9' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/modules/blockwishlist/blockwishlist_button.tpl',
      1 => 1470857799,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '166396450262b5786f7f6427-33181382',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'wishlists' => 0,
    'product' => 0,
    'wishlist' => 0,
    'id_product' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b5786f81c654_75967115',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b5786f81c654_75967115')) {function content_62b5786f81c654_75967115($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['wishlists']->value)&&count($_smarty_tpl->tpl_vars['wishlists']->value)>1) {?>
	<div class="wishlist">
		<?php  $_smarty_tpl->tpl_vars['wishlist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['wishlist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['wishlists']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['wishlist']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['wishlist']->iteration=0;
 $_smarty_tpl->tpl_vars['wishlist']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['wishlist']->key => $_smarty_tpl->tpl_vars['wishlist']->value) {
$_smarty_tpl->tpl_vars['wishlist']->_loop = true;
 $_smarty_tpl->tpl_vars['wishlist']->iteration++;
 $_smarty_tpl->tpl_vars['wishlist']->index++;
 $_smarty_tpl->tpl_vars['wishlist']->first = $_smarty_tpl->tpl_vars['wishlist']->index === 0;
 $_smarty_tpl->tpl_vars['wishlist']->last = $_smarty_tpl->tpl_vars['wishlist']->iteration === $_smarty_tpl->tpl_vars['wishlist']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['wl']['first'] = $_smarty_tpl->tpl_vars['wishlist']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['wl']['last'] = $_smarty_tpl->tpl_vars['wishlist']->last;
?>
			<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['wl']['first']) {?>
				<a class="wishlist_button_list btn btn-outline" data-link="<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
" tabindex="0" data-toggle="popover" data-trigger="focus" title="<?php echo smartyTranslate(array('s'=>'Wishlist','mod'=>'blockwishlist'),$_smarty_tpl);?>
" data-placement="top">
					<i class="fa fa fa-heart-o"></i> <span><?php echo smartyTranslate(array('s'=>'Add to wishlist','mod'=>'blockwishlist'),$_smarty_tpl);?>
</span>
				</a>
					<div hidden class="popover-content">
						<table class="table" border="0">
							<tbody>
			<?php }?>
								<tr title="<?php echo $_smarty_tpl->tpl_vars['wishlist']->value['name'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['wishlist']->value['id_wishlist'];?>
" onclick="WishlistCart('wishlist_block_list', 'add', '<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
', false, 1, '<?php echo $_smarty_tpl->tpl_vars['wishlist']->value['id_wishlist'];?>
');">
									<td>
										<?php echo smartyTranslate(array('s'=>'%s','sprintf'=>array($_smarty_tpl->tpl_vars['wishlist']->value['name']),'mod'=>'blockwishlist'),$_smarty_tpl);?>

									</td>
								</tr>
			<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['wl']['last']) {?>
						</tbody>
					</table>
				</div>
			<?php }?>
		<?php }
if (!$_smarty_tpl->tpl_vars['wishlist']->_loop) {
?>
			<a class="btn btn-outline" href="#" id="wishlist_button_nopop" data-link="<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
" onclick="WishlistCart('wishlist_block_list', 'add', '<?php echo intval($_smarty_tpl->tpl_vars['id_product']->value);?>
', $('#idCombination').val(), document.getElementById('quantity_wanted').value); return false;" title="<?php echo smartyTranslate(array('s'=>'Add to my wishlist','mod'=>'blockwishlist'),$_smarty_tpl);?>
">
				<i class="fa fa-heart"></i> <span><?php echo smartyTranslate(array('s'=>'Add to wishlist','mod'=>'blockwishlist'),$_smarty_tpl);?>
</span>
			</a>
		<?php } ?>
	</div>
<?php } else { ?>
	
		<a class="btn btn-outline addToWishlist wishlistProd_<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
" data-link="<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
" href="#" onclick="WishlistCart('wishlist_block_list', 'add', '<?php echo intval($_smarty_tpl->tpl_vars['product']->value['id_product']);?>
', false, 1); return false;" title="<?php echo smartyTranslate(array('s'=>'Add to my wishlist','mod'=>'blockwishlist'),$_smarty_tpl);?>
">
			<i class="fa fa-heart"></i> <span><?php echo smartyTranslate(array('s'=>"Add to Wishlist",'mod'=>'blockwishlist'),$_smarty_tpl);?>
</span>
		</a>	
	
<?php }?><?php }} ?>
