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
class ExtensionDependency {
	private $ExtensionDependency = array ();
	public function __construct() {
	}
	public function getExtensionDependencyDataFromDB($id) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		$dbquery = $SDDMObj->query ( "
			SELECT *
			FROM " . $SqlTableListObj->getSQLTableName ('extension_dependency') . "
			WHERE dependency_id = '" . $id . "'
			;" );
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog(__METHOD__ . " : Loading data for Extension_Dependency id=".$id);
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->ExtensionDependency[$A] = $B; }
			}
		}
		else {
			$LMObj->InternalLog(__METHOD__ . " : No rows returned for Extension_Dependency id=".$id);
		}
		
	}

	//@formatter:off
	public function getExtensionDependencyEntry ($data) { return $this->ExtensionDependency[$data]; }
	public function getExtensionDependency() { return $this->ExtensionDependency; }
	
	public function setExtensionDependencyEntry ($entry, $data) { 
		if ( isset($this->ExtensionDependency[$entry])) { $this->ExtensionDependency[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setExtensionDependency($ExtensionDependency) { $this->ExtensionDependency = $ExtensionDependency; }
	//@formatter:off

}


?>