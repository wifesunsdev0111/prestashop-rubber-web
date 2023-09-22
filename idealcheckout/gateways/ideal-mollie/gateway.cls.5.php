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
				$sHtml .= '<p>Invalid issuer request.</p>';
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
					elseif((strcmp($this->oRecord['transaction_status'], 'OPEN') === 0) && !empty($this->oRecord['transaction_url']))
					{
						header('Location: ' . $this->oRecord['transaction_url']);
						exit;
					}
					else
					{
						$oMollie = new iDEAL_Payment($this->aSettings['PARTNER_ID']);

						if(empty($this->aSettings['PROFILE_KEY']) == false)
						{
							$oMollie->setProfileKey($this->aSettings['PROFILE_KEY']);
						}

						if(!empty($this->aSettings['TEST_MODE']))
						{
							$oMollie->setTestmode();
						}

						$aIssuerList = $oMollie->getBanks();
						$sIssuerList = '';

						if($aIssuerList === false)
						{
							idealcheckout_output('<code>Er is een fout opgetreden bij het ophalen van de banklijst: ' . $oMollie->getErrorMessage() . '</code>');
						}

						if(empty($this->oRecord['transaction_log']) == false)
						{
							$this->oRecord['transaction_log'] .= "\n\n";
						}

						$this->oRecord['transaction_log'] .= 'Executing IssuerRequest on ' . date('Y-m-d, H:i:s') . '.';

						$this->save();


						foreach($aIssuerList as $k => $v)
						{
							$sIssuerList .= '<option value="' . $k . '">' . htmlspecialchars($v) . '</option>';
						}

						$sHtml .= '
<form action="' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/transaction.php?order_id=' . $sOrderId . '&order_code=' . $sOrderCode) . '" method="post" id="checkout">
	<p><b>Kies uw bank</b><br><select name="issuer_id" style="margin: 6px; width: 200px;">' . $sIssuerList . '</select><br><input type="submit" value="Verder"></p>.
</form>';
					}
				}
				else
				{
					$sHtml .= '<p>Invalid issuer request.</p>';
				}
			}

			idealcheckout_output($sHtml);
		}


		// Execute payment
		public function doTransaction()
		{
			$sHtml = '';

			// Look for proper GET's en POST's
			if(empty($_POST['issuer_id']) || empty($_GET['order_id']) || empty($_GET['order_code']))
			{
				$sHtml .= '<p>Invalid transaction request.</p>';
			}
			else
			{
				$sIssuerId = $_POST['issuer_id'];
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
						$oMollie = new iDEAL_Payment($this->aSettings['PARTNER_ID']);

						if(empty($this->aSettings['PROFILE_KEY']) == false)
						{
							$oMollie->setProfileKey($this->aSettings['PROFILE_KEY']);
						}

						if(!empty($this->aSettings['TEST_MODE']))
						{
							$oMollie->setTestmode();
						}

						$oPayment = $oMollie->createPayment($sIssuerId, round($this->oRecord['transaction_amount'] * 100), $this->oRecord['transaction_description'], idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?order_id=' . htmlspecialchars($this->oRecord['order_id']) . '&order_code=' . htmlspecialchars($this->oRecord['order_code']), idealcheckout_getRootUrl(1) . 'idealcheckout/report.php?order_id=' . htmlspecialchars($this->oRecord['order_id']) . '&order_code=' . htmlspecialchars($this->oRecord['order_code']));

						if($oPayment == false)
						{
							idealcheckout_output('<code>De betaling kon niet aangemaakt worden.<br><br><br><br><b>Foutmelding:</b><br><br>' . $oMollie->getErrorMessage() . '</code>');
						}

						$sTransactionId = $oMollie->getTransactionId();
						$sTransactionUrl = $oMollie->getBankURL();

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
						
						// idealcheckout_die('<a href="' . htmlentities($sTransactionUrl) . '">' . htmlentities($sTransactionUrl) . '</a>', __FILE__, __LINE__);
						header('Location: ' . $sTransactionUrl);
						exit;
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

			if(empty($_GET['order_id']) || empty($_GET['order_code']))
			{
				$sHtml .= '<p>Invalid return request.</p>';
			}
			else
			{
				$sOrderId = $_GET['order_id'];
				$sOrderCode = $_GET['order_code'];

				// Lookup transaction
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

			if(empty($_GET['transaction_id']) || empty($_GET['order_id']) || empty($_GET['order_code']))
			{
				$sHtml .= '<p>Invalid report request.</p>';
			}
			else
			{
				$sTransactionId = $_GET['transaction_id'];
				$sOrderId = $_GET['order_id'];
				$sOrderCode = $_GET['order_code'];

				// Lookup record
				if($this->getRecordByOrder())
				{
					// Check status
					$oMollie = new iDEAL_Payment($this->aSettings['PARTNER_ID']);

					if(empty($this->aSettings['PROFILE_KEY']) == false)
					{
						$oMollie->setProfileKey($this->aSettings['PROFILE_KEY']);
					}

					if(!empty($this->aSettings['TEST_MODE']))
					{
						$oMollie->setTestmode();
					}


					if($oMollie->checkPayment($sTransactionId))
					{
						if($oMollie->getPaidStatus() == true)
						{
							$this->oRecord['transaction_status'] = 'SUCCESS';
						}
						else
						{
							$this->oRecord['transaction_status'] = 'CANCELLED';
						}
					}
					else
					{
						$this->oRecord['transaction_status'] = 'FAILURE';
						// idealcheckout_output('<code>' . var_export($oMollie->getErrors(), true) . '</code>');
					}

					if(empty($this->oRecord['transaction_log']) == false)
					{
						$this->oRecord['transaction_log'] .= "\n\n";
					}

					$this->oRecord['transaction_log'] .= 'Executing StatusRequest on ' . date('Y-m-d, H:i:s') . ' for #' . $sTransactionId . '. Recieved: ' . $this->oRecord['transaction_status'];

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
					$oMollie = new iDEAL_Payment($this->aSettings['PARTNER_ID']);

					if(empty($this->aSettings['PROFILE_KEY']) == false)
					{
						$oMollie->setProfileKey($this->aSettings['PROFILE_KEY']);
					}

					if(!empty($this->aSettings['TEST_MODE']))
					{
						$oMollie->setTestmode();
					}


					if($oMollie->checkPayment($aRecord['transaction_id']))
					{
						if($oMollie->getPaidStatus() == true)
						{
							$aRecord['transaction_status'] = 'SUCCESS';
						}
						else
						{
							$aRecord['transaction_status'] = 'CANCELLED';
						}
					}
					else
					{
						$aRecord['transaction_status'] = 'FAILURE';
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