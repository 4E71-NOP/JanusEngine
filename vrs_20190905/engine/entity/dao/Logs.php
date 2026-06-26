<?php
// // @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see       : https://github.com/4E71-NOP/JanusEngine
//
// @license   : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author    : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note      : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//              without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end


class Logs {
	private $Logs = array ();
	public function __construct() {
	}
	public function getLogsDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;

		$dbquery = $bts->SDDMObj->query("SELECT "
			. "CONCAT('0x', HEX(log_id)) AS log_id, "
			. "CONCAT('0x', HEX(fk_ws_id)) AS fk_ws_id, "
			. "log_date, "
			. "log_initiator, "
			. "log_action, "
			. "log_signal, "
			. "log_msgid, "
			. "log_contenu "
			. "FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName('log') . " "
			. "WHERE log_id = " . $id
			. ";");
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for log id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->Logs[$A] = $B; }
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for log id=".$id));
			$res = false;
		}

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}

	//@formatter:off
	public function getLogsEntry ($data) { return $this->Logs[$data]; }
	public function getLogs() { return $this->Logs; }
	
	public function setLogsEntry ($entry, $data) { 
		if ( isset($this->Logs[$entry])) { $this->Logs[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setLogs($Logs) { $this->Logs = $Logs; }
	//@formatter:off

}


?>