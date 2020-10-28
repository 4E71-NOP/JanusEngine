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
 * SDDM as "Sql Database Dialog Management"
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
		$cs = CommonSystem::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();				// Make sure it's loaded
		switch ( $cs->CMObj->getConfigurationEntry('dal')) {
			case "MYSQLI" :
				$ClassLoaderObj->provisionClass('SddmMySQLI');
				$this->DALInstance = SddmMySQLI::getInstance ();
				break;
			case "PDOMYSQL" :
				$ClassLoaderObj->provisionClass('SddmPDO');
				$this->DALInstance = SddmPDO::getInstance();
				break;
			case "SQLITE" :
				break;
			case "ADODB" :
				$ClassLoaderObj->provisionClass('SddmADODB');
				$this->DALInstance = SddmADODB::getInstance();
				break;
			case "PEARDB" :
				$ClassLoaderObj->provisionClass('SddmPEARDB');
				$this->DALInstance = SddmPEARDB::getInstance();
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

