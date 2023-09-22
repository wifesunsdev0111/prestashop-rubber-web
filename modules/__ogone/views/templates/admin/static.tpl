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
        <h2>{l s='Static template configuration' mod='ogone'}</h2>
        <div class="row">
          <div class="quarter-block-3">
            <p class="ogone-subtitle">{l s='This page allows you to make your customer\'s experience better by changing display of the payment page' mod='ogone'}</p>
            <section>
              <!-- OGONE_USE_TPL -->
              <div class="form-group">
                <label class="control-label">{l s='Activate static templates' mod='ogone'}</label>
                <div class="control-field">
                  <input type="checkbox" id="OGONE_USE_TPL" name="OGONE_USE_TPL" {if $OGONE_USE_TPL}checked="checked"{/if} />
                  <div class="ogone-help">{l s='Activate use of static template' mod='ogone'}</div>
                </div>
              </div>
            </section>
          </div>


          <div class="quarter-block block-info">
            <div class="inner">
              <h4>{l s='You can change how payment page is displayed' mod='ogone'}</h4>
              <ul>
                <li>{l s='If you want use static templates, this option should be activated in your Ingenico ePayments back-office' mod='ogone'}</li>
                <li>{l s='In order to use logo, adequate option should be activated in your back-office' mod='ogone'}</li>
                <li>{l s='Please contact our support team if you have any questions' mod='ogone'}</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <hr />

      <div class="ogone-config-block">
        <h2>{l s='Static template configuration' mod='ogone'}</h2>
        <div class="row">
          <div class="third-block">
            <p class="ogone-subtitle">{l s='You can change the look and feel of some elements on the payment page and add your logo' mod='ogone'}. {l s='You can see the preview below' mod='ogone'}</p>

            <div id="ogone_tpl_definition"></div>

            <div class="save_alert" id="st_save_alert">
              {l s='Don\'t forget to save your modifications' mod='ogone'}
              <input type="submit" name="submitOgoneStatic" value="{l s='Update settings' mod='ogone'}" class="small-submit" style="float:right"/>
              <div class="clear"></div>
            </div>

            <div class="form-group">
              <label class="control-label" for="title">{l s='Title and header of the page' mod='ogone'}</label>
              <div class="control-field">
                <input type="text" name="OGONE_TITLE" id="title" size="20" value="{$OGONE_TITLE|escape:'htmlall':'UTF-8'}" class="ogone_preview_trigger" hex="true" />
                <div class="ogone-help">{l s='Title and header of the page' mod='ogone'}</div>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label" for="bgcolor">{l s='Background colour' mod='ogone'}</label>
              <div class="control-field">
                <input type="color" name="OGONE_BGCOLOR" id="bgcolor" size="20" value="{$OGONE_BGCOLOR|escape:'htmlall':'UTF-8'}" class="ogone_preview_trigger" hex="true" />
                <div class="ogone-help">{l s='Background colour' mod='ogone'}</div>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label" for="txtcolor">{l s='Text colour' mod='ogone'}</label>
              <div class="control-field">
                <input type="color" name="OGONE_TXTCOLOR" id="txtcolor" size="20" value="{$OGONE_TXTCOLOR|escape:'htmlall':'UTF-8'}" class="ogone_preview_trigger" hex="true" />
                <div class="ogone-help">{l s='text colour' mod='ogone'}</div>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label" for="tblbgcolor">{l s='Table background colour' mod='ogone'}</label>
              <div class="control-field">
                <input type="color" name="OGONE_TBLBGCOLOR" id="tblbgcolor" size="20" value="{$OGONE_TBLBGCOLOR|escape:'htmlall':'UTF-8'}" class="ogone_preview_trigger" hex="true" />
                <div class="ogone-help">{l s='Table background colour' mod='ogone'}</div>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label" for="tbltxtcolor">{l s='Table text colour' mod='ogone'}</label>
              <div class="control-field">
                <input type="color" name="OGONE_TBLTXTCOLOR" id="tbltxtcolor" size="20" value="{$OGONE_TBLTXTCOLOR|escape:'htmlall':'UTF-8'}" class="ogone_preview_trigger" hex="true" />
                <div class="ogone-help">{l s='Table text colour' mod='ogone'}</div>
              </div>
            </div>


            <div class="form-group">
              <label class="control-label" for="buttonbgcolor">{l s='Button background colour' mod='ogone'}</label>
              <div class="control-field">
                <input type="color" name="OGONE_BUTTONBGCOLOR" id="buttonbgcolor" size="20" value="{$OGONE_BUTTONBGCOLOR|escape:'htmlall':'UTF-8'}" class="ogone_preview_trigger" hex="true" />
                <div class="ogone-help">{l s='Button background colour' mod='ogone'}</div>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label" for="buttontxtcolor">{l s='Button text colour' mod='ogone'}</label>
              <div class="control-field">
                <input type="color" name="OGONE_BUTTONTXTCOLOR" id="buttontxtcolor" size="20" value="{$OGONE_BUTTONTXTCOLOR|escape:'htmlall':'UTF-8'}" class="ogone_preview_trigger" hex="true" />
                <div class="ogone-help">{l s='Button text colour' mod='ogone'}</div>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label" for="fonttype">{l s='Font family' mod='ogone'}</label>
              <div class="control-field">
                <select id="fonttype" name="OGONE_FONTTYPE" class="ogone_preview_trigger">
                  {foreach $fonts as $font}
                    <option value="{$font|escape:'htmlall':'UTF-8'}" {if $font==$OGONE_FONTTYPE}selected="selected"{/if}>{$font|escape:'htmlall':'UTF-8'}</option>
                  {/foreach}
                </select>
                <div class="ogone-help">{l s='Font family' mod='ogone'}</div>
              </div>
            </div>

            <div class="form-group">
              <label class="control-label" for="logo">{l s='Logo image name' mod='ogone'}</label>
              <div class="control-field">
                <input type="text" name="OGONE_LOGO" id="logo" size="20" value="{$OGONE_LOGO|escape:'htmlall':'UTF-8'}" class="ogone_preview_trigger" hex="true" />
                <div class="ogone-help">{l s='You shoud add this file using File Manager in your Ingenico ePayments backoffice.' mod='ogone'}. {l s='Use the name of file (for example "logo.jpg") as value of this field' mod='ogone'}</div>
              </div>
            </div>
          </div>

          <div class="third-block-2">
            <div id="preview_container">
              {include file='./preview.tpl'}
            </div>
          </div>
        </div>
      </div>

      <hr />

      <div class="ogone-config-block">
        <section>
          <div class="form-group ogone-submit">
            <input type="submit" name="submitOgoneStatic" value="{l s='Update settings' mod='ogone'}" />
          </div>
        </section>
      </div>

      <div class="clear"></div>
    </form>
  </div>
</div>