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
class Article {
	private $Article = array ();
	
	public function __construct() {}
	
	/**
	 * Gets article data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the article selection to the website ID only.
	 * @param integer $id
	 */
	public function getArticleDataFromDB($ref, $page) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		
		$dbquery = $dbquery = $SDDMObj->query("
			SELECT *
			FROM ".$SqlTableListObj->getSQLTableName('article')."
			WHERE arti_ref = '".$ref."'
			AND arti_page = '".$page."'
			AND site_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
			;");
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog(__METHOD__ . " : Loading data for article id=".$ref."/".$page);
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->Article[$A] = $B; }
			}
		}
		else {
			$LMObj->InternalLog(__METHOD__ . " : No rows returned for article id=".$ref."/".$page);
		}
		
	}
	
	
	//@formatter:off
	public function getArticleEntry ($data) { return $this->Article[$data]; }
	public function getArticle() { return $this->Article; }
	
	public function setArticleEntry ($entry, $data) { 
		if ( isset($this->Article[$entry])) { $this->Article[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setArticle($Article) { $this->Article = $Article; }
	//@formatter:off

}


?>