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


$(function(){

  var cnt = 0;

   /* If there is no order confirmation after 6o seconds, display additional support info */
   function displaySupportInfo() {
      $('#ogone_support_info').show('slow');
   }

   function checkwaitingorder() {
         $.ajax({
             type:"POST",
             async:true,
             url:ogone_check_url,
             data: ogone_check_data,
             success:function (r){
                 if (r == 'ok') {
                     window.location.href = ogone_check_redirect;
                 }
             },
             error:function (r, x, y) {
                   console.log(r, x, y)
             }
         });
      cnt = cnt + 1;
      window.setTimeout(checkwaitingorder, ogone_check_delay + (cnt * cnt * 100) );
      }

     window.setTimeout(displaySupportInfo, ogone_support_info_display_delay);
     window.setTimeout(checkwaitingorder, ogone_check_delay);

});
