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
class DeadLine {
	private $DeadLine = array ();
	
	private $columns = array(
			'deadline_id'				=>	0,
			'deadline_name'				=>	'New deadline',
			'deadline_title'			=>	'New deadline title',
			'deadline_state'			=>	0,
			'deadline_creation_date'	=>	0,
			'deadline_end_date'			=>	0,
			'ws_id'						=>	2,
			'user_id'					=>	1,
	);
	
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
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		if ( $this->existsInDB() === true && $mode == 2 || $mode == 0 ) {
			$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($this->columns, $this->DeadLine);
// 			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : QueryColumnDescription - ".$bts->StringFormatObj->arrayToString($QueryColumnDescription) ));
			
			$bts->SDDMObj->query("
			UPDATE ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('deadline')." dl 
			SET ".$QueryColumnDescription['equality']." 
			WHERE dl.deadline_id ='".$this->DeadLine['deadline_id']."' 
			;
			");
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : deadline already exist in DB. Updating Id=".$this->DeadLine['deadline_id']));
		}
		elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) {
			$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($this->columns, $this->DeadLine);
			$bts->SDDMObj->query("
				INSERT INTO ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('deadline')."
				(".$QueryColumnDescription['columns'].")
				VALUES
				(".$QueryColumnDescription['values'].")
				;
			");
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : deadline doesn't exist in DB. Inserting Id=".$this->DeadLine['deadline_id']));
		}
	}
	
	/**
	 * Verifies if the entity exists in DB.
	 */
	public function existsInDB() {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$res = false;
		$dbquery = $bts->SDDMObj->query("
			SELECT dl.deadline_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('deadline')." dl
			WHERE dl.deadline_id ='".$this->DeadLine['deadline_id']."';
		");
		if ( $bts->SDDMObj->num_row_sql($dbquery) == 1 ) { $res = true; }
		return $res;
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
		
		$dbquery = $bts->SDDMObj->query("
			SELECT ws_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('website')." 
			WHERE ws_id = ".$this->DeadLine['ws_id']." 
			LIMIT 1;"
		);
		if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {$res = false; }
		
		$dbquery = $bts->SDDMObj->query("
			SELECT user_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('user')."
			WHERE user_id = ".$this->DeadLine['user_id']."
			LIMIT 1;"
		);
		if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {$res = false; }
		
		return $res;
	}
	
	
	/**
	 * Returns the default values of this type (this is consistent witht de SQL model and it should stay that way)
	 * @return array()
	 */
	public function getDefaultValues () {
		$date = time ();
		$tab = $this->columns;
		$tab['deadline_creation_date'] = $date;
		$tab['deadline_end_date'] = $date + (60*60*24*31*12*10);
		return $tab;
	}
	
	/**
	 * Returns an array containing the list of states for this entity.
	 * Useful for menu select amongst other things.
	 * @return array()
	 */
	public function getStatesArray () {
		$bts = BaseToolSet::getInstance();
		return array (
			0 => array( 'db' =>	 0,	's' => '',	't' => $bts->I18nObj->getI18nEntry('offline')),
			1 => array( 'db' =>	 1,	's' => '',	't' => $bts->I18nObj->getI18nEntry('online')),
			2 => array( 'db' =>	 2,	's' => '',	't' => $bts->I18nObj->getI18nEntry('disabled')),
		);
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