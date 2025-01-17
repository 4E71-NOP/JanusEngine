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

class FileContent {
	private static $Instance = null;
	private $fileContent = null;

	public function __construct() {}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return FileContent
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new FileContent ();
		}
		return self::$Instance;
	}
	
   	//@formatter:off
    public function getFileContent (){return ($this->fileContent); }
    public function setFileContent ($data){$this->fileContent = $data; }
	//@formatter:on



}
?>
