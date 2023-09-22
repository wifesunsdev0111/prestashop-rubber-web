<?php

	$sAdminConfigurationFile = dirname(__FILE__) . '/configuration/admin.php';

	if(is_file($sAdminConfigurationFile))
	{
		$aSettings = array();
		require_once($sAdminConfigurationFile);

		if(!empty($aSettings['ADMIN_USERNAME']) && !empty($aSettings['ADMIN_PASSWORD']))
		{
			define('ADMIN_USERNAME', $aSettings['ADMIN_USERNAME']);
			define('ADMIN_PASSWORD', $aSettings['ADMIN_PASSWORD']);
		}
	}

	if(!defined('ADMIN_USERNAME') || !defined('ADMIN_PASSWORD'))
	{
		// die('Please setup a valid username and password in: ' . $sAdminConfigurationFile);
		die('Please setup a valid username and password.');
	}





	// Load setup
	require_once(dirname(__FILE__) . '/includes/init.php');

	$sSessionId = false;
	
	if(!empty($_COOKIE['idealcheckout-admin']))
	{
		$sSessionId = $_COOKIE['idealcheckout-admin'];
		$sSessionFile = __DIR__ . '/temp/session.' . md5($_SERVER['REMOTE_ADDR'] . (empty($_SERVER['HTTP_USER_AGENT']) ? '' : $_SERVER['HTTP_USER_AGENT'])) . '.' . $sSessionId . '.lock';

		if(!is_file($sSessionFile))
		{
			$sSessionId = false;
		}
	}

	
	$aGateways = array();
	$aGateways[] = array('name' => 'AfterPay', 'code' => 'afterpay', 'enabled' => true);
	$aGateways[] = array('name' => 'Eenmalige machtiging', 'code' => 'authorizedtransfer', 'enabled' => true);
	$aGateways[] = array('name' => 'Carte Bleue', 'code' => 'cartebleue', 'enabled' => true);
	$aGateways[] = array('name' => 'Click & Buy', 'code' => 'clickandbuy', 'enabled' => true);
	$aGateways[] = array('name' => 'Direct e-Banking', 'code' => 'directebanking', 'enabled' => true);
	$aGateways[] = array('name' => 'eBon', 'code' => 'ebon', 'enabled' => true);
	$aGateways[] = array('name' => 'FasterPay', 'code' => 'fasterpay', 'enabled' => true);
	$aGateways[] = array('name' => 'GiroPay', 'code' => 'giropay', 'enabled' => true);
	$aGateways[] = array('name' => 'iDEAL', 'code' => 'ideal', 'enabled' => true, 'bold' => true);
	$aGateways[] = array('name' => 'Maestro', 'code' => 'maestro', 'enabled' => true);
	$aGateways[] = array('name' => 'Handmatig overboeken', 'code' => 'manualtransfer', 'enabled' => true);
	$aGateways[] = array('name' => 'Mastercard', 'code' => 'mastercard', 'enabled' => true);
	$aGateways[] = array('name' => 'Minitix', 'code' => 'minitix', 'enabled' => true);
	$aGateways[] = array('name' => 'MisterCash', 'code' => 'mistercash', 'enabled' => true);
	$aGateways[] = array('name' => 'PayPal', 'code' => 'paypal', 'enabled' => true);
	$aGateways[] = array('name' => 'PaySafeCard', 'code' => 'paysafecard', 'enabled' => true);
	$aGateways[] = array('name' => 'PostePay', 'code' => 'postepay', 'enabled' => true);
	$aGateways[] = array('name' => 'Visa', 'code' => 'visa', 'enabled' => true);
	$aGateways[] = array('name' => 'V Pay', 'code' => 'vpay', 'enabled' => true);
	$aGateways[] = array('name' => 'Webshop Giftcard', 'code' => 'webshopgiftcard', 'enabled' => true);


	$aFormData = array('username' => '', 'password' => '', 'link_reference' => '', 'link_amount' => '10.00', 'link_gateway' => 'ideal', 'filter_reference' => '', 'filter_gateway' => '', 'filter_limit' => 10);

	if(!empty($_POST['form']) && !empty($_POST['username']) && !empty($_POST['password']))
	{
		$aFormData['form'] = $_POST['form'];
		$aFormData['username'] = $_POST['username'];
		$aFormData['password'] = $_POST['password'];

		if((strcmp('login', $aFormData['form']) === 0) && (strcmp(ADMIN_USERNAME, $aFormData['username']) === 0) && (strcmp(ADMIN_PASSWORD, $aFormData['password']) === 0))
		{
			// Create session
			$sRootUrl = idealcheckout_getRootUrl(1);
			$aRootUrl = parse_url($sRootUrl);

			$sSessionId = idealcheckout_getRandomCode(32);
			$sSessionFile = __DIR__ . '/temp/session.' . md5($_SERVER['REMOTE_ADDR'] . (empty($_SERVER['HTTP_USER_AGENT']) ? '' : $_SERVER['HTTP_USER_AGENT'])) . '.' . $sSessionId . '.lock';
			touch($sSessionFile);

			setcookie('idealcheckout-admin', $sSessionId, 0, $aRootUrl['path'] . 'idealcheckout/', $aRootUrl['host'], false, true);
		}
	}

	
	
	// Force login
	if(empty($sSessionId))
	{
		$sHtml = '
<p><b>Inloggen</b></p>
<form action="admin.php" method="post">
	<input name="form" type="hidden" value="login">';

		if(!empty($_POST['form']))
		{
			$sHtml .= '<p>Ongeldige gebruikersnaam/wachtwoord.</p>';
		}

		$sHtml .= '
	<table align="center" border="0" cellpadding="5" cellspacing="0" width="350">
		<tr>
			<td align="left" valign="top" width="125"><b>Gebruikersnaam</b> <em>*</em></td>
			<td align="left" valign="top"><input autocomplete="off" name="username" style="width: 200px;" type="text" value="' . htmlspecialchars($aFormData['username']) . '"></td>
		</tr>
		<tr>
			<td align="left" valign="top"><b>Wachtwoord</b> <em>*</em></td>
			<td align="left" valign="top"><input autocomplete="off" name="password" style="width: 200px;" type="password" value="' . htmlspecialchars($aFormData['password']) . '"></td>
		</tr>
		<tr>
			<td align="left" valign="top">&nbsp;</td>
			<td align="left" valign="top"><input style="width: 125px;" type="submit" value="Inloggen"></td>
		</tr>
	</table>
</form>';

		idealcheckout_output($sHtml, false);
	}





	$sPaymentLink = '';

	if(isset($_POST['form']) && (strcasecmp($_POST['form'], 'payment-link') === 0))
	{
		if(!empty($_POST['link_reference']))
		{
			$aFormData['link_reference'] = preg_replace('/([^0-9a-zA-Z]+)/', '-', $_POST['link_reference']);
		}

		if(!empty($_POST['link_amount']))
		{
			$aFormData['link_amount'] = floatval(str_replace(',', '.', $_POST['link_amount']));

			if($aFormData['link_amount'] < 1.50)
			{
				$aFormData['link_amount'] = 1.50;
			}
		}

		if(!empty($_POST['link_gateway']))
		{
			$aFormData['link_gateway'] = strtolower($_POST['link_gateway']);
		}
		else
		{
			$aFormData['link_gateway'] = 'ideal';
		}

		$sPaymentLink .= ($sPaymentLink ? '&' : '') . 'amount=' . urlencode(number_format($aFormData['link_amount'], 2, '.', ''));

		if(strcasecmp($aFormData['link_gateway'], 'ideal') !== 0)
		{
			$sPaymentLink .= ($sPaymentLink ? '&' : '') . 'gateway_code=' . urlencode($aFormData['link_gateway']);
		}

		if(!empty($aFormData['link_reference']))
		{
			$sPaymentLink .= ($sPaymentLink ? '&' : '') . 'reference=' . urlencode($aFormData['link_reference']);
		}

		$aGatewaySettings = idealcheckout_getGatewaySettings(false, $aFormData['link_gateway']);

		if(!empty($aGatewaySettings['GATEWAY_HASH'])) // Create HASH?
		{
			$sCalculatedHash = md5($aGatewaySettings['GATEWAY_HASH'] . $sPaymentLink);
			$sPaymentLink .= ($sPaymentLink ? '&' : '') . 'hash=' . urlencode($sCalculatedHash);
		}

		$sPaymentLink = idealcheckout_getRootUrl(1) . 'idealcheckout/checkout.php?' . $sPaymentLink;
	}
	elseif(isset($_POST['form']) && (strcasecmp($_POST['form'], 'payment-filter') === 0))
	{
		if(!empty($_POST['filter_reference']))
		{
			$aFormData['filter_reference'] = $_POST['filter_reference'];
		}

		if(!empty($_POST['filter_gateway']))
		{
			$aFormData['filter_gateway'] = strtolower($_POST['filter_gateway']);
		}

		if(!empty($_POST['filter_limit']))
		{
			$aFormData['filter_limit'] = intval($_POST['filter_limit']);

			if($aFormData['filter_limit'] < 1)
			{
				$aFormData['filter_limit'] = 10;
			}
		}
	}


	$sHtml = '
<p><b>Overzicht van laatst gestarte transacties</i></b><br>(tot ' . $aFormData['filter_limit'] . ' records)</p>

<form action="admin.php" method="post">
	<input name="form" type="hidden" value="payment-filter">
	<table align="center" border="0" cellpadding="5" cellspacing="0" width="750">
		<tr>
			<td align="left" valign="top" width="125"><b>Ordernummer</b></td>
			<td align="left" valign="top"><input name="filter_reference" style="width: 600px;" type="text" value="' . htmlspecialchars($aFormData['filter_reference']) . '"></td>
		</tr>
		<tr>
			<td align="left" valign="top"><b>Betaalmethode</b></td>
			<td align="left" valign="top"><select name="filter_gateway" style="width: 600px;"><option value="">-</option>';

	foreach($aGateways as $aGateway)
	{
		$sHtml .= '<option' . ((strcasecmp($aFormData['filter_gateway'], $aGateway['code']) === 0) ? ' selected="selected"' : '') . ' value="' . $aGateway['code'] . '"' . (!empty($aGateway['bold']) ? ' style="font-weight: bold;"' : '') . '>' . htmlentities($aGateway['name']) . '</option>';
	}

	$sHtml .= '</select></td>
		</tr>
		<tr>
			<td align="left" valign="top" width="125"><b>Aantal records</b></td>
			<td align="left" valign="top"><input name="filter_limit" style="width: 600px;" type="text" value="' . htmlspecialchars($aFormData['filter_limit']) . '"></td>
		</tr>
		<tr>
			<td align="left" valign="top">&nbsp;</td>
			<td align="left" valign="top"><input style="width: 125px;" type="submit" value="Filteren"></td>
		</tr>
		<tr>
			<td align="left" valign="top">&nbsp;</td>
			<td align="left" valign="top">&nbsp;</td>
		</tr>
	</table>
</form>

<table align="center" border="0" cellpadding="5" cellspacing="2" width="750">
	<tr bgcolor="#000000">
		<td align="left" valign="top"><b><span style="color: #FFFFFF;">Record ID</span></b></td>
		<td align="left" valign="top"><b><span style="color: #FFFFFF;">Ordernummer</span></b></td>
		<td align="left" valign="top"><b><span style="color: #FFFFFF;">Betaalmethode</span></b></td>
		<td align="left" valign="top"><b><span style="color: #FFFFFF;">Valuta</span></b></td>
		<td align="left" valign="top"><b><span style="color: #FFFFFF;">Bedrag</span></b></td>
		<td align="left" valign="top"><b><span style="color: #FFFFFF;">Betaalstatus</span></b></td>
	</tr>';





	$sSqlWhere = '';

	if(!empty($aFormData['filter_reference']))
	{
		$sSqlWhere .= ($sSqlWhere ? ' AND ' : '') . "(`order_id` LIKE '%" . idealcheckout_escapeSql($aFormData['filter_reference'], true) . "%')";
	}

	if(!empty($aFormData['filter_gateway']))
	{
		$sSqlWhere .= ($sSqlWhere ? ' AND ' : '') . "(`gateway_code` = '" . idealcheckout_escapeSql($aFormData['filter_gateway']) . "')";
	}


	$sql = "SELECT `id`, `order_id`, `gateway_code`, `currency_code`, `transaction_amount`, `transaction_status` FROM `" . $aIdealCheckout['database']['table'] . "` " . ($sSqlWhere ? "WHERE " . $sSqlWhere : "") . " ORDER BY `id` DESC LIMIT " . $aFormData['filter_limit'] . ";";
	$oRecordset = idealcheckout_database_query($sql) or idealcheckout_die(idealcheckout_database_error(), __FILE__, __LINE__);


	$iRowCount = 0;

	while($aRecord = idealcheckout_database_fetch_assoc($oRecordset))
	{
		$sHtml .= '
	<tr bgcolor="' . (($iRowCount % 2) ? '#F0F0F0' : '#E0E0E0') . '">
		<td align="left" valign="top">' . htmlspecialchars($aRecord['id']) . '&nbsp;</td>
		<td align="left" valign="top">' . htmlspecialchars($aRecord['order_id']) . '&nbsp;</td>
		<td align="left" valign="top">' . htmlspecialchars($aRecord['gateway_code']) . '&nbsp;</td>
		<td align="left" valign="top">' . htmlspecialchars($aRecord['currency_code']) . '&nbsp;</td>
		<td align="left" valign="top">' . htmlspecialchars($aRecord['transaction_amount']) . '&nbsp;</td>
		<td align="left" valign="top">' . htmlspecialchars($aRecord['transaction_status']) . '&nbsp;</td>
	</tr>';

		$iRowCount++;
	}

	$sHtml .= '
</table>

<p>&nbsp;</p>
<a name="payment-validation"></a>
<p>&nbsp;</p>

<p><b>Betaal status controle</b><br>Controleer de status van openstaande betalingen indien beschikbaar bij jou<br>Payment Service Provider en het door jou gekozen abonnement.</p>

<p>';

	$iGatewayCount = 0;

	foreach($aGateways as $aGateway)
	{
		if(!empty($aGateway['enabled']))
		{
			$aSettings = idealcheckout_getGatewaySettings(false, $aGateway['code']);
			
			if(!empty($aSettings['GATEWAY_VALIDATION']))
			{
				if($iGatewayCount && (($iGatewayCount % 3) == 0))
				{
					$sHtml .= '<br>';
				}

				$sHtml .= '<input style="width: 240px; margin: 0px 5px 10px 5px;' . (!empty($aGateway['bold']) ? ' font-weight: bold;' : '') . '" type="button" value="' . htmlentities($aGateway['name']) . '" onclick="javascript: window.open(\'' . idealcheckout_getRootUrl(1) . 'idealcheckout/validate/' . $aGateway['code'] . '.php\', \'popup\', \'directories=no,height=550,location=no,menubar=no,resizable=yes,scrollbars=yes,status=no,toolbar=no,width=750\');">';
				
				$iGatewayCount++;
			}
		}
	}

	$sHtml .= '</p>';
	
	if(is_file(__DIR__ . '/checkout.php'))
	{
		$sHtml .= '
<p>&nbsp;</p>
<a name="payment-link"></a>
<p>&nbsp;</p>

<p><b>Genereer een betaallink voor in een e-mail of chat bericht.</b></p>
<form action="admin.php#payment-link" method="post">
	<input name="form" type="hidden" value="payment-link">
	<table align="center" border="0" cellpadding="5" cellspacing="0" width="750">
		<tr>
			<td align="left" valign="top" width="125"><b>Ordernummer</b></td>
			<td align="left" valign="top"><input name="link_reference" style="width: 600px;" type="text" value="' . htmlspecialchars($aFormData['link_reference']) . '"></td>
		</tr>
		<tr>
			<td align="left" valign="top"><b>Bedrag</b> <em>*</em></td>
			<td align="left" valign="top"><input name="link_amount" style="width: 600px;" type="text" value="' . htmlspecialchars(number_format($aFormData['link_amount'], 2, '.', '')) . '"></td>
		</tr>
		<tr>
			<td align="left" valign="top"><b>Betaalmethode</b> <em>*</em></td>
			<td align="left" valign="top"><select name="link_gateway" style="width: 600px;"><option value="">-</option>';

		foreach($aGateways as $aGateway)
		{
			$sHtml .= '<option' . ((strcasecmp($aFormData['filter_gateway'], $aGateway['code']) === 0) ? ' selected="selected"' : '') . ' value="' . $aGateway['code'] . '"' . (!empty($aGateway['bold']) ? ' style="font-weight: bold;"' : '') . '>' . htmlentities($aGateway['name']) . '</option>';
		}
	
		$sHtml .= '</select></td>
		</tr>
		<tr>
			<td align="left" valign="top">&nbsp;</td>
			<td align="left" valign="top"><input style="width: 125px;" type="submit" value="Genereren"></td>
		</tr>';

		if(!empty($sPaymentLink))
		{
			$sHtml .= '
		<tr>
			<td align="left" valign="top">&nbsp;</td>
			<td align="left" valign="top">&nbsp;</td>
		</tr>
		<tr>
			<td align="left" valign="top"><b>Betaallink</b></td>
			<td align="left" valign="top"><textarea style="height: 100px; width: 600px;">' . htmlspecialchars($sPaymentLink) . '</textarea></td>
		</tr>';
		}

		$sHtml .= '
	</table>
</form>';
	}

	$sHtml .= '
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>';


	idealcheckout_output($sHtml, false);

?>