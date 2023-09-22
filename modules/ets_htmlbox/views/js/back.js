/**
 * Copyright ETS Software Technology Co., Ltd
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future.
 *
 * @author ETS Software Technology Co., Ltd
 * @copyright  ETS Software Technology Co., Ltd
 * @license    Valid for 1 website (or project) for each purchase of license
 */

$(document).ready(function () {
    $(document).on('click', '.ctf-short-code', function (e) {
        $(this).select();
        document.execCommand("copy");
        $(this).next().addClass('copied');
        setTimeout(function () {
            $('.copied').removeClass('copied');
        }, 2000);
    });
    $(document).on('click', ' #_ets_hb_html_box_form_submit_btn', function () {
        var html =
            '<button type="button" onclick="javascript::void(0)" class="btn btn-default pull-right disabled">' +
            '<i class="process-icon-save"></i> Saving' +
            '</button>';
        $(this).after(html)
        $(this).remove();
        $("<input />").attr("type", "hidden")
            .attr("name", "stay")
            .attr("value", 1)
            .appendTo("#ets_hb_html_box_form");
        $('#ets_hb_html_box_form').submit();
    });
});