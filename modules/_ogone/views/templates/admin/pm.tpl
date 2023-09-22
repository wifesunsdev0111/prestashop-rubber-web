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
<div id="payment_wrapper" class="ogone-panel">
  <div class="sticky-help">
      <div class="step-text">
        <strong>{l s='Need assistance?' mod='ogone'}</strong> {l s='Even if you are not an Ingenico customer ' mod='ogone'}<br />
          {l s='you can create ' mod='ogone'}  <a href="{$support_url|escape:'htmlall':'UTF-8'}" target="_blank">{l s='a ticket' mod='ogone'}</a>
          {l s='or contact us' mod='ogone'} <a href="mailto:{$support_email|escape:'htmlall':'UTF-8'}">{l s='by email' mod='ogone'}</a>.
      </div>
    </div>
    <div class="full-block">
        <script type="text/javascript">
            id_language = Number('{$defaultLanguage|escape:'htmlall':'UTF-8'}');
        </script>

        <form action="{$form_action|escape:'htmlall':'UTF-8'}" method="post" enctype="multipart/form-data">
            <div class="ogone-config-block">
                <h2>{l s='Payment methods' mod='ogone'}</h2>

                <div class="row">
                    <div class="quarter-block-3">
                        <section>


                            <!-- OGONE_DISPLAY_DEFAULT_OPTION -->
                            <div class="form-group">
                                <label class="control-label">{l s='Display default payment option' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="checkbox" id="OGONE_DISPLAY_DEFAULT_OPTION" name="OGONE_DISPLAY_DEFAULT_OPTION" {if $OGONE_DISPLAY_DEFAULT_OPTION}checked="checked"{/if} />
                                    <div class="ogone-help">{l s='Display default payment option even if another payment means are accessible' mod='ogone'}</div>
                                </div>
                            </div>

                            <!-- OGONE_DEFAULT_NAME -->
                            <div class="form-group">
                                <label class="control-label">{l s='name of the default payment option' mod='ogone'}</label>
                                <div class="control-field">
                                    {foreach $default_names as $id_lang=>$value}
                                        <div id="OGONE_DEFAULT_NAME_{$id_lang|escape:'htmlall':'UTF-8'}" style="display: {if $id_lang == $defaultLanguage}block{else}none{/if}; float: left;">
                                            <input type="text" name="OGONE_DEFAULT_NAME_{$id_lang|escape:'htmlall':'UTF-8'}" id="OGONE_DEFAULT_NAME_{$id_lang|escape:'htmlall':'UTF-8'}" value="{$value|escape:'htmlall':'UTF-8'}" />
                                        </div>
                                    {/foreach}
                                    {$flags} {* HTML, cannot escape*}
                                    <div class="ogone-help">{l s='This is name of default payment option' mod='ogone'}</div>
                                </div>

                            </div>

                            <!-- OGONE_DEFAULT_LOGO -->
                            <div class="form-group">
                                <label class="control-label">{l s='Default logo' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="file" id="OGONE_DEFAULT_LOGO" name="OGONE_DEFAULT_LOGO" />
                                    <div class="ogone-help">{l s='PNG image only' mod='ogone'} <br />{l s='Image will be resized to 194px x 80px' mod='ogone'}</div>
                                    <p><span class="current">{l s='Current logo' mod='ogone'}</span></p>
                                    <div class="opt_logo_preview">
                                        <img class="ogone_default_option_logo" src="{$ogone_logo_url|escape:'htmlall':'UTF-8'}" />
                                        {if !$custom_logo_exists}
                                            <p><small>({l s='It\'s default logo, you cannot delete it' mod='ogone'})</small></p>
                                        {else}
                                            <input class="small-submit" type="submit" name="submitOgoneDeleteLogo" value="{l s='Delete' mod='ogone'}" />
                                        {/if}
                                    </div>
                                </div>
                            </div>

                            <!-- OGONE_USE_PM -->
                            <div class="form-group">
                                <label class="control-label">{l s='Use payment methods' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="checkbox" id="OGONE_USE_PM" name="OGONE_USE_PM" {if $OGONE_USE_PM}checked="checked"{/if} />
                                    <div class="ogone-help">{l s='Allows you to propopose selected payment methods directly' mod='ogone'}</div>
                                </div>
                            </div>


                        <!-- OGONE_USE_KLARNA -->
                            <div class="form-group">
                                <label class="control-label">{l s='Set Klarna variables' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="checkbox" id="OGONE_USE_KLARNA" name="OGONE_USE_KLARNA" {if $OGONE_USE_KLARNA}checked="checked"{/if} />
                                    <div class="ogone-help">{l s='Sets variables required by Klarna for every payment. Use if you are offering Klarna payment. If you add Klarna (named Installment or Open Invoice DE, NL, SE, FI, NO, DK) only as one of payment methods, this option is not necessary. You need to have Klarna payment activated in Ingenico Backoffice.' mod='ogone'}</div>
                                </div>
                            </div>

                        </section>
                    </div>

                    <div class="quarter-block block-info">
                        <div class="inner">
                            <h4>{l s='This options will display different payment methods directly on payment choice page' mod='ogone'}</h4>
                            <ul>
                                <li>{l s='In order to propose different payment methods, you need activate them.' mod='ogone'}</li>
                                <li>{l s='Click to activate payment method, drag\'n\'drop to change order' mod='ogone'}</li>
                                <li>{l s='Please verify that payment methods you are activating are disponible for your contract.' mod='ogone'}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ogone-config-block">
                <h2>{l s='Choose payment methods' mod='ogone'}</h2>
                <p class="ogone-subtitle">
                {l s='You can select which payment methods will be proposed to customer on payment page.' mod='ogone'}
                <br />{l s='Client will be redirected to payment page with given payment method preselected' mod='ogone'}

                </p>

                <section>
                    <div class="save_alert" id="pm_save_alert">{l s='Don\'t forget to save your modifications' mod='ogone'}
                        <input type="submit" name="submitOgonePM" value="{l s='Update settings' mod='ogone'}" class="small-submit" style="float:right"/>
                        <div style="clear:both"></div>
                    </div>

                    <ul class="ogone_pm_list clear sortable">
                        {foreach $payment_methods as $position=>$pm}
                            <li class="{if $pm->active}checked{/if}">
                                <input type="hidden" name="OGONE_PM_POSITION[{$pm->id|escape:'htmlall':'UTF-8'}]" value="{$position|escape:'htmlall':'UTF-8'}" class="curpos" />
                                <img src="{$pm->logo_url|escape:'htmlall':'UTF-8'}" />
                                <input type="checkbox" name="OGONE_PM_STATUS[{$pm->id|escape:'htmlall':'UTF-8'}]" value="1" class="status" {if $pm->active}checked="checked"{/if}>
                                <span class='ogone-pm-pm' title="{l s='Payment method and brand' mod='ogone'}">{$pm->pm|escape:'htmlall':'UTF-8'} : {$pm->brand|escape:'htmlall':'UTF-8'}</span>
                                <span class='ogone-pm-name'>{$pm->name|escape:'htmlall':'UTF-8'}</span> <span class='ogone-pm-description'>({$pm->description|escape:'htmlall':'UTF-8'})</span>
                                <div class='ogone-pm-actions'>
                                    {*<a href="{$module_url|escape:'htmlall':'UTF-8'}&action=edit_pm&pmid={$pm->id|escape:'htmlall':'UTF-8'}"><i class="icon icon-edit ogone-pm-edit" data-pmid="{$pm->id|escape:'htmlall':'UTF-8'}" title="{l s='Edit' mod='ogone'}" ></i></a>*}
                                    <a href="{$module_url|escape:'htmlall':'UTF-8'}&action=delete_pm&pmid={$pm->id|escape:'htmlall':'UTF-8'}"><i class="icon icon-trash ogone-pm-delete" data-pmid="{$pm->id|escape:'htmlall':'UTF-8'}" title="{l s='Delete' mod='ogone'}" ></i></a>
                                </div>

                            </li>
                        {/foreach}
                    </ul>
                </section>
            </div>

            <div class="ogone-config-block">
                <section>
                    <div class="form-group ogone-submit">
                            <input type="submit" name="submitOgonePM" value="{l s='Update settings' mod='ogone'}" />
                    </div>
                </section>
            </div>
        </form>

        <hr />

        <form action="{$form_action|escape:'htmlall':'UTF-8'}" method="post" enctype="multipart/form-data">
            <div class="ogone-config-block">
                <h2>{l s='Add payment method' mod='ogone'}</h2>

                <div class="row">
                    <div class="quarter-block-3">
                        <p class="ogone-subtitle">{l s='You can add simple payment method.' mod='ogone'}<br />
                        <br />{l s='Client will be redirected to payment page with given payment method preselected' mod='ogone'}
                        <br /> <strong>{l s='Please, make sure that payment method you are adding is activated and configured in your Ingenico backoffice' mod='ogone'}</strong>

                         </p>
                        <section>
                            <div class="form-group">
                                <label class="control-label">{l s='Payment method' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="text" id="add_pm_pm" name="add_pm_pm" value="" />
                                    <div class="ogone-help">{l s='For example "CreditCard"' mod='ogone'}</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">{l s='Brand' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="text" id="add_pm_brand" name="add_pm_brand" value="" />
                                    <div class="ogone-help">{l s='For example "MasterCard"' mod='ogone'}</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">{l s='Name' mod='ogone'}</label>
                                <div class="control-field">
                                    {foreach $default_names as $id_lang=>$value}
                                    <div id="add_pm_name_{$id_lang|escape:'htmlall':'UTF-8'}" style="display: {if $id_lang == $defaultLanguage}block{else}none{/if}; float: left;">
                                        <input type="text" name="add_pm_name_{$id_lang|escape:'htmlall':'UTF-8'}" id="add_pm_name_{$id_lang|escape:'htmlall':'UTF-8'}" value="" />
                                    </div>
                                    {/foreach}
                                    {$flags_pm_name} {* HTML, cannot escape*}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">{l s='Description' mod='ogone'}</label>
                                <div class="control-field">
                                {foreach $default_names as $id_lang=>$value}
                                    <div id="add_pm_desc_{$id_lang|escape:'htmlall':'UTF-8'}" style="display: {if $id_lang == $defaultLanguage}block{else}none{/if}; float: left;">
                                        <input type="text" name="add_pm_desc_{$id_lang|escape:'htmlall':'UTF-8'}" id="add_pm_desc_{$id_lang|escape:'htmlall':'UTF-8'}" value="" />
                                    </div>
                                    {/foreach}
                                    {$flags_pm_desc} {* HTML, cannot escape*}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">{l s='Logo' mod='ogone'}</label>
                                <div class="control-field">
                                    <input type="file" id="add_pm_logo" name="add_pm_logo" />
                                    <div class="ogone-help">{l s='PNG image only' mod='ogone'} <br />{l s='Image will be resized to 194px x 80px' mod='ogone'}</div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="quarter-block block-info">
                        <div class="inner">
                            <h4>{l s='Adding new payment mode' mod='ogone'}</h4>
                            <ul>
                                <li>{l s='You can add another payment mode.' mod='ogone'}</li>
                                <li>{l s='Please verify that payment methods you are adding are disponible for your contract.' mod='ogone'}</li>
                                <li>{l s='Some payment methods (like Klarna) needs additional configuration and shouldn\'t be added via this interface' mod='ogone'}</li>
                                <li>{l s='If you have any questions, please contact our support' mod='ogone'}</li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ogone-config-block">
                <section>
                    <div class="form-group ogone-submit">
                            <input type="submit" name="submitOgoneAddPM" value="{l s='Add new Payment Method' mod='ogone'}" />
                    </div>
                </section>
            </div>
        </form>

        <div class="clear"></div>
    </div>
</div>