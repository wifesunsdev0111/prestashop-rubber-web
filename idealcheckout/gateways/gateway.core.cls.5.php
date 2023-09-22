<?php

	class GatewayCore
	{
		protected $aRecord = false;
		protected $aSettings = false;

		public function __construct()
		{
			$this->init();
		}
		
		public function __call($sName, $aArguments)
		{
			if(strcmp($sName, 'doSetup') === 0)
			{
				idealcheckout_output('<p>Invalid setup request.</p>');
			}
			elseif(strcmp($sName, 'doTransaction') === 0)
			{
				idealcheckout_output('<p>Invalid transaction request.</p>');
			}
			elseif(strcmp($sName, 'doReturn') === 0)
			{
				idealcheckout_output('<p>Invalid return request.</p>');
			}
			elseif(strcmp($sName, 'doReport') === 0)
			{
				idealcheckout_output('<p>Invalid report request.</p>');
			}
			elseif(strcmp($sName, 'doValidate') === 0)
			{
				idealcheckout_output('<p>This gateway doesn\'t support a validation request.</p>');
			}
			else
			{
				idealcheckout_die('Unknown method "' . $sName . '".', __FILE__, __LINE__);
			}
		}

	
		// Load iDEAL settings
		public function init()
		{
			$this->aSettings = idealcheckout_getGatewaySettings();
		}


		// Load record from table #transactions using order_id and order_code
		public function getRecordByOrder($sOrderId = false, $sOrderCode = false)
		{
			global $aIdealCheckout;

			if($sOrderId === false)
			{
				$this->oRecord = (empty($aIdealCheckout['record']) ? false : $aIdealCheckout['record']);
			}
			else
			{
				$sql = "SELECT * FROM `" . $aIdealCheckout['database']['table'] . "` WHERE (`order_id` = '" . idealcheckout_escapeSql($sOrderId) . "')" . ($sOrderCode === false ? "" : " AND (`order_code` = '" . idealcheckout_escapeSql($sOrderCode) . "')") . " ORDER BY `id` DESC LIMIT 1;";
				$oRecordset = idealcheckout_database_query($sql) or idealcheckout_die('QUERY: ' . $sql . "\n\n" . 'ERROR: ' . idealcheckout_database_error() . '', __FILE__, __LINE__);

				if(idealcheckout_database_num_rows($oRecordset))
				{
					$this->oRecord = idealcheckout_database_fetch_assoc($oRecordset);
				}
				else
				{
					$this->oRecord = false;
				}
			}

			return $this->oRecord;
		}


		// Load record from table #transactions using transaction_id and transaction_code
		public function getRecordByTransaction($sTransactionId = false, $sTransactionCode = false)
		{
			global $aIdealCheckout;

			if($sTransactionId === false)
			{
				$this->oRecord = (empty($aIdealCheckout['record']) ? false : $aIdealCheckout['record']);
			}
			else
			{
				$sql = "SELECT * FROM `" . $aIdealCheckout['database']['table'] . "` WHERE (`transaction_id` = '" . idealcheckout_escapeSql($sTransactionId) . "')" . ($sTransactionCode === false ? "" : " AND (`transaction_code` = '" . idealcheckout_escapeSql($sTransactionCode) . "')") . " ORDER BY `id` DESC LIMIT 1;";
				$oRecordset = idealcheckout_database_query($sql) or idealcheckout_die('QUERY: ' . $sql . "\n\n" . 'ERROR: ' . idealcheckout_database_error() . '', __FILE__, __LINE__);

				if(idealcheckout_database_num_rows($oRecordset))
				{
					$this->oRecord = idealcheckout_database_fetch_assoc($oRecordset);
				}
				else
				{
					$this->oRecord = false;
				}
			}

			return $this->oRecord;
		}


		// Update transaction record
		public function save($aRecord = false)
		{
			global $aIdealCheckout;

			if($aRecord === false)
			{
				$aRecord = $this->oRecord;
			}

			if($aRecord)
			{
				$sql = "UPDATE `" . $aIdealCheckout['database']['table'] . "` SET ";

				foreach($aRecord as $k => $v)
				{
					if(is_null($v))
					{
						$sql .= "`" . $k . "` = NULL, ";
					}
					elseif(is_string($v) || is_numeric($v))
					{
						$sql .= "`" . $k . "` = '" . idealcheckout_escapeSql($v) . "', ";
					}
				}

				$sql = substr($sql, 0, -2) . " WHERE `id` = '" . $aRecord['id'] . "' LIMIT 1;";
				idealcheckout_database_query($sql) or idealcheckout_die('QUERY: ' . $sql . "\n\n" . 'ERROR: ' . idealcheckout_database_error() . '', __FILE__, __LINE__);

				return true;
			}

			return false;
		}
	}

?>