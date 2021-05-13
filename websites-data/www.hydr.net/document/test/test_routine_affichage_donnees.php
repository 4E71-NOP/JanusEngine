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

// $ADC[onglet][$NumO][TableCaptionPos] = 1 top ; 2 left ; 3 right ; 4 bottom ; 5 left&right ; 6 top&bottom
//	$tab_infos['AffOnglet']			= 0;
//	$tab_infos['NbrOnglet']			= 1;
//	$tab_infos['tab_comportement']	= 1;
//	$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
//	$tab_infos['TypSurbrillance']	= 1; // 1:ligne, 2:cellule
//	$tab_infos['doc_height']		= $pres_[$mn]['dim_y_22'] - ${$theme_tableau}[$_REQUEST['bloc']]['tab_y'] - 32 ;
//	$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_internal_width'] -24 ;
//	$tab_infos['group']			= "inst1";
//	$tab_infos['cell_id']			= "tab";
//	$tab_infos['document']			= "doc";
//	$tab_infos['cell_1_txt']		= $tl_[$l]['onglet_1'];
//	$tab_infos['cell_2_txt']		= $tl_[$l]['onglet_2'];
//	$tab_infos['cell_3_txt']		= $tl_[$l]['onglet_3'];
//	$tab_infos['cell_4_txt']		= $tl_[$l]['onglet_4'];
//	$tab_infos['cell_5_txt']		= $tl_[$l]['onglet_5'];
//	$tab_infos['cell_6_txt']		= $tl_[$l]['onglet_6'];
//	include ("engine/affichage_donnees.php");
//	$pv['tabs']++;
//	$ADC['tabs'][$pv['tabs']]['NbrOfLines'] = 5;	$ADC['tabs'][$pv['tabs']]['NbrOfCells'] = 4;	$ADC['tabs'][$pv['tabs']]['TableCaptionPos'] = 1;
//	$lt = 1;

//	$pv['tabs'] = 1;
//	$lt = 1;

//	$AD[$pv['tabs']][$lt]['1']['cont'] = "";
//	$AD[$pv['tabs']][$lt]['2']['cont'] = "";
//	$AD[$pv['tabs']][$lt]['3']['cont'] = "";
//	$AD[$pv['tabs']][$lt]['4']['cont'] = "";
//	$AD[$pv['tabs']][$lt]['5']['cont'] = "";
//	$AD[$pv['tabs']][$lt]['6']['cont'] = "";
//	$AD[$pv['tabs']][$lt]['7']['cont'] = "";
//	$AD[$pv['tabs']][$lt]['8']['cont'] = "";
//	$AD[$pv['tabs']][$lt]['9']['cont'] = "";

//	$AD[$pv['tabs']][$lt]['9']['cc'] = "";							// Definit la légende en fonction de $ADC['tabs'][$NumO]['TableCaptionPos']
//	$AD[$pv['tabs']][$lt]['9']['tc'] = "";							// Taille texte
//	$AD[$pv['tabs']][$lt]['9']['sc'] = "";							// Style du fond de cellule choisi (numéroté pour clair/sombre etc)
//	$AD[$pv['tabs']][$lt]['9']['style'] = 'text_align: justify;';		// Insère les définitions de style demandées.
//	$AD[$pv['tabs']][$lt]['9']['class'] = 'theme_princ_B03_t2';		// Insère les définitions de class CSS demandées.
//	$AD[$pv['tabs']][$lt]['9']['colspan']	= x;						// = colspan
//	$AD[$pv['tabs']][$lt]['9']['rowspan'] = x;						// = rowspan
//	$AD[$pv['tabs']][$lt]['9']['desactive'] = 1;						// pas de traitement


$pv['tabs'] = 4;
$pv['ligne'] = 20;
$pv['Cell'] = 5;


$pv['F_TC'] = 0;
$pv['tabTC'] = array ( 3,4,5,6 );
$pv['tc'] = $pv['tabTC'][$pv['F_TC']];

$pv['F_S'] = 0;
$pv['tabS'] = array (
"font-weight:bold;",
"text-align:left;",
"letter-spacing:5px",
"text-align:right;",
"font-weight:bold;",
);
$pv['S'] = $pv['tabS'][$pv['F_S']];

for ( $pv['i'] = 1 ; $pv['i'] <= $pv['tabs'] ; $pv['i']++ ) {

	$ADC['tabs'][$pv['i']]['NbrOfLines'] = $pv['ligne'];
	$pv['tc'] = $pv['tabTC'][$pv['F_TC']];

	for ( $pv['j'] = 1 ; $pv['j'] <= $pv['ligne'] ; $pv['j']++ ) {
		$ADC['tabs'][$pv['i']]['NbrOfCells'] = $pv['Cell'];
		$pv['F_S'] = 0;
		for ( $pv['k'] = 1 ; $pv['k'] <= $pv['Cell']  ; $pv['k']++ ) {
			$pv['S'] = $pv['tabS'][$pv['F_S']];
			$AD[$pv['i']][$pv['j']][$pv['k']]['cont'] = "test";
			$AD[$pv['i']][$pv['j']][$pv['k']]['tc'] = $pv['tc'];
			$AD[$pv['i']][$pv['j']][$pv['k']]['style'] = $pv['S'];
			$pv['F_S']++;
		}
	}
	$pv['F_TC']++;

}

$AD['1']['4']['1']['desactive'] = 1;

$AD['1']['5']['1']['sc'] = 0;		$AD['1']['5']['2']['sc'] = 4;		$AD['1']['5']['3']['sc'] = 8;		
$AD['1']['6']['1']['sc'] = 1;		$AD['1']['6']['2']['sc'] = 5;		$AD['1']['6']['3']['sc'] = 9;		
$AD['1']['7']['1']['sc'] = 2;		$AD['1']['7']['2']['sc'] = 6;		$AD['1']['7']['3']['sc'] = 10;	
$AD['1']['8']['1']['sc'] = 3;		$AD['1']['8']['2']['sc'] = 7;		$AD['1']['8']['3']['sc'] = 11;	

$AD['1']['9']['1']['colspan'] = 3;
$AD['1']['10']['1']['rowspan'] = 3;

/*
$ADC['tabs']['1']['theadD'] = 1;
$ADC['tabs']['1']['theadF'] = 1;
$ADC['tabs']['1']['tbodyD'] = 2;
$ADC['tabs']['1']['tbodyF'] = 20;
$ADC['tabs']['1']['tfootD'] = 0;
$ADC['tabs']['1']['tfootF'] = 0;
*/
$ADC['tabs']['1']['TableCaptionPos'] = 1;
$ADC['tabs']['2']['TableCaptionPos'] = 2;
$ADC['tabs']['3']['TableCaptionPos'] = 3;
$ADC['tabs']['4']['TableCaptionPos'] = 4;

$tab_infos['AffOnglet']			= 1;
$tab_infos['NbrOnglet']			= 4;
$tab_infos['tab_comportement']	= 1;
$tab_infos['TypSurbrillance']	= 1; // 1:ligne, 2:cellule
$tab_infos['mode_rendu']		= 0;	// 0 echo 1 dans une variable
$tab_infos['doc_height']		= 256;
$tab_infos['doc_width']			= ${$theme_tableau}['theme_module_internal_width'] -24 ;
$tab_infos['group']			= "tst";
$tab_infos['cell_id']			= "tab";
$tab_infos['document']			= "doc";
$tab_infos['cell_1_txt']		= 1;
$tab_infos['cell_2_txt']		= 2;
$tab_infos['cell_3_txt']		= 3;
$tab_infos['cell_4_txt']		= 4;
$tab_infos['cell_5_txt']		= 5;
$tab_infos['cell_6_txt']		= 6;
$tab_infos['cell_7_txt']		= 7;
$tab_infos['cell_8_txt']		= 8;
include ("engine/affichage_donnees.php");


?>
