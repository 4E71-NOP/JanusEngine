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
				
		$dbquery = $bts->SDDMObj->query ( "
				SELECT *
				FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ('stored_event') . "
				WHERE stored_event_id = '" . $id . "'
				;" );
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