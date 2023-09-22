<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:07
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4078401262b57867e173a2-19832083%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6803e52f127763ffcfcf30305ca51021e35e2485' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/footer.tpl',
      1 => 1470857603,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4078401262b57867e173a2-19832083',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content_only' => 0,
    'right_column_size' => 0,
    'HOOK_RIGHT_COLUMN' => 0,
    'fullwidth_hook' => 0,
    'HOOK_FOOTER' => 0,
    'LEO_PANELTOOL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b57867e363f8_19927508',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b57867e363f8_19927508')) {function content_62b57867e363f8_19927508($_smarty_tpl) {?>
<?php if (!isset($_smarty_tpl->tpl_vars['content_only']->value)||!$_smarty_tpl->tpl_vars['content_only']->value) {?>
								
						</section>
						<?php if (isset($_smarty_tpl->tpl_vars['right_column_size']->value)&&!empty($_smarty_tpl->tpl_vars['right_column_size']->value)) {?>
						<!-- Right -->
						<section id="right_column" class="column sidebar col-md-<?php echo intval($_smarty_tpl->tpl_vars['right_column_size']->value);?>
">
								<?php echo $_smarty_tpl->tpl_vars['HOOK_RIGHT_COLUMN']->value;?>

						</section>
						<?php }?> 
				<?php if (isset($_smarty_tpl->tpl_vars['fullwidth_hook']->value['displayHome'])&&$_smarty_tpl->tpl_vars['fullwidth_hook']->value['displayHome']==0) {?>
					</div>
					</div>
				<?php } else { ?>
					</div>
				<?php }?>
            </section>
			<!-- Footer -->
			<footer id="footer" class="footer-container">       
				<?php if (isset($_smarty_tpl->tpl_vars['fullwidth_hook']->value['displayFooter'])&&$_smarty_tpl->tpl_vars['fullwidth_hook']->value['displayFooter']==0) {?>
				<div class="container">  	
				<?php }?>
						<?php echo $_smarty_tpl->tpl_vars['HOOK_FOOTER']->value;?>
							
				<?php if (isset($_smarty_tpl->tpl_vars['fullwidth_hook']->value['displayFooter'])&&$_smarty_tpl->tpl_vars['fullwidth_hook']->value['displayFooter']==0) {?>
				 
				</div>
				<?php }?>
            </footer>
		</section><!-- #page -->
<?php }?>
<p id="back-top">
	<a href="#top" title="<?php echo smartyTranslate(array('s'=>'Scroll To Top'),$_smarty_tpl);?>
"><i class="fa fa-angle-up"></i></a>
</p>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./global.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php if (isset($_smarty_tpl->tpl_vars['LEO_PANELTOOL']->value)&&$_smarty_tpl->tpl_vars['LEO_PANELTOOL']->value) {?>
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./info/paneltool.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
	</body>
</html><?php }} ?>
