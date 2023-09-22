{*
* 2007-2015 PrestaShop
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
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<!DOCTYPE HTML>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<!--[if gt IE 8]> <html class="no-js ie9"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<html{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if} {if isset($IS_RTL) && $IS_RTL} dir="rtl" class="rtl{if isset($LEO_DEFAULT_SKIN)} {$LEO_DEFAULT_SKIN}{/if}" {else} class="{if isset($LEO_DEFAULT_SKIN)}{$LEO_DEFAULT_SKIN}{/if}" {/if}>
	{include file="$tpl_dir./layout/setting.tpl"}
	<head>
		<meta charset="utf-8" />
		<title>{$meta_title|escape:'html':'UTF-8'}</title>
		{if isset($meta_description) AND $meta_description}
			<meta name="description" content="{$meta_description|escape:'html':'UTF-8'}" />
		{/if}
		{if isset($meta_keywords) AND $meta_keywords}
			<meta name="keywords" content="{$meta_keywords|escape:'html':'UTF-8'}" />
		{/if}
		<meta name="generator" content="PrestaShop" />
		<meta name="robots" content="{if isset($nobots)}no{/if}index,{if isset($nofollow) && $nofollow}no{/if}follow" />
		{if $ENABLE_RESPONSIVE}<meta name="viewport" content="width=device-width, minimum-scale=0.25, maximum-scale=1.6, initial-scale=1.0" />{/if}
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<link rel="icon" type="image/vnd.microsoft.icon" href="{$favicon_url}?{$img_update_time}" />
		<link rel="shortcut icon" type="image/x-icon" href="{$favicon_url}?{$img_update_time}" />
		{if isset($css_files)}
			{foreach from=$css_files key=css_uri item=media}
				<link rel="stylesheet" href="{$css_uri|escape:'html':'UTF-8'}" type="text/css" media="{$media|escape:'html':'UTF-8'}" />
			{/foreach}
		{/if}
		{if isset($js_defer) && !$js_defer && isset($js_files) && isset($js_def)}
			{$js_def}
			{foreach from=$js_files item=js_uri}
			<script type="text/javascript" src="{$js_uri|escape:'html':'UTF-8'}"></script>
			{/foreach}
		{/if}
		{$HOOK_HEADER}
		{if !$LOAD_CSS_TYPE}
			{if $ENABLE_RESPONSIVE}
			<link rel="stylesheet" type="text/css" href="{$content_dir}themes/{$LEO_THEMENAME}/css/responsive.css"/>
			{else}
			<link rel="stylesheet" type="text/css" href="{$content_dir}themes/{$LEO_THEMENAME}/css/non-responsive.css"/>
			{/if}
			{if isset($LEO_CSS)}{foreach from=$LEO_CSS key=css_uri item=media}
			<link rel="stylesheet" href="{$css_uri}" type="text/css" media="{$media}" />
			{/foreach}{/if}
			
			{if isset($LEO_SKIN_CSS)}
				{foreach from=$LEO_SKIN_CSS item=linkCss}
					{$linkCss}
				{/foreach}
			{/if}
		{/if}
		{if isset($CUSTOM_FONT)}
                {$CUSTOM_FONT}
		{/if}
		{if isset($LAYOUT_WIDTH)}
                {$LAYOUT_WIDTH}
		{/if}
		<link href='https://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
		<!--[if IE 8]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
		
	</head>
	<body{if isset($page_name)} id="{$page_name|escape:'html':'UTF-8'}"{/if} class="{if isset($page_name)}{$page_name|escape:'html':'UTF-8'}{/if}{if isset($body_classes) && $body_classes|@count} {implode value=$body_classes separator=' '}{/if}{if $hide_left_column} hide-left-column{else} show-left-column{/if}{if $hide_right_column} hide-right-column{else} show-right-column{/if}{if isset($content_only) && $content_only} content_only{/if} lang_{$lang_iso}  {if isset($LEO_LAYOUT_MODE)}{$LEO_LAYOUT_MODE}{/if}{if isset($USE_FHEADER) && $USE_FHEADER} keep-header{/if}{if isset($LEO_HEADER_STYLE)} {$LEO_HEADER_STYLE}{/if}{if $LEO_HEADER_STYLE!="header-hide-topmenu" && $LEO_SIDEBAR_MENU!="sidebar-hide"} double-menu{/if}">
	{if !isset($content_only) || !$content_only}
		{if isset($restricted_country_mode) && $restricted_country_mode}
			<section id="restricted-country">
				<p>{l s='You cannot place a new order from your country.'}{if isset($geolocation_country) && $geolocation_country} <span class="bold">{$geolocation_country|escape:'html':'UTF-8'}</span>{/if}</p>
			</section>
		{/if}
		{capture name='displayBanner'}{hook h='displayBanner'}{/capture}
			{if $smarty.capture.displayBanner}
				<div class="banner">
					{if isset($fullwidth_hook.displayBanner) AND $fullwidth_hook.displayBanner == 0}
						<div class="container">							
					{/if}
						{$smarty.capture.displayBanner}
							{if isset($fullwidth_hook.displayBanner) AND $fullwidth_hook.displayBanner == 0}							
					</div>
					{/if}
			</div>
		{/if}
		<section id="page" data-column="{$colValue}" data-type="{$LISTING_GRIG_MODE}">
			<!-- Header -->
			<header id="header" class="header-center">
				<section class="header-container">
					<div id="header-main" class="header-left">
						<div id="header_content">
							<div class="inner">
								{capture name='displayNav'}{hook h='displayNav'}{/capture}
								{if $smarty.capture.displayNav}
								<div id="topbar">
									{if isset($fullwidth_hook.displayNav) AND $fullwidth_hook.displayNav == 0}
									<div class="container">
									{/if}
										{$smarty.capture.displayNav}
									{if isset($fullwidth_hook.displayNav) AND $fullwidth_hook.displayNav == 0}
									</div>
									{/if}
								</div>
								{/if}
								<div class="top">
									{if isset($fullwidth_hook.displayTop) AND $fullwidth_hook.displayTop == 0}
									<div class="container">
									{/if}
										{if isset($HOOK_TOP)}{$HOOK_TOP}{/if}
									{if isset($fullwidth_hook.displayTop) AND $fullwidth_hook.displayTop == 0}
									</div>
									{/if}
								</div>
							</div>
						</div>
					</div>
				</section>
			</header>
			{if in_array($page_name,array('index'))}
				{capture name='displayTopColumn'}{hook h='displayTopColumn'}{/capture}
				{if $smarty.capture.displayTopColumn}
				<div id="slideshow" class="clearfix">					
					{if isset($fullwidth_hook.displayTopColumn) AND $fullwidth_hook.displayTopColumn == 0}
						<div class="container">
					{/if}
					{$smarty.capture.displayTopColumn}
					{if isset($fullwidth_hook.displayTopColumn) AND $fullwidth_hook.displayTopColumn == 0}				 
						</div>
					{/if}					
				</div>
				{/if}
			{/if}
			{if $page_name !='index' && $page_name !='pagenotfound'}
				<div id="breadcrumb" class="clearfix">
					<div class="container">		
						{include file="$tpl_dir./breadcrumb.tpl"}	
					</div>
				</div>
			{/if}
			<!-- Content -->
			<section id="columns" class="columns-container">
				{if isset($fullwidth_hook.displayHome) AND $fullwidth_hook.displayHome == 0}
					<div class="container">
					<div class="row">
				{else}         
					<div class="row">
				{/if}                               
                        {if isset($left_column_size) && !empty($left_column_size)}
						<!-- Left -->
						<section id="left_column" class="column sidebar col-md-{$left_column_size|intval}">
								{$HOOK_LEFT_COLUMN}
						</section>
						{/if}
						{if isset($left_column_size) && isset($right_column_size)}{assign var='cols' value=(12 - $left_column_size - $right_column_size)}{else}{assign var='cols' value=12}{/if}
						<!-- Center -->
						<section id="center_column" class="col-md-{$cols|intval}">
	{/if}
