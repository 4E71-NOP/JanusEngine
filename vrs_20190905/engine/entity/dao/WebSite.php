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
		$cs = CommonSystem::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		if ( $cs->SMObj->getSessionEntry('ws') > 1 ){
			$dbquery = $cs->SDDMObj->query ( "
				SELECT * 
				FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ('website') . " 
				WHERE ws_id = '" . $cs->SMObj->getSessionEntry('ws') . "'
				;" );
			if ( $cs->SDDMObj->num_row_sql($dbquery) != 0 ) {
				$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for website id=".$cs->SMObj->getSessionEntry('ws')));
				while ( $dbp = $cs->SDDMObj->fetch_array_sql ( $dbquery ) ) {
					foreach ( $dbp as $A => $B ) { $this->WebSite[$A] = $B; }
				}
			}
			else {
				$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for website id=".$cs->SMObj->getSessionEntry('ws')));
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
		$cs = CommonSystem::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $cs->SDDMObj->query ( 
			"SELECT * 
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('website')." 
			WHERE ws_id = '" . $id. "'
			;");
		if ( $cs->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for website id=".$id));
			while ( $dbp = $cs->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->WebSite[$A] = $B; }
			}
		}
		else {
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for website id=".$id));
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