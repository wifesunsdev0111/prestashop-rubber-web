<?php /* Smarty version Smarty-3.1.19, created on 2022-07-28 17:55:33
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal//views/templates/admin/installmentSettings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:93652255762e2b175de69f8-66476151%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0ee7948805ef72dcb8aae05394bbc149ac83def7' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal//views/templates/admin/installmentSettings.tpl',
      1 => 1641581521,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '93652255762e2b175de69f8-66476151',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'isoCountryDefault' => 0,
    'moduleDir' => 0,
    'PAYPAL_ENABLE_INSTALLMENT' => 0,
    'PayPal_sandbox_mode' => 0,
    'PAYPAL_CLIENT_ID_INSTALLMENT' => 0,
    'PAYPAL_INSTALLMENT_HOME_PAGE' => 0,
    'PAYPAL_INSTALLMENT_CATEGORY_PAGE' => 0,
    'PAYPAL_INSTALLMENT_PRODUCT_PAGE' => 0,
    'PAYPAL_INSTALLMENT_CART_PAGE' => 0,
    'PAYPAL_INSTALLMENT_CHECKOUT_PAGE' => 0,
    'PAYPAL_ADVANCED_OPTIONS_INSTALLMENT' => 0,
    'installmentColorOptions' => 0,
    'value' => 0,
    'PAYPAL_INSTALLMENT_COLOR' => 0,
    'title' => 0,
    'paypalInstallmentBanner' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62e2b175e2b717_89574925',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62e2b175e2b717_89574925')) {function content_62e2b175e2b717_89574925($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['isoCountryDefault']->value)) {?>
    <?php if ($_smarty_tpl->tpl_vars['isoCountryDefault']->value=='fr') {?>
        <div installment-disclaimer class="pp__flex pp__flex-align-center pp__mb-5 pp__pb-4">
            <div class="pp__pr-4">
                <img style="width: 135px" src="<?php echo addslashes($_smarty_tpl->tpl_vars['moduleDir']->value);?>
/views/img/paypal.png">
            </div>
            <div class="pp__pl-5 bootstrap">
                <div class="h4">
                    <?php echo smartyTranslate(array('s'=>'Display the 4X PayPal Payment on your site','mod'=>'paypal'),$_smarty_tpl);?>

                </div>

                <div>
                    <?php echo smartyTranslate(array('s'=>'Payment in 4X PayPal allows French consumers to pay in 4 equal installments. You can promote 4X PayPal Payment only if you are a merchant based in France, with a French website and standard PayPal integration.','mod'=>'paypal'),$_smarty_tpl);?>

                    <?php echo smartyTranslate(array('s'=>'Merchants with the Vaulting tool (digital safe) or recurring payments / subscription integration, as well as those with certain activities (sale of digital goods / non-physical goods) are not eligible to promote 4X PayPal Payment . We will post messages on your site promoting 4X PayPal Payment. You cannot promote 4X PayPal Payment with any other content.','mod'=>'paypal'),$_smarty_tpl);?>

                </div>
                <div>
                    <a href="https://www.paypal.com/fr/business/buy-now-pay-later" target="_blank">
                        <?php echo smartyTranslate(array('s'=>'See more','mod'=>'paypal'),$_smarty_tpl);?>

                    </a>
                </div>
            </div>
        </div>

    <?php }?>

    <?php if ($_smarty_tpl->tpl_vars['isoCountryDefault']->value=='gb') {?>
        <div installment-disclaimer class="pp__flex pp__flex-align-center pp__mb-5 pp__pb-4">
            <div class="pp__pr-4">
                <img style="width: 135px" src="<?php echo addslashes($_smarty_tpl->tpl_vars['moduleDir']->value);?>
/views/img/paypal.png">
            </div>
            <div class="pp__pl-5 bootstrap">
                <div class="h4">
                    <?php echo smartyTranslate(array('s'=>'Display the 3X PayPal Payment on your site','mod'=>'paypal'),$_smarty_tpl);?>

                </div>
                <div>
                    <?php echo smartyTranslate(array('s'=>'Display pay later messaging on your site for offers like Pay in 3, which lets customers pay with 3 interest-free monthly payments.','mod'=>'paypal'),$_smarty_tpl);?>

                    <?php echo smartyTranslate(array('s'=>'We’ll show messages on your site to promote this feature for you. You may not promote pay later offers with any other content, marketing, or materials.','mod'=>'paypal'),$_smarty_tpl);?>

                </div>

                <div>
                    <a href="https://www.paypal.com/fr/business/buy-now-pay-later" target="_blank">
                        <?php echo smartyTranslate(array('s'=>'See more','mod'=>'paypal'),$_smarty_tpl);?>

                    </a>
                </div>
            </div>
        </div>
    <?php }?>
<?php }?>

<div paypal-installment-settings>

    <form
            id="pp_config_installment"
            method="post"
            action="<?php echo mb_convert_encoding(htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">

        <div class="paypal-form-group pp__flex-align-center pp_mb-20">
            <div class="label">
                <?php if (isset($_smarty_tpl->tpl_vars['isoCountryDefault']->value)&&$_smarty_tpl->tpl_vars['isoCountryDefault']->value==='gb') {?>
                    <?php echo smartyTranslate(array('s'=>'Enable the display of 3x banners','mod'=>'paypal'),$_smarty_tpl);?>

                <?php } else { ?>
                    <?php echo smartyTranslate(array('s'=>'Enable the display of 4x banners','mod'=>'paypal'),$_smarty_tpl);?>

                <?php }?>

            </div>

            <div class="configuration">
                <div class="pp__switch-field">
                    <input
                            class="pp__switch-input"
                            type="radio"
                            id="PAYPAL_ENABLE_INSTALLMENT_on"
                            name="PAYPAL_ENABLE_INSTALLMENT"
                            value="1"
                            <?php if (isset($_smarty_tpl->tpl_vars['PAYPAL_ENABLE_INSTALLMENT']->value)&&$_smarty_tpl->tpl_vars['PAYPAL_ENABLE_INSTALLMENT']->value=='1') {?>checked<?php }?>/>
                    <label for="PAYPAL_ENABLE_INSTALLMENT_on" class="pp__switch-label on">Yes</label>
                    <input
                            class="pp__switch-input"
                            type="radio"
                            id="PAYPAL_ENABLE_INSTALLMENT_off"
                            name="PAYPAL_ENABLE_INSTALLMENT"
                            value="0"
                            <?php if (isset($_smarty_tpl->tpl_vars['PAYPAL_ENABLE_INSTALLMENT']->value)&&$_smarty_tpl->tpl_vars['PAYPAL_ENABLE_INSTALLMENT']->value=='0') {?>checked<?php }?>/>
                    <label for="PAYPAL_ENABLE_INSTALLMENT_off" class="pp__switch-label off">No</label>
                </div>
            </div>
        </div>

        <div class="paypal-form-group pp__flex-align-center pp_mb-20">
            <div class="label">
                <?php if (isset($_smarty_tpl->tpl_vars['PayPal_sandbox_mode']->value)&&$_smarty_tpl->tpl_vars['PayPal_sandbox_mode']->value) {?>
                    <?php echo smartyTranslate(array('s'=>'REST Client ID Sandbox','mod'=>'paypal'),$_smarty_tpl);?>


                <?php } else { ?>
                    <?php echo smartyTranslate(array('s'=>'REST Client ID','mod'=>'paypal'),$_smarty_tpl);?>

                <?php }?>
            </div>

            <div class="configuration">
                <div class="bootstrap pp__flex" style="width: 50%">
                    <input
                            type="text"
                            name="PAYPAL_CLIENT_ID_INSTALLMENT"
                            <?php if (isset($_smarty_tpl->tpl_vars['PAYPAL_CLIENT_ID_INSTALLMENT']->value)) {?>value="<?php echo $_smarty_tpl->tpl_vars['PAYPAL_CLIENT_ID_INSTALLMENT']->value;?>
"<?php }?>>
                    <div>
                        <span class="btn btn-default pp__ml-2" onclick="toggleHint(event)">?</span>
                    </div>

                </div>
            </div>
        </div>

        <div class="paypal-form-group pp__flex-align-center pp_mb-20 hidden" clientId-hint>
            <div class="label">
            </div>

            <div class="configuration">
                <div class="bootstrap">
                    <div class="alert alert-info">
                        <?php echo smartyTranslate(array('s'=>'In order to display the banner “Pay in 4x”, please create a REST App in order to get your ClientID :','mod'=>'paypal'),$_smarty_tpl);?>

                        <ul>
                            <li>
                                <?php echo smartyTranslate(array('s'=>'Access to ','mod'=>'paypal'),$_smarty_tpl);?>

                                <a href="https://developer.paypal.com/developer/applications/" target="_blank">
                                    https://developer.paypal.com/developer/applications/
                                </a>
                            </li>
                            <li>
                                <?php echo smartyTranslate(array('s'=>'Log in or create a business account','mod'=>'paypal'),$_smarty_tpl);?>

                            </li>
                            <li>
                                <?php echo smartyTranslate(array('s'=>'Create a "REST API apps"','mod'=>'paypal'),$_smarty_tpl);?>

                            </li>
                            <li>
                                <?php echo smartyTranslate(array('s'=>'Copy/paste your "Client ID"','mod'=>'paypal'),$_smarty_tpl);?>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="paypal-form-group pp_mb-20">
            <div class="label"></div>

            <div class="configuration">
                <div installment-page-displaying-setting-container>
                    <div class="pp_mb-10">
                        <input
                                type="checkbox"
                                id="PAYPAL_INSTALLMENT_HOME_PAGE"
                                name="PAYPAL_INSTALLMENT_HOME_PAGE"
                                value="1"
                                <?php if (isset($_smarty_tpl->tpl_vars['PAYPAL_INSTALLMENT_HOME_PAGE']->value)&&$_smarty_tpl->tpl_vars['PAYPAL_INSTALLMENT_HOME_PAGE']->value) {?>checked<?php }?>
                        >
                        <label for="PAYPAL_INSTALLMENT_HOME_PAGE">
                            <?php echo smartyTranslate(array('s'=>'Home Page','mod'=>'paypal'),$_smarty_tpl);?>

                        </label>
                    </div>

                    <div class="pp_mb-10">
                        <input
                                type="checkbox"
                                id="PAYPAL_INSTALLMENT_CATEGORY_PAGE"
                                name="PAYPAL_INSTALLMENT_CATEGORY_PAGE"
                                value="1"
                                <?php if (isset($_smarty_tpl->tpl_vars['PAYPAL_INSTALLMENT_CATEGORY_PAGE']->value)&&$_smarty_tpl->tpl_vars['PAYPAL_INSTALLMENT_CATEGORY_PAGE']->value) {?>checked<?php }?>
                        >
                        <label for="PAYPAL_INSTALLMENT_CATEGORY_PAGE">
                            <?php echo smartyTranslate(array('s'=>'Category Page','mod'=>'paypal'),$_smarty_tpl);?>

                        </label>
                    </div>

                    <div class="pp_mb-10">
                        <input
                                type="checkbox"
                                id="PAYPAL_INSTALLMENT_PRODUCT_PAGE"
                                name="PAYPAL_INSTALLMENT_PRODUCT_PAGE"
                                value="1"
                                <?php if (isset($_smarty_tpl->tpl_vars['PAYPAL_INSTALLMENT_PRODUCT_PAGE']->value)&&$_smarty_tpl->tpl_vars['PAYPAL_INSTALLMENT_PRODUCT_PAGE']->value) {?>checked<?php }?>
                        >
                        <label for="PAYPAL_INSTALLMENT_PRODUCT_PAGE">
                            <?php echo smartyTranslate(array('s'=>'Product Page','mod'=>'paypal'),$_smarty_tpl);?>

                        </label>
                    </div>

                    <div class="pp_mb-10">
                        <input
                                type="checkbox"
                                id="PAYPAL_INSTALLMENT_CART_PAGE"
                                name="PAYPAL_INSTALLMENT_CART_PAGE"
                                value="1"
                                <?php if (isset($_smarty_tpl->tpl_vars['PAYPAL_INSTALLMENT_CART_PAGE']->value)&&$_smarty_tpl->tpl_vars['PAYPAL_INSTALLMENT_CART_PAGE']->value) {?>checked<?php }?>
                        >
                        <label for="PAYPAL_INSTALLMENT_CART_PAGE">
                            <?php echo smartyTranslate(array('s'=>'Cart','mod'=>'paypal'),$_smarty_tpl);?>

                        </label>
                    </div>

                    <div>
                        <input
                                type="checkbox"
                                id="PAYPAL_INSTALLMENT_CHECKOUT_PAGE"
                                name="PAYPAL_INSTALLMENT_CHECKOUT_PAGE"
                                value="1"
                                <?php if (isset($_smarty_tpl->tpl_vars['PAYPAL_INSTALLMENT_CHECKOUT_PAGE']->value)&&$_smarty_tpl->tpl_vars['PAYPAL_INSTALLMENT_CHECKOUT_PAGE']->value) {?>checked<?php }?>
                        >
                        <label for="PAYPAL_INSTALLMENT_CHECKOUT_PAGE">
                            <?php echo smartyTranslate(array('s'=>'Checkout (payment step)','mod'=>'paypal'),$_smarty_tpl);?>

                        </label>
                    </div>

                </div>
            </div>
        </div>

        <div class="paypal-form-group pp__flex-align-center pp_mb-20">
            <div class="label">
                <?php echo smartyTranslate(array('s'=>'Advanced options','mod'=>'paypal'),$_smarty_tpl);?>

            </div>

            <div class="configuration">
                <div class="pp__switch-field">
                    <input
                            class="pp__switch-input"
                            type="radio"
                            id="PAYPAL_ADVANCED_OPTIONS_INSTALLMENT_on"
                            name="PAYPAL_ADVANCED_OPTIONS_INSTALLMENT"
                            value="1"
                            <?php if (isset($_smarty_tpl->tpl_vars['PAYPAL_ADVANCED_OPTIONS_INSTALLMENT']->value)&&$_smarty_tpl->tpl_vars['PAYPAL_ADVANCED_OPTIONS_INSTALLMENT']->value=='1') {?>checked<?php }?>/>
                    <label for="PAYPAL_ADVANCED_OPTIONS_INSTALLMENT_on" class="pp__switch-label on">Yes</label>
                    <input
                            class="pp__switch-input"
                            type="radio"
                            id="PAYPAL_ADVANCED_OPTIONS_INSTALLMENT_off"
                            name="PAYPAL_ADVANCED_OPTIONS_INSTALLMENT"
                            value="0"
                            <?php if (isset($_smarty_tpl->tpl_vars['PAYPAL_ADVANCED_OPTIONS_INSTALLMENT']->value)&&$_smarty_tpl->tpl_vars['PAYPAL_ADVANCED_OPTIONS_INSTALLMENT']->value=='0') {?>checked<?php }?>/>
                    <label for="PAYPAL_ADVANCED_OPTIONS_INSTALLMENT_off" class="pp__switch-label off">No</label>
                </div>
            </div>
        </div>

        <div class="paypal-form-group pp__flex-align-center pp_mb-20">
            <div class="label">
                <?php echo smartyTranslate(array('s'=>'The styles for the home page and category pages','mod'=>'paypal'),$_smarty_tpl);?>

            </div>

            <div class="configuration">
                <div class="installment-preview-wrap">
                    <div class="bootstrap preview-setting">
                        <select name="PAYPAL_INSTALLMENT_COLOR">
                            <?php if (isset($_smarty_tpl->tpl_vars['installmentColorOptions']->value)&&false===empty($_smarty_tpl->tpl_vars['installmentColorOptions']->value)) {?>
                                <?php  $_smarty_tpl->tpl_vars['title'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['title']->_loop = false;
 $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['installmentColorOptions']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['title']->key => $_smarty_tpl->tpl_vars['title']->value) {
$_smarty_tpl->tpl_vars['title']->_loop = true;
 $_smarty_tpl->tpl_vars['value']->value = $_smarty_tpl->tpl_vars['title']->key;
?>
                                    <option
                                            value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"
                                            <?php if (isset($_smarty_tpl->tpl_vars['PAYPAL_INSTALLMENT_COLOR']->value)&&$_smarty_tpl->tpl_vars['PAYPAL_INSTALLMENT_COLOR']->value==$_smarty_tpl->tpl_vars['value']->value) {?>selected<?php }?>>

                                        <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['title']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

                                    </option>
                                <?php } ?>
                            <?php }?>
                        </select>
                    </div>

                    <div class="preview-container">
                        <?php if (isset($_smarty_tpl->tpl_vars['paypalInstallmentBanner']->value)) {?>
                            <?php echo $_smarty_tpl->tpl_vars['paypalInstallmentBanner']->value;?>
 
                        <?php }?>
                    </div>
                </div>


            </div>
        </div>

        <div class="pp-panel-footer bootstrap">
            <button
                    type="submit"
                    class="btn btn-default pull-right"
                    name="installmentSettingForm">
                <i class="process-icon-save"></i>
                <?php echo smartyTranslate(array('s'=>'Save','mod'=>'paypal'),$_smarty_tpl);?>

            </button>

        </div>
    </form>

</div>

<script>
    window.toggleHint = function (e) {
        try {
            var btn = e.target;
            var hint = document.querySelector('[clientId-hint]');

            if (hint.classList.contains('hidden')) {
                hint.classList.remove('hidden');
            } else {
                hint.classList.add('hidden');
            }

            btn.textContent = btn.textContent == '?' ? 'X' : '?';
        } catch (exception) {
            console.error(exception);
        }
    }
</script>
<?php }} ?>
