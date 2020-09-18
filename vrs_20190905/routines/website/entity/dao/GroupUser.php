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
	public function getGroupUserDataFromDB($id) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		$dbquery = $SDDMObj->query ( "
			SELECT *
			FROM " . $SqlTableListObj->getSQLTableName ('groupe_user') . "
			WHERE group_user_id = '" . $id . "'
			;" );
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog(__METHOD__ . " : Loading data for groupe_user id=".$id);
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->GroupUser[$A] = $B; }
			}
		}
		else {
			$LMObj->InternalLog(__METHOD__ . " : No rows returned for groupe_user id=".$id);
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