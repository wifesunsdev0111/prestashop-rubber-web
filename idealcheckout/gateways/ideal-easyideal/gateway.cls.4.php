<?php

	class Gateway extends GatewayCore
	{
		// Load iDEAL settings
		function Gateway()
		{
			$this->init();
		}

		
		// Setup payment
		function doSetup()
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
						$sMerchantId = $this->aSettings['MERCHANT_ID'];
						$sMerchantKey = $this->aSettings['MERCHANT_KEY'];
						$sSecretKey = $this->aSettings['MERCHANT_SECRET'];
						$sTestMode = (empty($this->aSettings['TEST_MODE']) ? '0' : '1');

						$sCurrencyCode = (empty($this->oRecord['currency_code']) ? 'EUR' : $this->oRecord['currency_code']);
						$sLanguageCode = (empty($this->oRecord['language_code']) ? 'NL' : $this->oRecord['language_code']);

						$sOrderId = $this->oRecord['order_id'];
						$sTransactionAmount = number_format($this->oRecord['transaction_amount'], 2, '.', '');
						$sReturnUrl = idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?transaction_id=' . $this->oRecord['transaction_id'] . '&transaction_code=' . $this->oRecord['transaction_code'];

						$sHash = sha1(utf8_encode($sCurrencyCode . $sTransactionAmount . $sMerchantId . $sReturnUrl . $sOrderId . $sSecretKey . (empty($this->aSettings['TEST_MODE']) ? '0' : '1') . '1'));

						$sFormHtml = '
<form action="https://www.qantanipayments.com/frontend/" method="post" name="payment">
	<input type="hidden" name="merchantid" value="' . htmlspecialchars($sMerchantId) . '">
	<input type="hidden" name="key" value="' . htmlspecialchars($sMerchantKey) . '">
	<input type="hidden" name="checksum" value="' . htmlspecialchars($sHash) . '">
	<input type="hidden" name="amount" value="' . htmlspecialchars($sTransactionAmount) . '">
	<input type="hidden" name="currency" value="' . htmlspecialchars($sCurrencyCode) . '">
	<input type="hidden" name="ordernumber" value="' . htmlspecialchars($sOrderId) . '">
	<input type="hidden" name="return" value="' . htmlspecialchars($sReturnUrl) . '">
	<input type="hidden" name="language" value="' . htmlspecialchars($sLanguageCode) . '">
	<input type="hidden" name="paymentmethod" value="1">
	<input type="hidden" name="test" value="' . htmlspecialchars($sTestMode) . '">
	<input type="submit" value="Verder >>">
</form>';

						$sHtml = '<p><b>Direct online afrekenen via uw eigen bank.</b></p>' . $sFormHtml;

						if(($this->aSettings['TEST_MODE'] == false) && !idealcheckout_getDebugMode())
						{
							$sHtml .= '<script type="text/javascript"> function doAutoSubmit() { document.forms[\'payment\'].submit(); } setTimeout(\'doAutoSubmit()\', 100); </script>';
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
		function doReturn()
		{
			$sHtml = '';

			if(empty($_GET['transaction_id']) || empty($_GET['transaction_code']) || empty($_GET['id']) || empty($_GET['salt']) || empty($_GET['checksum']))
			{
				$sHtml .= '<p>Invalid return request.</p>';
			}
			else
			{
				$sHash = sha1($_GET['id'] . $this->aSettings['MERCHANT_SECRET'] . $_GET['status'] . $_GET['salt']);
				$sChecksum = $_GET['checksum'];

				if(strcmp($sHash, $sChecksum) === 0)
				{
					$sTransactionId = $_GET['transaction_id'];
					$sTransactionCode = $_GET['transaction_code'];
					$sTransactionStatus = (empty($_GET['status']) ? 'CANCELLED' : 'SUCCESS');

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
							$this->oRecord['transaction_status'] = $sTransactionStatus;

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
						}
					}
					else
					{
						$sHtml .= '<p>Invalid return request (Cannot lookup order).</p>';
					}
				}
				else
				{
					$sHtml .= '<p>Invalid return request (Bad signature).</p>';
				}
			}

			idealcheckout_output($sHtml);
		}
	}

?>