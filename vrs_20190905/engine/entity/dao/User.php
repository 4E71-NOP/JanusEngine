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
class User {
	private $User;
	
// 	array(
// 			"user_id" => null,
// 			"user_name" => null,
// 			"user_login" => null,
// 			"user_password" => null,
// 			"user_subscription_date" => null,
// 			"user_status" => null,
// 			"user_role_function" => null,
// 			"user_forum_access" => null,
// 			"user_email" => null,
// 			"user_msn" => null,
// 			"user_aim" => null,
// 			"user_icq" => null,
// 			"user_yim" => null,
// 			"user_website" => null,
// 			"user_perso_name" => null,
// 			"user_perso_country" => null,
// 			"user_perso_town" => null,
// 			"user_perso_occupation" => null,
// 			"user_perso_interest" => null,
// 			"user_last_visit" => null,
// 			"user_last_ip" => null,
// 			"user_timezone" => null,
// 			"user_lang" => null,
// 			"user_pref_theme" => null,
// 			"user_pref_newsletter" => null,
// 			"user_pref_show_email" => null,
// 			"user_pref_show_online_status" => null,
// 			"user_pref_forum_notification" => null,
// 			"user_pref_forum_pm" => null,
// 			"user_pref_allow_bbcode" => null,
// 			"user_pref_allow_html" => null,
// 			"user_pref_autorise_smilies" => null,
// 			"user_avatar_image" => null,
// 			"user_admin_comment" => null,
			
// 			"clause_in_group" => "",
// 			"error_login_not_found" => null,
// 	);

	//@formatter:off
	private $columns = array(
	'user_id'						=> 0,
	'user_name'						=> "new User",
	'user_login'					=> 0,
	'user_password'					=> 0,
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
	public function getDataFromDB($UserLogin , $WebSiteObj) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$SqlTableListObj = SqlTableList::getInstance(null, null);

		$dbquery = $bts->SDDMObj->query ("
			SELECT usr.*, g.group_id, g.group_name, gu.group_user_initial_group, g.group_tag
			FROM " . $SqlTableListObj->getSQLTableName ( 'user' ) . " usr, " . $SqlTableListObj->getSQLTableName ( 'group_user' ) . " gu, " . $SqlTableListObj->getSQLTableName ( 'group_website' ) . " sg , " . $SqlTableListObj->getSQLTableName ( 'group' ) . " g
			WHERE usr.user_login = '" . $UserLogin . "'
			AND usr.user_id = gu.user_id
			AND gu.group_user_initial_group = '1'
			AND gu.group_id = g.group_id
			AND gu.group_id = sg.group_id
			AND sg.ws_id = '" . $WebSiteObj->getWebSiteEntry('ws_id') . "'
		;");
		if ($bts->SDDMObj->num_row_sql ( $dbquery ) != 0) {
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				foreach ( $dbp as $A => $B ) {
					if (isset($this->columns[$A])) { $this->User[$A] = $B; }
				}
			}

// 			Building SQL clause for groups. Done here to avoid redoing it over and over. 
			$this->User['clause_in_group'] = "";
			$groupList00 = $groupList01 = $groupList02 = array ();

			// find all sons of the initial user "groupset". 
			$dbquery = $bts->SDDMObj->query ("
				SELECT group_id
				FROM " . $SqlTableListObj->getSQLTableName ('group_user') . "
				WHERE user_id = '" . $this->User['user_id'] . "'
				ORDER BY group_id
				;
				");
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ($dbquery) ) {
				$groupList01[] = $dbp ['group_id'];
				$this->User['group'][$dbp ['group_id']] = 1;
			}

			$loopAgain = 1;
			while ( $loopAgain == 1 ) {
				$loopAgain = 0;
				$strGrp = "";
				unset ($A);
				foreach ( $groupList01 as $A ) { $strGrp .= "'" . $A . "', "; }
				$strGrp = "(" . substr ( $strGrp, 0, - 2 ) . ") ";
				$dbquery = $bts->SDDMObj->query ("SELECT group_id, group_parent
					FROM " . $SqlTableListObj->getSQLTableName ('group') . "
					WHERE group_parent IN " . $strGrp . "
					ORDER BY group_id
					;");
				if ($bts->SDDMObj->num_row_sql ($dbquery) > 0) {
					while ( $dbp = $bts->SDDMObj->fetch_array_sql ($dbquery) ) {
						$groupList02[] = $dbp ['group_id'];
						$this->User['group'][$dbp ['group_id']] = 1;
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
			$this->User['user_lang'] = $WebSiteObj->getWebSiteEntry('ws_lang');
		}
		// Set a default theme if none is specified.
		if ( $this->User['user_pref_theme'] == 0 ) {
			$this->User['user_pref_theme'] = $WebSiteObj->getWebSiteEntry('theme_id');
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
			$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($this->columns, $this->User);
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : QueryColumnDescription - ".$bts->StringFormatObj->arrayToString($QueryColumnDescription) ));
			
			$bts->SDDMObj->query("
			UPDATE ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('user')." u
			SET ".$QueryColumnDescription['equality']."
			WHERE u.user_id ='".$this->User['user_id']."'
			;
			");
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : user already exist in DB. Updating Id=".$this->User['user_id']));
		}
		elseif ( $this->existsInDB() === false  && $mode == 1 || $mode == 0 ) {
			$QueryColumnDescription = $bts->SddmToolsObj->makeQueryColumnDescription($this->columns, $this->User);
			$bts->SDDMObj->query("
				INSERT INTO ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('user')."
				(".$QueryColumnDescription['columns'].")
				VALUES
				(".$QueryColumnDescription['values'].")
				;
			");
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : user doesn't exist in DB. Inserting Id=".$this->User['user_id']));
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
			SELECT u.user_id FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('user')." u
			WHERE u.user_id ='".$this->User['user_id']."';
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
		
// 		$this->User['ws_id'] = ($bts->CMObj->getExecutionContext() == 'render')
// 		? $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')
// 		: $CurrentSetObj->getInstanceOfWebSiteContextObj()->getWebSiteEntry('ws_id');
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
