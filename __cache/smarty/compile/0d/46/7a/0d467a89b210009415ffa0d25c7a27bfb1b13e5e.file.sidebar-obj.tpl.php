<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:23
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/sub/product/sidebar-obj.tpl" */ ?>
<?php /*%%SmartyHeaderCode:140169914762b578772172f4-15765930%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0d467a89b210009415ffa0d25c7a27bfb1b13e5e' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/sub/product/sidebar-obj.tpl',
      1 => 1470858040,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '140169914762b578772172f4-15765930',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'products' => 0,
    'product' => 0,
    'link' => 0,
    'page_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b57877250482_05999524',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b57877250482_05999524')) {function content_62b57877250482_05999524($_smarty_tpl) {?><ul class="products products-block">
    <?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value) {
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
        <li class="clearfix media">  
            <div class="product-block">
				<div class="product-container media" itemscope itemtype="https://schema.org/Product">
					 <a class="products-block-image img pull-left" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->product_link, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->legend, ENT_QUOTES, 'UTF-8', true);?>
">
						<img class="replace-2x img-responsive" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['product']->value->link_rewrite,$_smarty_tpl->tpl_vars['product']->value->id_image,'small_default'), ENT_QUOTES, 'UTF-8', true);?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->name, ENT_QUOTES, 'UTF-8', true);?>
" />
					 </a>
					<div class="media-body">
						<div class="product-content">
							<h5 class="name media-heading">
								<a class="product-name" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->product_link, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->name, ENT_QUOTES, 'UTF-8', true);?>
">
									<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate(htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['product']->value->name), ENT_QUOTES, 'UTF-8', true),25,'...');?>

								</a>
							</h5>
							<?php if ($_smarty_tpl->tpl_vars['page_name']->value!="product") {?>
								<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayProductListReviews','product'=>array('id_product'=>$_smarty_tpl->tpl_vars['product']->value->id)),$_smarty_tpl);?>

							<?php }?>
							<div class="product-description description"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate(strip_tags($_smarty_tpl->tpl_vars['product']->value->description_short),75,'...');?>
</div>
						</div>
					</div>
				</div> 
            </div>    
        </li>
    <?php } ?>
</ul><?php }} ?>
