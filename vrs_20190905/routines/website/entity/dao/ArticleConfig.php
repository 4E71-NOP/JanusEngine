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
	public function getArticleConfigDataFromDB($data) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$dbquery = $SDDMObj->query ( "" );
		while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
			foreach ( $dbp as $A => $B ) { $this->ArticleConfig [$A] = $B; }
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