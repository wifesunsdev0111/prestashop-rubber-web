/**
 * @copyright Commercial License By LeoTheme.Com 
 * @email leotheme.com
 * @visit http://www.leotheme.com
 */
$(document).ready(function() {
    $("#leo-customize .btn-show").click(function() {
        $("body").toggleClass("off-customize");
    });
    $('#myCustomTab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    })
    $('#myCustomTab a:first').tab('show');
    $("#custom-accordion .accordion-group:first .accordion-body").addClass('in');
    $(".bg-config").hide();
    var setBackGroundAction = function(){
        /**
        * BACKGROUND-IMAGE SELECTION
        */
       $(".background-images").each(function() {
           var $parent = this;
           var $input = $(".input-setting", $parent);
           $(".bi-wrapper > div", this).click(function() {
               $(".bg-config",$parent).show();
               $input.val($(this).data('val'));
               $('.bi-wrapper > div', $parent).removeClass('active');
               $(this).addClass('active');

               if ($input.data('selector')) {
                   $($input.data('selector'), $("#main-preview iframe").contents()).css($input.data('attrs'), 'url(' + $(this).data('image') + ')');
               }
               
           });
           $(".bg-config select", this).change(function(){
               if ($input.data('selector')) {
                   $($input.data('selector'), $("#main-preview iframe").contents()).css($(this).data('attrs'), $(this).val());
               }
           });
       });
    }
    setBackGroundAction();
    
    
    $(".clear-bg").click(function() {
        var $parent = $(this).parent();
        var $input = $(".input-setting", $parent);
        if ($input.val('')) {
            if ($parent.hasClass("background-images")) {
                $('.bi-wrapper > div', $parent).removeClass('active');
                $($input.data('selector'), $("#main-preview iframe").contents()).css($input.data('attrs'), 'none');
                $('ul select', $parent).each(function(){
                    $($input.data('selector'), $("#main-preview iframe").contents()).css($(this).data('attrs'), '');
                });
                $('ul select', $parent).val("");
                $('ul.bg-config', $parent).hide();
            } else {
                $input.attr('style', '')
            }
            $($input.data('selector'), $("#main-preview iframe").contents()).css($input.data('attrs'), 'inherit');

        }
        $input.val('');
    });


    /**
     *  FORM SUBMIT
     */
    $("#form").submit(function() {
        $('.input-setting').each(function() {
            if ($(this).data("match")) {
                var val = $(this).data('selector') + "|" + $(this).data('attrs');
                $(this).parent().append('<input type="hidden" name="customize_match[' + $(this).data("match") + '][]" value="' + val + '"/>');
                if($(this).data('attrs') == "background-image"){
                    $("select",$(this).closest(".background-images")).each(function(){
                       // if($(this).val()){
                            val = $(this).data('selector') + "|" + $(this).data('attrs');
                            $(this).closest(".background-images").append('<input type="hidden" name="customize_match[' + $(this).data("match") + '][]" value="' + val + '"/>');
                        //}
                    });
                }
            }
        });
        return true;
    });
    $("#main-preview iframe").ready(function() {
        $('.accordion-group input.input-setting').each(function() {
            var input = this;
            $(input).attr('readonly', 'readonly');
            $(input).ColorPicker({
                onChange: function(hsb, hex, rgb) {
                    $(input).css('backgroundColor', '#' + hex);
                    $(input).val(hex);
                    if ($(input).data('selector')) {
                        $("#main-preview iframe").contents().find($(input).data('selector')).css($(input).data('attrs'), "#" + $(input).val())
                    }
                }
            });
        });
        $('.accordion-group select.input-setting').change(function() {
            var input = this;
            if ($(input).data('selector')) {
                var ex = $(input).data('attrs') == 'font-size' ? 'px' : "";
                $("#main-preview iframe").contents().find($(input).data('selector')).css($(input).data('attrs'), $(input).val() + ex);
            }
        });
    })

    $(".show-for-existed").hide();
    $("#saved-files").change(function() {
        if ($(this).val()) {
            $(".show-for-notexisted").hide();
            $(".show-for-existed").show();
        } else {
            $(".show-for-notexisted").show();
            $(".show-for-existed").hide();
        }
        var url = customizeFolderURL + $(this).val() + ".json?rand" + Math.random();

        $.getJSON(url, function(data) {
            var items = data;
            if (items) {
                $('#customize-body .accordion-group').each(function() {
                    var i = 0;
                    $("input, select", this).each(function() {
                        if ($(this).data('match')) {
                            if (items[$(this).data('match')] && items[$(this).data('match')][i]) {
                                var el = items[$(this).data('match')][i];
                                $(this).val(el.val);
                                if (el.val == '') {
                                    $(this).css('background', "inherit");
                                }
                                else {
                                    if(el.attr == "background-image"){
                                        $(this).parent().find("div.pull-left").each(function(){
                                            if($(this).data("val") == el.val)
                                                $(this).addClass('active');
                                        });
                                    }else if(el.attr == "background-color"){
                                        $(this).css('background', "#" + el.val);
                                    }else {
                                        $(this).closest("ul").show();
                                    }
                                }
                                if(el.attr == "background-color")
                                    $(this).ColorPickerSetColor(el.val);
                            }
                            i++;
                        }
                    });

                });
            }
        });

        $("#main-preview iframe").contents().find("#customize-theme").remove();
        if ($(this).val()) {
            var _link = $('<link rel="stylesheet" href="" id="customize-theme">');
            _link.attr('href', customizeFolderURL + $(this).val() + ".css?rand=" + Math.random());
            $("#main-preview iframe").contents().find("head").append(_link);
        }
    });

    $("#main-preview iframe").load(function() {
        if ($("#main-preview iframe").contents().find(".paneltool.editortool").length) {
            $("#main-preview iframe").contents().find(".paneltool.editortool").hide();
        }
    });
    $("#upload_pattern").click(function(e){
        e.preventDefault();
        $.fancybox.open([
                {
                    type: 'iframe', 
                    href : $(this).attr("href"),
                    afterLoad:function(){
                        hideSomeElement();
                        //$('.fancybox-iframe').load( $this.hideSomeElement );
                    },
                    afterClose: function (event, ui) {
                        //location.reload();
                        refressImage();
                    }
                }
            ], {
                padding: 10
            });
        
    });
    var hideSomeElement = function(){
        $('body',$('.fancybox-iframe').contents()).find("#header").hide();
        $('body',$('.fancybox-iframe').contents()).find("#footer").hide();
        $('body',$('.fancybox-iframe').contents()).find(".page-head, #nav-sidebar ").hide();
        //$('body',$('.fancybox-iframe').contents()).find("#content.bootstrap").css( 'padding',0).css('margin',0);
    };
    var refressImage = function(){
        $.ajax({
            type: 'GET',
            url: $("#upload_pattern").attr("href")+ '&reloadBack=1&sortBy=name',
            data: '',
            dataType: 'json',
            cache: false, // @todo see a way to use cache and to add a timestamps parameter to refresh cache each 10 minutes for example
            success: function(data)
            {
                $('.bi-wrapper').html(data);
                setBackGroundAction();
            }
        });
        
        return false;
    }
});