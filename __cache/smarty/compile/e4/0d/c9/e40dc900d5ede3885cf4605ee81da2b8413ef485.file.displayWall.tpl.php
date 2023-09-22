<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:40:05
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/psagechecker/views/templates/hook/displayWall.tpl" */ ?>
<?php /*%%SmartyHeaderCode:198454155662b5786546c044-64690798%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e40dc900d5ede3885cf4605ee81da2b8413ef485' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/psagechecker/views/templates/hook/displayWall.tpl',
      1 => 1575971598,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '198454155662b5786546c044-64690798',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'show_img' => 0,
    'img_upload' => 0,
    'font_family' => 0,
    'custom_tit' => 0,
    'custom_msg' => 0,
    'method' => 0,
    'deny_button' => 0,
    'confirm_button' => 0,
    'deny_msg' => 0,
    'popup_bg_color' => 0,
    'deny_bg_color' => 0,
    'deny_txt_color' => 0,
    'confirm_bg_color' => 0,
    'confirm_txt_color' => 0,
    'popup_width' => 0,
    'popup_height' => 0,
    'opacity' => 0,
    'display_popup' => 0,
    'age_required' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b578654a6fe1_31728526',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b578654a6fe1_31728526')) {function content_62b578654a6fe1_31728526($_smarty_tpl) {?><!--
* 2007-2018 PrestaShop
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
* @author    PrestaShop SA <contact@prestashop.com>
* @copyright 2007-2018 PrestaShop SA
* @license   http://addons.prestashop.com/en/content/12-terms-and-conditions-of-use
* International Registered Trademark & Property of PrestaShop SA
-->
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css" media="all">
<link href="https://fonts.googleapis.com/css?family=Hind" rel="stylesheet" type="text/css" media="all">
<link href="https://fonts.googleapis.com/css?family=Maven+Pro" rel="stylesheet" type="text/css" media="all">
<link href="https://fonts.googleapis.com/css?family=Noto+Serif" rel="stylesheet" type="text/css" media="all">
<link href="https://fonts.googleapis.com/css?family=Bitter" rel="stylesheet" type="text/css" media="all">
<link href="https://fonts.googleapis.com/css?family=Forum" rel="stylesheet" type="text/css" media="all">

<div id="psagechecker_block" class="preload psagechecker-hide">
    <div id="psagechecker-lightbox" class="lightbox">
        <div class="lightbox-content">
            <div style="height:100%">
                <?php if ($_smarty_tpl->tpl_vars['show_img']->value==1) {?>
                    <div class="logo_age_verify">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['img_upload']->value;?>
" /><br />
                    </div>
                <?php }?>
                <div class="<?php if ($_smarty_tpl->tpl_vars['show_img']->value!=1) {?>age_verify_text_content<?php }?>">
                    <div class="age_verify" style="font-family: <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['font_family']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 !important;">
                        <?php echo $_smarty_tpl->tpl_vars['custom_tit']->value;?>

                    </div>
                    <div class="blockAgeVerify">
                        <div class="custom_msg_age_verify">
                            <?php echo $_smarty_tpl->tpl_vars['custom_msg']->value;?>

                        </div>
                        <?php if ($_smarty_tpl->tpl_vars['method']->value==0) {?>
                            <div class="age_verify_buttons">
                                <button id="deny_button" class="btn btn_deny" ><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['deny_button']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</button>
                                <button id="confirm_button" class="btn btn_confirm" ><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['confirm_button']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</button>
                            </div>
                        <?php } else { ?>
                            <div class="age_verify_input">
                                <input id="day" class="form-control day" type="number" name="day" placeholder="DD" size="2" min="1" max="31" required>
                                <input id="month" class="form-control month" type="number" name="month" size="2" placeholder="MM" min="1" max="12" required>
                                <input id="year" class="form-control year" type="number" name="year" placeholder="YYYY" min="1940"required>
                                <br /><br />
                                <button id="submitAge" class="btn btn_confirm" ><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['confirm_button']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</button>
                            </div>
                        <?php }?>
                    </div>
                </div>
                <div class="deny_msg_age_verify psagechecker-hide">
                    <?php echo $_smarty_tpl->tpl_vars['deny_msg']->value;?>

                </div>
            </div>
        </div>
    </div>
    <div id="overlay" class="psagechecker-hide"></div>
</div>
<style>

    #psagechecker-lightbox{
        background-color: <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['popup_bg_color']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 !important;
    }
    #psagechecker-lightbox, #psagechecker-lightbox *{
        font-family: <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['font_family']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 !important;
    }

    .btn_deny{
        background-color: <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['deny_bg_color']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 !important;
        color: <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['deny_txt_color']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 !important;
    }
    .btn_confirm{
        background-color: <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['confirm_bg_color']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 !important;
        color: <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['confirm_txt_color']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 !important;
    }
    #psagechecker_block .lightbox{
        width : <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['popup_width']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
px ;
        height : <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['popup_height']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
px !important;
    }
    #psagechecker_block #overlay {
        background-color: rgba(0,0,0,<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['opacity']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
);
        height: 100%;
        left: 0;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 9999;
    }
</style>

<script>
var display_popup = "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['display_popup']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
";
var age_required = "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['age_required']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
";
</script>

<?php }} ?>
