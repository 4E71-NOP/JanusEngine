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
//	Affichage des variables de la page
// --------------------------------------------------------------------------------------------

$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 0;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 2;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;

$tl_['eng']['o8l11']	= "Name";		$tl_['fra']['o8l11']	= "Nom";
$tl_['eng']['o8l12']	= "Content";	$tl_['fra']['o8l12']	= "Contenu";

$AD[$pv['onglet']]['1']['1']['cont'] = $tl_[$l]['o8l11'];	$AD[$pv['onglet']]['1']['1']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";
$AD[$pv['onglet']]['1']['2']['cont'] = $tl_[$l]['o8l12'];	$AD[$pv['onglet']]['1']['2']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";

$pv['i'] = 2;
unset ( $A );

$Table = $LMObj->getDebugLog();
foreach ( $Table as $A ) {
	$AD[$pv['onglet']][$pv['i']]['1']['cont'] = $A['name'];
	$AD[$pv['onglet']][$pv['i']]['2']['cont'] = $StringFormatObj->print_r_html($A['data']);
	$AD[$pv['onglet']][$pv['i']]['2']['tc'] = 1;
	$pv['i']++;
}
$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = $pv['i']-1;
unset ( $A, $pv['i'] );

?>
