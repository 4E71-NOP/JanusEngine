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
class ArticleConfig {
	private $ArticleConfig = array ();
	public function __construct() {
	}
	public function getArticleConfigDataFromDB($id) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$LMObj = LogManagement::getInstance();
		$dbquery = $SDDMObj->query ( "
			SELECT *
			FROM " . $SqlTableListObj->getSQLTableName ('article_config') . "
			WHERE config_id = '" . $id . "'
			;" );
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog(__METHOD__ . " : Loading data for article_config id=".$id);
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->ArticleConfig[$A] = $B; }
			}
		}
		else {
			$LMObj->InternalLog(__METHOD__ . " : No rows returned for article_config id=".$id);
		}
		
	}

	//@formatter:off
	public function getArticleConfigEntry ($data) { return $this->ArticleConfig[$data]; }
	public function getArticleConfig() { return $this->ArticleConfig; }
	
	public function setArticleConfigEntry ($entry, $data) { 
		if ( isset($this->ArticleConfig[$entry])) { $this->ArticleConfig[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setArticleConfig($ArticleConfig) { $this->ArticleConfig = $Article; }
	//@formatter:off

}


?>