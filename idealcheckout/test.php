<?php

	global $aIdealCheckout;

	// Load database settings
	require_once(dirname(__FILE__) . '/includes/init.php');

	$sWarningHtml = '';


	$sStoreCode = idealcheckout_getStoreCode();
	$sGatewayCode = 'ideal';
	$sLanguageCode = 'nl'; // nl, de, en
	$sCountryCode = '';
	$sCurrencyCode = 'EUR';

	if(!empty($_POST['gateway_code']))
	{
		$sGatewayCode = $_POST['gateway_code'];
	}
	elseif(!empty($_GET['gateway_code']))
	{
		$sGatewayCode = $_GET['gateway_code'];
	}
	
	

	if(sizeof($_POST))
	{
		$sOrderId = (empty($_POST['order_id']) ? idealcheckout_getRandomCode(16) : $_POST['order_id']);
		$sOrderCode = idealcheckout_getRandomCode(32);
		$sTransactionId = idealcheckout_getRandomCode(32);
		$sTransactionCode = idealcheckout_getRandomCode(32);
		$fTransactionAmount = (empty($_POST['transaction_amount']) ? round(rand(1000, 100000) / 100, 2) : round(floatval(str_replace(',', '.', $_POST['transaction_amount'])), 2));
		$sTransactionDescription = (empty($_POST['transaction_description']) ? idealcheckout_getTranslation($sLanguageCode, 'idealcheckout', 'Webshop order #{0}', array($sOrderId)) : $_POST['transaction_description']);



		$aOrderParams = array(
			'customer' => array(
				'shipment_company' => 'iDEAL Checkout',
				'shipment_first_name' => 'iDEAL',
				'shipment_last_name' => 'Checkout',
				'shipment_gender' => 'M',
				'shipment_date_of_birth' => '376354800',
				'shipment_phone' => '0614707337',
				'shipment_email' => 'test@ideal-checkout.nl',
				'shipment_street_name' => 'Jan Steenstraat',
				'shipment_street_number' => '175',
				'shipment_zipcode' => '7944 TT',
				'shipment_city' => 'Meppel',
				'shipment_country_code' => 'NL',
				'shipment_country_name' => 'Nederland',

				'payment_company' => 'iDEAL Checkout',
				'payment_first_name' => 'iDEAL',
				'payment_last_name' => 'Checkout',
				'payment_gender' => 'M',
				'payment_date_of_birth' => '376354800',
				'payment_phone' => '0614707337',
				'payment_email' => 'test@ideal-checkout.nl',
				'payment_street_name' => 'Jan Steenstraat',
				'payment_street_number' => '175',
				'payment_zipcode' => '7944 TT',
				'payment_city' => 'Meppel',
				'payment_country_code' => 'NL',
				'payment_country_name' => 'Nederland',
			),
			'products' => array(
				array(
					'code' => 'P00001',
					'description' => 'Test product 1',
					'quantity' => 1,
					'price_incl' => 121.00,
					'price_excl' => 100.00,
					'vat' => 21.0
				),
				array(
					'code' => 'P00002',
					'description' => 'Test product 2',
					'quantity' => 2,
					'price_incl' => 106.00,
					'price_excl' => 100.00,
					'vat' => 6.0
				),
				array(
					'code' => 'P00003',
					'description' => 'Test product 3',
					'quantity' => 3,
					'price_incl' => 121.00,
					'price_excl' => 100.00,
					'vat' => 21.0
				),
				array(
					'code' => 'P00004',
					'description' => 'Test product 4',
					'quantity' => 4,
					'price_incl' => 100.00,
					'price_excl' => 100.00,
					'vat' => 0.0
				),
				array(
					'code' => 'P00005',
					'description' => 'Test product 5',
					'quantity' => 5,
					'price_incl' => 121.00,
					'price_excl' => 100.00,
					'vat' => 21.0
				),
			)
		);

/*
		$aOrderParams = array(
			'customer' => array(
				'shipment_company' => 'Pay.nl',
				'shipment_first_name' => 'M',
				'shipment_last_name' => 'Roeten',
				'shipment_gender' => 'M',
				'shipment_date_of_birth' => '255049200',
				'shipment_phone' => '0888866666',
				'shipment_email' => 'mark@pay.nl',
				'shipment_street_name' => 'Voorstraat',
				'shipment_street_number' => '2',
				'shipment_zipcode' => '3201BB',
				'shipment_city' => 'Spijkenisse',
				'shipment_country_code' => 'NL',
				'shipment_country_name' => 'Nederland',

				'payment_company' => 'Pay.nl',
				'payment_first_name' => 'M',
				'payment_last_name' => 'Roeten',
				'payment_gender' => 'M',
				'payment_date_of_birth' => '255049200',
				'payment_phone' => '0888866666',
				'payment_email' => 'mark@pay.nl',
				'payment_street_name' => 'Voorstraat',
				'payment_street_number' => '2',
				'payment_zipcode' => '3201BB',
				'payment_city' => 'Spijkenisse',
				'payment_country_code' => 'NL',
				'payment_country_name' => 'Nederland',
			),
			'products' => array(
				array(
					'code' => 'P00001',
					'description' => 'Test product 1',
					'quantity' => 1,
					'price_incl' => 121.00,
					'price_excl' => 100.00,
					'vat' => 21.0
				),
				array(
					'code' => 'P00002',
					'description' => 'Test product 2',
					'quantity' => 2,
					'price_incl' => 106.00,
					'price_excl' => 100.00,
					'vat' => 6.0
				),
				array(
					'code' => 'P00003',
					'description' => 'Test product 3',
					'quantity' => 3,
					'price_incl' => 121.00,
					'price_excl' => 100.00,
					'vat' => 21.0
				),
				array(
					'code' => 'P00004',
					'description' => 'Test product 4',
					'quantity' => 4,
					'price_incl' => 100.00,
					'price_excl' => 100.00,
					'vat' => 0.0
				),
				array(
					'code' => 'P00005',
					'description' => 'Test product 5',
					'quantity' => 5,
					'price_incl' => 121.00,
					'price_excl' => 100.00,
					'vat' => 21.0
				),
			)
		);
*/



		$sReturnUrl = idealcheckout_getRootUrl(1) . 'idealcheckout/test.php?status=';

		// Insert into #_idealcheckout
		$sql = "INSERT INTO `" . $aIdealCheckout['database']['table'] . "` SET 
`id` = NULL, 
`order_id` = '" . idealcheckout_escapeSql($sOrderId) . "', 
`order_code` = '" . idealcheckout_escapeSql($sOrderCode) . "', 
`order_params` = '" . idealcheckout_escapeSql(idealcheckout_serialize($aOrderParams)) . "', 
`store_code` = '" . idealcheckout_escapeSql($sStoreCode) . "', 
`gateway_code` = '" . idealcheckout_escapeSql($sGatewayCode) . "', 
`language_code` = '" . idealcheckout_escapeSql($sLanguageCode) . "', 
`country_code` = '" . idealcheckout_escapeSql($sCountryCode) . "', 
`currency_code` = '" . idealcheckout_escapeSql($sCurrencyCode) . "', 
`transaction_id` = '" . idealcheckout_escapeSql($sTransactionId) . "', 
`transaction_code` = '" . idealcheckout_escapeSql($sTransactionCode) . "', 
`transaction_date` = '" . idealcheckout_escapeSql(time()) . "', 
`transaction_amount` = '" . idealcheckout_escapeSql($fTransactionAmount) . "', 
`transaction_description` = '" . idealcheckout_escapeSql($sTransactionDescription) . "',
`transaction_success_url` = '" . idealcheckout_escapeSql($sReturnUrl) . "success', 
`transaction_pending_url` = '" . idealcheckout_escapeSql($sReturnUrl) . "pending', 
`transaction_failure_url` = '" . idealcheckout_escapeSql($sReturnUrl) . "failure';";


		if(idealcheckout_database_query($sql))
		{
			header('Location: ' . idealcheckout_getRootUrl(1) . 'idealcheckout/setup.php?order_id=' . urlencode($sOrderId) . '&order_code=' . urlencode($sOrderCode));
			exit;
		}
		else
		{
			$sWarningHtml .= '
		<div style="font-weight: bold; border: red solid 1px; padding: 10px; margin-bottom: 20px;">Cannot create record in table &quot;' . $aIdealCheckout['database']['table'] . '&quot;</div>';
		}
	}

	if(isset($_GET['status']))
	{
		if(strcasecmp($_GET['status'], 'success') === 0)
		{
			$sWarningHtml .= '
		<div style="font-weight: bold; border: #008000 solid 1px; background: #80C080; padding: 10px; margin-bottom: 20px;">Transactie is voltooid.</div>';
		}
		elseif(strcasecmp($_GET['status'], 'pending') === 0)
		{
			$sWarningHtml .= '
		<div style="font-weight: bold; border: #F08000 solid 1px; background: #FFC080; padding: 10px; margin-bottom: 20px;">Transactie is nog in behandeling.</div>';
		}
		else
		{
			$sWarningHtml .= '
		<div style="font-weight: bold; border: #800000 solid 1px; background: #FF8080; padding: 10px; margin-bottom: 20px;">Transactie is geannuleerd/mislukt.</div>';
		}
	}



	$sOrderId = idealcheckout_getRandomCode(16);
	$fTransactionAmount = round(rand(1000, 100000) / 100, 2);
	$sTransactionDescription = idealcheckout_getTranslation($sLanguageCode, 'idealcheckout', 'Webshop order #{0}', array($sOrderId));


	echo '<!DOCTYPE html>
<html>
	<head>

		<title>iDEAL Checkout - TEST betaling</title>

		<style type="text/css">

h1
{
	font-family: Arial;
	font-size: 20px;
	font-weight: bold;
}

p, td, div
{
	font-family: Arial;
	font-size: 12px;
}

select, input
{
	font-family: Arial;
	font-size: 11px;
}

		</style>

	</head>
	<body>
' . $sWarningHtml . '

		<h1>iDEAL Checkout - Test betaling</h1>
		<p>Via deze tool kun je eenvoudig testbetalingen uitvoeren om te zien of de configuratie van je betaalmethodes kloppen.</p>

		<form action="" method="post" name="payment">
			<table border="0" cellpadding="5" cellspacing="0">
				<tr>
					<td width="150"><b>Betaalmethode</b></td>
					<td width="600"><select name="gateway_code" style="width: 450px;">
						<option' . (($sGatewayCode == 'afterpay') ? ' selected="selected"' : '') . ' value="afterpay">AfterPay - /idealcheckout/configuration/afterpay.php</option>
						<option' . (($sGatewayCode == 'authorizedtransfer') ? ' selected="selected"' : '') . ' value="authorizedtransfer">Eenmalige machtiging - /idealcheckout/configuration/authorizedtransfer.php</option>
						<option' . (($sGatewayCode == 'cartebleue') ? ' selected="selected"' : '') . ' value="cartebleue">Carte Bleue - /idealcheckout/configuration/cartebleue.php</option>
						<option' . (($sGatewayCode == 'clickandbuy') ? ' selected="selected"' : '') . ' value="clickandbuy">Click and Buy - /idealcheckout/configuration/clickandbuy.php</option>
						<option' . (($sGatewayCode == 'creditcard') ? ' selected="selected"' : '') . ' value="creditcard">Creditcard - /idealcheckout/configuration/creditcard.php</option>
						<option' . (($sGatewayCode == 'directebanking') ? ' selected="selected"' : '') . ' value="directebanking">Direct E-Banking - /idealcheckout/configuration/directebanking.php</option>
						<option' . (($sGatewayCode == 'ebon') ? ' selected="selected"' : '') . ' value="ebon">E-Bon - /idealcheckout/configuration/ebon.php</option>
						<option' . (($sGatewayCode == 'fasterpay') ? ' selected="selected"' : '') . ' value="fasterpay">FasterPay - /idealcheckout/configuration/fasterpay.php</option>
						<option' . (($sGatewayCode == 'giropay') ? ' selected="selected"' : '') . ' value="giropay">GiroPay - /idealcheckout/configuration/giropay.php</option>
						<option' . (($sGatewayCode == 'ideal') ? ' selected="selected"' : '') . ' value="ideal">iDEAL - /idealcheckout/configuration/ideal.php</option>
						<option' . (($sGatewayCode == 'maestro') ? ' selected="selected"' : '') . ' value="maestro">Maestro - /idealcheckout/configuration/maestro.php</option>
						<option' . (($sGatewayCode == 'mastercard') ? ' selected="selected"' : '') . ' value="mastercard">Mastercard - /idealcheckout/configuration/mastercard.php</option>
						<option' . (($sGatewayCode == 'minitix') ? ' selected="selected"' : '') . ' value="minitix">MiniTix - /idealcheckout/configuration/minitix.php</option>
						<option' . (($sGatewayCode == 'mistercash') ? ' selected="selected"' : '') . ' value="mistercash">MisterCash - /idealcheckout/configuration/mistercash.php</option>
						<option' . (($sGatewayCode == 'manualtransfer') ? ' selected="selected"' : '') . ' value="manualtransfer">Handmatige overboeking - /idealcheckout/configuration/manualtransfer.php</option>
						<option' . (($sGatewayCode == 'paypal') ? ' selected="selected"' : '') . ' value="paypal">PayPal - /idealcheckout/configuration/paypal.php</option>
						<option' . (($sGatewayCode == 'paysafecard') ? ' selected="selected"' : '') . ' value="paysafecard">PaySafeCard - /idealcheckout/configuration/paysafecard.php</option>
						<option' . (($sGatewayCode == 'postepay') ? ' selected="selected"' : '') . ' value="postepay">PostePay - /idealcheckout/configuration/postepay.php</option>
						<option' . (($sGatewayCode == 'visa') ? ' selected="selected"' : '') . ' value="visa">Visa - /idealcheckout/configuration/visa.php</option>
						<option' . (($sGatewayCode == 'vpay') ? ' selected="selected"' : '') . ' value="vpay">VPAY - /idealcheckout/configuration/vpay.php</option>
					</select></td>
				</tr>
				<tr>
					<td><b>Ordernummer</b></td>
					<td><input name="order_id" style="width: 450px;" type="text" value="' . htmlspecialchars($sOrderId) . '"></td>
				</tr>
				<tr>
					<td><b>Bedrag</b></td>
					<td><input name="transaction_amount" style="width: 450px;" type="text" value="' . htmlspecialchars(number_format($fTransactionAmount, 2, ',', '')) . '"></td>
				</tr>
				<tr>
					<td><b>Omschrijving</b></td>
					<td><input name="transaction_description" style="width: 450px;" type="text" value="' . htmlspecialchars($sTransactionDescription) . '"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Test betaling"></td>
				</tr>
			</table>
		</form>
	</body>
</html>';

?>