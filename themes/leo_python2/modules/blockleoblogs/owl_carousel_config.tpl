{*
 *  Leo Theme for Prestashop 1.6.x
 *
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
*}

{if $call_owl_carousel}
<script>
$(document).ready(function() {
    $("{$call_owl_carousel}").owlCarousel({
            items : {if $owl_items}{$owl_items|intval}{else}false{/if},
            {if $owl_itemsDesktop}itemsDesktop : [1199,{$owl_itemsDesktop|intval}],{/if}
            {if $owl_itemsDesktopSmall}itemsDesktopSmall : [979,{$owl_itemsDesktopSmall|intval}],{/if}
            {if $owl_itemsTablet}itemsTablet : [768,{$owl_itemsTablet|intval}],{/if}
            {if $owl_itemsTabletSmall}itemsTabletSmall : [640,{$owl_itemsTabletSmall|intval}],{/if}
            {if $owl_itemsMobile}itemsMobile : [479,{$owl_itemsMobile|intval}],{/if}
            {if $owl_itemsCustom}itemsCustom : {$owl_itemsCustom},{/if}
            singleItem : false,         // true : show only 1 item
            itemsScaleUp : false,
            slideSpeed : {if $owl_slideSpeed}{$owl_slideSpeed|intval}{else}200{/if},  //  change speed when drag and drop a item
            paginationSpeed : {if $owl_paginationSpeed}{$owl_paginationSpeed}{else}800{/if}, // change speed when go next page
            rewindSpeed : {if $owl_rewindSpeed}{$owl_rewindSpeed}{else}1000{/if}, // change speed when carousel go back first page
            autoPlay : {if $owl_autoPlay}{$owl_autoPlay|intval}{else}false{/if},   // time to show each item
            stopOnHover : {if $owl_stopOnHover}true{else}false{/if},
            navigation : {if $owl_navigation}true{else}false{/if},
            navigationText : ["&lsaquo;", "&rsaquo;"],
            rewindNav : {if $owl_rewindNav}true{else}false{/if}, // enable, disable tua lại về first item
            scrollPerPage : {if $owl_scrollPerPage}true{else}false{/if},
            
            pagination : {if $owl_pagination}true{else}false{/if}, // show bullist
            paginationNumbers : {if $owl_paginationNumbers}true{else}false{/if}, // show number
            
            responsive : {if $owl_responsive}true{else}false{/if},
            //responsiveRefreshRate : 200,
            //responsiveleo_bigstoreWidth : window,
            
            //leo_bigstoreClass : "owl-carousel",
            //theme : "owl-theme",
            
            lazyLoad : {if $owl_lazyLoad}true{else}false{/if},
            lazyFollow : {if $owl_lazyFollow}true{else}false{/if},  // true : go to page 7th and load all images page 1...7. false : go to page 7th and load only images of page 7
            lazyEffect : {if $owl_lazyEffect}"fade"{else}false{/if},
            
            autoHeight : {if $owl_autoHeight}true{else}false{/if},

            //jsonPath : false,
            //jsonSuccess : false,

            //dragBeforeAnimFinish
            mouseDrag : {if $owl_mouseDrag}true{else}false{/if},
            touchDrag : {if $owl_touchDrag}true{else}false{/if},
            
            addClassActive : true,
            {if $owl_rtl}direction:'rtl',{/if}
            //transitionStyle : "owl_transitionStyle",
            
            //beforeUpdate : false,
            //afterUpdate : false,
            //beforeInit : false,
            afterInit : SetOwlCarouselFirstLast,
            //beforeMove : false,
            //afterMove : false,
            afterAction : SetOwlCarouselFirstLast,
            //startDragging : false,
            //afterLazyLoad: false
    

        });
      });

      function SetOwlCarouselFirstLast(el){
            el.find(".owl-item").removeClass("first_item");
            el.find(".owl-item.active").first().addClass("first_item");
            
            el.find(".owl-item").removeClass("last_item");
            el.find(".owl-item.active").last().addClass("last_item");
      }
</script>
{/if}
