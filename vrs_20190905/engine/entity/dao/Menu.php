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
class Menu extends Entity {
	private $Menu = array ();
	
	//@formatter:off
	private $columns = array(
		"menu_id"				=> "",
		"menu_name"				=> "New Menu",
		"menu_title"			=> "New Menu",
		"menu_desc"				=> "New Menu",
		"menu_type"				=> "ARTICLE",
		"fk_ws_id"				=> 0,
		"fk_lang_id"			=> 0,
		"fk_deadline_id"		=> 0,
		"menu_state"			=> 0,
		"menu_parent"			=> 0,
		"menu_position"			=> "",
		"fk_perm_id"			=> 0,
		"menu_last_update"		=> 0,
		"menu_role"				=> 0,
		"menu_initial_document"	=> 0,
		"fk_artie_slug"			=> "",
		"fk_arti_ref"			=> 0,	
	);
	//@formatter:on
	
	public function __construct() {
		$this->Menu= $this->getDefaultValues();
	}
	
	/**
	 * Gets Menu data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the Menu selection to the website ID only. 
	 * @param integer $id
	 */
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
				
		$dbquery = $dbquery = $bts->SDDMObj->query("
			SELECT * 
			FROM ".$CurrentSetObj->SqlTableListObj->getSQLTableName('menu')." 
			WHERE menu_id = '".$id."'
			AND fk_ws_id = '".$CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id')."'
		;");
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for Menu id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->Menu[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for Menu id=".$id));
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
				'data'			=> $this->Menu,
				'targetTable'	=> 'menu',
				'targetColumn'	=> 'menu_id',
				'entityId'		=> $this->Menu['menu_id'],
				'entityTitle'	=> 'menu'
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
		return $this->entityExistsInDb('menu', $this->Menu['menu_id']);

	}
	
	
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$res = true;
		if ( $this->Menu['lang_id'] == 0) { $res = false; }
		if ( $this->Menu['deadline_id'] == 0) { $res = false; }
		if ( $this->Menu['menu_state'] < 0 && $this->Menu['menu_state'] > 2) { $res = false; }
		if ( $this->Menu['group_id'] == 0) { $res = false; }
		if ( $this->Menu['menu_last_modif'] == 0) { $res = false; }
		if ( $this->Menu['menu_parent'] != 0 || $this->Menu['menu_parent'] != null ) {
			if ( $this->entityExistsInDb('menu', $this->Menu['menu_parent'] ) == false ) { $res = false; }
		}
		if ( $this->entityExistsInDb('website', $this->Menu['ws_id']) == false ) { $res = false; }
		if ( $this->entityExistsInDb('group', $this->Menu['fk_group_id']) == false ) { $res = false; }
		if ( $this->entityExistsInDb('deadline', $this->Menu['fk_deadline_id']) == false ) { $res = false; }
		if ( $this->entityExistsInDb('permission', $this->Menu['fk_perm_id']) == false ) { $res = false; }
		
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
		$tab['menu_last_modif'] = $date;
		
		$tab['menu_name']				= "New Menu name ".$date;
		$tab['menu_title']				= "New Menu title ".$date;
		$tab['menu_desc']				= "New Menu desc ".$date;
		$tab['menu_type']				= 1;
		$tab['fk_deadline_id']			= "";
		$tab['menu_state']				= _OFFLINE_;
		$tab['menu_parent']				= "";
		$tab['menu_position']			= 1;
		$tab['fk_perm_id']				= "";
		$tab['menu_last_update']		= $date;
		$tab['menu_role']				= _NULL_;
		$tab['menu_initial_document']	= _NO_;
		$tab['fk_artie_slug']			= "";
		$tab['fk_arti_ref']				= "";

		$tab['fk_ws_id'] = ($bts->CMObj->getExecutionContext() == 'render') 
			? $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id')
			: $CurrentSetObj->WebSiteContextObj->getWebSiteEntry('ws_id');
		
		$tab['fk_user_id'] = $CurrentSetObj->UserObj->getUserEntry('user_id');

		$tab['fk_lang_id'] = ($bts->CMObj->getExecutionContext() == 'render')
			? $CurrentSetObj->WebSiteObj->getWebSiteEntry('lang_id')
			: $CurrentSetObj->WebSiteContextObj->getWebSiteEntry('lang_id');
		
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
			'yesno' => array (
				0 => array( _MENU_OPTION_DB_ =>	 "NO",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('no')),
				1 => array( _MENU_OPTION_DB_ =>	 "YES",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('yes')),	
			),
			'type' => array (
				0 =>	array ( _MENU_OPTION_DB_ => "article_racine",		_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('article_racine')	),
				1 =>	array ( _MENU_OPTION_DB_ => "article",				_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('article')			),
				2 =>	array ( _MENU_OPTION_DB_ => "menu_admin_racine",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('menu_admin_racine')	),
				3 =>	array ( _MENU_OPTION_DB_ => "menu_admin",			_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('menu_admin')		),
			),
			'role' => array(
				0 =>	array ( _MENU_OPTION_DB_ => 0,						_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('noRole')				),
				1 =>	array ( _MENU_OPTION_DB_ => "correction_article",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('correction_article')	),
				2 =>	array ( _MENU_OPTION_DB_ => "admin_conf_extension",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('admin_conf_extension')	),
			),
			'state' => array (
				0 => array( _MENU_OPTION_DB_ =>	 0,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('offline')),
				1 => array( _MENU_OPTION_DB_ =>	 1,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('online')),
				2 => array( _MENU_OPTION_DB_ =>	 2,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('disabled')),
			));
	}
	
	//@formatter:off
	public function getMenuEntry ($data) { return $this->Menu[$data]; }
	public function getMenu() { return $this->Menu; }
	
	public function setMenuEntry ($entry, $data) { 
		if ( isset($this->Menu[$entry])) { $this->Menu[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setMenu($Menu) { $this->Menu = $Menu; }
	//@formatter:off

}

?>