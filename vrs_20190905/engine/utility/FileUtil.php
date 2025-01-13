<?php
/*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/

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
