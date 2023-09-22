{function name=menu level=0}
  <ul class="level{$level}">
  {foreach $data as $category}
    {if isset($category.children) && is_array($category.children)}
      <li class="cate_{$category.id_category}" ><a href="{$link->getCategoryLink($category.id_category, $category.link_rewrite)|escape:'html':'UTF-8'}"><span {if {$category.id_category} == {$id_root}} style="display:none"{/if}>{$category.name}{if isset($category.image)}<span {if  {$showicons} == 0 || ({$level} gt 0 && {$showicons} == 2)} style="display:none"{/if}><img height = '20px' src='{$category["image"]}' alt='{$category["name"]}'></span>{/if}</span></a>
        {menu data=$category.children level=$level+1}</li>
    {else}
      <li class="cate_{$category.id_category}"><a href="{$link->getCategoryLink($category.id_category, $category.link_rewrite)|escape:'html':'UTF-8'}">{$category.name}{if isset($category.image)}<span {if {$showicons} == 0 || ({$level} gt 0 && {$showicons} == 2)} style="display:none"{/if}><img height = '10px' src='{$category["image"]}' alt='{$category["name"]}'></span>{/if}</a></li>
    {/if}
  {/foreach}
  </ul>
{/function}

{if isset($categories)}
<div class="widget-category_image block">
	{if isset($widget_heading)&&!empty($widget_heading)}
	<h4 class="title_block">
		{$widget_heading}
	</h4>
	{/if}
	<div class="block_content">
    {foreach from = $categories   key=key item =cate}
			{menu data=$cate}
    {/foreach}
    <div id="view_all_wapper" style="display:none">
        <span class ="view_all"><a href="javascript:void(0)">{l s='View all' mod='leomanagewidgets'}</a></span>
    </div> 
	</div>
</div>
{/if}
<script type="text/javascript">
      {literal} 
          jQuery(document).ready(function(){      
            var limit = {/literal}{$limit}{literal};
            var level = {/literal}{$cate_depth}{literal};
            $("ul.level0").each(function(){
                var element = $(this).find("ul.level" + level + " >li").length;
                var count = 0;
                $(this).find("ul.level" + level + " >li").each(function(){
                  count = count + 1;
                  if(count > limit){
                    $(this).remove();
                  }

                });
                
                if(element > limit){
                    view = $(".view_all","#view_all_wapper").clone(1);
                    view.appendTo($(this).find("ul.level" + level));
                    var href = $(this).find('a:first').attr('href');
                    $("a",view).attr("href", href);
                }
          })

      });
      {/literal}
      </script>

