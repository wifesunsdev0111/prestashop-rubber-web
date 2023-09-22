<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:24
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/category.tpl" */ ?>
<?php /*%%SmartyHeaderCode:109824879462b57878181085-65889590%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5d50d7021bf7aaab49a11fceae0b98b52003e040' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/category.tpl',
      1 => 1470857536,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '109824879462b57878181085-65889590',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'category' => 0,
    'subcategories' => 0,
    'products' => 0,
    'scenes' => 0,
    'description_short' => 0,
    'link' => 0,
    'display_subcategories' => 0,
    'subcategory' => 0,
    'img_cat_dir' => 0,
    'lang_iso' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b578781e5c61_94003340',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b578781e5c61_94003340')) {function content_62b578781e5c61_94003340($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php if (isset($_smarty_tpl->tpl_vars['category']->value)) {?>
	<?php if ($_smarty_tpl->tpl_vars['category']->value->id&&$_smarty_tpl->tpl_vars['category']->value->active) {?>
		<h1 class="page-heading<?php if ((isset($_smarty_tpl->tpl_vars['subcategories']->value)&&!$_smarty_tpl->tpl_vars['products']->value)||(isset($_smarty_tpl->tpl_vars['subcategories']->value)&&$_smarty_tpl->tpl_vars['products']->value)||!isset($_smarty_tpl->tpl_vars['subcategories']->value)&&$_smarty_tpl->tpl_vars['products']->value) {?> product-listing<?php }?>">
	
            
		</h1>
    	<?php if ($_smarty_tpl->tpl_vars['scenes']->value||$_smarty_tpl->tpl_vars['category']->value->description||$_smarty_tpl->tpl_vars['category']->value->id_image) {?>
			<div class="content_scene_cat">
            	 <?php if ($_smarty_tpl->tpl_vars['scenes']->value) {?>
                 	<div class="content_scene">
                        <!-- Scenes -->
                        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./scenes.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('scenes'=>$_smarty_tpl->tpl_vars['scenes']->value), 0);?>

                        <?php if ($_smarty_tpl->tpl_vars['category']->value->description) {?>
                            <div class="cat-desc rte">
                            <?php if (Tools::strlen($_smarty_tpl->tpl_vars['category']->value->description)>350) {?>
                                <div id="category_description_short"><?php echo $_smarty_tpl->tpl_vars['description_short']->value;?>
</div>
                                <div id="category_description_full" class="unvisible"><?php echo $_smarty_tpl->tpl_vars['category']->value->description;?>
</div>
                                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink($_smarty_tpl->tpl_vars['category']->value->id_category,$_smarty_tpl->tpl_vars['category']->value->link_rewrite), ENT_QUOTES, 'UTF-8', true);?>
" class="lnk_more"><?php echo smartyTranslate(array('s'=>'More'),$_smarty_tpl);?>
</a>
                            <?php } else { ?>
                                <div><?php echo $_smarty_tpl->tpl_vars['category']->value->description;?>
</div>
                            <?php }?>
                            </div>
                        <?php }?>
                    </div>
				<?php } else { ?>
                    <!-- Category image -->
                    <div class="content_scene_cat_bg scene_cat">
						<?php if ($_smarty_tpl->tpl_vars['category']->value->id_image) {?>
						<div class="image">
                    		<img class="img-responsive" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCatImageLink($_smarty_tpl->tpl_vars['category']->value->link_rewrite,$_smarty_tpl->tpl_vars['category']->value->id_image,'category_default'), ENT_QUOTES, 'UTF-8', true);?>
" alt="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->name, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" title="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->name, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" id="categoryImage"  /> 
						</div>
                    	<?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['category']->value->description) {?>
                            <div class="cat-desc">                            
                            <?php if (Tools::strlen($_smarty_tpl->tpl_vars['category']->value->description)>350) {?>
                                <div id="category_description_short" class="rte"><?php echo $_smarty_tpl->tpl_vars['description_short']->value;?>
</div>
                                <div id="category_description_full" class="unvisible rte"><?php echo $_smarty_tpl->tpl_vars['category']->value->description;?>
</div>
                                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink($_smarty_tpl->tpl_vars['category']->value->id_category,$_smarty_tpl->tpl_vars['category']->value->link_rewrite), ENT_QUOTES, 'UTF-8', true);?>
" class="lnk_more"><?php echo smartyTranslate(array('s'=>'More'),$_smarty_tpl);?>
</a>
                            <?php } else { ?>
                                <div class="rte"><?php echo $_smarty_tpl->tpl_vars['category']->value->description;?>
</div>
                            <?php }?>
                            </div>
                        <?php }?>
                     </div>
                  <?php }?>
            </div>
		<?php }?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./category-count.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

		<?php if (isset($_smarty_tpl->tpl_vars['subcategories']->value)) {?>
        <?php if ((isset($_smarty_tpl->tpl_vars['display_subcategories']->value)&&$_smarty_tpl->tpl_vars['display_subcategories']->value==1)||!isset($_smarty_tpl->tpl_vars['display_subcategories']->value)) {?>
		<!-- Subcategories -->
					
        <div id="subcategories">
			<div class="row">
			<?php  $_smarty_tpl->tpl_vars['subcategory'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['subcategory']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['subcategories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['subcategory']->key => $_smarty_tpl->tpl_vars['subcategory']->value) {
$_smarty_tpl->tpl_vars['subcategory']->_loop = true;
?>
				<div class="col-md-4 col-xs-6 col-sp-12">
                	<div class="subcategories scene_cat">
                		<div class="image">
							<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink($_smarty_tpl->tpl_vars['subcategory']->value['id_category'],$_smarty_tpl->tpl_vars['subcategory']->value['link_rewrite']), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['subcategory']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" class="img">
							<?php if ($_smarty_tpl->tpl_vars['subcategory']->value['id_image']) {?>
								<img class="replace-2x img-responsive" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCatImageLink($_smarty_tpl->tpl_vars['subcategory']->value['link_rewrite'],$_smarty_tpl->tpl_vars['subcategory']->value['id_image'],'category_default'), ENT_QUOTES, 'UTF-8', true);?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['subcategory']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
"/>
							<?php } else { ?>
								<img class="replace-2x img-responsive" src="<?php echo $_smarty_tpl->tpl_vars['img_cat_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['lang_iso']->value;?>
-default-category_default.jpg" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['subcategory']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
"/>
							<?php }?>
						</a>
                   		</div>
						<?php if ($_smarty_tpl->tpl_vars['subcategory']->value['description']) {?>
							<div class="cat-desc"><?php echo $_smarty_tpl->tpl_vars['subcategory']->value['description'];?>
</div>
						<?php }?>
					</div>
				</div>
			<?php } ?>
			</div>

		</div>
        <?php }?>
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['products']->value) {?>

			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./sub/product/product-list-form.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


		<?php }?>
	<?php } elseif ($_smarty_tpl->tpl_vars['category']->value->id) {?>
		<p class="alert alert-warning"><?php echo smartyTranslate(array('s'=>'This category is currently unavailable.'),$_smarty_tpl);?>
</p>
	<?php }?>
<?php }?>
<?php }} ?>
