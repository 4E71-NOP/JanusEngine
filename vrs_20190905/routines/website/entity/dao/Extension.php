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
class Extension {
	private $Extension = array ();
	public function __construct() {
	}
	public function getExtensionDataFromDB($id) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		$dbquery = $SDDMObj->query ( "
			SELECT *
			FROM " . $SqlTableListObj->getSQLTableName ('extension') . "
			WHERE extension_id = '" . $id . "'
			;" );
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => __METHOD__ . " : Loading data for extension id=".$id));
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->Extension[$A] = $B; }
			}
		}
		else {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => __METHOD__ . " : No rows returned for extension id=".$id));
		}
		
	}

	//@formatter:off
	public function getExtensionEntry ($data) { return $this->Extension[$data]; }
	public function getExtension() { return $this->Extension; }
	
	public function setExtensionEntry ($entry, $data) { 
		if ( isset($this->Extension[$entry])) { $this->Extension[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setExtension($Extension) { $this->Extension = $Extension; }
	//@formatter:off

}


?>