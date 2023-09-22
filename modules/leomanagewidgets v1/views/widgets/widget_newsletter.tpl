{*
* 2007-2014 PrestaShop
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
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<!-- Block Newsletter module-->
<div id="newsletter_block_left" class="block">
	{if isset($widget_heading)&&!empty($widget_heading)}
    <h4 class="title_block">
        {$widget_heading}
    </h4>
    {/if}
	<div class="block_content">
		<form action="{$link->getPageLink('index')|escape:'html':'UTF-8'}" method="post">
			{if $information}
             <div class="newsletter-info">{$information}</div>
             {/if}	
			<div class="form-group{if isset($msg) && $msg } {if $nw_error}form-error{else}form-ok{/if}{/if}" >
				<input class="inputNew form-control grey newsletter-input" id="leonewsletter-input" type="text" name="email" size="18" value="{if isset($msg) && $msg}{$msg}{elseif isset($value) && $value}{$value}{else}{l s='Enter your e-mail' mod='leomanagewidgets'}{/if}" />
                <button type="submit" name="submitNewsletter" class="btn btn-default button button-small">
                    <span>{l s='Ok' mod='leomanagewidgets'}</span>
                </button>
				<input type="hidden" name="action" value="0" />
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
{literal}
	$(document).ready(function() {
    $('#leonewsletter-input').on({
        focus: function() {
            if ($(this).val() == placeholder_leomanagewidgets || $(this).val() == msg_newsl)
                $(this).val('');
        },
        blur: function() {
            if ($(this).val() == '')
                $(this).val(placeholder_leomanagewidgets);
        }
    });

	var cssClass = 'alert alert-danger';
    if (typeof nw_error != 'undefined' && !nw_error)
		cssClass = 'alert alert-success';

    if (typeof msg_newsl != 'undefined' && msg_newsl)
	{
        $('#columns').prepend('<div class="clearfix"></div><p class="' + cssClass + '"> ' + alert_leomanagewidgets + '</p>');
		$('html, body').animate({scrollTop: $('#columns').offset().top}, 'slow');
	}
});
{/literal}
</script>
<!-- /Block Newsletter module-->
{strip}
{if isset($msg) && $msg}
{addJsDef msg_newsl=$msg|@addcslashes:'\''}
{/if}
{if isset($nw_error)}
{addJsDef nw_error=$nw_error}
{/if}
{addJsDefL name=placeholder_leomanagewidgets}{l s='Enter your e-mail' mod='leomanagewidgets' js=1}{/addJsDefL}
{if isset($msg) && $msg}
	{addJsDefL name=alert_leomanagewidgets}{l s='Newsletter : %1$s' sprintf=$msg js=1 mod="leomanagewidgets"}{/addJsDefL}
{/if}
{/strip}