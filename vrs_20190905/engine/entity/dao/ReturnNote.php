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
class ReturnNote {
	private $ReturnNote = array ();
	
	//@formatter:off
	private $columns = array(
		'retnot_id'			=> 0,
		'docu_id'			=> 0,
		'user_id'			=> 0,
		'retnot_date'		=> 0,
		'retnot_origin'		=> 0,
		'retnot_content'	=> 0,
	);
	//@formatter:on
	
	public function __construct() {
		$this->Module= $this->getDefaultValues();
	}
	
	/**
	 * Gets module data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the module selection to the website ID only.
	 * @param integer $id
	 */
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ('returnnote') . "
			WHERE retnot_id = '" . $id . "'
			;");
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for returnnote id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->ReturnNote[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for returnnote id=".$id));
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
			$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($this->columns, $this->ReturnNote);
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : QueryColumnDescription - ".$bts->StringFormatObj->arrayToString($QueryColumnDescription) ));
			
			$bts->SDDMObj->query("
			UPDATE ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('returnnote')." rn
			SET ".$QueryColumnDescription['equality']."
			WHERE rn.retnot_id ='".$this->ReturnNote['retnot_id']."'
			;
			");
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : returnnote already exist in DB. Updating Id=".$this->ReturnNote['retnot_id']));
		}
		elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) {
			$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($this->columns, $this->ReturnNote);
			$bts->SDDMObj->query("
				INSERT INTO ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('returnnote')."
				(".$QueryColumnDescription['columns'].")
				VALUES
				(".$QueryColumnDescription['values'].")
				;
			");
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : returnnote doesn't exist in DB. Inserting Id=".$this->ReturnNote['retnot_id']));
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
			SELECT rn.retnot_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('returnnote')." rn
			WHERE rn.retnot_id ='".$this->ReturnNote['retnot_id']."';
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
		
		$dbquery = $bts->SDDMObj->query("
			SELECT d.docu_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('document')." d
			WHERE d.docu_id ='".$this->Decoration['docu_id']."';
		");
		if ( $bts->SDDMObj->num_row_sql($dbquery) == 1 ) { $res = false; }
		
		$dbquery = $bts->SDDMObj->query("
			SELECT user_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('user')."
			WHERE user_id = ".$this->Extension['arti_creator']."
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
	public function getReturnNoteEntry ($data) { return $this->ReturnNote[$data]; }
	public function getReturnNote() { return $this->ReturnNote; }
	
	public function setReturnNoteEntry ($entry, $data) { 
		if ( isset($this->ReturnNote[$entry])) { $this->ReturnNote[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setReturnNote($returnnote) { $this->ReturnNote = $returnnote; }
	//@formatter:off

}


?>