<?php
/* Hydre-licence-debut */
// --------------------------------------------------------------------------------------------
//
// Hydre - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@club-internet.fr
//
// --------------------------------------------------------------------------------------------
/* Hydre-licence-fin */

/**
 * 
 * @author Faust
 * This class is a necessary pseudo-facade to be able to reuse the code as much as possible. 
 * Interfaces and Abstract classes will NOT provide the desired level of reusabitlity.
 *
 */
class DalFacade {
	private static $Instance = null;
	private $DALInstance = null;
	private function __construct() {
	}

	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new DalFacade ();
		}
		return self::$Instance;
	}
	
	public function createDALInstance () {
		$ClassLoaderObj = ClassLoader::getInstance();
		
		$CMobj = ConfigurationManagement::getInstance ();
		switch ( $CMobj->getConfigurationEntry('dal')) {
			case "MYSQLI" :
				$ClassLoaderObj->provisionClass('SddmMySQLI');
				$this->DALInstance = SddmMySQLI::getInstance ();
// 				include ("routines/website/sddm/SddmMySQLI.php");
				break;
			case "PDOMYSQL" :
				$ClassLoaderObj->provisionClass('SddmPDO');
				$this->DALInstance = SddmPDO::getInstance();
// 				include ("routines/website/sddm/SddmPDO.php");
				break;
			case "SQLITE" :
				break;
			case "ADODB" :
				$ClassLoaderObj->provisionClass('SddmADODB');
				$this->DALInstance = SddmADODB::getInstance();
// 				include ("routines/website/sddm/SddmADODB.php");
				break;
			case "PEARDB" :
				$ClassLoaderObj->provisionClass('SddmPEARDB');
				$this->DALInstance = SddmPEARDB::getInstance();
// 				include ("routines/website/sddm/SddmPEARDB.php");
				break;
			case "PEARSQLITE" :
				break;
		}
		$this->DALInstance->connect ();
	}
	
	public function getDALInstance() {
		return $this->DALInstance;
	}

}

?>

