<?php

	class PayNL
	{
		protected $aErrors;

		protected $sTokenCode;
		protected $sServiceId;
		protected $sCachePath = false;
		protected $iAccountStatus;

		protected $bTestMode = false;
		protected $bInit = false;

		protected $aPaymentMethods = array();
		protected $aAdditionalData = array();

		protected $sTransactionId = false;
		protected $sTransactionUrl = false;

		public function __construct($sCachePath = false)
		{
			if($sCachePath !== false)
			{
				if(substr($sCachePath, -1, 1) == '/')
				{
					$sCachePath = substr($sCachePath, 0, -1);
				}
			}

			if(is_dir($sCachePath))
			{
				$this->sCachePath = $sCachePath;
			}
			else
			{
				// Set default cache path
				$sRootPath = dirname(__FILE__);
				
				while((strlen($sRootPath) > 3) && !is_dir($sRootPath . '/idealcheckout'))
				{
					$sRootPath = dirname($sRootPath);
				}
				
				if(!is_dir($sRootPath . '/idealcheckout'))
				{
					idealcheckout_die('Cannot find /idealcheckout/ folder.', __FILE__, __LINE__);
				}
				
				$this->sCachePath = $sRootPath . '/idealcheckout/temp';
			}
		}

		public function setTokenCode($sTokenCode)
		{
			$this->sTokenCode = $sTokenCode;
		}

		public function setServiceId($sServiceId)
		{
			$this->sServiceId = $sServiceId;
		}

		public function setTestMode($bTestMode = true)
		{
			$this->bTestMode = $bTestMode;
		}

		public function setCachePath($sCachePath = false)
		{
			$this->sCachePath = $sCachePath;
		}

		public function getPaymentMethods()
		{
			$this->_init();

			if(empty($this->aPaymentMethods))
			{
				$sCacheFile = $this->sCachePath . '/paynl-paymentmethods.' . $this->sServiceId . '.cache';
				$sCacheData = file_get_contents($sCacheFile);

				$this->aPaymentMethods = unserialize($sCacheData);
			}

			return $this->aPaymentMethods;
		}

		public function isPaymentMethod($sPaymentMethod)
		{
			$this->_init();

			if(empty($this->aPaymentMethods))
			{
				$this->getPaymentMethods();
			}

			return in_array($this->aPaymentMethods, $aCacheData);
		}

		public function getPaymentMethodId($sPaymentMethod)
		{
			$aPaymentMethods = $this->getPaymentMethods();

			foreach($aPaymentMethods as $aPaymentMethod)
			{
				if(strcasecmp($sPaymentMethod, $aPaymentMethod['code']) === 0)
				{
					return $aPaymentMethod['id'];
				}
			}


			$sErrorMessage = $sPaymentMethod . ' is not available.<br><br>';

			if(sizeof($aPaymentMethods))
			{
				$sErrorMessage .= 'Enabled gateways in your PAY.NL account:';

				foreach($aPaymentMethods as $aPaymentMethod)
				{
					$sErrorMessage .= '<br>' . $aPaymentMethod['code'] . ' (#' . $aPaymentMethod['id'] . ')';
				}
			}
			else
			{
				$sErrorMessage .= 'No gateways enabled in your PAY.NL account.';
			}

			idealcheckout_die($sErrorMessage, __FILE__, __LINE__);
		}

		public function savePaymentMethods($aPaymentMethods)
		{
			$this->aPaymentMethods = $aPaymentMethods;

			$sCacheFile = $this->sCachePath . '/paynl-paymentmethods.' . $this->sServiceId . '.cache';
			$sCacheData = file_put_contents($sCacheFile, serialize($aPaymentMethods));
			@chmod($sCacheFile, 0777);
		}

		public function setOrder($sOrderNumber, $sOrderDescription, $fOrderAmount, $sOrderCurrency = 'EUR')
		{
			$this->sOrderNumber = $sOrderNumber;
			$this->sOrderDescription = $sOrderDescription;
			$this->fOrderAmount = $fOrderAmount;
			$this->sOrderCurrency = $sOrderCurrency;
		}

		public function setPaymentMethod($sPaymentMethod, $iIssuerId = false)
		{
			$this->sPaymentMethod = $sPaymentMethod;
			$this->iIssuerId = $iIssuerId;
		}

		public function setReturnUrl($sReturnUrl)
		{
			$this->sReturnUrl = $sReturnUrl;
		}

		public function setReportUrl($sReportUrl)
		{
			$this->sReportUrl = $sReportUrl;
		}

		public function setData($aData = array())
		{
			$this->aAdditionalData = $aData;
		}

		public function getTransaction()
		{
			$iAmount = round($this->fOrderAmount * 100);

			$iPaymentMethodId = $this->getPaymentMethodId($this->sPaymentMethod);
			$aBrowser = $this->getBrowser();

			$sRequestUrl = 'https://rest-api.pay.nl/v3/Transaction/start/json/?token=' . urlencode($this->sTokenCode) . '&serviceId=' . urlencode($this->sServiceId) . '&ipAddress=' . urlencode($_SERVER['REMOTE_ADDR']) . '&browserData[parent]=' . urlencode($aBrowser['parent']);
			$sRequestUrl .= '&amount=' . urlencode($iAmount); // In centen
			$sRequestUrl .= '&transaction[currency]=' . urlencode($this->sOrderCurrency); // EUR|USD|GBP
			$sRequestUrl .= '&transaction[description]=' . urlencode(substr($this->sOrderNumber, 0, 32)); // Max 32 karakters
			$sRequestUrl .= '&statsData[extra1]=' . urlencode(substr($this->sOrderNumber, 0, 32)); // Max 32 karakters

			if($this->sReturnUrl)
			{
				$sRequestUrl .= '&finishUrl=' . urlencode($this->sReturnUrl);
			}

			if($this->sReportUrl)
			{
				$sRequestUrl .= '&transaction[orderExchangeUrl]=' . urlencode($this->sReportUrl);
			}

			$sRequestUrl .= '&paymentOptionId=' . urlencode($iPaymentMethodId);

			if(is_array($this->aAdditionalData) && sizeof($this->aAdditionalData))
			{
				$sAdditionalData = http_build_query($this->aAdditionalData);
				$sAdditionalData = str_replace(array('%5B', '%5D'), array('[', ']'), $sAdditionalData);

				$sRequestUrl .= '&' . $sAdditionalData;
			}

// idealcheckout_log($sRequestUrl, __FILE__, __LINE__);

			$sResponseData = idealcheckout_doHttpRequest($sRequestUrl, false, true, 30, false);
			$aResponseData = json_decode($sResponseData, true);

// idealcheckout_log($aResponseData, __FILE__, __LINE__);

			if(!empty($aResponseData['request']['result']))
			{
				$this->sTransactionId = $aResponseData['transaction']['transactionId'];
				$this->sTransactionUrl = $aResponseData['transaction']['paymentURL'];

				return array($this->sTransactionId, $this->sTransactionUrl);
			}
			else
			{
				if(isset($aResponseData['request']['result']))
				{
					$this->setError($aResponseData['request']['errorMessage'], $aResponseData['request']['errorId'], __FILE__, __LINE__);

					idealcheckout_log('PAY.NL: ' . $aResponseData['request']['errorMessage'] . ' (' . $aResponseData['request']['errorId'] . ')');
				}
				else
				{
					idealcheckout_log('TRANSACTION RESPONSE FROM PAY.NL' . "\n" . $sResponseData);
				}

				// idealcheckout_die('Cannot setup TransactionRequest. Invalid HTTP response from PAY.NL (See log files).', __FILE__, __LINE__);
			}

			return array(false, false);
		}



		public function getTransactionUrl()
		{
			if($this->sTransactionUrl)
			{
				return $this->sTransactionUrl;
			}
			else
			{
				idealcheckout_die('Please setup a valid transaction first.', __FILE__, __LINE__);
			}
		}

		public function getTransactionId()
		{
			if($this->sTransactionId)
			{
				return $this->sTransactionId;
			}
			else
			{
				idealcheckout_die('Please setup a valid transaction first.', __FILE__, __LINE__);
			}
		}







		public function doTransaction()
		{
			if($this->sTransactionUrl)
			{
				header('Location: ' . $this->sTransactionUrl);
				exit;
			}
			else
			{
				idealcheckout_die('Please setup a valid transaction first.', __FILE__, __LINE__);
			}
		}

		public function getStatus($sTransactionId)
		{
			$aBrowser = $this->getBrowser();
			$sRequestUrl = 'https://rest-api.pay.nl/v3/Transaction/info/json/?token=' . urlencode($this->sTokenCode) . '&transactionId=' . urlencode($sTransactionId);
			$sResponseData = idealcheckout_doHttpRequest($sRequestUrl, false, true, 30, false);
			$aResponseData = json_decode($sResponseData, true);

			if(!empty($aResponseData['request']['result']))
			{
				$iStatus = $aResponseData['paymentDetails']['state'];

				if($iStatus >= 100) // SUCCESS
				{
					return 'SUCCESS';
				}
				elseif($iStatus >= 0) // PENDING|IN PROGRESS
				{
					return 'PENDING';
				}
				else // CANCELLED
				{
					return 'CANCELLED';
				}
			}
			else
			{
				if(isset($aResponseData['request']['result']))
				{
					idealcheckout_log('PAY.NL: ' . $aResponseData['request']['errorMessage'] . ' (' . $aResponseData['request']['errorId'] . ')');
				}
				else
				{
					idealcheckout_log('STATUS RESPONSE FROM PAY.NL' . "\n" . $sResponseData);
				}

				idealcheckout_die('Cannot setup StatusRequest. Invalid HTTP response from PAY.NL (See log files).', __FILE__, __LINE__);
			}
		}



		private function _init()
		{
			if(empty($this->sCachePath))
			{
				idealcheckout_die('No cache path defined.', __FILE__, __LINE__);
			}

			if($this->bInit === false)
			{
				$sLockFile = $this->sCachePath . '/paynl.' . $this->sServiceId . '.lock';
				$iTimestamp = strtotime('-1 Day');

				if($this->bTestMode || !is_file($sLockFile) || ($iTimestamp <= filectime($sLockFile)))
				{
					$sRequestUrl = 'https://rest-api.pay.nl/v3/Transaction/getService/json/?token=' . urlencode($this->sTokenCode) . '&serviceId=' . urlencode($this->sServiceId);
					$sResponseData = idealcheckout_doHttpRequest($sRequestUrl, false, true, 30, false);
					$aResponseData = json_decode($sResponseData, true);

					$aPaymentMethods = array();

					if(!empty($aResponseData['request']['result']) && !empty($aResponseData['countryOptionList']) && isset($aResponseData['merchant']['state']))
					{
						if($aResponseData['merchant']['state'] < -1)
						{
							idealcheckout_die('PAY.NL account is disabled.', __FILE__, __LINE__);
						}
						elseif($aResponseData['merchant']['state'] < 0)
						{
							idealcheckout_die('PAY.NL account is not verified (yet).', __FILE__, __LINE__);
						}
						elseif($aResponseData['merchant']['state'] < 1)
						{
							if($this->bTestMode == false)
							{
								idealcheckout_die('PAY.NL account is in testmode. Please activate your account or configurate your plugin for TEST.', __FILE__, __LINE__);
							}
						}

						$aAvailablePaymentMethods = array('AFTERPAY', 'CARTEBLEUE', 'CLICKANDBUY', 'DIRECTEBANKING', 'EBON', 'FASTERPAY', 'GIROPAY', 'IDEAL', 'INCASSO', 'MAESTRO', 'MASTERCARD', 'MINITIXHYVES', 'MINITIXSMS', 'MISTERCASH', 'OVERBOEKING', 'PAYPAL', 'PAYSAFECARD', 'POSTEPAY', 'VISA', 'VPAY', 'WEBSHOPGIFTCARD');

						// Find payment methods
						foreach($aResponseData['countryOptionList'] as $k => $v)
						{
							if(!empty($aResponseData['countryOptionList'][$k]['paymentOptionList']))
							{
								foreach($aResponseData['countryOptionList'][$k]['paymentOptionList'] as $iPaymentId => $aPaymentMethod)
								{
									$sCode = preg_replace('/[^A-Z]+/', '', strtoupper($aPaymentMethod['name']));

									if((strpos($sCode, 'VISA') !== false) || (strpos($sCode, 'MASTERCARD') !== false))
									{
										$aPaymentMethods[] = array('id' => $iPaymentId, 'code' => 'CREDITCARD', 'name' => 'Creditcard');
									}
									elseif(strpos($sCode, 'MINITIXSMS') !== false)
									{
										$aPaymentMethods[] = array('id' => $iPaymentId, 'code' => 'MINITIX', 'name' => $aPaymentMethod['visibleName']);
									}
									elseif(strpos($sCode, 'MINITIXHYVES') !== false)
									{
										// $aPaymentMethods[] = array('id' => $iPaymentId, 'code' => 'MINITIX', 'name' => $aPaymentMethod['visibleName']);
									}
									elseif(strpos($sCode, 'OVERBOEKING') !== false)
									{
										$aPaymentMethods[] = array('id' => $iPaymentId, 'code' => 'MANUALTRANSFER', 'name' => $aPaymentMethod['visibleName']);
									}
									elseif(strpos($sCode, 'INCASSO') !== false)
									{
										$aPaymentMethods[] = array('id' => $iPaymentId, 'code' => 'AUTHORIZEDTRANSFER', 'name' => $aPaymentMethod['visibleName']);
									}
									else
									{
										foreach($aAvailablePaymentMethods as $sPaymentMethodCode)
										{							
											if(strpos($sCode, $sPaymentMethodCode) !== false)
											{
												$aPaymentMethods[] = array('id' => $iPaymentId, 'code' => $sPaymentMethodCode, 'name' => $aPaymentMethod['visibleName']);
											}
										}
									}
								}
							}
						}

						$this->savePaymentMethods($aPaymentMethods);
					}
					else
					{
						if(isset($aResponseData['request']['result']))
						{
							idealcheckout_log('PAY.NL: ' . $aResponseData['request']['errorMessage'] . ' (' . $aResponseData['request']['errorId'] . ')');
						}
						else
						{
							idealcheckout_log('INIT RESPONSE FROM PAY.NL' . "\n" . $sResponseData);
						}

						idealcheckout_die('Error while talking to PAY.NL server. Please check your gateway configuration (Service ID [SL-1234-5678] and Token Code).', __FILE__, __LINE__);
					}

					@touch($sLockFile);
					@chmod($sLockFile, 0777);
				}

				$this->bInit = true;
			}
		}



		// Error functions
		protected function setError($sDesc, $sCode = false, $sFile = 0, $sLine = 0)
		{
			$this->aErrors[] = array('desc' => $sDesc, 'code' => $sCode, 'file' => $sFile, 'line' => $sLine);
		}

		public function getErrors()
		{
			return $this->aErrors;
		}

		public function hasErrors()
		{
			return (sizeof($this->aErrors) ? true : false);
		}



		private function getBrowser()
		{
			$aBrowserData = @get_browser();

			if(is_array($aBrowserData) && isset($aBrowserData['parent']))
			{
				return $aBrowserData;
			}
			else
			{
				$sBrowserName = 'Unknown';
				$sBrowserVersion = '1.0';

				if(empty($_SERVER['HTTP_USER_AGENT']) == false)
				{
					$sBrowserInfo = $_SERVER['HTTP_USER_AGENT'];
					$sBrowserRaw = strtolower($_SERVER['HTTP_USER_AGENT']);

					if(strstr($sBrowserRaw, 'opera')) // Opera
					{
						$iStrPos = strpos($sBrowserRaw, ' version/');

						if($iStrPos !== false)
						{
							$sBrowserName = 'Opera';

							$sBrowserVersion = substr($sBrowserRaw, $iStrPos + 9);
							$aBrowserVersion = preg_split('/[^0-9.]+/', trim($sBrowserVersion));
							$sBrowserVersion = $aBrowserVersion[0];
						}
					}
					elseif(strstr($sBrowserRaw, ' msie ')) // IE
					{
						$iStrPos = strpos($sBrowserRaw, ' msie ');

						if($iStrPos !== false)
						{
							$sBrowserName = 'IE';

							$sBrowserVersion = substr($sBrowserRaw, $iStrPos + 6);
							$aBrowserVersion = preg_split('/[^0-9.]+/', trim($sBrowserVersion));
							$sBrowserVersion = $aBrowserVersion[0];
						}
					}
					elseif(strstr($sBrowserRaw, 'firefox')) // Mozilla Firefox
					{
						$iStrPos = strpos($sBrowserRaw, ' firefox/');

						if($iStrPos !== false)
						{
							$sBrowserName = 'Firefox';

							$sBrowserVersion = substr($sBrowserRaw, $iStrPos + 9);
							$aBrowserVersion = preg_split('/[^0-9.]+/', trim($sBrowserVersion));
							$sBrowserVersion = $aBrowserVersion[0];
						}
					}
					elseif(strstr($sBrowserRaw, 'chrome')) // Google Chrome
					{
						$iStrPos = strpos($sBrowserRaw, ' chrome/');

						if($iStrPos !== false)
						{
							$sBrowserName = 'Chrome';

							$sBrowserVersion = substr($sBrowserRaw, $iStrPos + 8);
							$aBrowserVersion = preg_split('/[^0-9.]+/', trim($sBrowserVersion));
							$sBrowserVersion = $aBrowserVersion[0];
						}
					}
					elseif(strstr($sBrowserRaw, 'safari')) // Safari
					{
						$iStrPos = strpos($sBrowserRaw, ' version/');

						if($iStrPos !== false)
						{
							$sBrowserName = 'Safari';

							$sBrowserVersion = substr($sBrowserRaw, $iStrPos + 9);
							$aBrowserVersion = preg_split('/[^0-9.]+/', trim($sBrowserVersion));
							$sBrowserVersion = $aBrowserVersion[0];
						}
					}
					elseif(strstr($sBrowserRaw, 'applewebkit')) // Safari
					{
						$iStrPos = strpos($sBrowserRaw, ' applewebkit/');

						if($iStrPos !== false)
						{
							$sBrowserName = 'Safari';

							$sBrowserVersion = substr($sBrowserRaw, $iStrPos + 13);
							$aBrowserVersion = preg_split('/[^0-9.]+/', trim($sBrowserVersion));
							$sBrowserVersion = $aBrowserVersion[0];
						}
					}
				}

				return array('browser' => $sBrowserName, 'parent' => $sBrowserName . ' ' . $sBrowserVersion, 'version' => $sBrowserVersion);
			}
		}
	}

?>