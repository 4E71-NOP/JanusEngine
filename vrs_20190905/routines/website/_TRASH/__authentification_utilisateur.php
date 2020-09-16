<?php
 /*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@club-internet.fr
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/
$_REQUEST['sql_initiateur'] = "Authentification utilisateur"; 

function auth_chargement_donnee ( $auth_params ) {
	global $user, $SDDMObj, $WebSiteObj, $SqlTableListObj;

	$dbquery = $SDDMObj->query("
	SELECT usr.*, g.groupe_id, g.groupe_nom, gu.groupe_premier, g.groupe_tag
	FROM ".$SqlTableListObj->getSQLTableName('user')." usr, ".$SqlTableListObj->getSQLTableName('groupe_user')." gu, ".$SqlTableListObj->getSQLTableName('site_groupe')." sg , ".$SqlTableListObj->getSQLTableName('groupe')." g 
	WHERE usr.user_login = '".$auth_params['login_decode']."' 
	AND usr.user_id = gu.user_id 
	AND gu.groupe_premier = '1'
	AND gu.groupe_id = g.groupe_id 
	AND gu.groupe_id = sg.groupe_id 
	AND sg.site_id = '".$WebSiteObj->getWebSiteEntry('sw_id')."'
	;");
// 	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
// 	SELECT usr.*, g.groupe_id, g.groupe_nom, gu.groupe_premier, g.groupe_tag
// 	FROM ".$SQL_tab['user']." usr, ".$SQL_tab['groupe_user']." gu, ".$SQL_tab['site_groupe']." sg , ".$SQL_tab['groupe']." g 
// 	WHERE usr.user_login = '".$auth_params['login_decode']."' 
// 	AND usr.user_id = gu.user_id 
// 	AND gu.groupe_premier = '1'
// 	AND gu.groupe_id = g.groupe_id 
// 	AND gu.groupe_id = sg.groupe_id 
// 	AND sg.site_id = '".$site_web['sw_id']."'
// 	;");

	while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { 
		$user['id']		= $user_id = $dbp['user_id'];
		$user['nom']		= $dbp['user_nom']; 
		$user['db_login']	= $dbp['user_login']; 
		$user['db_pass']	= $dbp['user_password'];

		$user['date_inscription']	= $dbp['user_date_inscription'];
		$user['status']				= $dbp['user_status'];
		$user['droit_forum']		= $dbp['user_droit_forum'];
		$user['email']				= $dbp['user_email'];
		$user['msn']				= $dbp['user_msn'];
		$user['aim']				= $dbp['user_aim'];
		$user['icq']				= $dbp['user_icq'];
		$user['yim']				= $dbp['user_yim'];
		$user['website']			= $dbp['user_website'];
		$user['perso_nom']			= $dbp['user_perso_nom'];
		$user['perso_pays']			= $dbp['user_perso_pays'];
		$user['perso_ville']		= $dbp['user_perso_ville'];
		$user['perso_occupation']	= $dbp['user_perso_occupation'];
		$user['perso_interet']		= $dbp['user_perso_interet'];
		$user['derniere_visite']	= $dbp['user_derniere_visite'];
		$user['derniere_ip']		= $dbp['user_derniere_ip'];
		$user['timezone']			= $dbp['user_timezone'];
		$user['lang']				= $dbp['user_lang'];

		$user['pref_theme']			= $dbp['user_pref_theme'];
		$user['pref_newsletter']				= $dbp['user_pref_newsletter'];
		$user['pref_montre_email']				= $dbp['user_pref_montre_email'];
		$user['pref_montre_status_online']		= $dbp['user_pref_montre_status_online'];
		$user['pref_notification_reponse_forum']	= $dbp['user_pref_notification_reponse_forum'];
		$user['pref_notification_nouveau_pm']		= $dbp['user_pref_notification_nouveau_pm'];
		$user['pref_autorise_bbcode']				= $dbp['user_pref_autorise_bbcode'];
		$user['pref_autorise_html']				= $dbp['user_pref_autorise_html'];
		$user['pref_autorise_smilies']			= $dbp['user_pref_autorise_smilies'];

		$user['user_image_avatar']				= $dbp['user_image_avatar'];
		$user['user_admin_commentaire']			= $dbp['user_admin_commentaire'];
		$user['groupe_tag']						= $dbp['groupe_tag'];
	}

	$user['clause_in_groupe'] = "";
	$pv['liste_groupes00'] = $pv['liste_groupes01'] =  $pv['liste_groupes02'] = array();

	$dbquery = $SDDMObj->query("
	SELECT groupe_id 
	FROM ".$SqlTableListObj->getSQLTableName('groupe_user')." 
	WHERE user_id = '".$user['id']."'
	;
	");
// 	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
// 	SELECT groupe_id 
// 	FROM ".$SQL_tab['groupe_user']." 
// 	WHERE user_id = '".$user['id']."'
// 	;
// 	");
	while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { 
		$pv['liste_groupes01'][] = $dbp['groupe_id']; 
		$user['groupe'][$dbp['groupe_id']] = 1 ;
	}

	$pv['ResteAFaire'] = 1;
	while ( $pv['ResteAFaire'] == 1 ) {
		$pv['ResteAFaire'] = 0;
		$pv['expr'] = "";
		unset ( $A );
		foreach ( $pv['liste_groupes01'] as $A ) { $pv['expr'] .= "'".$A."', "; }
		$pv['expr'] = "(" . substr ( $pv['expr'] , 0 , -2 ) . ") ";

		$q = "
		SELECT groupe_id, groupe_parent
		FROM ".$SqlTableListObj->getSQLTableName('groupe')."
		WHERE groupe_parent IN ".$pv['expr']."
		;";
		
// 		$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
// 		SELECT groupe_id, groupe_parent 
// 		FROM ".$SQL_tab['groupe']." 
// 		WHERE groupe_parent IN ".$pv['expr']." 
// 		;
// 		");
// 		if ( num_row_sql ($dbquery) > 0 ) {

		$dbquery = $SDDMObj->query($q);
		if ( $SDDMObj->num_row_sql ($dbquery, $q) > 0 ) {
			while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
				$pv['liste_groupes02'][] = $dbp['groupe_id'];
				$user['groupe'][$dbp['groupe_id']] = 1 ;
				$pv['ResteAFaire'] = 1; 
			}
		}

		unset ( $A );
		foreach ( $pv['liste_groupes01'] as $A ) { $pv['liste_groupes00'][] = $A; }
		unset ($pv['liste_groupes01']);
		$pv['liste_groupes01'] = $pv['liste_groupes02'];
		unset ($pv['liste_groupes02']);
	}

	unset ( $A );
	$pv['expr'] = "";
	foreach ( $pv['liste_groupes00'] as $A ) { $pv['expr'] .= "'".$A."', "; }
	$user['clause_in_groupe'] = " IN ( " . substr ( $pv['expr'] , 0 , -2 ) . " ) ";
	

//	outil_debug ($user , "\$user" );
} 


// --------------------------------------------------------------------------------------------
//
//	Session control.
//

$SMObj->CheckSession();

// if ( isset($_SESSION['Dernier_REMOTE_ADDR']) )	{ if ( $_SESSION['Dernier_REMOTE_ADDR'] != $_SERVER['REMOTE_ADDR'] ) { $pv['erreur_session'] = 1; } }
// else { $_SESSION['Dernier_REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR']; }

// $_SESSION['Dernier_REMOTE_PORT'] = $_SERVER['REMOTE_PORT'];

// if ( isset($_SESSION['Dernier_HTTP_USER_AGENT'])) { if ( $_SESSION['Dernier_HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT'] ) { $pv['erreur_session'] = 1; } }
// else { $_SESSION['Dernier_HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT']; }

// if ( isset($_SESSION['Dernier_REQUEST_TIME']) )	{ $pv['attente'] = $_SERVER['REQUEST_TIME'] - $_SESSION['Dernier_REQUEST_TIME'] ;	if ( $pv['attente'] > $MWM_session_max_time ) { $pv['erreur_session'] = 1; } }
// else { $_SESSION['Dernier_REQUEST_TIME'] = $_SERVER['REQUEST_TIME']; }

// if ( isset($_SESSION['Dernier_site']) )	{ if ( $_SESSION['Dernier_site'] != $_REQUEST['sw'] ) { $pv['erreur_session'] = 1; } }
// else { $_SESSION['Dernier_site'] = $_REQUEST['sw']; }

// if ( $pv['erreur_session'] == 1 ) { session_unset(); }
// else {	$_SESSION['mode_session']	= 1; }

// --------------------------------------------------------------------------------------------
//		Scoring authentification
$pv['auth_score'] = 0;
$pv['auth_challenge'] = "vides";
if ( isset($_REQUEST['da_user_login']) ) { $pv['auth_score'] += 1; }
if ( isset($_REQUEST['da_user_pass']) ) { $pv['auth_score'] += 2; }
if ( $_REQUEST['mod_auth_demande_connexion'] == 1 ) { $pv['auth_score'] += 4; }
if ( isset($_REQUEST['user_login']) ) {
	if ( $_REQUEST['user_login'] != base64_encode(stripslashes($_REQUEST['user_login'])) ) { $pv['auth_score'] += 8; }
	if ( $_REQUEST['user_login'] == base64_encode(stripslashes($_REQUEST['user_login'])) ) { $pv['auth_score'] += 16; }
}

switch ( $pv['auth_score'] ) {
case 1:
case 2:
case 3:
case 4:
case 5:
case 6:
case 9:
case 10:
case 11:
case 12:
case 13:
case 14:
case 16:
case 17:
case 18:
case 19:
case 20:
case 21:
case 22:
case 24:
case 25:
case 26:
case 27:
case 28:
case 29:
case 30:
case 31:	$user['reset_identifiants'] = 1;		break;

case 7 :
case 15 :
case 23 :	$pv['auth_challenge'] = "form";		break;

case 0:
case 8 :	$pv['auth_challenge'] = "session";	break;
}

switch ( $pv['auth_challenge'] ) {
case "form":
	$user['login']			= base64_encode(stripslashes($_REQUEST['da_user_login']));
	$user['login_decode']	= stripslashes($_REQUEST['da_user_login']);
	$user['pass']			= base64_encode(hash("sha1",stripslashes($_REQUEST['da_user_pass'])));
	$user['pass_decode']	= hash("sha1",stripslashes($_REQUEST['da_user_pass']));
break;
case "session":
	if ( isset($_SESSION['user_login']) ) {
		$user['login_decode']	= base64_decode( $_SESSION['user_login'] );
		$user['pass_decode']	= base64_decode( $_SESSION['user_pass'] );
	}
	else { 
		$user['reset_identifiants'] = 1;
		unset ( $_REQUEST['arti_ref'] ); // Session fails, so the auth, so the admin panels shouldn't be visible. 
	}
break;
}

if ( $user['reset_identifiants'] != 1 ) {
	//$auth_params['login_decode'] = $db->escape($user['login_decode'], $escape_wildcards = false);
	$auth_params['login_decode'] = string_DAL_escape ( $user['login_decode'] );

	auth_chargement_donnee ( $auth_params );

	if ( $user['login_decode'] == $user['db_login'] && $user['login_decode'] != "anonymous") { 
		if ( $user['pass_decode'] == $user['db_pass'] ) {
			$mod_auth_demande_connexion_resultat = 0;
			$SDDMObj->query("
			UPDATE ".$SqlTableListObj->getSQLTableName('user')." SET 
			user_derniere_ip = '".$_SESSION['Dernier_REMOTE_ADDR']."', 
			user_derniere_visite = '".$_SESSION['Dernier_REQUEST_TIME']."' 
			WHERE user_id = '".$user['id']."' 
			;");
			$_REQUEST['user_login'] = $_SESSION['user_login'] = $user['login'] = base64_encode($user['db_login']);
			$_REQUEST['user_pass'] = $_SESSION['user_pass'] = $user['pass'] = base64_encode($user['db_pass']);
		}
		else { $mod_auth_demande_connexion_resultat = 1; $user['reset_identifiants'] = 1; }
	}
	else { $mod_auth_demande_connexion_resultat = 2; $user['reset_identifiants'] = 1; }
}

if ( $user['reset_identifiants'] == 1 ) {
	if ( $user['login_decode'] == "anonymous" ) { $mod_auth_demande_connexion_resultat = 0; }
	$auth_params['login_decode'] = "anonymous";
	auth_chargement_donnee ( $auth_params );
	$_REQUEST['user_login'] = $_SESSION['user_login'] = $user['login'] = base64_encode($user['db_login']);
	$_REQUEST['user_pass'] = $_SESSION['user_pass'] = $user['pass'] = base64_encode($user['db_pass']);
	$user['login_decode'] = $user['db_login'];
	$user['pass_decode'] = $user['db_pass'];
	unset ( $_SESSION['user_lang']);
} 

$pv['langage_priorisation'] = 0;
if ( $WebSiteObj->getWebSiteEntry('sw_lang_select') == 1 )	{ $pv['langage_priorisation'] += 1;	$pv['debug_auth']['sw_lang_select'] = $WebSiteObj->getWebSiteEntry('sw_lang_select'); }
if ( $_SESSION['user_lang'] != 0 )		{ $pv['langage_priorisation'] += 2; $pv['debug_auth']['SESSION_user_lang'] = "_SESSION[user_lang] != 0"; }
if ( $user['reset_identifiants'] != 1 )	{ $pv['langage_priorisation'] += 4;	$pv['debug_auth']['user_reset_identifiants'] = "user[reset_identifiants] != 1"; }

$pv['debug_auth']['langage_priorisation'] = $pv['langage_priorisation'];
//echo ( "<!--\r" . print_r_debug ( $pv['debug_auth'] ) . "\r-->\r" ); 

switch ( $pv['langage_priorisation'] ) {
case 0 :
case 1 :
case 2 :
case 4 :
case 6 :	$pv['language_selection'] = $WebSiteObj->getWebSiteEntry('sw_lang');	break;
case 3 :	$pv['language_selection'] = $_SESSION['user_lang'];	break;
case 5 :
case 7 :	$pv['language_selection'] = $user['lang'];			break;
}
$WebSiteObj->setWebSiteEntry('sw_lang', $pv['language_selection'] ); 
$user['lang'] = $site_web['sw_lang'] = $_SESSION['user_lang'] = $pv['language_selection'];
$l = $langues[$pv['language_selection']]['langue_id'];

?>
