/**
 * @copyright Commercial License By LeoTheme.Com 
 * @email leotheme.com
 * @visit http://www.leotheme.com
 */
$(document).ready(function(){
	$("#pcategories").closest(".form-group").hide();
	$("#ptype").closest(".form-group").hide();
	$("#pproductids").closest(".form-group").hide();
	$("#pmanufacturers").closest(".form-group").hide();
	
	$( "#source option:selected" ).each(function() {
		$("#limit").closest(".form-group").hide();
		var val = $(this).val();
		$("#"+val).closest(".form-group").show(500);
		if( val != 'pproductids'){
			$("#limit").closest(".form-group").show(500);
		}
	});
	$("#source").change(function(){
		$("#pcategories").closest(".form-group").hide();
		$("#ptype").closest(".form-group").hide();
		$("#pproductids").closest(".form-group").hide();
		$("#pmanufacturers").closest(".form-group").hide();
		$("#limit").closest(".form-group").hide();
        var val = $(this).val();
        $("#"+val).closest(".form-group").show(500);
			if(val != 'pproductids')
				$("#limit").closest(".form-group").show(500);
    });
	
    //for imageproduct widget
    $("#ip_pcategories").closest(".form-group").hide();
    $("#ip_pproductids").closest(".form-group").hide();
    $( "#ip_source option:selected" ).each(function() {
        var val = $(this).val();
        $("#"+val).closest(".form-group").show();
    });
    $("#ip_source").change(function(){
        $("#ip_pcategories").closest(".form-group").hide();
        $("#ip_pproductids").closest(".form-group").hide();
        var val = $(this).val();
        $("#"+val).closest(".form-group").show(500);
    });
    //done for imageproduct widget
    //for category_image widget
    //hide checkbox of root node
    $("input[type=checkbox]", "#image_cate_tree").first().hide();
    var root_id = $("input[type=checkbox]", "#image_cate_tree").first().val();
    Array.prototype.remove = function(v) { this.splice(this.indexOf(v) == -1 ? this.length : this.indexOf(v), 1); }
    var selected_images = {};
    if($("#category_img").val()){
        selected_images = JSON.parse($("#category_img").val());
    }
    $("input[type=checkbox]", "#image_cate_tree").click(function(){
        if($(this).is(":checked")){
            //find parent category
            //all parent category must be not checked
            var check = checkParentNodes($(this));
            if(!check){          
                $(this).prop("checked",false);
                alert("All parent of this category must be not checked"); 
            }
        }else{
            $(".list-image-"+$(this).val()).remove();
            delete  selected_images[$(this).val()];
        }
    });
    $(".list-image a").click(function(){
        var selText = $(this).text();
        $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
        $(this).parents('.btn-group').find('.dropdown-menu').hide();
        if(selText != "none"){
            cate_id = $(this).parents('.btn-group').find('.dropdown-toggle').closest("li").find("input[type=checkbox]").val();
            selected_images[cate_id] = selText.trim();
        }
        return false;
    });
    $(".dropdown-toggle").click(function(){
        $(this).parents('.btn-group').find('.dropdown-menu').show();
        return false;
    });
    $(".list-image .dropdown-menu").mouseleave(function(){
        $(".list-image .dropdown-menu").hide();
        return false;
    });
    $('[name="saveleotempcp"].sub_categories').click(
        function(){
             $("#category_img").val(JSON.stringify(selected_images));
    });
    $('[name="saveandstayleotempcp"].sub_categories').click(
        function(){
             $("#category_img").val(JSON.stringify(selected_images));
    });
  //  show selected_image when loaded page
    $("input[type=checkbox]", $(".form-select-icon")).each(function(){
            if($(this).val() != root_id){
                listImage = $(".list-image","#list_image_wrapper").clone(1);
                listImage.addClass("list-image-"+$(this).val());
                listImage.appendTo($(this).closest("li").find("span").first());
            }
            for(var key in selected_images){
                if(key == $(this).val()){
                    image_name = selected_images[key];
                    listImage.find(".dropdown-toggle").html(image_name+' <span class="caret"></span>');
                    break;
                }
            }
            //$(this).closest("ul.tree").css("display", "none");
    });
    //$("ul.tree").css("display", "none");
    function checkParentNodes(obj){
        var flag = true;
        if(parent = obj.closest("ul").closest("li").find("input[type=checkbox]")){
            if(parent.val() != root_id){
                if($("input[value=" + parent.val() + "]","#image_cate_tree").is(":checked")){
                    flag = false;
                }else{
                    flag = checkParentNodes(parent);                  
                }
            }
       }
       return flag;
    }
    //done for category_image widget
});


/*
 * Owl carousel
 */
 $(document).ready(function(){
    // Check type of Carousel type - BEGIN
    $('.form-action').change(function(){
        elementName = $(this).attr('name');
        $('.'+elementName+'_sub').hide(300);
        $('.'+elementName+'-'+$(this).val()).show(500);
    });
    $('.form-action').trigger("change");
    // Check type of Carousel type - END
    
    $("#configuration_form").validate({
        rules : {
                owl_items : {
                    min : 1,
                },
                owl_rows : {
                    min : 1,
                }
            }        
    });
 });
 
$.validator.addMethod("owl_items_custom", function(value, element) {
    pattern_en = /^\[\[[0-9]+, [0-9]+\](, [\[[0-9]+, [0-9]+\])*\]$/;  // [[320, 1], [360, 1]]
    pattern_dis = /^0?$/
    //console.clear();
    //console.log (pattern.test(value));
    return (pattern_en.test(value) || pattern_dis.test(value));
    //return false;
}, "Please enter correctly config follow under example.");
