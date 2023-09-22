<?php /* Smarty version Smarty-3.1.19, created on 2022-06-26 10:21:56
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/address.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6333451962b817245723c9-82139027%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2a20b6e00b60f454f5f67b925b88432283f95730' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/themes/leo_python/address.tpl',
      1 => 1470857534,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6333451962b817245723c9-82139027',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'id_address' => 0,
    'address' => 0,
    'link' => 0,
    'ordered_adr_fields' => 0,
    'field_name' => 0,
    'required_fields' => 0,
    'address_validation' => 0,
    'countries_list' => 0,
    'one_phone_at_least' => 0,
    'atLeastOneExists' => 0,
    'postCodeExist' => 0,
    'stateExist' => 0,
    'dniExist' => 0,
    'homePhoneExist' => 0,
    'mobilePhoneExist' => 0,
    'select_address' => 0,
    'back' => 0,
    'mod' => 0,
    'token' => 0,
    'countries' => 0,
    'vatnumber_ajax_call' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b817246fe559_26374613',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b817246fe559_26374613')) {function content_62b817246fe559_26374613($_smarty_tpl) {?>
<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><?php echo smartyTranslate(array('s'=>'Your addresses'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<div class="box">
	<h1 class="page-subheading"><?php echo smartyTranslate(array('s'=>'Your addresses'),$_smarty_tpl);?>
</h1>
	<p class="info-title">
		<?php if (isset($_smarty_tpl->tpl_vars['id_address']->value)&&(isset($_POST['alias'])||isset($_smarty_tpl->tpl_vars['address']->value->alias))) {?>
			<?php echo smartyTranslate(array('s'=>'Modify address'),$_smarty_tpl);?>

			<?php if (isset($_POST['alias'])) {?>
				"<?php echo $_POST['alias'];?>
"
			<?php } else { ?>
				<?php if (isset($_smarty_tpl->tpl_vars['address']->value->alias)) {?>"<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value->alias, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?>
			<?php }?>
		<?php } else { ?>
			<?php echo smartyTranslate(array('s'=>'To add a new address, please fill out the form below.'),$_smarty_tpl);?>

		<?php }?>
	</p>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	<p class="required"><sup>*</sup><?php echo smartyTranslate(array('s'=>'Required field'),$_smarty_tpl);?>
</p>
	<form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('address',true), ENT_QUOTES, 'UTF-8', true);?>
" method="post" class="std form-horizontal" id="add_address">
		<!--h3 class="page-subheading"><?php if (isset($_smarty_tpl->tpl_vars['id_address']->value)) {?><?php echo smartyTranslate(array('s'=>'Your address'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'New address'),$_smarty_tpl);?>
<?php }?></h3-->
		<?php $_smarty_tpl->tpl_vars["stateExist"] = new Smarty_variable(false, null, 0);?>
		<?php $_smarty_tpl->tpl_vars["postCodeExist"] = new Smarty_variable(false, null, 0);?>
		<?php $_smarty_tpl->tpl_vars["dniExist"] = new Smarty_variable(false, null, 0);?>
		<?php $_smarty_tpl->tpl_vars["homePhoneExist"] = new Smarty_variable(false, null, 0);?>
		<?php $_smarty_tpl->tpl_vars["mobilePhoneExist"] = new Smarty_variable(false, null, 0);?>
		<?php $_smarty_tpl->tpl_vars["atLeastOneExists"] = new Smarty_variable(false, null, 0);?>
		<?php  $_smarty_tpl->tpl_vars['field_name'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field_name']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ordered_adr_fields']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field_name']->key => $_smarty_tpl->tpl_vars['field_name']->value) {
$_smarty_tpl->tpl_vars['field_name']->_loop = true;
?>
			<?php if ($_smarty_tpl->tpl_vars['field_name']->value=='company') {?>
				<div class="form-group">
					<label class="control-label col-sm-4" for="company"><?php echo smartyTranslate(array('s'=>'Company'),$_smarty_tpl);?>
<?php if (isset($_smarty_tpl->tpl_vars['required_fields']->value)&&in_array($_smarty_tpl->tpl_vars['field_name']->value,$_smarty_tpl->tpl_vars['required_fields']->value)) {?> <sup>*</sup><?php }?></label>
					<div class="col-sm-6">
					<input class="form-control validate" data-validate="<?php echo $_smarty_tpl->tpl_vars['address_validation']->value[$_smarty_tpl->tpl_vars['field_name']->value]['validate'];?>
" type="text" id="company" name="company" value="<?php if (isset($_POST['company'])) {?><?php echo $_POST['company'];?>
<?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['address']->value->company)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value->company, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><?php }?>" />
					</div>
				</div>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['field_name']->value=='vat_number') {?>
				<div id="vat_area">
					<div id="vat_number">
						<div class="form-group">
							<label class="control-label col-sm-4" for="vat-number"><?php echo smartyTranslate(array('s'=>'VAT number'),$_smarty_tpl);?>
<?php if (isset($_smarty_tpl->tpl_vars['required_fields']->value)&&in_array($_smarty_tpl->tpl_vars['field_name']->value,$_smarty_tpl->tpl_vars['required_fields']->value)) {?> <sup>*</sup><?php }?></label>
							<div class="col-sm-6">
							<input type="text" class="form-control validate" data-validate="<?php echo $_smarty_tpl->tpl_vars['address_validation']->value[$_smarty_tpl->tpl_vars['field_name']->value]['validate'];?>
" id="vat-number" name="vat_number" value="<?php if (isset($_POST['vat_number'])) {?><?php echo $_POST['vat_number'];?>
<?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['address']->value->vat_number)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value->vat_number, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><?php }?>" />
							</div>
						</div>
					</div>
				</div>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['field_name']->value=='dni') {?>
			<?php $_smarty_tpl->tpl_vars["dniExist"] = new Smarty_variable(true, null, 0);?>
			<div class="required form-group dni">
				<label class="control-label col-sm-4" for="dni"><?php echo smartyTranslate(array('s'=>'Identification number'),$_smarty_tpl);?>
 <sup>*</sup></label>
				<div class="col-sm-6">
				<input class="form-control" data-validate="<?php echo $_smarty_tpl->tpl_vars['address_validation']->value[$_smarty_tpl->tpl_vars['field_name']->value]['validate'];?>
" type="text" name="dni" id="dni" value="<?php if (isset($_POST['dni'])) {?><?php echo $_POST['dni'];?>
<?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['address']->value->dni)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value->dni, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><?php }?>" />
				<span class="form_info"><?php echo smartyTranslate(array('s'=>'DNI / NIF / NIE'),$_smarty_tpl);?>
</span>
				</div>
			</div>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['field_name']->value=='firstname') {?>
				<div class="required form-group">
					<label class="control-label col-sm-4" for="firstname"><?php echo smartyTranslate(array('s'=>'First name'),$_smarty_tpl);?>
 <sup>*</sup></label>
					<div class="col-sm-6">
					<input class="is_required validate form-control" data-validate="<?php echo $_smarty_tpl->tpl_vars['address_validation']->value[$_smarty_tpl->tpl_vars['field_name']->value]['validate'];?>
" type="text" name="firstname" id="firstname" value="<?php if (isset($_POST['firstname'])) {?><?php echo $_POST['firstname'];?>
<?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['address']->value->firstname)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value->firstname, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><?php }?>" />
					</div>
				</div>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['field_name']->value=='lastname') {?>
				<div class="required form-group">
					<label class="control-label col-sm-4" for="lastname"><?php echo smartyTranslate(array('s'=>'Last name'),$_smarty_tpl);?>
 <sup>*</sup></label>
					<div class="col-sm-6">
					<input class="is_required validate form-control" data-validate="<?php echo $_smarty_tpl->tpl_vars['address_validation']->value[$_smarty_tpl->tpl_vars['field_name']->value]['validate'];?>
" type="text" id="lastname" name="lastname" value="<?php if (isset($_POST['lastname'])) {?><?php echo $_POST['lastname'];?>
<?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['address']->value->lastname)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value->lastname, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><?php }?>" />
					</div>
				</div>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['field_name']->value=='address1') {?>
				<div class="required form-group">
					<label class="control-label col-sm-4" for="address1"><?php echo smartyTranslate(array('s'=>'Address'),$_smarty_tpl);?>
 <sup>*</sup></label>
					<div class="col-sm-6">
					<input class="is_required validate form-control" data-validate="<?php echo $_smarty_tpl->tpl_vars['address_validation']->value[$_smarty_tpl->tpl_vars['field_name']->value]['validate'];?>
" type="text" id="address1" name="address1" value="<?php if (isset($_POST['address1'])) {?><?php echo $_POST['address1'];?>
<?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['address']->value->address1)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value->address1, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><?php }?>" />
					</div>
				</div>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['field_name']->value=='address2') {?>
				<div class="required form-group">
					<label class="control-label col-sm-4" for="address2"><?php echo smartyTranslate(array('s'=>'Address (Line 2)'),$_smarty_tpl);?>
<?php if (isset($_smarty_tpl->tpl_vars['required_fields']->value)&&in_array($_smarty_tpl->tpl_vars['field_name']->value,$_smarty_tpl->tpl_vars['required_fields']->value)) {?> <sup>*</sup><?php }?></label>
					<div class="col-sm-6">
					<input class="validate form-control" data-validate="<?php echo $_smarty_tpl->tpl_vars['address_validation']->value[$_smarty_tpl->tpl_vars['field_name']->value]['validate'];?>
" type="text" id="address2" name="address2" value="<?php if (isset($_POST['address2'])) {?><?php echo $_POST['address2'];?>
<?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['address']->value->address2)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value->address2, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><?php }?>" />
					</div>
				</div>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['field_name']->value=='postcode') {?>
				<?php $_smarty_tpl->tpl_vars["postCodeExist"] = new Smarty_variable(true, null, 0);?>
				<div class="required postcode form-group unvisible">
					<label class="control-label col-sm-4" for="postcode"><?php echo smartyTranslate(array('s'=>'Zip/Postal Code'),$_smarty_tpl);?>
 <sup>*</sup></label>
					<div class="col-sm-6">
					<input class="is_required validate form-control" data-validate="<?php echo $_smarty_tpl->tpl_vars['address_validation']->value[$_smarty_tpl->tpl_vars['field_name']->value]['validate'];?>
" type="text" id="postcode" name="postcode" value="<?php if (isset($_POST['postcode'])) {?><?php echo $_POST['postcode'];?>
<?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['address']->value->postcode)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value->postcode, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><?php }?>" />
					</div>
				</div>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['field_name']->value=='city') {?>
				<div class="required form-group">
					<label class="control-label col-sm-4" for="city"><?php echo smartyTranslate(array('s'=>'City'),$_smarty_tpl);?>
 <sup>*</sup></label>
					<div class="col-sm-6">
					<input class="is_required validate form-control" data-validate="<?php echo $_smarty_tpl->tpl_vars['address_validation']->value[$_smarty_tpl->tpl_vars['field_name']->value]['validate'];?>
" type="text" name="city" id="city" value="<?php if (isset($_POST['city'])) {?><?php echo $_POST['city'];?>
<?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['address']->value->city)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value->city, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><?php }?>" maxlength="64" />
					</div>
				</div>
				
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['field_name']->value=='Country:name'||$_smarty_tpl->tpl_vars['field_name']->value=='country'||$_smarty_tpl->tpl_vars['field_name']->value=='Country:iso_code') {?>
				<div class="required form-group">
					<label class="control-label col-sm-4" for="id_country"><?php echo smartyTranslate(array('s'=>'Country'),$_smarty_tpl);?>
 <sup>*</sup></label>
					<div class="col-sm-6">
					<select id="id_country" class="form-control" name="id_country"><?php echo $_smarty_tpl->tpl_vars['countries_list']->value;?>
</select>
					</div>
				</div>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['field_name']->value=='State:name') {?>
				<?php $_smarty_tpl->tpl_vars["stateExist"] = new Smarty_variable(true, null, 0);?>
				<div class="required id_state form-group">
					<label class="control-label col-sm-4" for="id_state"><?php echo smartyTranslate(array('s'=>'State'),$_smarty_tpl);?>
 <sup>*</sup></label>
					<div class="col-sm-6">
					<select name="id_state" id="id_state" class="form-control">
						<option value="">-</option>
					</select>
					</div>
				</div>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['field_name']->value=='phone') {?>
				<?php $_smarty_tpl->tpl_vars["homePhoneExist"] = new Smarty_variable(true, null, 0);?>
				<div class="form-group phone-number">
					<label class="control-label col-sm-4" for="phone"><?php echo smartyTranslate(array('s'=>'Home phone'),$_smarty_tpl);?>
<?php if (isset($_smarty_tpl->tpl_vars['one_phone_at_least']->value)&&$_smarty_tpl->tpl_vars['one_phone_at_least']->value) {?> <sup>**</sup><?php }?></label>
					<div class="col-sm-6">
					<input class="<?php if (isset($_smarty_tpl->tpl_vars['one_phone_at_least']->value)&&$_smarty_tpl->tpl_vars['one_phone_at_least']->value) {?>is_required<?php }?> validate form-control" data-validate="<?php echo $_smarty_tpl->tpl_vars['address_validation']->value['phone']['validate'];?>
" type="tel" id="phone" name="phone" value="<?php if (isset($_POST['phone'])) {?><?php echo $_POST['phone'];?>
<?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['address']->value->phone)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value->phone, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><?php }?>"  />
					</div>
				</div>
				<div class="clearfix"></div>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['field_name']->value=='phone_mobile') {?>
				<?php $_smarty_tpl->tpl_vars["mobilePhoneExist"] = new Smarty_variable(true, null, 0);?>
				<div class="<?php if (isset($_smarty_tpl->tpl_vars['one_phone_at_least']->value)&&$_smarty_tpl->tpl_vars['one_phone_at_least']->value) {?>required <?php }?>form-group">
					<label class="control-label col-sm-4" for="phone_mobile"><?php echo smartyTranslate(array('s'=>'Mobile phone'),$_smarty_tpl);?>
<?php if (isset($_smarty_tpl->tpl_vars['one_phone_at_least']->value)&&$_smarty_tpl->tpl_vars['one_phone_at_least']->value) {?> <sup>**</sup><?php }?></label>
					<div class="col-sm-6">
					<input class="validate form-control" data-validate="<?php echo $_smarty_tpl->tpl_vars['address_validation']->value['phone_mobile']['validate'];?>
" type="tel" id="phone_mobile" name="phone_mobile" value="<?php if (isset($_POST['phone_mobile'])) {?><?php echo $_POST['phone_mobile'];?>
<?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['address']->value->phone_mobile)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value->phone_mobile, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><?php }?>" />
					</div>
				</div>
				<?php }?>
			<?php if (($_smarty_tpl->tpl_vars['field_name']->value=='phone_mobile')||($_smarty_tpl->tpl_vars['field_name']->value=='phone_mobile')&&!isset($_smarty_tpl->tpl_vars['atLeastOneExists']->value)&&isset($_smarty_tpl->tpl_vars['one_phone_at_least']->value)&&$_smarty_tpl->tpl_vars['one_phone_at_least']->value) {?>
				<?php $_smarty_tpl->tpl_vars["atLeastOneExists"] = new Smarty_variable(true, null, 0);?>
				<div class="inline-infos required"><label class="col-sm-offset-4 col-sm-6">** <?php echo smartyTranslate(array('s'=>'You must register at least one phone number.'),$_smarty_tpl);?>
</label></div>
			<?php }?>
		<?php } ?>
		<?php if (!$_smarty_tpl->tpl_vars['postCodeExist']->value) {?>
			<div class="required postcode form-group unvisible">
				<label class="control-label col-sm-4" for="postcode"><?php echo smartyTranslate(array('s'=>'Zip/Postal Code'),$_smarty_tpl);?>
 <sup>*</sup></label>
				<div class="col-sm-6">
				<input class="is_required validate form-control" data-validate="<?php echo $_smarty_tpl->tpl_vars['address_validation']->value['postcode']['validate'];?>
" type="text" id="postcode" name="postcode" value="<?php if (isset($_POST['postcode'])) {?><?php echo $_POST['postcode'];?>
<?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['address']->value->postcode)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value->postcode, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><?php }?>" />
				</div>
			</div>
		<?php }?>
		<?php if (!$_smarty_tpl->tpl_vars['stateExist']->value) {?>
			<div class="required id_state form-group unvisible">
				<label class="control-label col-sm-4" for="id_state"><?php echo smartyTranslate(array('s'=>'State'),$_smarty_tpl);?>
 <sup>*</sup></label>
				<div class="col-sm-6">
				<select name="id_state" id="id_state" class="form-control">
					<option value="">-</option>
				</select>
				</div>
			</div>
		<?php }?>
		<?php if (!$_smarty_tpl->tpl_vars['dniExist']->value) {?>
			<div class="required dni form-group unvisible">
				<label class="control-label col-sm-4" for="dni"><?php echo smartyTranslate(array('s'=>'Identification number'),$_smarty_tpl);?>
 <sup>*</sup></label>
				<div class="col-sm-6">
				<input class="is_required form-control" data-validate="<?php echo $_smarty_tpl->tpl_vars['address_validation']->value['dni']['validate'];?>
" type="text" name="dni" id="dni" value="<?php if (isset($_POST['dni'])) {?><?php echo $_POST['dni'];?>
<?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['address']->value->dni)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value->dni, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><?php }?>" />
				<span class="form_info"><?php echo smartyTranslate(array('s'=>'DNI / NIF / NIE'),$_smarty_tpl);?>
</span>
				</div>
			</div>
		<?php }?>
		<div class="form-group">
			<label class="control-label col-sm-4" for="other"><?php echo smartyTranslate(array('s'=>'Additional information'),$_smarty_tpl);?>
</label>
			<div class="col-sm-6">
			<textarea class="validate form-control" data-validate="<?php echo $_smarty_tpl->tpl_vars['address_validation']->value['other']['validate'];?>
" id="other" name="other" cols="26" rows="3" ><?php if (isset($_POST['other'])) {?><?php echo $_POST['other'];?>
<?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['address']->value->other)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value->other, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><?php }?></textarea>
			</div>
		</div>
		<?php if (!$_smarty_tpl->tpl_vars['homePhoneExist']->value) {?>
			<div class="form-group phone-number">
				<label class="control-label col-sm-4" for="phone"><?php echo smartyTranslate(array('s'=>'Home phone'),$_smarty_tpl);?>
</label>
				<div class="col-sm-6">
				<input class="<?php if (isset($_smarty_tpl->tpl_vars['one_phone_at_least']->value)&&$_smarty_tpl->tpl_vars['one_phone_at_least']->value) {?>is_required<?php }?> validate form-control" data-validate="<?php echo $_smarty_tpl->tpl_vars['address_validation']->value['phone']['validate'];?>
" type="tel" id="phone" name="phone" value="<?php if (isset($_POST['phone'])) {?><?php echo $_POST['phone'];?>
<?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['address']->value->phone)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value->phone, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><?php }?>"  />
				</div>
			</div>
		<?php }?>
		<div class="clearfix"></div>
		<?php if (!$_smarty_tpl->tpl_vars['mobilePhoneExist']->value) {?>
			<div class="<?php if (isset($_smarty_tpl->tpl_vars['one_phone_at_least']->value)&&$_smarty_tpl->tpl_vars['one_phone_at_least']->value) {?>required <?php }?>form-group">
				<label class="control-label col-sm-4" for="phone_mobile"><?php echo smartyTranslate(array('s'=>'Mobile phone'),$_smarty_tpl);?>
<?php if (isset($_smarty_tpl->tpl_vars['one_phone_at_least']->value)&&$_smarty_tpl->tpl_vars['one_phone_at_least']->value) {?> <sup>**</sup><?php }?></label>
				<div class="col-sm-6">
				<input class="validate form-control" data-validate="<?php echo $_smarty_tpl->tpl_vars['address_validation']->value['phone_mobile']['validate'];?>
" type="tel" id="phone_mobile" name="phone_mobile" value="<?php if (isset($_POST['phone_mobile'])) {?><?php echo $_POST['phone_mobile'];?>
<?php } else { ?><?php if (isset($_smarty_tpl->tpl_vars['address']->value->phone_mobile)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value->phone_mobile, ENT_QUOTES, 'UTF-8', true);?>
<?php }?><?php }?>" />
				</div>
			</div>
			<?php }?>
		<?php if (isset($_smarty_tpl->tpl_vars['one_phone_at_least']->value)&&$_smarty_tpl->tpl_vars['one_phone_at_least']->value&&!$_smarty_tpl->tpl_vars['atLeastOneExists']->value) {?>
			<div class="inline-infos required"><label class="col-sm-offset-4 col-sm-6"><?php echo smartyTranslate(array('s'=>'You must register at least one phone number.'),$_smarty_tpl);?>
</label></div>
		<?php }?>
		<div class="required form-group" id="adress_alias">
			<label class="control-label col-sm-4" for="alias"><?php echo smartyTranslate(array('s'=>'Please assign an address title for future reference.'),$_smarty_tpl);?>
 <sup>*</sup></label>
			<div class="col-sm-6">
			<input type="text" id="alias" class="is_required validate form-control" data-validate="<?php echo $_smarty_tpl->tpl_vars['address_validation']->value['alias']['validate'];?>
" name="alias" value="<?php if (isset($_POST['alias'])) {?><?php echo $_POST['alias'];?>
<?php } elseif (isset($_smarty_tpl->tpl_vars['address']->value->alias)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['address']->value->alias, ENT_QUOTES, 'UTF-8', true);?>
<?php } elseif (!$_smarty_tpl->tpl_vars['select_address']->value) {?><?php echo smartyTranslate(array('s'=>'My address'),$_smarty_tpl);?>
<?php }?>" />
			</div>
		</div>
		<p class="submit2 text-right">
			<?php if (isset($_smarty_tpl->tpl_vars['id_address']->value)) {?><input type="hidden" name="id_address" value="<?php echo intval($_smarty_tpl->tpl_vars['id_address']->value);?>
" /><?php }?>
			<?php if (isset($_smarty_tpl->tpl_vars['back']->value)) {?><input type="hidden" name="back" value="<?php echo $_smarty_tpl->tpl_vars['back']->value;?>
" /><?php }?>
			<?php if (isset($_smarty_tpl->tpl_vars['mod']->value)) {?><input type="hidden" name="mod" value="<?php echo $_smarty_tpl->tpl_vars['mod']->value;?>
" /><?php }?>
			<?php if (isset($_smarty_tpl->tpl_vars['select_address']->value)) {?><input type="hidden" name="select_address" value="<?php echo intval($_smarty_tpl->tpl_vars['select_address']->value);?>
" /><?php }?>
			<input type="hidden" name="token" value="<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
" />
			<button type="submit" name="submitAddress" id="submitAddress" class="btn btn-outline button button-medium">
				<span>
					<?php echo smartyTranslate(array('s'=>'Save'),$_smarty_tpl);?>

				</span>
			</button>
		</p>
	</form>
</div>
<ul class="footer_links clearfix">
	<li class="pull-left">
		<a class="btn btn-outline button button-small btn-sm" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('addresses',true), ENT_QUOTES, 'UTF-8', true);?>
">
			<span><i class="fa fa-user"></i> <?php echo smartyTranslate(array('s'=>'Back to your addresses'),$_smarty_tpl);?>
</span>
		</a>
	</li>
</ul>
<?php if (isset($_POST['id_state'])&&$_POST['id_state']) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('idSelectedState'=>intval($_POST['id_state'])),$_smarty_tpl);?>
<?php } elseif (isset($_smarty_tpl->tpl_vars['address']->value->id_state)&&$_smarty_tpl->tpl_vars['address']->value->id_state) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('idSelectedState'=>intval($_smarty_tpl->tpl_vars['address']->value->id_state)),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('idSelectedState'=>false),$_smarty_tpl);?>
<?php }?><?php if (isset($_POST['id_country'])&&$_POST['id_country']) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('idSelectedCountry'=>intval($_POST['id_country'])),$_smarty_tpl);?>
<?php } elseif (isset($_smarty_tpl->tpl_vars['address']->value->id_country)&&$_smarty_tpl->tpl_vars['address']->value->id_country) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('idSelectedCountry'=>intval($_smarty_tpl->tpl_vars['address']->value->id_country)),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('idSelectedCountry'=>false),$_smarty_tpl);?>
<?php }?><?php if (isset($_smarty_tpl->tpl_vars['countries']->value)) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('countries'=>$_smarty_tpl->tpl_vars['countries']->value),$_smarty_tpl);?>
<?php }?><?php if (isset($_smarty_tpl->tpl_vars['vatnumber_ajax_call']->value)&&$_smarty_tpl->tpl_vars['vatnumber_ajax_call']->value) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['addJsDef'][0][0]->addJsDef(array('vatnumber_ajax_call'=>$_smarty_tpl->tpl_vars['vatnumber_ajax_call']->value),$_smarty_tpl);?>
<?php }?>
<?php }} ?>
