/**
 *  @Website: apollotheme.com - prestashop template provider
 *  @author Apollotheme <apollotheme@gmail.com>
 *  @copyright  2007-2015 Apollotheme
 *  @description: 
 */

/**
 * Start block functions common for front-end
 */
(function ($) {
    $.LeoCustomAjax = function () {
        this.leoData = 'leoajax=1';
    };
    $.LeoCustomAjax.prototype = {
        processAjax: function () {

            var myElement = this;
            
            if (leoOption.productNumber && $(".leo-qty").length)
                myElement.getCategoryList();
            else if ($(".leo-qty").length)
                $(".leo-qty").remove();
            if (leoOption.productInfo && $(".leo-more-info").length)
                myElement.getProductListInfo();
            else if ($(".leo-more-info").length)
                $(".leo-more-info").remove();
            if (leoOption.productTran && $(".product-additional").length)
                myElement.getProductListTran();
            else if ($(".product-additional").length)
                $(".product-additional").remove();
            if (leoOption.productCdown && $(".leo-more-cdown").length)
                myElement.getProductCdownInfo();
            else if ($(".leo-more-cdown").length)
                $(".leo-more-cdown").remove();
            if (leoOption.productCdown && $(".leo-more-color").length)
                myElement.getProductColorInfo();
            else if ($(".leo-more-color").length)
                $(".leo-more-color").remove();
            
            //find class ap-count-wishlist-compare
            if($('.ap-total-wishlist').length || $('.ap-total-compare').length)
            {
                myElement.getCountWishlistCompare();
            }
            
            if (myElement.leoData != "leoajax=1") {
                $.ajax({
                    type: 'POST',
                    headers: {"cache-control": "no-cache"},
                    url: baseDir + 'modules/appagebuilder/apajax.php' + '?rand=' + new Date().getTime(),
                    async: true,
                    cache: false,
                    dataType: "json",
                    data: myElement.leoData,
                    success: function (jsonData) {
                        if (jsonData) {
                            if (jsonData.cat) {
                                for (i = 0; i < jsonData.cat.length; i++) {
                                    var str = jsonData.cat[i].total;
                                    var label = $("#leo-cat-" + jsonData.cat[i].id_category).data("str");
                                    if(typeof label != "undefined") {
                                        str += "<span>" + label + "</span>";
                                    }
                                    $("#leo-cat-" + jsonData.cat[i].id_category).html(str);
                                    $("#leo-cat-" + jsonData.cat[i].id_category).show();
                                }
                            }
                            if (jsonData.pro_info) {
                                var listProduct = new Array();
                                for (i = 0; i < jsonData.pro_info.length; i++) {
                                    listProduct[jsonData.pro_info[i].id] = jsonData.pro_info[i].content;
                                }

                                $(".leo-more-info").each(function () {
                                    $(this).html(listProduct[$(this).data("idproduct")]);
                                });
                                addEffectProducts();
                            }

                            if (jsonData.pro_cdown) {
                                var listProduct = new Array();
                                for (i = 0; i < jsonData.pro_cdown.length; i++) {
                                    listProduct[jsonData.pro_cdown[i].id] = jsonData.pro_cdown[i].content;
                                }

                                $(".leo-more-cdown").each(function () {
                                    $(this).html(listProduct[$(this).data("idproduct")]);
                                });
                            }

                            if (jsonData.pro_color) {
                                var listProduct = new Array();
                                for (i = 0; i < jsonData.pro_color.length; i++) {
                                    listProduct[jsonData.pro_color[i].id] = jsonData.pro_color[i].content;
                                }

                                $(".leo-more-color").each(function () {
                                    $(this).html(listProduct[$(this).data("idproduct")]);
                                });
                            }
                                                        
                            if (jsonData.pro_add) {
                                var listProductImg = new Array();
                                for (i = 0; i < jsonData.pro_add.length; i++) {
                                    listProductImg[jsonData.pro_add[i].id] = jsonData.pro_add[i].content;
                                }
                                                                iw = 360;
                                                                ih = 360;
                                                                if (typeof leoOption.homeWidth !== 'undefined') {
                                                                        iw = leoOption.homeWidth;
                                                                        ih = leoOption.homeheight;
                                                                }else{
                                                                        iw = $('.product_img_link .img-responsive').first().attr('width');
                                                                        ih = $('.product_img_link .img-responsive').first().attr('height');
                                                                }
                                $(".product-additional").each(function () {
                                    if (listProductImg[$(this).data("idproduct")]) {
                                        var str_image = listProductImg[$(this).data("idproduct")];
                                        var src_image = str_image.replace('home_default', 'home_default');
                                        $(this).html('<img class="img-responsive" title="" alt="" src="' + src_image + '" width="'+iw+'" height="'+ih+'"/>');
                                    }
                                });
                                //addEffOneImg();
                            }
                            
                            //wishlist 
                            if (jsonData.wishlist_products)
                            {
                                $('.ap-total-wishlist').text(jsonData.wishlist_products);
                            }
                            else
                            {
                                $('.ap-total-wishlist').text('0');
                            }
                            
                            //compare
                            if (jsonData.compared_products)
                            {
                                $('.ap-total-compare').text(jsonData.compared_products);
                            }
                            else
                            {
                                $('.ap-total-compare').text('0');
                            }
                        }
                    },
                    error: function () {
                    }
                });
            }
        },
        
        //check get number product of wishlist compare
        getCountWishlistCompare: function()
        {
            this.leoData += '&wishlist_compare=1';
        },
        
        getCategoryList: function () {
            //get category id
            var leoCatList = "";
            $(".leo-qty").each(function () {
                if (leoCatList)
                    leoCatList += "," + $(this).attr("id");
                else
                    leoCatList = $(this).attr("id");
            });

            if (leoCatList) {
                leoCatList = leoCatList.replace(/leo-cat-/g, "");
                this.leoData += '&cat_list=' + leoCatList;
            }
            return false;
        },
        getProductListInfo: function () {
            var leoProInfo = "";
            $(".leo-more-info").each(function () {
                if (!leoProInfo)
                    leoProInfo += $(this).data("idproduct");
                else
                    leoProInfo += "," + $(this).data("idproduct");
            });
            if (leoProInfo) {
                this.leoData += '&pro_info=' + leoProInfo;
            }
            return false;
        },
        getProductCdownInfo: function () {
            var leoProCdown = "";
            $(".leo-more-cdown").each(function () {
                if (!leoProCdown)
                    leoProCdown += $(this).data("idproduct");
                else
                    leoProCdown += "," + $(this).data("idproduct");
            });
            if (leoProCdown) {
                this.leoData += '&pro_cdown=' + leoProCdown;
            }
            return false;
        },
        getProductColorInfo: function () {
            var leoProColor = "";
            $(".leo-more-color").each(function () {
                if (!leoProColor)
                    leoProColor += $(this).data("idproduct");
                else
                    leoProColor += "," + $(this).data("idproduct");
            });
            if (leoProColor) {
                this.leoData += '&pro_color=' + leoProColor;
            }
            return false;
        },
        getProductListTran: function () {
            //tranditional image
            var leoAdditional = "";
            $(".product-additional").each(function () {
                if (!leoAdditional)
                    leoAdditional += $(this).data("idproduct");
                else
                    leoAdditional += "," + $(this).data("idproduct");
            });
            if (leoAdditional) {
                this.leoData += '&pro_add=' + leoAdditional;
            }
            return false;
        }
    };
}(jQuery));

function addJSProduct(currentProduct) {
//    if (typeof serialScroll == 'function') { 
        $('.thumbs_list_' + currentProduct).serialScroll({
            items: 'li:visible',
            prev: '.view_scroll_left_' + currentProduct,
            next: '.view_scroll_right_' + currentProduct,
            axis: 'y',
            offset: 0,
            start: 0,
            stop: true,
            duration: 700,
            step: 1,
            lazy: true,
            lock: false,
            force: false,
            cycle: false
        });
        $('.thumbs_list_' + currentProduct).trigger('goto', 1);// SerialScroll Bug on goto 0 ?
        $('.thumbs_list_' + currentProduct).trigger('goto', 0);
 //   }   
}
function addEffectProducts(){
    if(typeof(leoOption) != 'undefined' && leoOption.productInfo){
        $(".leo-more-info").each(function() {
            addJSProduct($(this).data("idproduct"));
        });
        addEffectProduct();
    }
}

function addEffectProduct() {
    var speed = 800;
    var effect = "easeInOutQuad";

    //$(".products_block .carousel-inner .ajax_block_product:first-child").mouseenter(function() {
        //$(".products_block .carousel-inner").css("overflow", "inherit");
    //});
    //$(".carousel-inner").mouseleave(function() {
        //$(".carousel-inner").css("overflow", "hidden");
    //});

    $(".leo-more-info").each(function() {
        var leo_preview = this;
        $(leo_preview).find(".leo-hover-image").each(function() {
            $(this).mouseover(function() {
                var big_image = $(this).attr("rel");
                imgElement = $(leo_preview).parent().find(".product_img_link img").first();
                if (!imgElement.length) {
                    imgElement = $(leo_preview).parent().find(".product_image img").first();
                }

                if (imgElement.length) {
                    $(imgElement).stop().animate({opacity: 0}, {duration: speed, easing: effect});
                    $(imgElement).first().attr("src", big_image);
                    $(imgElement).first().attr("data-rel", big_image);
                    $(imgElement).stop().animate({opacity: 1}, {duration: speed, easing: effect});
                }
            });
        });

        $('.thickbox-ajax-'+$(this).data("idproduct")).fancybox({
            'hideOnContentClick': true,
            'transitionIn'  : 'elastic',
            'transitionOut' : 'elastic'
        });
    });
}

function addEffOneImg() {
    var speed = 800;
    var effect = "easeInOutQuad";

    $(".product-additional").each(function() {
        if ($(this).find("img").length) {
            var leo_hover_image = $(this).parent().find("img").first();
            var leo_preview = $(this);
            $(this).parent().mouseenter(function() {
                $(this).find("img").first().stop().animate({opacity: 0}, {duration: speed, easing: effect});
                $(leo_preview).stop().animate({opacity: 1}, {duration: speed, easing: effect});
            });
            $(this).parent().mouseleave(function() {
                $(this).find("img").first().stop().animate({opacity: 1}, {duration: speed, easing: effect});
                $(leo_preview).stop().animate({opacity: 0}, {duration: speed, easing: effect});
            });
        }
    });
}
function log(message) {
    console.log(message);
}
function onScrollInit(items) {
    items.each(function() {
        var osElement = $(this);
        var animation = $(osElement).data("animation");
        var osAnimationDelay = $(osElement).data("animation-delay");
        osElement.css({
            "-webkit-animation-delay": osAnimationDelay,
            "-moz-animation-delay": osAnimationDelay,
            "animation-delay": osAnimationDelay
        });
        
        osElement.waypoint(function() {
            osElement.addClass("animated").addClass(animation);
        }, {
            triggerOnce: true,
            offset: '90%'
        });
    });
}
/**
 * End block functions common for front-end
 */

/**
 * Start block for module ap_gmap
 */
function initializeGmap(map, data, markers, nameGmap, zoom) {
    map = new google.maps.Map(document.getElementById(nameGmap), {
        center: new google.maps.LatLng(latitude, longitude),
        zoom: zoom,
        mapTypeId: 'roadmap'
    });
    setTimeout(createMarkers(map, markers, data), 1500);
};

function createMarkers(map, markers, data) {
    for (var i = 0; i < data.length; i++) {
        var obj = data[i];
        var lg = parseFloat(obj.longitude);
        var lt = parseFloat(obj.latitude);
        var name = obj.name;
        var address = obj.address;
        var other = obj.other;
        var id_store = obj.id_store;
        var has_store_picture = obj.has_store_picture;

        var latlng = new google.maps.LatLng(lt, lg);
        var html = "<div style='min-width:200px;'><b>" + name + "</b><br/>" + address;
        //html += "<br /><br /><img src='" + img_store_dir + parseInt(id_store) + ".jpg' alt='' />";
        html += (has_store_picture ? "<br /><br /><p><img src='" + img_store_dir + parseInt(id_store) + ".jpg' alt='' /></p>" : "");
        html += other + "<a href='http://maps.google.com/maps?saddr=&daddr=" + latlng + "' target='_blank'>" + translation_5 +"<\/a>";
        html += "</div>";

        infowindow = new google.maps.InfoWindow({
            content: "loading..."
        });

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lt, lg),
            animation: google.maps.Animation.DROP,
            map: map,
            icon: img_ps_dir + logo_store,
            title: obj.name,
            html: html
        });

        google.maps.event.addListener(marker, "click", function () {
            infowindow.setContent(this.html);
            infowindow.open(map, this);
        });
        markers[i] = marker;
    }
}
/**
 * End block for module ap_gmap
 */
function synSize(name) {
    var obj = $("#" + name);
    var div = $(obj).closest(".gmap-cover");
    var gmap = $(div).find(".gmap");
    $(obj).height($(gmap).height());
    //console.log($(gmap).height());
}

$(function() {
    /**
     * Start block for module ap_product_list
     */
    $(".btn-show-more").click(function() {
        var page = parseInt($(this).data('page'));
        var btn = $(this);
        var config = $(this).closest(".ApProductList").find(".apconfig").val();
        btn.button("loading");
        $.ajax({
            headers: {"cache-control": "no-cache"},
            url: baseDir + 'modules/appagebuilder/apajax.php',
            async: true,
            cache: false,
            dataType: "Json",
            data: {"config": config, "p": page},
            success: function(response) {
                var boxCover = $(btn).closest(".box-show-more");
                if(!response.is_more) {
                    $(boxCover).removeClass("open");
                }
                if(response.html) {
                    $(boxCover).prev().append(response.html);
                }
                $(btn).data("page", (page + 1));
            }
        }).always(function () {
            btn.button("reset");
        });
    });
    /**
     * End block for module ap_product_list
     */
    /**
     * Start block for module ap_image
     */
    $(".has-animation").each(function() {
        onScrollInit($(this));
    });
    /**
     * End block for module ap_image
     */
});
(function ($) {

    window.addRule = function (selector, styles, sheet) {

        styles = (function (styles) {
            if (typeof styles === "string") return styles;
            var clone = "";
            for (var prop in styles) {
                if (styles.hasOwnProperty(prop)) {
                    var val = styles[prop];
                    prop = prop.replace(/([A-Z])/g, "-$1").toLowerCase(); // convert to dash-case
                    clone += prop + ":" + (prop === "content" ? '"' + val + '"' : val) + "; ";
                }
            }
            return clone;
        }(styles));
        sheet = sheet || document.styleSheets[document.styleSheets.length - 1];

        if (sheet.insertRule) {
                        if(sheet.cssRules!==null && sheet.cssRules.length!== 0)
                                sheet.insertRule(selector + " {" + styles + "}", sheet.cssRules.length);
                }
        else if (sheet.addRule) sheet.addRule(selector, styles);

        return this;

    };

    if ($) $.fn.addRule = function (styles, sheet) {
        addRule(this.selector, styles, sheet);
        return this;
    };

}(this.jQuery || this.Zepto));
function apPopupForm(){
    if($.totalStorage('apnewletter')) return;
    $.fancybox({
            'content' : $(".ap-popup").html(),
            afterClose: function (event, ui) {
                $.totalStorage('apnewletter', '1');
            }
    });
}

//set background and parallax
$(document).ready(function(){
    //show popup
    if($('.ap-popup').length){
        if($('.ap-popup').hasClass('index-only') && $('body').attr('id') == 'index')
            apPopupForm();
        else
            apPopupForm();
    }

    $(".has-bg.bg-fullwidth").each(function(){
        id = "#"+$(this).attr("id");
        bg = $(this).data("bg");
        $(id + ":before").addRule({
            background: bg
        });
    });
    //stela
    if (typeof stellar !== 'undefined' && stellar)
            $.stellar({horizontalScrolling:false});

    //mouse
    currentPosX = [];
    currentPosY = [];
    $("div[data-mouse-parallax-strength]").each(function(){
        currentPos = $(this).css("background-position");
        if (typeof currentPos == "string")
        {
            currentPosArray = currentPos.split(" ");
        }else
        {
            currentPosArray = [$(this).css("background-position-x"),$(this).css("background-position-y")];
        }
        currentPosX[$(this).data("mouse-parallax-rid")] = parseFloat(currentPosArray[0]);
        currentPosY[$(this).data("mouse-parallax-rid")] = parseFloat(currentPosArray[1]);
        $(this).mousemove(function(e){
            newPosX = currentPosX[$(this).data("mouse-parallax-rid")];
            newPosY = currentPosY[$(this).data("mouse-parallax-rid")];
            if($(this).data("mouse-parallax-axis") != "axis-y"){
                mparallaxPageX = e.pageX - $(this).offset().left;
                if($(this).hasClass("full-bg-screen"))
                {
                    mparallaxPageX = mparallaxPageX - 1000;
                }
                newPosX = (mparallaxPageX * $(this).data("mouse-parallax-strength") * -1) + newPosX;
            }
            if($(this).data("mouse-parallax-axis") !="axis-x"){
                mparallaxPageY = e.pageY - $(this).offset().top;
                newPosY = mparallaxPageY * $(this).data("mouse-parallax-strength") * -1;
            }
            $(this).css("background-position",newPosX+"px "+newPosY+"px");
        });
    });

    var ytIframeId; var ytVideoId;
    function onYouTubeIframeAPIReady() {
        $("div.iframe-youtube-api-tag").each(function(){
            ytIframeId = $(this).attr("id");
            ytVideoId = $(this).data("youtube-video-id");

            new YT.Player(ytIframeId, {
                videoId: ytVideoId,
                width: "100%",
                height: "100%",
                playerVars :{autoplay:1,controls:0,disablekb:1,fs:0,cc_load_policy:0,
                            iv_load_policy:3,modestbranding:0,rel:0,showinfo:0,start:0},
                events: {
                    "onReady": function(event){
                        event.target.mute();
                        setInterval(
                            function(){event.target.seekTo(0);},
                            (event.target.getDuration() - 1) * 1000
                        );
                    }
                }
            });
        });
    }
    onYouTubeIframeAPIReady();
    
    if (typeof MediaElementPlayer !== 'undefined') {
        //add function for html5 youtube video
        var player1 = new MediaElementPlayer('#special-youtube-video1');
        var player2 = new MediaElementPlayer('#special-youtube-video2');
        if(player1)
        {
            var auto_find = setInterval(function(){
                if($('#video-1 .mejs-overlay-play').html())
                {
                    $('#video-1 .mejs-overlay-play>.mejs-overlay-button').before('<div class="video-name">'+$('#special-youtube-video1').data('name')+'</div>');
                    $('#video-1 .mejs-overlay-play').append('<div class="video-description">Watch video and <span>subscribe us<span></div>');   
                    clearInterval(auto_find);
                }
            }, 500);
        }
        
        if(player2)
        {
            var auto_find1 = setInterval(function(){        
                if($('#video-2 .mejs-overlay-play').html())
                {
                    $('#video-2 .mejs-overlay-play>.mejs-overlay-button').before('<div class="video-name">'+$('#special-youtube-video2').data('name')+'</div>');
                    $('#video-2 .mejs-overlay-play').append('<div class="video-description">Watch video and <span>subscribe us<span></div>');   
                    clearInterval(auto_find1);              
                }
            }, 500);
        }
    }
    //js for select header, footer, content in demo
    current_url = window.location.href;
    $('.apconfig').each(function(){
        param = $(this).data('type');
        value = $(this).data('id');
        var re = new RegExp("([?|&])" + param + "=.*?(&|$)","i");
        if (current_url.match(re))
            $(this).attr('href', current_url.replace(re,'$1' + param + "=" + value + '$2'));
        else{
            if(current_url.indexOf('?') == -1)
                $(this).attr('href', current_url + '?' + param + "=" + value);
            else
                 $(this).attr('href', current_url + '&' + param + "=" + value);
                
        }
    });
});