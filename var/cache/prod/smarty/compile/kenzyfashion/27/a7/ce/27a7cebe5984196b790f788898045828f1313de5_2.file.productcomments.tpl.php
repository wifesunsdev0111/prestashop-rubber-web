<?php
/* Smarty version 3.1.47, created on 2023-05-15 14:57:59
  from '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/modules/productcomments/productcomments.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64622c57320437_94125969',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '27a7cebe5984196b790f788898045828f1313de5' => 
    array (
      0 => '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/modules/productcomments/productcomments.tpl',
      1 => 1680526194,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64622c57320437_94125969 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="text/javascript">
    var productcomments_controller_url = '<?php echo $_smarty_tpl->tpl_vars['productcomments_controller_url']->value;?>
';
    var confirm_report_message = '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Are you sure that you want to report this comment?','mod'=>'productcomments','js'=>1),$_smarty_tpl ) );?>
';
    var secure_key = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['secure_key']->value, ENT_QUOTES, 'UTF-8');?>
';
    var productcomments_url_rewrite = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['productcomments_url_rewriting_activated']->value, ENT_QUOTES, 'UTF-8');?>
';
    var productcomment_added = '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Your comment has been added!','mod'=>'productcomments','js'=>1),$_smarty_tpl ) );?>
';
    var productcomment_added_moderation = '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Your comment has been submitted and will be available once approved by a moderator.','mod'=>'productcomments','js'=>1),$_smarty_tpl ) );?>
';
    var productcomment_title = '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'New comment','mod'=>'productcomments','js'=>1),$_smarty_tpl ) );?>
';
    var productcomment_ok = '<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'OK','mod'=>'productcomments','js'=>1),$_smarty_tpl ) );?>
';
    var moderation_active = <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['moderation_active']->value, ENT_QUOTES, 'UTF-8');?>
;
<?php echo '</script'; ?>
>

<div id="productCommentsBlock">
    <h1 class="h1 ax-product-title text-uppercase "><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Reviews','mod'=>'productcomments'),$_smarty_tpl ) );?>
</h1>
    <div class="tabs">
        <div class="clearfix">
            <?php if (($_smarty_tpl->tpl_vars['too_early']->value == false && ($_smarty_tpl->tpl_vars['logged']->value || $_smarty_tpl->tpl_vars['allow_guests']->value))) {?>
                <a class="open-comment-form btn btn-primary" href="#new_comment_form"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Write your review','mod'=>'productcomments'),$_smarty_tpl ) );?>
</a>
            <?php }?>
        </div>
        <div id="new_comment_form_ok" class="alert alert-success" style="display:none;padding:15px 25px"></div>
        <div id="product_comments_block_tab">
            <?php if ($_smarty_tpl->tpl_vars['comments']->value) {?>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['comments']->value, 'comment');
$_smarty_tpl->tpl_vars['comment']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['comment']->value) {
$_smarty_tpl->tpl_vars['comment']->do_else = false;
?>
                    <?php if ($_smarty_tpl->tpl_vars['comment']->value['content']) {?>
                        <div class="comment clearfix" itemprop="review" itemscope itemtype="https://schema.org/Review">
                            <div class="comment_author" >
                                <span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Grade','mod'=>'productcomments'),$_smarty_tpl ) );?>
&nbsp</span>
                                <div class="star_content clearfix" itemprop="reviewRating" itemscope itemtype="https://schema.org/Rating">
                                    <?php
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if (true) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = 0; $__section_i_0_iteration <= 5; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
                                        <?php if ($_smarty_tpl->tpl_vars['comment']->value['grade'] <= (isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)) {?>
                                            <div class="star"></div>
                                        <?php } else { ?>
                                            <div class="star star_on"></div>
                                        <?php }?>
                                    <?php
}
}
?>
                                    <meta itemprop="worstRating" content = "0" />
                                    <meta itemprop="ratingValue" content = "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['comment']->value['grade'], ENT_QUOTES, 'UTF-8');?>
" />
                                    <meta itemprop="bestRating" content = "5" />
                                </div>
                                <div class="comment_author_infos" >
                                    <strong itemprop="author"><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['comment']->value['customer_name'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
</strong><br/>
                                    <em><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['comment']->value['date_add'],'html','UTF-8' )),'full'=>0),$_smarty_tpl ) );?>
</em>
                                    <meta itemprop="datePublished" content="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0], array( array('date'=>call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['comment']->value['date_add'],'html','UTF-8' )),'full'=>0),$_smarty_tpl ) );?>
" />
                                </div>
                            </div>
                            <div class="comment_details">
                                <h4 class="title_block" itemprop="name"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['comment']->value['title'], ENT_QUOTES, 'UTF-8');?>
</h4>
                                <p itemprop="reviewBody"><?php echo nl2br(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['comment']->value['content'],'html','UTF-8' )));?>
</p>
                                <ul>
                                    <?php if ($_smarty_tpl->tpl_vars['comment']->value['total_advice'] > 0) {?>
                                        <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'%1$d out of %2$d people found this review useful.','sprintf'=>array($_smarty_tpl->tpl_vars['comment']->value['total_useful'],$_smarty_tpl->tpl_vars['comment']->value['total_advice']),'mod'=>'productcomments'),$_smarty_tpl ) );?>
</li>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['logged']->value) {?>
                                        <?php if (!$_smarty_tpl->tpl_vars['comment']->value['customer_advice']) {?>
                                            <li><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Was this comment useful to you?','mod'=>'productcomments'),$_smarty_tpl ) );?>

                                                <button class="usefulness_btn" data-is-usefull="1" data-id-product-comment="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['comment']->value['id_product_comment'], ENT_QUOTES, 'UTF-8');?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'yes','mod'=>'productcomments'),$_smarty_tpl ) );?>
</button>
                                                <button class="usefulness_btn" data-is-usefull="0" data-id-product-comment="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['comment']->value['id_product_comment'], ENT_QUOTES, 'UTF-8');?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'no','mod'=>'productcomments'),$_smarty_tpl ) );?>
</button>
                                            </li>
                                        <?php }?>
                                        <?php if (!$_smarty_tpl->tpl_vars['comment']->value['customer_report']) {?>
                                            <li><span class="report_btn" data-id-product-comment="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['comment']->value['id_product_comment'], ENT_QUOTES, 'UTF-8');?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Report abuse','mod'=>'productcomments'),$_smarty_tpl ) );?>
</span></li>
                                        <?php }?>
                                    <?php }?>
                                </ul>
                                <?php echo hook::exec('displayProductComment',$_smarty_tpl->tpl_vars['comment']->value);?>

                            </div>
                        </div>
                    <?php }?>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            <?php } else { ?>
                <?php if ((!$_smarty_tpl->tpl_vars['too_early']->value && ($_smarty_tpl->tpl_vars['logged']->value || $_smarty_tpl->tpl_vars['allow_guests']->value))) {?>
                    <p class="align_center alert alert-info">
                        <a id="new_comment_tab_btn" class="open-comment-form" href="#new_comment_form"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Be the first to write your review','mod'=>'productcomments'),$_smarty_tpl ) );?>
 !</a>
                    </p>
                <?php } else { ?>
                    <p class="align_center"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No customer reviews for the moment.','mod'=>'productcomments'),$_smarty_tpl ) );?>
</p>
                <?php }?>
            <?php }?>
        </div>
    </div>

    <?php if ((isset($_smarty_tpl->tpl_vars['productcomments_product']->value)) && $_smarty_tpl->tpl_vars['productcomments_product']->value) {?>
        <!-- Fancybox -->
        <div style="display:none">
            <div id="new_comment_form">
                <form id="id_new_comment_form" action="#">
                    <h2 class="title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Write your review','mod'=>'productcomments'),$_smarty_tpl ) );?>
</h2>
                    <?php if ((isset($_smarty_tpl->tpl_vars['productcomments_product']->value)) && $_smarty_tpl->tpl_vars['productcomments_product']->value) {?>
                        <div class="product clearfix">
                            <div class="product_desc">
                                <p class="product_name"><strong><?php if ((isset($_smarty_tpl->tpl_vars['productcomments_product']->value->name))) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['productcomments_product']->value->name, ENT_QUOTES, 'UTF-8');
} elseif ((isset($_smarty_tpl->tpl_vars['productcomments_product']->value['name']))) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['productcomments_product']->value['name'], ENT_QUOTES, 'UTF-8');
}?></strong></p>
                                <?php if ((isset($_smarty_tpl->tpl_vars['productcomments_product']->value->description_short))) {
echo $_smarty_tpl->tpl_vars['productcomments_product']->value->description_short;
} elseif ((isset($_smarty_tpl->tpl_vars['productcomments_product']->value['description_short']))) {
echo $_smarty_tpl->tpl_vars['productcomments_product']->value['description_short'];
}?>
                            </div>
                        </div>
                    <?php }?>
                    <div class="new_comment_form_content">
                        <h2><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Write your review','mod'=>'productcomments'),$_smarty_tpl ) );?>
</h2>
                        <div id="new_comment_form_error" class="error" style="display:none;padding:15px 25px">
                            <ul></ul>
                        </div>
                        <?php if (count($_smarty_tpl->tpl_vars['criterions']->value) > 0) {?>
                            <ul id="criterions_list">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['criterions']->value, 'criterion');
$_smarty_tpl->tpl_vars['criterion']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['criterion']->value) {
$_smarty_tpl->tpl_vars['criterion']->do_else = false;
?>
                                    <li>
                                        <label><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['criterion']->value['name'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
</label>
                                        <div class="star_content">
                                            <input class="star" type="radio" name="criterion[<?php echo htmlspecialchars(round($_smarty_tpl->tpl_vars['criterion']->value['id_product_comment_criterion']), ENT_QUOTES, 'UTF-8');?>
]" value="1"/>
                                            <input class="star" type="radio" name="criterion[<?php echo htmlspecialchars(round($_smarty_tpl->tpl_vars['criterion']->value['id_product_comment_criterion']), ENT_QUOTES, 'UTF-8');?>
]" value="2"/>
                                            <input class="star" type="radio" name="criterion[<?php echo htmlspecialchars(round($_smarty_tpl->tpl_vars['criterion']->value['id_product_comment_criterion']), ENT_QUOTES, 'UTF-8');?>
]" value="3"/>
                                            <input class="star" type="radio" name="criterion[<?php echo htmlspecialchars(round($_smarty_tpl->tpl_vars['criterion']->value['id_product_comment_criterion']), ENT_QUOTES, 'UTF-8');?>
]" value="4"/>
                                            <input class="star" type="radio" name="criterion[<?php echo htmlspecialchars(round($_smarty_tpl->tpl_vars['criterion']->value['id_product_comment_criterion']), ENT_QUOTES, 'UTF-8');?>
]" value="5" checked="checked"/>
                                        </div>
                                        <div class="clearfix"></div>
                                    </li>
                                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </ul>
                        <?php }?>
                        <label for="comment_title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Title for your review','mod'=>'productcomments'),$_smarty_tpl ) );?>
<sup class="required">*</sup></label>
                        <input id="comment_title" name="title" type="text" value=""/>

                        <label for="content"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Your review','mod'=>'productcomments'),$_smarty_tpl ) );?>
<sup class="required">*</sup></label>
                        <textarea id="content" name="content"></textarea>

                        <?php if ($_smarty_tpl->tpl_vars['allow_guests']->value == true && !$_smarty_tpl->tpl_vars['logged']->value) {?>
                            <label><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Your name','mod'=>'productcomments'),$_smarty_tpl ) );?>
<sup class="required">*</sup></label>
                            <input id="commentCustomerName" name="customer_name" type="text" value=""/>
                        <?php }?>

                        <div id="new_comment_form_footer">
                            <input id="id_product_comment_send" name="id_product" type="hidden" value='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id_product_comment_form']->value, ENT_QUOTES, 'UTF-8');?>
'/>
                            <p class="row required"><sup>*</sup> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Required fields','mod'=>'productcomments'),$_smarty_tpl ) );?>
</p>
                            <p class="fr">
                                <?php if ($_smarty_tpl->tpl_vars['PRODUCT_COMMENTS_GDPR']->value == 1) {?>
                                
                                    <input onchange="if($(this).is(':checked')){$('#submitNewMessage').removeClass('gdpr_disabled'); $('#submitNewMessage').removeAttr('disabled'); rebindClickButton();}else{$('#submitNewMessage').addClass('gdpr_disabled'); $('#submitNewMessage').off('click'); $('#submitNewMessage').attr('disabled', 1); }" id="gdpr_checkbox" type="checkbox" >
                                
                                    <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'I accept ','mod'=>'productcomments'),$_smarty_tpl ) );?>
 <a target="_blank" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCmsLink($_smarty_tpl->tpl_vars['PRODUCT_COMMENTS_GDPRCMS']->value), ENT_QUOTES, 'UTF-8');?>
"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'privacy policy','mod'=>'productcomments'),$_smarty_tpl ) );?>
</a> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'rules','mod'=>'productcomments'),$_smarty_tpl ) );?>

                                <?php }?>

                                <button <?php if ($_smarty_tpl->tpl_vars['PRODUCT_COMMENTS_GDPR']->value == 1) {?>disabled<?php }?> class="btn btn-primary <?php if ($_smarty_tpl->tpl_vars['PRODUCT_COMMENTS_GDPR']->value == 1) {?>gdpr_disabled<?php }?>" id="submitNewMessage" name="submitMessage" type="submit"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Send','mod'=>'productcomments'),$_smarty_tpl ) );?>
</button>&nbsp;
                                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'or','mod'=>'productcomments'),$_smarty_tpl ) );?>
&nbsp;<a href="#" onclick="$.fancybox.close();"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Cancel','mod'=>'productcomments'),$_smarty_tpl ) );?>
</a>
                            </p>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </form><!-- /end new_comment_form_content -->
            </div>
        </div>
        <!-- End fancybox -->
    <?php }?>
</div><?php }
}
