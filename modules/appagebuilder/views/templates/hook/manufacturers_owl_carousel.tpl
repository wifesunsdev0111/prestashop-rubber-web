{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\manufacturers_owl_carousel -->
<div id="{$carouselName|escape:'html':'UTF-8'}" class="owl-carousel owl-theme">
	{if array_key_exists('select_by_manufacture',$formAtts) && $formAtts.select_by_manufacture eq '1' }
		{$Num=array_chunk($manuselect,$formAtts.itempercolumn)}
	{else}
		{$Num=array_chunk($manuselect,$formAtts.itempercolumn)}
	{/if}

	{foreach from=$Num item=manuselect name=manuloop} 
	<div class="item">
		{foreach from=$manuselect item=manu}
			<div class="manufacturer-container manufacturer-block" itemscope itemtype="https://schema.org/Brand">
				<div class="left-block">
					<div class="manufacturer-image-container image">
						<a title="{l s='%s' sprintf=[$manu.name] mod='appagebuilder'}" href="{$link->getmanufacturerLink($manu.id_manufacturer, $manu.link_rewrite)|escape:'html':'UTF-8'}" itemprop="url">
								<img class="img-responsive" src="{$img_manu_dir}{*full link can not escape*}{$manu.id_manufacturer|intval}-{$image_type|escape:'html':'UTF-8'}.jpg" alt="{$manu.name|escape:'html':'UTF-8'}" itemprop="image" />
						</a>
					</div>
				</div>
			</div>
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
	$('#{$carouselName|escape:'html':'UTF-8'}').owlCarousel({
            items : {if $formAtts.items}{$formAtts.items|intval}{else}false{/if},
            {if $formAtts.itemsdesktop}itemsDesktop : [1199,{$formAtts.itemsdesktop|intval}],{/if}
            {if $formAtts.itemsdesktopsmall}itemsDesktopSmall : [979,{$formAtts.itemsdesktopsmall|intval}],{/if}
            {if $formAtts.itemstablet}itemsTablet : [768,{$formAtts.itemstablet|intval}],{/if}

            {if $formAtts.itemsmobile}itemsMobile : [479,{$formAtts.itemsmobile|intval}],{/if}
            {if $formAtts.itemscustom}itemsCustom : {$formAtts.itemscustom|escape:'html':'UTF-8'},{/if}
            singleItem : false,         // true : show only 1 item
            itemsScaleUp : false,
            slideSpeed : {if $formAtts.slidespeed}{$formAtts.slidespeed|intval}{else}200{/if},  //  change speed when drag and drop a item
            paginationSpeed : {if $formAtts.paginationspeed}{$formAtts.paginationspeed|intval}{else}800{/if}, // change speed when go next page

            autoPlay : {$formAtts.autoplay|escape:'html':'UTF-8'},   // time to show each item
            stopOnHover : {if $formAtts.stoponhover}true{else}false{/if},
            navigation : {if $formAtts.navigation}true{else}false{/if},
            navigationText : ["&lsaquo;", "&rsaquo;"],

            scrollPerPage : {if $formAtts.scrollperpage}true{else}false{/if},
            
            pagination : {$formAtts.pagination|escape:'html':'UTF-8'}, // show bullist
            paginationNumbers : {if $formAtts.paginationnumbers}true{else}false{/if}, // show number
            
            responsive : {if $formAtts.responsive}true{else}false{/if},
            //responsiveRefreshRate : 200,
            //responsiveBaseWidth : window,
            
            //baseClass : "owl-carousel",
            //theme : "owl-theme",
            
            lazyLoad : {$formAtts.lazyload|escape:'html':'UTF-8'},
            lazyFollow : {if $formAtts.lazyfollow}true{else}false{/if},  // true : go to page 7th and load all images page 1...7. false : go to page 7th and load only images of page 7th
            lazyEffect : "{$formAtts.lazyeffect|escape:'html':'UTF-8'}",
            
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
    });
	
function SetOwlCarouselFirstLast(el){
	el.find(".owl-item").removeClass("first");
	el.find(".owl-item.active").first().addClass("first");

	el.find(".owl-item").removeClass("last");
	el.find(".owl-item.active").last().addClass("last");
}
</script>