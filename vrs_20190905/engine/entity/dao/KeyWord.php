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
class KeyWord {
	private $KeyWord = array ();
	
	//@formatter:off
	private $columns = array(
		'keyword_id'		=> 0,
		'keyword_state'		=> 0,
		'keyword_name'		=> 'new Keyword',
		'arti_id'			=> 0,
		'ws_id'				=> 0,
		'keyword_string'	=> "",
		'keyword_count'		=> 0,
		'keyword_type'		=> 0,
		'keyword_data'		=> 0,
	);
	//@formatter:on
	
	public function __construct() {
		$this->KeyWord= $this->getDefaultValues();
	}
	
	/**
	 * Gets keyword data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the keyword selection to the website ID only.
	 * @param integer $id
	 */
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $bts->SDDMObj->query("
			SELECT *
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('keyword')."
			WHERE keyword_id = '".$id."'
			AND ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
		;");
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for keyword id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->KeyWord[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for keyword id=".$id));
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
			$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($this->columns, $this->KeyWord);
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : QueryColumnDescription - ".$bts->StringFormatObj->arrayToString($QueryColumnDescription) ));
			
			$bts->SDDMObj->query("
			UPDATE ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('keyword')." k
			SET ".$QueryColumnDescription['equality']."
			WHERE k.keyword_id ='".$this->KeyWord['keyword_id']."'
			;
			");
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : keyword already exist in DB. Updating Id=".$this->KeyWord['keyword_id']));
		}
		elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) {
			$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($this->columns, $this->KeyWord);
			$bts->SDDMObj->query("
				INSERT INTO ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('keyword')."
				(".$QueryColumnDescription['columns'].")
				VALUES
				(".$QueryColumnDescription['values'].")
				;
			");
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : keyword doesn't exist in DB. Inserting Id=".$this->KeyWord['keyword_id']));
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
			SELECT k.keyword_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('keyword')." k
			WHERE k.keyword_id ='".$this->KeyWord['keyword_id']."';
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
		if ( $this->KeyWord['keyword_type'] < 0 && $this->KeyWord['keyword_type'] > 3) { $res = false; }
		
		$dbquery = $bts->SDDMObj->query("
			SELECT a.article_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('article')." a
			WHERE a.article_id ='".$this->Article['article_id']."';
		");
		if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {$res = false; }
		
		$dbquery = $bts->SDDMObj->query("
			SELECT ws_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('website')."
			WHERE ws_id = ".$this->KeyWord['ws_id']."
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
		$this->Group['keyword_name'] .= "-".date("d_M_Y_H:i:s", time());
		
		$this->KeyWord['ws_id'] = ($bts->CMObj->getExecutionContext() == 'render')
			? $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')
			: $CurrentSetObj->getInstanceOfWebSiteContextObj()->getWebSiteEntry('ws_id');
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
	public function getKeyWordEntry ($data) { return $this->KeyWord[$data]; }
	public function getKeyWord() { return $this->KeyWord; }
	
	public function setKeyWordEntry ($entry, $data) { 
		if ( isset($this->KeyWord[$entry])) { $this->KeyWord[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setKeyWord($KeyWord) { $this->KeyWord = $KeyWord; }
	//@formatter:off

}


?>