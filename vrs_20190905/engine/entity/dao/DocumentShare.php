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
class DocumentShare {
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
		$this->Decoration = $this->getDefaultValues();
	}
	
	/**
	 * Gets document_share data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the document selection to the website ID only.
	 * @param integer $id
	 */
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query ( "" );
		while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
			foreach ( $dbp as $A => $B ) {
				if (isset($this->columns[$A])) { $this->DocumentShare[$A] = $B; }
			}
		}
		
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
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		if ( $this->existsInDB() === true && $mode == 2 || $mode == 0 ) {
			$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($this->columns, $this->DocumentShare);
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : QueryColumnDescription - ".$bts->StringFormatObj->arrayToString($QueryColumnDescription) ));
			
			$bts->SDDMObj->query("
			UPDATE ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('document_share')." ds
			SET ".$QueryColumnDescription['equality']."
			WHERE ds.share_id ='".$this->DocumentShare['share_id']."'
			;
			");
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : document_share already exist in DB. Updating Id=".$this->DocumentShare['share_id']));
		}
		elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) {
			$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($this->columns, $this->DocumentShare);
			$bts->SDDMObj->query("
				INSERT INTO ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('document_share')."
				(".$QueryColumnDescription['columns'].")
				VALUES
				(".$QueryColumnDescription['values'].")
				;
			");
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : document_share doesn't exist in DB. Inserting Id=".$this->DocumentShare['share_id']));
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
			SELECT ds.share_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('document_share')." ds
			WHERE ds.share_id ='".$this->DocumentShare['share_id']."';
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
			SELECT ws_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('website')."
			WHERE ws_id = ".$this->DocumentShare['ws_id']."
			LIMIT 1;"
				);
		if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {$res = false; }
		
		$dbquery = $bts->SDDMObj->query("
			SELECT d.docu_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('document')." d
			WHERE d.docu_id ='".$this->Decoration['docu_id']."';
		");
		if ( $bts->SDDMObj->num_row_sql($dbquery) == 1 ) { $res = false; }
		
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