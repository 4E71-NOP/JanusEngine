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
class Article extends Entity {
	private $Article = array ();
	
	//@formatter:off
	private $columns = array(
		"arti_id"					=> "",
		"arti_ref"					=> "new article ref",
		"fk_deadline_id"			=> "",
		"arti_name"					=> "new article name",
		"arti_desc"					=> "",
		"arti_title"				=> "New article",
		"arti_subtitle"				=> "",
		"arti_page"					=> 1,
		
		"layout_generic_name"		=> "default",
		"config_id"					=> "",
		
		"arti_creator_id"			=> "",
		"arti_creation_date"		=> "",
		"arti_validator_id"			=> "",
		"arti_validation_date"		=> "",
		"arti_validation_state"		=> _NOT_VALIDATED_,
		
		"arti_release_date"			=> 0,
		"fk_docu_id"				=> "",
		"fk_ws_id"					=> ""
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
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;
		
		$dbquery = $dbquery = $bts->SDDMObj->query("
			SELECT *
			FROM ".$CurrentSetObj->SqlTableListObj->getSQLTableName('article')."
			WHERE arti_id = '".$id."'
			;");
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for article arti_id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { 
					if (isset($this->columns[$A])) { $this->Article[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for article arti_id=".$id));
			$res = false;
		}
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}
	
	/**
	 * Updates or inserts in DB the local data.
	 * mode are available: <br>
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
			'data'			=> $this->Article,
			'targetTable'	=> 'article',
			'targetColumn'	=> 'arti_id',
			'entityId'		=> $this->Article['arti_id'],
			'entityTitle'	=> 'article'
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
		return $this->entityExistsInDb('article', $this->Article['arti_id']);
	}
	
	
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$res = true;
		if ( $this->Article['validation_state'] < 0 && $this->Article['validation_state'] > 2) { $res = false; }
		if ( $this->Article['arti_creation_date'] == 0 ) { $res = false; }
		
		if ( $this->entityExistsInDb('deadline', $this->Article['deadline_id']) == false )		{ $res = false; }
		if ( $this->entityExistsInDb('article_config', $this->Article['config_id']) == false )	{ $res = false; }
		if ( $this->entityExistsInDb('document', $this->Article['fk_docu_id']) == false )		{ $res = false; }
		if ( $this->entityExistsInDb('website', $this->Article['fk_ws_id']) == false )			{ $res = false; }
		if ( $this->entityExistsInDb('user', $this->Article['arti_creator_id']) == false )		{ $res = false; }
		if ( $this->entityExistsInDb('user', $this->Article['arti_validator_id']) == false )	{ $res = false; }
		
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
		
		$tab['arti_name']	= "New article name ".$date;
		$tab['arti_title']	= "New article title ".$date;
		$tab['arti_ref']	= "New article ref ".$date;
		$tab['arti_creator_id']		= $tab['arti_validator_id'] = $CurrentSetObj->UserObj->getUserEntry('user_id');
		$tab['arti_creation_date']	= $tab['arti_creation_date'] = $tab['arti_validation_date'] = $date;
		
		$tab['fk_ws_id'] = ($bts->CMObj->getExecutionContext() == 'render')
			? $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id')
			: $CurrentSetObj->WebSiteContextObj->getWebSiteEntry('ws_id');
		return $tab;
	}
	
	/**
	 * Returns an array containing the list of states for this entity.
	 * Useful for menu select amongst other things.
	 * @return array()
	 */
	public function getMenuOptionArray () {
		$bts = BaseToolSet::getInstance();
		// $CurrentSetObj = CurrentSet::getInstance();
		return array ( 
			'validation' => array (
				0 => array( _MENU_OPTION_DB_ =>	 0,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('invalid')),
				1 => array( _MENU_OPTION_DB_ =>	 1,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('valid')),
			),
			'state' => array (
				0 => array( _MENU_OPTION_DB_ =>	 0,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('offline')),
				1 => array( _MENU_OPTION_DB_ =>	 1,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('online')),
				2 => array( _MENU_OPTION_DB_ =>	 2,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('disabled')),
			),
		);
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