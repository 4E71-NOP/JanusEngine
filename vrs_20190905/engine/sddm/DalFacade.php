<?php
/* JanusEngine-license-start */
// --------------------------------------------------------------------------------------------
//
// Janus Engine - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/* JanusEngine-license-end */

/**
 * This class is a necessary facade to be able to reuse the code as much as possible. 
 * Interfaces and Abstract classes will NOT provide the desired level of reusabitlity.
 * SDDM as "Sql Database Dialog Management"
 * @author Faust
 *
 */
class DalFacade {
	private static $Instance = null;
	private $DALInstance = null;
	private function __construct() {
	}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return DalFacade
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new DalFacade ();
		}
		return self::$Instance;
	}
	
	/**
	 * Will load the desired class depending on configuration.
	 */
	public function createDALInstance () {
		$bts = BaseToolSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();				// Make sure it's loaded

		// Disconnects a pre-existing connection. We won't have multiple connections.
		if ( $this->DALInstance) {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . " : Pre-existing connetion found. Diconnecting..."));
			$this->DALInstance->disconnect_sql();
		}

		switch ( $bts->CMObj->getConfigurationEntry('dal')) {
			case "PHP" :
				switch ( $bts->CMObj->getConfigurationEntry('type')) {
					case "mysql":
							$ClassLoaderObj->provisionClass('SddmMySQLI');
							$this->DALInstance = SddmMySQLI::getInstance ();
							break;
					case "pgsql":
							$ClassLoaderObj->provisionClass('SddmPgsql');
							$this->DALInstance = SddmPgsql::getInstance();
					break;
				}
				break;
			case "PDO" :
				$ClassLoaderObj->provisionClass('SddmPDO');
				$this->DALInstance = SddmPDO::getInstance();
				break;
			case "SQLITE" :
				break;
			// case "ADODB" :
			// 	$ClassLoaderObj->provisionClass('SddmADODB');
			// 	$this->DALInstance = SddmADODB::getInstance();
			// 	break;
			// case "PEARDB" :
			// 	$ClassLoaderObj->provisionClass('SddmPEARDB');
			// 	$this->DALInstance = SddmPEARDB::getInstance();
			// 	break;
		}
		$this->DALInstance->connect();
	}
	
	/**
	 * Returns the current Database Abstraction Layer class instance. 
	 * @return SddmMySQLI|SddmPDO|SddmADODB|SddmPEARDB
	 */
	public function getDALInstance() {
		return $this->DALInstance;
	}
}
?>

