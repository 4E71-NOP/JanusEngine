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
$localisation = " / module_affiche_document";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("module_affiche_document");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("module_affiche_document");

$_REQUEST['localisation'] .= $localisation;
// statistique_checkpoint ("module_affiche_document");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

include ("../module/initial/AfficheDocument/module_affiche_document_principal.php");

?>
