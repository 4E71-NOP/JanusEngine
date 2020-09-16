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
	if ( strlen($p['deco_repertoire']) != 0 ) { $pv['theme_tmp_repertoire'] = ${$theme_tableau}[$_REQUEST['blocG']]['deco_repertoire']; }
	if ( $p['deco_a_line_height'] > 0 ) { $pv['supLH'] = "; line-height: ". $p['deco_a_line_height']."px;"; }
	$stylesheet .= 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex11" ) . " { position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex11'].");	".$p['deco_ex11_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex11_x']."px;	height: ".$p['deco_ex11_y']."px;	".$p['deco_ex11_bgp']."		background-repeat : no-repeat;	overflow:hidden }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex12" ) . " { position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex12'].");	".$p['deco_ex12_bgp']."	vertical-align: bottom;									height: ".$p['deco_ex12_y']."px;	".$p['deco_ex12_bgp']."		background-repeat : repeat-x;	overflow:hidden }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex13" ) . " { position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex13'].");	".$p['deco_ex13_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex13_x']."px;	height: ".$p['deco_ex13_y']."px;	".$p['deco_ex13_bgp']."		background-repeat : no-repeat;	overflow:hidden }\r" . 

	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex21" ) . " { position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex21'].");	".$p['deco_ex21_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex21_x']."px;										".$p['deco_ex21_bgp']."		background-repeat : repeat-y;	overflow:hidden }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex22" ) . " { position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex22'].");	".$p['deco_ex22_bgp']."	vertical-align: bottom;																		".$p['deco_ex22_bgp']."		background-repeat : repeat;		overflow:hidden".$pv['supLH']."}\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex23" ) . " { position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex23'].");	".$p['deco_ex23_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex23_x']."px;										".$p['deco_ex23_bgp']."		background-repeat : repeat-y;	overflow:hidden }\r" . 

	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex31" ) . " { position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex31'].");	".$p['deco_ex32_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex31_x']."px;	height: ".$p['deco_ex31_y']."px;	".$p['deco_ex31_bgp']."		background-repeat : no-repeat;	overflow:hidden }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex32" ) . " { position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex32'].");	".$p['deco_ex32_bgp']."	vertical-align: bottom;									height: ".$p['deco_ex32_y']."px;	".$p['deco_ex32_bgp']."		background-repeat : repeat-x;	overflow:hidden }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ex33" ) . " { position: absolute; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ex33'].");	".$p['deco_ex33_bgp']."	vertical-align: bottom;	width: ".$p['deco_ex33_x']."px;	height: ".$p['deco_ex33_y']."px;	".$p['deco_ex33_bgp']."		background-repeat : no-repeat;	overflow:hidden }\r 
	";

	$pv['PreloadImg'] = array ( "deco_ex11", "deco_ex12", "deco_ex13", "deco_ex21", "deco_ex22", "deco_ex23", "deco_ex31", "deco_ex32", "deco_ex33" );
	unset ($A);
	foreach ( $pv['PreloadImg'] as $A ) { $stylesheet_preload[] = $p[$A]; }
}
?>
