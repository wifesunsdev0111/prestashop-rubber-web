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
					else
					{
						$sFormHtml = '
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
	<input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="notify_url" value="' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/report.php?transaction_id=' . $this->oRecord['transaction_id'] . '&transaction_code=' . $this->oRecord['transaction_code'] . '&status=SUCCESS') . '">
	<input type="hidden" name="return" value="' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?transaction_id=' . $this->oRecord['transaction_id'] . '&transaction_code=' . $this->oRecord['transaction_code'] . '&status=SUCCESS') . '">
	<input type="hidden" name="cancel_return" value="' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?transaction_id=' . $this->oRecord['transaction_id'] . '&transaction_code=' . $this->oRecord['transaction_code'] . '&status=CANCELLED') . '">
	<input type="hidden" name="business" value="' . htmlspecialchars($this->aSettings['PAYPAL_BUSINESS_EMAIL']) . '">

	<input type="hidden" name="paymentaction" value="sale">
	<input type="hidden" name="invoice" value="' . htmlspecialchars($this->oRecord['order_id']) . '">
	<input type="hidden" name="custom" value="' . htmlspecialchars($this->oRecord['order_code']) . '">

	<input type="hidden" name="item_name" value="' . htmlspecialchars($this->oRecord['transaction_description']) . '">
	<input type="hidden" name="item_number" value="' . htmlspecialchars($this->oRecord['order_id']) . '">
	<input type="hidden" name="quantity" value="1">

	<input type="hidden" name="amount" value="' . htmlspecialchars($this->oRecord['transaction_amount']) . '">
	<input type="hidden" name="currency_code" value="' . htmlspecialchars($this->oRecord['currency_code']) . '">
	<input type="hidden" name="lc" value="' . htmlspecialchars(strtoupper($this->oRecord['language_code'])) . '">

	<input type="hidden" name="no_note" value="1">
	<input type="hidden" name="no_shipping" value="1">
	<input type="submit" value="Verder >>">
</form>';

						$sHtml = '<p><b>Direct online afrekenen via PayPal.</b></p>' . $sFormHtml . '</div>';

						if($this->aSettings['TEST_MODE'] == false)
						{
							$sHtml .= '<script type="text/javascript"> function doAutoSubmit() { document.forms[0].submit(); } setTimeout(\'doAutoSubmit()\', 100); </script>';
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
				$sTransactionStatus = (empty($_GET['status']) ? '' : $_GET['status']);

				if(!in_array($sTransactionStatus, array('SUCCESS', 'CANCELLED')))
				{
					$sTransactionStatus = 'PENDING';
				}


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
				$sHtml .= '<p>Invalid report request.</p>';
			}
			else
			{
				$sTransactionId = $_GET['transaction_id'];
				$sTransactionCode = $_GET['transaction_code'];
				$sTransactionStatus = (empty($_GET['status']) ? '' : $_GET['status']);

				if(!in_array($sTransactionStatus, array('SUCCESS', 'CANCELLED')))
				{
					$sTransactionStatus = 'PENDING';
				}


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
							idealcheckout_update_order_status($this->oRecord, 'doReport');
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
					$sHtml .= '<p>Invalid report request.</p>';
				}
			}

			idealcheckout_output($sHtml);
		}
	}

?>