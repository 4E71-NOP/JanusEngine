<?php
/* Hydre-licence-debut */
// --------------------------------------------------------------------------------------------
//
// Hydre - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/* Hydre-licence-fin */
class Deco30_1Div {
	private $Deco30_1Div = array ();
	public function __construct() {
	}
	public function getDeco30_1DivDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
		
		$dbquery = $bts->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ('deco_30_1_div') . "
			WHERE fk_deco_id = '" . $id . "'
			;" );
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for deco_30_1_div id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$this->Deco30_1Div[$dbp['deco_variable_name']] = $dbp['deco_value'];
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for deco_30_1_div id=".$id));
			$res = false;
		}
		
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}

	//@formatter:off
	public function getDeco30_1DivEntry ($data) { return $this->Deco30_1Div[$data]; }
	public function getDeco30_1Div() { return $this->Deco30_1Div; }
	
	public function setDeco30_1DivEntry ($entry, $data) { 
		if ( isset($this->Deco30_1Div[$entry])) { $this->Deco30_1Div[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setDeco30_1Div($Deco30_1Div) { $this->Deco30_1Div = $Deco30_1Div; }
	//@formatter:off

}


?>