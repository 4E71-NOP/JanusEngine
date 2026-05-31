<?php
// @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see      : https://github.com/4E71-NOP/JanusEngine
//
// @license  : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author   : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note     : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//             without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end

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