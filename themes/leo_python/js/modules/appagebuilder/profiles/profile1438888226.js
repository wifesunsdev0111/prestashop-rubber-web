$(document).ready(function(){
	var win_height = $(window).height();
	var check_scroll = 0;
	var lastScroll = $(window).scrollTop();
	
	$('.banner').css({'height':win_height});
	$('.banner').click(function(){		
		 $('html, body').animate({
			scrollTop: $("#header").offset().top
		
		}, 2000);
	});
	$(window).scroll(function() {
		if($(window).width() >= 992)
		{
			var scrollTop = $(window).scrollTop();
			if(scrollTop > 0 && scrollTop < $("#header").offset().top && check_scroll == 0)
			{
				$('html, body').stop().animate({
					scrollTop: $("#header").offset().top
				
				}, 100, function(){
					check_scroll = 1;
				});
				
			}
			if(scrollTop == 0)
			{
				check_scroll = 0;
			}
			lastScroll = scrollTop;
		}
		
	});
})