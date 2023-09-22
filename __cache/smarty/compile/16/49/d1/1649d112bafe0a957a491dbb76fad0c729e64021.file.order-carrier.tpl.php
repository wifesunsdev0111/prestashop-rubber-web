<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 16:30:27
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/onepagecheckout/views/templates/front/order-carrier.tpl" */ ?>
<?php /*%%SmartyHeaderCode:212235499262b5ca839f02b4-53569401%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1649d112bafe0a957a491dbb76fad0c729e64021' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/onepagecheckout/views/templates/front/order-carrier.tpl',
      1 => 1470858411,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '212235499262b5ca839f02b4-53569401',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'opc_config' => 0,
    'carriers' => 0,
    'singleCarrier' => 0,
    'isVirtualCart' => 0,
    'conditions' => 0,
    'cms_id' => 0,
    'onlyCartSummary' => 0,
    'displayForm' => 0,
    'virtual_cart' => 0,
    'HOOK_BEFORECARRIER' => 0,
    'carrier' => 0,
    'checked' => 0,
    'free_shipping' => 0,
    'priceDisplay' => 0,
    'use_taxes' => 0,
    'HOOK_EXTRACARRIER' => 0,
    'recyclablePackAllowed' => 0,
    'recyclable' => 0,
    'giftAllowed' => 0,
    'cart' => 0,
    'gift_wrapping_price' => 0,
    'total_wrapping_tax_exc_cost' => 0,
    'total_wrapping_cost' => 0,
    'oldMessage' => 0,
    'checkedTOS' => 0,
    'link_conditions' => 0,
    'link_goods_return' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b5ca83a5ef91_48297381',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b5ca83a5ef91_48297381')) {function content_62b5ca83a5ef91_48297381($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value)&&isset($_smarty_tpl->tpl_vars['opc_config']->value['hide_carrier'])) {?>
    <?php $_smarty_tpl->tpl_vars['singleCarrier'] = new Smarty_variable($_smarty_tpl->tpl_vars['opc_config']->value['hide_carrier']=="1"&&isset($_smarty_tpl->tpl_vars['carriers']->value)&&$_smarty_tpl->tpl_vars['carriers']->value&&count($_smarty_tpl->tpl_vars['carriers']->value)==1, null, 0);?>
<?php } else { ?>
    <?php $_smarty_tpl->tpl_vars['singleCarrier'] = new Smarty_variable(isset($_smarty_tpl->tpl_vars['carriers']->value)&&$_smarty_tpl->tpl_vars['carriers']->value&&count($_smarty_tpl->tpl_vars['carriers']->value)==1, null, 0);?>
<?php }?>


<?php $_smarty_tpl->tpl_vars['displayForm'] = new Smarty_variable((!$_smarty_tpl->tpl_vars['singleCarrier']->value&&(!isset($_smarty_tpl->tpl_vars['isVirtualCart']->value)||!$_smarty_tpl->tpl_vars['isVirtualCart']->value))||(isset($_smarty_tpl->tpl_vars['opc_config']->value['order_msg'])&&$_smarty_tpl->tpl_vars['opc_config']->value['order_msg'])||($_smarty_tpl->tpl_vars['conditions']->value&&$_smarty_tpl->tpl_vars['cms_id']->value)||isset($_smarty_tpl->tpl_vars['onlyCartSummary']->value), null, 0);?>


<form id="carriers_section" class="std<?php if (isset($_smarty_tpl->tpl_vars['isVirtualCart']->value)&&$_smarty_tpl->tpl_vars['isVirtualCart']->value) {?> no_carriers<?php }?>" action="#"
      <?php if (!$_smarty_tpl->tpl_vars['displayForm']->value) {?>style="display:none"<?php }?>>
    <fieldset>

        <?php if (!isset($_smarty_tpl->tpl_vars['isVirtualCart']->value)||!$_smarty_tpl->tpl_vars['isVirtualCart']->value) {?>
            <h3 id="choose_delivery"
                <?php if ($_smarty_tpl->tpl_vars['singleCarrier']->value) {?>style="display:none;"<?php }?>><?php echo smartyTranslate(array('s'=>'Choose your delivery method','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</h3>
        <?php }?>

        <div id="opc_delivery_methods" class="opc-main-block">
            <div id="opc_delivery_methods-overlay" class="opc-overlay" style="display: none;"></div>

            <?php if ($_smarty_tpl->tpl_vars['virtual_cart']->value) {?>
                <input id="input_virtual_carrier" class="hidden" type="hidden" name="id_carrier" value="0"/>
            <?php } else { ?>
                <div id="HOOK_BEFORECARRIER"><?php if (isset($_smarty_tpl->tpl_vars['carriers']->value)) {?><?php echo $_smarty_tpl->tpl_vars['HOOK_BEFORECARRIER']->value;?>
<?php }?></div>
                <?php if (isset($_smarty_tpl->tpl_vars['isVirtualCart']->value)&&$_smarty_tpl->tpl_vars['isVirtualCart']->value) {?>
                
                <?php } else { ?>
                    <p class="warning" id="noCarrierWarning"
                       <?php if (isset($_smarty_tpl->tpl_vars['carriers']->value)&&$_smarty_tpl->tpl_vars['carriers']->value&&count($_smarty_tpl->tpl_vars['carriers']->value)) {?>style="display:none;"<?php }?>><?php echo smartyTranslate(array('s'=>'There are no carriers available that deliver to this address.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</p>
                    <table id="carrierTable" class="std"
                           <?php if (!isset($_smarty_tpl->tpl_vars['carriers']->value)||!$_smarty_tpl->tpl_vars['carriers']->value||!count($_smarty_tpl->tpl_vars['carriers']->value)||$_smarty_tpl->tpl_vars['singleCarrier']->value) {?>style="display:none;"<?php }?>>
                        
                        <tbody>
                        <?php if (isset($_smarty_tpl->tpl_vars['carriers']->value)) {?>
                            <?php  $_smarty_tpl->tpl_vars['carrier'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['carrier']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['carriers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['carrier']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['carrier']->iteration=0;
 $_smarty_tpl->tpl_vars['carrier']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['carrier']->key => $_smarty_tpl->tpl_vars['carrier']->value) {
$_smarty_tpl->tpl_vars['carrier']->_loop = true;
 $_smarty_tpl->tpl_vars['carrier']->iteration++;
 $_smarty_tpl->tpl_vars['carrier']->index++;
 $_smarty_tpl->tpl_vars['carrier']->first = $_smarty_tpl->tpl_vars['carrier']->index === 0;
 $_smarty_tpl->tpl_vars['carrier']->last = $_smarty_tpl->tpl_vars['carrier']->iteration === $_smarty_tpl->tpl_vars['carrier']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['first'] = $_smarty_tpl->tpl_vars['carrier']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['index']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['last'] = $_smarty_tpl->tpl_vars['carrier']->last;
?>
                                <tr class="<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['first']) {?>first_item<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['last']) {?>last_item<?php }?> <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['index']%2) {?>alternate_item<?php } else { ?>item<?php }?>">
                                    <td class="carrier_action radio">
                                        <input type="radio" name="id_carrier" value="<?php echo intval($_smarty_tpl->tpl_vars['carrier']->value['id_carrier']);?>
"
                                               id="id_carrier<?php echo intval($_smarty_tpl->tpl_vars['carrier']->value['id_carrier']);?>
"
                                               onclick="updateCarrierSelectionAndGift();"
                                               <?php if ($_smarty_tpl->tpl_vars['carrier']->value['id_carrier']==$_smarty_tpl->tpl_vars['checked']->value||count($_smarty_tpl->tpl_vars['carriers']->value)==1) {?>checked="checked"<?php }?> />
                                    </td>
                                    <td class="carrier_name">
                                        <label for="id_carrier<?php echo intval($_smarty_tpl->tpl_vars['carrier']->value['id_carrier']);?>
">
                                            <?php if ($_smarty_tpl->tpl_vars['carrier']->value['img']) {?><img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['img'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"
                                                                  alt="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"/><?php } else { ?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>
                                        </label>
                                    </td>
                                    <td class="carrier_infos">
                                        <label for="id_carrier<?php echo intval($_smarty_tpl->tpl_vars['carrier']->value['id_carrier']);?>
">
                                            <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['delay'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

                                        </label>
                                    </td>
                                    <td class="carrier_price">
                                        <label for="id_carrier<?php echo intval($_smarty_tpl->tpl_vars['carrier']->value['id_carrier']);?>
">
                                            <?php if ($_smarty_tpl->tpl_vars['carrier']->value['price']&&(!isset($_smarty_tpl->tpl_vars['free_shipping']->value)||(isset($_smarty_tpl->tpl_vars['free_shipping']->value)&&!$_smarty_tpl->tpl_vars['free_shipping']->value))) {?>
                                                <span class="price">
                                                <?php if ($_smarty_tpl->tpl_vars['priceDisplay']->value==1) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['carrier']->value['price_tax_exc']),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['carrier']->value['price']),$_smarty_tpl);?>
<?php }?>
                                                 </span>
                                                <?php if ($_smarty_tpl->tpl_vars['use_taxes']->value) {?><?php if ($_smarty_tpl->tpl_vars['priceDisplay']->value==1) {?> <?php echo smartyTranslate(array('s'=>'(tax excl.)','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php } else { ?> <?php echo smartyTranslate(array('s'=>'(tax incl.)','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php }?><?php }?>
                                            <?php } else { ?>
                                                <?php echo smartyTranslate(array('s'=>'Free!','mod'=>'onepagecheckout'),$_smarty_tpl);?>

                                            <?php }?>
                                        </label>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr id="HOOK_EXTRACARRIER"><?php if (isset($_smarty_tpl->tpl_vars['HOOK_EXTRACARRIER']->value)) {?><?php echo $_smarty_tpl->tpl_vars['HOOK_EXTRACARRIER']->value;?>
<?php }?></tr>
                        <?php }?>
                        </tbody>
                    </table>
                    <div style="display: none;" id="extra_carrier"></div>
                    <?php if ($_smarty_tpl->tpl_vars['recyclablePackAllowed']->value&&!isset($_smarty_tpl->tpl_vars['onlyCartSummary']->value)) {?>
                        <p class="checkbox">
                            <input type="checkbox" name="recyclable" id="recyclable" value="1"
                                   <?php if ($_smarty_tpl->tpl_vars['recyclable']->value==1) {?>checked="checked"<?php }?> />
                            <label for="recyclable"><?php echo smartyTranslate(array('s'=>'I agree to receive my order in recycled packaging','mod'=>'onepagecheckout'),$_smarty_tpl);?>

                                .</label>
                        </p>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['giftAllowed']->value&&!isset($_smarty_tpl->tpl_vars['onlyCartSummary']->value)) {?>
                        <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['compact_form'])||!$_smarty_tpl->tpl_vars['opc_config']->value['compact_form']) {?><h4
                                class="gift_title"><?php echo smartyTranslate(array('s'=>'Gift','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</h4><?php }?>
                        <p class="checkbox">
                            <input type="checkbox" name="gift" id="gift" value="1"
                                   <?php if ($_smarty_tpl->tpl_vars['cart']->value->gift==1) {?>checked="checked"<?php }?> />
                            <label for="gift"><?php echo smartyTranslate(array('s'=>'I would like the order to be gift-wrapped.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</label>
                            <?php if ($_smarty_tpl->tpl_vars['gift_wrapping_price']->value>0) {?>
                                (<?php echo smartyTranslate(array('s'=>'Additional cost of','mod'=>'onepagecheckout'),$_smarty_tpl);?>

                                <strong class="price" id="gift-price">
                                    <?php if ($_smarty_tpl->tpl_vars['priceDisplay']->value==1) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['total_wrapping_tax_exc_cost']->value),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['total_wrapping_cost']->value),$_smarty_tpl);?>
<?php }?>
                                </strong>
                                <?php if ($_smarty_tpl->tpl_vars['use_taxes']->value) {?><?php if ($_smarty_tpl->tpl_vars['priceDisplay']->value==1) {?> <?php echo smartyTranslate(array('s'=>'(tax excl.)','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php } else { ?> <?php echo smartyTranslate(array('s'=>'(tax incl.)','mod'=>'onepagecheckout'),$_smarty_tpl);?>
<?php }?><?php }?>
                                )
                            <?php }?>
                        </p>
                        <p id="gift_div" class="textarea">
                            <label for="gift_message"
                                   style="text-align: left;"><?php echo smartyTranslate(array('s'=>'If you wish, you can add a note to the gift:','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</label>
                            <textarea rows="5" cols="35" id="gift_message"
                                      name="gift_message"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cart']->value->gift_message, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</textarea>
                        </p>
                    <?php }?>
                <?php }?>
            <?php }?>
            <div id="message_container">
            <?php if (isset($_smarty_tpl->tpl_vars['opc_config']->value['order_msg'])&&$_smarty_tpl->tpl_vars['opc_config']->value['order_msg']&&!isset($_smarty_tpl->tpl_vars['onlyCartSummary']->value)) {?>
                <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['compact_form'])||!$_smarty_tpl->tpl_vars['opc_config']->value['compact_form']) {?>
                    <h4><?php echo smartyTranslate(array('s'=>'Leave a message','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</h4>
                <?php }?>
                <div>
                    <p id="order_msg_placeholder_fallback"><?php echo smartyTranslate(array('s'=>'If you would like to add a comment about your order, please write it below.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</p>

                    <p><div class="textarea-wrapper"><textarea rows="3" name="message" id="message"
                                 placeholder="<?php echo smartyTranslate(array('s'=>'If you would like to add a comment about your order, please write it here.','mod'=>'onepagecheckout'),$_smarty_tpl);?>
"><?php if (isset($_smarty_tpl->tpl_vars['oldMessage']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['oldMessage']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?></textarea></div>
                    </p>
                </div>
            <?php }?>
            </div>


            <?php if ($_smarty_tpl->tpl_vars['conditions']->value&&$_smarty_tpl->tpl_vars['cms_id']->value&&!isset($_smarty_tpl->tpl_vars['onlyCartSummary']->value)) {?>
            <?php if (!isset($_smarty_tpl->tpl_vars['opc_config']->value['compact_form'])||!$_smarty_tpl->tpl_vars['opc_config']->value['compact_form']) {?>
                <h4 class="condition_title"><?php echo smartyTranslate(array('s'=>'Terms of service','mod'=>'onepagecheckout'),$_smarty_tpl);?>
</h4>
            <?php }?>
            <?php if (!$_smarty_tpl->tpl_vars['opc_config']->value['order_detail_review']) {?>
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
            <?php }?>
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

        </div>
    </fieldset>
</form>

<?php }} ?>
