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
FROM ".$SQL_tab_abrege['deco_60_elysion']."  
WHERE deco_id = '".$pv['bloc_en_cours']['deco_id']."' 
;");
$p = &${$theme_tableau}[$_REQUEST['blocG']];
$p['liste_bloc'] = "B" . $_REQUEST['bloc'];

unset ( $A );
while ($dbp = fetch_array_sql($dbquery)) { $p['deco_'.$dbp['deco_variable']] = $dbp['deco_valeur']; }

$_REQUEST['liste_colonne_bgp']['elysion_60'] = array (
"deco_ex11_bgp", 
"deco_ex12_bgp",
"deco_ex13_bgp",
"deco_ex14_bgp",
"deco_ex15_bgp",
"deco_ex21_bgp",
"deco_ex22_bgp",
"deco_ex25_bgp",
"deco_ex31_bgp",
"deco_ex35_bgp",
"deco_ex41_bgp",
"deco_ex45_bgp",
"deco_ex51_bgp",
"deco_ex52_bgp",
"deco_ex53_bgp",
"deco_ex54_bgp",
"deco_ex55_bgp",

"deco_in11_bgp", 
"deco_in12_bgp",
"deco_in13_bgp",
"deco_in14_bgp",
"deco_in15_bgp",
"deco_in21_bgp",
"deco_in25_bgp",
"deco_in31_bgp",
"deco_in35_bgp",
"deco_in41_bgp",
"deco_in45_bgp",
"deco_in51_bgp",
"deco_in52_bgp",
"deco_in53_bgp",
"deco_in54_bgp",
"deco_in55_bgp"
);

unset ( $A , $B );
foreach ( $_REQUEST['liste_colonne_bgp']['elysion_60'] as $A ) { $p[$A] = $tab_bgp[$p[$A]]; }

$_REQUEST['compteur_bloc_drapeau'] = 1;

unset ($A, $B, $dbquery, $dbp, $_REQUEST['liste_colonne_bgp']['elysion_60'] );

?>
