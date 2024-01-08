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
class Group extends Entity {
	private $Group = array ();
	
	//@formatter:off
	private $columns = array(
			'group_id'			=> 0,
			'group_parent'		=> 0,
			'group_tag'			=> 0,
			'group_name'		=> "New Group",
			'group_title'		=> "New Group",
			'group_file'		=> 0,
			'group_desc'		=> "New Group",
	);
	//@formatter:on
	
	public function __construct() {
		$this->Group= $this->getDefaultValues();
	}
	
	/**
	 * Gets group data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the group selection to the website ID only.
	 * @param integer $id
	 */
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
				
		$dbquery = $dbquery = $bts->SDDMObj->query("
			SELECT grp.* 
			FROM "
			.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('group')." grp , "
			.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('group_website')." gw
			WHERE grp.group_id = '".$id."'
			AND grp.group_id = gw.fk_group_id
			AND gw.fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
		;");
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for group id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->Group[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . " : No rows returned for group id=".$id));
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
			'data'			=> $this->Group,
			'targetTable'	=> 'group',
			'targetColumn'	=> 'group_id',
			'entityId'		=> $this->Group['group_id'],
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
		return $this->entityExistsInDb('group', $this->Group['group_id']);
	}
	
	
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$res = true;
		if ( $this->Group['group_tag'] < 0 && $this->Group['group_tag'] > 3) { $res = false; }
		
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
		$tab['group_tag']	= _READER_;
		$tab['group_name']	= "New Group name " .	$date;
		$tab['group_title']	= "New Group title " .	$date;
		$tab['group_desc']	= "New Group desc " .	$date;

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
			'tag' => array(
				0 => array( _MENU_OPTION_DB_ =>	 'ANONYMOUS',		_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('anonymous')),
				1 => array( _MENU_OPTION_DB_ =>	 'READER',			_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('reader')),
				2 => array( _MENU_OPTION_DB_ =>	 'STAFF',			_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('staff')),
				3 => array( _MENU_OPTION_DB_ =>	 'SENIOR_STAFF',	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('seniorStaff')),
			),
			'state' => array (
				0 => array( _MENU_OPTION_DB_ =>	 0,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('offline')),
				1 => array( _MENU_OPTION_DB_ =>	 1,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('online')),
				2 => array( _MENU_OPTION_DB_ =>	 2,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('disabled')),
			));
	}
	
	//@formatter:off
	public function getGroupEntry ($data) { return $this->Group[$data]; }
	public function getGroup() { return $this->Group; }
	
	public function setGroupEntry ($entry, $data) { 
		if ( isset($this->Group[$entry])) { $this->Group[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setGroup($Group) { $this->Group = $Group; }
	//@formatter:off

}


?>