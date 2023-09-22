<?php

	// Load setup
	require_once(dirname(__FILE__) . '/includes/init.php');

	idealcheckout_log('Calling doReport()', __FILE__, __LINE__);
	
	$oGateway = new Gateway();
	$oGateway->doReport();

	idealcheckout_log('Completed doReport()', __FILE__, __LINE__);

?>