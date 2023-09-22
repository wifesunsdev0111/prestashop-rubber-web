<?php

	require_once(dirname(dirname(__FILE__)) . '/includes/library.php');
	require_once(dirname(__FILE__) . '/includes/install.php');
	require_once(dirname(__FILE__) . '/includes/ftp.cls.php');
	require_once(dirname(__FILE__) . '/includes/settings.php');



	// Set default ftp & db values
	$aFormValues = array();
	$aFormValues['code'] = call_user_func($_REQUEST['software'] . '::getSoftwareCode'); // $_REQUEST['software']::getSoftwareCode();
	$aFormValues['software'] = call_user_func($_REQUEST['software'] . '::getSoftwareName'); // $_REQUEST['software']::getSoftwareName();

	$aFormValues['ftp_host'] = $_SERVER['SERVER_ADDR'];
	$aFormValues['ftp_port'] = '21';
	$aFormValues['ftp_user'] = '';
	$aFormValues['ftp_pass'] = '';
	$aFormValues['ftp_path'] = '';
	$aFormValues['ftp_success'] = '';
	$aFormValues['ftp_error'] = '';

	$aFormValues['db_host'] = 'localhost';
	$aFormValues['db_port'] = '';
	$aFormValues['db_user'] = '';
	$aFormValues['db_pass'] = '';
	$aFormValues['db_name'] = '';
	$aFormValues['db_prefix'] = '';
	$aFormValues['db_type'] = (version_compare(PHP_VERSION, '5.3', '>') ? 'mysqli' : 'mysql');
	$aFormValues['db_success'] = '';
	$aFormValues['db_error'] = '';

	$aFormValues['software_url'] = idealcheckout_getRootUrl(2);

	$aFormErrors = array();

	foreach($aFormValues as $k => $v)
	{
		$aFormErrors[$k] = false;
	}

	$bServerError = false;
	$bFtpError = false;
	$bDatabaseError = false;
	$bDatabaseAutodetect = false;
	$aFtpRootPaths = array();


	$aDatabaseSettings = call_user_func($_REQUEST['software'] . '::getDatabaseSettings', $aFormValues); //$_REQUEST['software']::getDatabaseSettings($aFormValues);
	$aDatabaseErrors = array();

	if(IDEALCHECKOUT_INSTALL::testDatabaseSettings($aDatabaseSettings, $aDatabaseErrors))
	{
		$bDatabaseAutodetect = true;
		
		$aFormValues = array_merge($aFormValues, $aDatabaseSettings);		
	}


	$iDisplayErrors = @ini_get('display_errors');

	$bFirewallCheck = IDEALCHECKOUT_INSTALL::testFirewall();
	$bIdealcheckoutCurlVerificationError = idealcheckout_getCurlVerificationError();

	if(!$bFirewallCheck)
	{
		$bServerError = true;
	}

	if(sizeof($_POST))
	{
		// Check FTP settings
		if(FTP_ACCESS_REQUIRED)
		{
			$aFormValues['ftp_host'] = (empty($_POST['ftp_host']) ? '' : $_POST['ftp_host']);
			$aFormValues['ftp_port'] = (empty($_POST['ftp_port']) ? 0 : intval($_POST['ftp_port']));
			$aFormValues['ftp_user'] = (empty($_POST['ftp_user']) ? '' : $_POST['ftp_user']);
			$aFormValues['ftp_pass'] = (empty($_POST['ftp_pass']) ? '' : $_POST['ftp_pass']);
			$aFormValues['ftp_passive'] = 0;

			if($aFormValues['ftp_host'] && $aFormValues['ftp_user'] && $aFormValues['ftp_pass'] && $aFormValues['ftp_port'])
			{
				// Test FTP ROOT & PATH
				$oFtp = new clsFtp();

				if($oFtp->connect($aFormValues['ftp_host'], $aFormValues['ftp_user'], $aFormValues['ftp_pass'], $aFormValues['ftp_port'], 0, true))
				{
					$sLocalPath = IDEALCHECKOUT_PATH;
					$sRemotePath = $oFtp->findRemotePath($sLocalPath);

					if($sRemotePath)
					{
						// Cut of '/idealcheckout'
						$sRemotePath = substr($sRemotePath, 0, -14);
						$aFormValues['ftp_path'] = $sRemotePath;

						IDEALCHECKOUT_INSTALL::addLog('Found remote path: ' . $sRemotePath);

						$aFormValues['ftp_success'] = 'FTP settings valid! Found path: ' . $sRemotePath;
						$aFormValues['ftp_error'] = '';
					}
					else
					{
						IDEALCHECKOUT_INSTALL::addLog('Cannot find remote path: ' . $sRemotePath);

						$bFtpError = true;
						$aFormErrors['ftp_path'] = true;

						$aFormValues['ftp_success'] = '';
						$aFormValues['ftp_error'] = 'FTP settings failed. Cannot detect installation folder.';
					}
				}
				else
				{
					$bFtpError = true;
					$aFormErrors['ftp_host'] = true;
					$aFormErrors['ftp_port'] = true;
					$aFormErrors['ftp_user'] = true;
					$aFormErrors['ftp_pass'] = true;

					$aFormValues['ftp_success'] = '';
					$aFormValues['ftp_error'] = 'FTP settings failed. Please check your settings.';
				}
			}
			else
			{
				$bFtpError = true;
				$aFormErrors['ftp_host'] = empty($aFormValues['ftp_host']);
				$aFormErrors['ftp_port'] = empty($aFormValues['ftp_port']);
				$aFormErrors['ftp_user'] = empty($aFormValues['ftp_user']);
				$aFormErrors['ftp_pass'] = empty($aFormValues['ftp_pass']);

				$aFormValues['ftp_success'] = '';
				$aFormValues['ftp_error'] = 'Some FTP settings are empty. Please check your settings.';
			}
		}


		// Check DB settings
		if(!$bDatabaseAutodetect)
		{
			$aFormValues['db_host'] = (empty($_POST['db_host']) ? '' : $_POST['db_host']);
			$aFormValues['db_port'] = (empty($_POST['db_port']) ? '' : intval($_POST['db_port']));
			$aFormValues['db_user'] = (empty($_POST['db_user']) ? '' : $_POST['db_user']);
			$aFormValues['db_pass'] = (empty($_POST['db_pass']) ? '' : $_POST['db_pass']);
			$aFormValues['db_name'] = (empty($_POST['db_name']) ? '' : $_POST['db_name']);
			$aFormValues['db_prefix'] = (empty($_POST['db_prefix']) ? '' : $_POST['db_prefix']);
			$aFormValues['db_type'] = (empty($_POST['db_type']) ? '' : $_POST['db_type']);

			if(!in_array($aFormValues['db_type'], array('mysql', 'mysqli')))
			{
				$aFormValues['db_type'] = (version_compare(PHP_VERSION, '5.3', '>') ? 'mysqli' : 'mysql');
			}

			if(!empty($aFormValues['db_prefix']))
			{
				$aFormValues['db_prefix'] = preg_replace('/[^a-zA-Z0-9_]+/i', '', $aFormValues['db_prefix']);
			}
		}
	
		if($bDatabaseAutodetect || IDEALCHECKOUT_INSTALL::testDatabaseSettings($aFormValues, $aFormErrors))
		{
			$aFormValues['db_success'] = 'Database settings valid!';

			// Save settings to database file
			$sFileData = '<' . '?' . 'php

	// MySQL Server/Host
	$aSettings[\'host\'] = \'' . idealcheckout_escapeQuotes($aFormValues['db_host'] . ($aFormValues['db_port'] ? ':' . $aFormValues['db_port'] : '')) . '\';

	// MySQL Username
	$aSettings[\'user\'] = \'' . idealcheckout_escapeQuotes($aFormValues['db_user']) . '\';

	// MySQL Password
	$aSettings[\'pass\'] = \'' . idealcheckout_escapeQuotes($aFormValues['db_pass']) . '\';

	// MySQL Database name
	$aSettings[\'name\'] = \'' . idealcheckout_escapeQuotes($aFormValues['db_name']) . '\';

	// MySQL Table Prefix
	$aSettings[\'prefix\'] = \'' . idealcheckout_escapeQuotes($aFormValues['db_prefix']) . '\';

	// MySQL Library (MySQL or MySQLi)
	$aSettings[\'type\'] = \'' . idealcheckout_escapeQuotes($aFormValues['db_type']) . '\';

?' . '>';

			if(!FTP_ACCESS_REQUIRED || !$bFtpError)
			{
				if(!IDEALCHECKOUT_INSTALL::setFile('/idealcheckout/configuration/database.php', $sFileData, $aFormValues))
				{
					IDEALCHECKOUT_INSTALL::output('<p>Cannot save database settings to: /idealcheckout/configuration/database.php</p>');
				}
			}
		}
		else
		{
			$bDatabaseError = true;
		}
	}


	$bOpensslHeartbleed = false;

	if(defined('OPENSSL_VERSION_TEXT'))
	{
		if(strpos(OPENSSL_VERSION_TEXT, '1.0.1 ') || strpos(OPENSSL_VERSION_TEXT, '1.0.1a') || strpos(OPENSSL_VERSION_TEXT, '1.0.1b') || strpos(OPENSSL_VERSION_TEXT, '1.0.1c') || strpos(OPENSSL_VERSION_TEXT, '1.0.1d') || strpos(OPENSSL_VERSION_TEXT, '1.0.1e') || strpos(OPENSSL_VERSION_TEXT, '1.0.1f'))
		{
			$bOpensslHeartbleed = true;
		}
	}

	if(sizeof($_POST) && !in_array(true, array($bServerError, $bFtpError, $bDatabaseError)) && !in_array(true, $aFormErrors))
	{
		// Save settings in /idealcheckout/configuration/install.php
		$sFileData = '<' . '?' . 'php

return ' . str_replace("\r", "", var_export($aFormValues, true)) . ';

?' . '>';


		if(!IDEALCHECKOUT_INSTALL::setFile('/idealcheckout/configuration/install.php', $sFileData, $aFormValues))
		{
			// echo "<br>\n" . 'DEBUG: ' . __FILE__ . ' : ' . __LINE__ . "<br>\n";
			idealcheckout_output('Kan het bestand /idealcheckout/configuration/install.php niet aanmaken. Controleer de schrijfrechten op de map /idealcheckout/configuration/');
		}


		// Execute queries for installation
		$aInstallResult = call_user_func($_REQUEST['software'] . '::doInstall', $aFormValues); // $_REQUEST['software']::doInstall($aFormValues);

		if(is_array($aInstallResult) && is_bool($aInstallResult[0]) && !$aInstallResult[0])
		{
			idealcheckout_output($aInstallResult[1]);
		}
		elseif(is_bool($aInstallResult) && !$aInstallResult)
		{
			idealcheckout_output('Er is een fout opgetreden bij de installatie van de scripts.');
		}
		elseif(is_string($aInstallResult))
		{
			idealcheckout_output($aInstallResult);
		}

		// Redirect to step 2
		header('Location: step-2.php');
		exit;
	}



	$sHtml = '
	<tr>
		<td colspan="3"><h1>Software</h1></td>
	</tr>
	<tr>
		<td width="150"><b>Software Pakket</b></td>
		<td width="auto">' . htmlentities($aFormValues['software']) . '</td>
		<td width="16"><div class="status ' . ($aFormErrors['software'] ? 'nok' : 'ok') . '"></div></td>
	</tr>
	<tr>
		<td width="150"><b>Webshop URL</b></td>
		<td width="auto">' . htmlentities($aFormValues['software_url']) . '</td>
		<td width="16"><div class="status ok"></div></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"><hr size="1"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"><h1>Server</h1></td>
	</tr>';

	if($iDisplayErrors)
	{
		$sHtml .= '
	<tr>
		<td colspan="3"><div class="warning">De optie &quot;DISPLAY_ERRORS&quot; in uw PHP configuratie staat aan! Dit is prima voor een TEST omgeving, maar voor een live website/webshop raden wij u sterk aan deze uit te zetten.<br>Raadpleeg uw server beheerder voor de mogelijkheden!!</div></td>
	</tr>';
	}

	if(!empty($aFormValues['server_success']))
	{
		$sHtml .= '
	<tr>
		<td colspan="3"><div class="success">' . nl2br(htmlentities($aFormValues['server_success'])) . '</div></td>
	</tr>';
	}
	elseif(!empty($aFormValues['server_error']))
	{
		$sHtml .= '
	<tr>
		<td colspan="3"><div class="error">' . nl2br(htmlentities($aFormValues['server_error'])) . '</div></td>
	</tr>';
	}

	if(!$bFirewallCheck)
	{
		$sHtml .= '
	<tr>
		<td colspan="3"><div class="error">De Firewall op de server blokkeerd cURL/FSock. Veel webshoppakketten en Banken/Payment Service Providers maken gebruik van cURL/FSock om onderling gegevens uit te wisselen.<br>Raadpleeg uw server beheerder voor de mogelijkheden!!</div></td>
	</tr>';
	}
	elseif($bIdealcheckoutCurlVerificationError)
	{
		$sHtml .= '
	<tr>
		<td colspan="3"><div class="error">OpenSSL lijkt verkeerd geconfigureerd waardoor SSL certificaten niet goed kunnen worden geverifieerd. Mogelijk is op uw server de &quot;ca-bundle.crt&quot; niet correct geinstalleerd. <b>Neem contact op met uw hosting provider!!</b></div></td>
	</tr>';
	}

	if($bOpensslHeartbleed)
	{
		$sHtml .= '
	<tr>
		<td colspan="3"><div class="error">De versie van OpenSSL op uw webserver is onveilig! Zie: <a href="http://www.heartbleed.com">The Heartbleed Bug</a>.<br>Laat uw server beheerder OpenSSL z.s.m. bijwerken!!</div></td>
	</tr>';
	}



	$sHtml .= '
	<tr>
		<td><b>PHP Versie</b></td>
		<td>' . PHP_VERSION . '</td>
		<td><div class="status ok"></div></td>
	</tr>
	<tr>
		<td><b>OPENSSL Bibliotheek</b></td>
		<td>' . ((function_exists('openssl_sign') && defined('OPENSSL_VERSION_TEXT')) ? 'Geinstalleerd &nbsp; <i>(Versie: ' . OPENSSL_VERSION_TEXT . ')</i>' : 'Niet geinstalleerd') . '</td>
		<td><div class="status ' . ((function_exists('openssl_sign') && defined('OPENSSL_VERSION_TEXT') && !$bOpensslHeartbleed) ? 'ok' : 'nok') . '"></div></td>
	</tr>
	<tr>
		<td><b>FSOCK Bibliotheek</b></td>
		<td>' . (function_exists('fsockopen') ? 'Geinstalleerd' : 'Niet geinstalleerd') . '</td>
		<td><div class="status ' . (function_exists('fsockopen') ? 'ok' : 'nok') . '"></div></td>
	</tr>
	<tr>
		<td><b>CURL Bibliotheek</b></td>
		<td>' . (function_exists('curl_init') ? 'Geinstalleerd' : 'Niet geinstalleerd') . '</td>
		<td><div class="status ' . (function_exists('curl_init') ? 'ok' : 'nok') . '"></div></td>
	</tr>
	<tr>
		<td><b>Firewall</b></td>
		<td>' . ($bFirewallCheck ? 'OK' : 'Firewall blokkeerd cURL/FSock') . '</td>
		<td><div class="status ' . ($bFirewallCheck ? 'ok' : 'nok') . '"></div></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"><hr size="1"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>';


	if(!FTP_ACCESS_REQUIRED)
	{
		// No need for FTP settings
		$sHtml .= '
	<tr>
		<td colspan="3"><h1>Schrijfrechten</h1><p>Alle mappen en bestanden lijken de juiste schrijfrechten te hebben.</p></td>
	</tr>
	<tr>
		<td><b>Map</b></td>
		<td>/idealcheckout/configuration/</td>
		<td><div class="status ok"></div></td>
	</tr>
	<tr>
		<td><b>Map</b></td>
		<td>/idealcheckout/temp/</td>
		<td><div class="status ok"></div></td>
	</tr>';
	}
	else
	{
		$sHtml .= '
	<tr>
		<td colspan="3"><h1>Schrijfrechten</h1></td>
	</tr>
	<tr>
		<td colspan="3">Deze plugin heeft schrijfrechten nodig voor enkele mappen. Door uw FTP op te geven kunnen we deze rechten voor u instellen.</td>
	</tr>';

	if(!empty($aFormValues['ftp_success']))
	{
		$sHtml .= '
	<tr>
		<td colspan="3"><div class="success">' . nl2br(htmlentities($aFormValues['ftp_success'])) . '</div></td>
	</tr>';
	}

	if(!empty($aFormValues['ftp_error']))
	{
		$sHtml .= '
	<tr>
		<td colspan="3"><div class="error">' . nl2br(htmlentities($aFormValues['ftp_error'])) . '</div></td>
	</tr>';
	}

	$sHtml .= '
	<tr>
		<td><b>FTP Host</b> <em>*</em></td>
		<td><input name="ftp_host" type="text" value="' . htmlentities($aFormValues['ftp_host']) . '"></td>
		<td><div class="status ' . ($aFormErrors['ftp_host'] ? 'nok' : 'ok') . '"></div></td>
	</tr>
	<tr>
		<td><b>FTP Port</b> <em>*</em></td>
		<td><input name="ftp_port" type="text" value="' . htmlentities($aFormValues['ftp_port']) . '"></td>
		<td><div class="status ' . ($aFormErrors['ftp_port'] ? 'nok' : 'ok') . '"></div></td>
	</tr>
	<tr>
		<td><b>FTP Username</b> <em>*</em></td>
		<td><input name="ftp_user" autocomplete="off" type="text" value="' . htmlentities($aFormValues['ftp_user']) . '"></td>
		<td><div class="status ' . ($aFormErrors['ftp_user'] ? 'nok' : 'ok') . '"></div></td>
	</tr>
	<tr>
		<td><b>FTP Password</b> <em>*</em></td>
		<td><input name="ftp_pass" autocomplete="off" type="text" value="' . htmlentities($aFormValues['ftp_pass']) . '"></td>
		<td><div class="status ' . ($aFormErrors['ftp_pass'] ? 'nok' : 'ok') . '"></div></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"><b>Rechten handmatig instellen</b><br>U kunt deze schrijfrechten natuurlijk ook handmatig instellen via een FTP programma. Het gaat om de volgende mappen (en alle onderliggende bestanden):<br>- /idealcheckout/install/<br>- /idealcheckout/configuration/<br>- /idealcheckout/temp/</td>
	</tr>';
	}


	if(!$bDatabaseAutodetect)
	{
		$sHtml .= '
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"><hr size="1"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"><h1>Database</h1><p>';
		
		// if($sSoftwareConfigFile = $_REQUEST['software']::getConfigFile())
		if($sSoftwareConfigFile = call_user_func($_REQUEST['software'] . '::getConfigFile'))
		{
			$sHtml .= 'Waar mogelijk probereren we de gegevens voor u op te zoeken in het configuratie bestand van uw webshop: ' . $sSoftwareConfigFile . '.<br><br>';
		}

if(in_array($_SERVER['REMOTE_ADDR'], array('94.215.210.107')))
{
echo '<br>DEBUG: ' . __FILE__ . ' : ' . __LINE__ . "<br>\n";
print_r($aFormValues);
echo '<br>DEBUG: ' . __FILE__ . ' : ' . __LINE__ . "<br>\n";
}


		$sHtml .= '</p></td>
	</tr>';

		if(!empty($aFormValues['db_success']))
		{
			$sHtml .= '
	<tr>
		<td colspan="3"><div class="success">' . nl2br(htmlentities($aFormValues['db_success'])) . '</div></td>
	</tr>';
		}

		if(!empty($aFormValues['db_error']))
		{
			$sHtml .= '
	<tr>
		<td colspan="3"><div class="error">' . nl2br(htmlentities($aFormValues['db_error'])) . '</div></td>
	</tr>';
		}

		$sHtml .= '
	<tr>
		<td><b>Host</b> <em>*</em></td>
		<td><input name="db_host" type="text" value="' . htmlentities($aFormValues['db_host']) . '"></td>
		<td><div class="status ' . ($aFormErrors['db_host'] ? 'nok' : 'ok') . '"></div></td>
	</tr>
	<tr>
		<td><b>Port</b></td>
		<td><input name="db_port" type="text" value="' . htmlentities($aFormValues['db_port']) . '"></td>
		<td><div class="status ' . ($aFormErrors['db_port'] ? 'nok' : 'ok') . '"></div></td>
	</tr>
	<tr>
		<td><b>Username</b> <em>*</em></td>
		<td><input name="db_user" type="text" value="' . htmlentities($aFormValues['db_user']) . '"></td>
		<td><div class="status ' . ($aFormErrors['db_user'] ? 'nok' : 'ok') . '"></div></td>
	</tr>
	<tr>
		<td><b>Password</b> <em>*</em></td>
		<td><input name="db_pass" type="text" value="' . htmlentities($aFormValues['db_pass']) . '"></td>
		<td><div class="status ' . ($aFormErrors['db_pass'] ? 'nok' : 'ok') . '"></div></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><b>Name</b> <em>*</em></td>
		<td><input name="db_name" type="text" value="' . htmlentities($aFormValues['db_name']) . '"></td>
		<td><div class="status ' . ($aFormErrors['db_name'] ? 'nok' : 'ok') . '"></div></td>
	</tr>';

		$aDatabasePrefixes = array();

		if(sizeof($aDatabasePrefixes))
		{
			$sHtml .= '
	<tr>
		<td><b>Prefix</b></td>
		<td><select name="db_prefix">';
	
			foreach($aDatabasePrefixes as $v)
			{
				$sHtml .= '<option' . (($aFormValues['db_prefix'] == $v) ? ' selected="selected"' : '') . ' value="' . htmlentities($v) . '">' . htmlentities($sPrefix) . '</option>';
			}

			$sHtml .= '</select></td>
		<td><div class="status ' . ($aFormErrors['db_prefix'] ? 'nok' : 'ok') . '"></div></td>
	</tr>';
		}
		else
		{
			$sHtml .= '
	<tr>
		<td><b>Prefix</b></td>
		<td><input name="db_prefix" type="text" value="' . htmlentities($aFormValues['db_prefix']) . '"></td>
		<td><div class="status ' . ($aFormErrors['db_prefix'] ? 'nok' : 'ok') . '"></div></td>
	</tr>';
		}

		$sHtml .= '
	<tr>
		<td><b>Type</b></td>
		<td><select name="db_type">' . str_replace(' value="' . htmlentities($aFormValues['db_type']) . '"', ' selected="selected" value="' . htmlentities($aFormValues['db_type']) . '"', '<option value="mysql">MySQL</option><option value="mysqli">MySQLi</option>') . '</select></td>
		<td><div class="status ' . ($aFormErrors['db_type'] ? 'nok' : 'ok') . '"></div></td>
	</tr>';
	}

	$sHtml .= '
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"><hr size="1"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right" colspan="3"><input type="submit" value="Verder"></td>
	</tr>';

	IDEALCHECKOUT_INSTALL::output($sHtml, 'install-step-1', 3);

?>