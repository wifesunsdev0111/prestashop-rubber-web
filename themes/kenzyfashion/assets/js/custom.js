
/*===========mega main menu=========== */
jQuery(document).ready(function() {
 	$("#top-menu .sub-menu li:has(ul)").parent().parent().parent().addClass("menu-dropdown");
});

/*===========flex slider=========== */
$(window).load(function() {
    $(".loadingdiv").removeClass("spinner");
});

/*===========back to top=========== */
$(window).scroll(function() {
    if ($(this).scrollTop() > 500) {
        $('.ax-back-to-top').fadeIn(500);
    } else {
        $('.ax-back-to-top').fadeOut(500);
    }
});
$('.ax-back-to-top').click(function(event) {
    event.preventDefault();
    $('html, body').animate({
        scrollTop: 0
    }, 800);
});

/*===========feature slick slider=========== */
$('#aeifeature-slider').slick({
  appendArrows: $('#aeifeature-arrows'),
  dots: false,
  infinite: false,
  speed: 300,
  slidesToShow: 4,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});

/*===========new product slick slider=========== */
$('#aeinewproduct-slider').slick({
  appendArrows: $('#aeinewproduct-arrows'),
  dots: false,
  infinite: false,
  speed: 300,
  slidesToShow: 4,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});

/*===========Bestseller product slick slider=========== */
$('#aeibestseller-slider').slick({
  appendArrows: $('#aeibestsellerarrows'),
  dots: false,
  infinite: false,
  speed: 300,
  slidesToShow: 4,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});


/*===========Special product slick slider=========== */
$('#aeispecial-slider').slick({
  appendArrows: $('#aeispecialarrows'),
  dots: false,
  infinite: false,
  speed: 300,
  slidesToShow: 4,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});

/*===========brand logo slick slider=========== */
$('#aeibrand-slider').slick({
  appendArrows: $('#aeibrand-arrows'),
  dots: false,
  infinite: false,
  speed: 300,
  slidesToShow: 5,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});

/*===========accesories slick slider=========== */
$('#aeiaccessories-slider').slick({
  appendArrows: $('#aeiaccessories-arrows'),
  dots: false,
  infinite: false,
  speed: 300,
  slidesToShow: 4,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});

/*===========testimonial slick slider=========== */
$('#aeitestimony-carousel').slick({
  dots: true,
  infinite: false,
  speed: 300,
  slidesToShow: 1,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});

/*===========Blog slick slider=========== */
$('#psblog-slider').slick({
  appendArrows: $('#blog-arrows'),
  auto: true,
  dots: false,
  infinite: false,
  speed: 300,
  slidesToShow: 3,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});

/*===========list grid view=========== */
  $(document).ready(function(){
    
    $('.show_list').click(function(){   
    $('.show_grid.active').removeClass('active');
        $(this).toggleClass('active');  
        $('#js-product-list .product-miniature').addClass('product_show_list');
    });

    $('.show_grid').toggleClass('active');  
    $('.show_grid').click(function(){
        $('.show_list.active').removeClass('active');
        $(this).toggleClass('active');
        $('#js-product-list .product-miniature').removeClass('product_show_list');
    });
     
    prestashop.on('updateProductList', function (event) {
        $('.show_list').click(function(){
            $('#js-product-list .product-miniature').addClass('product_show_list');
        });
         
        $('.show_grid').click(function(){
            $('#js-product-list .product-miniature').removeClass('product_show_list');
        });
    }); 
})

 /*===========myaccount dropdown=========== */
  $(".user-info").on("click", function(event) {
      event.stopPropagation();
  });
 
/*===========active menu responsive =========== */ 
 $('#menu-icon').on('click', function() {
    $(this).toggleClass('active');
  $('#mobile_top_menu_wrapper').toggleClass('active');
});

/*===========left column =========== */
function responsivecolumn() {
    if ($(document).width() <= 991) {
        $('.container #left-column').insertAfter('#content-wrapper');
    } else if ($(document).width() >= 992) {
        $('.container #left-column').insertBefore('#content-wrapper');
    }
}
$(document).ready(function() {
    responsivecolumn();
});
$(window).resize(function() {
    responsivecolumn();
});





$(document).ready(function() {
  $('.search-widget form input[type=text]').before('<h6 class="block_title">Search</h6>');
 }); 

 $(document).ready(function() {
  $('.item-product').find('img').removeClass('invisible');
 }); 


 
$(document).ready(function() {
  $('.header-navfullwidth .container').addClass('container-fluid');
  $('.header-navfullwidth .container').removeClass('container');
});

$(document).ready(function() {
  $('#checkout .header .container').addClass('container-fluid');
  $('#checkout .header .container').removeClass('container');
}); 
