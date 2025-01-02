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
class Deco60_Elysion {
	private $Deco60_Elysion = array ();
	public function __construct() {
	}
	public function getDeco60_ElysionDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
		
		$dbquery = $bts->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName ('deco_60_elysion') . "
			WHERE fk_deco_id = '" . $id . "'
			;" );
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for deco_60_elysion id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$this->Deco60_Elysion[$dbp['deco_variable_name']] = $dbp['deco_value'];
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for deco_60_elysion id=".$id));
			$res = false;
		}
		
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}

	//@formatter:off
	public function getDeco60_ElysionEntry ($data) { return $this->Deco60_Elysion[$data]; }
	public function getDeco60_Elysion() { return $this->Deco60_Elysion; }
	
	public function setDeco60_ElysionEntry ($entry, $data) { 
		if ( isset($this->Deco60_Elysion[$entry])) { $this->Deco60_Elysion[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setDeco60_Elysion($Deco60_Elysion) { $this->Deco60_Elysion = $Deco60_Elysion; }
	//@formatter:off

}


?>