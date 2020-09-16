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
$_REQUEST['Traiter_couleur'] = 1;
$_REQUEST['Bloc_a_traiter_couleur'] = &${$theme_tableau}[$_REQUEST['blocG']];
${$theme_tableau}[$_REQUEST['blocG']]['deco_type'] = $pv['bloc_en_cours']['deco_type'];

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab_abrege['deco_30_1_div']." 
WHERE deco_id = '".$pv['bloc_en_cours']['deco_id']."' 
;");

$p = &${$theme_tableau}[$_REQUEST['blocG']];
$p['liste_bloc'] = "B" . $_REQUEST['bloc'];

unset ( $A );
while ($dbp = fetch_array_sql($dbquery)) { $p['deco_'.$dbp['deco_variable']] = $dbp['deco_valeur']; }

$_REQUEST['compteur_bloc_drapeau'] = 1;

unset ($A, $B, $dbquery, $dbp );

?>
