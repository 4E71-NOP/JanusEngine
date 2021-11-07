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
class LayoutFile extends Entity {
	private $LayoutFile = array ();
	
	//@formatter:off
	private $columns = array(
		'layoutfile_id'			=> 0,
		'layoutfile_name'			=> "New Layout",
		'layoutfile_generic_name'	=> "NewLyt",
		'layoutfile_filename'		=> "LayoutFileName.lyt.html",
		'layoutfile_desc'			=> "Desc",
	);
	//@formatter:on
	
	public function __construct() {
		$this->LayoutFile = $this->getDefaultValues();
	}
	
	/**
	 * Gets layout data from the database.<br>
	 * @param integer $id
	 */
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ('layoutfile') . "
			WHERE layoutfile_id = '" . $id . "'
			;" );
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for layoutfile id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->LayoutFile[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for layoutfile id=".$id));
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
			'data'			=> $this->LayoutFile,
			'targetTable'	=> 'layoutfile',
			'targetColumn'	=> 'layoutfile_id',
			'entityId'		=> $this->LayoutFile['layoutfile_id'],
			'entityTitle'	=> 'layout file'
		);
		if ( $this->existsInDB() === true && $mode == 2 || $mode == 0 ) { $this->genericUpdateDb($genericActionArray);}
		elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) { $this->genericInsertInDb($genericActionArray); }
	}
	
	/**
	 * Verifies if the entity exists in DB.
	 */
	public function existsInDB() {
		return $this->layoutExists($this->LayoutFile['layoutfile_id']);
	}
	
	
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$res = true;
		
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
		$this->LayoutFile['layoutfile_name'] .= "-".date("d_M_Y_H:i:s", time());
		
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
				0 => array( _MENU_OPTION_DB_ =>	 0,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('offline')),
				1 => array( _MENU_OPTION_DB_ =>	 1,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('online')),
				2 => array( _MENU_OPTION_DB_ =>	 2,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('disabled')),
			));
	}
	
	
	//@formatter:off
	public function getLayoutFileEntry ($data) { return $this->LayoutFile[$data]; }
	public function getLayoutFile() { return $this->LayoutFile; }
	
	public function setLayoutFileEntry ($entry, $data) { 
		if ( isset($this->LayoutFile[$entry])) { $this->LayoutFile[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setLayoutFile($LayoutFile) { $this->LayoutFile = $LayoutFile; }
	//@formatter:off

}


?>