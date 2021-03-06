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
		$cs = CommonSystem::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $cs->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ('group_user') . "
			WHERE group_user_id = '" . $id . "'
			;" );
		if ( $cs->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for group_user id=".$id));
			while ( $dbp = $cs->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->GroupUser[$A] = $B; }
			}
		}
		else {
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for group_user id=".$id));
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