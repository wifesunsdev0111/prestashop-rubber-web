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
				$sHtml .= '<p>Invalid setup request.</p>';
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
						$oPaynl = new PayNL();
						$oPaynl->setCachePath($this->aSettings['TEMP_PATH']);

						$oPaynl->setServiceId($this->aSettings['SERVICE_ID']);
						$oPaynl->setTokenCode($this->aSettings['TOKEN_CODE']);
						$oPaynl->setTestMode($this->aSettings['TEST_MODE']);

						// Set order information
						$oPaynl->setOrder($this->oRecord['order_id'], $this->oRecord['transaction_description'], $this->oRecord['transaction_amount'], $this->oRecord['currency_code']);
						$oPaynl->setPaymentMethod('MANUALTRANSFER');
						$oPaynl->setReturnUrl(idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?idealcheckout_order_id=' . urlencode($sOrderId) . '&idealcheckout_order_code=' . urlencode($sOrderCode));
						$oPaynl->setReportUrl(idealcheckout_getRootUrl(1) . 'idealcheckout/report.php?idealcheckout_order_id=' . urlencode($sOrderId) . '&idealcheckout_order_code=' . urlencode($sOrderCode));


						// Find TransactionId & TransactionUrl
						list($sTransactionId, $sTransactionUrl) = $oPaynl->getTransaction();

						if($oPaynl->hasErrors())
						{
							if($this->aSettings['TEST_MODE'])
							{
								idealcheckout_output('<code>' . var_export($oPaynl->getErrors(), true) . '</code>');
							}
							else
							{
								$this->oRecord['transaction_status'] = 'FAILURE';

								if(empty($this->oRecord['transaction_log']) == false)
								{
									$this->oRecord['transaction_log'] .= "\n\n";
								}

								$this->oRecord['transaction_log'] .= 'Executing TransactionRequest on ' . date('Y-m-d, H:i:s') . '. Recieved: ERROR' . "\n" . var_export($oPaynl->getErrors(), true);
								$this->save();

								$sHtml = '<p>Door een technische storing kunnen er momenteel helaas geen betalingen worden verwerkt. Onze excuses voor het ongemak.</p>';

								if($this->oRecord['transaction_payment_url'])
								{
									$sHtml .= '<p><a href="' . htmlentities($this->oRecord['transaction_payment_url']) . '">kies een andere betaalmethode</a></p>';
								}
								elseif($this->oRecord['transaction_failure_url'])
								{
									$sHtml .= '<p><a href="' . htmlentities($this->oRecord['transaction_failure_url']) . '">terug naar de website</a></p>';
								}

								$sHtml .= '<!--

' . var_export($oPaynl->getErrors(), true) . '

-->';
								
								idealcheckout_output($sHtml);
							}
						}

						if(empty($this->oRecord['transaction_log']) == false)
						{
							$this->oRecord['transaction_log'] .= "\n\n";
						}

						$this->oRecord['transaction_log'] .= 'Executing TransactionRequest on ' . date('Y-m-d, H:i:s') . '. Recieved: ' . $sTransactionId;
						$this->oRecord['transaction_id'] = $sTransactionId;
						$this->oRecord['transaction_url'] = $sTransactionUrl;
						$this->oRecord['transaction_status'] = 'OPEN';
						$this->oRecord['transaction_date'] = time();

						$this->save();

						// die('<a href="' . $oPaynl->getTransactionUrl() . '">' . $oPaynl->getTransactionUrl() . '</a>');
						$oPaynl->doTransaction();
					}
				}
				else
				{
					$sHtml .= '<p>Invalid transaction request.</p>';
				}
			}

			idealcheckout_output($sHtml);
		}


		// Catch return
		public function doReturn()
		{
			$sHtml = '';

			if(empty($_GET['idealcheckout_order_id']) || empty($_GET['idealcheckout_order_code']))
			{
				$sHtml .= '<p>Invalid return request.</p>';
			}
			else
			{
				$sOrderId = $_GET['idealcheckout_order_id'];
				$sOrderCode = $_GET['idealcheckout_order_code'];

				// Lookup record
				if($this->getRecordByOrder())
				{
					// Transaction already finished
					if(strcmp($this->oRecord['transaction_status'], 'SUCCESS') === 0)
					{
						if($this->oRecord['transaction_success_url'])
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
						// Check status
						$oPaynl = new PayNL();
						$oPaynl->setCachePath($this->aSettings['TEMP_PATH']);

						$oPaynl->setServiceId($this->aSettings['SERVICE_ID']);
						$oPaynl->setTokenCode($this->aSettings['TOKEN_CODE']);
						$oPaynl->setTestMode($this->aSettings['TEST_MODE']);

						$sTransactionStatus = $oPaynl->getStatus($this->oRecord['transaction_id']);

						if(!$oPaynl->hasErrors() && (strcasecmp($sTransactionStatus, $this->oRecord['transaction_status']) !== 0))
						{
							$this->oRecord['transaction_status'] = $sTransactionStatus;

							if($oPaynl->hasErrors())
							{
								if($this->aSettings['TEST_MODE'])
								{
									idealcheckout_output('<code>' . var_export($oPaynl->getErrors(), true) . '</code>');
								}
								else
								{
									$this->oRecord['transaction_status'] = 'FAILURE';

									if(empty($this->oRecord['transaction_log']) == false)
									{
										$this->oRecord['transaction_log'] .= "\n\n";
									}

									$this->oRecord['transaction_log'] .= 'Executing StatusRequest on ' . date('Y-m-d, H:i:s') . '. Recieved: ERROR' . "\n" . var_export($oPaynl->getErrors(), true);
									$this->save();

									$sHtml = '<p>Door een technische storing kunnen er momenteel helaas geen betalingen worden verwerkt. Onze excuses voor het ongemak.</p>';

									$sHtml .= '<!--

' . var_export($oPaynl->getErrors(), true) . '

-->';

									idealcheckout_log('TRUE|Error while retrieving status for order ' . $sOrderId, __FILE__, __LINE__, true);
									idealcheckout_log($oPaynl->getErrors(), __FILE__, __LINE__);
									idealcheckout_output($sHtml);
								}
							}

							if(empty($this->oRecord['transaction_log']) == false)
							{
								$this->oRecord['transaction_log'] .= "\n\n";
							}

							$this->oRecord['transaction_log'] .= 'Executing StatusRequest on ' . date('Y-m-d, H:i:s') . ' for #' . $this->oRecord['transaction_id'] . '. Recieved: ' . $this->oRecord['transaction_status'];
							$this->save();



							// Handle status change
							if(function_exists('idealcheckout_update_order_status'))
							{
								idealcheckout_update_order_status($this->oRecord, 'doReturn');
							}
						}



						// Set status message
						if(strcmp($this->oRecord['transaction_status'], 'SUCCESS') === 0)
						{
							$sHtml .= '<p>Uw betaling is met succes ontvangen.' . ($this->oRecord['transaction_success_url'] ? '<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars($this->oRecord['transaction_success_url']) . '\'">' : '') . '</p>';
						}
						elseif(strcmp($this->oRecord['transaction_status'], 'PENDING') === 0)
						{
							$sHtml .= '<p>Uw betaling is in behandeling.' . ($this->oRecord['transaction_success_url'] ? '<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars($this->oRecord['transaction_success_url']) . '\'">' : '') . '</p>';
						}
						else
						{
							if(strcasecmp($this->oRecord['transaction_status'], 'CANCELLED') === 0)
							{
								$sHtml .= '<p>Uw betaling is geannuleerd. Probeer opnieuw te betalen.<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/setup.php?order_id=' . $this->oRecord['order_id'] . '&order_code=' . $this->oRecord['order_code']) . '\'"></p>';
							}
							else // if(strcasecmp($this->oRecord['transaction_status'], 'FAILURE') === 0)
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


						if($this->oRecord['transaction_success_url'] && (strcasecmp($this->oRecord['transaction_status'], 'SUCCESS') === 0))
						{
							header('Location: ' . $this->oRecord['transaction_success_url']);
							exit;
						}
						elseif($this->oRecord['transaction_payment_url'] && !in_array($this->oRecord['transaction_status'], array('SUCCESS', 'PENDING')))
						{
							header('Location: ' . $this->oRecord['transaction_payment_url']);
							exit;
						}
						elseif($this->oRecord['transaction_failure_url'] && !in_array($this->oRecord['transaction_status'], array('SUCCESS', 'PENDING')))
						{
							header('Location: ' . $this->oRecord['transaction_failure_url']);
							exit;
						}
					}
				}
				else
				{
					$sHtml .= '<p>Invalid return request.</p>';
				}
			}

			idealcheckout_output($sHtml);
		}


		// Catch report
		public function doReport()
		{
			$sHtml = '';

			if(empty($_GET['idealcheckout_order_id']) || empty($_GET['idealcheckout_order_code']))
			{
				$sHtml .= '<p>Invalid return request.</p>';

				idealcheckout_log('TRUE|Invalid ORDER_ID or ORDER_CODE.', __FILE__, __LINE__, true);
				die('TRUE|Invalid ORDER_ID or ORDER_CODE.');
			}
			elseif(isset($_GET['action']) && (strcasecmp($_GET['action'], 'pending') === 0))
			{
				idealcheckout_log('TRUE|Ignoring pending', __FILE__, __LINE__, true);
				die('TRUE|Ignoring pending');
			}
			else
			{
				$sOrderId = $_GET['idealcheckout_order_id'];
				$sOrderCode = $_GET['idealcheckout_order_code'];

				// Lookup record
				if($this->getRecordByOrder())
				{
					// Transaction already finished
					if(strcmp($this->oRecord['transaction_status'], 'SUCCESS') === 0)
					{
						$sHtml .= '<p>Uw betaling is met succes ontvangen.<br><input style="margin: 6px;" type="button" value="Terug naar de website" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1)) . '\'"></p>';
					}
					else
					{
						// Check status
						$oPaynl = new PayNL();
						$oPaynl->setCachePath($this->aSettings['TEMP_PATH']);

						$oPaynl->setServiceId($this->aSettings['SERVICE_ID']);
						$oPaynl->setTokenCode($this->aSettings['TOKEN_CODE']);
						$oPaynl->setTestMode($this->aSettings['TEST_MODE']);

						$sTransactionStatus = $oPaynl->getStatus($this->oRecord['transaction_id']);

						if(!$oPaynl->hasErrors() && (strcasecmp($sTransactionStatus, $this->oRecord['transaction_status']) !== 0))
						{
							$this->oRecord['transaction_status'] = $sTransactionStatus;

							if($oPaynl->hasErrors())
							{
								if($this->aSettings['TEST_MODE'])
								{
									// idealcheckout_output('<code>' . var_export($oPaynl->getErrors(), true) . '</code>');
								}
								else
								{
									$this->oRecord['transaction_status'] = 'FAILURE';

									if(empty($this->oRecord['transaction_log']) == false)
									{
										$this->oRecord['transaction_log'] .= "\n\n";
									}

									$this->oRecord['transaction_log'] .= 'Executing StatusRequest on ' . date('Y-m-d, H:i:s') . '. Recieved: ERROR' . "\n" . var_export($oPaynl->getErrors(), true);
									$this->save();

									$sHtml = '<p>Door een technische storing kunnen er momenteel helaas geen betalingen worden verwerkt. Onze excuses voor het ongemak.</p>';

									$sHtml .= '<!--

' . var_export($oPaynl->getErrors(), true) . '

-->';

									// idealcheckout_output($sHtml);
								}

								idealcheckout_log('TRUE|Error while retrieving status for order ' . $sOrderId, __FILE__, __LINE__, true);
								idealcheckout_log($oPaynl->getErrors(), __FILE__, __LINE__);
								die('TRUE|Error while retrieving status for order ' . $sOrderId);
							}

							if(empty($this->oRecord['transaction_log']) == false)
							{
								$this->oRecord['transaction_log'] .= "\n\n";
							}

							$this->oRecord['transaction_log'] .= 'Executing StatusRequest on ' . date('Y-m-d, H:i:s') . ' for #' . $this->oRecord['transaction_id'] . '. Recieved: ' . $this->oRecord['transaction_status'];
							$this->save();



							// Handle status change
							if(function_exists('idealcheckout_update_order_status'))
							{
								idealcheckout_update_order_status($this->oRecord, 'doReport');
							}
						}



						// Set status message
						if(strcmp($this->oRecord['transaction_status'], 'SUCCESS') === 0)
						{
							$sHtml .= '<p>Uw betaling is met succes ontvangen.' . ($this->oRecord['transaction_success_url'] ? '<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars($this->oRecord['transaction_success_url']) . '\'">' : '') . '</p>';
						}
						elseif(strcmp($this->oRecord['transaction_status'], 'PENDING') === 0)
						{
							$sHtml .= '<p>Uw betaling is in behandeling.' . ($this->oRecord['transaction_success_url'] ? '<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars($this->oRecord['transaction_success_url']) . '\'">' : '') . '</p>';
						}
						else
						{
							if(strcasecmp($this->oRecord['transaction_status'], 'CANCELLED') === 0)
							{
								$sHtml .= '<p>Uw betaling is geannuleerd. Probeer opnieuw te betalen.<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/setup.php?order_id=' . $this->oRecord['order_id'] . '&order_code=' . $this->oRecord['order_code']) . '\'"></p>';
							}
							else // if(strcasecmp($this->oRecord['transaction_status'], 'FAILURE') === 0)
							{
								$sHtml .= '<p>Uw betaling is mislukt. Probeer opnieuw te betalen.<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/setup.php?order_id=' . $this->oRecord['order_id'] . '&order_code=' . $this->oRecord['order_code']) . '\'"></p>';
							}
						}
					}

					idealcheckout_log('TRUE|Status ' . $this->oRecord['transaction_status'] . ' processed for order ' . $sOrderId, __FILE__, __LINE__, true);
					die('TRUE|Status ' . $this->oRecord['transaction_status'] . ' processed for order ' . $sOrderId);
				}
				else
				{
					$sHtml .= '<p>Invalid report request.</p>';
				}
			}

			idealcheckout_log('TRUE|Invalid ORDER_ID or ORDER_CODE.', __FILE__, __LINE__, true);
			die('TRUE|Invalid ORDER_ID or ORDER_CODE.');
			idealcheckout_output($sHtml);
		}


		// Validate all open transactions
		public function doValidate()
		{
			global $aIdealCheckout; 

			$sql = "SELECT * FROM `" . $aIdealCheckout['database']['table'] . "` WHERE (`transaction_status` = 'OPEN') AND (`gateway_code` = '" . idealcheckout_escapeSql($aIdealCheckout['record']['gateway_code']) . "') AND " . (empty($aIdealCheckout['record']['store_code']) ? "((`store_code` IS NULL) OR (`store_code` = ''))" : "(`store_code` = '" . idealcheckout_escapeSql($aIdealCheckout['record']['store_code']) . "')") . " AND ((`transaction_success_url` IS NULL) OR (`transaction_success_url` = '') OR (`transaction_success_url` LIKE '" . idealcheckout_escapeSql(idealcheckout_getRootUrl(1)) . "%')) ORDER BY `id` ASC;";
			$oRecordset = idealcheckout_database_query($sql) or idealcheckout_die('QUERY: ' . $sql . "\n\n" . 'ERROR: ' . idealcheckout_database_error() . '', __FILE__, __LINE__);

			$sHtml = '<b>Controle van openstaande transacties.</b><br>';

			if(idealcheckout_database_num_rows($oRecordset))
			{
				while($aRecord = idealcheckout_database_fetch_assoc($oRecordset))
				{
					// Execute status request
					$oPaynl = new PayNL();
					$oPaynl->setCachePath($this->aSettings['TEMP_PATH']);

					$oPaynl->setServiceId($this->aSettings['SERVICE_ID']);
					$oPaynl->setTokenCode($this->aSettings['TOKEN_CODE']);
					$oPaynl->setTestMode($this->aSettings['TEST_MODE']);

					$this->oRecord['transaction_status'] = $oPaynl->getStatus($aRecord['transaction_id']);

					if(empty($aRecord['transaction_log']) == false)
					{
						$aRecord['transaction_log'] .= "\n\n";
					}

					if($oPaynl->hasErrors())
					{
						$aRecord['transaction_status'] = 'FAILURE';
						$aRecord['transaction_log'] .= 'Executing StatusRequest on ' . date('Y-m-d, H:i:s') . '. Recieved: ERROR' . "\n" . var_export($oPaynl->getErrors(), true);
					}
					else
					{
						$aRecord['transaction_log'] .= 'Executing StatusRequest on ' . date('Y-m-d, H:i:s') . ' for #' . $aRecord['transaction_id'] . '. Recieved: ' . $aRecord['transaction_status'];
					}

					$this->save($aRecord);


					// Add to body
					$sHtml .= '<br>#' . $aRecord['transaction_id'] . ' : ' . $aRecord['transaction_status'];


					// Handle status change
					if(function_exists('idealcheckout_update_order_status'))
					{
						idealcheckout_update_order_status($aRecord, 'doValidate');
					}
				}

				$sHtml .= '<br><br><br>Alle openstaande transacties zijn bijgewerkt.';
			}
			else
			{
				$sHtml .= '<br>Er zijn geen openstaande transacties gevonden.';
			}

			idealcheckout_output('<p>' . $sHtml . '</p><p>&nbsp;</p><p><input type="button" value="Venster sluiten" onclick="javascript: window.close();"></p>');
		}
	}

?>