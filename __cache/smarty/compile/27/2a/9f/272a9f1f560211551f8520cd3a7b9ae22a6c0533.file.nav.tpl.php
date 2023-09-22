<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:07
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/modules/blockuserinfo/nav.tpl" */ ?>
<?php /*%%SmartyHeaderCode:49582334562b57867d37e92-93910725%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '272a9f1f560211551f8520cd3a7b9ae22a6c0533' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/modules/blockuserinfo/nav.tpl',
      1 => 1470857793,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '49582334562b57867d37e92-93910725',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'is_logged' => 0,
    'link' => 0,
    'cookie' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b57867d69bb1_49795191',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b57867d69bb1_49795191')) {function content_62b57867d69bb1_49795191($_smarty_tpl) {?><script type="text/javascript">
/* Blockusreinfo */
	
$(document).ready( function(){
	if( $(window).width() < 991 ){
			 $(".header_user_info").addClass('popup-over');
			 $(".header_user_info ul").addClass('popup-content');
		}
		else{
			$(".header_user_info").removeClass('popup-over');
			 $(".header_user_info ul").removeClass('popup-content');
		}
	$(window).resize(function() {
		if( $(window).width() < 991 ){
			 $(".header_user_info").addClass('popup-over');
			 $(".header_user_info ul").addClass('popup-content');
		}
		else{
			$(".header_user_info").removeClass('popup-over');
			 $(".header_user_info ul").removeClass('popup-content');
		}
	});
});
</script>
<!-- Block user information module NAV  -->
<div class="header_user_info pull-right e-translate-top">
	<div data-toggle="dropdown" class="popup-title"><i class="fa fa-user"></i></span></div>	
		<ul class="clearfix">
		<?php if ($_smarty_tpl->tpl_vars['is_logged']->value) {?>
			<li><a class="logout" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('index',true,null,"mylogout"), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Log me out','mod'=>'blockuserinfo'),$_smarty_tpl);?>
">
				<?php echo smartyTranslate(array('s'=>'Sign out','mod'=>'blockuserinfo'),$_smarty_tpl);?>

			</a></li>
		<?php } else { ?>
			<li>
				<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'My account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
"><i class="fa fa-user"></i><span><?php echo smartyTranslate(array('s'=>'Account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
</span></a>
			</li>
		<?php }?>

		<li class="liwishlist"><a class="ap-btn-wishlist" id="wishlist-total" href="<?php echo addslashes($_smarty_tpl->tpl_vars['link']->value->getModuleLink('blockwishlist','mywishlist',array(),true));?>
" title="<?php echo smartyTranslate(array('s'=>'My wishlists','mod'=>'blockuserinfo'),$_smarty_tpl);?>
">
				<i class="fa fa-heart"></i>
				<?php echo smartyTranslate(array('s'=>'WishList','mod'=>'blockuserinfo'),$_smarty_tpl);?>

			</a>
		</li>
		

		<?php if ($_smarty_tpl->tpl_vars['is_logged']->value) {?>
			<li>
				<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'View my customer account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
" class="account" rel="nofollow">
					<i class="fa fa-user"></i>
					<span><?php echo smartyTranslate(array('s'=>'Hi','mod'=>'blockuserinfo'),$_smarty_tpl);?>
, <?php echo $_smarty_tpl->tpl_vars['cookie']->value->customer_firstname;?>
 <?php echo $_smarty_tpl->tpl_vars['cookie']->value->customer_lastname;?>
</span></a>
			</li>
		<?php }?>
		</ul>
</div>	<?php }} ?>
