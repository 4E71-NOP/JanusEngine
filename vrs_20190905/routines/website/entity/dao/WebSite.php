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

class WebSite {
	private $WebSite = array();
	
	public function __construct() {
		$this->WebSite = array(
			'ws_name'		=>	'New website',
			'ws_title'		=>	'New website',
			'ws_message'	=>	'message',
		);
	}
	
	/**
	 * Gets website data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the website selection to the website ID only.
	 * @param integer $id
	 */
	public function getWebSiteDataFromDB() {
		$RequestDataObj = RequestData::getInstance();
		$SDDMObj = DalFacade::getInstance ()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		$SMObj = SessionManagement::getInstance(0);
		
		$LMObj = LogManagement::getInstance();
		
// 		if ( $RequestDataObj->getRequestDataEntry('sw') > 1 ){
		if ( $SMObj->getSessionEntry('ws') > 1 ){
			$dbquery = $SDDMObj->query ( "
				SELECT * 
				FROM " . $SqlTableListObj->getSQLTableName ('website') . " 
				WHERE ws_id = '" . $SMObj->getSessionEntry('ws') . "'
				;" );
			if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
				$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => __METHOD__ . " : Loading data for website id=".$SMObj->getSessionEntry('ws')));
				while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
					foreach ( $dbp as $A => $B ) { $this->WebSite[$A] = $B; }
				}
			}
			else {
				$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => __METHOD__ . " : No rows returned for website id=".$SMObj->getSessionEntry('ws')));
			}
			$_REQUEST['site_context']['ws_id'] = $this->WebSite['ws_id'] ;		// Dédiée aux routines de manipulation
		}
		else {
			echo ("Error : Website ID is NOT defined in the session.<br>Exiting.");
			exit(1);
		}
	}
	
	/**
	 * Change website context
	 * @param integer $id
	 */
	public function changeWebSiteContext( $id ) {
		$SDDMObj = DalFacade::getInstance ()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance ( null, null );
		
		$LMObj = LogManagement::getInstance();
		
		$dbquery = $SDDMObj->query ( 
			"SELECT * 
			FROM " . $SqlTableListObj->getSQLTableName('website')." 
			WHERE ws_id = '" . $id. "'
			;");
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => __METHOD__ . " : Loading data for website id=".$id));
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->WebSite[$A] = $B; }
			}
		}
		else {
			$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => __METHOD__ . " : No rows returned for website id=".$id));
		}
		
	}

	//@formatter:off
	public function getWebSiteEntry ($data) { return $this->WebSite[$data]; }
	public function getWebSite() { return $this->WebSite; }

	public function setWebSiteEntry ($entry, $data) { 
		if ( isset($this->WebSite[$entry])) { $this->WebSite[$entry] = $data; }	//DB Entity objects do NOT accept new columns!
	}
	public function setWebSite($WebSite) { $this->WebSite = $WebSite; }
	
	public function setInstallationInstance () {
		$this->WebSite = array (
			"ws_id" => "1",
			"ws_title" => "Hydr Installation",
			"ws_lang" => 38,
		);
		// 38 = Eng
	}
	//@formatter:on

}

?>