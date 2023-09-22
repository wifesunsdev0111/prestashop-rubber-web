{*
* 2007-2017 PrestaShop
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
*  @copyright  2007-2017 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<div class="ogone-panel">
    <div class="full-block">

        <div class="full-block text-center">
        <div class="step-text">
            <p class="question">{l s='Ask for a no obligation quote' mod='ogone'}</p>

            <p>{l s='Call our sales support team' mod='ogone'} :</p>
            <p>
                <img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/callcenter.png" class="callcenter" alt="{l s='Call center' mod='ogone'}" width="100px" height="auto" />
            </p>
            <p>
                {l s='Need assistance?' mod='ogone'}!<br/>
                {l s='We are happy to help' mod='ogone'}!<br/>
                {l s='Contact our' mod='ogone'} <strong>{l s='sales team' mod='ogone'}</strong><br/>
                <strong><i>{l s='Phone' mod='ogone'}</i></strong> : {$sales_phone_number|escape:'htmlall':'UTF-8'}<br/>
                <strong><i>{l s='Email' mod='ogone'}</i></strong> : <a href="mailto:{$sales_email|escape:'htmlall':'UTF-8'}">{$support_email|escape:'htmlall':'UTF-8'}</a>
            </p>
        </div>
    </div>
    <h3>{l s='Check our comparative study' mod='ogone'}</h3>
        <p>{l s='Our model focuses on your success. The more you realize transactions, the more our solution is competitive.' mod='ogone'}</p>
        <p>{l s='Here are' mod='ogone'} <strong>{l s='3 cases, ' mod='ogone'}</strong> {l s='with a 12 month projection that highlight how much you will save thanks to our solution.' mod='ogone'} </p>
        <table>
            <thead>
                <tr>
                    <th>{l s='Cases' mod='ogone'}</th>
                    <th>{l s='Ingenico ePayments' mod='ogone'}</th>
                    <th>{l s='Alternative Payment Solution' mod='ogone'}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>{l s='CASE1 :  50 transactions per month,  average basket  £50' mod='ogone'}</strong></td>
                    <td><strong>{l s='Total to pay for the year: £239.88' mod='ogone'}</strong><br />
                        {l s='Fee per transaction = 0€ because the first 300 transactions are free' mod='ogone'}
                    </td>
                    <td>
                        <strong>{l s='Total to pay for the year : £750' mod='ogone'}</strong><br />
                        {l s='Fee per transaction  = 50*2.5% * 50 *12= £750' mod='ogone'}
                    </td>
                </tr>
                <tr>
                    <td><strong>{l s='CASE 2 : 100 transactions per month, average basket £50' mod='ogone'}</strong></td>
                    <td><strong>{l s='Total to pay for the year: £239.88' mod='ogone'}</strong><br />
                    {l s='Fee per transaction = £0 because the first 300 transactions are free' mod='ogone'}
                    </td>
                    <td><strong>{l s='Total invoice for the year: £1500' mod='ogone'}</strong><br />
                    {l s='Fee per transaction  = 100*2.5% * 50*12 = £1500' mod='ogone'}
                </tr>
                <tr>
                    <td><strong>{l s='CASE 3 : 150 transactions per month, average basket £50' mod='ogone'}</strong></td>
                    <td><strong>{l s='Total invoice for the year: £239.88' mod='ogone'}</strong><br />
                    {l s='Fee per transaction = £0 because the first 300 transactions are free' mod='ogone'}
                    </td>
                    <td><strong>{l s='Total invoice for the year £2250' mod='ogone'}</strong><br />
                    {l s='Fee per transaction  = 50*2.5%*150 *12= £2250' mod='ogone'}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <hr/>

        <div class="full-block text-center">
        <div class="step-text">
            <p><strong>{l s='Need assistance?' mod='ogone'}</strong><br/>{l s='We are happy to help even if you are not an Ingenico customer!' mod='ogone'}</p>
            <p>
                <img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/callcenter_bw.png" class="callcenter" alt="{l s='Call center' mod='ogone'}" width="100px" height="auto" />
            </p>
            <p>
                {l s='Contact our support team through creating a ticket' mod='ogone'}  <a href="{$support_url|escape:'htmlall':'UTF-8'}" target="_blank">{l s='here' mod='ogone'}</a>, {l s=' we will call you back!' mod='ogone'}<br />
                <strong><i>{l s='Email' mod='ogone'}</i></strong> : <a href="mailto:{$support_email|escape:'htmlall':'UTF-8'}">{$support_email|escape:'htmlall':'UTF-8'}</a>
            </p>
        </div>
    </div>
</div>
