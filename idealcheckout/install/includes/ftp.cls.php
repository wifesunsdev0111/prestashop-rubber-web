<?php

/*
		Description:   FTP class for easy communication with webservers

		Author:        PHP Solutions Meppel (NL / The Netherlands)
		Website:       http://www.php-solutions.nl
		E-mail:        info@php-solutions.nl

		Licence:       This library is created and copyrighted by PHP Solutions Meppel.
		               You are not allowed to (partially) use, alter or share this code without 
		               explicit authorization of the author.
*/

	class clsFtp
	{
		protected $oConnection = null;

		public function connect($sHostname, $sUsername = false, $sPassword = false, $iPortNumber = false, $bPassiveMode = false, $bIgnoreError = false)
		{
			$aHostname = parse_url($sHostname);

			if(!empty($aHostname['host']))
			{
				$sFtpAddress = $aHostname['host'];
			}
			elseif(!empty($aHostname['path']))
			{
				$sFtpAddress = $aHostname['path'];
			}
			else
			{
				$sFtpAddress = $sHostname;
			}

			if($iPortNumber === false)
			{
				if(!empty($aHostname['port']))
				{
					$iPortNumber = intval($aHostname['port']);
				}
				else
				{
					$iPortNumber = 21;
				}
			}

			if($this->oConnection = @ftp_connect($sFtpAddress, $iPortNumber, 30))
			{
				@set_time_limit(3600); // Working with FTP requires extra processing time

				if(($sUsername !== false) && ($sPassword !== false))
				{
					if(@ftp_login($this->oConnection, $sUsername, $sPassword))
					{
						// Login success
						if($bPassiveMode)
						{
							@ftp_pasv($this->oConnection, true);
						}
					}
					elseif($bIgnoreError === false)
					{
						echo '<b>FTP Error</b><br>Hostname: ' . $sFtpAddress . ':' . $iPortNumber . '<br>Username: ' . $sUsername . '<br>Password: ********<br>Error: Login error - Invalid username and/or password.';
						exit;
					}
					else
					{
						$this->disconnect();
						return false;
					}
				}
			}
			elseif($bIgnoreError === false)
			{
				echo '<b>FTP Error</b><br>Hostname: ' . $sFtpAddress . '<br>Username: ' . $sUsername . '<br>Password: ********<br>Error: Connection error - Can\'t find hostname.';
				exit;
			}
			else
			{
				return false;
			}

			return $this->oConnection;
		}

		public function disconnect()
		{
			if($this->oConnection === false)
			{
				return false;
			}

			if(@ftp_close($this->oConnection))
			{
				$this->oConnection = false;
			}

			return true;
		}

		public function isConnected()
		{
			if($this->oConnection)
			{
				return true;
			}

			return false;
		}

		public function getRemotePath()
		{
			if($this->oConnection === false)
			{
				return false;
			}

			return @ftp_pwd($this->oConnection);
		}

		// Try to detect root folders: httpdocs, htdocs, public_html, private_html, web, or www folder
		public function getRootPaths($sPath = false, $sDetectPath = false, $iDepth = 3)
		{
			if($sPath === false)
			{
				$sPath = $this->getRemotePath();
			}

			list($aFiles, $aFolders) = $this->getFilesAndFolders($sPath, false, false);

			if($sDetectPath)
			{
				$iDetectPath = (0 - strlen($sDetectPath));

				foreach($aFiles as $sFile)
				{
					$_sPath = self::addSlash($sPath) . $sFile;

					if(strcasecmp($sDetectPath, substr($_sPath, $iDetectPath)) === 0)
					{
						return array(self::removeSlash(substr($_sPath, 0, $iDetectPath)));
					}
				}

				foreach($aFolders as $sFolder)
				{
					$_sPath = self::addSlash($sPath) . $sFolder;
					
					if(strcasecmp($sDetectPath, substr($_sPath, $iDetectPath)) === 0)
					{
						return array(self::removeSlash(substr($_sPath, 0, $iDetectPath)));
					}
				}
			}
			else
			{
				if(in_array('index.php', $aFiles))
				{
					return array($sPath);
				}
				elseif(in_array('index.html', $aFiles))
				{
					return array($sPath);
				}
				elseif(in_array('public_html', $aFolders))
				{
					return array(self::addSlash($sPath) . 'public_html');
				}
				elseif(in_array('private_html', $aFolders))
				{
					return array(self::addSlash($sPath) . 'private_html');
				}
				elseif(in_array('httpdocs', $aFolders))
				{
					return array(self::addSlash($sPath) . 'httpdocs');
				}
				elseif(in_array('htdocs', $aFolders))
				{
					return array(self::addSlash($sPath) . 'htdocs');
				}
				elseif(in_array('web', $aFolders))
				{
					return array(self::addSlash($sPath) . 'web');
				}
				elseif(in_array('www', $aFolders))
				{
					return array(self::addSlash($sPath) . 'www');
				}
			}

			$aMatches = array(); 

			if($iDepth > 0)
			{
				foreach($aFolders as $sFolder)
				{
					$aRootPaths = $this->getRootPaths(self::addSlash($sPath) . $sFolder, $sDetectPath, $iDepth - 1);

					if(is_array($aRootPaths) && sizeof($aRootPaths))
					{
						foreach($aRootPaths as $v)
						{
							$aMatches[] = $v;
						}
					}
				}
			}


			return $aMatches;
		}

		// Try to detect httpdocs, public_html, web, or www folder
		public function getRootPath($sPath = false)
		{
			$aRootPaths = $this->getRootPaths($sPath);

			if(sizeof($aRootPaths) === 1)
			{
				return $aRootPaths[0];
			}

			return false;
		}

		public function findRemotePath($sLocalPath)
		{
			$sRemotePath = $this->getRemotePath();

			// Cleanup paths
			$iRemoteOffset = strpos($sRemotePath, ':\\');
			$iLocalOffset = strpos($sLocalPath, ':\\');

			if($iRemoteOffset !== $iLocalOffset)
			{
				if($iRemoteOffset !== false) // Windows path
				{
					$sRemotePath = substr($sRemotePath, $iRemoteOffset);
				}

				if($iLocalOffset !== false) // Windows path
				{
					$sLocalPath = substr($sLocalPath, $iLocalOffset);
				}
			}

			$sRemotePath = str_replace('\\', '/', $sRemotePath);
			$sLocalPath = str_replace('\\', '/', $sLocalPath);

			$aLocalPath = explode('/', $sLocalPath);

			if($sRemotePath != '/')
			{
				$iOffset = strpos($sLocalPath, $sRemotePath);

				if($iOffset !== false)
				{
					return substr($sLocalPath, $iOffset);
				}
			}
			else
			{
				list($aFiles, $aFolders) = $this->getFilesAndFolders($sRemotePath, false, false);

				foreach($aFolders as $k => $v)
				{
					$iOffset = strpos($sLocalPath, $sRemotePath . $v);

					if($iOffset !== false)
					{
						return substr($sLocalPath, $iOffset);
					}
				}

				foreach($aFiles as $k => $v)
				{
					$iOffset = strpos($sLocalPath, $sRemotePath . $v);

					if($iOffset !== false)
					{
						return substr($sLocalPath, $iOffset);
					}
				}
			}

			return false;
		}

		public function setRemotePath($sRemotePath)
		{
			if($this->oConnection === false)
			{
				return false;
			}

			return @ftp_chdir($this->oConnection, $sRemotePath);
		}

		// Retrieve all files & folders at given $sRemotePath
		public function getFilesAndFolders($sRemotePath = false, $bExtended = false, $bShowHidden = true)
		{
			$bDebug = false; // (strpos($sRemotePath, 'idealcheckout') !== false);
			$aMonths = array('Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4, 'May' => 5, 'Jun' => 6, 'Jul' => 7, 'Aug' => 8, 'Sep' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12);

			if($sRemotePath === false)
			{
				$sRemotePath = $this->getRemotePath();
			}

			$aFiles = array();
			$aFolders = array();

			$sRemotePath = self::removeSlash($sRemotePath);
			$aLines = @ftp_rawlist($this->oConnection, $sRemotePath);
			$i = 0;

if($bDebug)
{
	echo "<br>\n";
	print_r($sRemotePath);
	echo "<br>\n" . 'DEBUG: ' . __FILE__ . ' : ' . __LINE__ . "<br>\n";
	print_r($aLines);
}

			if(is_array($aLines) && sizeof($aLines))
			{
				foreach($aLines as $sLine)
				{
					$aMatch = preg_split('/([\s]+)/', $sLine, 9);

					if(substr($aMatch[0], 0, 1) == 'd')
					{
						if(!in_array($aMatch[8], array('.', '..')) && ($bShowHidden || !in_array(substr($aMatch[8], 0, 1), array('.', '-', '_'))))
						{
							if($bExtended)
							{
								$oDate = mktime(0, 0, 0, intval($aMonths[$aMatch[5]]), intval($aMatch[6]), intval($aMatch[7]));

								$iChmod = self::getChmod(substr($aMatch[0], 1));
								$sChmod = decoct($iChmod);
								$sChmod = str_repeat('0', 4 - strlen($sChmod)) . $sChmod;

								$aFolders[] = array('name' => $aMatch[8], 'path' => self::addSlash($sRemotePath) . $aMatch[8], 'size' => $aMatch[4], 'date' => $oDate, 'chmod' => $iChmod, 'chmod_octaal' => $sChmod, 'chmod_text' => substr($aMatch[0], 1));
							}
							else
							{
								$aFolders[] = $aMatch[8];
							}
						}
					}
					elseif(substr($aMatch[0], 0, 1) == '-')
					{
						if($bShowHidden || !in_array(substr($aMatch[8], 0, 1), array('.', '-', '_')))
						{
							if($bExtended)
							{
								$oDate = mktime(0, 0, 0, intval($aMonths[$aMatch[5]]), intval($aMatch[6]), intval($aMatch[7]));

								$iChmod = self::getChmod(substr($aMatch[0], 1));
								$sChmod = decoct($iChmod);
								$sChmod = str_repeat('0', 4 - strlen($sChmod)) . $sChmod;

								$aFiles[] = array('name' => $aMatch[8], 'path' => self::addSlash($sRemotePath) . $aMatch[8], 'size' => $aMatch[4], 'date' => $oDate, 'chmod' => $iChmod, 'chmod_octaal' => $sChmod, 'chmod_text' => substr($aMatch[0], 1));
							}
							else
							{
								$aFiles[] = $aMatch[8];
							}
						}
					}
				}
			}

			return array($aFiles, $aFolders);
		}

		// Retrieve all files at given $sRemotePath
		public function getFiles($sRemotePath, $bExtended = false, $bShowHidden = true)
		{
			$aMonths = array('Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4, 'May' => 5, 'Jun' => 6, 'Jul' => 7, 'Aug' => 8, 'Sep' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12);

			$aFiles = array();

			$sRemotePath = self::removeSlash($sRemotePath);
			$aLines = ftp_rawlist($this->oConnection, $sRemotePath);
			$i = 0;

			if(sizeof($aLines))
			{
				foreach($aLines as $sLine)
				{					
					$aMatch = preg_split('/([\s]+)/', $sLine, 9);

					if(substr($aMatch[0], 0, 1) == '-')
					{
						if($bShowHidden || !in_array(substr($aMatch[8], 0, 1), array('.', '-', '_')))
						{
							if($bExtended)
							{
								$oDate = mktime(0, 0, 0, intval($aMonths[$aMatch[5]]), intval($aMatch[6]), intval($aMatch[7]));

								$iChmod = self::getChmod(substr($aMatch[0], 1));
								$sChmod = decoct($iChmod);
								$sChmod = str_repeat('0', 4 - strlen($sChmod)) . $sChmod;

								$aFiles[] = array('name' => $aMatch[8], 'path' => self::addSlash($sRemotePath) . $aMatch[8], 'size' => $aMatch[4], 'date' => $oDate, 'chmod' => $iChmod, 'chmod_octaal' => $sChmod, 'chmod_text' => substr($aMatch[0], 1));
							}
							else
							{
								$aFiles[] = $aMatch[8];
							}
						}
					}
				}
			}

			return $aFiles;
		}

		// Retrieve all folders at given $sRemotePath
		public function getFolders($sRemotePath, $bExtended = false, $bShowHidden = true)
		{
			$aMonths = array('Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4, 'May' => 5, 'Jun' => 6, 'Jul' => 7, 'Aug' => 8, 'Sep' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12);

			$aFolders = array();

			$sRemotePath = self::removeSlash($sRemotePath);
			$aLines = ftp_rawlist($this->oConnection, $sRemotePath);
			$i = 0;

			if(sizeof($aLines))
			{
				foreach($aLines as $sLine)
				{					
					$aMatch = preg_split('/([\s]+)/', $sLine, 9);

					if(substr($aMatch[0], 0, 1) == 'd')
					{
						if(!in_array($aMatch[8], array('.', '..')) && ($bShowHidden || !in_array(substr($aMatch[8], 0, 1), array('.', '-', '_'))))
						{
							if($bExtended)
							{
								$oDate = mktime(0, 0, 0, intval($aMonths[$aMatch[5]]), intval($aMatch[6]), intval($aMatch[7]));

								$iChmod = self::getChmod(substr($aMatch[0], 1));
								$sChmod = decoct($iChmod);
								$sChmod = str_repeat('0', 4 - strlen($sChmod)) . $sChmod;

								$aFolders[] = array('name' => $aMatch[8], 'path' => self::addSlash($sRemotePath) . $aMatch[8], 'size' => $aMatch[4], 'date' => $oDate, 'chmod' => $iChmod, 'chmod_octaal' => $sChmod, 'chmod_text' => substr($aMatch[0], 1));
							}
							else
							{
								$aFolders[] = $aMatch[8];
							}
						}
					}
				}
			}

			return $aFolders;
		}

		// Create a new folder
		public function createFolder($sRemotePath, $iChmod = 0755)
		{
			if($this->oConnection === false)
			{
				return false;
			}

			$bResult = true;

			if(@ftp_chdir($this->oConnection, $sRemotePath))
			{
				// Folder exists, do nothing
			}
			else
			{
				$aPath = explode('/', $sRemotePath);
				$sFolderPath = '';

				foreach($aPath as $sFolderName)
				{
					if(!empty($sFolderName))
					{
						$sFolderPath .= '/' . $sFolderName;

						if(@ftp_chdir($this->oConnection, $sFolderPath))
						{
							// Folder exists
						}
						else
						{
							if(@ftp_mkdir($this->oConnection, $sFolderName))
							{
								if($iChmod !== false)
								{
									@ftp_chmod($this->oConnection, $iChmod, $sFolderName);
								}

								@ftp_chdir($this->oConnection, $sFolderName);
							}
							else
							{
								$bResult = false;
								break;
							}
						}
					}
				}
			}

			return $bResult;
		}

		// Create a new file
		public function createFile($sRemotePath, $sData = '', $iFileChmod = 0644, $iFolderChmod = 0755)
		{
			if($this->oConnection === false)
			{
				return false;
			}

			$bResult = false;

			if($this->createFolder(self::getPathFolder($sRemotePath), $iFolderChmod))
			{
				$oFile = tmpfile();
				fwrite($oFile, $sData);
				rewind($oFile);

				if(ftp_fput($this->oConnection, $sRemotePath, $oFile, FTP_BINARY, 0))
				{
					@ftp_chmod($this->oConnection, $iFileChmod, $sRemotePath);
					$bResult = true;
				}
			}

			return $bResult;
		}

		// Upload a file
		public function uploadFile($sLocalPath, $sRemotePath = '', $iFileChmod = 0644, $iFolderChmod = 0755)
		{
			if($this->oConnection === false)
			{
				return false;
			}

			if(is_file($sLocalPath) === false)
			{
				return false;
			}

			// No file extension found, add local filename to remote path
			if(strpos(basename($sRemotePath), '.') === false)
			{
				$sRemotePath .= '/' . basename($sLocalPath);
			}

			$bResult = false;

			if($this->createFolder(dirname($sRemotePath), $iFolderChmod))
			{
				if(ftp_put($this->oConnection, $sRemotePath, $sLocalPath, FTP_BINARY))
				{
					@ftp_chmod($this->oConnection, $iFileChmod, $sRemotePath);
					$bResult = true;
				}
			}

			return $bResult;
		}

		public function uploadFolder($sLocalPath, $sRemotePath = '', $iFileChmod = 0644, $iFolderChmod = 0755, $iTimestamp = false, $_bInit = true)
		{
			if($_bInit)
			{
				// echo ('Creating folder: "' . $sRemotePath . '"' . "<br>\n");
				$this->createFolder($sRemotePath);
			}

			list($aFiles, $aFolders) = clsFolder::getFilesAndFolders($sLocalPath);

			foreach($aFolders as $sFolder)
			{
				// echo ('Creating folder: "' . $sRemotePath . '/' . $sFolder . '"' . "<br>\n");
				if($this->createFolder($sRemotePath . '/' . $sFolder))
				{
					$this->uploadFolder($sLocalPath . '/' . $sFolder, $sRemotePath . '/' . $sFolder, $iFileChmod, $iFolderChmod, $iTimestamp, false);
				}
				else
				{
					die('Cannot create folder: "' . $sRemotePath . '/' . $sFolder . '"');
				}
			}

			foreach($aFiles as $sFile)
			{
				if($iTimestamp && (clsFile::getTime($sLocalPath . '/' . $sFile) < $iTimestamp))
				{
					continue;
				}

				if($this->uploadFile($sLocalPath . '/' . $sFile, $sRemotePath . '/' . $sFile, $iFileChmod, $iFolderChmod))
				{
					// Success
					// echo ('Uploading file: "' . $sLocalPath . '/' . $sFile . '"' . "<br>\n");
				}
				else
				{
					die('Cannot upload file: "' . $sLocalPath . '/' . $sFile . '" to "' . $sRemotePath . '/' . $sFile . '"');
				}
			}
		}

		public function isFile($sRemotePath)
		{
			if($this->oConnection === false)
			{
				return false;
			}

			$sFileName = basename($sRemotePath);
			$sFolderPath = dirname($sRemotePath);

			if(@ftp_chdir($this->oConnection, $sFolderPath))
			{
				$aFiles = $this->getFiles($sFolderPath);

				if(is_array($aFiles) && in_array($sFileName, $aFiles))
				{
					return true;
				}
			}

			return false;
		}

		public function isFolder($sRemotePath)
		{
			if($this->oConnection === false)
			{
				return false;
			}

			if(@ftp_chdir($this->oConnection, $sRemotePath))
			{
				return true;
			}

			return false;
		}

		public function downloadFile($sRemotePath, $sLocalPath)
		{
			if($this->oConnection === false)
			{
				return false;
			}

			// No file extension found, add local filename to remote path
			if(strpos(basename($sLocalPath), '.') === false)
			{
				$sRemotePath .= '/' . basename($sRemotePath);
			}

			$bResult = false;

			if(clsFolder::create(dirname($sLocalPath)))
			{
				@unlink($sLocalPath);

				if(ftp_get($this->oConnection, $sLocalPath, $sRemotePath, FTP_BINARY))
				{
					@chmod($sLocalPath, 0777);
					$bResult = true;
				}
			}

			return $bResult;
		}

		public function downloadFolder($sRemotePath, $sLocalPath, $iTimestamp = false, $_bInit = true)
		{
			if($_bInit)
			{
				// echo ('Creating folder: "' . $sLocalPath . '"' . "<br>\n");
				if(!clsFolder::create($sLocalPath))
				{
					die('Cannot create folder: "' . $sLocalPath . '"');
				}
			}

			list($aFiles, $aFolders) = $this->getFilesAndFolders($sRemotePath, false);

			foreach($aFolders as $sFolder)
			{
				$this->downloadFolder($sRemotePath . '/' . $sFolder, $sLocalPath . '/' . $sFolder, $iTimestamp, false);
			}

			foreach($aFiles as $sFile)
			{
				if($iTimestamp && (clsFile::getTime($sLocalPath . '/' . $sFile) < $iTimestamp))
				{
					continue;
				}

				if($this->downloadFile($sRemotePath . '/' . $sFile, $sLocalPath . '/' . $sFile))
				{
					// Success
					// echo ('Downloading file: "' . $sRemotePath . '/' . $sFile . '" to "' . $sLocalPath . '/' . $sFile . '"' . "<br>\n");
				}
				else
				{
					die('Cannot download file: "' . $sRemotePath . '/' . $sFile . '" to "' . $sLocalPath . '/' . $sFile . '"');
				}
			}
		}

		public function setChmod($sRemotePath, $iChmod = 777, $bRecursive = true)
		{
			if($this->oConnection === false)
			{
				return false;
			}

			if(@ftp_chdir($this->oConnection, $iChmod, $sRemotePath))
			{
				if($bRecursive) // Treat as folder
				{
					$a = explode('/', $sRemotePath);
					$sFolderName = array_pop($a);

					if(strpos($sFolderName, '.') === false)
					{
						list($aFiles, $aFolders) = $this->getFilesAndFolders($sRemotePath);

						foreach($aFiles as $k => $v)
						{
							$this->setChmod($sRemotePath . '/' . $v, $iChmod);
						}

						foreach($aFolders as $k => $v)
						{
							$this->setChmod($sRemotePath . '/' . $v, $iChmod);
						}
					}
				}

				return true;
			}

			return false;
		}

		public function deleteFile($sRemotePath)
		{
			if($this->oConnection === false)
			{
				return false;
			}

			return @ftp_delete($this->oConnection, $sRemotePath);
		}

		public function deleteFolder($sRemotePath)
		{
			if($this->oConnection === false)
			{
				return false;
			}

			list($aFiles, $aFolders) = $this->getFilesAndFolders($sRemotePath);

			// Remove inner files
			foreach($aFiles as $k => $v)
			{
				$this->deleteFile($sRemotePath . '/' . $v);
			}

			// Remove inner folders
			foreach($aFolders as $k => $v)
			{
				$this->deleteFolder($sRemotePath . '/' . $v);
			}

			return @ftp_rmdir($this->oConnection, $sRemotePath);
		}

		public static function test($sHostname, $sUsername = false, $sPassword = false, $iPortNumber = false, $bPassiveMode = false)
		{
			if($sHostname && $sUsername && $sPassword && $iPortNumber)
			{
				$oFtp = new clsFtp();

				if($oFtp->connect($sHostname, $sUsername, $sPassword, $iPortNumber, $bPassiveMode, true))
				{
					$oFtp->disconnect();
					return true;
				}
			}

			return false;
		}

		// Parse string 'rwxrwxrwx' to integer '511' (Octaal: 0777).
		public static function getChmod($sChmod)
		{
			$a = str_split($sChmod, 1);
			$aChmod = array(0, 0, 0);

			if($a[0] == 'r')
			{
				$aChmod[0] += 4;
			}

			if($a[1] == 'w')
			{
				$aChmod[0] += 2;
			}

			if($a[2] == 'x')
			{
				$aChmod[0] += 1;
			}

			if($a[3] == 'r')
			{
				$aChmod[1] += 4;
			}

			if($a[4] == 'w')
			{
				$aChmod[1] += 2;
			}

			if($a[5] == 'x')
			{
				$aChmod[1] += 1;
			}

			if($a[6] == 'r')
			{
				$aChmod[2] += 4;
			}

			if($a[7] == 'w')
			{
				$aChmod[2] += 2;
			}

			if($a[8] == 'x')
			{
				$aChmod[2] += 1;
			}

			return (($aChmod[0] * 64) + ($aChmod[1] * 8) + $aChmod[2]);
		}

		public static function addSlash($sPath)
		{
			if(!in_array(substr($sPath, -1, 1), array('\\', '/', '')))
			{
				$sPath .= ((strpos($sPath, '/') === false) ? '\\' : '/'); // Add UNIX or WINDOWS slash
			}

			return $sPath;
		}

		public static function removeSlash($sPath)
		{
			if(in_array(substr($sPath, -1, 1), array('\\', '/')))
			{
				$sPath = substr($sPath, 0, -1);
			}

			return $sPath;
		}

		public static function getPathFolder($sPath)
		{
			$a = explode('/', str_replace('\\', '/', $sPath));
			$l = strlen($a[sizeof($a) - 1]) + 1;
			return substr($sPath, 0, 0 - $l);
		}

		public static function getPathName($sPath)
		{
			$a = explode('/', str_replace('\\', '/', $sPath));
			return $a[sizeof($a) - 1];
		}
	}

?>