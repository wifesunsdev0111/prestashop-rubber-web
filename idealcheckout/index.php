<?php

	$sInstallFolder = dirname(__FILE__) . '/install';

	if(is_dir($sInstallFolder))
	{
		header('Location: install/index.php');
		exit;
	}
	else
	{
		$sHtml = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>Security Warning</title>
		<link href="https://www.ideal-checkout.nl/manuals/install/install.css" media="screen" rel="stylesheet" type="text/css">
	</head>
	<body>
		<table align="center" border="0" cellpadding="3" cellspacing="0" width="580">
			<tr>
				<td align="left" height="180" valign="top"><a href="https://www.ideal-checkout.nl" target="_blank"><img alt="iDEAL Checkout" border="0" src="https://www.ideal-checkout.nl/manuals/install/ideal-checkout-logo.png"></a></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><h1>Security Warning</h1></td>
			</tr>
			<tr>
				<td>You are not allowed to view any files within this directory due to security reasons.</td>
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
				<td align="right"><input onclick="javascript: window.location.href = \'../\';" type="button" value="Continue"></td>
			</tr>
		</table>
	</body>
</html>';

		echo $sHtml;
		exit;
	}

?>