{*
* 2007-2014 PrestaShop
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
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{capture name=path}{l s='Manufacturers:'}{/capture}

<h1 class="page-heading product-listing">
	{l s='Brands'}
    {strip}
		<small class="heading-counter">
			{if $nbManufacturers == 0}{l s='There are no manufacturers.'}
			{else}
				{if $nbManufacturers == 1}
					{l s='There is 1 brand'}
				{else}
					{l s='There are %d brands' sprintf=$nbManufacturers}
				{/if}
			{/if}
		</small>
    {/strip}
</h1>
{if isset($errors) AND $errors}
	{include file="$tpl_dir./errors.tpl"}
{else}
	{if $nbManufacturers > 0}
		

        {assign var='nbItemsPerLine' value=3}
        {assign var='nbItemsPerLineTablet' value=2}
        {assign var='nbLi' value=$manufacturers|@count}
        {math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
        {math equation="nbLi/nbItemsPerLineTablet" nbLi=$nbLi nbItemsPerLineTablet=$nbItemsPerLineTablet assign=nbLinesTablet}

		<ul id="manufacturers_list" class="list">
			{foreach from=$manufacturers item=manufacturer name=manufacturers}
	        	{math equation="(total%perLine)" total=$smarty.foreach.manufacturers.total perLine=$nbItemsPerLine assign=totModulo}
	            {math equation="(total%perLineT)" total=$smarty.foreach.manufacturers.total perLineT=$nbItemsPerLineTablet assign=totModuloTablet}
	            {if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
	            {if $totModuloTablet == 0}{assign var='totModuloTablet' value=$nbItemsPerLineTablet}{/if}
				<li class="{if $smarty.foreach.manufacturers.iteration%$nbItemsPerLine == 0} last-in-line{elseif $smarty.foreach.manufacturers.iteration%$nbItemsPerLine == 1} first-in-line{/if} {if $smarty.foreach.manufacturers.iteration > ($smarty.foreach.manufacturers.total - $totModulo)}last-line{/if} {if $smarty.foreach.manufacturers.iteration%$nbItemsPerLineTablet == 0}last-item-of-tablet-line{elseif $smarty.foreach.manufacturers.iteration%$nbItemsPerLineTablet == 1}first-item-of-tablet-line{/if} {if $smarty.foreach.manufacturers.iteration > ($smarty.foreach.manufacturers.total - $totModuloTablet)}last-tablet-line{/if}{if $smarty.foreach.manufacturers.last} item-last{/if}">
					<div class="mansup-container">
						<div class="row"> 
			            	<div class="left-side col-xs-12 col-sm-3">
								<div class="logo">
									{if $manufacturer.nb_products > 0}
										<a
										class="lnk_img" 
										href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}" 
										title="{$manufacturer.name|escape:'html':'UTF-8'}" >
									{/if}
										<img src="{$img_manu_dir}{$manufacturer.image|escape:'html':'UTF-8'}-medium_default.jpg" alt="" />
									{if $manufacturer.nb_products > 0}
										</a>
									{/if}
								</div> <!-- .logo -->
							</div> <!-- .left-side -->
						
							<div class="middle-side col-xs-12 col-sm-5">
								<h3>
									{if $manufacturer.nb_products > 0}
										<a 
										class="product-name" 
										href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}">
									{/if}
										{$manufacturer.name|truncate:60:'...'|escape:'html':'UTF-8'}
									{if $manufacturer.nb_products > 0}
										</a>
									{/if}
								</h3>
								<div class="description rte">
									{$manufacturer.short_description}
								</div>
			                </div> <!-- .middle-side -->

							<div class="right-side col-xs-12 col-sm-4">
			                	<div class="right-side-content">
			                        <p class="product-counter">
			                            {if $manufacturer.nb_products > 0}
			                            	<a href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}">
			                            {/if}
			                            {if $manufacturer.nb_products == 1}
			                            	{l s='%d product' sprintf=$manufacturer.nb_products|intval}
			                            {else}
			                            	{l s='%d products' sprintf=$manufacturer.nb_products|intval}
			                            {/if}
			                            {if $manufacturer.nb_products > 0}
			                        		</a>
			                        	{/if}
			                        </p>
				                    {if $manufacturer.nb_products > 0}
				                        <a 
				                        class="btn btn-outline button exclusive-medium" 
				                        href="{$link->getmanufacturerLink($manufacturer.id_manufacturer, $manufacturer.link_rewrite)|escape:'html':'UTF-8'}">
				                        	<span>
				                        		{l s='view products'}
				                        	</span>
				                        </a>
				                    {/if}
			                    </div>
			                </div> <!-- .right-side -->
			            </div>
			        </div>
				</li>
			{/foreach}
		</ul>
        
		
	{/if}
{/if}
