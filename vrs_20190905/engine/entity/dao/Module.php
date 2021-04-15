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
class Module {
	private $Module = array ();
	
	//@formatter:off
	private $columns = array(
		'module_id'						=> 0,
		'module_deco'					=> 0,
		'module_deco_nbr'				=> 0,
		'module_deco_default_text'		=> 0,
		'module_name'					=> "New Module",
		'module_classname'				=> "",
		'module_title'					=> 0,
		'module_directory'				=> 0,
		'module_file'					=> 0,
		'module_desc'					=> 0,
		'module_container_name'			=> 0,
		'module_container_style'		=> 0,
		'module_group_allowed_to_see'	=> 0,
		'module_group_allowed_to_use'	=> 0,
		'module_adm_control'			=> 0,
		'module_execution'				=> 0,
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
		
		$dbquery = $bts->SDDMObj->query("
			SELECT a.*,b.module_state
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('module')." a , ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('module_website')." b
			WHERE a.module_id = '".$id."'
			AND a.module_id = b.module_id
			AND b.ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
		;");
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for module id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->Module[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for module id=".$id));
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
			$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($this->columns, $this->Module);
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : QueryColumnDescription - ".$bts->StringFormatObj->arrayToString($QueryColumnDescription) ));
			
			$bts->SDDMObj->query("
			UPDATE ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('module')." m
			SET ".$QueryColumnDescription['equality']."
			WHERE m.module_id ='".$this->Module['module_id']."'
			;
			");
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : module already exist in DB. Updating Id=".$this->Module['module_id']));
		}
		elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) {
			$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($this->columns, $this->Module);
			$bts->SDDMObj->query("
				INSERT INTO ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('module')."
				(".$QueryColumnDescription['columns'].")
				VALUES
				(".$QueryColumnDescription['values'].")
				;
			");
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : module doesn't exist in DB. Inserting Id=".$this->Module['module_id']));
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
			SELECT m.module_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('module')." m
			WHERE m.module_id ='".$this->Module['module_id']."';
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
			SELECT g.group_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('group')." g
			WHERE g.group_id ='".$this->Module['module_group_allowed_to_see']."';
		");
		if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {$res = false; }
		
		$dbquery = $bts->SDDMObj->query("
			SELECT g.group_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('group')." g
			WHERE g.group_id ='".$this->Module['module_group_allowed_to_use']."';
		");
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
		$this->Group['module_name'] .= "-".date("d_M_Y_H:i:s", time());
		
// 		$this->Module['ws_id'] = ($bts->CMObj->getExecutionContext() == 'render')
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
	public function getModuleEntry ($data) { return $this->Module[$data]; }
	public function getModule() { return $this->Module; }
	
	public function setModuleEntry ($entry, $data) { 
		if ( isset($this->Module[$entry])) { $this->Module[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setModule($Module) { $this->Module = $Module; }
	//@formatter:off

}


?>