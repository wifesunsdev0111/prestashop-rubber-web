<?php
/* Smarty version 3.1.47, created on 2023-05-15 14:58:06
  from 'module:aeiimagesliderviewstempla' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64622c5e2cee31_50941754',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f6ac4522ba9dffd8990fc7cb28421c83923bd245' => 
    array (
      0 => 'module:aeiimagesliderviewstempla',
      1 => 1680526194,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64622c5e2cee31_50941754 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '115171266964622c5e2c97c4_86304665';
?>
<div class="slider-menu">
<?php if ($_smarty_tpl->tpl_vars['aeihomeslider']->value['slides']) {?>
<div id="slideshow">
	<div class="slideshow-container" data-interval="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['aeihomeslider']->value['speed'], ENT_QUOTES, 'UTF-8');?>
" data-wrap="true"  data-pause="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['aeihomeslider']->value['pause'], ENT_QUOTES, 'UTF-8');?>
">
		<div class="loadingdiv spinner"></div>
		<ul class="slides aeisliders">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['aeihomeslider']->value['slides'], 'slide');
$_smarty_tpl->tpl_vars['slide']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['slide']->value) {
$_smarty_tpl->tpl_vars['slide']->do_else = false;
?>
				<li class="slide">
					<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['url'], ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['legend'], ENT_QUOTES, 'UTF-8');?>
">
					<img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['image_url'], ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['legend'], ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['title'], ENT_QUOTES, 'UTF-8');?>
" />
					</a>
					<?php if ($_smarty_tpl->tpl_vars['slide']->value['title'] || $_smarty_tpl->tpl_vars['slide']->value['description']) {?>
					<span class="slider-text caption">	
						<h2><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide']->value['title'], ENT_QUOTES, 'UTF-8');?>
</h2>
						<div class="caption-description">
							<?php echo $_smarty_tpl->tpl_vars['slide']->value['description'];?>

						</div>
					</span>	
					<?php }?>					
				</li>
			<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
		</ul>
	</div>
</div>
<?php }?>
</div>

<?php }
}
