{**
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2018 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}
<style>
.top-menu .menu-dropdown .sub-menu {
    width: 280px;
    max-width: 280px;
}

.top-menu .menu-dropdown .sub-menu .top-menu {
    width: 100%;
}
</style>
{extends file='page.tpl'}

    {block name='page_content_container'}
    
    
      <section id="content" class="page-home">
        {block name='page_content_top'}{/block}
    {if $page.page_name == 'index'}
        <div class="container index-main-container first-index-container">
          {/if}
    {if $page.page_name == 'index'}   
        {hook h='displayTopColumn'}
      {/if}
      <section class="aei-producttab">
        <div class="container">
        <div class="tabs">
          <div class="tab-inner">
            <div class="h1 ax-product-title text-uppercase"><span>{l s='OUR OPTIONS' d='Shop.Theme.Global'}</span></div>
            {*
            <ul id="product-tabs" class="nav nav-tabs clearfix">
              <li class="nav-item">
                <a data-toggle="tab" href="#featureProduct" class="nav-link active" data-text="{l s='Featured products' d='Shop.Theme.Global'}">
                  <span>{l s='Featured products' d='Shop.Theme.Global'}</span>
                </a>
              </li>
              <li class="nav-item">
                <a data-toggle="tab" href="#bestseller" class="nav-link" data-text="{l s='Best Sellers' d='Shop.Theme.Global'}">
                  <span>{l s='Best Sellers' d='Shop.Theme.Global'}</span>
                </a>
              </li>
              <li class="nav-item">
                <a data-toggle="tab" href="#newProduct" class="nav-link" data-text="{l s='New Arrivals' d='Shop.Theme.Global'}">
                  <span>{l s='New Arrivals' d='Shop.Theme.Global'}</span>
                </a>
              </li>
              
            </ul>
            *}
          </div>
          <div class="tab-content">
            <div id="featureProduct" class="ax_products tab-pane active"> 
              {hook h='displayAeiFeature'}
            </div>
            <div id="bestseller" class="ax_products tab-pane">
              {hook h='displayAeiBestseller'}
            </div>
            <div id="newProduct" class="ax_products tab-pane">
              {hook h='displayAeiNew'}
            </div>
          </div>          
        </div>  
        </div>      
      </section>
      {if $page.page_name == 'index'}
    </div>
    {/if}
        {block name='page_content'}
          {block name='hook_home'}
            {$HOOK_HOME nofilter}
          {/block}
        {/block}
      </section>
      

    {/block}
    