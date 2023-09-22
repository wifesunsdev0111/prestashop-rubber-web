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
  <script>
    var ogone_periods_ww = {$period_moments_ww_json}; /* cannot escape */
    var ogone_periods_m = {$period_moments_m_json}; /* cannot escape */

  </script>
  <div class="full-block">
    <form action="{$form_action|escape:'htmlall':'UTF-8'}" method="post" enctype="multipart/form-data">
      <div class="ogone-config-block">
        <h2>{l s='Subscription configuration' mod='ogone'}</h2>
        <div class="row">
          <div class="quarter-block-3">
            <p class="ogone-subtitle">{l s='This page allows you to configure subscriptions' mod='ogone'}</p>
            <section>
              <div class="form-group">
                <label class="control-label">{l s='Activate subscriptions' mod='ogone'}</label>
                <div class="control-field">
                  <input type="checkbox" id="OGONE_USE_SUBSCRIPTION" name="OGONE_USE_SUBSCRIPTION" {if $OGONE_USE_SUBSCRIPTION}checked="checked"{/if} />
                  <div class="ogone-help">{l s='Activate use of subscriptions' mod='ogone'}</div>
                </div>
              </div>
            </section>
          </div>
         </div>

         <div class="quarter-block-3">
            <p class="ogone-subtitle">{l s='Default params' mod='ogone'}</p>
            <section>
               <div class="form-group">
                   <label class="control-label">{l s='Period unit' mod='ogone'}</label>
                   <div class="control-field">
                       <select id="OGONE_SUB_PERIOD_UNIT" name="OGONE_SUB_PERIOD_UNIT">
                         <option value="d" {if $OGONE_SUB_PERIOD_UNIT=='d'}selected="selected"{/if}>{l s='Day' mod='ogone'}</option>
                         <option value="ww" {if $OGONE_SUB_PERIOD_UNIT=='ww'}selected="selected"{/if}>{l s='Week' mod='ogone'}</option>
                         <option value="m" {if $OGONE_SUB_PERIOD_UNIT=='m' ||  $OGONE_SUB_PERIOD_UNIT==''}selected="selected"{/if}>{l s='Month' mod='ogone'}</option>
                       </select>
                       <div class="ogone-help">{l s='Unit of interval between each occurrence of the subscription payments.' mod='ogone'}</div>
                   </div>
               </div>

              <div class="form-group" id="period_moment_holder" {if $OGONE_SUB_PERIOD_UNIT=='d'}style='display:none'{/if}>
                   <label class="control-label">{l s='Period moment' mod='ogone'}</label>
                   <div class="control-field">
                       <select id="OGONE_SUB_PERIOD_MOMENT" name="OGONE_SUB_PERIOD_MOMENT">
                       {if $current_period_moments}
                       {foreach  $current_period_moments as $k=>$v}
                         <option value="{$k|escape:'htmlall':'UTF-8'}" {if $OGONE_SUB_PERIOD_MOMENT==$k}selected="selected"{/if}>{$v|escape:'htmlall':'UTF-8'}</option>
                       {/foreach}

                       {/if}
                       </select>
                       <div class="ogone-help">{l s='Depending on SUB_PERIOD_UNIT (not applicable for "daily" (d) as here the moment is equal to the unit).' mod='ogone'}</div>
                   </div>
               </div>


               <div class="form-group">
                      <label class="control-label">{l s='Periods between payments' mod='ogone'}</label>
                      <div class="control-field">
                          <input type="number" name="OGONE_SUB_PERIOD_NUMBER" id="OGONE_SUB_PERIOD_NUMBER" value="{$OGONE_SUB_PERIOD_NUMBER|escape:'htmlall':'UTF-8'}" step="1" min="{$min_period_number}" max="{$max_period_number}" /><br />
                          <div class="ogone-help">{l s='Number of periods between two installments' mod='ogone'}</div>
                      </div>
                  </div>



             <div class="form-group">
                 <label class="control-label">{l s='Number of payments' mod='ogone'}</label>
                 <div class="control-field">
                     <input type="number" name="OGONE_SUB_INSTALLMENTS" id="OGONE_SUB_INSTALLMENTS" value="{$OGONE_SUB_INSTALLMENTS|escape:'htmlall':'UTF-8'}" step="1" min="{$min_period_number}" max="{$max_period_number}" /><br />
                     <div class="ogone-help">{l s='Total number of payments' mod='ogone'}</div>
                 </div>
             </div>

           </div>

</section>
</div>
      <hr />

            <div class="ogone-config-block">
                <section>
                    <div class="form-group ogone-submit">
                        <input type="submit" name="submitOgoneSubscription" value="{l s='Update settings' mod='ogone'}" />
                    </div>
                </section>
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>