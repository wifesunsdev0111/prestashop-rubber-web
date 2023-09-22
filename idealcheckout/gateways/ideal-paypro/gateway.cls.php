<?php

	// Load gateway classes & libraries
	require_once(dirname(dirname(__FILE__)) . '/gateway.core.cls.5.php');

	if(!class_exists('PayProApi'))
	{
		require_once(dirname(__FILE__) . '/paypro.cls.php');
	}

	require_once(dirname(__FILE__) . '/gateway.cls.5.php');
	
?>