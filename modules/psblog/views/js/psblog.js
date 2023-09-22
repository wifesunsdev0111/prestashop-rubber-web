
$(document).ready( function(){
	/*  */
	var src =  $('#comment-form img.comment-capcha-image').attr('src');
	$("#comment-form").submit( function() {
		var action = $(this).attr( 'action' );
		var data = $('#comment-form').serialize();
		
		if( $("#comment-form").parent().find('.comment-message').length<=0 ){
			var msg = $( '<div class="comment-message"></div>' );
			$("#comment-form").before( msg );
		}else {
			var msg = $("#comment-form").parent().find(".comment-message");
		} 

	 	$.ajax( {
			url:action,
			data: data+"&submitcomment="+Math.random(),
			type:'POST',
			dataType: 'json',
			success:function( ct ){ 
				if( !ct.error ){
					$( msg ).html( '<div class="alert alert-info">'+ct.message+'</div>' );
					$( 'input[type=text], textarea', '#comment-form' ).each( function(){
						$(this).val('');
						var srcn = src.replace('captchaimage','rand='+Math.random()+"&captchaimage");
						$('#comment-form img.comment-capcha-image').attr( 'src', srcn );
					} );
				}else {
					$( msg ).html( '<div class="alert alert-warning">'+ct.message+'</div>' );
				}	
			}
		} );  
		return false;
	} );
} );