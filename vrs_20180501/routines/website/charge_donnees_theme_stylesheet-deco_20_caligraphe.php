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
$p = &${$theme_tableau}[$_REQUEST['blocT']];
if ( strpos ( $p['liste_doublon'] , $_REQUEST['blocT'] ) === FALSE ) {
	$pv['theme_tmp_repertoire'] = ${$theme_tableau}[$_REQUEST['blocT']]['deco_repertoire'];
	$p = &${$theme_tableau}[$_REQUEST['blocT']];

// --------------------------------------------------------------------------------------------
//	bloc de code identique sur charge_donnes_theme_tableau.php et charge_donnees_theme_stylesheet-deco_20_caligraphe.php
	$pv['fonte_plage']	= $p['deco_txt_fonte_size_max'] - $p['deco_txt_fonte_size_min'];
	$pv['fonte_coef']	= $pv['fonte_plage'] / 6;
	$pv['fonte_depart']	= $p['deco_txt_fonte_size_min'];
	for ( $pv['i'] = 1 ; $pv['i'] <= 7 ; $pv['i']++ ) { 
		$stylesheet .= 
		CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_t".$pv['i'] ) .  "{ font-size: ". floor ($pv['fonte_depart'] + ($pv['fonte_coef'] * ($pv['i'] - 1))) . "px; font-family: ".$p['deco_txt_fonte'] . "; letter-spacing : 0px; word-spacing : 0px; font-weight: normal; } \r" . 
		CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_tb".$pv['i'] ) . "{ font-size: ". floor ($pv['fonte_depart'] + ($pv['fonte_coef'] * ($pv['i'] - 1))) . "px; font-family: ".$p['deco_txt_fonte'] . "; letter-spacing : 0px; word-spacing : 0px; font-weight: bold; } \r" . 
		CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_th".$pv['i'] ) . "{ font-size: ". floor ($pv['fonte_depart'] + ($pv['fonte_coef'] * ($pv['i'] - 1))) . "px; vertical-align: top; font-weight: normal;}\r";
		$p['fonte_size_n'.$pv['i']] = floor ($pv['fonte_depart'] + ($pv['fonte_coef'] * ($pv['i'] - 1)));
	}

	unset ( $pv['CCSD'] );
	if ( $p['deco_txt_l_01_size'] != 0 )					{ $pv['CCSD']['deco_txt_l_01_size']				= "font-size: ".$p['deco_txt_l_01_size']."px; "; }
	if ( $p['deco_txt_l_01_weight'] != "normal" )			{ $pv['CCSD']['deco_txt_l_01_weight']			= "font-weight: ".$p['deco_txt_l_01_weight']."px; "; }
	if ( $p['deco_txt_l_01_hover_size'] != 0 )				{ $pv['CCSD']['deco_txt_l_01_hover_size']		= "font-size: ".$p['deco_txt_l_01_hover_size']."px; "; }
	if ( $p['deco_txt_l_01_hover_weight'] != "normal" )		{ $pv['CCSD']['deco_txt_l_01_hover_weight']		= "font-weight: ".$p['deco_txt_l_01_hover_weight']."; "; }
	$pv['CCSD']['deco_txt_l_01_hover_decoration']	= "text-decoration: ".$p['deco_txt_l_01_hover_decoration']."; ";

	if ( $p['deco_txt_l_td_size'] != 0 )					{ $pv['CCSD']['deco_txt_l_td_size']				= "font-size: ".$p['deco_txt_l_td_size']."px; "; }
	if ( $p['deco_txt_l_td_weight'] != "normal" )			{ $pv['CCSD']['deco_txt_l_td_weight']			= "font-weight: ".$p['deco_txt_l_td_weight']."px; "; }
	if ( $p['deco_txt_l_td_hover_size'] != 0 )				{ $pv['CCSD']['deco_txt_l_td_hover_size']		= "font-size: ".$p['deco_txt_l_td_hover_size']."px; "; }
	if ( $p['deco_txt_l_td_hover_weight'] != "normal" )		{ $pv['CCSD']['deco_txt_l_td_hover_weight']		= "font-weight: ".$p['deco_txt_l_td_hover_weight']."; "; }
	$pv['CCSD']['deco_txt_l_td_hover_decoration']	= "text-decoration: ".$p['deco_txt_l_td_hover_decoration']."; ";

	$stylesheet .= "
	".	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_p" ) . "{
	font-family: ".$p['deco_txt_fonte'].";
	text-indent: ".$p['deco_p_txt_indent']."px;
	text-align: ".$p['deco_p_txt_align'].";
	margin-top: ".$p['deco_p_mrg_top']."px;
	margin-bottom: ".$p['deco_p_mrg_bottom']."px;
	margin-left: ".$p['deco_p_mrg_left']."px;
	margin-right: ".$p['deco_p_mrg_right']."px;
	padding-top: ".$p['deco_p_pad_top']."px;
	padding-bottom: ".$p['deco_p_pad_bottom']."px;
	padding-left: ".$p['deco_p_pad_left']."px;
	padding-right: ".$p['deco_p_pad_right']."px
	}\r". 

	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_t_couleur_de_base" ) . "{ color: ".$p['deco_txt_col'] . "; } \r" .

	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ft" ) . "{ border-spacing: 0px; border: 0px;	empty-cells: show; vertical-align: middle; } \r" .
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ft1" ) . "{ padding: 0px;	border: 0px;	width: ".$p['deco_ft1_x']."px;	height: ".$p['deco_ft_y']."px;	background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ft1']."); } \r" .
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ft2" ) . "{ padding: 0px;	border: 0px;									height: ".$p['deco_ft_y']."px;	background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ft2'].");	color: ".$p['deco_txt_titre_col']."; } \r" .
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ft3" ) . "{ padding: 0px;	border: 0px;	width: ".$p['deco_ft3_x']."px;	height: ".$p['deco_ft_y']."px;	background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_ft3']."); } \r" .

	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_fca" ) . "	{ padding: 5px ; vertical-align: top; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_bgca'].");  color: ".$p['deco_ca_txt_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_fcb" ) . "	{ padding: 5px ; vertical-align: top; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_bgcb'].");  color: ".$p['deco_cb_txt_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_fcc" ) . "	{ padding: 5px ; vertical-align: top; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_bgcc'].");  color: ".$p['deco_cc_txt_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_fcd" ) . "	{ padding: 5px ; vertical-align: top; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_bgcd'].");  color: ".$p['deco_cd_txt_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_fcta" ) . "	{ padding: 5px ; vertical-align: top; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_bgcta']."); color: ".$p['deco_cta_txt_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_fctb" ) . "	{ padding: 5px ; vertical-align: top; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_bgctb']."); color: ".$p['deco_ctb_txt_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_fcsa" ) . "	{ padding: 5px ; vertical-align: top; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_bgcsa']."); color: ".$p['deco_csa_txt_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_fcsb" ) . "	{ padding: 5px ; vertical-align: top; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_bgcsb']."); color: ".$p['deco_csb_txt_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_fco" ) . "	{ padding: 5px ; vertical-align: top; background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_bgco'].");  color: ".$p['deco_co_txt_col']."; }\r\r" . 

	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_highlight" ) . "	{ color: ".$p['deco_txt_highlight_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_code" ) . "		{ color: ".$p['deco_txt_code_fg_col'].";		background-color: ".$p['deco_txt_code_bg_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_ok" ) . "			{ color: ".$p['deco_txt_ok_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_avert" ) . "		{ color: ".$p['deco_txt_avert_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_erreur" ) . "		{ color: ".$p['deco_txt_erreur_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_fade" ) . "		{ color: ".$p['deco_txt_fade_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_form_1" ) . "		{ color: ".$p['deco_txt_input1_fg_col'].";		background-color: ".$p['deco_txt_input1_bg_col']."; font-weight: normal;  }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_form_2" ) . "		{ color: ".$p['deco_txt_input2_fg_col'].";		background-color: ".$p['deco_txt_input2_bg_col']."; font-weight: normal;  }\r" . 	
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_tab_up" ) . "		{ color: ".$p['deco_tab_up_txt_col'].";			background-color: ".$p['deco_tab_up_txt_bg_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_tab_down" ) . "	{ color: ".$p['deco_tab_down_txt_col'].";		background-color: ".$p['deco_tab_down_txt_bg_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_tab_hover" ) . "	{ color: ".$p['deco_tab_hover_txt_col'].";		background-color: ".$p['deco_tab_hover_txt_bg_col']."; }\r\r" . 

	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_submit_s1_n01" ) . " { width: ".$p['deco_s1_01_x']."px;	height: ".$p['deco_s1_01_y']."px; 							background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_s1_n01'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['deco_s1_txt_col'].";}\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_submit_s1_n02" ) . " { 									height: ".$p['deco_s1_01_y']."px; background: transparent;	background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_s1_n02'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['deco_s1_txt_col'].	";		font-weight:".$p['deco_s1_txt_weight'].";		text-shadow: ".$p['deco_s1_txt_shadow'].";	}\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_submit_s1_n03" ) . " { width: ".$p['deco_s1_03_x']."px;	height: ".$p['deco_s1_01_y']."px; 							background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_s1_n03'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['deco_s1_txt_col'].";}\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_submit_s1_h01" ) . " { width: ".$p['deco_s1_01_x']."px;	height: ".$p['deco_s1_01_y']."px; 							background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_s1_h01'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['deco_s1_txt_hover_col'].";}\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_submit_s1_h02" ) . " { 									height: ".$p['deco_s1_01_y']."px; background: transparent;	background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_s1_h02'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['deco_s1_txt_hover_col'].";	font-weight:".$p['deco_s1_txt_hover_weight'].";	text-shadow: ".$p['deco_s1_txt_hover_shadow'].";	}\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_submit_s1_h03" ) . " { width: ".$p['deco_s1_03_x']."px;	height: ".$p['deco_s1_01_y']."px; 							background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_s1_h03'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['deco_s1_txt_hover_col'].";}\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_submit_s2_n01" ) . " { width: ".$p['deco_s2_01_x']."px;	height: ".$p['deco_s2_01_y']."px; 							background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_s2_n01'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['deco_s2_txt_col'].";}\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_submit_s2_n02" ) . " { 									height: ".$p['deco_s2_01_y']."px; background: transparent;	background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_s2_n02'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['deco_s2_txt_col'].";		font-weight:".$p['deco_s2_txt_weight'].";		text-shadow: ".$p['deco_s2_txt_shadow'].";	}\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_submit_s2_n03" ) . " { width: ".$p['deco_s2_03_x']."px;	height: ".$p['deco_s2_01_y']."px; 							background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_s2_n03'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['deco_s2_txt_col'].";}\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_submit_s2_h01" ) . " { width: ".$p['deco_s2_01_x']."px;	height: ".$p['deco_s2_01_y']."px; 							background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_s2_h01'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['deco_s2_txt_hover_col'].";}\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_submit_s2_h02" ) . " { 									height: ".$p['deco_s2_01_y']."px; background: transparent;	background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_s2_h02'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['deco_s2_txt_hover_col'].";	font-weight:".$p['deco_s2_txt_hover_weight'].";	text-shadow: ".$p['deco_s2_txt_hover_shadow'].";	}\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_submit_s2_h03" ) . " { width: ".$p['deco_s2_03_x']."px;	height: ".$p['deco_s2_01_y']."px; 							background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_s2_h03'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['deco_s2_txt_hover_col'].";}\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_submit_s3_n01" ) . " { width: ".$p['deco_s3_01_x']."px;	height: ".$p['deco_s3_01_y']."px; 							background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_s3_n01'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['deco_s3_txt_col'].";}\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_submit_s3_n02" ) . " { 									height: ".$p['deco_s3_01_y']."px; background: transparent;	background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_s3_n02'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['deco_s3_txt_col'].";		font-weight:".$p['deco_s3_txt_weight'].";		text-shadow: ".$p['deco_s3_txt_shadow'].";	}\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_submit_s3_n03" ) . " { width: ".$p['deco_s3_03_x']."px;	height: ".$p['deco_s3_01_y']."px; 							background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_s3_n03'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['deco_s3_txt_col'].";}\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_submit_s3_h01" ) . " { width: ".$p['deco_s3_01_x']."px;	height: ".$p['deco_s3_01_y']."px; 							background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_s3_h01'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['deco_s3_txt_hover_col'].";}\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_submit_s3_h02" ) . " { 									height: ".$p['deco_s3_01_y']."px; background: transparent;	background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_s3_h02'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['deco_s3_txt_hover_col'].";	font-weight:".$p['deco_s3_txt_hover_weight'].";	text-shadow: ".$p['deco_s3_txt_hover_shadow'].";	}\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_submit_s3_h03" ) . " { width: ".$p['deco_s3_03_x']."px;	height: ".$p['deco_s3_01_y']."px; 							background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_s3_h03'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['deco_s3_txt_hover_col'].";}\r\r" . 

	CDS_liste_bloc_element ( "a." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_lien" ) . " 			{ text-decoration: ".$p['deco_txt_l_01_decoration']."; display: ".$p['deco_txt_l_01_display'].";}\r	" . 
	CDS_liste_bloc_element ( "a." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_lien:link" ) . " 	{ color: ".$p['deco_txt_l_01_fg_col'].";			background-color: ".$p['deco_txt_l_01_bg_col']."; ".$pv['CCSD']['deco_txt_l_01_size'].$pv['CCSD']['deco_txt_l_01_weight']." margin-top:".$p['deco_txt_l_01_margin_top']."px; margin-bottom:".$p['deco_txt_l_01_margin_bottom']."px; margin-left:".$p['deco_txt_l_01_margin_left']."px; margin-right:".$p['deco_txt_l_01_margin_right']."px; }\r" . 
	CDS_liste_bloc_element ( "a." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_lien:visited" ) . "	{ color: ".$p['deco_txt_l_01_fg_visite_col'].";		background-color: ".$p['deco_txt_l_01_bg_visite_col']."; }\r" . 
	CDS_liste_bloc_element ( "a." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_lien:hover" ) . "  	{ color: ".$p['deco_txt_l_01_fg_hover_col'].";		background-color: ".$p['deco_txt_l_01_bg_hover_col']."; ".$pv['CCSD']['deco_txt_l_01_hover_size'].$pv['CCSD']['deco_txt_l_01_hover_weight'].$pv['CCSD']['deco_txt_l_01_hover_decoration']." }\r\r" . 
	CDS_liste_bloc_element ( "a." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_lien:active" ) . " 	{ color: ".$p['deco_txt_l_01_fg_active_col'].";		background-color: ".$p['deco_txt_l_01_bg_active_col']."; }\r" . 

	CDS_liste_bloc_element ( "td > a." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_lien" ) . " 		{ text-decoration: ".$p['deco_txt_l_td_decoration']."; display: ".$p['deco_txt_l_td_display'].";}\r	" . 
	CDS_liste_bloc_element ( "td > a." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_lien:link" ) . "	{ color: ".$p['deco_txt_l_td_fg_col'].";			background-color: ".$p['deco_txt_l_td_bg_col']."; ".$pv['CCSD']['deco_txt_l_td_size'].$pv['CCSD']['deco_txt_l_td_weight']." margin-top:".$p['deco_txt_l_td_margin_top']."px; margin-bottom:".$p['deco_txt_l_td_margin_bottom']."px; margin-left:".$p['deco_txt_l_td_margin_left']."px; margin-right:".$p['deco_txt_l_td_margin_right']."px; }\r" . 
	CDS_liste_bloc_element ( "td > a." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_lien:visited" ) . "	{ color: ".$p['deco_txt_l_td_fg_visite_col'].";		background-color: ".$p['deco_txt_l_td_bg_visite_col']."; }\r" . 
	CDS_liste_bloc_element ( "td > a." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_lien:hover" ) . " 	{ color: ".$p['deco_txt_l_td_fg_hover_col'].";		background-color: ".$p['deco_txt_l_td_bg_hover_col']."; ".$pv['CCSD']['deco_txt_l_td_hover_size'].$pv['CCSD']['deco_txt_l_td_hover_weight'].$pv['CCSD']['deco_txt_l_td_hover_decoration']." }\r\r" . 
	CDS_liste_bloc_element ( "td > a." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_lien:active" ) . "	{ color: ".$p['deco_txt_l_td_fg_active_col'].";		background-color: ".$p['deco_txt_l_td_bg_active_col']."; }\r" . 

	CDS_liste_bloc_element ( "td > ." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_form_1" ) . "	{ font-weight: normal; color: ".$p['deco_txt_input1_td_fg_col']."; background-color: ".$p['deco_txt_input1_td_bg_col']."; }\r" . 
	CDS_liste_bloc_element ( "td > ." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_form_2" ) . "	{ font-weight: normal; color: ".$p['deco_txt_input2_td_fg_col']."; background-color: ".$p['deco_txt_input2_td_bg_col']."; }\r\r" . 

	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_tab_down_a" ) . 	"	{ background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_tab_down_a'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;	width: ".$p['deco_tab_a_x']."px;	height: ".$p['deco_tab_y']."px;	background-position: top left;	background-repeat : no-repeat;	overflow:hidden;	text-align: center;	color: ".$p['deco_tab_down_txt_col'].";																												background-color: ".$p['deco_tab_down_txt_bg_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_tab_down_b" ) . 	"	{ background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_tab_down_b'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;										height: ".$p['deco_tab_y']."px;	background-position: top left;	background-repeat : repeat-x;	overflow:hidden;	text-align: center;	color: ".$p['deco_tab_down_txt_col'].";		font-weight: ".$p['deco_tab_down_txt_weight'].";	text-shadow : ".$p['deco_tab_down_txt_shadow'].";	background-color: ".$p['deco_tab_down_txt_bg_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_tab_down_c" ) . 	"	{ background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_tab_down_c'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;	width: ".$p['deco_tab_c_x']."px;	height: ".$p['deco_tab_y']."px;	background-position: top left;	background-repeat : no-repeat;	overflow:hidden;	text-align: center;	color: ".$p['deco_tab_down_txt_col'].";																												background-color: ".$p['deco_tab_down_txt_bg_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_tab_up_a" ) . "		{ background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_tab_up_a'].");		padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;	width: ".$p['deco_tab_a_x']."px;	height: ".$p['deco_tab_y']."px;	background-position: top left;	background-repeat : no-repeat;	overflow:hidden;	text-align: center;	color: ".$p['deco_tab_up_txt_col'].";																												background-color: ".$p['deco_tab_up_txt_bg_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_tab_up_b" ) . "		{ background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_tab_up_b'].");		padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;										height: ".$p['deco_tab_y']."px;	background-position: top left;	background-repeat : repeat-x;	overflow:hidden;	text-align: center;	color: ".$p['deco_tab_up_txt_col'].";		font-weight: ".$p['deco_tab_up_txt_weight'].";		text-shadow : ".$p['deco_tab_up_txt_shadow'].";		background-color: ".$p['deco_tab_up_txt_bg_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_tab_up_c" ) . "		{ background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_tab_up_c'].");		padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;	width: ".$p['deco_tab_c_x']."px;	height: ".$p['deco_tab_y']."px;	background-position: top left;	background-repeat : no-repeat;	overflow:hidden;	text-align: center;	color: ".$p['deco_tab_up_txt_col'].";																												background-color: ".$p['deco_tab_up_txt_bg_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_tab_hover_a" ) . "	{ background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_tab_hover_a'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;	width: ".$p['deco_tab_a_x']."px;	height: ".$p['deco_tab_y']."px;	background-position: top left;	background-repeat : no-repeat;	overflow:hidden;	text-align: center;	color: ".$p['deco_tab_hover_txt_col'].";																											background-color: ".$p['deco_tab_hover_txt_bg_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_tab_hover_b" ) . "	{ background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_tab_hover_b'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;										height: ".$p['deco_tab_y']."px;	background-position: top left;	background-repeat : repeat-x;	overflow:hidden;	text-align: center;	color: ".$p['deco_tab_hover_txt_col'].";	font-weight: ".$p['deco_tab_hover_txt_weight'].";	text-shadow : ".$p['deco_tab_hover_txt_shadow'].";	background-color: ".$p['deco_tab_hover_txt_bg_col']."; }\r" . 
	CDS_liste_bloc_element ( "." . $theme_tableau_a_ecrire , $p['liste_bloc'] , "_tab_hover_c" ) . "	{ background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".$p['deco_tab_hover_c'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;	width: ".$p['deco_tab_c_x']."px;	height: ".$p['deco_tab_y']."px;	background-position: top left;	background-repeat : no-repeat;	overflow:hidden;	text-align: center;	color: ".$p['deco_tab_hover_txt_col'].";																											background-color: ".$p['deco_tab_hover_txt_bg_col']."; }\r\r
	";

	$pv['PreloadImg'] = array ( "deco_ft1", "deco_ft2", "deco_ft3", "deco_bgca", "deco_bgcb", "deco_bgcc", "deco_bgcd", "deco_bgcta", "deco_bgctb", "deco_bgcsa", "deco_bgcsb", "deco_bgco", "deco_s1_n01", "deco_s1_n02", "deco_s1_n03", "deco_s1_h01", "deco_s1_h02", "deco_s1_h03", "deco_s2_n01", "deco_s2_n02", "deco_s2_n03", "deco_s2_h01", "deco_s2_h02", "deco_s2_h03", "deco_s3_n01", "deco_s3_n02", "deco_s3_n03", "deco_s3_h01", "deco_s3_h02", "deco_s3_h03", "deco_tab_down_a", "deco_tab_down_b", "deco_tab_down_c", "deco_tab_up_a", "deco_tab_up_b", "deco_tab_up_c", "deco_tab_hover_a", "deco_tab_hover_b", "deco_tab_hover_c" );
	unset ($A);
	foreach ( $pv['PreloadImg'] as $A ) { $stylesheet_preload[] = $p[$A]; }
}
?>
