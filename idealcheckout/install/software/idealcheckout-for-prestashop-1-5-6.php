<?php

	class IDEALCHECKOUT_FOR_PRESTASHOP_1_5_6
	{
		// Return the software name
		public static function getSoftwareName()
		{
			return 'Prestashop 1.5+';
		}



		// Return the software code
		public static function getSoftwareCode()
		{
			return str_replace('_', '-', substr(basename(__FILE__), 0, -4));
		}



		// Return the software name
		public static function getSoftwareVersion()
		{
			// Test version
			$sConfigData = self::getConfigData();

			if(strlen($sConfigData))
			{
				return IDEALCHECKOUT_INSTALL::getFileValue($sConfigData, '/define\(\'_PS_VERSION_\', \'([^\']+)\'\);/');
			}

			return '';
		}



		// Return path to main cinfig file (if any)
		public static function getConfigFile()
		{
			return SOFTWARE_PATH . DS . 'config' . DS . 'settings.inc.php';
		}



		// Return path to main cinfig file (if any)
		public static function getConfigData()
		{
			$sConfigFile = self::getConfigFile();

			// Detect DB settings via configuration file
			if(is_file($sConfigFile))
			{
				return file_get_contents($sConfigFile);
			}

			return '';
		}



		// Find default database settings
		public static function getDatabaseSettings($aSettings)
		{
			$aSettings['db_prefix'] = 'ps_';
			$sConfigData = self::getConfigData();

			if(!empty($sConfigData))
			{
				$aSettings['db_host'] = IDEALCHECKOUT_INSTALL::getFileValue($sConfigData, '/define\(\'_DB_SERVER_\', \'([^\']+)\'\);/');
				$aSettings['db_user'] = IDEALCHECKOUT_INSTALL::getFileValue($sConfigData, '/define\(\'_DB_USER_\', \'([^\']+)\'\);/');
				$aSettings['db_pass'] = IDEALCHECKOUT_INSTALL::getFileValue($sConfigData, '/define\(\'_DB_PASSWD_\', \'([^\']+)\'\);/');
				$aSettings['db_name'] = IDEALCHECKOUT_INSTALL::getFileValue($sConfigData, '/define\(\'_DB_NAME_\', \'([^\']+)\'\);/');
				$aSettings['db_prefix'] = IDEALCHECKOUT_INSTALL::getFileValue($sConfigData, '/define\(\'_DB_PREFIX_\', \'([^\']+)\'\);/');
				$aSettings['db_type'] = (version_compare(PHP_VERSION, '5.3', '>') ? 'mysqli' : 'mysql');
			}

			return $aSettings;
		}



		// See if current software == self::$sSoftwareCode
		public static function isSoftware()
		{
			$aFiles = array();
			$aFiles[] = SOFTWARE_PATH . DS . 'classes' . DS . 'CMS.php';

			foreach($aFiles as $sFile)
			{
				if(!is_file($sFile))
				{
					return array(false, 'Invalid version of PrestaShop.');
				}
			}

			// Test version
			$sVersion = self::getSoftwareVersion();

			if(!empty($sVersion) && version_compare($sVersion, '1.5', '>='))
			{
				return array(true, '');
			}

			return array(false, 'Invalid version of PrestaShop.');
		}



		// See if write privileges are properly set
		public static function getFilesAndFolders()
		{
			return array();
		}



		// Install plugin, return text
		public static function doInstall($aSettings)
		{
			IDEALCHECKOUT_INSTALL::doInstall($aSettings);

			// Patch files or output instructions
			// Set read/write privileges or output instructions

			$aPaymentMethods = IDEALCHECKOUT_INSTALL::getPaymentMethods();

			foreach($aPaymentMethods as $k => $aPaymentMethod)
			{
				IDEALCHECKOUT_INSTALL::setLog('Creating default configuration settings in database table #_configuration for ' . $aPaymentMethod['code'], __FILE__, __LINE__);

				$sql = "SELECT * FROM `" . $aSettings['db_prefix'] . "configuration` WHERE `name` = 'CONF_" . idealcheckout_escapeSql(strtoupper($aPaymentMethod['code'])) . "_FIXED' LIMIT 1;";
				if(!idealcheckout_database_isRecord($sql))
				{
					$sql = "INSERT INTO `" . $aSettings['db_prefix'] . "configuration` (`id_configuration`, `id_shop_group`, `id_shop`, `name`, `value`, `date_add`, `date_upd`) VALUES (NULL, NULL, NULL, 'CONF_" . idealcheckout_escapeSql(strtoupper($aPaymentMethod['code'])) . "_FIXED', '0.2', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "');";
					idealcheckout_database_execute($sql);

					$sql = "INSERT INTO `" . $aSettings['db_prefix'] . "configuration` (`id_configuration`, `id_shop_group`, `id_shop`, `name`, `value`, `date_add`, `date_upd`) VALUES (NULL, NULL, NULL, 'CONF_" . idealcheckout_escapeSql(strtoupper($aPaymentMethod['code'])) . "_VAR', '2', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "');";
					idealcheckout_database_execute($sql);

					$sql = "INSERT INTO `" . $aSettings['db_prefix'] . "configuration` (`id_configuration`, `id_shop_group`, `id_shop`, `name`, `value`, `date_add`, `date_upd`) VALUES (NULL, NULL, NULL, 'CONF_" . idealcheckout_escapeSql(strtoupper($aPaymentMethod['code'])) . "_FIXED_FOREIGN', '0.2', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "');";
					idealcheckout_database_execute($sql);

					$sql = "INSERT INTO `" . $aSettings['db_prefix'] . "configuration` (`id_configuration`, `id_shop_group`, `id_shop`, `name`, `value`, `date_add`, `date_upd`) VALUES (NULL, NULL, NULL, 'CONF_" . idealcheckout_escapeSql(strtoupper($aPaymentMethod['code'])) . "_VAR_FOREIGN', '2', '" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "');";
					idealcheckout_database_execute($sql);
				}

				$sql = "SELECT * FROM `" . $aSettings['db_prefix'] . "module` WHERE `name` = '" . idealcheckout_escapeSql($aPaymentMethod['code']) . "' LIMIT 1;";
				if(!idealcheckout_database_isRecord($sql))
				{
					$sql = "INSERT INTO `" . $aSettings['db_prefix'] . "module` (`id_module`, `name`, `active`, `version`) VALUES (NULL, '" . idealcheckout_escapeSql($aPaymentMethod['code']) . "', 1, '0.5');";
					idealcheckout_database_execute($sql);
				}
			}


			// Add orderstatus "Payment Pending"
			IDEALCHECKOUT_INSTALL::setLog('Adding order state "pending".', __FILE__, __LINE__);

			$sql = "SELECT * FROM `" . $aSettings['db_prefix'] . "order_state` WHERE (`id_order_state` = '1000') LIMIT 1;";
			if(!idealcheckout_database_isRecord($sql))
			{
				$sql = "INSERT INTO `" . $aSettings['db_prefix'] . "order_state` SET `id_order_state` = '1000', `invoice` = '1', `send_email` = '0', `color` = 'lightblue', `unremovable` = '1', `hidden` = '0', `logable` = '0', `delivery` = '0', `deleted` = '0';";
				idealcheckout_database_execute($sql);

				// Find languages
				$sql = "SELECT `id_lang`, `iso_code` FROM `" . $aSettings['db_prefix'] . "lang` ORDER BY `id_lang` ASC;";
				$rsLanguages = idealcheckout_database_getRecords($sql);

				foreach($rsLanguages as $aLanguage)
				{
					if(strcmp($aLanguage['iso_code'], 'nl') === 0)
					{
						$sql = "INSERT INTO `" . $aSettings['db_prefix'] . "order_state_lang` SET `id_order_state` = '1000', `id_lang` = '" . $aLanguage['id_lang'] . "', `name` = 'Wacht op betaling', `template` = 'payment';";
						idealcheckout_database_execute($sql);
					}
					else
					{
						$sql = "INSERT INTO `" . $aSettings['db_prefix'] . "order_state_lang` SET `id_order_state` = '1000', `id_lang` = '" . $aLanguage['id_lang'] . "', `name` = 'Awaiting payment', `template` = 'payment';";
						idealcheckout_database_execute($sql);
					}
				}
			}

			// Additional tips & instructions
			return true;
		}



		// Install plugin, return text
		public static function getInstructions($aSettings)
		{
			$sHtml = '';
			$sHtml .= '<ol>';
			$sHtml .= '<li>Log in op de beheeromgeving van uw webshop.</li>';
			$sHtml .= '<li>Ga naar Modules, en scroll naar "Payment".</li>';
			$sHtml .= '<li>Klik per gewenste betaalmethoden op de knop "install" om de betaalmethode in te schakelen.</li>';
			$sHtml .= '</ol>';

			return $sHtml;
		}
	}

?>