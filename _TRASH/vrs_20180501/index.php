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

$_REQUEST['localisation'] = "";
function microtime_chrono() {
	return microtime(TRUE);
}

function statistique_checkpoint ( $routine ) {
	if ( $_REQUEST['StatistiqueInsertion'] == 1 ) {
		global $statistiques_ , $statistiques_index;
		$statistiques_index++;
		$i = &$statistiques_index;
		$statistiques_[$i]['position'] = $i;
		$statistiques_[$i]['context'] = $_REQUEST['localisation'];
		$statistiques_[$i]['routine'] = $routine;
		$statistiques_[$i]['temps'] = microtime_chrono();
		$statistiques_[$i]['memoire'] = memory_get_usage();
		$statistiques_[$i]['SQL_err'] = 0;
		$statistiques_[$i]['SQL_queries'] = 0;
	}
}

$_REQUEST['StatistiqueInsertion'] = 1;
$statistiques_index = -1;
$localisation = " / idx";
$_REQUEST['localisation'] .= $localisation;
statistique_checkpoint ("Index");

// --------------------------------------------------------------------------------------------
// 0 Pas de journal;	1 erreurs;	2 +avertissment		3 +tout
// 0 No log; 			1 erreurs;	2 +warnings			3 +all
$_REQUEST['debug_option']['SQL_debug_level']		= 1;				// Préparatif_sql.php
$_REQUEST['debug_option']['CC_debug_level']			= 1;				// Manipulation_<element>.php
$_REQUEST['debug_option']['PHP_debug_level']		= 1;				// PHP original debug level
$_REQUEST['debug_option']['JS_debug_level']			= 1;				// JavaScript
$_REQUEST['debug_option']['journalisation_cible']	= "interne";		// 'systeme' (apache log), 'echo' (affichage erreur sur l'ecran), 'aucun' (conserve la comptabilité des états)

$_REQUEST['contexte_d_execution']	= "Rendu";
$_REQUEST['sql_initiateur']			= "Rendu";

$JavaScriptFichier	= array();
$JavaScriptInit		= array();
$JavaScriptOnload	= array();

$_REQUEST['CC']['Compteur'] = 0;
$_REQUEST['CC_niveau_de_verification'] = 1;								//Fait les vérifications au complet des commandes entrées. Doublon, erreur etc.

$_REQUEST['configuration_serveur'] = "normal";
$_REQUEST['SQL_fatal_error'] = 0;										// Utile pour le banner de redirection pour obtenir un navigateur descent.
$Outil_debug = array();													// Utile pour la fonction "outil_debug"

$_REQUEST['CC_niveau_de_verification'] = 1;								//Fait les vérifications au complet des commandes entrées. Doublon, erreur etc.

// --------------------------------------------------------------------------------------------
//Debug fignolage
$_REQUEST['debug_special'] = 1;
$_REQUEST['debug_conversion_expression'] = 0;
// --------------------------------------------------------------------------------------------

switch ( $_REQUEST['configuration_serveur'] ) {
	case "normal":
		if ( $_REQUEST['debug_option']['PHP_debug_level'] != 0 ) { 
			error_reporting( E_ERROR | E_WARNING | E_PARSE );							// http://fr2.php.net/error_reporting
			ini_set('log_errors', "On");
			ini_set('error_log' , "/var/log/apache2/error.log");
		}
		else { error_reporting(0); }

		$_REQUEST['server_infos']['include_path']		= get_include_path();
		$_REQUEST['server_infos']['repertoire_courant']	= getcwd(); 
		ini_set('session.gc_maxlifetime', $MWM_session_max_time );
		ini_set('display_errors', "Off");
		//$pv['PEAR_fallback'] = $_REQUEST['server_infos']['include_path'] . ":" . $_REQUEST['server_infos']['repertoire_courant'] . "/components/PEAR";
		//ini_set('include_path',$pv['PEAR_fallback'] );								// Make sure PEAR is found
	break;	

	// Put any settings you wish to activate in a different situation (ex : webhosting plan)
	// Insérez les réglages que vous souhaitez pour correspondre à une autre situation (ex : hébergeur)
	case "webhosting-plan":
	case "hebergeur":
	break;	
}

// --------------------------------------------------------------------------------------------
// MSIE 5 and 6 must die!!!		Even if IE7 and IE8 do not diserve it, we keep them.
// MSIE 5 et 6 doivent mourrir!!! Meme si IE7 et IE8 ne le méritent pas, on les garde.
$Navigator = getenv("HTTP_USER_AGENT");

if ( strpos($Navigator, "MSIE" ) !== FALSE ) {
	if ( strpos($Navigator, "MSIE 5" ) !== FALSE ) { $pv['navigateur_pourri'] = 1; }
	if ( strpos($Navigator, "MSIE 6" ) !== FALSE ) { $pv['navigateur_pourri'] = 1; }
	if ( strpos($Navigator, "MSIE 7" ) !== FALSE ) { $pv['navigateur_pourri'] = 1; }
	if ( strpos($Navigator, "MSIE 8" ) !== FALSE ) { $pv['navigateur_pourri'] = 1; }
	if ( strpos($Navigator, "MSIE 9" ) !== FALSE ) { $pv['navigateur_pourri'] = 1; }
	if ( strpos($Navigator, "MSIE 10" ) !== FALSE ) { $pv['navigateur_pourri'] = 1; }
}

if ( $pv['navigateur_pourri'] == 1 ) {
	include ( "routines/MSIE6/MSIE6_banner.php");
	exit();
}
unset ( $Navigator );

// --------------------------------------------------------------------------------------------
include ("routines/website/fonctions_universelles.php");

/*
$localisation = " / Avant MDB2";
$_REQUEST['localisation'] .= $localisation;
statistique_checkpoint ("MDB2");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );
include ("MDB2.php");									// pear install MDB2_Driver_mysql
*/
// --------------------------------------------------------------------------------------------
//	Demmarrage
$localisation = "";
$_REQUEST['localisation'] .= $localisation;
statistique_checkpoint ("Demarrage");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

if (!isset($_REQUEST['sw']) || $_REQUEST['sw'] == 0 ) { $_REQUEST['sw'] = 2; }
$fichier_config = "config/actuelle/site_" . $_REQUEST['sw'] . "_config_mwm.php";
include ($fichier_config);
$SQL_tab = array();
$SQL_tab_abrege = array();
config_variable();
include ("routines/website/preparatifs_sql.php");
if ( $_REQUEST['SQL_fatal_error'] == 1 ) { include ("../modules/initial/MessageHorsLigne/message_hors_ligne.php"); }	//Affiche un banner si besoin

$langList = array();
genere_table_langue ( "langues" );

// --------------------------------------------------------------------------------------------
//	context site web - Authentification
$theme_tableau = "theme_princ_";
include ("routines/website/charge_donnees_site.php");
switch ( $site_web['sw_etat'] ) {
case 0:			//	Offline
case 3:			//	Maintenance
case 99:		//	Verouillé
	$site_web['banner_offline'] = 1; include ("../modules/initial/MessageHorsLigne/message_hors_ligne.php");
break;
}

session_name( "MWM".$_REQUEST['sw'] );
session_start();

include ("routines/website/authentification_utilisateur.php");
// --------------------------------------------------------------------------------------------
//	Les insertions
if ( $user['login_decode'] == "anonymous" && $_REQUEST['UPDATE_action'] == "UPDATE_USER" ) {
	if ( isset($_REQUEST['M_UTILIS']['lang']) ) { 
		$pv['sessionlangue'] = &$_REQUEST['M_UTILIS']['lang'];
		$site_web['sw_lang'] = $user['lang'] = $_SESSION['user_lang'] = $langList[$pv['sessionlangue']]['id'];
//		outil_debug ( $_REQUEST['M_UTILIS'] , "\$_REQUEST['M_UTILIS']" );
	}
}

$pv['UPDATE_action'] = 0;
if ( isset($_REQUEST['UPDATE_action']) ) { $pv['UPDATE_action']++; }
if ( $_SESSION['mode_session'] == 1 ) { $pv['UPDATE_action']++; }
if ( $user['login_decode'] != "anonymous" ) { $pv['UPDATE_action']++; }
if ( $pv['UPDATE_action'] == 3 ) {
	$_REQUEST['StatistiqueInsertion'] = 1;
	$_REQUEST['contexte_d_execution']	= "Admin_menu";
	$_REQUEST['mode_operatoire'] 		= "connexion_directe";

	$_REQUEST['site_context']['site_nom'] = $site_web['sw_nom'];
	$_REQUEST['site_context']['site_lang'] = $site_web['sw_lang'];
	include ("routines/website/manipulation_contexte.php");
	include ("routines/website/forge_de_commande.php");
	include ("routines/website/console_de_commande.php");

// ENG uniquement pour la gestion depuis un formulaire graphique 
	switch ( $_REQUEST['UPDATE_action'] ) {
	case "ADD_MODULE":			case "DELETE_MODULE":		case "UPDATE_MODULE":		include ("routines/website/manipulation_module.php");				break;
	case "ADD_ARTICLE":			case "DELETE_ARTICLE":		case "UPDATE_ARTICLE":		include ("routines/website/manipulation_article.php");				break;
	case "ADD_DEADLINE":		case "DELETE_DEADLINE":		case "UPDATE_DEADLINE":		include ("routines/website/manipulation_bouclage.php");				break;
	case "ADD_DECORATION":		case "DELETE_DECORATION":	case "UPDATE_DECORATION":	include ("routines/website/manipulation_decoration.php");			break;
	case "ADD_DOCUMENT":		case "DELETE_DOCUMENT":		case "UPDATE_DOCUMENT":		include ("routines/website/manipulation_document.php");				break;
	case "ADD_CATEGORY":		case "DELETE_CATEGORY":		case "UPDATE_CATEGORY":		include ("routines/website/manipulation_categorie.php");			break;
	case "ADD_GROUP":			case "DELETE_GROUP":		case "UPDATE_GROUP":		include ("routines/website/manipulation_groupe.php");				break;
	case "ADD_DOCUCONFIG":		case "DELETE_DOCUCONFIG":	case "UPDATE_DOCUCONFIG":																		break;
	case "ADD_MODULE":			case "DELETE_MODULE":		case "UPDATE_MODULE":		include ("routines/website/manipulation_module.php");				break;
	case "ADD_KEYWORD":			case "DELETE_KEYWORD":		case "UPDATE_KEYWORD":		include ("routines/website/manipulation_mot_cle.php");				break;
	case "ADD_DISPLAY":			case "DELETE_DISPLAY":		case "UPDATE_DISPLAY":		include ("routines/website/manipulation_presentation.php");			break;
	case "ADD_WEBSITE":										case "UPDATE_WEBSITE":		include ("routines/website/manipulation_site.php");					break;
	case "ADD_THEME":			case "DELETE_THEME":		case "UPDATE_THEME":		include ("routines/website/manipulation_theme.php");				break;
	case "ADD_USER":			case "DELETE_USER":			case "UPDATE_USER":			include ("routines/website/manipulation_utilisateur.php");			break;
	}

	//if ( isset($_REQUEST['MT_action']) ) { include ("routines/website/manipulation_tribune.php"); }
	$tampon_commande_buffer = array(); 
	forge_commande ($_REQUEST['UPDATE_action']);
	$ligne = 1;
	foreach ( $tampon_commande_buffer as $A ) { 
		command_line ($A);
		$ligne++; 
	}

	switch ( $_REQUEST['theme_activation'] == 1 ) {
	case TRUE:
		$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
		SELECT usr.*, grp.groupe_id, grp.groupe_nom, gu.groupe_premier, grp.groupe_tag
		FROM ".$SQL_tab['user']." usr, ".$SQL_tab['groupe_user']." gu, ".$SQL_tab['site_groupe']." sg , ".$SQL_tab['groupe']." grp 
		WHERE usr.user_login = '".$user['db_login']."' 
		AND usr.user_id = gu.user_id 
		AND gu.groupe_premier = '1'
		AND gu.groupe_id = grp.groupe_id 
		AND gu.groupe_id = sg.groupe_id 
		AND sg.site_id = '".$site_web['sw_id']."'
		;");
		while ($dbp = fetch_array_sql($dbquery)) { $user['pref_theme'] = $dbp['user_pref_theme']; }
	break;
	}

	if ( $_REQUEST['M_SITWEB']['modification_effectuee'] == 1 ) { include ("routines/website/charge_donnees_site.php"); }
	if ( $_REQUEST['M_UTILIS']['modification_effectuee'] == 1 ) {
		$auth_params['login_decode'] = $user['login_decode'];
		auth_chargement_donnee ( $auth_params );

		$pv['langage_priorisation'] = 0;
		if ( $site_web['sw_lang_select'] == 1 )	{ $pv['langage_priorisation'] += 1;	$pv['debug_auth']['sw_lang_select'] = "site_web['sw_lang_select'] == 1"; }
		if ( $_SESSION['user_lang'] != 0 )		{ $pv['langage_priorisation'] += 2; $pv['debug_auth']['SESSION_user_lang'] = "_SESSION['user_lang'] != 0"; }
		if ( $user['reset_identifiants'] != 1 )	{ $pv['langage_priorisation'] += 4;	$pv['debug_auth']['user_reset_identifiants'] = "user['reset_identifiants'] != 1"; }

		$pv['debug_auth']['langage_priorisation'] = $pv['langage_priorisation'];

		switch ( $pv['langage_priorisation'] ) {
		case 0 :
		case 1 :
		case 2 :
		case 4 :
		case 6 :	$pv['language_selection'] = $site_web['sw_lang'];	break;
		case 3 :	$pv['language_selection'] = $_SESSION['user_lang'];	break;
		case 5 :
		case 7 :	$pv['language_selection'] = $user['lang'];			break;
		}
		$user['lang'] = $site_web['sw_lang'] = $_SESSION['user_lang'] = $pv['language_selection'];
		$l = $langList[$pv['language_selection']]['langue_id'];

//		echo ("<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
//		user['lang'] = $user['lang']<br>\r
//		site_web['sw_lang'] = $site_web['sw_lang']<br>\r
//		_SESSION['user_lang'] = $_SESSION['user_lang']<br>\r
//		pv['langage_priorisation'] = $pv['langage_priorisation']<br>\r
//		1=ENG / 2=FR
//		");

	}
	$localisation = " / modification_admin";
	$_REQUEST['localisation'] .= $localisation;
	statistique_checkpoint ("modification_admin_fin");
	$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );
}

// --------------------------------------------------------------------------------------------
//	Console de commandes
$pv['CC_go'] = 0;
if ( isset($_REQUEST['CC_interface']) ) { $pv['CC_go']++; }
if ( $_SESSION['mode_session'] == 1) { $pv['CC_go']++; }
if ( $pv['CC_go'] == 2 ) {
	include ("routines/website/manipulation_article.php");
	include ("routines/website/manipulation_article_config.php");
	include ("routines/website/manipulation_bouclage.php");
	include ("routines/website/manipulation_categorie.php");
	include ("routines/website/manipulation_contexte.php");
	include ("routines/website/manipulation_decoration.php");
	include ("routines/website/manipulation_document.php");
	include ("routines/website/manipulation_groupe.php");
	include ("routines/website/manipulation_module.php");
	include ("routines/website/manipulation_mot_cle.php");
	include ("routines/website/manipulation_presentation.php");
	include ("routines/website/manipulation_site.php");
	include ("routines/website/manipulation_theme.php");
	include ("routines/website/manipulation_tag.php");
	include ("routines/website/manipulation_utilisateur.php");
	include ("routines/website/manipulation_variable.php");
	include ("routines/website/console_de_commande.php");
	include ("routines/website/formattage_commande.php");


	$_REQUEST['contexte_d_execution']	= "Admin_menu";
	$_REQUEST['mode_operatoire'] 		= "connexion_directe";
	$tampon_commande_buffer = stripslashes ($_REQUEST['requete_insert']); 
	$pv['CC_tampon'] = 0;

	$_REQUEST['SC_comportement'] = "interface_CC";
	$requete_insert['0'] = "site_context site ".$site_web['sw_nom']." user ".$user['login_decode']." password ".$user['pass_decode'].";"; 
	include ("install/install_routines/traitement_commande.php");
	unset ($requete_insert);

	$_REQUEST['SC_comportement'] = "interface_CC";
	$requete_insert['0'] = $tampon_commande_buffer;
	include ("install/install_routines/traitement_commande.php");
	unset ($requete_insert);

	$_REQUEST['SC_comportement'] = "interface_CC";
	$requete_insert['0'] = "site_context site ".$site_web['sw_nom']." user ".$user['login_decode']." password ".$user['pass_decode'].";";
	include ("install/install_routines/traitement_commande.php");
	unset ($requete_insert);


	$localisation = " / console_de_commande";
	$_REQUEST['localisation'] .= $localisation;
	statistique_checkpoint ("console_de_commande_fin");
	$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );
}

// --------------------------------------------------------------------------------------------
//
//
//	Début des affichages
//
//
// --------------------------------------------------------------------------------------------

$_REQUEST['contexte_d_execution']	= "Rendu";

//	Special block HTML >> ne pas etre autre part<<
$document_tableau = "DP_";
if ( !isset($_REQUEST['arti_ref']) || strlen($_REQUEST['arti_ref']) == 0 ) {
	$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
	SELECT cat.cate_id, cat.cate_nom, cat.arti_ref 
	FROM ".$SQL_tab['categorie']." cat, ".$SQL_tab['bouclage']." bcl
	WHERE cat.site_id = '".$site_web['sw_id']."'
	AND cat.cate_lang = '".$site_web['sw_lang']."'
	AND cat.bouclage_id = bcl.bouclage_id
	AND bcl.bouclage_etat = '1' 
	AND cat.cate_type IN ('0','1') 
	AND cat.groupe_id ".$user['clause_in_groupe']." 
	AND cat.cate_etat = '1' 
	AND cate_doc_premier = '1'  
	ORDER BY cat.cate_parent,cat.cate_position
	;");
	while ($dbp = fetch_array_sql($dbquery)) { $affdoc_arti_ref = ${$document_tableau}['arti_ref'] = $dbp['arti_ref']; }
	$affdoc_arti_page = ${$document_tableau}['arti_page'] = 1;
}
else {
	$affdoc_arti_ref	= ${$document_tableau}['arti_ref']	= $_REQUEST['arti_ref'];
	$affdoc_arti_page	= ${$document_tableau}['arti_page']	= $_REQUEST['arti_page'];
}

// --------------------------------------------------------------------------------------------
$bloc_html['post_hidden_sw']			= "<input type='hidden'	name='sw'			value='".$site_web['sw_id']."'>\r";
$bloc_html['post_hidden_l']				= "<input type='hidden'	name='l'			value='".$user['lang']."'>\r";
$bloc_html['post_hidden_user_login']	= "<input type='hidden'	name='user_login'	value='".$user['login']."'>\r";
$bloc_html['post_hidden_user_pass']		= "<input type='hidden'	name='user_pass'	value='".$user['pass']."'>\r";
$bloc_html['post_hidden_arti_ref']		= "<input type='hidden'	name='arti_ref'		value='".$DP_['arti_ref']."'>\r";
$bloc_html['post_hidden_arti_page']		= "<input type='hidden'	name='arti_page'	value='".$DP_['arti_page']."'>\r";

if ( $_SESSION['mode_session'] != 1 ) { $bloc_html['url_up'] = "&amp;user_login=".$user['login']."&amp;user_pass=".$user['pass'].""; }
$bloc_html['url_slup']	= "&amp;sw=".$site_web['sw_id']."&amp;l=".$user['lang'].$bloc_html['url_up'] ;																			// Site Lang User Pass
$bloc_html['url_sldup']	= "&amp;sw=".$site_web['sw_id']."&amp;l=".$user['lang']."&amp;arti_ref=".$DP_['arti_ref']."&amp;arti_page=".$DP_['arti_page'].$bloc_html['url_up'];		// Site Lang Article User Pass
$bloc_html['url_sdup']	= "&amp;sw=".$site_web['sw_id']."&amp;arti_ref=".$DP_['arti_ref']."&amp;arti_page=".$DP_['arti_page']. $bloc_html['url_up'];							// Site Article User Pass


$_REQUEST['FS_index'] = 0;
$_REQUEST['FS_table'] = array();

// --------------------------------------------------------------------------------------------
//	Elements et contenu de la page

include ("routines/website/charge_donnees_theme.php");

$JavaScriptFichier[] = "routines/website/javascript_statique.js";
$JavaScriptOnload[] = "\tGebi( 'MWMbody' ).style.visibility = 'visible';";


// --------------------------------------------------------------------------------------------
//	Affichage
include ("routines/website/charge_donnees_presentation.php");
$module_['compteur'] = 1;
include ("routines/website/affiche_module.php");

// --------------------------------------------------------------------------------------------
statistique_checkpoint ("index_avant_stat");

$localisation = " / idx";
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );
$_REQUEST['StatistiqueInsertion'] = 0;
// --------------------------------------------------------------------------------------------
$dbquery_AF = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab['module']." a, ".$SQL_tab['site_module']." b 
WHERE b.site_id = '".$site_web['sw_id']."' 
AND a.module_id = b.module_id 
AND b.module_etat = '1' 
AND a.module_groupe_pour_voir ".$user['clause_in_groupe']." 
AND a.module_adm_control > '0' 
ORDER BY module_position
;");

if ( num_row_sql($dbquery_AF) != 0 ) {
	$i = 1;
	while ($dbp_AF = fetch_array_sql($dbquery_AF)) { 
		$module_tab_adm_[$i]['module_id']					= $dbp_AF['module_id'];
		$module_tab_adm_[$i]['module_deco']					= $dbp_AF['module_deco'];
		$module_tab_adm_[$i]['module_deco_nbr']				= $dbp_AF['module_deco_nbr'];
		$module_tab_adm_[$i]['module_deco_txt_defaut']		= $dbp_AF['module_deco_txt_defaut'];
		$module_tab_adm_[$i]['module_nom']					= $dbp_AF['module_nom'];
		$module_tab_adm_[$i]['module_nom']					= str_replace ( $site_web['sw_abrege'] , "" , $module_tab_adm_[$i]['module_nom'] ); // trouver pourquoi enlever le tag MWM (ou RW) du nom)
		$module_tab_adm_[$i]['module_titre']				= $dbp_AF['module_titre'];
		$module_tab_adm_[$i]['module_fichier']				= $dbp_AF['module_fichier'];
		$module_tab_adm_[$i]['module_desc']					= $dbp_AF['module_desc'];
		$module_tab_adm_[$i]['module_groupe_pour_voir']		= $dbp_AF['module_groupe_pour_voir'];
		$module_tab_adm_[$i]['module_groupe_pour_utiliser']	= $dbp_AF['module_groupe_pour_utiliser'];
		$module_tab_adm_[$i]['module_adm_control']			= $dbp_AF['module_adm_control'];
		$i++;
	}
	include ("routines/website/affiche_admin_control.php");
}

// --------------------------------------------------------------------------------------------
echo ("
<!-- 
Auteur : FMA - 2005-2017
License : Creative commons CC-by-nc-sa (http://www.creativecommons.org/)
-->
");

// --------------------------------------------------------------------------------------------
//	Affichage des selecteurs de fichier si necessaire
$module_z_index['compteur'] = 500;		//Contourne les Z-index venant de la présentation
$pv['sdftotal'] = $_REQUEST['FS_index'];
if ( $_REQUEST['FS_index'] > 0 ) {
	if ( !function_exists("selecteur_de_fichier") ) {
		include ("routines/website/selecteur_de_fichier_div.php");
	}
	$JavaScriptFichier[] = "routines/website/javascript_lib_selecteur_fichier.js";

	for ( $pv['sdfcount'] = 1; $pv['sdfcount'] <= $pv['sdftotal']; $pv['sdfcount']++ ) { 
		$_REQUEST['FS_index'] = $pv['sdfcount'];
		listage_systeme_de_fichier(0); 
		$pv['SDF_id'] = $_REQUEST['FS_table'][$_REQUEST['FS_index']]['lsdf_indicatif'];
		$JavaScriptInitDonnees[] = "var TabSDF_".$pv['SDF_id']." = { \r".$_REQUEST['SDFObj']."\r};\r\r";
		$_REQUEST['SDFObj'] = "";
	}
	$JavaScriptInitCommandes[] = "SDFTabRepCourant ( TabSDF_".$pv['SDF_id'].", TabSDF_".$pv['SDF_id'].", 'selecteur_de_fichier_dynamique' );";

	$idx_ = &$_REQUEST['FS_table'][$_REQUEST['FS_index']];

	echo ("
	<div id='selecteur_de_fichier_FondNoir' 
	class ='".$theme_tableau."div_SelecteurDeFichierConteneur' 
	style='display:none; visibility:hidden; z-index:".$module_z_index['compteur'].";' 
	OnClick=\"wpsa[0][cliEnv.browser.support](); DisparitionElement( this.id ); DisparitionElement('selecteur_de_fichier_cadre');\">\r
	</div>\r

	<div id='selecteur_de_fichier_cadre' 
	class ='".$theme_tableau."div_SelecteurDeFichier' 
	style='left:".$idx_['left']."px;		top:".$idx_['top']."px; 
	width:".$idx_['width']."px ;	height:".$idx_['height']."px; 
	display:none; visibility:hidden; z-index:".($module_z_index['compteur']+1).";
	line-height:normal; overflow:auto;
	background-color:#".${$theme_tableau}['theme_bg_color'].";'>\r
	</div>\r
	");

}
// --------------------------------------------------------------------------------------------
if ( isset($JavaScriptPHPElements) )	{	foreach ( $JavaScriptPHPElements as $A )	{ include ($A); }		unset ($A);	}
if ( isset($JavaScriptFichier) )		{	foreach ( $JavaScriptFichier as $A )		{ echo ( "<script type='text/javascript' src='".$A."'></script>\r" ); }	unset ($A); }

$JavaScriptInitCommandes[] = "JavaScriptTabInfoModule ( 'modulecompletementfactice' , 1000 );";
//echo ("<script type='text/javascript'><!--/*--><![CDATA[//><!--\r");
echo ("<script type='text/javascript'>\r");
if ( isset($JavaScriptInitDonnees) )	{	foreach ( $JavaScriptInitDonnees as $A ) { echo ( $A . "\r" ); }		unset ($A);		}
if ( isset($JavaScriptInitCommandes) )	{	foreach ( $JavaScriptInitCommandes as $A ) { echo ( $A . "\r" ); }		unset ($A);		}
if ( isset($JavaScriptInit) )			{	foreach ( $JavaScriptInit as $A ) { echo ( $A . "\r" ); }				unset ($A);		}

echo ("function WindowOnload () {\r");	
if ( isset($JavaScriptOnload) )			{	foreach ( $JavaScriptOnload as $A ) { echo ( $A . "\r" ); }	unset ($A);	}
echo ("

}\r
window.onload = WindowOnload;\r\r

</script>\r");

// //--><!]]>window.trigger('redraw');

unset (
	$A,
	$JavaScriptFichier,
	$JavaScriptTabInfoModule,
	$JavaScriptInit,
	$JavaScriptOnload
);
// --------------------------------------------------------------------------------------------
session_write_close ();
disconnect_sql();
echo ("</body>\r</html>\r");

?>
