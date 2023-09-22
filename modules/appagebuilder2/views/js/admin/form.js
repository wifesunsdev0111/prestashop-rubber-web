/*
 *  @Website: apollotheme.com - prestashop template provider
 *  @author Apollotheme <apollotheme@gmail.com>
 *  @copyright  2007-2015 Apollotheme
 *  @description: 
 */
function addNewLink() {
	var total = parseInt($("#total_link").val());
	var tempBlock = $(".cover-block-link:first").closest(".form-group");
	$(".list-link-block").append("<li>" + $(tempBlock).html() + "</li>");
	var li = $(".list-link-block li:last-child");
	Object.keys($globalthis.languages).forEach(function (key) {
		var i = $globalthis.languages[key];
		var title = $(li).find(".lang-" + i + " input:first-child");
		var link = $(li).find(".cover-link .lang-" + i + " input");
		$(title).attr("id", "title_" + total + "_" + i);
		$(title).attr("name", "title_" + total + "_" + i);
		$(link).attr("id", "link_" + total + "_" + i);
		$(link).attr("name", "link_" + total + "_" + i);
	});
}
function renderBlockLink() {
	var total = parseInt($("#total_link").val());
	var html = $(".cover-block-link:first").closest(".form-group").html();
	for(var item = 1; item <= total; item++) {
		$(".list-link-block").append("<li>" + html + "</li>");
		var li = $(".list-link-block li:last-child");
		Object.keys($globalthis.languages).forEach(function (key) {
			var i = $globalthis.languages[key];
			var title = $(li).find(".cover-block-link .lang-" + i + " input:first-child");
			var name = "title_" + item + "_" + i;
			$(title).attr("id", name);
			$(title).attr("name", name);
			$(title).val(listData[name]);
			var link = $(li).find(".cover-link .lang-" + i + " input:first-child");
			name = "link_" + item + "_" + i;
			$(link).attr("id", name);
			$(link).attr("name", name);
			$(link).val(listData[name]);
		});
	}
}
function initBlockLink(type) {
	if(!$("#total_link").val()) {
		$("#total_link").val("0");
	}
	var total = parseInt($("#total_link").val());
	var tempBlock = $(".cover-block-link:first").closest(".form-group");
	tempBlock.addClass("hidden");
	$(".list-link-block").closest("div").attr("class", "col-lg-12");
	if(type === 'add') {
		$("#total_link").val(total + 1);
		addNewLink();
	} else {
		renderBlockLink();
	}
}
function initFullSlider(type) {
	var total = parseInt($("#total_slider").val());
	$(".apfullslider-row").addClass("hide");
	$(".apfullslider-row input, .apfullslider-row textarea").removeAttr("name");
}
function updateListIdFullSlider() {
	var listId = "";
	var sep = "";
	$("#list-slider li").each(function() {
		listId += sep + $(this).attr("id");
		sep = "|";
	});
	$("#total_slider").val(listId);
}
$(document).ready(function() {
	$("#modal_form").draggable({
		handle: ".modal-header"
	});
	//close menu
	$('.adminappagebuilderhome').addClass('page-sidebar-closed');
//    $('.addnew-group').popover({
//        html: true,
//        content: function () {
//            return $('#addnew-group-form').html();
//        }
//    });

	$('.form-action').change(function(){
		elementName = $(this).attr('name');
		$('.'+elementName+'_sub').hide();
		$('.'+elementName+'-'+$(this).val()).show();
	});
	$('.form-action').trigger("change");

	 $('.checkbox-group').change(function(){
		id = $(this).attr('id');
		if($(this).is(':checked'))
			$('.'+id).show();
		else
			$('.'+id).hide();
	});
	$('.checkbox-group').trigger("change");


    $(document).on("click", ".hook-top", function() {
		$(".hook-content", $(this).parent()).each(function(){
			$(this).toggle('clip');
			var groupTop = $(".open-group i", $(this).parent());
			if($(groupTop).attr('class').indexOf('up') >-1){
				$(groupTop).attr('class',$(groupTop).attr('class').replace('up', 'down'));
			}else{
				$(groupTop).attr('class',$(groupTop).attr('class').replace('down', 'up'));
			}
		});
	});
	$('.ApTabs .nav-tabs a:first').tab('show');
	$(".ApAccordions").each(function(){
	   $('.panel-collapse:first' , $(this)).collapse('show'); 
	});
	$('.btn-form-toggle').click(function () {
		if ($('.displayLeftColumn').hasClass('col-md-3')) {
			$('i', $(this)).attr('class', 'icon-resize-small');
			$(".hook-content").hide();
			$(".open-group i").attr('class', $(".open-group i").attr('class').replace('down', 'up'));
			$('.displayLeftColumn').removeClass('col-md-3').addClass('col-md-12');
			$('.displayRightColumn').removeClass('col-md-3').addClass('col-md-12');
			$('.home-content-wrapper').removeClass('col-md-6').addClass('col-md-12');
		} else {
			$('i', $(this)).attr('class', 'icon-resize-full');
			$(".hook-content").show();
			$(".open-group i").attr('class', $(".open-group i").attr('class').replace('up', 'down'));
			$('.displayLeftColumn').removeClass('col-md-12').addClass('col-md-3');
			$('.displayRightColumn').removeClass('col-md-12').addClass('col-md-3');
			$('.home-content-wrapper').removeClass('col-md-12').addClass('col-md-6');
		}
	});

	//only for product generate
	$( ".product-container .content" ).sortable({
	  revert: false
	});
	$('.element-list .plist-element').draggable({
	  connectToSortable: ".product-container .content",
	  revert: "true",
	  helper: "clone",
	  stop: function() {

	   $( ".product-container .content" ).sortable({
		revert: false
	  });
	  }
	});
	$(document).on("click", "#list-slider .btn-delete-slider", function() {
		if(confirm($("#form_content").data("delete"))) {
			$(this).closest("li").remove();
			$("#frm-slider").removeAttr("edit");
			updateListIdFullSlider();
		}
	});
	$(document).on("click", "#list-slider .btn-delete-fullslider", function() {
		if(confirm($("#form_content").data("delete"))) {
			$(this).closest("li").remove();
			$("#frm-slider").removeAttr("edit");
			updateListIdFullSlider();
		}
	});
	$(document).on("click", "#btn-add-slider", function() {
		$("#frm-slider, .apfullslider-row, #frm-block-slider").removeClass("hide");
		$(".btn-reset-slider, .btn-reset-fullslider").trigger("click");
		$("#frm-slider, #frm-block-slider").removeAttr("edit");
	});
	$(document).on("click", ".btn-cancel-slider, .btn-cancel-fullslider", function() {
		$("#frm-slider, .apfullslider-row, #frm-block-slider").addClass("hide");
	});
	// $(document).on("click", ".btn-reset-slider", function() {
	// 	$("#frm-slider, #frm-block-slider").removeAttr("edit");
	// 	$("#s-open").removeAttr("checked");
	// 	$("#s-image").attr("src", "");
	// 	$("#s-image").hide();
	// 	$("#frm-slider input, #frm-slider textarea, #frm-block-slider input, #frm-block-slider textarea").val("");
	// 	$("#s-tit").focus();
	// });
	$(document).on("click", ".btn-reset-fullslider, .btn-reset-slider", function() {
		$("#frm-slider, #frm-block-slider").removeAttr("edit");
		$(".apfullslider-row img").attr("src", "").hide();
		$(".apfullslider-row input, .apfullslider-row textarea").val("");
	});
	$(document).on("click", ".btn-edit-slider", function() {
		var li = $(this).closest("li");
		var idRow = $(li).attr("id");
		var lengthLang = Object.keys($globalthis.languages).length;
		$("#frm-slider, .apfullslider-row").removeClass("hide");
		$("#frm-slider").attr("edit", $(li).attr("id"));

		if(lengthLang > 1) {
			$(".select-img .translatable-field").each(function() {
				currentLang = $(this).data("lang");
				var tempId = idRow + "_" + currentLang;
				var img = $(li).find("#img_" + tempId).val();
				var title = $(li).find("#tit_" + tempId).val();
				var link= $(li).find("#link_" + tempId).val();
				var descript = $(li).find("#descript_" + tempId).val();
				$("#temp_title_" + currentLang).val(title);
				$("#temp_image_" + currentLang).val(img);
				// Check only diplay image for language
				if(img) {
					if($(".select-img .lang-" + currentLang).find("img").length == 0) {
						$(".select-img .lang-" + currentLang + " div:first-child").prepend("<img src='" + img + "' class='img-thumbnail'/>");
					} else {
						$(".select-img .lang-" + currentLang).find("img").attr("src", img);
						$(".select-img .lang-" + currentLang).find("img").css("display", "block");
					}
				}
				$("#temp_link_" + currentLang).val(link);
				$(".description-slide .lang-"  + currentLang + " textarea").val(descript.replace(/_APNEWLINE_/g, "&#10;"));
			});
		} else {
			currentLang = default_language;
			var tempId = idRow + "_" + currentLang;
			var img = $(li).find("#img_" + tempId).val();
			var title = $(li).find("#tit_" + tempId).val();
			var link= $(li).find("#link_" + tempId).val();
			var descript = $(li).find("#descript_" + tempId).val();
			$("#temp_title_" + currentLang).val(title);
			$("#temp_image_" + currentLang).val(img);
			// Check only diplay image for language
			if(img) {
				if($(".select-img img").length == 0) {
					$(".select-img div:first-child").prepend("<img src='" + img + "' class='img-thumbnail'/>");
				} else if(img) {
					$(".select-img img").attr("src", img);
				}
			}
			$("#temp_link_" + currentLang).val(link);
			$(".description-slide textarea").val(descript.replace(/_APNEWLINE_/g, "&#10;"));
		}
	});
	$(document).on("click", ".btn-edit-fullslider", function() {
		var li = $(this).closest("li");
		var idRow = $(li).attr("id");
		var lengthLang = Object.keys($globalthis.languages).length;
		$("#frm-slider, .apfullslider-row").removeClass("hide");
		$("#frm-slider").attr("edit", $(li).attr("id"));
                
		if(lengthLang > 1) {
			$(".select-img .translatable-field").each(function() {
				currentLang = $(this).data("lang");
				var tempId = idRow + "_" + currentLang;
				var img = $(li).find("#img_" + tempId).val();
                                imgLink = imgModuleLink+img;
				var title = $(li).find("#tit_" + tempId).val();
				var link= $(li).find("#link_" + tempId).val();
				var descript = $(li).find("#descript_" + tempId).val();
				$("#temp_title_" + currentLang).val(title);
				$("#temp_image_" + currentLang).val(img);
				// Check only diplay image for language
				if(img) {
					if($(".select-img .lang-" + currentLang).find("img").length == 0) {
						$(".select-img .lang-" + currentLang + " div:first-child").prepend("<img src='" + imgLink + "' class='img-thumbnail'/>");
					} else if(img) {
						$(".select-img .lang-" + currentLang).find("img").attr("src", imgLink);
						$(".select-img .lang-" + currentLang).find("img").css("display", "block");
					}
				}
				$("#temp_link_" + currentLang).val(link);
				$(".description-slide .lang-"  + currentLang + " textarea").val(descript.replace(/_APNEWLINE_/g, "&#10;"));
			});
		} else {
			currentLang = default_language;
			var tempId = idRow + "_" + currentLang;
			var img = $(li).find("#img_" + tempId).val();
                        imgLink = imgModuleLink+img;
			var title = $(li).find("#tit_" + tempId).val();
			var link= $(li).find("#link_" + tempId).val();
			var descript = $(li).find("#descript_" + tempId).val();
			$("#temp_title_" + currentLang).val(title);
			$("#temp_image_" + currentLang).val(img);
			// Check only diplay image for language
			if(img) {
				if($(".select-img img").length == 0) {
					$(".select-img div:first-child").prepend("<img src='" + imgLink + "' class='img-thumbnail'/>");
				} else if(img) {
					$(".select-img img").attr("src", imgLink);
				}
			}
			$("#temp_link_" + currentLang).val(link);
			$(".description-slide textarea").val(descript.replace(/_APNEWLINE_/g, "&#10;"));
		}
	});
	$(document).on("click", ".btn-save-slider", function() {
		// Validate
		// Get current language code selected
		var currentLang = default_language;
		var lengthLang = Object.keys($globalthis.languages).length;
		var temId = lengthLang > 1 ? ".title-slide .lang-" + default_language + " input" : ".title-slide input";
		var title = $.trim($(temId).val());
		temId = lengthLang > 1 ? ".select-img .lang-" + default_language + " img" : ".select-img img";
		var image = $.trim($(temId).attr("src"));
		var imageName = $.trim($(temId).data("img"));
		temId = lengthLang > 1 ? ".link-slide .lang-" + default_language + " input" : ".link-slide input";
		var link = $.trim($(temId).val());
		temId = lengthLang > 1 ? ".description-slide .lang-" + default_language + " textarea" : ".description-slide textarea";
		var description = $.trim($(temId).val());
		var countLimit = 0;
		if(!image) {
			countLimit++;
		}
		if(!title) {
			countLimit++;
		}
		if(!description) {
			countLimit++;
		}
		// Require enter value for one in of [image, title, description]
		if(countLimit == 3) {
			alert($(this).data("error"));
			return;
		}
		
		var idForm = "#frm-slider";
		var idRow = (typeof $(idForm).attr("edit") != "undefined") ? $(idForm).attr("edit") : "";
		if(!idRow) {
			var html = $("#temp-list li:first").html();
			idRow = 1;
			var arr = $("#total_slider").val().split("|");
			arr.sort(function (a, b) { return a - b; });
			for(var i = 0; i < arr.length; i++) {
				if(idRow != arr[i]) {
					break;
				}
				idRow++;
			}
			if(lengthLang > 1) {
				//console.log(idRow);
				// Duplicate for new slider and build name and id by language
				$(".select-img .translatable-field").each(function() {
					currentLang = $(this).data("lang");
					var tempId = idRow + "_" + currentLang + "'";
					html += "<input type='hidden' name='tit_" + tempId + " id='tit_" + tempId + "/>";
					html += "<input type='hidden' name='img_" + tempId + " id='img_" + tempId + "/>";
					html += "<input type='hidden' name='link_" + tempId + " id='link_" + tempId + "/>";
					html += "<input type='hidden' name='descript_" + tempId + " id='descript_" + tempId + "/>";
				});
			} else {
				var tempId = idRow + "_" + currentLang + "'";
				html += "<input type='hidden' name='tit_" + tempId + " id='tit_" + tempId + " value='" + title + "'/>";
				html += "<input type='hidden' name='img_" + tempId + " id='img_" + tempId + " value='" + imageName + "'/>";
				html += "<input type='hidden' name='link_" + tempId + " id='link_" + tempId + " value='" + link + "'/>";
				html += "<input type='hidden' name='descript_" + tempId + " id='descript_" + tempId + " value='" + description + "'/>";
			}
			$("#list-slider").prepend("<li id='" + idRow + "'>" + html + "</li>");
		}
		// Update labels for diplay interface
		var label = (title ? '<div class="col-lg-5">'+ title +'</div>' : "");
		label += (image ? '<img src="' + image + '">': "");
		$("#" + idRow + " div:first").html(label);
                
		if(lengthLang > 1) {
			// Update value for other language by default language and save to dum hidden fields
			$(".select-img .translatable-field").each(function() {
				currentLang = $(this).data("lang");
				var titleOther = $.trim($(".title-slide .lang-" + currentLang + " input").val());
				var imageOther = $.trim($(".select-img #temp_image_" + currentLang).val());
				var linkOther = $.trim($(".link-slide .lang-" + currentLang + " input").val());
				var descriptionOther = $.trim($(".description-slide .lang-" + currentLang + " textarea").val());
				if(currentLang != default_language) {
					if(!titleOther) {
						titleOther = title;
						$(".title-slide .lang-" + currentLang + " input").val(title);
					}
					if(!imageOther) {
						imageOther = imageName;
						$(".select-img .lang-" + currentLang + " input").val(imageOther);
					}
					if(!linkOther) {
						linkOther = link;
						$(".link-slide .lang-" + currentLang + " input").val(link);
					}
					if(!descriptionOther) {
						descriptionOther = description;
						$(".description-slide .lang-" + currentLang + " textarea").val(description);
					}
				}
				var tempId = idRow + "_" + currentLang;
                                
				$("#tit_" + tempId).val(titleOther);
				$("#img_" + tempId).val(imageOther);
				$("#link_" + tempId).val(linkOther);
				$("#descript_" + tempId).val(descriptionOther);
			});
		} else {
			var tempId = idRow + "_" + currentLang;
			$("#tit_" + tempId).val(title);
			$("#img_" + tempId).val(imageName);
			$("#link_" + tempId).val(link);
			$("#descript_" + tempId).val(description);
		}
		$(idForm).attr("edit", idRow);
		updateListIdFullSlider();
		$(idForm).addClass("hide");
		$(".apfullslider-row").addClass("hide");
	});
	/**
	* Validate and gender data for fullsilder and fill data for all language from current language selected in form
	*/
	$(document).on("click", ".btn-save-fullslider", function() {
		// Validate
		// Get current language code selected
		var currentLang = default_language;
		var lengthLang = Object.keys($globalthis.languages).length;
		var temId = lengthLang > 1 ? ".title-slide .lang-" + default_language + " input" : ".title-slide input";
		var title = $.trim($(temId).val());
		temId = lengthLang > 1 ? ".select-img .lang-" + default_language + " img" : ".select-img img";
		var image = $.trim($(temId).attr("src"));
		var imageName = $.trim($(temId).data("img"));
		temId = lengthLang > 1 ? ".link-slide .lang-" + default_language + " input" : ".link-slide input";
		var link = $.trim($(temId).val());
		temId = lengthLang > 1 ? ".description-slide .lang-" + default_language + " textarea" : ".description-slide textarea";
		var description = $.trim($(temId).val());
		var countLimit = 0;
		if(!image) {
			countLimit++;
		}
		if(!title) {
			countLimit++;
		}
		if(!description) {
			countLimit++;
		}
		// Require enter value for one in of [image, title, description]
		if(countLimit == 3) {
			alert($(this).data("error"));
			return;
		}
		
		var idForm = "#frm-slider";
		var idRow = (typeof $(idForm).attr("edit") != "undefined") ? $(idForm).attr("edit") : "";
		if(!idRow) {
			var html = $("#temp-list li:first").html();
			idRow = 1;
			var arr = $("#total_slider").val().split("|");
			arr.sort();
			for(var i = 0; i < arr.length; i++) {
				if(idRow != arr[i]) {
					break;
				}
				idRow++;
			}
			if(lengthLang > 1) {
				//console.log(idRow);
				// Duplicate for new slider and build name and id by language
				$(".select-img .translatable-field").each(function() {
					currentLang = $(this).data("lang");
					var tempId = idRow + "_" + currentLang + "'";
					html += "<input type='hidden' name='tit_" + tempId + " id='tit_" + tempId + "/>";
					html += "<input type='hidden' name='img_" + tempId + " id='img_" + tempId + "/>";
					html += "<input type='hidden' name='link_" + tempId + " id='link_" + tempId + "/>";
					html += "<input type='hidden' name='descript_" + tempId + " id='descript_" + tempId + "/>";
				});
			} else {
				var tempId = idRow + "_" + currentLang + "'";
				html += "<input type='hidden' name='tit_" + tempId + " id='tit_" + tempId + " value='" + title + "'/>";
				html += "<input type='hidden' name='img_" + tempId + " id='img_" + tempId + " value='" + image + "'/>";
				html += "<input type='hidden' name='link_" + tempId + " id='link_" + tempId + " value='" + link + "'/>";
				html += "<input type='hidden' name='descript_" + tempId + " id='descript_" + tempId + " value='" + description + "'/>";
			}
			$("#list-slider").prepend("<li id='" + idRow + "'>" + html + "</li>");
		}
		// Update labels for diplay interface
		var label = (title ? '<div class="col-lg-5">'+ title +'</div>' : "");
		label += (image ? '<img src="' + image + '">': "");
		$("#" + idRow + " div:first").html(label);

		if(lengthLang > 1) {
			// Update value for other language by default language and save to dum hidden fields
			$(".select-img .translatable-field").each(function() {
				currentLang = $(this).data("lang");
				var titleOther = $.trim($(".title-slide .lang-" + currentLang + " input").val());
				var imageOther = $.trim($(".select-img #temp_image_" + currentLang).val());
				var linkOther = $.trim($(".link-slide .lang-" + currentLang + " input").val());
				var descriptionOther = $.trim($(".description-slide .lang-" + currentLang + " textarea").val());
				if(currentLang != default_language) {
					if(!titleOther) {
						titleOther = title;
						$(".title-slide .lang-" + currentLang + " input").val(title);
					}
					if(!imageOther) {
						imageOther = imageName;
						$(".select-img .lang-" + currentLang + " input").val(imageOther);
					}
					if(!linkOther) {
						linkOther = link;
						$(".link-slide .lang-" + currentLang + " input").val(link);
					}
					if(!descriptionOther) {
						descriptionOther = description;
						$(".description-slide .lang-" + currentLang + " textarea").val(description);
					}
				}
				var tempId = idRow + "_" + currentLang;
				$("#tit_" + tempId).val(titleOther);
				$("#img_" + tempId).val(imageOther);
				$("#link_" + tempId).val(linkOther);
				$("#descript_" + tempId).val(descriptionOther);
			});
		} else {
			var tempId = idRow + "_" + currentLang;
			$("#tit_" + tempId).val(title);
			$("#img_" + tempId).val(imageName);
			$("#link_" + tempId).val(link);
			$("#descript_" + tempId).val(description);
		}
		$(idForm).attr("edit", idRow);
		updateListIdFullSlider();
		$(idForm).addClass("hide");
		$(".apfullslider-row").addClass("hide");
	});
	$(document).on("click", ".btn-add-block-link", function() {
		var total = parseInt($("#total_link").val());
		$("#total_link").val(total + 1);
		addNewLink();
	});
	$(document).on("click", ".btn-remove-block-link", function() {
		var total = parseInt($("#total_link").val());
		$("#total_link").val(total > 0 ? total - 1 : 0);
		$(this).closest("li").remove();
	});
	$(document).on("click", ".latest-blog-category input[type='checkbox']", function() {
		ckb = $(this).is(':checked');
		if(ckb) {
			$(this).closest("li").find('input').attr("checked", "checked");
		} else {
			$(this).closest("li").find('input').removeAttr("checked");
		}
	});
	$(document).on("click", ".list-font-awesome li", function() {
		$(".list-font-awesome li").removeClass("selected");
		$("#font_name").val($(this).find("i").data("default"));
		$(".preview-widget i").attr("class", $(this).find("i").attr("class"));
		$(this).addClass("selected");
		renderDefaultPreviewFontwesome();
	});
	$(document).on("change", "#font_type, #font_size, #is_spin", function() {
		renderDefaultPreviewFontwesome();
	});
});
function renderDefaultPreviewFontwesome() {
	var cls = "icon " + $("#font_name").val() + " " + $("#font_type").val()
			+ " " + $("#font_size").val()
			+ " " + $("#is_spin").val();
	$(".preview-widget i").attr("class", cls);
}
/**
* Start block for module ApCategoryImage
*/
/**
 * Update status check a current category, this function is called from event in file home.js in this module
 * @param {type} obj: install of image just selected
 * @returns {Boolean}
 */
var selected_images = {};
function resetSelectedImage() {
	if(typeof selected_images != "undefined") {
		selected_images = {};
	}
}
function updateStatusCheck(obj) {
	var checkbox = $(obj).closest("span").find("input[type='checkbox']").first();
	if($(obj).attr("src-url") != "") {
		selected_images[$(checkbox).val()] = $(obj).attr("src-url");
		// Set status for checkbox
		// $(checkbox).attr("checked", "checked");
		$(obj).closest("span").find(".remove-img").removeClass("hidden");	
	} else {
		$(checkbox).removeAttr("checked");
		$(obj).closest("span").find(".remove-img").addClass("hidden");
		delete selected_images[$(checkbox).val()];
	}
	$("#category_img").val(JSON.stringify(selected_images));
	return false;
}
function intiForApCategoryImage() {
	// Check only run when exist widget ApCategoryImage
	if($(".form_ApCategoryImage").length <= 0) {
		return;
	}
	$("#pcategories").closest(".form-group").hide();
	$("#ptype").closest(".form-group").hide();
	$("#pproductids").closest(".form-group").hide();
	$("#pmanufacturers").closest(".form-group").hide();
	$("#source option:selected").each(function() {
		var val = $(this).val();
		$("#"+val).closest(".form-group").show();
	});
	$("#source").change(function(){
		$("#pcategories").closest(".form-group").hide();
		$("#ptype").closest(".form-group").hide();
		$("#pproductids").closest(".form-group").hide();
		$("#pmanufacturers").closest(".form-group").hide();
		var val = $(this).val();
		$("#"+val).closest(".form-group").show(500);
	});
	//hide checkbox of root node
	$("input[type=checkbox]", "#categorybox").first().hide();
	var root_id = $("input[type=checkbox]", "#categorybox").first().val();
	Array.prototype.remove = function(v) { this.splice(this.indexOf(v) == -1 ? this.length : this.indexOf(v), 1); }
	if($("#category_img").val()){
		selected_images = JSON.parse($("#category_img").val());
	}
	$("input[type=checkbox]", "#categorybox").click(function(){
		if($(this).is(":checked")) {
			//find parent category
			//all parent category must be not checked
			var check = checkParentNodes($(this));
			if(!check){
				$(this).prop("checked", false);
				alert("All parent of this category must be not checked"); 
			} else {
				$(this).closest("ul").find("ul input[type=checkbox]").removeAttr("checked");
			}
		} else {
			//$(".list-image-" + $(this).val()).remove();
			delete selected_images[$(this).val()];
		}
		$("#category_img").val(JSON.stringify(selected_images));
	});
	/*
	$(".list-image a").click(function(){
		var selText = $(this).text();
		$(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
		$(this).parents('.btn-group').find('.dropdown-menu').hide();
		var checkbox = $(this).closest(".tree-item-name").find("input[type='checkbox']").first();
		if(selText != "none"){
			cate_id = $(this).parents('.btn-group').find('.dropdown-toggle').closest("li").find("input[type=checkbox]").val();
			selected_images[cate_id] = selText.trim();
			// Set status for checkbox
			$(checkbox).attr("checked", "checked");
		} else {
			$(checkbox).removeAttr("checked");
		}
		$("#category_img").val(JSON.stringify(selected_images));
		return false;
	});
	
	$(".dropdown-toggle").click(function(){
		if($(this).parents('.btn-group').find('.dropdown-menu').css("display") === "none") {
			$(this).parents('.btn-group').find('.dropdown-menu').show();
		} else {
			$(this).parents('.btn-group').find('.dropdown-menu').hide();
		}
		return false;
	});
	$(".dropdown-menu").mouseleave(function(){
		$(".dropdown-menu").hide();
		return false;
	});
	*/
	
	// Show selected_image when loaded page
	refreshListIcon();
	function refreshListIcon() {
		$("input[type=checkbox]", $(".form-select-icon")).each(function() {
			var listImage;
			if($(this).val() != root_id){
				listImage = $(".list-image", "#list_image_wrapper").clone(1);
				var d = new Date();
				var n = "" + d.getTime() +  Math.random();
				n = n.replace(".", "");
				var span = $(this).closest("li").find("span");
				$(listImage).find("img").attr("id", "apci_" + n);
				$(listImage).find("a").data("for", "#apci_" + n);
				listImage.appendTo($(span).first());
			}
			for(var key in selected_images){
				if(key == $(this).val()){
					image_name = selected_images[key];
					if(listImage) {
						var path = $(listImage).find("img").attr("path");
						$(listImage).find("img").attr("src", path + image_name);
						$(listImage).find("img").removeClass("hidden");
						$(listImage).find(".remove-img").removeClass("hidden");
					}
					//listImage.find(".dropdown-toggle").html(image_name+' <span class="caret"></span>');
					// Set status for checkbox
					//$(this).attr("checked", "checked");
					break;
				}
			}
			$("#category_img").val(JSON.stringify(selected_images));
				//$(this).closest("ul.tree").css("display", "none");
		});
	}

	//$("ul.tree").css("display", "none");
	function checkParentNodes(obj) {
		var flag = true;
		if(parent = obj.closest("ul").closest("li").find("input[type=checkbox]")){
			if(parent.val() != root_id){
				if($("input[value=" + parent.val() + "]","#categorybox").is(":checked")){
					flag = false;
				} else {
					flag = checkParentNodes(parent);
				}
			}
		}
		return flag;
	}
}
function replaceSpecialString(str){
    return str.replace(/\t/g, "_APTAB_").replace(/\r/g, "_APNEWLINE_").replace(/\n/g, "_APENTER_").replace(/"/g, "_APQUOT_").replace(/'/g, "_APAPOST_");
}
/*
* End block for module ApCategoryImage
*/