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
    if ($('#js-product-list-header').length > 0) {
        if ($('#hookDisplayProductListHeaderBefore').length > 0) {
            $('#js-product-list-header').prepend($('#hookDisplayProductListHeaderBefore').html());
        }
        if ($('#hookDisplayProductListHeaderAfter').length > 0) {
            $('#js-product-list-header').append($('#hookDisplayProductListHeaderAfter').html());
        }
    }
    if ($('.content_scene_cat').length > 0) {
        if ($('#hookDisplayProductListHeaderBefore').length > 0) {
            $('.content_scene_cat').before($('#hookDisplayProductListHeaderBefore').html());
        }
        if ($('#hookDisplayProductListHeaderAfter').length > 0) {
            $('.content_scene_cat').after($('#hookDisplayProductListHeaderAfter').html());
        }
    }
    if ($('#left-column').length > 0) {
        if ($('#hookDisplayLeftColumnBefore').length > 0) {
            $('#left-column').prepend($('#hookDisplayLeftColumnBefore').html());
        }
    }
    if ($('#left_column').length > 0) {
        if ($('#hookDisplayLeftColumnBefore').length > 0) {
            $('#left_column').prepend($('#hookDisplayLeftColumnBefore').html());
        }
    }
    if ($('#right-column').length > 0) {
        if ($('#hookDisplayRightColumnBefore').length > 0) {
            $('#right-column').prepend($('#hookDisplayRightColumnBefore').html());
        }
    }
    if ($('#right_column').length > 0) {
        if ($('#hookDisplayRightColumnBefore').length > 0) {
            $('#right_column').prepend($('#hookDisplayRightColumnBefore').html());
        }
    }
    if ($('.product-variants').length > 0) {
        if ($('#hookDisplayProductVariantsBefore').length > 0) {
            $('.product-variants').prepend($('#hookDisplayProductVariantsBefore').html());
        }
    }
    if ($('.product_attributes').length > 0) {
        if ($('#hookDisplayProductVariantsBefore').length > 0) {
            $('.product_attributes').prepend($('#hookDisplayProductVariantsBefore').html());
        }
    }
    if ($('.product-variants').length > 0) {
        if ($('#hookDisplayProductVariantsAfter').length > 0) {
            $('.product-variants').append($('#hookDisplayProductVariantsAfter').html());
        }
    }
    if ($('.product_attributes').length > 0) {
        if ($('#hookDisplayProductVariantsAfter').length > 0) {
            $('.product_attributes').append($('#hookDisplayProductVariantsAfter').html());
        }
    }
    if ($('#product-comments-list-header').length > 0) {
        if ($('#hookDisplayProductCommentsListHeaderBefore').length > 0) {
            $('#product-comments-list-header').before($('#hookDisplayProductCommentsListHeaderBefore').html());
        }
    }
    if ($('.cart-grid-body').length > 0) {
        if ($('#hookDisplayCartGridBodyBefore1').length > 0) {
            $('.cart-grid-body').prepend($('#hookDisplayCartGridBodyBefore1').html());
        }
        if ($('#hookDisplayCartGridBodyBefore2').length > 0) {
            $('.cart-grid-body').prepend($('#hookDisplayCartGridBodyBefore2').html());
        }
        if ($('#hookDisplayCartGridBodyAfter').length > 0) {
            $('.cart-grid-body').append($('#hookDisplayCartGridBodyAfter').html());
        }
    }
    if ($('#order_step').length > 0){
        if ($('#hookDisplayCartGridBodyBefore2').length > 0) {
            $('#order_step').after($('#hookDisplayCartGridBodyBefore2').html());
        }
    }
    if($('.cart_navigation').length > 0){
        if ($('#hookDisplayCartGridBodyAfter').length > 0) {
            $('.cart_navigation').after($('#hookDisplayCartGridBodyAfter').html());
        }
    }
});