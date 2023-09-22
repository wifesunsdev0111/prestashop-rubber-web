 <div id="livethemeeditor">
    <form  enctype="multipart/form-data" action="{$actionURL}" id="form" method="post">
        <div id="leo-customize" class="leo-customize">
            <div class="btn-show">{l s='Customize'}<span class="icon-wrench"></span></div>
            <div class="wrapper"><div id="customize-form">
                    <p>  
                        <span class="badge">{l s='Theme' mod='leotempcp'}{$themeName}</span>   <a class="label label-default pull-right" href="{$backLink}">{l s='Back'}</a>  
                    </p>        

                    <div class="buttons-group">
                        <input type="hidden" id="action-mode" name="action-mode">   
                        <a onclick="$('#action-mode').val('save-edit');
                                $('#form').submit();" class="btn btn-primary btn-xs" href="#" type="submit">{l s='Submit'}</a>
                        <a onclick="$('#action-mode').val('save-delete');
                                $('#form').submit();" class="btn btn-danger btn-xs show-for-existed" href="#" type="submit">{l s='Delete'}</a>
                    </div>
                    <hr>
                    <div class="groups">
                        <div class="form-group clearfix">
                            <label>{l s='Edit for'}</label> 
                            <select id="saved-files" name="saved_file" class="form-control">
                                <option value="">{l s='create new'}</option>
                                {foreach $profiles as $profile}
                                    <option value="{$profile}">{$profile}</option>
                                {/foreach}
                            </select> 
                        </div>
                        <div class="form-group clearfix">
                            <label class="show-for-notexisted pull-left">{l s='Or  Save New' mod='leotempcp'}&nbsp;&nbsp;&nbsp;</label><label class="show-for-existed">{l s='And Rename File To'}</label>
                            <input type="text" name="newfile">
                        </div>  
                        <div class="form-group clearfix">
                        <a href="{$imgLink}" class="btn btn btn-default btn-xs" id="upload_pattern">{l s='Upload other pattern'}</a>
                        </div>
                    <hr>
                        <div class="clearfix" id="customize-body">
                            <ul id="myCustomTab" class="nav nav-tabs">
                                {foreach $xmlselectors as $for => $output}
                                    <li><a href="#tab-{$for}">{$for}</a></li> 
                                    {/foreach}  
                            </ul>
                            <div class="tab-content" > 
                                {foreach $xmlselectors as $for => $items}
                                    <div class="tab-pane" id="tab-{$for}">

                                        {if !empty($items)}
                                            <div class="accordion"  id="custom-accordion">
                                                {foreach $items as $group}
                                                    <div class="accordion-group panel panel-default">
                                                        <div class="accordion-heading panel-heading">
                                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#custom-accordion" href="#collapse{$group.match}">
                                                                {$group.header}  
                                                            </a>
                                                        </div>

                                                        <div id="collapse{$group.match}" class="accordion-body collapse">
                                                            <div class="accordion-inner panel-body clearfix">
                                                                {foreach $group.selector as $item}

                                                                    {if isset($item.type)&&$item.type=="image"} 
                                                                        <div class="form-group background-images cleafix"> 
                                                                            <label>{$item.label}</label>
                                                                            <a class="clear-bg label label-success" href="#">{l s='Clear'}</a>
                                                                            <input value="" type="hidden" name="customize[{$group.match}][]" data-match="{$group.match}" class="input-setting" data-selector="{$item.selector}" data-attrs="background-image">

                                                                            <div class="clearfix"></div>
                                                                            <p><em style="font-size:10px">{l s='Those Images in folder YOURTHEME/img/patterns/'}</em></p>
                                                                            <div class="bi-wrapper clearfix">
                                                                                {foreach $patterns as $pattern}
                                                                                    <div style="background:url('{$backgroundImageURL}{$pattern}') no-repeat center center;" class="pull-left" data-image="{$backgroundImageURL}{$pattern}" data-val="../../img/patterns/{$pattern}">

                                                                                    </div>
                                                                                {/foreach}
                                                                            </div>
                                                                            <ul class="bg-config">
                                                                                <li>
                                                                                    <div>{l s='Attachment'}</div>
                                                                                    <select data-attrs="background-attachment" name="customize[{$group.match}][]" data-selector="{$item.selector}" data-match="{$group.match}">
                                                                                        <option value="">{l s='Not set'}</option>
                                                                                        {foreach $backGroundValue.attachment as $attachment}
                                                                                            <option value="{$attachment}">{$attachment}</option>
                                                                                        {/foreach}
                                                                                    </select>
                                                                                </li>
                                                                                <li>
                                                                                    <div>{l s='Position'}</div>
                                                                                    <select data-attrs="background-position" name="customize[{$group.match}][]" data-selector="{$item.selector}" data-match="{$group.match}">
                                                                                        <option value="">{l s='Not set'}</option>
                                                                                        {foreach $backGroundValue.position as $position}
                                                                                            <option value="{$position}">{$position}</option>
                                                                                        {/foreach}
                                                                                    </select>
                                                                                </li>
                                                                                <li>
                                                                                    <div>{l s='Repeat'}</div>
                                                                                    <select data-attrs="background-repeat" name="customize[{$group.match}][]" data-selector="{$item.selector}" data-match="{$group.match}">
                                                                                        <option value="">{l s='Not set'}</option>
                                                                                        {foreach $backGroundValue.repeat as $repeat}
                                                                                            <option value="{$repeat}">{$repeat}</option>
                                                                                        {/foreach}
                                                                                    </select>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    {elseif $item.type=="fontsize"}
                                                                        <div class="form-group cleafix">
                                                                            <label>{$item.label}</label>
                                                                            <select name="customize[{$group.match}][]" data-match="{$group.match}" type="text" class="input-setting" data-selector="{$item.selector}" data-attrs="{$item.attrs}">
                                                                                <option value="">Inherit</option>
                                                                                {for $i=9 to 16}
                                                                                    <option value="{$i}">{$i}</option>
                                                                                {/for}
                                                                            </select>   <a href="#" class="clear-bg label label-success">{l s='Clear'}</a>
                                                                        </div>
                                                                    {else}
                                                                        <div class="form-group cleafix">
                                                                            <label>{$item.label}</label>
                                                                            <input value="" size="10" name="customize[{$group.match}][]" data-match="{$group.match}" type="text" class="input-setting" data-selector="{$item.selector}" data-attrs="{$item.attrs}"><a href="#" class="clear-bg label label-success">{l s='Clear'}</a>
                                                                        </div>
                                                                    {/if}


                                                                {/foreach}
                                                            </div>
                                                        </div>
                                                    </div>              
                                                {/foreach}
                                            </div>
                                        {/if}
                                    </div>
                                {/foreach}
                            </div>      
                        </div>    
                    </div>
                </div></div></div>
    </form>
    <div id="main-preview">
        <iframe src="{$siteURL}" ></iframe> 
    </div>
</div>
        <script>
        var customizeFolderURL = '{$customizeFolderURL}';
        </script>