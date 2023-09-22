<script type="text/javascript">
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
		{if $is_logged}
			<li><a class="logout" href="{$link->getPageLink('index', true, NULL, "mylogout")|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Log me out' mod='blockuserinfo'}">
				{*<i class="fa fa-unlock-alt"></i>*}{l s='Sign out' mod='blockuserinfo'}
			</a></li>
		{else}
			<li>
				<a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='My account' mod='blockuserinfo'}"><i class="fa fa-user"></i><span>{l s='Account' mod='blockuserinfo'}</span></a>
			</li>
		{/if}

		<li class="liwishlist"><a class="ap-btn-wishlist" id="wishlist-total" href="{$link->getModuleLink('blockwishlist', 'mywishlist', array(), true)|addslashes}" title="{l s='My wishlists' mod='blockuserinfo'}">
				<i class="fa fa-heart"></i>
				{l s='WishList' mod='blockuserinfo'}
			</a>
		</li>
		{*<li>
			<a class="ap-btn-compare" href="{$link->getPageLink('products-comparison')|escape:'html':'UTF-8'}" title="{l s='Compare' mod='blockuserinfo'}" rel="nofollow">
				<i class="fa fa-compress"></i>{l s='Compare' mod='blockuserinfo'}
			</a>
		</li>*}

		{if $is_logged}
			<li>
				<a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='View my customer account' mod='blockuserinfo'}" class="account" rel="nofollow">
					<i class="fa fa-user"></i>
					<span>{l s='Hi' mod='blockuserinfo'}, {$cookie->customer_firstname} {$cookie->customer_lastname}</span></a>
			</li>
		{/if}
		</ul>
</div>	