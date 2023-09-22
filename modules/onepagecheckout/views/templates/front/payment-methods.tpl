{**
* NOTICE OF LICENSE
*
* This source file is subject to the Software License Agreement
* that is bundled with this package in the file LICENSE.txt.
* 
*  @author Peter Sliacky
*  @copyright 2009-2016 Peter Sliacky
*  @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0) 
*}

{if isset($payment_methods)}
<table id="paymentMethodsTable" class="std">
    <tbody>
        {foreach from=$payment_methods item=payment_method name=myLoop}
        <tr class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{/if} {if $smarty.foreach.myLoop.index % 2}alternate_item{else}item{/if}">
            <td class="payment_action radio">
                <input type="radio" name="id_payment_method" value="{$payment_method.link|escape:'html':'UTF-8'}"
                       id="payment_{$payment_method.link|escape:'html':'UTF-8'}" {if ($payment_methods|@count == 1)}checked="checked"{/if} />
            </td>
            <td class="payment_name">
                <label for="payment_{$payment_method.link|escape:'html':'UTF-8'}">
                    {if $payment_method.img}<img{if isset($payment_method.class)} class="cssback {$payment_method.class|escape:'html':'UTF-8'}"{/if} src="{$payment_method.img|escape:'htmlall':'UTF-8'}"/>{/if}
                </label>
            </td>
            <td class="payment_description">
                <label for="payment_{$payment_method.link|escape:'html':'UTF-8'}">
	    	    {$payment_method.desc|regex_replace:'/[\r\t\n]/':' '}
		</label>
	    </td>
        </tr>
        {/foreach}
    </tbody>
</table>
{/if}
