<?php
/* JanusEngine-license-start */
// --------------------------------------------------------------------------------------------
//
// Janus Engine - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/* JanusEngine-license-end */
class ThemeWebsite extends Entity {
	private $ThemeWebsite = array ();
	
	//@formatter:off
	private $columns = array(
		"theme_website_id"	=> 0,
		"ws_id"				=> 0,
		"theme_id"			=> 0,
		"theme_state"		=> 0,
	);
	//@formatter:on
	
	public function __construct() {
		$this->ThemeWebsite= $this->getDefaultValues();
	}
	
	/**
	 * Gets ThemeWebsite data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the ThemeWebsite selection to the website ID only.
	 * @param integer $id
	 */
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
		
				
		$dbquery = $bts->SDDMObj->query("
			SELECT *
			FROM ".$CurrentSetObj->SqlTableListObj->getSQLTableName('theme_website')."
			WHERE theme_website_id = '".$id."'
		;");
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for theme_website id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->ThemeWebsite[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for theme_website id=".$id));
			$res = false;
		}

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}
	
	/**
	 * Updates or inserts in DB the local data.
	 * mode ar available: <br>
	 * <br>
	 * 0 = insert or update - Depending on the Id existing in DB or not, it'll be UPDATE or INSERT<br>
	 * 1 = insert only - Supposedly a new ID and not an existing one<br>
	 * 2 = update only - Supposedly an existing ID<br>
	 */
	public function sendToDB($mode = OBJECT_SENDTODB_MODE_DEFAULT){
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;

		$genericActionArray = array(
			'columns'		=> $this->columns,
			'data'			=> $this->ThemeWebsite,
			'targetTable'	=> 'theme_website',
			'targetColumn'	=> 'theme_website_id',
			'entityId'		=> $this->ThemeWebsite['theme_website_id'],
			'entityTitle'	=> 'group'
		);
		if ( $this->existsInDB() === true && $mode == 2 || $mode == 0 ) { $res = $this->genericUpdateDb($genericActionArray);}
		elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) { $res = $this->genericInsertInDb($genericActionArray); }

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}
	
	/**
	 * Verifies if the entity exists in DB.
	 */
	public function existsInDB() {
		return $this->entityExistsInDb('theme_website', $this->ThemeWebsite['theme_website_id']);
	}
	
	
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$res = true;
		if ( $this->ThemeWebsite['theme_website_type'] < 0 && $this->ThemeWebsite['theme_website_type'] > 3) { $res = false; }

		if ( $this->entityExistsInDb('theme_descriptor', $this->ThemeWebsite['theme_id']) == false ) { $res = false; }
		if ( $this->entityExistsInDb('website', $this->ThemeWebsite['ws_id']) == false ) { $res = false; }

		return $res;
	}
	
	
	/**
	 * Returns the default values of this type (this is consistent witht de SQL model and it should stay that way)
	 * @return array()
	 */
	public function getDefaultValues () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$date = time ();
		$tab = $this->columns;
		
		$this->ThemeWebsite['ws_id'] = ($bts->CMObj->getExecutionContext() == 'render')
			? $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id')
			: $CurrentSetObj->WebSiteContextObj->getWebSiteEntry('ws_id');
		return $tab;
	}
	
	/**
	 * Returns an array containing the list of states for this entity.
	 * Useful for menu select amongst other things.
	 * @return array()
	 */
	public function getMenuOptionArray () {
		$bts = BaseToolSet::getInstance();
		return array (
			'state' => array (
				0 => array( _MENU_OPTION_DB_ =>	 0,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('offline')),
				1 => array( _MENU_OPTION_DB_ =>	 1,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('online')),
				2 => array( _MENU_OPTION_DB_ =>	 2,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('disabled')),
			));
	}
	
	//@formatter:off
	public function getThemeWebsiteEntry ($data) { return $this->ThemeWebsite[$data]; }
	public function getThemeWebsite() { return $this->ThemeWebsite; }
	
	public function setThemeWebsiteEntry ($entry, $data) { 
		if ( isset($this->ThemeWebsite[$entry])) { $this->ThemeWebsite[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setThemeWebsite($ThemeWebsite) { $this->ThemeWebsite = $ThemeWebsite; }
	//@formatter:off

}


?>