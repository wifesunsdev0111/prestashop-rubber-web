{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ProductOwlCarousel -->
<div id="{$carouselName}" class="owl-carousel owl-theme {if isset($productClassWidget)}{$productClassWidget}{/if}">
{$mproducts=array_chunk($products,$formAtts.itempercolumn)}
{foreach from=$mproducts item=products name=mypLoop}
	<div class="item">
		{foreach from=$products item=product name=products}
			{if isset($profile) && $profile}
				{assign var="tplPath" value="$tpl_dir./profiles/$profile.tpl"}
				{include file="$tplPath"}
			{else}
				{include file='./ProductItem.tpl'}
			{/if}

		{/foreach}
	</div>
{/foreach}
</div>

{addJsDefL name=min_item}{l s='Please select at least one product' mod='appagebuilder' js=1}{/addJsDefL}
{addJsDefL name=max_item}{l s='You cannot add more than %d product(s) to the product comparison' mod='appagebuilder' sprintf=$comparator_max_item js=1}{/addJsDefL}
{addJsDef comparator_max_item=$comparator_max_item}
{addJsDef comparedProductsIds=$compared_products}
<script type="text/javascript">
$(document).ready(function() {
	
	$('#{$carouselName}').owlCarousel({
            items : {if $formAtts.items}{$formAtts.items|intval}{else}false{/if},
            {if $formAtts.itemsdesktop}itemsDesktop : [1199,{$formAtts.itemsdesktop|intval}],{/if}
            {if $formAtts.itemsdesktopsmall}itemsDesktopSmall : [979,{$formAtts.itemsdesktopsmall|intval}],{/if}
            {if $formAtts.itemstablet}itemsTablet : [768,{$formAtts.itemstablet|intval}],{/if}

            {if $formAtts.itemsmobile}itemsMobile : [479,{$formAtts.itemsmobile|intval}],{/if}
            {if $formAtts.itemscustom}itemsCustom : {$formAtts.itemscustom},{/if}
            singleItem : false,         // true : show only 1 item
            itemsScaleUp : false,
            slideSpeed : {if $formAtts.slidespeed}{$formAtts.slidespeed|intval}{else}200{/if},  //  change speed when drag and drop a item
            paginationSpeed : {if $formAtts.paginationspeed}{$formAtts.paginationspeed}{else}800{/if}, // change speed when go next page

            autoPlay : {$formAtts.autoplay},   // time to show each item
            stopOnHover : {if $formAtts.stoponhover}true{else}false{/if},
            navigation : {if $formAtts.navigation}true{else}false{/if},
            navigationText : ["&lsaquo;", "&rsaquo;"],

            scrollPerPage : {if $formAtts.scrollperpage}true{else}false{/if},
            
            pagination : {$formAtts.pagination}, // show bullist
            paginationNumbers : {if $formAtts.paginationnumbers}true{else}false{/if}, // show number
            
            responsive : {if $formAtts.responsive}true{else}false{/if},
            //responsiveRefreshRate : 200,
            //responsiveBaseWidth : window,
            
            //baseClass : "owl-carousel",
            //theme : "owl-theme",
            
            lazyLoad : {$formAtts.lazyload},
            lazyFollow : {if $formAtts.lazyfollow}true{else}false{/if},  // true : go to page 7th and load all images page 1...7. false : go to page 7th and load only images of page 7th
            lazyEffect : "{$formAtts.lazyeffect}",
            
            autoHeight : {if $formAtts.autoheight}true{else}false{/if},

            //jsonPath : false,
            //jsonSuccess : false,

            //dragBeforeAnimFinish
            mouseDrag : {if $formAtts.mousedrag}true{else}false{/if},
            touchDrag : {if $formAtts.touchdrag}true{else}false{/if},
            
            addClassActive : true,
            {if $formAtts.rtl}direction:'rtl',{/if}
            //transitionStyle : "owl_transitionStyle",
            
            //beforeUpdate : false,
            //afterUpdate : false,
            //beforeInit : false,
            //afterInit : false,
            //beforeMove : false,
            //afterMove : false,
            afterAction : SetOwlCarouselFirstLast,
            //startDragging : false,
            //afterLazyLoad: false
    

        });
		
		var number_item = $('.owl-featured .owl-item').length;
	  if($('.ApProductCarousel').hasClass('owl-featured'))
	  {
	   $('.owl-featured .owl-next').empty();
	   $('.owl-featured .owl-prev').empty();
	   $('.owl-featured .owl-next').append($('.owl-featured .owl-item.active').next().find('.product_img_link').html());
	   $('.owl-featured .owl-prev').append($('.owl-featured .owl-item').last().find('.product_img_link').html());
	   
	   var delay_value = {if $formAtts.paginationspeed}{$formAtts.paginationspeed}{else}800{/if};
	   
	   $('.owl-featured .owl-next').click(function(){   
	    
	    ChangeImageNavigation(number_item);
	   });
	   
	   $('.owl-featured .owl-prev').click(function(){   
	    ChangeImageNavigation(number_item);
	    
	   });
	   
	   var index_active = $('.owl-featured .owl-item.active').index();
	   var check_change;
	   $('.owl-featured .owl-item').hover(function(){   
	    check_change = setInterval(function(){    
	     if(index_active != $('.owl-featured .owl-item.active').index())
	     {
	      ChangeImageNavigation(number_item)
	      index_active = $('.owl-featured .owl-item.active').index();
	      
	     }
	    },500);
	    
	   },function(){   
	    clearInterval(check_change);
	   });
	   
	   {if $formAtts.autoplay}
	    var check_change_autoplay;
	    check_change_autoplay = setInterval(function(){    
	     if(index_active != $('.owl-featured .owl-item.active').index())
	     {
	      ChangeImageNavigation(number_item)
	      index_active = $('.owl-featured .owl-item.active').index();
	      
	     }
	    },{if $formAtts.slidespeed}{$formAtts.slidespeed|intval}{else}200{/if});
	    {if $formAtts.stoponhover}
	     $('.owl-featured .owl-item').hover(function(){
	      clearInterval(check_change_autoplay);
	     },function(){
	      check_change_autoplay = setInterval(function(){    
	       if(index_active != $('.owl-featured .owl-item.active').index())
	       {
	        ChangeImageNavigation(number_item)
	        index_active = $('.owl-featured .owl-item.active').index();
	        
	       }
	      },{if $formAtts.slidespeed}{$formAtts.slidespeed|intval}{else}200{/if});
	     });
	    {/if}
	   {/if}
	   
	  }
	  
	   
	});

	function ChangeImageNavigation(number_item)
	{
	 $('.owl-featured .owl-next').empty();
	 $('.owl-featured .owl-prev').empty();
	 if($('.owl-featured .owl-item.active').index() == 0)
	 {     
	  $('.owl-featured .owl-next').append($('.owl-featured .owl-item.active').next().find('.product_img_link').html());
	  $('.owl-featured .owl-prev').append($('.owl-featured .owl-item').last().find('.product_img_link').html());
	 }
	 else if($('.owl-featured .owl-item.active').index() == number_item-1)
	 {     
	  $('.owl-featured .owl-next').append($('.owl-featured .owl-item').first().find('.product_img_link').html());
	  $('.owl-featured .owl-prev').append($('.owl-featured .owl-item.active').prev().find('.product_img_link').html());
	 }
	 else
	 {     
	  $('.owl-featured .owl-next').append($('.owl-featured .owl-item.active').next().find('.product_img_link').html());
	  $('.owl-featured .owl-prev').append($('.owl-featured .owl-item.active').prev().find('.product_img_link').html());
	 }
	}
      function SetOwlCarouselFirstLast(el){
            el.find(".owl-item").removeClass("first_item");
            el.find(".owl-item.active").first().addClass("first_item");
            
            el.find(".owl-item").removeClass("last_item");
            el.find(".owl-item.active").last().addClass("last_item");
      }
</script>