<?php /* Smarty version Smarty-3.1.19, created on 2022-07-28 17:55:33
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal//views/templates/admin/back_office.tpl" */ ?>
<?php /*%%SmartyHeaderCode:184135536862e2b175ce8c75-53915525%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6617b513a5a2db4d8c10318a8bde43822b3c48e0' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/paypal//views/templates/admin/back_office.tpl',
      1 => 1641581521,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '184135536862e2b175ce8c75-53915525',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'showInstallmentSetting' => 0,
    'isoCountryDefault' => 0,
    'showPsCheckoutInfo' => 0,
    'PayPal_payment_method' => 0,
    'PayPal_ECS' => 0,
    'PayPal_HSS' => 0,
    'PayPal_WPS_is_configured' => 0,
    'PayPal_login' => 0,
    'hss_errors' => 0,
    'hss' => 0,
    'moduleDir' => 0,
    'PayPal_allowed_methods' => 0,
    'PayPal_country' => 0,
    'PayPal_business' => 0,
    'PayPal_WPS' => 0,
    'PayPal_PPP' => 0,
    'PayPal_api_username' => 0,
    'PayPal_api_password' => 0,
    'PayPal_api_signature' => 0,
    'PayPal_plus_client' => 0,
    'PayPal_plus_secret' => 0,
    'PayPal_plus_webprofile' => 0,
    'PayPal_express_checkout_shortcut' => 0,
    'PayPal_in_context_checkout_merchant_id' => 0,
    'PayPal_in_context_checkout' => 0,
    'PayPal_sandbox_mode' => 0,
    'PayPal_payment_capture' => 0,
    'PayPal_PVZ' => 0,
    'PayPal_module_dir' => 0,
    'ps_ssl_active' => 0,
    'PayPal_braintree_enabled' => 0,
    'Braintree_Style' => 0,
    'Braintree_Message' => 0,
    'PayPal_save_success' => 0,
    'showInstallmentPopup' => 0,
    'tls_link_ajax' => 0,
    'activeNavTab' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62e2b175da9ba4_86225705',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62e2b175da9ba4_86225705')) {function content_62e2b175da9ba4_86225705($_smarty_tpl) {?>

<div class="bootstrap">
	<ul paypal-nav-bar class="nav nav-pills">
		<li class="active" tab-content="general"><a href="#"><?php echo smartyTranslate(array('s'=>'General','mod'=>'paypal'),$_smarty_tpl);?>
</a></li>
		<?php if (isset($_smarty_tpl->tpl_vars['showInstallmentSetting']->value)&&$_smarty_tpl->tpl_vars['showInstallmentSetting']->value) {?>
			<li tab-content="payment4x">
				<a href="#">
					<?php if (isset($_smarty_tpl->tpl_vars['isoCountryDefault']->value)&&$_smarty_tpl->tpl_vars['isoCountryDefault']->value=='gb') {?>
						<?php echo smartyTranslate(array('s'=>'Payment in 3x','mod'=>'paypal'),$_smarty_tpl);?>

					<?php } else { ?>
						<?php echo smartyTranslate(array('s'=>'Payment in 4x','mod'=>'paypal'),$_smarty_tpl);?>

					<?php }?>

				</a>
			</li>
		<?php }?>
	</ul>
</div>

<div class="bootstrap">

	<?php if ($_smarty_tpl->tpl_vars['showPsCheckoutInfo']->value) {?>
		<div class="alert alert-info ps-checkout-info">
			<button type="button" class="close" data-dismiss="alert" data-action="close">×</button>
			<?php ob_start();?><?php echo smartyTranslate(array('s'=>'This module allows your customers to pay with their PayPal account. If you wish to accept credit cards and other payment methods in addition to PayPal, we recommend the [a @href1@]PrestaShop Checkout[/a] module.','mod'=>'paypal'),$_smarty_tpl);?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo '#';?>
<?php $_tmp2=ob_get_clean();?><?php ob_start();?><?php echo 'data-action="install"';?>
<?php $_tmp3=ob_get_clean();?><?php echo smarty_modifier_paypalreplace($_tmp1,array('@href1@'=>$_tmp2,'@target@'=>$_tmp3));?>

		</div>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['PayPal_payment_method']->value==$_smarty_tpl->tpl_vars['PayPal_ECS']->value) {?>
		<div class="alert alert-info">
			<p>
				<?php echo smartyTranslate(array('s'=>'The PayPal Integral payment experience offers today the same conversion, security and simplicity benefits as Option +. So we have merge these options within the module.','mod'=>'paypal'),$_smarty_tpl);?>

			</p>
		</div>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['PayPal_payment_method']->value==$_smarty_tpl->tpl_vars['PayPal_HSS']->value) {?>
		<div class="alert alert-info">
			<p>
				<?php echo smartyTranslate(array('s'=>'HSS is not supported by PayPal anymore (but for the moment the payments by PayPal work correctly)','mod'=>'paypal'),$_smarty_tpl);?>

			</p>

			<ul>
				<li>
					<?php echo smartyTranslate(array('s'=>'What to do? (Recommended) Install PrestaShop Checkout. Or you can still use PayPal standard even if it’s deprecated.','mod'=>'paypal'),$_smarty_tpl);?>

				</li>

				<li>
					<?php echo smartyTranslate(array('s'=>'How to cancel HSS subscription?','mod'=>'paypal'),$_smarty_tpl);?>

					<a href="https://www.paypal.com/us/smarthelp/article/how-do-i-cancel-a-billing-agreement,-automatic-recurring-payment-or-subscription-faq2254"
						target="_blank">
						https://www.paypal.com/us/smarthelp/article/how-do-i-cancel-a-billing-agreement,-automatic-recurring-payment-or-subscription-faq2254
					</a>
				</li>
			</ul>
		</div>

		<?php if ($_smarty_tpl->tpl_vars['PayPal_WPS_is_configured']->value) {?>
			<div class = "alert alert-info">
				<p>
					<?php echo smartyTranslate(array('s'=>'You have already configured the PayPal Standard payment solution. In order to enable it please verify if all the settings are correct and save them again.','mod'=>'paypal'),$_smarty_tpl);?>

				</p>
			</div>
		<?php }?>

		<div class="alert alert-info">
			<?php echo smartyTranslate(array('s'=>'The PayPal Integral payment experience offers today the same conversion, security and simplicity benefits as Option +. So we have merge these options within the module.','mod'=>'paypal'),$_smarty_tpl);?>

		</div>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['PayPal_login']->value==1) {?>
		<div class="alert alert-warning">
			<?php echo smartyTranslate(array('s'=>'PayPal Login feature has sunset in this release. If you had it enabled, it has been automatically disabled.','mod'=>'paypal'),$_smarty_tpl);?>

		</div>
	<?php }?>

</div>


<div id="paypal-wrapper">
	<div id="general" paypal-tab-content>
		<?php if (!empty($_smarty_tpl->tpl_vars['hss_errors']->value)) {?>
			<div style="background-color: red; color: white; font-weight: bolder; padding: 5px; margin-top: 10px;">
				<?php echo smartyTranslate(array('s'=>'Orders for following carts (id) could not be created because of email error','mod'=>'paypal'),$_smarty_tpl);?>

				<?php  $_smarty_tpl->tpl_vars['hss'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['hss']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['hss_errors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['hss']->key => $_smarty_tpl->tpl_vars['hss']->value) {
$_smarty_tpl->tpl_vars['hss']->_loop = true;
?>
					<p><span style="background-color: black; padding: 5px;"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['hss']->value['id_cart'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 - <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['hss']->value['email'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span></p>
				<?php } ?>
				<?php echo smartyTranslate(array('s'=>'You must change the e-mail in the module configuration with the one displayed above','mod'=>'paypal'),$_smarty_tpl);?>

			</div>
		<?php }?>
		
		<div class="box half left">
			<img src="<?php echo addslashes($_smarty_tpl->tpl_vars['moduleDir']->value);?>
/views/img/logos/PP_Horizontal_rgb_2016.png" alt="" style="margin-bottom: -5px; max-height: 50px;" />
			<p id="paypal-slogan"><span class="dark"><?php echo smartyTranslate(array('s'=>'Leader in','mod'=>'paypal'),$_smarty_tpl);?>
</span> <span class="light"><?php echo smartyTranslate(array('s'=>'online payments','mod'=>'paypal'),$_smarty_tpl);?>
</span></p>
			<p><?php echo smartyTranslate(array('s'=>'Easy, secure, fast payments for your buyers.','mod'=>'paypal'),$_smarty_tpl);?>
</p>
		</div>

		<div class="box half right">
			<ul class="tick">
				<li><span class="paypal-bold"><?php echo smartyTranslate(array('s'=>'Get more buyers','mod'=>'paypal'),$_smarty_tpl);?>
</span><br /><?php echo smartyTranslate(array('s'=>'300 million-plus PayPal accounts worldwide','mod'=>'paypal'),$_smarty_tpl);?>
</li>
				<li><span class="paypal-bold"><?php echo smartyTranslate(array('s'=>'Access international buyers','mod'=>'paypal'),$_smarty_tpl);?>
</span><br /><?php echo smartyTranslate(array('s'=>'190 countries, 25 currencies','mod'=>'paypal'),$_smarty_tpl);?>
</li>
				<li><span class="paypal-bold"><?php echo smartyTranslate(array('s'=>'Reassure your buyers','mod'=>'paypal'),$_smarty_tpl);?>
</span><br /><?php echo smartyTranslate(array('s'=>'Buyers don\'t need to share their private data','mod'=>'paypal'),$_smarty_tpl);?>
</li>
				<li><span class="paypal-bold"><?php echo smartyTranslate(array('s'=>'Accept all major payment method','mod'=>'paypal'),$_smarty_tpl);?>
</span></li>
			</ul>
		</div>

		<div class="paypal-clear"></div>


		<?php if ($_smarty_tpl->tpl_vars['PayPal_allowed_methods']->value) {?>
		<div class="paypal-clear"></div><hr>

		<form method="post" action="<?php echo mb_convert_encoding(htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" id="paypal_configuration">
			
			<div class="box">
				<h3 class="inline"><?php echo smartyTranslate(array('s'=>'Getting started with PayPal only takes 5 minutes','mod'=>'paypal'),$_smarty_tpl);?>
</h3>
				<div style="line-height: 20px; margin-top: 8px">
					<div>
						<label><?php echo smartyTranslate(array('s'=>'Your country','mod'=>'paypal'),$_smarty_tpl);?>
 :
							<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_country']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

						</label>
					</div>

					<label><?php echo smartyTranslate(array('s'=>'You already have a PayPal business account','mod'=>'paypal'),$_smarty_tpl);?>
 ?</label>
					<input type="radio" name="business" id="paypal_business_account_no" value="0" <?php if ($_smarty_tpl->tpl_vars['PayPal_business']->value==0) {?>checked="checked"<?php }?> /> <label for="paypal_business_account_no"><?php echo smartyTranslate(array('s'=>'No','mod'=>'paypal'),$_smarty_tpl);?>
</label>
					<input type="radio" name="business" id="paypal_business_account_yes" value="1" style="margin-left: 14px" <?php if ($_smarty_tpl->tpl_vars['PayPal_business']->value==1) {?>checked="checked"<?php }?> /> <label for="paypal_business_account_yes"><?php echo smartyTranslate(array('s'=>'Yes','mod'=>'paypal'),$_smarty_tpl);?>
</label>
				</div>
			</div>

			<div class="paypal-clear"></div><hr />

			

			
			<div data-open-account-section class="box" id="account">

				<h3 class="inline"><?php echo smartyTranslate(array('s'=>'Apply or open your PayPal Business account','mod'=>'paypal'),$_smarty_tpl);?>
</h3>

				<br /><br />

				<div id="signup">
					
					<a href="<?php echo smartyTranslate(array('s'=>'https://www.paypal.com/bizsignup','mod'=>'paypal'),$_smarty_tpl);?>
" target="_blank" class="paypal-button paypal-signup-button" id="paypal-signup-button-u1"><?php echo smartyTranslate(array('s'=>'Sign Up','mod'=>'paypal'),$_smarty_tpl);?>
</a>

					<a href="<?php echo smartyTranslate(array('s'=>'https://www.paypal.com/bizsignup','mod'=>'paypal'),$_smarty_tpl);?>
" target="_blank" class="paypal-button paypal-signup-button" id="paypal-signup-button-u3"><?php echo smartyTranslate(array('s'=>'Sign Up','mod'=>'paypal'),$_smarty_tpl);?>
</a>

					
					<a href="<?php echo smartyTranslate(array('s'=>'https://www.paypal.com/bizsignup','mod'=>'paypal'),$_smarty_tpl);?>
#" target="_blank" class="paypal-button paypal-signup-button" id="paypal-signup-button-u5"><?php echo smartyTranslate(array('s'=>'Subscribe','mod'=>'paypal'),$_smarty_tpl);?>
</a>

					<br /><br />

					
					<span class="paypal-signup-content" id="paypal-signup-content-u1"><?php echo smartyTranslate(array('s'=>'Once your account is created, come back to this page in order to complete the setup of the module.','mod'=>'paypal'),$_smarty_tpl);?>
</span>

					<span class="paypal-signup-content" id="paypal-signup-content-u3"><?php echo smartyTranslate(array('s'=>'Once your account is created, come back to this page in order to complete the setup of the module.','mod'=>'paypal'),$_smarty_tpl);?>
</span>

					
					<span class="paypal-signup-content" id="paypal-signup-content-u5"><?php echo smartyTranslate(array('s'=>'Click on the SAVE button only when PayPal has approved your subscription for this product, otherwise you won\'t be able to process payment. This process can take up to 3-5 days.','mod'=>'paypal'),$_smarty_tpl);?>
<br/>
                    <?php echo smartyTranslate(array('s'=>'If your application for Website Payments Pro has already been approved by PayPal, please go directly to step 3','mod'=>'paypal'),$_smarty_tpl);?>
.</span>

				</div>

				<hr />

			</div>

			
			<div data-configuration-section class="box paypal-disabled" id="credentials">

				<div class="right half" id="paypal-call-button">
					<div id="paypal-call" class="box right"><span style="font-weight: bold"><?php echo smartyTranslate(array('s'=>'Need help ?','mod'=>'paypal'),$_smarty_tpl);?>
</span> <a target="_blank" href="https://www.paypal.com/webapps/mpp/contact-us"><?php echo smartyTranslate(array('s'=>'Contact us','mod'=>'paypal'),$_smarty_tpl);?>
</a></div>
				</div>

				<h3 class="inline"><?php echo smartyTranslate(array('s'=>'CONFIGURE YOUR PAYMENT SOLUTION','mod'=>'paypal'),$_smarty_tpl);?>
</h3>
				<br /><br />

				

				<?php if ((in_array($_smarty_tpl->tpl_vars['PayPal_WPS']->value,$_smarty_tpl->tpl_vars['PayPal_allowed_methods']->value))) {?>

					<div class="paypal-clear"></div>
					<div class="form-block">
						<?php if ((in_array($_smarty_tpl->tpl_vars['PayPal_WPS']->value,$_smarty_tpl->tpl_vars['PayPal_allowed_methods']->value))) {?>
							
							<label for="paypal_payment_wps" class="flex-display">
								<div>
									<input
											type="radio"
											name="paypal_payment_method"
											id="paypal_payment_wps"
											value='<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_WPS']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
'
											<?php if ((in_array($_smarty_tpl->tpl_vars['PayPal_PPP']->value,$_smarty_tpl->tpl_vars['PayPal_allowed_methods']->value)==false)) {?>style="display: none"<?php }?>
											<?php if (in_array($_smarty_tpl->tpl_vars['PayPal_payment_method']->value,array($_smarty_tpl->tpl_vars['PayPal_WPS']->value,$_smarty_tpl->tpl_vars['PayPal_HSS']->value,$_smarty_tpl->tpl_vars['PayPal_ECS']->value))) {?>checked="checked"<?php }?> />
								</div>
								<div>
									<div class="bold size-l">
										<?php echo smartyTranslate(array('s'=>'Website Payments Standard','mod'=>'paypal'),$_smarty_tpl);?>

									</div>
									<div class="description">
										<div><?php echo smartyTranslate(array('s'=>'Start accepting payments immediately.','mod'=>'paypal'),$_smarty_tpl);?>
</div>
										<div><?php echo smartyTranslate(array('s'=>'No subscription fees, pay only when you get paid.','mod'=>'paypal'),$_smarty_tpl);?>
</div>
									</div>


								</div>
							</label>
						<?php }?>
						<div class="paypal-clear"></div>


						<div class="paypal-clear"></div>
						<?php if ((in_array($_smarty_tpl->tpl_vars['PayPal_PPP']->value,$_smarty_tpl->tpl_vars['PayPal_allowed_methods']->value))) {?>
							
							<br />
							<label for="paypal_payment_ppp">
								<input type="radio" name="paypal_payment_method" id="paypal_payment_ppp" value='<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_PPP']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
' <?php if ($_smarty_tpl->tpl_vars['PayPal_payment_method']->value==$_smarty_tpl->tpl_vars['PayPal_PPP']->value) {?>checked="checked"<?php }?> />
								<span class="bold size-l"><?php echo smartyTranslate(array('s'=>'Choose','mod'=>'paypal'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'PayPal Plus','mod'=>'paypal'),$_smarty_tpl);?>
</span><br />
								<span class="description"></span>
							</label>
						<?php }?>
					</div>
				<?php }?>
				<div class="paypal-clear"></div>

				

				<div class="paypal-hide" id="configuration">
					

					<div id="standard-credentials">
						<h4><?php echo smartyTranslate(array('s'=>'Communicate your PayPal identification info to PrestaShop','mod'=>'paypal'),$_smarty_tpl);?>
</h4>

						<br />

						<a href="#" class="paypal-button" id="paypal-get-identification">
							<?php echo smartyTranslate(array('s'=>'Get my PayPal identification info','mod'=>'paypal'),$_smarty_tpl);?>
<p class="toolbox"><?php echo smartyTranslate(array('s'=>'After clicking on the “Get my PayPal identification info” button, enter your login and password in the pop up, copy your PayPal identification info from the pop up and paste them is the below fields.','mod'=>'paypal'),$_smarty_tpl);?>
</p>
						</a>

						<br /><br />

						<dl>
							<dt><label for="api_username"><?php echo smartyTranslate(array('s'=>'API username','mod'=>'paypal'),$_smarty_tpl);?>
 : </label></dt>
							<dd><input type='text' name="api_username" id="api_username" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_api_username']->value, ENT_QUOTES, 'UTF-8', true);?>
" autocomplete="off" size="85"/></dd>
							<dt><label for="api_password"><?php echo smartyTranslate(array('s'=>'API password','mod'=>'paypal'),$_smarty_tpl);?>
 : </label></dt>
							<dd><input type='password' size="85" name="api_password" id="api_password" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_api_password']->value, ENT_QUOTES, 'UTF-8', true);?>
" autocomplete="off" /></dd>
							<dt><label for="api_signature"><?php echo smartyTranslate(array('s'=>'API signature','mod'=>'paypal'),$_smarty_tpl);?>
 : </label></dt>
							<dd><input type='text' size="85" name="api_signature" id="api_signature" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_api_signature']->value, ENT_QUOTES, 'UTF-8', true);?>
" autocomplete="off" /></dd>
						</dl>
						<div class="paypal-clear"></div>
						<span class="description"><?php echo smartyTranslate(array('s'=>'Please check once more that you pasted all the characters.','mod'=>'paypal'),$_smarty_tpl);?>
</span>
					</div>

					<div id="paypalplus-credentials">
						<h4><?php echo smartyTranslate(array('s'=>'Provide your PayPal API credentials to PrestaShop','mod'=>'paypal'),$_smarty_tpl);?>
</h4>

						<br />

						<dl>
							<dt><label for="client_id"><?php echo smartyTranslate(array('s'=>'Client ID','mod'=>'paypal'),$_smarty_tpl);?>
 : </label></dt>
							<dd><input type='text' name="client_id" id="client_id" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_plus_client']->value, ENT_QUOTES, 'UTF-8', true);?>
" autocomplete="off" size="85"/></dd>
							<dt><label for="secret"><?php echo smartyTranslate(array('s'=>'Secret','mod'=>'paypal'),$_smarty_tpl);?>
 : </label></dt>
							<dd><input type='password' size="85" name="secret" id="secret" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_plus_secret']->value, ENT_QUOTES, 'UTF-8', true);?>
" autocomplete="off" /></dd>

							<dt><label for="webprofile"><?php echo smartyTranslate(array('s'=>'Use personnalisation (uses your logo and your shop name on Paypal) :','mod'=>'paypal'),$_smarty_tpl);?>
</label></dt>
							<dd>
								<input type="radio" name="paypalplus_webprofile" value="1" id="paypal_plus_webprofile_yes" <?php if ($_smarty_tpl->tpl_vars['PayPal_plus_webprofile']->value) {?>checked="checked"<?php }?> /> <label for="paypal_plus_webprofile_yes"><?php echo smartyTranslate(array('s'=>'Yes','mod'=>'paypal'),$_smarty_tpl);?>
</label><br />
								<input type="radio" name="paypalplus_webprofile"  value="0" id="paypal_plus_webprofile_no" <?php if ($_smarty_tpl->tpl_vars['PayPal_plus_webprofile']->value=='0') {?>checked="checked"<?php }?> /> <label for="paypal_plus_webprofile_no"><?php echo smartyTranslate(array('s'=>'No','mod'=>'paypal'),$_smarty_tpl);?>
</label>
							</dd>
						</dl>
						<div class="paypal-clear"></div>
					</div>


					<div class="paypal-clear"></div>

					<h4><?php echo smartyTranslate(array('s'=>'To finalize setting up your PayPal account, you need to','mod'=>'paypal'),$_smarty_tpl);?>
 : </h4>
					<p><span class="paypal-bold">1.</span> <?php echo smartyTranslate(array('s'=>'Confirm your email address : check the email sent by PayPal when you created your account','mod'=>'paypal'),$_smarty_tpl);?>
</p>
					<p><span class="paypal-bold">2.</span> <?php echo smartyTranslate(array('s'=>'Link your PayPal account to a bank account or a credit card : log into your PayPal account and go to "My business setup"','mod'=>'paypal'),$_smarty_tpl);?>
</p>

					<h4><?php echo smartyTranslate(array('s'=>'Configuration options','mod'=>'paypal'),$_smarty_tpl);?>
</h4>

					<div id="express_checkout_shortcut" class="paypal-hide">
						<p><?php echo smartyTranslate(array('s'=>'Use express checkout shortcut','mod'=>'paypal'),$_smarty_tpl);?>
</p>
						<p class="description"><?php echo smartyTranslate(array('s'=>'Offer your customers a 2-click payment option','mod'=>'paypal'),$_smarty_tpl);?>
</p>
						<input type="radio" name="express_checkout_shortcut" id="paypal_payment_ecs_no_shortcut" value="1" <?php if ($_smarty_tpl->tpl_vars['PayPal_express_checkout_shortcut']->value==1) {?>checked="checked"<?php }?> /> <label for="paypal_payment_ecs_no_shortcut"><?php echo smartyTranslate(array('s'=>'Yes','mod'=>'paypal'),$_smarty_tpl);?>
 (recommanded)</label><br />
						<input type="radio" name="express_checkout_shortcut" id="paypal_payment_ecs_shortcut" value="0" <?php if ($_smarty_tpl->tpl_vars['PayPal_express_checkout_shortcut']->value==0) {?>checked="checked"<?php }?> /> <label for="paypal_payment_ecs_shortcut"><?php echo smartyTranslate(array('s'=>'No','mod'=>'paypal'),$_smarty_tpl);?>
</label>
						<p class="merchant_id">
							<label><?php echo smartyTranslate(array('s'=>'Merchant ID','mod'=>'paypal'),$_smarty_tpl);?>
</label>
							<input type="text" name="in_context_checkout_merchant_id" id="in_context_checkout_merchant_id" value="<?php if (isset($_smarty_tpl->tpl_vars['PayPal_in_context_checkout_merchant_id']->value)&&$_smarty_tpl->tpl_vars['PayPal_in_context_checkout_merchant_id']->value!='') {?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_in_context_checkout_merchant_id']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>" />
						<p class="description"><?php echo smartyTranslate(array('s'=>'You can find your merchant account ID under "Account options" > "Business information" > "PayPal merchant ID" in your PayPal account Settings','mod'=>'paypal'),$_smarty_tpl);?>
</p>
						</p>
					</div>

					<div id="in_context_checkout" class="paypal-hide">
						<p><?php echo smartyTranslate(array('s'=>'Use PayPal In Context Checkout','mod'=>'paypal'),$_smarty_tpl);?>
</p>
						<p class="description"><?php echo smartyTranslate(array('s'=>'Make your client pay without leaving your website','mod'=>'paypal'),$_smarty_tpl);?>
</p>
						<input type="radio" name="in_context_checkout" id="paypal_payment_ecs_no_in_context_checkout" value="1" <?php if ($_smarty_tpl->tpl_vars['PayPal_in_context_checkout']->value==1) {?>checked="checked"<?php }?> /> <label for="paypal_payment_ecs_no_in_context_checkout"><?php echo smartyTranslate(array('s'=>'Yes','mod'=>'paypal'),$_smarty_tpl);?>
</label><br />
						<input type="radio" name="in_context_checkout" id="paypal_payment_ecs_in_context_checkout" value="0" <?php if ($_smarty_tpl->tpl_vars['PayPal_in_context_checkout']->value==0) {?>checked="checked"<?php }?> /> <label for="paypal_payment_ecs_in_context_checkout"><?php echo smartyTranslate(array('s'=>'No','mod'=>'paypal'),$_smarty_tpl);?>
</label>
					</div>


					<p><?php echo smartyTranslate(array('s'=>'Use Sand box','mod'=>'paypal'),$_smarty_tpl);?>
</p>
					<p class="description"><?php echo smartyTranslate(array('s'=>'Activate a test environment in your PayPal account (only if you are a developer).','mod'=>'paypal'),$_smarty_tpl);?>
 <a href="<?php echo smartyTranslate(array('s'=>'https://developer.paypal.com/','mod'=>'paypal'),$_smarty_tpl);?>
" target="_blank"><?php echo smartyTranslate(array('s'=>'Learn more','mod'=>'paypal'),$_smarty_tpl);?>
</a></p>
					<input type="radio" name="sandbox_mode" id="paypal_payment_live_mode" value="0" <?php if ($_smarty_tpl->tpl_vars['PayPal_sandbox_mode']->value==0) {?>checked="checked"<?php }?> /> <label for="paypal_payment_live_mode"><?php echo smartyTranslate(array('s'=>'Live mode','mod'=>'paypal'),$_smarty_tpl);?>
</label><br />
					<input type="radio" name="sandbox_mode" id="paypal_payment_test_mode" value="1" <?php if ($_smarty_tpl->tpl_vars['PayPal_sandbox_mode']->value==1) {?>checked="checked"<?php }?> /> <label for="paypal_payment_test_mode"><?php echo smartyTranslate(array('s'=>'Test mode','mod'=>'paypal'),$_smarty_tpl);?>
</label>

					<br />

					<p><?php echo smartyTranslate(array('s'=>'Payment type','mod'=>'paypal'),$_smarty_tpl);?>
</p>
					<p class="description"><?php echo smartyTranslate(array('s'=>'Choose your way of processing payments (automatically vs.manual authorization).','mod'=>'paypal'),$_smarty_tpl);?>
</p>
					<input type="radio" name="payment_capture" id="paypal_direct_sale" value="0" <?php if ($_smarty_tpl->tpl_vars['PayPal_payment_capture']->value==0) {?>checked="checked"<?php }?> /> <label for="paypal_direct_sale"><?php echo smartyTranslate(array('s'=>'Direct sales (recommended)','mod'=>'paypal'),$_smarty_tpl);?>
</label><br />
					<input type="radio" name="payment_capture" id="paypal_manual_capture" value="1" <?php if ($_smarty_tpl->tpl_vars['PayPal_payment_capture']->value==1) {?>checked="checked"<?php }?> /> <label for="paypal_manual_capture"><?php echo smartyTranslate(array('s'=>'Authorization/Manual capture (payment shipping)','mod'=>'paypal'),$_smarty_tpl);?>
</label>

					<div class="clear"></div>

				</div>

				<br><br>

				

				<?php if ((in_array($_smarty_tpl->tpl_vars['PayPal_PVZ']->value,$_smarty_tpl->tpl_vars['PayPal_allowed_methods']->value))) {?>
					<?php if (version_compare(@constant('PHP_VERSION'),'5.4.0','<')) {?>
						<strong class="braintree_title_bo"><?php echo smartyTranslate(array('s'=>'Want to use Braintree as card processor ?','mod'=>'paypal'),$_smarty_tpl);?>
</strong> &nbsp;<a href="<?php echo smartyTranslate(array('s'=>'https://www.braintreepayments.com/','mod'=>'paypal'),$_smarty_tpl);?>
" target="_blank" class="braintree_link"><img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_module_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/views/img/logos/BRAINTREE.png" class="braintree_logo"> &nbsp;&nbsp;&nbsp;<div class="bo_paypal_help">?</div></a><br/>
						<p id="error_version_php"><?php echo smartyTranslate(array('s'=>'You can\'t use braintree because your PHP version is too old (PHP 5.4 min)','mod'=>'paypal'),$_smarty_tpl);?>
</p>
					<?php } elseif (!$_smarty_tpl->tpl_vars['ps_ssl_active']->value) {?>
						<strong class="braintree_title_bo"><?php echo smartyTranslate(array('s'=>'Want to use Braintree as card processor ?','mod'=>'paypal'),$_smarty_tpl);?>
</strong> &nbsp;<a href="<?php echo smartyTranslate(array('s'=>'https://www.braintreepayments.com/','mod'=>'paypal'),$_smarty_tpl);?>
" target="_blank" class="braintree_link"><img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_module_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/views/img/logos/BRAINTREE.png" class="braintree_logo"> &nbsp;&nbsp;&nbsp;<div class="bo_paypal_help">?</div></a><br/>
						<p id="error_version_php"><?php echo smartyTranslate(array('s'=>'You can\'t use braintree because you haven\'t enabled https','mod'=>'paypal'),$_smarty_tpl);?>
</p>
					<?php } else { ?>
						
						<br />
						<strong class="braintree_title_bo"><?php echo smartyTranslate(array('s'=>'Want to use Braintree as card processor ?','mod'=>'paypal'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'(Euro only)','mod'=>'paypal'),$_smarty_tpl);?>
</strong> &nbsp;<a href="<?php echo smartyTranslate(array('s'=>'https://www.braintreepayments.com/','mod'=>'paypal'),$_smarty_tpl);?>
" target="_blank" class="braintree_link"><img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_module_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/views/img/logos/BRAINTREE.png" class="braintree_logo"> &nbsp;&nbsp;&nbsp;<div class="bo_paypal_help">?</div></a><br/>

						<label for="braintree_enabled">
							<input type="checkbox" name="braintree_enabled" id="braintree_enabled" value='<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_PVZ']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
' <?php if ($_smarty_tpl->tpl_vars['PayPal_braintree_enabled']->value) {?>checked="checked"<?php }?> />
							<?php echo smartyTranslate(array('s'=>'Choose','mod'=>'paypal'),$_smarty_tpl);?>
 <?php echo smartyTranslate(array('s'=>'Braintree','mod'=>'paypal'),$_smarty_tpl);?>
<br />
							<span class="description"></span>
							<!-- <p class="toolbox"></p> -->
						</label>
						<span id="braintree_message" style="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['Braintree_Style']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['Braintree_Message']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
						<div id="paypal_braintree">
							<div>
								<?php echo $_smarty_tpl->getSubTemplate ('./sectionBraintreeCredentials.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

							</div>

							<div class="bootstrap">
								<div class="alert alert-info">
									<p>
										<?php echo smartyTranslate(array('s'=>'Note : As part of European Regulation PSD2 and related SCA (Strong Customer Authentication) planned on September 14th 2019, all transactions will have to go through SCA (3DS 2.0) with the aim to reduce friction (fewer “client challenges”) while raise conversion and protection (more liability shifts from merchant to bank).','mod'=>'paypal'),$_smarty_tpl);?>

									</p>

									<p>
										<?php echo smartyTranslate(array('s'=>'It is thus recommended to enable 3D Secure in order to avoid bank declines and impact to your business.','mod'=>'paypal'),$_smarty_tpl);?>

									</p>

									<p>
										<?php ob_start();?><?php echo smartyTranslate(array('s'=>'More info in our blog post [b]to get the last updates:[/b]','mod'=>'paypal'),$_smarty_tpl);?>
<?php $_tmp4=ob_get_clean();?><?php echo smarty_modifier_paypalreplace($_tmp4);?>

										<a href="https://www.braintreepayments.com/ie/features/3d-secure">
											https://www.braintreepayments.com/ie/features/3d-secure
										</a>
									</p>
								</div>
							</div>


							<div>
								<?php echo $_smarty_tpl->getSubTemplate ('./button_braintree.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

							</div>
						</div>
					<?php }?>
				<?php }?>

				

				<br /><br />

				<input type="hidden" name="submitPaypal" value="paypal_configuration" />
				<input type="submit" name="submitButton" value="<?php echo smartyTranslate(array('s'=>'Save','mod'=>'paypal'),$_smarty_tpl);?>
" id="paypal_submit" />

				<div class="box paypal-hide" id="paypal-test-mode-confirmation">
					<h3><?php echo smartyTranslate(array('s'=>'Activating the test mode implies that','mod'=>'paypal'),$_smarty_tpl);?>
 :</h3>
					<ul>
						<li><?php echo smartyTranslate(array('s'=>'You won\'t be able to accept payment','mod'=>'paypal'),$_smarty_tpl);?>
</li>
						<li><?php echo smartyTranslate(array('s'=>'You will need to come back to the PayPal module page in order to complete the Step 3 before going live.','mod'=>'paypal'),$_smarty_tpl);?>
</li>
						<li><?php echo smartyTranslate(array('s'=>'You\'ll need to create an account on the PayPal sandbox site','mod'=>'paypal'),$_smarty_tpl);?>
 (<a href="https://developer.paypal.com/" target="_blank"><?php echo smartyTranslate(array('s'=>'learn more','mod'=>'paypal'),$_smarty_tpl);?>
</a>)</li>
						<li><?php echo smartyTranslate(array('s'=>'You\'ll need programming skills','mod'=>'paypal'),$_smarty_tpl);?>
</li>
					</ul>

					<h4><?php echo smartyTranslate(array('s'=>'Are you sure you want to activate the test mode ?','mod'=>'paypal'),$_smarty_tpl);?>
</h4>

					<div id="buttons">
						<button class="sandbox_confirm" value="0"><?php echo smartyTranslate(array('s'=>'No','mod'=>'paypal'),$_smarty_tpl);?>
</button>
						<button class="sandbox_confirm" value="1"><?php echo smartyTranslate(array('s'=>'Yes','mod'=>'paypal'),$_smarty_tpl);?>
</button>
					</div>
				</div>

				<?php if (isset($_smarty_tpl->tpl_vars['PayPal_save_success']->value)) {?>
					<div class="box paypal-hide" id="paypal-save-success">
						<h3><?php echo smartyTranslate(array('s'=>'Congratulation !','mod'=>'paypal'),$_smarty_tpl);?>
</h3>
						<?php if ($_smarty_tpl->tpl_vars['PayPal_sandbox_mode']->value==0) {?>
							<p><?php echo smartyTranslate(array('s'=>'You can now start accepting Payment  with PayPal.','mod'=>'paypal'),$_smarty_tpl);?>
</p>
						<?php } elseif ($_smarty_tpl->tpl_vars['PayPal_sandbox_mode']->value==1) {?>
							<p><?php echo smartyTranslate(array('s'=>'You can now start testing PayPal solutions. Don\'t forget to comeback to this page and activate the live mode in order to start accepting payements.','mod'=>'paypal'),$_smarty_tpl);?>
</p>
						<?php }?>
					</div>
				<?php }?>

				<div class="box paypal-hide" id="js-paypal-save-failure">
					<h3><?php echo smartyTranslate(array('s'=>'Error !','mod'=>'paypal'),$_smarty_tpl);?>
</h3>
					<p><?php echo smartyTranslate(array('s'=>'You need to complete the PayPal identification Information in step 4 otherwise you won\'t be able to accept payment.','mod'=>'paypal'),$_smarty_tpl);?>
</p>
				</div>

				<hr />
			</div>

			
			<div data-tls-check-section>
				<h3 class="inline"><?php echo smartyTranslate(array('s'=>'Test TLS & curl','mod'=>'paypal'),$_smarty_tpl);?>
</h3>
				<br /><br />
				<input type="hidden" id="security_token" value="<?php echo $_GET['token'];?>
" >
				<span style="cursor: pointer;display: inline-block;" id="test_ssl_submit"><b><?php echo smartyTranslate(array('s'=>'Test','mod'=>'paypal'),$_smarty_tpl);?>
</b></span>
				<div style="margin-top: 10px;" id="test_ssl_result"></div>
			</div>

		</form>

		<?php } else { ?>
		<div class="paypal-clear"></div><hr />
		<div class="box">
			<p><?php echo smartyTranslate(array('s'=>'Your country is not available for this module please go on Prestashop addons to see the different possibilities.','mod'=>'paypal'),$_smarty_tpl);?>
</p>
		</div>
		<hr />
	</div>

	<?php }?>
	</div>

	<div id="payment4x" paypal-tab-content style="display: none">

		<?php echo $_smarty_tpl->getSubTemplate ('./installmentSettings.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


	</div>

</div>

<?php if (isset($_smarty_tpl->tpl_vars['showInstallmentPopup']->value)&&$_smarty_tpl->tpl_vars['showInstallmentPopup']->value) {?>
	<?php echo $_smarty_tpl->getSubTemplate ('./installmentPopup.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<script>
	var tlscurltest_url = '<?php echo addslashes($_smarty_tpl->tpl_vars['tls_link_ajax']->value);?>
';
	var activeNavTab = '<?php echo $_smarty_tpl->tpl_vars['activeNavTab']->value;?>
';
</script>
<?php }} ?>
