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
function module_deco_60_elysion ( $TS, $TP , $TM, $Mode ) {
	global $statistiques, $admin_control_, $affiche_module_mode, $module_z_index, $JavaScriptTabInfoModule, $JavaScriptInitCommandes;
	global ${$TS} ; $S = &${$TS} ;
	global ${$TP} ; $P = &${$TP} ;
	global ${$TM} ; $M = &${$TM} ;

	$mn = &$M['module_nom'];
	$module_deco_stat = $mn . "_deco_a";
	$P[$mn]['NomModule'] = $mn;

	switch ($affiche_module_mode) {
	case "bypass":
		$P[$mn]['px'] = $admin_control_['px'];
		$P[$mn]['py'] = $admin_control_['py'];
	break;
	case "normal":
	break;
	case "menu":
		$P[$mn]['px'] = 0;
		$P[$mn]['py'] = 0;
	break;
	}
	if ( $P[$mn]['pres_module_zindex'] != 0 ) { $module_z_index['compteur'] = $P[$mn]['pres_module_zindex']; }
// --------------------------------------------------------------------------------------------
// x1 x2
// x3 x4
	$B = &$S[$_REQUEST['blocG']];

	$P[$mn]['pos_x1_ex22'] = $P[$mn]['px'] + max ( $B['deco_ex11_x'], $B['deco_ex21_x'], $B['deco_ex31_x'], $B['deco_ex41_x'], $B['deco_ex51_x']);
	$P[$mn]['pos_y1_ex22'] = $P[$mn]['py'] + max ( $B['deco_ex11_y'], $B['deco_ex12_y'], $B['deco_ex13_y'], $B['deco_ex14_y'], $B['deco_ex15_y']);
	$P[$mn]['pos_x2_ex22'] = $P[$mn]['px'] + $P[$mn]['dx'] - max ( $B['deco_ex15_x'], $B['deco_ex25_x'], $B['deco_ex35_x'], $B['deco_ex45_x'], $B['deco_ex55_x'] );
	$P[$mn]['pos_y2_ex22'] = &$P[$mn]['pos_y1_ex22'];
	$P[$mn]['pos_x3_ex22'] = &$P[$mn]['pos_x1_ex22'];
	$P[$mn]['pos_y3_ex22'] = $P[$mn]['py'] + $P[$mn]['dy'] - max ( $B['deco_ex51_y'], $B['deco_ex52_y'], $B['deco_ex53_y'], $B['deco_ex54_y'], $B['deco_ex55_y'] );
	$P[$mn]['pos_x4_ex22'] = &$P[$mn]['pos_x2_ex22'];
	$P[$mn]['pos_y4_ex22'] = &$P[$mn]['pos_y3_ex22'];

	$P[$mn]['dim_x_ex22'] = $P[$mn]['pos_x2_ex22'] - $P[$mn]['pos_x1_ex22'];
	$P[$mn]['dim_y_ex22'] = $P[$mn]['pos_y3_ex22'] - $P[$mn]['pos_y1_ex22'];

// Correction des valeurs en fonction des gabarits des éléments de la décoration.
	$CV = ($P[$mn]['dim_x_ex22'] - $B['deco_ex12_x'] - $B['deco_ex14_x']);	if ( $CV <= 0 ) { $CV = abs($CV) + 8; $P[$mn]['dim_x_ex22'] += $CV; $P[$mn]['dx'] += $CV; $P[$mn]['pos_x2_ex22'] += $CV; $P[$mn]['pos_x4_ex22'] = &$P[$mn]['pos_x2_ex22']; }
	$CV = ($P[$mn]['dim_x_ex22'] - $B['deco_ex52_x'] - $B['deco_ex54_x']);	if ( $CV <= 0 ) { $CV = abs($CV) + 8; $P[$mn]['dim_x_ex22'] += $CV; $P[$mn]['dx'] += $CV; $P[$mn]['pos_x2_ex22'] += $CV; $P[$mn]['pos_x4_ex22'] = &$P[$mn]['pos_x2_ex22']; }
	$CV = ($P[$mn]['dim_y_ex22'] - $B['deco_ex21_y'] - $B['deco_ex41_y']);	if ( $CV <= 0 ) { $CV = abs($CV) + 8; $P[$mn]['dim_y_ex22'] += $CV; $P[$mn]['dy'] += $CV; $P[$mn]['pos_y3_ex22'] += $CV; $P[$mn]['pos_y4_ex22'] = &$P[$mn]['pos_y3_ex22']; }
	$CV = ($P[$mn]['dim_y_ex22'] - $B['deco_ex25_y'] - $B['deco_ex45_y']);	if ( $CV <= 0 ) { $CV = abs($CV) + 8; $P[$mn]['dim_y_ex22'] += $CV; $P[$mn]['dy'] += $CV; $P[$mn]['pos_y3_ex22'] += $CV; $P[$mn]['pos_y4_ex22'] = &$P[$mn]['pos_y3_ex22']; }

	$P[$mn]['dim_x_ex13'] = $P[$mn]['dim_x_ex22'] - $B['deco_ex12_x'] - $B['deco_ex14_x'] ;
	$P[$mn]['dim_x_ex53'] = $P[$mn]['dim_x_ex22'] - $B['deco_ex52_x'] - $B['deco_ex54_x'] ;
	$P[$mn]['dim_y_ex31'] = $P[$mn]['dim_y_ex22'] - $B['deco_ex21_y'] - $B['deco_ex41_y'] ;
	$P[$mn]['dim_y_ex35'] = $P[$mn]['dim_y_ex22'] - $B['deco_ex25_y'] - $B['deco_ex45_y'] ;

// --------------------------------------------------------------------------------------------
	$P[$mn]['pos_x_ex11'] = $P[$mn]['pos_x1_ex22'] - $B['deco_ex11_x'];	$P[$mn]['pos_y_ex11'] = $P[$mn]['pos_y1_ex22'] - $B['deco_ex11_y'];
	$P[$mn]['pos_x_ex12'] = &$P[$mn]['pos_x1_ex22']; 						$P[$mn]['pos_y_ex12'] = $P[$mn]['pos_y1_ex22'] - $B['deco_ex12_y'];
	$P[$mn]['pos_x_ex13'] = $P[$mn]['pos_x1_ex22'] + $B['deco_ex12_x'];	$P[$mn]['pos_y_ex13'] = $P[$mn]['pos_y1_ex22'] - $B['deco_ex13_y'];
	$P[$mn]['pos_x_ex14'] = $P[$mn]['pos_x2_ex22'] - $B['deco_ex14_x'];	$P[$mn]['pos_y_ex14'] = $P[$mn]['pos_y1_ex22'] - $B['deco_ex14_y'];
	$P[$mn]['pos_x_ex15'] = &$P[$mn]['pos_x2_ex22'];						$P[$mn]['pos_y_ex15'] = $P[$mn]['pos_y1_ex22'] - $B['deco_ex15_y'];

	$P[$mn]['pos_x_ex21'] = $P[$mn]['pos_x1_ex22'] - $B['deco_ex21_x'];	$P[$mn]['pos_y_ex21'] = &$P[$mn]['pos_y1_ex22'];
	$P[$mn]['pos_x_ex22'] = &$P[$mn]['pos_x1_ex22'];						$P[$mn]['pos_y_ex22'] = &$P[$mn]['pos_y1_ex22'];
	$P[$mn]['pos_x_ex25'] = &$P[$mn]['pos_x2_ex22']; 						$P[$mn]['pos_y_ex25'] = &$P[$mn]['pos_y1_ex22'];

	$P[$mn]['pos_x_ex31'] = $P[$mn]['pos_x1_ex22'] - $B['deco_ex31_x'];	$P[$mn]['pos_y_ex31'] = $P[$mn]['pos_y1_ex22'] + $B['deco_ex21_y'];
	$P[$mn]['pos_x_ex35'] = &$P[$mn]['pos_x2_ex22'];						$P[$mn]['pos_y_ex35'] = $P[$mn]['pos_y1_ex22'] + $B['deco_ex25_y'];

	$P[$mn]['pos_x_ex41'] = $P[$mn]['pos_x1_ex22'] - $B['deco_ex41_x'];	$P[$mn]['pos_y_ex41'] = $P[$mn]['pos_y3_ex22'] - $B['deco_ex41_y'];
	$P[$mn]['pos_x_ex45'] = &$P[$mn]['pos_x2_ex22']; 						$P[$mn]['pos_y_ex45'] = $P[$mn]['pos_y3_ex22'] - $B['deco_ex45_y'];

	$P[$mn]['pos_x_ex51'] = $P[$mn]['pos_x1_ex22'] - $B['deco_ex51_x'];	$P[$mn]['pos_y_ex51'] = &$P[$mn]['pos_y3_ex22'];
	$P[$mn]['pos_x_ex52'] = &$P[$mn]['pos_x1_ex22']; 						$P[$mn]['pos_y_ex52'] = &$P[$mn]['pos_y3_ex22'];
	$P[$mn]['pos_x_ex53'] = $P[$mn]['pos_x1_ex22'] + $B['deco_ex52_x'];	$P[$mn]['pos_y_ex53'] = &$P[$mn]['pos_y3_ex22'];
	$P[$mn]['pos_x_ex54'] = $P[$mn]['pos_x2_ex22'] - $B['deco_ex54_x'];	$P[$mn]['pos_y_ex54'] = &$P[$mn]['pos_y3_ex22'];
	$P[$mn]['pos_x_ex55'] = &$P[$mn]['pos_x2_ex22'];						$P[$mn]['pos_y_ex55'] = &$P[$mn]['pos_y3_ex22'];

// --------------------------------------------------------------------------------------------
	$P[$mn]['pos_x_in11'] = &$P[$mn]['pos_x1_ex22'];											$P[$mn]['pos_y_in11'] = &$P[$mn]['pos_y1_ex22'];
	$P[$mn]['pos_x_in12'] = $P[$mn]['pos_x1_ex22'] + $B['deco_in11_x']; 						$P[$mn]['pos_y_in12'] = &$P[$mn]['pos_y1_ex22'];
	$P[$mn]['pos_x_in13'] = $P[$mn]['pos_x1_ex22'] + $B['deco_in11_x']+ $B['deco_in12_x'];	$P[$mn]['pos_y_in13'] = &$P[$mn]['pos_y1_ex22'];
	$P[$mn]['pos_x_in14'] = $P[$mn]['pos_x2_ex22'] - $B['deco_in14_x']- $B['deco_in15_x'];	$P[$mn]['pos_y_in14'] = &$P[$mn]['pos_y1_ex22'];
	$P[$mn]['pos_x_in15'] = $P[$mn]['pos_x2_ex22'] - $B['deco_in15_x'];						$P[$mn]['pos_y_in15'] = &$P[$mn]['pos_y1_ex22'];

	$P[$mn]['pos_x_in21'] = &$P[$mn]['pos_x1_ex22'];						$P[$mn]['pos_y_in21'] = $P[$mn]['pos_y1_ex22'] + $B['deco_in11_y'];
	$P[$mn]['pos_x_in25'] = $P[$mn]['pos_x2_ex22'] - $B['deco_in25_x']; 	$P[$mn]['pos_y_in25'] = $P[$mn]['pos_y1_ex22'] + $B['deco_in15_y'];

	$P[$mn]['pos_x_in31'] = &$P[$mn]['pos_x1_ex22'];						$P[$mn]['pos_y_in31'] = $P[$mn]['pos_y1_ex22'] + $B['deco_in11_y'] + $B['deco_in21_y'];
	$P[$mn]['pos_x_in35'] = $P[$mn]['pos_x2_ex22'] - $B['deco_in35_x'];	$P[$mn]['pos_y_in35'] = $P[$mn]['pos_y1_ex22'] + $B['deco_in15_y'] + $B['deco_in25_y'];

	$P[$mn]['pos_x_in41'] = &$P[$mn]['pos_x1_ex22'];						$P[$mn]['pos_y_in41'] = $P[$mn]['pos_y3_ex22'] - $B['deco_in41_y'] - $B['deco_in51_y'];
	$P[$mn]['pos_x_in45'] = $P[$mn]['pos_x2_ex22'] - $B['deco_in45_x']; 	$P[$mn]['pos_y_in45'] = $P[$mn]['pos_y3_ex22'] - $B['deco_in45_y'] - $B['deco_in55_y'];

	$P[$mn]['pos_x_in51'] = &$P[$mn]['pos_x1_ex22'];						$P[$mn]['pos_y_in51'] = $P[$mn]['pos_y3_ex22'] - $B['deco_in51_y'];
	$P[$mn]['pos_x_in52'] = $P[$mn]['pos_x1_ex22'] + $B['deco_in51_x'];	$P[$mn]['pos_y_in52'] = $P[$mn]['pos_y3_ex22'] - $B['deco_in52_y'];
	$P[$mn]['pos_x_in53'] = $P[$mn]['pos_x1_ex22'] + $B['deco_in52_x'];	$P[$mn]['pos_y_in53'] = $P[$mn]['pos_y3_ex22'] - $B['deco_in53_y'];
	$P[$mn]['pos_x_in54'] = $P[$mn]['pos_x2_ex22'] - $B['deco_in54_x'];	$P[$mn]['pos_y_in54'] = $P[$mn]['pos_y3_ex22'] - $B['deco_in54_y'];
	$P[$mn]['pos_x_in55'] = $P[$mn]['pos_x2_ex22'] - $B['deco_in55_x'];	$P[$mn]['pos_y_in55'] = $P[$mn]['pos_y3_ex22'] - $B['deco_in55_y'];

// --------------------------------------------------------------------------------------------

	$P[$mn]['dim_x_in13'] = $P[$mn]['dim_x_ex22'] - $B['deco_in11_x'] - $B['deco_in12_x'] - $B['deco_in14_x'] - $B['deco_in15_x'];
	$P[$mn]['dim_x_in53'] = $P[$mn]['dim_x_ex22'] - $B['deco_in51_x'] - $B['deco_in52_x'] - $B['deco_in54_x'] - $B['deco_in55_x'];
	$P[$mn]['dim_y_in31'] = $P[$mn]['dim_y_ex22'] - $B['deco_in11_y'] - $B['deco_in21_y'] - $B['deco_in41_y'] - $B['deco_in51_y'];
	$P[$mn]['dim_y_in35'] = $P[$mn]['dim_y_ex22'] - $B['deco_in15_y'] - $B['deco_in25_y'] - $B['deco_in45_y'] - $B['deco_in55_y'];

// --------------------------------------------------------------------------------------------

	$S['theme_module_largeur_interne'] = $P[$mn]['dim_x_ex22'] - 16;
	$S['theme_module_hauteur_interne'] = $P[$mn]['dim_y_ex22'] - 16;

	$pv['listeDiv'] = array ( "ex11", "ex12", "ex13", "ex14", "ex15", "ex21", "ex22", "ex23", "ex25", "ex31", "ex35", "ex41", "ex45", "ex51", "ex52", "ex53", "ex54", "ex55", "in11", "in12", "in13", "in14", "in15", "in21", "in25", "in31", "in35", "in41", "in45", "in51", "in52", "in53", "in54", "in55");
	foreach ( $pv['listeDiv'] as $A ) { $_REQUEST['div_id'][$A] = "id='" . $mn . "_".$A."' "; }

	$Rendu = "
	<!-- _______________________________________ Decoration du module ".$mn." (debut) _______________________________________ -->\r
	";
	if ( isset($module_['module_conteneur_nom']) && strlen($module_['module_conteneur_nom']) > 0 ) { $Rendu .= "<div id='".$module_['module_conteneur_nom']."' style='visibility: hidden; position:absolute; top: 0px; left: 0px;'>"; } 
	$Rendu .= "
	<div ".$_REQUEST['div_id']['ex11']." class='".$TS . $_REQUEST['bloc']."_ex11' style='left: ".$P[$mn]['pos_x_ex11']."px;	top: ".$P[$mn]['pos_y_ex11']."px; z-index: ".$module_z_index['compteur']."; width:".$B['deco_ex11_x']."px;		height:".$B['deco_ex11_y']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex12']." class='".$TS . $_REQUEST['bloc']."_ex12' style='left: ".$P[$mn]['pos_x_ex12']."px;	top: ".$P[$mn]['pos_y_ex12']."px; z-index: ".$module_z_index['compteur']."; width:".$B['deco_ex12_x']."px;		height:".$B['deco_ex12_y']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex13']." class='".$TS . $_REQUEST['bloc']."_ex13' style='left: ".$P[$mn]['pos_x_ex13']."px;	top: ".$P[$mn]['pos_y_ex13']."px; z-index: ".$module_z_index['compteur']."; width:".$P[$mn]['dim_x_ex13']."px;	height:".$B['deco_ex13_y']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex14']." class='".$TS . $_REQUEST['bloc']."_ex14' style='left: ".$P[$mn]['pos_x_ex14']."px;	top: ".$P[$mn]['pos_y_ex14']."px; z-index: ".$module_z_index['compteur']."; width:".$B['deco_ex14_x']."px;		height:".$B['deco_ex14_y']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex15']." class='".$TS . $_REQUEST['bloc']."_ex15' style='left: ".$P[$mn]['pos_x_ex15']."px;	top: ".$P[$mn]['pos_y_ex15']."px; z-index: ".$module_z_index['compteur']."; width:".$B['deco_ex15_x']."px;		height:".$B['deco_ex15_y']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex21']." class='".$TS . $_REQUEST['bloc']."_ex21' style='left: ".$P[$mn]['pos_x_ex21']."px;	top: ".$P[$mn]['pos_y_ex21']."px; z-index: ".$module_z_index['compteur']."; width:".$B['deco_ex21_x']."px;		height:".$B['deco_ex21_y']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex25']." class='".$TS . $_REQUEST['bloc']."_ex25' style='left: ".$P[$mn]['pos_x_ex25']."px;	top: ".$P[$mn]['pos_y_ex25']."px; z-index: ".$module_z_index['compteur']."; width:".$B['deco_ex25_x']."px;		height:".$B['deco_ex25_y']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex31']." class='".$TS . $_REQUEST['bloc']."_ex31' style='left: ".$P[$mn]['pos_x_ex31']."px;	top: ".$P[$mn]['pos_y_ex31']."px; z-index: ".$module_z_index['compteur']."; width:".$B['deco_ex31_x']."px;		height:".$P[$mn]['dim_y_ex31']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex35']." class='".$TS . $_REQUEST['bloc']."_ex35' style='left: ".$P[$mn]['pos_x_ex35']."px;	top: ".$P[$mn]['pos_y_ex35']."px; z-index: ".$module_z_index['compteur']."; width:".$B['deco_ex35_x']."px;		height:".$P[$mn]['dim_y_ex35']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex41']." class='".$TS . $_REQUEST['bloc']."_ex41' style='left: ".$P[$mn]['pos_x_ex41']."px;	top: ".$P[$mn]['pos_y_ex41']."px; z-index: ".$module_z_index['compteur']."; width:".$B['deco_ex41_x']."px;		height:".$B['deco_ex41_y']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex45']." class='".$TS . $_REQUEST['bloc']."_ex45' style='left: ".$P[$mn]['pos_x_ex45']."px;	top: ".$P[$mn]['pos_y_ex45']."px; z-index: ".$module_z_index['compteur']."; width:".$B['deco_ex45_x']."px;		height:".$B['deco_ex45_y']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex51']." class='".$TS . $_REQUEST['bloc']."_ex51' style='left: ".$P[$mn]['pos_x_ex51']."px;	top: ".$P[$mn]['pos_y_ex51']."px; z-index: ".$module_z_index['compteur']."; width:".$B['deco_ex51_x']."px;		height:".$B['deco_ex51_y']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex52']." class='".$TS . $_REQUEST['bloc']."_ex52' style='left: ".$P[$mn]['pos_x_ex52']."px;	top: ".$P[$mn]['pos_y_ex52']."px; z-index: ".$module_z_index['compteur']."; width:".$B['deco_ex52_x']."px;		height:".$B['deco_ex52_y']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex53']." class='".$TS . $_REQUEST['bloc']."_ex53' style='left: ".$P[$mn]['pos_x_ex53']."px;	top: ".$P[$mn]['pos_y_ex53']."px; z-index: ".$module_z_index['compteur']."; width:".$P[$mn]['dim_x_ex53']."px;	height:".$B['deco_ex53_y']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex54']." class='".$TS . $_REQUEST['bloc']."_ex54' style='left: ".$P[$mn]['pos_x_ex54']."px;	top: ".$P[$mn]['pos_y_ex54']."px; z-index: ".$module_z_index['compteur']."; width:".$B['deco_ex54_x']."px;		height:".$B['deco_ex54_y']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex55']." class='".$TS . $_REQUEST['bloc']."_ex55' style='left: ".$P[$mn]['pos_x_ex55']."px;	top: ".$P[$mn]['pos_y_ex55']."px; z-index: ".$module_z_index['compteur']."; width:".$B['deco_ex55_x']."px;		height:".$B['deco_ex55_y']."px;'></div>\r";

	if ( $B['deco_in11_e'] == 1 ) { $Rendu .= "<div ".$_REQUEST['div_id']['in11']." class='".$TS . $_REQUEST['bloc']."_in11' style='left: ".$P[$mn]['pos_x_in11']."px;	top: ".$P[$mn]['pos_y_in11']."px; width:".$P[$mn]['deco_in11_x']."px;	height:".$B['deco_in11_y']."px;		z-index: ".($module_z_index['compteur']+1).";'></div>\r"; }
	if ( $B['deco_in12_e'] == 1 ) { $Rendu .= "<div ".$_REQUEST['div_id']['in12']." class='".$TS . $_REQUEST['bloc']."_in12' style='left: ".$P[$mn]['pos_x_in12']."px;	top: ".$P[$mn]['pos_y_in12']."px; width:".$P[$mn]['deco_in12_x']."px;	height:".$B['deco_in12_y']."px;		z-index: ".($module_z_index['compteur']+1).";'></div>\r"; }
	if ( $B['deco_in13_e'] == 1 ) { $Rendu .= "<div ".$_REQUEST['div_id']['in13']." class='".$TS . $_REQUEST['bloc']."_in13' style='left: ".$P[$mn]['pos_x_in13']."px;	top: ".$P[$mn]['pos_y_in13']."px; width:".$P[$mn]['dim_x_in13']."px;	height:".$B['deco_in13_y']."px;		z-index: ".($module_z_index['compteur']+1).";'></div>\r"; }
	if ( $B['deco_in14_e'] == 1 ) { $Rendu .= "<div ".$_REQUEST['div_id']['in14']." class='".$TS . $_REQUEST['bloc']."_in14' style='left: ".$P[$mn]['pos_x_in14']."px;	top: ".$P[$mn]['pos_y_in14']."px; width:".$P[$mn]['deco_in14_x']."px;	height:".$B['deco_in14_y']."px;		z-index: ".($module_z_index['compteur']+1).";'></div>\r"; }
	if ( $B['deco_in15_e'] == 1 ) { $Rendu .= "<div ".$_REQUEST['div_id']['in15']." class='".$TS . $_REQUEST['bloc']."_in15' style='left: ".$P[$mn]['pos_x_in15']."px;	top: ".$P[$mn]['pos_y_in15']."px; width:".$P[$mn]['deco_in15_x']."px;	height:".$B['deco_in15_y']."px;		z-index: ".($module_z_index['compteur']+1).";'></div>\r"; }
	if ( $B['deco_in21_e'] == 1 ) { $Rendu .= "<div ".$_REQUEST['div_id']['in21']." class='".$TS . $_REQUEST['bloc']."_in21' style='left: ".$P[$mn]['pos_x_in21']."px;	top: ".$P[$mn]['pos_y_in21']."px; width:".$P[$mn]['deco_in21_x']."px;	height:".$B['deco_in21_y']."px;		z-index: ".($module_z_index['compteur']+1).";'></div>\r"; }
	if ( $B['deco_in25_e'] == 1 ) { $Rendu .= "<div ".$_REQUEST['div_id']['in25']." class='".$TS . $_REQUEST['bloc']."_in25' style='left: ".$P[$mn]['pos_x_in25']."px;	top: ".$P[$mn]['pos_y_in25']."px; width:".$P[$mn]['deco_in25_x']."px;	height:".$B['deco_in25_y']."px;		z-index: ".($module_z_index['compteur']+1).";'></div>\r"; }
	if ( $B['deco_in31_e'] == 1 ) { $Rendu .= "<div ".$_REQUEST['div_id']['in31']." class='".$TS . $_REQUEST['bloc']."_in31' style='left: ".$P[$mn]['pos_x_in31']."px;	top: ".$P[$mn]['pos_y_in31']."px; width:".$P[$mn]['deco_in31_x']."px;	height:".$P[$mn]['dim_y_in31']."px; z-index: ".($module_z_index['compteur']+1).";'></div>\r"; }
	if ( $B['deco_in35_e'] == 1 ) { $Rendu .= "<div ".$_REQUEST['div_id']['in35']." class='".$TS . $_REQUEST['bloc']."_in35' style='left: ".$P[$mn]['pos_x_in35']."px;	top: ".$P[$mn]['pos_y_in35']."px; width:".$P[$mn]['deco_in35_x']."px;	height:".$P[$mn]['dim_y_in35']."px; z-index: ".($module_z_index['compteur']+1).";'></div>\r"; }
	if ( $B['deco_in41_e'] == 1 ) { $Rendu .= "<div ".$_REQUEST['div_id']['in41']." class='".$TS . $_REQUEST['bloc']."_in41' style='left: ".$P[$mn]['pos_x_in41']."px;	top: ".$P[$mn]['pos_y_in41']."px; width:".$P[$mn]['deco_in41_x']."px;	height:".$B['deco_in41_y']."px;		z-index: ".($module_z_index['compteur']+1).";'></div>\r"; }	
	if ( $B['deco_in45_e'] == 1 ) { $Rendu .= "<div ".$_REQUEST['div_id']['in45']." class='".$TS . $_REQUEST['bloc']."_in45' style='left: ".$P[$mn]['pos_x_in45']."px;	top: ".$P[$mn]['pos_y_in45']."px; width:".$P[$mn]['deco_in45_x']."px;	height:".$B['deco_in45_y']."px;		z-index: ".($module_z_index['compteur']+1).";'></div>\r"; }
	if ( $B['deco_in51_e'] == 1 ) { $Rendu .= "<div ".$_REQUEST['div_id']['in51']." class='".$TS . $_REQUEST['bloc']."_in51' style='left: ".$P[$mn]['pos_x_in51']."px;	top: ".$P[$mn]['pos_y_in51']."px; width:".$P[$mn]['deco_in51_x']."px;	height:".$B['deco_in51_y']."px;		z-index: ".($module_z_index['compteur']+1).";'></div>\r"; }
	if ( $B['deco_in52_e'] == 1 ) { $Rendu .= "<div ".$_REQUEST['div_id']['in52']." class='".$TS . $_REQUEST['bloc']."_in52' style='left: ".$P[$mn]['pos_x_in52']."px;	top: ".$P[$mn]['pos_y_in52']."px; width:".$P[$mn]['deco_in52_x']."px;	height:".$B['deco_in52_y']."px;		z-index: ".($module_z_index['compteur']+1).";'></div>\r"; }
	if ( $B['deco_in53_e'] == 1 ) { $Rendu .= "<div ".$_REQUEST['div_id']['in53']." class='".$TS . $_REQUEST['bloc']."_in53' style='left: ".$P[$mn]['pos_x_in53']."px;	top: ".$P[$mn]['pos_y_in53']."px; width:".$P[$mn]['dim_x_in53']."px;	height:".$B['deco_in53_y']."px;		z-index: ".($module_z_index['compteur']+1).";'></div>\r"; }
	if ( $B['deco_in54_e'] == 1 ) { $Rendu .= "<div ".$_REQUEST['div_id']['in54']." class='".$TS . $_REQUEST['bloc']."_in54' style='left: ".$P[$mn]['pos_x_in54']."px;	top: ".$P[$mn]['pos_y_in54']."px; width:".$P[$mn]['deco_in54_x']."px;	height:".$B['deco_in54_y']."px;		z-index: ".($module_z_index['compteur']+1).";'></div>\r"; }
	if ( $B['deco_in55_e'] == 1 ) { $Rendu .= "<div ".$_REQUEST['div_id']['in55']." class='".$TS . $_REQUEST['bloc']."_in55' style='left: ".$P[$mn]['pos_x_in55']."px;	top: ".$P[$mn]['pos_y_in55']."px; width:".$P[$mn]['deco_in55_x']."px;	height:".$B['deco_in55_y']."px;		z-index: ".($module_z_index['compteur']+1).";'></div>\r"; }
	$Rendu .= "
	<div ".$_REQUEST['div_id']['ex22']." class='".$TS.$_REQUEST['bloc']."_ex22 ".$TS.$_REQUEST['bloc']."_t".$M['module_deco_txt_defaut']." ".$TS.$_REQUEST['bloc']."_t_couleur_de_base' style='left: ".$P[$mn]['pos_x_ex22']."px;	top: ".$P[$mn]['pos_y_ex22']."px; width: ".$P[$mn]['dim_x_ex22']."px ; height: ".$P[$mn]['dim_y_ex22']."px; overflow: auto; z-index: ".$module_z_index['compteur'].";'>\r
	<!-- _______________________________________ Decoration du module ".$mn." (fin)_______________________________________ -->\r 
	";

	vide_module_div_ids ();

	$JavaScriptInitCommandes[] = "JavaScriptTabInfoModule ( '".$mn."' , 60 );";
//	JavaScriptTabInfoModule ( $mn , "60" );

	switch ( $Mode ) {
	case 0 :	echo $Rendu;	break;
	case 1 :	return $Rendu;	break;
	}
}
?>
