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
class Module extends Entity {
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
		'module_type'					=> 0,
		'module_container_name'			=> 0,
		'module_container_style'		=> 0,
		'fk_perm_id'					=> 0,
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
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
				
		$dbquery = $bts->SDDMObj->query("
			SELECT m.*,mw.module_state
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('module')." m , ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('module_website')." mw
			WHERE m.module_id = '".$id."'
			AND m.module_id = mw.fk_module_id
			AND mw.fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
		;");
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for module id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->Module[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for module id=".$id));
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
			'data'			=> $this->Module,
			'targetTable'	=> 'module',
			'targetColumn'	=> 'module_id',
			'entityId'		=> $this->Module['module_id'],
			'entityTitle'	=> 'module'
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
		return $this->entityExistsInDb('module', $this->Module['module_id']);
	}
	
	
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$res = true;
		if ( $this->entityExistsInDb('permission', $this->Module['fk_perm_id']) == false ) { $res = false; }
		
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
		$tab['module_deco']					= _ON_;
		$tab['module_deco_nbr']				= 1;
		$tab['module_deco_default_text']	= "Module";
		$tab['module_name']					= "New Module name ".$date;
		$tab['module_classname']			= "";
		$tab['module_title']				= "Module title ".$date;
		$tab['module_directory']			= 0;
		$tab['module_file']					= 0;
		$tab['module_desc']					= "Module description ".$date;
		$tab['module_type']					= 0;
		$tab['module_container_name']		= "Modulecontainer_".$date;
		$tab['module_container_style']		= 0;
		$tab['fk_perm_id']					= "";
		$tab['module_adm_control']			= _NO_;
		$tab['module_execution']			= _DURING_;
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
			'yesno' => array (
				0 => array( _MENU_OPTION_DB_ =>	 "NO",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('no')),
				1 => array( _MENU_OPTION_DB_ =>	 "YES",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('yes')),	
			),
			'execution' => array (
				0	=>	array( _MENU_OPTION_DB_ =>	 'DURING',	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_  => $bts->I18nTransObj->getI18nTransEntry('during')),
				1	=>	array( _MENU_OPTION_DB_ =>	 'BEFORE',	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_  => $bts->I18nTransObj->getI18nTransEntry('before')),
				2	=>	array( _MENU_OPTION_DB_ =>	 'AFTER',	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_  => $bts->I18nTransObj->getI18nTransEntry('after')),
			),
			'state' => array (
				0 => array( _MENU_OPTION_DB_ =>	 0,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('offline')),
				1 => array( _MENU_OPTION_DB_ =>	 1,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('online')),
				2 => array( _MENU_OPTION_DB_ =>	 2,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('disabled')),
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