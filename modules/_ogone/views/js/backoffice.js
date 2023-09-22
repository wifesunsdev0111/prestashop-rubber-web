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

    $('.ogone-tabs nav .tab-title').click(function(){
        var elem = $(this);
        var target = $(elem.data('target'));
        elem.addClass('active').siblings().removeClass('active');
        target.show().siblings().hide();
    })

    if ($('.ogone-tabs nav .tab-title.active').length == 0){
        $('.ogone-tabs nav .tab-title:first').trigger("click");
    }

    $("#preview_container").click(function(event){event.stopImmediatePropagation(); return false;})

    function updateOgonePreview(data, save_alert){
        var selectors1= ["td.ncolh1","td.ncoltxtl","td.ncoltxtl2","td.ncoltxtr","td.ncoltxtc","td.ncollogol","td.ncollogor","td.ncollogoc","td.ncoltxtmessage","td.ncolinput","td.ncolline1","td.ncolline2"];
        var selectors2= ["table.ncoltable1","table.ncoltable2","table.ncoltable3"];
        var selectors3= ["a","p"];
        var selectors4= ["input.ncol"];
        var $body = $(".ogone_preview_body");

        // var logo_img = 'https://secure.ogone.com/images/merchant/' +  data["OGONE_PSPID"] + '/' +  data["OGONE_LOGO"];
        var logo_img = data["OGONE_LOGO"];

        $body.css({"color": data["OGONE_TXTCOLOR"], "background-color" : data["OGONE_BGCOLOR"]});
        $body.find(".ogone_preview_title").css({"font-family" :  data["OGONE_FONTTYPE"]});
        $body.find(selectors1.join(',')).css({"background-color" : data["OGONE_TBLBGCOLOR"], "color" : data["OGONE_TBLTXTCOLOR"], "font-family" :  data["OGONE_FONTTYPE"]});
        $body.find(selectors2.join(',')).css({"background-color" : data["OGONE_TBLBGCOLOR"], "color" : data["OGONE_TBLTXTCOLOR"], "border" :  "1 solid " + data["OGONE_TBLTXTCOLOR"]});
        $body.find(selectors3.join(',')).css({"color" : data["OGONE_TBLTXTCOLOR"]});
        $body.find(selectors4.join(',')).css({"background-color" : data["OGONE_BUTTONBGCOLOR"],"color" : data["OGONE_BUTTONTXTCOLOR"], "font-family" :  data["OGONE_FONTTYPE"]});
        $body.find(".ogone_preview_title").css({"font-family" :  data["OGONE_FONTTYPE"]}).text(data["OGONE_TITLE"]);
        if (logo_img){
            $body.find(".ogone_logo").show();
        } else {
            $body.find(".ogone_logo").hide();
        }

    }
    function getOgonePreviewData(){
        return {
            "OGONE_TITLE" : $("INPUT[name=OGONE_TITLE]").val(),
            "OGONE_TXTCOLOR" : $("INPUT[name=OGONE_TXTCOLOR]").val(),
            "OGONE_BGCOLOR" : $("INPUT[name=OGONE_BGCOLOR]").val(),
            "OGONE_FONTTYPE" : $("SELECT[name=OGONE_FONTTYPE]").val(),
            "OGONE_TBLBGCOLOR" : $("INPUT[name=OGONE_TBLBGCOLOR]").val(),
            "OGONE_BUTTONBGCOLOR" : $("INPUT[name=OGONE_BUTTONBGCOLOR]").val(),
            "OGONE_BUTTONTXTCOLOR" : $("INPUT[name=OGONE_BUTTONTXTCOLOR]").val(),
            'OGONE_LOGO' : $("INPUT[name=OGONE_LOGO]").val(),
            'OGONE_PSPID' : $("INPUT[name=OGONE_PSPID]").val()
        };
    }

    $(".ogone_preview_trigger").change(function(){
        updateOgonePreview(getOgonePreviewData())
        $("#st_save_alert").show("slow");
    })

    updateOgonePreview(getOgonePreviewData());

    $(".ogone_acc").click(function(){
        var tgt_id = "#"+ $(this).data("acc-tgt");
        $(".ogone_acc_tgt").not(tgt_id).hide().removeClass("active");
        $(tgt_id).toggle().addClass("active");
    });

    $(".ogone_acc").each(function(){
        if ($(this).hasClass("ogone_hide")){
        var tgt_id = "#"+ $(this).data("acc-tgt");
        $(tgt_id).hide().removeClass("active");
        }
    });


    $( ".sortable" ).sortable({
        forcePlaceholderSize: true,
        stop: function () {
            $("input.curpos").each(function(idx) {
                $(this).val(idx);
            });
            $("#pm_save_alert").show("slow");

        }
    });
    $(".ogone_pm_list LI").click(function(){
        var $tgt = $(this).find("INPUT.status")
        $tgt.attr("checked", !$tgt.attr("checked"));
        $(this).toggleClass("checked", !!$tgt.attr("checked"))
        $("#pm_save_alert").show("slow");


    });


    $('.ogone-pm-delete').click(function(event){
        event.stopPropagation();
    })

    $('#OGONE_SUB_PERIOD_UNIT').change(function(){
      var $moment =  $('#OGONE_SUB_PERIOD_MOMENT');
      var options = null;

      if ($('#OGONE_SUB_PERIOD_UNIT').val() == 'ww') {
        options = ogone_periods_ww;
      } else if ($('#OGONE_SUB_PERIOD_UNIT').val() == 'm') {
        options = ogone_periods_m;
      } else {
        options = null;
      }

      $moment.find('OPTION').remove();

      if (options === null) {
      $('#period_moment_holder').hide();
        $moment.attr('disabled', true);
      } else {
          $('#period_moment_holder').show();

        $moment.attr('disabled', false);
        $(options).each(function(i, v){

          $('<option>').text(v).attr('value',i).appendTo($moment)
        })
      }
    });
    console.log($('#period_unit'));

    $('#period_unit').change(function(){

      console.log( $('#period_moment'), $('#period_moment').parents('DIV.form_group'));


        var $moment =  $('#period_moment');
        var options = null;

        if ($('#period_unit').val() == 'ww') {
          options = ogone_periods_ww;
        } else if ($('#period_unit').val() == 'm') {
          options = ogone_periods_m;
        } else {
          options = null;
        }

        $moment.find('OPTION').remove();

        if (options === null) {
        $('#period_moment').parents('.form-group').hide();
          $moment.attr('disabled', true);
        } else {
          $('#period_moment').parents('.form-group').show();

          $moment.attr('disabled', false);
          $(options).each(function(i, v){

            $('<option>').text(v).attr('value',i).appendTo($moment)
          })
        }
      });



});
