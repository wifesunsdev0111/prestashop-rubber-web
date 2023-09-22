<?php /* Smarty version Smarty-3.1.19, created on 2022-07-28 17:51:40
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/gamification/views/templates/admin/gamification/helpers/view/view_bt.tpl" */ ?>
<?php /*%%SmartyHeaderCode:199464332262e2b08c079f93-88510143%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5a62a6388b53e13be7dead91ac96b99d31988de3' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/gamification/views/templates/admin/gamification/helpers/view/view_bt.tpl',
      1 => 1579509749,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '199464332262e2b08c079f93-88510143',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'current_level_percent' => 0,
    'current_level' => 0,
    'base_url' => 0,
    'badges_type' => 0,
    'type' => 0,
    'key' => 0,
    'badge' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62e2b08c0b8358_29080016',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62e2b08c0b8358_29080016')) {function content_62e2b08c0b8358_29080016($_smarty_tpl) {?>
<script>
    var current_level_percent_tab = <?php echo intval($_smarty_tpl->tpl_vars['current_level_percent']->value);?>
;
    var current_level_tab = '<?php echo intval($_smarty_tpl->tpl_vars['current_level']->value);?>
';
    var gamification_level_tab = '<?php echo smartyTranslate(array('s'=>'Level','mod'=>'gamification','js'=>1),$_smarty_tpl);?>
';
    $(document).ready(function () {
        $('.gamification_badges_img').tooltip();
        $('#gamification_progressbar_tab').progressbar({
            change: function() {
                if (<?php echo $_smarty_tpl->tpl_vars['current_level_percent']->value;?>
)
                    $( "#gamification_progress-label_tab" ).html( '<?php echo smartyTranslate(array('s'=>'Level','mod'=>'gamification','js'=>1),$_smarty_tpl);?>
'+' '+<?php echo intval($_smarty_tpl->tpl_vars['current_level']->value);?>
+' : '+$('#gamification_progressbar_tab').progressbar( "value" ) + "%" );
                else
                    $( "#gamification_progress-label_tab" ).html('');
              },
        });
        $('#gamification_progressbar_tab').progressbar("value", <?php echo intval($_smarty_tpl->tpl_vars['current_level_percent']->value);?>
 );
    });
    var admintab_gamification = true;
</script>

<div class="panel">
    <div id="intro_gamification">
        <div class="left_intro">
            <img src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
modules/gamification/views/img/checklist.png" alt="<?php echo smartyTranslate(array('s'=>'Email','mod'=>'gamification'),$_smarty_tpl);?>
" />
        </div>
        <div class="central_intro">
            <h2><?php echo smartyTranslate(array('s'=>"Become an e-commerce expert in leaps and bounds!",'mod'=>'gamification'),$_smarty_tpl);?>
</h2>
            <p>
                <?php echo smartyTranslate(array('s'=>"In order to make you succeed in the e-commerce world, we have created a system of badges and points to help you monitor your progress as a merchant. The system has three levels:",'mod'=>'gamification'),$_smarty_tpl);?>


            </p>
            <ol class="central_intro_list">
                <li><?php echo smartyTranslate(array('s'=>"Your use of key e-commerce features on your store",'mod'=>'gamification'),$_smarty_tpl);?>
</li>
                <li><?php echo smartyTranslate(array('s'=>"Your sales performances",'mod'=>'gamification'),$_smarty_tpl);?>
</li>
                <li><?php echo smartyTranslate(array('s'=>"Your presence in international markets",'mod'=>'gamification'),$_smarty_tpl);?>
</li>
            </ol>
            <p><?php echo smartyTranslate(array('s'=>"The more progress your store makes, the more badges and points you earn. Take advantage and check it out below!",'mod'=>'gamification'),$_smarty_tpl);?>
</p>
        </div>
        <div class="right_intro">
            <img src="<?php echo $_smarty_tpl->tpl_vars['base_url']->value;?>
modules/gamification/views/img/persona.png" alt="<?php echo smartyTranslate(array('s'=>"Employee",'mod'=>'gamification'),$_smarty_tpl);?>
">
            <h3 class="text-center right_intro_title"><?php echo smartyTranslate(array('s'=>"Our team of experts is available to help, feel free to contact them!",'mod'=>'gamification'),$_smarty_tpl);?>
</h3>
            <a class="text-center right_intro_btn-contact" href="https://www.prestashop.com/en/experts?utm_source=gamification"><?php echo smartyTranslate(array('s'=>"Find an expert",'mod'=>'gamification'),$_smarty_tpl);?>
</a>
        </div>
    </div>

    <div id="completion_gamification">
        <h2><?php echo smartyTranslate(array('s'=>'Completion level','mod'=>'gamification'),$_smarty_tpl);?>
</h2>
        <div id="gamification_progressbar_tab"></div>
        <p class="gamification_progress-label"><?php echo smartyTranslate(array('s'=>"Level %s:",'sprintf'=>array(intval($_smarty_tpl->tpl_vars['current_level']->value)),'mod'=>'gamification'),$_smarty_tpl);?>


        <span class="gamification_progress-label_percent">
            <?php echo intval($_smarty_tpl->tpl_vars['current_level_percent']->value);?>
%
        </span>
        </p>
    </div>
    &nbsp;
</div>
<div class="clear"><br/></div>

<?php  $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['type']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['badges_type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['type']->key => $_smarty_tpl->tpl_vars['type']->value) {
$_smarty_tpl->tpl_vars['type']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['type']->key;
?>
    <div class="panel">
        <h3><i class="icon-bookmark"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['type']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</h3>
        <div class="row">
            <div class="col-lg-2">
                <?php echo $_smarty_tpl->getSubTemplate ('./filters_bt.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('type'=>$_smarty_tpl->tpl_vars['key']->value), 0);?>

            </div>
            <div class="col-lg-10">
                <ul class="badge_list" id="list_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" style="">
                    <?php  $_smarty_tpl->tpl_vars['badge'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['badge']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['type']->value['badges']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['badge']->key => $_smarty_tpl->tpl_vars['badge']->value) {
$_smarty_tpl->tpl_vars['badge']->_loop = true;
?>
                    <li class="badge_square badge_all <?php if ($_smarty_tpl->tpl_vars['badge']->value->validated) {?>validated <?php } else { ?> not_validated<?php }?> group_<?php echo $_smarty_tpl->tpl_vars['badge']->value->id_group;?>
 level_<?php echo $_smarty_tpl->tpl_vars['badge']->value->group_position;?>
 " id="<?php echo intval($_smarty_tpl->tpl_vars['badge']->value->id);?>
">
                        <div class="gamification_badges_img" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['badge']->value->description, ENT_QUOTES, 'UTF-8', true);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['badge']->value->getBadgeImgUrl();?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['badge']->value->name, ENT_QUOTES, 'UTF-8', true);?>
" /></div>
                        <div class="gamification_badges_name"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['badge']->value->name, ENT_QUOTES, 'UTF-8', true);?>
</div>
                    </li>
                    <?php }
if (!$_smarty_tpl->tpl_vars['badge']->_loop) {
?>
                    <li>
                        <div class="gamification_badges_name"><?php echo smartyTranslate(array('s'=>"No badge in this section",'mod'=>'gamification'),$_smarty_tpl);?>
</div>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <p id="no_badge_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" class="gamification_badges_name" style="display:none;text-align:center"><?php echo smartyTranslate(array('s'=>"No badge in this section",'mod'=>'gamification'),$_smarty_tpl);?>
</p>
        </div>
    </div>
    <div class="clear"><br/></div>
<?php } ?>
<?php }} ?>
