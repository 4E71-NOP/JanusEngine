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
$localisation = " / module_aide_dynamique";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("module_aide_dynamique");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("module_aide_dynamique");

$_REQUEST['localisation'] .= $localisation;
// statistique_checkpoint ("module_aide_dynamique");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

$pv['cdx'] = $pres_[$module_['module_nom']]['cdx'];
$pv['cdy'] = $pres_[$module_['module_nom']]['cdy'];

$JavaScriptFichier[] = "routines/website/javascript_Aide_dynamique.js";
$JavaScriptFichier[] = "routines/website/javascript_lib_calculs_decoration.js";
//JavaScriptTabInfoModule ( $module_['module_nom'] , ${$theme_tableau}[$_REQUEST['blocG']]['deco_type'] );
$JavaScriptInitCommandes[] = "JavaScriptTabInfoModule ( '".$module_['module_nom']."' , ".${$theme_tableau}[$_REQUEST['blocG']]['deco_type']." );";
$JavaScriptOnload[] = "\tinitAdyn('".$module_['module_conteneur_nom']."' , '".$module_['module_nom']."_ex22' , '".$pv['cdx']."' , '".$pv['cdy']."' );";

?>
