{**
* 2007-2018 PrestaShop
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
*  @copyright  2007-2018 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<div class="slider-menu">
{if $aeihomeslider.slides}
<div id="slideshow">
	<div class="slideshow-container" data-interval="{$aeihomeslider.speed}" data-wrap="true"  data-pause="{$aeihomeslider.pause}">
		<div class="loadingdiv spinner"></div>
		<ul class="slides aeisliders">
			{foreach from=$aeihomeslider.slides item=slide}
				<li class="slide">
					<a href="{$slide.url}" title="{$slide.legend}">
					<img src="{$slide.image_url}" alt="{$slide.legend}" title="{$slide.title}" />
					</a>
					{if $slide.title || $slide.description }
					<span class="slider-text caption">	
						<h2>{$slide.title}</h2>
						<div class="caption-description">
							{$slide.description nofilter}
						</div>
					</span>	
					{/if}					
				</li>
			{/foreach}
		</ul>
	</div>
</div>
{/if}
</div>

