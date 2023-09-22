<?php

	require_once(dirname(dirname(__FILE__)) . '/includes/init.php');
	$sRootUrl = idealcheckout_getRootUrl(2);

	$sHtml = '
<html>
	<head>
		<style type="text/css">

			h2
			{
				color: #000000;
				font-family: Arial;
				font-size: 15px;
				
				margin: 36px 0px 3px 0px;
			}

			p
			{
				color: #000000;
				font-family: Arial;
				font-size: 11px;
				
				margin: 0px 0px 12px 0px;
			}
			
			a
			{
				color: #000000;
				font-family: Arial;
				font-size: 11px;
			}
		
		</style>
	</head>
	<body>

		<p>Via deze plugin kunt u <a href="http://www.ideal-checkout.nl/authorizedtransfer">Eenmalige machtiging / Incasso</a> betalingen ontvangen binnen uw webshop.</p>';


	$aGatewaySettings = idealcheckout_getGatewaySettings(false, 'authorizedtransfer');

	if(!empty($aGatewaySettings['GATEWAY_VALIDATION']))
	{
		$sHtml .= '

		<h2>Transacties Controleren</h2>
		<p>Controleer de status van alle openstaande Eenmalige machtigingen / Incasso\'s bij uw Payment Service Provider.<br><br><input type="button" value="Controleer openstaande transacties." onclick="javascript: window.open(\'' . $sRootUrl . 'idealcheckout/validate.php?gateway=' . urlencode('authorizedtransfer') . '\', \'popup\', \'directories=no,height=550,location=no,menubar=no,resizable=yes,scrollbars=yes,status=no,toolbar=no,width=750\');"></p>';
	}


	$sHtml .= '

		<h2>Over deze plugin</h2>
		<p>Deze plugin is ontwikkeld door <a href="https://www.ideal-checkout.nl" target="_blank">iDEAL Checkout</a> i.s.m. diverse Payment Service Providers.</p>
		<p>U kunt een kopie van deze plugin gratis downloaden via <a href="http://www.ideal-checkout.nl" target="_blank">http://www.ideal-checkout.nl</a></p>
		<p>- Voor vragen over deze plugin kunt u kijken op <a href="http://www.ideal-checkout.nl" target="_blank">http://www.ideal-checkout.nl</a> of mailen naar <a href="mailto:info@ideal-checkout.nl">info@ideal-checkout.nl</a><br>- Feedback en donaties worden zeer op prijs gesteld.<br>- Het gebruik van onze plugins/scripts is geheel op eigen risico.</p>

	</body>
</html>';
	
	echo $sHtml;

?>