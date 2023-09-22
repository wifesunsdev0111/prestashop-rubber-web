<?php /* Smarty version Smarty-3.1.19, created on 2022-07-28 18:02:44
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/leotempcp/views/templates/admin/leotempcp_theme/themeeditor.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2466439162e2b324b14d33-67525331%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '58632aca12a00b3e965c9bb2b17b089888f50bed' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/leotempcp/views/templates/admin/leotempcp_theme/themeeditor.tpl',
      1 => 1470856268,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2466439162e2b324b14d33-67525331',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'actionURL' => 0,
    'themeName' => 0,
    'backLink' => 0,
    'profiles' => 0,
    'profile' => 0,
    'imgLink' => 0,
    'xmlselectors' => 0,
    'for' => 0,
    'items' => 0,
    'group' => 0,
    'item' => 0,
    'patterns' => 0,
    'backgroundImageURL' => 0,
    'pattern' => 0,
    'backGroundValue' => 0,
    'attachment' => 0,
    'position' => 0,
    'repeat' => 0,
    'i' => 0,
    'siteURL' => 0,
    'customizeFolderURL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62e2b324b947f0_04011768',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62e2b324b947f0_04011768')) {function content_62e2b324b947f0_04011768($_smarty_tpl) {?>
<div id="livethemeeditor">
    <form  enctype="multipart/form-data" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['actionURL']->value, ENT_QUOTES, 'UTF-8', true);?>
" id="form" method="post">
        <div id="leo-customize" class="leo-customize">
            <div class="btn-show"><?php echo smartyTranslate(array('s'=>'Customize','mod'=>'leotempcp'),$_smarty_tpl);?>
<span class="icon-wrench"></span></div>
            <div class="wrapper"><div id="customize-form">
                    <p>  
                        <span class="badge"><?php echo smartyTranslate(array('s'=>'Theme','mod'=>'leotempcp'),$_smarty_tpl);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['themeName']->value, ENT_QUOTES, 'UTF-8', true);?>
</span>   <a class="label label-default pull-right" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['backLink']->value, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo smartyTranslate(array('s'=>'Back','mod'=>'leotempcp'),$_smarty_tpl);?>
</a>  
                    </p>        

                    <div class="buttons-group">
                        <input type="hidden" id="action-mode" name="action-mode">   
                        <a onclick="$('#action-mode').val('save-edit');
                                $('#form').submit();" class="btn btn-primary btn-xs" href="#" type="submit"><?php echo smartyTranslate(array('s'=>'Submit','mod'=>'leotempcp'),$_smarty_tpl);?>
</a>
                        <a onclick="$('#action-mode').val('save-delete');
                                $('#form').submit();" class="btn btn-danger btn-xs show-for-existed" href="#" type="submit"><?php echo smartyTranslate(array('s'=>'Delete','mod'=>'leotempcp'),$_smarty_tpl);?>
</a>
                    </div>
                    <hr>
                    <div class="groups">
                        <div class="form-group clearfix">
                            <label><?php echo smartyTranslate(array('s'=>'Edit for','mod'=>'leotempcp'),$_smarty_tpl);?>
</label> 
                            <select id="saved-files" name="saved_file" class="form-control">
                                <option value=""><?php echo smartyTranslate(array('s'=>'create new','mod'=>'leotempcp'),$_smarty_tpl);?>
</option>
                                <?php  $_smarty_tpl->tpl_vars['profile'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['profile']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['profiles']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['profile']->key => $_smarty_tpl->tpl_vars['profile']->value) {
$_smarty_tpl->tpl_vars['profile']->_loop = true;
?>
                                    <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['profile']->value, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['profile']->value, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                <?php } ?>
                            </select> 
                        </div>
                        <div class="form-group clearfix">
                            <label class="show-for-notexisted pull-left"><?php echo smartyTranslate(array('s'=>'Or  Save New','mod'=>'leotempcp'),$_smarty_tpl);?>
&nbsp;&nbsp;&nbsp;</label><label class="show-for-existed"><?php echo smartyTranslate(array('s'=>'And Rename File To','mod'=>'leotempcp'),$_smarty_tpl);?>
</label>
                            <input type="text" name="newfile">
                        </div>  
                        <div class="form-group clearfix">
                        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['imgLink']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="btn btn btn-default btn-xs" id="upload_pattern"><?php echo smartyTranslate(array('s'=>'Upload other pattern','mod'=>'leotempcp'),$_smarty_tpl);?>
</a>
                        </div>
                    <hr>
                        <div class="clearfix" id="customize-body">
                            <ul id="myCustomTab" class="nav nav-tabs">
                                <?php  $_smarty_tpl->tpl_vars['output'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['output']->_loop = false;
 $_smarty_tpl->tpl_vars['for'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['xmlselectors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['output']->key => $_smarty_tpl->tpl_vars['output']->value) {
$_smarty_tpl->tpl_vars['output']->_loop = true;
 $_smarty_tpl->tpl_vars['for']->value = $_smarty_tpl->tpl_vars['output']->key;
?>
                                    <li><a href="#tab-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['for']->value, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['for']->value, ENT_QUOTES, 'UTF-8', true);?>
</a></li> 
                                    <?php } ?>  
                            </ul>
                            <div class="tab-content" > 
                                <?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['items']->_loop = false;
 $_smarty_tpl->tpl_vars['for'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['xmlselectors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value) {
$_smarty_tpl->tpl_vars['items']->_loop = true;
 $_smarty_tpl->tpl_vars['for']->value = $_smarty_tpl->tpl_vars['items']->key;
?>
                                    <div class="tab-pane" id="tab-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['for']->value, ENT_QUOTES, 'UTF-8', true);?>
">

                                        <?php if (!empty($_smarty_tpl->tpl_vars['items']->value)) {?>
                                            <div class="accordion"  id="custom-accordion">
                                                <?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value) {
$_smarty_tpl->tpl_vars['group']->_loop = true;
?>
                                                    <div class="accordion-group panel panel-default">
                                                        <div class="accordion-heading panel-heading">
                                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#custom-accordion" href="#collapse<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['match'], ENT_QUOTES, 'UTF-8', true);?>
">
                                                                <?php echo $_smarty_tpl->tpl_vars['group']->value['header'];?>

                                                            </a>
                                                        </div>

                                                        <div id="collapse<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['match'], ENT_QUOTES, 'UTF-8', true);?>
" class="accordion-body collapse">
                                                            <div class="accordion-inner panel-body clearfix">
                                                                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group']->value['selector']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>

                                                                    <?php if (isset($_smarty_tpl->tpl_vars['item']->value['type'])&&$_smarty_tpl->tpl_vars['item']->value['type']=="image") {?> 
                                                                        <div class="form-group background-images cleafix"> 
                                                                            <label><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['label'], ENT_QUOTES, 'UTF-8', true);?>
</label>
                                                                            <a class="clear-bg label label-success" href="#"><?php echo smartyTranslate(array('s'=>'Clear','mod'=>'leotempcp'),$_smarty_tpl);?>
</a>
                                                                            <input value="" type="hidden" name="customize[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['match'], ENT_QUOTES, 'UTF-8', true);?>
][]" data-match="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['match'], ENT_QUOTES, 'UTF-8', true);?>
" class="input-setting" data-selector="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['selector'], ENT_QUOTES, 'UTF-8', true);?>
" data-attrs="background-image">

                                                                            <div class="clearfix"></div>
                                                                            <p><em style="font-size:10px"><?php echo smartyTranslate(array('s'=>'Those Images in folder YOURTHEME/img/patterns/','mod'=>'leotempcp'),$_smarty_tpl);?>
</em></p>
                                                                            <div class="bi-wrapper clearfix">
                                                                                <?php  $_smarty_tpl->tpl_vars['pattern'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pattern']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['patterns']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pattern']->key => $_smarty_tpl->tpl_vars['pattern']->value) {
$_smarty_tpl->tpl_vars['pattern']->_loop = true;
?>
                                                                                    <div style="background:url('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['backgroundImageURL']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['pattern']->value, ENT_QUOTES, 'UTF-8', true);?>
') no-repeat center center;" class="pull-left" data-image="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['backgroundImageURL']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['pattern']->value, ENT_QUOTES, 'UTF-8', true);?>
" data-val="../../img/patterns/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['pattern']->value, ENT_QUOTES, 'UTF-8', true);?>
">

                                                                                    </div>
                                                                                <?php } ?>
                                                                            </div>
                                                                            <ul class="bg-config">
                                                                                <li>
                                                                                    <div><?php echo smartyTranslate(array('s'=>'Attachment','mod'=>'leotempcp'),$_smarty_tpl);?>
</div>
                                                                                    <select data-attrs="background-attachment" name="customize[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['match'], ENT_QUOTES, 'UTF-8', true);?>
][]" data-selector="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['selector'], ENT_QUOTES, 'UTF-8', true);?>
" data-match="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['match'], ENT_QUOTES, 'UTF-8', true);?>
">
                                                                                        <option value=""><?php echo smartyTranslate(array('s'=>'Not set','mod'=>'leotempcp'),$_smarty_tpl);?>
</option>
                                                                                        <?php  $_smarty_tpl->tpl_vars['attachment'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attachment']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['backGroundValue']->value['attachment']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attachment']->key => $_smarty_tpl->tpl_vars['attachment']->value) {
$_smarty_tpl->tpl_vars['attachment']->_loop = true;
?>
                                                                                            <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['attachment']->value, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['attachment']->value, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </li>
                                                                                <li>
                                                                                    <div><?php echo smartyTranslate(array('s'=>'Position','mod'=>'leotempcp'),$_smarty_tpl);?>
</div>
                                                                                    <select data-attrs="background-position" name="customize[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['match'], ENT_QUOTES, 'UTF-8', true);?>
][]" data-selector="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['selector'], ENT_QUOTES, 'UTF-8', true);?>
" data-match="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['match'], ENT_QUOTES, 'UTF-8', true);?>
">
                                                                                        <option value=""><?php echo smartyTranslate(array('s'=>'Not set','mod'=>'leotempcp'),$_smarty_tpl);?>
</option>
                                                                                        <?php  $_smarty_tpl->tpl_vars['position'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['position']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['backGroundValue']->value['position']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['position']->key => $_smarty_tpl->tpl_vars['position']->value) {
$_smarty_tpl->tpl_vars['position']->_loop = true;
?>
                                                                                            <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['position']->value, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['position']->value, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </li>
                                                                                <li>
                                                                                    <div><?php echo smartyTranslate(array('s'=>'Repeat','mod'=>'leotempcp'),$_smarty_tpl);?>
</div>
                                                                                    <select data-attrs="background-repeat" name="customize[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['match'], ENT_QUOTES, 'UTF-8', true);?>
][]" data-selector="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['selector'], ENT_QUOTES, 'UTF-8', true);?>
" data-match="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['match'], ENT_QUOTES, 'UTF-8', true);?>
">
                                                                                        <option value=""><?php echo smartyTranslate(array('s'=>'Not set','mod'=>'leotempcp'),$_smarty_tpl);?>
</option>
                                                                                        <?php  $_smarty_tpl->tpl_vars['repeat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['repeat']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['backGroundValue']->value['repeat']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['repeat']->key => $_smarty_tpl->tpl_vars['repeat']->value) {
$_smarty_tpl->tpl_vars['repeat']->_loop = true;
?>
                                                                                            <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['repeat']->value, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['repeat']->value, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['type']=="fontsize") {?>
                                                                        <div class="form-group cleafix">
                                                                            <label><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['label'], ENT_QUOTES, 'UTF-8', true);?>
</label>
                                                                            <select name="customize[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['match'], ENT_QUOTES, 'UTF-8', true);?>
][]" data-match="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['match'], ENT_QUOTES, 'UTF-8', true);?>
" type="text" class="input-setting" data-selector="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['selector'], ENT_QUOTES, 'UTF-8', true);?>
" data-attrs="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['attrs'], ENT_QUOTES, 'UTF-8', true);?>
">
                                                                                <option value="">Inherit</option>
                                                                                <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int) ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? 16+1 - (9) : 9-(16)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0) {
for ($_smarty_tpl->tpl_vars['i']->value = 9, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++) {
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
                                                                                    <option value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['i']->value, ENT_QUOTES, 'UTF-8', true);?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['i']->value, ENT_QUOTES, 'UTF-8', true);?>
</option>
                                                                                <?php }} ?>
                                                                            </select>   <a href="#" class="clear-bg label label-success"><?php echo smartyTranslate(array('s'=>'Clear','mod'=>'leotempcp'),$_smarty_tpl);?>
</a>
                                                                        </div>
                                                                    <?php } else { ?>
                                                                        <div class="form-group cleafix">
                                                                            <label><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['label'], ENT_QUOTES, 'UTF-8', true);?>
</label>
                                                                            <input value="" size="10" name="customize[<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['match'], ENT_QUOTES, 'UTF-8', true);?>
][]" data-match="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['group']->value['match'], ENT_QUOTES, 'UTF-8', true);?>
" type="text" class="input-setting" data-selector="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['selector'], ENT_QUOTES, 'UTF-8', true);?>
" data-attrs="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['attrs'], ENT_QUOTES, 'UTF-8', true);?>
"><a href="#" class="clear-bg label label-success"><?php echo smartyTranslate(array('s'=>'Clear','mod'=>'leotempcp'),$_smarty_tpl);?>
</a>
                                                                        </div>
                                                                    <?php }?>


                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>              
                                                <?php } ?>
                                            </div>
                                        <?php }?>
                                    </div>
                                <?php } ?>
                            </div>      
                        </div>    
                    </div>
                </div></div></div>
    </form>
    <div id="main-preview">
        <iframe src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['siteURL']->value, ENT_QUOTES, 'UTF-8', true);?>
" ></iframe> 
    </div>
</div>
        <script>
        var customizeFolderURL = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['customizeFolderURL']->value, ENT_QUOTES, 'UTF-8', true);?>
';
        </script><?php }} ?>
