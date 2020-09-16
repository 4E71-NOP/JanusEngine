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
function module_deco_40_elegance ( $TS, $TP , $TM, $Mode ) {
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
	$B = &$S[$_REQUEST['blocG']];

	$P[$mn]['pos_x1_ex22'] = $P[$mn]['px'] + max ( $B['deco_ex11_x'] , $B['deco_ex21_x'] , $B['deco_ex31_x'] );
	$P[$mn]['pos_y1_ex22'] = $P[$mn]['py'] + max ( $B['deco_ex11_y'] , $B['deco_ex12_y'] , $B['deco_ex13_y'] );
	$P[$mn]['pos_x2_ex22'] = $P[$mn]['px'] + $P[$mn]['dx'] - max ( $B['deco_ex13_x'] , $B['deco_ex23_x'] , $B['deco_ex33_x'] );
	$P[$mn]['pos_y2_ex22'] = &$P[$mn]['pos_y1_ex22'];
	$P[$mn]['pos_x3_ex22'] = &$P[$mn]['pos_x1_ex22'];
	$P[$mn]['pos_y3_ex22'] = $P[$mn]['py'] + $P[$mn]['dy'] - max ( $B['deco_ex31_y'] , $B['deco_ex32_y'] , $B['deco_ex33_y'] );
	$P[$mn]['pos_x4_ex22'] = &$P[$mn]['pos_x2_ex22'];
	$P[$mn]['pos_y4_ex22'] = &$P[$mn]['pos_y3_ex22'];

	$P[$mn]['dim_x_ex22'] = $P[$mn]['pos_x2_ex22'] - $P[$mn]['pos_x1_ex22'];
	$P[$mn]['dim_y_ex22'] = $P[$mn]['pos_y3_ex22'] - $P[$mn]['pos_y1_ex22'];

// Correction des valeurs en fonction des gabarits des elements de la décoration.
	$CV = ($P[$mn]['dim_x_ex22'] );	if ( $CV <= 0 ) { $CV = abs($CV) + 8; $P[$mn]['dim_x_ex22'] += $CV; $P[$mn]['dx'] += $CV; $P[$mn]['pos_x2_ex22'] += $CV; $P[$mn]['pos_x4_ex22'] = &$P[$mn]['pos_x2_ex22']; }
	$CV = ($P[$mn]['dim_x_ex22'] );	if ( $CV <= 0 ) { $CV = abs($CV) + 8; $P[$mn]['dim_x_ex22'] += $CV; $P[$mn]['dx'] += $CV; $P[$mn]['pos_x2_ex22'] += $CV; $P[$mn]['pos_x4_ex22'] = &$P[$mn]['pos_x2_ex22']; }
	$CV = ($P[$mn]['dim_y_ex22'] );	if ( $CV <= 0 ) { $CV = abs($CV) + 8; $P[$mn]['dim_y_ex22'] += $CV; $P[$mn]['dy'] += $CV; $P[$mn]['pos_y3_ex22'] += $CV; $P[$mn]['pos_y4_ex22'] = &$P[$mn]['pos_y3_ex22']; }
	$CV = ($P[$mn]['dim_y_ex22'] );	if ( $CV <= 0 ) { $CV = abs($CV) + 8; $P[$mn]['dim_y_ex22'] += $CV; $P[$mn]['dy'] += $CV; $P[$mn]['pos_y3_ex22'] += $CV; $P[$mn]['pos_y4_ex22'] = &$P[$mn]['pos_y3_ex22']; }

	$P[$mn]['dim_x_ex12'] = $P[$mn]['dim_x_ex22'] - $B['deco_ex11_x'] - $B['deco_ex13_x'] ;
	$P[$mn]['dim_x_ex32'] = $P[$mn]['dim_x_ex22'] - $B['deco_ex31_x'] - $B['deco_ex33_x'] ;
	$P[$mn]['dim_y_ex21'] = $P[$mn]['dim_y_ex22'] - $B['deco_ex12_y'] - $B['deco_ex41_y'] ;
	$P[$mn]['dim_y_ex23'] = $P[$mn]['dim_y_ex22'] - $B['deco_ex31_y'] - $B['deco_ex45_y'] ;

// --------------------------------------------------------------------------------------------
	$P[$mn]['pos_x_ex11'] = $P[$mn]['pos_x1_ex22'] - $B['deco_ex11_x'];	$P[$mn]['pos_y_ex11'] = $P[$mn]['pos_y1_ex22'] - $B['deco_ex11_y'];
	$P[$mn]['pos_x_ex12'] = $P[$mn]['pos_x1_ex22'];						$P[$mn]['pos_y_ex12'] = $P[$mn]['pos_y1_ex22'] - $B['deco_ex12_y'];
	$P[$mn]['pos_x_ex13'] = $P[$mn]['pos_x2_ex22'];						$P[$mn]['pos_y_ex13'] = $P[$mn]['pos_y1_ex22'] - $B['deco_ex13_y'];

	$P[$mn]['pos_x_ex21'] = $P[$mn]['pos_x1_ex22'] - $B['deco_ex21_x'];	$P[$mn]['pos_y_ex21'] = $P[$mn]['pos_y1_ex22'];
	$P[$mn]['pos_x_ex22'] = $P[$mn]['pos_x1_ex22'];						$P[$mn]['pos_y_ex22'] = $P[$mn]['pos_y1_ex22'];
	$P[$mn]['pos_x_ex23'] = $P[$mn]['pos_x2_ex22'];						$P[$mn]['pos_y_ex23'] = $P[$mn]['pos_y1_ex22'];

	$P[$mn]['pos_x_ex31'] = $P[$mn]['pos_x1_ex22'] - $B['deco_ex31_x'];	$P[$mn]['pos_y_ex31'] = $P[$mn]['pos_y3_ex22'];
	$P[$mn]['pos_x_ex32'] = $P[$mn]['pos_x1_ex22'];						$P[$mn]['pos_y_ex32'] = $P[$mn]['pos_y3_ex22'];
	$P[$mn]['pos_x_ex33'] = $P[$mn]['pos_x2_ex22'];						$P[$mn]['pos_y_ex33'] = $P[$mn]['pos_y3_ex22'];

// --------------------------------------------------------------------------------------------
	$S['theme_module_largeur_interne'] = $P[$mn]['dim_x_ex22'] - 16;
	$S['theme_module_hauteur_interne'] = $P[$mn]['dim_y_ex22'] - 16;

	$pv['listeDiv'] = array ( "ex11", "ex12", "ex13", "ex21", "ex22", "ex23", "ex31", "ex32", "ex33" );
	foreach ( $pv['listeDiv'] as $A ) { $_REQUEST['div_id'][$A] = "id='" . $mn . "_".$A."' "; }

	$Rendu = "
	<!-- _______________________________________ Decoration du module ".$mn." (debut) _______________________________________ -->\r
	";
	if ( isset($module_['module_conteneur_nom'] ) && strlen($module_['module_conteneur_nom']) > 0 ) { $Rendu .= "<div id='".$module_['module_conteneur_nom']."' style='visibility: hidden; position:absolute; top: 0px; left: 0px;'>\r"; } 
	$Rendu .= "
	<div ".$_REQUEST['div_id']['ex11']." class='".$TS . $_REQUEST['bloc']."_ex11' style='left: ".$P[$mn]['pos_x_ex11']."px;	top: ".$P[$mn]['pos_y_ex11']."px; z-index: ".$module_z_index['compteur']."; width: ".$B['deco_ex11_x']."px; 	height:".$B['deco_ex11_y']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex12']." class='".$TS . $_REQUEST['bloc']."_ex12' style='left: ".$P[$mn]['pos_x_ex12']."px;	top: ".$P[$mn]['pos_y_ex12']."px; z-index: ".$module_z_index['compteur']."; width: ".$P[$mn]['dim_x_ex22']."px;	height:".$B['deco_ex12_y']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex13']." class='".$TS . $_REQUEST['bloc']."_ex13' style='left: ".$P[$mn]['pos_x_ex13']."px;	top: ".$P[$mn]['pos_y_ex13']."px; z-index: ".$module_z_index['compteur']."; width: ".$B['deco_ex13_x']."px;		height:".$B['deco_ex13_y']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex21']." class='".$TS . $_REQUEST['bloc']."_ex21' style='left: ".$P[$mn]['pos_x_ex21']."px;	top: ".$P[$mn]['pos_y_ex21']."px; z-index: ".$module_z_index['compteur']."; width: ".$B['deco_ex21_x']."px;		height:".$P[$mn]['dim_y_ex22']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex23']." class='".$TS . $_REQUEST['bloc']."_ex23' style='left: ".$P[$mn]['pos_x_ex23']."px;	top: ".$P[$mn]['pos_y_ex23']."px; z-index: ".$module_z_index['compteur']."; width: ".$B['deco_ex23_x']."px;		height:".$P[$mn]['dim_y_ex22']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex31']." class='".$TS . $_REQUEST['bloc']."_ex31' style='left: ".$P[$mn]['pos_x_ex31']."px;	top: ".$P[$mn]['pos_y_ex31']."px; z-index: ".$module_z_index['compteur']."; width: ".$B['deco_ex31_x']."px; 	height:".$B['deco_ex31_y']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex32']." class='".$TS . $_REQUEST['bloc']."_ex32' style='left: ".$P[$mn]['pos_x_ex32']."px;	top: ".$P[$mn]['pos_y_ex32']."px; z-index: ".$module_z_index['compteur']."; width: ".$P[$mn]['dim_x_ex22']."px; height:".$B['deco_ex32_y']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex33']." class='".$TS . $_REQUEST['bloc']."_ex33' style='left: ".$P[$mn]['pos_x_ex33']."px;	top: ".$P[$mn]['pos_y_ex33']."px; z-index: ".$module_z_index['compteur']."; width: ".$B['deco_ex33_x']."px; 	height:".$B['deco_ex33_y']."px;'></div>\r
	<div ".$_REQUEST['div_id']['ex22']." class='".$TS . $_REQUEST['bloc']."_ex22 ".$TS.$_REQUEST['bloc']."_t".$M['module_deco_txt_defaut']." ".$TS.$_REQUEST['bloc']."_t_couleur_de_base' style='left: ".$P[$mn]['pos_x_ex22']."px;	top: ".$P[$mn]['pos_y_ex22']."px; width: ".$P[$mn]['dim_x_ex22']."px ; height: ".$P[$mn]['dim_y_ex22']."px; overflow: auto; z-index: ".$module_z_index['compteur'].";'>\r
	<!-- _______________________________________ Decoration du module ".$mn." (fin)_______________________________________ -->\r
	";

	vide_module_div_ids ();

	$JavaScriptInitCommandes[] = "JavaScriptTabInfoModule ( '".$mn."' , 40 );";
//	JavaScriptTabInfoModule ( $mn , "40" );

	switch ( $Mode ) {
	case 0 :	echo $Rendu;	break;
	case 1 :	return $Rendu;	break;
	}
}
?>
