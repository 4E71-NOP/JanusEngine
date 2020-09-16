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
$localisation = " / module_blason";
$MapperObj->AddAnotherLevel($localisation );
$LMObj->logCheckpoint("module_blason");
$MapperObj->RemoveThisLevel($localisation );
$MapperObj->setSqlApplicant("module_blason");

$_REQUEST['localisation'] .= $localisation;
// statistique_checkpoint ("module_blason");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

echo ("
<div style='text-align: center;'>\r
<a href='www.rootwave.com' onMouseOver=\"Bulle('(?)Rootwave : Homepage')\" onMouseOut=\"Bulle()\">\r
<img src='../graph/".${$theme_tableau}['theme_repertoire']."/".${$theme_tableau}['theme_blason']."' alt='".$WebSiteObj->getWebSiteEntry('sw_nom')."' border='0'>\r
</a>\r
</div>\r
");

?>
