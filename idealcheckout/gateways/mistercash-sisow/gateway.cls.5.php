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
			global $aIdealCheckout;

			$sHtml = '';

			// Look for proper GET's en POST's
			if(empty($_GET['order_id']) || empty($_GET['order_code']))
			{
				$sHtml .= '<p>Invalid transaction request.</p>';
			}
			else
			{
				$sIssuerId = '01';
				$sOrderId = $_GET['order_id'];
				$sOrderCode = $_GET['order_code'];

				// Lookup transaction
				if($this->getRecordByOrder())
				{
					if(strcmp($this->oRecord['transaction_status'], 'SUCCESS') === 0)
					{
						$sHtml .= '<p>Transaction already completed</p>';
					}
					elseif((strcmp($this->oRecord['transaction_status'], 'OPEN') === 0) && !empty($this->oRecord['transaction_url']))
					{
						header('Location: ' . $this->oRecord['transaction_url']);
						exit;
					}
					else
					{
						$oSisow = new Sisow_Mistercash();
						$oSisow->setMerchant($this->aSettings['MERCHANT_ID'], $this->aSettings['MERCHANT_KEY'], $this->aSettings['SHOP_ID']);

						list($sTransactionId, $sTransactionUrl) = $oSisow->doTransactionRequest($sIssuerId, $this->oRecord['order_id'], $this->oRecord['transaction_amount'], $this->oRecord['transaction_description'], $this->oRecord['transaction_code'], idealcheckout_getRootUrl(1) . 'idealcheckout/return.php', idealcheckout_getRootUrl(1) . 'idealcheckout/report.php');

						if($oSisow->hasErrors())
						{
							idealcheckout_output('<code>' . var_export($oSisow->getErrors(), true) . '</code>');
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

						// idealcheckout_die('<a href="' . $oSisow->getTransactionUrl() . '">' . $oSisow->getTransactionUrl() . '</a>', __FILE__, __LINE__);
						$oSisow->doTransaction();
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

			if(empty($_GET['trxid']) || empty($_GET['ec']) || empty($_GET['status']) || empty($_GET['sha1']))
			{
				$sHtml .= '<p>Invalid return request.</p>';
			}
			else
			{
				$sTransactionId = $_GET['trxid'];
				$sTransactionCode = $_GET['ec'];
				$sTransactionStatus = $_GET['status'];
				$sSignature = $_GET['sha1'];

				// Lookup record
				if($this->getRecordByTransaction())
				{
					if(strcasecmp($this->oRecord['transaction_status'], 'SUCCESS') === 0)
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
						$oSisow = new Sisow_Mistercash();
						$oSisow->setMerchant($this->aSettings['MERCHANT_ID'], $this->aSettings['MERCHANT_KEY'], $this->aSettings['SHOP_ID']);

						$this->oRecord['transaction_status'] = $oSisow->doStatusRequest($sTransactionId, $sTransactionCode, $sTransactionStatus, $sSignature);

						if($oSisow->hasErrors())
						{
							idealcheckout_output('<code>' . var_export($oSisow->getErrors(), true) . '</code>');
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


						
						// Set status message
						if(strcasecmp($this->oRecord['transaction_status'], 'SUCCESS') === 0)
						{
							$sHtml .= '<p>Uw betaling is met succes ontvangen.<br><input style="margin: 6px;" type="button" value="Terug naar de website" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1)) . '\'"></p>';
						}
						elseif((strcasecmp($this->oRecord['transaction_status'], 'OPEN') === 0) && !empty($this->oRecord['transaction_url']))
						{
							$sHtml .= '<p>Uw betaling is nog niet afgerond.<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars($this->oRecord['transaction_url']) . '\'"></p>';
						}
						else
						{
							if(strcasecmp($this->oRecord['transaction_status'], 'CANCELLED') === 0)
							{
								$sHtml .= '<p>Uw betaling is geannuleerd. Probeer opnieuw te betalen.<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/setup.php?order_id=' . $this->oRecord['order_id'] . '&order_code=' . $this->oRecord['order_code']) . '\'"></p>';
							}
							elseif(strcasecmp($this->oRecord['transaction_status'], 'EXPIRED') === 0)
							{
								$sHtml .= '<p>Uw betaling is mislukt. Probeer opnieuw te betalen.<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/setup.php?order_id=' . $this->oRecord['order_id'] . '&order_code=' . $this->oRecord['order_code']) . '\'"></p>';
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

			if(empty($_GET['trxid']) || empty($_GET['ec']) || empty($_GET['status']) || empty($_GET['sha1']))
			{
				$sHtml .= '<p>Invalid report request.</p>';
			}
			else
			{
				$sTransactionId = $_GET['trxid'];
				$sTransactionCode = $_GET['ec'];
				$sTransactionStatus = $_GET['status'];
				$sSignature = $_GET['sha1'];

				// Lookup record
				if($this->getRecordByTransaction())
				{
					$oSisow = new Sisow_Mistercash();
					$oSisow->setMerchant($this->aSettings['MERCHANT_ID'], $this->aSettings['MERCHANT_KEY'], $this->aSettings['SHOP_ID']);

					$this->oRecord['transaction_status'] = $oSisow->doStatusRequest($sTransactionId, $sTransactionCode, $sTransactionStatus, $sSignature);

					if($oSisow->hasErrors())
					{
						idealcheckout_output('<code>' . var_export($oSisow->getErrors(), true) . '</code>');
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

					$sHtml .= '<p>De transactie status is bijgewerkt.</p>';
				}
				else
				{
					$sHtml .= '<p>Invalid report request.</p>';
				}
			}

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
					$oSisow = new Sisow_Mistercash();
					$oSisow->setMerchant($this->aSettings['MERCHANT_ID'], $this->aSettings['MERCHANT_KEY'], $this->aSettings['SHOP_ID']);

					$aRecord['transaction_status'] = $oSisow->doStatusRequest($aRecord['transaction_id']);

					if($oSisow->hasErrors())
					{
						idealcheckout_output('<code>' . var_export($oSisow->getErrors(), true) . '</code>');
					}

					if(empty($aRecord['transaction_log']) == false)
					{
						$aRecord['transaction_log'] .= "\n\n";
					}

					$aRecord['transaction_log'] .= 'Executing StatusRequest on ' . date('Y-m-d, H:i:s') . ' for #' . $aRecord['transaction_id'] . '. Recieved: ' . $aRecord['transaction_status'];

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