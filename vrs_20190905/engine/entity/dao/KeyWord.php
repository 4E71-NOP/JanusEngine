<?php
/* Hydre-licence-debut */
// --------------------------------------------------------------------------------------------
//
// Hydre - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/* Hydre-licence-fin */
class KeyWord extends Entity {
	private $KeyWord = array ();
	
	//@formatter:off
	private $columns = array(
		'keyword_id'		=> 0,
		'keyword_state'		=> 0,
		'keyword_name'		=> 'new Keyword',
		'fk_arti_id'		=> 0,
		'fk_ws_id'			=> 0,
		'keyword_string'	=> "",
		'keyword_count'		=> 0,
		'keyword_type'		=> 0,
		'keyword_data'		=> 0,
	);
	//@formatter:on
	
	public function __construct() {
		$this->KeyWord = $this->getDefaultValues();
	}
	
	/**
	 * Gets keyword data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the keyword selection to the website ID only.
	 * @param integer $id
	 */
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
				
		$dbquery = $bts->SDDMObj->query("
			SELECT *
			FROM ".$CurrentSetObj->SqlTableListObj->getSQLTableName('keyword')."
			WHERE keyword_id = '".$id."'
			AND fk_ws_id = '".$CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id')."'
		;");
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for keyword id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->KeyWord[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for keyword id=".$id));
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
			'data'			=> $this->KeyWord,
			'targetTable'	=> 'keyword',
			'targetColumn'	=> 'keyword_id',
			'entityId'		=> $this->KeyWord['keyword_id'],
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
		return $this->entityExistsInDb('keyword', $this->KeyWord['keyword_id']);
	}
	
	
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$res = true;
		if ( $this->KeyWord['keyword_type'] < 0 && $this->KeyWord['keyword_type'] > 3) { $res = false; }

		if ( $this->entityExistsInDb('article', $this->KeyWord['arti_id']) == false ) { $res = false; }
		if ( $this->entityExistsInDb('website', $this->KeyWord['ws_id']) == false ) { $res = false; }

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
		$tab['keyword_name']	= 'new Keyword name'.$date;
		$tab['keyword_state']	= _ONLINE_;
		$tab['keyword_string']	= 'This word';
		$tab['keyword_count']	= 1;
		$tab['keyword_type']	= 3;
		$tab['fk_arti_id']		= 0;
		$tab['fk_ws_id'] = ($bts->CMObj->getExecutionContext() == 'render')
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
			'type' => array(
				1 => array( _MENU_OPTION_DB_ =>	 "TO_MENU",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('kwType1')		),
				2 => array( _MENU_OPTION_DB_ =>	 "TO_URL",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('kwType2')		),
				3 => array( _MENU_OPTION_DB_ =>	 "TOOLTIP",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('kwType3')		),
			),
			'state' => array (
				0 => array( _MENU_OPTION_DB_ =>	 "OFFLINE",		_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('offline')),
				1 => array( _MENU_OPTION_DB_ =>	 "ENABLED",		_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('online')),
				2 => array( _MENU_OPTION_DB_ =>	 "DISABLED",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('disabled')),
			));
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