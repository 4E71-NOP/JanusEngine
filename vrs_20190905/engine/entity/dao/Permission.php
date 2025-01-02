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
class Permission extends Entity {
	private $Permission = array ();
	
	//@formatter:off
	private $columns = array(
		"perm_id"					=> "",
		"state"						=> 0,
		"perm_name" 				=> "defaultPermission",
		"perm_affinity"				=> "user",
		"perm_object_type"			=> "module",
		"perm_desc"					=> "defaultPermission description",
		"perm_level"				=> 1,
	);
	//@formatter:on
	
	public function __construct() {
		$this->Permission = $this->getDefaultValues();
	}
	
	/**
	 * Gets article data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the article selection to the website ID only.
	 * @param integer $id
	 */
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
				
		$dbquery = $dbquery = $bts->SDDMObj->query("
			SELECT *
			FROM ".$CurrentSetObj->SqlTableListObj->getSQLTableName('permission')."
			WHERE perm_id = '".$id."'
			;");
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for permission perm_id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { 
					if (isset($this->columns[$A])) { $this->Permission[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for permission perm_id=".$id));
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
			'data'			=> $this->Permission,
			'targetTable'	=> 'permission',
			'targetColumn'	=> 'perm_id',
			'entityId'		=> $this->Permission['perm_id'],
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
		return $this->entityExistsInDb('permission', $this->Permission['perm_id']);
	}
	
	
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$res = true;
//		if ( $this->Permission['validation_state'] < 0 && $this->Permission['validation_state'] > 2) { $res = false; }
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
		
		$tab['perm_id']				=	"";
		$tab['perm_state']			=	1;
		$tab['perm_name'] 			=	"defaultPermission";
		$tab['perm_affinity']		=	"user";
		$tab['perm_object_type']	=	"module";
		$tab['perm_desc']			=	"defaultPermission description";
		$tab['perm_level']			=	1;

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
				0 => array( _MENU_OPTION_DB_ =>	 _FORBIDDEN_,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('forbidden')),
				1 => array( _MENU_OPTION_DB_ =>	 _READ_,		_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('read')),
				2 => array( _MENU_OPTION_DB_ =>	 _WRITE_,		_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('write')),
		));
	}
	
	//@formatter:off
	public function getPermissionEntry ($data) { return $this->Permission[$data]; }
	public function getPermission() { return $this->Permission; }
	
	public function setPermissionEntry ($entry, $data) { 
		if ( isset($this->Permission[$entry])) { $this->Permission[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}
	public function setPermission($Permission) { $this->Permission = $Permission; }
	//@formatter:off
}
?>