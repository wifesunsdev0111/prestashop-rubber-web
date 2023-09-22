<?php
/* Smarty version 3.1.47, created on 2023-07-30 01:10:29
  from '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/themes/kenzyfashion/templates/checkout/_partials/steps/addresses.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64c59c65b1a1b1_85081768',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ce8f32aaca60d301a319367957ac482d5d89d761' => 
    array (
      0 => '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/themes/kenzyfashion/templates/checkout/_partials/steps/addresses.tpl',
      1 => 1680526196,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:checkout/_partials/address-selector-block.tpl' => 2,
  ),
),false)) {
function content_64c59c65b1a1b1_85081768 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_209976728664c59c65b00077_64188924', 'step_content');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, 'checkout/_partials/steps/checkout-step.tpl');
}
/* {block 'step_content'} */
class Block_209976728664c59c65b00077_64188924 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'step_content' => 
  array (
    0 => 'Block_209976728664c59c65b00077_64188924',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <div class="js-address-form">
    <form
      method="POST"
      action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['urls']->value['pages']['order'], ENT_QUOTES, 'UTF-8');?>
"
      data-refresh-url="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0], array( array('entity'=>'order','params'=>array('ajax'=>1,'action'=>'addressForm')),$_smarty_tpl ) );?>
"
    >

      <?php if (!$_smarty_tpl->tpl_vars['use_same_address']->value) {?>
        <h2 class="h4"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Shipping Address','d'=>'Shop.Theme.Checkout'),$_smarty_tpl ) );?>
</h2>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['use_same_address']->value && !$_smarty_tpl->tpl_vars['cart']->value['is_virtual']) {?>
        <p>
          <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'The selected address will be used both as your personal address (for invoice) and as your delivery address.','d'=>'Shop.Theme.Checkout'),$_smarty_tpl ) );?>

        </p>
      <?php } elseif ($_smarty_tpl->tpl_vars['use_same_address']->value && $_smarty_tpl->tpl_vars['cart']->value['is_virtual']) {?>
        <p>
          <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'The selected address will be used as your personal address (for invoice).','d'=>'Shop.Theme.Checkout'),$_smarty_tpl ) );?>

        </p>
      <?php }?>

      <?php if ($_smarty_tpl->tpl_vars['show_delivery_address_form']->value) {?>
        <div id="delivery-address">
          <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['render'][0], array( array('file'=>'checkout/_partials/address-form.tpl','ui'=>$_smarty_tpl->tpl_vars['address_form']->value,'use_same_address'=>$_smarty_tpl->tpl_vars['use_same_address']->value,'type'=>"delivery",'form_has_continue_button'=>$_smarty_tpl->tpl_vars['form_has_continue_button']->value),$_smarty_tpl ) );?>

        </div>
      <?php } elseif (count($_smarty_tpl->tpl_vars['customer']->value['addresses']) > 0) {?>
        <div id="delivery-addresses" class="address-selector js-address-selector">
          <?php $_smarty_tpl->_subTemplateRender('file:checkout/_partials/address-selector-block.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('addresses'=>$_smarty_tpl->tpl_vars['customer']->value['addresses'],'name'=>"id_address_delivery",'selected'=>$_smarty_tpl->tpl_vars['id_address_delivery']->value,'type'=>"delivery",'interactive'=>!$_smarty_tpl->tpl_vars['show_delivery_address_form']->value && !$_smarty_tpl->tpl_vars['show_invoice_address_form']->value), 0, false);
?>
        </div>

        <?php if ((isset($_smarty_tpl->tpl_vars['delivery_address_error']->value))) {?>
          <p class="alert alert-danger js-address-error" name="alert-delivery" id="id-failure-address-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['delivery_address_error']->value['id_address'], ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['delivery_address_error']->value['exception'], ENT_QUOTES, 'UTF-8');?>
</p>
        <?php } else { ?>
          <p class="alert alert-danger js-address-error" name="alert-delivery" style="display: none"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Your address is incomplete, please update it.",'d'=>"Shop.Notifications.Error"),$_smarty_tpl ) );?>
</p>
        <?php }?>

        <p class="add-address">
          <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['new_address_delivery_url']->value, ENT_QUOTES, 'UTF-8');?>
"><i class="material-icons">&#xE145;</i><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'add new address','d'=>'Shop.Theme.Actions'),$_smarty_tpl ) );?>
</a>
        </p>

        <?php if ($_smarty_tpl->tpl_vars['use_same_address']->value && !$_smarty_tpl->tpl_vars['cart']->value['is_virtual']) {?>
          <p>
            <a data-link-action="different-invoice-address" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['use_different_address_url']->value, ENT_QUOTES, 'UTF-8');?>
">
              <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Billing address differs from shipping address','d'=>'Shop.Theme.Checkout'),$_smarty_tpl ) );?>

            </a>
          </p>
        <?php }?>

      <?php }?>

      <?php if (!$_smarty_tpl->tpl_vars['use_same_address']->value) {?>

        <h2 class="h4"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Your Invoice Address','d'=>'Shop.Theme.Checkout'),$_smarty_tpl ) );?>
</h2>

        <?php if ($_smarty_tpl->tpl_vars['show_invoice_address_form']->value) {?>
          <div id="invoice-address">
            <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['render'][0], array( array('file'=>'checkout/_partials/address-form.tpl','ui'=>$_smarty_tpl->tpl_vars['address_form']->value,'use_same_address'=>$_smarty_tpl->tpl_vars['use_same_address']->value,'type'=>"invoice",'form_has_continue_button'=>$_smarty_tpl->tpl_vars['form_has_continue_button']->value),$_smarty_tpl ) );?>

          </div>
        <?php } else { ?>
          <div id="invoice-addresses" class="address-selector js-address-selector">
            <?php $_smarty_tpl->_subTemplateRender('file:checkout/_partials/address-selector-block.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('addresses'=>$_smarty_tpl->tpl_vars['customer']->value['addresses'],'name'=>"id_address_invoice",'selected'=>$_smarty_tpl->tpl_vars['id_address_invoice']->value,'type'=>"invoice",'interactive'=>!$_smarty_tpl->tpl_vars['show_delivery_address_form']->value && !$_smarty_tpl->tpl_vars['show_invoice_address_form']->value), 0, true);
?>
          </div>

          <?php if ((isset($_smarty_tpl->tpl_vars['invoice_address_error']->value))) {?>
            <p class="alert alert-danger js-address-error" name="alert-invoice" id="id-failure-address-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['invoice_address_error']->value['id_address'], ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['invoice_address_error']->value['exception'], ENT_QUOTES, 'UTF-8');?>
</p>
          <?php } else { ?>
            <p class="alert alert-danger js-address-error" name="alert-invoice" style="display: none"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>"Your address is incomplete, please update it.",'d'=>"Shop.Notifications.Error"),$_smarty_tpl ) );?>
</p>
          <?php }?>

          <p class="add-address">
            <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['new_address_invoice_url']->value, ENT_QUOTES, 'UTF-8');?>
"><i class="material-icons">&#xE145;</i><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'add new address','d'=>'Shop.Theme.Actions'),$_smarty_tpl ) );?>
</a>
          </p>
        <?php }?>

      <?php }?>

      <?php if (!$_smarty_tpl->tpl_vars['form_has_continue_button']->value) {?>
        <div class="clearfix">
          <button type="submit" class="btn btn-primary continue float-xs-right" name="confirm-addresses" value="1">
              <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Continue','d'=>'Shop.Theme.Actions'),$_smarty_tpl ) );?>

          </button>
          <input type="hidden" id="not-valid-addresses" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['not_valid_addresses']->value, ENT_QUOTES, 'UTF-8');?>
">
        </div>
      <?php }?>

    </form>
  </div>
<?php
}
}
/* {/block 'step_content'} */
}
