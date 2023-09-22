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
				$sHtml .= '<p>' . idealcheckout_getTranslation(false, 'idealcheckout', 'Invalid setup request.') . '</p>';
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
						$sHtml .= '<p>' . idealcheckout_getTranslation(false, 'idealcheckout', 'Transaction already completed.') . '</p>';
					}
					else
					{
						$oOmniKassa = new OmniKassa('cashondelivery');
						$oOmniKassa->setHashKey($this->aSettings['HASH_KEY']);

						if(!empty($this->aSettings['KEY_VERSION']))
						{
							$oOmniKassa->setKeyVersion($this->aSettings['KEY_VERSION']);
						}

						$oOmniKassa->setMerchant($this->aSettings['MERCHANT_ID'], $this->aSettings['SUB_ID']);
						$oOmniKassa->setAquirer($this->aSettings['GATEWAY_NAME'], $this->aSettings['TEST_MODE']);

						if(!empty($this->oRecord['language_code']))
						{
							$oOmniKassa->setLanguageCode($this->oRecord['language_code']);
						}
						
						// Set return URLs
						$oOmniKassa->setNotifyUrl(idealcheckout_getRootUrl(1) . 'idealcheckout/report.php');
						$oOmniKassa->setReturnUrl(idealcheckout_getRootUrl(1) . 'idealcheckout/return.php');

						// Set order details
						$oOmniKassa->setOrderId($this->oRecord['order_id']); // Unieke order referentie (tot 32 karakters)
						$oOmniKassa->setAmount($this->oRecord['transaction_amount'], $this->oRecord['currency_code']); // Bedrag (in EURO's)

						$iTry = 1;

						$aTransactionParams = array('omnikassa_try' => 1);

						if(!empty($this->oRecord['transaction_params']))
						{
							$aTransactionParams = idealcheckout_unserialize($this->oRecord['transaction_params']);

							if(empty($aTransactionParams['omnikassa_try']))
							{
								$aTransactionParams['omnikassa_try'] = 1;
							}
							else
							{
								$aTransactionParams['omnikassa_try']++;
								$iTry = $aTransactionParams['omnikassa_try'];
							}
						}

						$this->oRecord['transaction_params'] = idealcheckout_serialize($aTransactionParams);

						if($this->aSettings['TEST_MODE'])
						{
							$sTransactionCode = $this->oRecord['order_id'] . 'n' . $this->oRecord['id'] . 't' . time();
						}
						else
						{
							$sTransactionCode = $this->oRecord['order_id'] . 'n' . $this->oRecord['id'] . (($iTry > 1) ? 'p' . $iTry : '');
						}

						// Save transaction_code in record
						$this->oRecord['transaction_code'] = $sTransactionCode;
						$this->save();

						$oOmniKassa->setTransactionReference($sTransactionCode);


						// Customize submit button
						$oOmniKassa->setButton('' . idealcheckout_getTranslation(false, 'idealcheckout', 'Continue') . ' >>');

						$sHtml = '<p><b>' . idealcheckout_getTranslation(false, 'idealcheckout', 'Checkout with {0}', array('Rembours')) . '</b></p>' . $oOmniKassa->createForm();

						// Add auto-submit button
						if(($this->aSettings['TEST_MODE'] == false) && !idealcheckout_getDebugMode())
						{
							$sHtml .= '<script type="text/javascript"> function doAutoSubmit() { document.forms[0].submit(); } setTimeout(\'doAutoSubmit()\', 100); </script>';
						}
					}
				}
				else
				{
					$sHtml .= '<p>' . idealcheckout_getTranslation(false, 'idealcheckout', 'Invalid setup request.') . '</p>';
				}
			}

			idealcheckout_output($sHtml);
		}


		// Catch return
		public function doReturn()
		{
			global $aIdealCheckout; 

			$sHtml = '';
			
			if(empty($_POST['Data']) || empty($_POST['Seal']))
			{
				$sHtml .= '<p>' . idealcheckout_getTranslation(false, 'idealcheckout', 'Invalid return request.') . '</p>' . ($this->aSettings['TEST_MODE'] ? '<!-- Missing params in $_POST -->' : '');
			}
			else
			{
				$oOmniKassa = new OmniKassa('cashondelivery');
				$oOmniKassa->setHashKey($this->aSettings['HASH_KEY']);

				$aOmniKassaResponse = $oOmniKassa->validate();

				if($aOmniKassaResponse && is_array($aOmniKassaResponse))
				{
					$sql = "SELECT * FROM `" . $aIdealCheckout['database']['table'] . "` WHERE (`transaction_code` = '" . idealcheckout_escapeSql($aOmniKassaResponse['transaction_code']) . "') ORDER BY `id` DESC LIMIT 1;";
					if($this->oRecord = idealcheckout_database_getRecord($sql))
					{
						if(strcmp(preg_replace('/[^a-zA-Z0-9]+/', '', $aIdealCheckout['record']['order_id']), $aOmniKassaResponse['order_id']) !== 0)
						{
							idealcheckout_log($aOmniKassaResponse, __FILE__, __LINE__);
							$sHtml .= '<p>' . idealcheckout_getTranslation(false, 'idealcheckout', 'Invalid return request.') . '</p>' . ($this->aSettings['TEST_MODE'] ? '<!-- Invalid OrderId recieved -->' : '');
						}
						elseif(strcmp($this->oRecord['transaction_status'], $aOmniKassaResponse['transaction_status']) !== 0)
						{
							$this->oRecord['transaction_id'] = $aOmniKassaResponse['transaction_id'];
							$this->oRecord['transaction_status'] = $aOmniKassaResponse['transaction_status'];

							if(empty($this->oRecord['transaction_log']) == false)
							{
								$this->oRecord['transaction_log'] .= "\n\n";
							}

							$this->oRecord['transaction_log'] .= 'RETURN: Recieved status ' . $this->oRecord['transaction_status'] . ' for #' . $this->oRecord['transaction_id'] . ' on ' . date('Y-m-d, H:i:s') . '.';


							// Update transaction
							$sql = "UPDATE `" . $aIdealCheckout['database']['table'] . "` SET `transaction_date` = '" . time() . "', `transaction_id` = '" . idealcheckout_escapeSql($this->oRecord['transaction_id']) . "', `transaction_status` = '" . idealcheckout_escapeSql($this->oRecord['transaction_status']) . "', `transaction_log` = '" . idealcheckout_escapeSql($this->oRecord['transaction_log']) . "' WHERE (`id` = '" . idealcheckout_escapeSql($this->oRecord['id']) . "') LIMIT 1;";
							idealcheckout_database_query($sql) or idealcheckout_die('QUERY: ' . $sql . ', ERROR: ' . idealcheckout_database_error(), __FILE__, __LINE__);


							// Handle status change
							if(function_exists('idealcheckout_update_order_status'))
							{
								idealcheckout_update_order_status($this->oRecord, 'doReturn');
							}
						}

						if(in_array($this->oRecord['transaction_status'], array('SUCCESS')))
						{
							if(empty($this->oRecord['transaction_success_url']))
							{
								$sHtml .= '<p>' . idealcheckout_getTranslation(false, 'idealcheckout', 'Your payment was recieved.') . '<br><input style="margin: 6px;" type="button" value="' . idealcheckout_getTranslation(false, 'idealcheckout', 'Return to website') . '" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1)) . '\'"></p>';
							}
							else
							{
								header('Location: ' . $this->oRecord['transaction_success_url']);
								exit;
							}
						}
						elseif(in_array($this->oRecord['transaction_status'], array('OPEN', 'PENDING')))
						{
							if(empty($this->oRecord['transaction_pending_url']))
							{
								$sHtml .= '<p>' . idealcheckout_getTranslation(false, 'idealcheckout', 'Your payment is in progress.') . '<br><input style="margin: 6px;" type="button" value="' . idealcheckout_getTranslation(false, 'idealcheckout', 'Continue') . '" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1)) . '\'"></p>';
							}
							else
							{
								header('Location: ' . $this->oRecord['transaction_pending_url']);
								exit;
							}
						}
						elseif(in_array($this->oRecord['transaction_status'], array('CANCELLED')))
						{
							if(empty($this->oRecord['transaction_failure_url']))
							{
								$sHtml .= '<p>' . idealcheckout_getTranslation(false, 'idealcheckout', 'Your payment was cancelled.') . '<br><input style="margin: 6px;" type="button" value="' . idealcheckout_getTranslation(false, 'idealcheckout', 'Continue') . '" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1)) . '\'"></p>';
							}
							else
							{
								header('Location: ' . $this->oRecord['transaction_failure_url']);
								exit;
							}
						}
						else
						{
							if(empty($this->oRecord['transaction_failure_url']))
							{
								$sHtml .= '<p>' . idealcheckout_getTranslation(false, 'idealcheckout', 'Your payment has failed.') . '<br><input style="margin: 6px;" type="button" value="' . idealcheckout_getTranslation(false, 'idealcheckout', 'Continue') . '" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1)) . '\'"></p>';
							}
							else
							{
								header('Location: ' . $this->oRecord['transaction_failure_url']);
								exit;
							}
						}
					}
					else
					{
						$sHtml .= '<p>' . idealcheckout_getTranslation(false, 'idealcheckout', 'Invalid return request.') . '</p>' . ($this->aSettings['TEST_MODE'] ? '<!-- Cannot find record in database -->' : '');
					}
				}
				else
				{
					$sHtml .= '<p>' . idealcheckout_getTranslation(false, 'idealcheckout', 'Invalid return request.') . '</p>' . ($this->aSettings['TEST_MODE'] ? '<!-- Invalid response from OmniKassa -->' : '');
				}
			}

			idealcheckout_output($sHtml);
		}


		// Catch report
		public function doReport()
		{
			global $aIdealCheckout; 

			$sHtml = '';
			
			if(empty($_POST['Data']) || empty($_POST['Seal']))
			{
				$sHtml .= '<p>' . idealcheckout_getTranslation(false, 'idealcheckout', 'Invalid report request.') . '</p>' . ($this->aSettings['TEST_MODE'] ? '<!-- Missing params in $_POST -->' : '');
			}
			else
			{
				$oOmniKassa = new OmniKassa('cashondelivery');
				$oOmniKassa->setHashKey($this->aSettings['HASH_KEY']);

				$aOmniKassaResponse = $oOmniKassa->validate();

				if($aOmniKassaResponse && is_array($aOmniKassaResponse))
				{
					$sql = "SELECT * FROM `" . $aIdealCheckout['database']['table'] . "` WHERE (`transaction_code` = '" . idealcheckout_escapeSql($aOmniKassaResponse['transaction_code']) . "') ORDER BY `id` DESC LIMIT 1;";
					if($this->oRecord = idealcheckout_database_getRecord($sql))
					{
						if(strcmp(preg_replace('/[^a-zA-Z0-9]+/', '', $aIdealCheckout['record']['order_id']), $aOmniKassaResponse['order_id']) !== 0)
						{
							$sHtml .= '<p>' . idealcheckout_getTranslation(false, 'idealcheckout', 'Invalid report request.') . '</p>' . ($this->aSettings['TEST_MODE'] ? '<!-- Invalid OrderId recieved -->' : '');
						}
						elseif(strcmp($this->oRecord['transaction_status'], $aOmniKassaResponse['transaction_status']) !== 0)
						{
							$this->oRecord['transaction_id'] = $aOmniKassaResponse['transaction_id'];
							$this->oRecord['transaction_status'] = $aOmniKassaResponse['transaction_status'];

							if(empty($this->oRecord['transaction_log']) == false)
							{
								$this->oRecord['transaction_log'] .= "\n\n";
							}

							$this->oRecord['transaction_log'] .= 'REPORT: Recieved status ' . $this->oRecord['transaction_status'] . ' for #' . $this->oRecord['transaction_id'] . ' on ' . date('Y-m-d, H:i:s') . '.';


							// Update transaction
							$sql = "UPDATE `" . $aIdealCheckout['database']['table'] . "` SET `transaction_date` = '" . time() . "', `transaction_id` = '" . idealcheckout_escapeSql($this->oRecord['transaction_id']) . "', `transaction_status` = '" . idealcheckout_escapeSql($this->oRecord['transaction_status']) . "', `transaction_log` = '" . idealcheckout_escapeSql($this->oRecord['transaction_log']) . "' WHERE (`id` = '" . idealcheckout_escapeSql($this->oRecord['id']) . "') LIMIT 1;";
							idealcheckout_database_query($sql) or idealcheckout_die('QUERY: ' . $sql . ', ERROR: ' . idealcheckout_database_error(), __FILE__, __LINE__);


							// Handle status change
							if(function_exists('idealcheckout_update_order_status'))
							{
								idealcheckout_update_order_status($this->oRecord, 'doReport');
							}
						}

						$sHtml .= '<p>' . idealcheckout_getTranslation(false, 'idealcheckout', 'Payment status was processed.') . '</p>';
					}
					else
					{
						$sHtml .= '<p>' . idealcheckout_getTranslation(false, 'idealcheckout', 'Invalid report request.') . '</p>' . ($this->aSettings['TEST_MODE'] ? '<!-- Cannot find record in database -->' : '');
					}
				}
				else
				{
					$sHtml .= '<p>' . idealcheckout_getTranslation(false, 'idealcheckout', 'Invalid report request.') . '</p>' . ($this->aSettings['TEST_MODE'] ? '<!-- Invalid response from OmniKassa -->' : '');
				}
			}

			idealcheckout_output($sHtml);
		}
	}

?>