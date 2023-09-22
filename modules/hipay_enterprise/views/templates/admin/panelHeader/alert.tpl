{**
 * HiPay Enterprise SDK Prestashop
 *
 * 2017 HiPay
 *
 * NOTICE OF LICENSE
 *
 * @author    HiPay <support.tpp@hipay.com>
 * @copyright 2017 HiPay
 * @license   https://github.com/hipay/hipay-enterprise-sdk-prestashop/blob/master/LICENSE.md
 *}

{if (isset($form_errors)) && (count($form_errors) > 0)}
    <div class="alert alert-danger">
        <h4>{l s='Error!' mod='hipay_enterprise'}</h4>
        <ul class="list-unstyled">
            {foreach from=$form_errors item='message'}
                <li>{$message|escape:'html':'UTF-8'}</li>
            {/foreach}
        </ul>
    </div>
{/if}

{if (isset($form_infos)) && (count($form_infos) > 0)}
    <div class="alert alert-warning">
        <h4>{l s='Notice!' mod='hipay_enterprise'}</h4>
        <ul class="list-unstyled">
            {foreach from=$form_infos item='message'}
                <li>{$message|escape:'html':'UTF-8'}</li>
            {/foreach}
        </ul>
    </div>
{/if}

{if (isset($form_successes)) && (count($form_successes) > 0)}
    <div class="alert alert-success">
        <h4>{l s='Success!' mod='hipay_enterprise'}</h4>
        <ul class="list-unstyled">
            {foreach from=$form_successes item='message'}
                <li>{$message|escape:'html':'UTF-8'}</li>
            {/foreach}
        </ul>
    </div>
{/if}

{if $ps_round_total}
    <div class="alert alert-danger">
        <h4>{l s='Error!' mod='hipay_enterprise'}</h4>
        <p>
            {l s='\'Round on the total\' is activated in prestashop configuration, cart will not be sent and payment method that force cart to be send will be disabled.' mod='hipay_enterprise'}
        </p>
    </div>
{/if}
