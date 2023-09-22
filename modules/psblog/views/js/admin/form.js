/**
 * Owl carousel
 *
 * @visit http://www.prestabrain.com
 */

(function($) {
	$.fn.PavMegaMenuList = function(opts) {
		// default configuration
		var config = $.extend({}, {
			action:null, 
			addnew : null,
			confirm_del:'Are you sure delete this?'
		}, opts);

		function checkInputHanlder(){
			var _updateMenuType = function(){
				$(".menu-type-group").parent().parent().hide();
				$("[for^=content_text_]").parent().hide();

				if( $("#menu_type").val() =='html' ){
					$("[for^=content_text_]").parent().show();
				}else {
					$("#"+$("#menu_type").val()+"_type").parent().parent().show();
				}
			};
			_updateMenuType(); 
			$("#menu_type").change(  _updateMenuType );

			var _updateSubmenuType = function(){
				if( $("#type_submenu").val() =='html' ){
					$("[for^=submenu_content_text_]").parent().show();
				}else{
					$("[for^=submenu_content_text_]").parent().hide();
				}
			};
			_updateSubmenuType();
			$("#type_submenu").change(  _updateSubmenuType );

		}

		function manageTreeMenu(){
			if($('ol').hasClass("sortable")){
				$('ol.sortable').nestedSortable({
						forcePlaceholderSize: true,
						handle: 'div',
						helper:	'clone',
						items: 'li',
						opacity: .6,
						placeholder: 'placeholder',
						revert: 250,
						tabSize: 25,
						tolerance: 'pointer',
						toleranceElement: '> div',
						maxLevels: 4,

						isTree: true,
						expandOnHover: 700,
						startCollapsed: true,
						
						stop: function(){ 							
							var serialized = $(this).nestedSortable('serialize');
						
							$.ajax({
								type: 'POST',
								url: config.action+"&doupdatepos=1&rand="+Math.random(),
								data : serialized+'&updatePosition=1' 
							}).done( function (msg) {
								 showSuccessMessage(msg);
							} );
						}
					});
				
				// $('#serialize').click(function(){
					// var serialized = $('ol.sortable').nestedSortable('serialize');
				 	// var text = $(this).val();
				 	// var $this  = $(this);
				 	// $(this).val( $(this).data('loading-text') );
					// $.ajax({
						// type: 'POST',
						// url: config.action+"&doupdatepos=1&rand="+Math.random(),
						// data : serialized+'&updatePosition=1' 
					// }).done( function () {
						 // $this.val( text );
					// } );
				// });
				
				$('#addcategory').click(function(){
					location.href=config.addnew;
				});
			}	
		}
	 	/**
	 	 * initialize every element
	 	 */
		this.each(function() {  
	 		$(".quickedit",this).click( function(){  
	 			location.href=config.action+"&id_psblogcat="+$(this).attr('rel').replace("id_","");
	 		} );

	 		$(".quickdel",this).click( function(){  
	 			if( confirm(config.confirm_del) ){
	 				location.href=config.action+"&dodel=1&id_psblogcat="+$(this).attr('rel').replace("id_","");
	 			}
	 			
	 		} );

	 		manageTreeMenu();
	 	 




		});

		return this;
	};
	
})(jQuery);


jQuery(document).ready(function(){
 	$(".ps-modal").fancybox({
	 	'type':'iframe',
	 	'width':980,
	 	'height':500,
	 	afterLoad:function(   ){
	 		if( $('body',$('.fancybox-iframe').contents()).find("#main").length  ){  
		 		$('body',$('.fancybox-iframe').contents()).find("#header").hide();
		 		$('body',$('.fancybox-iframe').contents()).find("#footer").hide();
	 		}else { 
	 			 
	 		}
	 	}
	});
 	
 	$("#widgetds a.btn").fancybox( {'type':'iframe'} );

 	$(".ps-modal-action, #widgets a.btn").fancybox({
	 	'type':'iframe',
	 	'width':950,
	 	'height':500,
	 	afterLoad:function(   ){
	 		if( $('body',$('.fancybox-iframe').contents()).find("#main").length  ){  
		 		$('body',$('.fancybox-iframe').contents()).find("#header").hide();
		 		$('body',$('.fancybox-iframe').contents()).find("#footer").hide();
	 		}else { 
	 			 
	 		}
	 	},
 		afterClose: function (event, ui) {  
		//	location.reload();
		},	
	});
	
	//delete image uploaded
	if ($('#image_link-images-thumbnails').length > 0)
	{
				
		psblog_del_img($('#image_link-images-thumbnails'), 'image');
	}
	
	if ($('#thumb_link-images-thumbnails').length > 0)
	{
				
		psblog_del_img($('#thumb_link-images-thumbnails'), 'thumb');
	}
	
	$('.psblog-del-img-bt').click(function(){
		if( confirm(psblog_del_img_mess) ){
			var id_parent = $(this).data('id');
			$('#'+id_parent).parent().fadeOut(function(){
				$(this).remove();
			});
			var id_element = $(this).data('element');
			$('#'+id_element).val('');
		}
		return false;
	})
});

//function delete image uploaded

function psblog_del_img(img_id_element, img_name_e)
{
	img_id_element.append('<a class="btn btn-default psblog-del-img-bt" href="#" data-element="'+img_name_e+'" data-id="'+img_id_element.attr('id')+'"><i class="icon-trash"></i>'+psblog_del_img_txt+'</a>');
}

 
jQuery(document).ready(function(){
	// var i = 0;
	// $("#bloggeneralsetting > form > .panel .form-group").hide();
	// $("#bloggeneralsetting > form > .panel .panel-footer").hide();

	// $("#bloggeneralsetting > form > .panel").each( function() {
		// var panel = $(this);
		// $( "h3, .panel-heading" , this ).click( function(){
		 	 // $("#bloggeneralsetting > form > .panel .form-group").hide();
	 

		 	 // $(".form-group",panel).show();
		 	 // $(".panel-footer",panel).show();
		// } );
		// if(i++==0){
			 // $(".form-group",this).show();
		 	 // $(".panel-footer",this).show();
		// } 

	// } );
		
	var id_panel = $("#bloggeneralsetting .psblog-globalconfig li.active a").attr("href");
	$(id_panel).addClass('active').show();
	$('.psblog-globalconfig li').click(function(){
		if(!$(this).hasClass('active'))
		{
			var default_tab = $(this).find('a').attr("href");			
			$('#PsBLOG_DASHBOARD_DEFAULTTAB').val(default_tab);
		}
	})
});

/*
 * SHOW HIDE - URL include ID
 */
 $(document).ready(function(){
    $('.form-action').change(function(){
        var elementName = $(this).attr('name');
        $('.'+elementName+'_sub').hide(300);
        $('.'+elementName+'-'+$(this).val()).show(500);
    });
    $('.form-action').trigger("change");

 });