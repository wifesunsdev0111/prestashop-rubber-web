{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApBlockOwlCarouselItem -->
{if isset($formAtts.title) && $formAtts.title}
	<h4 class="title_block">{$formAtts.title|escape:'html':'UTF-8'}</h4>
{/if}
{if isset($formAtts.description) && $formAtts.description}
	<p>{$formAtts.description}{*contain html can not escape*}</p>
{/if}
<div id="{$carouselName|escape:'html':'UTF-8'}" class="owl-carousel owl-theme">
	{$Num=array_chunk($formAtts.slides, $formAtts.itempercolumn)}
	{foreach from=$Num item=sliders name=manuloop} 
	<div class="item">
		{foreach from=$sliders item=slider}
			<div class="block-carousel-container">
				<div class="left-block">
					<div class="block-carousel-image-container image">
						<div class="ap-more-info" data-id="{$slider.id|intval}"></div>
						{if $slider.link}
						<a title="{l s='%s' sprintf=[$slider.title] mod='appagebuilder'}" {if $formAtts.is_open}target="_blank"{/if} href="{$slider.link}{*full link can not escape*}">
						{/if}
						
						{if isset($slider.image) && !empty($slider.image)}
							<img class="img-responsive" src="{$slider.image}{*full link can not escape*}" alt="{if isset($slider.title)}{$slider.title|escape:'html':'UTF-8'}{/if}"/>
						{/if}
						{if isset($slider.title) && !empty($slider.title)}
							<div class="title">{$slider.title|escape:'html':'UTF-8'}</div>
						{/if}
						{if isset($slider.descript) && !empty($slider.descript)}
							<div class="descript">{$slider.descript|rtrim}{*contain html can not escape*}</div>
						{/if}
						{if $slider.link}{*full link can not escape*}
						</a>
						{/if}
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
            afterMove : SetOwlCarouselFirstLast,
            //afterAction : false,
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