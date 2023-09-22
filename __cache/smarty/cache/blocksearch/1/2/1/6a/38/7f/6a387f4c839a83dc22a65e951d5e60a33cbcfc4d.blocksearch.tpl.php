<?php /*%%SmartyHeaderCode:26882438262b57865566dd3-95921041%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6a387f4c839a83dc22a65e951d5e60a33cbcfc4d' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/blocksearch/blocksearch.tpl',
      1 => 1575969891,
      2 => 'file',
    ),
    '2992d73ca09259c1a62ac28544cd6b94b28f0e09' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/modules/blocksearch/blocksearch-instantsearch.tpl',
      1 => 1575969891,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26882438262b57865566dd3-95921041',
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62e3bd8b6a14f7_32116254',
  'has_nocache_code' => false,
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62e3bd8b6a14f7_32116254')) {function content_62e3bd8b6a14f7_32116254($_smarty_tpl) {?><div id="search_block_left" class="block exclusive"><h4 class="title_block">Search</h4><form method="get" action="https://rubberfun.nl/search" id="searchbox"><p class="block_content"> <label for="search_query_block">Search products:</label> <input type="hidden" name="controller" value="search" /> <input type="hidden" name="orderby" value="position" /> <input type="hidden" name="orderway" value="desc" /> <input class="search_query" type="text" id="search_query_block" name="search_query" value="" /> <input type="submit" id="search_button" class="button_mini" value="Go" /></p></form></div> <script type="text/javascript">/* <![CDATA[ */;$('document').ready(function(){var $input=$("#search_query_block");$input.autocomplete('https://rubberfun.nl/search',{minChars:3,max:10,width:500,selectFirst:false,scroll:false,dataType:"json",formatItem:function(data,i,max,value,term){return value;},parse:function(data){var mytab=[];for(var i=0;i<data.length;i++)
mytab[mytab.length]={data:data[i],value:data[i].cname+' > '+data[i].pname};return mytab;},extraParams:{ajaxSearch:1,id_lang:1}}).result(function(event,data,formatted){$input.val(data.pname);document.location.href=data.product_link;});});/* ]]> */</script> <?php }} ?>
