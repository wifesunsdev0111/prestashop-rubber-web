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
						// Request payment link
						$oApi = new PayProApi($this->aSettings['PAYPRO_API_KEY'], 'create_payment');

						if(!empty($this->aSettings['TEST_MODE']))
						{
							$oApi->setTestMode();
						}

						if(!empty($this->aSettings['PAYPRO_PRODUCT_ID']))
						{
							$oApi->setParam('product_id', $this->aSettings['PAYPRO_PRODUCT_ID']);
						}



						// Create custom description
						$aUrl = parse_url(strtolower(idealcheckout_getRootUrl()));
						$sDomainName = $aUrl['host'];

						if(strcasecmp(substr($sDomainName, 0, 4), 'www.') === 0)
						{
							$sDomainName = substr($sDomainName, 4);
						}

						$sCustomDescription = 'Bestelling ' . $this->oRecord['order_id'] . ' op ' . $sDomainName;



						$oApi->setParam('psp_code', '102'); // PayPal
						$oApi->setParam('amount', round($this->oRecord['transaction_amount'] * 100));
						$oApi->setParam('description', $sCustomDescription);
						$oApi->setParam('custom', $this->oRecord['order_id'] . '|' . $this->oRecord['transaction_id'] . '|' . $this->oRecord['transaction_code']);
						$oApi->setParam('return_url', idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?transaction_id=' . $this->oRecord['transaction_id'] . '&transaction_code=' . $this->oRecord['transaction_code']);
						$oApi->setParam('postback_url', idealcheckout_getRootUrl(1) . 'idealcheckout/report.php?transaction_id=' . $this->oRecord['transaction_id'] . '&transaction_code=' . $this->oRecord['transaction_code']);

						if(!empty($this->oRecord['order_params']))
						{
							$aOrderParams = idealcheckout_unserialize($this->oRecord['order_params']);

							// $oApi->setParam('consumer_accountno', '');

							if(!empty($aOrderParams['customer']['payment_name']))
							{
								$oApi->setParam('consumer_name', $aOrderParams['customer']['payment_name']);
							}

							if(!empty($aOrderParams['customer']['payment_address']))
							{
								$oApi->setParam('consumer_address', $aOrderParams['customer']['payment_address']);
							}

							if(!empty($aOrderParams['customer']['payment_zipcode']))
							{
								$oApi->setParam('consumer_postal', $aOrderParams['customer']['payment_zipcode']);
							}

							if(!empty($aOrderParams['customer']['payment_city']))
							{
								$oApi->setParam('consumer_city', $aOrderParams['customer']['payment_city']);
							}

							if(!empty($aOrderParams['customer']['payment_country_name']))
							{
								$oApi->setParam('consumer_country', $aOrderParams['customer']['payment_country_name']);
							}

							if(!empty($aOrderParams['customer']['payment_email']))
							{
								$oApi->setParam('consumer_email', $aOrderParams['customer']['payment_email']);
							}
						}

// echo "<br>\n" . 'DEBUG: ' . __FILE__ . ' : ' . __LINE__ . "<br>\n";
// print_r($oApi);
						$aResponse = $oApi->execute();

// echo "<br>\n" . 'DEBUG: ' . __FILE__ . ' : ' . __LINE__ . "<br>\n";
// print_r($aResponse);
// exit;


						if(isset($aResponse['errors']) && (strcasecmp($aResponse['errors'], 'true') === 0))
						{
							idealcheckout_log('Invalid response from PayPRO.', __FILE__, __LINE__);
							idealcheckout_log($aResponse, __FILE__, __LINE__);
							idealcheckout_die('Invalid response from PayPRO.', __FILE__, __LINE__);
						}
						elseif(!empty($aResponse['return']['payment_url']) && !empty($aResponse['return']['payment_hash']))
						{
							$aTransactionParams = array();

							if(!empty($this->oRecord['transaction_params']))
							{
								$aTransactionParams = idealcheckout_unserialize($this->oRecord['transaction_params']);
							}

							$aTransactionParams['payment_hash'] = $aResponse['return']['payment_hash'];
							$this->oRecord['transaction_params'] = idealcheckout_serialize($aTransactionParams);

							$this->oRecord['transaction_url'] = $aResponse['return']['payment_url'];

							if(empty($this->oRecord['transaction_log']) == false)
							{
								$this->oRecord['transaction_log'] .= "\n\n";
							}

							$this->oRecord['transaction_log'] .= 'Executing PaymentRequest on ' . date('Y-m-d, H:i:s') . ' for #' . $this->oRecord['transaction_id'] . '. Recieved: ' . $aResponse['payment_url'];
							$this->save();


							header('Location: ' . $aResponse['return']['payment_url']);
							exit;
						}
						else
						{
							idealcheckout_log('Invalid response from PayPRO.', __FILE__, __LINE__);
							idealcheckout_log($aResponse, __FILE__, __LINE__);
							idealcheckout_die('Invalid response from PayPRO.', __FILE__, __LINE__);
						}
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

			if(empty($_GET['transaction_id']) || empty($_GET['transaction_code']))
			{
				$sHtml .= '<p>Invalid return request.</p>';
			}
			else
			{
				$sTransactionId = $_GET['transaction_id'];
				$sTransactionCode = $_GET['transaction_code'];

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
						if(!empty($this->oRecord['transaction_pending_url']))
						{
							header('Location: ' . $this->oRecord['transaction_pending_url']);
							exit;
						}

						$sHtml .= '<p>Uw betaling wordt verwerkt.<br><input style="margin: 6px;" type="button" value="Terug naar de website" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1)) . '\'"></p>';
					}
				}
				else
				{
					$sHtml .= '<p>Invalid return request.</p>';
				}
			}

			idealcheckout_output($sHtml);
		}


		// Catch return
		public function doReport()
		{
			$sHtml = '';

			if(empty($_GET['transaction_id']) || empty($_GET['transaction_code']))
			{
				$sHtml .= '<p>Invalid return request.</p>';
			}
			else
			{
				$sTransactionId = $_GET['transaction_id'];
				$sTransactionCode = $_GET['transaction_code'];

				$aResponse = PayProApi::getResponse();

				// Lookup record
				if($this->getRecordByTransaction() && $aResponse)
				{
					if(strcasecmp($this->oRecord['transaction_status'], 'SUCCESS') === 0)
					{
						$sHtml .= '<p>Uw betaling is met succes ontvangen.</p>';
					}
					else
					{
						$sTransactionStatus = 'SUCCESS';

						if(strcasecmp($this->oRecord['transaction_status'], $sTransactionStatus) !== 0)
						{
							$this->oRecord['transaction_status'] = $sTransactionStatus;


							$aTransactionParams = array();

							if(!empty($this->oRecord['transaction_params']))
							{
								$aTransactionParams = idealcheckout_unserialize($this->oRecord['transaction_params']);
							}

							$aTransactionParams['response'] = $aResponse;
							$this->oRecord['transaction_params'] = idealcheckout_serialize($aTransactionParams);

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

						// Set status or redirect
						$sHtml .= '<p>Uw betaling is met succes ontvangen.<br><input style="margin: 6px;" type="button" value="Terug naar de website" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1)) . '\'"></p>';
					}
				}
				else
				{
					$sHtml .= '<p>Invalid return request.</p>';
				}
			}

			idealcheckout_output($sHtml);
		}
	}

?>