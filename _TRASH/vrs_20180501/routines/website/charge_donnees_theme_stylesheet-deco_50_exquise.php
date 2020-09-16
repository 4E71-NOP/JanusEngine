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
$p = &${$theme_tableau}[$_REQUEST['blocG']];
if ( strpos ( $p['liste_doublon'] , $_REQUEST['blocG'] ) === FALSE ) {
	if ( strlen(${$theme_tableau}[$_REQUEST['blocG']]['deco_repertoire']) != 0 ) { $pv['theme_tmp_repertoire'] = ${$theme_tableau}[$_REQUEST['blocG']]['deco_repertoire']; }
	if ( $p['deco_a_line_height'] > 0 ) { $pv['supLH'] = "; line-height: ". $p['deco_a_line_height']."px;"; }
	$stylesheet .= 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex11" ) . "{ position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex11'].");	".$p['deco_ex11_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex11_x']."px;	height: ".$p['deco_ex11_y']."px;	".$p['deco_ex11_bgp']."		background-repeat : no-repeat;	overflow:hidden }\r" .
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex12" ) . "{ position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex12'].");	".$p['deco_ex12_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex12_x']."px;	height: ".$p['deco_ex12_y']."px;	".$p['deco_ex12_bgp']."		background-repeat : no-repeat;	overflow:hidden }\r" .
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex13" ) . "{ position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex13'].");	".$p['deco_ex13_bgp']."	vertical-align: bottom;									height: ".$p['deco_ex13_y']."px;	".$p['deco_ex13_bgp']."		background-repeat : repeat-x;	overflow:hidden }\r" .
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex14" ) . "{ position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex14'].");	".$p['deco_ex14_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex14_x']."px;	height: ".$p['deco_ex14_y']."px;	".$p['deco_ex14_bgp']."		background-repeat : no-repeat;	overflow:hidden }\r" .
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex15" ) . "{ position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex15'].");	".$p['deco_ex15_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex15_x']."px;	height: ".$p['deco_ex15_y']."px;	".$p['deco_ex15_bgp']."		background-repeat : no-repeat;	overflow:hidden }\r" .

	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex21" ) . "{ position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex21'].");	".$p['deco_ex21_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex21_x']."px;	height: ".$p['deco_ex21_y']."px;	".$p['deco_ex21_bgp']."		background-repeat : no-repeat;	overflow:hidden }\r" .
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex22" ) . "{ position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex22'].");	".$p['deco_ex22_bgp']."	vertical-align: bottom;																		".$p['deco_ex22_bgp']."		background-repeat : repeat;		overflow:hidden;".$pv['supLH']." }\r" .
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex25" ) . "{ position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex25'].");	".$p['deco_ex25_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex25_x']."px;	height: ".$p['deco_ex25_y']."px;	".$p['deco_ex25_bgp']."		background-repeat : no-repeat;	overflow:hidden }\r" .

	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex31" ) . "{ position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex31'].");	".$p['deco_ex31_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex31_x']."px;	height: ".$p['deco_ex31_y']."px;	".$p['deco_ex31_bgp']."		background-repeat : repeat-y;	overflow:hidden }\r" .
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex35" ) . "{ position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex35'].");	".$p['deco_ex35_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex35_x']."px;	height: ".$p['deco_ex35_y']."px;	".$p['deco_ex35_bgp']."		background-repeat : repeat-y;	overflow:hidden }\r" .

	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex41" ) . "{ position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex41'].");	".$p['deco_ex41_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex41_x']."px;	height: ".$p['deco_ex41_y']."px;	".$p['deco_ex41_bgp']."		background-repeat : no-repeat;	overflow:hidden }\r" .
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex45" ) . "{ position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex45'].");	".$p['deco_ex45_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex45_x']."px;	height: ".$p['deco_ex45_y']."px;	".$p['deco_ex45_bgp']."		background-repeat : no-repeat;	overflow:hidden }\r" .

	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex51" ) . "{ position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex51'].");	".$p['deco_ex51_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex51_x']."px;	height: ".$p['deco_ex51_y']."px;	".$p['deco_ex51_bgp']."		background-repeat : no-repeat;	overflow:hidden }\r" .
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex52" ) . "{ position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex52'].");	".$p['deco_ex52_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex52_x']."px;	height: ".$p['deco_ex52_y']."px;	".$p['deco_ex52_bgp']."		background-repeat : no-repeat;	overflow:hidden }\r" .
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex53" ) . "{ position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex53'].");	".$p['deco_ex53_bgp']."	vertical-align: bottom;									height: ".$p['deco_ex53_y']."px;	".$p['deco_ex53_bgp']."		background-repeat : repeat-x;	overflow:hidden }\r" .
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex54" ) . "{ position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex54'].");	".$p['deco_ex54_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex54_x']."px;	height: ".$p['deco_ex54_y']."px;	".$p['deco_ex54_bgp']."		background-repeat : no-repeat;	overflow:hidden }\r" .
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex55" ) . "{ position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex55'].");	".$p['deco_ex55_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex55_x']."px;	height: ".$p['deco_ex55_y']."px;	".$p['deco_ex55_bgp']."		background-repeat : no-repeat;	overflow:hidden }\r
	";

	$pv['PreloadImg'] = array ( "deco_ex11", "deco_ex12", "deco_ex13", "deco_ex14", "deco_ex15", "deco_ex21", "deco_ex22", "deco_ex25", "deco_ex31", "deco_ex35", "deco_ex41", "deco_ex45", "deco_ex51", "deco_ex52", "deco_ex53", "deco_ex54", "deco_ex55" );
	unset ($A);
	foreach ( $pv['PreloadImg'] as $A ) { $stylesheet_preload[] = $p[$A]; }
}
?>
