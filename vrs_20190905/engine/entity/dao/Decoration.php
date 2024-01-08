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
class Decoration extends Entity {
	private $Decoration = array ();
	
	//@formatter:off
	private $columns = array(
		"deco_id"			=> "",
		"deco_name"			=> "New Decoration",
		"deco_state"		=> 1,
		"deco_type"			=> 20,
		"deco_id"			=> 0,
	);
	//@formatter:on
	
	public function __construct() {	
		$this->Decoration = $this->getDefaultValues();
	}
	
	/**
	 * Gets decoration data from the database.<br>
	 * @param integer $id
	 */
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
				
		$dbquery = $bts->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ('decoration') . "
			WHERE deco_id = '" . $id . "'
			;" );
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for <neddle> id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->Decoration[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for <neddle> id=".$id));
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
				'data'			=> $this->Decoration,
				'targetTable'	=> 'decoration',
				'targetColumn'	=> 'deco_id',
				'entityId'		=> $this->Decoration['deco_id'],
				'entityTitle'	=> 'decoration'
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
		return $this->entityExistsInDb('decoration', $this->Decoration['deco_id']);
	}
	
	
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$res = true;
		if ( $this->Decoration['deco_state'] < 0 && $this->Decoration['deco_state'] > 2) { $res = false; }
		
		return $res;
	}
	
	
	/**
	 * Returns the default values of this type (this is consistent witht de SQL model and it should stay that way)
	 * @return array()
	 */
	public function getDefaultValues () {
		return $this->columns;
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
				0 => array( _MENU_OPTION_DB_ =>	 0,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('offline')),
				1 => array( _MENU_OPTION_DB_ =>	 1,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('online')),
				2 => array( _MENU_OPTION_DB_ =>	 2,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('disabled')),
			),
			'type' => array (
				10 => array( _MENU_OPTION_DB_ => 'menu',		_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('menu')),
				20 => array( _MENU_OPTION_DB_ => 'caligraph',	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('caligraph')),
				30 => array( _MENU_OPTION_DB_ => '1_div',		_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('1_div')),
				40 => array( _MENU_OPTION_DB_ => 'elegance',	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('elegance')),
				50 => array( _MENU_OPTION_DB_ => 'exquisite',	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('exquisite')),
				60 => array( _MENU_OPTION_DB_ => 'elysion',		_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('elysion')),
			)
		);
	}
	
	//@formatter:off
	public function getDecorationEntry ($data) { return $this->Decoration[$data]; }
	public function getDecoration() { return $this->Decoration; }
	
	public function setDecorationEntry ($entry, $data) { 
		if ( isset($this->Decoration[$entry])) { $this->Decoration[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setDecoration($Decoration) { $this->Decoration = $Decoration; }
	//@formatter:off

}


?>