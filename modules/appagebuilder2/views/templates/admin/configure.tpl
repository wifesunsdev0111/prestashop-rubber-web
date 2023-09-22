{* 
* @Module Name: AP Page Builder
* @Website: apollotheme.com - prestashop template provider
* @author Apollotheme <apollotheme@gmail.com>
* @copyright  2007-2015 Apollotheme
* @description: ApPageBuilder is module help you can build content for your shop
*}
<!-- @file modules\appagebuilder\views\templates\admin\configure -->
{$guide_box}{* HTML form , no escape necessary *}
<div class="panel">
	<h3><i class="icon icon-book"></i> {l s='Documentation' mod='appagebuilder'}</h3>
	<p>
        &raquo; {l s='Before Start You can click here to read guide' mod='appagebuilder'} :
        <ul>
            <li><a href="http://demothemes.info/prestashop/appagebuilder/guide/" target="_blank">{l s='Read Guide' mod='appagebuilder'}</a></li>
        </ul>
		&raquo; {l s='You can start with Ap Page Builder following steps' mod='appagebuilder'} :
		<ul>
			<li><a href="{$create_profile_link|escape:'html':'UTF-8'}" target="_blank">{l s='Create new Profile' mod='appagebuilder'}</a></li>
		</ul>
		&raquo; {l s='Others management function:' mod='appagebuilder'}
		<ul>
			<li><a href="{$profile_link|escape:'html':'UTF-8'}" target="_blank">{l s='Manager Profile' mod='appagebuilder'}</a>
				<span> - {l s='This function enables you to manage all profiles in the module. This function is useful when you\'re building plans before the home interface changes, the product page for the event discounts, holidays ... by changing the options Default profile' mod='appagebuilder'}</span>
			</li>
			<li><a href="{$position_link|escape:'html':'UTF-8'}" target="_blank">{l s='Manager Position' mod='appagebuilder'}</a>
				<span> - {l s='This function enables you to manage all of the position of all profiles. This function is useful when you have multiple profiles' mod='appagebuilder'}</span>
			</li>
			<li><a href="{$product_link|escape:'html':'UTF-8'}" target="_blank">{l s='Manager Product List Builder' mod='appagebuilder'}</a>
				<span> - {l s='A function to help you design the details of the composition of the products displayed in the list of products on the website.' mod='appagebuilder'}</span>
			</li>
		</ul>
	</p>
</div>
<div class="panel">
	<h3>
            <i class="icon icon-credit-card"></i> {l s='Sample Data' mod='appagebuilder'}
            <span class="panel-heading-action">
                <a class="list-toolbar-btn open-content" href="#">
                <i class="icon-plus"></i>
                </a>
            </span>
        </h3>
        <div class="panel-content-builder">
            <p>
            <strong>{l s='Here is my module page builder!' mod='appagebuilder'}</strong><br />
            {l s='Thanks to PrestaShop, now I have a great module.' mod='appagebuilder'}<br />
            {l s='You can configure it using the following configuration form.' mod='appagebuilder'}
            </p>
            <div class="alert alert-info">
                {l s='You can click here to import demo data' mod='appagebuilder'}
            </div>
            <a class="btn btn-default btn-primary" onclick="javascript:return confirm('{l s='Are you sure you want to install demo?' mod='appagebuilder'}')" href="{$module_link|escape:'html':'UTF-8'}&installdemo=1"><i class="icon-AdminTools"></i> {l s='Install Demo Data' mod='appagebuilder'}</a>
            <br/><br/>
            <div class="alert alert-info">
                {l s='You can download demo image in' mod='appagebuilder'}<br/>
                {l s='Then you can unzip and copy folder appagebuilder to themes/THEME_NAME/img/module' mod='appagebuilder'}
            </div>
            <a class="btn btn-default btn-primary" href="http://demothemes.info/prestashop/appagebuilder/appagebuilder.zip"><i class="icon-AdminCatalog"></i> {l s='Demo Image' mod='appagebuilder'}</a><br/>
						<br/><br/>
						<div class="alert alert-info">
                {l s='You can reset database' mod='appagebuilder'}<br/>
            </div>
						<a class="btn btn-default btn-primary" style="background-color:red" onclick="javascript:return confirm('{l s='Are you sure you want to reset data? All database will lost' mod='appagebuilder'}')" href="{$module_link|escape:'html':'UTF-8'}&resetmodule=1"><i class="icon-AdminTools"></i> {l s='Reset Data' mod='appagebuilder'}</a>
        </div>
</div>
<div class="panel">
	<h3>
            <i class="icon icon-credit-card"></i> {l s='Back-up and Update' mod='appagebuilder'}
            <span class="panel-heading-action">
                <a class="list-toolbar-btn open-content" href="#">
                <i class="icon-plus"></i>
                </a>
            </span>
        </h3>
        <div class="panel-content-builder">
            <div class="alert alert-info">
                {l s='Please click back-up button to back-up database' mod='appagebuilder'}
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <a class="btn btn-default" href="{$module_link|escape:'html':'UTF-8'}&backup=1">
                        <i class="icon-AdminParentPreferences"></i> {l s='Create Back-up' mod='appagebuilder'}
                    </a>                
                </div>
                
            </div>
            <br/>
            <div class="alert alert-info">
                {l s='You can select a file by date backup to restore data' mod='appagebuilder'}
            </div>
            <div class="row">
                <form class="defaultForm form-horizontal" action="{$module_link|escape:'html':'UTF-8'}" method="post" enctype="multipart/form-data" novalidate="">
                    <div class="col-sm-12">
                        {if $back_up_file}
                            <select name="backupfile" style="width:50%">
                            {foreach from=$back_up_file item=file name=Modulefile}
                                <option value="{$file|escape:'html':'UTF-8'}">{$file|escape:'html':'UTF-8'}</option>
                            {/foreach}
                            </select>
                        {else}
                            <i style="color:red">{l s='No file to select' mod='appagebuilder'}</i>
                        {/if}
                        <br/>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-default" name="restore">
                        {l s='Restore' mod='appagebuilder'}
                        </button>
                    </div>
                </form>
            </div>
						<br/>
            <div class="alert alert-warning">
                {l s='Delete position do not use (fix error when create profile)' mod='appagebuilder'}
            </div>
            <a class="btn btn-default" onclick="javascript:return confirm('{l s='Are you sure you want to Delete do not use position. Please back-up all thing before?' mod='appagebuilder'}')" href="{$module_link|escape:'html':'UTF-8'}&deleteposition=1">
                <i class="icon-AdminParentPreferences"></i> {l s='Delete do not use position' mod='appagebuilder'}</a>
						<br/>
            <br/>
            <div class="alert alert-info">
                {l s='Please click on update and correct button to update module to latest version. Please backup database and file before process' mod='appagebuilder'}
            </div>
            <a class="btn btn-default" onclick="javascript:return confirm('{l s='Are you sure you want to Update Database. Please back-up all thing before?' mod='appagebuilder'}')" href="{$module_link|escape:'html':'UTF-8'}&updatemodule=1">
                <i class="icon-AdminParentPreferences"></i> {l s='Update and Correct Module' mod='appagebuilder'}</a>
						
        </div>
</div>