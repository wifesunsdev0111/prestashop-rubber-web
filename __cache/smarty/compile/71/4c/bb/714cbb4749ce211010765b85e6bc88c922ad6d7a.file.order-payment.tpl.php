<?php /* Smarty version Smarty-3.1.19, created on 2022-07-18 18:40:14
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/onepagecheckout/views/templates/front/order-payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:150107234062d58cee853c84-87459606%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '714cbb4749ce211010765b85e6bc88c922ad6d7a' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/onepagecheckout/views/templates/front/order-payment.tpl',
      1 => 1470858413,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '150107234062d58cee853c84-87459606',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'opc_config' => 0,
    'HOOK_PAYMENT' => 0,
    'HOOK_TOP_PAYMENT' => 0,
    'checkedTOS' => 0,
    'link_conditions' => 0,
    'link_goods_return' => 0,
    'add_extra_div' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62d58cee88cdc9_97866589',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62d58cee88cdc9_97866589')) {function content_62d58cee88cdc9_97866589($_smarty_tpl) {?>




<?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['payment_radio_buttons'])&&$_smarty_tpl->tpl_vars['opc_config']->value['payment_radio_buttons']) {?>
<form class="std" action="#" id="payments_section"<?php if ($_smarty_tpl->tpl_vars['opc_config']->value['hide_payment']=='1') {?> style="display: none;"<?php }?>>
<fieldset>
    <h3><?php echo smartyTranslate(array('s'=>'Choose your payment method','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</h3>

    <?php if (isset($_smarty_tpl->tpl_vars['HOOK_PAYMENT']->value['parsed_content'])&&$_smarty_tpl->tpl_vars['HOOK_PAYMENT']->value['parsed_content']&&isset($_smarty_tpl->tpl_vars['opc_config']->value['payment_radio_buttons'])&&$_smarty_tpl->tpl_vars['opc_config']->value['payment_radio_buttons']) {?>
    <div id="opc_payment_methods" class="opc-main-block">
        <div id="opc_payment_methods-overlay" class="opc-overlay" style="display: none;"></div>

        <div id="opc_payment_errors" class="error" style="display: none;"></div>
        <div id="HOOK_TOP_PAYMENT"><?php echo $_smarty_tpl->tpl_vars['HOOK_TOP_PAYMENT']->value;?>
</div>


        <div id="opc_payment_methods-parsed-content">
            <div id="HOOK_PAYMENT_PARSED"><?php echo $_smarty_tpl->tpl_vars['HOOK_PAYMENT']->value['parsed_content'];?>
</div>
        </div>
        <?php } else { ?>
        <div id="HOOK_PAYMENT_PARSED" style="display:none;"></div>
    </div>
    <?php }?>
</fieldset>
</form>
<?php }?>
</div> 
</div> 




    <?php if ((trim(Smarty::$_smarty_vars['capture']['password_checkbox'])!='')&&((!isset($_smarty_tpl->tpl_vars['opc_config']->value['offer_password_top'])||!$_smarty_tpl->tpl_vars['opc_config']->value['offer_password_top']))) {?>
    <form class="std<?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['hide_password_box'])&&$_smarty_tpl->tpl_vars['opc_config']->value['hide_password_box']) {?> no_show<?php }?>" action="javascript:return false;" id="offer_password">
        <fieldset>
            <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['offer_password_top'])||!$_smarty_tpl->tpl_vars['opc_config']->value['offer_password_top']) {?><?php echo Smarty::$_smarty_vars['capture']['password_checkbox'];?>
<?php }?>
    <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['offer_password_top'])||!$_smarty_tpl->tpl_vars['opc_config']->value['offer_password_top']) {?><?php echo Smarty::$_smarty_vars['capture']['password_field'];?>
<?php }?>
        </fieldset>
    </form>
    <?php }?>


    <?php if ($_smarty_tpl->tpl_vars['opc_config']->value['order_detail_review']) {?>
    <script type="text/javascript">
            
            function setPersonalDetailsAddress(targetDivs, postfix) {
                var address = $.trim($("#firstname" + postfix).val()) + " ";
                var tmpField = "";
                $("#lastname" + postfix + ", #address1" + postfix + ", #address2" + postfix + ", #postcode" + postfix + ", #city" + postfix + "").each(function () {
                    tmpField = $.trim($(this).val());
                    if (tmpField != "")
                        address += $.trim($(this).val()) + "<br />";
                });
                if ($("#id_country" + postfix + "").length)
                    address += $("#id_country" + postfix + " option:selected").html() + "<br />";

                if ($("#id_state" + postfix + "").length && $.trim($("#id_state" + postfix + " option:selected").html()) != "-")
                    address += $("#id_state" + postfix + " option:selected").html() + "<br />";

                $("#phone" + postfix + ", #phone_mobile" + postfix + "").each(function () {
                    tmpField = $.trim($(this).val());
                    if (tmpField != "")
                        address += $.trim($(this).val()) + "<br />";
                });

                targetDivs.each(function () {
                    $(this).html(address);
                });
            }

            function setDeliveryAddress() {
                if (!$("#invoice_address").is(":checked"))
                    setPersonalDetailsAddress($('#personal_info_delivery p.review-address, #personal_info_invoice p.review-address'), '');
                else
                    setPersonalDetailsAddress($('#personal_info_delivery p.review-address'), '');
            }

            function setInvoiceAddress() {
                if ($("#invoice_address").is(":checked"))
                    setPersonalDetailsAddress($('#personal_info_invoice p.review-address'), '_invoice');
                else
                    setPersonalDetailsAddress($('#personal_info_invoice p.review-address'), '');
            }

            function setPersonalDetailsCarrier() {

                $('#email-review').remove();
                $('#personal_info_delivery h4').after('<p id="email-review" style="padding-bottom: 3px">'+$('#email').val()+'</p>');

                if ($('input[name=id_carrier]:checked').length) {
                    //$('#personal_info_shipping p').html($('input[name=id_carrier]:checked').parent().next().children('label').html());
                    var carrier_tr = $('input[name=id_carrier]:checked').closest('tr');
                    var img = carrier_tr.find('.carrier_name label').html();
                    var desc = carrier_tr.find('.carrier_infos label').html();
                    $('#personal_info_shipping p').html(img+desc);
                } else if($('input.delivery_option_radio:checked').length) {
                    var dlv_el = $('input.delivery_option_radio:checked').next();
                    var c1 = dlv_el.find('.delivery_option_logo').html();
                    c1 += dlv_el.find('.delivery_option_title').html();
                    $('#personal_info_shipping p').html(c1);
                }

            }

            function setPersonalDetailsPayment() {
                if ($('input[name=id_payment_method]:checked').length) {
                    var el = $('input[name=id_payment_method]:checked').parent();
                    if (!el.next().length)
                      el = el.parent();
                    if (!el.next().length)
                      el = el.parent();

                    //$('#personal_info_payment p').html(el.next().next().html());
                    var payment_tr = el.closest('tr');
                    var img = payment_tr.find('.payment_name label').html();
                    var desc = payment_tr.find('.payment_description label').html();
                    $('#personal_info_payment p').html(img+desc);
                }
            }

            $(function () {
                $('#firstname, #lastname, #address1, #address2, #postcode, #city, #phone, #phone_mobile').keyup(setDeliveryAddress);
                $('#id_country, #id_state').change(setDeliveryAddress);
                setDeliveryAddress();
                $('#firstname_invoice, #lastname_invoice, #address1_invoice, #address2_invoice, #postcode_invoice, #city_invoice, #phone_invoice, #phone_mobile_invoice').keyup(setInvoiceAddress);
                $('#id_country_invoice, #id_state_invoice').change(setInvoiceAddress);
                setInvoiceAddress();

                setPersonalDetailsCarrier();
                $('#email').keyup(setPersonalDetailsCarrier);
                //setPersonalDetailsPayment();
                $('input[name=id_payment_method]').change(setPersonalDetailsPayment);

            });
            
    </script>

    <form id="personal_info_review" action="#" class="std">
        <fieldset>
            <h3><?php echo smartyTranslate(array('s'=>'Order summary review','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</h3>

            <div id="personal_info_delivery"><h4><?php echo smartyTranslate(array('s'=>'Delivery address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <a href="#"
                                                                                                   onclick="$.scrollTo('#opc_account_form', 1000);"><?php echo smartyTranslate(array('s'=>'Edit','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</a>
            </h4>

                <p class="review-address"></p></div>
            <div id="personal_info_invoice"><h4><?php echo smartyTranslate(array('s'=>'Invoice address','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <a href="#"
                                                                                                 onclick="$.scrollTo('#opc_account_form', 1000);"><?php echo smartyTranslate(array('s'=>'Edit','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</a>
            </h4>

                <p class="review-address"></p></div>
            <div id="personal_info_shipping"><h4><?php echo smartyTranslate(array('s'=>'Shipping method','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <a href="#"
                                                                                                  onclick="$.scrollTo('#carriers_section', 600);"><?php echo smartyTranslate(array('s'=>'Edit','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</a>
            </h4>

                <p></p></div>
            <div id="personal_info_payment"><h4><?php echo smartyTranslate(array('s'=>'Payment method','mod'=>'onepagecheckout'),$_smarty_tpl);?>
 <a href="#"
                                                                                                onclick="$.scrollTo('#payments_section', 600);"><?php echo smartyTranslate(array('s'=>'Edit','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</a>
            </h4>

                <p></p></div>
            <div id="personal_info_tos">
                <div id="opc_tos_errors" class="error" style="display: none;"></div>
                <p class="checkbox">
                    <input type="checkbox" name="cgv" id="cgv" value="1" <?php if ($_smarty_tpl->tpl_vars['checkedTOS']->value) {?>checked="checked"<?php }?> />
                    <label for="cgv"><?php echo smartyTranslate(array('s'=>'I agree to the terms of service and adhere to them unconditionally.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</label>
                    <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link_conditions']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="iframe"><?php echo smartyTranslate(array('s'=>'(read)','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</a>
                    <sup>*</sup><?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes'])&&$_smarty_tpl->tpl_vars['opc_config']->value['validation_checkboxes']) {?><span
                        class="validity valid_<?php if ($_smarty_tpl->tpl_vars['checkedTOS']->value) {?>ok<?php } else { ?>nok<?php }?>"></span><?php }?>
                </p>
                <?php if ($_smarty_tpl->tpl_vars['opc_config']->value['goods_return_cms']>0) {?>
                    <div id="goods_return">
                        <p><?php echo smartyTranslate(array('s'=>'You are entitled to cancel your order within 7 Working Days upon goods receive.','mod'=>'onepagecheckout'),$_smarty_tpl);?>

                            <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link_goods_return']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="iframe"><?php echo smartyTranslate(array('s'=>'(read)','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</a></p>
                    </div>
                <?php }?>
            </div>
        </fieldset>
    </form>
        <script type="text/javascript">
            $(document).ready(function() {
                $("a.iframe").fancybox({
                    'type' : 'iframe',
                    'width':600,
                    'height':600
                });
            });
        </script>
        <!--script type="text/javascript">$('a.iframe').fancybox();</script-->
    <?php }?>

    <?php if ($_smarty_tpl->tpl_vars['opc_config']->value['cart_summary_bottom']) {?>
    <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['opc_templates_path']->value)."/shopping-cart.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('addClass'=>"summary_bottom"), 0);?>

    <?php }?>

    <?php if ($_smarty_tpl->tpl_vars['opc_config']->value['above_confirmation_message']) {?>
    <div id="above_confirmation_msg"><?php echo smartyTranslate(array('s'=>'above confirmation button msg','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</div>
    <?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['payment_radio_buttons'])&&$_smarty_tpl->tpl_vars['opc_config']->value['payment_radio_buttons']) {?>

<div class="confirm_button_div">
    <input type="button" class="confirm_button" title="<?php echo smartyTranslate(array('s'=>'I confirm my order','mod'=>'onepagecheckout'),$_smarty_tpl);?>
"
           value="&raquo;  <?php echo smartyTranslate(array('s'=>'I confirm my order','mod'=>'onepagecheckout'),$_smarty_tpl);?>
  &laquo;"
           onclick="paymentModuleConfirm();"/>
</div>

<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['payment_radio_buttons'])&&$_smarty_tpl->tpl_vars['opc_config']->value['payment_radio_buttons']) {?>
    <?php if (isset($_smarty_tpl->tpl_vars['HOOK_PAYMENT']->value['orig_hook'])&&$_smarty_tpl->tpl_vars['HOOK_PAYMENT']->value['orig_hook']) {?>
    <div id="opc_payment_methods-content" style="display: none;">
        <div id="HOOK_PAYMENT" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['HOOK_PAYMENT']->value['orig_hook'];?>
</div>
    </div>
        <?php } else { ?>
    <p class="warning"><?php echo smartyTranslate(array('s'=>'No payment modules have been installed.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</p>
    <?php }?>
<?php }?>


<script src='/js/2ca5a69ad9c1f47d6c6743f3446fa75f.js'></script>

<?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['payment_radio_buttons'])||!$_smarty_tpl->tpl_vars['opc_config']->value['payment_radio_buttons']) {?>

    <div class="std" action="#" id="payments_section">
        <fieldset>
            <h3><?php echo smartyTranslate(array('s'=>'Choose your payment method','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</h3>

            <div id="opc_payment_methods" class="opc-main-block">
                <div id="opc_payment_methods-overlay" class="opc-overlay" style="display: none;"></div>

                <div id="save_account-overlay" class="save-account-overlay" style="display: none;">
                </div>
                <div class="save-account-button-container" style="display: none">
                    <div class="save-account-button"><?php echo smartyTranslate(array('s'=>'Save account & Show payment options','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</div>
                </div>


                <div id="opc_payment_errors" class="error" style="display: none;"></div>
                <div id="HOOK_TOP_PAYMENT"><?php echo $_smarty_tpl->tpl_vars['HOOK_TOP_PAYMENT']->value;?>
</div>

                <?php if (isset($_smarty_tpl->tpl_vars['HOOK_PAYMENT']->value['orig_hook'])&&$_smarty_tpl->tpl_vars['HOOK_PAYMENT']->value['orig_hook']) {?>
                    <div id="opc_payment_methods-content">
                        <div id="HOOK_PAYMENT"><?php echo $_smarty_tpl->tpl_vars['HOOK_PAYMENT']->value['orig_hook'];?>
</div>

                    </div>
                <?php } else { ?>
                    <p class="warning"><?php echo smartyTranslate(array('s'=>'No payment modules have been installed.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</p>
                <?php }?>
            </div>
        </fieldset>
    </div>
<?php }?>


<?php if ($_smarty_tpl->tpl_vars['add_extra_div']->value) {?></div><?php }?>
<div class="clearfix"></div>

<?php }} ?>
