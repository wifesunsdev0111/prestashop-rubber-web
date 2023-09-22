/*
* 2007-2014 PrestaShop
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
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
//global variables
var responsiveflag = false;

$(document).ready(function(){
	highdpiInit();
	responsiveResize();
	floatHeader();      
	$(window).resize(responsiveResize);
        
	$('.verticalmenu .dropdown-toggle').prop('disabled', true);
        $('.verticalmenu .dropdown-toggle').data('toggle', '');
        $(".verticalmenu .caret").click(function(){
            var $parent  = $(this).parent();
            $parent.toggleClass('open')
            return false;
        });
        if ($(document).width() >990) $('.verticalmenu').addClass('active-hover');
        else $('.verticalmenu').removeClass('active-hover');
        $(window).resize(menuleftResize);
        
	scrollSliderBarMenu();
	if (navigator.userAgent.match(/Android/i))
	{
		var viewport = document.querySelector('meta[name="viewport"]');
		viewport.setAttribute('content', 'initial-scale=1.0,maximum-scale=1.0,user-scalable=0,width=device-width,height=device-height');
		window.scrollTo(0, 1);
	}
	//blockHover();
	if (typeof quickView !== 'undefined' && quickView)
		quick_view();
	dropDown();
        if(typeof page_name != 'undefined') page_name = $("body").attr("id");

	if (!in_array(page_name, ['index', 'product']))
	{
		bindGrid();

 		$(document).on('change', '.selectProductSort', function(e){
			if (typeof request != 'undefined' && request)
				var requestSortProducts = request;
 			var splitData = $(this).val().split(':');
			if (typeof requestSortProducts != 'undefined' && requestSortProducts)
				document.location.href = requestSortProducts + ((requestSortProducts.indexOf('?') < 0) ? '?' : '&') + 'orderby=' + splitData[0] + '&orderway=' + splitData[1];
    	});

		$(document).on('change', 'select[name="n"]', function(){
			$(this.form).submit();
		});

		$(document).on('change', 'select[name="manufacturer_list"], select[name="supplier_list"]', function() {
			if (this.value != '')
				location.href = this.value;
		});

		$(document).on('change', 'select[name="currency_payement"]', function(){
			setCurrency($(this).val());
		});
	}

	$(document).on('click', '.back', function(e){
		e.preventDefault();
		history.back();
	});
	jQuery.curCSS = jQuery.css;
	if (!!$.prototype.cluetip)
		$('a.cluetip').cluetip({
			local:true,
			cursor: 'pointer',
			dropShadow: false,
			dropShadowSteps: 0,
			showTitle: false,
			tracking: true,
			sticky: false,
			mouseOutClose: true,
			fx: {
		    	open:       'fadeIn',
		    	openSpeed:  'fast'
			}
		}).css('opacity', 0.8);

	if (!!$.prototype.fancybox)
		$.extend($.fancybox.defaults.tpl, {
			closeBtn : '<a title="' + FancyboxI18nClose + '" class="fancybox-item fancybox-close" href="javascript:;"></a>',
			next     : '<a title="' + FancyboxI18nNext + '" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
			prev     : '<a title="' + FancyboxI18nPrev + '" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'
		});
});

function menuleftResize(removeOpen){
    if ($(document).width() >990)
    {
        $('.verticalmenu .dropdown').removeClass('open');
        $('.verticalmenu').addClass('active-hover');
    }else{
    	$('.verticalmenu').removeClass('active-hover');
    }
}

function scrollSliderBarMenu(){
    var menuElement = $(".float-vertical");
    var columnElement = null;
    var maxWindowSize = 990;
    
    if($(menuElement).hasClass('float-vertical-right'))
        columnElement = $("#right_column");
    else if($(menuElement).hasClass('float-vertical-left'))
        columnElement = $("#left_column");
    //auto display slider bar menu when have left or right column
    if($(columnElement).length && $(window).width()>=maxWindowSize) showOrHideSliderBarMenu(columnElement, menuElement, 1);
    $(".float-vertical-button").click(function(){
        if($(menuElement).hasClass('active')) showOrHideSliderBarMenu(columnElement, menuElement, 0);
        else showOrHideSliderBarMenu(columnElement, menuElement, 1);
    });

    var lastWidth = $(window).width();
    $(window).resize(function() {
    	if($(window).width()!=lastWidth){
	        if($(window).width()<maxWindowSize) {
	            if($(menuElement).hasClass('active')) showOrHideSliderBarMenu(columnElement, menuElement, 0);
	        }else{
	            if($(columnElement).length && !$(menuElement).hasClass('active')) showOrHideSliderBarMenu(columnElement, menuElement, 1);
	        }
	        lastWidth = $(window).width();
    	}
    });
}

function showOrHideSliderBarMenu(columnElement, menuElement, active){
    if(active){
        $(menuElement).addClass('active');
        if($(columnElement).length && $(window).width()>=990) 
            columnElement.css('padding-top',($('.block_content',$(menuElement)).height())+'px');
    }else{
        $(menuElement).removeClass('active');
        if($(columnElement).length) columnElement.css('padding-top','');
    }
}

function highdpiInit()
{
	if($('.replace-2x').css('font-size') == "1px")
	{
		var els = $("img.replace-2x").get();
		for(var i = 0; i < els.length; i++)
		{
			src = els[i].src;
			extension = src.substr( (src.lastIndexOf('.') +1) );
			src = src.replace("." + extension, "2x." + extension);
			var img = new Image();
			img.src = src;
			img.height != 0 ? els[i].src = src : els[i].src = els[i].src;
		}
	}
}

function responsiveResize()
{
	if ($(document).width() <= 767 && responsiveflag == false)
	{
		accordion('enable');
	    accordionFooter('enable');
		responsiveflag = true;
	}
	else if ($(document).width() >= 768)
	{
		accordion('disable');
		accordionFooter('disable');
	    responsiveflag = false;
	}
	if (typeof page_name != 'undefined' && in_array(page_name, ['category']))
		resizeCatimg();

}
/*
function blockHover(status)
{
	$(document).off('mouseenter').on('mouseenter', '.product_list.grid li.ajax_block_product .product-container', function(e){
		if ($('body').find('.container').width() == 1170)
		{
			var pcHeight = $(this).parent().outerHeight();
			var pcPHeight = $(this).parent().find('.button-container').outerHeight() + $(this).parent().find('.comments_note').outerHeight() + $(this).parent().find('.functional-buttons').outerHeight();
			$(this).parent().addClass('hovered').css({'height':pcHeight + pcPHeight, 'margin-bottom':pcPHeight * (-1)});

		}
	});

	$(document).off('mouseleave').on('mouseleave', '.product_list.grid li.ajax_block_product .product-container', function(e){
		if ($('body').find('.container').width() == 1170)
			$(this).parent().removeClass('hovered').css({'height':'auto', 'margin-bottom':'0'});
	});

}

*/
function quick_view()
{
	$(document).on('click', '.quick-view:visible, .quick-view-mobile:visible', function(e) 
	{
		e.preventDefault();
		var url = this.rel;
		if (url.indexOf('?') != -1)
			url += '&';
		else
			url += '?';

		if (!!$.prototype.fancybox)
			$.fancybox({
				'padding':  0,
				'width':    1087,
				'height':   610,
				'type':     'iframe',
				'href':     url + 'content_only=1'
			});
	});
}

function bindGrid()
{
	var view = $.totalStorage('display');

	if (!view && (typeof displayList != 'undefined') && displayList)
		view = 'list';

        gridType = "grid";
        if($("#page").data("type") != 'undefined') gridType = $("#page").data("type");
        if(view && view != gridType) display(view);
        else display(gridType);
	$(document).on('click', '#grid', function(e){
		e.preventDefault();
		
		display('grid');
	});

	$(document).on('click', '#list', function(e){
		e.preventDefault();
		display('list');
	});
}

function display(view)
{

		$('.display').find('div').removeClass('selected');
		$('.display').find('div#'+view).addClass('selected');
        classGrid = "col-xs-12 col-sm-6 col-md-4";
        if($("#page").data("column") != 'undefined') classGrid = $("#page").data("column");
	if (view == 'list')
	{
		$('.product_list').removeClass('grid').addClass('list');
		$('.product_list > div').removeClass(classGrid).addClass('col-xs-12');
		$('.product_list > div').each(function(index, element) {
			html = '';
			html = '<div class="product-container product-block text-left"><div class="row">';
				html += '<div class="left-block col-md-4 col-sm-4">' + $(element).find('.left-block').html() + '</div>';
				html += '<div class="right-block col-md-8 col-sm-8">';
				html += '<div class="product-meta">';
					var rating = $(element).find('.comments_note').html(); // check : rating
						if (rating != null) { 
							html += '<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" class="comments_note">'+ rating + '</div>';
						}
					html += '<h5 itemprop="name" class="name">'+ $(element).find('h5').html() + '</h5>';
					html += '<p itemprop="description" class="product-desc">'+ $(element).find('.product-desc').html() + '</p>';
					html += '<div class="functional-compare clearfix ">' + $(element).find('.functional-compare').html() + '</div>';
					html += '<div class="product-flags">'+ $(element).find('.product-flags').html() + '</div>';
					var price = $(element).find('.content_price').html(); // check : catalog mode is enabled
						if (price != null) { 
							html += '<div class="content_price">'+ price + '</div>';
						}
					var colorList = $(element).find('.color-list-container').html();
					if (colorList != null) {
						html += '<div class="color-list-container">'+ colorList +'</div>';
					}
					var availability = $(element).find('.availability').html(); // check : catalog mode is enabled
					if (availability != null) {
						html += '<span class="availability">'+ availability +'</span>';
					}
					
				html += '<div class="functional-buttons clearfix ">' + $(element).find('.functional-buttons').html() + '</div>';
				html += '</div>';
				html += '</div>';
			html += '</div></div>';
		$(element).html(html);
		});		
		$('.display').find('li#list').addClass('selected');
		$('.display').find('li#grid').removeAttr('class');
		$.totalStorage('display', 'list');
	}
	else 
	{
		$('div.product_list').removeClass('list').addClass('grid');
		$('.product_list > div').removeClass('col-xs-12').addClass(classGrid);
		$('.product_list > div').each(function(index, element) {
		html = '';
		html += '<div class="product-container product-block text-left">';
			html += '<div class="left-block">' + $(element).find('.left-block').html() + '</div>';
			html += '<div class="right-block">';
			html += '<div class="product-meta">';
				var rating = $(element).find('.comments_note').html(); // check : rating
					if (rating != null) { 
						html += '<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" class="comments_note">'+ rating + '</div>';
					}
				html += '<h5 itemprop="name" class="name">'+ $(element).find('h5').html() + '</h5>';
				html += '<p itemprop="description" class="product-desc">'+ $(element).find('.product-desc').html() + '</p>';
				html += '<div class="functional-compare">' + $(element).find('.functional-compare').html() + '</div>';
				html += '<div class="product-flags">'+ $(element).find('.product-flags').html() + '</div>';
				var price = $(element).find('.content_price').html(); // check : catalog mode is enabled
					if (price != null) { 
						html += '<div class="content_price">'+ price + '</div>';
					}
				var colorList = $(element).find('.color-list-container').html();
				if (colorList != null) {
					html += '<div class="color-list-container">'+ colorList +'</div>';
				}
				var availability = $(element).find('.availability').html(); // check : catalog mode is enabled
				if (availability != null) {
					html += '<span class="availability">'+ availability +'</span>';
				}
				
			
			html += '</div>';
			html += '</div>';
		html += '</div>';		
		$(element).html(html);
		});
		$('.display').find('li#grid').addClass('selected');
		$('.display').find('li#list').removeAttr('class');
		$.totalStorage('display', 'grid');
	}
	if (typeof addEffectProducts == 'function') { 
		addEffectProducts();
	}	
}

function dropDown() 
{
	elementClick = '#header .current';
	elementSlide =  'ul.toogle_content';       
	activeClass = 'active';			 

	$(elementClick).on('click', function(e){
		e.stopPropagation();
		var subUl = $(this).next(elementSlide);
		if(subUl.is(':hidden'))
		{
			subUl.slideDown();
			$(this).addClass(activeClass);	
		}
		else
		{
			subUl.slideUp();
			$(this).removeClass(activeClass);
		}
		$(elementClick).not(this).next(elementSlide).slideUp();
		$(elementClick).not(this).removeClass(activeClass);
		e.preventDefault();
	});

	$(elementSlide).on('click', function(e){
		e.stopPropagation();
	});

	$(document).on('click', function(e){
		e.stopPropagation();
		var elementHide = $(elementClick).next(elementSlide);
		$(elementHide).slideUp();
		$(elementClick).removeClass('active');
	});
}

function accordionFooter(status)
{
	if(status == 'enable')
	{
		$('#footer .footer-block h4').on('click', function(){
			$(this).toggleClass('active').parent().find('.toggle-footer').stop().slideToggle('medium');
		})
		$('#footer').addClass('accordion').find('.toggle-footer').slideUp('fast');
	}
	else
	{

		$('.footer-block h4').removeClass('active').off().parent().find('.toggle-footer').removeAttr('style').slideDown('fast');
		$('#footer').removeClass('accordion');
	}
}

function accordion(status)
{
	leftColumnBlocks = $('#left_column');
	if(status == 'enable')
	{
		$('#right_column .block .title_block, #left_column .block .title_block, #left_column #newsletter_block_left h4').on('click', function(){
			$(this).toggleClass('active').parent().find('.block_content').stop().slideToggle('medium');
		})
		$('#right_column, #left_column').addClass('accordion').find('.block .block_content').slideUp('fast');
	}
	else
	{
		$('#right_column .block .title_block, #left_column .block .title_block, #left_column #newsletter_block_left h4').removeClass('active').off().parent().find('.block_content').removeAttr('style').slideDown('fast');
		$('#left_column, #right_column').removeClass('accordion');
	}
}

function resizeCatimg()
{
	var div = $('.cat_desc').parent('div');
	var image = new Image;
	$(image).load(function(){
	    var width  = image.width;
	    var height = image.height;
		var ratio = parseFloat(height / width);
		var calc = Math.round(ratio * parseInt(div.outerWidth(false)));
		div.css('min-height', calc);
	});
	if (div.length)
		image.src = div.css('background-image').replace(/url\("?|"?\)$/ig, '');
}
function processFloatHeader(headerAdd, scroolAction){
	if(headerAdd){
		$("#header").addClass( "navbar-fixed-top" );
	    var hideheight =  $("#header").height()+120; 
	    $("#page").css( "padding-top", $("#header").height() );
	}else{
		$("#header").removeClass( "navbar-fixed-top" );
	    $("#page").css( "padding-top", '');
	}

	var pos = $(window).scrollTop();
    if( scroolAction && pos >= hideheight ){
        $("#topbar").addClass('hide-bar');
        $(".hide-bar").css( "margin-top", - $("#topbar").height() );
        $("#header-main").addClass("mini-navbar");
    }else {
        $("#topbar").removeClass('hide-bar');
        $("#topbar").css( "margin-top", 0 );
        $("#header-main").removeClass("mini-navbar");
    }
}
//Float Menu
function floatHeader(){
	if (!$("body").hasClass("keep-header") || $(window).width() <= 990){
		return;
	}
	
	$(window).resize(function(){
		if ($(window).width() <= 990)
		{
			processFloatHeader(0,0);
		}
		else if ($(window).width() > 990)
		{
			processFloatHeader(1,1);
		}
	});
    
   
    $(window).scroll(function() {
    	if($(window).width() > 990){
	         processFloatHeader(1,1);
    	}
    });
}
