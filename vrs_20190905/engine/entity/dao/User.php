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
class User extends Entity
{
	private $User;
	private $groupList = array();
	//@formatter:off
	private $columns = array(
		'user_id'						=> 0,
		'user_name'						=> "new User",
		'user_login'					=> "newLogin",
		'user_password'					=> "1a2b3c4d5e",
		'user_subscription_date'		=> 0,
		'user_status'					=> 0,
		'user_role_function'			=> 0,
		'user_forum_access'				=> 0,
		'user_email'					=> 0,
		'user_msn'						=> 0,
		'user_aim'						=> 0,
		'user_icq'						=> 0,
		'user_yim'						=> 0,
		'user_website'					=> 0,
		'user_perso_name'				=> 0,
		'user_perso_country'			=> 0,
		'user_perso_town'				=> 0,
		'user_perso_occupation'			=> 0,
		'user_perso_interest'			=> 0,
		'user_last_visit'				=> 0,
		'user_last_ip'					=> 0,
		'user_timezone'					=> 0,
		'user_lang'						=> 0,
		'user_pref_theme'				=> 0,
		'user_pref_newsletter'			=> 0,
		'user_pref_show_email'			=> 0,
		'user_pref_show_online_status'	=> 0,
		'user_pref_forum_notification'	=> 0,
		'user_pref_forum_pm'			=> 0,
		'user_pref_allow_bbcode'		=> 0,
		'user_pref_allow_html'			=> 0,
		'user_pref_autorise_smilies'	=> 0,
		'user_avatar_image'				=> 0,
		'user_admin_comment'			=> 0,
		'fk_group_id'					=> 0,
	);
	//@formatter:on

	public function __construct()
	{
		$this->User = $this->getDefaultValues();
	}

	/**
	 * Gets the user data from the DB using ID<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the user selection to the website ID only.
	 * 
	 * @param User $UserLogin
	 * @param WebSite $WebSiteObj
	 */
	public function getDataFromDB($UserId)
	{
		// $bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$SqlTableListObj = SqlTableList::getInstance(null, null);

		$sqlQuery = "
			SELECT usr.*, g.group_id as fk_group_id, g.group_name, gu.group_user_initial_group, g.group_tag
			FROM "
			. $SqlTableListObj->getSQLTableName('user') . " usr, "
			. $SqlTableListObj->getSQLTableName('group_user') . " gu, "
			. $SqlTableListObj->getSQLTableName('group_website') . " sg, "
			. $SqlTableListObj->getSQLTableName('group') . " g
			WHERE usr.user_id = '" . $UserId . "'
			AND usr.user_id = gu.fk_user_id
			AND gu.group_user_initial_group = '1'
			AND gu.fk_group_id = g.group_id
			AND gu.fk_group_id = sg.fk_group_id
			AND sg.fk_ws_id = '" . $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id') . "'
			;";
		return $this->loadDataFromDB($sqlQuery);
	}


	/**
	 * Gets the user data from the DB using login<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the user selection to the website ID only.
	 * 
	 * @param User $UserLogin
	 * 
	 */
	public function getDataFromDBUsingLogin($UserLogin)
	{
		// $bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$SqlTableListObj = SqlTableList::getInstance(null, null);

		$sqlQuery = "
			SELECT usr.*, g.group_id as fk_group_id, g.group_name, gu.group_user_initial_group, g.group_tag
			FROM "
			. $SqlTableListObj->getSQLTableName('user') . " usr, "
			. $SqlTableListObj->getSQLTableName('group_user') . " gu, "
			. $SqlTableListObj->getSQLTableName('group_website') . " sg, "
			. $SqlTableListObj->getSQLTableName('group') . " g
			WHERE usr.user_login = '" . $UserLogin . "'
			AND usr.user_id = gu.fk_user_id
			AND gu.group_user_initial_group = '1'
			AND gu.fk_group_id = g.group_id
			AND gu.fk_group_id = sg.fk_group_id
			AND sg.fk_ws_id = '" . $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id') . "'
			;";
		return $this->loadDataFromDB($sqlQuery);
	}

	/**
	 * Gets the user data from the DB using email<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the user selection to the website ID only.
	 * 
	 * @param User $UserLogin
	 * 
	 */
	public function getDataFromDBUsingEmail($UserEmail)
	{
		// $bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$SqlTableListObj = SqlTableList::getInstance(null, null);

		$sqlQuery = "
			SELECT usr.*, g.group_id as fk_group_id, g.group_name, gu.group_user_initial_group, g.group_tag
			FROM "
			. $SqlTableListObj->getSQLTableName('user') . " usr, "
			. $SqlTableListObj->getSQLTableName('group_user') . " gu, "
			. $SqlTableListObj->getSQLTableName('group_website') . " sg, "
			. $SqlTableListObj->getSQLTableName('group') . " g
			WHERE usr.user_email = '" . $UserEmail . "'
			AND usr.user_id = gu.fk_user_id
			AND gu.group_user_initial_group = '1'
			AND gu.fk_group_id = g.group_id
			AND gu.fk_group_id = sg.fk_group_id
			AND sg.fk_ws_id = '" . $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id') . "'
			;";
		return $this->loadDataFromDB($sqlQuery);
	}




	/**
	 * Load data from DB using the argument (query)
	 */
	private function loadDataFromDB($sqlQuery)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$SqlTableListObj = SqlTableList::getInstance(null, null);
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Start"));
		$res = true;

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " `" . $bts->StringFormatObj->formatToLog($sqlQuery) . "`."));
		$dbquery = $bts->SDDMObj->query($sqlQuery);
		if ($bts->SDDMObj->num_row_sql($dbquery) != 0) {
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				foreach ($dbp as $A => $B) {
					if (isset($this->columns[$A])) {
						$this->User[$A] = $B;
					}
				}
			}

			// Building SQL clause for groups. Done here to avoid redoing it over and over. 
			$this->User['clause_in_group'] = "";
			$groupList00 = $groupList01 = $groupList02 = array();

			// find all children of the initial user "groupset". 
			$sqlQuery = "
				SELECT fk_group_id
				FROM " . $SqlTableListObj->getSQLTableName('group_user') . "
				WHERE fk_user_id = '" . $this->User['user_id'] . "'
				ORDER BY fk_group_id
				;";
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " `" . $bts->StringFormatObj->formatToLog($sqlQuery) . "`."));
			$dbquery = $bts->SDDMObj->query($sqlQuery);
			$groupList01 = array();
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				$groupList01[] = $dbp['fk_group_id'];
				$this->User['group'][$dbp['fk_group_id']] = 1;
			}

			$loopAgain = 1;
			while ($loopAgain == 1) {
				$loopAgain = 0;
				$strGrp = "";
				unset($A);
				foreach ($groupList01 as $A) {
					$strGrp .= "'" . $A . "', ";
				}
				$strGrp = "(" . substr($strGrp, 0, -2) . ") ";
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " groupList01= `" . $strGrp . "`."));
				$sqlQuery = "SELECT group_id, group_parent, group_name, group_tag 
					FROM " . $SqlTableListObj->getSQLTableName('group') . "
					WHERE group_parent IN " . $strGrp . "
					ORDER BY group_id
					;";
				$dbquery = $bts->SDDMObj->query($sqlQuery);
				if ($bts->SDDMObj->num_row_sql($dbquery) > 0) {
					while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
						$groupList02[] = $dbp['group_id'];
						$this->User['group'][$dbp['group_id']] = 1;
						$this->groupList[$dbp['group_id']] = array("group_id" => $dbp['group_id'], "group_name" => $dbp['group_name'], "group_tag" => $dbp['group_tag']);
						$loopAgain = 1;
					}
				} else {
					$bts->LMObj->msgLog(array('level' => LOGLEVEL_INFORMATION, 'msg' => __METHOD__ . " The query `" . $bts->StringFormatObj->formatToLog($sqlQuery) . "` did not return any rows. Most likely it's the end of the group search process."));
					// $res = false; // it's only a warning not an error
				}

				unset($A);
				foreach ($groupList01 as $A) {
					$groupList00[] = $A;
				}
				unset($groupList01);
				$groupList01 = $groupList02;
				unset($groupList02);
			}

			// Sort entries
			sort($this->groupList);
			ksort($this->User['group']);
			unset($A);
			$strGrp = "";
			// 			foreach ( $groupList00 as $A ) { $strGrp .= "'" . $A . "', "; }
			foreach ($this->User['group'] as $A => $B) {
				$strGrp .= "'" . $A . "', ";
			}
			$this->User['clause_in_group'] = " IN ( " . substr($strGrp, 0, -2) . " ) ";
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_DEBUG_LVL0, 'msg' => __METHOD__ . " : user = " . $bts->StringFormatObj->arrayToString($this->User)));
		} else {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . " Login not found. Maybe a user mispelling the login."));
			$this->User['error_login_not_found'] == 1;
			$res = false;
		}

		// Building the permission list
		$q = "SELECT p.*, gp.fk_group_id, g.group_name 
				FROM 
				" . $SqlTableListObj->getSQLTableName('permission') . " p, 
				" . $SqlTableListObj->getSQLTableName('group_permission') . " gp, 
				" . $SqlTableListObj->getSQLTableName('group') . " g 
				WHERE p.perm_id = gp.fk_perm_id 
				AND gp.fk_group_id = g.group_id 
				AND gp.fk_group_id " . $this->User['clause_in_group'] . ";";

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : permissionList q = " . $bts->StringFormatObj->formatToLog($q)));
		$dbquery = $bts->SDDMObj->query($q);

		if ($bts->SDDMObj->num_row_sql($dbquery) > 0) {
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				$this->User['permissionList'][$dbp['perm_id']] = array(
					"perm_id"			=> $dbp['perm_id'],
					"perm_state"		=> $dbp['perm_state'],
					"perm_name"			=> $dbp['perm_name'],
					"perm_affinity"		=> $dbp['perm_affinity'],
					"perm_object_type"	=> $dbp['perm_object_type'],
					"perm_desc"			=> $dbp['perm_desc'],
					"perm_level"		=> $dbp['perm_level'],
				);
			}
		}
		$strPerm = "";
		reset($this->User['permissionList']);
		foreach ($this->User['permissionList'] as $A) {
			$strPerm .= "'" . $A['perm_id'] . "', ";
		}
		$this->User['clause_in_perm'] = " IN ( " . substr($strPerm, 0, -2) . " ) ";

		// Set a default language if none is specified.
		if ($this->User['user_lang'] == 0) {
			$this->User['user_lang'] = $CurrentSetObj->WebSiteObj->getWebSiteEntry('fk_lang_id');
		}
		// Set a default theme if none is specified.
		if ($this->User['user_pref_theme'] == 0) {
			$this->User['user_pref_theme'] = $CurrentSetObj->WebSiteObj->getWebSiteEntry('fk_theme_id');
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
			'data'			=> $this->User,
			'targetTable'	=> 'user',
			'targetColumn'	=> 'user_id',
			'entityId'		=> $this->User['user_id'],
			'entityTitle'	=> 'user'
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
		return $this->entityExistsInDb('user', $this->User['user_id']);
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
		if (strlen($this->User['user_name']) == 0) {
			$res = false;
		}
		if (strlen($this->User['user_login']) == 0) {
			$res = false;
		}
		if (strlen($this->User['user_password']) == 0) {
			$res = false;
		}
		if (strlen($this->User['user_status']) == 0) {
			$res = false;
		}
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

		$tab['user_id']							= 0;
		$tab['user_name']						= "New user name " . $date;
		$tab['user_login']						= "New user login " . $date;
		$tab['user_password']					= "1a2b3c4d5e";
		$tab['user_subscription_date']			= $date;
		$tab['user_status']						= _ENABLED_;
		$tab['user_role_function']				= _READER_;
		$tab['user_forum_access']				= _YES_;
		$tab['user_email']						= "";
		$tab['user_msn']						= "";
		$tab['user_aim']						= "";
		$tab['user_icq']						= "";
		$tab['user_yim']						= "";
		$tab['user_website']					= "";
		$tab['user_perso_name']					= "";
		$tab['user_perso_country']				= "";
		$tab['user_perso_town']					= "";
		$tab['user_perso_occupation']			= "";
		$tab['user_perso_interest']				= "";
		$tab['user_last_visit']					= 0;
		$tab['user_last_ip']					= "0.0.0.0";
		$tab['user_timezone']					= "";
		$tab['user_lang']						= "";
		$tab['user_pref_theme']					= "";
		$tab['user_pref_newsletter']			= "";
		$tab['user_pref_show_email']			= "";
		$tab['user_pref_show_online_status']	= "";
		$tab['user_pref_forum_notification']	= "";
		$tab['user_pref_forum_pm']				= "";
		$tab['user_pref_allow_bbcode']			= "";
		$tab['user_pref_allow_html']			= "";
		$tab['user_pref_autorise_smilies']		= "";
		$tab['user_avatar_image']				= "";
		$tab['user_admin_comment']				= "";
		$tab['fk_group_id']						= "";
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

		$res = array(
			'yesno' => array(
				0 => array(_MENU_OPTION_DB_ =>	 "NO",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('no')),
				1 => array(_MENU_OPTION_DB_ =>	 "YES",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('yes')),
			),
			'state' => array(
				0 => array(_MENU_OPTION_DB_ =>	 "DISABLED",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('disabled')),
				1 => array(_MENU_OPTION_DB_ =>	 "ENABLED",		_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('enabled')),
				2 => array(_MENU_OPTION_DB_ =>	 "DELETED",		_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('deleted')),
			),
			'role' => array(
				1	=> array(_MENU_OPTION_DB_ => "PUBLIC",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('public')),
				2	=> array(_MENU_OPTION_DB_ => "PRIVATE",	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('private')),
			),
			// 'status' => array (
			// 	'name' => "user_status",
			// 	'defaultSelected'=> 1,
			// ),

			// 'group' => array (
			// 	'name' => 'user_status',
			// 	'defaultSelected'=> 0,
			// )
		);

		$res['group']['options'] = array(0 => array(_MENU_OPTION_DB_ =>	 0,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => ''));
		foreach ($this->groupList as $A) {
			$res['group']['options'][$A['group_id']] = array(_MENU_OPTION_DB_ =>	 $A['group_id'],	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $A['group_name']);
		}
		return $res;
	}


	//@formatter:off
	public function getUserEntry($data)
	{
		if (isset($this->User[$data])) {
			return $this->User[$data];
		} else {
			return null;
		}
	}
	public function getUserGroupEntry($lvl1, $lvl2)
	{
		if (isset($this->User[$lvl1][$lvl2])) {
			return $this->User[$lvl1][$lvl2];
		} else {
			return null;
		}
	}

	public function getGroupList()
	{
		return $this->groupList;
	}

	public function getUser()
	{
		return $this->User;
	}
	
	public function resetUser()
	{
		$this->User = $this->columns;
		$this->groupList = array();
	}

	public function setUserEntry($entry, $data)
	{
		if (isset($this->User[$entry])) {
			$this->User[$entry] = $data;
		}	//DB Entity objects do NOT accept new columns!
	}

	// 	public function setUser($User) { $this->User = $User; }

	/**
	 * Returns bolean true/false on named permission
	 * @param string
	 * @return boolean
	 */
	public function hasPermission($perm)
	{
		foreach ($this->User['permissionList'] as $A) {
			if ($A['perm_name'] == $perm) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Sets named permission
	 * @param string
	 * @return boolean
	 */
	public function setPermission($perm)
	{
		if ($this->hasPermission($perm) == false) {
			$this->User['permissionList'][$perm] = array('perm_name' => $perm, 'perm_level' => 2);
		}
	}

	/**
	 * Returns bolean true/false on named Read permission
	 * @param string
	 * @return boolean
	 */
	public function hasReadPermission($perm)
	{
		foreach ($this->User['permissionList'] as $A) {
			if ($A['perm_name'] == $perm && $A['perm_level'] == 1) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Returns bolean true/false on named Write permission
	 * @param string
	 * @return boolean
	 */
	public function hasWritePermission($perm)
	{
		foreach ($this->User['permissionList'] as $A) {
			if ($A['perm_name'] == $perm && $A['perm_level'] == 2) {
				return true;
			}
		}
		return false;
	}

	//@formatter:on

}
