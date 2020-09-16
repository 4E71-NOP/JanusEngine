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
	
// 	sw_id			sw_nom				sw_abrege				sw_lang
// 	sw_lang_select	theme_id			sw_titre				sw_barre_status
// 	sw_home			sw_repertoire		sw_etat					sw_info_debug
// 	sw_stylesheet	sw_gal_mode			sw_gal_fichier_tag		sw_gal_qualite
// 	sw_gal_x		sw_gal_y			sw_gal_liserai			sw_ma_diff
	private $WebSite = array();
	
	public function __construct() {
		$this->WebSite = array(
			'sw_nom'		=>	'New website',
			'sw_titre'		=>	'New website',
			'sw_message'	=>	'message',
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
				FROM " . $SqlTableListObj->getSQLTableName ('site_web') . " 
				WHERE sw_id = '" . $SMObj->getSessionEntry('ws') . "'
				;" );
			if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
				$LMObj->InternalLog("WebSite/getWebSiteDataFromDB() : Loading data for website id=".$SMObj->getSessionEntry('ws'));
				while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
					foreach ( $dbp as $A => $B ) { $this->WebSite[$A] = $B; }
				}
			}
			else {
				$LMObj->InternalLog("WebSite/getWebSiteDataFromDB() : No rows returned for website id=".$SMObj->getSessionEntry('ws'));
			}
			$_REQUEST['site_context']['site_id'] = $this->WebSite['sw_id'] ;		// Dédiée aux routines de manipulation
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
			FROM " . $SqlTableListObj->getSQLTableName('site_web')." 
			WHERE sw_id = '" . $id. "'
			;");
		if ( $SDDMObj->num_row_sql($dbquery) != 0 ) {
			$LMObj->InternalLog("WebSite/changeWebSiteContext() : Loading data for website id=".$id);
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->WebSite[$A] = $B; }
			}
		}
		else {
			$LMObj->InternalLog("WebSite/changeWebSiteContext() : No rows returned for website id=".$id);
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
			"sw_id" => "1",
			"sw_title" => "Hydr Installation",
			"sw_lang" => 38,
		);
		// 38 = Eng
	}
	//@formatter:on

}

?>