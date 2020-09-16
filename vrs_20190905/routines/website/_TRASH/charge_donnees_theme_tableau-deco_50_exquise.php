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
$dbquery = $SDDMObj->query("
SELECT *
FROM ".$SqlTableListObj->getSQLTableName('deco_50_exquise')."
WHERE deco_id = '".$pv['bloc_en_cours']['deco_id']."'
;");
// $dbquery = requete_sql($_REQUEST['sql_initiateur'],"
// SELECT * 
// FROM ".$SQL_tab_abrege['deco_50_exquise']."  
// WHERE deco_id = '".$pv['bloc_en_cours']['deco_id']."' 
// ;");
$p = &${$theme_tableau}[$_REQUEST['blocG']];
$p['liste_bloc'] = "B" . $_REQUEST['bloc'];

unset ( $A );
while ($dbp = fetch_array_sql($dbquery)) { $p['deco_'.$dbp['deco_variable']] = $dbp['deco_valeur']; }

$_REQUEST['liste_colonne_bgp']['exquise_50'] = array (
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
"deco_ex55_bgp"
);

unset ( $A , $B );
foreach ( $_REQUEST['liste_colonne_bgp']['exquise_50'] as $A ) { $p[$A] = $tab_bgp[$p[$A]]; }

$_REQUEST['compteur_bloc_drapeau'] = 1;

unset ($A, $B, $dbquery, $dbp, $_REQUEST['liste_colonne_bgp']['exquise_50']);

?>
