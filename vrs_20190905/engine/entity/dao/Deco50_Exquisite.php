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
class Deco50_Exquisite {
	private $Deco50_Exquisite = array ();
	public function __construct() {
	}
	public function getDeco50_ExquisiteDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ('deco_50_exquisite') . "
			WHERE deco_id = '" . $id . "'
			;" );
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for deco_50_exquisite id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$this->Deco50_Exquisite[$dbp['deco_variable_name']] = $dbp['deco_value'];
			}
		}
		else {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for deco_50_exquisite id=".$id));
		}
		
	}

	//@formatter:off
	public function getDeco50_ExquisiteEntry ($data) { return $this->Deco50_Exquisite[$data]; }
	public function getDeco50_Exquisite() { return $this->Deco50_Exquisite; }
	
	public function setDeco50_ExquisiteEntry ($entry, $data) { 
		if ( isset($this->Deco50_Exquisite[$entry])) { $this->Deco50_Exquisite[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setDeco50_Exquisite($Deco50_Exquisite) { $this->Deco50_Exquisite = $Deco50_Exquisite; }
	//@formatter:off

}


?>