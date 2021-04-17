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
/**
 * Base skeleton of entities
 * @author faust
 *
 */
class Entity {
	
	public function __construct() {	}

	
	/**
	 * Returns the current website depending on the context
	 * @return number
	 */
	public function getCurrentWebsite () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		return ($bts->CMObj->getExecutionContext() == 'render')
			? $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')
			: $CurrentSetObj->getInstanceOfWebSiteContextObj()->getWebSiteEntry('ws_id');
	}
	
	
	/**
	 * Insert in Db according to data in the array
	 * @param array $data
	 */
	public function genericInsertInDb ($data) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
// 		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : QueryColumnDescription - ".$bts->StringFormatObj->arrayToString($QueryColumnDescription) ));
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : ".$data['entityTitle']." already exist in DB. Updating Id=".$data['entityId']));
		$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($data['columns'], $data['data']);
		
		$bts->SDDMObj->query("
			INSERT INTO ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName($data['targetTable'])."
			(".$QueryColumnDescription['columns'].")
			VALUES
			(".$QueryColumnDescription['values'].")
			;");
	}
	
	public function genericUpdateDb ($data) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : ".$data['entityTitle']." doesn't exist in DB. Inserting Id=".$data['entityId']));
		$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($data['columns'], $data['data']);
		$bts->SDDMObj->query("
			UPDATE ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName($data['targetTable'])." a
			SET ".$QueryColumnDescription['equality']."
			WHERE a.".$data['targetColumn']." ='".$data['entityId']."'
			;");
	}
	
	/**
	 * Finds an entity filtering on the specified table and columns.
	 * It doesn't filter on any other parameter.
	 * @param array $t
	 * @return boolean
	 */
	private function findEntryInDb ($t) {
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Looking for ".$t['column']." = ".$t['id']." in ".$t['table']));
		$res = true;
		
		$dbquery = $bts->SDDMObj->query("
			SELECT ".$t['column']." FROM ".$t['table']."
			WHERE ".$t['column']." = ".$t['id']."
			LIMIT 1;");
		if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {$res = false; }
		return $res;
	}
	
	/**
	 * Returns true if the article id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function articleExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('article'),
			'column'	=> 'arti_id',
			'id'		=> $id,
			)
		);
	}
	
	/**
	 * Returns true if the articleConfig id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function articleConfigExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('article_config'),
			'column'	=> 'config_id',
			'id'		=> $id,
			)
		);
	}
	
	
	/**
	 * Returns true if the articleConfig id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function articleTagExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('article_tag'),
			'column'	=> 'article_tag_id',
			'id'		=> $id,
			)
		);
	}
	
	
	/**
	 * Returns true if the category id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function categoryExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('category'),
			'column'	=> 'cate_id',
			'id'		=> $id,
			)
		);
	}
	
	
	/**
	 * Returns true if the category id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function deadlineExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('deadline'),
			'column'	=> 'deadline_id',
			'id'		=> $id,
			)
		);
	}
	
	
	/**
	 * Returns true if the category id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function decorationExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('decoration'),
			'column'	=> 'deco_id',
			'id'		=> $id,
			)
		);
	}
	
		/**
	 * Returns true if the category id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function definitionExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('definition'),
			'column'	=> 'def_id',
			'id'		=> $id,
			)
		);
	}	
	
	/**
	 * Returns true if the category id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function documentExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('document'),
			'column'	=> 'docu_id',
			'id'		=> $id,
			)
		);
	}
	
	/**
	 * Returns true if the category id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function documentShareExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('document_share'),
			'column'	=> 'share_id',
			'id'		=> $id,
			)
		);
	}
	
	
	/**
	 * Returns true if the category id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function extensionExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('extension'),
			'column'	=> 'extension_id',
			'id'		=> $id,
			)
		);
	}
	
	
	
	/**
	 * Returns true if the category id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function extensionConfigExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('extension_config'),
			'column'	=> 'config_id',
			'id'		=> $id,
			)
		);
	}
	
	
	/**
	 * Returns true if the dependency_id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function extensiondependencyExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('extension_dependency'),
			'column'	=> 'dependency_id',
			'id'		=> $id,
			)
		);
	}
	
	
	/**
	 * Returns true if the file_id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function extensionFileExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('extension_file'),
			'column'	=> 'file_id',
			'id'		=> $id,
			)
		);
	}
	
	/**
	 * Returns true if the file_id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function groupExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('group'),
			'column'	=> 'group_id',
			'id'		=> $id,
			)
		);
	}
	
	
	/**
	 * Returns true if the file_id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function groupUserExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('group_user'),
			'column'	=> 'group_user_id',
			'id'		=> $id,
			)
		);
	}

	/**
	 * Returns true if the file_id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function groupWebsiteExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('group_website'),
			'column'	=> 'group_website_id',
			'id'		=> $id,
			)
		);
	}

	/**
	 * Returns true if the file_id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function i18nExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('i18n'),
			'column'	=> 'i18n_id',
			'id'		=> $id,
			)
		);
	}
	
	/**
	 * Returns true if the keyword exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function keywordExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('keyword'),
			'column'	=> 'keyword_id',
			'id'		=> $id,
			)
		);
	}
	
	/**
	 * Returns true if the lang_id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function languageExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('language'),
			'column'	=> 'lang_id',
			'id'		=> $id,
			)
		);
	}
	
	/**
	 * Returns true if the lang_id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function LanguageWebsiteExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('language_website'),
			'column'	=> 'lang_website_id',
			'id'		=> $id,
			)
		);
	}
	
	/**
	 * Returns true if the lang_id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function layoutExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('layout'),
			'column'	=> 'layout_id',
			'id'		=> $id,
			)
		);
	}
	
	/**
	 * Returns true if the lang_id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function layoutContentExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('layout_content'),
			'column'	=> 'lyoc_id',
			'id'		=> $id,
			)
		);
	}
	
	/**
	 * Returns true if the module exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function moduleExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('module'),
			'column'	=> 'module_id',
			'id'		=> $id,
			)
		);
	}
	
	/**
	 * Returns true if the module exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function moduleWebsiteExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('module_website'),
			'column'	=> 'module_website_id',
			'id'		=> $id,
			)
		);
	}
	
	
	/**
	 * Returns true if the note_id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function noteExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('note'),
			'column'	=> 'note_id',
			'id'		=> $id,
			)
		);
	}
	
	
	/**
	 * Returns true if the tag_id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function tagExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('tag'),
			'column'	=> 'tag_id',
			'id'		=> $id,
			)
		);
	}
	
	/**
	 * Returns true if the theme_id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function themeDescriptorExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_descriptor'),
			'column'	=> 'theme_id',
			'id'		=> $id,
			)
		);
	}
	
	/**
	 * Returns true if the theme_id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function themeWebsiteExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('theme_website'),
			'column'	=> 'theme_website_id',
			'id'		=> $id,
			)
		);
	}
	
	/**
	 * Returns true if the user_id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function userExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('user'),
			'column'	=> 'user_id',
			'id'		=> $id,
			)
		);
	}
	
	
	/**
	 * Returns true if the website_id exists in the DB.
	 * @param int $id
	 * @return boolean
	 */
	public function websiteExists($id) {
		$CurrentSetObj = CurrentSet::getInstance();
		return $this->findEntryInDb( array (
			'table' 	=> $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('website'),
			'column'	=> 'ws_id',
			'id'		=> $id,
			)
		);
	}
	
	
	
	
	
	
}