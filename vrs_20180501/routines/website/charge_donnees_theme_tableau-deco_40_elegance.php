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
$_REQUEST['Traiter_couleur'] = 0;
${$theme_tableau}[$_REQUEST['blocG']]['deco_type'] = $pv['bloc_en_cours']['deco_type'];
$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab_abrege['deco_40_elegance']."  
WHERE deco_id = '".$pv['bloc_en_cours']['deco_id']."' 
;");
$p = &${$theme_tableau}[$_REQUEST['blocG']];
$p['liste_bloc'] = "B" . $_REQUEST['bloc'];

unset ( $A );
while ($dbp = fetch_array_sql($dbquery)) { $p['deco_'.$dbp['deco_variable']] = $dbp['deco_valeur']; }

$_REQUEST['liste_colonne_bgp']['elegance_40'] = array (
"deco_ex11_bgp",
"deco_ex12_bgp",
"deco_ex13_bgp",
"deco_ex21_bgp",
"deco_ex22_bgp",
"deco_ex23_bgp",
"deco_ex31_bgp",
"deco_ex32_bgp",
"deco_ex33_bgp"
);

unset ( $A , $B );
foreach ( $_REQUEST['liste_colonne_bgp']['elegance_40'] as $A ) { $p[$A] = $tab_bgp[$p[$A]]; }

$_REQUEST['compteur_bloc_drapeau'] = 1;

unset ($A, $B, $dbquery, $dbp, $_REQUEST['liste_colonne_bgp']['elegance_40'] );

?>
