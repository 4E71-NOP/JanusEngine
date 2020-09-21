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
class ExtensionConfig {
	private $ExtensionConfig = array ();
	public function __construct() {
	}
	public function getExtensionConfigDataFromDB($id) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		$dbquery = $SDDMObj->query ( "
			SELECT *
			FROM " . $SqlTableListObj->getSQLTableName ('extension_config') . "
			WHERE config_id = '" . $id . "'
			;" );
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => __METHOD__ . " : Loading data for extension_config id=".$id));
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->ExtensionConfig[$A] = $B; }
			}
		}
		else {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => __METHOD__ . " : No rows returned for extension_config id=".$id));
		}
		
	}

	//@formatter:off
	public function getExtensionConfigEntry ($data) { return $this->ExtensionConfig[$data]; }
	public function getExtensionConfig() { return $this->ExtensionConfig; }
	
	public function setExtensionConfigEntry ($entry, $data) { 
		if ( isset($this->ExtensionConfig[$entry])) { $this->ExtensionConfig[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setExtensionConfig($ExtensionConfig) { $this->ExtensionConfig = $ExtensionConfig; }
	//@formatter:off

}


?>