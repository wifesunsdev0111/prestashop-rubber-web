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

  <h2>{l s='One single platform to handle all your online transactions!' mod='ogone'}</h2>

  <div class="third-block-2">
    <img class="img-responsive" src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/info_img2_{$lg_code|escape:'htmlall':'UTF-8'}.png" alt="{l s='Payment process' mod='ogone'}"/><br />
  </div>

  <div class="third-block contact-top">
    <p class="text-center">
      <img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/logo.png" width="180px" alt="{l s='Logo branded' mod='ogone'}"/>
    </p>

    <p class="text-center">
      {l s='Create a FREE test account.' mod='ogone'}
      <br />
      {l s='Just click on the button below and complete the information requested on our website.' mod='ogone'}
    </p>
    <p class="text-center">
      <a href="{$create_test_account_url|escape:'htmlall':'UTF-8'}" target="_blank">
        <img class="img-responsive img-center" src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/test_account_{$lg_code|escape:'htmlall':'UTF-8'}.png" class="account" alt="{l s='Account' mod='ogone'}"/>
      </a>
    </p>
  </div>



  <hr/>
      <p>{l s='Good news, our PRO Subscription is very competitive: we do not charge a commission based on the amount of your transactions, but only a flat fee per transaction!' mod='ogone'}</p>
      <p class="ogone-activate"><strong>{l s='Activate your account in only 3 steps' mod='ogone'}</strong></p>


  <div id="step_01" class="third-block text-center">
    <p>
      <img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/step1.png" class="step" alt="{l s='Step 1' mod='ogone'}" />
    </p>

    <div class="step-text">

      <p>
        <small>
          <strong>
            {l s='First create a test account (it’s free and without obligation). Just click below and fill the information requested on our website.'  mod='ogone'}
          </strong>
        </small>
      </p>

      <p>
        <a href="{$create_test_account_url|escape:'htmlall':'UTF-8'}" target="_blank">
          <img class="img-responsive img-center" src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/test_account_{$lg_code|escape:'htmlall':'UTF-8'}.png" class="account" alt="{l s='Account' mod='ogone'}"/>
        </a>
      </p>
      <small>{l s='You will receive a confirmation email just after creating the account to connect to your Ingenico Back Office. Our sales team will contact you as soon as possible to assist you in the configuration of your account.' mod='ogone'}</small>
    </div>
  </div>

  <div id="step_02" class="third-block text-center">
    <p>
      <img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/step2.png"  class="step" alt="{l s='Step 2' mod='ogone'}" />
    </p>

    <div class="step-text">
      <p>{l s='Configure the PrestaShop module and the Ingenico ePayments account by following our configuration guide' mod='ogone'} :</p>
      <p>
        <a href="{$integration_guide_url|escape:'htmlall':'UTF-8'}" target="_blank">
          <img class="img-responsive" src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/documentation.png" class="documentation" />
        </a>
      </p>
      <p>
        {l s='Setup is very easy, follow' mod='ogone'}
        <a href="{$integration_guide_url|escape:'htmlall':'UTF-8'}" target="_blank">{l s='the instructions here' mod='ogone'}</a>
        {l s='or contact us to assist you' mod='ogone'}
      </p>
    </div>
  </div>

  <div id="step_03" class="third-block text-center">
    <p>
      <img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/step3.png"  class="step" alt="{l s='Step 3' mod='ogone'}" />
    </p>

    <div class="step-text">
      <p>{l s='Transfer your test account into production. You will receive your contract and start accepting payments!' mod='ogone'}</p>
      <p>
        <img src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/callcenter.png" class="callcenter" alt="{l s='Call center' mod='ogone'}" />
      </p>
      <p>
        {l s='Ask for a no obligation quote' mod='ogone'}<br/>
        <strong>{l s='Contact our sales team' mod='ogone'}!</strong><br />
        <strong><i>{l s='Phone' mod='ogone'}</i></strong> : {$sales_phone_number|escape:'htmlall':'UTF-8'}<br/>
        <strong><i>{l s='Email' mod='ogone'}</i></strong> : <a href="mailto:{$sales_email|escape:'htmlall':'UTF-8'}">{$sales_email|escape:'htmlall':'UTF-8'}</a>
      </p>
    </div>
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



  <div class="full-block text-center">
    <img class="img-responsive img-center" src="{$module_dir|escape:'htmlall':'UTF-8'}/views/img/info_img1_{$lg_code|escape:'htmlall':'UTF-8'}.png" alt="{l s='Payment process' mod='ogone'}"/>
  </div>


</div>