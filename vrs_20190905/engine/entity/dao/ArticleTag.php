<?php
// // @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see       : https://github.com/4E71-NOP/JanusEngine
//
// @license   : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author    : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note      : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//              without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end


class ArticleTag extends Entity {
	private $ArticleTag = array ();

		//@formatter:off
		private $columns = array(
			"article_tag_id"		=> "",
			"arti_id"				=> "",
			"tag_id"				=> "",
		);
		//@formatter:on

	public function __construct() {
		$this->ArticleTag = $this->getDefaultValues();
	}
	public function getDataFromDB($id) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;

		$dbquery = $bts->SDDMObj->query ( "SELECT "
			. "CONCAT('0x', HEX(article_tag_id)) AS article_tag_id, "
			. "CONCAT('0x', HEX(fk_arti_id)) AS fk_arti_id, "
			. "CONCAT('0x', HEX(fk_tag_id)) AS fk_tag_id "
			. "FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName ('article_tag') . " "
			. "WHERE article_tag_id = " . $id
			. ";" );
		if ( $bts->SDDMObj->num_row_sql($dbquery) != 0 ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for article_tag id=".$id));
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) { $this->ArticleTag[$A] = $B; }
			}
		}
		else {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for article_tag id=".$id));
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
			'data'			=> $this->ArticleTag,
			'targetTable'	=> 'article',
			'targetColumn'	=> 'article_tag_id',
			'entityId'		=> $this->ArticleTag['article_tag_id'],
			'entityTitle'	=> 'articleTag'
		);
		if ($this->existsInDB() === true && ($mode == OBJECT_SENDTODB_MODE_UPDATEONLY || $mode == OBJECT_SENDTODB_MODE_DEFAULT)) {
			$res = $this->genericUpdateDb($genericActionArray);
		} elseif ($this->existsInDB() === false && ($mode == OBJECT_SENDTODB_MODE_INSERTONLY || $mode == OBJECT_SENDTODB_MODE_DEFAULT)) {
			$res = $this->genericInsertInDb($genericActionArray);
		}

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
		
	}
	
	/**
	 * Verifies if the entity exists in DB.
	 */
	public function existsInDB() {
		return $this->entityExistsInDb('article_tag', $this->ArticleTag['article_tag_id']);
	}
		
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$res = true;
		if ( $this->entityExistsInDb('article', $this->ArticleTag['arti_id']) == false ) { $res = false; }
		if ( $this->entityExistsInDb('tag', $this->ArticleTag['tag_id']) == false ) { $res = false; }
		
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
		
		$tab['arti_creator_id'] = $tab['arti_validator_id'] = $CurrentSetObj->UserObj->getUserEntry('user_id');
		$tab['arti_creation_date'] = $tab['arti_creation_date'] = $tab['arti_validation_date'] = $date;
		
		$tab['ws_id'] = ($bts->CMObj->getExecutionContext() == 'render')
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
		return array ( 
			'state' => array (
				0 => array( _MENU_OPTION_DB_ =>	 0,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('offline')),
				1 => array( _MENU_OPTION_DB_ =>	 1,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('online')),
				2 => array( _MENU_OPTION_DB_ =>	 2,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('disabled')),
		));
	}
	
	//@formatter:off
	public function getArticleTagEntry ($data) { return $this->ArticleTag[$data]; }
	public function getArticleTag() { return $this->ArticleTag; }
	
	public function setArticleTagEntry ($entry, $data) { 
		if ( isset($this->ArticleTag[$entry])) { $this->ArticleTag[$entry] = $data; }	//DB Entity objects do NOT accept new columns!  
	}

	public function setArticleTag($ArticleTag) { $this->ArticleTag = $ArticleTag; }
	//@formatter:off

}


?>