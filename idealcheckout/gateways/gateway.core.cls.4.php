<?php

	class GatewayCore
	{
		var $aRecord = false;
		var $aSettings = false;


		function GatewayCore()
		{
			$this->init();
		}
		
	
		// Load iDEAL settings
		function init()
		{
			$this->aSettings = idealcheckout_getGatewaySettings();
		}


		// Load record from table #transactions using order_id and order_code
		function getRecordByOrder($sOrderId = false, $sOrderCode = false)
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
		function getRecordByTransaction($sTransactionId = false, $sTransactionCode = false)
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

/*
		// Setup payment
		function doSetup()
		{
			idealcheckout_output('<p>Invalid iDEAL setup request.</p>');
		}


		// Execute payment
		function doTransaction()
		{
			idealcheckout_output('<p>Invalid iDEAL transaction request.</p>');
		}


		// Catch return
		function doReturn()
		{
			idealcheckout_output('<p>Invalid iDEAL return request.</p>');
		}


		// Catch report
		function doReport()
		{
			idealcheckout_output('<p>Invalid iDEAL report request.</p>');
		}


		// Validate all open transactions
		function doValidate()
		{
			idealcheckout_output('<p>This gateway doesn\'t support a validation request.</p>');
		}
*/

		// Update transaction record
		function save($aRecord = false)
		{
			global $aIdealCheckout;

			if($aRecord === false)
			{
				$aRecord = $this->oRecord;
			}

			if($aRecord)
			{
				$sql = "UPDATE `" . $aIdealCheckout['database']['table'] . "` SET";

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