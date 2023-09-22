<?php

	require_once(dirname(dirname(__FILE__)) . '/includes/library.php');
	require_once(dirname(__FILE__) . '/includes/install.php');
	require_once(dirname(__FILE__) . '/includes/ftp.cls.php');
	require_once(dirname(__FILE__) . '/includes/settings.php');

	$sConfigFile = dirname(dirname(__FILE__)) . '/configuration/install.php';

	if(is_file($sConfigFile))
	{
		header('Location: step-2.php');
		exit;
	}


	$sHtml = '
	<tr>
		<td><h1>iDEAL Checkout Installatie Wizard</h1></td>
	</tr>
	<tr>
		<td>Welkom bij de installatie wizard van deze plug-in. Heeft u vragen over de installatie van de plug-ins, wilt u gebruik maken van onze installatie service, of heeft u suggesties om zaken te verbeteren, kijk dan op <a href="https://www.ideal-checkout.nl" target="_blank">www.ideal-checkout.nl</a> of neem contact met ons op.<br><br>Deze plug-in wordt u GRATIS aangeboden door <a href="https://www.ideal-checkout.nl" target="_blank">iDEAL Checkout</a>. Donaties worden zeer op prijs gesteld!</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><h3>Let op!</h3></td>
	</tr>
	<tr>
		<td>Op sommige server configuraties kan de installatie wizard of de plugin/betaalmethode niet correct werken.
		Enkele voorbeelden van server beperkingen die voor problemen kunnen zorgen:
		<ul>
			<li>Verouderde PHP versie (Minimaal versie 5.3)</li>
			<li>Verouderde OpenSSL bibliotheek</li>
			<li>Ontbreken van de cUrl bibliotheek</li>
			<li>Onjuiste configuratie van de ca-bundle, <a href="http://en.wikipedia.org/wiki/Intermediate_certificate_authorities" target="_blank">klik hier</a> (nieuw venster) voor meer informatie</li>
			<li>Ontbreken van de beveiligingspatch "veiligheidspatch 5746" van 2010.</li>
		</ul></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><h3>Disclaimer</h3></td>
	</tr>
	<tr>
		<td>Het gebruik van onze scripts/plug-ins is op eigen risico! Maak altijd een back-up (van uw bestanden en uw database) voor u de scripts installeert.<br><br>Wij zijn experts op gebied van PHP en online betaalsystemen, maar hebben echter (zeer) beperkte kennis van het specifieke software pakket dat u gebruikt. Voor vragen over het gebruik, installatie of configuratie van uw webshop/webapplicatie kunt u dan ook het beste contact op nemen met de makers van deze software.</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><h3>Webshop installeren en testen</h3></td>
	</tr>
	<tr>
		<td><p>Zorg dat uw webshop/webapplicatie volledig heb geinstalleerd en geconfigureerd is. Test uw webshop grondig voordat u de installatie van onze plug-in start, zodat u zeker weet dat alles goed functioneert.<br>Enkele zaken waarmee u al rekening kunt houden bij het configureren van uw webshop:</p>
		<ul>
			<li>Veel Nederlandse banken en PSP\'s ondersteunen alleen transacties in EURO\'s.</li>
			<li>Alle iDEAL transansacties worden altijd uitgevoerd in EURO\'s.</li>
			<li>De plug-ins zijn voor het NEDERLANDSE publiek ontwikkeld en bevatten daarom, waar nodig, Nederlandse teksten.</li>
		</ul></td>
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
		<td align="right"><input onclick="javascript: window.location.href = \'step-1.php\';" type="button" value="Verder"></td>
	</tr>';

	IDEALCHECKOUT_INSTALL::output($sHtml);

?>