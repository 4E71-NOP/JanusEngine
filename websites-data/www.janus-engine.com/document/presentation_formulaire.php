<?php
 // @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see      : https://github.com/4E71-NOP/JanusEngine
//
// @license  : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author   : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note     : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//             without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end

$_REQUEST[MM][id] = 10 ;
/* -------------------------------------------------------------------------------------------- */
/*	2005 09 11 : fra_gestion_des_modules_p02.php debut 											*/
/*	2007 08 16 : derniere modification															*/
/* -------------------------------------------------------------------------------------------- */
/*JanusEngine-Content-Begin*/
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
/*JanusEngine-Content-End*/
?>
