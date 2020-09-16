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
//	Module : banniere
// --------------------------------------------------------------------------------------------
$localisation = " / module_banniere";
$MapperObj->AddAnotherLevel($localisation );
$SLMObj->logCheckpoint("module_banniere");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("module_banniere");

$_REQUEST['localisation'] .= $localisation;
// statistique_checkpoint ("module_banniere");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

if ( $skin_banniere."a" != "a" ) {
	echo ("<center><img src='../graph/".$skin_repertoire."/".$skin_banniere."' alt='".$nom_du_site."' border='0'></center>");
}

?>
