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
class I18n extends Entity{
	private $I18n = array ();
	
	//@formatter:off
	private $columns = array(
		"i18n_id"		=> 0,
		"fk_lang_id"	=> 0,
		"i18n_package"	=> 0,
		"i18n_name"		=> 0,
		"i18n_text"		=> 0,
	);
	//@formatter:on
	
	public function __construct() {
		$this->I18n= $this->getDefaultValues();
	}
	
	/**
	 * Gets I18n data from the database.<br>
	 * @param integer $id
	 */
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
				
		$dbquery = $bts->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName ('i18n') . "
			WHERE i18n_id = '" . $id . "'
			;" );
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for i18n id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->I18n[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for i18n id=".$id));
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
			'data'			=> $this->I18n,
			'targetTable'	=> 'i18n',
			'targetColumn'	=> 'i18n_id',
			'entityId'		=> $this->I18n['i18n_id'],
			'entityTitle'	=> 'I18n'
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
		return $this->entityExistsInDb('i18n', $this->I18n['i18n_id']);
	}
	
	
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$res = true;
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
	public function getI18nEntry ($data) { return $this->I18n[$data]; }
	public function getI18n() { return $this->I18n; }
	
	public function setI18nEntry ($entry, $data) { 
		if ( isset($this->I18n[$entry])) { $this->I18n[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setI18n($I18n) { $this->I18n = $I18n; }
	//@formatter:off

}

?>