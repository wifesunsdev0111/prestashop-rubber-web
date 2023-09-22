{*
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
* needs, please contact us for extra customization service at an affordable price
*
*  @author ETS-Soft <etssoft.jsc@gmail.com>
*  @copyright  2007-2022 ETS-Soft
*  @license    Valid for 1 website (or project) for each purchase of license
*  International Registered Trademark & Property of ETS-Soft
*}
{if $reviews}
    <div class="ets-ttn-home-reviews" {if $ETS_TTN_BACKGROUND} style="background-image: url('{$link_base|escape:'html':'UTF-8'}/img/ets_testimonial/{$ETS_TTN_BACKGROUND|escape:'html':'UTF-8'}')"{/if}>
        <h4 class="ets-ttn-follow-title align_{$ETS_TTN_VARTICAL_TITLE|escape:'html':'UTF-8'}" {if isset($ETS_TTN_COLOR_TITLE) && $ETS_TTN_COLOR_TITLE}style="color:{$ETS_TTN_COLOR_TITLE|escape:'html':'UTF-8'}"{/if}>
            {if $ETS_TTN_TITLE}
                {$ETS_TTN_TITLE|escape:'html':'UTF-8'}<br />
            {/if}
        </h4>
    	<div id="ets-ttn-page_home_reviews" class="ets-ttn-list-reviews-slide total_items{$reviews|count}">
            {assign var="count" value=0}
            {foreach from=$reviews item='review'}
                <div class="review-item">
                    <div class="ets-ttn-review-item">
                        {if $review.license || $review.id_product || $review.additional}
                            <div class="{if ($review.license && $review.id_product) } has_clicense_idproduct{elseif $review.id_product || $review.additional} has_id_product{elseif ($review.license)} has_license{/if}">
                                {if $review.license}
                                    <div class="license">{$review.license|escape:'html':'UTF-8'}</div>
                                {/if}
                                {if $review.id_product}
                                    <div class="product">
                                        {if $review.additional}
                                            <span class="additional">
                                                <img class="" src="{$link->getMediaLink("`$smarty.const._PS_TESTIMONIAL_IMG_`additional/`$review.additional|escape:'htmlall':'UTF-8'`")}" />
                                            </span>
                                        {elseif $review.image}
                                            <span class="additional">
                                                <img class="" src="{$review.image|escape:'html':'UTF-8'}" />
                                            </span>    
                                        {/if}
                                        <div class="product-name"><a href="{$review.link_product|escape:'html':'UTF-8'}">{$review.product_name|escape:'html':'UTF-8'}</a></div>
                                    </div>
                                {elseif $review.additional}
                                    <div class="product">
                                        <span class="additional">
                                            <img class="" src="{$link->getMediaLink("`$smarty.const._PS_TESTIMONIAL_IMG_`additional/`$review.additional|escape:'htmlall':'UTF-8'`")}" />
                                        </span>
                                    </div>
                                {/if}
                            </div>
                        {/if}
                        <div class="review-item-info">
                            <div class="review_avatar"
                                style="{if $review.avatar}
                                    background-image:url({$link->getMediaLink("`$smarty.const._PS_TESTIMONIAL_IMG_`avatars/`$review.avatar|escape:'htmlall':'UTF-8'`")});
                                {else}
                                    background-image:url({$path_default_img|escape:'html':'UTF-8'});
                                {/if}">
                            </div>
                            <div title="{l s='Average rating' mod='ets_testimonial'}" class="rate-review">
                                {for $i = 1 to $review.rate}
                                    {if $i <= $review.rate}
                                        <div class="star star_on">
                                            <svg width="23" height="23" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1728 647q0 22-26 48l-363 354 86 500q1 7 1 20 0 21-10.5 35.5t-30.5 14.5q-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z"/></svg>
                                        </div>
                                    {else}
                                        <div class="star star_pos star_on_{10-($i-$review.rate)*10|intval}">
                                            <svg width="23" height="23" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1728 647q0 22-26 48l-363 354 86 500q1 7 1 20 0 21-10.5 35.5t-30.5 14.5q-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z"/></svg>
                                        </div>
                                    {/if}
                                {/for}
                                {if Ceil($review.rate)<5}
                                    {for $i = ceil($review.rate)+1 to 5}
                                        <div class="star">
                                            <svg width="23" height="23" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1201 1004l306-297-422-62-189-382-189 382-422 62 306 297-73 421 378-199 377 199zm527-357q0 22-26 48l-363 354 86 500q1 7 1 20 0 50-41 50-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z"/></svg>
                                        </div>
                                    {/for}
                                {/if}
                                {if Ceil($review.rate)!=$review.rate}
                                    <div class="star">
                                        <svg width="23" height="23" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1201 1004l306-297-422-62-189-382-189 382-422 62 306 297-73 421 378-199 377 199zm527-357q0 22-26 48l-363 354 86 500q1 7 1 20 0 50-41 50-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z"/></svg>
                                    </div>
                                {/if}                                      
                            </div>
                            <div class="testimonial_des">
                                {$review.testimonial|nl2br nofilter}
                            </div>
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>
        {if isset($ETS_TTN_COLOR_BUTTON) && $ETS_TTN_COLOR_BUTTON}
        {literal}
        <style type="text/css">
            .ets-ttn-list-reviews-slide .slick-dots button{
                border-color: {/literal}{$ETS_TTN_COLOR_BUTTON|escape:'html':'UTF-8'}{literal} !important;
            }
            .ets-ttn-list-reviews-slide .slick-dots li.slick-active button,
            .ets-ttn-list-reviews-slide .slick-dots li.ets-slick-active button{
                background-color: {/literal}{$ETS_TTN_COLOR_BUTTON|escape:'html':'UTF-8'} {literal}!important
            }
        </style>
        {/literal}
        {/if}
    </div>
{/if}