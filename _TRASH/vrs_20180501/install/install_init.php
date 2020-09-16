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
$localisation = " / inst";
$_REQUEST['localisation'] .= $localisation;
statistique_checkpoint ( "Debut" );

// --------------------------------------------------------------------------------------------
// 0 Pas de journal;	1 erreurs;	2 +avertissment		3 +tout
// 0 No log; 			1 erreurs;	2 +warnings			3 +all
$_REQUEST['debug_option']['SQL_debug_level']		= 1;				// Préparatif_sql.php
$_REQUEST['debug_option']['CC_debug_level']			= 2;				// Console_de_commande.php; Manipulation_<element>.php
$_REQUEST['debug_option']['PHP_debug_level']		= 1;				// PHP original debug level
$_REQUEST['debug_option']['JS_debug_level']			= 0;				// Javascript
$_REQUEST['debug_option']['journalisation_cible']	= "aucun";			// 'systeme' (apache log), 'echo' (affichage erreur sur l'ecran), 'aucun' (conserve la comptabilité des états)
$_REQUEST['debug_option']['onglet_install_debug']	= 0;				// A investiguer

$_REQUEST['sql_initiateur'] = "Installation";

$JavaScriptFichier	= array();
$JavaScriptInit		= array();
$JavaScriptOnload	= array();

$_REQUEST['CC']['Compteur'] = 0;
$_REQUEST['CC_niveau_de_verification'] = 0;								//Fait les vérifications au complet des commandes entrées. Doublon, erreur etc.

// --------------------------------------------------------------------------------------------
//	Install options
// --------------------------------------------------------------------------------------------
$_REQUEST['contexte_d_execution'] = "Installation";

$_REQUEST['install_options']['mdp_dans_fichier_de_conf'] = 1;
//ini_set('memory_limit', '32M' );
ini_set('max_execution_time', 60 );

// --------------------------------------------------------------------------------------------
if ( $_REQUEST['debug_option']['PHP_debug_level'] == 0 ) { error_reporting(0); }
else { 
	error_reporting(E_ALL ^ E_NOTICE);
	//ini_set('display_errors','On');
	ini_set('log_errors', "On");
	ini_set('error_log' , "/var/log/apache2/error.log");
}

// --------------------------------------------------------------------------------------------
//	Mise en place d'un stylesheet et d'un entete HTML
// --------------------------------------------------------------------------------------------
include ( "routines/website/fonctions_universelles.php");
include ( "routines/website/decoration_onglet.php");

$SQL_tab = array();
$SQL_tab_abrege = array();
config_variable();

$_REQUEST['bloc'] = decoration_nomage_bloc ( "B" , "1" , "" );
$_REQUEST['blocG'] = $_REQUEST['bloc'] . "G";
$_REQUEST['blocT'] = $_REQUEST['bloc'] . "T";

// --------------------------------------------------------------------------------------------
include ("../stylesheets/css_admin_install.php");
$theme_tableau = "theme_princ_";
${$theme_tableau}['theme_module_largeur_interne'] = 896;
${$theme_tableau}['theme_module_largeur'] = 896;

$module_['module_deco'] = 1;

include ("routines/website/module_deco_40_elegance.php");
include ("routines/website/module_deco_50_exquise.php");

// --------------------------------------------------------------------------------------------
echo ("<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"	\"http://www.w3.org/TR/html4/loose.dtd\">\r

<html>\r
<head>\r
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>\r
<title>".$site_web['sw_titre']."</title>\r
".$stylesheet."\r
</head>\r
<body id='MWMbody' text='".${$theme_tableau}['theme_s01_txt_col']."' link='".${$theme_tableau}['theme_s01_txt_l_01_fg_col']."' vlink='".${$theme_tableau}['theme_s01_txt_l_01_fg_visite_col']."' alink='".${$theme_tableau}['theme_s01_txt_l_01_fg_active_col']."' background='../graph/".${$theme_tableau}['theme_repertoire']."/".${$theme_tableau}['theme_bg']."'>\r\r
");

if ( $_REQUEST['debug_option']['onglet_install_debug'] == 1 ) {
	outil_debug ( $_REQUEST['server_infos'] , '_REQUEST[server_infos]' );
	outil_debug ( $db_ , 'db_' );
	outil_debug ( $Support , 'Support' );
}

// --------------------------------------------------------------------------------------------
//
//
//	Debut de la presentation de la page d'installation
//
//
// --------------------------------------------------------------------------------------------
if ( !isset($_REQUEST['installation']) ) { $_REQUEST['installation'] = 1 ;}
statistique_checkpoint ( "Install avant page" );

if ( isset($_REQUEST['l']) ) {
	$pv['langue_comp'] = Array ("fra" ,"eng");
	unset ( $A );
	foreach ( $pv['langue_comp'] as $A ) { if ( $A == $_REQUEST['l'] ) { $pv['langue_hit'] = 1; } }
}
if ( $pv['langue_hit'] == 1 ) { $l = $_REQUEST['l']; }
else { $l = "fra"; }

$tl_['fra']['txt01']	= "Bienvenue sur Multi-Web Manager !";
$tl_['eng']['txt01']	= "Welcome to Multi-Web Manager !";

// --------------------------------------------------------------------------------------------

if ( strlen( ${$theme_tableau}['theme_divinitial_bg'] ) > 0 ) { $pv['div_initial_bg'] = "background-image: url(../graph/".${$theme_tableau}['theme_repertoire']."/".${$theme_tableau}['theme_divinitial_bg']."); background-repeat: ".${$theme_tableau}['theme_divinitial_repeat'].";" ; } 
if ( ${$theme_tableau}['theme_divinitial_dx'] == 0 ) { ${$theme_tableau}['theme_divinitial_dx'] = ${$theme_tableau}['theme_module_largeur'] + 16; } 
if ( ${$theme_tableau}['theme_divinitial_dy'] == 0 ) { ${$theme_tableau}['theme_divinitial_dy'] = ${$theme_tableau}['theme_module_largeur'] + 16; } 
echo ("<!-- __________ Debut des modules __________ -->\r
<div id='initial_div' style='position:relative; margin-left: auto; margin-right: auto; visibility: hidden;
width:".${$theme_tableau}['theme_divinitial_dx']."px; 
height:".${$theme_tableau}['theme_divinitial_dy']."px;" .
$pv['div_initial_bg'].
"'>\r");

$module_['module_nom'] = "Admin_install_B1"; $mn = &$module_['module_nom'];
$pres_[$mn]['px'] = 0; $pres_[$mn]['py'] = 0; $pres_[$mn]['dx'] = ${$theme_tableau}['theme_module_largeur']; $pres_[$mn]['dy'] = 112; $module_['module_deco_nbr'] = 2; 
$pv['y_suivant'] = $pres_[$mn]['dy'] + 4;
$pv['n'] = $module_['module_deco_nbr'];
$_REQUEST['bloc'] = decoration_nomage_bloc ( "B", $pv['n'] , ""); 
$_REQUEST['blocG'] = $_REQUEST['bloc'] . "G"; 
$_REQUEST['blocT'] = $_REQUEST['bloc'] . "T"; 
choix_decoration ( "50" );
echo ("<p class='".$theme_tableau .$_REQUEST['bloc']."_tb7' style='text-align: center;'>".$tl_[$l]['txt01']."</p></div>\r");

// --------------------------------------------------------------------------------------------

$module_['module_nom'] = "Admin_install_B2"; $mn = &$module_['module_nom'];
$pres_[$mn]['px'] = 0; $pres_[$mn]['py'] = 120; $pres_[$mn]['dx'] = ${$theme_tableau}['theme_module_largeur']; $pres_[$mn]['dy'] = 816+64; $module_['module_deco_nbr'] = 1;

$pv['n'] = $module_['module_deco_nbr'];
$_REQUEST['bloc'] = decoration_nomage_bloc ( "B", $pv['n'] , ""); 
$_REQUEST['blocG'] = $_REQUEST['bloc'] . "G"; 
$_REQUEST['blocT'] = $_REQUEST['bloc'] . "T"; 
choix_decoration ( "40" );

// --------------------------------------------------------------------------------------------
//
//		Pages - Présentation des informations
//
// --------------------------------------------------------------------------------------------
//$pv['PageInstall'] = 1 ;
if ( !isset( $_REQUEST['PageInstall']) ) { $_REQUEST['PageInstall'] = 1; }

switch ( $_REQUEST['PageInstall'] ) {
case "1":	include ( "install/install_page_01.php");	break;
case "2":	include ( "install/install_page_02.php");	break;
}

echo ("</div>\r"); // fin 'Bloc en cours'
echo ("</div>\r"); // fin 'initial_div'

/*
Préparatif pour test de IFRAME
echo ("
<div id='intall_moniteur'><iframe width='512' heigth='512' src='install/install_moniteur.php'></iframe></div>\r
");
*/

// --------------------------------------------------------------------------------------------
// Aide dynamique
// --------------------------------------------------------------------------------------------
$module_['module_conteneur_nom'] = "CalqueConteneur";
$module_['module_nom'] = "AideDynamique"; $mn = &$module_['module_nom'];
$pres_[$mn]['px'] = 8; $pres_[$mn]['py'] = 4; $pres_[$mn]['dx'] = 320; $pres_[$mn]['dy'] = 192; $module_['module_deco_nbr'] = 20;
$pv['n'] = $module_['module_deco_nbr'];
$_REQUEST['bloc'] = decoration_nomage_bloc ( "B", $pv['n'] , ""); 
$_REQUEST['blocG'] = $_REQUEST['bloc'] . "G"; 
$_REQUEST['blocT'] = $_REQUEST['bloc'] . "T"; 
choix_decoration ( "40" );
echo ("
</div>\r
</div>\r
");

$JavaScriptInitDonnees[] = "var DivInitial = LocaliseElement ( 'initial_div' );";
$JavaScriptInitDonnees[] = "var TabInfoModule = new Array();\r";
$JavaScriptInitCommandes[] = "JavaScriptTabInfoModule ( '".$module_['module_nom']."' , ".${$theme_tableau}[$_REQUEST['blocG']]['deco_type']." );";

$JavaScriptOnload[] = "\tinitAdyn('".$module_['module_conteneur_nom']."' , '".$module_['module_nom']."_ex22' , '".$pres_[$mn]['dx']."' , '".$pres_[$mn]['dy']."' );";

// --------------------------------------------------------------------------------------------
// Fichier Javascript
// --------------------------------------------------------------------------------------------
unset ($A);

$JavaScriptFichier[] = "install/install_routines/install_test_db.js";
$JavaScriptFichier[] = "install/install_routines/install_fonctions.js";
$JavaScriptFichier[] = "routines/website/javascript_statique.js";
$JavaScriptFichier[] = "routines/website/javascript_onglet.js";
$JavaScriptFichier[] = "routines/website/javascript_Aide_dynamique.js";
$JavaScriptFichier[] = "routines/website/javascript_lib_calculs_decoration.js";
$JavaScriptFichier[] = "routines/website/javascript_lib_animation_document.js";

$JavaScriptOnload[] = "\tGebi( 'initial_div' ).style.visibility = 'visible';";
$JavaScriptOnload[] = "\tGebi( 'MWMbody' ).style.visibility = 'visible';";

foreach ( $JavaScriptFichier as $A ) { echo ( "<script type='text/javascript' src='".$A."'></script>\r" ); }
unset ($A);

echo ("<script type='text/javascript'><!--/*--><![CDATA[//><!--\r");

foreach ( $JavaScriptInitDonnees as $A ) { echo ( $A . "\r" ); }
unset ($A);
foreach ( $JavaScriptInitCommandes as $A ) { echo ( $A . "\r" ); }
unset ($A);
foreach ( $JavaScriptInit as $A ) { echo ( $A . "\r" ); }
unset ($A);

echo ("function WindowOnload () {\r");	
foreach ( $JavaScriptOnload as $A ) { echo ( $A . "\r" ); }
unset ($A);

echo ("}\r
window.onload = WindowOnload;\r\r
//--><!]]>
</script>\r");
unset ($A);

// --------------------------------------------------------------------------------------------
echo ("
</body>
</html>
");

if ( $_REQUEST['debug_option']['onglet_install_debug'] == 1 ) {
	error_log (  "------------------------------------------------------------ _*_ ------------------------------------------------------------" ,0 );
	outil_debug ( $JavaScriptFichier , 'JavaScriptFichier' );
	outil_debug ( $JavaScriptInit , 'JavaScriptInit' );
	outil_debug ( $JavaScriptOnload , 'JavaScriptOnload' );
}

?>
