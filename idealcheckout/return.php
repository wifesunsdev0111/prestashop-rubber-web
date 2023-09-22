<?php

	// Load setup
	require_once(dirname(__FILE__) . '/includes/init.php');

	idealcheckout_log('Calling doReturn()', __FILE__, __LINE__);

	$oGateway = new Gateway();
	$oGateway->doReturn();

	idealcheckout_log('Completed doReturn()', __FILE__, __LINE__);

?>