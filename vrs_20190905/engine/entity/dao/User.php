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
class User extends Entity {
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
	);
	//@formatter:on
	
	public function __construct() {
		$this->User = $this->getDefaultValues();
	}
	
	/**
	 * Gets the user data from the DB<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the user selection to the website ID only.
	 * 
	 * @param User $UserLogin
	 * @param WebSite $WebSiteObj
	 */
	public function getDataFromDB($UserLogin) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$SqlTableListObj = SqlTableList::getInstance(null, null);

		$sqlQuery = "
			SELECT usr.*, g.group_id, g.group_name, gu.group_user_initial_group, g.group_tag
			FROM " . $SqlTableListObj->getSQLTableName ( 'user' ) . " usr, " . $SqlTableListObj->getSQLTableName ( 'group_user' ) . " gu, " . $SqlTableListObj->getSQLTableName ( 'group_website' ) . " sg , " . $SqlTableListObj->getSQLTableName ( 'group' ) . " g
			WHERE usr.user_login = '" . $UserLogin . "'
			AND usr.user_id = gu.fk_user_id
			AND gu.group_user_initial_group = '1'
			AND gu.fk_group_id = g.group_id
			AND gu.fk_group_id = sg.fk_group_id
			AND sg.fk_ws_id = '" . $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
			;";
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . $sqlQuery));
		$dbquery = $bts->SDDMObj->query ($sqlQuery);
		if ($bts->SDDMObj->num_row_sql ( $dbquery ) != 0) {
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->User[$A] = $B; }
				}
			}

// 			Building SQL clause for groups. Done here to avoid redoing it over and over. 
			$this->User['clause_in_group'] = "";
			$groupList00 = $groupList01 = $groupList02 = array ();

			// find all children of the initial user "groupset". 
			$sqlQuery = "
				SELECT fk_group_id
				FROM " . $SqlTableListObj->getSQLTableName ('group_user') . "
				WHERE fk_user_id = '" . $this->User['user_id'] . "'
				ORDER BY fk_group_id
				;";
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . $sqlQuery));
			$dbquery = $bts->SDDMObj->query ($sqlQuery);
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ($dbquery) ) {
				$groupList01[] = $dbp ['fk_group_id'];
				$this->User['group'][$dbp ['fk_group_id']] = 1;
			}

			$loopAgain = 1;
			while ( $loopAgain == 1 ) {
				$loopAgain = 0;
				$strGrp = "";
				unset ($A);
				foreach ( $groupList01 as $A ) { $strGrp .= "'" . $A . "', "; }
				$strGrp = "(" . substr ( $strGrp, 0, - 2 ) . ") ";
				$sqlQuery = "SELECT group_id, group_parent, group_name 
					FROM " . $SqlTableListObj->getSQLTableName ('group') . "
					WHERE group_parent IN " . $strGrp . "
					ORDER BY group_id
					;";
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . $sqlQuery));
				$dbquery = $bts->SDDMObj->query ($sqlQuery);
				if ($bts->SDDMObj->num_row_sql ($dbquery) > 0) {
					while ( $dbp = $bts->SDDMObj->fetch_array_sql ($dbquery) ) {
						$groupList02[] = $dbp['group_id'];
						$this->User['group'][$dbp['group_id']] = 1;
						$this->groupList[$dbp['group_id']] = array("group_id"=>$dbp ['group_id'], "group_name"=>$dbp['group_name']);
						$loopAgain = 1;
					}
				}
				
				unset ( $A );
				foreach ( $groupList01 as $A ) { $groupList00 [] = $A; }
				unset ( $groupList01 );
				$groupList01 = $groupList02;
				unset ( $groupList02 );
			}

			// Sort entries
			sort ($this->groupList);
			ksort ( $this->User['group']);
			unset ( $A );
			$strGrp = "";
// 			foreach ( $groupList00 as $A ) { $strGrp .= "'" . $A . "', "; }
			foreach ( $this->User['group'] as $A => $B ) { $strGrp .= "'" . $A . "', "; }
			$this->User['clause_in_group'] = " IN ( " . substr ( $strGrp, 0, - 2 ) . " ) ";
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : user = " . $bts->StringFormatObj->arrayToString($this->User)));
			
		} else {
			$this->User['error_login_not_found'] == 1;
		}
		
		// Set a default language if none is specified.
		if ( $this->User['user_lang'] == 0 ) {
			$this->User['user_lang'] = $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_lang');
		}
		// Set a default theme if none is specified.
		if ( $this->User['user_pref_theme'] == 0 ) {
			$this->User['user_pref_theme'] = $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('theme_id');
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
			'data'			=> $this->User,
			'targetTable'	=> 'user',
			'targetColumn'	=> 'user_id',
			'entityId'		=> $this->User['user_id'],
			'entityTitle'	=> 'user'
		);
		if ( $this->existsInDB() === true && $mode == 2 || $mode == 0 ) { $this->genericUpdateDb($genericActionArray);}
		elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) { $this->genericInsertInDb($genericActionArray); }
	}
	
	/**
	 * Verifies if the entity exists in DB.
	 */
	public function existsInDB() {
		return $this->userExists($this->User['user_id']);
	}
	
	/**
	 * Checks weither the local data is consistant with the database.
	 * Meaning that every foreign key must be corresponding to an entry in the 'right table'.
	 */
	public function checkDataConsistency () {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$res = true;
		if ( strlen($this->User['user_name']) == 0 ) { $res = false; }
		if ( strlen($this->User['user_login']) == 0 ) { $res = false; }
		if ( strlen($this->User['user_password']) == 0 ) { $res = false; }
		if ( strlen($this->User['user_status']) == 0 ) { $res = false; }
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
		$this->User['user_name'] .= "-".date("d_M_Y_H:i:s", time());
		$this->User['user_login'] .= "-".date("dMYHis", time());
		
		return $tab;
	}
	
	/**
	 * Returns an array containing the list of states for this entity.
	 * Useful for menu select amongst other things.
	 * @return array()
	 */
	public function getMenuOptionArray () {
		$bts = BaseToolSet::getInstance();

		$res = array (
			'status' => array (
				'name' => "user_status",
				'defaultSelected'=> 1,
				'options' => array (
					array( _MENU_OPTION_DB_ =>	 _DISABLED_,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('disabled')),
					array( _MENU_OPTION_DB_ =>	 _ENABLED_,		_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('enabled')),
					array( _MENU_OPTION_DB_ =>	 _DELETED_,		_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $bts->I18nTransObj->getI18nTransEntry('deleted')),
				)
			),
			'group' => array (
				'name' => 'user_status',
				'defaultSelected'=> 0,
			)
		);

		$res['group']['options'] = array( 0=> array( _MENU_OPTION_DB_ =>	 0,	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => '') );
		foreach ($this->groupList as $A ) {
			$res['group']['options'][$A['group_id']] = array( _MENU_OPTION_DB_ =>	 $A['group_id'],	_MENU_OPTION_SELECTED_ => '',	_MENU_OPTION_TXT_ => $A['group_name']);
		}
		return $res;
	}
	
	
	//@formatter:off
	public function getUserEntry( $data ) { 
		if ( isset($this->User[$data])) {return $this->User[$data];}
		else { return null; }
	}
	public function getUserGroupEntry ($lvl1, $lvl2) { 
		if ( isset($this->User[$lvl1][$lvl2])) { return $this->User[$lvl1][$lvl2];}
		else { return null; }
	}
	public function getUser() { return $this->User; }
	public function resetUser () { $this->User = array(); }
	
	public function setUserEntry($entry, $data) {
		if ( isset($this->User[$entry])) { $this->User[$entry] = $data; }	//DB Entity objects do NOT accept new columns!
	}
	
// 	public function setUser($User) { $this->User = $User; }
	
	//@formatter:on
	
}

?>
