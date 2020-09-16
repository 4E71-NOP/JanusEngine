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

// --------------------------------------------------------------------------------------------
//	Affichage des variable de la page
// --------------------------------------------------------------------------------------------

function affiche_array_table ( &$array , $onglet ) {
	global $AD, $ADC; $l;

	$tl_['eng']['oxl11'] = "Name";	$tl_['fra']['oxl11'] = "Nom";
	$tl_['eng']['oxl12'] = "Value";	$tl_['fra']['oxl12'] = "Valeur";
	$AD[$onglet]['1']['1']['cont'] = $tl_[$l]['oxl11'];
	$AD[$onglet]['1']['2']['cont'] = $tl_[$l]['oxl12'];
	$AD[$onglet]['1']['2']['tc'] = 1;

	$i = 2;
	foreach ( $array as $key => $value ) {
		if ( is_bool($value) || is_int($value) || is_float($value) ) { $value = "= " . $value; }
		if ( is_string($value) ) { $value = string_format_html($value); }
		if ( is_resource($value) ) { $value = "Type = Ressource"; }
		if ( is_object($value) ) { $value = "Type = Objet"; }
		if ( $key != "GLOBALS" && is_array($value) ) { $value = print_r_html($value); } 

		$AD[$onglet][$i]['1']['cont'] = $key;		$AD[$onglet][$i]['1']['tc'] = 2;  
		$AD[$onglet][$i]['2']['cont'] = $value;		$AD[$onglet][$i]['2']['tc'] = 1;
		$i++;
	}
	$ADC['onglet'][$onglet]['nbr_ligne'] = $i - 1;
}
?>
