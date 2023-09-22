<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:04
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/leosliderlayer/leosliderlayer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:56920254462b5786484d4b0-96238046%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6f46d4f740b9f90267e5eaad4ffc67bb53b073e5' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/leosliderlayer/leosliderlayer.tpl',
      1 => 1447066906,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '56920254462b5786484d4b0-96238046',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sliderParams' => 0,
    'sliderIDRand' => 0,
    'sliders' => 0,
    'slider' => 0,
    'layer' => 0,
    'count' => 0,
    'sliderImgUrl' => 0,
    'sliderFullwidth' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b578648b3280_77440114',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b578648b3280_77440114')) {function content_62b578648b3280_77440114($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/tools/smarty/plugins/modifier.replace.php';
?>
<?php if ($_smarty_tpl->tpl_vars['sliderParams']->value['slider_class']=="boxed") {?>
<div class="layerslider-wrapper<?php if ($_smarty_tpl->tpl_vars['sliderParams']->value['group_class']) {?> <?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['group_class'];?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['sliderParams']->value['md_width']) {?> col-md-<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['md_width'];?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['sliderParams']->value['sm_width']) {?> col-sm-<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['sm_width'];?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['sliderParams']->value['sm_width']) {?> col-xs-<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['xs_width'];?>
<?php }?>">
    <?php $_smarty_tpl->tpl_vars["sliderParams.group_class"] = new Smarty_variable('', null, 0);?>
<?php }?>
    <div class="bannercontainer banner-<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['slider_class'];?>
<?php if ($_smarty_tpl->tpl_vars['sliderParams']->value['group_class']) {?> <?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['group_class'];?>
<?php }?>" style="padding: <?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['padding'];?>
;margin: <?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['margin'];?>
;<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['background'];?>
">
        <div id="sliderlayer<?php echo $_smarty_tpl->tpl_vars['sliderIDRand']->value;?>
" class="rev_slider <?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['slider_class'];?>
banner" style="width:100%;height:<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['height'];?>
px; " >
            <ul>
                <?php if ($_smarty_tpl->tpl_vars['sliders']->value) {?>
                    <?php $_smarty_tpl->tpl_vars["count"] = new Smarty_variable("61", null, 0);?>
                <?php  $_smarty_tpl->tpl_vars['slider'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['slider']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['sliders']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['slider']->key => $_smarty_tpl->tpl_vars['slider']->value) {
$_smarty_tpl->tpl_vars['slider']->_loop = true;
?>

                <li <?php echo $_smarty_tpl->tpl_vars['slider']->value['data_link'];?>
 <?php echo $_smarty_tpl->tpl_vars['slider']->value['data_delay'];?>
 <?php echo $_smarty_tpl->tpl_vars['slider']->value['data_target'];?>
 data-masterspeed="<?php echo $_smarty_tpl->tpl_vars['slider']->value['params']['duration'];?>
"  data-transition="<?php echo $_smarty_tpl->tpl_vars['slider']->value['params']['transition'];?>
" data-slotamount="<?php echo $_smarty_tpl->tpl_vars['slider']->value['params']['slot'];?>
" data-thumb="<?php echo $_smarty_tpl->tpl_vars['slider']->value['thumbnail'];?>
"<?php if ($_smarty_tpl->tpl_vars['slider']->value['background_color']) {?> style="background-color:<?php echo $_smarty_tpl->tpl_vars['slider']->value['background_color'];?>
"<?php }?>>
                    <?php if ($_smarty_tpl->tpl_vars['slider']->value['videoURL']) {?>
                    <div class="caption fade fullscreenvideo" data-autoplay="true" data-x="0" data-y="0" data-speed="500" data-start="10" data-easing="easeOutBack">
                        <iframe src="<?php echo $_smarty_tpl->tpl_vars['slider']->value['videoURL'];?>
?title=0&amp;byline=0&amp;portrait=0;api=1" width="100%" height="100%"></iframe>
                    </div>
                    <?php } elseif ($_smarty_tpl->tpl_vars['slider']->value['main_image']) {?>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['slider']->value['main_image'];?>
" alt=""/>
                    <?php }?>
                    <?php if (isset($_smarty_tpl->tpl_vars['slider']->value['layersparams'])) {?>
                    <?php  $_smarty_tpl->tpl_vars['layer'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['layer']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['slider']->value['layersparams']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['layer']->key => $_smarty_tpl->tpl_vars['layer']->value) {
$_smarty_tpl->tpl_vars['layer']->_loop = true;
?>
                    <div class="caption<?php if ($_smarty_tpl->tpl_vars['layer']->value['layer_class']) {?> <?php echo $_smarty_tpl->tpl_vars['layer']->value['layer_class'];?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['layer']->value['layer_animation']) {?> <?php echo $_smarty_tpl->tpl_vars['layer']->value['layer_animation'];?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['layer']->value['layer_easing']) {?> <?php echo $_smarty_tpl->tpl_vars['layer']->value['layer_easing'];?>
<?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['layer']->value['layer_endanimation']!="auto"&&!$_smarty_tpl->tpl_vars['layer']->value['layer_endtime']) {?><?php echo $_smarty_tpl->tpl_vars['layer']->value['layer_endanimation'];?>
<?php }?>"
                         data-x="<?php echo $_smarty_tpl->tpl_vars['layer']->value['layer_left'];?>
"
                         data-y="<?php echo $_smarty_tpl->tpl_vars['layer']->value['layer_top'];?>
"
                         data-speed="<?php echo $_smarty_tpl->tpl_vars['layer']->value['layer_speed'];?>
"
                         data-start="<?php echo $_smarty_tpl->tpl_vars['layer']->value['time_start'];?>
"
                         <?php $_smarty_tpl->tpl_vars['count'] = new Smarty_variable($_smarty_tpl->tpl_vars['count']->value+1, null, 0);?>
                         data-easing="easeOutExpo" <?php if ($_smarty_tpl->tpl_vars['layer']->value['layer_endtime']) {?>data-end="<?php echo $_smarty_tpl->tpl_vars['layer']->value['layer_endtime'];?>
" data-endspeed="<?php echo $_smarty_tpl->tpl_vars['layer']->value['layer_endspeed'];?>
" <?php if ($_smarty_tpl->tpl_vars['layer']->value['layer_endeasing']!="nothing") {?>data-endeasing="<?php echo $_smarty_tpl->tpl_vars['layer']->value['layer_endeasing'];?>
"<?php }?><?php }?>
                         <?php if ($_smarty_tpl->tpl_vars['layer']->value['layer_link']) {?>onclick="window.open('<?php echo $_smarty_tpl->tpl_vars['layer']->value['layer_link'];?>
','<?php echo $_smarty_tpl->tpl_vars['layer']->value['layer_target'];?>
');"<?php }?>
                         <?php if ($_smarty_tpl->tpl_vars['layer']->value['css']) {?>style="<?php echo $_smarty_tpl->tpl_vars['layer']->value['css'];?>
;z-index: <?php echo $_smarty_tpl->tpl_vars['count']->value;?>
;"<?php }?>>
                        
                         <?php if ($_smarty_tpl->tpl_vars['layer']->value['layer_type']=="image") {?>
                         <img src="<?php echo $_smarty_tpl->tpl_vars['sliderImgUrl']->value;?>
<?php echo $_smarty_tpl->tpl_vars['layer']->value['layer_content'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['slider']->value['title'];?>
" />
                         <?php } elseif ($_smarty_tpl->tpl_vars['layer']->value['layer_type']=="video") {?>
                            <?php if ($_smarty_tpl->tpl_vars['layer']->value['layer_video_type']=="vimeo") {?>
                            <iframe src="http://player.vimeo.com/video/<?php echo $_smarty_tpl->tpl_vars['layer']->value['layer_video_id'];?>
?wmode=transparent&amp;title=0&amp;byline=0&amp;portrait=0;api=1" width="<?php echo $_smarty_tpl->tpl_vars['layer']->value['layer_video_width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['layer']->value['layer_video_height'];?>
"></iframe>
                            <?php } else { ?>
                            <iframe width="<?php echo $_smarty_tpl->tpl_vars['layer']->value['layer_video_width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['layer']->value['layer_video_height'];?>
" src="http://www.youtube.com/embed/<?php echo $_smarty_tpl->tpl_vars['layer']->value['layer_video_id'];?>
?wmode=transparent" frameborder="0" allowfullscreen></iframe>
                            <?php }?>
                         <?php } else { ?>
                             
                            <?php echo html_entity_decode(smarty_modifier_replace($_smarty_tpl->tpl_vars['layer']->value['layer_caption'],"_ASM_","&"),@constant('ENT_QUOTES'),"UTF-8");?>

                         <?php }?>

                    </div>
                    <?php } ?>
                    <?php }?>
                </li>           
                <?php } ?>
                <?php }?>
            </ul>
            <?php if ($_smarty_tpl->tpl_vars['sliderParams']->value['show_time_line']) {?> 
            <div class="tp-bannertimer tp-<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['time_line_position'];?>
"></div>
            <?php }?>
        </div>
    </div>
<?php if ($_smarty_tpl->tpl_vars['sliderParams']->value['slider_class']=="boxed") {?>
</div>
<?php }?>

<script type="text/javascript">
             
                 var tpj=jQuery;
                 
                 if (tpj.fn.cssOriginal!=undefined)
                 tpj.fn.css = tpj.fn.cssOriginal;

                 tpj("#sliderlayer<?php echo $_smarty_tpl->tpl_vars['sliderIDRand']->value;?>
").revolution(
                 {
                     delay:<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['delay'];?>
,
                 startheight:<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['height'];?>
,
                 startwidth:<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['width'];?>
,


                 hideThumbs:<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['hide_navigator_after'];?>
,

                 thumbWidth:<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['thumbnail_width'];?>
,                     
                 thumbHeight:<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['thumbnail_height'];?>
,
                 thumbAmount:<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['thumbnail_amount'];?>
,
                 <?php if ($_smarty_tpl->tpl_vars['sliderParams']->value['navigator_type']!="both") {?>
                 navigationType:"<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['navigator_type'];?>
",
                 <?php } else { ?>
                 navsecond:"both",
                 <?php }?>
                 navigationArrows:"<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['navigator_arrows'];?>
",                
                 <?php if ($_smarty_tpl->tpl_vars['sliderParams']->value['navigation_style']!="none") {?>
                 navigationStyle:"<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['navigation_style'];?>
",          
                 <?php }?>

                 navOffsetHorizontal:<?php if ($_smarty_tpl->tpl_vars['sliderParams']->value['offset_horizontal']) {?><?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['offset_horizontal'];?>
<?php } else { ?>0<?php }?>,
                 <?php if ($_smarty_tpl->tpl_vars['sliderParams']->value['offset_vertical']) {?>
                 navOffsetVertical:<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['offset_vertical'];?>
,  
                <?php }?>    
                 touchenabled:"<?php if ($_smarty_tpl->tpl_vars['sliderParams']->value['touch_mobile']) {?>on<?php } else { ?>off<?php }?>",         
                 onHoverStop:"<?php if ($_smarty_tpl->tpl_vars['sliderParams']->value['stop_on_hover']) {?>on<?php } else { ?>off<?php }?>",                     
                 shuffle:"<?php if ($_smarty_tpl->tpl_vars['sliderParams']->value['shuffle_mode']) {?>on<?php } else { ?>off<?php }?>",  
                 stopAtSlide: <?php if ($_smarty_tpl->tpl_vars['sliderParams']->value['auto_play']) {?>-1<?php } else { ?>1<?php }?>,                        
                 stopAfterLoops:<?php if ($_smarty_tpl->tpl_vars['sliderParams']->value['auto_play']) {?>-1<?php } else { ?>0<?php }?>,                     

                 hideCaptionAtLimit:0,              
                 hideAllCaptionAtLilmit:0,              
                 hideSliderAtLimit:0,           
                 fullWidth:"<?php echo $_smarty_tpl->tpl_vars['sliderFullwidth']->value;?>
",
                 shadow:<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['shadow_type'];?>
,
                 startWithSlide:<?php echo $_smarty_tpl->tpl_vars['sliderParams']->value['slider_start_with_slide'];?>

         
                 });
                 $( document ).ready(function() {
                    $('.caption',$('#sliderlayer<?php echo $_smarty_tpl->tpl_vars['sliderIDRand']->value;?>
')).click(function(){
                        if($(this).data('link') != undefined && $(this).data('link') != '') location.href = $(this).data('link');
                    });

                    $('li',$('#sliderlayer<?php echo $_smarty_tpl->tpl_vars['sliderIDRand']->value;?>
')).click(function(){
                        if($(this).data('link') != undefined && $(this).data('link') != '') location.href = $(this).data('link');
                    });
                 });
             
</script><?php }} ?>
