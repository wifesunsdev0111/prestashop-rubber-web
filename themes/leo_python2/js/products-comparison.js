/*
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
$(document).ready(function(){
	$(document).on('click', '.add_to_compare', function(e){
		e.preventDefault();
		//Leotheme edit: add product name when add to compare
		if (typeof addToCompare != 'undefined')
			addToCompare(parseInt($(this).data('id-product')),$.trim($(this).parents('.product-container').find('.product-name').html()));
		
	});

	reloadProductComparison();
	compareButtonsStatusRefresh();
	totalCompareButtons();
});

//Leotheme edit: add product name when add to compare
function addToCompare(productId, productName)
{
	var totalValueNow = parseInt($('.bt_compare').next('.compare_product_count').val());
	var action, totalVal;
	//Leotheme add: get url of compare page for popup
	var url_list_comapre = mywishlist_url.replace('module/blockwishlist/mywishlist','');
	if ($.inArray(parseInt(productId),comparedProductsIds) === -1)
		action = 'add';
	else
		action = 'remove';

	$.ajax({
		url: baseUri + '?controller=products-comparison&ajax=1&action=' + action + '&id_product=' + productId,
		async: true,
		cache: false,
		success: function(data) {
			if (action === 'add' && comparedProductsIds.length < comparator_max_item) {
				comparedProductsIds.push(parseInt(productId)),
				compareButtonsStatusRefresh(),
				totalVal = totalValueNow +1,
				$('.bt_compare').next('.compare_product_count').val(totalVal),
				totalValue(totalVal);	
				//Leotheme add: update number product on icon compare		
				var old_num_compare = parseInt($('.ap-btn-compare .ap-total-compare').text());
				$('.ap-btn-compare .ap-total-compare').text(old_num_compare+1);	
				//Leotheme add: create content for popup after add compare	
				var content_alert = 'The product <strong>'+productName+'</strong> has been added to list compare. <a href="'+url_list_comapre+'products-comparison"><strong>Click to view list compare</strong></a>';
				if (!!$.prototype.fancybox)
					$.fancybox.open([{
						type: 'inline',
						autoScale: true,
						minHeight: 30,
						content: '<p class="fancybox-error">' + content_alert + '</p>'
					}], {
						padding: 0
					});
				else
					alert(content_alert);
				
			}
			else if (action === 'remove') {
				comparedProductsIds.splice($.inArray(parseInt(productId), comparedProductsIds), 1),
				compareButtonsStatusRefresh(),
				totalVal = totalValueNow -1,
				$('.bt_compare').next('.compare_product_count').val(totalVal),
				totalValue(totalVal);
				//Leotheme add: update number product on icon compare	
				var old_num_compare = parseInt($('.ap-btn-compare .ap-total-compare').text());
				$('.ap-btn-compare .ap-total-compare').text(old_num_compare-1);
				//Leotheme add: create content for popup after remove from compare				
				var content_alert = 'The product <strong>'+productName+'</strong> has been removed from list compare. <a href="'+url_list_comapre+'products-comparison"><strong>Click to view list compare</strong></a>';
				if (!!$.prototype.fancybox)
					$.fancybox.open([{
						type: 'inline',
						autoScale: true,
						minHeight: 30,
						content: '<p class="fancybox-error">' + content_alert + '</p>'
					}], {
						padding: 0
					});
				else
					alert(content_alert);
				
			}
			else
			{				
				if (!!$.prototype.fancybox)
					$.fancybox.open([{
						type: 'inline',
						autoScale: true,
						minHeight: 30,
						content: '<p class="fancybox-error">' + max_item + '</p>'
					}], {
						padding: 0
					});
				else
					alert(max_item);
			}
			totalCompareButtons();
		},
		error: function(){}
	});
}

function reloadProductComparison()
{
	$(document).on('click', 'a.cmp_remove', function(e){
		e.preventDefault();
		var idProduct = parseInt($(this).data('id-product'));
		$.ajax({
			url: baseUri + '?controller=products-comparison&ajax=1&action=remove&id_product=' + idProduct,
			async: false,
			cache: false
		});
		$('td.product-' + idProduct).fadeOut(600);

		var compare_product_list = get('compare_product_list');
		var bak = compare_product_list;
		var new_compare_product_list = [];
		compare_product_list = decodeURIComponent(compare_product_list).split('|');
		for (var i in compare_product_list)
			if (parseInt(compare_product_list[i]) != idProduct)
				new_compare_product_list.push(compare_product_list[i]);
		if (new_compare_product_list.length)
			window.location.search = window.location.search.replace(bak, new_compare_product_list.join(encodeURIComponent('|')));
	});
};

function compareButtonsStatusRefresh()
{
	$('.add_to_compare').each(function() {
		if ($.inArray(parseInt($(this).data('id-product')), comparedProductsIds) !== -1)
			$(this).addClass('checked');
		else
			$(this).removeClass('checked');
	});
}

function totalCompareButtons()
{
	var totalProductsToCompare = parseInt($('.bt_compare .total-compare-val').html());
	if (typeof totalProductsToCompare !== "number" || totalProductsToCompare === 0)
		$('.bt_compare').attr("disabled",true);
	else
		$('.bt_compare').attr("disabled",false);
}

function totalValue(value)
{
	$('.bt_compare').find('.total-compare-val').html(value);
}

function get(name)
{
	var regexS = "[\\?&]" + name + "=([^&#]*)";
	var regex = new RegExp(regexS);
	var results = regex.exec(window.location.search);

	if (results == null)
		return "";
	else
		return results[1];
}
