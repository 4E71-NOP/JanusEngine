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
class Notice {
	private $Notice = array ();
	public function __construct() {
	}
	public function getNoticeDataFromDB($data) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$dbquery = $SDDMObj->query ( "" );
		while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
			foreach ( $dbp as $A => $B ) { $this->Notice [$A] = $B; }
		}
		
	}

	//@formatter:off
	public function getNoticeEntry ($data) { return $this->Notice[$data]; }
	public function getNotice() { return $this->Notice; }
	
	public function setNoticeEntry ($entry, $data) { 
		if ( isset($this->Notice[$entry])) { $this->Notice[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setNotice($Notice) { $this->Notice = $Notice; }
	//@formatter:off

}


?>