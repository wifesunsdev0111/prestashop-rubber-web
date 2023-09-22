<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:04
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal/views/js/paypal.js" */ ?>
<?php /*%%SmartyHeaderCode:166593704062b57864d26ef2-96160640%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8a742f98023bcc697aa046ff0103fa883b3f3ddb' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal/views/js/paypal.js',
      1 => 1641581521,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '166593704062b57864d26ef2-96160640',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ssl_enabled' => 0,
    'paypal_authorization' => 0,
    'paypal_confirmation' => 0,
    'paypal_order_opc' => 0,
    'id_cart' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b57864d54f75_07356219',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b57864d54f75_07356219')) {function content_62b57864d54f75_07356219($_smarty_tpl) {?>/*
 *
 *  2007-2021 PayPal
 *
 *  NOTICE OF LICENSE
 *
 *  This source file is subject to the Academic Free License (AFL 3.0)
 *  that is bundled with this package in the file LICENSE.txt.
 *  It is also available through the world-wide-web at this URL:
 *  http://opensource.org/licenses/afl-3.0.php
 *  If you did not receive a copy of the license and are unable to
 *  obtain it through the world-wide-web, please send an email
 *  to license@prestashop.com so we can send you a copy immediately.
 *
 *  DISCLAIMER
 *
 *  Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 *  versions in the future. If you wish to customize PrestaShop for your
 *  needs please refer to http://www.prestashop.com for more information.
 *
 *  @author 2007-2021 PayPal
 *  @author 202 ecommerce <tech@202-ecommerce.com>
 *  @copyright PayPal
 *  @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 */


    

function updateFormDatas()
{
	var nb = $('#quantity_wanted').val();
	var id = $('#idCombination').val();

	$('.paypal_payment_form input[name=quantity]').val(nb);
	$('.paypal_payment_form input[name=id_p_attr]').val(id);
}
	
$(document).ready( function() {
    
	<?php if ($_smarty_tpl->tpl_vars['ssl_enabled']->value) {?>
	var baseDirPP = baseDir.replace('http:', 'https:');
	<?php } else { ?>
	var baseDirPP = baseDir;
	<?php }?>
	
	if($('#in_context_checkout_enabled').val() != 1)
	{
        $(document).on('click','#payment_paypal_express_checkout', function() {
			$('#paypal_payment_form_cart').submit();
			return false;
		});
	}


	var jquery_version = $.fn.jquery.split('.');
	if(jquery_version[0]>=1 && jquery_version[1] >= 7)
	{
		$('body').on('submit',".paypal_payment_form", function () {
			updateFormDatas();
		});
	}
	else {
		$('.paypal_payment_form').live('submit', function () {
			updateFormDatas();
		});
	}

	function displayExpressCheckoutShortcut() {
		var id_product = $('input[name="id_product"]').val();
		var id_product_attribute = $('input[name="id_product_attribute"]').val();
		$.ajax({
			type: "GET",
			url: baseDirPP+'/modules/paypal/express_checkout/ajax.php',
			data: { get_qty: "1", id_product: id_product, id_product_attribute: id_product_attribute },
			cache: false,
			success: function(result) {
				if (result == '1') {
					$('#container_express_checkout').slideDown();
				} else {
					$('#container_express_checkout').slideUp();
				}
				return true;
			}
		});
	}

	$('select[name^="group_"]').change(function () {
		setTimeout(function(){displayExpressCheckoutShortcut()}, 500);
	});

	$('.color_pick').click(function () {
		setTimeout(function(){displayExpressCheckoutShortcut()}, 500);
	});

    if($('body#product').length > 0) {
        setTimeout(function(){displayExpressCheckoutShortcut()}, 500);
    }
	
	
	<?php if (isset($_smarty_tpl->tpl_vars['paypal_authorization']->value)) {?>
	
	
		/* 1.5 One page checkout*/
		var qty = $('.qty-field.cart_quantity_input').val();
		$('.qty-field.cart_quantity_input').after(qty);
		$('.qty-field.cart_quantity_input, .cart_total_bar, .cart_quantity_delete, #cart_voucher *').remove();
		
		var br = $('.cart > a').prev();
		br.prev().remove();
		br.remove();
		$('.cart.ui-content > a').remove();
		
		var gift_fieldset = $('#gift_div').prev();
		var gift_title = gift_fieldset.prev();
		$('#gift_div, #gift_mobile_div').remove();
		gift_fieldset.remove();
		gift_title.remove();
		
	
	<?php }?>
	<?php if (isset($_smarty_tpl->tpl_vars['paypal_confirmation']->value)) {?>
	
		
		$('#container_express_checkout').hide();
		if(jquery_version[0] >= 1 && jquery_version[1] >= 7)
		{
			$('body').on('click',"#cgv", function () {
				if ($('#cgv:checked').length != 0)
					$(location).attr('href', '<?php echo $_smarty_tpl->tpl_vars['paypal_confirmation']->value;?>
');
			});
		}
		else {
			$('#cgv').live('click', function () {
				if ($('#cgv:checked').length != 0)
					$(location).attr('href', '<?php echo $_smarty_tpl->tpl_vars['paypal_confirmation']->value;?>
');
			});

			/* old jQuery compatibility */
			$('#cgv').click(function () {
				if ($('#cgv:checked').length != 0)
					$(location).attr('href', '<?php echo $_smarty_tpl->tpl_vars['paypal_confirmation']->value;?>
');
			});
		}

	
	<?php } elseif (isset($_smarty_tpl->tpl_vars['paypal_order_opc']->value)) {?>

	


		var jquery_version = $.fn.jquery.split('.');
		if(jquery_version[0]>=1 && jquery_version[1] >= 7)
		{
			$('body').on('click','#cgv', function() {
				if ($('#cgv:checked').length != 0)
					checkOrder();
			});
		}
		else
		{
			$('#cgv').live('click', function() {
				if ($('#cgv:checked').length != 0)
					checkOrder();
			});

			/* old jQuery compatibility */
			$('#cgv').click(function() {
				if ($('#cgv:checked').length != 0)
					checkOrder();
			});
		}

	

	<?php }?>
	

	var modulePath = 'modules/paypal';
	var subFolder = '/integral_evolution';

	var fullPath = baseDirPP + modulePath + subFolder;
	var confirmTimer = false;
		
	if ($('form[target="hss_iframe"]').length == 0) {
		if ($('select[name^="group_"]').length > 0)
			displayExpressCheckoutShortcut();
		return false;
	} else {
		checkOrder();
	}

	function checkOrder() {
		if(confirmTimer == false)
			confirmTimer = setInterval(getOrdersCount, 1000);
	}

	<?php if (isset($_smarty_tpl->tpl_vars['id_cart']->value)) {?>
	function getOrdersCount() {


		$.get(
			fullPath + '/confirm.php',
			{ id_cart: '<?php echo $_smarty_tpl->tpl_vars['id_cart']->value;?>
' },
			function (data) {
				if ((typeof(data) != 'undefined') && (data > 0)) {
					clearInterval(confirmTimer);
					window.location.replace(fullPath + '/submit.php?id_cart=<?php echo $_smarty_tpl->tpl_vars['id_cart']->value;?>
');
					$('p.payment_module, p.cart_navigation').hide();
				}
			}
		);
	}
	<?php }?>
});


<?php }} ?>
