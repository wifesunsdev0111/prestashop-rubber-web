/**
 *  @Website: apollotheme.com - prestashop template provider
 *  @author Apollotheme <apollotheme@gmail.com>
 *  @copyright  2007-2015 Apollotheme
 *  @description: 
 */
$(document).ready(function() {
    //only for product generate
    
    $('.plist-eedit').click(function(){
        element = $(this).data('element');
        $.fancybox.open([{
                type: 'iframe', 
                href : $('#appagebuilder_products_form').attr('action') + '&pelement=' + element,
                afterLoad:function(){
                    if( $('body',$('.fancybox-iframe').contents()).find("#main").length  ){
                        hideSomeElement();
                        $('.fancybox-iframe').load( hideSomeElement );
                    }else { 
                        $('body',$('.fancybox-iframe').contents()).find("#psException").html('<div class="alert error">Can not find this element</div>');
                    }
                },
                afterClose: function (event, ui) { 
                }
            }], {
            padding: 10
        });
    });
    
    $('.element-list .plist-element').draggable({
        connectToSortable: ".product-container .content",
        revert: "true",
        helper: "clone",
        stop: function() {
         setProFormAction();
         setSortAble();
        }
    });
    
    $('#saveAndStay').click(function(){
        $('input[name=submitAddappagebuilder_productsAndStay]').val('1');
        genreateForm();
        $('#appagebuilder_products_form').submit();
        return false;
    });
    
    setProFormAction();
    setSortAble();
});

function genreateForm(){
    //generate grid first
    var ObjectFrom = {};
    ObjectFrom.gridLeft = returnObjElemnt('.ap_proGrid .gridLeft-block-content');
    ObjectFrom.gridRight = returnObjElemnt('.ap_proGrid .gridRight-block-content');
    $('input[name=params]').val(JSON.stringify(ObjectFrom));
}

function returnObjElemnt(element){
    var Object = {};
    $(element).children().each(function(iElement){
        var Obj = {};
        Obj.name = $(this).data('element');
        
        if($(this).hasClass('functional_buttons')){
            Obj.element = returnObjElemnt($('.content', $(this)));
        }
        if($(this).hasClass('code')){
            Obj.code = replaceSpecialString($('textarea', $(this)).val());
        }
        Object[iElement] = Obj;
    });
    return Object;
}

function hideSomeElement(){
    $('body',$('.fancybox-iframe').contents()).addClass("page-sidebar-closed");
}

function setSortAble(){
    $( ".product-container .content" ).sortable({
      connectWith: ".content",
    });
}
function setProFormAction(){
    $('.plist-code').click(function(){
        textAre = $(this).closest('.plist-element').find('textarea').first();
        if(textAre.attr('rows') == 20)
            $(textAre).attr('rows',5);
        else
            $(textAre).attr('rows',20);
    });
    
    $('.plist-eremove').click(function(){
        $(this).closest('.plist-element').remove();
    });
}