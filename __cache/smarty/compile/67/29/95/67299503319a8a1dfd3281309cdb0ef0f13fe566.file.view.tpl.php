<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:44:06
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/Backoffice/themes/default/template/controllers/information/helpers/view/view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:134668179562b57956e553e4-08354989%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '67299503319a8a1dfd3281309cdb0ef0f13fe566' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/Backoffice/themes/default/template/controllers/information/helpers/view/view.tpl',
      1 => 1575969812,
      2 => 'file',
    ),
    'cc286bc2a4f4f04f74ee56b5b9e0fd17e69ecc9e' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/Backoffice/themes/default/template/helpers/view/view.tpl',
      1 => 1575969816,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '134668179562b57956e553e4-08354989',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'name_controller' => 0,
    'hookName' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b57956edbd97_99806418',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b57956edbd97_99806418')) {function content_62b57956edbd97_99806418($_smarty_tpl) {?>

<div class="leadin"></div>


	<?php if (!$_smarty_tpl->tpl_vars['host_mode']->value) {?>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$.ajax({
				type: 'GET',
				url: '<?php echo addslashes($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminInformation'));?>
',
				data: {
					'action': 'checkFiles',
					'ajax': 1
				},
				dataType: 'json',
				success: function(json)
				{
					var tab = {
						'missing': '<?php echo smartyTranslate(array('s'=>'Missing files'),$_smarty_tpl);?>
',
						'updated': '<?php echo smartyTranslate(array('s'=>'Updated files'),$_smarty_tpl);?>
'
					};

					if (json.missing.length || json.updated.length)
						$('#changedFiles').html('<div class="alert alert-warning"><?php echo smartyTranslate(array('s'=>'Changed/missing files have been detected.'),$_smarty_tpl);?>
</div>');
					else
						$('#changedFiles').html('<div class="alert alert-success"><?php echo smartyTranslate(array('s'=>'No change has been detected in your files.'),$_smarty_tpl);?>
</div>');

					$.each(tab, function(key, lang)
					{
						if (json[key].length)
						{
							var html = $('<ul>').attr('id', key+'_files');
							$(json[key]).each(function(key, file)
							{
								html.append($('<li>').html(file))
							});
							$('#changedFiles')
								.append($('<h4>').html(lang+' ('+json[key].length+')'))
								.append(html);
						}
					});
				}
			});
		});
	</script>
	<?php }?>
	<div class="row">
		<div class="col-lg-6">
			<div class="panel">
				<h3>
					<i class="icon-info"></i>
					<?php echo smartyTranslate(array('s'=>'Configuration information'),$_smarty_tpl);?>

				</h3>
				<p><?php echo smartyTranslate(array('s'=>'This information must be provided when you report an issue on our bug tracker or forum.'),$_smarty_tpl);?>
</p>
			</div>
			<?php if (!$_smarty_tpl->tpl_vars['host_mode']->value) {?>
			<div class="panel">
				<h3>
					<i class="icon-info"></i>
					<?php echo smartyTranslate(array('s'=>'Server information'),$_smarty_tpl);?>

				</h3>
				<?php if (count($_smarty_tpl->tpl_vars['uname']->value)) {?>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'Server information:'),$_smarty_tpl);?>
</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['uname']->value, ENT_QUOTES, 'UTF-8', true);?>

				</p>
				<?php }?>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'Server software version:'),$_smarty_tpl);?>
</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['version']->value['server'], ENT_QUOTES, 'UTF-8', true);?>

				</p>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'PHP version:'),$_smarty_tpl);?>
</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['version']->value['php'], ENT_QUOTES, 'UTF-8', true);?>

				</p>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'Memory limit:'),$_smarty_tpl);?>
</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['version']->value['memory_limit'], ENT_QUOTES, 'UTF-8', true);?>

				</p>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'Max execution time:'),$_smarty_tpl);?>
</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['version']->value['max_execution_time'], ENT_QUOTES, 'UTF-8', true);?>

				</p>
				<?php if ($_smarty_tpl->tpl_vars['apache_instaweb']->value) {?>
					<p><?php echo smartyTranslate(array('s'=>'PageSpeed module for Apache installed (mod_instaweb)'),$_smarty_tpl);?>
</p>
				<?php }?>
			</div>
			<div class="panel">
				<h3>
					<i class="icon-info"></i>
					<?php echo smartyTranslate(array('s'=>'Database information'),$_smarty_tpl);?>

				</h3>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'MySQL version:'),$_smarty_tpl);?>
</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['database']->value['version'], ENT_QUOTES, 'UTF-8', true);?>

				</p>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'MySQL server:'),$_smarty_tpl);?>
</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['database']->value['server'], ENT_QUOTES, 'UTF-8', true);?>

				</p>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'MySQL name:'),$_smarty_tpl);?>
</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['database']->value['name'], ENT_QUOTES, 'UTF-8', true);?>

				</p>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'MySQL user:'),$_smarty_tpl);?>
</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['database']->value['user'], ENT_QUOTES, 'UTF-8', true);?>

				</p>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'Tables prefix:'),$_smarty_tpl);?>
</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['database']->value['prefix'], ENT_QUOTES, 'UTF-8', true);?>

				</p>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'MySQL engine:'),$_smarty_tpl);?>
</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['database']->value['engine'], ENT_QUOTES, 'UTF-8', true);?>

				</p>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'MySQL driver:'),$_smarty_tpl);?>
</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['database']->value['driver'], ENT_QUOTES, 'UTF-8', true);?>

				</p>
			</div>
		</div>
		<?php }?>
		<div class="col-lg-6">
			<div class="panel">
				<h3>
					<i class="icon-info"></i>
					<?php echo smartyTranslate(array('s'=>'Store information'),$_smarty_tpl);?>

				</h3>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'PrestaShop version:'),$_smarty_tpl);?>
</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['ps'], ENT_QUOTES, 'UTF-8', true);?>

				</p>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'Shop URL:'),$_smarty_tpl);?>
</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['url'], ENT_QUOTES, 'UTF-8', true);?>

				</p>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'Current theme in use:'),$_smarty_tpl);?>
</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['theme'], ENT_QUOTES, 'UTF-8', true);?>

				</p>
			</div>
			<div class="panel">
				<h3>
					<i class="icon-info"></i>
					<?php echo smartyTranslate(array('s'=>'Mail configuration'),$_smarty_tpl);?>

				</h3>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'Mail method:'),$_smarty_tpl);?>
</strong>

			<?php if ($_smarty_tpl->tpl_vars['mail']->value) {?>
				<?php echo smartyTranslate(array('s'=>'You are using the PHP mail() function.'),$_smarty_tpl);?>
</p>
			<?php } else { ?>
				<?php echo smartyTranslate(array('s'=>'You are using your own SMTP parameters.'),$_smarty_tpl);?>
</p>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'SMTP server'),$_smarty_tpl);?>
:</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['smtp']->value['server'], ENT_QUOTES, 'UTF-8', true);?>

				</p>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'SMTP username'),$_smarty_tpl);?>
:</strong>
					<?php if ($_smarty_tpl->tpl_vars['smtp']->value['user']!='') {?>
						<?php echo smartyTranslate(array('s'=>'Defined'),$_smarty_tpl);?>

					<?php } else { ?>
						<span style="color:red;"><?php echo smartyTranslate(array('s'=>'Not defined'),$_smarty_tpl);?>
</span>
					<?php }?>
				</p>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'SMTP password'),$_smarty_tpl);?>
:</strong>
					<?php if ($_smarty_tpl->tpl_vars['smtp']->value['password']!='') {?>
						<?php echo smartyTranslate(array('s'=>'Defined'),$_smarty_tpl);?>

					<?php } else { ?>
						<span style="color:red;"><?php echo smartyTranslate(array('s'=>'Not defined'),$_smarty_tpl);?>
</span>
					<?php }?>
				</p>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'Encryption:'),$_smarty_tpl);?>
</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['smtp']->value['encryption'], ENT_QUOTES, 'UTF-8', true);?>

				</p>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'SMTP port:'),$_smarty_tpl);?>
</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['smtp']->value['port'], ENT_QUOTES, 'UTF-8', true);?>

				</p>
			<?php }?>
			</div>
			<div class="panel">
				<h3>
					<i class="icon-info"></i>
					<?php echo smartyTranslate(array('s'=>'Your information'),$_smarty_tpl);?>

				</h3>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'Your web browser:'),$_smarty_tpl);?>
</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['user_agent']->value, ENT_QUOTES, 'UTF-8', true);?>

				</p>
			</div>

			<div class="panel" id="checkConfiguration">
				<h3>
					<i class="icon-info"></i>
					<?php echo smartyTranslate(array('s'=>'Check your configuration'),$_smarty_tpl);?>

				</h3>
				<p>
					<strong><?php echo smartyTranslate(array('s'=>'Required parameters:'),$_smarty_tpl);?>
</strong>
				<?php if (!$_smarty_tpl->tpl_vars['failRequired']->value) {?>
					<span class="text-success"><?php echo smartyTranslate(array('s'=>'OK'),$_smarty_tpl);?>
</span>
				</p>
				<?php } else { ?>
					<span class="text-danger"><?php echo smartyTranslate(array('s'=>'Please fix the following error(s)'),$_smarty_tpl);?>
</span>
				</p>
				<ul>
					<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['testsRequired']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
						<?php if ($_smarty_tpl->tpl_vars['value']->value=='fail'&&isset($_smarty_tpl->tpl_vars['testsErrors']->value[$_smarty_tpl->tpl_vars['key']->value])) {?>
							<li><?php echo $_smarty_tpl->tpl_vars['testsErrors']->value[$_smarty_tpl->tpl_vars['key']->value];?>
</li>
						<?php }?>
					<?php } ?>
				</ul>
				<?php }?>
				<?php if (isset($_smarty_tpl->tpl_vars['failOptional']->value)) {?>
					<p>
						<strong><?php echo smartyTranslate(array('s'=>'Optional parameters:'),$_smarty_tpl);?>
</strong>
					<?php if (!$_smarty_tpl->tpl_vars['failOptional']->value) {?>
						<span class="text-success"><?php echo smartyTranslate(array('s'=>'OK'),$_smarty_tpl);?>
</span>
					</p>
					<?php } else { ?>
						<span class="text-danger"><?php echo smartyTranslate(array('s'=>'Please fix the following error(s)'),$_smarty_tpl);?>
</span>
					</p>
					<ul>
						<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['testsOptional']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
							<?php if ($_smarty_tpl->tpl_vars['value']->value=='fail'&&isset($_smarty_tpl->tpl_vars['testsErrors']->value[$_smarty_tpl->tpl_vars['key']->value])) {?>
								<li><?php echo $_smarty_tpl->tpl_vars['testsErrors']->value[$_smarty_tpl->tpl_vars['key']->value];?>
</li>
							<?php }?>
						<?php } ?>
					</ul>
					<?php }?>
				<?php }?>
			</div>
		</div>
	</div>
	<?php if (!$_smarty_tpl->tpl_vars['host_mode']->value) {?>
	<div class="panel">
		<h3>
			<i class="icon-info"></i>
			<?php echo smartyTranslate(array('s'=>'List of changed files'),$_smarty_tpl);?>

		</h3>
		<div id="changedFiles"><i class="icon-spin icon-refresh"></i> <?php echo smartyTranslate(array('s'=>'Checking files...'),$_smarty_tpl);?>
</div>
	</div>
	<?php }?>


<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayAdminView'),$_smarty_tpl);?>

<?php if (isset($_smarty_tpl->tpl_vars['name_controller']->value)) {?>
	<?php $_smarty_tpl->_capture_stack[0][] = array('hookName', 'hookName', null); ob_start(); ?>display<?php echo ucfirst($_smarty_tpl->tpl_vars['name_controller']->value);?>
View<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>$_smarty_tpl->tpl_vars['hookName']->value),$_smarty_tpl);?>

<?php } elseif (isset($_GET['controller'])) {?>
	<?php $_smarty_tpl->_capture_stack[0][] = array('hookName', 'hookName', null); ob_start(); ?>display<?php echo htmlentities(ucfirst($_GET['controller']));?>
View<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>$_smarty_tpl->tpl_vars['hookName']->value),$_smarty_tpl);?>

<?php }?>
<?php }} ?>
