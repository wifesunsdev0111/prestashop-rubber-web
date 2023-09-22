<?php /* Smarty version Smarty-3.1.19, created on 2022-07-29 12:45:23
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/leotempcp/views/templates/admin/_configure/helpers/form/form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:152824410962e3ba439bfed9-03126249%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0a7c5285e17a5a2b4fdb6af1308cbc1cc8c0fd52' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/leotempcp/views/templates/admin/_configure/helpers/form/form.tpl',
      1 => 1470856268,
      2 => 'file',
    ),
    '3397e7aa32e8740a453a09c95fdd1e36932a26d9' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/Backoffice/themes/default/template/helpers/form/form.tpl',
      1 => 1575969815,
      2 => 'file',
    ),
    '12935fb76542278678f24befa6285dac56f99875' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/Backoffice/themes/default/template/helpers/form/form_group.tpl',
      1 => 1575969815,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '152824410962e3ba439bfed9-03126249',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'fields' => 0,
    'tabs' => 0,
    'identifier_bk' => 0,
    'identifier' => 0,
    'table_bk' => 0,
    'table' => 0,
    'name_controller' => 0,
    'current' => 0,
    'token' => 0,
    'style' => 0,
    'form_id' => 0,
    'submit_action' => 0,
    'f' => 0,
    'fieldset' => 0,
    'key' => 0,
    'field' => 0,
    'input' => 0,
    'contains_states' => 0,
    'fields_value' => 0,
    'hint' => 0,
    'languages' => 0,
    'language' => 0,
    'defaultFormLanguage' => 0,
    'value_text' => 0,
    'name' => 0,
    'value' => 0,
    'option' => 0,
    'optiongroup' => 0,
    'field_value' => 0,
    'id_checkbox' => 0,
    'select' => 0,
    'k' => 0,
    'v' => 0,
    'categories_tree' => 0,
    'asso_shop' => 0,
    'p' => 0,
    'hookName' => 0,
    'show_cancel_button' => 0,
    'back_url' => 0,
    'btn' => 0,
    'tinymce' => 0,
    'iso' => 0,
    'ad' => 0,
    'firstCall' => 0,
    'vat_number' => 0,
    'allowEmployeeFormLang' => 0,
    'use_textarea_autosize' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62e3ba43eee758_13134235',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62e3ba43eee758_13134235')) {function content_62e3ba43eee758_13134235($_smarty_tpl) {?><?php if (!is_callable('smarty_function_counter')) include '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/tools/smarty/plugins/function.counter.php';
?>
<?php if (isset($_smarty_tpl->tpl_vars['fields']->value['title'])) {?><h3><?php echo $_smarty_tpl->tpl_vars['fields']->value['title'];?>
</h3><?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['tabs']->value)&&count($_smarty_tpl->tpl_vars['tabs']->value)) {?>
<script type="text/javascript">
	var helper_tabs = <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['json_encode'][0][0]->jsonEncode($_smarty_tpl->tpl_vars['tabs']->value);?>
;
	var unique_field_id = '';
</script>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['identifier_bk']->value)&&$_smarty_tpl->tpl_vars['identifier_bk']->value==$_smarty_tpl->tpl_vars['identifier']->value) {?><?php $_smarty_tpl->_capture_stack[0][] = array('identifier_count', null, null); ob_start(); ?><?php echo smarty_function_counter(array('name'=>'identifier_count'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><?php }?>
<?php $_smarty_tpl->tpl_vars['identifier_bk'] = new Smarty_variable($_smarty_tpl->tpl_vars['identifier']->value, null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['identifier_bk'] = clone $_smarty_tpl->tpl_vars['identifier_bk'];?>
<?php if (isset($_smarty_tpl->tpl_vars['table_bk']->value)&&$_smarty_tpl->tpl_vars['table_bk']->value==$_smarty_tpl->tpl_vars['table']->value) {?><?php $_smarty_tpl->_capture_stack[0][] = array('table_count', null, null); ob_start(); ?><?php echo smarty_function_counter(array('name'=>'table_count'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><?php }?>
<?php $_smarty_tpl->tpl_vars['table_bk'] = new Smarty_variable($_smarty_tpl->tpl_vars['table']->value, null, 1);
if ($_smarty_tpl->parent != null) $_smarty_tpl->parent->tpl_vars['table_bk'] = clone $_smarty_tpl->tpl_vars['table_bk'];?>
<form id="<?php if (isset($_smarty_tpl->tpl_vars['fields']->value['form']['form']['id_form'])) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['fields']->value['form']['form']['id_form'], ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php if ($_smarty_tpl->tpl_vars['table']->value==null) {?>configuration_form<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_form<?php }?><?php if (isset(Smarty::$_smarty_vars['capture']['table_count'])&&Smarty::$_smarty_vars['capture']['table_count']) {?>_<?php echo intval(Smarty::$_smarty_vars['capture']['table_count']);?>
<?php }?><?php }?>" class="defaultForm form-horizontal<?php if (isset($_smarty_tpl->tpl_vars['name_controller']->value)&&$_smarty_tpl->tpl_vars['name_controller']->value) {?> <?php echo $_smarty_tpl->tpl_vars['name_controller']->value;?>
<?php }?>"<?php if (isset($_smarty_tpl->tpl_vars['current']->value)&&$_smarty_tpl->tpl_vars['current']->value) {?> action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['current']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php if (isset($_smarty_tpl->tpl_vars['token']->value)&&$_smarty_tpl->tpl_vars['token']->value) {?>&amp;token=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>"<?php }?> method="post" enctype="multipart/form-data"<?php if (isset($_smarty_tpl->tpl_vars['style']->value)) {?> style="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
"<?php }?> novalidate>
	<?php if ($_smarty_tpl->tpl_vars['form_id']->value) {?>
		<input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['identifier']->value;?>
" id="<?php echo $_smarty_tpl->tpl_vars['identifier']->value;?>
<?php if (isset(Smarty::$_smarty_vars['capture']['identifier_count'])&&Smarty::$_smarty_vars['capture']['identifier_count']) {?>_<?php echo intval(Smarty::$_smarty_vars['capture']['identifier_count']);?>
<?php }?>" value="<?php echo $_smarty_tpl->tpl_vars['form_id']->value;?>
" />
	<?php }?>
	<?php if (!empty($_smarty_tpl->tpl_vars['submit_action']->value)) {?>
		<input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['submit_action']->value;?>
" value="1" />
	<?php }?>
	<?php  $_smarty_tpl->tpl_vars['fieldset'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['fieldset']->_loop = false;
 $_smarty_tpl->tpl_vars['f'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['fields']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['fieldset']->key => $_smarty_tpl->tpl_vars['fieldset']->value) {
$_smarty_tpl->tpl_vars['fieldset']->_loop = true;
 $_smarty_tpl->tpl_vars['f']->value = $_smarty_tpl->tpl_vars['fieldset']->key;
?>
		
		<?php $_smarty_tpl->_capture_stack[0][] = array('fieldset_name', null, null); ob_start(); ?><?php echo smarty_function_counter(array('name'=>'fieldset_name'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
		<div class="panel" id="fieldset_<?php echo $_smarty_tpl->tpl_vars['f']->value;?>
<?php if (isset(Smarty::$_smarty_vars['capture']['identifier_count'])&&Smarty::$_smarty_vars['capture']['identifier_count']) {?>_<?php echo intval(Smarty::$_smarty_vars['capture']['identifier_count']);?>
<?php }?><?php if (Smarty::$_smarty_vars['capture']['fieldset_name']>1) {?>_<?php echo intval((Smarty::$_smarty_vars['capture']['fieldset_name']-1));?>
<?php }?>">
			<?php  $_smarty_tpl->tpl_vars['field'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['fieldset']->value['form']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field']->key => $_smarty_tpl->tpl_vars['field']->value) {
$_smarty_tpl->tpl_vars['field']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['field']->key;
?>
				<?php if ($_smarty_tpl->tpl_vars['key']->value=='legend') {?>
					
						<div class="panel-heading">
							<?php if (isset($_smarty_tpl->tpl_vars['field']->value['image'])&&isset($_smarty_tpl->tpl_vars['field']->value['title'])) {?><img src="<?php echo $_smarty_tpl->tpl_vars['field']->value['image'];?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['field']->value['title'], ENT_QUOTES, 'UTF-8', true);?>
" /><?php }?>
							<?php if (isset($_smarty_tpl->tpl_vars['field']->value['icon'])) {?><i class="<?php echo $_smarty_tpl->tpl_vars['field']->value['icon'];?>
"></i><?php }?>
							<?php echo $_smarty_tpl->tpl_vars['field']->value['title'];?>

						</div>
					
				<?php } elseif ($_smarty_tpl->tpl_vars['key']->value=='description'&&$_smarty_tpl->tpl_vars['field']->value) {?>
					<div class="alert alert-info"><?php echo $_smarty_tpl->tpl_vars['field']->value;?>
</div>
				<?php } elseif ($_smarty_tpl->tpl_vars['key']->value=='warning'&&$_smarty_tpl->tpl_vars['field']->value) {?>
					<div class="alert alert-warning"><?php echo $_smarty_tpl->tpl_vars['field']->value;?>
</div>
				<?php } elseif ($_smarty_tpl->tpl_vars['key']->value=='success'&&$_smarty_tpl->tpl_vars['field']->value) {?>
					<div class="alert alert-success"><?php echo $_smarty_tpl->tpl_vars['field']->value;?>
</div>
				<?php } elseif ($_smarty_tpl->tpl_vars['key']->value=='error'&&$_smarty_tpl->tpl_vars['field']->value) {?>
					<div class="alert alert-danger"><?php echo $_smarty_tpl->tpl_vars['field']->value;?>
</div>
				<?php } elseif ($_smarty_tpl->tpl_vars['key']->value=='input') {?>
					<div class="form-wrapper">
					<?php  $_smarty_tpl->tpl_vars['input'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['input']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['field']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['input']->key => $_smarty_tpl->tpl_vars['input']->value) {
$_smarty_tpl->tpl_vars['input']->_loop = true;
?>
						
						<div class="form-group<?php if (isset($_smarty_tpl->tpl_vars['input']->value['form_group_class'])) {?> <?php echo $_smarty_tpl->tpl_vars['input']->value['form_group_class'];?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['input']->value['type']=='hidden') {?> hide<?php }?>"<?php if ($_smarty_tpl->tpl_vars['input']->value['name']=='id_state') {?> id="contains_states"<?php if (!$_smarty_tpl->tpl_vars['contains_states']->value) {?> style="display:none;"<?php }?><?php }?><?php if (isset($_smarty_tpl->tpl_vars['tabs']->value)&&isset($_smarty_tpl->tpl_vars['input']->value['tab'])) {?> data-tab-id="<?php echo $_smarty_tpl->tpl_vars['input']->value['tab'];?>
"<?php }?>>
						<?php if ($_smarty_tpl->tpl_vars['input']->value['type']=='hidden') {?>
							<input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']], ENT_QUOTES, 'UTF-8', true);?>
" />
						<?php } else { ?>
							
								<?php if (isset($_smarty_tpl->tpl_vars['input']->value['label'])) {?>
									<label class="control-label col-lg-3<?php if (isset($_smarty_tpl->tpl_vars['input']->value['required'])&&$_smarty_tpl->tpl_vars['input']->value['required']&&$_smarty_tpl->tpl_vars['input']->value['type']!='radio') {?> required<?php }?>">
										<?php if (isset($_smarty_tpl->tpl_vars['input']->value['hint'])) {?>
										<span class="label-tooltip" data-toggle="tooltip" data-html="true" title="<?php if (is_array($_smarty_tpl->tpl_vars['input']->value['hint'])) {?>
													<?php  $_smarty_tpl->tpl_vars['hint'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['hint']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['input']->value['hint']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['hint']->key => $_smarty_tpl->tpl_vars['hint']->value) {
$_smarty_tpl->tpl_vars['hint']->_loop = true;
?>
														<?php if (is_array($_smarty_tpl->tpl_vars['hint']->value)) {?>
															<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['hint']->value['text']);?>

														<?php } else { ?>
															<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['hint']->value);?>

														<?php }?>
													<?php } ?>
												<?php } else { ?>
													<?php echo preg_replace("%(?<!\\\\)'%", "\'",$_smarty_tpl->tpl_vars['input']->value['hint']);?>

												<?php }?>">
										<?php }?>
										<?php echo $_smarty_tpl->tpl_vars['input']->value['label'];?>

										<?php if (isset($_smarty_tpl->tpl_vars['input']->value['hint'])) {?>
										</span>
										<?php }?>
									</label>
								<?php }?>
							

							
        <?php if ($_smarty_tpl->tpl_vars['input']->value['type']=='setting_list') {?>
            <ol class="breadcrumb leo-redirect">
                <li class="active"><?php echo smartyTranslate(array('s'=>'Setting List','mod'=>'leotempcp'),$_smarty_tpl);?>
</li>
                <li><a href="#" data-element="fieldset_0"><?php echo smartyTranslate(array('s'=>'GENERAL SETTING','mod'=>'leotempcp'),$_smarty_tpl);?>
</a></li>
                <li><a href="#" data-element="fieldset_1_1"><?php echo smartyTranslate(array('s'=>'PAGES SETTING','mod'=>'leotempcp'),$_smarty_tpl);?>
</a></li>
                <li><a href="#" data-element="fieldset_2_2"><?php echo smartyTranslate(array('s'=>'CUSTOMIZATION SETTING','mod'=>'leotempcp'),$_smarty_tpl);?>
</a></li>
                <li><a href="#" data-element="fieldset_3_3"><?php echo smartyTranslate(array('s'=>'FONT SETTING','mod'=>'leotempcp'),$_smarty_tpl);?>
</a></li>
                <li><a href="#" data-element="fieldset_4_4"><?php echo smartyTranslate(array('s'=>'DATA SAMPLE','mod'=>'leotempcp'),$_smarty_tpl);?>
</a></li>
            </ol>
        <?php }?>

        <?php if ($_smarty_tpl->tpl_vars['input']->value['type']=='img_cat') {?>
                <?php $_smarty_tpl->tpl_vars['tree'] = new Smarty_variable($_smarty_tpl->tpl_vars['input']->value['tree'], null, 0);?>
  				<?php $_smarty_tpl->tpl_vars['imageList'] = new Smarty_variable($_smarty_tpl->tpl_vars['input']->value['imageList'], null, 0);?>
  				<?php $_smarty_tpl->tpl_vars['selected_images'] = new Smarty_variable($_smarty_tpl->tpl_vars['input']->value['selected_images'], null, 0);?>
                <div class="form-group form-select-icon">
                                <label class="control-label col-lg-3 " for="categories"> <?php echo smartyTranslate(array('s'=>'Categories','mod'=>'leotempcp'),$_smarty_tpl);?>
 </label>
                                <div class="col-lg-9">
                                <?php echo $_smarty_tpl->tpl_vars['tree']->value;?>

                                </div>
                                <input type="hidden" name="category_img" id="category_img" value='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['selected_images']->value, ENT_QUOTES, 'UTF-8', true);?>
'/>
                                <div id="list_image_wrapper" style="display:none">
                                    <div class="list-image btn-group">
                                        <button style="background-color:#00aff0; padding:0 8px;" type="button" class="btn dropdown-toggle" data-toggle="dropdown" value="imageicon">icons
                                          <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                        	<li><a href="#">none</a></li>
                                        	<?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['image']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['imageList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value) {
$_smarty_tpl->tpl_vars['image']->_loop = true;
?>
                        					<li><a href="#"><img height = '10px' src='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value["path"], ENT_QUOTES, 'UTF-8', true);?>
'> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value["name"], ENT_QUOTES, 'UTF-8', true);?>
</a></li>
                   							 <?php } ?>
                                        </ul>
                                      </div>
                                </div>
                </div>
        <?php }?>
		
		<?php if ($_smarty_tpl->tpl_vars['input']->value['type']=='slide') {?>
			<style type="text/css">
				#list-imgs li {
				border: 1px solid #ddd;
				float: left;
				font-size: 12px;
				height: 115px;
				line-height: 1.4;
				margin: 0 -1px -1px 0;
				padding: 10px 5px;
				text-align: center;
				width: 20%;
				list-style: none outside none;
			}
			</style>
			<script type="text/javascript">
			
			jQuery(document).ready(function(){
				$(".addslide").click( function(){
					var html = getSlide();
					$("#contentSlides").append(html);
					deleteSlide();
				});
				
				// leotempcp choose image, thumbnail
				$(".choose-img").click(function(e){
					chooseIMG = $(this);
					e.preventDefault();
					$.fancybox.open([
							{
								type: 'iframe', 
								href : $(this).attr("href"),
								afterLoad:function(){
									hideSomeElement(chooseIMG);
									//$('.fancybox-iframe').load( $this.hideSomeElement );
								},
								beforeShow: function () {
									hideSomeElement(chooseIMG);
								},
								afterShow: function () {
									hideSomeElement(chooseIMG);
								},
								afterClose: function (event, ui) {
									//location.reload();
									//refressImage();
								}
							}
						], {
							padding: 10
						});
				});
				
				var hideSomeElement = function(chooseIMG)
				{
					$('.select-img', $('.fancybox-iframe').contents()).click(function(){
						if($(chooseIMG).data('type') == 'main'){
							selectImage('image', $(this).data('name') , '#main_image', $(this).attr('src'));
						}else{
							selectImage('thum', $(this).data('name') , '#main_thum', $(this).attr('src'));
						}
						$.fancybox.close();
					});
					$('body',$('.fancybox-iframe').contents()).find("#header").hide();
					$('body',$('.fancybox-iframe').contents()).find("#footer").hide();
					$('body',$('.fancybox-iframe').contents()).find(".page-head, #nav-sidebar ").hide();
					//$('body',$('.fancybox-iframe').contents()).find("#content.bootstrap").css( 'padding',0).css('margin',0);
				};
				
				<?php if ($_smarty_tpl->tpl_vars['slide_edit']->value&&$_smarty_tpl->tpl_vars['slide_edit']->value['id_slide']) {?>
				$(".updateslide").click( function(){
					var id_slide = <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide_edit']->value['id_slide'], ENT_QUOTES, 'UTF-8', true);?>
;
					var html = getSlide(true);
					$("#contentSlides_"+id_slide).html(html);
					deleteSlide();
				});	
				<?php }?>
				
				$(function() {
				var $myTabs = $("#contentSlides");
				$myTabs.sortable({
					opacity: 0.6,
					cursor: "move"
				});
				$myTabs.hover(function() {
					$(this).css("cursor","move");
					},
					function() {
					$(this).css("cursor","auto");   
					});
				});
				deleteSlide();
			});	
			function selectImage(name,url,id,path){
					if(url != ''){
						var iso_code = '';
						$.each(languages, function(key, language) {
							if(language['id_lang'] == id_language)
								iso_code = language['iso_code'];
						});
						
						var html = 	"<img class='select-img' height='100px' src='"+path+"' data-image='"+url+"' title=''>";
							html += "<input type='hidden' name='"+name+'_'+iso_code+"' value='"+url+"'>";
						$(id+'_'+iso_code).html(html);
					}
					return false;
			}
				
			function getSlide(edit)
			 {
				var result = new Array();
				var string_tab = new Array();
				$(".leo-slide").each(function(x) {
					var res = $(this).attr("id");
					if(res)
						result[x] =  res.replace("contentSlides_",""); 
				});
				var max = Math.max.apply(Math, result);
				if(max != '-Infinity')
					maxid = max+1;
				else
					maxid = 1;	
				$.each(languages, function(key, language) {
						if(language['id_lang'] == id_language)
							iso_code = language['iso_code'];
				});	
				var this_title 	= 	$("#title_"+iso_code).val();
                                var this_link 	= 	$("#link_"+iso_code).val();
				var lang_des 	= 	$("#description_"+iso_code).val();
				var this_image 	= 	$("#main_image_"+iso_code+" img").data("image");
				var this_thum 	= 	$("#main_thum_"+iso_code+" img").data("image");
				var myObject = {
					"id_slide": 	maxid,		
				};
                                $(".slide_link").each(
					function(){
						var iso_code =  $(this).attr("id").replace("link_","");
						myObject["link_"+iso_code] = $(this).val();
					}
				);
				$(".slide_title").each(
					function(){
						var iso_code =  $(this).attr("id").replace("title_","");
						myObject["title_"+iso_code] = $(this).val();
					}
				);
				$(".slide_description").each(
					function(){
						var iso_code =  $(this).attr("id").replace("description_","");
						myObject["description_"+iso_code] = $(this).val();
					}
				);
				$(".main_image img").each(
					function(){
						var iso_code =  $(this).parent().attr("id").replace("main_image_","");
						myObject["image_"+iso_code] = $(this).data("image");
					}
				);
				$(".main_thum img").each(
					function(){
						var iso_code =  $(this).parent().attr("id").replace("main_thum_","");
						myObject["thum_"+iso_code] = $(this).data("image");
					}
				);
                                
				slides = JSON.stringify(myObject);
				var imgUrl = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['pathimg']->value, ENT_QUOTES, 'UTF-8', true);?>
';
				var thumUrl ='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['paththum']->value, ENT_QUOTES, 'UTF-8', true);?>
';
				if(this_image && this_image != 'none')
					var src_img = "<img class='"+this_image+"' src="+imgUrl+this_image+" style='height:50px;width:100px;'/>";
				else
					var src_img = '';
				if(this_thum && this_thum != 'none')
					var src_thum = "<img class='"+this_thum+"' src="+thumUrl+this_thum+" style='height:25px;width:25px;'/>";
				else
					var src_thum = '';	
				if(edit){
					<?php if ($_smarty_tpl->tpl_vars['slide_edit']->value&&$_smarty_tpl->tpl_vars['slide_edit']->value['id_slide']) {?>
					var html = "<div class='col-lg-1'>"+<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide_edit']->value['id_slide'], ENT_QUOTES, 'UTF-8', true);?>
+"</div><div  class='col-lg-2'>"+this_title+"</div><div class='col-lg-5'>"+src_img+"</div><div class='col-lg-2'>"+src_thum+"</div><div class='col-lg-2'><div class='btn-group-action pull-right'><p><input id="+<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide_edit']->value['id_slide'], ENT_QUOTES, 'UTF-8', true);?>
+" class='btn-delete btn btn-danger' type='button'  value='Delete'></p></div></div><input id='leoslide_"+<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide_edit']->value['id_slide'], ENT_QUOTES, 'UTF-8', true);?>
+"' name='leoslide[]' value='"+slides+"' type='hidden'/>";
					<?php }?>
				}
				else{
					var html = "<div class='leo-slide col-lg-12' id='contentSlides_"+maxid+"' style='border: 1px solid #ccc;margin-top: 5px;padding: 5px;'><div  class='col-lg-1'>"+maxid+"</div><div class='col-lg-2'>"+this_title+"</div><div  class='col-lg-5'>"+src_img+"</div><div  class='col-lg-2'>"+src_thum+"</div><div class='col-lg-2'><div class='btn-group-action pull-right'><p><input id="+maxid+" class='btn-delete btn btn-danger' type='button'  value='Delete'></p></div></div><input id='leoslide_"+maxid+"' name='leoslide[]' value='"+slides+"' type='hidden'/></div>";
				}
				return html;
			 }	
			 
			function deleteSlide()
			{
				$(".btn-delete").click( function(){
					$(this).closest(".col-lg-12").remove();
				});
			}
				
			</script>
			<hr>
		<div class="form-group">
			<label class="control-label col-lg-3 " for="title"> <?php echo smartyTranslate(array('s'=>'Title','mod'=>'leotempcp'),$_smarty_tpl);?>
 </label>
			<div class="col-lg-9">
				<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
				<?php $_smarty_tpl->tpl_vars["t_title"] = new Smarty_variable("title_".((string)$_smarty_tpl->tpl_vars['language']->value['iso_code']), null, 0);?>
					<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>
					<div class="row">
						<div class="translatable-field lang-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['id_lang'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['language']->value['id_lang']!=$_smarty_tpl->tpl_vars['id_lang_default']->value) {?>style="display:none"<?php }?>>
							<div class="col-lg-9"> 
					<?php }?>
						<input class="slide_title" id="title_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['iso_code'], ENT_QUOTES, 'UTF-8', true);?>
" type="text"  name="title_<?php echo intval($_smarty_tpl->tpl_vars['language']->value['id_lang']);?>
" value="<?php if ($_smarty_tpl->tpl_vars['slide_edit']->value&&$_smarty_tpl->tpl_vars['slide_edit']->value[$_smarty_tpl->tpl_vars['t_title']->value]) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide_edit']->value[$_smarty_tpl->tpl_vars['t_title']->value], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>">
					<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>
							</div>
							<div class="col-lg-2">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['iso_code'], ENT_QUOTES, 'UTF-8', true);?>
 
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
									<li><a href="javascript:hideOtherLanguage(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['id_lang'], ENT_QUOTES, 'UTF-8', true);?>
);" tabindex="-1"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</a></li>
									<?php } ?>
								</ul>
							</div>		
						</div>
					</div>
					<?php }?>
				<?php } ?>
		</div>
	</div>
        <div class="form-group">
			<label class="control-label col-lg-3 " for="link"> <?php echo smartyTranslate(array('s'=>'Link','mod'=>'leotempcp'),$_smarty_tpl);?>
 </label>
			<div class="col-lg-9">
				<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
				<?php $_smarty_tpl->tpl_vars["t_link"] = new Smarty_variable("link_".((string)$_smarty_tpl->tpl_vars['language']->value['iso_code']), null, 0);?>
					<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>
					<div class="row">
						<div class="translatable-field lang-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['id_lang'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['language']->value['id_lang']!=$_smarty_tpl->tpl_vars['id_lang_default']->value) {?>style="display:none"<?php }?>>
							<div class="col-lg-9"> 
					<?php }?>
						<input class="slide_link" id="link_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['iso_code'], ENT_QUOTES, 'UTF-8', true);?>
" type="text"  name="link_<?php echo intval($_smarty_tpl->tpl_vars['language']->value['id_lang']);?>
" value="<?php if ($_smarty_tpl->tpl_vars['slide_edit']->value&&$_smarty_tpl->tpl_vars['slide_edit']->value[$_smarty_tpl->tpl_vars['t_link']->value]) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide_edit']->value[$_smarty_tpl->tpl_vars['t_link']->value], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>">
					<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>
							</div>
							<div class="col-lg-2">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['iso_code'], ENT_QUOTES, 'UTF-8', true);?>
 
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
									<li><a href="javascript:hideOtherLanguage(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['id_lang'], ENT_QUOTES, 'UTF-8', true);?>
);" tabindex="-1"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</a></li>
									<?php } ?>
								</ul>
							</div>		
						</div>
					</div>
					<?php }?>
				<?php } ?>
		</div>
	</div>
	<div class="form-group">
				<label class="control-label col-lg-3 " for="description"> <?php echo smartyTranslate(array('s'=>'Description','mod'=>'leotempcp'),$_smarty_tpl);?>
 </label>
				<div class="col-lg-9">
					<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
					<?php $_smarty_tpl->tpl_vars["t_description"] = new Smarty_variable("description_".((string)$_smarty_tpl->tpl_vars['language']->value['iso_code']), null, 0);?>
						<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>
						<div class="row">
							<div class="translatable-field lang-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['id_lang'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['language']->value['id_lang']!=$_smarty_tpl->tpl_vars['id_lang_default']->value) {?>style="display:none"<?php }?>>
								<div class="col-lg-9">
									<?php }?>
										<textarea id="description_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['iso_code'], ENT_QUOTES, 'UTF-8', true);?>
" class="slide_description textarea-autosize" rows="10" cols="40" style="overflow: hidden; word-wrap: break-word; resize: none; height: 199px;" id="description_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['iso_code'], ENT_QUOTES, 'UTF-8', true);?>
" name="description_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['iso_code'], ENT_QUOTES, 'UTF-8', true);?>
"><?php if ($_smarty_tpl->tpl_vars['slide_edit']->value&&$_smarty_tpl->tpl_vars['slide_edit']->value[$_smarty_tpl->tpl_vars['t_description']->value]) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide_edit']->value[$_smarty_tpl->tpl_vars['t_description']->value], ENT_QUOTES, 'UTF-8', true);?>
<?php }?></textarea>
									<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>	
								</div>
								<div class="col-lg-2">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
										<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['iso_code'], ENT_QUOTES, 'UTF-8', true);?>
 
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu">
										<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
										<li><a href="javascript:hideOtherLanguage(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['id_lang'], ENT_QUOTES, 'UTF-8', true);?>
);" tabindex="-1"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</a></li>
										<?php } ?>
									</ul>
								</div>		
							</div>
						</div>
						<?php }?>
					<?php } ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-lg-3 " for="title"> <?php echo smartyTranslate(array('s'=>'Image','mod'=>'leotempcp'),$_smarty_tpl);?>
 </label>
				<div class="col-lg-9">
						<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
						<?php $_smarty_tpl->tpl_vars["t_image"] = new Smarty_variable("image_".((string)$_smarty_tpl->tpl_vars['language']->value['iso_code']), null, 0);?>
							<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>
							<div class="row">
								<div class="translatable-field lang-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['id_lang'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['language']->value['id_lang']!=$_smarty_tpl->tpl_vars['id_lang_default']->value) {?>style="display:none"<?php }?>>
									<div class="col-lg-9"> 
							<?php }?>
								<div class="main_image" id="main_image_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['iso_code'], ENT_QUOTES, 'UTF-8', true);?>
" type="text">
									<?php if ($_smarty_tpl->tpl_vars['slide_edit']->value&&isset($_smarty_tpl->tpl_vars['slide_edit']->value[$_smarty_tpl->tpl_vars['t_image']->value])&&$_smarty_tpl->tpl_vars['slide_edit']->value[$_smarty_tpl->tpl_vars['t_image']->value]) {?>
										<img class="select-img" height="100px" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['pathimg']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide_edit']->value[$_smarty_tpl->tpl_vars['t_image']->value], ENT_QUOTES, 'UTF-8', true);?>
" data-image="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide_edit']->value[$_smarty_tpl->tpl_vars['t_image']->value], ENT_QUOTES, 'UTF-8', true);?>
" title="">
										<input type='hidden' name="image_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['iso_code']->value, ENT_QUOTES, 'UTF-8', true);?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide_edit']->value[$_smarty_tpl->tpl_vars['t_image']->value], ENT_QUOTES, 'UTF-8', true);?>
">
									<?php }?>	
								</div>
							<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>
									</div>
									<div class="col-lg-2">
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['iso_code'], ENT_QUOTES, 'UTF-8', true);?>

											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
											<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
											<li><a href="javascript:hideOtherLanguage(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['id_lang'], ENT_QUOTES, 'UTF-8', true);?>
);" tabindex="-1"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</a></li>
											<?php } ?>
										</ul>
									</div>		
								</div>
							</div>
							<?php }?>
						<?php } ?>
					<a href='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['selectImg'], ENT_QUOTES, 'UTF-8', true);?>
&imgDir=slideImg' data-type='main' class='choose-img'>
						<?php echo smartyTranslate(array('s'=>'Choose Image','mod'=>'leotempcp'),$_smarty_tpl);?>

					</a>	
				</div>
			</div>	
			<div class="form-group">
				<label class="control-label col-lg-3 " for="title"> <?php echo smartyTranslate(array('s'=>'Thumb','mod'=>'leotempcp'),$_smarty_tpl);?>
 </label>
				<div class="col-lg-9">
						<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
						<?php $_smarty_tpl->tpl_vars["t_thum"] = new Smarty_variable("thum_".((string)$_smarty_tpl->tpl_vars['language']->value['iso_code']), null, 0);?>
							<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>
							<div class="row">
								<div class="translatable-field lang-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['id_lang'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['language']->value['id_lang']!=$_smarty_tpl->tpl_vars['id_lang_default']->value) {?>style="display:none"<?php }?>>
									<div class="col-lg-9"> 
							<?php }?>
								<div class="main_thum" id="main_thum_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['iso_code'], ENT_QUOTES, 'UTF-8', true);?>
" type="text">
									<?php if ($_smarty_tpl->tpl_vars['slide_edit']->value&&isset($_smarty_tpl->tpl_vars['slide_edit']->value[$_smarty_tpl->tpl_vars['t_thum']->value])&&$_smarty_tpl->tpl_vars['slide_edit']->value[$_smarty_tpl->tpl_vars['t_thum']->value]) {?>
										<img class="select-img" height="100px" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['paththum']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide_edit']->value[$_smarty_tpl->tpl_vars['t_thum']->value], ENT_QUOTES, 'UTF-8', true);?>
" data-image="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide_edit']->value[$_smarty_tpl->tpl_vars['t_thum']->value], ENT_QUOTES, 'UTF-8', true);?>
" title="">
										<input type='hidden' name="image_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['iso_code']->value, ENT_QUOTES, 'UTF-8', true);?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['slide_edit']->value[$_smarty_tpl->tpl_vars['t_thum']->value], ENT_QUOTES, 'UTF-8', true);?>
">
									<?php }?>	
								</div>
							<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>
									</div>
									<div class="col-lg-2">
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['iso_code'], ENT_QUOTES, 'UTF-8', true);?>
 
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
											<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
											<li><a href="javascript:hideOtherLanguage(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['id_lang'], ENT_QUOTES, 'UTF-8', true);?>
);" tabindex="-1"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</a></li>
											<?php } ?>
										</ul>
									</div>		
								</div>
							</div>
							<?php }?>
						<?php } ?>
                                                <a href='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['selectImg'], ENT_QUOTES, 'UTF-8', true);?>
&imgDir=slideThumb' data-type='thumb' class='choose-img'>
                                                        <?php echo smartyTranslate(array('s'=>'Choose Thumbnail','mod'=>'leotempcp'),$_smarty_tpl);?>

                                                </a>
				</div>
			</div>	
			<div class="form-group">
				<div  class="col-lg-9 col-lg-offset-3">
						<button class="btn btn-default addslide" name="addslide" type="button">
							<i class="icon-plus-sign-alt"></i>
							<?php echo smartyTranslate(array('s'=>'Add','mod'=>'leotempcp'),$_smarty_tpl);?>

						</button>
						<input class="btn-update btn btn-info updateslide" type="button" name="updateslide" value="<?php echo smartyTranslate(array('s'=>'Update','mod'=>'leotempcp'),$_smarty_tpl);?>
">
				</div>	
			</div>	
			<hr>
			<div class="form-group">
				<div class="col-lg-offset-3 contentSlides" id="contentSlides">
					<?php if (isset($_smarty_tpl->tpl_vars['items']->value)&&$_smarty_tpl->tpl_vars['items']->value) {?>	
					 <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
						<?php $_smarty_tpl->tpl_vars["t_title"] = new Smarty_variable("title_".((string)$_smarty_tpl->tpl_vars['iso_code']->value), null, 0);?>
						<?php $_smarty_tpl->tpl_vars["t_description"] = new Smarty_variable("description_".((string)$_smarty_tpl->tpl_vars['iso_code']->value), null, 0);?>
						<?php $_smarty_tpl->tpl_vars["t_image"] = new Smarty_variable("image_".((string)$_smarty_tpl->tpl_vars['iso_code']->value), null, 0);?>
						<?php $_smarty_tpl->tpl_vars["t_thum"] = new Smarty_variable("thum_".((string)$_smarty_tpl->tpl_vars['iso_code']->value), null, 0);?>
						<div id="contentSlides_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['id_slide'], ENT_QUOTES, 'UTF-8', true);?>
" class="leo-slide col-lg-12" style="border: 1px solid #ccc;margin-top: 5px;padding: 5px;">
							<div class="col-lg-1"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['id_slide'], ENT_QUOTES, 'UTF-8', true);?>
</div>
							<div class="col-lg-2"><?php if (isset($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['t_title']->value])&&$_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['t_title']->value]) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['t_title']->value], ENT_QUOTES, 'UTF-8', true);?>
<?php }?></div>
							<div class="col-lg-5"><?php if (isset($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['t_image']->value])&&$_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['t_image']->value]) {?><img  src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['pathimg']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['t_image']->value], ENT_QUOTES, 'UTF-8', true);?>
" style="width:100px;height:50px" class="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['t_image']->value], ENT_QUOTES, 'UTF-8', true);?>
"><?php }?></div>
							<div class="col-lg-2"><?php if (isset($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['t_thum']->value])&&$_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['t_thum']->value]) {?><img  src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['paththum']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['t_thum']->value], ENT_QUOTES, 'UTF-8', true);?>
" style="width:25px;height:25px" class="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['t_thum']->value], ENT_QUOTES, 'UTF-8', true);?>
"><?php }?></div>
							<div class="col-lg-2">
								<div class="btn-group-action pull-right">
								<p>
									<a class="btn-edit btn btn-info" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['url']->value, ENT_QUOTES, 'UTF-8', true);?>
&id_slide=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['id_slide'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['slide_edit']->value&&$_smarty_tpl->tpl_vars['slide_edit']->value['id_slide']&&$_smarty_tpl->tpl_vars['slide_edit']->value['id_slide']==$_smarty_tpl->tpl_vars['item']->value['id_slide']) {?>style="display:none"<?php }?>/><?php echo smartyTranslate(array('s'=>'Edit','mod'=>'leotempcp'),$_smarty_tpl);?>
</a>
									<input class="btn-delete btn btn-danger" type="button" id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['id_slide'], ENT_QUOTES, 'UTF-8', true);?>
" value="<?php echo smartyTranslate(array('s'=>'Delete','mod'=>'leotempcp'),$_smarty_tpl);?>
">
								</p>
								</div>
							</div>
							<input id="Tabs_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['id_slide'], ENT_QUOTES, 'UTF-8', true);?>
" name="leoslide[]" value='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['slide'], ENT_QUOTES, 'UTF-8', true);?>
' type="hidden"/>
						</div>
					 <?php } ?>
					<?php }?>				
				</div>
			</div>		
		<?php }?>			
		
		<?php if ($_smarty_tpl->tpl_vars['input']->value['type']=='setting_tab') {?>
			<?php $_smarty_tpl->tpl_vars['tree'] = new Smarty_variable($_smarty_tpl->tpl_vars['input']->value['tree'], null, 0);?>	
			<script type="text/javascript">
				
				jQuery(document).ready(function(){
				$(".addtabs").click( function(){
					var html = getTabs();
					$("#contentTabs").append(html);
					deleteTabs();
				});
				<?php if ($_smarty_tpl->tpl_vars['tab_edit']->value&&$_smarty_tpl->tpl_vars['tab_edit']->value['id_tab']) {?>
				$(".updatetabs").click( function(){
					var id_tab = <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_edit']->value['id_tab'], ENT_QUOTES, 'UTF-8', true);?>
;
					var html = getTabs(true);
					$("#contentTabs_"+id_tab).html(html);
					deleteTabs();
				});	
				<?php }?>
				deleteTabs();
				$(function() {
				var $myTabs = $("#contentTabs");
				$myTabs.sortable({
					opacity: 0.6,
					cursor: "move"
				});
				$myTabs.hover(function() {
					$(this).css("cursor","move");
					},
					function() {
					$(this).css("cursor","auto");
					});
				});
				
			var bgCatUrl = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['path']->value, ENT_QUOTES, 'UTF-8', true);?>
";

			function deleteTabs()
			{
				$(".btn-delete").click( function(){
					$(this).closest(".col-lg-9").remove();
				});
			}
			
			function getTabs(edit)
			 {
				var result = new Array();
				var string_tab = new Array();
				$(".leo-tab").each(function(x) {
					var res = $(this).attr("id");
					if(res)
						result[x] =  res.replace("contentTabs_",""); 
				});
				var max = Math.max.apply(Math, result);
				if(max != '-Infinity')
					maxid = max+1;
				else
					maxid = 1;	
				var this_lang = "tabtitle_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['iso_code']->value, ENT_QUOTES, 'UTF-8', true);?>
";
				var this_title = $("#"+this_lang).val();
				var type = $( "select#tabtype option:selected" ).val();
				var icon = $( "select#icon option:selected" ).val();
				var categories = new Array();
				$('.tree input:checked').each(function(y){        
					var values = $(this).val();
					categories[y] = values;
				});
				var myObject = {
					"id_tab": 	maxid,	
					"type": 	type,
					"icon": 	icon,	
					"categories": categories		
				};
				$(".tabtitle").each(
					function(){
						var iso_code =  $(this).attr("id").replace("tabtitle_","");
						myObject["title_"+iso_code] = $(this).val();
					}
				);
				mytab = JSON.stringify(myObject);
				if(icon && icon != 'none')
					var src_img = "<img class='"+icon+"' src="+bgCatUrl+icon+" style='width:30px;'/>";
				else
					var src_img = '';
				if(edit){
					<?php if ($_smarty_tpl->tpl_vars['tab_edit']->value&&$_smarty_tpl->tpl_vars['tab_edit']->value['id_tab']) {?>
					var html = "<div class='col-lg-1'>"+<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_edit']->value['id_tab'], ENT_QUOTES, 'UTF-8', true);?>
+"</div><div  class='col-lg-2'>"+this_title+"</div><div class='col-lg-3'>"+type+"</div><div class='col-lg-3'>"+categories+"</div><div  class='col-lg-1'>"+src_img+"</div><div class='col-lg-2'><div class='btn-group-action pull-right'><p><input id="+<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_edit']->value['id_tab'], ENT_QUOTES, 'UTF-8', true);?>
+" class='btn-delete btn btn-danger' type='button'  value='Delete'></p></div></div><input id='Tabs_"+<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_edit']->value['id_tab'], ENT_QUOTES, 'UTF-8', true);?>
+"' name='leotab[]' value='"+mytab+"' type='hidden'/>";
					<?php }?>
				}
				else{
					var html = "<div class='leo-tab col-lg-9' id='contentTabs_"+maxid+"' style='border: 1px solid #ccc;margin-top: 5px;padding: 5px;'><div  class='col-lg-1'>"+maxid+"</div><div class='col-lg-2'>"+this_title+"</div><div  class='col-lg-3'>"+type+"</div><div class='col-lg-3'>"+categories+"</div><div  class='col-lg-1'>"+src_img+"</div><div class='col-lg-2'><div class='btn-group-action pull-right'><p><input id="+maxid+" class='btn-delete btn btn-danger' type='button'  value='Delete'></p></div></div><input id='Tabs_"+maxid+"' name='leotab[]' value='"+mytab+"' type='hidden'/></div>";
				}
				return html;
			 }
			});
			
			</script>
			<hr>	
					<div class="form-group">
									<label class="control-label col-lg-3 " for="tabtitle"> <?php echo smartyTranslate(array('s'=>'Title','mod'=>'leotempcp'),$_smarty_tpl);?>
 </label>
									<div class="col-lg-9">
										<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
										<?php $_smarty_tpl->tpl_vars["t_title"] = new Smarty_variable("title_".((string)$_smarty_tpl->tpl_vars['language']->value['iso_code']), null, 0);?>
											<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>
											<div class="row">
												<div class="translatable-field lang-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['id_lang'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['language']->value['id_lang']!=$_smarty_tpl->tpl_vars['id_lang_default']->value) {?>style="display:none"<?php }?>>
													<div class="col-lg-9"> 
											<?php }?>
												<input class="tabtitle" id="tabtitle_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['iso_code'], ENT_QUOTES, 'UTF-8', true);?>
" type="text"  name="tabtitle_<?php echo intval($_smarty_tpl->tpl_vars['language']->value['id_lang']);?>
" value="<?php if ($_smarty_tpl->tpl_vars['tab_edit']->value&&$_smarty_tpl->tpl_vars['tab_edit']->value[$_smarty_tpl->tpl_vars['t_title']->value]) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tab_edit']->value[$_smarty_tpl->tpl_vars['t_title']->value], ENT_QUOTES, 'UTF-8', true);?>
<?php }?>">
											<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>
													</div>
													<div class="col-lg-2">
														<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
															<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['iso_code'], ENT_QUOTES, 'UTF-8', true);?>
 
															<span class="caret"></span>
														</button>
														<ul class="dropdown-menu">
															<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
															<li><a href="javascript:hideOtherLanguage(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['id_lang'], ENT_QUOTES, 'UTF-8', true);?>
);" tabindex="-1"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['language']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</a></li>
															<?php } ?>
														</ul>
													</div>		
												</div>
											</div>
											<?php }?>
										<?php } ?>
									</div>
							</div>
							<div class="form-group">
									<label class="control-label col-lg-3 " for="categories"> <?php echo smartyTranslate(array('s'=>'Categories','mod'=>'leotempcp'),$_smarty_tpl);?>
 </label>
									<div class="col-lg-9">
									<?php echo $_smarty_tpl->tpl_vars['tree']->value;?>

									</div>
							</div>

							<div class="form-group">
									<label class="control-label col-lg-3 " for="tabtype"> <?php echo smartyTranslate(array('s'=>'Type','mod'=>'leotempcp'),$_smarty_tpl);?>
 </label>
									<div class="col-lg-9">
										<div class="col-lg-9 ">
											<select id="tabtype" class=" fixed-width-xl" name="tabtype">
												<option value="all"><?php echo smartyTranslate(array('s'=>'--All--','mod'=>'leotempcp'),$_smarty_tpl);?>
</option>
												<option value="special" <?php if ($_smarty_tpl->tpl_vars['tab_edit']->value&&$_smarty_tpl->tpl_vars['tab_edit']->value['type']=='special') {?> selected="selected" <?php }?> ><?php echo smartyTranslate(array('s'=>'Special','mod'=>'leotempcp'),$_smarty_tpl);?>
</option>
												<option value="bestseller" <?php if ($_smarty_tpl->tpl_vars['tab_edit']->value&&$_smarty_tpl->tpl_vars['tab_edit']->value['type']=='bestseller') {?> selected="selected" <?php }?>><?php echo smartyTranslate(array('s'=>'BestSeller','mod'=>'leotempcp'),$_smarty_tpl);?>
</option>
												<option value="featured" <?php if ($_smarty_tpl->tpl_vars['tab_edit']->value&&$_smarty_tpl->tpl_vars['tab_edit']->value['type']=='featured') {?> selected="selected" <?php }?>><?php echo smartyTranslate(array('s'=>'Featured','mod'=>'leotempcp'),$_smarty_tpl);?>
</option>
												<option value="new" <?php if ($_smarty_tpl->tpl_vars['tab_edit']->value&&$_smarty_tpl->tpl_vars['tab_edit']->value['type']=='new') {?>	selected="selected" <?php }?>><?php echo smartyTranslate(array('s'=>'New Arrials','mod'=>'leotempcp'),$_smarty_tpl);?>
</option>
											</select>
										</div>	
									</div>
							</div>
							<div class="form-group">
									<label class="control-label col-lg-3 " for="icon"> <?php echo smartyTranslate(array('s'=>'Icon','mod'=>'leotempcp'),$_smarty_tpl);?>
 </label>
									<div class="col-lg-9">
										<div class="col-lg-9 ">
											<select id="icon" class=" fixed-width-xl" name="icon">
												<option value="none"><?php echo smartyTranslate(array('s'=>'--None--','mod'=>'leotempcp'),$_smarty_tpl);?>
</option>
												<?php if ($_smarty_tpl->tpl_vars['images']->value) {?>
													<?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['image']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['images']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value) {
$_smarty_tpl->tpl_vars['image']->_loop = true;
?>
													<option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value, ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['tab_edit']->value&&$_smarty_tpl->tpl_vars['tab_edit']->value['icon']==$_smarty_tpl->tpl_vars['image']->value) {?> selected="selected" <?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value, ENT_QUOTES, 'UTF-8', true);?>
</option>
													<?php } ?>
												<?php }?>
											</select>
										</div>	
									</div>
							</div>
					<div class="form-group">
						<div  class="col-lg-9 col-lg-offset-3">
							<button class="btn btn-default addtabs" name="addtabs" type="button">
								<i class="icon-plus-sign-alt"></i>
								<?php echo smartyTranslate(array('s'=>'Add','mod'=>'leotempcp'),$_smarty_tpl);?>

							</button>
							<input class="btn-update btn btn-info updatetabs" type="button" name="updatetabs" value="<?php echo smartyTranslate(array('s'=>'Update','mod'=>'leotempcp'),$_smarty_tpl);?>
">
						</div>	
					</div>	
					<div class="form-group">
						<div class="col-lg-offset-3">
							<div  class="col-lg-9">
								<div class="col-lg-1"><?php echo smartyTranslate(array('s'=>'Id','mod'=>'leotempcp'),$_smarty_tpl);?>
</div>
								<div class="col-lg-2"><?php echo smartyTranslate(array('s'=>'Title','mod'=>'leotempcp'),$_smarty_tpl);?>
</div>
								<div class="col-lg-3"><?php echo smartyTranslate(array('s'=>'Type','mod'=>'leotempcp'),$_smarty_tpl);?>
</div>
								<div class="col-lg-3" ><?php echo smartyTranslate(array('s'=>'Categories','mod'=>'leotempcp'),$_smarty_tpl);?>
</div>
								<div class="col-lg-1" ><?php echo smartyTranslate(array('s'=>'Icon','mod'=>'leotempcp'),$_smarty_tpl);?>
</div>
								<div class="col-lg-2 " style="text-align:right;"><?php echo smartyTranslate(array('s'=>'Action','mod'=>'leotempcp'),$_smarty_tpl);?>
</div>
							</div>
						</div>	
					</div>
					<div class="form-group">
							<div class="col-lg-offset-3 contentTabs" id="contentTabs">
							<?php if (isset($_smarty_tpl->tpl_vars['items']->value)&&$_smarty_tpl->tpl_vars['items']->value) {?>	
							 <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
								<div id="contentTabs_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['id_tab'], ENT_QUOTES, 'UTF-8', true);?>
" class="leo-tab col-lg-9" style="border: 1px solid #ccc;margin-top: 5px;padding: 5px;">
									<div class="col-lg-1"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['id_tab'], ENT_QUOTES, 'UTF-8', true);?>
</div>
									<div class="col-lg-2"><?php if (isset($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['text_title']->value])&&$_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['text_title']->value]) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['text_title']->value], ENT_QUOTES, 'UTF-8', true);?>
<?php }?></div>
									<div class="col-lg-3"><?php if ($_smarty_tpl->tpl_vars['item']->value['type']) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['type'], ENT_QUOTES, 'UTF-8', true);?>
<?php }?></div>
									<div class="col-lg-3"><?php echo implode(', ',$_smarty_tpl->tpl_vars['item']->value['categories']);?>
</div>
									<div class="col-lg-1">
										<?php if ($_smarty_tpl->tpl_vars['item']->value['icon']&&$_smarty_tpl->tpl_vars['item']->value['icon']!='none') {?><img  src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['path']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['icon'], ENT_QUOTES, 'UTF-8', true);?>
" style="width:30px;" class="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['icon'], ENT_QUOTES, 'UTF-8', true);?>
"><?php }?>
									</div>
									<div class="col-lg-2">
										<div class="btn-group-action pull-right">
										<p>
												<a class="btn-edit btn btn-info" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['url']->value, ENT_QUOTES, 'UTF-8', true);?>
&id_tab=<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['id_tab'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if ($_smarty_tpl->tpl_vars['tab_edit']->value&&$_smarty_tpl->tpl_vars['tab_edit']->value['id_tab']&&$_smarty_tpl->tpl_vars['tab_edit']->value['id_tab']==$_smarty_tpl->tpl_vars['item']->value['id_tab']) {?>style="display:none"<?php }?>/><?php echo smartyTranslate(array('s'=>'Edit','mod'=>'leotempcp'),$_smarty_tpl);?>
</a>
											<input class="btn-delete btn btn-danger" type="button" id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['id_tab'], ENT_QUOTES, 'UTF-8', true);?>
" value="<?php echo smartyTranslate(array('s'=>'Delete','mod'=>'leotempcp'),$_smarty_tpl);?>
">
										</p>
										</div>
									</div>
									<input id="Tabs_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['id_tab'], ENT_QUOTES, 'UTF-8', true);?>
" name="leotab[]" value='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['tab'], ENT_QUOTES, 'UTF-8', true);?>
' type="hidden"/>
								</div>
							 <?php } ?>
							<?php }?>
							</div>
					</div>	
        <?php }?>
	<?php if ($_smarty_tpl->tpl_vars['input']->value['type']=='modules_block') {?>
            <?php $_smarty_tpl->tpl_vars['moduleList'] = new Smarty_variable($_smarty_tpl->tpl_vars['input']->value['values'], null, 0);?>
            <div class="col-lg-9 ">
            <?php if (isset($_smarty_tpl->tpl_vars['moduleList']->value)&&count($_smarty_tpl->tpl_vars['moduleList']->value)>0) {?>
                <p class="help-block"><?php echo smartyTranslate(array('s'=>'You can select one or more Module.','mod'=>'leotempcp'),$_smarty_tpl);?>
</p>
                <table cellspacing="0" cellpadding="0" class="table" style="min-width:40em;">
                    <tr>
                        <th>
                            <input type="checkbox" name="checkme" id="checkme" class="noborder" onclick="checkDelBoxes(this.form, '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
[]', this.checked)" />
                        </th>
                        <th><?php echo smartyTranslate(array('s'=>'Name','mod'=>'leotempcp'),$_smarty_tpl);?>
</th>
                        <th><?php echo smartyTranslate(array('s'=>'Back-up File','mod'=>'leotempcp'),$_smarty_tpl);?>
</th>
                    </tr>

                    <?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['moduleList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['moduleItem']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value) {
$_smarty_tpl->tpl_vars['module']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['moduleItem']['index']++;
?>
                        <tr <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['moduleItem']['index']%2) {?>class="alt_row"<?php }?>>
                            <td> 
                                <input type="checkbox" class="cmsBox" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
[]" id="chk_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
"/>
                            </td>
                            <td><label for="chk_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" class="t"><strong><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</strong></label></td>
                            <td>
                                <?php if (isset($_smarty_tpl->tpl_vars['module']->value['files'])) {?>
                                <select name="file_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
">
                                <?php  $_smarty_tpl->tpl_vars['file'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['file']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['module']->value['files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['file']->key => $_smarty_tpl->tpl_vars['file']->value) {
$_smarty_tpl->tpl_vars['file']->_loop = true;
?>
                                    <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['file']->value, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['file']->value, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                <?php } ?>
                                </select>
                                <?php }?>
                            </td>
                        </tr>
                    <?php } ?>

                </table>
            <?php }?>
            </div>
            <div class="form-group button-wrapper">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button class="button btn btn-success" name="submitBackup" id="module_form_submit_btn" type="submit">
                                 <?php echo smartyTranslate(array('s'=>'Back-up','mod'=>'leotempcp'),$_smarty_tpl);?>

                        </button>
                        <button class="button btn btn-danger" name="submitRestore" data-confirm="<?php echo smartyTranslate(array('s'=>'Are you sure you want to restore back-up file?','mod'=>'leotempcp'),$_smarty_tpl);?>
" id="module_form_submit_btn" type="submit">
                                 <?php echo smartyTranslate(array('s'=>'Restore Back-up File','mod'=>'leotempcp'),$_smarty_tpl);?>

                        </button>
                        
                        <button class="button btn btn-success" name="submitSample" id="module_form_submit_btn" type="submit">
                                 <?php echo smartyTranslate(array('s'=>'Export Sample Data','mod'=>'leotempcp'),$_smarty_tpl);?>

                        </button>
                        <button class="button btn btn-danger" name="submitImport" data-confirm="<?php echo smartyTranslate(array('s'=>'Are you sure you want to restore data sample of template. You will lost all data of module','mod'=>'leotempcp'),$_smarty_tpl);?>
" id="module_form_submit_btn" type="submit">
                                 <?php echo smartyTranslate(array('s'=>'Restore Sample Data','mod'=>'leotempcp'),$_smarty_tpl);?>

                        </button>
                        <p class="help-block"><?php echo smartyTranslate(array('s'=>'Data Sample is only for theme developer','mod'=>'leotempcp'),$_smarty_tpl);?>
</p>
                    </div>
            </div>
            <div class="form-group">
                <div class="col-lg-9 col-lg-offset-3">
                    <div class="alert alert-info">
                        <?php echo smartyTranslate(array('s'=>'With restore function, you will lost all data of module in site for all shop','mod'=>'leotempcp'),$_smarty_tpl);?>

                        <hr>
                        <?php echo smartyTranslate(array('s'=>'You should back-up before do any thing','mod'=>'leotempcp'),$_smarty_tpl);?>

                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-9 col-lg-offset-3">
                    <button class="button btn btn-success" name="submitExportDBStruct" id="module_form_submit_btn" type="submit">
                            <?php echo smartyTranslate(array('s'=>'Export Data Struct','mod'=>'leotempcp'),$_smarty_tpl);?>

                    </button>
                    <p class="help-block"><?php echo smartyTranslate(array('s'=>'You can download file in modules/leotemcp/install. This function is only for theme developer','mod'=>'leotempcp'),$_smarty_tpl);?>
</p>
                </div>
            </div>
            <script type="text/javascript">
                $(".button-wrapper .button").click(function(){
                    hasCheckedE = 0;
                    $("[name='moduleList[]']").each(function(){
                        if($(this).is(":checked")){
                            hasCheckedE = 1;
                            return false;
                        }
                    });
                    if(!hasCheckedE){
                        alert("You have to select atleast one module");
                        return false;
                    }
                    dataConfirm = $(this).attr("data-confirm");
                    if(dataConfirm){
                        return confirm(dataConfirm);
                    }
                });
            </script>
	<?php }?>
	
								<div class="col-lg-<?php if (isset($_smarty_tpl->tpl_vars['input']->value['col'])) {?><?php echo intval($_smarty_tpl->tpl_vars['input']->value['col']);?>
<?php } else { ?>9<?php }?><?php if (!isset($_smarty_tpl->tpl_vars['input']->value['label'])) {?> col-lg-offset-3<?php }?>">
								
								<?php if ($_smarty_tpl->tpl_vars['input']->value['type']=='text'||$_smarty_tpl->tpl_vars['input']->value['type']=='tags') {?>
									<?php if (isset($_smarty_tpl->tpl_vars['input']->value['lang'])&&$_smarty_tpl->tpl_vars['input']->value['lang']) {?>
									<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>
									<div class="form-group">
									<?php }?>
									<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
										<?php $_smarty_tpl->tpl_vars['value_text'] = new Smarty_variable($_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']][$_smarty_tpl->tpl_vars['language']->value['id_lang']], null, 0);?>
										<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>
										<div class="translatable-field lang-<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
" <?php if ($_smarty_tpl->tpl_vars['language']->value['id_lang']!=$_smarty_tpl->tpl_vars['defaultFormLanguage']->value) {?>style="display:none"<?php }?>>
											<div class="col-lg-9">
										<?php }?>
												<?php if ($_smarty_tpl->tpl_vars['input']->value['type']=='tags') {?>
													
														<script type="text/javascript">
															$().ready(function () {
																var input_id = '<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
<?php }?>';
																$('#'+input_id).tagify({delimiters: [13,44], addTagPrompt: '<?php echo smartyTranslate(array('s'=>'Add tag','js'=>1),$_smarty_tpl);?>
'});
																$('#<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_form').submit( function() {
																	$(this).find('#'+input_id).val($('#'+input_id).tagify('serialize'));
																});
															});
														</script>
													
												<?php }?>
												<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])||isset($_smarty_tpl->tpl_vars['input']->value['prefix'])||isset($_smarty_tpl->tpl_vars['input']->value['suffix'])) {?>
												<div class="input-group<?php if (isset($_smarty_tpl->tpl_vars['input']->value['class'])) {?> <?php echo $_smarty_tpl->tpl_vars['input']->value['class'];?>
<?php }?>">
												<?php }?>
												<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])&&$_smarty_tpl->tpl_vars['input']->value['maxchar']) {?>
												<span id="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
<?php }?>_counter" class="input-group-addon">
													<span class="text-count-down"><?php echo intval($_smarty_tpl->tpl_vars['input']->value['maxchar']);?>
</span>
												</span>
												<?php }?>
												<?php if (isset($_smarty_tpl->tpl_vars['input']->value['prefix'])) {?>
													<span class="input-group-addon">
													  <?php echo $_smarty_tpl->tpl_vars['input']->value['prefix'];?>

													</span>
													<?php }?>
												<input type="text"
													id="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
<?php }?>"
													name="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
"
													class="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['class'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['class'];?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['input']->value['type']=='tags') {?> tagify<?php }?>"
													value="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['string_format'])&&$_smarty_tpl->tpl_vars['input']->value['string_format']) {?><?php echo htmlspecialchars(sprintf($_smarty_tpl->tpl_vars['input']->value['string_format'],$_smarty_tpl->tpl_vars['value_text']->value), ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value_text']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>"
													onkeyup="if (isArrowKey(event)) return ;updateFriendlyURL();"
													<?php if (isset($_smarty_tpl->tpl_vars['input']->value['size'])) {?> size="<?php echo $_smarty_tpl->tpl_vars['input']->value['size'];?>
"<?php }?>
													<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])&&$_smarty_tpl->tpl_vars['input']->value['maxchar']) {?> data-maxchar="<?php echo intval($_smarty_tpl->tpl_vars['input']->value['maxchar']);?>
"<?php }?>
													<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxlength'])&&$_smarty_tpl->tpl_vars['input']->value['maxlength']) {?> maxlength="<?php echo intval($_smarty_tpl->tpl_vars['input']->value['maxlength']);?>
"<?php }?>
													<?php if (isset($_smarty_tpl->tpl_vars['input']->value['readonly'])&&$_smarty_tpl->tpl_vars['input']->value['readonly']) {?> readonly="readonly"<?php }?>
													<?php if (isset($_smarty_tpl->tpl_vars['input']->value['disabled'])&&$_smarty_tpl->tpl_vars['input']->value['disabled']) {?> disabled="disabled"<?php }?>
													<?php if (isset($_smarty_tpl->tpl_vars['input']->value['autocomplete'])&&!$_smarty_tpl->tpl_vars['input']->value['autocomplete']) {?> autocomplete="off"<?php }?>
													<?php if (isset($_smarty_tpl->tpl_vars['input']->value['required'])&&$_smarty_tpl->tpl_vars['input']->value['required']) {?> required="required" <?php }?>
													<?php if (isset($_smarty_tpl->tpl_vars['input']->value['placeholder'])&&$_smarty_tpl->tpl_vars['input']->value['placeholder']) {?> placeholder="<?php echo $_smarty_tpl->tpl_vars['input']->value['placeholder'];?>
"<?php }?> />
													<?php if (isset($_smarty_tpl->tpl_vars['input']->value['suffix'])) {?>
													<span class="input-group-addon">
													  <?php echo $_smarty_tpl->tpl_vars['input']->value['suffix'];?>

													</span>
													<?php }?>
												<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])||isset($_smarty_tpl->tpl_vars['input']->value['prefix'])||isset($_smarty_tpl->tpl_vars['input']->value['suffix'])) {?>
												</div>
												<?php }?>
										<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>
											</div>
											<div class="col-lg-2">
												<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
													<?php echo $_smarty_tpl->tpl_vars['language']->value['iso_code'];?>

													<i class="icon-caret-down"></i>
												</button>
												<ul class="dropdown-menu">
													<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
													<li><a href="javascript:hideOtherLanguage(<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
);" tabindex="-1"><?php echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
</a></li>
													<?php } ?>
												</ul>
											</div>
										</div>
										<?php }?>
									<?php } ?>
									<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])&&$_smarty_tpl->tpl_vars['input']->value['maxchar']) {?>
									<script type="text/javascript">
									$(document).ready(function(){
									<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
										countDown($("#<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
<?php }?>"), $("#<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
<?php }?>_counter"));
									<?php } ?>
									});
									</script>
									<?php }?>
									<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>
									</div>
									<?php }?>
									<?php } else { ?>
										<?php if ($_smarty_tpl->tpl_vars['input']->value['type']=='tags') {?>
											
											<script type="text/javascript">
												$().ready(function () {
													var input_id = '<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
<?php }?>';
													$('#'+input_id).tagify({delimiters: [13,44], addTagPrompt: '<?php echo smartyTranslate(array('s'=>'Add tag'),$_smarty_tpl);?>
'});
													$('#<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_form').submit( function() {
														$(this).find('#'+input_id).val($('#'+input_id).tagify('serialize'));
													});
												});
											</script>
											
										<?php }?>
										<?php $_smarty_tpl->tpl_vars['value_text'] = new Smarty_variable($_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']], null, 0);?>
										<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])||isset($_smarty_tpl->tpl_vars['input']->value['prefix'])||isset($_smarty_tpl->tpl_vars['input']->value['suffix'])) {?>
										<div class="input-group<?php if (isset($_smarty_tpl->tpl_vars['input']->value['class'])) {?> <?php echo $_smarty_tpl->tpl_vars['input']->value['class'];?>
<?php }?>">
										<?php }?>
										<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])&&$_smarty_tpl->tpl_vars['input']->value['maxchar']) {?>
										<span id="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
<?php }?>_counter" class="input-group-addon"><span class="text-count-down"><?php echo intval($_smarty_tpl->tpl_vars['input']->value['maxchar']);?>
</span></span>
										<?php }?>
										<?php if (isset($_smarty_tpl->tpl_vars['input']->value['prefix'])) {?>
										<span class="input-group-addon">
										  <?php echo $_smarty_tpl->tpl_vars['input']->value['prefix'];?>

										</span>
										<?php }?>
										<input type="text"
											name="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
"
											id="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
<?php }?>"
											value="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['string_format'])&&$_smarty_tpl->tpl_vars['input']->value['string_format']) {?><?php echo htmlspecialchars(sprintf($_smarty_tpl->tpl_vars['input']->value['string_format'],$_smarty_tpl->tpl_vars['value_text']->value), ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value_text']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>"
											class="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['class'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['class'];?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['input']->value['type']=='tags') {?> tagify<?php }?>"
											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['size'])) {?> size="<?php echo $_smarty_tpl->tpl_vars['input']->value['size'];?>
"<?php }?>
											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])&&$_smarty_tpl->tpl_vars['input']->value['maxchar']) {?> data-maxchar="<?php echo intval($_smarty_tpl->tpl_vars['input']->value['maxchar']);?>
"<?php }?>
											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxlength'])&&$_smarty_tpl->tpl_vars['input']->value['maxlength']) {?> maxlength="<?php echo intval($_smarty_tpl->tpl_vars['input']->value['maxlength']);?>
"<?php }?>
											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['readonly'])&&$_smarty_tpl->tpl_vars['input']->value['readonly']) {?> readonly="readonly"<?php }?>
											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['disabled'])&&$_smarty_tpl->tpl_vars['input']->value['disabled']) {?> disabled="disabled"<?php }?>
											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['autocomplete'])&&!$_smarty_tpl->tpl_vars['input']->value['autocomplete']) {?> autocomplete="off"<?php }?>
											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['required'])&&$_smarty_tpl->tpl_vars['input']->value['required']) {?> required="required" <?php }?>
											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['placeholder'])&&$_smarty_tpl->tpl_vars['input']->value['placeholder']) {?> placeholder="<?php echo $_smarty_tpl->tpl_vars['input']->value['placeholder'];?>
"<?php }?>
											/>
										<?php if (isset($_smarty_tpl->tpl_vars['input']->value['suffix'])) {?>
										<span class="input-group-addon">
										  <?php echo $_smarty_tpl->tpl_vars['input']->value['suffix'];?>

										</span>
										<?php }?>

										<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])||isset($_smarty_tpl->tpl_vars['input']->value['prefix'])||isset($_smarty_tpl->tpl_vars['input']->value['suffix'])) {?>
										</div>
										<?php }?>
										<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])&&$_smarty_tpl->tpl_vars['input']->value['maxchar']) {?>
										<script type="text/javascript">
										$(document).ready(function(){
											countDown($("#<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
<?php }?>"), $("#<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
<?php }?>_counter"));
										});
										</script>
										<?php }?>
									<?php }?>
								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='textbutton') {?>
									<?php $_smarty_tpl->tpl_vars['value_text'] = new Smarty_variable($_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']], null, 0);?>
									<div class="row">
										<div class="col-lg-9">
										<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])) {?>
										<div class="input-group">
											<span id="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
<?php }?>_counter" class="input-group-addon">
												<span class="text-count-down"><?php echo intval($_smarty_tpl->tpl_vars['input']->value['maxchar']);?>
</span>
											</span>
										<?php }?>
										<input type="text"
											name="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
"
											id="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
<?php }?>"
											value="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['string_format'])&&$_smarty_tpl->tpl_vars['input']->value['string_format']) {?><?php echo htmlspecialchars(sprintf($_smarty_tpl->tpl_vars['input']->value['string_format'],$_smarty_tpl->tpl_vars['value_text']->value), ENT_QUOTES, 'UTF-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value_text']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>"
											class="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['class'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['class'];?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['input']->value['type']=='tags') {?> tagify<?php }?>"
											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['size'])) {?> size="<?php echo $_smarty_tpl->tpl_vars['input']->value['size'];?>
"<?php }?>
											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])&&$_smarty_tpl->tpl_vars['input']->value['maxchar']) {?> data-maxchar="<?php echo intval($_smarty_tpl->tpl_vars['input']->value['maxchar']);?>
"<?php }?>
											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxlength'])&&$_smarty_tpl->tpl_vars['input']->value['maxlength']) {?> maxlength="<?php echo intval($_smarty_tpl->tpl_vars['input']->value['maxlength']);?>
"<?php }?>
											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['readonly'])&&$_smarty_tpl->tpl_vars['input']->value['readonly']) {?> readonly="readonly"<?php }?>
											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['disabled'])&&$_smarty_tpl->tpl_vars['input']->value['disabled']) {?> disabled="disabled"<?php }?>
											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['autocomplete'])&&!$_smarty_tpl->tpl_vars['input']->value['autocomplete']) {?> autocomplete="off"<?php }?>
											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['placeholder'])&&$_smarty_tpl->tpl_vars['input']->value['placeholder']) {?> placeholder="<?php echo $_smarty_tpl->tpl_vars['input']->value['placeholder'];?>
"<?php }?>
											/>
										<?php if (isset($_smarty_tpl->tpl_vars['input']->value['suffix'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['suffix'];?>
<?php }?>
										<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])&&$_smarty_tpl->tpl_vars['input']->value['maxchar']) {?>
										</div>
										<?php }?>
										</div>
										<div class="col-lg-2">
											<button type="button" class="btn btn-default<?php if (isset($_smarty_tpl->tpl_vars['input']->value['button']['attributes']['class'])) {?> <?php echo $_smarty_tpl->tpl_vars['input']->value['button']['attributes']['class'];?>
<?php }?><?php if (isset($_smarty_tpl->tpl_vars['input']->value['button']['class'])) {?> <?php echo $_smarty_tpl->tpl_vars['input']->value['button']['class'];?>
<?php }?>"
												<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['input']->value['button']['attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
													<?php if (mb_strtolower($_smarty_tpl->tpl_vars['name']->value, 'UTF-8')!='class') {?>
													 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8', true);?>
="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value, ENT_QUOTES, 'UTF-8', true);?>
"
													<?php }?>
												<?php } ?> >
												<?php echo $_smarty_tpl->tpl_vars['input']->value['button']['label'];?>

											</button>
										</div>
									</div>
									<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])&&$_smarty_tpl->tpl_vars['input']->value['maxchar']) {?>
									<script type="text/javascript">
										$(document).ready(function() {
											countDown($("#<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
<?php }?>"), $("#<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
<?php }?>_counter"));
										});
									</script>
									<?php }?>
								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='swap') {?>
									<div class="form-group">
										<div class="col-lg-9">
											<div class="form-control-static row">
												<div class="col-xs-6">
													<select <?php if (isset($_smarty_tpl->tpl_vars['input']->value['size'])) {?>size="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['size'], ENT_QUOTES, 'utf-8', true);?>
"<?php }?><?php if (isset($_smarty_tpl->tpl_vars['input']->value['onchange'])) {?> onchange="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['onchange'], ENT_QUOTES, 'utf-8', true);?>
"<?php }?> class="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['class'])) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['class'], ENT_QUOTES, 'utf-8', true);?>
<?php }?>" id="availableSwap" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['name'], ENT_QUOTES, 'utf-8', true);?>
_available[]" multiple="multiple">
													<?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['input']->value['options']['query']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value) {
$_smarty_tpl->tpl_vars['option']->_loop = true;
?>
														<?php if (is_object($_smarty_tpl->tpl_vars['option']->value)) {?>
															<?php if (!in_array($_smarty_tpl->tpl_vars['option']->value->{$_smarty_tpl->tpl_vars['input']->value['options']['id']},$_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']])) {?>
																<option value="<?php echo $_smarty_tpl->tpl_vars['option']->value->{$_smarty_tpl->tpl_vars['input']->value['options']['id']};?>
"><?php echo $_smarty_tpl->tpl_vars['option']->value->{$_smarty_tpl->tpl_vars['input']->value['options']['name']};?>
</option>
															<?php }?>
														<?php } elseif ($_smarty_tpl->tpl_vars['option']->value=="-") {?>
															<option value="">-</option>
														<?php } else { ?>
															<?php if (!in_array($_smarty_tpl->tpl_vars['option']->value[$_smarty_tpl->tpl_vars['input']->value['options']['id']],$_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']])) {?>
																<option value="<?php echo $_smarty_tpl->tpl_vars['option']->value[$_smarty_tpl->tpl_vars['input']->value['options']['id']];?>
"><?php echo $_smarty_tpl->tpl_vars['option']->value[$_smarty_tpl->tpl_vars['input']->value['options']['name']];?>
</option>
															<?php }?>
														<?php }?>
													<?php } ?>
													</select>
													<a href="#" id="addSwap" class="btn btn-default btn-block"><?php echo smartyTranslate(array('s'=>'Add'),$_smarty_tpl);?>
 <i class="icon-arrow-right"></i></a>
												</div>
												<div class="col-xs-6">
													<select <?php if (isset($_smarty_tpl->tpl_vars['input']->value['size'])) {?>size="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['size'], ENT_QUOTES, 'utf-8', true);?>
"<?php }?><?php if (isset($_smarty_tpl->tpl_vars['input']->value['onchange'])) {?> onchange="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['onchange'], ENT_QUOTES, 'utf-8', true);?>
"<?php }?> class="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['class'])) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['class'], ENT_QUOTES, 'utf-8', true);?>
<?php }?>" id="selectedSwap" name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['name'], ENT_QUOTES, 'utf-8', true);?>
_selected[]" multiple="multiple">
													<?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['input']->value['options']['query']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value) {
$_smarty_tpl->tpl_vars['option']->_loop = true;
?>
														<?php if (is_object($_smarty_tpl->tpl_vars['option']->value)) {?>
															<?php if (in_array($_smarty_tpl->tpl_vars['option']->value->{$_smarty_tpl->tpl_vars['input']->value['options']['id']},$_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']])) {?>
																<option value="<?php echo $_smarty_tpl->tpl_vars['option']->value->{$_smarty_tpl->tpl_vars['input']->value['options']['id']};?>
"><?php echo $_smarty_tpl->tpl_vars['option']->value->{$_smarty_tpl->tpl_vars['input']->value['options']['name']};?>
</option>
															<?php }?>
														<?php } elseif ($_smarty_tpl->tpl_vars['option']->value=="-") {?>
															<option value="">-</option>
														<?php } else { ?>
															<?php if (in_array($_smarty_tpl->tpl_vars['option']->value[$_smarty_tpl->tpl_vars['input']->value['options']['id']],$_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']])) {?>
																<option value="<?php echo $_smarty_tpl->tpl_vars['option']->value[$_smarty_tpl->tpl_vars['input']->value['options']['id']];?>
"><?php echo $_smarty_tpl->tpl_vars['option']->value[$_smarty_tpl->tpl_vars['input']->value['options']['name']];?>
</option>
															<?php }?>
														<?php }?>
													<?php } ?>
													</select>
													<a href="#" id="removeSwap" class="btn btn-default btn-block"><i class="icon-arrow-left"></i> <?php echo smartyTranslate(array('s'=>'Remove'),$_smarty_tpl);?>
</a>
												</div>
											</div>
										</div>
									</div>
								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='select') {?>
									<?php if (isset($_smarty_tpl->tpl_vars['input']->value['options']['query'])&&!$_smarty_tpl->tpl_vars['input']->value['options']['query']&&isset($_smarty_tpl->tpl_vars['input']->value['empty_message'])) {?>
										<?php echo $_smarty_tpl->tpl_vars['input']->value['empty_message'];?>

										<?php $_smarty_tpl->createLocalArrayVariable('input', null, 0);
$_smarty_tpl->tpl_vars['input']->value['required'] = false;?>
										<?php $_smarty_tpl->createLocalArrayVariable('input', null, 0);
$_smarty_tpl->tpl_vars['input']->value['desc'] = null;?>
									<?php } else { ?>
										<select name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['name'], ENT_QUOTES, 'utf-8', true);?>
"
												class="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['class'])) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['class'], ENT_QUOTES, 'utf-8', true);?>
<?php }?> fixed-width-xl"
												id="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['id'], ENT_QUOTES, 'utf-8', true);?>
<?php } else { ?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['name'], ENT_QUOTES, 'utf-8', true);?>
<?php }?>"
												<?php if (isset($_smarty_tpl->tpl_vars['input']->value['multiple'])&&$_smarty_tpl->tpl_vars['input']->value['multiple']) {?> multiple="multiple"<?php }?>
												<?php if (isset($_smarty_tpl->tpl_vars['input']->value['size'])) {?> size="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['size'], ENT_QUOTES, 'utf-8', true);?>
"<?php }?>
												<?php if (isset($_smarty_tpl->tpl_vars['input']->value['onchange'])) {?> onchange="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['onchange'], ENT_QUOTES, 'utf-8', true);?>
"<?php }?>
												<?php if (isset($_smarty_tpl->tpl_vars['input']->value['disabled'])&&$_smarty_tpl->tpl_vars['input']->value['disabled']) {?> disabled="disabled"<?php }?>>
											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['options']['default'])) {?>
												<option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['options']['default']['value'], ENT_QUOTES, 'utf-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['input']->value['options']['default']['label'], ENT_QUOTES, 'utf-8', true);?>
</option>
											<?php }?>
											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['options']['optiongroup'])) {?>
												<?php  $_smarty_tpl->tpl_vars['optiongroup'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['optiongroup']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['input']->value['options']['optiongroup']['query']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['optiongroup']->key => $_smarty_tpl->tpl_vars['optiongroup']->value) {
$_smarty_tpl->tpl_vars['optiongroup']->_loop = true;
?>
													<optgroup label="<?php echo $_smarty_tpl->tpl_vars['optiongroup']->value[$_smarty_tpl->tpl_vars['input']->value['options']['optiongroup']['label']];?>
">
														<?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['optiongroup']->value[$_smarty_tpl->tpl_vars['input']->value['options']['options']['query']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value) {
$_smarty_tpl->tpl_vars['option']->_loop = true;
?>
															<option value="<?php echo $_smarty_tpl->tpl_vars['option']->value[$_smarty_tpl->tpl_vars['input']->value['options']['options']['id']];?>
"
																<?php if (isset($_smarty_tpl->tpl_vars['input']->value['multiple'])) {?>
																	<?php  $_smarty_tpl->tpl_vars['field_value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field_value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field_value']->key => $_smarty_tpl->tpl_vars['field_value']->value) {
$_smarty_tpl->tpl_vars['field_value']->_loop = true;
?>
																		<?php if ($_smarty_tpl->tpl_vars['field_value']->value==$_smarty_tpl->tpl_vars['option']->value[$_smarty_tpl->tpl_vars['input']->value['options']['options']['id']]) {?>selected="selected"<?php }?>
																	<?php } ?>
																<?php } else { ?>
																	<?php if ($_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']]==$_smarty_tpl->tpl_vars['option']->value[$_smarty_tpl->tpl_vars['input']->value['options']['options']['id']]) {?>selected="selected"<?php }?>
																<?php }?>
															><?php echo $_smarty_tpl->tpl_vars['option']->value[$_smarty_tpl->tpl_vars['input']->value['options']['options']['name']];?>
</option>
														<?php } ?>
													</optgroup>
												<?php } ?>
											<?php } else { ?>
												<?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['option']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['input']->value['options']['query']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value) {
$_smarty_tpl->tpl_vars['option']->_loop = true;
?>
													<?php if (is_object($_smarty_tpl->tpl_vars['option']->value)) {?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['option']->value->{$_smarty_tpl->tpl_vars['input']->value['options']['id']};?>
"
															<?php if (isset($_smarty_tpl->tpl_vars['input']->value['multiple'])) {?>
																<?php  $_smarty_tpl->tpl_vars['field_value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field_value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field_value']->key => $_smarty_tpl->tpl_vars['field_value']->value) {
$_smarty_tpl->tpl_vars['field_value']->_loop = true;
?>
																	<?php if ($_smarty_tpl->tpl_vars['field_value']->value==$_smarty_tpl->tpl_vars['option']->value->{$_smarty_tpl->tpl_vars['input']->value['options']['id']}) {?>
																		selected="selected"
																	<?php }?>
																<?php } ?>
															<?php } else { ?>
																<?php if ($_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']]==$_smarty_tpl->tpl_vars['option']->value->{$_smarty_tpl->tpl_vars['input']->value['options']['id']}) {?>
																	selected="selected"
																<?php }?>
															<?php }?>
														><?php echo $_smarty_tpl->tpl_vars['option']->value->{$_smarty_tpl->tpl_vars['input']->value['options']['name']};?>
</option>
													<?php } elseif ($_smarty_tpl->tpl_vars['option']->value=="-") {?>
														<option value="">-</option>
													<?php } else { ?>
														<option value="<?php echo $_smarty_tpl->tpl_vars['option']->value[$_smarty_tpl->tpl_vars['input']->value['options']['id']];?>
"
															<?php if (isset($_smarty_tpl->tpl_vars['input']->value['multiple'])) {?>
																<?php  $_smarty_tpl->tpl_vars['field_value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field_value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field_value']->key => $_smarty_tpl->tpl_vars['field_value']->value) {
$_smarty_tpl->tpl_vars['field_value']->_loop = true;
?>
																	<?php if ($_smarty_tpl->tpl_vars['field_value']->value==$_smarty_tpl->tpl_vars['option']->value[$_smarty_tpl->tpl_vars['input']->value['options']['id']]) {?>
																		selected="selected"
																	<?php }?>
																<?php } ?>
															<?php } else { ?>
																<?php if ($_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']]==$_smarty_tpl->tpl_vars['option']->value[$_smarty_tpl->tpl_vars['input']->value['options']['id']]) {?>
																	selected="selected"
																<?php }?>
															<?php }?>
														><?php echo $_smarty_tpl->tpl_vars['option']->value[$_smarty_tpl->tpl_vars['input']->value['options']['name']];?>
</option>

													<?php }?>
												<?php } ?>
											<?php }?>
										</select>
									<?php }?>
								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='radio') {?>
									<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['input']->value['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
										<div class="radio <?php if (isset($_smarty_tpl->tpl_vars['input']->value['class'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['class'];?>
<?php }?>">
											<label><input type="radio"	name="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
"<?php if ($_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']]==$_smarty_tpl->tpl_vars['value']->value['value']) {?> checked="checked"<?php }?><?php if (isset($_smarty_tpl->tpl_vars['input']->value['disabled'])&&$_smarty_tpl->tpl_vars['input']->value['disabled']) {?> disabled="disabled"<?php }?>/><?php echo $_smarty_tpl->tpl_vars['value']->value['label'];?>
</label>
										</div>
										<?php if (isset($_smarty_tpl->tpl_vars['value']->value['p'])&&$_smarty_tpl->tpl_vars['value']->value['p']) {?><p class="help-block"><?php echo $_smarty_tpl->tpl_vars['value']->value['p'];?>
</p><?php }?>
									<?php } ?>
								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='switch') {?>
									<span class="switch prestashop-switch fixed-width-lg">
										<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['input']->value['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
										<input type="radio" name="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
"<?php if ($_smarty_tpl->tpl_vars['value']->value['value']==1) {?> id="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_on"<?php } else { ?> id="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_off"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['value']->value['value'];?>
"<?php if ($_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']]==$_smarty_tpl->tpl_vars['value']->value['value']) {?> checked="checked"<?php }?><?php if (isset($_smarty_tpl->tpl_vars['input']->value['disabled'])&&$_smarty_tpl->tpl_vars['input']->value['disabled']) {?> disabled="disabled"<?php }?>/>
										<label <?php if ($_smarty_tpl->tpl_vars['value']->value['value']==1) {?> for="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_on"<?php } else { ?> for="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_off"<?php }?>><?php if ($_smarty_tpl->tpl_vars['value']->value['value']==1) {?><?php echo smartyTranslate(array('s'=>'Yes'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'No'),$_smarty_tpl);?>
<?php }?></label>
										<?php } ?>
										<a class="slide-button btn"></a>
									</span>
								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='textarea') {?>
									<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])&&$_smarty_tpl->tpl_vars['input']->value['maxchar']) {?><div class="input-group"><?php }?>
									<?php $_smarty_tpl->tpl_vars['use_textarea_autosize'] = new Smarty_variable(true, null, 0);?>
									<?php if (isset($_smarty_tpl->tpl_vars['input']->value['lang'])&&$_smarty_tpl->tpl_vars['input']->value['lang']) {?>
										<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
											<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>
											<div class="form-group translatable-field lang-<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
"<?php if ($_smarty_tpl->tpl_vars['language']->value['id_lang']!=$_smarty_tpl->tpl_vars['defaultFormLanguage']->value) {?> style="display:none;"<?php }?>>
												<div class="col-lg-9">
											<?php }?>
													<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])&&$_smarty_tpl->tpl_vars['input']->value['maxchar']) {?>
														<span id="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
<?php }?>_counter" class="input-group-addon">
															<span class="text-count-down"><?php echo intval($_smarty_tpl->tpl_vars['input']->value['maxchar']);?>
</span>
														</span>
													<?php }?>
													<textarea<?php if (isset($_smarty_tpl->tpl_vars['input']->value['readonly'])&&$_smarty_tpl->tpl_vars['input']->value['readonly']) {?> readonly="readonly"<?php }?> name="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
" id="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
<?php }?>_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
" class="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['autoload_rte'])&&$_smarty_tpl->tpl_vars['input']->value['autoload_rte']) {?>rte autoload_rte<?php } else { ?>textarea-autosize<?php }?><?php if (isset($_smarty_tpl->tpl_vars['input']->value['class'])) {?> <?php echo $_smarty_tpl->tpl_vars['input']->value['class'];?>
<?php }?>"<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxlength'])&&$_smarty_tpl->tpl_vars['input']->value['maxlength']) {?> maxlength="<?php echo intval($_smarty_tpl->tpl_vars['input']->value['maxlength']);?>
"<?php }?><?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])&&$_smarty_tpl->tpl_vars['input']->value['maxchar']) {?> data-maxchar="<?php echo intval($_smarty_tpl->tpl_vars['input']->value['maxchar']);?>
"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']][$_smarty_tpl->tpl_vars['language']->value['id_lang']], ENT_QUOTES, 'UTF-8', true);?>
</textarea>
											<?php if (count($_smarty_tpl->tpl_vars['languages']->value)>1) {?>
												</div>
												<div class="col-lg-2">
													<button type="button" class="btn btn-default dropdown-toggle" tabindex="-1" data-toggle="dropdown">
														<?php echo $_smarty_tpl->tpl_vars['language']->value['iso_code'];?>

														<span class="caret"></span>
													</button>
													<ul class="dropdown-menu">
														<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
														<li>
															<a href="javascript:hideOtherLanguage(<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
);" tabindex="-1"><?php echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
</a>
														</li>
														<?php } ?>
													</ul>
												</div>
											</div>
											<?php }?>
										<?php } ?>
										<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])&&$_smarty_tpl->tpl_vars['input']->value['maxchar']) {?>
											<script type="text/javascript">
											$(document).ready(function(){
											<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
?>
												countDown($("#<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
<?php }?>"), $("#<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
<?php }?>_counter"));
											<?php } ?>
											});
											</script>
										<?php }?>
									<?php } else { ?>
										<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])&&$_smarty_tpl->tpl_vars['input']->value['maxchar']) {?>
											<span id="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
_<?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
<?php }?>_counter" class="input-group-addon">
												<span class="text-count-down"><?php echo intval($_smarty_tpl->tpl_vars['input']->value['maxchar']);?>
</span>
											</span>
										<?php }?>
										<textarea<?php if (isset($_smarty_tpl->tpl_vars['input']->value['readonly'])&&$_smarty_tpl->tpl_vars['input']->value['readonly']) {?> readonly="readonly"<?php }?> name="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
" id="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
<?php }?>" <?php if (isset($_smarty_tpl->tpl_vars['input']->value['cols'])) {?>cols="<?php echo $_smarty_tpl->tpl_vars['input']->value['cols'];?>
"<?php }?> <?php if (isset($_smarty_tpl->tpl_vars['input']->value['rows'])) {?>rows="<?php echo $_smarty_tpl->tpl_vars['input']->value['rows'];?>
"<?php }?> class="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['autoload_rte'])&&$_smarty_tpl->tpl_vars['input']->value['autoload_rte']) {?>rte autoload_rte<?php } else { ?>textarea-autosize<?php }?><?php if (isset($_smarty_tpl->tpl_vars['input']->value['class'])) {?> <?php echo $_smarty_tpl->tpl_vars['input']->value['class'];?>
<?php }?>"<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxlength'])&&$_smarty_tpl->tpl_vars['input']->value['maxlength']) {?> maxlength="<?php echo intval($_smarty_tpl->tpl_vars['input']->value['maxlength']);?>
"<?php }?><?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])&&$_smarty_tpl->tpl_vars['input']->value['maxchar']) {?> data-maxchar="<?php echo intval($_smarty_tpl->tpl_vars['input']->value['maxchar']);?>
"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']], ENT_QUOTES, 'UTF-8', true);?>
</textarea>
										<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])&&$_smarty_tpl->tpl_vars['input']->value['maxchar']) {?>
											<script type="text/javascript">
											$(document).ready(function(){
												countDown($("#<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
<?php }?>"), $("#<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
<?php }?>_counter"));
											});
											</script>
										<?php }?>
									<?php }?>
									<?php if (isset($_smarty_tpl->tpl_vars['input']->value['maxchar'])&&$_smarty_tpl->tpl_vars['input']->value['maxchar']) {?></div><?php }?>
								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='checkbox') {?>
									<?php if (isset($_smarty_tpl->tpl_vars['input']->value['expand'])) {?>
										<a class="btn btn-default show_checkbox<?php if (strtolower($_smarty_tpl->tpl_vars['input']->value['expand']['default'])=='hide') {?> hidden<?php }?>" href="#">
											<i class="icon-<?php echo $_smarty_tpl->tpl_vars['input']->value['expand']['show']['icon'];?>
"></i>
											<?php echo $_smarty_tpl->tpl_vars['input']->value['expand']['show']['text'];?>

											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['expand']['print_total'])&&$_smarty_tpl->tpl_vars['input']->value['expand']['print_total']>0) {?>
												<span class="badge"><?php echo $_smarty_tpl->tpl_vars['input']->value['expand']['print_total'];?>
</span>
											<?php }?>
										</a>
										<a class="btn btn-default hide_checkbox<?php if (strtolower($_smarty_tpl->tpl_vars['input']->value['expand']['default'])=='show') {?> hidden<?php }?>" href="#">
											<i class="icon-<?php echo $_smarty_tpl->tpl_vars['input']->value['expand']['hide']['icon'];?>
"></i>
											<?php echo $_smarty_tpl->tpl_vars['input']->value['expand']['hide']['text'];?>

											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['expand']['print_total'])&&$_smarty_tpl->tpl_vars['input']->value['expand']['print_total']>0) {?>
												<span class="badge"><?php echo $_smarty_tpl->tpl_vars['input']->value['expand']['print_total'];?>
</span>
											<?php }?>
										</a>
									<?php }?>
									<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['input']->value['values']['query']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
										<?php $_smarty_tpl->tpl_vars['id_checkbox'] = new Smarty_variable((($_smarty_tpl->tpl_vars['input']->value['name']).('_')).($_smarty_tpl->tpl_vars['value']->value[$_smarty_tpl->tpl_vars['input']->value['values']['id']]), null, 0);?>
										<div class="checkbox<?php if (isset($_smarty_tpl->tpl_vars['input']->value['expand'])&&strtolower($_smarty_tpl->tpl_vars['input']->value['expand']['default'])=='show') {?> hidden<?php }?>">
											<label for="<?php echo $_smarty_tpl->tpl_vars['id_checkbox']->value;?>
"><input type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['id_checkbox']->value;?>
" id="<?php echo $_smarty_tpl->tpl_vars['id_checkbox']->value;?>
" class="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['class'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['class'];?>
<?php }?>"<?php if (isset($_smarty_tpl->tpl_vars['value']->value['val'])) {?> value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['value']->value['val'], ENT_QUOTES, 'UTF-8', true);?>
"<?php }?><?php if (isset($_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['id_checkbox']->value])&&$_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['id_checkbox']->value]) {?> checked="checked"<?php }?> /><?php echo $_smarty_tpl->tpl_vars['value']->value[$_smarty_tpl->tpl_vars['input']->value['values']['name']];?>
</label>
										</div>
									<?php } ?>
								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='change-password') {?>
									<div class="row">
										<div class="col-lg-12">
											<button type="button" id="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
-btn-change" class="btn btn-default">
												<i class="icon-lock"></i>
												<?php echo smartyTranslate(array('s'=>'Change password...'),$_smarty_tpl);?>

											</button>
											<div id="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
-change-container" class="form-password-change well hide">
												<div class="form-group">
													<label for="old_passwd" class="control-label col-lg-2 required">
														<?php echo smartyTranslate(array('s'=>'Current password'),$_smarty_tpl);?>

													</label>
													<div class="col-lg-10">
														<div class="input-group fixed-width-lg">
															<span class="input-group-addon">
																<i class="icon-unlock"></i>
															</span>
															<input type="password" id="old_passwd" name="old_passwd" class="form-control" value="" required="required" autocomplete="off">
														</div>
													</div>
												</div>
												<hr />
												<div class="form-group">
													<label for="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
" class="required control-label col-lg-2">
														<span class="label-tooltip" data-toggle="tooltip" data-html="true" title="" data-original-title="<?php echo smartyTranslate(array('s'=>'Password should be at least 8 characters long.'),$_smarty_tpl);?>
">
															<?php echo smartyTranslate(array('s'=>'New password'),$_smarty_tpl);?>

														</span>
													</label>
													<div class="col-lg-9">
														<div class="input-group fixed-width-lg">
															<span class="input-group-addon">
																<i class="icon-key"></i>
															</span>
															<input type="password" id="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
" class="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['class'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['class'];?>
<?php }?>" value="" required="required" autocomplete="off"/>
														</div>
														<span id="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
-output"></span>
													</div>
												</div>
												<div class="form-group">
													<label for="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
2" class="required control-label col-lg-2">
														<?php echo smartyTranslate(array('s'=>'Confirm password'),$_smarty_tpl);?>

													</label>
													<div class="col-lg-4">
														<div class="input-group fixed-width-lg">
															<span class="input-group-addon">
																<i class="icon-key"></i>
															</span>
															<input type="password" id="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
2" name="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
2" class="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['class'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['class'];?>
<?php }?>" value="" autocomplete="off"/>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-lg-10 col-lg-offset-2">
														<input type="text" class="form-control fixed-width-md pull-left" id="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
-generate-field" disabled="disabled">
														<button type="button" id="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
-generate-btn" class="btn btn-default">
															<i class="icon-random"></i>
															<?php echo smartyTranslate(array('s'=>'Generate password'),$_smarty_tpl);?>

														</button>
													</div>
												</div>
												<div class="form-group">
													<div class="col-lg-10 col-lg-offset-2">
														<p class="checkbox">
															<label for="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
-checkbox-mail">
																<input name="passwd_send_email" id="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
-checkbox-mail" type="checkbox" checked="checked">
																<?php echo smartyTranslate(array('s'=>'Send me this new password by Email'),$_smarty_tpl);?>

															</label>
														</p>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-12">
														<button type="button" id="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
-cancel-btn" class="btn btn-default">
															<i class="icon-remove"></i>
															<?php echo smartyTranslate(array('s'=>'Cancel'),$_smarty_tpl);?>

														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
									<script>
										$(function(){
											var $oldPwd = $('#old_passwd');
											var $passwordField = $('#<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
');
											var $output = $('#<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
-output');
											var $generateBtn = $('#<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
-generate-btn');
											var $generateField = $('#<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
-generate-field');
											var $cancelBtn = $('#<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
-cancel-btn');

											var feedback = [
												{ badge: 'text-danger', text: '<?php echo smartyTranslate(array('s'=>"Invalid",'js'=>1),$_smarty_tpl);?>
' },
												{ badge: 'text-warning', text: '<?php echo smartyTranslate(array('s'=>"Okay",'js'=>1),$_smarty_tpl);?>
' },
												{ badge: 'text-success', text: '<?php echo smartyTranslate(array('s'=>"Good",'js'=>1),$_smarty_tpl);?>
' },
												{ badge: 'text-success', text: '<?php echo smartyTranslate(array('s'=>"Fabulous",'js'=>1),$_smarty_tpl);?>
' }
											];
											$.passy.requirements.length.min = 8;
											$.passy.requirements.characters = 'DIGIT';
											$passwordField.passy(function(strength, valid) {
												$output.text(feedback[strength].text);
												$output.removeClass('text-danger').removeClass('text-warning').removeClass('text-success');
												$output.addClass(feedback[strength].badge);
												if (valid){
													$output.show();
												}
												else {
													$output.hide();
												}
											});
											var $container = $('#<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
-change-container');
											var $changeBtn = $('#<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
-btn-change');
											var $confirmPwd = $('#<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
2');

											$changeBtn.on('click',function(){
												$container.removeClass('hide');
												$changeBtn.addClass('hide');
											});
											$generateBtn.click(function() {
												$generateField.passy( 'generate', 8 );
												var generatedPassword = $generateField.val();
												$passwordField.val(generatedPassword);
												$confirmPwd.val(generatedPassword);
											});
											$cancelBtn.on('click',function() {
												$container.find("input").val("");
												$container.addClass('hide');
												$changeBtn.removeClass('hide');
											});

											$.validator.addMethod('password_same', function(value, element) {
												return $passwordField.val() == $confirmPwd.val();
											}, '<?php echo smartyTranslate(array('s'=>"Invalid password confirmation",'js'=>1),$_smarty_tpl);?>
');

											$('#employee_form').validate({
												rules: {
													"email": {
														email: true
													},
													"<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
" : {
														minlength: 8
													},
													"<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
2": {
														password_same: true
													},
													"old_passwd" : {},
												},
												// override jquery validate plugin defaults for bootstrap 3
												highlight: function(element) {
													$(element).closest('.form-group').addClass('has-error');
												},
												unhighlight: function(element) {
													$(element).closest('.form-group').removeClass('has-error');
												},
												errorElement: 'span',
												errorClass: 'help-block',
												errorPlacement: function(error, element) {
													if(element.parent('.input-group').length) {
														error.insertAfter(element.parent());
													} else {
														error.insertAfter(element);
													}
												}
											});
										});
									</script>
								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='password') {?>
									<div class="input-group fixed-width-lg">
										<span class="input-group-addon">
											<i class="icon-key"></i>
										</span>
										<input type="password"
											id="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
<?php }?>"
											name="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
"
											class="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['class'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['class'];?>
<?php }?>"
											value=""
											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['autocomplete'])&&!$_smarty_tpl->tpl_vars['input']->value['autocomplete']) {?>autocomplete="off"<?php }?>
											<?php if (isset($_smarty_tpl->tpl_vars['input']->value['required'])&&$_smarty_tpl->tpl_vars['input']->value['required']) {?> required="required" <?php }?> />
									</div>

								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='birthday') {?>
								<div class="form-group">
									<?php  $_smarty_tpl->tpl_vars['select'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['select']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['input']->value['options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['select']->key => $_smarty_tpl->tpl_vars['select']->value) {
$_smarty_tpl->tpl_vars['select']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['select']->key;
?>
									<div class="col-lg-2">
										<select name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" class="fixed-width-lg<?php if (isset($_smarty_tpl->tpl_vars['input']->value['class'])) {?> <?php echo $_smarty_tpl->tpl_vars['input']->value['class'];?>
<?php }?>">
											<option value="">-</option>
											<?php if ($_smarty_tpl->tpl_vars['key']->value=='months') {?>
												
												<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['select']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
													<option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['k']->value==$_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['key']->value]) {?>selected="selected"<?php }?>><?php echo smartyTranslate(array('s'=>$_smarty_tpl->tpl_vars['v']->value),$_smarty_tpl);?>
</option>
												<?php } ?>
											<?php } else { ?>
												<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['select']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
													<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['v']->value==$_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['key']->value]) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
												<?php } ?>
											<?php }?>
										</select>
									</div>
									<?php } ?>
								</div>
								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='group') {?>
									<?php $_smarty_tpl->tpl_vars['groups'] = new Smarty_variable($_smarty_tpl->tpl_vars['input']->value['values'], null, 0);?>
									<?php /*  Call merged included template "helpers/form/form_group.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('helpers/form/form_group.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '152824410962e3ba439bfed9-03126249');
content_62e3ba43d16c50_19115185($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "helpers/form/form_group.tpl" */?>
								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='shop') {?>
									<?php echo $_smarty_tpl->tpl_vars['input']->value['html'];?>

								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='categories') {?>
									<?php echo $_smarty_tpl->tpl_vars['categories_tree']->value;?>

								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='file') {?>
									<?php echo $_smarty_tpl->tpl_vars['input']->value['file'];?>

								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='categories_select') {?>
									<?php echo $_smarty_tpl->tpl_vars['input']->value['category_tree'];?>

								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='asso_shop'&&isset($_smarty_tpl->tpl_vars['asso_shop']->value)&&$_smarty_tpl->tpl_vars['asso_shop']->value) {?>
									<?php echo $_smarty_tpl->tpl_vars['asso_shop']->value;?>

								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='color') {?>
								<div class="form-group">
									<div class="col-lg-2">
										<div class="row">
											<div class="input-group">
												<input type="color"
												data-hex="true"
												<?php if (isset($_smarty_tpl->tpl_vars['input']->value['class'])) {?> class="<?php echo $_smarty_tpl->tpl_vars['input']->value['class'];?>
"
												<?php } else { ?> class="color mColorPickerInput"<?php }?>
												name="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
"
												value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']], ENT_QUOTES, 'UTF-8', true);?>
" />
											</div>
										</div>
									</div>
								</div>
								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='date') {?>
									<div class="row">
										<div class="input-group col-lg-4">
											<input
												id="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
<?php }?>"
												type="text"
												data-hex="true"
												<?php if (isset($_smarty_tpl->tpl_vars['input']->value['class'])) {?> class="<?php echo $_smarty_tpl->tpl_vars['input']->value['class'];?>
"
												<?php } else { ?>class="datepicker"<?php }?>
												name="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
"
												value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']], ENT_QUOTES, 'UTF-8', true);?>
" />
											<span class="input-group-addon">
												<i class="icon-calendar-empty"></i>
											</span>
										</div>
									</div>
								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='datetime') {?>
									<div class="row">
										<div class="input-group col-lg-4">
											<input
												id="<?php if (isset($_smarty_tpl->tpl_vars['input']->value['id'])) {?><?php echo $_smarty_tpl->tpl_vars['input']->value['id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
<?php }?>"
												type="text"
												data-hex="true"
												<?php if (isset($_smarty_tpl->tpl_vars['input']->value['class'])) {?> class="<?php echo $_smarty_tpl->tpl_vars['input']->value['class'];?>
"
												<?php } else { ?> class="datetimepicker"<?php }?>
												name="<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>
"
												value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']], ENT_QUOTES, 'UTF-8', true);?>
" />
											<span class="input-group-addon">
												<i class="icon-calendar-empty"></i>
											</span>
										</div>
									</div>
								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='free') {?>
									<?php echo $_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['input']->value['name']];?>

								<?php } elseif ($_smarty_tpl->tpl_vars['input']->value['type']=='html') {?>
									<?php if (isset($_smarty_tpl->tpl_vars['input']->value['html_content'])) {?>
										<?php echo $_smarty_tpl->tpl_vars['input']->value['html_content'];?>

									<?php } else { ?>
										<?php echo $_smarty_tpl->tpl_vars['input']->value['name'];?>

									<?php }?>
								<?php }?>
								
								
									<?php if (isset($_smarty_tpl->tpl_vars['input']->value['desc'])&&!empty($_smarty_tpl->tpl_vars['input']->value['desc'])) {?>
										<p class="help-block">
											<?php if (is_array($_smarty_tpl->tpl_vars['input']->value['desc'])) {?>
												<?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['input']->value['desc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value) {
$_smarty_tpl->tpl_vars['p']->_loop = true;
?>
													<?php if (is_array($_smarty_tpl->tpl_vars['p']->value)) {?>
														<span id="<?php echo $_smarty_tpl->tpl_vars['p']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['p']->value['text'];?>
</span><br />
													<?php } else { ?>
														<?php echo $_smarty_tpl->tpl_vars['p']->value;?>
<br />
													<?php }?>
												<?php } ?>
											<?php } else { ?>
												<?php echo $_smarty_tpl->tpl_vars['input']->value['desc'];?>

											<?php }?>
										</p>
									<?php }?>
								
								</div>
							

						<?php }?>
						</div>
						
					<?php } ?>
					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'displayAdminForm','fieldset'=>$_smarty_tpl->tpl_vars['f']->value),$_smarty_tpl);?>

					<?php if (isset($_smarty_tpl->tpl_vars['name_controller']->value)) {?>
						<?php $_smarty_tpl->_capture_stack[0][] = array('hookName', 'hookName', null); ob_start(); ?>display<?php echo ucfirst($_smarty_tpl->tpl_vars['name_controller']->value);?>
Form<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
						<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>$_smarty_tpl->tpl_vars['hookName']->value,'fieldset'=>$_smarty_tpl->tpl_vars['f']->value),$_smarty_tpl);?>

					<?php } elseif (isset($_GET['controller'])) {?>
						<?php $_smarty_tpl->_capture_stack[0][] = array('hookName', 'hookName', null); ob_start(); ?>display<?php echo htmlentities(ucfirst($_GET['controller']));?>
Form<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
						<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>$_smarty_tpl->tpl_vars['hookName']->value,'fieldset'=>$_smarty_tpl->tpl_vars['f']->value),$_smarty_tpl);?>

					<?php }?>
				</div><!-- /.form-wrapper -->
				<?php } elseif ($_smarty_tpl->tpl_vars['key']->value=='desc') {?>
					<div class="alert alert-info col-lg-offset-3">
						<?php if (is_array($_smarty_tpl->tpl_vars['field']->value)) {?>
							<?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['field']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value) {
$_smarty_tpl->tpl_vars['p']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['p']->key;
?>
								<?php if (is_array($_smarty_tpl->tpl_vars['p']->value)) {?>
									<span<?php if (isset($_smarty_tpl->tpl_vars['p']->value['id'])) {?> id="<?php echo $_smarty_tpl->tpl_vars['p']->value['id'];?>
"<?php }?>><?php echo $_smarty_tpl->tpl_vars['p']->value['text'];?>
</span><br />
								<?php } else { ?>
									<?php echo $_smarty_tpl->tpl_vars['p']->value;?>

									<?php if (isset($_smarty_tpl->tpl_vars['field']->value[$_smarty_tpl->tpl_vars['k']->value+1])) {?><br /><?php }?>
								<?php }?>
							<?php } ?>
						<?php } else { ?>
							<?php echo $_smarty_tpl->tpl_vars['field']->value;?>

						<?php }?>
					</div>
				<?php }?>
				
			<?php } ?>
			
			<?php $_smarty_tpl->_capture_stack[0][] = array('form_submit_btn', null, null); ob_start(); ?><?php echo smarty_function_counter(array('name'=>'form_submit_btn'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
				<?php if (isset($_smarty_tpl->tpl_vars['fieldset']->value['form']['submit'])||isset($_smarty_tpl->tpl_vars['fieldset']->value['form']['buttons'])) {?>
					<div class="panel-footer">
						<?php if (isset($_smarty_tpl->tpl_vars['fieldset']->value['form']['submit'])&&!empty($_smarty_tpl->tpl_vars['fieldset']->value['form']['submit'])) {?>
						<button type="submit" value="1"	id="<?php if (isset($_smarty_tpl->tpl_vars['fieldset']->value['form']['submit']['id'])) {?><?php echo $_smarty_tpl->tpl_vars['fieldset']->value['form']['submit']['id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_form_submit_btn<?php }?><?php if (Smarty::$_smarty_vars['capture']['form_submit_btn']>1) {?>_<?php echo intval((Smarty::$_smarty_vars['capture']['form_submit_btn']-1));?>
<?php }?>" name="<?php if (isset($_smarty_tpl->tpl_vars['fieldset']->value['form']['submit']['name'])) {?><?php echo $_smarty_tpl->tpl_vars['fieldset']->value['form']['submit']['name'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['submit_action']->value;?>
<?php }?><?php if (isset($_smarty_tpl->tpl_vars['fieldset']->value['form']['submit']['stay'])&&$_smarty_tpl->tpl_vars['fieldset']->value['form']['submit']['stay']) {?>AndStay<?php }?>" class="<?php if (isset($_smarty_tpl->tpl_vars['fieldset']->value['form']['submit']['class'])) {?><?php echo $_smarty_tpl->tpl_vars['fieldset']->value['form']['submit']['class'];?>
<?php } else { ?>btn btn-default pull-right<?php }?>">
							<i class="<?php if (isset($_smarty_tpl->tpl_vars['fieldset']->value['form']['submit']['icon'])) {?><?php echo $_smarty_tpl->tpl_vars['fieldset']->value['form']['submit']['icon'];?>
<?php } else { ?>process-icon-save<?php }?>"></i> <?php echo $_smarty_tpl->tpl_vars['fieldset']->value['form']['submit']['title'];?>

						</button>
						<?php }?>
						<?php if (isset($_smarty_tpl->tpl_vars['show_cancel_button']->value)&&$_smarty_tpl->tpl_vars['show_cancel_button']->value) {?>
						<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['back_url']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="btn btn-default" onclick="window.history.back();">
							<i class="process-icon-cancel"></i> <?php echo smartyTranslate(array('s'=>'Cancel'),$_smarty_tpl);?>

						</a>
						<?php }?>
						<?php if (isset($_smarty_tpl->tpl_vars['fieldset']->value['form']['reset'])) {?>
						<button
							type="reset"
							id="<?php if (isset($_smarty_tpl->tpl_vars['fieldset']->value['form']['reset']['id'])) {?><?php echo $_smarty_tpl->tpl_vars['fieldset']->value['form']['reset']['id'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['table']->value;?>
_form_reset_btn<?php }?>"
							class="<?php if (isset($_smarty_tpl->tpl_vars['fieldset']->value['form']['reset']['class'])) {?><?php echo $_smarty_tpl->tpl_vars['fieldset']->value['form']['reset']['class'];?>
<?php } else { ?>btn btn-default<?php }?>"
							>
							<?php if (isset($_smarty_tpl->tpl_vars['fieldset']->value['form']['reset']['icon'])) {?><i class="<?php echo $_smarty_tpl->tpl_vars['fieldset']->value['form']['reset']['icon'];?>
"></i> <?php }?> <?php echo $_smarty_tpl->tpl_vars['fieldset']->value['form']['reset']['title'];?>

						</button>
						<?php }?>
						<?php if (isset($_smarty_tpl->tpl_vars['fieldset']->value['form']['buttons'])) {?>
						<?php  $_smarty_tpl->tpl_vars['btn'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['btn']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['fieldset']->value['form']['buttons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['btn']->key => $_smarty_tpl->tpl_vars['btn']->value) {
$_smarty_tpl->tpl_vars['btn']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['btn']->key;
?>
							<?php if (isset($_smarty_tpl->tpl_vars['btn']->value['href'])&&trim($_smarty_tpl->tpl_vars['btn']->value['href'])!='') {?>
								<a href="<?php echo $_smarty_tpl->tpl_vars['btn']->value['href'];?>
" <?php if (isset($_smarty_tpl->tpl_vars['btn']->value['id'])) {?>id="<?php echo $_smarty_tpl->tpl_vars['btn']->value['id'];?>
"<?php }?> class="btn btn-default<?php if (isset($_smarty_tpl->tpl_vars['btn']->value['class'])) {?> <?php echo $_smarty_tpl->tpl_vars['btn']->value['class'];?>
<?php }?>" <?php if (isset($_smarty_tpl->tpl_vars['btn']->value['js'])&&$_smarty_tpl->tpl_vars['btn']->value['js']) {?> onclick="<?php echo $_smarty_tpl->tpl_vars['btn']->value['js'];?>
"<?php }?>><?php if (isset($_smarty_tpl->tpl_vars['btn']->value['icon'])) {?><i class="<?php echo $_smarty_tpl->tpl_vars['btn']->value['icon'];?>
" ></i> <?php }?><?php echo $_smarty_tpl->tpl_vars['btn']->value['title'];?>
</a>
							<?php } else { ?>
								<button type="<?php if (isset($_smarty_tpl->tpl_vars['btn']->value['type'])) {?><?php echo $_smarty_tpl->tpl_vars['btn']->value['type'];?>
<?php } else { ?>button<?php }?>" <?php if (isset($_smarty_tpl->tpl_vars['btn']->value['id'])) {?>id="<?php echo $_smarty_tpl->tpl_vars['btn']->value['id'];?>
"<?php }?> class="btn btn-default<?php if (isset($_smarty_tpl->tpl_vars['btn']->value['class'])) {?> <?php echo $_smarty_tpl->tpl_vars['btn']->value['class'];?>
<?php }?>" name="<?php if (isset($_smarty_tpl->tpl_vars['btn']->value['name'])) {?><?php echo $_smarty_tpl->tpl_vars['btn']->value['name'];?>
<?php } else { ?>submitOptions<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
<?php }?>"<?php if (isset($_smarty_tpl->tpl_vars['btn']->value['js'])&&$_smarty_tpl->tpl_vars['btn']->value['js']) {?> onclick="<?php echo $_smarty_tpl->tpl_vars['btn']->value['js'];?>
"<?php }?>><?php if (isset($_smarty_tpl->tpl_vars['btn']->value['icon'])) {?><i class="<?php echo $_smarty_tpl->tpl_vars['btn']->value['icon'];?>
" ></i> <?php }?><?php echo $_smarty_tpl->tpl_vars['btn']->value['title'];?>
</button>
							<?php }?>
						<?php } ?>
						<?php }?>
					</div>
				<?php }?>
			
		</div>
		
		
	<?php } ?>
</form>



<?php if (isset($_smarty_tpl->tpl_vars['tinymce']->value)&&$_smarty_tpl->tpl_vars['tinymce']->value) {?>
<script type="text/javascript">
	var iso = '<?php echo addslashes($_smarty_tpl->tpl_vars['iso']->value);?>
';
	var pathCSS = '<?php echo addslashes(@constant('_THEME_CSS_DIR_'));?>
';
	var ad = '<?php echo addslashes($_smarty_tpl->tpl_vars['ad']->value);?>
';

	$(document).ready(function(){
		
			tinySetup({
				editor_selector :"autoload_rte"
			});
		
	});
</script>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['firstCall']->value) {?>
	<script type="text/javascript">
		var module_dir = '<?php echo @constant('_MODULE_DIR_');?>
';
		var id_language = <?php echo intval($_smarty_tpl->tpl_vars['defaultFormLanguage']->value);?>
;
		var languages = new Array();
		var vat_number = <?php if ($_smarty_tpl->tpl_vars['vat_number']->value) {?>1<?php } else { ?>0<?php }?>;
		// Multilang field setup must happen before document is ready so that calls to displayFlags() to avoid
		// precedence conflicts with other document.ready() blocks
		<?php  $_smarty_tpl->tpl_vars['language'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['language']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['language']->key => $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['language']->key;
?>
			languages[<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
] = {
				id_lang: <?php echo $_smarty_tpl->tpl_vars['language']->value['id_lang'];?>
,
				iso_code: '<?php echo $_smarty_tpl->tpl_vars['language']->value['iso_code'];?>
',
				name: '<?php echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
',
				is_default: '<?php echo $_smarty_tpl->tpl_vars['language']->value['is_default'];?>
'
			};
		<?php } ?>
		// we need allowEmployeeFormLang var in ajax request
		allowEmployeeFormLang = <?php echo intval($_smarty_tpl->tpl_vars['allowEmployeeFormLang']->value);?>
;
		displayFlags(languages, id_language, allowEmployeeFormLang);

		$(document).ready(function() {

			$(".show_checkbox").click(function () {
				$(this).addClass('hidden')
				$(this).siblings('.checkbox').removeClass('hidden');
				$(this).siblings('.hide_checkbox').removeClass('hidden');
				return false;
			});
			$(".hide_checkbox").click(function () {
				$(this).addClass('hidden')
				$(this).siblings('.checkbox').addClass('hidden');
				$(this).siblings('.show_checkbox').removeClass('hidden');
				return false;
			});

			<?php if (isset($_smarty_tpl->tpl_vars['fields_value']->value['id_state'])) {?>
				if ($('#id_country') && $('#id_state'))
				{
					ajaxStates(<?php echo $_smarty_tpl->tpl_vars['fields_value']->value['id_state'];?>
);
					$('#id_country').change(function() {
						ajaxStates();
					});
				}
			<?php }?>

			if ($(".datepicker").length > 0)
				$(".datepicker").datepicker({
					prevText: '',
					nextText: '',
					dateFormat: 'yy-mm-dd'
				});

			if ($(".datetimepicker").length > 0)
			$('.datetimepicker').datetimepicker({
				prevText: '',
				nextText: '',
				dateFormat: 'yy-mm-dd',
				// Define a custom regional settings in order to use PrestaShop translation tools
				currentText: '<?php echo smartyTranslate(array('s'=>'Now','js'=>1),$_smarty_tpl);?>
',
				closeText: '<?php echo smartyTranslate(array('s'=>'Done','js'=>1),$_smarty_tpl);?>
',
				ampm: false,
				amNames: ['AM', 'A'],
				pmNames: ['PM', 'P'],
				timeFormat: 'hh:mm:ss tt',
				timeSuffix: '',
				timeOnlyTitle: '<?php echo smartyTranslate(array('s'=>'Choose Time','js'=>1),$_smarty_tpl);?>
',
				timeText: '<?php echo smartyTranslate(array('s'=>'Time','js'=>1),$_smarty_tpl);?>
',
				hourText: '<?php echo smartyTranslate(array('s'=>'Hour','js'=>1),$_smarty_tpl);?>
',
				minuteText: '<?php echo smartyTranslate(array('s'=>'Minute','js'=>1),$_smarty_tpl);?>
',
			});
			<?php if (isset($_smarty_tpl->tpl_vars['use_textarea_autosize']->value)) {?>
			$(".textarea-autosize").autosize();
			<?php }?>
		});
	state_token = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminStates'),$_smarty_tpl);?>
';
	
	</script>
<?php }?>
<?php }} ?>
<?php /* Smarty version Smarty-3.1.19, created on 2022-07-29 12:45:23
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/Backoffice/themes/default/template/helpers/form/form_group.tpl" */ ?>
<?php if ($_valid && !is_callable('content_62e3ba43d16c50_19115185')) {function content_62e3ba43d16c50_19115185($_smarty_tpl) {?>

<?php if (count($_smarty_tpl->tpl_vars['groups']->value)&&isset($_smarty_tpl->tpl_vars['groups']->value)) {?>
<div class="row">
	<div class="col-lg-6">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th class="fixed-width-xs">
						<span class="title_box">
							<input type="checkbox" name="checkme" id="checkme" onclick="checkDelBoxes(this.form, 'groupBox[]', this.checked)" />
						</span>
					</th>
					<th class="fixed-width-xs"><span class="title_box"><?php echo smartyTranslate(array('s'=>'ID'),$_smarty_tpl);?>
</span></th>
					<th>
						<span class="title_box">
							<?php echo smartyTranslate(array('s'=>'Group name'),$_smarty_tpl);?>

						</span>
					</th>
				</tr>
			</thead>
			<tbody>
			<?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['groups']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value) {
$_smarty_tpl->tpl_vars['group']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['group']->key;
?>
				<tr>
					<td>
						<?php $_smarty_tpl->tpl_vars['id_checkbox'] = new Smarty_variable((('groupBox').('_')).($_smarty_tpl->tpl_vars['group']->value['id_group']), null, 0);?>
						<input type="checkbox" name="groupBox[]" class="groupBox" id="<?php echo $_smarty_tpl->tpl_vars['id_checkbox']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
" <?php if ($_smarty_tpl->tpl_vars['fields_value']->value[$_smarty_tpl->tpl_vars['id_checkbox']->value]) {?>checked="checked"<?php }?> />
					</td>
					<td><?php echo $_smarty_tpl->tpl_vars['group']->value['id_group'];?>
</td>
					<td>
						<label for="<?php echo $_smarty_tpl->tpl_vars['id_checkbox']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['group']->value['name'];?>
</label>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<?php } else { ?>
<p>
	<?php echo smartyTranslate(array('s'=>'No group created'),$_smarty_tpl);?>

</p>
<?php }?>
<?php }} ?>
