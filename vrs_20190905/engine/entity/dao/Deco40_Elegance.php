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
class Deco40_Elegance {
	private $Deco40_Elegance = array ();
	public function __construct() {
	}
	public function getDeco40_EleganceDataFromDB($id) {
		$cs = CommonSystem::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $cs->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ('deco_40_elegance') . "
			WHERE deco_id = '" . $id . "'
			;" );
		if ( $cs->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for deco_40_elegance id=".$id));
			while ( $dbp = $cs->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$this->Deco40_Elegance[$dbp['deco_variable_name']] = $dbp['deco_value'];
			}
		}
		else {
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for deco_40_elegance id=".$id));
		}
		
	}

	//@formatter:off
	public function getDeco40_EleganceEntry ($data) { return $this->Deco40_Elegance[$data]; }
	public function getDeco40_Elegance() { return $this->Deco40_Elegance; }
	
	public function setDeco40_EleganceEntry ($entry, $data) { 
		if ( isset($this->Deco40_Elegance[$entry])) { $this->Deco40_Elegance[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setDeco40_Elegance($Deco40_Elegance) { $this->Deco40_Elegance = $Deco40_Elegance; }
	//@formatter:off

}


?>