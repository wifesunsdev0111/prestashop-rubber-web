{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\ApFacebook -->
 <div class="widget-facebook block">
	{($apLiveEdit)?$apLiveEdit:''}{* HTML form , no escape necessary *}
	<div id="fb-root"></div>
    {if isset($formAtts.title) && $formAtts.title}
    <h4 class="title_block">{$formAtts.title|escape:'html':'UTF-8'}</h4>
    {/if}
    {if isset($formAtts.page_url) && $formAtts.page_url}
    <script type="text/javascript">
    // Check avoid include duplicate library Facebook SDK
    if($("#facebook-jssdk").length == 0) {
        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    }
    </script>
    
    <div class="fb-like-box" data-href="{$formAtts.page_url|escape:'html':'UTF-8'}" 
		{if isset($formAtts.height) && $formAtts.height}data-height={$formAtts.height|escape:'html':'UTF-8'}{/if}
		{if isset($formAtts.width) && $formAtts.width}data-width={$formAtts.width|escape:'html':'UTF-8'}{/if}
    	data-colorscheme="{$formAtts.target|escape:'html':'UTF-8'}" 
    	data-show-faces="{if $formAtts.show_faces}true{else}false{/if}" 
    	data-header="{if $formAtts.show_header}true{else}false{/if}" 
    	data-stream="{if $formAtts.show_stream}true{else}false{/if}" 
    	data-show-border="{if $formAtts.show_border}true{else}false{/if}">
    </div>
    {/if}
	{($apLiveEditEnd)?$apLiveEditEnd:''}{* HTML form , no escape necessary *}
</div>