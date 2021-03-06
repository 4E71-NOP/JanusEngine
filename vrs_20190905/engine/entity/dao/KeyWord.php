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
class KeyWord {
	private $KeyWord = array ();
	
	public function __construct() {}
	
	/**
	 * Gets keyword data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the keyword selection to the website ID only.
	 * @param integer $id
	 */
	public function getKeyWordDataFromDB($id) {
		$cs = CommonSystem::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $cs->SDDMObj->query("
			SELECT *
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('keyword')."
			WHERE keyword_id = '".$id."'
			AND ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
		;");
		
		if ( $cs->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for keyword id=".$id));
			while ( $dbp = $cs->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->KeyWord[$A] = $B; }
			}
		}
		else {
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for keyword id=".$id));
		}
		
	}

	//@formatter:off
	public function getKeyWordEntry ($data) { return $this->KeyWord[$data]; }
	public function getKeyWord() { return $this->KeyWord; }
	
	public function setKeyWordEntry ($entry, $data) { 
		if ( isset($this->KeyWord[$entry])) { $this->KeyWord[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setKeyWord($KeyWord) { $this->KeyWord = $KeyWord; }
	//@formatter:off

}


?>