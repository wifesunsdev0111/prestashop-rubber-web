<?php

	/*
		API DOCS: https://www.mollie.nl/files/documentatie/payments-api.html
	*/

	class MolliePayment
	{
		private $sApiKey = false;
		private $sPaymentMethod = false;
		private $sLanguageCode = false;

		private $sReturnUrl = false;
		private $sReportUrl = false;

		private $sOrderId = false;
		private $fAmount = false;
		private $sDescription = false;

		private $aTransaction = false;

		public function __construct($sApiKey)
		{
			$this->sApiKey = $sApiKey;
		}

		public function setLanguageCode($sLanguageCode = false)
		{
			if(is_bool($sLanguageCode))
			{
				$this->sLanguageCode = false;
				return true;
			}
			elseif(is_string($sLanguageCode))
			{
				$sLanguageCode = strtolower(substr($sLanguageCode, 0, 2));

				if(in_array($sLanguageCode, array('nl', 'fr', 'de', 'es', 'en')))
				{
					$this->sLanguageCode = $sLanguageCode;
					return true;
				}
			}

			return false;
		}

		public function setPaymentMethod($sPaymentMethod = false)
		{
			if(is_bool($sPaymentMethod))
			{
				$this->sPaymentMethod = false;
				return true;
			}
			elseif(is_string($sPaymentMethod))
			{
				$sPaymentMethod = strtolower($sPaymentMethod);

				if(in_array($sPaymentMethod, array('ideal', 'creditcard', 'mistercash', 'sofort', 'banktransfer', 'bitcoin', 'paypal', 'paysafecard')))
				{
					$this->sPaymentMethod = $sPaymentMethod;
					return true;
				}
			}

			return false;
		}

		public function setReturnUrl($sReturnUrl = false)
		{
			$this->sReturnUrl = $sReturnUrl;
			return true;
		}

		public function setReportUrl($sReportUrl = false)
		{
			$this->sReportUrl = $sReportUrl;
			return true;
		}

		public function setOrder($sOrderId, $fAmount, $sDescription = false)
		{
			$this->sOrderId = $sOrderId;
			$this->fAmount = $fAmount;
			$this->sDescription = $sDescription;

			if(empty($this->sDescription))
			{
				$this->sDescription = 'Webshop bestelling ' . $this->sOrderId;
			}

			return true;
		}

		public function getTransaction()
		{
			if(empty($this->sApiKey))
			{
				idealcheckout_log('No API key found.', __FILE__, __LINE__);

				$this->aTransaction = array('error' => array('message' => 'No API key found.'));
				return false;
			}
			elseif(empty($this->sOrderId))
			{
				idealcheckout_log('No order ID found.', __FILE__, __LINE__);

				$this->aTransaction = array('error' => array('message' => 'No order ID found.'));
				return false;
			}
			elseif(empty($this->fAmount))
			{
				idealcheckout_log('No amount found.', __FILE__, __LINE__);

				$this->aTransaction = array('error' => array('message' => 'No amount found.'));
				return false;
			}
			elseif($this->fAmount < 1.00)
			{
				idealcheckout_log('Amount ' . number_format($this->fAmount, 2, ',', '') . ' is to small to process order #' . $this->sOrderId . '.', __FILE__, __LINE__);

				$this->aTransaction = array('error' => array('message' => 'Amount ' . number_format($this->fAmount, 2, ',', '') . ' is to small to process order #' . $this->sOrderId . '.'));
				return false;
			}
			elseif(empty($this->sReturnUrl))
			{
				idealcheckout_log('No return URL found.', __FILE__, __LINE__);

				$this->aTransaction = array('error' => array('message' => 'No return URL found.'));
				return false;
			}
/*
			elseif(empty($this->sReportUrl))
			{
				idealcheckout_die('No report URL found.', __FILE__, __LINE__);
			}
*/


			$aRequest = array();

			// Order data
			$aRequest['metadata'] = $this->sOrderId; // Order amount
			$aRequest['amount'] = round($this->fAmount, 2); // Order amount
			$aRequest['description'] = $this->sDescription; // Order description

			// Set return URL
			if(!empty($this->sReturnUrl))
			{
				$aRequest['redirectUrl'] = $this->sReturnUrl; // Return URL
			}

			// Set report URL
			if(!empty($this->sReportUrl))
			{
				$aRequest['webhookUrl'] = $this->sReportUrl; // Report URL
			}

			// Set locale
			if(!empty($this->sLanguageCode))
			{
				$aRequest['locale'] = $this->sLanguageCode;
			}

			// Set payment method
			if(!empty($this->sPaymentMethod))
			{
				$aRequest['method'] = $this->sPaymentMethod;
			}

			$sApiUrl = 'https://api.mollie.nl/v1/payments/';
			$sPostData = json_encode($aRequest);

			$sResponse = idealcheckout_doHttpRequest($sApiUrl, $sPostData, true, 30, false, array('Authorization: Bearer ' . $this->sApiKey));

			if(!empty($sResponse))
			{
				$this->aTransaction = json_decode($sResponse, true);

				if($this->aTransaction)
				{
					if(isset($this->aTransaction['id'], $this->aTransaction['links'], $this->aTransaction['links']['paymentUrl']))
					{
						return true;
					}
					elseif(!isset($this->aTransaction['error'], $this->aTransaction['error']['message']))
					{
						$this->aTransaction = array('error' => array('message' => 'Unknown response received from Mollie (See logs).'));
					}
				}
				else
				{
					$this->aTransaction = array('error' => array('message' => 'Cannot decode JSON response (See logs).'));
				}
			}
			else
			{
				$this->aTransaction = array('error' => array('message' => 'No response received from Mollie (See logs).'));
			}

			idealcheckout_log($aRequest, __FILE__, __LINE__, true);
			idealcheckout_log($sResponse, __FILE__, __LINE__, true);

			return false;
		}

		public function getTransactionId()
		{
			if(!empty($this->aTransaction['id']))
			{
				return $this->aTransaction['id'];
			}

			return false;
		}

		public function getTransactionUrl()
		{
			if(!empty($this->aTransaction['links']['paymentUrl']))
			{
				return $this->aTransaction['links']['paymentUrl'];
			}

			return false;
		}

		public function getError()
		{
			if(!empty($this->aTransaction['error']['message']))
			{
				return $this->aTransaction['error']['message'];
			}

			return false;
		}

		public function getStatus($sTransactionId)
		{
			$sApiUrl = 'https://api.mollie.nl/v1/payments/' . $sTransactionId;
			$sResponse = idealcheckout_doHttpRequest($sApiUrl, false, true, 30, false, array('Authorization: Bearer ' . $this->sApiKey));

			if(!empty($sResponse))
			{
				$aResponse = json_decode($sResponse, true);

				if(!empty($aResponse['status']))
				{
					if(in_array($aResponse['status'], array('open', 'pending')))
					{
						return 'OPEN';
					}
					elseif(in_array($aResponse['status'], array('paid', 'paidout')))
					{
						return 'SUCCESS';
					}
					elseif(in_array($aResponse['status'], array('cancelled', 'refunded')))
					{
						return 'CANCELLED';
					}
					elseif(in_array($aResponse['status'], array('expired')))
					{
						return 'FAILURE';
					}
				}
			}

			return '';
		}
	}

?>