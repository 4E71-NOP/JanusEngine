<?php
// @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see      : https://github.com/4E71-NOP/JanusEngine
//
// @license  : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author   : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note     : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//             without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end


class FileUtil
{
	private static $Instance = null;

	public function __construct() {}

	/**
	 * Singleton : Will return the instance of this class.
	 * @return FileUtil
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new FileUtil();
		}
		return self::$Instance;
	}

	public function Exists($filename) {}

	public function getFileContent($filename)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		if (file_exists($filename)) {
			$fileHandle = fopen($filename, "r");
			$fileData = fread($fileHandle, filesize($filename));
			fclose($fileHandle);

			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : File loaded"));
			return ($fileData);
		} else {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : File '" . $filename . "' doesn't exist. From pwd = '" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('currentDirectory') . "'"));
			return (false);
		}
	}
}
