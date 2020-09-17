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
class StoredEvent {
	private $StoredEvent = array ();
	public function __construct() {
	}
	public function getStoredEventDataFromDB($id) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		$dbquery = $SDDMObj->query ( "
				SELECT *
				FROM " . $SqlTableListObj->getSQLTableName ('stored_event') . "
				WHERE stored_event_id = '" . $id . "'
				;" );
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog(__METHOD__ . " : Loading data for stored_event id=".$id);
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->StoredEvent[$A] = $B; }
			}
		}
		else {
			$LMObj->InternalLog(__METHOD__ . " : No rows returned for stored_event id=".$id);
		}
	
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