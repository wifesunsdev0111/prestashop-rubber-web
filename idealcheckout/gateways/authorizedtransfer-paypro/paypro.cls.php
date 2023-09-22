<?php

	class PayProApi
	{
		private $sApikey;
		private $sCommand;
		private $bTestMode = false;
		private $aParams = array();

		public function __construct($sApikey, $sCommand = null, $aParams = null)
		{
			$this->sApikey = $sApikey;
			$this->sCommand = $sCommand;

			if(is_array($aParams))
			{
				$this->aParams = $aParams;
			}
		}

		public function execute()
		{
			$sParams = json_encode($this->aParams);
			$sParams = str_replace('\/', '/', $sParams);

			$sPostData = 'apikey=' . $this->sApikey . '&command=' . $this->sCommand . '&params=' . urlencode($sParams);

			if($this->bTestMode)
			{
				$sPostUrl = 'https://staging.paypro.nl/post_api/';
			}
			else
			{
				$sPostUrl = 'https://www.paypro.nl/post_api/';
			}

			$aResponse = array();
			$sResponse = idealcheckout_doHttpRequest($sPostUrl, $sPostData, true, 30, false);

			if(!empty($sResponse))
			{
				$aResponse = json_decode($sResponse, true);
			}

			$this->aParams = array();

			return $aResponse;
		}

		public function setTestMode($bTestMode = true)
		{
			$this->bTestMode = $bTestMode;
		}

		public function setCommand($sCommand)
		{
			$this->sCommand = $sCommand;
		}

		public function setParam($sKey, $mValue = false)
		{
			$this->aParams[$sKey] = $mValue;
		}

		public function setParams($aParams = false)
		{
			if(is_array($aParams))
			{
				$this->aParams = $aParams;
			}
			else
			{
				$this->aParams = array();
			}
		}

		public static function getResponse()
		{
			if(!empty($_SERVER['REMOTE_ADDR']))
			{
				// Response recieved from www.paypro.nl OR staging.paypro.nl
				if(in_array($_SERVER['REMOTE_ADDR'], array('178.22.56.21', '178.22.57.240')))
				{
					return array('GET' => $_GET, 'POST' => $_POST, 'COOKIE' => $_COOKIE, 'IP' => $_SERVER['REMOTE_ADDR']);
				}
			}

			return false;
		}

		public static function hasAffiliate($sApiKey, $bTestMode = false, $sProductId = false, $sCustomId = false)
		{
			if(!empty($_SERVER['REMOTE_ADDR']))
			{
				$oApi = new PayProApi($sApiKey, 'has_affiliate_by_product_id_and_ip');

				if($bTestMode || !$sProductId)
				{
					$oApi->setTestMode();
				}

				if($sProductId)
				{
					$oApi->setParam('product_id', $sProductId);
				}

				if($sCustomId)
				{
					$oApi->setParam('custom', $sCustomId);
				}

				$oApi->setParam('ip', $_SERVER['REMOTE_ADDR']);

				$aResponse = $oApi->execute();

				if(isset($aResponse['errors']) && (strcasecmp($aResponse['errors'], 'true') === 0))
				{
					// Invalid request
				}
				elseif(isset($aResponse['return']))
				{
					if($sCustomId && isset($aResponse['return']['custom']) && (strcasecmp($aResponse['return']['custom'], $sCustomId) !== 0))
					{
						// Invalid CUSTOM
					}
					elseif($sProductId && isset($aResponse['return']['product_id']) && (strcasecmp($aResponse['return']['product_id'], $sProductId) !== 0))
					{
						// Invalid PRODUCT ID
					}
					elseif(strcasecmp($aResponse['return']['ip'], $_SERVER['REMOTE_ADDR']) !== 0)
					{
						// Invalid IP ADDRESS
					}
					elseif(!empty($aResponse['return']['has_affiliate']))
					{
						return true;
					}
				}
			}

			return false;
		}

		public static function getIdealIssuers($bTestMode = false)
		{
			if($bTestMode)
			{
				return array('0021' => 'Rabobank (Test)', '0721' => 'ING Bank (Test)');
			}
			else
			{
				return array('0021' => 'Rabobank', '0031' => 'ABN Amro Bank', '0721' => 'ING Bank', '0751' => 'SNS Bank', '0091' => 'Friesland Bank', '0761' => 'ASN Bank', '0511' => 'Triodos Bank', '0771' => 'RegioBank', '0161' => 'Van Lanschot Bankiers', '0801' => 'Knab Bank');
			}
		}

		public static function getIdealIssuerOptions($bTestMode = false)
		{
			$aIssuers = self::getIdealIssuers($bTestMode);

			$sOptions = '';

			foreach($aIssuers as $k => $v)
			{
				$sOptions .= '<option value="' . htmlentities($k) . '">' . htmlentities($v) . '</option>';
			}

			return $sOptions;
		}
	}

?>