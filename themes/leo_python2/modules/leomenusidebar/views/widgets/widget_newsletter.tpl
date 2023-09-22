{*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<!-- Block Newsletter module-->

<div id="newsletter_block_footer" class="block leo-newsletter">
	<h4 class="title_block">{l s='Newsletter' mod='blocknewsletter'}</h4>
	<div class="block_content">
 
		<form action="{$link->getPageLink('index')|escape:'html'}" method="post">
             {if $information}
             <div class="newsletter-info">{$information}</div>
             {/if}
             <div class="alert alert-danger hide">{l s='Newsletter: Invalid email address' mod='blocknewsletter'}</div>
		      <div class="input-group">
				<input   class="form-control"  id="newsletter-input-footer" type="text" name="email"  value="{if isset($value) && $value}{$value}{else}{l s='your e-mail' mod='blocknewsletter'}{/if}" />
				<input type="hidden" name="action" value="0" />
                <span class="input-group-btn">                
                     <button type="submit" class="btn btn-outline" name="submitNewsletter" >{l s='Go!' mod='blocknewsletter'}</button>              
                </span>

			</div>
		</form>
	</div>
</div>
<!-- /Block Newsletter module-->
 


<script type="text/javascript">
    var placeholder = "{l s='your e-mail' mod='blocknewsletter' js=1}";
    {literal}
        $(document).ready(function() {
            $('#newsletter-input-footer').on({
                focus: function() {
                    if ($(this).val() == placeholder) {
                        $(this).val('');
                    }
                },
                blur: function() {
                    if ($(this).val() == '') {
                        $(this).val(placeholder);
                    }
                }
            });

            $("#newsletter_block_footer form").submit( function(){  
                if ( $('#newsletter-input-footer').val() == placeholder) {
                    $("#newsletter_block_footer .alert").removeClass("hide");
                    return false;
                }else {
                     $("#newsletter_block_footer .alert").addClass("hide");
                     return true;
                }
            } );
        });

    {/literal}
</script>