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
$ligne++;
$tampon_commande_buffer[$ligne] = "add decoration name \"".$_REQUEST['M_DECORA']['nom']. "\"	\n";
$tampon_commande_buffer[$ligne] .= "state		\"".$_REQUEST['M_DECORA']['etat']. "\"	\n";
$tampon_commande_buffer[$ligne] .= "type		\"".$_REQUEST['M_DECORA']['type']. "\"	\n";
$tampon_commande_buffer[$ligne] .= "directory	\"".$_REQUEST['M_DECORA']['repertoire']. "\"	\n";


switch ($_REQUEST['M_DECORA']['type']) {
	case 10:		case "menu":
	break;
	case 30:	case "1_div":
		if ( isset($REQUEST['M_DECORA']['Bloc_GD_1_div_allw']) && strlen($_REQUEST['M_DECORA']['Bloc_GD_1_div_allw']) > 0 ) {
			$tampon_commande_buffer[$ligne] .= "border_all_width 	\"".$_REQUEST['M_DECORA']['Bloc_GD_1_div_allw']."\"	\n";
		}
		else {
			$tampon_commande_buffer[$ligne] .= "border_left_width 	\"".$_REQUEST['M_DECORA']['Bloc_GD_1_div_blw']."\"	\n";
			$tampon_commande_buffer[$ligne] .= "border_right_width 	\"".$_REQUEST['M_DECORA']['Bloc_GD_1_div_brw']."\"	\n";
			$tampon_commande_buffer[$ligne] .= "border_top_width 	\"".$_REQUEST['M_DECORA']['Bloc_GD_1_div_btw']."\"	\n";
			$tampon_commande_buffer[$ligne] .= "border_bottom_width \"".$_REQUEST['M_DECORA']['Bloc_GD_1_div_bbw']."\"	\n";
		}

		$REQUEST['M_DECORA']['Bloc_GD_1_div_alls_test'] = 0;
		if ( $_REQUEST['M_DECORA']['Bloc_GD_1_div_bls'] != $REQUEST['M_DECORA']['Bloc_GD_1_div_alls'] ) { $REQUEST['M_DECORA']['Bloc_GD_1_div_alls_test'] = 1; }
		if ( $_REQUEST['M_DECORA']['Bloc_GD_1_div_brs'] != $REQUEST['M_DECORA']['Bloc_GD_1_div_alls'] ) { $REQUEST['M_DECORA']['Bloc_GD_1_div_alls_test'] = 1; }
		if ( $_REQUEST['M_DECORA']['Bloc_GD_1_div_bts'] != $REQUEST['M_DECORA']['Bloc_GD_1_div_alls'] ) { $REQUEST['M_DECORA']['Bloc_GD_1_div_alls_test'] = 1; }
		if ( $_REQUEST['M_DECORA']['Bloc_GD_1_div_bbs'] != $REQUEST['M_DECORA']['Bloc_GD_1_div_alls'] ) { $REQUEST['M_DECORA']['Bloc_GD_1_div_alls_test'] = 1; }

		if ( isset($REQUEST['M_DECORA']['Bloc_GD_1_div_alls_test']) == 0 ) {
			$tampon_commande_buffer[$ligne] .= "border_all_style 	\"".$_REQUEST['M_DECORA']['Bloc_GD_1_div_alls']."\"	\n";
		}
		else {
			$tampon_commande_buffer[$ligne] .= "border_left_style 	\"".$_REQUEST['M_DECORA']['Bloc_GD_1_div_bls']."\"	\n";
			$tampon_commande_buffer[$ligne] .= "border_right_style 	\"".$_REQUEST['M_DECORA']['Bloc_GD_1_div_brs']."\"	\n";
			$tampon_commande_buffer[$ligne] .= "border_top_style 	\"".$_REQUEST['M_DECORA']['Bloc_GD_1_div_bts']."\"	\n";
			$tampon_commande_buffer[$ligne] .= "border_bottom_style \"".$_REQUEST['M_DECORA']['Bloc_GD_1_div_bbs']."\"	\n";
		}

		if ( isset($REQUEST['Bloc_GD_1_div_allc']) && strlen($_REQUEST['M_DECORA']['Bloc_GD_1_div_allc']) > 0 ) {
			$tampon_commande_buffer[$ligne] .= "border_all_color 	\"".$_REQUEST['Bloc_GD_1_div_allc']."\"	\n";
		}
		else {
			$tampon_commande_buffer[$ligne] .= "border_left_color 	\"".$_REQUEST['M_DECORA']['Bloc_GD_1_div_blc']."\"	\n";
			$tampon_commande_buffer[$ligne] .= "border_right_color 	\"".$_REQUEST['M_DECORA']['Bloc_GD_1_div_brc']."\"	\n";
			$tampon_commande_buffer[$ligne] .= "border_top_color 	\"".$_REQUEST['M_DECORA']['Bloc_GD_1_div_btc']."\"	\n";
			$tampon_commande_buffer[$ligne] .= "border_bottom_color \"".$_REQUEST['M_DECORA']['Bloc_GD_1_div_bbc']."\"	\n";
		}
		$tampon_commande_buffer[$ligne] .= "background_color 	\"".$_REQUEST['M_DECORA']['Bloc_GD_1_div_bgc']."\"	\n";
		if ( isset($_REQUEST['M_DECORA']['Bloc_GD_1_div_bgi']) && strlen($_REQUEST['M_DECORA']['Bloc_GD_1_div_bgi']) > 0 ) {
			$tampon_commande_buffer[$ligne] .= "background_image 	\"".$_REQUEST['M_DECORA']['Bloc_GD_1_div_bgi']."\"	\n";
		}
	break;

	case 40:	case "elegance":
		$liste_divs = array ( "ex11", "ex12", "ex13", "ex21", "ex23", "ex31", "ex32", "ex33" );
		foreach ( $liste_divs as $A ) {
			if ( strlen($_REQUEST['M_DECORA'][Bloc_GD_elegance_."$A"._bg]) > 0 )	{ $tampon_commande_buffer[$ligne] .= $A . " 	\"".$_REQUEST['M_DECORA'][Bloc_GD_elegance_."$A"._bg]."\"	\n"; }
			if ( $_REQUEST['M_DECORA'][Bloc_GD_elegance_."$A"._dimx] > 0 )			{ $tampon_commande_buffer[$ligne] .= $A . "_x 	\"".$_REQUEST['M_DECORA'][Bloc_GD_elegance_."$A"._dimx]."\"	\n"; }
			if ( $_REQUEST['M_DECORA'][Bloc_GD_elegance_."$A"._dimy] > 0 )			{ $tampon_commande_buffer[$ligne] .= $A . "_y 	\"".$_REQUEST['M_DECORA'][Bloc_GD_elegance_."$A"._dimy]."\"	\n"; }
			$tampon_commande_buffer[$ligne] .= $A . "_bgp	\"".$_REQUEST['M_DECORA'][Bloc_GD_elegance_."$A"._bgp]."\"	\n";
		}
	break;
	case 50:	case "exquise":
		$liste_divs = array ( "ex11", "ex12", "ex13", "ex14", "ex15", "ex21", "ex25", "ex31", "ex35", "ex41", "ex45", "ex51", "ex52", "ex53", "ex54", "ex55" );
		foreach ( $liste_divs as $A ) {
			if ( strlen($_REQUEST['M_DECORA'][Bloc_GD_exquise_."$A"._bg]) > 0 )	{ $tampon_commande_buffer[$ligne] .= $A . " 	\"".$_REQUEST['M_DECORA'][Bloc_GD_exquise_."$A"._bg]."\"	\n"; }
			if ( $_REQUEST['M_DECORA'][Bloc_GD_exquise_."$A"._dimx] > 0 )		{ $tampon_commande_buffer[$ligne] .= $A . "_x 	\"".$_REQUEST['M_DECORA'][Bloc_GD_exquise_."$A"._dimx]."\"	\n"; }
			if ( $_REQUEST['M_DECORA'][Bloc_GD_exquise_."$A"._dimy] > 0 )		{ $tampon_commande_buffer[$ligne] .= $A . "_y 	\"".$_REQUEST['M_DECORA'][Bloc_GD_exquise_."$A"._dimy]."\"	\n"; }
			$tampon_commande_buffer[$ligne] .= $A . "_bgp	\"".$_REQUEST['M_DECORA'][Bloc_GD_exquise_."$A"._bgp]."\"	\n";
		}
	break;
	case 60:	case "elysion":
		$liste_divs = array ( "ex11", "ex12", "ex13", "ex14", "ex15", "ex21", "ex25", "ex31", "ex35", "ex41", "ex45", "ex51", "ex52", "ex53", "ex54", "ex55", "in11", "in12", "in13", "in14", "in15", "in21", "in25", "in31", "in35", "in41", "in45", "in51", "in52", "in53", "in54", "in55" );
		foreach ( $liste_divs as $A ) {
			if ( strlen($_REQUEST['M_DECORA'][Bloc_GD_elysion_."$A"._bg]) > 0 )	{ $tampon_commande_buffer[$ligne] .= $A . " 	\"".$_REQUEST['M_DECORA'][Bloc_GD_elysion_."$A"._bg]."\"	\n"; }
			if ( $_REQUEST['M_DECORA'][Bloc_GD_elysion_."$A"._dimx] > 0 )		{ $tampon_commande_buffer[$ligne] .= $A . "_x 	\"".$_REQUEST['M_DECORA'][Bloc_GD_elysion_."$A"._dimx]."\"	\n"; }
			if ( $_REQUEST['M_DECORA'][Bloc_GD_elysion_."$A"._dimy] > 0 )		{ $tampon_commande_buffer[$ligne] .= $A . "_y 	\"".$_REQUEST['M_DECORA'][Bloc_GD_elysion_."$A"._dimy]."\"	\n"; }
			$tampon_commande_buffer[$ligne] .= $A . "_bgp	\"".$_REQUEST['M_DECORA'][Bloc_GD_elysion_."$A"._bgp]."\"	\n";
		}
	break;
	default:
	break;
}
?>
