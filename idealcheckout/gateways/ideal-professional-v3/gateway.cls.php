<?php

	// Load gateway classes & libraries
	if(version_compare(PHP_VERSION, '5.2.0') < 0)
	{
		idealcheckout_die('iDEAL 3.3.1 requires PHP 5.2.0 for proper SHA256 support in OPENSSL libraries.<br>Your server is running PHP ' . PHP_VERSION . '.', __FILE__, __LINE__);
	}

	require_once(dirname(dirname(__FILE__)) . '/gateway.core.cls.5.php');
	require_once(dirname(__FILE__) . '/gateway.cls.5.php');
	require_once(dirname(__FILE__) . '/idealprofessional.cls.5.php');
	
?>