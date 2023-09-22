<?php

	// Update order status when required
	function idealcheckout_update_order_status($aRecord, $sView)
	{
		idealcheckout_log('Updating status to "' . $aRecord['transaction_status'] . '" for order #' . $aRecord['order_id'], __FILE__, __LINE__);
		idealcheckout_log($aRecord, __FILE__, __LINE__);

		$aDatabaseSettings = idealcheckout_getDatabaseSettings();

		$iOrderState = 0;

		if(strcasecmp($aRecord['transaction_status'], 'SUCCESS') === 0)
		{
			$iOrderState = 2;
		}
		elseif(strcasecmp($aRecord['transaction_status'], 'PENDING') === 0)
		{
			$iOrderState = 1000;
		}
		elseif(strcasecmp($aRecord['transaction_status'], 'CANCELLED') === 0)
		{
			$iOrderState = 6;
		}
		else // if(strcasecmp($aRecord['transaction_status'], 'FAILED') === 0)
		{
			$iOrderState = 8;
		}

		idealcheckout_log('We have found order state: ' . $iOrderState, __FILE__, __LINE__);


		// Verify valid prestashop order id
		if(($iOrderState > 0) && is_numeric($aRecord['order_id']))
		{
			$sql = "SELECT * FROM `" . $aDatabaseSettings['prefix'] . "orders` WHERE (`id_order` = '" . $aRecord['order_id'] . "') LIMIT 1";
			if($aOrder = idealcheckout_database_getRecord($sql))
			{
				include_once(dirname(__FILE__) . '/../../config/config.inc.php');
				include_once(dirname(__FILE__) . '/../../init.php');

				$history = new OrderHistory();

				// change order state
				$history->id_order = $aRecord['order_id'];
				$history->changeIdOrderState(intval($iOrderState), intval($aRecord['order_id']));

				$history->addWithemail(true, false);
			}
			else
			{
				idealcheckout_log('No record found with query: ' . $sql, __FILE__, __LINE__);
			}
		}
		elseif($iOrderState > 0)
		{
			idealcheckout_log('Order_id is not numeric. order_id = ' . $aRecord['order_id'], __FILE__, __LINE__);
		}
		else
		{
			idealcheckout_log('Order State has not been changed.', __FILE__, __LINE__);
		}
		
		if($iOrderState > 0)
		{
			idealcheckout_log('Sending mail for order #' . $aRecord['order_id'], __FILE__, __LINE__);
			idealcheckout_sendMail($aRecord);
		}
	}

?>