{*
 *  Leo Theme for Prestashop 1.6.x
 *
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
*}
{if isset($reloadBack) && $reloadBack==1}
    {foreach $images as $image}
        <div style="background:url('{$image.link|escape:'html':'UTF-8'}') no-repeat center center;" class="pull-left" data-image="{$image.link|escape:'html':'UTF-8'}" data-val="../../img/patterns/{$image.name|escape:'html':'UTF-8'}">

        </div>
    {/foreach}
{else}
{if !(isset($reloadSliderImage) && $reloadSliderImage==1)}
<div class="panel product-tab">
<h3 class="tab" >
    {l s='Images Manager' mod='leotempcp'}
    <span class="badge" id="countImage">{$countImages|escape:'html':'UTF-8'}</span>
    <label class="control-label col-lg-3 file_upload_label">
            {l s='Format:' mod='leotempcp'} JPG, GIF, PNG. {l s='Filesize:' mod='leotempcp'} {$max_image_size|string_format:"%.2f|escape:'html':'UTF-8'"} {l s='MB max.' mod='leotempcp'}
    </label>
</h3>

<div class="row">
    <div class="form-group">
        <div class="col-lg-12">
            {$image_uploader}{* HTML form , no escape necessary *}
        </div>
    </div>
</div>
    
<div class="row">
    <div class="form-group">
        <ul id="list-imgs">
{/if}
        {foreach from=$images item=image name=myLoop}
            <li><div class="row img-row">
                    <a class="label-tooltip img-link" onclick="selectImage()" data-toggle="tooltip" href="{$image.link|escape:'html':'UTF-8'}" title="{$image.name|escape:'html':'UTF-8'}" style="height:70px;overflow: hidden">
                        <img class="select-img" data-name="{$image.name|escape:'html':'UTF-8'}" title="" width="70" alt="" src="{$image.link|escape:'html':'UTF-8'}"/>
                    </a>
                 </div>
                <div class="row">
                    <a class="fancybox" data-toggle="tooltip" href="{$image.link|escape:'html':'UTF-8'}" title="{l s='Click to view' mod='leotempcp'}">
                        <i class="icon-eye-open"></i>
                        {l s='View' mod='leotempcp'}
                    </a>
                    <a href="{$link->getAdminLink('AdminLeotempcpImages')}&imgName={$image.name|escape:'url'}" class="text-danger delete-image" title="{l s='Delete Selected Image?' mod='leotempcp'}" onclick="if (confirm('{l s='Delete Selected Image?' mod='leotempcp'}')) {
                            return deleteImage($(this));
                        } else {
                            return false;
                        }
                        ;">
                        <i class="icon-remove"></i>
                        {l s='Delete' mod='leotempcp'}
                    </a>
                </div></li>
        {/foreach}
{if !(isset($reloadSliderImage) && $reloadSliderImage==1)}
        </ul>
    </div>
</div>
<script type="text/javascript">
var upbutton = "{l s='Upload an image' mod='leotempcp'}";
var imgManUrl = '{$imgManUrl|escape:'html':'UTF-8'}';
{literal}
    $(document).ready(function(){
        $('.fancybox').fancybox();
        
    });
    $(".img-link").click(function(){
       return false;
    });
    function selectImage(url){
        return false;
    }
    
    function deleteImage(element){
        $.ajax({
            type: 'GET',
            url: element.attr("href") + '&reloadSliderImage=1&sortBy=name',
            data: '',
            dataType: 'json',
            cache: false, // @todo see a way to use cache and to add a timestamps parameter to refresh cache each 10 minutes for example
            success: function(data)
            {
                 $("#list-imgs").html(data);
                 $('.label-tooltip').tooltip();
                 $('.fancybox').fancybox();
            }
        });
        
        return false;
    }
    
    function getUrlVars()
    {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }
{/literal}
</script>
{/if}
{/if}