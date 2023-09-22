<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 10:39:53
         compiled from "/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/Backoffice/themes/default/template/controllers/products/helpers/tree/tree_associated_categories.tpl" */ ?>
<?php /*%%SmartyHeaderCode:161384176762b578594badf4-02304024%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ffc629471eae090aefb74ec6f60a5fb923c9f72f' => 
    array (
      0 => '/mnt/web017/a2/88/54052188/htdocs/Prestashop_02/Backoffice/themes/default/template/controllers/products/helpers/tree/tree_associated_categories.tpl',
      1 => 1575969813,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '161384176762b578594badf4-02304024',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'header' => 0,
    'nodes' => 0,
    'id' => 0,
    'token' => 0,
    'use_checkbox' => 0,
    'use_search' => 0,
    'selected_categories' => 0,
    'imploded_selected_categories' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b578594d73f2_49577897',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b578594d73f2_49577897')) {function content_62b578594d73f2_49577897($_smarty_tpl) {?>
<div class="panel">
	<?php if (isset($_smarty_tpl->tpl_vars['header']->value)) {?><?php echo $_smarty_tpl->tpl_vars['header']->value;?>
<?php }?>
	<?php if (isset($_smarty_tpl->tpl_vars['nodes']->value)) {?>
	<ul id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="cattree tree">
		<?php echo $_smarty_tpl->tpl_vars['nodes']->value;?>

	</ul>
	<?php }?>
</div>
<script type="text/javascript">
	var currentToken="<?php echo addslashes($_smarty_tpl->tpl_vars['token']->value);?>
";
	var treeClickFunc = function() {
		var newURL = window.location.protocol + "//" + window.location.host + window.location.pathname;
		var queryString = window.location.search.replace(/&id_category=[0-9]*/, "") + "&id_category=" + $(this).val();
		location.href = newURL+queryString; // hash part is dropped: window.location.hash
	};
	function addDefaultCategory(elem)
	{
		$('select#id_category_default').append('<option value="' + elem.val()+'">' + (elem.val() !=1 ? elem.parent().find('label').html() : home) + '</option>');
		if ($('select#id_category_default option').length > 0)
		{
			$('select#id_category_default').closest('.form-group').show();
			$('#no_default_category').hide();
		}
	}

	<?php if (isset($_smarty_tpl->tpl_vars['use_checkbox']->value)&&$_smarty_tpl->tpl_vars['use_checkbox']->value==true) {?>
		function checkAllAssociatedCategories($tree)
		{
			$tree.find(':input[type=checkbox]').each(function(){
				$(this).prop('checked', true);

				addDefaultCategory($(this));
				$(this).parent().addClass('tree-selected');
			});
		}

		function uncheckAllAssociatedCategories($tree)
		{
			$tree.find(':input[type=checkbox]').each(function(){
				$(this).prop('checked', false);

				$('select#id_category_default option[value='+$(this).val()+']').remove();
				if ($('select#id_category_default option').length == 0)
				{
					$('select#id_category_default').closest('.form-group').hide();
					$('#no_default_category').show();
				}

				$(this).parent().removeClass('tree-selected');
			});
		}
	<?php }?>
	<?php if (isset($_smarty_tpl->tpl_vars['use_search']->value)&&$_smarty_tpl->tpl_vars['use_search']->value==true) {?>
		$('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
-categories-search').bind('typeahead:selected', function(obj, datum){
			var match = $('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
').find(':input[value="'+datum.id_category+'"]').first();
			if (match.length)
			{
				match.each(function(){
						$(this).prop("checked", true);
						$(this).parent().addClass("tree-selected");
						$(this).parents('ul.tree').each(function(){
							$(this).show();
							$(this).prev().find('.icon-folder-close').removeClass('icon-folder-close').addClass('icon-folder-open');
						});
						addDefaultCategory($(this));
					}
				);
			}
			else
			{
				var selected = [];
				that = this;
				$('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
').find('.tree-selected input').each(
					function()
					{
						selected.push($(this).val());
					}
				);
				
				$.get(
					'ajax-tab.php',
					{controller:'AdminProducts',token:currentToken,action:'getCategoryTree', fullTree:1, selected:selected},
					function(content) {
				
						$('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
').html(content);
						$('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
').tree('init');
						$('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
').find(':input[value="'+datum.id_category+'"]').each(function(){
								$(this).prop("checked", true);
								$(this).parent().addClass("tree-selected");
								$(this).parents('ul.tree').each(function(){
									$(this).show();
									$(this).prev().find('.icon-folder-close').removeClass('icon-folder-close').addClass('icon-folder-open');
								});
								full_loaded = true;
							}
						);
					}
				);
			}
		});
	<?php }?>
	function startTree() {
		if (typeof $.fn.tree === 'undefined') {
			setTimeout(startTree, 100);
			return;
		}

		$('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
').tree('collapseAll');
		$('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
').find(':input[type=radio]').click(treeClickFunc);

		<?php if (isset($_smarty_tpl->tpl_vars['selected_categories']->value)) {?>
			$('#no_default_category').hide();
			<?php $_smarty_tpl->tpl_vars['imploded_selected_categories'] = new Smarty_variable(implode('","',$_smarty_tpl->tpl_vars['selected_categories']->value), null, 0);?>
			var selected_categories = new Array("<?php echo $_smarty_tpl->tpl_vars['imploded_selected_categories']->value;?>
");

			if (selected_categories.length > 1)
				$('#expand-all-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
').hide();
			else
				$('#collapse-all-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
').hide();

			$('#<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
').find(':input').each(function(){
				if ($.inArray($(this).val(), selected_categories) != -1)
				{
					$(this).prop("checked", true);
					$(this).parent().addClass("tree-selected");
					$(this).parents('ul.tree').each(function(){
						$(this).show();
						$(this).prev().find('.icon-folder-close').removeClass('icon-folder-close').addClass('icon-folder-open');
					});
				}
			});
		<?php } else { ?>
			$('#collapse-all-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
').hide();
		<?php }?>
	}
	startTree();
</script>
<?php }} ?>
