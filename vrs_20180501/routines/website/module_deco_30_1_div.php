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
function module_deco_30_1_div ( $TS, $TP , $TM, $Mode ) {
	global $statistiques, $admin_control_, $affiche_module_mode, $module_z_index;
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

	$P[$mn]['pos_x1_22'] = $P[$mn]['px'];
	$P[$mn]['pos_y1_22'] = $P[$mn]['py'];

	$P[$mn]['pos_x2_22'] = $P[$mn]['px'] + $P[$mn]['dx'];
	$P[$mn]['pos_y2_22'] = &$P[$mn]['pos_y1_22'];

	$P[$mn]['pos_x3_22'] = &$P[$mn]['pos_x1_22'];
	$P[$mn]['pos_y3_22'] = $P[$mn]['py'] + $P[$mn]['dy'];

	$P[$mn]['pos_x4_22'] = &$P[$mn]['pos_x2_22'];
	$P[$mn]['pos_y4_22'] = &$P[$mn]['pos_y3_22'];

	$P[$mn]['dim_x_22'] = $P[$mn]['pos_x2_22'] - $P[$mn]['pos_x1_22'];
	$P[$mn]['dim_y_22'] = $P[$mn]['pos_y3_22'] - $P[$mn]['pos_y1_22'];

	$S['theme_module_largeur_interne'] = $P[$mn]['dim_x_22'] - 16;
	$S['theme_module_hauteur_interne'] = $P[$mn]['dim_y_22'] - 16;

	$_REQUEST['div_id']['un_div'] = "id='" . $mn . "_un_div' ";

	$Rendu = "
	<!-- _______________________________________ Decoration du module ".$mn." (debut) ".$module_['module_conteneur_nom']." _______________________________________ -->\r
	";
	if ( isset($M['module_conteneur_nom']) && strlen($M['module_conteneur_nom']) > 0 ) { $Rendu .= "<div id='".$M['module_conteneur_nom']."' style='visibility: hidden; position: absolute; top: 0px; left: 0px;'>\r"; } 
	$Rendu .= "<div ".$_REQUEST['div_id']['un_div']." class='".$TS . $_REQUEST['bloc']."_1_div ".$TS . $_REQUEST['bloc']."_t".$M['module_deco_txt_defaut']." ".$TS . $_REQUEST['bloc']."_t_couleur_de_base' style='position: absolute; left: ".$P[$mn]['pos_x1_22']."px;	top: ".$P[$mn]['pos_y1_22']."px;  width: ".$P[$mn]['dim_x_22']."px ;	height: ".$P[$mn]['dim_y_22']."px; line-height: normal; overflow: auto; ";
	if ( isset($module_z_index['compteur']) ) { $Rendu .= " z-index: ".$module_z_index['compteur']."; "; }
	$Rendu .= "
	background-repeat: repeat;'>\r
	<!-- _______________________________________ Decoration du module ".$mn." (fin)_______________________________________ -->\r
	";

	vide_module_div_ids ();
/*
	$localisation = " / module_deco_30_1_div";
	$_REQUEST['localisation'] .= $localisation;
	statistique_checkpoint ("module_deco_30_1_div_fin");
	$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );
*/
	switch ( $Mode ) {
	case 0 :	echo $Rendu;	break;
	case 1 :	return $Rendu;	break;
	}
}

?>
