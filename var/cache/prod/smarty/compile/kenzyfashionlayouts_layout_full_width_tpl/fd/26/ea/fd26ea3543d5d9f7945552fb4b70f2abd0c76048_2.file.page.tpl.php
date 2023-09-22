<?php
/* Smarty version 3.1.47, created on 2023-05-15 14:54:57
  from '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/themes/kenzyfashion/templates/page.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_64622ba1e69fd5_52525236',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fd26ea3543d5d9f7945552fb4b70f2abd0c76048' => 
    array (
      0 => '/var/www/vhosts/rubberfun.nl/demo.rubberfun.nl/themes/kenzyfashion/templates/page.tpl',
      1 => 1680526196,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64622ba1e69fd5_52525236 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_73312616564622ba1e649d6_20409499', 'content');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, $_smarty_tpl->tpl_vars['layout']->value);
}
/* {block 'page_title'} */
class Block_177575479564622ba1e65357_12686202 extends Smarty_Internal_Block
{
public $callsChild = 'true';
public $hide = 'true';
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

        <header class="page-header">
          <h1><?php 
$_smarty_tpl->inheritance->callChild($_smarty_tpl, $this);
?>
</h1>
        </header>
      <?php
}
}
/* {/block 'page_title'} */
/* {block 'page_header_container'} */
class Block_193615804064622ba1e64e21_50139666 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_177575479564622ba1e65357_12686202', 'page_title', $this->tplIndex);
?>

    <?php
}
}
/* {/block 'page_header_container'} */
/* {block 'page_content_top'} */
class Block_191313981464622ba1e68072_31375404 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'page_content_top'} */
/* {block 'page_content'} */
class Block_118630696264622ba1e686a9_90334088 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <!-- Page content -->
        <?php
}
}
/* {/block 'page_content'} */
/* {block 'page_content_container'} */
class Block_175258205064622ba1e67c23_50567785 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <section id="content" class="page-content card card-block">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_191313981464622ba1e68072_31375404', 'page_content_top', $this->tplIndex);
?>

        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_118630696264622ba1e686a9_90334088', 'page_content', $this->tplIndex);
?>

      </section>
    <?php
}
}
/* {/block 'page_content_container'} */
/* {block 'page_footer'} */
class Block_21482028664622ba1e69398_46439491 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <!-- Footer content -->
        <?php
}
}
/* {/block 'page_footer'} */
/* {block 'page_footer_container'} */
class Block_116824423164622ba1e68ff2_93864498 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

      <footer class="page-footer">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_21482028664622ba1e69398_46439491', 'page_footer', $this->tplIndex);
?>

      </footer>
    <?php
}
}
/* {/block 'page_footer_container'} */
/* {block 'content'} */
class Block_73312616564622ba1e649d6_20409499 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_73312616564622ba1e649d6_20409499',
  ),
  'page_header_container' => 
  array (
    0 => 'Block_193615804064622ba1e64e21_50139666',
  ),
  'page_title' => 
  array (
    0 => 'Block_177575479564622ba1e65357_12686202',
  ),
  'page_content_container' => 
  array (
    0 => 'Block_175258205064622ba1e67c23_50567785',
  ),
  'page_content_top' => 
  array (
    0 => 'Block_191313981464622ba1e68072_31375404',
  ),
  'page_content' => 
  array (
    0 => 'Block_118630696264622ba1e686a9_90334088',
  ),
  'page_footer_container' => 
  array (
    0 => 'Block_116824423164622ba1e68ff2_93864498',
  ),
  'page_footer' => 
  array (
    0 => 'Block_21482028664622ba1e69398_46439491',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


  <section id="main">

    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_193615804064622ba1e64e21_50139666', 'page_header_container', $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_175258205064622ba1e67c23_50567785', 'page_content_container', $this->tplIndex);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_116824423164622ba1e68ff2_93864498', 'page_footer_container', $this->tplIndex);
?>


  </section>

<?php
}
}
/* {/block 'content'} */
}
