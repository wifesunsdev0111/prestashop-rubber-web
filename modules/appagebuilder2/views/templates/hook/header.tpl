{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\hook\header -->
{if isset($ap_header_config) && isset($leo_customajax)}
<script type='text/javascript'>
        var leoOption = {
		productNumber:{if $leo_customajax_pn}{$leo_customajax_pn|escape:'html':'UTF-8'}{else}0{/if},
		productInfo:{if $leo_customajax_img}{$leo_customajax_img|escape:'html':'UTF-8'}{else}0{/if},
		productTran:{if $leo_customajax_tran}{$leo_customajax_tran|escape:'html':'UTF-8'}{else}0{/if},
		productCdown: {if $leo_customajax_count}{$leo_customajax_count|escape:'html':'UTF-8'}{else}0{/if},
		productColor: {if $leo_customajax_acolor}{$leo_customajax_acolor|escape:'html':'UTF-8'}{else}0{/if},
		homeWidth: {if $homeSize}{$homeSize.width|escape:'html':'UTF-8'}{else}0{/if},
		homeheight: {if $homeSize}{$homeSize.height|escape:'html':'UTF-8'}{else}0{/if},
	}

        $(document).ready(function(){	
            var leoCustomAjax = new $.LeoCustomAjax();
            leoCustomAjax.processAjax();
        });
	{$ap_header_config|escape:'html':'UTF-8'}
</script>
{/if}