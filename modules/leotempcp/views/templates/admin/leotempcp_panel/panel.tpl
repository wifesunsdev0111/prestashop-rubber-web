{*
 *  Leo Theme for Prestashop 1.6.x
 *
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
*}
{if $showed==true}
 {$toolbar}{* HTML form , no escape necessary *}
<div id="leo-page" class="clearfix">
	
	<div class="note">

		<p>+ {l s='Drop modules from hooks layouts to "<b>UnHook Modules</b>" Panel to unhook them'  mod='leotempcp'}. {l s='Drag and drop modules from hooks layouts to update theirs order and hook position'  mod='leotempcp'}</p>
		<p>+  {l s='Override hook feature only applies for <b>HOOK_HEADERRIGHT, HOOK_SLIDESHOW, HOOK_TOPNAVIATION, HOOK_SLIDESHOW, HOOK_PROMOTETOP, HOOK_CONTENTBOTTOM, HOOK_BOTTOM</b>'  mod='leotempcp'}</p>
		<p>+ {l s='Here only shows all of installed modules having hooks supportting for LeoTheme Layout.' mod='leotempcp'}
	</div>	
	<div class="leo-container holdposition" id="noposition">
		<div class="pos">{l s='UnHook Modules'  mod='leotempcp'} </div>
		 {foreach from=$modules item=module name=leotempcp}
			<div class="module-pos" id="module-{$module->id|escape:'html':'UTF-8'}">
				<a class="editmod" href="{$moduleEditURL|escape:'html':'UTF-8'}&module_name={$module->name|escape:'html':'UTF-8'}&configure={$module->name|escape:'html':'UTF-8'}" data-mod="{$module->name|escape:'html':'UTF-8'}"></a>
				<div class="leo-editmodule" rel="{$module->author|escape:'html':'UTF-8'}">
				<img src="{$URI|escape:'html':'UTF-8'}{$module->name|escape:'html':'UTF-8'}/logo.png"/>
				{$module->displayName|escape:'html':'UTF-8'}
				</div>
			
			</div>
		 {/foreach}
	</div>
	<br>
	<div class="leotheme-layout">
		<div id="leo-header">
                    <div id="leo-displaynav" class="leo-container overridehook" data-position="displayNav"><div class="pos">HOOK_DISPLAYNAV</div>
			{if isset($hookModules['displayNav']) && $hookModules['displayNav']['module_count'] > 0}
			{foreach $hookModules['displayNav']['modules'] as $position => $module} 
			{if isset($module['instance'])}
			<div class="module-pos" id="module-{$module['instance']->id|escape:'html':'UTF-8'}" data-position="{$module['id_hook']|escape:'html':'UTF-8'}">
				<a class="editmod" href="{$moduleEditURL|escape:'html':'UTF-8'}&module_name={$module['name']|escape:'html':'UTF-8'}&configure={$module['name']|escape:'html':'UTF-8'}" data-mod="{$module['name']|escape:'html':'UTF-8'}"></a><div class="edithook"></div>
				<div class="leo-editmodule">
					<img src="{$URI|escape:'html':'UTF-8'}{$module['name']|escape:'html':'UTF-8'}/logo.png"/>
					{$module['instance']->displayName|escape:'html':'UTF-8'}
				</div>
			</div>
			{/if}
			{/foreach}
			{/if}
                    </div>

			<div class="leoheader clearfix">
				<div id="leologo"><div class="pos">LOGO</div></div>
				<div id="leo-hheaderright" class="leo-container overridehook" data-position="displayTop"><div class="pos">HOOK_TOP</div>
					{if isset($hookModules['displayTop']) && $hookModules['displayTop']['module_count'] > 0}
					{foreach $hookModules['displayTop']['modules'] as $position => $module}
					{if isset($module['instance'])}
					<div class="module-pos" id="module-{$module['instance']->id|escape:'html':'UTF-8'}" data-position="{$module['id_hook']|escape:'html':'UTF-8'}">
						<a class="editmod" href="{$moduleEditURL|escape:'html':'UTF-8'}&module_name={$module['name']|escape:'html':'UTF-8'}&configure={$module['name']|escape:'html':'UTF-8'}" data-mod="{$module['name']|escape:'html':'UTF-8'}"></a><div class="edithook"></div>

						<div class="leo-editmodule">
							<img src="{$URI|escape:'html':'UTF-8'}{$module['name']|escape:'html':'UTF-8'}/logo.png"/>
							{$module['instance']->displayName|escape:'html':'UTF-8'}
						</div>
					</div>
					{/if}
					{/foreach}
					{/if}
				</div>
			</div>
		</div>
		
		
		<div id="leo-menu" class="leo-container overridehook" data-position="topNavigation"><div class="pos">HOOK_TOPNAVIATION</div>
			{if isset($hookModules['topNavigation']) && $hookModules['topNavigation']['module_count'] > 0}
			{foreach $hookModules['topNavigation']['modules'] as $position => $module} 
			{if isset($module['instance'])}
			<div class="module-pos" id="module-{$module['instance']->id|escape:'html':'UTF-8'}" data-position="{$module['id_hook']|escape:'html':'UTF-8'}">
				<a class="editmod" href="{$moduleEditURL|escape:'html':'UTF-8'}&module_name={$module['name']|escape:'html':'UTF-8'}&configure={$module['name']|escape:'html':'UTF-8'}" data-mod="{$module['name']|escape:'html':'UTF-8'}"></a><div class="edithook"></div>
				<div class="leo-editmodule">
					<img src="{$URI|escape:'html':'UTF-8'}{$module['name']|escape:'html':'UTF-8'}/logo.png"/>
					{$module['instance']->displayName|escape:'html':'UTF-8'}
				</div>
			</div>
			{/if}
			{/foreach}
			{/if}
		</div>
		
		
		<div id="leo-slideshow" class="leo-container overridehook" data-position="displaySlideshow"><div class="pos">HOOK_SLIDESHOW</div>
				{if isset($hookModules['displaySlideshow']) && $hookModules['displaySlideshow']['module_count'] > 0}
				{foreach $hookModules['displaySlideshow']['modules'] as $position => $module}
				{if isset($module['instance'])}
				<div class="module-pos" id="module-{$module['instance']->id|escape:'html':'UTF-8'}" data-position="{$module['id_hook']|escape:'html':'UTF-8'}">
					<a class="editmod" href="{$moduleEditURL|escape:'html':'UTF-8'}&module_name={$module['name']|escape:'html':'UTF-8'}&configure={$module['name']|escape:'html':'UTF-8'}" data-mod="{$module['name']|escape:'html':'UTF-8'}"></a><div class="edithook"></div>
					<div class="leo-editmodule">
						<img src="{$URI|escape:'html':'UTF-8'}{$module['name']|escape:'html':'UTF-8'}/logo.png"/>
						{$module['instance']->displayName|escape:'html':'UTF-8'}
					</div>
				</div>
				{/if}
				{/foreach}
				{/if}
		</div>
		<div id="leo-displayTopColumn"  class="leo-container overridehook" data-position="displayTopColumn"><div class="pos">HOOK_DISPLAYTOPCOLUMN</div>
			{if isset($hookModules['displayTopColumn']) && $hookModules['displayTopColumn']['module_count'] > 0}
			{foreach $hookModules['displayTopColumn']['modules'] as $position => $module}
			{if isset($module['instance'])}
			<div class="module-pos" id="module-{$module['instance']->id|escape:'html':'UTF-8'}" data-position="{$module['id_hook']|escape:'html':'UTF-8'}">
				<a class="editmod" href="{$moduleEditURL|escape:'html':'UTF-8'}&module_name={$module['name']|escape:'html':'UTF-8'}&configure={$module['name']|escape:'html':'UTF-8'}" data-mod="{$module['name']|escape:'html':'UTF-8'}"></a><div class="edithook"></div>
				<div class="leo-editmodule">
					<img src="{$URI|escape:'html':'UTF-8'}{$module['name']|escape:'html':'UTF-8'}/logo.png"/>
					{$module['instance']->displayName|escape:'html':'UTF-8'}
				</div>
			</div>
			{/if}
			{/foreach}
			{/if}
		</div>

		<div id="leo-content" class="clearfix"  >
			<div id="leo-left" class="leo-container" data-position="displayLeftColumn"><div class="pos">HOOK_LEFT</div>
				{if isset($hookModules['displayLeftColumn']) && $hookModules['displayLeftColumn']['module_count'] > 0}
				{foreach $hookModules['displayLeftColumn']['modules'] as $position => $module} 
				{if isset($module['instance'])}
				<div class="module-pos" id="module-{$module['instance']->id|escape:'html':'UTF-8'}" data-position="{$module['id_hook']|escape:'html':'UTF-8'}">
					<a class="editmod" href="{$moduleEditURL|escape:'html':'UTF-8'}&module_name={$module['name']|escape:'html':'UTF-8'}&configure={$module['name']|escape:'html':'UTF-8'}" data-mod="{$module['name']|escape:'html':'UTF-8'}"></a><div class="edithook"></div>
					<div class="leo-editmodule">
						<img src="{$URI|escape:'html':'UTF-8'}{$module['name']|escape:'html':'UTF-8'}/logo.png"/>
						{$module['instance']->displayName|escape:'html':'UTF-8'}
					</div>
				</div>
				{/if}
				{/foreach}
				{/if}
			
			</div>
			<div id="leo-center">
				<div  class="leo-container inner" data-position="displayHome" style="min-height:250px"><div class="pos">HOOK_HOME</div>
				{if isset($hookModules['displayHome']) && $hookModules['displayHome']['module_count'] > 0}
				{foreach $hookModules['displayHome']['modules'] as $position => $module}
				{if isset($module['instance'])}
				<div class="module-pos" id="module-{$module['instance']->id|escape:'html':'UTF-8'}" data-position="{$module['id_hook']|escape:'html':'UTF-8'}">
					<a class="editmod" href="{$moduleEditURL|escape:'html':'UTF-8'}&module_name={$module['name']|escape:'html':'UTF-8'}&configure={$module['name']|escape:'html':'UTF-8'}" data-mod="{$module['name']|escape:'html':'UTF-8'}"></a><div class="edithook"></div>
					<div class="leo-editmodule">
						<img src="{$URI|escape:'html':'UTF-8'}{$module['name']|escape:'html':'UTF-8'}/logo.png"/>
						{$module['instance']->displayName|escape:'html':'UTF-8'}
					</div>
				</div>
				{/if}
				{/foreach}
				{/if}
				</div>
				
				<div  class="leo-container overridehook inner" data-position="displayContentBottom" style="min-height:50px">
					<div class="pos">HOOK_CONTENTBOTTOM</div>
					{if isset($hookModules['displayContentBottom']) && $hookModules['displayContentBottom']['module_count'] > 0}
					{foreach $hookModules['displayContentBottom']['modules'] as $position => $module}
					<div class="module-pos" id="module-{$module['instance']->id|escape:'html':'UTF-8'}" data-position="{$module['id_hook']|escape:'html':'UTF-8'}">
						<a class="editmod" href="{$moduleEditURL|escape:'html':'UTF-8'}&module_name={$module['name']|escape:'html':'UTF-8'}&configure={$module['name']|escape:'html':'UTF-8'}" data-mod="{$module['name']|escape:'html':'UTF-8'}"></a><div class="edithook"></div>
						<div class="leo-editmodule">
							<img src="{$URI|escape:'html':'UTF-8'}{$module['name']|escape:'html':'UTF-8'}/logo.png"/>
							{$module['instance']->displayName|escape:'html':'UTF-8'}
						</div>
					</div>
					{/foreach}
					{/if}
				</div>
			</div>
			
			
			<div id="leo-right" class="leo-container" data-position="displayRightColumn"><div class="pos">HOOK_RIGHT</div>
				{if isset($hookModules['displayRightColumn']) && $hookModules['displayRightColumn']['module_count'] > 0}
				{foreach $hookModules['displayRightColumn']['modules'] as $position => $module}
				{if isset($module['instance'])}
				<div class="module-pos" id="module-{$module['instance']->id|escape:'html':'UTF-8'}" data-position="{$module['id_hook']|escape:'html':'UTF-8'}">
					<a class="editmod" href="{$moduleEditURL|escape:'html':'UTF-8'}&module_name={$module['name']|escape:'html':'UTF-8'}&configure={$module['name']|escape:'html':'UTF-8'}" data-mod="{$module['name']|escape:'html':'UTF-8'}"></a><div class="edithook"></div>
					<div class="leo-editmodule">
						<img src="{$URI|escape:'html':'UTF-8'}{$module['name']|escape:'html':'UTF-8'}/logo.png"/>
						{$module['instance']->displayName|escape:'html':'UTF-8'}
					</div>
				</div>
				{/if}
				{/foreach}
				{/if}
			</div>
		</div>

	



		<div id="leo-bottom" class="leo-container overridehook clearfix" data-position="displayBottom">
				<div class="pos">HOOK_BOTTOM</div>
				{if isset($hookModules['displayBottom']) && $hookModules['displayBottom']['module_count'] > 0}
				{foreach $hookModules['displayBottom']['modules'] as $position => $module}
				{if isset($module['instance'])}
				<div class="module-pos" id="module-{$module['instance']->id|escape:'html':'UTF-8'}" data-position="{$module['id_hook']|escape:'html':'UTF-8'}">
					<a class="editmod" href="{$moduleEditURL|escape:'html':'UTF-8'}&module_name={$module['name']|escape:'html':'UTF-8'}&configure={$module['name']|escape:'html':'UTF-8'}" data-mod="{$module['name']|escape:'html':'UTF-8'}"></a><div class="edithook"></div>
					<div class="leo-editmodule">
						<img src="{$URI|escape:'html':'UTF-8'}{$module['name']|escape:'html':'UTF-8'}/logo.png"/>
						{$module['instance']->displayName|escape:'html':'UTF-8'}
					</div>
				</div>
				{/if}
				{/foreach}
				{/if}
		</div>

		<div id="leo-bottom" class="leo-container overridehook clearfix" data-position="displayFooterTop">
				<div class="pos">HOOK_FOOTERTOP</div>
				{if isset($hookModules['displayFooterTop']) && $hookModules['displayFooterTop']['module_count'] > 0}
				{foreach $hookModules['displayFooterTop']['modules'] as $position => $module}
				{if isset($module['instance'])}
				<div class="module-pos" id="module-{$module['instance']->id|escape:'html':'UTF-8'}" data-position="{$module['id_hook']|escape:'html':'UTF-8'}">
					<a class="editmod" href="{$moduleEditURL|escape:'html':'UTF-8'}&module_name={$module['name']|escape:'html':'UTF-8'}&configure={$module['name']|escape:'html':'UTF-8'}" data-mod="{$module['name']|escape:'html':'UTF-8'}"></a><div class="edithook"></div>
					<div class="leo-editmodule">
						<img src="{$URI|escape:'html':'UTF-8'}{$module['name']|escape:'html':'UTF-8'}/logo.png"/>
						{$module['instance']->displayName|escape:'html':'UTF-8'}
					</div>
				</div>
				{/if}
				{/foreach}
				{/if}
				
		</div>

		<div id="leo-footer" class="clearfix">
			<div id="leo-hfooter" class="leo-container clearfix" data-position="displayFooter">
				<div class="pos">HOOK_FOOTER</div>
				{if isset($hookModules['displayFooter']) && $hookModules['displayFooter']['module_count'] > 0}
				{foreach $hookModules['displayFooter']['modules'] as $position => $module}
				{if isset($module['instance'])}
				<div class="module-pos" id="module-{$module['instance']->id|escape:'html':'UTF-8'}" data-position="{$module['id_hook']|escape:'html':'UTF-8'}">
					<a class="editmod" href="{$moduleEditURL|escape:'html':'UTF-8'}&module_name={$module['name']|escape:'html':'UTF-8'}&configure={$module['name']|escape:'html':'UTF-8'}" data-mod="{$module['name']|escape:'html':'UTF-8'}"></a><div class="edithook"></div>
					<div class="leo-editmodule">
						<img src="{$URI|escape:'html':'UTF-8'}{$module['name']|escape:'html':'UTF-8'}/logo.png"/>
						{$module['instance']->displayName|escape:'html':'UTF-8'}
					</div>
				</div>
				{/if}
				{/foreach}
				{/if}
			</div>
		</div>
		
		<div id="leo-footer-bottom" class="clearfix">
			<div id="leo-hfooter" class="leo-container clearfix" data-position="displayFooterBottom">
				<div class="pos">HOOK_FOOTER_BOTTOM</div>
				{if isset($hookModules['displayFooterBottom']) && $hookModules['displayFooterBottom']['module_count'] > 0}
				{foreach $hookModules['displayFooterBottom']['modules'] as $position => $module}
				{if isset($module['instance'])}
				<div class="module-pos" id="module-{$module['instance']->id|escape:'html':'UTF-8'}" data-position="{$module['id_hook']|escape:'html':'UTF-8'}">
					<a class="editmod" href="{$moduleEditURL|escape:'html':'UTF-8'}&module_name={$module['name']|escape:'html':'UTF-8'}&configure={$module['name']|escape:'html':'UTF-8'}" data-mod="{$module['name']|escape:'html':'UTF-8'}" ></a><div class="edithook"></div>
					<div class="leo-editmodule">
						<img src="{$URI|escape:'html':'UTF-8'}{$module['name']|escape:'html':'UTF-8'}/logo.png"/>
						{$module['instance']->displayName|escape:'html':'UTF-8'}
					</div>
				</div>
				{/if}
				{/foreach}
				{/if}
			</div>
		</div>
                        
                <div id="leo-footer-bottom" class="clearfix">
			<div id="leo-hfooter" class="leo-container clearfix" data-position="displayFootNav">
				<div class="pos">HOOK_FOOTNAV</div>
				{if isset($hookModules['displayFootNav']) && $hookModules['displayFootNav']['module_count'] > 0}
				{foreach $hookModules['displayFootNav']['modules'] as $position => $module}
				{if isset($module['instance'])}
				<div class="module-pos" id="module-{$module['instance']->id|escape:'html':'UTF-8'}" data-position="{$module['id_hook']|escape:'html':'UTF-8'}">
					<a class="editmod" href="{$moduleEditURL|escape:'html':'UTF-8'}&module_name={$module['name']|escape:'html':'UTF-8'}&configure={$module['name']|escape:'html':'UTF-8'}" data-mod="{$module['name']|escape:'html':'UTF-8'}" ></a><div class="edithook"></div>
					<div class="leo-editmodule">
						<img src="{$URI|escape:'html':'UTF-8'}{$module['name']|escape:'html':'UTF-8'}/logo.png"/>
						{$module['instance']->displayName|escape:'html':'UTF-8'}
					</div>
				</div>
				{/if}
				{/foreach}
				{/if}
			</div>
		</div>
 
	
		<div class="clearfix"  id="page-footer">
		<div id="leo-copyright" class="clearfix"><div class="pos">POWERED BY</div></div>
 
			<hr>
	</div>
	<div class="clearfix"></div>
</div>
<div id="overidehook" style="display:none">
	<div id="oh-close">Close</div>
	<form action="{$currentURL}&action=overridehook" method="post">
	<p class="clearfix"><label>{l s='Select override hook' mod='leotempcp'}</lable><br>
	<select  name="name_hook">
		<option value="0">{l s='--- Use Self Hook ---'  mod='leotempcp'}</option>

	</select>
	
	
	<input type="hidden" name="hdidmodule" id="hdidmodule" value=""/>
        <input type="hidden" name="deshook" id="deshook" value=""/>
	<input type="submit" value="{l s='Save' mod='leotempcp'}" name="submit" />
	</p>
	</form>
</div>	
<script type="text/javascript">
$("#noposition").css("height",$(".leotheme-layout").height() );
$('#leo-page .leo-container').sortable( {
			connectWith: '#leo-page .leo-container',
			containment: '#leo-page',
			forceHelperSize: true,
			forcePlaceholderSize: true,
			placeholder: 'placeholder',
			handle:".leo-editmodule"
		});
$(document).ready( function(){
	$("#desc-leohook-save, #page-header-desc-leohook-save").click( function(){
			var string = 'rand='+Math.random();
			var hook = '';
			$(".ui-sortable").each( function(){
				if( $(this).attr("data-position") && $(".module-pos",this).length>0) {
					string +="&position[]="+$(this).attr("data-position")+"|";
				 	hook += "&"+$(this).attr("data-position")+"=";
					$(".module-pos",this).each( function(){
						if( $(this).attr("id") != "" ){
							string += $(this).attr("id").replace("module-","")+",";
							hook += $(this).attr("data-position")+",";
						}				
					} );
					string = string.replace(/\,$/,"");
					hook = hook.replace(/\,$/,"");
				}	
			} );
			var unhook = '';
			$("#noposition .module-pos").each( function(){
				if( $(this).attr("data-position") ) {
					unhook += '&unhook['+$(this).attr("id").replace("module-","")+']='+$(this).attr("data-position");
				}
			} );

			$.ajax({
			  type: 'POST',
			  url: $(this).attr("href"),
			  data: string+"&"+hook+unhook,
			  success: function(){
					window.location.reload(true);
			  }
			});
		return false; 
	} );
	
	$(".module-pos .edithook").bind("click", function(){
		var parent = $(this).parent(".module-pos");
	 
		$("#overidehook").css({
			"top":$(parent).offset().top-$("#overidehook").height()-$(parent).height(),
			"left":$(parent).offset().left 
		});
		var id = $(parent).attr("id").replace("module-","");
		$("#overidehook #hdidmodule").val( id );
                var leocontainer = $(this).closest("div.leo-container");
                $("#overidehook #deshook").val( leocontainer.data("position"));
	  	 $.ajax({ type:'POST',
				  url:'{$currentURL}&action=modulehook',
				  data:'id='+id,
				  success: function( data ){
					if( data.hooks ){
						var hooks = data.hooks.split("|");
						$("#overidehook select option").each( function(){
							if(  $(this).val() == 0 || $(this).val() == 1 ){}else{ $(this).remove(); }
						});
						for (i =0; i<hooks.length; i++){
						 $("#overidehook select").append('<option value="'+hooks[i]+'">'+hooks[i]+'</option>')
						}
					}
					if( !data.hasError) {
						$("#overidehook select option").each( function(){
							if( $(this).val() == data.hook ){ 
								$(this).attr("selected","selected" );
							}
						} );
					}
					$("#overidehook").show();
				  },
				  dataType:'json'
		 });
	} );
	$("#overidehook #oh-close").click( function() { $("#overidehook").hide(); } );
	$("#overidehook form").submit( function(){
		var string  =  $("#overidehook form").serialize();
		if( $("#overidehook #hdidmodule").val() ){
			$.ajax({ type:'POST',
					  url:$(this).attr("action"),
					  data:string,
					  success: function( data ){
						$("#overidehook").hide();
					  } 
			 });
		 }
		 return false; 
	} );

        $(".editmod").each(function(){
            if($(this).attr("href").indexOf("leomanagewidgets") > -1){
                $(this).attr("href",$(this).attr("href")+"#"+$(this).closest(".leo-container").data("position"));
            }
        });
} );	
</script>
<script type="text/javascript">
 var hideSomeElement = function(){
 	$('body',$('.fancybox-iframe').contents()).find("#header").hide();
	 		$('body',$('.fancybox-iframe').contents()).find("#footer").hide();
	 		$('body',$('.fancybox-iframe').contents()).find(".page-head, #nav-sidebar ").hide();
	 		$('body',$('.fancybox-iframe').contents()).find("#content.bootstrap").css( 'padding',0).css('margin',0);


 };

$(".editmod").fancybox({
 	'type':'iframe',
 	'width':860,
 	'height':500,
 	afterLoad:function(   ){
 		if( $('body',$('.fancybox-iframe').contents()).find("#main").length  ){  
	 			setTimeout(function(){
                                      $globalthis.hideSomeElement();
                                    }, 2000);
	 			 $('.fancybox-iframe').load( hideSomeElement );

 		}else { 
 			$('body',$('.fancybox-iframe').contents()).find("#psException").html('<div class="alert error">{$noModuleConfig|escape:'html':'UTF-8'}</div>');
 		}
 	}
});
</script>
{/if}