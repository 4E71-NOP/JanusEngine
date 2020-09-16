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

$localisation = " / charge_donnees_theme_stylesheet";
$_REQUEST['localisation'] .= $localisation;
statistique_checkpoint ("charge_donnees_theme_stylesheet");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

$pv['theme_tmp_repertoire'] = ${$theme_tableau}['theme_repertoire'];	// on prend le repertoire du theme de maniere general
$stylesheet = "";

for ( $pv['n'] = 1 ; $pv['n'] <= $_REQUEST['compteur_bloc'] ; $pv['n']++ ) {
	$_REQUEST['bloc'] = decoration_nomage_bloc ( "B", $_REQUEST['compteur_bloc_mumero'][$pv['n']] , "");
	$_REQUEST['blocG'] = $_REQUEST['bloc'] . "G";
	$_REQUEST['blocT'] = $_REQUEST['bloc'] . "T";
	$pv['stae'] = $theme_tableau_a_ecrire . $_REQUEST['bloc'];

	if ( is_array( ${$theme_tableau}[$_REQUEST['blocT']] ) ) {
		include ("charge_donnees_theme_stylesheet-deco_20_caligraphe.php");

		switch ( ${$theme_tableau}[$_REQUEST['blocG']]['deco_type'] ) {
		case 30:	case "1_div":		include ("charge_donnees_theme_stylesheet-deco_30_1_div.php");		break;
		case 40:	case "elegance":	include ("charge_donnees_theme_stylesheet-deco_40_elegance.php");	break;
		case 50:	case "exquise":		include ("charge_donnees_theme_stylesheet-deco_50_exquise.php");	break;
		case 60:	case "elysion":		include ("charge_donnees_theme_stylesheet-deco_60_elysion.php");	break;
		}
		$pv['theme_tmp_repertoire'] = ${$theme_tableau}['theme_repertoire'];	// !!! A VIRER !!! on prend le repertoire de la decoration de maniere generale
	}
}
/* 2018 01 17 - Echec du préchargement.
$stylesheet_preload_text = "
:root:before {\r
content:\r
";
$stylesheet_preload = array_unique( $stylesheet_preload );
unset ($A);
foreach ( $stylesheet_preload as $A ) { $stylesheet_preload_text .= "url(../graph/".$pv['theme_tmp_repertoire']."/".$A.")\r"; }
$stylesheet_preload_text .= "visibility:hidden;\r}\r\r";
*/
switch ( $theme_tableau ) {
case "theme_princ_":
	$stylesheet = "<style type='text/css' media='all'>\r <!--\r".
	$stylesheet_entete .
	$stylesheet_preload_text.
	$stylesheet_at_fontface.
	"@media screen {\r
	body {\r
	font-family: ".${$theme_tableau}['B01T']['deco_txt_fonte'].";\r
	font-size: ".${$theme_tableau}['B01T']['deco_txt_fonte_size_min']."px ;\r
	margin: 0px;\r
	padding: 0px;\r
	}\r".
	$stylesheet
	;
break;
case "GDS_":
	$stylesheet = "<!--\r".
	$stylesheet_entete .
	$stylesheet_preload_text.
	$stylesheet_at_fontface.
	"@media screen {\r
	body {\r
	font-family: ".${$theme_tableau}['B01T']['deco_txt_fonte'].";\r
	font-size: ".${$theme_tableau}['B01T']['deco_txt_fonte_size_min']."px ;\r
	margin: 0px;\r
	padding: 0px;\r
	}\r".
	$stylesheet
	;
break;
case "theme_GP_":
case "theme_GD_":
	$stylesheet = "<style type='text/css'>\r <!--\r\r".
	$stylesheet_at_fontface."\r".
	"@media screen {\r\r".
	$stylesheet
	;
break;
}
$stylesheet .= "\r\r";


$pv['i'] = 0 ;
while ( $pv['i'] <= ( $_REQUEST['compteur_bloc_menu'] -1 ) ) {
	$_REQUEST['blocM'] = decoration_nomage_bloc ( "B", $pv['i'] , "M");
	$p = &${$theme_tableau}[$_REQUEST['blocM']];

	$pv['css_menu_div'] = "." . $theme_tableau_a_ecrire . "menu_niv_" . $p['niveau'] . ", ";
	$pv['css_menu_lnn'] = "." . $theme_tableau_a_ecrire . "menu_niv_" . $p['niveau'] . "_lien, ";
	$pv['css_menu_lnh'] = "." . $theme_tableau_a_ecrire . "menu_niv_" . $p['niveau'] . "_lien:hover, ";
	if ( isset ( $p['liste_niveaux'] ) ) {
		$p['liste_niveaux'] = substr ( $p['liste_niveaux'] , 0 , -1 );
		$pv['css_menu_div'] .= CDS_liste_bloc_element (  $theme_tableau_a_ecrire."menu_niv_" , $p['liste_niveaux'] , "" ); 
		$pv['css_menu_lnn'] .= CDS_liste_bloc_element (  ".".$theme_tableau_a_ecrire."menu_niv_" , $p['liste_niveaux'] , "_lien" ); 
		$pv['css_menu_lnh'] .= CDS_liste_bloc_element (  ".".$theme_tableau_a_ecrire."menu_niv_" , $p['liste_niveaux'] , "_lien:hover" ); 
	}
	else {
		$pv['css_menu_div'] = substr ( $pv['css_menu_div'] , 0 , -2 ) . " ";
		$pv['css_menu_lnn'] = substr ( $pv['css_menu_lnn'] , 0 , -2 ) . " ";
		$pv['css_menu_lnh'] = substr ( $pv['css_menu_lnh'] , 0 , -2 ) . " ";
	}

	$stylesheet .= $pv['css_menu_div'] . " { position: absolute; margin: 0px; padding: 0px ; border: 0px; }\r";
	$stylesheet .= $pv['css_menu_lnn'] . " { ";
	if ( strlen($p['deco_txt_fonte']) > 0 )				{ $stylesheet .= "font-family: ".$p['deco_txt_fonte'].";	"; }
	if ( strlen($p['deco_txt_l_01_fg_col']) > 0 )		{ $stylesheet .= "color: ".$p['deco_txt_l_01_fg_col'].";	"; }
	if ( strlen($p['deco_txt_l_01_bg_col']) > 0 )		{ $stylesheet .= "background-color: ".$p['deco_txt_l_01_bg_col'].";	"; }
	if ( $p['deco_txt_l_01_size'] != 0 )				{ $stylesheet .= "font-size: ".$p['deco_txt_l_01_size']."px;	"; }
	if ( strlen($p['deco_txt_l_01_weight']) > 0 )		{ $stylesheet .= "font-weight: ".$p['deco_txt_l_01_weight'].";	"; }
	if ( strlen($p['deco_txt_l_01_display']) > 0 )		{ $stylesheet .= "display: ".$p['deco_txt_l_01_display'].";	"; }
	if ( strlen($p['deco_txt_l_01_decoration']) > 0 )	{ $stylesheet .= "text-decoration: ".$p['deco_txt_l_01_decoration'].";	"; }
	if ( $p['deco_txt_l_01_margin_top'] > 0 )			{ $stylesheet .= "margin-top: ".$p['deco_txt_l_01_margin_top']."px;	"; }
	if ( $p['deco_txt_l_01_margin_bottom'] > 0 )		{ $stylesheet .= "margin-bottom: ".$p['deco_txt_l_01_margin_bottom']."px;	"; }
	if ( $p['deco_txt_l_01_margin_left'] > 0 )			{ $stylesheet .= "margin-left: ".$p['deco_txt_l_01_margin_left']."px;	"; }
	if ( $p['deco_txt_l_01_margin_right'] > 0 )			{ $stylesheet .= "margin-right: ".$p['deco_txt_l_01_margin_right']."px;	"; }
	//if ( $p['deco_a_line_height'] > 0 )					{ $stylesheet .= "line-height: ".$p['deco_a_line_height']."px;	"; } // Ne pas utiliser ici!!

	$stylesheet .= "}\r";

	$stylesheet_cadet = "";
	//if ( $p['deco_txt_l_01_hover_size'] != 0 )			{ $stylesheet_cadet .= "font-size: ".$p['deco_txt_l_01_hover_size']."px;	"; }
	if ( strlen($p['deco_txt_l_01_hover_weight']) > 0 )	{ $stylesheet_cadet .= "font-weight: ".$p['deco_txt_l_01_hover_weight'].";	"; }
	if ( strlen($p['deco_txt_l_01_fg_hover_col']) > 0 )	{ $stylesheet_cadet .= "color: ".$p['deco_txt_l_01_fg_hover_col'].";	"; }
	if ( strlen($p['deco_txt_l_01_bg_hover_col']) > 0 )	{ $stylesheet_cadet .= "background-color: ".$p['deco_txt_l_01_bg_hover_col'].";	"; }
	if ( strlen( $stylesheet_cadet ) > 0 )		{ $stylesheet .= $pv['css_menu_lnh'] ." { ".$stylesheet_cadet." }\r\r"; }

	$p['liste_bloc'] = $_REQUEST['blocG'] = $_REQUEST['blocT'] = $_REQUEST['blocM'];
	$p['liste_bloc_menu'] = substr ( $p['liste_bloc_menu'] , 0 , -1 );
	$p['liste_bloc'] = &$p['liste_bloc_menu'];
	switch ( $p['deco_type'] ) {
	case 30:	case "1_div":		include ("charge_donnees_theme_stylesheet-deco_30_1_div.php");		break;
	case 40:	case "elegance":	include ("charge_donnees_theme_stylesheet-deco_40_elegance.php");	break;
	case 50:	case "exquise":		include ("charge_donnees_theme_stylesheet-deco_50_exquise.php");	break;
	case 60:	case "elysion":		include ("charge_donnees_theme_stylesheet-deco_60_elysion.php");	break;
	}
	$pv['i']++;
}

$pv['styleFinCorp'] = "
	.".$theme_tableau_a_ecrire."modif_article	{ height:512px ; overflow:auto }\r
	.".$theme_tableau_a_ecrire."modif_categorie	{ height:512px ; overflow:auto }\r

	.".$theme_tableau_a_ecrire."div_AdminControlSwitch {	
		width: ". ${$theme_tableau}['theme_admctrl_size_x'] ."px; 
		height: ". ${$theme_tableau}['theme_admctrl_size_y'] ."px; 
		background-image: url(../graph/".$pv['theme_tmp_repertoire']."/". ${$theme_tableau}['theme_admctrl_switch_bg'] ."); 
		left: 0px;
		top: 0px;
		display: block;
		visibility: visible;
		background-position: center;
		background-repeat: repeat;
		position: fixed;
	}\r

	.".$theme_tableau_a_ecrire."div_AdminControlPanel {
		position: absolute; 
		top: ". floor( ${$theme_tableau}['theme_admctrl_size_y']/ 2 )."px; 
		left: ".floor( ${$theme_tableau}['theme_admctrl_size_x']/ 2 )."px; 
		border-style: solid; 
		border-width: 8px; 
		border-color: ".${$theme_tableau}['B01T']['deco_txt_avert_col']."; 
		margin : 0px;
		padding : 0px;
		background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".${$theme_tableau}['theme_admctrl_panel_bg'].");
		visibility: hidden; 
	}


	.".$theme_tableau_a_ecrire."div_SelecteurDeFichierConteneur {
		position: absolute; 
		border-style: solid; 
		border-width: 0px; 
		border-color: #000000; 
		margin : 0px;
		padding : 0px;
		background-image: url(../graph/universel/noir_50prct.png);
		visibility: hidden; display : none;
	}
	.".$theme_tableau_a_ecrire."div_SelecteurDeFichier {
		position: absolute; 
		border-style: solid; 
		border-width: 8px; 
		border-color: ".${$theme_tableau}['B01T']['deco_txt_avert_col']."; 
		margin : 0px;
		padding : 4px;
		background-image: url(../graph/".$pv['theme_tmp_repertoire']."/".${$theme_tableau}['B01T']['deco_bgco'].");
		visibility: hidden; display : none; 
	}

	.SdfTdDeco1 {
		border-style: solid;
		border-width : 0px 0px 0px 1px;
		border-color: ".${$theme_tableau}['B01T']['deco_txt_col'].";
		padding-left: 5px;
		padding-right: 5px;
		overflow:hidden;
	}

	.SdfTdDeco2 {
		border-style: solid;
		border-width : 0px 1px 0px 1px;
		border-color: ".${$theme_tableau}['B01T']['deco_txt_col'].";
		overflow:hidden;
	}

	.SdfTdDeco3 {
		border-style: solid;
		border-width : 0px 1px 0px 0px;
		border-color: ".${$theme_tableau}['B01T']['deco_txt_col'].";
		overflow:hidden;
	}


	.div_std {
	font-family: ".${$theme_tableau}[$_REQUEST['blocT']]['deco_txt_fonte'].";
	font-weight: normal;
	line-height: normal;
	color: ".${$theme_tableau}[$_REQUEST['blocT']]['deco_txt_col'].";
	text-align: left;
	letter-spacing : 0px;
	word-spacing : 0px;
	overflow: auto;
	}\r

	}\r	/* Media screen */

	@media print { BODY { font-size: ".${$theme_tableau}['B01T']['deco_txt_fonte_size_min']."pt; } }
	";
$pv['styleFinComm'] = "-->\r";
$pv['styleFinMark'] = "</style>\r";

switch ( $theme_tableau ) {
case "theme_princ_":	$stylesheet .= $pv['styleFinCorp'] .	$pv['styleFinComm'] . $pv['styleFinMark'];	break;
case "theme_GP_":
case "theme_GD_":		$stylesheet .= "}\r" .					$pv['styleFinComm'] . $pv['styleFinMark'];	break;
case "GDS_":			$stylesheet .= $pv['styleFinCorp'] .	$pv['styleFinComm'];						break;
}

//graph/universel/noir_50prct.png

if ( $site_web['sw_info_debug'] < 10 ) { 
	unset (
	$fonte_temp_,
	$p, 
	$pv, 
	$stylesheet_at_fontface,
	$stylesheet_preload,
	$stylesheet_preload_text
	);
}

?>
