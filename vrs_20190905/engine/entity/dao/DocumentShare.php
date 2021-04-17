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
class DocumentShare extends Entity{
	private $DocumentShare = array ();
	
	//@formatter:off
	private $columns = array(
			'share_id'				=> 0,
			'docu_id'				=> 0,
			'ws_id'					=> 0,
			'share_modification'	=> 0,
	);
	//@formatter:on
	
	public function __construct() {
		$this->DocumentShare = $this->getDefaultValues();
	}
	
	/**
	 * Gets DocumentShare data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the document selection to the website ID only.
	 * @param integer $id
	 */
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query ( "
			SELECT *
			FROM " . $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName ('document_share') . "
			WHERE share_id = '" . $id . "'
			;" );
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for document_share id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->DocumentShare[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for document_share id=".$id));
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
			'data'			=> $this->DocumentShare,
			'targetTable'	=> 'document_share',
			'targetColumn'	=> 'share_id',
			'entityId'		=> $this->DocumentShare['share_id'],
			'entityTitle'	=> 'documentShare'
		);
		if ( $this->existsInDB() === true && $mode == 2 || $mode == 0 ) { $this->genericUpdateDb($genericActionArray);}
		elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) { $this->genericInsertInDb($genericActionArray); }
	}


	/**
	 * Verifies if the entity exists in DB.
	 */
	public function existsInDB() {
		return $this->documentShareExists($this->DocumentShare['share_id']);
	}
	
	
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$res = true;
		
		if ( $this->documentExists($this->DocumentShare['docu_id']) == false ) { $res = false; }
		if ( $this->websiteExists($this->DocumentShare['ws_id']) == false ) { $res = false; }

		return $res;
	}
	
	
	/**
	 * Returns the default values of this type (this is consistent witht de SQL model and it should stay that way)
	 * @return array()
	 */
	public function getDefaultValues () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$tab = $this->columns;

		$tab['ws_id'] = ($bts->CMObj->getExecutionContext() == 'render')
		? $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')
		: $CurrentSetObj->getInstanceOfWebSiteContextObj()->getWebSiteEntry('ws_id');
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
			'state' => array (
				0 => array( MenuOptionDb =>	 0,	MenuOptionSelected => '',	MenuOptionTxt => $bts->I18nObj->getI18nEntry('offline')),
				1 => array( MenuOptionDb =>	 1,	MenuOptionSelected => '',	MenuOptionTxt => $bts->I18nObj->getI18nEntry('online')),
				2 => array( MenuOptionDb =>	 2,	MenuOptionSelected => '',	MenuOptionTxt => $bts->I18nObj->getI18nEntry('disabled')),
			));
	}
	
	//@formatter:off
	public function getDocumentShareEntry ($data) { return $this->DocumentShare[$data]; }
	public function getDocumentShare() { return $this->DocumentShare; }
	
	public function setDocumentShareEntry ($entry, $data) { 
		if ( isset($this->DocumentShare[$entry])) { $this->DocumentShare[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}
	
	public function setDocumentShare($DocumentShare) { $this->DocumentShare = $DocumentShare; }
	//@formatter:off
	
}


?>