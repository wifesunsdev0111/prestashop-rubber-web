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


	if(!empty($_POST['form']) && (strcasecmp($_POST['form'], 'delete-install') === 0))
	{
		if(IDEALCHECKOUT_INSTALL::deleteFolder('/idealcheckout/install'))
		{
			// echo "<br>\n" . 'DEBUG: ' . __FILE__ . ' : ' . __LINE__ . "<br>\n";
		}

		if(IDEALCHECKOUT_INSTALL::deleteFile('/idealcheckout/configuration/install.php'))
		{
			// echo "<br>\n" . 'DEBUG: ' . __FILE__ . ' : ' . __LINE__ . "<br>\n";
		}

		header('Location: ../../');
		exit;
	}





	$sJavascript = '<script type="text/javascript">

	function goNext()
	{
		var sVal = jQuery(\'input[type="button"]:first\').val();
		var bRedirect = true;

		if(sVal.length > 0)
		{
			bRedirect = confirm(\'Wilt u verder gaan zonder de installatie map te verwijderen?\');
		}

		if(bRedirect)
		{
			window.location.href = \'../../\';
		}
	}

</script>';
	

	$sHtml = '
	<tr>
		<td><h1>Installatie wizard voltooid</h1></td>
	</tr>
	<tr>
		<td>De installatie van de plugin is voltooid!</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><h2>Vragen of feedback</h2></td>
	</tr>
	<tr>
		<td>Mocht u vragen hebben over de installatie van onze plug-ins, of suggesties hebben om zaken te verbeteren, kijk dan op <a href="https://www.ideal-checkout.nl" target="_blank">www.ideal-checkout.nl</a>.</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><h2>Installatie wizard verwijderen</h2></td>
	</tr>
	<tr>
		<td>Verwijder a.u.b. de installatie map van uw webserver (/idealcheckout/install).</td>
	</tr>
	<tr>
		<td><form action="" method="post" name="delete-install" value=""><input name="form" type="hidden" value="delete-install"><input type="submit" value="Verwijderen"></form></td>
	</tr>
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
		<td align="right">' . $sJavascript . '<input onclick="javascript: goNext();" type="button" value="Afsluiten"></td>
	</tr>';


/*
	$sConfigFile = SOFTWARE_PATH . '/idealcheckout/configuration/install.php';

	if(is_file($sConfigFile))
	{
			$sHtml .= '
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><code>' . nl2br(htmlentities(file_get_contents($sConfigFile))) . '</code></td>
	</tr>
	<tr>
		<td><b>/idealcheckout/configuration/install.php</b></td>
	</tr>';
	}
*/


	IDEALCHECKOUT_INSTALL::output($sHtml);

?>