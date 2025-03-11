<?php
/* JanusEngine-license-start */
// --------------------------------------------------------------------------------------------
//
// Janus Engine - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/* JanusEngine-license-end */

/**
 * Base skeleton of entities
 * @author faust
 *
 */
class Entity
{
	private $LastExecutionReport = array();
	private $infos_config = array();
	private $infos = array();

	public function __construct() {}

	/**
	 * Returns the current website id depending on the context
	 * @return number
	 */
	public function getCurrentWebsite()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		return ($bts->CMObj->getExecutionContext() == 'render')
			? $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id')
			: $CurrentSetObj->WebSiteContextObj->getWebSiteEntry('ws_id');
	}

	/**
	 * Insert in Db according to data in the array
	 * @param array $data
	 */
	public function genericInsertInDb($data)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$res = true;

		// 		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : QueryColumnDescription - ".$bts->StringFormatObj->arrayToString($QueryColumnDescription) ));
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : " . $data['entityTitle'] . " doesn't exist in DB. Inserting Id=" . $data['entityId']));
		$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($data['columns'], $data['data']);

		$bts->SDDMObj->query("
			INSERT INTO " . $CurrentSetObj->SqlTableListObj->getSQLTableName($data['targetTable']) . "
			(" . $QueryColumnDescription['columns'] . ")
			VALUES
			(" . $QueryColumnDescription['values'] . ")
			;");
		if ($bts->SDDMObj->errno != 0) {
			$this->LastExecutionReport[] = array('state' => 'err', 'msg' => $bts->SDDMObj->error);
			$res = false;
		}
		return $res;
	}

	/**
	 * Update an entity in DB
	 * @param array $data
	 */
	public function genericUpdateDb($data)
	{
		$res = true;
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : " . $data['entityTitle'] . " already exist in DB. Updating Id=" . $data['entityId']));
		$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($data['columns'], $data['data']);
		$bts->SDDMObj->query("
			UPDATE " . $CurrentSetObj->SqlTableListObj->getSQLTableName($data['targetTable']) . " a
			SET " . $QueryColumnDescription['equality'] . "
			WHERE a." . $data['targetColumn'] . " ='" . $data['entityId'] . "'
			;");
		if ($bts->SDDMObj->errno != 0) {
			$this->LastExecutionReport[] = array('state' => 'err', 'msg' => $bts->SDDMObj->error);
			$res = false;
		}
		return $res;
	}

	/**
	 * Finds an entity filtering on the specified table and columns.
	 * It doesn't filter on any other parameter.
	 * @param string $entity
	 * @param integer $id
	 * @return boolean
	 */
	public function entityExistsInDb($entity, $id)
	{
		$res = true;
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$SqlTableListObj = $CurrentSetObj->SqlTableListObj;
		$column = "";

		switch ($entity) {
			case "article":
				$column = "arti_id";
				break;
			case "article_config":
				$column = "config_id";
				break;
			case "article_tag":
				$column = "article_tag_id";
				break;
			case "menu":
				$column = "menu_id";
				break;
			case "deadline":
				$column = "deadline_id";
				break;
			case "decoration":
				$column = "deco_id";
				break;
			case "definition":
				$column = "def_id";
				break;
			case "document":
				$column = "docu_id";
				break;
			case "document_share":
				$column = "share_id";
				break;
			case "extension":
				$column = "extension_id";
				break;
			case "extension_config":
				$column = "config_id";
				break;
			case "extension_dependency":
				$column = "dependency_id";
				break;
			case "extension_file":
				$column = "file_id";
				break;
			case "group":
				$column = "group_id";
				break;
			case "group_user":
				$column = "group_user_id";
				break;
			case "group_website":
				$column = "group_website_id";
				break;
			case "i18n":
				$column = "i18n_id";
				break;
			case "keyword":
				$column = "keyword_id";
				break;
			case "language":
				$column = "lang_id";
				break;
			case "language_website":
				$column = "lang_website_id";
				break;
			case "layout":
				$column = "layout_id";
				break;
			case "module":
				$column = "module_id";
				break;
			case "module_website":
				$column = "module_website_id";
				break;
			case "permission":
				$column = "perm_id";
				break;
			case "note":
				$column = "note_id";
				break;
			case "security_token":
				$column = "st_id";
				break;
			case "tag":
				$column = "tag_id";
				break;
			case "theme_descriptor":
				$column = "theme_id";
				break;
			case "theme_website":
				$column = "theme_website_id";
				break;
			case "user":
				$column = "user_id";
				break;
			case "website":
				$column = "ws_id";
				break;
		}

		$dbquery = $bts->SDDMObj->query("
			SELECT " . $column . " FROM " . $SqlTableListObj->getSQLTableName($entity) . "
			WHERE " . $column . " = " . $id . "
			LIMIT 1;");
		if ($bts->SDDMObj->num_row_sql($dbquery) == 0) {
			$this->LastExecutionReport[] = array('state' => 'wrn', 'msg' => 'No rows returned for the last query.');
			$res = false;
		}
		return $res;
	}

	/**
	 * Gets the information configuration for the user section.
	 */
	protected function getInfosConfig($type)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$SqlTableListObj = SqlTableList::getInstance(null, null);
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : loading infos_config for section : User"));

		$q = "SELECT * "
			. "FROM " . $SqlTableListObj->getSQLTableName('infos_config') . " ic "
			. "WHERE ic.fk_ws_id = '" . $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id') . "' "
			. "AND ic.infcfg_section = '" . $type . "' "
			. "ORDER BY ic.infcfg_order"
			. ";";

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " q=`" . $bts->StringFormatObj->formatToLog($q) . "`."));
		$dbquery = $bts->SDDMObj->query($q);
		if ($bts->SDDMObj->num_row_sql($dbquery) != 0) {
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				foreach ($dbp as $A => $B) {
					$idx = $dbp['infcfg_order'];
					$this->infos_config[$idx] = array(
						"infcfg_id" 		=> $dbp['infcfg_id'],
						"fk_ws_id"			=> $dbp['fk_ws_id'],
						"infcfg_section"	=> $dbp['infcfg_section'],
						"infcfg_field"		=> $dbp['infcfg_field'],
						"infcfg_enabled"	=> $dbp['infcfg_enabled'],
						"infcfg_type"		=> $dbp['infcfg_type'],
						"infcfg_order"		=> $dbp['infcfg_order'],
					);
				}
			}
		} else {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_INFORMATION, 'msg' => __METHOD__ . " no infos_config rows returned for this type."));
		}
	}


	/**
	 * Gets the related information for this user
	 */
	protected function getInfos($id, $type)
	{
		$bts = BaseToolSet::getInstance();
		$SqlTableListObj = SqlTableList::getInstance(null, null);
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : loading infos for id : " . $id));

		$q = "SELECT * "
			. "FROM " . $SqlTableListObj->getSQLTableName('infos') . " inf "
			. "WHERE inf.info_ref_obj = '" . $id . "' "
			. "AND inf.fk_infcfg_section = '" . $type . "' "
			. ";";

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " q=`" . $bts->StringFormatObj->formatToLog($q) . "`."));
		$dbquery = $bts->SDDMObj->query($q);
		if ($bts->SDDMObj->num_row_sql($dbquery) != 0) {
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				foreach ($dbp as $A => $B) {
					$idx = $dbp['info_field'];
					$this->infos[$idx] = array(
						"info_id" 				=> $dbp['info_id'],
						"fk_infcfg_section"		=> $dbp['fk_infcfg_section'],
						"info_ref_obj"			=> $dbp['info_ref_obj'],
						"info_field"			=> $dbp['info_field'],
						"info_string"			=> $dbp['info_string'],
						"info_number"			=> $dbp['info_number'],
					);
				}
			}
		} else {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_INFORMATION, 'msg' => __METHOD__ . " no infos rows returned for this id : " . $id));
		}
	}


	public function getInfosEntry($data) {
		return $this->infos[$data];
	}
}
