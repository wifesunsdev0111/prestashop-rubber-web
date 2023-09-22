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

const Ingenico3Ds = {
    setEnvironment: function () {
        const data = Ingenico3Ds.getBrowserData();
        for (let elem in data) {
            Ingenico3Ds.setCookie(elem, data[elem], 2);
        }
    },

    getBrowserData: function () {
        return {
            'browserColorDepth': window.screen.colorDepth,
            'browserJavaEnabled': navigator.javaEnabled(),
            'browserLanguage': navigator.language,
            'browserScreenHeight': window.screen.height,
            'browserScreenWidth': window.screen.width,
            'browserTimeZone': (new Date()).getTimezoneOffset()
        };
    },

    setCookie: function(name, value, days) {
        let d = new Date;
        d.setTime(d.getTime() + 24*60*60*1000*days);
        document.cookie = name + "=" + value + ";path=/;expires=" + d.toGMTString();
    }
};

$(function(){
    Ingenico3Ds.setEnvironment();

    var id = null;
    if(typeof prestashop != 'undefined') {




    $(".alias_trigger_creditcard").click(function(){
      if ($(".alias_holder_creditcard:visible").length == 1){
         $(".alias_trigger_creditcard").text(alias_holder_hidden_txt);
         $(".alias_holder_creditcard").hide();
      } else {
         $(".alias_trigger_creditcard").text(alias_holder_displayed_txt);
         $(".alias_holder_creditcard").show();
      }
    });
  $(".alias_trigger_directdebitde").click(function(){
      if ($(".alias_holder_directdebitde:visible").length == 1){
         $(".alias_trigger_directdebitde").text(alias_holder_hidden_txt);
         $(".alias_holder_directdebitde").hide();
      } else {
         $(".alias_trigger_directdebitde").text(alias_holder_displayed_txt);
         $(".alias_holder_directdebitde").show();
          }
  });
  $(".alias_trigger_directdebitnl").click(function(){
      if ($(".alias_holder_directdebitnl:visible").length == 1){
         $(".alias_trigger_directdebitnl").text(alias_holder_hidden_txt);
         $(".alias_holder_directdebitnl").hide();
      } else {
         $(".alias_trigger_directdebitnl").text(alias_holder_displayed_txt);
         $(".alias_holder_directdebitnl").show();
          }
  });
  $(".alias_trigger_directdebitat").click(function(){
      if ($(".alias_holder_directdebitat:visible").length == 1){
         $(".alias_trigger_directdebitat").text(alias_holder_hidden_txt);
         $(".alias_holder_directdebitat").hide();
      } else {
         $(".alias_trigger_directdebitat").text(alias_holder_displayed_txt);
         $(".alias_holder_directdebitat").show();
          }
  });

      $('.oaip').click(function(event){
        var cd_checked = $('INPUT#conditions_to_approve\\[terms-and-conditions\\]:checked').length == 1;
        if (!cd_checked) {
            event.stopPropagation();
            alert(accept_conditions_txt);
            return false;
        }
      });
      $('.oaip').mouseover(
          function(){$('#payment-confirmation button').attr("disabled", true).removeClass('btn-primary').addClass('btn-secondary').hide();

      })
      $('.oaip').mouseout(function(){$('#payment-confirmation button').addClass('btn-primary').removeClass('btn-secondary').show();
      if ($('INPUT#conditions_to_approve\\[terms-and-conditions\\]:checked').length == 1) {
        $('#payment-confirmation button').attr("disabled", false);
      }

      })
      $('.ogone_alias_button').click(function(){
         if ($('INPUT#conditions_to_approve\\[terms-and-conditions\\]:checked').length == 1) {
           document.forms[$(this).data('ogtarget')].submit();
          }

      })

      if ($('INPUT[name=SUB_AMOUNT]').parents('.js-payment-option-form').attr('id')) {
         id = $('INPUT[name=SUB_AMOUNT]').parents('.js-payment-option-form').attr('id').split('-')[4]
      }
      if (id) {
        $('.payment-option').not('#payment-option-'+id+'-container').remove();
      }
     } else {
       if ($('#ogone_sub_block').length > 0) {
         $('.payment_module').not('#ogone_sub_block').remove();
       }
     }
    $(".ogone_cvc_holder").unbind("click").click(function(e) {
      e.stopPropagation();
      return false;
   })



  });