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
<!-- logs.tpl -->

<div id="logs_wrapper" class="ogone-panel">
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
                    <h2>{l s='Debug configuration' mod='ogone'}</h2>
                    <p class="ogone-subtitle">{l s='This section can help you in case of troubleshooting' mod='ogone'}</p>
                    <section>
                        <!-- OGONE_USE_LOG -->
                        <div class="form-group">
                            <label class="control-label col-lg-3">{l s='Activate log' mod='ogone'}</label>
                            <div class="col-lg-9">
                                <input type="checkbox" id="OGONE_USE_LOG" name="OGONE_USE_LOG" {if $OGONE_USE_LOG}checked="checked"{/if} />
                                <div class="ogone-help">{l s='If you choose this option, logs will be created and stocked on your server' mod='ogone'}</div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="ogone-config-block">
                    <section>
                        <div class="form-group ogone-submit">
                                <input type="submit" name="submitOgoneLog" value="{l s='Update settings' mod='ogone'}" />
                        </div>
                    </section>
                </div>
        </form>

        <hr/>

        {if $log_files}
            <div class="ogone-config-block">
                <h2>{l s='Log files' mod='ogone'}</h2>
                <p class="ogone-subtitle">{l s='You can download log files' mod='ogone'}</p>
                <table>
                    <thead>
                        <tr>
                            <th>{l s='File' mod='ogone'}</th>
                            <th>{l s='Creation date' mod='ogone'}</th>
                            <th>{l s='File size' mod='ogone'}</th>
                        </tr>
                    </thead>
                    {foreach $log_files as $log_file}
                        <tr>
                            <td>
                                <a href="{$log_file.url|escape:'htmlall':'UTF-8'}" >{$log_file.name|escape:'htmlall':'UTF-8'}</a>
                            </td>
                            <td>
                                {$log_file.dt|escape:'htmlall':'UTF-8'}
                            </td>
                            <td>
                                {$log_file.size|escape:'htmlall':'UTF-8'}	{l s='bytes' mod='ogone'}
                            </td>
                        </tr>
                    {/foreach}
                </table>

                <!-- <section>
                    <ul>
                        {foreach $log_files as $log_file}
                            <li>
                                <a href="{$log_file.url|escape:'htmlall':'UTF-8'}" >{$log_file.name|escape:'htmlall':'UTF-8'}</a>
                                <br />{$log_file.dt|escape:'htmlall':'UTF-8'}	- {$log_file.size|escape:'htmlall':'UTF-8'}	{l s='bytes' mod='ogone'}
                            </li>
                        {/foreach}
                    </ul>
                </section> -->
            </div>

            <form action="{$form_action|escape:'htmlall':'UTF-8'}" method="post" enctype="multipart/form-data">
                <div class="ogone-config-block">
                    <section>
                        <div class="form-group ogone-submit">
                            <input class="red-button" type="submit" name="submitOgoneClearLogs" value="{l s='Delete all log files' mod='ogone'}" />
                        </div>
                    </section>
                </div>
            </form>

            <div class="clear"></div>
        {/if}


          {if $upgrade_log_files}
            <div class="ogone-config-block">
                <h2>{l s='Upgrade log files' mod='ogone'}</h2>
                <p class="ogone-subtitle">{l s='You can download log files' mod='ogone'}</p>
                <table>
                    <thead>
                        <tr>
                            <th>{l s='File' mod='ogone'}</th>
                            <th>{l s='Creation date' mod='ogone'}</th>
                            <th>{l s='File size' mod='ogone'}</th>
                        </tr>
                    </thead>
                    {foreach $upgrade_log_files as $log_file}
                        <tr>
                            <td>
                                <a href="{$log_file.url|escape:'htmlall':'UTF-8'}" >{$log_file.name|escape:'htmlall':'UTF-8'}</a>
                            </td>
                            <td>
                                {$log_file.dt|escape:'htmlall':'UTF-8'}
                            </td>
                            <td>
                                {$log_file.size|escape:'htmlall':'UTF-8'}	{l s='bytes' mod='ogone'}
                            </td>
                        </tr>
                    {/foreach}
                </table>

                <!-- <section>
                    <ul>
                        {foreach $log_files as $log_file}
                            <li>
                                <a href="{$log_file.url|escape:'htmlall':'UTF-8'}" >{$log_file.name|escape:'htmlall':'UTF-8'}</a>
                                <br />{$log_file.dt|escape:'htmlall':'UTF-8'}	- {$log_file.size|escape:'htmlall':'UTF-8'}	{l s='bytes' mod='ogone'}
                            </li>
                        {/foreach}
                    </ul>
                </section> -->
            </div>

            <form action="{$form_action|escape:'htmlall':'UTF-8'}" method="post" enctype="multipart/form-data">
                <div class="ogone-config-block">
                    <section>
                        <div class="form-group ogone-submit">
                            <input class="red-button" type="submit" name="submitOgoneClearUpgradeLogs" value="{l s='Delete all upgrade log files' mod='ogone'}" />
                        </div>
                    </section>
                </div>
            </form>

            <div class="clear"></div>
        {/if}

</div>
<!-- /logs.tpl -->