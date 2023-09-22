<?php

	// Load gateway classes & libraries
	if(version_compare(PHP_VERSION, '5', '<'))
	{
		idealcheckout_die('PHP5 Required', __FILE__, __LINE__);
	}
	else
	{
		require_once(dirname(dirname(__FILE__)) . '/gateway.core.cls.5.php');
		require_once(dirname(__FILE__) . '/gateway.cls.5.php');
		require_once(dirname(__FILE__) . '/paysafecardtargetpay.cls.5.php');
	}
	
?>