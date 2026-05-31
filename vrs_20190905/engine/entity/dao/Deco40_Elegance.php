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

class Deco40_Elegance {
	private $Deco40_Elegance = array ();
	public function __construct() {
	}
	public function getDeco40_EleganceDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
		
		$dbquery = $bts->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName ('deco_40_elegance') . "
			WHERE fk_deco_id = '" . $id . "'
			;" );
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for deco_40_elegance id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$this->Deco40_Elegance[$dbp['deco_variable_name']] = $dbp['deco_value'];
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for deco_40_elegance id=".$id));
			$res = false;
		}
		
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
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