<?php
 /*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/
$_REQUEST[MM][id] = 10 ;
/* -------------------------------------------------------------------------------------------- */
/*	2005 09 11 : fra_gestion_des_modules_p02.php debut 											*/
/*	2007 08 16 : derniere modification															*/
/* -------------------------------------------------------------------------------------------- */
/*Hydr-Content-Begin*/
$_REQUEST[sql_initiateur] = "fra_gestion_des_modules_p02";

for ( $i=1 ; $i<=3 ; $i++ ) {
	for ( $j=1 ; $j<=3 ; $j++ ) {
		for ( $k=1 ; $k<=3 ; $k++ ) {
			$PF_[$i][$j][$k][cont] = $i . $j . $j ;
		}
	}
}

include ("engine/layout_formulaire.php");

/*

$dbquery = requete_sql($_REQUEST[sql_initiateur],"
SELECT a.*,b.module_state 
FROM $SQL_tab[module] a , $SQL_tab[module_website] b 
WHERE a.module_id = '".$_REQUEST[MM][id]."'  
AND a.module_id = b.module_id 
AND b.ws_id = '$website[ws_id]' 
;");

while ($dbp = fetch_array_sql($dbquery)) { 
	foreach ( $dbp as $A => $B ) { $table_module[$A] = $B; }
}
*/
/*Hydr-Content-End*/
?>
