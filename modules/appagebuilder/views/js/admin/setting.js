/**
 *  @Website: apollotheme.com - prestashop template provider
 *  @author Apollotheme <apollotheme@gmail.com>
 *  @copyright  2007-2015 Apollotheme
 *  @description: 
 */
function proccessData(id) {
    var list = $.trim($(id).val()).split(",");
    var result = "";
    var sep = "";
    for(var i = 0; i < list.length; i++) {
        if($.trim(list[i])) {
            result += sep + $.trim(list[i]);
            sep = ",";
        }
    }
    $(id).val(result);
}
$(document).ready(function() {
    $('.panel-content-builder').hide();
    $('.open-content').click(function(){
        $(this).closest('.panel').find('.panel-content-builder').toggle();
        return false
    });
});
function compareListHooks(oldHooks, newHooks) {
    //console.log(oldHooks);
    //console.log(newHooks);
    isEqual = true;
    if(oldHooks.length > 0 && newHooks.length > 0) {
        for(var i = 0; i < oldHooks.length; i++) {
            var isSubLook = false;
            for(var j = 0; j < newHooks.length; j++) {
                if(oldHooks[i] === newHooks[j]) {
                    newHooks.splice(j, 1);
                    //console.log(newHooks);
                    isSubLook = true;
                    break;
                }
            }
            if(!isSubLook) {
                return false;
            }
        }
    }
    return isEqual;
}

$(function() {
    $(".appagebuilder-preview-url").text($("#APPAGEBUILDER_IMGDIR").val());
    $("#hook_header_old").val($("#HEADER_HOOK").val());
    $("#hook_content_old").val($("#CONTENT_HOOK").val());
    $("#hook_footer_old").val($("#FOOTER_HOOK").val());
    $("#hook_product_old").val($("#PRODUCT_HOOK").val());
    
    $("#APPAGEBUILDER_IMGDIR").keyup(function() {
        $(".appagebuilder-preview-url").text($(this).val());
    });
    $(".list-all-hooks a").click(function() {
        var newHook = $.trim($(this).text());
        var id = $("#position-hook-select").val();
        id = id ? id : "#HEADER_HOOK";
        var listHook = $.trim($(id).val());
        if(listHook.search(newHook) < 0) {
            listHook += (listHook ? "," : "") + newHook;
            $(id).val(listHook);
        } else {
            alert("This hook is existed");
        }
    });
    $("#HEADER_HOOK, #CONTENT_HOOK, #FOOTER_HOOK, #PRODUCT_HOOK").focus(function() {
        var id = "#" + $(this).attr("id");
        $("#position-hook-select").val(id);
    });
    $("#btn-save-appagebuilder").click(function(e) {
        $isChange = false;
        proccessData("#HEADER_HOOK");
        proccessData("#CONTENT_HOOK");
        proccessData("#FOOTER_HOOK");
        proccessData("#PRODUCT_HOOK");
        // Check change config hooks
        var oldHook = $.trim($("#hook_header_old").val()).split(",");
        var currentHook = $.trim($("#HEADER_HOOK").val()).split(",");
        if(oldHook.length != currentHook.length || !compareListHooks(oldHook, currentHook)) {
            $isChange = true;
        }
        oldHook = $.trim($("#hook_content_old").val()).split(",");
        currentHook = $.trim($("#CONTENT_HOOK").val()).split(",");
        if(oldHook.length != currentHook.length || !compareListHooks(oldHook, currentHook)) {
            $isChange = true;
        }
        oldHook = $.trim($("#hook_footer_old").val()).split(",");
        currentHook = $.trim($("#FOOTER_HOOK").val()).split(",");
        if(oldHook.length != currentHook.length || !compareListHooks(oldHook, currentHook)) {
            $isChange = true;
        }
        oldHook = $.trim($("#hook_product_old").val()).split(",");
        currentHook = $.trim($("#PRODUCT_HOOK").val()).split(",");
        if(oldHook.length != currentHook.length || !compareListHooks(oldHook, currentHook)) {
            $isChange = true;
        }
        if($isChange) {
            if(!confirm($("#message_confirm").val())) {
                e.stopPropagation();
                return false;
            }
            $("#is_change").val("is_change");
        }
        
    });
    
    $("#modal_form").on("click", ".btn-savewidget", function() {
        // Is form add new module to appagebuilder
        if($("#modal_form").find(".form_ap_module").length > 0) {
            // Validate select hook
            if(!$("#select-hook").val()) {
                alert($("#select-hook-error").val());
                return false;
            }
        }
    });
});