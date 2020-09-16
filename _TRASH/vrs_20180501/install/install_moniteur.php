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
// --------------------------------------------------------------------------------------------
// 0 Pas de journal;	1 erreurs;	2 +avertissment		3 +tout
// 0 No log; 			1 erreurs;	2 +warnings			3 +all
$_REQUEST['debug_option']['SQL_debug_level']		= 1;				// Préparatif_sql.php
$_REQUEST['debug_option']['CC_debug_level']			= 1;				// Manipulation_<element>.php
$_REQUEST['debug_option']['PHP_debug_level']		= 1;				// PHP original debug level
$_REQUEST['debug_option']['JS_debug_level']			= 0;				// Javascript
$_REQUEST['debug_option']['journalisation_cible']	= "aucun";			// 'systeme' (apache log), 'echo' (affichage erreur sur l'ecran), 'aucun' (conserve la comptabilité des états)
$_REQUEST['debug_option']['onglet_install_debug']	= 0;				// A investiguer

$_REQUEST['sql_initiateur'] = "Installation";
// --------------------------------------------------------------------------------------------
$_REQUEST['contexte_d_execution'] = "Installation";

// --------------------------------------------------------------------------------------------
error_reporting( E_ERROR | E_WARNING | E_PARSE );							// http://fr2.php.net/error_reporting
ini_set('log_errors', "On");
ini_set('error_log' , "/var/log/apache2/error.log");

// --------------------------------------------------------------------------------------------
//chdir('../../');		//change le répertoire courant

$_REQUEST['localisation'] = "";
function microtime_chrono() {
	list($usec, $sec) = explode(" ", microtime( TRUE ));
	return ((float)$usec + (float)$sec);
}

$statistiques_ = [];
$statistiques_index = 0;

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
$localisation = " / inst";
$_REQUEST['localisation'] .= $localisation;
statistique_checkpoint ( "Debut" );

// --------------------------------------------------------------------------------------------
$db_ = array();
$db_['dal']						= $_REQUEST['form']['database_dal_choix'];
$db_['type']					= $_REQUEST['form']['database_type_choix'];
$db_['host']					= $_REQUEST['form']['database_host'];
$db_['user_login']				= $_REQUEST['form']['db_hosting_prefix'] . $_REQUEST['form']['db_admin_user'];
$db_['user_password']			= $_REQUEST['form']['db_admin_password'];
$db_['tabprefix']				= $_REQUEST['form']['prefix_des_tables'];
$db_['database_user_login']		= $_REQUEST['form']['db_hosting_prefix'] . $_REQUEST['form']['database_user_login'];
$db_['database_user_password']	= $_REQUEST['form']['database_user_password'];
$db_['dbprefix']				= $_REQUEST['form']['db_hosting_prefix'] . $_REQUEST['form']['dbprefix'];
$db_['dbprefix2']				= "mysql";
include ( "routines/website/fonctions_universelles.php");

$SQL_tab = array();
$SQL_tab_abrege = array();
config_variable();

// --------------------------------------------------------------------------------------------
include ("../stylesheets/css_admin_install.php");
$theme_tableau = "theme_princ_";
${$theme_tableau}['theme_module_largeur_interne'] = 512;
${$theme_tableau}['theme_module_largeur'] = 512;

$module_['module_deco'] = 1;

$_REQUEST['bloc'] = decoration_nomage_bloc ( "B" , "1" , "" );
$_REQUEST['blocG'] = $_REQUEST['bloc'] . "G";
$_REQUEST['blocT'] = $_REQUEST['bloc'] . "T";
include ("routines/website/preparatifs_sql.php");
include ("routines/website/module_deco_40_elegance.php");


// --------------------------------------------------------------------------------------------
// Récupération des données
// --------------------------------------------------------------------------------------------
$pv['onglet'] = 1;
$lt = 0;
unset ($A);
$l = $_REQUEST['l'];

$tl_['fra']['SQL_requete_nbr'] = "Nombre d'action SQL";			$tl_['eng']['SQL_requete_nbr'] = "SQL action count";
$tl_['fra']['commande_nbr'] = "Nombre de commandes";			$tl_['eng']['commande_nbr'] = "Command count";
$tl_['fra']['SQL_pas pret'] = "Pas encore disponible.";			$tl_['eng']['SQL_pas pret'] = "Not available for now.";

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"SELECT * FROM ".$SQL_tab['installation'].";");
$Cell = 1;

if ( num_row_sql($dbquery) > 0 ) {
	while ($dbp = fetch_array_sql($dbquery)) {
		if ( $dbp['install_etat_affichage'] == 1 ) {
			$lt++;
			$AD[$pv['onglet']][$lt][$Cell]['cont'] = $tl_[$l][$dbp['install_etat_nom']];		$AD[$pv['onglet']][$lt][$Cell]['tc'] = 4;		$Cell++;
			$AD[$pv['onglet']][$lt][$Cell]['cont'] = $dbp['install_etat_nombre'];				$AD[$pv['onglet']][$lt][$Cell]['tc'] = 4;		$Cell--;
		}
		else {
			$pv['var'][$dbp['install_etat_nom']]['nombre'] = $dbp['install_etat_nombre'];
			$pv['var'][$dbp['install_etat_nom']]['texte'] = $dbp['install_etat_texte'];
		}
	}
}
else { 
	$lt++;
	$AD[$pv['onglet']][$lt][$Cell]['cont'] = $tl_[$l]['SQL_pas pret'];		$AD[$pv['onglet']][$lt][$Cell]['tc'] = 4;		$Cell++;
}


$pv['Inactif'] = $pv['var']['moniteur_verification']['nombre'] - $pv['var']['derniere_activite']['nombre'];
if ( $pv['Inactif'] > 6 ) {
	$tl_['fra']['inactif'] = "Inactif depuis";			$tl_['eng']['inactif'] = "Inactive since";

	$lt++;
	$Cell = 1;
	$AD[$pv['onglet']][$lt][$Cell]['cont'] = $tl_[$l]['inactif'];
	$AD[$pv['onglet']][$lt][$Cell]['tc'] = 7;
	$AD[$pv['onglet']][$lt][$Cell]['class'] = $theme_tableau.$_REQUEST['bloc']."_erreur";
	$AD[$pv['onglet']][$lt][$Cell]['style'] = "font-weight:bold;";
	$Cell++;

	$AD[$pv['onglet']][$lt][$Cell]['cont'] = $pv['Inactif'] . "s";
	$AD[$pv['onglet']][$lt][$Cell]['tc'] = 7;
	$AD[$pv['onglet']][$lt][$Cell]['class'] = $theme_tableau.$_REQUEST['bloc']."_erreur";
	$AD[$pv['onglet']][$lt][$Cell]['style'] = "font-weight:bold;";
	$Cell++;
}
requete_sql ( $_REQUEST['sql_initiateur'], "UPDATE ".$SQL_tab_abrege['installation']." SET install_etat_nombre = '".time()."' WHERE install_etat_nom = 'moniteur_verification';" );

$pv['refraichissement'] = 3;
$tl_['fra']['message01'] = "Installation en cours";
$tl_['eng']['message01'] = "Installation is running";
if ( $pv['var']['SessionID']['nombre'] == $_REQUEST['SessionID'] && $pv['var']['affichage']['nombre'] == 0 ) { 

	$pv['refraichissement'] = 3600*24; 
	$tl_['fra']['message01'] = "Installation termin&eacute;e";
	$tl_['eng']['message01'] = "Installation done";


	$tl_['fra']['temps'] = "Temps";
	$tl_['eng']['temps'] = "Time";
	$Cell = 1;
	$lt++;
	$AD[$pv['onglet']][$lt][$Cell]['cont'] = $tl_[$l]['temps'];	$Cell++;
	$AD[$pv['onglet']][$lt][$Cell]['cont'] = ( $pv['var']['date_fin']['nombre'] - $pv['var']['date_debut']['nombre'] ) ;	$Cell++;
}
$pv['message01'] = $tl_[$l]['message01'];

// --------------------------------------------------------------------------------------------
echo ("<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"	\"http://www.w3.org/TR/html4/loose.dtd\">\r
<html>\r
<head>\r
<meta http-equiv='refresh' content='".$pv['refraichissement']."'>\r
<title>M W M - Install progression</title>\r
".$stylesheet."\r
</head>\r
<body id='MWMbody' text='".${$theme_tableau}['theme_s01_txt_col']."' link='".${$theme_tableau}['theme_s01_txt_l_01_fg_col']."' vlink='".${$theme_tableau}['theme_s01_txt_l_01_fg_visite_col']."' alink='".${$theme_tableau}['theme_s01_txt_l_01_fg_active_col']."' background='../graph/".${$theme_tableau}['theme_repertoire']."/".${$theme_tableau}['theme_bg']."'>\r\r
");


if ( strlen( ${$theme_tableau}['theme_divinitial_bg'] ) > 0 ) { $pv['div_initial_bg'] = "background-image: url(../graph/".${$theme_tableau}['theme_repertoire']."/".${$theme_tableau}['theme_divinitial_bg']."); background-repeat: ".${$theme_tableau}['theme_divinitial_repeat'].";" ; } 
if ( ${$theme_tableau}['theme_divinitial_dx'] == 0 ) { ${$theme_tableau}['theme_divinitial_dx'] = ${$theme_tableau}['theme_module_largeur'] + 16; } 
if ( ${$theme_tableau}['theme_divinitial_dy'] == 0 ) { ${$theme_tableau}['theme_divinitial_dy'] = ${$theme_tableau}['theme_module_largeur'] + 16; } 
echo ("<!-- __________ Debut des modules __________ -->\r
<div id='initial_div' style='position:relative; margin-left: auto; margin-right: auto; visibility: visible;
width:".${$theme_tableau}['theme_divinitial_dx']."px; 
height:".${$theme_tableau}['theme_divinitial_dy']."px;" .
$pv['div_initial_bg'].
"'>\r");


$module_['module_nom'] = "Admin_install B1"; $mn = &$module_['module_nom'];
$pres_[$mn]['px'] = 0; $pres_[$mn]['py'] = 128; $pres_[$mn]['dx'] = ${$theme_tableau}['theme_module_largeur']; $pres_[$mn]['dy'] = 256; $module_['module_deco_nbr'] = 2; 
$pv['y_suivant'] = $pres_[$mn]['dy'] + 4;
$pv['n'] = $module_['module_deco_nbr'];
$_REQUEST['bloc'] = decoration_nomage_bloc ( "B", $pv['n'] , ""); 
$_REQUEST['blocG'] = $_REQUEST['bloc'] . "G"; 
$_REQUEST['blocT'] = $_REQUEST['bloc'] . "T"; 
choix_decoration ( "50" );
echo ( "<br>\r
<sapn class='".$theme_tableau.$_REQUEST['bloc']."_tb7'>" . $pv['message01'] . "</sapn>\r
<br>\r
<br>\r
");

// --------------------------------------------------------------------------------------------
if ( $pv['var']['SessionID']['nombre'] == $_REQUEST['SessionID'] ) { 
	$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = $lt;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 2;	$ADC['onglet'][$pv['onglet']]['legende'] = 0;
	$tab_infos['AffOnglet']			= 0;
	$tab_infos['NbrOnglet']			= 1;
	$tab_infos['NbrOnglet']			+= $_REQUEST['debug_option']['onglet_install_debug'];
	$tab_infos['tab_comportement']	= 1;
	$tab_infos['mode_rendu']		= 0;
	$tab_infos['TypSurbrillance']	= 0; // 1:ligne, 2:cellule
	$tab_infos['doc_height']		= 368;
	$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_largeur_interne'] -24 ;
	$tab_infos['groupe']			= "inst1";
	$tab_infos['cell_id']			= "cadre01";
	$tab_infos['document']			= "doc";
	include ("routines/website/affichage_donnees.php");
} 

//echo ( print_r_html ( $pv ));

echo ("
</div>\r
</body>\r
</html>\r
");

?>
