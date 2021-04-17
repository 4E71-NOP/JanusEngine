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
class Category extends Entity {
	private $Category = array ();
	
	//@formatter:off
	private $columns = array(
		"cate_id"				=> "",
		"cate_name"				=> "New category",
		"cate_title"			=> "New category",
		"cate_desc"				=> "New category",
		"cate_type"				=> "ARTICLE",
		"ws_id"					=> 0,
		"lang_id"				=> 0,
		"deadline_id"			=> 0,
		"cate_state"			=> 0,
		"cate_parent"			=> 0,
		"cate_position"			=> "",
		"group_id"				=> 0,
		"cate_last_update"		=> 0,
		"cate_role"				=> 0,
		"cate_initial_document"	=> 0,
		"cate_slug"				=> "",
		"arti_ref"				=> 0,
		
	);
	//@formatter:on
	
	public function __construct() {
		$this->Category= $this->getDefaultValues();
	}
	
	/**
	 * Gets category data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the category selection to the website ID only. 
	 * @param integer $id
	 */
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$dbquery = $dbquery = $bts->SDDMObj->query("
			SELECT * 
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('category')." 
			WHERE cate_id = '".$id."'
			AND ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
		;");
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for category id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->Category[$A] = $B; }
				}
			}
		}
		else {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for category id=".$id));
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
				'data'			=> $this->Category,
				'targetTable'	=> 'category',
				'targetColumn'	=> 'cate_id',
				'entityId'		=> $this->Category['cate_id'],
				'entityTitle'	=> 'category'
		);
		if ( $this->existsInDB() === true && $mode == 2 || $mode == 0 ) { $this->genericUpdateDb($genericActionArray);}
		elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) { $this->genericInsertInDb($genericActionArray); }
		
	}
	
	/**
	 * Verifies if the entity exists in DB.
	 */
	public function existsInDB() {
		return $this->categoryExists($this->Category['cate_id']);

	}
	
	
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$res = true;
		if ( $this->Category['lang_id'] == 0) { $res = false; }
		if ( $this->Category['deadline_id'] == 0) { $res = false; }
		if ( $this->Category['cate_state'] < 0 && $this->Category['cate_state'] > 2) { $res = false; }
		if ( $this->Category['group_id'] == 0) { $res = false; }
		if ( $this->Category['cate_last_modif'] == 0) { $res = false; }
		if ( $this->Category['cate_parent'] != 0 || $this->Category['cate_parent'] != null ) {
			if ( $this->categoryExists($this->Category['cate_parent'] ) == false ) { $res = false; }
		}
		if ( $this->websiteExists($this->Category['ws_id']) == false ) { $res = false; }
		if ( $this->groupExists($this->Category['group_id']) == false ) { $res = false; }
		if ( $this->deadlineExists($this->Category['deadline_id']) == false ) { $res = false; }
		
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
		$tab['cate_last_modif'] = $date;
		
		$tab['ws_id'] = ($bts->CMObj->getExecutionContext() == 'render') 
			? $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')
			: $CurrentSetObj->getInstanceOfWebSiteContextObj()->getWebSiteEntry('ws_id');
		
		$tab['user_id'] = $CurrentSetObj->getInstanceOfUserObj()->getUserEntry('user_id');
		$tab['lang_id'] = ($bts->CMObj->getExecutionContext() == 'render')
			? $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('lang_id')
			: $CurrentSetObj->getInstanceOfWebSiteContextObj()->getWebSiteEntry('lang_id');
		
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
				0 => array( MenuOptionDb =>	 0,	MenuOptionSelected => '',	MenuOptionTxt => $bts->I18nTransObj->getI18nTransEntry('offline')),
				1 => array( MenuOptionDb =>	 1,	MenuOptionSelected => '',	MenuOptionTxt => $bts->I18nTransObj->getI18nTransEntry('online')),
				2 => array( MenuOptionDb =>	 2,	MenuOptionSelected => '',	MenuOptionTxt => $bts->I18nTransObj->getI18nTransEntry('disabled')),
			));
	}
	
	//@formatter:off
	public function getCategoryEntry ($data) { return $this->Category[$data]; }
	public function getCategory() { return $this->Category; }
	
	public function setCategoryEntry ($entry, $data) { 
		if ( isset($this->Category[$entry])) { $this->Category[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setCategory($Category) { $this->Category = $Category; }
	//@formatter:off

}


?>