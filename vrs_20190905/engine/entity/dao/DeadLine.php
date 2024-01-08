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
class DeadLine extends Entity{
	private $DeadLine = array ();
	
	//@formatter:off
	private $columns = array(
		'deadline_id'				=>	0,
		'deadline_name'				=>	"",
		'deadline_title'			=>	"",
		'deadline_state'			=>	_OFFLINE_,
		'deadline_creation_date'	=>	0,
		'deadline_end_date'			=>	0,
		'fk_ws_id'					=>	0,
	);
	//@formatter:on
	
	public function __construct() {
		$this->DeadLine = $this->getDefaultValues();
	}
	
	/**
	 * Gets deadline data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the deadline selection to the website ID only.
	 * @param integer $id
	 */
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
				
		$dbquery = $bts->SDDMObj->query("
		SELECT dl.*
		FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('deadline')." dl "
		."WHERE dl.fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
		AND dl.deadline_id ='".$id."'
		;");
		if ( $dbquery === false ) { 
			$this->LastExecutionReport[] = array('state' => 'err', 'msg' =>  $bts->SDDMObj->errno.':'.$bts->SDDMObj->error);
			return false; 
		}

		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for deadline id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->DeadLine[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for deadline id=".$id));
			$this->LastExecutionReport[] = array('state' => 'err', 'msg' => 'No rows returned for deadline id='.$id );
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
				'data'			=> $this->DeadLine,
				'targetTable'	=> 'deadline',
				'targetColumn'	=> 'deadline_id',
				'entityId'		=> $this->DeadLine['deadline_id'],
				'entityTitle'	=> 'deadline'
		);
		if ( $this->existsInDB() === true && $mode == 2 || $mode == 0 ) { $res = $this->genericUpdateDb($genericActionArray);}
		elseif ( $this->existsInDB() === false && $mode == 1 || $mode == 0 ) { $res = $this->genericInsertInDb($genericActionArray); }

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}
	
	/**
	 * Verifies if the entity exists in DB.
	 */
	public function existsInDB() {
		return $this->entityExistsInDb('deadline', $this->DeadLine['deadline_id']);
	}
	
	
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$res = true;
		if ( $this->DeadLine['deadline_state'] < 0 && $this->DeadLine['deadline_state'] > 2) { $res = false; }
		if ( $this->DeadLine['deadline_creation_date'] == 0 ) { $res = false; }
		if ( $this->DeadLine['deadline_end_date'] == 0 ) { $res = false; }
		
		if ( $this->entityExistsInDb('website', $this->DeadLine['ws_id']) == false ) { $res = false; }
		if ( $this->entityExistsInDb('user', $this->DeadLine['user_id']) == false ) { $res = false; }
		
		return $res;
	}
	
	
	/**
	 * Returns the default values of this type (this is consistent witht de SQL model and it should stay that way)
	 * @return array()
	 */
	public function getDefaultValues () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$date = time();
		
		$tab = $this->columns;
		$tab['deadline_name'] = "New Deadline name " . time();
		$tab['deadline_title'] = "New Deadline title " . time();
		$tab['deadline_creation_date'] = $date;
		$tab['deadline_end_date'] = $date+(60*60*24*31*12*10);

		$tab['fk_ws_id'] = ($bts->CMObj->getExecutionContext() == 'render')
			? $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')
			: $CurrentSetObj->getInstanceOfWebSiteContextObj()->getWebSiteEntry('ws_id');
		return $tab;
	}
	
	/**
	 * Returns an array containing the useful table to build menus for this entity.
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
			'state' => array (
				0 => array( _MENU_OPTION_DB_ =>	 'offline',		_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('offline')),
				1 => array( _MENU_OPTION_DB_ =>	 'online',		_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('online')),
				2 => array( _MENU_OPTION_DB_ =>	 'disabled',	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('disabled')),
		));
	}
	
	//@formatter:off
	public function getDeadLineEntry ($data) { return $this->DeadLine[$data]; }
	public function getDeadLine() { return $this->DeadLine; }
	
	public function setDeadLineEntry ($entry, $data) { 
		if ( isset($this->DeadLine[$entry])) { $this->DeadLine[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}
	
	public function setDeadLine($DeadLine) { $this->DeadLine = $DeadLine; }
	//@formatter:off

}


?>