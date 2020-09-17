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
class ArticleTag {
	private $ArticleTag = array ();
	public function __construct() {
	}
	public function getArticleTagDataFromDB($id) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance ();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );

		$LMObj = LogManagement::getInstance();
		$dbquery = $SDDMObj->query ( "
			SELECT *
			FROM " . $SqlTableListObj->getSQLTableName ('article_tag') . "
			WHERE article_tag_id = '" . $id . "'
			;" );
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog(__METHOD__ . " : Loading data for article_tag id=".$id);
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->ArticleTag[$A] = $B; }
			}
		}
		else {
			$LMObj->InternalLog(__METHOD__ . " : No rows returned for article_tag id=".$id);
		}
		
	}

	//@formatter:off
	public function getArticleTagEntry ($data) { return $this->ArticleTag[$data]; }
	public function getArticleTag() { return $this->ArticleTag; }
	
	public function setArticleTagEntry ($entry, $data) { 
		if ( isset($this->ArticleTag[$entry])) { $this->ArticleTag[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setArticleTag($ArticleTag) { $this->ArticleTag = $ArticleTag; }
	//@formatter:off

}


?>