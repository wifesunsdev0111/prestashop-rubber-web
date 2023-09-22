<?php
/* Smarty version 3.1.47, created on 2023-05-15 14:54:57
  from '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/modules/psagechecker/views/templates/hook/displayWall.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64622ba1f22892_67186539',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'be11ff28464d475d748a00c54bea4f560d57766c' => 
    array (
      0 => '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/modules/psagechecker/views/templates/hook/displayWall.tpl',
      1 => 1680526194,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64622ba1f22892_67186539 (Smarty_Internal_Template $_smarty_tpl) {
?><!--
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
                <?php if ($_smarty_tpl->tpl_vars['show_img']->value == 1) {?>
                    <div class="logo_age_verify">
                            <img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['img_upload']->value, ENT_QUOTES, 'UTF-8');?>
" /><br />
                    </div>
                <?php }?>
                <div class="<?php if ($_smarty_tpl->tpl_vars['show_img']->value != 1) {?>age_verify_text_content<?php }?>">
                    <div class="age_verify" style="font-family: <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['font_family']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 !important;">
                        <?php echo $_smarty_tpl->tpl_vars['custom_tit']->value;?>

                    </div>
                    <div class="blockAgeVerify">
                        <div class="custom_msg_age_verify">
                            <?php echo $_smarty_tpl->tpl_vars['custom_msg']->value;?>

                        </div>
                        <?php if ($_smarty_tpl->tpl_vars['method']->value == 0) {?>
                            <div class="age_verify_buttons">
                                <button id="deny_button" class="btn btn_deny" ><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['deny_button']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
</button>
                                <button id="confirm_button" class="btn btn_confirm" ><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['confirm_button']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
</button>
                            </div>
                        <?php } else { ?>
                            <div class="age_verify_input">
                                <input id="day" class="form-control day" type="number" name="day" placeholder="DD" size="2" min="1" max="31" required>
                                <input id="month" class="form-control month" type="number" name="month" size="2" placeholder="MM" min="1" max="12" required>
                                <input id="year" class="form-control year" type="number" name="year" placeholder="YYYY" min="1940"required>
                                <br /><br />
                                <button id="submitAge" class="btn btn_confirm" ><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['confirm_button']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
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
        background-color: <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['popup_bg_color']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 !important;
    }
    #psagechecker-lightbox, #psagechecker-lightbox *{
        font-family: <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['font_family']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 !important;
    }

    .btn_deny{
        background-color: <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['deny_bg_color']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 !important;
        color: <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['deny_txt_color']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 !important;
    }
    .btn_confirm{
        background-color: <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['confirm_bg_color']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 !important;
        color: <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['confirm_txt_color']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
 !important;
    }
    #psagechecker_block .lightbox{
        width : <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['popup_width']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
px ;
        height : <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['popup_height']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
px !important;
    }
    #psagechecker_block #overlay {
        background-color: rgba(0,0,0,<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['opacity']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
);
        height: 100%;
        left: 0;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 9999;
    }
</style>

<?php echo '<script'; ?>
>
var display_popup = "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['display_popup']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
";
var age_required = "<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['age_required']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
";
<?php echo '</script'; ?>
>

<?php }
}
