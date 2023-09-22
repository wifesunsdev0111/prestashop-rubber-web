/**
 * @copyright Commercial License By LeoTheme.Com 
 * @email leotheme.com
 * @visit http://www.leotheme.com
 */
$(document).ready(function() {
	 $(".btn-modal").fancybox({	'type':'iframe' , 'width':1000});

	 

  	$("a.btn-ajax").click( function(){  	 
 			var url = $(this).attr('href');
	 		$.ajax({
				url: url,
				type:'POST',
				context: document.body
				}).done(function() {
				$( this ).addClass( "done" );
			});

		return false;
 	} ); 

    var THEMEKEY = $("#theme_key").val();
 	/* font style 1 */
  	var fontUP1 = function(){
  		  	$("#"+THEMEKEY+"_FONT_ENGINE1 option").each( function(){
  		var f =  $(this).val();

  		if( $(this).attr('selected') ){
  			$('[id^='+THEMEKEY+'_ENGINE1_'+f.toUpperCase()+']').parent().parent().show();
  		}else {
  			$('[id^='+THEMEKEY+'_ENGINE1_'+f.toUpperCase()+']').parent().parent().hide();
  		}
  		} );	
  	}

  	fontUP1();
  	$("#"+THEMEKEY+"_FONT_ENGINE1").change( fontUP1 );

	/* font style 2	*/
  	var fontUP2 = function(){
  		  	$("#"+THEMEKEY+"_FONT_ENGINE2 option").each( function(){
  		var f =  $(this).val();

  		if( $(this).attr('selected') ){
  			$('[id^='+THEMEKEY+'_ENGINE2_'+f.toUpperCase()+']').parent().parent().show();
  		}else {
  			$('[id^='+THEMEKEY+'_ENGINE2_'+f.toUpperCase()+']').parent().parent().hide();
  		}
  		} );	
  	}

  	fontUP2();
  	$("#"+THEMEKEY+"_FONT_ENGINE2").change( fontUP2 );
  	/* font style 2	*/
  	var fontUP3 = function(){
  		  	$("#"+THEMEKEY+"_FONT_ENGINE3 option").each( function(){
  		var f =  $(this).val();

  		if( $(this).attr('selected') ){
  			$('[id^='+THEMEKEY+'_ENGINE3_'+f.toUpperCase()+']').parent().parent().show();
  		}else {
  			$('[id^='+THEMEKEY+'_ENGINE3_'+f.toUpperCase()+']').parent().parent().hide();
  		}
  		} );	
  	}

  	fontUP3();
  	$("#"+THEMEKEY+"_FONT_ENGINE3").change( fontUP3 );

 	/* */ 
        
        $(".leo-redirect a").click(function(){
            
            $('html, body').animate({
                scrollTop: parseInt(parseInt($("#"+$(this).data("element")).offset().top)-100)
            }, 2000);
        });
		
		
	/*
	 * Changing special characters to normal
	 */
	$( "#module_form" ).submit(function( event ) {
		var css = $('#LEO_COSMETICS_C_CODECSS').val();
		css = css.replace(/\\/g, 'LEO_BACKSLASH');
		$('#LEO_COSMETICS_C_CODECSS').val(css);
		//this.submit();
		//event.preventDefault();
	});
});

 

