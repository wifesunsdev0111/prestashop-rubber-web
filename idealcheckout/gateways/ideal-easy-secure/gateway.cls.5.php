<?php

	class Gateway extends GatewayCore
	{
		// Load iDEAL settings
		public function __construct()
		{
			$this->init();
		}

		
		// Setup payment
		public function doSetup()
		{
			$sHtml = '';

			// Look for proper GET's en POST's
			if(empty($_GET['order_id']) || empty($_GET['order_code']))
			{
				$sHtml .= '<p>Invalid setup request.</p>
<!-- Invalid orderid/ordercode -->';
			}
			else
			{
				$sOrderId = $_GET['order_id'];
				$sOrderCode = $_GET['order_code'];

				// Lookup transaction
				if($this->getRecordByOrder())
				{
					if(strcmp($this->oRecord['transaction_status'], 'SUCCESS') === 0)
					{
						$sHtml .= '<p>Transaction already completed</p>';
					}
					else
					{
						$oIdeal = new IdealInternetKassa();

						// Account settings
						$oIdeal->setValue('ACQUIRER', $this->aSettings['GATEWAY_NAME']); // Aquirer Name
						$oIdeal->setValue('PSPID', $this->aSettings['PSP_ID']); // Merchant Id
						$oIdeal->setValue('ACQUIRER', $this->aSettings['GATEWAY_NAME']); // Aquirer Name
						$oIdeal->setValue('PSPID', $this->aSettings['PSP_ID']); // Merchant Id
						$oIdeal->setValue('TEST_MODE', $this->aSettings['TEST_MODE']); // True=TEST, False=LIVE

						if(!empty($this->aSettings['SHA_1_IN']))
						{
							$oIdeal->setValue('SHA1_IN_KEY', $this->aSettings['SHA_1_IN']); // Secret Hash Key
						}

						if(!empty($this->aSettings['SHA_1_OUT']))
						{
							$oIdeal->setValue('SHA1_OUT_KEY', $this->aSettings['SHA_1_OUT']); // Secret Hash Key

							// Webshop settings
							$oIdeal->setValue('accepturl', idealcheckout_getRootUrl(1) . 'idealcheckout/return.php'); // Success/pending URL
							$oIdeal->setValue('declineurl', idealcheckout_getRootUrl(1) . 'idealcheckout/return.php'); // Failure URL
							$oIdeal->setValue('exceptionurl', idealcheckout_getRootUrl(1) . 'idealcheckout/return.php'); // Failure URL
							$oIdeal->setValue('cancelurl', idealcheckout_getRootUrl(1) . 'idealcheckout/return.php'); // Cancelled URL
							$oIdeal->setValue('backurl', idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?trxid=' . $this->oRecord['transaction_id'] . '&ec=' . $this->oRecord['transaction_code'] . '&status=CANCELLED'); // Cart/Checkout URL
							$oIdeal->setValue('homeurl', idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?trxid=' . $this->oRecord['transaction_id'] . '&ec=' . $this->oRecord['transaction_code'] . '&status=CANCELLED'); // Homepage URL
							$oIdeal->setValue('catalogurl', idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?trxid=' . $this->oRecord['transaction_id'] . '&ec=' . $this->oRecord['transaction_code'] . '&status=CANCELLED'); // Catalog URL
						}
						else
						{
							// Webshop settings
							$oIdeal->setValue('accepturl', idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?trxid=' . $this->oRecord['transaction_id'] . '&ec=' . $this->oRecord['transaction_code'] . '&status=SUCCESS'); // Success/pending URL
							$oIdeal->setValue('declineurl', idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?trxid=' . $this->oRecord['transaction_id'] . '&ec=' . $this->oRecord['transaction_code'] . '&status=FAILURE'); // Failure URL
							$oIdeal->setValue('exceptionurl', idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?trxid=' . $this->oRecord['transaction_id'] . '&ec=' . $this->oRecord['transaction_code'] . '&status=FAILURE'); // Failure URL
							$oIdeal->setValue('cancelurl', idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?trxid=' . $this->oRecord['transaction_id'] . '&ec=' . $this->oRecord['transaction_code'] . '&status=CANCELLED'); // Cancelled URL
							$oIdeal->setValue('backurl', idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?trxid=' . $this->oRecord['transaction_id'] . '&ec=' . $this->oRecord['transaction_code'] . '&status=CANCELLED'); // Cart/Checkout URL
							$oIdeal->setValue('homeurl', idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?trxid=' . $this->oRecord['transaction_id'] . '&ec=' . $this->oRecord['transaction_code'] . '&status=CANCELLED'); // Homepage URL
							$oIdeal->setValue('catalogurl', idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?trxid=' . $this->oRecord['transaction_id'] . '&ec=' . $this->oRecord['transaction_code'] . '&status=CANCELLED'); // Catalog URL
						}

						// Payment method(s)
						$oIdeal->setValue('PM', 'iDEAL'); // Force 'iDEAL' or 'CreditCard'
						// $oIdeal->setValue('PMLIST', 'iDEAL;CreditCard'); // Available payment methods in acquirer GUI (when no PM was forced)
						$oIdeal->setValue('OPERATION', 'SAL');

						// Order settings
						$oIdeal->setValue('orderID', $this->oRecord['order_id']); // Order ID
						$oIdeal->setValue('COM', $this->oRecord['transaction_description']); // Order Description
						$oIdeal->setValue('amount', intval(round($this->oRecord['transaction_amount'] * 100))); // Order Amount
						
						// Customer settings (Optional)
						// $oIdeal->setValue('CN', 'iDEAL Checkout'); // Customer Name
						// $oIdeal->setValue('EMAIL', 'info@ideal-checkout.nl'); // Customer Email

						$sHtml = '<p><b>Direct online afrekenen via uw eigen bank.</b></p>' . $oIdeal->createForm('Verder >>') . '</div>';

						// Add auto-submit button
						if(($this->aSettings['TEST_MODE'] == false) && !idealcheckout_getDebugMode())
						{
							$sHtml .= '<script type="text/javascript"> function doAutoSubmit() { document.forms[0].submit(); } setTimeout(\'doAutoSubmit()\', 100); </script>';
						}
					}
				}
				else
				{
					$sHtml .= '<p>Invalid setup request.</p>
<!-- Invalid orderid/ordercode -->';
				}
			}

			idealcheckout_output($sHtml);
		}


		// Catch return
		public function doReturn()
		{
			global $aIdealCheckout; 
			$sHtml = '';





			if(!empty($_GET['trxid']) && !empty($_GET['ec']) && !empty($_GET['status']))
			{
				$sTransactionId = $_GET['trxid'];
				$sTransactionCode = $_GET['ec'];
				$sTransactionStatus = $_GET['status'];

				if($this->getRecordByTransaction($sTransactionId, $sTransactionCode))
				{
					if(strcmp($this->oRecord['transaction_status'], 'SUCCESS') === 0)
					{
						if(!empty($this->oRecord['transaction_success_url']))
						{
							header('Location: ' . $this->oRecord['transaction_success_url']);
							exit;
						}
						else
						{
							$sHtml .= '<p>Uw betaling is met succes ontvangen.<br><input style="margin: 6px;" type="button" value="Terug naar de website" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1)) . '\'"></p>';
						}
					}
					elseif(empty($this->aSettings['SHA_1_OUT']))
					{
						$this->oRecord['transaction_status'] = ((empty($_GET['status']) || (in_array($_GET['status'], array('SUCCESS', 'CANCELLED', 'FAILURE')) == false)) ? 'FAILURE' : $_GET['status']);

						if(strcmp($this->oRecord['transaction_status'], 'SUCCESS') === 0)
						{
							$sHtml .= '<p>Uw betaling is met succes ontvangen.' . ($this->oRecord['transaction_success_url'] ? '<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars($this->oRecord['transaction_success_url']) . '\'">' : '') . '</p>';
						}
						elseif((strcmp($this->oRecord['transaction_status'], 'OPEN') === 0) && !empty($this->oRecord['transaction_url']))
						{
							$sHtml .= '<p>Uw betaling is nog niet afgerond.' . ($this->oRecord['transaction_url'] ? '<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars($this->oRecord['transaction_url']) . '\'">' : '') . '</p>';
						}
						else
						{
							if(strcmp($this->oRecord['transaction_status'], 'CANCELLED') === 0)
							{
								$sHtml .= '<p>Uw betaling is geannuleerd. Probeer opnieuw te betalen.<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/setup.php?order_id=' . $this->oRecord['order_id'] . '&order_code=' . $this->oRecord['order_code']) . '\'"></p>';
							}
							elseif(strcmp($this->oRecord['transaction_status'], 'EXPIRED') === 0)
							{
								$sHtml .= '<p>Uw betaling is mislukt. Probeer opnieuw te betalen.<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/setup.php?order_id=' . $this->oRecord['order_id'] . '&order_code=' . $this->oRecord['order_code']) . '\'"></p>';
							}
							else // if(strcmp($this->oRecord['transaction_status'], 'FAILURE') === 0)
							{
								$sHtml .= '<p>Uw betaling is mislukt. Probeer opnieuw te betalen.<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/setup.php?order_id=' . $this->oRecord['order_id'] . '&order_code=' . $this->oRecord['order_code']) . '\'"></p>';
							}


							if($this->oRecord['transaction_payment_url'])
							{
								$sHtml .= '<p><a href="' . htmlentities($this->oRecord['transaction_payment_url']) . '">kies een andere betaalmethode</a></p>';
							}
							elseif($this->oRecord['transaction_failure_url'])
							{
								$sHtml .= '<p><a href="' . htmlentities($this->oRecord['transaction_failure_url']) . '">ik kan nu niet betalen via deze betaalmethode</a></p>';
							}
						}


						if(empty($this->oRecord['transaction_log']) == false)
						{
							$this->oRecord['transaction_log'] .= "\n\n";
						}

						$this->oRecord['transaction_log'] .= 'Recieved status ' . $this->oRecord['transaction_status'] . ' on ' . date('Y-m-d, H:i:s') . '.';


						// Update transaction
						$sql = "UPDATE `" . $aIdealCheckout['database']['table'] . "` SET `transaction_date` = '" . time() . "' , `transaction_status` = '" . idealcheckout_escapeSql($this->oRecord['transaction_status']) . "', `transaction_log` = '" . idealcheckout_escapeSql($this->oRecord['transaction_log']) . "' WHERE (`id` = '" . idealcheckout_escapeSql($this->oRecord['id']) . "') LIMIT 1;";
						idealcheckout_database_query($sql) or idealcheckout_die('QUERY: ' . $sql . ', ERROR: ' . idealcheckout_database_error(), __FILE__, __LINE__);


						// Handle status change
						if(function_exists('idealcheckout_update_order_status'))
						{
							idealcheckout_update_order_status($this->oRecord, 'doReturn');
						}
					}
					else
					{
						$sHtml .= '<p>Uw betaling is geannuleerd. Probeer opnieuw te betalen.<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/setup.php?order_id=' . $this->oRecord['order_id'] . '&order_code=' . $this->oRecord['order_code']) . '\'"></p>';

						if($this->oRecord['transaction_payment_url'])
						{
							$sHtml .= '<p><a href="' . htmlentities($this->oRecord['transaction_payment_url']) . '">kies een andere betaalmethode</a></p>';
						}
						elseif($this->oRecord['transaction_failure_url'])
						{
							$sHtml .= '<p><a href="' . htmlentities($this->oRecord['transaction_failure_url']) . '">ik kan nu niet betalen via deze betaalmethode</a></p>';
						}

						$this->oRecord['transaction_status'] = 'CANCELLED';
					}
				}

				idealcheckout_output($sHtml);
			}





			$oIdeal = new IdealInternetKassa();

			// Account settings
			$oIdeal->setValue('ACQUIRER', $this->aSettings['GATEWAY_NAME']); // Aquirer Name
			$oIdeal->setValue('PSPID', $this->aSettings['PSP_ID']); // Merchant Id
			$oIdeal->setValue('TEST_MODE', $this->aSettings['TEST_MODE']); // True=TEST, False=LIVE

			if(!empty($this->aSettings['SHA_1_IN']))
			{
				$oIdeal->setValue('SHA1_IN_KEY', $this->aSettings['SHA_1_IN']); // Secret Hash Key
			}

			if(!empty($this->aSettings['SHA_1_OUT']))
			{
				$oIdeal->setValue('SHA1_OUT_KEY', $this->aSettings['SHA_1_OUT']); // Secret Hash Key
			}

			$sTransactionStatus = $oIdeal->validate();

			if($sTransactionStatus === false)
			{
				$sHtml .= '<p>Invalid return request.</p>
<!-- Invalid signature -->';
			}
			else
			{
				$sOrderId = $oIdeal->getValue('ORDERID');
				$sTransactionId = $oIdeal->getValue('PAYID');

				// Lookup record
				if($this->getRecordByOrder($sOrderId))
				{
					if(strcmp($this->oRecord['transaction_status'], 'SUCCESS') === 0)
					{
						if(!empty($this->oRecord['transaction_success_url']))
						{
							header('Location: ' . $this->oRecord['transaction_success_url']);
							exit;
						}
						else
						{
							$sHtml .= '<p>Uw betaling is met succes ontvangen.<br><input style="margin: 6px;" type="button" value="Terug naar de website" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1)) . '\'"></p>';
						}
					}
					else
					{
						$this->oRecord['transaction_id'] = $sTransactionId;
						$this->oRecord['transaction_status'] = $sTransactionStatus;

						if(empty($this->oRecord['transaction_log']) == false)
						{
							$this->oRecord['transaction_log'] .= "\n\n";
						}

						$this->oRecord['transaction_log'] .= 'Recieved status ' . $this->oRecord['transaction_status'] . ' for #' . $sTransactionId . ' on ' . date('Y-m-d, H:i:s') . '.';


						if(strcmp($this->oRecord['transaction_status'], 'SUCCESS') === 0)
						{
							$sHtml .= '<p>Uw betaling is met succes ontvangen.<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars($this->oRecord['transaction_success_url']) . '\'"></p>';
						}
						else
						{
							if(strcmp($this->oRecord['transaction_status'], 'CANCELLED') === 0)
							{
								$sHtml .= '<p>Uw betaling is geannuleerd. Probeer opnieuw te betalen.<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/setup.php?order_id=' . $this->oRecord['order_id'] . '&order_code=' . $this->oRecord['order_code']) . '\'"></p>';
							}
							elseif(strcmp($this->oRecord['transaction_status'], 'EXPIRED') === 0)
							{
								$sHtml .= '<p>Uw betaling is mislukt. Probeer opnieuw te betalen.<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/setup.php?order_id=' . $this->oRecord['order_id'] . '&order_code=' . $this->oRecord['order_code']) . '\'"></p>';
							}
							else // if(strcmp($this->oRecord['transaction_status'], 'FAILURE') === 0)
							{
								$sHtml .= '<p>Uw betaling is mislukt. Probeer opnieuw te betalen.<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/setup.php?order_id=' . $this->oRecord['order_id'] . '&order_code=' . $this->oRecord['order_code']) . '\'"></p>';
							}


							if($this->oRecord['transaction_payment_url'])
							{
								$sHtml .= '<p><a href="' . htmlentities($this->oRecord['transaction_payment_url']) . '">kies een andere betaalmethode</a></p>';
							}
							elseif($this->oRecord['transaction_failure_url'])
							{
								$sHtml .= '<p><a href="' . htmlentities($this->oRecord['transaction_failure_url']) . '">ik kan nu niet betalen via deze betaalmethode</a></p>';
							}
						}


						// Update transaction
						$sql = "UPDATE `" . $aIdealCheckout['database']['table'] . "` SET `transaction_date` = '" . time() . "', `transaction_id` = '" . idealcheckout_escapeSql($this->oRecord['transaction_id']) . "', `transaction_status` = '" . idealcheckout_escapeSql($this->oRecord['transaction_status']) . "', `transaction_log` = '" . idealcheckout_escapeSql($this->oRecord['transaction_log']) . "' WHERE (`id` = '" . idealcheckout_escapeSql($this->oRecord['id']) . "') LIMIT 1;";
						idealcheckout_database_query($sql) or idealcheckout_die('QUERY: ' . $sql . ', ERROR: ' . idealcheckout_database_error(), __FILE__, __LINE__);



						// Handle status change
						if(function_exists('idealcheckout_update_order_status'))
						{
							idealcheckout_update_order_status($this->oRecord, 'doReturn');
						}



						if(!empty($this->oRecord['transaction_success_url']) && (strcmp($this->oRecord['transaction_status'], 'SUCCESS') === 0))
						{
							header('Location: ' . $this->oRecord['transaction_success_url']);
							exit;
						}
					}
				}
				else
				{
					$sHtml .= '<p>Invalid return request.</p>
<!-- Invalid orderID -->';
				}
			}

			idealcheckout_output($sHtml);
		}
	}

?>