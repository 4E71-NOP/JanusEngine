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
class GroupUser {
	private $GroupUser = array ();
	public function __construct() {
	}
	public function getGroupUserDataFromDB($data) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$dbquery = $SDDMObj->query ( "" );
		while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
			foreach ( $dbp as $A => $B ) { $this->GroupUser [$A] = $B; }
		}
		
	}

	//@formatter:off
	public function getGroupUserEntry ($data) { return $this->GroupUser[$data]; }
	public function getGroupUser() { return $this->GroupUser; }
	
	public function setGroupUserEntry ($entry, $data) { 
		if ( isset($this->GroupUser[$entry])) { $this->GroupUser[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setGroupUser($GroupUser) { $this->GroupUser = $GroupUser; }
	//@formatter:off

}


?>