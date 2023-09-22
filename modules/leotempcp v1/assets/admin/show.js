$(document).ready(function(){
	$("#pcategories").closest(".form-group").hide();
	$("#ptype").closest(".form-group").hide();
	$("#pproductids").closest(".form-group").hide();
	$("#pmanufacturers").closest(".form-group").hide();
	$( "#source option:selected" ).each(function() {
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
});