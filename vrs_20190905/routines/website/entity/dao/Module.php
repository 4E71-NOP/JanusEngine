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
class Module {
	private $Module = array ();
	
	public function __construct() {}
	
	/**
	 * Gets module data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the module selection to the website ID only. 
	 * @param integer $id
	 */
	public function getModuleDataFromDB($id) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		
		$dbquery = $dbquery = $SDDMObj->query("
			SELECT a.*,b.module_state
			FROM ".$SqlTableListObj->getSQLTableName('module')." a , ".$SqlTableListObj->getSQLTableName('module_website')." b
			WHERE a.module_id = '".$id."'
			AND a.module_id = b.module_id
			AND b.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
		;");
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog(__METHOD__ . " : Loading data for module id=".$id);
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->Module[$A] = $B; }
			}
		}
		else {
			$LMObj->InternalLog(__METHOD__ . " : No rows returned for module id=".$id);
		}
		
	}

	//@formatter:off
	public function getModuleEntry ($data) { return $this->Module[$data]; }
	public function getModule() { return $this->Module; }
	
	public function setModuleEntry ($entry, $data) { 
		if ( isset($this->Module[$entry])) { $this->Module[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setModule($Module) { $this->Module = $Module; }
	//@formatter:off

}


?>