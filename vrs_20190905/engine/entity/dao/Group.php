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
class Group {
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
		
		$dbquery = $dbquery = $bts->SDDMObj->query("
			SELECT grp.* 
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('group')." grp , ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('group_website')." sg
			WHERE grp.group_id = '".$id."'
			AND grp.group_id = sg.group_id
			AND sg.ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
		;");
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for group id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->Group[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for group id=".$id));
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
			$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($this->columns, $this->Group);
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : QueryColumnDescription - ".$bts->StringFormatObj->arrayToString($QueryColumnDescription) ));
			
			$bts->SDDMObj->query("
			UPDATE ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('group')." g
			SET ".$QueryColumnDescription['equality']."
			WHERE g.group_id ='".$this->Group['group_id']."'
			;
			");
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : group already exist in DB. Updating Id=".$this->Group['group_id']));
		}
		elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) {
			$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($this->columns, $this->Group);
			$bts->SDDMObj->query("
				INSERT INTO ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('group')."
				(".$QueryColumnDescription['columns'].")
				VALUES
				(".$QueryColumnDescription['values'].")
				;
			");
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : group doesn't exist in DB. Inserting Id=".$this->Group['group_id']));
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
			SELECT g.group_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('group')." g
			WHERE g.group_id ='".$this->Group['group_id']."';
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
		if ( $this->Group['group_tag'] < 0 && $this->Group['group_tag'] > 3) { $res = false; }
		
// 		$dbquery = $bts->SDDMObj->query("
// 			SELECT ws_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('website')."
// 			WHERE ws_id = ".$this->Group['ws_id']."
// 			LIMIT 1;"
// 				);
// 		if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {$res = false; }
		
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
		$this->Group['group_name'] .= "-".date("d_M_Y_H:i:s", time());
		
// 		$this->Group['ws_id'] = ($bts->CMObj->getExecutionContext() == 'render')
// 		? $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')
// 		: $CurrentSetObj->getInstanceOfWebSiteContextObj()->getWebSiteEntry('ws_id');
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
	public function getGroupEntry ($data) { return $this->Group[$data]; }
	public function getGroup() { return $this->Group; }
	
	public function setGroupEntry ($entry, $data) { 
		if ( isset($this->Group[$entry])) { $this->Group[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setGroup($Group) { $this->Group = $Group; }
	//@formatter:off

}


?>