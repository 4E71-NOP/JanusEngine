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
class DeadLine {
	private $DeadLine = array ();
	
	public function __construct() {}
	
	/**
	 * Gets deadline data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the deadline selection to the website ID only.
	 * @param integer $id
	 */
	public function getDeadLineDataFromDB($id) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		
		$dbquery = $dbquery = $SDDMObj->query("
		SELECT bcl.*,usr.user_login
		FROM ".$SqlTableListObj->getSQLTableName('bouclage')." bcl , ".$SqlTableListObj->getSQLTableName('user')." usr
		WHERE ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
		AND usr.user_id = bcl.user_id
		AND bouclage_id ='".$id."'
		;");
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog(__METHOD__ . " : Loading data for deadline id=".$id);
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->DeadLine[$A] = $B; }
			}
		}
		else {
			$LMObj->InternalLog(__METHOD__ . " : No rows returned for deadline id=".$id);
		}
		
	}

	//@formatter:off
	public function getDeadLineEntry ($data) { return $this->DeadLine[$data]; }
	public function getDeadLine() { return $this->DeadLine; }
	
	public function setDeadLineEntry ($entry, $data) { 
		if ( isset($this->DeadLine[$entry])) { $this->DeadLine[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setDeadLine($DeadLine) { $this->DeadLine = $DeadLine; }
	//@formatter:off

}


?>