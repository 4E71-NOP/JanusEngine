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
//	Module : menu
//	Reconstitue nom du fichier avec le numero de style choisi et execute le fichier
// --------------------------------------------------------------------------------------------
$localisation = " / module_admin_menu";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("module_admin_menu_debut");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("module_admin_menu");

$_REQUEST['localisation'] .= $localisation;
// statistique_checkpoint ("module_admin_menu_debut");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

$_REQUEST['sql_initiateur'] = "Module admin menu";
$module_menu_requete = "
SELECT * 
FROM ".$SQL_tab['categorie']." 
WHERE cate_type IN ('2', '3') 
AND site_id IN ('1', '".$WebSiteObj->getWebSiteEntry('sw_id')."') 
AND cate_lang = '".$WebSiteObj->getWebSiteEntry('sw_lang')."' 
AND groupe_id ".$user['clause_in_groupe']." 
AND cate_etat = '1' 
;";

$menu_racine = 2; // type
include ( "../modules/initial/AdminMenu/module_menu_admin.php" );

$LMObj->logCheckpoint("module_admin_menu_fin");
// statistique_checkpoint ("module_admin_menu_fin");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

?>
