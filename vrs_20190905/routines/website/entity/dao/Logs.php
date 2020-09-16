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
class Logs {
	private $Logs = array ();
	public function __construct() {
	}
	public function getLogsDataFromDB($data) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$dbquery = $SDDMObj->query ( "" );
		while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
			foreach ( $dbp as $A => $B ) { $this->Logs [$A] = $B; }
		}
		
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