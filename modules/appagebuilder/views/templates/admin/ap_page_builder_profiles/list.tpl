{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\admin\ap_page_builder_profiles\list -->
{$id_default = 0}
{if isset($list_profile) && $list_profile}
	<ul class="source-profile hidden">
	{$nameProfile = ''}
	{foreach $list_profile as $item}
		<li class="{if $item['active'] == 1}active{/if}">={$item['id_appagebuilder_profiles']|escape:'html':'UTF-8'}</li>
		{if $item['active'] == 1}
		{$id_default = $item['id_appagebuilder_profiles']}
		{$nameProfile = $item['name']}
		{/if}
	{/foreach}
	</ul>
	<div id="cover-live-iframe" class="">
		<div class="ap-live-tool">{l s='Mode Live Edit' mod='appagebuilder'} <span id="name-profile">{if $nameProfile} for <b>{$nameProfile|escape:'html':'UTF-8'}</b>{/if}</span>&nbsp;
			<a href="javascript:;" id="btn-change-mode" class="label-tooltip" title="{l s='Expand/Compress' mod='appagebuilder'}" data-placement="left"><i class="icon-expand"></i></a>
			<a href="javascript:;" id="btn-reload-live" class="label-tooltip" title="{l s='Reload content' mod='appagebuilder'}" data-placement="left"><i class="icon-refresh"></i></a>
			<a href="javascript:;" id="btn-preview" class="label-tooltip" title="{l s='Preview this profile' mod='appagebuilder'}" data-placement="left"><i class="icon-zoom-in"></i></a>
			<a href="javascript:;" id="btn-design-layout" class="label-tooltip" title="{l s='Mode design layout' mod='appagebuilder'}" data-placement="left"><i class="icon-desktop"></i></a>
		</div>
		<iframe id="live-edit-iframe" src="{$url_live_edit|escape:'html':'UTF-8'}{if $id_default}{$id_default|escape:'html':'UTF-8'}{/if}" 
				idProfile="{if $id_default}{$id_default|escape:'html':'UTF-8'}{/if}">
		</iframe>
	</div>
<div id="ap_loading" class="ap-loading">
    <div class="spinner">
        <div class="cube1"></div>
        <div class="cube2"></div>
    </div>
</div>
<script language="javascript" type="text/javascript">
	{addJsDef urlLiveEdit=$url_live_edit}
	{addJsDef urlPreview=$url_preview}
	{addJsDef urlEditProfile=$url_edit_profile}
	{addJsDef urlProfileDetail=$url_profile_detail}
	{addJsDef urlEditProfileToken=$url_edit_profile_token}
	{addJsDef idProfile=$id_default}
	function resize() {
		//$("#live-edit-iframe").width($(window).width() - 80);
		$("#live-edit-iframe").height($("body").height() - 
				$("#header_infos").height() - $(".page-head").height() - 
				$("#form-appagebuilder_profiles").height() - $(".ap-live-tool").height() - 
				$("#footer").height() - 80 - ($(".bootstrap .alert").length > 0 ? ($(".bootstrap .alert").height() + 20) : 0));
		
	}
	function changeProfilePreview(obj) {
		$("#ap_loading").show();
		if($('.table-responsive-row .row-selector').length){
			var td = $(obj).closest("tr").find("td:nth-child(2)");
			var tdName = $(obj).closest("tr").find("td:nth-child(3)");
		}else{
			var td = $(obj).closest("tr").find("td:nth-child(1)");
			var tdName = $(obj).closest("tr").find("td:nth-child(2)");
		}
		
		var d = new Date();
		idProfile = $.trim($(td).text());
		$("#name-profile b").text($.trim($(tdName).text()));
		$("#live-edit-iframe").attr("idProfile", idProfile);
		$("#live-edit-iframe").attr("src", urlLiveEdit + "&ap_edit_token=" + urlEditProfileToken + "&id_appagebuilder_profiles=" + idProfile + "&t=" + d.getTime());
	}
	$(function() {
		// Add button preview, tooltip for row
		totalTr = $(".appagebuilder_profiles tbody tr").length;
		$(".appagebuilder_profiles tbody tr").each(function() {
			$(this).attr("title", "{l s='When you click any profiles in profile list, this will be shown at the same screen below in mode live edit' mod='appagebuilder'}");
			// Add button preview
			if(totalTr <=1)
					var idProfile = $.trim($(this).find("td:nth-child(1)").text());
			else
				var idProfile = $.trim($(this).find("td:nth-child(2)").text());
                        
                        var url = urlProfileDetail + "&submitBulkinsertLangappagebuilder_profiles&id=" + idProfile;
			$(this).find(".pull-right ul").prepend("<li><a title='{l s='Copy data from default language to other' mod='appagebuilder'}' href='" + url + "'><i class='icon-copy'></i> {l s='Copy to Other Language' mod='appagebuilder'}</a></li>");
                        
			url = urlEditProfile + "&id_appagebuilder_profiles=" + idProfile;
			$(this).find(".pull-right ul").prepend("<li><a title='{l s='Edit in mode design layout' mod='appagebuilder'}' target='_blank' href='" + url + "'><i class='icon-desktop'></i> {l s='Edit Design Layout' mod='appagebuilder'}</a></li>");
                        
                        
                        
			url = urlPreview + "?id_appagebuilder_profiles=" + idProfile;
			$(this).find(".pull-right ul").prepend("<li><a title='{l s='Preview' mod='appagebuilder'}' target='_blank' href='" + url + "'><i class='icon-search-plus'></i> {l s='Preview' mod='appagebuilder'}</a></li>");
		});
		$(".appagebuilder_profiles tbody tr").tooltip();
		//$("#ap_loading").show();
		$(window).resize(function() {
			resize();
		});
		var d = new Date();
		if($('.table-responsive-row .row-selector').length){
			var listTd = ".appagebuilder_profiles tr td:nth-child(2)," + 
				".appagebuilder_profiles tr td:nth-child(3), .appagebuilder_profiles tr td:nth-child(4)";
		}else{
			var listTd = ".appagebuilder_profiles tr td:nth-child(1)," + 
				".appagebuilder_profiles tr td:nth-child(2), .appagebuilder_profiles tr td:nth-child(3)";
		}
		$("#live-edit-iframe").attr("src", urlLiveEdit + "&ap_edit_token=" + urlEditProfileToken + "&id_appagebuilder_profiles=" + idProfile + "&t=" + d.getTime());
		
		$(listTd).each(function() {
			$(this).attr("onclick", "return changeProfilePreview(this);");
		});
		$("#btn-reload-live").click(function() {
			$("#ap_loading").show();
			var d = new Date();	
			$("#live-edit-iframe").attr("src", urlLiveEdit + "&ap_edit_token=" + urlEditProfileToken + "&id_appagebuilder_profiles=" + idProfile + "&t=" + d.getTime());
		});
		$("#btn-preview").click(function() {
			window.open(urlPreview + "?id_appagebuilder_profiles=" + idProfile, "_blank");
		});
		$("#btn-design-layout").click(function() {
			window.open(urlEditProfile + "&id_appagebuilder_profiles=" + idProfile, "_blank");
		});
		$("#btn-change-mode").click(function() {
			if($(this).hasClass("full-screen")) {
				$("#cover-live-iframe").removeClass("full-screen");
				$(this).removeClass("full-screen");
				$(this).find("i").attr("class", "icon-expand");
			} else {
				$("#cover-live-iframe").addClass("full-screen");
				$(this).addClass("full-screen");
				$(this).find("i").attr("class", "icon-compress");
			}
		});
		$("#live-edit-iframe").load(function() {
			$("#ap_loading").hide();
		});
		$("body").addClass("page-sidebar-closed");
		resize();
	});
</script>
{else}
	<hr/>
	<center><p><a href="{$profile_link|escape:'html':'UTF-8'}" class="btn btn btn-primary"><i class="icon-file-text"></i> {l s='Create first Profile >>' mod='appagebuilder'}</a>
	</p></center>
	<script type="text/javascript">
		$(function() {
			$(".appagebuilder_profiles td:first-child").attr("colspan", $(".appagebuilder_profiles th").length);
		});
	</script>
{/if}