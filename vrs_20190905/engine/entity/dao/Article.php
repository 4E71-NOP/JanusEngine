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
	
// 	public function __construct() {}
	
	/**
	 * Gets article data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the article selection to the website ID only.
	 * @param integer $ref
	 * @param integer $page
	 */
	public function getArticleDataFromDB($ref, $page) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $dbquery = $bts->SDDMObj->query("
			SELECT *
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('article')."
			WHERE arti_ref = '".$ref."'
			AND arti_page = '".$page."'
			AND ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
			;");
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for article arti_ref=".$ref."/".$page));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->Article[$A] = $B; }
			}
		}
		else {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for article arti_ref=".$ref."/".$page));
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