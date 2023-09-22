<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 11:37:53
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/cms.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5452105762b585f1b70192-76503505%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '466b587cd82cde4ed76ffc8ea625fd6d329d03ac' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/cms.tpl',
      1 => 1470857537,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5452105762b585f1b70192-76503505',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cms' => 0,
    'cms_category' => 0,
    'content_only' => 0,
    'base_dir' => 0,
    'link' => 0,
    'sub_category' => 0,
    'subcategory' => 0,
    'cms_pages' => 0,
    'cmspages' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b585f1c519d9_19930148',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b585f1c519d9_19930148')) {function content_62b585f1c519d9_19930148($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['cms']->value)&&!isset($_smarty_tpl->tpl_vars['cms_category']->value)) {?>
	<?php if (!$_smarty_tpl->tpl_vars['cms']->value->active) {?>
		<br />
		<div id="admin-action-cms">
			<p>
				<span><?php echo smartyTranslate(array('s'=>'This CMS page is not visible to your customers.'),$_smarty_tpl);?>
</span>
				<input type="hidden" id="admin-action-cms-id" value="<?php echo $_smarty_tpl->tpl_vars['cms']->value->id;?>
" />
				<input type="submit" value="<?php echo smartyTranslate(array('s'=>'Publish'),$_smarty_tpl);?>
" name="publish_button" class="button btn btn-outline"/>
				<input type="submit" value="<?php echo smartyTranslate(array('s'=>'Back'),$_smarty_tpl);?>
" name="lnk_view" class="button btn btn-outline"/>
			</p>
			<div class="clear" ></div>
			<p id="admin-action-result"></p>
		</div>
	<?php }?>
	<div class="rte<?php if ($_smarty_tpl->tpl_vars['content_only']->value) {?> content_only<?php }?>">
		<?php echo $_smarty_tpl->tpl_vars['cms']->value->content;?>

	</div>
<?php } elseif (isset($_smarty_tpl->tpl_vars['cms_category']->value)) {?>
	<div class="block-cms">
		<h1><a href="<?php if ($_smarty_tpl->tpl_vars['cms_category']->value->id==1) {?><?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['link']->value->getCMSCategoryLink($_smarty_tpl->tpl_vars['cms_category']->value->id,$_smarty_tpl->tpl_vars['cms_category']->value->link_rewrite);?>
<?php }?>"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cms_category']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</a></h1>
		<?php if ($_smarty_tpl->tpl_vars['cms_category']->value->description) {?>
			<p><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cms_category']->value->description, ENT_QUOTES, 'UTF-8', true);?>
</p>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['sub_category']->value)&&!empty($_smarty_tpl->tpl_vars['sub_category']->value)) {?>	
			<p class="title_block"><?php echo smartyTranslate(array('s'=>'List of sub categories in %s:','sprintf'=>$_smarty_tpl->tpl_vars['cms_category']->value->name),$_smarty_tpl);?>
</p>
			<ul class="bullet list-group">
				<?php  $_smarty_tpl->tpl_vars['subcategory'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['subcategory']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['sub_category']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['subcategory']->key => $_smarty_tpl->tpl_vars['subcategory']->value) {
$_smarty_tpl->tpl_vars['subcategory']->_loop = true;
?>
					<li>
						<a class="list-group-item" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCMSCategoryLink($_smarty_tpl->tpl_vars['subcategory']->value['id_cms_category'],$_smarty_tpl->tpl_vars['subcategory']->value['link_rewrite']), ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['subcategory']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</a>
					</li>
				<?php } ?>
			</ul>
		<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['cms_pages']->value)&&!empty($_smarty_tpl->tpl_vars['cms_pages']->value)) {?>
		<p class="title_block"><?php echo smartyTranslate(array('s'=>'List of pages in %s:','sprintf'=>$_smarty_tpl->tpl_vars['cms_category']->value->name),$_smarty_tpl);?>
</p>
			<ul class="bullet list-group">
				<?php  $_smarty_tpl->tpl_vars['cmspages'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cmspages']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cms_pages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cmspages']->key => $_smarty_tpl->tpl_vars['cmspages']->value) {
$_smarty_tpl->tpl_vars['cmspages']->_loop = true;
?>
					<li>
						<a class="list-group-item" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCMSLink($_smarty_tpl->tpl_vars['cmspages']->value['id_cms'],$_smarty_tpl->tpl_vars['cmspages']->value['link_rewrite']), ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cmspages']->value['meta_title'], ENT_QUOTES, 'UTF-8', true);?>
</a>
					</li>
				<?php } ?>
			</ul>
		<?php }?>
	</div>
<?php } else { ?>
	<div class="alert alert-danger">
		<?php echo smartyTranslate(array('s'=>'This page does not exist.'),$_smarty_tpl);?>

	</div>
<?php }?>
<br />
<?php if (isset($_GET['ad'])&&$_GET['ad']) {?><?php $_smarty_tpl->smarty->_tag_stack[] = array('addJsDefL', array('name'=>'ad')); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'ad'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<?php echo htmlspecialchars(($_smarty_tpl->tpl_vars['base_dir']->value).($_GET['ad']), ENT_QUOTES, 'UTF-8', true);?>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'ad'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php }?><?php if (isset($_GET['adtoken'])&&$_GET['adtoken']) {?><?php $_smarty_tpl->smarty->_tag_stack[] = array('addJsDefL', array('name'=>'adtoken')); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'adtoken'), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<?php echo htmlspecialchars($_GET['adtoken'], ENT_QUOTES, 'UTF-8', true);?>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['addJsDefL'][0][0]->addJsDefL(array('name'=>'adtoken'), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php }?>
<?php }} ?>
