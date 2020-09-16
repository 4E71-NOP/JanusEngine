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
$_REQUEST['Bloc_a_traiter_couleur'] = &${$theme_tableau}[$_REQUEST['blocT']];
${$theme_tableau}[$_REQUEST['blocT']]['deco_type'] = $pv['bloc_en_cours']['deco_type'];

$dbquery = requete_sql($_REQUEST['sql_initiateur'],"
SELECT * 
FROM ".$SQL_tab_abrege['deco_20_caligraphe']." 
WHERE deco_id = '".$pv['bloc_en_cours']['deco_id']."' 
;");

$p = &${$theme_tableau}[$_REQUEST['blocT']];
$p['liste_bloc'] = "B" . $_REQUEST['bloc'];
unset ( $A );
while ($dbp = fetch_array_sql($dbquery)) { $p['deco_'.$dbp['deco_variable']] = $dbp['deco_valeur']; }

$_REQUEST['compteur_bloc_drapeau'] = 1;

if ( strlen($p['deco_txt_fonte_dl_nom']) > 0 ) {
	if ( $_REQUEST['blocT'] == "B01T" ) {
		$stylesheet_at_fontface = "
		@font-face {
			font-family: '".${$theme_tableau}['B01T']['deco_txt_fonte_dl_nom']."'; src: url('../graph/".${$theme_tableau}['B01T']['deco_repertoire']."/".${$theme_tableau}['B01T']['deco_txt_fonte_dl_url']."') format('truetype');
			font-weight: normal;
			font-style: normal;
		}\r\r
		";
	}
	$p['deco_txt_fonte'] = $p['deco_txt_fonte_dl_nom'] . ", " . $p['deco_txt_fonte'] ; // txt_fonte = fallback
}

unset ($A, $B, $dbquery, $dbp );

?>
