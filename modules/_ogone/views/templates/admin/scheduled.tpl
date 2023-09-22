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
<div class="ogone-panel" id="static_wrapper">
  <div class="sticky-help">
      <div class="step-text">
        <strong>{l s='Need assistance?' mod='ogone'}</strong> {l s='Even if you are not an Ingenico customer ' mod='ogone'}<br />
          {l s='you can create ' mod='ogone'}  <a href="{$support_url|escape:'htmlall':'UTF-8'}" target="_blank">{l s='a ticket' mod='ogone'}</a>
          {l s='or contact us' mod='ogone'} <a href="mailto:{$support_email|escape:'htmlall':'UTF-8'}">{l s='by email' mod='ogone'}</a>.
      </div>
    </div>

  <div class="full-block">
    <form action="{$form_action|escape:'htmlall':'UTF-8'}" method="post" enctype="multipart/form-data">
      <div class="ogone-config-block">
        <h2>{l s='Scheduled payment configuration' mod='ogone'}</h2>
        <div class="row">
          <div class="quarter-block-3">
            <p class="ogone-subtitle">{l s='This page allows you to configure scheduled payments' mod='ogone'}</p>
            <section>

              <div class="form-group">
                <label class="control-label">{l s='Activate scheduled payments' mod='ogone'}</label>
                <div class="control-field">
                  <input type="checkbox" id="OGONE_USE_SP" name="OGONE_USE_SP" {if $OGONE_USE_SP}checked="checked"{/if} />
                  <div class="ogone-help">{l s='Activate use of scheduled payments' mod='ogone'}</div>
                </div>
              </div>

             <div class="form-group">
                <label class="control-label">{l s='Use scheduled payment as option' mod='ogone'}</label>
                <div class="control-field">
                  <input type="checkbox" id="OGONE_SP_OPTION" name="OGONE_SP_OPTION" {if $OGONE_SP_OPTION}checked="checked"{/if} />
                  <div class="ogone-help">{l s='If checked, scheduled payment will be only one of options' mod='ogone'}</div>
                </div>
              </div>
              <div class="form-group">
                  <label class="control-label">{l s='Minimal amount' mod='ogone'}</label>
                  <div class="control-field">
                      <input type="number" name="OGONE_SP_MINIMUM" id="OGONE_SP_MINIMUM" value="{$OGONE_SP_MINIMUM|escape:'htmlall':'UTF-8'}" min="{$min_amount}" step="1" max="{$max_amount}"/><br />
                      <div class="ogone-help">{l s='Minimal amount' mod='ogone'}</div>
                  </div>
              </div>

             <div class="form-group">
                  <label class="control-label">{l s='Installments' mod='ogone'}</label>
                  <div class="control-field">
                      <input type="number" name="OGONE_SP_INSTALLMENTS" id="OGONE_SP_INSTALLMENTS" value="{$OGONE_SP_INSTALLMENTS|escape:'htmlall':'UTF-8'}" min="{$min_installments}" max="{$max_installments}" /><br />
                      <div class="ogone-help">{l s='Installments' mod='ogone'}</div>
                  </div>
              </div>

             <div class="form-group">
                  <label class="control-label">{l s='Days between installments' mod='ogone'}</label>
                  <div class="control-field">
                      <input type="number" name="OGONE_SP_DAYS" id="OGONE_SP_DAYS" value="{$OGONE_SP_DAYS|escape:'htmlall':'UTF-8'}" step="1" min="{$min_days}" max="{$max_days}" /><br />
                      <div class="ogone-help">{l s='Days between two installments' mod='ogone'}</div>
                  </div>
              </div>

            </section>

          </div>

          <div class="quarter-block block-info">
            <div class="inner">
              <h4>{l s='Scheduled payments' mod='ogone'}</h4>
              <ul>
                <li>{l s='Scheduled Payments allows customers to pay for a purchase in several instalments, instead of one single payment.' mod='ogone'}</li>
                <li>{l s='This is usually done for large amounts, so that the customer doesn\'t have to spend too much at once for an order.' mod='ogone'}</li>
                <li>{l s='Please contact our support team if you have any questions' mod='ogone'}</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <hr />

            <div class="ogone-config-block">
                <section>
                    <div class="form-group ogone-submit">
                        <input type="submit" name="submitOgoneScheduled" value="{l s='Update settings' mod='ogone'}" />
                    </div>
                </section>
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>