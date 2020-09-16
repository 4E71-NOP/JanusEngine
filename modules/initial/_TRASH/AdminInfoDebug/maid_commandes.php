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
//	Rapport sur les commande
// --------------------------------------------------------------------------------------------
//if ( !empty($tampon_commande_accumulateur) ) {
if ( isset($tampon_commande_accumulateur) ) {
	$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 0;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 2;	$ADC['onglet'][$pv['onglet']]['legende'] = 1;

	$tl_['eng']['o5l11']	= "N";			$tl_['fra']['o5l11']	= "N";
	$tl_['eng']['o5l12']	= "Command";	$tl_['fra']['o5l12']	= "Commande";
	$AD[$pv['onglet']]['1']['1']['cont'] = $tl_[$l]['o5l11'];	$AD[$pv['onglet']]['1']['1']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";	$AD[$pv['onglet']]['1']['1']['style'] = "text-align: center;";
	$AD[$pv['onglet']]['1']['2']['cont'] = $tl_[$l]['o5l12'];	$AD[$pv['onglet']]['1']['2']['class'] = $theme_tableau.$_REQUEST['bloc']."_tb3";

	$pv['i'] = 2;
	foreach ( $_REQUEST['accumulateur_commandes'] as $a => $b ) {
		$AD[$pv['onglet']][$pv['i']]['1']['cont'] = $a;													$AD[$pv['onglet']][$pv['i']]['1']['style'] = "text-align: center;";
		$AD[$pv['onglet']][$pv['i']]['2']['cont'] = $b;	$AD[$pv['onglet']][$pv['i']]['2']['tc'] = 1; 
		$pv['i']++;
	}
	$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = $pv['i'] - 1;
}
else { 
	$tl_['eng']['o5l11']	= "Status";												$tl_['fra']['o5l11']	= "Etat";
	$tl_['eng']['o5l12']	= "Command buffer is empty, nothing to display.";		$tl_['fra']['o5l12']	= "Bac de commande vide, rien a afficher.";
	$AD[$pv['onglet']]['1']['1']['cont'] = $tl_[$l]['o5l11'];
	$AD[$pv['onglet']]['1']['2']['cont'] = $tl_[$l]['o5l12'];
	$ADC['onglet'][$pv['onglet']]['nbr_ligne'] = 1;	$ADC['onglet'][$pv['onglet']]['nbr_cellule'] = 2;	$ADC['onglet']['5']['legende'] = 1;
}

?>
