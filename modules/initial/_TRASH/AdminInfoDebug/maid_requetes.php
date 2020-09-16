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
//	Rapport sur les requetes
// --------------------------------------------------------------------------------------------
$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 0;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 4;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;

$tl_['eng']['o3l12']	= "Query count";			$tl_['fra']['o3l12']	= "Nombre de requetes";

$AD[$pv['onglet']]['caption']['cont'] = $tl_[$l]['o3l12'] ." : ". ($SQL_requete['nbr'] -1);

unset ( $SQL_requete['nbr'] );
$tl_['eng']['o3l21']	= "N";			$tl_['fra']['o3l21']	= "N";
$tl_['eng']['o3l22']	= "Origin";		$tl_['fra']['o3l22']	= "Origine";
$tl_['eng']['o3l23']	= "Time";		$tl_['fra']['o3l23']	= "Temps";
$tl_['eng']['o3l24']	= "Query";		$tl_['fra']['o3l24']	= "Requete";

$AD[$pv['onglet']]['1']['1']['cont'] = $tl_[$l]['o3l21'];	$AD[$pv['onglet']]['1']['1']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";	$AD[$pv['onglet']]['1']['1']['style'] = "text-align: center;";
$AD[$pv['onglet']]['1']['2']['cont'] = $tl_[$l]['o3l22'];	$AD[$pv['onglet']]['1']['2']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";
$AD[$pv['onglet']]['1']['3']['cont'] = $tl_[$l]['o3l23'];	$AD[$pv['onglet']]['1']['3']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";	$AD[$pv['onglet']]['1']['3']['style'] = "text-align: center;";
$AD[$pv['onglet']]['1']['4']['cont'] = $tl_[$l]['o3l24'];	$AD[$pv['onglet']]['1']['4']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";

$pv['i'] = 2;
unset ( $A );

// foreach ( $SQL_requete as $A ) {
foreach ( $LMObj->getSqlQueryLog() as $A ) {
	$pv['requete'] = string_format_html($A['requete']); 

	$pv['temp_query'] = round( ( $A['temps_fin'] - $A['temps_debut'] ) , 4);
	$pv['temp_query_cumul'] += $pv['temp_query'];

	$AD[$pv['onglet']][$pv['i']]['1']['cont'] = $A['nbr'];				$AD[$pv['onglet']][$pv['i']]['1']['style'] = "text-align: center;"; $AD[$pv['onglet']][$pv['i']]['1']['tc'] = 1;
	$AD[$pv['onglet']][$pv['i']]['2']['cont'] = $A['nom'];																					$AD[$pv['onglet']][$pv['i']]['2']['tc'] = 2;
	$AD[$pv['onglet']][$pv['i']]['3']['cont'] = $pv['temp_query'];		$AD[$pv['onglet']][$pv['i']]['3']['style'] = "text-align: center;"; $AD[$pv['onglet']][$pv['i']]['3']['tc'] = 1;
	$AD[$pv['onglet']][$pv['i']]['4']['cont'] = $pv['requete'];	
	$AD[$pv['onglet']][$pv['i']]['4']['tc'] = 1; 
	if ( isset ($A['signal']) && $A['signal'] != "OK")	{ 
// 		outil_debug($A, "A");
		$AD[$pv['onglet']][$pv['i']]['4']['cont'] .= "<br>\r" . $A['err_no']." : ".$A['err_msg'];
		$AD[$pv['onglet']][$pv['i']]['4']['class'] = $theme_tableau.$_REQUEST['bloc']."_avert"; 
		$AD[$pv['onglet']][$pv['i']]['4']['style'] = "font-weight: bold";
		$AD[$pv['onglet']][$pv['i']]['4']['tc'] = 2; 
	}
	$pv['i']++;
}
$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = $pv['i'] - 1;

unset ( $A );
?>
