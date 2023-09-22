{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApInstagram -->
 <div class="instagram-block">
	{($apLiveEdit)?$apLiveEdit:''}{* HTML form , no escape necessary *}
    {if isset($formAtts.title) && $formAtts.title}
    <h4 class="title_block">{$formAtts.title|escape:'html':'UTF-8'}</h4>
    {/if}
    {if isset($formAtts.client_id) && $formAtts.client_id}
    <div class="block-content">
        <div id="instafeed"></div>
		<p class="link-instagram">
		{if isset($formAtts.profile_link) && $formAtts.profile_link}
			<a href="https://instagram.com/{$formAtts.profile_link|escape:'html':'UTF-8'}" title="{l s='View all in instagram' mod='appagebuilder'}"><i class="fa fa-instagram"></i>&nbsp;&nbsp;{l s='View all in instagram' mod='appagebuilder'}</a>
		{/if}
		</p>
    </div>
    <script type="text/javascript">
         var feed = new Instafeed({
            clientId: "{$formAtts.client_id|escape:'html':'UTF-8'}",
            {if isset($formAtts.access_token) && $formAtts.access_token}
            accessToken: "{$formAtts.access_token|escape:'html':'UTF-8'}",
            {/if}
            {if isset($formAtts.target) && $formAtts.target}
            target: "{$formAtts.target|escape:'html':'UTF-8'}",
            {/if}
            {if isset($formAtts.template) && $formAtts.template}
            template: "{$formAtts.template|escape:'html':'UTF-8'}",
            {/if}
            {if isset($formAtts.get) && $formAtts.get}
            get: "{$formAtts.get|escape:'html':'UTF-8'}",
            {/if}
             {if isset($formAtts.tag_name) && $formAtts.tag_name}
            tagName: "{$formAtts.tag_name|escape:'html':'UTF-8'}",
            {/if}
             {if isset($formAtts.location_id) && $formAtts.location_id}
            locationId: "{$formAtts.get|escape:'html':'UTF-8'}",
            {/if}
            {if isset($formAtts.user_id) && $formAtts.user_id}
            userId: "{$formAtts.user_id|intval}",
            {/if}
            {if isset($formAtts.sort_by) && $formAtts.sort_by}
            sortBy: "{$formAtts.sort_by|escape:'html':'UTF-8'}",
            {/if}
            {if isset($formAtts.links) && $formAtts.links}
            links: "{$formAtts.links}{*full link can not validate*}",
            {/if}    
            {if isset($formAtts.limit) && $formAtts.limit}
            limit: "{$formAtts.limit|intval}",
            {/if}
            {if isset($formAtts.resolution) && $formAtts.resolution}
            resolution: "{$formAtts.resolution|escape:'html':'UTF-8'}",
            {/if}
            {if isset($formAtts.carousel_type) && $formAtts.carousel_type !== "list"}
            after: function() {
                {if $formAtts.carousel_type == "boostrap"}

                {else}
                    $('#instafeed').owlCarousel({
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
                {/if}
            }
            {/if}
        });
        feed.run();
		
		function SetOwlCarouselFirstLast(el){
			el.find(".owl-item").removeClass("first");
			el.find(".owl-item.active").first().addClass("first");

			el.find(".owl-item").removeClass("last");
			el.find(".owl-item.active").last().addClass("last");
		}
    </script>    
    {/if}
	{($apLiveEditEnd)?$apLiveEditEnd:''}{* HTML form , no escape necessary *}
</div>