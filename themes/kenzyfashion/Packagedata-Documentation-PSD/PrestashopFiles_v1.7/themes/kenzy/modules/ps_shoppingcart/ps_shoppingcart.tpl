{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
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
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 *}
<div id="_desktop_cart">
  <div class="dropdown js-dropdown shopping-cart">
  <div class="blockcart cart-preview {if $cart.products_count > 0}active{else}inactive{/if}" data-refresh-url="{$refresh_url}">
    <div class="header" data-toggle="dropdown">
      <div class="blockcart-inner">
        {if $cart.products_count > 0}
          <a rel="nofollow" href="{$cart_url}">
        {/if}
          
		  <div class="shopping-cart-icon"></div>
          <span class="cart-products-count">{$cart.products_count}</span>
          <span class="hidden-sm-down shopping-cart-name">{l s='My Cart' d='Shop.Theme.Checkout'}</span>
          
        {if $cart.products_count > 0}
          </a>
        {/if}
      </div>
    </div>
    {if $cart.products_count > 0}
            <div class="ax_cart cart-hover-content  dropdown-menu">
                <ul>
                    {foreach from=$cart.products item=product}
                        <li class="cart-wishlist-item">
                            {include 'module:ps_shoppingcart/ps_shoppingcart-product-line.tpl' product=$product}
                        </li>
                    {/foreach}
                </ul>
                <div class="cart-summary">
                    <div class="cart-subtotals">
                        {foreach from=$cart.subtotals item="subtotal"}
							  {if $subtotal && $subtotal.value|count_characters > 0 && $subtotal.type !== 'tax'}
								<div class="cart-summary-line" id="cart-subtotal-{$subtotal.type}">
								  <span class="label{if 'products' === $subtotal.type} js-subtotal{/if}">
									{if 'products' == $subtotal.type}
									  {$cart.summary_string}
									{else}
									  {$subtotal.label}
									{/if}
								  </span>
								  <span class="value">
									{if 'discount' == $subtotal.type}-&nbsp;{/if}{$subtotal.value}
								  </span>
								  {if $subtotal.type === 'shipping'}
									  <div><small class="value">{hook h='displayCheckoutSubtotalDetails' subtotal=$subtotal}</small></div>
								  {/if}
								</div>
							  {/if}
						{/foreach}
                    </div>
					
                    
					<div class="cart-total">
                        <span class="label">{$cart.totals.total.label}</span>
                        <span class="value">{$cart.totals.total.value}</span>
                    </div>
					
                </div>
                <div class="cart-wishlist-action">
                    <a rel="nofollow" class="cart-wishlist-viewcart btn btn-primary" href="{$cart_url}">view cart</a>
                  
                </div>
            </div> 
        {else}
            <div class="ax_cart cart-hover-content dropdown-menu no-item">
                <span class="no-item">There is no itme in your cart.</span>
            </div>
  {/if}
  </div>
</div>
</div>
