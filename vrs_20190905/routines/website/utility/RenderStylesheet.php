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
class RenderStylesheet {
	private static $Instance = null;

	public function __construct() {}

	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new RenderStylesheet ();
		}
		return self::$Instance;
	}
	
	/**
	 * Reder the stylesheet based on the theme data.
	 * @param String $tableName
	 * @param Object $ThemeDataObj
	 * @return string
	 */
	public function render($tableName, $ThemeDataObj){
		$StringFormat = StringFormat::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$LMObj = LogManagement::getInstance();
		
		$logTarget = $LMObj->getInternalLogTarget();
		$LMObj->setInternalLogTarget("none");
		
// 		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$themeArray = $ThemeDataObj->getThemeData();
		$themeArray['tableName'] = $tableName;
		$TimeObj = Time::getInstance();
		
		$Content = "
<style type='text/css'>
<!--
/*
//----------------------------------------------------------------------------
// Hydr - Generated stylesheet
//----------------------------------------------------------------------------
// Theme : ".$themeArray['theme_nom']."
// Date : ".$TimeObj->timestampToDate(time())."
// fileName : ".$themeArray['theme_nom'].".css
//----------------------------------------------------------------------------
*/
";
		$blockIdList = &$themeArray['blockTFirstInLineId'];
		for ( $i = 1 ; $i <= $themeArray['blockTCount'] ; $i++ ) {
			$themeArray['currentBlock']	= $StringFormat->getDecorationBlockName( "B", $blockIdList[$i] , "");
			if ( is_array($themeArray[$themeArray['currentBlock']."T"]) ) {
				$Content .= $this->renderStylesheetDeco20($themeArray);
			}
		}
		
		$blockIdList = &$themeArray['blockGFirstInLineId'];
		for ( $i = 1 ; $i <= $themeArray['blockGCount'] ; $i++ ) {
			$themeArray['currentBlock']	= $StringFormat->getDecorationBlockName( "B", $blockIdList[$i] , "");
			$themeArray['currentBlockType'] = "G";
			if ( is_array($themeArray[$themeArray['currentBlock']."G"]) ) {
				switch ( $themeArray[$themeArray['currentBlock']."G"]['deco_type'] ) {
					case 30:	case "1_div":		$Content .= $this->renderStylesheetDeco30($themeArray);	break;
					case 40:	case "elegance":	$Content .= $this->renderStylesheetDeco40($themeArray);	break;
					case 50:	case "exquise":		$Content .= $this->renderStylesheetDeco50($themeArray);	break;
					case 60:	case "elysion":		$Content .= $this->renderStylesheetDeco60($themeArray);	break;
				}
			}
		}

		// --------------------------------------------------------------------------------
		//
		// Dedicated section for menu (which are an assembly of both text and graphical decoration type)
		//
		//
		$Content .= "\r\r\r";
		$blockIdList = &$themeArray['blockMFirstInLineId'];
		for ( $i = 1 ; $i <= $themeArray['blockMCount'] ; $i++ ) {
			$themeArray['currentBlock']	= $StringFormat->getDecorationBlockName( "B", $blockIdList[$i] , "");
			$themeArray['currentBlockType'] = "M";
			if ( is_array($themeArray[$themeArray['currentBlock']."M"]) ) {
				$p = &$themeArray[$themeArray['currentBlock']."M"];
				
				$css_menu_div = ".".$tableName."menu_niv_".$p['niveau'].", ";
				$css_menu_lnn = ".".$tableName."menu_niv_".$p['niveau']."_lien, ";
				$css_menu_lnh = ".".$tableName."menu_niv_".$p['niveau']."_lien:hover, ";
// 				$p['liste_bloc_bak'] = $p['liste_bloc'];
				if ( isset ( $p['liste_niveaux'] ) ) {
// 					$p['liste_niveaux'] = substr ( $p['liste_niveaux'] , 0 , -1 );
// 					$p['liste_bloc'] = $p['liste_niveaux'];
					$css_menu_div .= $this->makeCssLevelString ($themeArray, $themeArray['currentBlock']."M", ".".$tableName."menu_niv_", "" );
					$css_menu_lnn .= $this->makeCssLevelString ($themeArray, $themeArray['currentBlock']."M", ".".$tableName."menu_niv_", "_lien" );
					$css_menu_lnh .= $this->makeCssLevelString ($themeArray, $themeArray['currentBlock']."M", ".".$tableName."menu_niv_", "_lien:hover" );
				}
				$css_menu_div = substr ( $css_menu_div , 0 , -2 ) . " ";
				$css_menu_lnn = substr ( $css_menu_lnn , 0 , -2 ) . " ";
				$css_menu_lnh = substr ( $css_menu_lnh , 0 , -2 ) . " ";
				
				$Content .= $css_menu_div . " { position: absolute; margin: 0px; padding: 0px ; border: 0px; }\r";
				$Content .= $css_menu_lnn . " { ";
				if ( strlen($p['txt_fonte']) > 0 )				{ $Content .= "font-family: ".		$p['txt_fonte']					.";	"; }
				if ( strlen($p['txt_l_01_fg_col']) > 0 )		{ $Content .= "color: ".			$p['txt_l_01_fg_col']			.";	"; }
				if ( strlen($p['txt_l_01_bg_col']) > 0 )		{ $Content .= "background-color: ".	$p['txt_l_01_bg_col']			.";	"; }
				if ( $p['txt_l_01_size'] != 0 )					{ $Content .= "font-size: ".		$p['txt_l_01_size']				."px;	"; }
				if ( strlen($p['txt_l_01_weight']) > 0 )		{ $Content .= "font-weight: ".		$p['txt_l_01_weight']			.";	"; }
				if ( strlen($p['txt_l_01_display']) > 0 )		{ $Content .= "display: ".			$p['txt_l_01_display']			.";	"; }
				if ( strlen($p['txt_l_01_decoration']) > 0 )	{ $Content .= "text-decoration: ".	$p['txt_l_01_decoration']		.";	"; }
				if ( $p['txt_l_01_margin_top'] > 0 )			{ $Content .= "margin-top: ".		$p['txt_l_01_margin_top']		."px;	"; }
				if ( $p['txt_l_01_margin_bottom'] > 0 )			{ $Content .= "margin-bottom: ".	$p['txt_l_01_margin_bottom']	."px;	"; }
				if ( $p['txt_l_01_margin_left'] > 0 )			{ $Content .= "margin-left: ".		$p['txt_l_01_margin_left']		."px;	"; }
				if ( $p['txt_l_01_margin_right'] > 0 )			{ $Content .= "margin-right: ".		$p['txt_l_01_margin_right']		."px;	"; }
				//if ( $p['deco_a_line_height'] > 0 )					{ $stylesheet .= "line-height: ".$p['deco_a_line_height']."px;	"; } // Ne pas utiliser ici!!
				
				$Content .= "}\r";
				
				$maybeMoreContent = "";
				if ( strlen($p['txt_l_01_hover_weight']) > 0 )	{ $maybeMoreContent .= "font-weight: ".		$p['txt_l_01_hover_weight'].";	"; }
				if ( strlen($p['txt_l_01_fg_hover_col']) > 0 )	{ $maybeMoreContent .= "color: ".			$p['txt_l_01_fg_hover_col'].";	"; }
				if ( strlen($p['txt_l_01_bg_hover_col']) > 0 )	{ $maybeMoreContent .= "background-color: ".$p['txt_l_01_bg_hover_col'].";	"; }
				if ( strlen( $maybeMoreContent ) > 0 )		{ $Content .= $css_menu_lnh ." { ".$maybeMoreContent." }\r"; }
				
				switch ( $themeArray[$themeArray['currentBlock']."M"]['deco_type'] ) {
					case 30:	case "1_div":		$Content .= $this->renderStylesheetDeco30($themeArray);	break;
					case 40:	case "elegance":	$Content .= $this->renderStylesheetDeco40($themeArray);	break;
					case 50:	case "exquise":		$Content .= $this->renderStylesheetDeco50($themeArray);	break;
					case 60:	case "elysion":		$Content .= $this->renderStylesheetDeco60($themeArray);	break;
				}
				$Content .= "\r\r";
				
			}
		}
		
		
		
		
		// --------------------------------------------------------------------------------
		$Content .="

	.".$tableName."modif_article	{ height:512px ; overflow:auto }\r
	.".$tableName."modif_categorie	{ height:512px ; overflow:auto }\r

	.".$tableName."div_AdminControlSwitch {	
		width: ". $themeArray['theme_admctrl_size_x'] ."px; 
		height: ". $themeArray['theme_admctrl_size_y'] ."px; 
		background-image: url(../graph/".$themeArray['theme_repertoire']."/". $themeArray['theme_admctrl_switch_bg'] ."); 
		left: 0px;
		top: 0px;
		display: block;
		visibility: visible;
		background-position: center;
		background-repeat: repeat;
		position: fixed;
	}\r

	.".$tableName."div_AdminControlPanel {
		position: absolute; 
		top: ". floor( $themeArray['theme_admctrl_size_y']/ 2 )."px; 
		left: ".floor( $themeArray['theme_admctrl_size_x']/ 2 )."px; 
		border-style: solid; 
		border-width: 8px; 
		border-color: ".$themeArray['B01T']['txt_avert_col']."; 
		margin : 0px;
		padding : 0px;
		background-image: url(../graph/".$themeArray['theme_repertoire']."/".$themeArray['theme_admctrl_panel_bg'].");
		visibility: hidden; 
	}


	.".$tableName."div_SelecteurDeFichierConteneur {
		position: absolute; 
		border-style: solid; 
		border-width: 0px; 
		border-color: #000000; 
		margin : 0px;
		padding : 0px;
		background-image: url(../graph/universal/noir_50prct.png);
		visibility: hidden; display : none;
	}
	.".$tableName."div_SelecteurDeFichier {
		position: absolute; 
		border-style: solid; 
		border-width: 8px; 
		border-color: ".$themeArray['B01T']['txt_avert_col']."; 
		margin : 0px;
		padding : 4px;
		background-image: url(../graph/".$themeArray['theme_repertoire']."/".$themeArray['B01T']['bgco'].");
		visibility: hidden; display : none; 
		cursor: pointer;
	}

	.SdfTdDeco1 {
		border-style: solid;
		border-width : 0px 0px 0px 1px;
		border-color: ".$themeArray['B01T']['txt_col'].";
		padding-left: 5px;
		padding-right: 5px;
		overflow:hidden;
	}

	.SdfTdDeco2 {
		border-style: solid;
		border-width : 0px 1px 0px 1px;
		border-color: ".$themeArray['B01T']['txt_col'].";
		overflow:hidden;
	}

	.SdfTdDeco3 {
		border-style: solid;
		border-width : 0px 1px 0px 0px;
		border-color: ".$themeArray['B01T']['txt_col'].";
		overflow:hidden;
	}


	.div_std {
	font-family: ".$themeArray['B01T']['txt_fonte'].";
	font-weight: normal;
	line-height: normal;
	color: ".$themeArray['B01T']['txt_col'].";
	text-align: left;
	letter-spacing : 0px;
	word-spacing : 0px;
	overflow: auto;
	}\r

	\r	/* Media screen */


@media print { BODY { font-size: ".$themeArray['B01T']['txt_fonte_size_min']."pt; } }\r\r-->\r</style>\r";

		$LMObj->setInternalLogTarget($logTarget);
		return $Content;
		
	}
	
	
	private function renderStylesheetDeco20 (&$infos) {
		$p = &$infos[$infos['currentBlock']."T"];
		$fontSizeRange= $p['txt_fonte_size_max'] - $p['txt_fonte_size_min'];
		$fontCoef	= $fontSizeRange / 6;
		$fontSizeStart = $p['txt_fonte_size_min'];

		$Content = "";
		for ( $i=1; $i<=7; $i++) {
			$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], "T", "_t" .$i, "{ font-size: ".floor ($fontSizeStart + ($fontCoef*($i-1)))."px; font-family: ".$p['txt_fonte'] . "; letter-spacing : 0px; word-spacing : 0px; font-weight: normal; } \r");
			$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], "T", "_tb".$i, "{ font-size: ".floor ($fontSizeStart + ($fontCoef*($i-1)))."px; font-family: ".$p['txt_fonte'] . "; letter-spacing : 0px; word-spacing : 0px; font-weight: bold; } \r");
			$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], "T", "_th".$i, "{ font-size: ".floor ($fontSizeStart + ($fontCoef*($i-1)))."px; vertical-align: top; font-weight: normal;}\r");
		}

		$tabLink= array(
			"txt_l_01_size"			=>	( $p['txt_l_01_size'] != 0 )				? "font-size: "		.$p['txt_l_01_size']."px; "         : "",
			"txt_l_01_weight"		=>	( $p['txt_l_01_weight'] != "normal" )		? "font-weight: "	.$p['txt_l_01_weight']."px; "     : "",
			"txt_l_01_hover_size"	=>	( $p['txt_l_01_hover_size'] != 0 )			? "font-size: "		.$p['txt_l_01_hover_size']."px; "   : "",
			"txt_l_01_hover_weight"	=>	( $p['txt_l_01_hover_weight'] != "normal" )	? "font-weight: "	.$p['txt_l_01_hover_weight']."; " : "",

			"txt_l_ts_size"			=>	( $p['txt_l_td_size'] != 0 )				? "font-size: "		.$p['txt_l_td_size']."px; "         : "",
			"txt_l_ts_weight"		=>	( $p['txt_l_td_weight'] != "normal" )		? "font-weight: "	.$p['txt_l_td_weight']."px; "     : "",
			"txt_l_ts_hover_size"	=>	( $p['txt_l_td_hover_size'] != 0 )			? "font-size: "		.$p['txt_l_td_hover_size']."px; "   : "",
			"txt_l_ts_hover_weight"	=>	( $p['txt_l_td_hover_weight'] != "normal" )	? "font-weight: "	.$p['txt_l_td_hover_weight']."; " : "",

			"txt_l_01_hover_decoration"	=>	"text-decoration: ".$p['txt_l_01_hover_decoration']."; ",
			"txt_l_td_hover_decoration"	=>	"text-decoration: ".$p['txt_l_td_hover_decoration']."; ",
		);
		
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], "T", "_p", "{
			font-family: ".		$p['txt_fonte'].";
			text-indent: ".		$p['p_txt_indent']."px;
			text-align: ".		$p['p_txt_align'].";
			margin-top: ".		$p['p_mrg_top']."px;
			margin-bottom: ".	$p['p_mrg_bottom']."px;
			margin-left: ".		$p['p_mrg_left']."px;
			margin-right: ".	$p['p_mrg_right']."px;
			padding-top: ".		$p['p_pad_top']."px;
			padding-bottom: ".	$p['p_pad_bottom']."px;
			padding-left: ".	$p['p_pad_left']."px;
			padding-right: ".	$p['p_pad_right']."px;
			}\r"
		);
		
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_t_couleur_de_base",	" { color: ".$p['txt_col'] . "; } \r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_ft",					" { border-spacing: 0px; border: 0px;	empty-cells: show; vertical-align: middle; } \r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_ft1",				" { padding: 0px;	border: 0px;	width: ".$p['ft1_x']."px;	height: ".$p['ft_y']."px;	background-image: url(../graph/".$infos['theme_repertoire']."/".$p['ft1']."); } \r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_ft2",				" { padding: 0px;	border: 0px;								height: ".$p['ft_y']."px;	background-image: url(../graph/".$infos['theme_repertoire']."/".$p['ft2'].");	color: ".$p['txt_titre_col']."; } \r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_ft3",				" { padding: 0px;	border: 0px;	width: ".$p['ft3_x']."px;	height: ".$p['ft_y']."px;	background-image: url(../graph/".$infos['theme_repertoire']."/".$p['ft3']."); } \r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_fca",				" { padding: 5px ; vertical-align: top; background-image: url(../graph/".$infos['theme_repertoire']."/".$p['bgca'].");  color: ".$p['ca_txt_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_fcb",				" { padding: 5px ; vertical-align: top; background-image: url(../graph/".$infos['theme_repertoire']."/".$p['bgcb'].");  color: ".$p['cb_txt_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_fcc",				" { padding: 5px ; vertical-align: top; background-image: url(../graph/".$infos['theme_repertoire']."/".$p['bgcc'].");  color: ".$p['cc_txt_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_fcd",				" { padding: 5px ; vertical-align: top; background-image: url(../graph/".$infos['theme_repertoire']."/".$p['bgcd'].");  color: ".$p['cd_txt_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_fcta",				" { padding: 5px ; vertical-align: top; background-image: url(../graph/".$infos['theme_repertoire']."/".$p['bgcta']."); color: ".$p['cta_txt_col']."; }\r"); 
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_fctb",				" { padding: 5px ; vertical-align: top; background-image: url(../graph/".$infos['theme_repertoire']."/".$p['bgctb']."); color: ".$p['ctb_txt_col']."; }\r"); 
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_fcsa",				" { padding: 5px ; vertical-align: top; background-image: url(../graph/".$infos['theme_repertoire']."/".$p['bgcsa']."); color: ".$p['csa_txt_col']."; }\r"); 
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_fcsb",				" { padding: 5px ; vertical-align: top; background-image: url(../graph/".$infos['theme_repertoire']."/".$p['bgcsb']."); color: ".$p['csb_txt_col']."; }\r"); 
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_fco",				" { padding: 5px ; vertical-align: top; background-image: url(../graph/".$infos['theme_repertoire']."/".$p['bgco'].");  color: ".$p['co_txt_col']."; }\r\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_highlight",			" { color: ".$p['txt_highlight_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_code",				" { color: ".$p['txt_code_fg_col'].";		background-color: ".$p['txt_code_bg_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_ok", 				" { color: ".$p['txt_ok_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_avert",				" { color: ".$p['txt_avert_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_erreur",				" { color: ".$p['txt_erreur_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_fade", 				" { color: ".$p['txt_fade_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_form_1", 			" { color: ".$p['txt_input1_fg_col'].";		background-color: ".$p['txt_input1_bg_col']."; font-weight: normal;  }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_form_2", 			" { color: ".$p['txt_input2_fg_col'].";		background-color: ".$p['txt_input2_bg_col']."; font-weight: normal;  }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_up", 			" { color: ".$p['tab_up_txt_col'].";			background-color: ".$p['tab_up_txt_bg_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_down",			" { color: ".$p['tab_down_txt_col'].";		background-color: ".$p['tab_down_txt_bg_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_hover", 			" { color: ".$p['tab_hover_txt_col'].";		background-color: ".$p['tab_hover_txt_bg_col']."; }\r\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s1_n01",		" { width: ".$p['s1_01_x']."px;	height: ".$p['s1_01_y']."px; 									background-image: url(../graph/".$infos['theme_repertoire']."/".$p['s1_n01'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s1_txt_col'].";}\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s1_n02",		" { 							height: ".$p['s1_01_y']."px; background: transparent;			background-image: url(../graph/".$infos['theme_repertoire']."/".$p['s1_n02'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s1_txt_col'].	";		font-weight:".$p['s1_txt_weight'].";		text-shadow: ".$p['s1_txt_shadow'].";	}\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s1_n03",		" { width: ".$p['s1_03_x']."px;	height: ".$p['s1_01_y']."px; 									background-image: url(../graph/".$infos['theme_repertoire']."/".$p['s1_n03'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s1_txt_col'].";}\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s1_h01",		" { width: ".$p['s1_01_x']."px;	height: ".$p['s1_01_y']."px; 									background-image: url(../graph/".$infos['theme_repertoire']."/".$p['s1_h01'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s1_txt_hover_col'].";}\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s1_h02",		" { 							height: ".$p['s1_01_y']."px; background: transparent;			background-image: url(../graph/".$infos['theme_repertoire']."/".$p['s1_h02'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s1_txt_hover_col'].";	font-weight:".$p['s1_txt_hover_weight'].";	text-shadow: ".$p['s1_txt_hover_shadow'].";	}\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s1_h03",		" { width: ".$p['s1_03_x']."px;	height: ".$p['s1_01_y']."px; 									background-image: url(../graph/".$infos['theme_repertoire']."/".$p['s1_h03'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s1_txt_hover_col'].";}\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s2_n01",		" { width: ".$p['s2_01_x']."px;	height: ".$p['s2_01_y']."px; 									background-image: url(../graph/".$infos['theme_repertoire']."/".$p['s2_n01'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s2_txt_col'].";}\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s2_n02",		" { 							height: ".$p['s2_01_y']."px; background: transparent;			background-image: url(../graph/".$infos['theme_repertoire']."/".$p['s2_n02'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s2_txt_col'].";		font-weight:".$p['s2_txt_weight'].";		text-shadow: ".$p['s2_txt_shadow'].";	}\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s2_n03",		" { width: ".$p['s2_03_x']."px;	height: ".$p['s2_01_y']."px; 									background-image: url(../graph/".$infos['theme_repertoire']."/".$p['s2_n03'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s2_txt_col'].";}\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s2_h01",		" { width: ".$p['s2_01_x']."px;	height: ".$p['s2_01_y']."px; 									background-image: url(../graph/".$infos['theme_repertoire']."/".$p['s2_h01'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s2_txt_hover_col'].";}\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s2_h02",		" { 							height: ".$p['s2_01_y']."px; background: transparent;			background-image: url(../graph/".$infos['theme_repertoire']."/".$p['s2_h02'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s2_txt_hover_col'].";	font-weight:".$p['s2_txt_hover_weight'].";	text-shadow: ".$p['s2_txt_hover_shadow'].";	}\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s2_h03",		" { width: ".$p['s2_03_x']."px;	height: ".$p['s2_01_y']."px; 									background-image: url(../graph/".$infos['theme_repertoire']."/".$p['s2_h03'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s2_txt_hover_col'].";}\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s3_n01",		" { width: ".$p['s3_01_x']."px;	height: ".$p['s3_01_y']."px; 									background-image: url(../graph/".$infos['theme_repertoire']."/".$p['s3_n01'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s3_txt_col'].";}\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s3_n02",		" { 							height: ".$p['s3_01_y']."px; background: transparent;			background-image: url(../graph/".$infos['theme_repertoire']."/".$p['s3_n02'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s3_txt_col'].";		font-weight:".$p['s3_txt_weight'].";		text-shadow: ".$p['s3_txt_shadow'].";	}\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s3_n03",		" { width: ".$p['s3_03_x']."px;	height: ".$p['s3_01_y']."px; 									background-image: url(../graph/".$infos['theme_repertoire']."/".$p['s3_n03'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s3_txt_col'].";}\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s3_h01",		" { width: ".$p['s3_01_x']."px;	height: ".$p['s3_01_y']."px; 									background-image: url(../graph/".$infos['theme_repertoire']."/".$p['s3_h01'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s3_txt_hover_col'].";}\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s3_h02",		" { 									height: ".$p['s3_01_y']."px; background: transparent;	background-image: url(../graph/".$infos['theme_repertoire']."/".$p['s3_h02'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s3_txt_hover_col'].";	font-weight:".$p['s3_txt_hover_weight'].";	text-shadow: ".$p['s3_txt_hover_shadow'].";	}\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s3_h03",		" { width: ".$p['s3_03_x']."px;	height: ".$p['s3_01_y']."px; 									background-image: url(../graph/".$infos['theme_repertoire']."/".$p['s3_h03'].");	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s3_txt_hover_col'].";}\r\r");
		$Content .= $this->makeCssIdString ($infos, "a.",		$infos['currentBlock'], "T", "_lien",				" { text-decoration: ".$p['txt_l_01_decoration']."; display: ".$p['txt_l_01_display'].";}\r	");
		$Content .= $this->makeCssIdString ($infos, "a.",		$infos['currentBlock'], "T", "_lien:link",			" { color: ".$p['txt_l_01_fg_col'].";				background-color: ".$p['txt_l_01_bg_col']."; ".$tabLink['txt_l_01_size'].$tabLink['txt_l_01_weight']." margin-top:".$p['txt_l_01_margin_top']."px; margin-bottom:".$p['txt_l_01_margin_bottom']."px; margin-left:".$p['txt_l_01_margin_left']."px; margin-right:".$p['txt_l_01_margin_right']."px; }\r");
		$Content .= $this->makeCssIdString ($infos, "a.",		$infos['currentBlock'], "T", "_lien:visited",		" { color: ".$p['txt_l_01_fg_visite_col'].";		background-color: ".$p['txt_l_01_bg_visite_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, "a.",		$infos['currentBlock'], "T", "_lien:hover",			" { color: ".$p['txt_l_01_fg_hover_col'].";			background-color: ".$p['txt_l_01_bg_hover_col']."; ".$tabLink['txt_l_01_hover_size'].$tabLink['txt_l_01_hover_weight'].$tabLink['txt_l_01_hover_decoration']." }\r\r");
		$Content .= $this->makeCssIdString ($infos, "a.",		$infos['currentBlock'], "T", "_lien:active",		" { color: ".$p['txt_l_01_fg_active_col'].";		background-color: ".$p['txt_l_01_bg_active_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, "td>a.",	$infos['currentBlock'], "T", "_lien",				" { text-decoration: ".$p['txt_l_td_decoration']."; display: ".$p['txt_l_td_display'].";}\r	");
		$Content .= $this->makeCssIdString ($infos, "td>a.",	$infos['currentBlock'], "T", "_lien:link",			" { color: ".$p['txt_l_td_fg_col'].";				background-color: ".$p['txt_l_td_bg_col']."; ".$tabLink['txt_l_td_size'].$tabLink['txt_l_td_weight']." margin-top:".$p['txt_l_td_margin_top']."px; margin-bottom:".$p['txt_l_td_margin_bottom']."px; margin-left:".$p['txt_l_td_margin_left']."px; margin-right:".$p['txt_l_td_margin_right']."px; }\r");
		$Content .= $this->makeCssIdString ($infos, "td>a.",	$infos['currentBlock'], "T", "_lien:visited",		" { color: ".$p['txt_l_td_fg_visite_col'].";		background-color: ".$p['txt_l_td_bg_visite_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, "td>a.",	$infos['currentBlock'], "T", "_lien:hover",			" { color: ".$p['txt_l_td_fg_hover_col'].";			background-color: ".$p['txt_l_td_bg_hover_col']."; ".$tabLink['txt_l_td_hover_size'].$tabLink['txt_l_td_hover_weight'].$tabLink['txt_l_td_hover_decoration']." }\r\r");
		$Content .= $this->makeCssIdString ($infos, "td>a.",	$infos['currentBlock'], "T", "_lien:active",		" { color: ".$p['txt_l_td_fg_active_col'].";		background-color: ".$p['txt_l_td_bg_active_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, "td>.",		$infos['currentBlock'], "T", "_form_1",				" { font-weight: normal; color: ".$p['txt_input1_td_fg_col']."; background-color: ".$p['txt_input1_td_bg_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, "td>.",		$infos['currentBlock'], "T", "_form_2",				" { font-weight: normal; color: ".$p['txt_input2_td_fg_col']."; background-color: ".$p['txt_input2_td_bg_col']."; }\r\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_down_a",			" { background-image: url(../graph/".$infos['theme_repertoire']."/".$p['tab_down_a'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;	width: ".$p['tab_a_x']."px;	height: ".$p['tab_y']."px;	background-position: top left;	background-repeat : no-repeat;	overflow:hidden;	text-align: center;	color: ".$p['tab_down_txt_col'].";																									background-color: ".$p['tab_down_txt_bg_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_down_b",			" { background-image: url(../graph/".$infos['theme_repertoire']."/".$p['tab_down_b'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;								height: ".$p['tab_y']."px;	background-position: top left;	background-repeat : repeat-x;	overflow:hidden;	text-align: center;	color: ".$p['tab_down_txt_col'].";	font-weight: ".$p['tab_down_txt_weight'].";		text-shadow : ".$p['tab_down_txt_shadow'].";	background-color: ".$p['tab_down_txt_bg_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_down_c",			" { background-image: url(../graph/".$infos['theme_repertoire']."/".$p['tab_down_c'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;	width: ".$p['tab_c_x']."px;	height: ".$p['tab_y']."px;	background-position: top left;	background-repeat : no-repeat;	overflow:hidden;	text-align: center;	color: ".$p['tab_down_txt_col'].";																									background-color: ".$p['tab_down_txt_bg_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_up_a",			" { background-image: url(../graph/".$infos['theme_repertoire']."/".$p['tab_up_a'].");		padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;	width: ".$p['tab_a_x']."px;	height: ".$p['tab_y']."px;	background-position: top left;	background-repeat : no-repeat;	overflow:hidden;	text-align: center;	color: ".$p['tab_up_txt_col'].";																									background-color: ".$p['tab_up_txt_bg_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_up_b",			" { background-image: url(../graph/".$infos['theme_repertoire']."/".$p['tab_up_b'].");		padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;								height: ".$p['tab_y']."px;	background-position: top left;	background-repeat : repeat-x;	overflow:hidden;	text-align: center;	color: ".$p['tab_up_txt_col'].";	font-weight: ".$p['tab_up_txt_weight'].";		text-shadow : ".$p['tab_up_txt_shadow'].";		background-color: ".$p['tab_up_txt_bg_col']."; }\r" );
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_up_c",			" { background-image: url(../graph/".$infos['theme_repertoire']."/".$p['tab_up_c'].");		padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;	width: ".$p['tab_c_x']."px;	height: ".$p['tab_y']."px;	background-position: top left;	background-repeat : no-repeat;	overflow:hidden;	text-align: center;	color: ".$p['tab_up_txt_col'].";																									background-color: ".$p['tab_up_txt_bg_col']."; }\r" );
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_hover_a",		" { background-image: url(../graph/".$infos['theme_repertoire']."/".$p['tab_hover_a'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;	width: ".$p['tab_a_x']."px;	height: ".$p['tab_y']."px;	background-position: top left;	background-repeat : no-repeat;	overflow:hidden;	text-align: center;	color: ".$p['tab_hover_txt_col'].";																									background-color: ".$p['tab_hover_txt_bg_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_hover_b",		" { background-image: url(../graph/".$infos['theme_repertoire']."/".$p['tab_hover_b'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;								height: ".$p['tab_y']."px;	background-position: top left;	background-repeat : repeat-x;	overflow:hidden;	text-align: center;	color: ".$p['tab_hover_txt_col'].";	font-weight: ".$p['tab_hover_txt_weight'].";	text-shadow : ".$p['tab_hover_txt_shadow'].";	background-color: ".$p['tab_hover_txt_bg_col']."; }\r");
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_hover_c",		" { background-image: url(../graph/".$infos['theme_repertoire']."/".$p['tab_hover_c'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;	width: ".$p['tab_c_x']."px;	height: ".$p['tab_y']."px;	background-position: top left;	background-repeat : no-repeat;	overflow:hidden;	text-align: center;	color: ".$p['tab_hover_txt_col'].";																									background-color: ".$p['tab_hover_txt_bg_col']."; }\r\r");
		
		return "\r".$Content;
	}
	
	private function renderStylesheetDeco30 (&$infos) {
		return $Content;
	}
	
	private function renderStylesheetDeco40 (&$infos) {
		$type = $infos['currentBlockType'];
		$p = &$infos[$infos['currentBlock'].$type];
		$Content = "";
		$dir = $infos['theme_repertoire'];
		if ( strlen($p['repertoire']) != 0 ) { $dir = $p['repertoire']; }
		if ( $p['a_line_height'] > 0 ) { $supLH = "; line-height: ". $p['a_line_height']."px;"; }
	
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex11", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex11'].");	background-position:".str_replace('-', ' ', $p['ex11_bgp']).";	vertical-align: bottom;	width: ".$p['ex11_x']."px;	height: ".$p['ex11_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex12", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex12'].");	background-position:".str_replace('-', ' ', $p['ex12_bgp']).";	vertical-align: bottom;	width: ".$p['ex12_x']."px;	height: ".$p['ex12_y']."px;		background-repeat : repeat-x;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex13", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex13'].");	background-position:".str_replace('-', ' ', $p['ex13_bgp']).";	vertical-align: bottom;								height: ".$p['ex13_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex21", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex21'].");	background-position:".str_replace('-', ' ', $p['ex21_bgp']).";	vertical-align: bottom;	width: ".$p['ex21_x']."px;	height: ".$p['ex21_y']."px;		background-repeat : repeat-y;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex22", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex22'].");	background-position:".str_replace('-', ' ', $p['ex22_bgp']).";	vertical-align: bottom;	width: ".$p['ex22_x']."px;									background-repeat : repeat;		overflow:hidden".$supLH."}\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex23", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex23'].");	background-position:".str_replace('-', ' ', $p['ex23_bgp']).";	vertical-align: bottom;	width: ".$p['ex23_x']."px;	height: ".$p['ex23_y']."px;		background-repeat : repeat-y;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex31", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex31'].");	background-position:".str_replace('-', ' ', $p['ex31_bgp']).";	vertical-align: bottom;	width: ".$p['ex31_x']."px;	height: ".$p['ex31_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex32", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex32'].");	background-position:".str_replace('-', ' ', $p['ex32_bgp']).";	vertical-align: bottom;	width: ".$p['ex32_x']."px;	height: ".$p['ex32_y']."px;		background-repeat : repeat-x;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex33", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex33'].");	background-position:".str_replace('-', ' ', $p['ex33_bgp']).";	vertical-align: bottom;	width: ".$p['ex33_x']."px;	height: ".$p['ex33_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		return "\r".$Content;
	}
	
	private function renderStylesheetDeco50 (&$infos) {
		$type = $infos['currentBlockType'];
		$p = &$infos[$infos['currentBlock'].$type];
		$Content = "";
		$dir = $infos['theme_repertoire'];
		if ( strlen($p['repertoire']) != 0 ) { $dir = $p['repertoire']; }
		if ( $p['a_line_height'] > 0 ) { $supLH = "; line-height: ". $p['a_line_height']."px;"; }
		
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex11", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex11'].");	background-position:".str_replace('-', ' ', $p['ex11_bgp']).";	vertical-align: bottom;	width: ".$p['ex11_x']."px;	height: ".$p['ex11_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex12", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex12'].");	background-position:".str_replace('-', ' ', $p['ex12_bgp']).";	vertical-align: bottom;	width: ".$p['ex12_x']."px;	height: ".$p['ex12_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex13", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex13'].");	background-position:".str_replace('-', ' ', $p['ex13_bgp']).";	vertical-align: bottom;								height: ".$p['ex13_y']."px;		background-repeat : repeat-x;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex14", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex14'].");	background-position:".str_replace('-', ' ', $p['ex14_bgp']).";	vertical-align: bottom;	width: ".$p['ex14_x']."px;	height: ".$p['ex14_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex15", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex15'].");	background-position:".str_replace('-', ' ', $p['ex15_bgp']).";	vertical-align: bottom;	width: ".$p['ex15_x']."px;	height: ".$p['ex15_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex21", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex21'].");	background-position:".str_replace('-', ' ', $p['ex21_bgp']).";	vertical-align: bottom;	width: ".$p['ex21_x']."px;	height: ".$p['ex21_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex22", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex22'].");	background-position:".str_replace('-', ' ', $p['ex22_bgp']).";	vertical-align: bottom;	width: ".$p['ex22_x']."px;									background-repeat : repeat;		overflow:hidden".$supLH."}\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex25", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex25'].");	background-position:".str_replace('-', ' ', $p['ex25_bgp']).";	vertical-align: bottom;	width: ".$p['ex25_x']."px;	height: ".$p['ex25_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex31", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex31'].");	background-position:".str_replace('-', ' ', $p['ex31_bgp']).";	vertical-align: bottom;	width: ".$p['ex31_x']."px;	height: ".$p['ex31_y']."px;		background-repeat : repeat-y;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex35", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex35'].");	background-position:".str_replace('-', ' ', $p['ex35_bgp']).";	vertical-align: bottom;	width: ".$p['ex35_x']."px;	height: ".$p['ex35_y']."px;		background-repeat : repeat-y;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex41", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex41'].");	background-position:".str_replace('-', ' ', $p['ex41_bgp']).";	vertical-align: bottom;	width: ".$p['ex41_x']."px;	height: ".$p['ex41_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex45", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex45'].");	background-position:".str_replace('-', ' ', $p['ex45_bgp']).";	vertical-align: bottom;	width: ".$p['ex45_x']."px;	height: ".$p['ex45_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex51", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex51'].");	background-position:".str_replace('-', ' ', $p['ex51_bgp']).";	vertical-align: bottom;	width: ".$p['ex51_x']."px;	height: ".$p['ex51_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex52", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex52'].");	background-position:".str_replace('-', ' ', $p['ex52_bgp']).";	vertical-align: bottom;	width: ".$p['ex52_x']."px;	height: ".$p['ex52_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex53", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex53'].");	background-position:".str_replace('-', ' ', $p['ex53_bgp']).";	vertical-align: bottom;								height: ".$p['ex53_y']."px;		background-repeat : repeat-x;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex54", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex54'].");	background-position:".str_replace('-', ' ', $p['ex54_bgp']).";	vertical-align: bottom;	width: ".$p['ex54_x']."px;	height: ".$p['ex54_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex55", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex55'].");	background-position:".str_replace('-', ' ', $p['ex55_bgp']).";	vertical-align: bottom;	width: ".$p['ex55_x']."px;	height: ".$p['ex55_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		return "\r".$Content;
	}
	
	private function renderStylesheetDeco60 (&$infos) {
		$type = $infos['currentBlockType'];
		$p = &$infos[$infos['currentBlock'].$type];
		$Content = "";
		$dir = $infos['theme_repertoire'];
		if ( strlen($p['repertoire']) != 0 ) { $dir = $p['repertoire']; }
		if ( $p['a_line_height'] > 0 ) { $supLH = "; line-height: ". $p['a_line_height']."px;"; }
		
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex11", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex11'].");	background-position:".str_replace('-', ' ', $p['ex11_bgp']).";	vertical-align: bottom;	width: ".$p['ex11_x']."px;	height: ".$p['ex11_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex12", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex12'].");	background-position:".str_replace('-', ' ', $p['ex12_bgp']).";	vertical-align: bottom;	width: ".$p['ex12_x']."px;	height: ".$p['ex12_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex13", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex13'].");	background-position:".str_replace('-', ' ', $p['ex13_bgp']).";	vertical-align: bottom;								height: ".$p['ex13_y']."px;		background-repeat : repeat-x;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex14", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex14'].");	background-position:".str_replace('-', ' ', $p['ex14_bgp']).";	vertical-align: bottom;	width: ".$p['ex14_x']."px;	height: ".$p['ex14_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex15", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex15'].");	background-position:".str_replace('-', ' ', $p['ex15_bgp']).";	vertical-align: bottom;	width: ".$p['ex15_x']."px;	height: ".$p['ex15_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex21", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex21'].");	background-position:".str_replace('-', ' ', $p['ex21_bgp']).";	vertical-align: bottom;	width: ".$p['ex21_x']."px;	height: ".$p['ex21_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex22", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex22'].");	background-position:".str_replace('-', ' ', $p['ex22_bgp']).";	vertical-align: bottom;	width: ".$p['ex22_x']."px;									background-repeat : repeat;		overflow:hidden".$supLH."}\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex25", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex25'].");	background-position:".str_replace('-', ' ', $p['ex25_bgp']).";	vertical-align: bottom;	width: ".$p['ex25_x']."px;	height: ".$p['ex25_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex31", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex31'].");	background-position:".str_replace('-', ' ', $p['ex31_bgp']).";	vertical-align: bottom;	width: ".$p['ex31_x']."px;	height: ".$p['ex31_y']."px;		background-repeat : repeat-y;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex35", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex35'].");	background-position:".str_replace('-', ' ', $p['ex35_bgp']).";	vertical-align: bottom;	width: ".$p['ex35_x']."px;	height: ".$p['ex35_y']."px;		background-repeat : repeat-y;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex41", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex41'].");	background-position:".str_replace('-', ' ', $p['ex41_bgp']).";	vertical-align: bottom;	width: ".$p['ex41_x']."px;	height: ".$p['ex41_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex45", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex45'].");	background-position:".str_replace('-', ' ', $p['ex45_bgp']).";	vertical-align: bottom;	width: ".$p['ex45_x']."px;	height: ".$p['ex45_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex51", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex51'].");	background-position:".str_replace('-', ' ', $p['ex51_bgp']).";	vertical-align: bottom;	width: ".$p['ex51_x']."px;	height: ".$p['ex51_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex52", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex52'].");	background-position:".str_replace('-', ' ', $p['ex52_bgp']).";	vertical-align: bottom;	width: ".$p['ex52_x']."px;	height: ".$p['ex52_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex53", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex53'].");	background-position:".str_replace('-', ' ', $p['ex53_bgp']).";	vertical-align: bottom;								height: ".$p['ex53_y']."px;		background-repeat : repeat-x;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex54", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex54'].");	background-position:".str_replace('-', ' ', $p['ex54_bgp']).";	vertical-align: bottom;	width: ".$p['ex54_x']."px;	height: ".$p['ex54_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex55", " { position: absolute; background-image: url(../graph/".$dir."/".$p['ex55'].");	background-position:".str_replace('-', ' ', $p['ex55_bgp']).";	vertical-align: bottom;	width: ".$p['ex55_x']."px;	height: ".$p['ex55_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");

		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in11", " { position: absolute; background-image: url(../graph/".$dir."/".$p['in11'].");	background-position:".str_replace('-', ' ', $p['in11_bgp']).";	vertical-align: bottom;	width: ".$p['in11_x']."px;	height: ".$p['in11_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in12", " { position: absolute; background-image: url(../graph/".$dir."/".$p['in12'].");	background-position:".str_replace('-', ' ', $p['in12_bgp']).";	vertical-align: bottom;	width: ".$p['in12_x']."px;	height: ".$p['in12_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in13", " { position: absolute; background-image: url(../graph/".$dir."/".$p['in13'].");	background-position:".str_replace('-', ' ', $p['in13_bgp']).";	vertical-align: bottom;	width: ".$p['in13_x']."px;	height: ".$p['in13_y']."px;		background-repeat : repeat-x;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in14", " { position: absolute; background-image: url(../graph/".$dir."/".$p['in14'].");	background-position:".str_replace('-', ' ', $p['in14_bgp']).";	vertical-align: bottom;	width: ".$p['in14_x']."px;	height: ".$p['in14_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in15", " { position: absolute; background-image: url(../graph/".$dir."/".$p['in15'].");	background-position:".str_replace('-', ' ', $p['in15_bgp']).";	vertical-align: bottom;	width: ".$p['in15_x']."px;	height: ".$p['in15_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in21", " { position: absolute; background-image: url(../graph/".$dir."/".$p['in21'].");	background-position:".str_replace('-', ' ', $p['in21_bgp']).";	vertical-align: bottom;	width: ".$p['in21_x']."px;	height: ".$p['in21_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in25", " { position: absolute; background-image: url(../graph/".$dir."/".$p['in25'].");	background-position:".str_replace('-', ' ', $p['in25_bgp']).";	vertical-align: bottom;	width: ".$p['in25_x']."px;	height: ".$p['in25_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in31", " { position: absolute; background-image: url(../graph/".$dir."/".$p['in31'].");	background-position:".str_replace('-', ' ', $p['in31_bgp']).";	vertical-align: bottom;	width: ".$p['in31_x']."px;	height: ".$p['in31_y']."px;		background-repeat : repeat-y;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in35", " { position: absolute; background-image: url(../graph/".$dir."/".$p['in35'].");	background-position:".str_replace('-', ' ', $p['in35_bgp']).";	vertical-align: bottom;	width: ".$p['in35_x']."px;	height: ".$p['in35_y']."px;		background-repeat : repeat-y;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in41", " { position: absolute; background-image: url(../graph/".$dir."/".$p['in41'].");	background-position:".str_replace('-', ' ', $p['in41_bgp']).";	vertical-align: bottom;	width: ".$p['in41_x']."px;	height: ".$p['in41_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in45", " { position: absolute; background-image: url(../graph/".$dir."/".$p['in45'].");	background-position:".str_replace('-', ' ', $p['in45_bgp']).";	vertical-align: bottom;	width: ".$p['in45_x']."px;	height: ".$p['in45_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in51", " { position: absolute; background-image: url(../graph/".$dir."/".$p['in51'].");	background-position:".str_replace('-', ' ', $p['in51_bgp']).";	vertical-align: bottom;	width: ".$p['in51_x']."px;	height: ".$p['in51_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in52", " { position: absolute; background-image: url(../graph/".$dir."/".$p['in52'].");	background-position:".str_replace('-', ' ', $p['in52_bgp']).";	vertical-align: bottom;	width: ".$p['in52_x']."px;	height: ".$p['in52_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in53", " { position: absolute; background-image: url(../graph/".$dir."/".$p['in53'].");	background-position:".str_replace('-', ' ', $p['in53_bgp']).";	vertical-align: bottom;	width: ".$p['in53_x']."px;	height: ".$p['in53_y']."px;		background-repeat : repeat-x;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in54", " { position: absolute; background-image: url(../graph/".$dir."/".$p['in54'].");	background-position:".str_replace('-', ' ', $p['in54_bgp']).";	vertical-align: bottom;	width: ".$p['in54_x']."px;	height: ".$p['in54_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in55", " { position: absolute; background-image: url(../graph/".$dir."/".$p['in55'].");	background-position:".str_replace('-', ' ', $p['in55_bgp']).";	vertical-align: bottom;	width: ".$p['in55_x']."px;	height: ".$p['in55_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		return "\r".$Content;
	}
	
	private function makeCssIdString (&$infos, $prefix, $block, $type, $suffix, $css) {
		$p = explode( " ", trim($block." ".$infos[$block.$type]['liste_bloc']) ); // trim removes the last space in the string
		$str = "";
		if ($type != "M") { $type = "";}
		foreach ($p as $A) { $str .= $prefix.$infos['tableName'].$A.$type.$suffix.", ";}
		$str = substr ( $str , 0 , -2 )." ".$css;
		return $str;
	}

	private function makeCssLevelString(&$infos, $block, $prefix, $suffix) {
		$p = explode( " ", trim($infos[$block]['liste_niveaux']) ); // trim removes the last space in the string
		$str = "";
		foreach ($p as $A) { $str .= $prefix.$A.$suffix.", "; }
		return $str;
		
	}
	

}
?>
