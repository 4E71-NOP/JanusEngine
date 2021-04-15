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
class DeadLine extends Entity{
	private $DeadLine = array ();
	
	//@formatter:off
	private $columns = array(
		'deadline_id'				=>	0,
		'deadline_name'				=>	'New deadline',
		'deadline_title'			=>	'New deadline title',
		'deadline_state'			=>	0,
		'deadline_creation_date'	=>	0,
		'deadline_end_date'			=>	0,
		'ws_id'						=>	0,
		'user_id'					=>	0,
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
		
		$dbquery = $bts->SDDMObj->query("
		SELECT dl.*,usr.user_login
		FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('deadline')." dl, ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('user')." usr
		WHERE ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
		AND usr.user_id = dl.user_id
		AND dl.deadline_id ='".$id."'
		;");
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for deadline id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->DeadLine[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for deadline id=".$id));
		}
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
		$genericActionArray = array(
				'columns'		=> $this->columns,
				'data'			=> $this->DeadLine,
				'targetTable'	=> 'deadline',
				'targetColumn'	=> 'deadline_id',
				'entityId'		=> $this->DeadLine['deadline_id'],
				'entityTitle'	=> 'deadline'
		);
		if ( $this->existsInDB() === true && $mode == 2 || $mode == 0 ) { $this->genericUpdateDb($genericActionArray);}
		elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) { $this->genericInsertInDb($genericActionArray); }
	}
	
	/**
	 * Verifies if the entity exists in DB.
	 */
	public function existsInDB() {
		return $this->deadlineExists($this->DeadLine['deadline_id']);
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
		
		if ( $this->websiteExists($this->DeadLine['ws_id']) == false ) { $res = false; }
		if ( $this->userExists($this->DeadLine['user_id']) == false ) { $res = false; }
		
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
		$tab['deadline_creation_date'] = $date;
		$tab['deadline_end_date'] = $date + (60*60*24*31*12*10);
		$tab['user_id'] = $CurrentSetObj->getInstanceOfUserObj()->getUserEntry('user_id');
		$tab['ws_id'] = ($bts->CMObj->getExecutionContext() == 'render')
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
			'state' => array (
				0 => array( MenuOptionDb =>	 0,	MenuOptionSelected => '',	MenuOptionTxt => $bts->I18nObj->getI18nEntry('offline')),
				1 => array( MenuOptionDb =>	 1,	MenuOptionSelected => '',	MenuOptionTxt => $bts->I18nObj->getI18nEntry('online')),
				2 => array( MenuOptionDb =>	 2,	MenuOptionSelected => '',	MenuOptionTxt => $bts->I18nObj->getI18nEntry('disabled')),
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