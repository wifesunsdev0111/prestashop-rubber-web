<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 16:30:27
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/onepagecheckout/views/templates/front/order-opc-new-account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:211086207662b5ca8376eec7-24135425%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4cfa64ce000e564453869b45c7b21e268d361a46' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/onepagecheckout/views/templates/front/order-opc-new-account.tpl',
      1 => 1470858411,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '211086207662b5ca8376eec7-24135425',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'opc_config' => 0,
    'guestInformations' => 0,
    'isGuest' => 0,
    'PS_GUEST_CHECKOUT_ENABLED' => 0,
    'def_different_billing' => 0,
    'isVirtualCart' => 0,
    'HOOK_CREATE_ACCOUNT_TOP' => 0,
    'cart' => 0,
    'days' => 0,
    'day' => 0,
    'months' => 0,
    'k' => 0,
    'years' => 0,
    'year' => 0,
    'invoice_first' => 0,
    'isLogged' => 0,
    'addresses' => 0,
    'address' => 0,
    'selOk' => 0,
    'onlineCountryActive' => 0,
    'sl_country' => 0,
    'countries' => 0,
    'v' => 0,
    'def_country' => 0,
    'one_phone_at_least' => 0,
    'def_country_invoice' => 0,
    'link' => 0,
    'modules_dir' => 0,
    'back' => 0,
    'def_state' => 0,
    'def_state_invoice' => 0,
    'country' => 0,
    'state' => 0,
    'HOOK_CREATE_ACCOUNT_FORM' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b5ca8398e796_63260039',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b5ca8398e796_63260039')) {function content_62b5ca8398e796_63260039($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_regex_replace')) include '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/tools/smarty/plugins/modifier.regex_replace.php';
?>

<?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['invoice_first'])&&$_smarty_tpl->tpl_vars['opc_config']->value['invoice_first']) {?>
    <?php $_smarty_tpl->tpl_vars["invoice_first"] = new Smarty_variable("1", null, 0);?>
<?php } else { ?>
    <?php $_smarty_tpl->tpl_vars["invoice_first"] = new Smarty_variable("0", null, 0);?>
<?php }?>



<?php $_smarty_tpl->_capture_stack[0][] = array('password_checkbox', null, null); ob_start(); ?>
    <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['create_customer_password'])||!$_smarty_tpl->tpl_vars['opc_config']->value['create_customer_password']) {?>
        <?php if (!isset($_smarty_tpl->tpl_vars['guestInformations']->value)||!$_smarty_tpl->tpl_vars['guestInformations']->value['id_customer']||$_smarty_tpl->tpl_vars['isGuest']->value) {?>
            <p class="checkbox" id="p_registerme"
               <?php if (!$_smarty_tpl->tpl_vars['PS_GUEST_CHECKOUT_ENABLED']->value&&!$_smarty_tpl->tpl_vars['opc_config']->value['display_password_msg']) {?>style="display: none"<?php }?>>
                <input type="checkbox"
                       <?php if (!$_smarty_tpl->tpl_vars['PS_GUEST_CHECKOUT_ENABLED']->value) {?>disabled="disabled"<?php }?> <?php if (!$_smarty_tpl->tpl_vars['PS_GUEST_CHECKOUT_ENABLED']->value||$_smarty_tpl->tpl_vars['opc_config']->value['password_checked']) {?>checked="checked"<?php }?>
                       name="registerme" id="registerme" value="1" onclick="toggle_password_box();"/>
                <label for="registerme"><?php echo smartyTranslate(array('s'=>'Create an account and enjoy benefits of registered customers.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</label>
            </p>
        <?php }?>
    <?php }?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>




<?php $_smarty_tpl->_capture_stack[0][] = array('invoice_checkbox_block', null, null); ob_start(); ?>

    <p class="checkbox is_customer_param<?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['invoice_checkbox'])||!$_smarty_tpl->tpl_vars['opc_config']->value['invoice_checkbox']) {?> no_show<?php }?>" id="invoice_address_checkbox">
        <input type="checkbox" name="invoice_address" id="invoice_address"
               <?php if (((isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['guestInformations']->value['use_another_invoice_address'])||(!isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['def_different_billing']->value==1))) {?>checked="checked"<?php }?>/>
        <label for="invoice_address"><b><?php if ($_smarty_tpl->tpl_vars['isVirtualCart']->value&&$_smarty_tpl->tpl_vars['opc_config']->value['virtual_no_delivery']) {?><?php echo smartyTranslate(array('s'=>'I would like to provide billing address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Please use another address for invoice','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php }?></b></label>
    </p>

<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>


<?php $_smarty_tpl->_capture_stack[0][] = array('delivery_checkbox_block', null, null); ob_start(); ?>

    <p class="checkbox is_customer_param<?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['invoice_checkbox'])||!$_smarty_tpl->tpl_vars['opc_config']->value['invoice_checkbox']) {?> no_show<?php }?>" id="delivery_address_checkbox">
        <input type="checkbox" name="delivery_address" id="delivery_address"
               <?php if (((isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['guestInformations']->value['use_another_invoice_address'])||(!isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['def_different_billing']->value==1))) {?>checked="checked"<?php }?>/>
        <label for="delivery_address"><b><?php if ($_smarty_tpl->tpl_vars['isVirtualCart']->value&&$_smarty_tpl->tpl_vars['opc_config']->value['virtual_no_delivery']) {?><?php echo smartyTranslate(array('s'=>'I would like to provide billing address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'Delivery to another address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php }?></b></label>
    </p>

<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>



<?php $_smarty_tpl->_capture_stack[0][] = array('account_block', null, null); ob_start(); ?>

   <div class="account_fields">

        <!-- Error return block -->
        <div id="opc_account_errors" class="error" style="display:none;"></div>
        <!-- END Error return block -->

    <?php echo $_smarty_tpl->tpl_vars['HOOK_CREATE_ACCOUNT_TOP']->value;?>


    <!-- Account -->
    <input type="hidden" id="is_new_customer" name="is_new_customer"
           value="<?php if (!$_smarty_tpl->tpl_vars['PS_GUEST_CHECKOUT_ENABLED']->value||$_smarty_tpl->tpl_vars['opc_config']->value['password_checked']) {?>1<?php } else { ?>0<?php }?>"/>
    <input type="hidden" id="opc_id_customer" name="opc_id_customer"
           value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['guestInformations']->value['id_customer']) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['id_customer'];?>
<?php } else { ?>0<?php }?>"/>
    <input type="hidden" id="opc_id_address_delivery" name="opc_id_address_delivery"
           value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['guestInformations']->value['id_address_delivery']) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['id_address_delivery'];?>
<?php } else { ?>0<?php }?>"/>
    <input type="hidden" id="opc_id_address_invoice" name="opc_id_address_invoice"
           value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['guestInformations']->value['id_address_delivery']) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['id_address_delivery'];?>
<?php } else { ?>0<?php }?>"/>
    <input type="hidden" id="opc_cart_id_address_delivery" value="<?php if (isset($_smarty_tpl->tpl_vars['cart']->value)&&isset($_smarty_tpl->tpl_vars['cart']->value->id_address_delivery)) {?><?php echo $_smarty_tpl->tpl_vars['cart']->value->id_address_delivery;?>
<?php } else { ?>0<?php }?>" />


    <?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['offer_password_top'])&&$_smarty_tpl->tpl_vars['opc_config']->value['offer_password_top']) {?><?php echo Smarty::$_smarty_vars['capture']['password_checkbox'];?>
<?php }?>

    <p class="required text">
        <label for="email"><?php echo smartyTranslate(array('s'=>'E-mail','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>*</sup></label>
        <input type="text"
               <?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['guestInformations']->value['id_customer']&&!$_smarty_tpl->tpl_vars['isGuest']->value) {?>readonly="readonly"<?php }?>
               class="ttp text<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['guestInformations']->value['id_customer']&&!$_smarty_tpl->tpl_vars['isGuest']->value) {?> readonly<?php }?>"
               id="email" name="email"
               value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['guestInformations']->value['email']) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['email'];?>
<?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
        <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
            <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'jack@gmail.com','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>


    </p>

    <?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['email_verify'])&&$_smarty_tpl->tpl_vars['opc_config']->value['email_verify']) {?>
        <p class="required text" id="email_verify_cont"
           <?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['guestInformations']->value['id_customer']) {?>style="display: none"<?php }?>>
            <label for="email_verify"><?php echo smartyTranslate(array('s'=>'E-mail (repeat)','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>*</sup></label>
            <input type="text" class="text" id="email_verify" name="email_verify"/>
        </p>
    <?php }?>

    <div id="existing_email_msg"><?php echo smartyTranslate(array('s'=>'This email is already registered, you can either','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <a href="#"
                                                                                                                   class="existing_email_login"><?php echo smartyTranslate(array('s'=>'log-in','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</a> <?php echo smartyTranslate(array('s'=>'or just fill in details below.','mod'=>'onepagecheckout'),$_smarty_tpl);?>

    </div>
    <div id="must_login_msg"><?php echo smartyTranslate(array('s'=>'This email is already registered, please','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <a href="#"
                                                                                                       class="existing_email_login"><?php echo smartyTranslate(array('s'=>'log-in','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</a>.
    </div>

    <?php $_smarty_tpl->_capture_stack[0][] = array("password_field", null, null); ob_start(); ?>
        <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['create_customer_password'])||!$_smarty_tpl->tpl_vars['opc_config']->value['create_customer_password']) {?>
            <p class="text required password is_customer_param" id="opc_password" style="display: none">
                <label for="passwd"><?php echo smartyTranslate(array('s'=>'Password','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>*</sup></label>
                <input type="password" class="text" name="passwd"
                       id="passwd"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
                <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                    <span class="sample_text ex_blur"><?php echo smartyTranslate(array('s'=>'(5 characters min.)','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</span><?php }?>
            </p>
        <?php }?>
    <?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

    <?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['offer_password_top'])&&$_smarty_tpl->tpl_vars['opc_config']->value['offer_password_top']) {?><?php echo Smarty::$_smarty_vars['capture']['password_field'];?>
<?php }?>



    <p class="radio required" <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['gender'])||!$_smarty_tpl->tpl_vars['opc_config']->value['gender']) {?>style="display: none;"<?php }?>>
        <label><?php echo smartyTranslate(array('s'=>'Title','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</label>
        <input type="radio" name="id_gender" id="id_gender1" value="1"
               <?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['guestInformations']->value['id_gender']==1) {?>checked="checked"<?php }?> />
        <label for="id_gender1" class="top"><?php echo smartyTranslate(array('s'=>'Mr.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</label>
        <input type="radio" name="id_gender" id="id_gender2" value="2"
               <?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['guestInformations']->value['id_gender']==2) {?>checked="checked"<?php }?> />
        <label for="id_gender2" class="top"><?php echo smartyTranslate(array('s'=>'Ms.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</label>
    </p>

    <p class="select" <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['birthday'])||!$_smarty_tpl->tpl_vars['opc_config']->value['birthday']) {?>style="display: none;"<?php }?>>
        <label><?php echo smartyTranslate(array('s'=>'Date of Birth','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</label>
        <select id="days" name="days">
            <option value="">-</option>
            <?php  $_smarty_tpl->tpl_vars['day'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['day']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['days']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['day']->key => $_smarty_tpl->tpl_vars['day']->value) {
$_smarty_tpl->tpl_vars['day']->_loop = true;
?>
                <option value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['day']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" <?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&($_smarty_tpl->tpl_vars['guestInformations']->value['sl_day']==$_smarty_tpl->tpl_vars['day']->value)) {?>
                    selected="selected"<?php }?>><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['day']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&nbsp;&nbsp;</option>
            <?php } ?>
        </select>
        
        <select id="months" name="months">
            <option value="">-</option>
            <?php  $_smarty_tpl->tpl_vars['month'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['month']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['months']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['month']->key => $_smarty_tpl->tpl_vars['month']->value) {
$_smarty_tpl->tpl_vars['month']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['month']->key;
?>
                <option value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['k']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" <?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&($_smarty_tpl->tpl_vars['guestInformations']->value['sl_month']==$_smarty_tpl->tpl_vars['k']->value)) {?>
                    selected="selected"<?php }?>><?php echo smartyTranslate(array('s'=>((string)$_smarty_tpl->tpl_vars['month']->value)),$_smarty_tpl);?>
&nbsp;</option>
            <?php } ?>
        </select>
        <select id="years" name="years">
            <option value="">-</option>
            <?php  $_smarty_tpl->tpl_vars['year'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['year']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['years']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['year']->key => $_smarty_tpl->tpl_vars['year']->value) {
$_smarty_tpl->tpl_vars['year']->_loop = true;
?>
                <option value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['year']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" <?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&($_smarty_tpl->tpl_vars['guestInformations']->value['sl_year']==$_smarty_tpl->tpl_vars['year']->value)) {?>
                    selected="selected"<?php }?>><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['year']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
&nbsp;&nbsp;</option>
            <?php } ?>
        </select>
    </p>
    <p class="checkbox" <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['newsletter'])||!$_smarty_tpl->tpl_vars['opc_config']->value['newsletter']) {?>style="display: none;"<?php }?>>
        <input type="checkbox" name="newsletter" id="newsletter" value="1"
               <?php if ((isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['guestInformations']->value['newsletter'])||(!isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['opc_config']->value['newsletter_checked'])&&$_smarty_tpl->tpl_vars['opc_config']->value['newsletter_checked'])) {?>checked="checked"<?php }?> />
        <label for="newsletter"><?php echo smartyTranslate(array('s'=>'Sign up for our newsletter','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</label>
    </p>

    <p class="checkbox" <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['special_offers'])||!$_smarty_tpl->tpl_vars['opc_config']->value['special_offers']) {?>style="display: none;"<?php }?>>
        <input type="checkbox" name="optin" id="optin" value="1"
               <?php if ((isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['guestInformations']->value['optin'])||(!isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['opc_config']->value['special_offers_checked'])&&$_smarty_tpl->tpl_vars['opc_config']->value['special_offers_checked'])) {?>checked="checked"<?php }?> />
        <label for="optin"><?php echo smartyTranslate(array('s'=>'Receive special offers from our partners','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</label>
    </p>

   </div> 

<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?> 


<?php $_smarty_tpl->_capture_stack[0][] = array('delivery_address_block', null, null); ob_start(); ?>

    <fieldset id="opc_delivery_address" style="display: <?php if ((isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['guestInformations']->value['use_another_invoice_address'])||(!isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['def_different_billing']->value==1)||!$_smarty_tpl->tpl_vars['invoice_first']->value) {?>block<?php } else { ?>none<?php }?>">
        <h3>
            <span id="dlv_label" class="<?php if (($_smarty_tpl->tpl_vars['isLogged']->value&&!$_smarty_tpl->tpl_vars['isGuest']->value)) {?>logged-l<?php } else { ?>new-l<?php }?>"><?php echo smartyTranslate(array('s'=>'Delivery & Personal information','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</span><span id="new_label" class="<?php if (($_smarty_tpl->tpl_vars['isLogged']->value&&!$_smarty_tpl->tpl_vars['isGuest']->value)) {?>logged-l<?php } else { ?>new-l<?php }?>"><?php if ($_smarty_tpl->tpl_vars['invoice_first']->value) {?><?php echo smartyTranslate(array('s'=>'Delivery & Personal information','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'New customer - account & address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php }?></span>
        </h3>

        <?php if (!$_smarty_tpl->tpl_vars['invoice_first']->value) {?><?php echo Smarty::$_smarty_vars['capture']['account_block'];?>
<?php }?>


        <div class="address-type-header delivery<?php if ($_smarty_tpl->tpl_vars['isVirtualCart']->value&&$_smarty_tpl->tpl_vars['opc_config']->value['virtual_no_delivery']) {?> hidden<?php }?>"><?php echo smartyTranslate(array('s'=>'Delivery address','mod'=>'onepagecheckout'),$_smarty_tpl);?>

        <div id="dlv_addresses_div"
             style="float: right;<?php if (!isset($_smarty_tpl->tpl_vars['addresses']->value)||count($_smarty_tpl->tpl_vars['addresses']->value)==0) {?>display:none;<?php } elseif (count($_smarty_tpl->tpl_vars['addresses']->value)==1&&$_smarty_tpl->tpl_vars['addresses']->value[0]['id_address']==$_smarty_tpl->tpl_vars['cart']->value->id_address_delivery) {?>display:none;<?php } else { ?>display:block;<?php }?>">
            <span style="font-size: 0.7em;"><?php echo smartyTranslate(array('s'=>'Choose another address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
:</span>
            <select id="dlv_addresses" style="width: 100px; margin-left: 0px;" onchange="updateAddressSelection_1();" title="<?php echo smartyTranslate(array('s'=>'Choose another address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
">
                <?php if (isset($_smarty_tpl->tpl_vars['addresses']->value)) {?>
                    <?php  $_smarty_tpl->tpl_vars['address'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['address']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['addresses']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['address']->key => $_smarty_tpl->tpl_vars['address']->value) {
$_smarty_tpl->tpl_vars['address']->_loop = true;
?>
                        <option value="<?php echo intval($_smarty_tpl->tpl_vars['address']->value['id_address']);?>
"
                                <?php if ($_smarty_tpl->tpl_vars['address']->value['id_address']==$_smarty_tpl->tpl_vars['cart']->value->id_address_delivery) {?><?php $_smarty_tpl->tpl_vars["selOk"] = new Smarty_variable("1", null, 0);?>selected="selected"<?php } elseif ($_smarty_tpl->tpl_vars['address']->value['id_address']==$_smarty_tpl->tpl_vars['cart']->value->id_address_invoice) {?>disabled="disabled"<?php }?>><?php echo smarty_modifier_regex_replace($_smarty_tpl->tpl_vars['address']->value['alias'],"/^dlv\-/",'');?>
</option>
                    <?php } ?>
                    <?php if (!$_smarty_tpl->tpl_vars['selOk']->value) {?>
                        <option value="<?php echo intval($_smarty_tpl->tpl_vars['addresses']->value[0]['id_address']);?>
" selected="selected"> -- </option>
                    <?php }?>
                <?php }?>
            </select>
        </div>
        </div>



      <div class="address_fields">



        <p class="text" <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['company_delivery'])||!$_smarty_tpl->tpl_vars['opc_config']->value['company_delivery']) {?>style="display: none;"<?php }?>>
            <label for="company"><?php echo smartyTranslate(array('s'=>'Company','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>&nbsp;&nbsp;</sup></label>
            <input type="text" class="text" id="company" name="company"
                   value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['company'])&&$_smarty_tpl->tpl_vars['guestInformations']->value['company']) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['company'];?>
<?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
            <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'Google, Inc.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
        </p>

        <div id="vat_number_block" style="display:none;">
            <p class="text">
                <label for="vat_number"><?php echo smartyTranslate(array('s'=>'VAT number','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>&nbsp;&nbsp;</sup></label>
                <input type="text" class="text" name="vat_number" id="vat_number"
                       value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['vat_number'])&&$_smarty_tpl->tpl_vars['guestInformations']->value['vat_number']) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['vat_number'];?>
<?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
                <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                    <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'FR101202303','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
            </p>
        </div>
        <p class="required text dni" <?php if ($_smarty_tpl->tpl_vars['isVirtualCart']->value&&$_smarty_tpl->tpl_vars['opc_config']->value['virtual_no_delivery']) {?>style="display: none;"<?php }?>>
            <label for="dni"><?php echo smartyTranslate(array('s'=>'Identification number','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>*</sup></label>
            <input type="text" class="text" name="dni" id="dni"
                   value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['dni'])&&$_smarty_tpl->tpl_vars['guestInformations']->value['dni']) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['dni'];?>
<?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
            <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'DNI / NIF / NIE','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
        </p>

        <p class="required text" <?php if ($_smarty_tpl->tpl_vars['isVirtualCart']->value&&$_smarty_tpl->tpl_vars['opc_config']->value['virtual_no_delivery']) {?>style="display: none;"<?php }?>>
            <label for="firstname"><?php echo smartyTranslate(array('s'=>'First name','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>*</sup></label>
            <input type="text" class="text" id="firstname" name="firstname"
                   value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['firstname'])&&$_smarty_tpl->tpl_vars['guestInformations']->value['firstname']) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['firstname'];?>
<?php } else { ?><?php if ($_smarty_tpl->tpl_vars['isVirtualCart']->value&&true) {?> <?php }?><?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
            <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'Jack','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
        </p>

        <p class="required text" <?php if ($_smarty_tpl->tpl_vars['isVirtualCart']->value&&$_smarty_tpl->tpl_vars['opc_config']->value['virtual_no_delivery']) {?>style="display: none;"<?php }?>>
            <label for="lastname"><?php echo smartyTranslate(array('s'=>'Last name','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>*</sup></label>
            <input type="text" class="text" id="lastname" name="lastname"
                   value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['lastname'])&&$_smarty_tpl->tpl_vars['guestInformations']->value['lastname']) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['lastname'];?>
<?php } else { ?><?php if ($_smarty_tpl->tpl_vars['isVirtualCart']->value&&true) {?> <?php }?><?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
            <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'Thompson','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
        </p>

        <p class="required text" <?php if ($_smarty_tpl->tpl_vars['isVirtualCart']->value&&$_smarty_tpl->tpl_vars['opc_config']->value['virtual_no_delivery']) {?>style="display: none;"<?php }?>>
            <label for="address1"><?php echo smartyTranslate(array('s'=>'Address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>*</sup></label>
            <input type="text" class="text" name="address1" id="address1"
                   value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['address1'])&&$_smarty_tpl->tpl_vars['guestInformations']->value['address1']) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['address1'];?>
<?php } else { ?><?php if ($_smarty_tpl->tpl_vars['isVirtualCart']->value&&true) {?> <?php }?><?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
            <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'15 High Street','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
        </p>

        <p class="text is_customer_param" id="p_address2"
           <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['address2_delivery'])||!$_smarty_tpl->tpl_vars['opc_config']->value['address2_delivery']||($_smarty_tpl->tpl_vars['isVirtualCart']->value&&$_smarty_tpl->tpl_vars['opc_config']->value['virtual_no_delivery'])) {?>style="display: none;"<?php }?>>
            <label for="address2"><?php echo smartyTranslate(array('s'=>'Address (Line 2)','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>&nbsp;&nbsp;</sup></label>
            <input type="text" class="text" name="address2" id="address2"
                   value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['address2'])&&$_smarty_tpl->tpl_vars['guestInformations']->value['address2']) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['address2'];?>
<?php } else { ?><?php if ($_smarty_tpl->tpl_vars['isVirtualCart']->value&&true) {?> <?php }?><?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
            <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'Room no.304','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
        </p>

        <p class="required postcode text" <?php if ($_smarty_tpl->tpl_vars['isVirtualCart']->value&&$_smarty_tpl->tpl_vars['opc_config']->value['virtual_no_delivery']) {?>style="display: none;"<?php }?>>
            <label for="postcode"><?php echo smartyTranslate(array('s'=>'Zip / Postal code','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>*</sup></label>
            <input type="text" class="text" name="postcode" id="postcode"
                   value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['postcode'])&&$_smarty_tpl->tpl_vars['guestInformations']->value['postcode']) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['postcode'];?>
<?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
            <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'90104','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
        </p>

        <p class="required text" <?php if ($_smarty_tpl->tpl_vars['isVirtualCart']->value&&$_smarty_tpl->tpl_vars['opc_config']->value['virtual_no_delivery']) {?>style="display: none;"<?php }?>>
            <label for="city"><?php echo smartyTranslate(array('s'=>'City','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>*</sup></label>
            <input type="text" class="text" name="city" id="city"
                   value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['city'])&&$_smarty_tpl->tpl_vars['guestInformations']->value['city']) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['city'];?>
<?php } else { ?><?php if ($_smarty_tpl->tpl_vars['isVirtualCart']->value&&true) {?> <?php }?><?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
            <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'Paris','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
        </p>


        <?php if ($_smarty_tpl->tpl_vars['isVirtualCart']->value&&$_smarty_tpl->tpl_vars['opc_config']->value['virtual_no_delivery']) {?>
            <input type="hidden" name="id_country" id="id_country"
                   value="<?php if (isset($_smarty_tpl->tpl_vars['onlineCountryActive']->value)&&$_smarty_tpl->tpl_vars['opc_config']->value['online_country_id']>0) {?><?php echo intval($_smarty_tpl->tpl_vars['opc_config']->value['online_country_id']);?>
<?php } else { ?><?php echo intval($_smarty_tpl->tpl_vars['sl_country']->value);?>
<?php }?>"/>
        <?php } else { ?>
            <p class="required select"
               <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['country_delivery'])||!$_smarty_tpl->tpl_vars['opc_config']->value['country_delivery']) {?>style="display: none;"<?php }?>>
                <label for="id_country"><?php echo smartyTranslate(array('s'=>'Country','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>*</sup></label>
                <select name="id_country" id="id_country">
                    <option value="">-</option>
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['countries']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                        <?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['online_country_id'])&&$_smarty_tpl->tpl_vars['opc_config']->value['online_country_id']>0&&$_smarty_tpl->tpl_vars['opc_config']->value['online_country_id']==$_smarty_tpl->tpl_vars['v']->value['id_country']) {?><?php } else { ?>
                            <option value="<?php echo intval($_smarty_tpl->tpl_vars['v']->value['id_country']);?>
" <?php if ((isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['id_country'])&&$_smarty_tpl->tpl_vars['guestInformations']->value['id_country']==$_smarty_tpl->tpl_vars['v']->value['id_country'])||($_smarty_tpl->tpl_vars['def_country']->value==$_smarty_tpl->tpl_vars['v']->value['id_country'])||(!isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&($_smarty_tpl->tpl_vars['def_country']->value==0)&&$_smarty_tpl->tpl_vars['sl_country']->value==$_smarty_tpl->tpl_vars['v']->value['id_country'])) {?>
                                selected="selected"<?php }?>><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</option>
                        <?php }?>
                    <?php } ?>
                </select>
                <?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?><span
                    class="validity valid_blank"></span><?php }?>
            </p>

        <?php }?>


        <p class="required id_state select">
            <label for="id_state"><?php echo smartyTranslate(array('s'=>'State','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>*</sup></label>
            <select name="id_state" id="id_state">
                <option value="">-</option>
            </select><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
            <span class="validity valid_blank"></span><?php }?>
        </p>

        <p class="text is_customer_param" <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['phone_delivery'])||!$_smarty_tpl->tpl_vars['opc_config']->value['phone_delivery']) {?>style="display: none;"<?php }?>>
            <label for="phone"><?php echo smartyTranslate(array('s'=>'Home phone','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup><?php if (isset($_smarty_tpl->tpl_vars['one_phone_at_least']->value)&&$_smarty_tpl->tpl_vars['one_phone_at_least']->value) {?>*<?php } else { ?>&nbsp;&nbsp;<?php }?></sup></label>
            <input type="text" class="text" name="phone" id="phone"
                   value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['phone'])&&$_smarty_tpl->tpl_vars['guestInformations']->value['phone']) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['phone'];?>
<?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
            <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'555-100200','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
        </p>

        <p class="text" <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['phone_mobile_delivery'])||!$_smarty_tpl->tpl_vars['opc_config']->value['phone_mobile_delivery']) {?>style="display: none;"<?php }?>>
            <label for="phone_mobile"><?php echo smartyTranslate(array('s'=>'Mobile phone','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>&nbsp;&nbsp;</sup></label>
            <input type="text" class="text" name="phone_mobile" id="phone_mobile"
                   value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['phone_mobile'])&&$_smarty_tpl->tpl_vars['guestInformations']->value['phone_mobile']) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['phone_mobile'];?>
<?php } else { ?><?php if ($_smarty_tpl->tpl_vars['isVirtualCart']->value&&true) {?> <?php }?><?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
            <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'555-100200','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
        </p>

        <p class="textarea is_customer_param"
           <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['additional_info_delivery'])||!$_smarty_tpl->tpl_vars['opc_config']->value['additional_info_delivery']) {?>style="display: none;"<?php }?>>
            <label for="other"><?php echo smartyTranslate(array('s'=>'Additional information','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</label>
            <textarea name="other" id="other" cols="26"
                      rows="3"><?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['other'])&&$_smarty_tpl->tpl_vars['guestInformations']->value['other']) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['other'];?>
<?php }?></textarea>
        </p>
        <input type="hidden" name="alias" id="alias"
               value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['alias'])&&$_smarty_tpl->tpl_vars['guestInformations']->value['alias']) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['alias'];?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'My address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php }?>"/>
        <input type="hidden" name="default_alias" id="default_alias" value="<?php echo smartyTranslate(array('s'=>'My address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
"/>

        <?php if (!$_smarty_tpl->tpl_vars['invoice_first']->value) {?><?php echo Smarty::$_smarty_vars['capture']['invoice_checkbox_block'];?>
<?php }?>

        <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['compact_form'])||!$_smarty_tpl->tpl_vars['opc_config']->value['compact_form']) {?>
            <p style="clear: both;">
                <sup>*</sup><?php echo smartyTranslate(array('s'=>'Required field','mod'=>'onepagecheckout'),$_smarty_tpl);?>

            </p>
        <?php }?>

      </div> 
    </fieldset>

<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?> 








<?php $_smarty_tpl->_capture_stack[0][] = array('invoice_address_block', null, null); ob_start(); ?>

    <div id="opc_invoice_address" class="is_customer_param"
         style="display: <?php if ((isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['guestInformations']->value['use_another_invoice_address'])||(!isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['def_different_billing']->value==1)||$_smarty_tpl->tpl_vars['invoice_first']->value) {?>block<?php } else { ?>none<?php }?>">
        <fieldset>
            <?php if ($_smarty_tpl->tpl_vars['invoice_first']->value) {?><?php echo Smarty::$_smarty_vars['capture']['account_block'];?>
<?php }?>


            
            
            
            
            <div class="address-type-header invoice"><?php echo smartyTranslate(array('s'=>'Invoice address','mod'=>'onepagecheckout'),$_smarty_tpl);?>

            <div id="inv_addresses_div"
                 style="float: right;<?php if (!isset($_smarty_tpl->tpl_vars['addresses']->value)||count($_smarty_tpl->tpl_vars['addresses']->value)==0) {?>display:none;<?php } elseif (count($_smarty_tpl->tpl_vars['addresses']->value)==1&&($_smarty_tpl->tpl_vars['addresses']->value[0]['id_address']==$_smarty_tpl->tpl_vars['cart']->value->id_address_invoice||$_smarty_tpl->tpl_vars['addresses']->value[0]['id_address']==$_smarty_tpl->tpl_vars['cart']->value->id_address_delivery)) {?>display:none;<?php } else { ?>display:block;<?php }?>">
                <span style="font-size: 0.7em;"><?php echo smartyTranslate(array('s'=>'Choose another address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
:</span>
                <select id="inv_addresses" style="width: 100px; margin-left: 0px;"
                        onchange="updateAddressSelection_1_invoice();" title="<?php echo smartyTranslate(array('s'=>'Choose another address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
">
                    <?php if (isset($_smarty_tpl->tpl_vars['addresses']->value)) {?>
                        <?php  $_smarty_tpl->tpl_vars['address'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['address']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['addresses']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['address']->key => $_smarty_tpl->tpl_vars['address']->value) {
$_smarty_tpl->tpl_vars['address']->_loop = true;
?>
                            <option value="<?php echo intval($_smarty_tpl->tpl_vars['address']->value['id_address']);?>
"
                                    <?php if ($_smarty_tpl->tpl_vars['address']->value['id_address']==$_smarty_tpl->tpl_vars['cart']->value->id_address_invoice) {?>selected="selected"<?php } elseif ($_smarty_tpl->tpl_vars['address']->value['id_address']==$_smarty_tpl->tpl_vars['cart']->value->id_address_delivery) {?>disabled="disabled"<?php }?>><?php echo $_smarty_tpl->tpl_vars['address']->value['alias'];?>
</option>
                        <?php } ?>
                    <?php }?>
                </select>
            </div>
            </div>




          <div class="address_fields">

            <!-- Error return block -->
            <div id="opc_account_errors_invoice" class="error" style="display:none;"></div>
            <!-- END Error return block -->
            <p class="text is_customer_param"
               <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['company_invoice'])||!$_smarty_tpl->tpl_vars['opc_config']->value['company_invoice']) {?>style="display: none;"<?php }?>>
                <label for="company_invoice"><?php echo smartyTranslate(array('s'=>'Company','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>&nbsp;&nbsp;</sup></label>
                <input type="text" class="text" id="company_invoice" name="company_invoice"
                       value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['company_invoice'])) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['company_invoice'];?>
<?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
                <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                    <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'Google, Inc.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
            </p>

            <div id="vat_number_block_invoice" class="is_customer_param"
                 style="display:<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['allow_eu_vat_invoice'])&&$_smarty_tpl->tpl_vars['guestInformations']->value['allow_eu_vat_invoice']==1) {?>block<?php } else { ?>none<?php }?>;">
                <p class="text">
                    <label for="vat_number_invoice"><?php echo smartyTranslate(array('s'=>'VAT number','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>&nbsp;&nbsp;</sup></label>
                    <input type="text" class="text" id="vat_number_invoice" name="vat_number_invoice"
                           value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['vat_number_invoice'])) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['vat_number_invoice'];?>
<?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
                    <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                        <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'FR101202303','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
                </p>
            </div>
            <p class="required text dni_invoice">
                <label for="dni"><?php echo smartyTranslate(array('s'=>'Identification number','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>*</sup></label>
                <input type="text" class="text" name="dni_invoice" id="dni_invoice"
                       value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['dni_invoice'])) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['dni_invoice'];?>
<?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
                <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                    <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'DNI / NIF / NIE','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
            </p>

            <p class="required text<?php if (strpos($_smarty_tpl->tpl_vars['opc_config']->value['hidden_fields'],'inv_firstname')>-1) {?> hidden_field<?php }?>">
                <label for="firstname_invoice"><?php echo smartyTranslate(array('s'=>'First name','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>*</sup></label>
                <input type="text" class="text" id="firstname_invoice" name="firstname_invoice"
                       value="<?php if (strpos($_smarty_tpl->tpl_vars['opc_config']->value['hidden_fields'],'inv_firstname')>-1) {?> <?php } elseif (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['firstname_invoice'])) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['firstname_invoice'];?>
<?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
                <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                    <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'Jack','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
            </p>

            <p class="required text">
                <label for="lastname_invoice"><?php echo smartyTranslate(array('s'=>'Last name','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>*</sup></label>
                <input type="text" class="text" id="lastname_invoice" name="lastname_invoice"
                       value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['lastname_invoice'])) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['lastname_invoice'];?>
<?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
                <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                    <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'Thompson','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
            </p>

            <p class="required text">
                <label for="address1_invoice"><?php echo smartyTranslate(array('s'=>'Address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>*</sup></label>
                <input type="text" class="text" name="address1_invoice" id="address1_invoice"
                       value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['address1_invoice'])) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['address1_invoice'];?>
<?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
                <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                    <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'15 High Street','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
            </p>

            <p class="text is_customer_param" id="p_address2_invoice"
               <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['address2_invoice'])||!$_smarty_tpl->tpl_vars['opc_config']->value['address2_invoice']) {?>style="display: none;"<?php }?>>
                <label for="address2_invoice"><?php echo smartyTranslate(array('s'=>'Address (Line 2)','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>&nbsp;&nbsp;</sup></label>
                <input type="text" class="text" name="address2_invoice" id="address2_invoice"
                       value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['address2_invoice'])) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['address2_invoice'];?>
<?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
                <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                    <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'Room no.304','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
            </p>

            <p class="required postcode_invoice text">
                <label for="postcode_invoice"><?php echo smartyTranslate(array('s'=>'Zip / Postal Code','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>*</sup></label>
                <input type="text" class="text" name="postcode_invoice" id="postcode_invoice"
                       value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['postcode_invoice'])) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['postcode_invoice'];?>
<?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
                <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                    <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'90104','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
            </p>

            <p class="required text">
                <label for="city_invoice"><?php echo smartyTranslate(array('s'=>'City','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>*</sup></label>
                <input type="text" class="text" name="city_invoice" id="city_invoice"
                       value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['city_invoice'])) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['city_invoice'];?>
<?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
                <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                    <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'Paris','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
            </p>

            <p class="required select"
               <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['country_invoice'])||!$_smarty_tpl->tpl_vars['opc_config']->value['country_invoice']) {?>style="display: none;"<?php }?>>
                <label for="id_country_invoice"><?php echo smartyTranslate(array('s'=>'Country','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>*</sup></label>
                <select name="id_country_invoice" id="id_country_invoice">
                    <option value="">-</option>
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['countries']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                        <?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['online_country_id'])&&$_smarty_tpl->tpl_vars['opc_config']->value['online_country_id']>0&&$_smarty_tpl->tpl_vars['opc_config']->value['online_country_id']==$_smarty_tpl->tpl_vars['v']->value['id_country']) {?><?php } else { ?>
                            <option value="<?php echo intval($_smarty_tpl->tpl_vars['v']->value['id_country']);?>
" <?php if ((isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['id_country_invoice'])&&$_smarty_tpl->tpl_vars['guestInformations']->value['id_country_invoice']==$_smarty_tpl->tpl_vars['v']->value['id_country'])||($_smarty_tpl->tpl_vars['def_country_invoice']->value==$_smarty_tpl->tpl_vars['v']->value['id_country'])||(!isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&($_smarty_tpl->tpl_vars['def_country_invoice']->value==0)&&$_smarty_tpl->tpl_vars['sl_country']->value==$_smarty_tpl->tpl_vars['v']->value['id_country'])) {?>
                                selected="selected"<?php }?>><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['v']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</option>
                        <?php }?>
                    <?php } ?>
                </select>
                <?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?><span
                    class="validity valid_blank"></span><?php }?>
            </p>
            <p class="required id_state_invoice select" style="display:none;">
                <label for="id_state_invoice"><?php echo smartyTranslate(array('s'=>'State','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>*</sup></label>
                <select name="id_state_invoice" id="id_state_invoice">
                    <option value="">-</option>
                </select><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
                <span class="validity valid_blank"></span><?php }?>
            </p>

            <p class="text" <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['phone_invoice'])||!$_smarty_tpl->tpl_vars['opc_config']->value['phone_invoice']) {?>style="display: none;"<?php }?>>
                <label for="phone_invoice"><?php echo smartyTranslate(array('s'=>'Home phone','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup><?php if (isset($_smarty_tpl->tpl_vars['one_phone_at_least']->value)&&$_smarty_tpl->tpl_vars['one_phone_at_least']->value) {?>*<?php } else { ?>&nbsp;&nbsp;<?php }?></sup></label>
                <input type="text" class="text" name="phone_invoice" id="phone_invoice"
                       value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['phone_invoice'])) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['phone_invoice'];?>
<?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
                <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                    <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'555-100200','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
            </p>

            <p class="text is_customer_param" <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['phone_mobile_invoice'])||!$_smarty_tpl->tpl_vars['opc_config']->value['phone_mobile_invoice']) {?>style="display: none;"<?php }?>>
                <label for="phone_mobile_invoice"><?php echo smartyTranslate(array('s'=>'Mobile phone','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<sup>&nbsp;&nbsp;</sup></label>
                <input type="text" class="text" name="phone_mobile_invoice" id="phone_mobile_invoice"
                       value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['phone_mobile_invoice'])) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['phone_mobile_invoice'];?>
<?php }?>"/><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?>
                <span class="validity valid_blank"></span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['sample_values'])&&$_smarty_tpl->tpl_vars['opc_config']->value['sample_values']) {?>
                    <span class="sample_text ex_blur">(<?php echo smartyTranslate(array('s'=>'e.g.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'555-100200','mod'=>'onepagecheckout'),$_smarty_tpl);?>
)</span><?php }?>
            </p>


            <p class="textarea is_customer_param"
               <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['additional_info_invoice'])||!$_smarty_tpl->tpl_vars['opc_config']->value['additional_info_invoice']) {?>style="display: none;"<?php }?>>
                <label for="other_invoice"><?php echo smartyTranslate(array('s'=>'Additional information','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</label>
                <textarea name="other_invoice" id="other_invoice" cols="26"
                          rows="3"><?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['other_invoice'])) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['other_invoice'];?>
<?php }?></textarea>
            </p>
            <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['compact_form'])||!$_smarty_tpl->tpl_vars['opc_config']->value['compact_form']) {?>
                <p style="clear: both;">
                    <sup>*</sup><?php echo smartyTranslate(array('s'=>'Required field','mod'=>'onepagecheckout'),$_smarty_tpl);?>

                </p>
            <?php }?>
            <input type="hidden" name="alias_invoice" id="alias_invoice"
                   value="<?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['alias_invoice'])) {?><?php echo $_smarty_tpl->tpl_vars['guestInformations']->value['alias_invoice'];?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'My Invoice address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php }?>"/>
            <input type="hidden" name="default_alias_invoice" id="default_alias_invoice"
                   value="<?php echo smartyTranslate(array('s'=>'My Invoice address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
"/>

            <?php if ($_smarty_tpl->tpl_vars['invoice_first']->value) {?><?php echo Smarty::$_smarty_vars['capture']['delivery_checkbox_block'];?>
<?php }?>
          </div> 
        </fieldset>
    </div>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?> 



<?php $_smarty_tpl->_capture_stack[0][] = array('login_block', null, null); ob_start(); ?>
    <form action="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('authentication.php',true), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
?back=order-opc.php" method="post" id="login_form"
          class="std" <?php if (($_smarty_tpl->tpl_vars['isLogged']->value&&!$_smarty_tpl->tpl_vars['isGuest']->value)) {?>style="display:none;"<?php }?>>
        <fieldset>
            <h3><div id="closeLoginFormContainer"><img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['modules_dir']->value, ENT_QUOTES, 'UTF-8', true);?>
onepagecheckout/views/img/close_icon.png" id="closeLoginFormBlock" /></div><?php echo smartyTranslate(array('s'=>'Already registered?','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <a href="#"
                                                                                                                                                                                                          id="openLoginFormBlock"><?php echo smartyTranslate(array('s'=>'Log-in','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</a>
            </h3>

            <div id="login_form_content" style="display:none;" class="address_fields">
                <!-- Error return block -->
                <div id="opc_login_errors" class="error" style="display:none;"></div>
                <!-- END Error return block -->

                <p class="required text">
                    <label for="login_email"><?php echo smartyTranslate(array('s'=>'E-mail address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</label>
                    <input type="text" class="text" id="login_email" name="email" value=""/>
                </p>

                <p class="required text">
                    <label for="login_passwd"><?php echo smartyTranslate(array('s'=>'Password','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</label>
                    <input type="password" class="text" id="login_passwd" name="login_passwd" value=""/>
                </p>

                <p class="submit">
                    <?php if (isset($_smarty_tpl->tpl_vars['back']->value)) {?><input type="hidden" class="hidden" name="back"
                                            value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['back']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"/><?php }?>
                    <label>&nbsp;</label>
                    <input type="submit" id="SubmitLoginOpc" name="SubmitLogin" class="button"
                           value="<?php echo smartyTranslate(array('s'=>'Log in','mod'=>'onepagecheckout'),$_smarty_tpl);?>
"/>
                </p>

                <p class="lost_password"><a
                            href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('password.php',true), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"><?php echo smartyTranslate(array('s'=>'Forgot your password?','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</a>
                </p>
            </div>
        </fieldset>
    </form>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?> 








<div id="opc_new_account" class="opc-main-block">
<div id="opc_new_account-overlay" class="opc-overlay" style="display: none;"></div>

<?php echo Smarty::$_smarty_vars['capture']['login_block'];?>


<div id="opc_account_form">
<form action="#" method="post" id="new_account_form" class="std">

<script type="text/javascript">
    // <![CDATA[
    idSelectedCountry = <?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&$_smarty_tpl->tpl_vars['guestInformations']->value['id_state']) {?><?php echo intval($_smarty_tpl->tpl_vars['guestInformations']->value['id_state']);?>
<?php } else { ?><?php if (($_smarty_tpl->tpl_vars['def_state']->value>0)) {?><?php echo intval($_smarty_tpl->tpl_vars['def_state']->value);?>
<?php } else { ?>false<?php }?><?php }?>;
    idSelectedCountry_invoice = <?php if (isset($_smarty_tpl->tpl_vars['guestInformations']->value)&&isset($_smarty_tpl->tpl_vars['guestInformations']->value['id_state_invoice'])) {?><?php echo intval($_smarty_tpl->tpl_vars['guestInformations']->value['id_state_invoice']);?>
<?php } else { ?><?php if (($_smarty_tpl->tpl_vars['def_state_invoice']->value>0)) {?><?php echo intval($_smarty_tpl->tpl_vars['def_state_invoice']->value);?>
<?php } else { ?>false<?php }?><?php }?>;
    <?php if (isset($_smarty_tpl->tpl_vars['countries']->value)) {?>
        <?php  $_smarty_tpl->tpl_vars['country'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['country']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['countries']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['country']->key => $_smarty_tpl->tpl_vars['country']->value) {
$_smarty_tpl->tpl_vars['country']->_loop = true;
?>
            <?php if (isset($_smarty_tpl->tpl_vars['country']->value['states'])&&$_smarty_tpl->tpl_vars['country']->value['contains_states']) {?>
            countries[<?php echo intval($_smarty_tpl->tpl_vars['country']->value['id_country']);?>
] = new Array();
                <?php  $_smarty_tpl->tpl_vars['state'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['state']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['country']->value['states']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['state']->key => $_smarty_tpl->tpl_vars['state']->value) {
$_smarty_tpl->tpl_vars['state']->_loop = true;
?>
                countries[<?php echo intval($_smarty_tpl->tpl_vars['country']->value['id_country']);?>
].push({'id':'<?php echo intval($_smarty_tpl->tpl_vars['state']->value['id_state']);?>
', 'name':'<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['state']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
'});
                <?php } ?>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['country']->value['need_identification_number']) {?>
            countriesNeedIDNumber.push(<?php echo intval($_smarty_tpl->tpl_vars['country']->value['id_country']);?>
);
            <?php }?>
            <?php if (isset($_smarty_tpl->tpl_vars['country']->value['need_zip_code'])) {?>
            countriesNeedZipCode[<?php echo intval($_smarty_tpl->tpl_vars['country']->value['id_country']);?>
] = <?php echo intval($_smarty_tpl->tpl_vars['country']->value['need_zip_code']);?>
;
            <?php }?>
        <?php } ?>
    <?php }?>
    //]]>
    
    
    function toggle_password_box() {
        if ($('#is_new_customer').val() == 0) {
            $('p.password').slideDown('slow');
            $('#is_new_customer').val(1);
        } else {
            $('p.password').slideUp('slow');
            $('#is_new_customer').val(0);
        }
    }//toggle_password_box()
    
</script>



<?php if (!$_smarty_tpl->tpl_vars['invoice_first']->value) {?>
    <?php echo Smarty::$_smarty_vars['capture']['delivery_address_block'];?>

    <?php echo Smarty::$_smarty_vars['capture']['invoice_address_block'];?>

<?php } else { ?>
    <?php echo Smarty::$_smarty_vars['capture']['invoice_address_block'];?>

    <?php echo Smarty::$_smarty_vars['capture']['delivery_address_block'];?>

<?php }?>





<?php echo $_smarty_tpl->tpl_vars['HOOK_CREATE_ACCOUNT_FORM']->value;?>

<!-- END Account -->

</form>
</div>
<!-- END div#opc_account_form -->
<div class="clear"></div>
</div>
<?php }} ?>
