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
{capture name=path}{l s='HiPay payment.' mod='hipay_enterprise'}{/capture}

<h2>{l s='Payment Summary' mod='hipay_enterprise'}</h2>
<h3>{l s='HiPay payment.' mod='hipay_enterprise'}</h3>

{if {isset($smarty.get.referenceToPay) and $smarty.get.referenceToPay}}
    <table>
        <tr>
            <td width="200px">{l s='Entity' mod='hipay_enterprise'}</td>
            <td width="200px">{$smarty.get.entity}</td>
        </tr>
        <tr>
            <td>{l s='Reference' mod='hipay_enterprise'}</td>
            <td>{$smarty.get.reference}</td>
        </tr>
        <tr>
            <td>{l s='Amount' mod='hipay_enterprise'}</td>
            <td>{$smarty.get.amount} {$currency->sign}</td>
        </tr>
        <tr>
            <td>{l s='Expiration date' mod='hipay_enterprise'}</td>
            <td>{dateFormat date=$smarty.get.expirationDate full=0}</td>
        </tr>
    </table>
    <br/>
    <p style="font-size: 15px">{l s='To pay a Multibanco reference online with you bank or with an automated cash machine, choose \'Payments\' and then \'Services\'.' mod='hipay_enterprise'}</p>
{else}
    <p>{l s='Your order is awaiting confirmation from the bank.' mod='hipay_enterprise'}
        <br/><br/>{l s='Once it is approved it will be available in your' mod='hipay_enterprise'} <strong><a
                    href="{$link->getPageLink('history', true)}">{l s='order history' mod='hipay_enterprise'}</a></strong>
    </p>
{/if}
<p><a href="index.php">{l s='Back to home' mod='hipay_enterprise'}</a></p>