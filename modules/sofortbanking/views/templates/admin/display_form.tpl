{**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@touchdesign.de so we can send you a copy immediately.
 *}

{literal}
<style type="text/css">
fieldset a {
    color:#0099ff !important;
    text-decoration:underline;
}
fieldset a:hover {
    color:#000000;
    text-decoration:underline;
}
.level1 {
    font-size:1.2em
}
.level2 {
    font-size:0.9em
}
</style>
{/literal}


<form method="post" action="{$sofort.dfl.action|escape:'htmlall':'UTF-8'}" class="form-horizontal">
	<div class="panel">	
		<div class="panel-heading">
			 {l s='Over SOFORT Banking' mod='sofortbanking'}
		</div>
		
		<div class="row">
			<div class="col-xs-12">
				<p>
					<b>{l s='SOFORT Banking is the direct payment method of SOFORT AG. SOFORT Banking allows the buyer to directly and automatically trigger a credit transfer during his online purchase with them online banking information. A transfer order is instantly confirmed to merchant allowing an instant delivery of goods and services. So you can send stock items and digital goods immediately - you will receive your purchases quickly. More about SOFORT Banking and SOFORT AG' mod='sofortbanking'}</b> <a target="_blank" href="https://sofort.com/"><b>{l s='sofort.com.' mod='sofortbanking'}</b></a>
				</p>		
			</div>
		</div>
	</div>
	
	<div class="panel">	
		<div class="panel-heading">
			 {l s='Setup and Configuration' mod='sofortbanking'}
		</div>
		
		<div class="row">
			<div class="col-xs-12">
				<p>
					<b>{l s='To use SOFORT Banking a few steps are necessary:' mod='sofortbanking'}</b>
				</p>
				<p>
					{l s='In order to offer SOFORT Banking you need a customer account with the SOFORT AG. You are not a customer?' mod='sofortbanking'}
        			<a target="_blank" href="https://www.sofortueberweisung.de/payment/users/register/1146"><b>{l s='Register now!' mod='sofortbanking'}</b></a>
				</p>		
			</div>
		</div>
	</div>
	
	<div class="panel">
		<div class="panel-heading">
			 {l s='Module configuration' mod='sofortbanking'}
		</div>
		
		<div class="row">
			<div class="col-xs-12">
				<p>
					{l s='Please leave your SOFORT-Project data and passwords in the fields below:' mod='sofortbanking'}
				</p>		
			</div>
		</div>
		
		<div class="form-wrapper">
		<ps-input-text name="SOFORTBANKING_USER_ID" label="{l s='User ID?' mod='sofortbanking'}" help="{l s='Leave it blank for disabling' mod='sofortbanking'}" size="10" value="{$sofort.config.SOFORTBANKING_USER_ID|escape:'htmlall':'UTF-8'}" required-input="true" fixed-width="lg"></ps-input-text>
		
		<ps-input-text name="SOFORTBANKING_PROJECT_ID" label="{l s='Project ID?' mod='sofortbanking'}" help="{l s='Leave it blank for disabling' mod='sofortbanking'}" size="10" value="{$sofort.config.SOFORTBANKING_PROJECT_ID|escape:'htmlall':'UTF-8'}" required-input="true" fixed-width="lg"></ps-input-text>
		
		<ps-input-text name="SOFORTBANKING_API_KEY" label="{l s='API Key?' mod='sofortbanking'}" help="{l s='Leave it blank for disabling' mod='sofortbanking'}" size="10" value="{$sofort.config.SOFORTBANKING_API_KEY|escape:'htmlall':'UTF-8'}" required-input="true" fixed-width="lg"></ps-input-text>
	
		<ps-select label="{l s='Order accepted status' mod='sofortbanking'}" name="SOFORTBANKING_OS_ACCEPTED" chosen='true' help="{l s='Order state for accepted payments' mod='sofortbanking'}">
			{$sofort.order_states.accepted|escape:'quotes':'UTF-8'}
		</ps-select>
		
		<ps-switch name="SOFORTBANKING_OS_ACCEPTED_IGNORE" label="{l s='No status update for this event' mod='sofortbanking'}" yes="Yes" no="No" active="{if $sofort.config.SOFORTBANKING_OS_ACCEPTED_IGNORE == "Y"}true{else}false{/if}" ></ps-switch>
	
		<ps-select label="{l s='Order error status' mod='sofortbanking'}" name="SOFORTBANKING_OS_ERROR" chosen='true' help="{l s='Order state for failed payments' mod='sofortbanking'}">
			{$sofort.order_states.error|escape:'quotes':'UTF-8'}
		</ps-select>
		
		<ps-switch name="SOFORTBANKING_OS_ERROR_IGNORE" label="{l s='No status update for this event' mod='sofortbanking'}" yes="Yes" no="No" active="{if $sofort.config.SOFORTBANKING_OS_ERROR_IGNORE == "Y"}true{else}false{/if}" ></ps-switch>	
		
		</div>
		
		<div class="panel-footer">
			<button type="submit" value="1"	id="submitUpdate" name="submitUpdate" class="btn btn-default pull-right">
				<i class="process-icon-save"></i> {l s='Save' mod='sofortbanking'}
			</button>
		</div>		
		
	</div>
	
	<div class="panel">	
		<div class="panel-heading">
			 {l s='Help' mod='sofortbanking'}
		</div>
		
		<div class="row">
			<div class="col-xs-12">
				<p>
    				<b>{l s='For detailed instructions, please visit our' mod='sofortbanking'}</b> <a target="_blank" href="https://www.sofort.com/integrationCenter-ger-DE/integration/shopsysteme/PrestaShop/"><b>{l s='Website' mod='sofortbanking'}</b></a>.<br /><br />
    				<b>{l s='We can assist you when ordering. Simply contact our' mod='sofortbanking'}</b> <a target="_blank" href="https://addons.prestashop.com/de/Write-to-developper?id_product=9176"><b>{l s='Support.' mod='sofortbanking'}</b></a><br />
				</p>		
			</div>
		</div>
	</div>
</form>

