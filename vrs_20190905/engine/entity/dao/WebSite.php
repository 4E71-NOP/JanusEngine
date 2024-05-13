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

class WebSite extends Entity
{
	private $WebSite = array();

	//@formatter:off
	private $columns = array(
		'ws_id'				=> 0,
		'ws_name'			=> "Hdr Base",
		'ws_short'			=> "HdrBase",
		'fk_lang_id'		=> 0,
		'ws_lang_select'	=> 0,
		'fk_theme_id'		=> 0,
		'ws_title'			=> "Hdr Base",
		'ws_home'			=> 0,
		'ws_directory'		=> 0,
		'ws_state'			=> 0,
		'ws_info_debug'		=> 0,
		'ws_stylesheet'		=> 0,
		'ws_gal_mode'		=> 0,
		'ws_gal_file_tag'	=> 0,
		'ws_gal_quality'	=> 0,
		'ws_gal_x'			=> 0,
		'ws_gal_y'			=> 0,
		'ws_gal_border'		=> 0,
		'ws_ma_diff'		=> 0,
	);
	//@formatter:on

	public function
	__construct()
	{
		$this->WebSite = $this->getDefaultValues();
	}

	/**
	 * Gets website data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the website selection to the website ID only.
	 */
	public function getDataFromDB()	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$currentWs = $CurrentSetObj->getDataEntry('ws'); // get the Webite

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;

		if ($currentWs) {
			$dbquery = $bts->SDDMObj->query("
				SELECT * 
				FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName('website') . " 
				WHERE ws_id = '" . $currentWs . "'
				;");
			if ($bts->SDDMObj->num_row_sql($dbquery) != 0) {
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for website id=" . $currentWs));
				while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
					foreach ($dbp as $A => $B) {
						if (isset($this->columns[$A])) {
							$this->WebSite[$A] = $B;
						}
					}
				}
			} else {
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for website id=" . $currentWs));
				$res = false;
			}
			$_REQUEST['site_context']['ws_id'] = $this->WebSite['ws_id'];		// Dédiée aux routines de manipulation
		} else {
			echo ("Error : Website ID is NOT defined in the session.<br>Exiting.");
			exit(1);
		}

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}

	/**
	 * Gets website data from the database.<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the website selection to the website SHORT only.
	 * 
	 */
	public function getDataFromDBUsingShort() {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$currentWs = $CurrentSetObj->getDataEntry('ws'); // get the Webite

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;

		if ($currentWs > 1) {
			$dbquery = $bts->SDDMObj->query("
				SELECT * 
				FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName('website') . " 
				WHERE ws_short = '" . $currentWs . "'
				;");
			if ($bts->SDDMObj->num_row_sql($dbquery) != 0) {
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for website short=" . $currentWs));
				while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
					foreach ($dbp as $A => $B) {
						if (isset($this->columns[$A])) {
							$this->WebSite[$A] = $B;
						}
					}
				}
			} else {
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for website short=" . $currentWs));
				$res = false;
			}
			$_REQUEST['site_context']['ws_id'] = $this->WebSite['ws_id'];		// Dédiée aux routines de manipulation
		} else {
			echo ("Error : Website ID is NOT defined in the session.<br>Exiting.");
			exit(1);
		}

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}


	/**
	 * Change website context
	 * @param integer $id
	 */
	public function changeWebSiteContext($id)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;

		$dbquery = $bts->SDDMObj->query(
			"SELECT * 
			FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName('website') . " 
			WHERE ws_id = '" . $id . "'
			;"
		);
		if ($bts->SDDMObj->num_row_sql($dbquery) != 0) {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Loading data for website id=" . $id));
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				foreach ($dbp as $A => $B) {
					if (isset($this->columns[$A])) {
						$this->WebSite[$A] = $B;
					}
				}
			}
		} else {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No rows returned for website id=" . $id));
			$res = false;
		}

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
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
	public function sendToDB($mode = OBJECT_SENDTODB_MODE_DEFAULT)
	{
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;

		$genericActionArray = array(
			'columns'		=> $this->columns,
			'data'			=> $this->WebSite,
			'targetTable'	=> 'website',
			'targetColumn'	=> 'ws_id',
			'entityId'		=> $this->WebSite['ws_id'],
			'entityTitle'	=> 'website'
		);
		if ($this->existsInDB() === true && $mode == 2 || $mode == 0) {
			$res = $this->genericUpdateDb($genericActionArray);
		} elseif ($this->existsInDB() === false  && $mode == 1 || $mode == 0) {
			$res = $this->genericInsertInDb($genericActionArray);
		}

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End"));
		return $res;
	}


	/**
	 * Verifies if the entity exists in DB.
	 */
	public function existsInDB()
	{
		return $this->entityExistsInDb('website', $this->WebSite['ws_id']);
	}

	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$res = true;

		return $res;
	}

	/**
	 * Returns the default values of this type (this is consistent witht de SQL model and it should stay that way)
	 * @return array()
	 */
	public function getDefaultValues()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$date = time();
		$tab = $this->columns;
		$this->WebSite['ws_name'] .= "-" . date("d_M_Y_H:i:s", time());

		return $tab;
	}

	/**
	 * Returns an array containing the list of states for this entity.
	 * Useful for menu select amongst other things.
	 * @return array()
	 */
	public function getMenuOptionArray()
	{
		$bts = BaseToolSet::getInstance();
		return array(
			'state' => array(
				0 => array(_MENU_OPTION_DB_ =>	 0,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('offline')),
				1 => array(_MENU_OPTION_DB_ =>	 1,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('online')),
				2 => array(_MENU_OPTION_DB_ =>	 2,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('disabled')),
			)
		);
	}


	//@formatter:off
	public function getWebSiteEntry($data)
	{
		return $this->WebSite[$data];
	}
	public function getWebSite()
	{
		return $this->WebSite;
	}

	public function setWebSiteEntry($entry, $data)
	{
		if (isset($this->WebSite[$entry])) {
			$this->WebSite[$entry] = $data;
		}	//DB Entity objects do NOT accept new columns!
	}
	public function setWebSite($WebSite)
	{
		$this->WebSite = $WebSite;
	}

	public function setInstallationInstance()
	{
		$this->WebSite = array(
			"ws_id"			=> "1",
			"ws_title"		=> "Hydr Installation",
			'fk_lang_id'	=> 38,
			"ws_lang"		=> 38, // <- deprecated
		);
		// 38 = Eng
	}
	//@formatter:on

}
