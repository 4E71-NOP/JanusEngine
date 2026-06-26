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



/**
 * Not yet used. Maybe something to remove.
 * @author faust
 *
 */
class StoredEvent {
	private $StoredEvent = array ();
	public function __construct() {
	}
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
				
		$dbquery = $bts->SDDMObj->query ("SELECT "
			. "CONCAT('0x', HEX(stored_event_id)) AS stored_event_id, "
			. "stored_event_date, "
			. "stored_event_object, "
			. "stored_event_type "
			. "FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName ('stored_event') . " "
			. "WHERE stored_event_id = " . $id
			. ";" );
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for stored_event id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->StoredEvent[$A] = $B; }
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for stored_event id=".$id));
			$res = false;
		}

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}
	
	//@formatter:off
	public function getStoredEventEntry ($data) { return $this->StoredEvent[$data]; }
	public function getStoredEvent() { return $this->StoredEvent; }
	
	public function setStoredEventEntry ($entry, $data) { 
		if ( isset($this->StoredEvent[$entry])) { $this->StoredEvent[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setStoredEvent($StoredEvent) { $this->StoredEvent = $StoredEvent; }
	//@formatter:off

}


?>