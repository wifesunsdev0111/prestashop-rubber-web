{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\admin\guide -->
<div class="alert alert-onboarding"><div class="" id="onboarding-starter">
	<div class="row">
		<div class="col-md-12">
			<h3>{l s='Getting Started with AP PAGE BUILDER' mod='appagebuilder'}</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4 col-md-3 col-md-offset-2">
			<div class="onboarding-step step-first {if $step == 1}active step-in-progress{else if $step > 1}active step-success{else}step-todo{/if}"></div>
		</div>
		<div class="col-xs-4 col-md-3">
			<div class="onboarding-step {if $step == 2}active step-in-progress{else if $step > 2}active step-success{else}step-todo{/if}"></div>
		</div>
		<div class="col-xs-4 col-md-3">
			<div class="onboarding-step step-final {if $step == 3}active step-in-progress{else}step-todo{/if}"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4 col-md-3 col-md-offset-2 text-center">
			<a href="{$url1|escape:'html':'UTF-8'}" style="">{l s='Configure Module' mod='appagebuilder'}</a>
		</div>
		<div class="col-xs-4 col-md-3 text-center">
			{if $step >= 2}
			<a href="{$url2|escape:'html':'UTF-8'}" style="">
			{else}
			<a style=" color:gray; text-decoration:none ">
			{/if}
				{l s='Add profile' mod='appagebuilder'}</a>
		</div>
		<div class="col-xs-4 col-md-3 text-center">
			{if $step >= 3}
			<a href="{$url3|escape:'html':'UTF-8'}" style="">
			{else}
			<a style=" color:gray; text-decoration:none ">
			{/if}{l s='Add widget' mod='appagebuilder'}</a>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-lg-8 {if $step != 1}hidden{/if}">
			<h4>{l s='Establish default parameters' mod='appagebuilder'}</h4>
			<p>{l s='This module provides a way to generate more website templates homepage, quickly changing your website, the list displays the product, multiple widgets with many selling feature for your shop (all in one).' mod='appagebuilder'}</p>
		</div>
		<div class="col-lg-8 {if $step != 2}hidden{/if}">
			<h4>{l s='Create new a profile' mod='appagebuilder'}</h4>
			<p>{l s='You can create multiple profiles, only one profile, the default will be triggered when the website is published. Each profile you can customize the interface to change independently of each other website, JavaScript and Css code to be edited directly here should become more flexible.' mod='appagebuilder'}</p>
			<p>{l s='How to create a new profile screen: From the menu on the left "Ap Manage Profiles" to the next screen lists Profile; Click the button "Add new +"' mod='appagebuilder'}</p>
		</div>
		<div class="col-lg-8 {if $step != 3}hidden{/if}">
			<h4>{l s='Add new widgets and modules to build Web sites in a profile.' mod='appagebuilder'}</h4>
			<p>{l s='This module also supply many widgets to build features for sales, intuitive user interface flexibility. Also integrate your existing modules in this module, you only need to build a site built just here and become faster page.' mod='appagebuilder'}</p>
			<p>{l s='How to create a new profile screen: From the menu on the left "Ap Manage Profiles" to the next screen lists Profile; click the button "View" in the list of profiles.' mod='appagebuilder'}</p>
		</div>
		<div class="col-lg-4 onboarding-action-container">
			<a class="btn btn-default btn-lg quick-start-button pull-right" href="{$next_step|escape:'html':'UTF-8'}{if $step == 3}&done=1{/if}">
				{if $step == 3}
					<i class="icon icon-check icon-lg"></i>
					{l s='DONE  ' mod='appagebuilder'}
				{else}
					{l s='I\'m done, take me to next step  ' mod='appagebuilder'}
					<i class="icon icon-angle-right icon-lg"></i>
				{/if}
			</a>
			{if $step < 3}
				<a class="btn btn-lg quick-start-button pull-right" href="{if $step == 1}{$url1|escape:'html':'UTF-8'}{else}{$url2|escape:'html':'UTF-8'}{/if}&skip=1">{l s='Skip  ' mod='appagebuilder'}</a>
			{/if}
		</div>
	</div>
</div></div>