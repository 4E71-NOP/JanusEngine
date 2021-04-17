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
class Article extends Entity {
	private $Article = array ();
	
	//@formatter:off
	private $columns = array(
		"arti_id"					=> "",
		"arti_ref"					=> 0,
		"deadline_id"				=> 0,
		"arti_name"					=> "new article",
		"arti_desc"					=> "",
		"arti_title"				=> "Nouvel article",
		"arti_subtitle"				=> "",
		"arti_page"					=> "1",
		
		"layout_generic_name"		=> "default_layout",
		"config_id"					=> 0,
		
		"arti_creator_id"			=> 0,
		"arti_creation_date"		=> 0,
		"arti_validator_id"			=> 0,
		"arti_validation_date"		=> 0,
		"arti_validation_state"		=> "NON_VALIDE",
		
		"arti_release_date"			=> 0,
		"docu_id"					=> 0,
		"ws_id"						=> 0
	);
	//@formatter:on
	
	public function __construct() {
		$this->Article = $this->getDefaultValues();
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
		
		$dbquery = $dbquery = $bts->SDDMObj->query("
			SELECT *
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('article')."
			WHERE arti_id = '".$id."'
			AND ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
			;");
// 			AND arti_page = '".$page."'
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for article arti_id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { 
					if (isset($this->columns[$A])) { $this->Article[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for article arti_id=".$id));
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
			'data'			=> $this->Article,
			'targetTable'	=> 'article',
			'targetColumn'	=> 'arti_id',
			'entityId'		=> $this->Article['arti_id'],
			'entityTitle'	=> 'article'
		);
		if ( $this->existsInDB() === true && $mode == 2 || $mode == 0 ) { $this->genericUpdateDb($genericActionArray);}
		elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) { $this->genericInsertInDb($genericActionArray); }
	}
	
	/**
	 * Verifies if the entity exists in DB.
	 */
	public function existsInDB() {
		return $this->articleExists($this->Article['arti_id']);
	}
	
	
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$res = true;
		if ( $this->Article['validation_state'] < 0 && $this->Article['validation_state'] > 2) { $res = false; }
		if ( $this->Article['arti_creation_date'] == 0 ) { $res = false; }
		
		if ( $this->deadlineExists($this->Article['deadline_id']) == false ) { $res = false; }
		if ( $this->articleConfigExists($this->Article['config_id']) == false ) { $res = false; }
		if ( $this->documentExists($this->Article['docu_id']) == false ) { $res = false; }
		if ( $this->websiteExists($this->Article['ws_id']) == false ) { $res = false; }
		if ( $this->userExists($this->Article['arti_creator_id']) == false ) { $res = false; }
		if ( $this->userExists($this->Article['arti_validator_id']) == false ) { $res = false; }
		
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
		
		$tab['arti_creator_id'] = $tab['arti_validator_id'] = $CurrentSetObj->getInstanceOfUserObj()->getUserEntry('user_id');
		$tab['arti_creation_date'] = $tab['arti_creation_date'] = $tab['arti_validation_date'] = $date;
		
		$tab['ws_id'] = ($bts->CMObj->getExecutionContext() == 'render')
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
	public function getArticleEntry ($data) { return $this->Article[$data]; }
	public function getArticle() { return $this->Article; }
	
	public function setArticleEntry ($entry, $data) { 
		if ( isset($this->Article[$entry])) { $this->Article[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}
	public function setArticle($Article) { $this->Article = $Article; }
	//@formatter:off
}
?>