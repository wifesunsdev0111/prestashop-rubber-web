{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApGmap -->
{if ($page_name != 'stores' || $formAtts.stores == 1) && ($page_name != 'sitemap' || $formAtts.sitemap == 1)}
<div id="google-maps-{$formAtts.form_id|escape:'html':'UTF-8'}" class="block" style="width: 100%; 
	 height:{if isset($formAtts.height) && $formAtts.height}{$formAtts.height}{else}100%;{/if}; clear:both;">
	{($apLiveEdit)?$apLiveEdit:''}{* HTML form , no escape necessary *}
    {if isset($formAtts.title) && !empty($formAtts.title)}
    <h4 class="title_block">
    	{$formAtts.title|escape:'html':'UTF-8'}
    </h4>
    {/if}
    <div class="gmap-cover {if $hasListStore}display-list-store{else}not-display-list-store{/if}">
    	{if $hasListStore}
    	<div class="gmap-content col-lg-9 col-md-8 col-sm-8 col-xs-6">
    	{else}
    	<div class="gmap-content">
    	{/if}
            <div id="map-canvas-{$formAtts.form_id|escape:'html':'UTF-8'}" class="gmap" style="min-width:100px; min-height:100px;
            	width:{if isset($formAtts.width) && $formAtts.width}{$formAtts.width|escape:'html':'UTF-8'}{else}100%;{/if}; 
            	height:{if isset($formAtts.height) && $formAtts.height}{$formAtts.height|escape:'html':'UTF-8'}{else}100%;{/if};"></div>
    	</div>
		{if $hasListStore}
    	<div class="gmap-stores-content col-lg-3 col-md-4 col-sm-4 col-xs-6" style="height: 100%">
    		<div id="gmap-stores-list-{$formAtts.form_id|escape:'html':'UTF-8'}">
        		<ul></ul>
        	</div>
    	</div>
    	{/if}
    </div>
	{($apLiveEditEnd)?$apLiveEditEnd:''}{* HTML form , no escape necessary *}
	{addJsDef logo_store=$logo_store}
	{addJsDef img_ps_dir=$img_ps_dir}
	{addJsDef img_store_dir=$img_store_dir}		
	{addJsDefL name=translation_5}{l s='Get directions' js=1 mod='appagebuilder'}{/addJsDefL}
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&amp;amp;region=US"></script>
    <script type="text/javascript">
		var dataMarkers_{$formAtts.form_id|escape:'html':'UTF-8'} = {$markers}{*contain html can not validate*};
		var centerMarker = {$centerMarkers}{*contain html can not validate*};
		var latitude = centerMarker.latitude;
    	var longitude = centerMarker.longitude;
    	var infowindow = null;
    	var map_{$formAtts.form_id|escape:'html':'UTF-8'} = "";
    	var hasStoreIcon = true;
    	var markers_{$formAtts.form_id|escape:'html':'UTF-8'} = [];
    	var infoWindow = "";

    	function displayAMarker(data, obj, id) {
    		var m = markers_{$formAtts.form_id|escape:'html':'UTF-8'}[id];
    		google.maps.event.trigger(m, 'click');
    	}
    	function initializeListStore(data, name) {
    		var obj = $("#" + name + " ul");
    		synSize(name);
    		for(var i = 0; i < data.length; i++) {
    			var s = data[i];
    			obj.append("<li class='item-gmap-store' marker-id='" + i + "'" 
    					+ "onclick='return displayAMarker(dataMarkers_{$formAtts.form_id|escape:'html':'UTF-8'}, this, " + i + ");'>"
    					+ "<strong><b><span class='icon-map-marker'></span> "
    					+ s.name + "</b></strong><br/><text>" + s.address + "</text>");
    		}
    	}
    	
    	$(function() {
			initializeGmap(map_{$formAtts.form_id|escape:'html':'UTF-8'},
					dataMarkers_{$formAtts.form_id|escape:'html':'UTF-8'}, 
					markers_{$formAtts.form_id|escape:'html':'UTF-8'}, 
					"map-canvas-{$formAtts.form_id|escape:'html':'UTF-8'}", {$formAtts.zoom|escape:'html':'UTF-8'});
			if("{$hasListStore|escape:'html':'UTF-8'}".length > 0) {
				initializeListStore(
						dataMarkers_{$formAtts.form_id|escape:'html':'UTF-8'}, 
						"gmap-stores-list-{$formAtts.form_id|escape:'html':'UTF-8'}");
			}
		});
	</script>
</div>
{/if}