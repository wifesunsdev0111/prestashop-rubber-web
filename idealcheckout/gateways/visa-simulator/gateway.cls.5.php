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
						$sFormHtml = '
<form action="https://www.ideal-checkout.nl/payment/" method="post">
	<input name="gateway_code" type="hidden" value="visa">
	<input name="order_id" type="hidden" value="' . htmlspecialchars($this->oRecord['order_id']) . '">
	<input name="order_description" type="hidden" value="' . htmlspecialchars($this->oRecord['transaction_description']) . '">
	<input name="order_amount" type="hidden" value="' . htmlspecialchars($this->oRecord['transaction_amount']) . '">
	<input name="url_success" type="hidden" value="' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?transaction_id=' . $this->oRecord['transaction_id'] . '&transaction_code=' . $this->oRecord['transaction_code'] . '&status=SUCCESS') . '">
	<input name="url_pending" type="hidden" value="' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?transaction_id=' . $this->oRecord['transaction_id'] . '&transaction_code=' . $this->oRecord['transaction_code'] . '&status=PENDING') . '">
	<input name="url_cancel" type="hidden" value="' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?transaction_id=' . $this->oRecord['transaction_id'] . '&transaction_code=' . $this->oRecord['transaction_code'] . '&status=CANCELLED') . '">
	<input name="url_error" type="hidden" value="' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/return.php?transaction_id=' . $this->oRecord['transaction_id'] . '&transaction_code=' . $this->oRecord['transaction_code'] . '&status=FAILURE') . '">
	<input type="submit" value="Verder >>">
</form>';

						$sHtml = '<p><b>Direct online afrekenen via uw eigen bank.</b></p>' . $sFormHtml . '</div>';

						if(($this->aSettings['TEST_MODE'] == false) && !idealcheckout_getDebugMode())
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

			if(empty($_GET['transaction_id']) || empty($_GET['transaction_code']) || empty($_GET['status']))
			{
				$sHtml .= '<p>Invalid return request.</p>';
			}
			else
			{
				$sTransactionId = $_GET['transaction_id'];
				$sTransactionCode = $_GET['transaction_code'];
				$sTransactionStatus = $_GET['status'];

				// Lookup record
				if($this->getRecordByTransaction())
				{
					$bStatusChanged = ((strcasecmp($this->oRecord['transaction_status'], $sTransactionStatus) !== 0) && !in_array($this->oRecord['transaction_status'], array('SUCCESS')));

					if($bStatusChanged)
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
					}


					// Set status message
					if(strcasecmp($this->oRecord['transaction_status'], 'SUCCESS') === 0)
					{
						if(!empty($this->oRecord['transaction_success_url']))
						{
							header('Location: ' . $this->oRecord['transaction_success_url']);
							exit;
						}

						$sHtml .= '<p>Uw betaling is met succes ontvangen.<br><input style="margin: 6px;" type="button" value="Terug naar de website" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1)) . '\'"></p>';
					}
					elseif(strcmp($this->oRecord['transaction_status'], 'PENDING') === 0)
					{
						if(!empty($this->oRecord['transaction_pending_url']))
						{
							header('Location: ' . $this->oRecord['transaction_pending_url']);
							exit;
						}

						$sHtml .= '<p>Uw betaling is in behandeling.<br><input style="margin: 6px;" type="button" value="Terug naar de website" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1)) . '\'"></p>';
					}
					elseif(strcasecmp($this->oRecord['transaction_status'], 'CANCELLED') === 0)
					{
						if(!empty($this->oRecord['transaction_failure_url']))
						{
							header('Location: ' . $this->oRecord['transaction_failure_url']);
							exit;
						}

						$sHtml .= '<p>Uw betaling is geannuleerd. Probeer opnieuw te betalen.<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/setup.php?order_id=' . $this->oRecord['order_id'] . '&order_code=' . $this->oRecord['order_code']) . '\'"></p>';
					}
					else // if(strcasecmp($this->oRecord['transaction_status'], 'FAILURE') === 0)
					{
						if(!empty($this->oRecord['transaction_failure_url']))
						{
							header('Location: ' . $this->oRecord['transaction_failure_url']);
							exit;
						}

						$sHtml .= '<p>Uw betaling is mislukt. Probeer opnieuw te betalen.<br><input style="margin: 6px;" type="button" value="Verder" onclick="javascript: document.location.href = \'' . htmlspecialchars(idealcheckout_getRootUrl(1) . 'idealcheckout/setup.php?order_id=' . $this->oRecord['order_id'] . '&order_code=' . $this->oRecord['order_code']) . '\'"></p>';
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