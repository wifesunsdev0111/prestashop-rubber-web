<?php
/* Smarty version 3.1.47, created on 2023-05-15 14:58:06
  from '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/themes/kenzyfashion/templates/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64622c5e026ce4_88796306',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bdadef5f7236d2e56b7eccddd76f01a306f7159a' => 
    array (
      0 => '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/themes/kenzyfashion/templates/index.tpl',
      1 => 1680526196,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64622c5e026ce4_88796306 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
<style>
.top-menu .menu-dropdown .sub-menu {
    width: 280px;
    max-width: 280px;
}

.top-menu .menu-dropdown .sub-menu .top-menu {
    width: 100%;
}
</style>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_128271104164622c5e01d317_18500362', 'page_content_container');
?>

    <?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, 'page.tpl');
}
/* {block 'page_content_top'} */
class Block_133839840164622c5e01d8d6_66371179 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'page_content_top'} */
/* {block 'hook_home'} */
class Block_193924061164622c5e024b03_65242959 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

            <?php echo $_smarty_tpl->tpl_vars['HOOK_HOME']->value;?>

          <?php
}
}
/* {/block 'hook_home'} */
/* {block 'page_content'} */
class Block_105724532364622c5e024736_86099164 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_193924061164622c5e024b03_65242959', 'hook_home', $this->tplIndex);
?>

        <?php
}
}
/* {/block 'page_content'} */
/* {block 'page_content_container'} */
class Block_128271104164622c5e01d317_18500362 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'page_content_container' => 
  array (
    0 => 'Block_128271104164622c5e01d317_18500362',
  ),
  'page_content_top' => 
  array (
    0 => 'Block_133839840164622c5e01d8d6_66371179',
  ),
  'page_content' => 
  array (
    0 => 'Block_105724532364622c5e024736_86099164',
  ),
  'hook_home' => 
  array (
    0 => 'Block_193924061164622c5e024b03_65242959',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    
    
      <section id="content" class="page-home">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_133839840164622c5e01d8d6_66371179', 'page_content_top', $this->tplIndex);
?>

    <?php if ($_smarty_tpl->tpl_vars['page']->value['page_name'] == 'index') {?>
        <div class="container index-main-container first-index-container">
          <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['page']->value['page_name'] == 'index') {?>   
        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayTopColumn'),$_smarty_tpl ) );?>

      <?php }?>
      <section class="aei-producttab">
        <div class="container">
        <div class="tabs">
          <div class="tab-inner">
            <div class="h1 ax-product-title text-uppercase"><span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'OUR OPTIONS','d'=>'Shop.Theme.Global'),$_smarty_tpl ) );?>
</span></div>
                      </div>
          <div class="tab-content">
            <div id="featureProduct" class="ax_products tab-pane active"> 
              <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayAeiFeature'),$_smarty_tpl ) );?>

            </div>
            <div id="bestseller" class="ax_products tab-pane">
              <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayAeiBestseller'),$_smarty_tpl ) );?>

            </div>
            <div id="newProduct" class="ax_products tab-pane">
              <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayAeiNew'),$_smarty_tpl ) );?>

            </div>
          </div>          
        </div>  
        </div>      
      </section>
      <?php if ($_smarty_tpl->tpl_vars['page']->value['page_name'] == 'index') {?>
    </div>
    <?php }?>
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_105724532364622c5e024736_86099164', 'page_content', $this->tplIndex);
?>

      </section>
      

    <?php
}
}
/* {/block 'page_content_container'} */
}
