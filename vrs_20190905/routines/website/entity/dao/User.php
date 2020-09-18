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
	private $User = array();

	public function __construct() {}

	/**
	 * Gets the user data from the DB<br>
	 * <br>
	 * It uses the current WebSiteObj to restrict the user selection to the website ID only.
	 * 
	 * @param User $UserLogin
	 * @param WebSite $WebSiteObj
	 */
	public function getUserDataFromDB($UserLogin , $WebSiteObj) {
		$LMObj = LogManagement::getInstance();
		$SDDMObj = DalFacade::getInstance()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance(null, null);
		
// 		$LMObj->InternalLog( __METHOD__ ."() : 
// 			SELECT usr.*, g.group_id, g.group_name, gu.group_user_initial_group, g.group_tag
// 			FROM " . $SqlTableListObj->getSQLTableName ( 'user' ) . " usr, " . $SqlTableListObj->getSQLTableName ( 'group_user' ) . " gu, " . $SqlTableListObj->getSQLTableName ( 'group_website' ) . " sg , " . $SqlTableListObj->getSQLTableName ( 'groupe' ) . " g
// 			WHERE usr.user_login = '" . $UserLogin . "'
// 			AND usr.user_id = gu.user_id
// 			AND gu.group_user_initial_group = '1'
// 			AND gu.group_id = g.group_id
// 			AND gu.group_id = sg.group_id
// 			AND sg.ws_id = '" . $WebSiteObj->getWebSiteEntry('ws_id') . "'
// 		;"
// 		);
		$dbquery = $SDDMObj->query ("
			SELECT usr.*, g.group_id, g.group_name, gu.group_user_initial_group, g.group_tag
			FROM " . $SqlTableListObj->getSQLTableName ( 'user' ) . " usr, " . $SqlTableListObj->getSQLTableName ( 'group_user' ) . " gu, " . $SqlTableListObj->getSQLTableName ( 'group_website' ) . " sg , " . $SqlTableListObj->getSQLTableName ( 'groupe' ) . " g
			WHERE usr.user_login = '" . $UserLogin . "'
			AND usr.user_id = gu.user_id
			AND gu.group_user_initial_group = '1'
			AND gu.group_id = g.group_id
			AND gu.group_id = sg.group_id
			AND sg.ws_id = '" . $WebSiteObj->getWebSiteEntry('ws_id') . "'
		;");
		if ($SDDMObj->num_row_sql ( $dbquery ) != 0) {
			while ( $dbp = $SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$this->User['id']					= $dbp['user_id'];
				$this->User['user_id']				= $dbp['user_id'];
				$this->User['nom']					= $dbp['user_nom'];
				$this->User['db_login']				= $dbp['user_login'];
				$this->User['user_login']			= $dbp['user_login'];
				$this->User['db_pass']				= $dbp['user_password'];
// 				$this->User['user_login']			= $dbp['user_login'];
// 				$this->User['user_password']		= $dbp['user_password'];

				$this->User['date_inscription']		= $dbp['user_date_inscription'];
				$this->User['status']				= $dbp['user_status'];
				$this->User['droit_forum']			= $dbp['user_droit_forum'];
				$this->User['email']				= $dbp['user_email'];
				$this->User['msn']					= $dbp['user_msn'];
				$this->User['aim']					= $dbp['user_aim'];
				$this->User['icq']					= $dbp['user_icq'];
				$this->User['yim']					= $dbp['user_yim'];
				$this->User['website']				= $dbp['user_website'];
				$this->User['perso_nom']			= $dbp['user_perso_nom'];
				$this->User['perso_pays']			= $dbp['user_perso_pays'];
				$this->User['perso_ville']			= $dbp['user_perso_ville'];
				$this->User['perso_occupation']		= $dbp['user_perso_occupation'];
				$this->User['perso_interet']		= $dbp['user_perso_interet'];
				$this->User['derniere_visite']		= $dbp['user_derniere_visite'];
				$this->User['derniere_ip']			= $dbp['user_derniere_ip'];
				$this->User['timezone']				= $dbp['user_timezone'];
				$this->User['lang']					= $dbp['user_lang'];

				$this->User['pref_theme']						= $dbp['user_pref_theme'];
				$this->User['pref_newsletter']					= $dbp['user_pref_newsletter'];
				$this->User['pref_montre_email']				= $dbp['user_pref_montre_email'];
				$this->User['pref_montre_status_online']		= $dbp['user_pref_montre_status_online'];
				$this->User['pref_notification_reponse_forum']	= $dbp['user_pref_notification_reponse_forum'];
				$this->User['pref_notification_nouveau_pm']		= $dbp['user_pref_notification_nouveau_pm'];
				$this->User['pref_autorise_bbcode']				= $dbp['user_pref_autorise_bbcode'];
				$this->User['pref_autorise_html']				= $dbp['user_pref_autorise_html'];
				$this->User['pref_autorise_smilies']			= $dbp['user_pref_autorise_smilies'];

				$this->User['user_image_avatar']		= $dbp['user_image_avatar'];
				$this->User['user_admin_commentaire']	= $dbp['user_admin_commentaire'];
				$this->User['group_tag']				= $dbp['group_tag'];
				foreach ( $dbp as $A => $B ) { $this->User [$A] = $B; }
			}

// 			Building SQL clause for groups. Done here to avoid redoing it over and over. 
			$this->User['clause_in_groupe'] = "";
			$groupList00 = $groupList01 = $groupList02 = array ();

			// find all sons of the initial user "groupset". 
			$dbquery = $SDDMObj->query ("
				SELECT group_id
				FROM " . $SqlTableListObj->getSQLTableName ('group_user') . "
				WHERE user_id = '" . $this->User['user_id'] . "'
				ORDER BY group_id
				;
				");
			while ( $dbp = $SDDMObj->fetch_array_sql ($dbquery) ) {
				$groupList01[] = $dbp ['group_id'];
				$this->User['groupe'][$dbp ['group_id']] = 1;
			}

			$loopAgain = 1;
			while ( $loopAgain == 1 ) {
				$loopAgain = 0;
				$strGrp = "";
				unset ($A);
				foreach ( $groupList01 as $A ) { $strGrp .= "'" . $A . "', "; }
				$strGrp = "(" . substr ( $strGrp, 0, - 2 ) . ") ";
				$dbquery = $SDDMObj->query ("SELECT group_id, group_parent
					FROM " . $SqlTableListObj->getSQLTableName ('groupe') . "
					WHERE group_parent IN " . $strGrp . "
					ORDER BY group_id
					;");
				if ($SDDMObj->num_row_sql ($dbquery) > 0) {
					while ( $dbp = $SDDMObj->fetch_array_sql ($dbquery) ) {
						$groupList02[] = $dbp ['group_id'];
						$this->User['groupe'][$dbp ['group_id']] = 1;
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
			ksort ( $this->User['groupe']);
			unset ( $A );
			$strGrp = "";
// 			foreach ( $groupList00 as $A ) { $strGrp .= "'" . $A . "', "; }
			foreach ( $this->User['groupe'] as $A => $B ) { $strGrp .= "'" . $A . "', "; }
			$this->User['clause_in_groupe'] = " IN ( " . substr ( $strGrp, 0, - 2 ) . " ) ";	
			
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

	//@formatter:off
	public function getUserEntry( $data ) { return $this->User[$data]; }
	public function getUserGroupEntry ($lvl1, $lvl2) { return $this->User[$lvl1][$lvl2]; }
	public function getUser() { return $this->User; }
	public function resetUser () { $this->User = array(); }
	
	public function setUserEntry($entry, $data) {
		if ( isset($this->User[$entry])) { $this->User[$entry] = $data; }	//DB Entity objects do NOT accept new columns!
	}
	
// 	public function setUser($User) { $this->User = $User; }
	
	//@formatter:on
	
}

?>
