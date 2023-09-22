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


	$sSelectedPsp = '';
	$aSelectedPsp = false;
	$bLockPsp = false;

	$sSelectedGateway = '';
	$aSelectedGateway = false;


	// DETECT PSP
	if(!empty($_GET['psp']) && is_string($_GET['psp']))
	{
		$sSelectedPsp = $_GET['psp'];
		$bLockPsp = true;
	}
	elseif(defined('IDEALCHECKOUT_PSP'))
	{
		$sSelectedPsp = IDEALCHECKOUT_PSP;
		$bLockPsp = true;
	}
	elseif(!empty($_POST['idealcheckout_psp']) && is_string($_POST['idealcheckout_psp']))
	{
		$sSelectedPsp = $_POST['idealcheckout_psp'];
		$bLockPsp = !empty($_POST['idealcheckout_psp_lock']);
	}

	if(array_key_exists($sSelectedPsp, $_REQUEST['psp']))
	{
		$aSelectedPsp = $_REQUEST['psp'][$sSelectedPsp];
	}
	else
	{
		$sSelectedPsp = '';
		$bLockPsp = false;
	}


	// DETECT GATEWAY
	if(!empty($aSelectedPsp))
	{
		if(!empty($_GET['gateway']) && is_string($_GET['gateway']))
		{
			$sSelectedGateway = $_GET['gateway'];
		}
		elseif(!empty($_POST['idealcheckout_gateway']) && is_string($_POST['idealcheckout_gateway']))
		{
			$sSelectedGateway = $_POST['idealcheckout_gateway'];
		}

		foreach($_REQUEST['psp'][$sSelectedPsp]['gateways'] as $k => $aGateway)
		{
			if($sSelectedGateway == $aGateway['code'])
			{
				$aSelectedGateway = $aGateway;
				break;
			}
		}

		if(empty($aSelectedGateway))
		{
			$sSelectedGateway = '';
		}
	}

	$bConfigurationPosted = false;
	$bConfigurationSaved = false;
	$sGatewayCode = false;

	if(!empty($aSelectedGateway))
	{
		if(!empty($_POST['save']) && !empty($_POST['gateway_check']) && (strcasecmp($aSelectedGateway['code'], $_POST['gateway_check']) === 0))
		{
			$bConfigurationPosted = true;
			$bConfigurationSaved = IDEALCHECKOUT_INSTALL::saveFormFields($aSelectedGateway);
			$sGatewayCode = $aSelectedGateway['type'];
		}
	}


	$sHtml = '
		<tr>
			<td><h1>Betaalmethoden configureren</h1></td>
		</tr>
		<tr>
			<td>De betaalmethoden zijn standaard geconfigureerd voor de <i>iDEAL Checkout Simulator</i>.<br>Deze test omgeving kunt u gebruiken om de werking van de plug-in goed te kunnen uitproberen. <b>Zo kunt u ook zonder abonnement de plug-ins installeren en testen.</b><br><br><span class="lightbulb">Test nu eerst de ingeschakelde betaalmethoden in uw webshop zodat u zeker weet dat het checkoutproces probleemloos verloopt via de <i>iDEAL Checkout Simulator</i>.</span><br><br>Via de onderstaande stappen kunt u de gewenste betaalmethoden configureren om echte betalingen te kunnen ontvangen via uw Payment Service Provider.</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>';



	if($bConfigurationPosted)
	{
		if($bConfigurationSaved)
		{
			$sHtml .= '
		<tr class="hide-c">
			<td><div class="success">De configuratie is succesvol opgeslagen. Herhaal stap A t/m C om meer betaalmethoden te configureren, of ga naar de <a href="step-4.php">volgende stap</a>.<br><br>Tip: Klik <a href="../test.php' . ($sGatewayCode ? '?gateway_code=' . urlencode($sGatewayCode) : '') . '" target="_blank">hier</a> om de instellingen van uw betaalmethoden direct te testen (opent in nieuw venster).</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>';
		}
		else
		{
			$sHtml .= '
		<tr class="hide-c">
			<td><div class="success">De configuratie kon niet worden opgeslagen. Controleer uw instellingen en probeer het opnieuw.</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>';
		}
	}



	if($bLockPsp)
	{
		$sHtml .= '
		<tr>
			<td><h2>A. Uw Bank / Payment Service Provider</h2></td>
		</tr>
		<tr>
			<td>' . htmlentities($aSelectedPsp['name']) . '<input type="hidden" name="idealcheckout_psp" value="' . htmlentities($sSelectedPsp) . '"><input type="hidden" name="idealcheckout_psp_lock" value="1"></td>
		</tr>';
	}
	else
	{
		$sHtml .= '
		<tr>
			<td><h2>A. Kies uw Bank / Payment Service Provider <em>*</em></h2></td>
		</tr>
		<tr>
			<td>Online betalingen ontvangen via een van onze plug-ins kan alleen als u een account<br> of abonnement heeft een van de onderstaande Banken / Payment Service Providers.</td>
		</tr>
		<tr>
			<td><select name="idealcheckout_psp" onchange="javascript: jQuery(\'.hide-b\').hide(); jQuery(\'.hide-c\').hide();">';

		foreach($_REQUEST['psp'] as $k => $aPsp)
		{
			if($sSelectedPsp == $k)
			{
				$sHtml .= '<option value="' . $k . '" selected="selected">' . htmlentities($aPsp['name']) . '</option>';
			}
			else
			{
				$sHtml .= '<option value="' . $k . '">' . htmlentities($aPsp['name']) . '</option>';
			}
		}

		$sHtml .= '</select></td>
		</tr>
		<tr>
			<td><input name="set_psp" type="submit" value="Selecteren"></td>
		</tr>';
	}


	if(!empty($aSelectedPsp))
	{
		$sHtml .= '
		<tr class="hide-b">
			<td>&nbsp;</td>
		</tr>
		<tr class="hide-b">
			<td>&nbsp;</td>
		</tr>
		<tr class="hide-b">
			<td><h2>B. Kies de gewenste betaalmethode <em>*</em></h2></td>
		</tr>
		<tr class="hide-b">
			<td>Controleer bij uw Bank/PSP welke betaalmethoden onderdeel zijn van uw abonnement.</td>
		</tr>
		<tr class="hide-b">
			<td><select name="idealcheckout_gateway" onchange="javascript: jQuery(\'.hide-c\').hide();">'; 

		foreach($aSelectedPsp['gateways'] as $k => $aGateway)
		{
			if($sSelectedGateway == $aGateway['code'])
			{
				$sHtml .= '<option value="' . htmlentities($aGateway['code']) . '" selected="selected">' . htmlentities($aGateway['name']) . '</option>';
			}
			else
			{
				$sHtml .= '<option value="' . htmlentities($aGateway['code']) . '">' . htmlentities($aGateway['name']) . '</option>';
			}
		}

		$sHtml .= '</select></td>
		</tr>
		<tr class="hide-b">
			<td><input name="set_gateway" type="submit" value="Selecteren"></td>
		</tr>';
	}

	if(!empty($aSelectedGateway))
	{
/*
		$bConfigurationPosted = false;
		$bConfigurationSaved = false;

		if(!empty($_POST['save']) && !empty($_POST['gateway_check']) && (strcasecmp($aSelectedGateway['code'], $_POST['gateway_check']) === 0))
		{
			$bConfigurationPosted = true;
			$bConfigurationSaved = IDEALCHECKOUT_INSTALL::saveFormFields($aSelectedGateway);
		}
*/

		$sHtml .= '
		<tr class="hide-c">
			<td>&nbsp;</td>
		</tr class="hide-c">
		<tr class="hide-c">
			<td>&nbsp;</td>
		</tr>
		<tr class="hide-c">
			<td><h2>C. Bepaal uw specifieke instellingen</h2></td>
		</tr>';

		if(!empty($aSelectedGateway['dashboard']))
		{
			$sHtml .= '
		<tr class="hide-c">
			<td>' . $aSelectedGateway['dashboard'] . '</td>
		</tr>';
		}
		else
		{
			$sHtml .= '
		<tr class="hide-c">
			<td>';

			if(in_array($sSelectedGateway, array('ABN Amro - iDEAL Easy', 'ABN Amro - iDEAL Easy (Beveiligd)')))
			{
				$sHtml .= 'Van uw bank/PSP heeft u een e-mail of brief ontvangen, waarop u deze gegevens kunt<br>terug vinden.';
			}
			else
			{
				$sHtml .= 'Van uw bank/PSP heeft u toegang tot een online dashboard gekregen, waarop uw deze<br>gegevens kunt terug vinden.';
			}

			$sHtml .= '</td>
		</tr>';
		}

		$sHtml .= '
		<tr class="hide-c">
			<td>&nbsp;</td>
		</tr>';

/*
		if($bConfigurationPosted)
		{
			if($bConfigurationSaved)
			{
				$sHtml .= '
		<tr class="hide-c">
			<td><div class="success">De configuratie is succesvol opgeslagen. Herhaal stap A t/m C om meer betaalmethoden te configureren, of ga naar de <a href="step-4.php">volgende stap</a>.<br><br>Tip: Klik <a href="../test.php" target="_blank">hier</a> om de instellingen van uw betaalmethoden direct te testen (opent in nieuw venster).</td>
		</tr>';
			}
			else
			{
				$sHtml .= '
		<tr class="hide-c">
			<td><div class="success">De configuratie kon niet worden opgeslagen. Controleer uw instellingen en probeer het opnieuw.</td>
		</tr>';
			}
		}
*/

		$sHtml .= IDEALCHECKOUT_INSTALL::drawFormFields($aSelectedGateway);

		$sHtml .= '
		<tr class="hide-c">
			<td>&nbsp;</td>
		</tr>
		<tr class="hide-c">
			<td><input name="gateway_check" type="hidden" value="' . htmlentities($aSelectedGateway['code']) . '"><input type="submit" name="save" value="Opslaan"> &nbsp; <i>' . ($bConfigurationSaved ? '<br>Uw instellingen zijn opgeslagen in: /idealcheckout/configuration/' . $aSelectedGateway['type'] . '.php' : '') . '</i></td>
		</tr>';
	}


	$sJavascript = '<script type="text/javascript">

	function goNext()
	{
		var sVal = jQuery(\'input[type="text"]:first\').val();
		var bRedirect = true;

		if(sVal && (sVal.length > 0))
		{
			bRedirect = confirm(\'Wilt u verder gaan zonder eerst uw configuratie op te slaan?\');
		}

		if(bRedirect)
		{
			window.location.href = \'step-4.php\';
		}
	}

</script>';
	
	
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
			<td align="right">' . $sJavascript . '<input onclick="javascript: goNext();" type="button" value="Verder"></td>
		</tr>';

	IDEALCHECKOUT_INSTALL::output($sHtml, 'install-step-3');

?>