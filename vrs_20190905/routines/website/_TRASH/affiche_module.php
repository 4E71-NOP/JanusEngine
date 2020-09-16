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
$localisation_module = " / affiche_module";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("charge_donnes_site");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("affiche module");


$_REQUEST['localisation'] .= $localisation_module;
// statistique_checkpoint ("affiche_module");
$_REQUEST['sql_initiateur'] = "Affiche module";

$JavaScriptInitDonnees[] = "var TabInfoModule = new Array();\r";

if ( strlen( ${$theme_tableau}['theme_divinitial_bg'] ) > 0 ) { $pv['div_initial_bg'] = "background-image: url(../graph/".${$theme_tableau}['theme_repertoire']."/".${$theme_tableau}['theme_divinitial_bg']."); background-repeat: ".${$theme_tableau}['theme_divinitial_repeat'].";" ; }
if ( ${$theme_tableau}['theme_divinitial_dx'] == 0 ) { ${$theme_tableau}['theme_divinitial_dx'] = $_REQUEST['document_dx']; } 
if ( ${$theme_tableau}['theme_divinitial_dy'] == 0 ) { ${$theme_tableau}['theme_divinitial_dy'] = $_REQUEST['document_dy']; } 
// $LMObj->logDebug( ${$theme_tableau} , "\${\$theme_tableau}");
// $LMObj->logDebug( $pres_ , "\$pres_");

$pv['initial_div_vis'] = "hidden";
if ( $_REQUEST['debug_special'] == 1 ) { $pv['initial_div_vis'] = "visible"; }

echo ("<!-- __________ Debut des modules __________ -->\r
<div id='initial_div' style='position:relative; margin-left: auto; margin-right: auto; visibility:".$pv['initial_div_vis'].";
width:".${$theme_tableau}['theme_divinitial_dx']."px; 
height:".${$theme_tableau}['theme_divinitial_dy']."px;" .
$pv['div_initial_bg'].
"'>\r");	// width = toujours à définir sinon cela ne fonctionne pas.

$JavaScriptOnload[] = "\tGebi( 'initial_div' ).style.visibility = 'visible';";

$affiche_module_mode = "normal";
$module_z_index['compteur'] = 0 ;
$pv['i'] = 1;

foreach ( $module_tab_ as $module_ ) {
	$_REQUEST['module_nbr'] = 1;
	echo ("<!-- __________ Debut du module '".$module_['module_nom']."' __________ -->\r");

	if ( $user['groupe'][$module_['module_groupe_pour_voir']] == 1 ) {
		$pv['n'] = $module_['module_deco_nbr'];
		$_REQUEST['bloc'] = decoration_nomage_bloc ( "B", $pv['n'] , ""); 
		$_REQUEST['blocG'] = $_REQUEST['bloc'] . "G"; 
		$_REQUEST['blocT'] = $_REQUEST['bloc'] . "T"; 
		switch ( $module_['module_execution'] ) {
		case 0:
			choix_decoration ( ${$theme_tableau}[$_REQUEST['blocG']]['deco_type'] );
			if ( isset($module_['module_conteneur_nom']) && strlen($module_['module_conteneur_nom']) > 0 ) { echo ("</div>\r"); } 
			if (file_exists($module_['module_fichier'])) { include ($module_['module_fichier']); } else { echo ("!! !! !! !!"); }
			echo ("</div>\r");
		break;
		case 1:
			if (file_exists($module_['module_fichier'])) { include ($module_['module_fichier']); } else { echo ("!! !! !! !!"); }
			choix_decoration ( ${$theme_tableau}[$_REQUEST['blocG']]['deco_type'] );
			if ( isset($module_['module_conteneur_nom']) && strlen($module_['module_conteneur_nom']) > 0 ) { echo ("</div>\r"); } 
			echo ("</div>\r");
		break;
		case 2:
			choix_decoration ( ${$theme_tableau}[$_REQUEST['blocG']]['deco_type'] );
			if ( isset($module_['module_conteneur_nom']) && strlen($module_['module_conteneur_nom']) > 0 ) { echo ("</div>\r"); } 
			echo ("</div>\r");
			if (file_exists($module_['module_fichier'])) { include ($module_['module_fichier']); } else { echo ("!! !! !! !!"); }
		break;
		}
	}

	if ( isset ( $affiche_module_['contenu_apres_module'] ) ) { 
		echo $affiche_module_['contenu_apres_module'];
		unset ( $affiche_module_ );
	}

	echo ("<!-- __________ Fin du module '".$module_['module_nom']."' __________ -->\r\r\r\r\r");
	$pv['i']++;
	$module_z_index['compteur'] += 2;
}
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation_module )) );

echo ("</div>\r
<!-- __________ Fin des modules __________ -->\r
");

?>
