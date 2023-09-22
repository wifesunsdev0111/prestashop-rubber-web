{if class_exists("LeoFrameworkHelper")}
{$skins=LeoFrameworkHelper::getSkins($LEO_THEMENAME)}
{$directions=LeoFrameworkHelper::getLayoutDirections($LEO_THEMENAME)}
{$theme_customizations=LeoFrameworkHelper::getLayoutSettingByTheme($LEO_THEMENAME)}
<div id="leo-paneltool" class="hidden-sm hidden-xs">
{if $skins || $directions || $theme_customizations}
  <div class="paneltool themetool">
    <div class="panelbutton">
      <i class="fa fa-cog"></i>
    </div>
      <div class="panelcontent ">
          <div class="panelinner">
            <h4>{l s='Panel Tool'}</h4>
              <form action="index.php" method="post" class="form-horizontal clearfix">
                {if $skins}
                <div class="group-input clearfix">
                  <label class="col-sm-3 control-label">{l s='Theme'}</label>		
                  <div class="col-sm-9">
                    <select class="form-control" name="userparams[skin]" >
                      <option value="">{l s='Default'}</option>
                      {foreach $skins as $skin}
                      <option value="{$skin.id}"{if $skin.id==$LEO_DEFAULT_SKIN} selected="selected"{/if}>{$skin.name}</option>
                      {/foreach}
                    </select> 
                  </div>
                </div>
                {/if}
                {if $directions}
                <div class="group-input clearfix">
                    <label class="col-sm-3 control-label">{l s='Layout'}</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="userparams[layout_dir]" >
                          {foreach $directions as $direc}
                          <option value="{$direc.id}"{if $direc.id==$LEO_LAYOUT_DIRECTION} selected="selected"{/if}>{$direc.name}</option>
                          {/foreach}
                      </select>
                    </div>				
                </div>
                {/if}
                 {if $theme_customizations && isset($theme_customizations.layout) && isset($theme_customizations.layout.layout_mode) && isset($theme_customizations.layout.layout_mode.option)}
                 <div class="group-input clearfix">
                    <label class="col-sm-3 control-label">{l s='Layout'}</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="userparams[layout_mode]" >
                          {foreach $theme_customizations.layout.layout_mode.option as $layout}
                          <option value="{$layout.id}" {if $LEO_LAYOUT_MODE == $layout.id}selected="selected"{/if}>{$layout.name}</option>
                          {/foreach}
                      </select>
                    </div>
                 </div>   
                {/if}
                <div class=" clearfix" style="width:100%">
                  <input type="hidden"  name="userparams[user_setting]" value="1"/>
                  <p class="pull-right">
                    <button value="Apply" class="btn btn-small" name="btn-save" type="submit">{l s='Apply'}</button>
                    <button value="Reset" class="btn btn-small" name="btn-leo-reset" type="submit">{l s='Reset'}</button>
                  </p>
              </div>
              </form>
          </div>  
      </div>
  </div>
{/if}
                  
<div class="paneltool editortool">
  <div class="panelbutton">
    <i class="fa fa-adjust"></i>
  </div>
  <div class="panelcontent editortool">
		<div class="panelinner">
			<h4>Live Theme Editor</h4>
            {$xmlselectors = LeoFrameworkHelper::renderEdtiorThemeForm($LEO_THEMENAME)}
            {$patterns = LeoFrameworkHelper::getPattern($LEO_THEMENAME)}
            <div class="clearfix" id="customize-body">      
              <ul class="nav nav-tabs" id="panelTab">
                {foreach $xmlselectors as $for => $output}
                <li><a href="#tab-{$for}">{$for}</a></li>   
                {/foreach}
              </ul>                   
            <div class="tab-content" >
            {foreach $xmlselectors as $for => $items}
            <div class="tab-pane" id="tab-{$for}">
            {if !empty($items)}
              <div class="accordion"  id="accordion-{$for}">
              {foreach $items as $group}
                 <div class="accordion-group panel panel-default">
                    <div class="accordion-headingt panel-heading">
                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-{$for}" href="#collapse{$group.match}">
                          {$group.header}  
                      </a>
                    </div>
                    <div id="collapse{$group.match}" class="accordion-body  {if $group@iteration == 1} in{/if} collapse">
                      <div class="accordion-inner panel-body clearfix">
                      {foreach $group.selector as $item}
                        {if isset($item.type)&&$item.type=="image"} 
                        <div class="form-group background-images cleafix"> 
                          <label>{$item.label}</label>
                          <input value="" type="hidden" name="customize[{$group.match}][]" data-match="{$group.match}" class="input-setting" data-selector="{$item.selector}" data-attrs="background-image">
                          <a class="clear-bg label label-success" href="#">{l s='Clear'}</a>

                          <div class="clearfix"></div>
                           <p><em style="font-size:10px">{l s='Those Images in folder YOURTHEME/img/patterns/'}</em></p>
                          <div class="bi-wrapper clearfix">
                          {foreach $patterns as $pattern}
                            <div style="background:url('{$content_dir}themes/{$LEO_THEMENAME}/img/patterns/{$pattern}') no-repeat center center;" class="pull-left" data-image="{$content_dir}themes/{$LEO_THEMENAME}/img/patterns/{$pattern}" data-val="../../img/patterns/{$pattern}">

                            </div>
                          {/foreach}
                          </div>
                           
                           <ul class="bg-config">
                                            <li>
                                                <div>{l s='Attachment'}</div>
                                                <select class="form-control" data-attrs="background-attachment" name="customize[body][]" data-selector="{$item.selector}" data-match="{$group.match}">
                                                    <option value="">{l s='Not set'}</option>
                                                    {foreach $BACKGROUNDVALUE.attachment as $attachment}
                                                        <option value="{$attachment}">{$attachment}</option>
                                                    {/foreach}
                                                </select>
                                            </li>
                                            <li>
                                                <div>{l s='Position'}</div>
                                                <select class="form-control" data-attrs="background-position" name="customize[body][]" data-selector="{$item.selector}" data-match="{$group.match}">
                                                    <option value="">{l s='Not set'}</option>
                                                    {foreach $BACKGROUNDVALUE.position as $position}
                                                        <option value="{$position}">{$position}</option>
                                                    {/foreach}
                                                </select>
                                            </li>
                                            <li>
                                                <div>{l s='Repeat'}</div>
                                                <select class="form-control" data-attrs="background-repeat" name="customize[body][]" data-selector="{$item.selector}" data-match="{$group.match}">
                                                    <option value="">{l s='Not set'}</option>
                                                    {foreach $BACKGROUNDVALUE.repeat as $repeat}
                                                        <option value="{$repeat}">{$repeat}</option>
                                                    {/foreach}
                                                </select>
                                            </li>
                                        </ul>
                        </div>
                        {elseif $item.type=="fontsize"}
                         <div class="form-group cleafix">
                          <label>{$item.label}</label>
                            <select class="form-control input-setting" name="customize[{$group.match}][]" data-match="{$group.match}"  data-selector="{$item.selector}" data-attrs="{$item.attrs}">
                              <option value="">Inherit</option>
                              {for $i=9 to 16}
                              <option value="{$i}">{$i}</option>
                              {/for}
                            </select> 
                            <a href="#" class="clear-bg label label-success">{l s='Clear'}</a>
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
    </div>
	<div class="panelbutton label-customize"></div>
  </div>
</div> 
{/if}   