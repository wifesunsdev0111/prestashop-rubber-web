{if $page_name !='stores' && $page_name !='sitemap'}
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true&amp;amp;region={$iso_code}"></script>
<div id="map-canvas" style="width:{$width}; height:{$height};"></div>
<script type="text/javascript">
$(document).ready(function(){
{literal} 
	var latitude = {/literal}{$latitude}{literal};
	var longitude = {/literal}{$longitude}{literal};
	var zoom = {/literal}{$zoom}{literal}
	map = new google.maps.Map(document.getElementById('map-canvas'), {
		center: new google.maps.LatLng(latitude,longitude),
		zoom: zoom,
		mapTypeId: 'roadmap'
	});
	{/literal}{if isset($show_market) && $show_market == 1}{literal}
	var myLatlng = new google.maps.LatLng(latitude,longitude);
	var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
	});
	{/literal}{/if}{literal}
});
{/literal} 
</script>
{/if}


