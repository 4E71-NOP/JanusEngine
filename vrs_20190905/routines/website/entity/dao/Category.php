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
class Category {
	private $Category = array ();
	
	public function __construct() {}
	
	/**
	 * Gets category data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the category selection to the website ID only. 
	 * @param integer $id
	 */
	public function getCategoryDataFromDB($id) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		$logTarget = $LMObj->getInternalLogTarget();
		$LMObj->setInternalLogTarget("both");
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		
		$dbquery = $dbquery = $SDDMObj->query("
			SELECT * 
			FROM ".$SqlTableListObj->getSQLTableName('categorie')." 
			WHERE cate_id = '".$id."'
			AND site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'
		;");
		
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog("Category/getCategoryDataFromDB() : Loading data for category id=".$id);
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->Category[$A] = $B; }
			}
		}
		else {
			$LMObj->InternalLog("Category/getCategoryDataFromDB() : No rows returned for category id=".$id);
		}
		
		$LMObj->setInternalLogTarget($logTarget);
	}
	
	//@formatter:off
	public function getCategoryEntry ($data) { return $this->Category[$data]; }
	public function getCategory() { return $this->Category; }
	
	public function setCategoryEntry ($entry, $data) { 
		if ( isset($this->Category[$entry])) { $this->Category[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setCategory($Category) { $this->Category = $Category; }
	//@formatter:off

}


?>