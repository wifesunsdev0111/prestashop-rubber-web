<?php
/* Smarty version 3.1.47, created on 2023-05-15 14:57:33
  from '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/modules/hipay_enterprise/views/templates/hook/updateNotif.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64622c3d4c2571_27673742',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '93872348de34c62ff18524ffb5d21119c1950ae5' => 
    array (
      0 => '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/modules/hipay_enterprise/views/templates/hook/updateNotif.tpl',
      1 => 1680526194,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64622c3d4c2571_27673742 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['updateNotif']->value->getVersion() != $_smarty_tpl->tpl_vars['updateNotif']->value->getNewVersion()) {?>
    <section id="hipayupdate" class="panel widget loading">
        <div class="panel-heading">
            <i class="icon-warning"></i>
            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'HiPay information','mod'=>'hipay_enterprise'),$_smarty_tpl ) );?>

        </div>

        <div class="row vertical-align">
            <div class="col-xs-6 col-sm-6 col-md-3 text-center">
                <img id="hipayNotifLogo" src="/modules/hipay_enterprise/views/img/logo.png" alt="HiPay Logo"/>
            </div>
            <div class="col-xs-18 col-sm-18 col-md-9 text-center">
                <p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'There is a new version of HiPay Enterprise module available.','mod'=>'hipay_enterprise'),$_smarty_tpl ) );?>

                    <a href="<?php echo $_smarty_tpl->tpl_vars['updateNotif']->value->getReadMeUrl();?>
">
                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'View version %s details','mod'=>'hipay_enterprise','sprintf'=>$_smarty_tpl->tpl_vars['updateNotif']->value->getNewVersion()),$_smarty_tpl ) );?>

                    </a>
                    <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'or','mod'=>'hipay_enterprise'),$_smarty_tpl ) );?>

                    <a href="<?php echo $_smarty_tpl->tpl_vars['updateNotif']->value->getDownloadUrl();?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'update now','mod'=>'hipay_enterprise'),$_smarty_tpl ) );?>
</a>.
                </p>
            </div>
        </div>
    </section>
        <?php echo '<script'; ?>
>
        var notifUpdateBox = $('#hipayupdate');

        notifUpdateBox.remove();
        $('#hookDashboardZoneOne').prepend(notifUpdateBox);
    <?php echo '</script'; ?>
>
<?php }
}
}
