<?php

	/*
		Class to manage your iDEAL Requests

		Version:     0.1
		Date:        01-12-2012
		PHP:         PHP 5

		Suitable for:
		Rabobank     iDEAL Professional - iDEAL v3.3.1
		ING BANK     iDEAL Advanced - iDEAL v3
		ABN AMRO     iDEAL Zelfbouw - iDEAL v3

		See also:
		www.ideal-simulator.nl


		Author:      Martijn Wieringa
		Company:     iDEAL Checkout
		Email:       info@ideal-checkout.nl
		Website:     https://www.ideal-checkout.nl
	*/

	class IdealRequest
	{
		protected $aErrors = array();

		// Security settings
		protected $sSecurePath;
		protected $sCachePath;
		protected $sPrivateKeyPass;
		protected $sPrivateKeyFile;
		protected $sPrivateCertificateFile;
		protected $sPublicCertificateFile;

		// Account settings
		protected $bABNAMRO = false; // ABN has some issues
		protected $sAquirerName;
		protected $sAquirerUrl;
		protected $bTestMode = false;
		protected $sMerchantId;
		protected $sSubId;

		// Constants
		protected $LF = "\n";
		protected $CRLF = "\r\n";

		public function __construct()
		{
			$this->sPrivateKeyFile = 'private.key';
			$this->sPrivateCertificateFile = 'private.cer';

			if(defined('IDEAL_SECURE_PATH'))
			{
				$this->setSecurePath(IDEAL_SECURE_PATH);
			}

			if(defined('IDEAL_CACHE_PATH'))
			{
				$this->setCachePath(IDEAL_CACHE_PATH);
			}

			if(defined('IDEAL_PRIVATE_KEY'))
			{
				$this->setPrivateKey(IDEAL_PRIVATE_KEY);
			}

			if(defined('IDEAL_PRIVATE_KEY_FILE'))
			{
				$this->sPrivateKeyFile = IDEAL_PRIVATE_KEY_FILE;
			}

			if(defined('IDEAL_PRIVATE_CERTIFICATE_FILE'))
			{
				$this->sPrivateCertificateFile = IDEAL_PRIVATE_CERTIFICATE_FILE;
			}

			if(defined('IDEAL_AQUIRER'))
			{
				if(defined('IDEAL_TEST_MODE'))
				{
					$this->setAquirer(IDEAL_AQUIRER, IDEAL_TEST_MODE);
				}
				else
				{
					$this->setAquirer(IDEAL_AQUIRER);
				}
			}

			if(defined('IDEAL_MERCHANT_ID'))
			{
				if(defined('IDEAL_SUB_ID'))
				{
					$this->setMerchant(IDEAL_MERCHANT_ID, IDEAL_SUB_ID);
				}
				else
				{
					$this->setMerchant(IDEAL_MERCHANT_ID);
				}
			}
		}


		// Should point to directory with .cer and .key files
		public function setSecurePath($sPath)
		{
			$this->sSecurePath = $sPath;
		}

		// Should point to directory where cache is strored
		public function setCachePath($sPath = false)
		{
			$this->sCachePath = $sPath;
		}

		// Set password to generate signatures
		public function setPrivateKey($sPrivateKeyPass, $sPrivateKeyFile = false, $sPrivateCertificateFile = false)
		{
			$this->sPrivateKeyPass = $sPrivateKeyPass;

			if($sPrivateKeyFile)
			{
				$this->sPrivateKeyFile = $sPrivateKeyFile;
			}

			if($sPrivateCertificateFile)
			{
				$this->sPrivateCertificateFile = $sPrivateCertificateFile;
			}
		}

		// Set MerchantID id and SubID
		public function setMerchant($sMerchantId, $sSubId = 0)
		{
			$this->sMerchantId = $sMerchantId;
			$this->sSubId = $sSubId;
		}

		// Set aquirer (Use: Rabobank, ING Bank, ABN Amro, Frieslandbank, Simulator or Mollie)
		public function setAquirer($sAquirerName, $bTestMode = false)
		{
			$this->sAquirerName = $sAquirerName;
			$this->bTestMode = $bTestMode;

			$sAquirerName = strtolower($sAquirerName);

			if(strpos($sAquirerName, 'abn') !== false) // ABN AMRO
			{
				$this->sPublicCertificateFile = 'abnamro.cer';
				$this->sAquirerUrl = 'ssl://abnamro' . ($bTestMode ? '-test' : '') . '.ideal-payment.de:443/ideal/iDEALv3';
			}
			elseif(strpos($sAquirerName, 'deu') !== false) // Deutsche Bank
			{
				$this->sPublicCertificateFile = 'deutschebank.cer';
				$this->sAquirerUrl = 'ssl://ideal' . ($this->bTestMode ? 'test' : '') . '.db.com:443/ideal/iDEALv3';
			}
			elseif(strpos($sAquirerName, 'fries') !== false) // Frieslandbank
			{
				$this->sPublicCertificateFile = 'frieslandbank.cer';
				$this->sAquirerUrl = 'ssl://' . ($bTestMode ? 'test' : '') . 'idealkassa.frieslandbank.nl:443/ideal/iDEALv3';
			}
			elseif(strpos($sAquirerName, 'ing') !== false) // ING Bank
			{
				$this->sPublicCertificateFile = 'ingbank.cer';
				$this->sAquirerUrl = 'ssl://ideal' . ($bTestMode ? 'test' : '') . '.secure-ing.com:443/ideal/iDEALv3';
			}
			elseif(strpos($sAquirerName, 'rabo') !== false) // Rabobank
			{
				$this->sPublicCertificateFile = 'rabobank.cer';
				$this->sAquirerUrl = 'ssl://ideal' . ($bTestMode ? 'test' : '') . '.rabobank.nl:443/ideal/iDEALv3';
			}
			elseif(strpos($sAquirerName, 'sim') !== false) // IDEAL SIMULATOR
			{
				$this->sPublicCertificateFile = 'idealcheckout.cer';
				$this->sAquirerUrl = 'ssl://www.ideal-checkout.nl:443/simulator/';
				$this->bTestMode = true; // Always in TEST MODE
			}
			else // Unknown issuer
			{
				$this->setError('Unknown aquirer. Please use "Rabobank", "ING Bank", "ABN Amro", or "Simulator".', false, __FILE__, __LINE__);
				return false;
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



		// Validate configuration
		protected function checkConfiguration($aSettings = array('sSecurePath', 'sPrivateKeyPass', 'sPrivateKeyFile', 'sPrivateCertificateFile', 'sPublicCertificateFile', 'sAquirerUrl', 'sMerchantId'))
		{
			$bOk = true;

			for($i = 0; $i < sizeof($aSettings); $i++)
			{
				// echo $aSettings[$i] . ' = ' . $this->$aSettings[$i] . '<br>';

				if(isset($this->$aSettings[$i]) == false)
				{
					$bOk = false;
					$this->setError('Setting ' . $aSettings[$i] . ' was not configurated.', false, __FILE__, __LINE__);
				}
			}

			return $bOk;
		}



		// Send GET/POST data through sockets
		protected function postToHost($url, $data, $timeout = 30)
		{
			$__url = $url;
			$idx = strrpos($url, ':');
			$host = substr($url, 0, $idx);
			$url = substr($url, $idx + 1);
			$idx = strpos($url, '/');
			$port = substr($url, 0, $idx);
			$path = substr($url, $idx);

			$fsp = fsockopen($host, $port, $errno, $errstr, $timeout);
			$res = '';
			
			if($fsp)
			{
				// echo "\n\nSEND DATA: \n\n" . $data . "\n\n";

				fputs($fsp, 'POST ' . $path . ' HTTP/1.0' . $this->CRLF);
				fputs($fsp, 'Host: ' . substr($host, 6) . $this->CRLF);
				fputs($fsp, 'Accept: text/xml' . $this->CRLF);
				fputs($fsp, 'Accept: charset=ISO-8859-1' . $this->CRLF);
				fputs($fsp, 'Content-Length:' . strlen($data) . $this->CRLF);
				fputs($fsp, 'Content-Type: text/xml' . $this->CRLF . $this->CRLF);
				fputs($fsp, $data, strlen($data));

				while(!feof($fsp))
				{
					$res .= @fgets($fsp, 128);
				}

				fclose($fsp);

				// echo "\n\nRECIEVED DATA: \n\n" . $res . "\n\n";
			}
			else
			{
				$this->setError('Error while connecting to ' . $__url, false, __FILE__, __LINE__);
			}

			return $res;
		}

		// Get value within given XML tag
		protected function parseFromXml($key, $xml)
		{
			$begin = 0;
			$end = 0;
			$begin = strpos($xml, '<' . $key . '>');
			
			if($begin === false)
			{
				return false;
			}

			$begin += strlen($key) + 2;
			$end = strpos($xml, '</' . $key . '>');

			if($end === false)
			{
				return false;
			}

			$result = substr($xml, $begin, $end - $begin);
			return $this->unescapeXml($result);
		}

		// Remove space characters from string
		protected function removeSpaceCharacters($string)
		{
			return preg_replace('/\s/', '', $string);
		}

		// Escape (replace/remove) special characters in string
		protected function escapeSpecialChars($string)
		{
			$string = str_replace(array('à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ð', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', '§', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', '€', 'Ð', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', '§', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'Ÿ'), array('a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'ed', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 's', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'EUR', 'ED', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'S', 'U', 'U', 'U', 'U', 'Y', 'Y'), $string);
			$string = preg_replace('/[^a-zA-Z0-9\-\.\,\(\)_]+/', ' ', $string);
			$string = preg_replace('/[\s]+/', ' ', $string);

			return $string;
		}

		// Escape special XML characters
		protected function escapeXml($string)
		{
			return utf8_encode(str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
		}

		// Unescape special XML characters
		protected function unescapeXml($string)
		{
			return str_replace(array('&lt;', '&gt;', '&quot;', '&amp;'), array('<', '>', '"', '&'), utf8_decode($string));
		}


		
		protected function getMessageDigest($sMessage)
		{
            return base64_encode(hash('sha256', $sMessage, true));
		}


		protected function getSignature($sMessage, $sKeyPath, $sKeyPassword = false)
		{
			$sKeyData = file_get_contents($sKeyPath);

			if(empty($sKeyData))
			{
				idealcheckout_die('File "' . $sKeyPath . '" is empty or does not exist.', __FILE__, __LINE__);
			}

			if($sKeyPassword === false)
			{
				$oKeyData = openssl_get_publickey($sKeyData);

				if(empty($oKeyData))
				{
					idealcheckout_die('File "' . $sKeyPath . '" is an invalid publickey file.', __FILE__, __LINE__);
				}
			}
			else
			{
				$oKeyData = openssl_get_privatekey($sKeyData, $sKeyPassword);

				if(empty($oKeyData))
				{
					idealcheckout_die('File "' . $sKeyPath . '" is an invalid privatekey file, or privatekey file doesn\'t match private keypass.', __FILE__, __LINE__);
				}
			}

			if(version_compare(PHP_VERSION, '5.3.0') < 0)
			{
				if(!self::openssl_sign_alternative($sMessage, $sSignature, $oKeyData))
				{
					idealcheckout_die('Cannot sign message', __FILE__, __LINE__);
				}
			}
			else
			{
				if(!openssl_sign($sMessage, $sSignature, $oKeyData, 'SHA256'))
				{
					idealcheckout_die('Cannot sign message', __FILE__, __LINE__);
				}
			}

			$sSignature = base64_encode($sSignature);

			return $sSignature;
		}

		protected function verifySignature($sMessage, $sSignature, $sCertificatePath)
		{
			$sCertificateData = file_get_contents($sCertificatePath);
			$oCertificateData = openssl_get_publickey($sCertificateData);

			// Replace self-closing-tags
			$sMessage = str_replace(array('/><SignatureMethod', '/><Reference', '/></Transforms', '/><DigestValue'), array('></CanonicalizationMethod><SignatureMethod', '></SignatureMethod><Reference', '></Transform></Transforms', '></DigestMethod><DigestValue'), $sMessage);

			// Decode signature
			$sSignature = base64_decode($sSignature);

			if(version_compare(PHP_VERSION, '5.3.0') < 0)
			{
				return self::openssl_verify_alternative($sMessage, $sSignature, $oCertificateData);
			}
			else
			{
				return openssl_verify($sMessage, $sSignature, $oCertificateData, 'SHA256');
			}
		}

		protected function verifyDigest($sMessage, $sDigest)
		{
			return (strcmp($this->getMessageDigest($sMessage), $sDigest) === 0);
		}

		protected function getCertificateFingerprint($sFilePath)
		{
			if(!$sFilePath || !is_file($sFilePath))
			{
				idealcheckout_die('Invalid certificate file: ' . $sFilePath . '.', __FILE__, __LINE__);
			}

			$sData = file_get_contents($sFilePath);

			if(empty($sData))
			{
				idealcheckout_die('Invalid certificate file: ' . $sFilePath . '.', __FILE__, __LINE__);
			}

			$oData = openssl_x509_read($sData);

			if($oData == false)
			{
				idealcheckout_die('Invalid certificate file: ' . $sFilePath . '.', __FILE__, __LINE__);
			}
			elseif(!openssl_x509_export($oData, $sData))
			{
				idealcheckout_die('Invalid certificate file: ' . $sFilePath . '.', __FILE__, __LINE__);
			}

			// Remove any ASCII armor
			$sData = str_replace('-----BEGIN CERTIFICATE-----', '', $sData);
			$sData = str_replace('-----END CERTIFICATE-----', '', $sData);

			$sData = base64_decode($sData);
			$sFingerprint = sha1($sData);
			$sFingerprint = strtoupper($sFingerprint);

			return $sFingerprint;
		}

		protected function getPublicCertificateFile($sCertificateFingerprint)
		{
			$aCertificateFiles = array();

			if(file_exists($this->sSecurePath . $this->sPublicCertificateFile))
			{
				$aCertificateFiles[] = $this->sPublicCertificateFile;
			}


			// Upto 10 public certificates by acquirer; eg: rabobank-0.cer, rabobank-1.cer, rabobank-2.cer, etc.
			for($i = 0; $i < 10; $i++)
			{
				$sCertificateFile = substr($this->sPublicCertificateFile, 0, -4) . '-' . $i . '.cer';

				if(file_exists($this->sSecurePath . $sCertificateFile))
				{
					$aCertificateFiles[] = $sCertificateFile;
				}
			}


			// Find generic certificates
			if(file_exists($this->sSecurePath . 'ideal.cer'))
			{
				$aCertificateFiles[] = 'ideal.cer';
			}


			// Upto 10 public certificates; eg: ideal-0.cer, ideal-1.cer, ideal-2.cer, etc.
			for($i = 0; $i < 10; $i++)
			{
				$sCertificateFile = 'ideal-' . $i . '.cer';

				if(file_exists($this->sSecurePath . $sCertificateFile))
				{
					$aCertificateFiles[] = $sCertificateFile;
				}
			}

			// Test each certificate with given fingerprint
			foreach($aCertificateFiles as $sCertificateFile)
			{
				$sFingerprint = $this->getCertificateFingerprint($this->sSecurePath . $sCertificateFile);

				if(strcmp($sFingerprint, $sCertificateFingerprint) === 0)
				{
					return $this->sSecurePath . $sCertificateFile;
				}
			}

			return false;
		}

		// Verify response message (<DigestValue>, <SignatureValue>)
		protected function verifyResponse($sXmlData, $sResponseType)
		{
			$sCertificateFingerprint = $this->parseFromXml('KeyName', $sXmlData);
			$sDigestValue = $this->parseFromXml('DigestValue', $sXmlData);
			$sSignatureValue = str_replace(array("\r", "\n"), '', $this->parseFromXml('SignatureValue', $sXmlData));

			$sDigestData = '';

			if($this->parseFromXml('errorCode', $sXmlData)) // Error found
			{
				// Add error to error-list
				$this->setError($this->parseFromXml('errorMessage', $sXmlData) . ' - ' . $this->parseFromXml('errorDetail', $sXmlData), $this->parseFromXml('errorCode', $sXmlData), __FILE__, __LINE__);
			}
			elseif(strpos($sXmlData, '</' . $sResponseType . '>') !== false) // Directory Response
			{
				// Strip <Signature>
				$iStart = strpos($sXmlData, '<' . $sResponseType);
				$iEnd = strpos($sXmlData, '<Signature');
				$sDigestData = substr($sXmlData, $iStart, $iEnd - $iStart) . '</' . $sResponseType . '>';
			}

			if(!empty($sDigestData))
			{
				// Recalculate & compare DigestValue
				if($this->verifyDigest($sDigestData, $sDigestValue))
				{
					// Find <SignedInfo>, and add ' xmlns="http://www.w3.org/2000/09/xmldsig#"'
					$iStart = strpos($sXmlData, '<SignedInfo>');
					$iEnd = strpos($sXmlData, '</SignedInfo>');
					$sSignatureData = '<SignedInfo xmlns="http://www.w3.org/2000/09/xmldsig#">' . substr($sXmlData, $iStart + 12, $iEnd - ($iStart + 12)) . '</SignedInfo>';

					if(!empty($sSignatureData))
					{
						// Detect used public certificate by given fingerprint
						if($sPublicCertificateFile = $this->getPublicCertificateFile($sCertificateFingerprint))
						{
							// Recalculate & compare SignatureValue
							if($this->verifySignature($sSignatureData, $sSignatureValue, $sPublicCertificateFile))
							{
								return true;
							}
							else
							{
								$this->setError('Invalid signature value in XML response.', '', __FILE__, __LINE__);
							}
						}
						else
						{
							$this->setError('Cannot find public certificate file with fingerprint: ' . $sCertificateFingerprint, '', __FILE__, __LINE__);
						}
					}
					else
					{
						$this->setError('Cannot find <SignedInfo> in XML response.', '', __FILE__, __LINE__);
					}
				}
				else
				{
					$this->setError('Invalid digest value in XML response.', '', __FILE__, __LINE__);
				}
			}
			else
			{
				$this->setError('Cannot find <' . $sResponseType . '> in XML response.', '', __FILE__, __LINE__);
			}

			return false;
		}

		// PHP 5.2 alternative for SHA256 signing
		public static function openssl_sign_alternative($sMessage, &$sSignature, $oKeyData)
		{
			$aPrivateKey = openssl_pkey_get_details($oKeyData);

			$sSha256 = '3031300d060960864801650304020105000420';
			$sHash = $sSha256 . hash('sha256', $sMessage);

			$iLength = ($aPrivateKey['bits'] / 8) - ((strlen($sHash) / 2) + 3);

			$sData = '0001' . str_repeat('FF', $iLength) . '00' . $sHash;
			$sData = pack('H*', $sData);

			return openssl_private_encrypt($sData, $sSignature, $oKeyData, OPENSSL_NO_PADDING);
		}

		// PHP 5.2 alternative for SHA256 validation
		public static function openssl_verify_alternative($sMessage, &$sSignature, $oKeyData)
		{
			$aPrivateKey = openssl_pkey_get_details($oKeyData);

			$sSha256 = '3031300d060960864801650304020105000420';
			$sHash = $sSha256 . hash('sha256', $sMessage);

			$iLength = ($aPrivateKey['bits'] / 8) - ((strlen($sHash) / 2) + 3);

			$sData = '0001' . str_repeat('FF', $iLength) . '00' . $sHash;
			$sData = pack('H*', $sData);

			return openssl_public_decrypt($sData, $sSignature, $oKeyData, OPENSSL_NO_PADDING);
		}
	}




	class IssuerRequest extends IdealRequest
	{
		public function __construct()
		{
			parent::__construct();
		}

		// Execute request (Lookup issuer list)
		public function doRequest()
		{
			if($this->checkConfiguration())
			{
				$sCacheFile = false;

				// Used cached issuers?
				if(($this->bTestMode == false) && $this->sCachePath)
				{
					$sCacheFile = $this->sCachePath . 'issuers.cache';
					$bFileCreated = false;

					if(file_exists($sCacheFile) == false)
					{
						$bFileCreated = true;

						// Attempt to create cache file
						if(@touch($sCacheFile))
						{
							@chmod($sCacheFile, 0777);
						}
					}

					if(file_exists($sCacheFile) && is_readable($sCacheFile) && is_writable($sCacheFile))
					{
						if($bFileCreated || (filemtime($sCacheFile) > strtotime('-24 Hours')))
						{
							// Read data from cache file
							if($sData = file_get_contents($sCacheFile))
							{
								return idealcheckout_unserialize($sData);
							}
						}
					}
					else
					{
						$sCacheFile = false;
					}
				}



				$sTimestamp = gmdate('Y-m-d\TH:i:s.000\Z');
				$sCertificateFingerprint = $this->getCertificateFingerprint($this->sSecurePath . $this->sPrivateCertificateFile);

				$sXml  = '<DirectoryReq xmlns="http://www.idealdesk.com/ideal/messages/mer-acq/3.3.1" version="3.3.1">';
				$sXml .= '<createDateTimestamp>' . $sTimestamp . '</createDateTimestamp>';
				$sXml .= '<Merchant>';
				$sXml .= '<merchantID>' . $this->sMerchantId . '</merchantID>';
				$sXml .= '<subID>' . $this->sSubId . '</subID>';
				$sXml .= '</Merchant>';
				$sXml .= '</DirectoryReq>';

				// Calculate <DigestValue>
				$sDigestValue = $this->getMessageDigest($sXml);

				$sXml = '<SignedInfo xmlns="http://www.w3.org/2000/09/xmldsig#">';
				$sXml .= '<CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"></CanonicalizationMethod>';
				$sXml .= '<SignatureMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha256"></SignatureMethod>';
				$sXml .= '<Reference URI="">';
				$sXml .= '<Transforms>';
				$sXml .= '<Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"></Transform>';
				$sXml .= '</Transforms>';
				$sXml .= '<DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"></DigestMethod>';
				$sXml .= '<DigestValue>' . $sDigestValue . '</DigestValue>';
				$sXml .= '</Reference>';
				$sXml .= '</SignedInfo>';

				// Calculate <SignatureValue>
				$sSignatureValue = $this->getSignature($sXml, $this->sSecurePath . $this->sPrivateKeyFile, $this->sPrivateKeyPass);

				$sXml  = '<' . '?' . 'xml version="1.0" encoding="UTF-8"' . '?' . '>' . "\n";
				$sXml .= '<DirectoryReq xmlns="http://www.idealdesk.com/ideal/messages/mer-acq/3.3.1" version="3.3.1">';
				$sXml .= '<createDateTimestamp>' . $sTimestamp . '</createDateTimestamp>';
				$sXml .= '<Merchant>';
				$sXml .= '<merchantID>' . $this->sMerchantId . '</merchantID>';
				$sXml .= '<subID>' . $this->sSubId . '</subID>';
				$sXml .= '</Merchant>';
				$sXml .= '<Signature xmlns="http://www.w3.org/2000/09/xmldsig#">';
				$sXml .= '<SignedInfo>';
				$sXml .= '<CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"></CanonicalizationMethod>';
				$sXml .= '<SignatureMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha256"></SignatureMethod>';
				$sXml .= '<Reference URI="">';
				$sXml .= '<Transforms>';
				$sXml .= '<Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"></Transform>';
				$sXml .= '</Transforms>';
				$sXml .= '<DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"></DigestMethod>';
				$sXml .= '<DigestValue>' . $sDigestValue . '</DigestValue>';
				$sXml .= '</Reference>';
				$sXml .= '</SignedInfo>';
				$sXml .= '<SignatureValue>' . $sSignatureValue . '</SignatureValue>';
				$sXml .= '<KeyInfo>';
				$sXml .= '<KeyName>' . $sCertificateFingerprint . '</KeyName>';
				$sXml .= '</KeyInfo>';
				$sXml .= '</Signature>';
				$sXml .= '</DirectoryReq>';

				$sXmlReply = $this->postToHost($this->sAquirerUrl, $sXml, 10);

				if($sXmlReply)
				{
					if($this->verifyResponse($sXmlReply, 'DirectoryRes'))
					{
						$aIssuerList = array();

						while(strpos($sXmlReply, '<issuerID>'))
						{
							$sIssuerId = $this->parseFromXml('issuerID', $sXmlReply);
							$sIssuerName = $this->parseFromXml('issuerName', $sXmlReply);

							$aIssuerList[$sIssuerId] = $sIssuerName;

							$sXmlReply = substr($sXmlReply, strpos($sXmlReply, '</Issuer>') + 9);
						}

						// Save data in cache?
						if($sCacheFile)
						{
							file_put_contents($sCacheFile, idealcheckout_serialize($aIssuerList));
						}

						return $aIssuerList;
					}
				}
			}

			return false;
		}
	}




	class TransactionRequest extends IdealRequest
	{
		protected $sOrderId;
		protected $sOrderDescription;
		protected $fOrderAmount;
		protected $sReturnUrl;
		protected $sIssuerId;
		protected $sEntranceCode;

		// Transaction info
		protected $sTransactionId;
		protected $sTransactionUrl;

		public function __construct()
		{
			parent::__construct();

			if(defined('IDEAL_RETURN_URL'))
			{
				$this->setReturnUrl(IDEAL_RETURN_URL);
			}

			// Random EntranceCode
			$this->sEntranceCode = sha1(rand(1000000, 9999999));
		}

		public function setOrderId($sOrderId)
		{
			$this->sOrderId = substr($sOrderId, 0, 16);
		}

		public function setOrderDescription($sOrderDescription)
		{
			$this->sOrderDescription = trim(substr($this->escapeSpecialChars($sOrderDescription), 0, 32));
		}

		public function setOrderAmount($fOrderAmount)
		{
			$this->fOrderAmount = round($fOrderAmount, 2);
		}

		public function setReturnUrl($sReturnUrl)
		{
			// Fix for ING Bank, urlescape [ and ]
			$sReturnUrl = str_replace('[', '%5B', $sReturnUrl);
			$sReturnUrl = str_replace(']', '%5D', $sReturnUrl);

			$this->sReturnUrl = substr($sReturnUrl, 0, 512);
		}

		// ID of the selected bank
		public function setIssuerId($sIssuerId)
		{
			$sIssuerId = preg_replace('/[^a-zA-Z0-9]/', '', $sIssuerId);
			$this->sIssuerId = $sIssuerId;
		}

		// A random generated entrance code
		public function setEntranceCode($sEntranceCode)
		{
			$this->sEntranceCode = substr($sEntranceCode, 0, 40);
		}

		// Retrieve the transaction URL recieved in the XML response of de IDEAL SERVER
		public function getTransactionUrl()
		{
			return $this->sTransactionUrl;
		}

		// Execute request (Setup transaction)
		public function doRequest()
		{
			if($this->checkConfiguration() && $this->checkConfiguration(array('sOrderId', 'sOrderDescription', 'fOrderAmount', 'sReturnUrl', 'sReturnUrl', 'sIssuerId', 'sEntranceCode')))
			{
				$sTimestamp = gmdate('Y-m-d\TH:i:s.000\Z');
				$sCertificateFingerprint = $this->getCertificateFingerprint($this->sSecurePath . $this->sPrivateCertificateFile);

				$sXml  = '<AcquirerTrxReq xmlns="http://www.idealdesk.com/ideal/messages/mer-acq/3.3.1" version="3.3.1">';
				$sXml .= '<createDateTimestamp>' . $sTimestamp . '</createDateTimestamp>';
				$sXml .= '<Issuer>';
				$sXml .= '<issuerID>' . $this->sIssuerId . '</issuerID>';
				$sXml .= '</Issuer>';
				$sXml .= '<Merchant>';
				$sXml .= '<merchantID>' . $this->sMerchantId . '</merchantID>';
				$sXml .= '<subID>' . $this->sSubId . '</subID>';
				$sXml .= '<merchantReturnURL>' . $this->sReturnUrl . '</merchantReturnURL>';
				$sXml .= '</Merchant>';
				$sXml .= '<Transaction>';
				$sXml .= '<purchaseID>' . $this->sOrderId . '</purchaseID>';
				$sXml .= '<amount>' . number_format($this->fOrderAmount, 2, '.', '') . '</amount>';
				$sXml .= '<currency>EUR</currency>';
				$sXml .= '<expirationPeriod>PT1H</expirationPeriod>';
				$sXml .= '<language>nl</language>';
				$sXml .= '<description>' . $this->sOrderDescription . '</description>';
				$sXml .= '<entranceCode>' . $this->sEntranceCode . '</entranceCode>';
				$sXml .= '</Transaction>';
				$sXml .= '</AcquirerTrxReq>';

				// Calculate <DigestValue>
				$sDigestValue = $this->getMessageDigest($sXml);

				$sXml  = '<SignedInfo xmlns="http://www.w3.org/2000/09/xmldsig#">';
				$sXml .= '<CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"></CanonicalizationMethod>';
				$sXml .= '<SignatureMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha256"></SignatureMethod>';
				$sXml .= '<Reference URI="">';
				$sXml .= '<Transforms>';
				$sXml .= '<Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"></Transform>';
				$sXml .= '</Transforms>';
				$sXml .= '<DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"></DigestMethod>';
				$sXml .= '<DigestValue>' . $sDigestValue . '</DigestValue>';
				$sXml .= '</Reference>';
				$sXml .= '</SignedInfo>';

				// Calculate <SignatureValue>
				$sSignatureValue = $this->getSignature($sXml, $this->sSecurePath . $this->sPrivateKeyFile, $this->sPrivateKeyPass);

				$sXml  = '<' . '?' . 'xml version="1.0" encoding="UTF-8"' . '?' . '>' . "\n";
				$sXml .= '<AcquirerTrxReq xmlns="http://www.idealdesk.com/ideal/messages/mer-acq/3.3.1" version="3.3.1">';
				$sXml .= '<createDateTimestamp>' . $sTimestamp . '</createDateTimestamp>';
				$sXml .= '<Issuer>';
				$sXml .= '<issuerID>' . $this->sIssuerId . '</issuerID>';
				$sXml .= '</Issuer>';
				$sXml .= '<Merchant>';
				$sXml .= '<merchantID>' . $this->sMerchantId . '</merchantID>';
				$sXml .= '<subID>' . $this->sSubId . '</subID>';
				$sXml .= '<merchantReturnURL>' . $this->sReturnUrl . '</merchantReturnURL>';
				$sXml .= '</Merchant>';
				$sXml .= '<Transaction>';
				$sXml .= '<purchaseID>' . $this->sOrderId . '</purchaseID>';
				$sXml .= '<amount>' . number_format($this->fOrderAmount, 2, '.', '') . '</amount>';
				$sXml .= '<currency>EUR</currency>';
				$sXml .= '<expirationPeriod>PT1H</expirationPeriod>';
				$sXml .= '<language>nl</language>';
				$sXml .= '<description>' . $this->sOrderDescription . '</description>';
				$sXml .= '<entranceCode>' . $this->sEntranceCode . '</entranceCode>';
				$sXml .= '</Transaction>';
				$sXml .= '<Signature xmlns="http://www.w3.org/2000/09/xmldsig#">';
				$sXml .= '<SignedInfo>';
				$sXml .= '<CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"></CanonicalizationMethod>';
				$sXml .= '<SignatureMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha256"></SignatureMethod>';
				$sXml .= '<Reference URI="">';
				$sXml .= '<Transforms>';
				$sXml .= '<Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"></Transform>';
				$sXml .= '</Transforms>';
				$sXml .= '<DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"></DigestMethod>';
				$sXml .= '<DigestValue>' . $sDigestValue . '</DigestValue>';
				$sXml .= '</Reference>';
				$sXml .= '</SignedInfo>';
				$sXml .= '<SignatureValue>' . $sSignatureValue . '</SignatureValue>';
				$sXml .= '<KeyInfo>';
				$sXml .= '<KeyName>' . $sCertificateFingerprint . '</KeyName>';
				$sXml .= '</KeyInfo>';
				$sXml .= '</Signature>';
				$sXml .= '</AcquirerTrxReq>';

				$sXmlReply = $this->postToHost($this->sAquirerUrl, $sXml, 10);

				if($sXmlReply)
				{
					if($this->verifyResponse($sXmlReply, 'AcquirerTrxRes'))
					{
						$this->sTransactionId = $this->parseFromXml('transactionID', $sXmlReply);
						$this->sTransactionUrl = html_entity_decode($this->parseFromXml('issuerAuthenticationURL', $sXmlReply));

						return $this->sTransactionId;
					}
				}
			}

			return false;
		}

		// Start transaction
		public function doTransaction()
		{
			if((sizeof($this->aErrors) == 0) && $this->sTransactionId && $this->sTransactionUrl)
			{
				header('Location: ' . $this->sTransactionUrl);
				exit;
			}

			$this->setError('Please setup a valid transaction request first.', false, __FILE__, __LINE__);
			return false;
		}
	}




	class StatusRequest extends IdealRequest
	{
		// Account info
		protected $sAccountCity;
		protected $sAccountName;
		protected $sAccountNumber;

		// Transaction info
		protected $sTransactionId;
		protected $sTransactionStatus;

		public function __construct()
		{
			parent::__construct();
		}

		// Set transaction id
		public function setTransactionId($sTransactionId)
		{
			$this->sTransactionId = $sTransactionId;
		}

		// Get account city
		public function getAccountCity()
		{
			if(!empty($this->sAccountCity))
			{
				return $this->sAccountCity;
			}

			return '';
		}

		// Get account name
		public function getAccountName()
		{
			if(!empty($this->sAccountName))
			{
				return $this->sAccountName;
			}

			return '';
		}

		// Get account number
		public function getAccountNumber()
		{
			if(!empty($this->sAccountNumber))
			{
				return $this->sAccountNumber;
			}

			return '';
		}

		// Execute request
		public function doRequest()
		{
			if($this->checkConfiguration() && $this->checkConfiguration(array('sTransactionId')))
			{
				$sTimestamp = gmdate('Y-m-d\TH:i:s.000\Z');
				$sCertificateFingerprint = $this->getCertificateFingerprint($this->sSecurePath . $this->sPrivateCertificateFile);

				$sXml  = '<AcquirerStatusReq xmlns="http://www.idealdesk.com/ideal/messages/mer-acq/3.3.1" version="3.3.1">';
				$sXml .= '<createDateTimestamp>' . $sTimestamp . '</createDateTimestamp>';
				$sXml .= '<Merchant>';
				$sXml .= '<merchantID>' . $this->sMerchantId . '</merchantID>';
				$sXml .= '<subID>' . $this->sSubId . '</subID>';
				$sXml .= '</Merchant>';
				$sXml .= '<Transaction>';
				$sXml .= '<transactionID>' . $this->sTransactionId . '</transactionID>';
				$sXml .= '</Transaction>';
				$sXml .= '</AcquirerStatusReq>';

				// Calculate <DigestValue>
				$sDigestValue = $this->getMessageDigest($sXml);

				$sXml  = '<SignedInfo xmlns="http://www.w3.org/2000/09/xmldsig#">';
				$sXml .= '<CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"></CanonicalizationMethod>';
				$sXml .= '<SignatureMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha256"></SignatureMethod>';
				$sXml .= '<Reference URI="">';
				$sXml .= '<Transforms>';
				$sXml .= '<Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"></Transform>';
				$sXml .= '</Transforms>';
				$sXml .= '<DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"></DigestMethod>';
				$sXml .= '<DigestValue>' . $sDigestValue . '</DigestValue>';
				$sXml .= '</Reference>';
				$sXml .= '</SignedInfo>';

				// Calculate <SignatureValue>
				$sSignatureValue = $this->getSignature($sXml, $this->sSecurePath . $this->sPrivateKeyFile, $this->sPrivateKeyPass);

				$sXml  = '<' . '?' . 'xml version="1.0" encoding="UTF-8"' . '?' . '>' . "\n";
				$sXml .= '<AcquirerStatusReq xmlns="http://www.idealdesk.com/ideal/messages/mer-acq/3.3.1" version="3.3.1">';
				$sXml .= '<createDateTimestamp>' . $sTimestamp . '</createDateTimestamp>';
				$sXml .= '<Merchant>';
				$sXml .= '<merchantID>' . $this->sMerchantId . '</merchantID>';
				$sXml .= '<subID>' . $this->sSubId . '</subID>';
				$sXml .= '</Merchant>';
				$sXml .= '<Transaction>';
				$sXml .= '<transactionID>' . $this->sTransactionId . '</transactionID>';
				$sXml .= '</Transaction>';
				$sXml .= '<Signature xmlns="http://www.w3.org/2000/09/xmldsig#">';
				$sXml .= '<SignedInfo>';
				$sXml .= '<CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"></CanonicalizationMethod>';
				$sXml .= '<SignatureMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha256"></SignatureMethod>';
				$sXml .= '<Reference URI="">';
				$sXml .= '<Transforms>';
				$sXml .= '<Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"></Transform>';
				$sXml .= '</Transforms>';
				$sXml .= '<DigestMethod Algorithm="http://www.w3.org/2001/04/xmlenc#sha256"></DigestMethod>';
				$sXml .= '<DigestValue>' . $sDigestValue . '</DigestValue>';
				$sXml .= '</Reference>';
				$sXml .= '</SignedInfo>';
				$sXml .= '<SignatureValue>' . $sSignatureValue . '</SignatureValue>';
				$sXml .= '<KeyInfo>';
				$sXml .= '<KeyName>' . $sCertificateFingerprint . '</KeyName>';
				$sXml .= '</KeyInfo>';
				$sXml .= '</Signature>';
				$sXml .= '</AcquirerStatusReq>';

				$sXmlReply = $this->postToHost($this->sAquirerUrl, $sXml, 10);

				if($sXmlReply)
				{
					// Verify message (DigestValue & SignatureValue)
					if($this->verifyResponse($sXmlReply, 'AcquirerStatusRes'))
					{
						$sTimestamp = $this->parseFromXml('createDateTimeStamp', $sXmlReply);
						$sTransactionId = $this->parseFromXml('transactionID', $sXmlReply);
						$sTransactionStatus = $this->parseFromXml('status', $sXmlReply);

						// $sAccountNumber = $this->parseFromXml('consumerAccountNumber', $sXmlReply);
						// $sAccountName = $this->parseFromXml('consumerName', $sXmlReply);
						// $sAccountCity = $this->parseFromXml('consumerCity', $sXmlReply);

						// Try to keep field compatible where possible
						$sAccountNumber = $this->parseFromXml('consumerIBAN', $sXmlReply) . ' | ' . $this->parseFromXml('consumerBIC', $sXmlReply);
						$sAccountName = $this->parseFromXml('consumerName', $sXmlReply);
						$sAccountCity = '-';

						// $this->sTransactionId = $sTransactionId;
						$this->sTransactionStatus = strtoupper($sTransactionStatus);

						$this->sAccountCity = $sAccountCity;
						$this->sAccountName = $sAccountName;
						$this->sAccountNumber = $sAccountNumber;

						return $this->sTransactionStatus;
					}
				}
			}

			return false;
		}
	}

?>