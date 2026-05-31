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

class Deco20_Caligraph {
	private $Deco20_Caligraph = array (
			"txt_font_dl_name" => null,
		);
	public function __construct() {
	}
	public function getDeco20_CaligraphDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
		
		$dbquery = $bts->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName ('deco_20_caligraph') . "
			WHERE fk_deco_id = '" . $id . "'
			;" );
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for deco_20_caligraph id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$this->Deco20_Caligraph[$dbp['deco_variable_name']] = $dbp['deco_value'];
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for deco_20_caligraph id=".$id));
			$res = false;
		}
		
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}

	//@formatter:off
	public function getDeco20_CaligraphEntry ($data) { return $this->Deco20_Caligraph[$data]; }
	public function getDeco20_Caligraph() { return $this->Deco20_Caligraph; }
	
	public function setDeco20_CaligraphEntry ($entry, $data) { 
		if ( isset($this->Deco20_Caligraph[$entry])) { $this->Deco20_Caligraph[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setDeco20_Caligraph($Deco20_Caligraph) { $this->Deco20_Caligraph = $Deco20_Caligraph; }
	//@formatter:off

}


?>