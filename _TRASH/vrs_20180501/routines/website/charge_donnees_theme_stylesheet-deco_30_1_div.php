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
	if ( $p['deco_a_line_height'] > 0 ) { $pv['supLH'] = "; line-height: ". $p['deco_a_line_height']."px;"; }
	$stylesheet .= CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_1_div" ) . 
	"{ vertical-align: bottom;	\r";

	$pv['One_div_score'] = 0;
	if ( strlen($p['deco_background_color']) != 0 ) { $pv['One_div_score'] += 1;}
	if ( strlen($p['deco_background_url']) != 0 ) { $pv['One_div_score'] += 10;}

	switch ($pv['One_div_score']) {
	case 1:					$stylesheet .= "background-color: ".$p['deco_background_color'].";\r\r";										break;
	case 10:	case 11:	$stylesheet .= "background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_background_url'].");\r\r";	break;
	}

	if ( $p['deco_border_all_width'] != 0 ) { $stylesheet .= "	border-top-width: ".$p['deco_border_all_width']."px;	border-bottom-width: ".$p['deco_border_all_width']."px;	border-left-width: ".$p['deco_border_all_width']."px;	border-right-width: ".$p['deco_border_all_width']."px;\r";	}
	else { $stylesheet .= "border-top-width: ".$p['deco_border_top_width']."px;	border-bottom-width: ".$p['deco_border_bottom_width']."px;	border-left-width: ".$p['deco_border_left_width']."px;	border-right-width: ".$p['deco_border_right_width']."px;\r"; }

	if ( strlen($p['deco_border_all_color']) != 0 ) { $stylesheet .= "	border-top-color: ".$p['deco_border_all_color'].";	border-bottom-color: ".$p['deco_border_all_color'].";	border-left-color: ".$p['deco_border_all_color'].";	border-right-color: ".$p['deco_border_all_color'].";\r"; }
	else { $stylesheet .= "	border-top-color: ".$p['deco_border_top_color'].";	border-bottom-color: ".$p['deco_border_bottom_color'].";	border-left-color: ".$p['deco_border_left_color'].";	border-right-color: ".$p['deco_border_right_color'].";\r"; }

	if ( strlen($p['deco_border_all_style']) != 0 ) { $stylesheet .= "	border-top-style: ".$p['deco_border_all_style'].";	border-bottom-style: ".$p['deco_border_all_style'].";	border-left-style: ".$p['deco_border_all_style'].";	border-right-style: ".$p['deco_border_all_style'].";\r"; }
	else { $stylesheet .= "	border-top-style: ".$p['deco_border_top_style'].";	border-bottom-style: ".$p['deco_border_bottom_style'].";	border-left-style: ".$p['deco_border_left_style'].";	border-right-style: ".$p['deco_border_right_style'].";\r"; }

	if ( $p['deco_padding_all'] != 0 ) { $stylesheet .= "	padding-top: ".$p['deco_padding_all']."px;	padding-bottom: ".$p['deco_padding_all']."px;	padding-left: ".$p['deco_padding_all']."px;	padding-right: ".$p['deco_padding_all']."px;\r"; }
	else { $stylesheet .= "	padding-top: ".$p['deco_padding_top']."px;	padding-bottom: ".$p['deco_padding_bottom']."px;	padding-left: ".$p['deco_padding_left']."px;	padding-right: ".$p['deco_padding_right']."px;\r"; }

	if ( $p['deco_margin_all'] != 0 ) { $stylesheet .= "	margin-top: ".$p['deco_margin_all']."px;	margin-bottom: ".$p['deco_margin_all']."px;	margin-left: ".$p['deco_margin_all']."px;	margin-right: ".$p['deco_margin_all']."px;\r"; }
	else { $stylesheet .= "	margin-top: ".$p['deco_margin_top']."px;	margin-bottom: ".$p['deco_margin_bottom']."px;	margin-left: ".$p['deco_margin_left']."px;	margin-right: ".$p['deco_margin_right']."px;\r"; }

	$stylesheet .= $pv['supLH'].
	"overflow: auto\r
	}\r";

	$pv['PreloadImg'] = array ( "deco_background_url" );
	unset ($A);
	foreach ( $pv['PreloadImg'] as $A ) { $stylesheet_preload[] = $p[$A]; }
}
?>
