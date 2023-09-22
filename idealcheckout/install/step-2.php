<?php

	require_once(dirname(dirname(__FILE__)) . '/includes/library.php');
	require_once(dirname(__FILE__) . '/includes/install.php');
	require_once(dirname(__FILE__) . '/includes/ftp.cls.php');
	require_once(dirname(__FILE__) . '/includes/settings.php');

	if(empty($_REQUEST['software']) || empty($_REQUEST['settings']))
	{
		header('Location: index.php');
		exit;
	}

	$sInstructionsHtml = '';

	if(is_callable($_REQUEST['software'] . '::getInstructions'))
	{
		$sInstructionsHtml = call_user_func($_REQUEST['software'] . '::getInstructions', $_REQUEST['settings']); // $_REQUEST['software']::getInstructions($_REQUEST['settings']);
	}


	$sAdminUrl = false;

	if(is_callable($_REQUEST['software'] . '::getAdminUrl'))
	{
		$sAdminUrl = call_user_func($_REQUEST['software'] . '::getAdminUrl'); // $_REQUEST['software']::getAdminUrl();
	}

	if(empty($sAdminUrl))
	{
		$sAdminUrl = idealcheckout_getRootUrl(2);
	}


	$sHtml = '
	<tr>
		<td><h1>Betaalmethoden activeren</h1></td>
	</tr>
	<tr>
		<td>Om de betaalmethoden voor uw klanten beschikbaar te maken in uw webshop, moeten deze eerst geactiveerd/ingeschakeld worden via de <a href="' . htmlentities($sAdminUrl) . '" target="_blank">beheeromgeving van uw webshop</a>.<br><br><span class="lightbulb">Activeer alleen de betaalmethoden die ondersteund worden bij het abonnement dat u, bij uw Bank of Payment Service Provider, heeft afgesloten.</span></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>';


	if(empty($sInstructionsHtml))
	{
		$sHtml .= '
	<tr>
		<td><h1>Instructies</h1></td>
	</tr>
	<tr>
		<td>Door in te loggen op de beheeromgeving van uw website kunt u de gewenste betaalmethoden in- en uitschakelen voor uw klanten.</td>
	</tr>';
	}
	else
	{
		$sHtml .= '
	<tr>
		<td><h1>Instructies</h1></td>
	</tr>
	<tr>
		<td>' . $sInstructionsHtml . '</td>
	</tr>';
	}


	$sHtml .= '
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><hr size="1"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right"><input onclick="javascript: window.location.href = \'step-3.php\';" type="button" value="Verder"></td>
	</tr>';


	IDEALCHECKOUT_INSTALL::output($sHtml);

?>