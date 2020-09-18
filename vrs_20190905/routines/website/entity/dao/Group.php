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
class Group {
	private $Group = array ();
	
	public function __construct() {}
	
	/**
	 * Gets group data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the group selection to the website ID only.
	 * @param integer $id
	 */
	public function getGroupDataFromDB($id) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		
		$dbquery = $dbquery = $SDDMObj->query("
			SELECT grp.* 
			FROM ".$SqlTableListObj->getSQLTableName('groupe')." grp , ".$SqlTableListObj->getSQLTableName('group_website')." sg
			WHERE grp.group_id = '".$id."'
			AND grp.group_id = sg.group_id
			AND sg.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
		;");
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog(__METHOD__ . " : Loading data for group id=".$id);
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->Group[$A] = $B; }
			}
		}
		else {
			$LMObj->InternalLog(__METHOD__ . " : No rows returned for group id=".$id);
		}
		
	}

	//@formatter:off
	public function getGroupEntry ($data) { return $this->Group[$data]; }
	public function getGroup() { return $this->Group; }
	
	public function setGroupEntry ($entry, $data) { 
		if ( isset($this->Group[$entry])) { $this->Group[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setGroup($Group) { $this->Group = $Group; }
	//@formatter:off

}


?>