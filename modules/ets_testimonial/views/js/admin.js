/**
 * 2007-2022 ETS-Soft
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses. 
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 *  @author ETS-Soft <etssoft.jsc@gmail.com>
 *  @copyright  2007-2022 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */
var etsTTNAddProductName = function(event,data,formatted)
{
    if (data == null)
		return false;
    $('#id_product').val(data[0]);
    if($('#product_name').parent().next('.product_selected').length <=0)
    {
       $('#product_name').parent().after('<div class="product_selected">'+(data[3] ? '<img src="'+data[3]+'" stype="width: 32px;"> ':'')+data[1]+' ('+data[2]+') <span class="delete_product_search">delete</span><div>');
       $('#product_name').val(''); 
       $('.product_selected').parent().addClass('has_product');
    }
    else
    {
        $('#product_name').parent().next('.product_selected').html((data[3] ? '<img src="'+data[3]+'" stype="width: 32px;"> ':'')+ data[1]+' ('+data[2]+') <span class="delete_product_search">delete</span>');
        $('#product_name').val('');
        $('.product_selected').parent().addClass('has_product');
    }    
}
function ets_ttn_displayBulkActionReview()
{
    if($('.ttn_reviews_readed:checked').length )
    {
        $('#bulk_action_ttn_reviews').show();
    }
    else
    {
        $('#bulk_action_ttn_reviews').hide();
    }
}
$(document).ready(function(){
    if($('input.star'))
        $('input.star').ets_rating();
    $('.ttn_reviews_readed_all').click(function(){
        if (this.checked) {
           $('.ttn_reviews_readed').prop('checked', true);
        } else {
            $('.ttn_reviews_readed').prop('checked', false);
        } 
        ets_ttn_displayBulkActionReview();
    });
    $(document).on('click','.ttn_reviews_readed',function(){
        if(this.checked){
            if($('.ttn_reviews_readed').length== $('.ttn_reviews_readed:checked').length)
                $('.ttn_reviews_readed_all').prop('checked', true);
        }
        else
        {
            $('.ttn_reviews_readed_all').prop('checked', false);
        }
        ets_ttn_displayBulkActionReview();
    });
    $(document).on('change','#bulk_action_ttn_reviews',function(){
        if($(this).val()=='')
            return false;
        if($('#bulk_action_ttn_reviews').val()=='delete_all')
            var result = confirm(confirm_delete_all_review);
        else if($('#bulk_action_ttn_reviews').val()=='duplicate_all')
            var result = confirm(confirm_duplicate_all_review);
        else
            var result = true;
        if(!result)
        {
            $(this).val('');
            return false;
        } 
        $(this).after('<input type="hidden" name="submitBulkActionReview" value="1">');
        $(this).parents('form').submit();
    });
    $(document).on('click','#additional-images-thumbnails a,#avatar-images-thumbnails a',function(){
       return confirm(comfirm_delete_image_text); 
    });
    $(document).on('click','.delete_product_search',function(e){
        e.preventDefault();
        $('.product_selected').parent().removeClass('has_product');
        $('.product_selected').remove();
        $('#id_product').val('');
    });
    if($('.form_search_product #product_name').length)
    {
        $('.form_search_product #product_name').autocomplete(ets_link_search_product,{
    		minChars: 1,
    		autoFill: true,
    		max:20,
    		matchContains: true,
    		mustMatch:false,
    		scroll:false,
    		cacheLength:0,
    		formatItem: function(item) {
    			return '<img src="'+item[3]+'">'+' '+item[1]+' ('+item[2]+')';
    		}
    	}).result(etsTTNAddProductName);
        if($('.form_search_product #product_name').val())
        {
            if($('#product_name').parent().next('.product_selected').length <=0)
            {
               $('#product_name').parent().after('<div class="product_selected">'+$('.form_search_product #product_name').val()+'<span class="delete_product_search">delete</span><div>');
               $('#product_name').val(''); 
               $('.product_selected').parent().addClass('has_product');
            }
        }
    }
    $(document).on('click','.ets_ttn-panel .list-action',function(){
        if(!$(this).hasClass('disabled'))
        {            
            $(this).addClass('disabled');
            var $this= $(this);
            $.ajax({
                url: $(this).attr('href')+'&ajax=1',
                data: {},
                type: 'post',
                dataType: 'json',                
                success: function(json){ 
                    $this.removeClass('disabled');
                    if(json.success)
                    {
                        if(json.enabled=='1')
                        {
                            $this.removeClass('action-disabled').addClass('action-enabled');
                            $this.html('<i class="fa fa-check"></i>');
                        }                        
                        else
                        {
                            $this.removeClass('action-enabled').addClass('action-disabled');
                            $this.html('<i class="fa fa-remove"></i>');
                        }
                        $this.attr('href',json.href);
                        if(json.title)
                            $this.attr('title',json.title); 
                        if(json.delete_button)
                            $this.remove();
                        showSuccessMessage(json.success,3000);
                    }
                    if(json.errors)
                        showErrorMessage(json.errors,3000);
                        
                                                                
                },
                error: function(error)
                {                                      
                    $this.removeClass('disabled');
                }
            });
        }
        return false;
    });
    if($('#list-ttn_reviews').length)
    {
        var $myReviews = $("#list-ttn_reviews");
        var pagination_limit = $('#paginator_review_select_limit').val();
    	$myReviews.sortable({
    		opacity: 0.6,
            handle: ".dragHandle",
    		update: function() {
    			var order = $(this).sortable("serialize") + "&action=updateReviewOrdering&limit="+pagination_limit;						
                $.ajax({
        			type: 'POST',
        			headers: { "cache-control": "no-cache" },
        			url: '',
        			async: true,
        			cache: false,
        			dataType : "json",
        			data:order,
        			success: function(jsonData)
        			{
                        if(jsonData.success)
                        {
                            showSuccessMessage(jsonData.success,3000);
                            var i=1;
                            $('.dragGroup span').each(function(){
                                $(this).html(i+(jsonData.page-1)*pagination_limit);
                                i++;
                            });
                        }
                        if(jsonData.errors)
                        {
                            showErrorMessage(jsonData.errors,3000);
                            $myReviews.sortable("cancel");
                        }
                    }
        		});
    		},
        	stop: function( event, ui ) {
       		}
    	});
    }
});