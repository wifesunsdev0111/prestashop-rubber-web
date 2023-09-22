/**
* 2007-2017 PrestaShop
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
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2017 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/


$(function() {

   if (typeof prestashop == 'undefined') {
     if (typeof findCombination != 'undefined') {
       var findCombination_n = findCombination;
         findCombination = function() {findCombination_n();   updateSubscriptions(parseInt($('#idCombination').val(),10)); }
         updateSubscriptions(parseInt($('#idCombination').val(),10));
     }
   }
  var upd_launched = false;
  if ((typeof delete_add_to_cart !== 'undefined') && delete_add_to_cart) {
    $('.product-add-to-cart, #add_to_cart, #quantity_wanted_p').remove();
  }

  function updateSubscriptions(selected_id) {
    upd_launched = true;
    var selector = '#subscribe_info_' + selected_id.toString();
    $('.subscription_presentation_product').not(selector).hide();
    $(selector).show();
    if ($(selector).length == 0) {
      $('.no-combination').show();
    } else {
      $('.no-combination').hide();
    }
    upd_launched = false;
  }
  if (typeof prestashop != 'undefined') {
    prestashop.on('updatedProduct', function(event) {
      if (event && event.id_product_attribute && !upd_launched) {
        updateSubscriptions(event.id_product_attribute);
      } // if
    });
  } else {
 /*  $(".attribute_select,.attribute_radio,.color_pick,#color_to_pick_list,.attribute_list").on("change", function(){
     console.log(this, $('#idCombination').val(), parseInt($('#idCombination').val(),10));
          updateSubscriptions(parseInt($('#idCombination').val(),10));
   });*/

  }
});