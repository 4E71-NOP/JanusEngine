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
class ExtensionFile {
	private $ExtensionFile = array ();
	public function __construct() {
	}
	public function getExtensionFileDataFromDB($id) {
		$cs = CommonSystem::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $cs->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ('extension_files') . "
			WHERE file_id = '" . $id . "'
			;" );
		if ( $cs->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for Extension_files id=".$id));
			while ( $dbp = $cs->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->ExtensionFile[$A] = $B; }
			}
		}
		else {
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for Extension_files id=".$id));
		}
		
	}

	//@formatter:off
	public function getExtensionFileEntry ($data) { return $this->ExtensionFile[$data]; }
	public function getExtensionFile() { return $this->ExtensionFile; }
	
	public function setExtensionFileEntry ($entry, $data) { 
		if ( isset($this->ExtensionFile[$entry])) { $this->ExtensionFile[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setExtensionFile($ExtensionFile) { $this->ExtensionFile = $ExtensionFile; }
	//@formatter:off

}


?>