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
class GroupUser {
	private $GroupUser = array ();
	
	//@formatter:off
	private $columns = array(
		'group_user_id'				=> 0,
		'group_id'					=> 0,
		'user_id'					=> 0,
		'group_user_initial_group'	=> 0,
	);
	//@formatter:on
	
	public function __construct() {
		$this->GroupUser= $this->getDefaultValues();
	}
	
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ('group_user') . "
			WHERE group_user_id = '" . $id . "'
			;" );
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for group_user id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->GroupUser[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for group_user id=".$id));
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
			$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($this->columns, $this->GroupUser);
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : QueryColumnDescription - ".$bts->StringFormatObj->arrayToString($QueryColumnDescription) ));
			
			$bts->SDDMObj->query("
			UPDATE ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('group_user')." gu
			SET ".$QueryColumnDescription['equality']."
			WHERE gu.group_user_id ='".$this->GroupUser['group_user_id']."'
			;
			");
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : group_user already exist in DB. Updating Id=".$this->GroupUser['group_user_id']));
		}
		elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) {
			$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($this->columns, $this->GroupUser);
			$bts->SDDMObj->query("
				INSERT INTO ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('group_user')."
				(".$QueryColumnDescription['columns'].")
				VALUES
				(".$QueryColumnDescription['values'].")
				;
			");
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : group_user doesn't exist in DB. Inserting Id=".$this->GroupUser['group_user_id']));
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
			SELECT a.group_user_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('group_user')." a
			WHERE a.group_user_id ='".$this->GroupUser['group_user_id']."';
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
		if ( $this->GroupUser['group_user_initial_group'] < 0 && $this->GroupUser['group_user_initial_group'] > 1) { $res = false; }
		
		$dbquery = $bts->SDDMObj->query("
			SELECT g.group_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('group')." g
			WHERE g.group_id ='".$this->GroupUser['group_id']."';
		");
		if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {$res = false; }
		
		$dbquery = $bts->SDDMObj->query("
			SELECT user_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('user')."
			WHERE user_id = ".$this->GroupUser['user_id']."
			LIMIT 1;");
		if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {$res = false; }
		
		
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
				0 => array( MenuOptionDb =>	 0,	MenuOptionSelected => '',	MenuOptionTxt => $bts->I18nObj->getI18nEntry('offline')),
				1 => array( MenuOptionDb =>	 1,	MenuOptionSelected => '',	MenuOptionTxt => $bts->I18nObj->getI18nEntry('online')),
				2 => array( MenuOptionDb =>	 2,	MenuOptionSelected => '',	MenuOptionTxt => $bts->I18nObj->getI18nEntry('disabled')),
			));
	}
	
	//@formatter:off
	public function getGroupUserEntry ($data) { return $this->GroupUser[$data]; }
	public function getGroupUser() { return $this->GroupUser; }
	
	public function setGroupUserEntry ($entry, $data) { 
		if ( isset($this->GroupUser[$entry])) { $this->GroupUser[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setGroupUser($GroupUser) { $this->GroupUser = $GroupUser; }
	//@formatter:off

}


?>