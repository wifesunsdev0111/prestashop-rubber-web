<?php

	// Load setup
	require_once(dirname(__FILE__) . '/includes/init.php');

	idealcheckout_log('Calling doSetup()', __FILE__, __LINE__);

	$oGateway = new Gateway();
	$oGateway->doSetup();

	idealcheckout_log('Completed doSetup()', __FILE__, __LINE__);

?>