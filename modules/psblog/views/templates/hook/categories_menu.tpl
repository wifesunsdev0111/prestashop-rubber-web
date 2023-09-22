{*
 *  Ps Prestashop SliderShow for Prestashop 1.7.x
 *
 * @package   pssliderlayer
 * @version   3.0
 * @author    http://www.prestabrain.com
 * @copyright Copyright (C) October 2017 prestabrain.com <@emai:prestabrain@gmail.com>
 *               
 * @license   GNU General Public License version 2
*}

<!-- Block categories module -->
    {if $tree}
    <div id="categories_blog_menu" class="block blog-menu">
      <h4 class="title_block">{if isset($currentCategory)}{$currentCategory->title|escape:'html':'UTF-8'}{else}{l s='Blog Categories' mod='psblog'}{/if}</h4>
        <div class="block_content">
            {$tree nofilter}{* HTML form , no escape necessary *}
        </div>
    </div>
    {/if}
    <!-- /Block categories module -->
