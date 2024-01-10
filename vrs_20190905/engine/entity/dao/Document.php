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
class Document extends Entity{
	private $Document = array ();
	private $Decoration = array();
	
	//@formatter:off
	private $columns = array(
		'docu_id'				=> 0,
		'docu_name'				=> 0,
		'docu_type'				=> 1,
		'docu_origin'			=> 0,
		'docu_creator'			=> 0,
		'docu_creation_date'	=> 0,
		'docu_validation'		=> 0,
		'docu_validator'		=> 0,
		'docu_validation_date'	=> 0,
		'docu_cont'				=> 0,
	);
	//@formatter:on
	
	public function __construct() {
		$this->Decoration = $this->getDefaultValues();
	}
	
	/**
	 * Gets document data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the document selection to the website ID only.
	 * @param integer $id
	 */
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
				
		$dbquery = $dbquery = $bts->SDDMObj->query("
			SELECT doc.*, shr.share_modification 
			FROM ".$CurrentSetObj->SqlTableListObj->getSQLTableName('document')." doc, "
			.$CurrentSetObj->SqlTableListObj->getSQLTableName('document_share')." shr 
			WHERE doc.docu_id = '".$id."' 
			AND shr.fk_ws_id = '".$CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id')."' 
			AND shr.fk_docu_id = doc.docu_id 
			AND doc.docu_origin = '".$CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id')."' 
		;");
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for document id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->Document[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for document id=".$id));
			$res = false;
		}

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}
	
	/**
	 * Gets document data from the database.<br>
	 * <br>
	 * Does not check for Origin. It's useful for admin management.
	 * @param integer $id
	 */
	public function getDataFromDBNoOriginCheck($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
		
		$dbquery = $dbquery = $bts->SDDMObj->query("
			SELECT doc.*, shr.share_modification 
			FROM ".$CurrentSetObj->SqlTableListObj->getSQLTableName('document')." doc, "
			.$CurrentSetObj->SqlTableListObj->getSQLTableName('document_share')." shr 
			WHERE shr.fk_ws_id = '".$CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id')."' 
			AND doc.docu_id = '".$id."' 
			AND shr.fk_docu_id = doc.docu_id 
		;");
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for document id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->Document[$A] = $B; }
				}
			}
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
		
		$tmp = $this->Document['docu_cont'];
		$this->Document['docu_cont'] = $bts->SDDMObj->escapeString($tmp); 
		$genericActionArray = array(
				'columns'		=> $this->columns,
				'data'			=> $this->Document,
				'targetTable'	=> 'document',
				'targetColumn'	=> 'docu_id',
				'entityId'		=> $this->Document['docu_id'],
				'entityTitle'	=> 'document'
		);
		if ( $this->existsInDB() === true && $mode == 2 || $mode == 0 ) { $res = $this->genericUpdateDb($genericActionArray);}
		elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) { $res = $this->genericInsertInDb($genericActionArray); }
		$this->Document['docu_cont'] = $tmp;

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}
	
	/**
	 * Verifies if the entity exists in DB.
	 */
	public function existsInDB() {
		return $this->entityExistsInDb('document', $this->Document['docu_id']);
 	}
	
	
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$res = true;
		if ( $this->entityExistsInDb('user', $this->Document['docu_creator']) == false ) { $res = false; }
		if ( $this->entityExistsInDb('user', $this->Document['docu_validator']) == false ) { $res = false; }
		
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
		
		$tab['docu_origin'] = ($bts->CMObj->getExecutionContext() == 'render')
			? $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id')
			: $CurrentSetObj->WebSiteContextObj->getWebSiteEntry('ws_id');
		
		$tab['docu_creator'] = $CurrentSetObj->UserObj->getUserEntry('user_id');
		$tab['docu_creation_date'] = $date;
		
		$tab['docu_validator'] = $CurrentSetObj->UserObj->getUserEntry('user_id');
		$tab['docu_validation_date'] = $date;
		
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
			'type' => array (
				0 => array( _MENU_OPTION_DB_ =>	 "HTML",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('type0')),
				1 => array( _MENU_OPTION_DB_ =>	 "PHP",		_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('type1')),
				2 => array( _MENU_OPTION_DB_ =>	 "MIXED",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('type2')),
				// 3 => array( _MENU_OPTION_DB_ =>	 "WMCODE",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('type0')),
			),
			'yesno' => array (
				0 => array( _MENU_OPTION_DB_ =>	 "NO",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('no')),
				1 => array( _MENU_OPTION_DB_ =>	 "YES",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('yes')),	
			),
			'state' => array (
				0 => array( _MENU_OPTION_DB_ =>	 0,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('offline')),
				1 => array( _MENU_OPTION_DB_ =>	 1,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('online')),
				2 => array( _MENU_OPTION_DB_ =>	 2,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('disabled')),
			));
	}
	
	//@formatter:off
	public function getDocumentEntry ($data) { return $this->Document[$data]; }
	public function getDocument() { return $this->Document; }
	
	public function setDocumentEntry ($entry, $data) { 
		if ( isset($this->Document[$entry])) { $this->Document[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}
	
	public function setDocument($Document) { $this->Document = $Document; }
	//@formatter:off

}


?>