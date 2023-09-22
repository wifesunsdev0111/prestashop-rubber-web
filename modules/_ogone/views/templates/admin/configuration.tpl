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

<div id="configuration_wrapper" class="ogone-panel">
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
                <h2>{l s='Basic configuration' mod='ogone'}</h2>
                <div class="row">
                    <div class="quarter-block-3">
                        <p class="ogone-subtitle">{l s='This is the configuration necessary to use Ingenico ePayments' mod='ogone'}</p>
                        <section>
                            <!-- OGONE_PSPID -->
                            <div class="form-group">
                                <label class="control-label">{l s='PSPID' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="text" name="OGONE_PSPID" id="OGONE_PSPID" value="{$OGONE_PSPID|escape:'htmlall':'UTF-8'}" />
                                    <div class="ogone-help">{l s='The PSPID is the Merchant ID chosen by the merchant administrator when opening the account' mod='ogone'}</div>
                                </div>
                            </div>

                            <!-- OGONE_SHA_IN -->
                            <div class="form-group">
                                <label class="control-label">{l s='SHA-IN signature' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="text" name="OGONE_SHA_IN" id="OGONE_SHA_IN" value="{$OGONE_SHA_IN|escape:'htmlall':'UTF-8'}" /><br />
                                    <div class="ogone-help">{l s='SHA-IN signature can be defined in your Ingenico ePayments backoffice in Configuration/Technical information/Data and origin verification/Checks for e-commerce/SHA-IN pass phrase' mod='ogone'}</div>
                                </div>
                            </div>

                            <!-- OGONE_SHA_OUT -->
                            <div class="form-group">
                                <label class="control-label">{l s='SHA-OUT signature' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="text" name="OGONE_SHA_OUT" id="OGONE_SHA_OUT" value="{$OGONE_SHA_OUT|escape:'htmlall':'UTF-8'}" /><br />
                                    <div class="ogone-help">{l s='SHA-OUT signature can be defined in your Ingenico ePayments backoffice' mod='ogone'}<br /> {l s='Look in Configuration/Technical information/Transaction feedback/SHA-OUT pass phrase' mod='ogone'}</div>
                                </div>
                            </div>

                            <!-- OGONE_MODE -->
                            <div class="form-group">
                                <label class="control-label" for="OGONE_MODE">{l s='Mode' mod='ogone'}</label>
                                <div class="control-field">
                                    <div class="ogone-radio-block">
                                        <input type="radio" id="OGONE_MODE_TEST" name="OGONE_MODE" value="0" {if $OGONE_MODE != 1}checked="checked"{/if} />
                                        <label for="OGONE_MODE_TEST">{l s='Test' mod='ogone'}</label>
                                    </div>
                                    <div class="ogone-radio-block">
                                        <input type="radio" id="OGONE_MODE_PRODUCTION" name="OGONE_MODE" value="1" {if $OGONE_MODE == 1}checked="checked"{/if} />
                                        <label for="OGONE_MODE_PRODUCTION">{l s='Production' mod='ogone'}</label>
                                    </div>
                                    <div class="ogone-help">{l s='You need visit your Ingenico ePayments backoffice to transfer your test account into production' mod='ogone'}</div>
                                </div>
                            </div>

                            <!-- OGONE_OPERATION -->
                            <div class="form-group">
                                <label class="control-label" for="OGONE_OPERATION">{l s='Default operation type' mod='ogone'}</label>
                                <div class="control-field">
                                    <div class="ogone-radio-block">
                                        <input type="radio" id="OGONE_OPERATION_SALE" name="OGONE_OPERATION" value="SAL" {if $OGONE_OPERATION == 'SAL'}checked="checked"{/if} />
                                        <label for="OGONE_OPERATION_SALE">{l s='Direct sale' mod='ogone'}</label>
                                    </div>
                                    <div class="ogone-radio-block">
                                        <input type="radio" id="OGONE_OPERATION_AUTH" name="OGONE_OPERATION" value="RES" {if $OGONE_OPERATION == 'RES'}checked="checked"{/if} />
                                        <label for="OGONE_OPERATION_AUTH">{l s='Authorise' mod='ogone'}</label>
                                    </div>
                                    <div class="ogone-help">{l s='If you choose "authorise" option, payment will be finalised only after order capture' mod='ogone'}</div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="quarter-block block-info">
                        <div class="inner">
                            <h4>{l s='In order to use basic payment capabilities, you need to configure properly your Ingenico ePayments backoffice' mod='ogone'}</h4>
                            <ul>
                                <li>{l s='You need to verify that e-commerce option is activated for your contract.' mod='ogone'}</li>
                                <li>{l s='You need to set SHA-IN and SHA-OUT variables properly' mod='ogone'}</li>
                                <li>{l s='You need to declare validation url in Ingenico ePayments backoffice' mod='ogone'}
                                        <br />{l s='Your validation url' mod='ogone'}:
                                        <br /><span class="long-url"><strong>{$validation_url|escape:'htmlall':'UTF-8'}</strong></span>
                                </li>
                                <li>{l s='If you have any questions, please contact our support' mod='ogone'}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <hr/>

            <div class="ogone-config-block">
                <h2>{l s='DirectLink configuration' mod='ogone'}</h2>

                <div class="row">
                    <div class="quarter-block-3">
                        <p class="ogone-subtitle">{l s='This part will allow you to use DirectLink' mod='ogone'}.
                        <br /><strong>{l s='Attention: In order to use DirectLink, you need to be PCI compliant.' mod='ogone'}</strong>
                        <br /><strong>{l s='You can find more info in' mod='ogone'}
                        <a href="https://www.pcisecuritystandards.org/documents/SAQ_A_v3.pdf" target="_blank"><i>Self-Assessment Questionnaire A
and Attestation of Compliance</i></a></strong></p>
                        </p>

                        <section>

                            <!-- OGONE_USE_DL -->
                            <div class="form-group">
                                <label class="control-label">{l s='Allow usage of Direct Link' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="checkbox" id="OGONE_USE_DL" name="OGONE_USE_DL" {if $OGONE_USE_DL}checked="checked"{/if} />
                                    <div class="ogone-help">{l s='If you choose this option, operations like capture could be handled directly from your Prestashop backoffice.' mod='ogone'}</div>
                                </div>
                            </div>


                            <!-- OGONE_DL_USER -->
                            <div class="form-group">
                                <label class="control-label">{l s='DirectLink user' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="text" name="OGONE_DL_USER" id="OGONE_DL_USER" value="{$OGONE_DL_USER|escape:'htmlall':'UTF-8'}" />
                                    <div class="ogone-help">{l s='You need to create separate user with special permissions to use DirectLink' mod='ogone'}</div>
                                </div>
                            </div>

                            <!-- OGONE_DL_PASSWORD -->
                            <div class="form-group">
                                <label class="control-label">{l s='DirectLink password' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="text" name="OGONE_DL_PASSWORD" id="OGONE_DL_PASSWORD" value="{$OGONE_DL_PASSWORD|escape:'htmlall':'UTF-8'}" />
                                    <div class="ogone-help">{l s='This is a password associated with DirectLink user' mod='ogone'}</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">{l s='DirectLink SHA-IN signature' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="text" name="OGONE_DL_SHA_IN" id="OGONE_DL_SHA_IN" value="{$OGONE_DL_SHA_IN|escape:'htmlall':'UTF-8'}" />
                                    <div class="ogone-help">{l s='DirectLink SHA-IN signature can be defined in your Ingenico ePayments backoffice in Configuration/Technical information/Data and origin verification/Checks for DirectLink/SHA-IN pass phrase' mod='ogone'}</div>
                                </div>
                            </div>

                            <!-- OGONE_DL_TIMEOUT -->
                            <div class="form-group">
                                <label class="control-label">{l s='DirectLink request timeout' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="number" min="0" max="300" name="OGONE_DL_TIMEOUT" id="OGONE_DL_TIMEOUT" value="{$OGONE_DL_TIMEOUT|escape:'htmlall':'UTF-8'}" />
                                    <div class="ogone-help">{l s='Maximal number of seconds to wait for DirectLink response' mod='ogone'}</div>
                                </div>
                            </div>

                        </section>
                    </div>

                    <div class="quarter-block block-info">
                        <div class="inner">
                            <h4>{l s='In order to use DirectLink capabilities, you need to configure properly your Ingenico ePayments backoffice' mod='ogone'}</h4>
                            <ul>
                                <li>{l s='You need to verify that DirectLink option is activated for your contract.' mod='ogone'}</li>
                                <li>{l s='You need to create an API user' mod='ogone'} {l s='See' mod='ogone'} <a href="{$direct_link_doc_url|escape:'html':'UTF-8'}" target="_blank">{l s='our documentation' mod='ogone'} </a> {l s='for more details' mod='ogone'}</li>
                                <li>{l s='You need to set API user, API user password, DirectLink SHA_IN' mod='ogone'}</li>
                                <li>{l s='You need to add your server\'s IP to whitelist in Ingenico ePayments backoffice. Contact your hosting provider if you don\'t know IP of your server.' mod='ogone'}
                                {if $server_ip}{l s='It seems that this server\'s IP is' mod='ogone'}  <strong>{$server_ip|escape:'html':'UTF-8'}</strong>{else}{l s='We cannot determine your server IP' mod='ogone'} {/if}</li>
                                <li>{l s='If you have any questions, please contact our support' mod='ogone'}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <hr/>

            <div class="ogone-config-block">
                <h2>{l s='Alias configuration' mod='ogone'}</h2>

                <div class="row">
                    <div class="quarter-block-3">
                        <p class="ogone-subtitle">{l s='This part will allow your customers to store they card data on Ingenico servers' mod='ogone'}</p>

                        <section>
                            <!-- OGONE_USE_ALIAS -->
                            <div class="form-group">
                                <label class="control-label">{l s='Allow Alias utilisation' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="checkbox" id="OGONE_USE_ALIAS" name="OGONE_USE_ALIAS" {if $OGONE_USE_ALIAS}checked="checked"{/if} />
                                    <div class="ogone-help">{l s='If you choose this option, your customers will have possibility to store their card credentials on Ingenico ePayments servers.' mod='ogone'}</div>
                                </div>
                            </div>

                            <!-- OGONE_PROPOSE_ALIAS -->
                            <div class="form-group">
                                <label class="control-label">{l s='Propose alias for normal payments' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="checkbox" id="OGONE_PROPOSE_ALIAS" name="OGONE_PROPOSE_ALIAS" {if $OGONE_PROPOSE_ALIAS}checked="checked"{/if} />
                                    <div class="ogone-help">{l s='If you choose this option, creation of alias will be proposed on payment moment.' mod='ogone'}</div>
                                </div>
                            </div>

                            <!-- OGONE_DONT_STORE_ALIAS -->
                            <div class="form-group">
                                <label class="control-label">{l s='Do not store alias' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="checkbox" id="OGONE_DONT_STORE_ALIAS" name="OGONE_DONT_STORE_ALIAS" {if $OGONE_DONT_STORE_ALIAS}checked="checked"{/if} />
                                    <div class="ogone-help">{l s='If you choose this option, alias will be stored only during 2 hours.' mod='ogone'}</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">{l s='Skip confirmation' mod='ogone'} ({l s='Single click payment' mod='ogone'})</label>
                                <div class="control-field">
                                    <input type="checkbox" id="OGONE_SKIP_AC" name="OGONE_SKIP_AC" {if $OGONE_SKIP_AC}checked="checked"{/if} />
                                    <div class="ogone-help">{l s='Skip confirmation step for alias payments' mod='ogone'}</div>
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="control-label">{l s='Make immediate payment' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="checkbox" id="OGONE_MAKE_IP" name="OGONE_MAKE_IP" {if $OGONE_MAKE_IP}checked="checked"{/if} />
                                    <div class="ogone-help">{l s='Make immediate payment after alias adding. This option needs DirectLink to be activated' mod='ogone'}</div>
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="control-label">{l s='Use DirectLink to perform alias payment' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="checkbox" id="OGONE_ALIAS_BY_DL" name="OGONE_ALIAS_BY_DL" {if $OGONE_ALIAS_BY_DL}checked="checked"{/if} />
                                    <div class="ogone-help">{l s='If you choose this option, your customers will be not redirected to perform payment. This option needs DirectLink to be activated' mod='ogone'}</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">{l s='Activate 3-D Secure option for alias payments using DirectLink' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="checkbox" id="OGONE_USE_D3D" name="OGONE_USE_D3D" {if $OGONE_USE_D3D}checked="checked"{/if} />
                                    <div class="ogone-help">{l s='If you wish to use 3-D Secure with DirectLink, you need to have the D3D option activated in your account.' mod='ogone'}</div>
                                </div>
                            </div>

                           <div class="form-group">
                                <label class="control-label">{l s='3-D Secure window mode for alias payments using DirectLink' mod='ogone'}</label>
                                <div class="control-field">
                                    <select id="OGONE_WIN3DS" name="OGONE_WIN3DS">
                                      <option value="MAINW" {if $OGONE_WIN3DS=='MAINW' || $OGONE_WIN3DS=="" || $OGONE_WIN3DS=="POPIX"}selected="selected"{/if}>{l s='In the main window' mod='ogone'}</option>
                                      <option value="POPUP" {if $OGONE_WIN3DS=='POPUP'}selected="selected"{/if}>{l s='Pop-up window, return to the main window' mod='ogone'}</option>
                                      {* <option value="POPIX" {if $OGONE_WIN3DS=='POPIX'}selected="selected"{/if}>{l s='Pop-up window, remain there' mod='ogone'}</option> *}

                                    </select>
                                    <div class="ogone-help">{l s='Way to show the identification page to the customer in context of Alias payment with 3-D Secure.' mod='ogone'}</div>
                                </div>
                            </div>

                       <!-- OGONE_ALIAS_PM -->
                            <div class="form-group">
                                <label class="control-label">{l s='Type of proposed payment method' mod='ogone'}</label>
                                <div class="control-field">
                                    <select name="OGONE_ALIAS_PM[]" id="OGONE_ALIAS_PM" multiple="multiple"/>
                                        <option value="CreditCard" {if $OGONE_ALIAS_PM['CreditCard']==1}selected="selected"{/if}>{l s='CreditCard' mod='ogone'}</option>
                                        <option value="DirectDebits DE" {if $OGONE_ALIAS_PM['DirectDebits DE']==1}selected="selected"{/if}>{l s='DirectDebits DE' mod='ogone'}</option>
                                        <option value="DirectDebits NL" {if $OGONE_ALIAS_PM['DirectDebits NL']==1}selected="selected"{/if}>{l s='DirectDebits NL' mod='ogone'}</option>
                                        <option value="DirectDebits AT" {if $OGONE_ALIAS_PM['DirectDebits AT']==1}selected="selected"{/if}>{l s='DirectDebits AT' mod='ogone'}</option>
                                    </select>
                                    <div class="ogone-help">{l s='Type of payment method proposed' mod='ogone'}</div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="quarter-block block-info">
                        <div class="inner">
                            <h4>{l s='In order to use Alias capabilities, you need to configure properly your Ingenico ePayments backoffice' mod='ogone'}</h4>
                            <ul>
                                <li>{l s='You need to verify that Alias option is activated for your contract.' mod='ogone'}</li>
                                <li>{l s='You need to set Alias dynamic variables properly' mod='ogone'}</li>
                                <li>{l s='You can send us CSS file to style alias creation form' mod='ogone'}</li>
                                <li>{l s='If you wish to use 3-D Secure with DirectLink, you need to have the D3D option activated in your account' mod='ogone'}</li>
                                <li>{l s='Some acquiring banks require the use of 3-D Secure. Please check with your acquirer if this is the case for you' mod='ogone'}</li>
                                <li>{l s='If you have any questions, please contact our support' mod='ogone'}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <hr/>

            <div class="ogone-config-block">
                <h2>{l s='Security configuration' mod='ogone'}</h2>
                <div class="row">
                  <div class="quarter-block-3">
                    <div class="form-group">
                      <label class="control-label">{l s='Display fraud scoring' mod='ogone'}</label>
                      <div class="control-field">
                        <input type="checkbox" id="OGONE_DISPLAY_FRAUD_SCORING" name="OGONE_DISPLAY_FRAUD_SCORING" {if $OGONE_DISPLAY_FRAUD_SCORING}checked="checked"{/if} />
                        <div class="ogone-help">{l s='Displays fraud scoring on the order page in your back-office' mod='ogone'}</div>
                      </div>
                    </div>
                  </div>
                  <div class="quarter-block block-info">
                    <div class="inner">
                      <h4>{l s='In order to use fraud scoring, you need to configure this option' mod='ogone'}</h4>
                        <ul>
                            <li>{l s='Fraud scoring needs to be activated for your contract' mod='ogone'}</li>
                            <li>{l s='You need to activate and configure DirectLink properly.' mod='ogone'}</li>
                            <li>{l s='You need to select SCO_CATEGORY and SCORING options in dynamic parameters for Directlink on Transaction Feedback page.' mod='ogone'}</li>
                            <li>{l s='If you have any questions, please contact our support' mod='ogone'}</li>
                       </ul>
                    </div>
                  </div>
                </div>
            </div>

            <div class="ogone-config-block">
                <section>
                    <div class="form-group ogone-submit">
                        <input type="submit" name="submitOgone" value="{l s='Update settings' mod='ogone'}" />
                    </div>
                </section>
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>