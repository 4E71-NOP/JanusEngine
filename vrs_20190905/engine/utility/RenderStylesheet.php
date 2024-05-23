<?php
/*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/
class RenderStylesheet {
	private static $Instance = null;
	private $ThemeDataObj = null;
	// private $themeDefinitionArray = null;

	public function __construct() {}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return RenderStylesheet
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new RenderStylesheet ();
		}
		return self::$Instance;
	}
	
	/**
	 * Render the stylesheet based on the theme data.
	 * @param String $tableName
	 * @param Object $ThemeDataObj
	 * @return string
	 */
	public function render($tableName, $ThemeDataObj){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$this->ThemeDataObj = $ThemeDataObj;
		$themeArray = $ThemeDataObj->getThemeData();
		$themeArray['tableName'] = $tableName;
		
		$baseUrl  = $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url');
		$Content = "
<style type='text/css'>
<!--
/*
//----------------------------------------------------------------------------
// Hydr - Generated stylesheet
//----------------------------------------------------------------------------
// Theme : ".$themeArray['theme_name']."
// Date : ".$bts->TimeObj->timestampToDate(time())."
// fileName : ".$themeArray['theme_name'].".css
//----------------------------------------------------------------------------
*/
html { width:100%; height:100%;}\r\r
";
		$blockIdList = &$themeArray['blockTFirstInLineId'];
		for ( $i = 1 ; $i <= $themeArray['blockTCount'] ; $i++ ) {
			$themeArray['currentBlock']	= $bts->StringFormatObj->getDecorationBlockName( "B", $blockIdList[$i] , "");
			if ( is_array($themeArray[$themeArray['currentBlock']."T"]) ) {
				$Content .= $this->renderStylesheetDeco20($themeArray);
			}
		}
		
		$blockIdList = &$themeArray['blockGFirstInLineId'];
		for ( $i = 1 ; $i <= $themeArray['blockGCount'] ; $i++ ) {
			$themeArray['currentBlock']	= $bts->StringFormatObj->getDecorationBlockName( "B", $blockIdList[$i] , "");
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
			$themeArray['currentBlock']	= $bts->StringFormatObj->getDecorationBlockName( "B", $blockIdList[$i] , "");
			$themeArray['currentBlockType'] = "M";
			if ( is_array($themeArray[$themeArray['currentBlock']."M"]) ) {
				$p = &$themeArray[$themeArray['currentBlock']."M"];
				
				$css_menu_div = ".".$tableName."menu_lvl_".$p['level'].", ";
				$css_menu_lnn = ".".$tableName."menu_lvl_".$p['level']."_link, ";
				$css_menu_lnh = ".".$tableName."menu_lvl_".$p['level']."_link:hover, ";
				$css_menu_lna = ".".$tableName."menu_lvl_".$p['level']."_link:active, ";
				$css_menu_lnv = ".".$tableName."menu_lvl_".$p['level']."_link:visited, ";
				if ( isset ( $p['levelList'] ) ) {
					$css_menu_div .= $this->makeCssLevelString ($themeArray, $themeArray['currentBlock']."M", ".".$tableName."menu_lvl_", "" );
					$css_menu_lnn .= $this->makeCssLevelString ($themeArray, $themeArray['currentBlock']."M", ".".$tableName."menu_lvl_", "_link" );
					$css_menu_lnh .= $this->makeCssLevelString ($themeArray, $themeArray['currentBlock']."M", ".".$tableName."menu_lvl_", "_link:hover" );
					$css_menu_lna .= $this->makeCssLevelString ($themeArray, $themeArray['currentBlock']."M", ".".$tableName."menu_lvl_", "_link:active" );
					$css_menu_lnv .= $this->makeCssLevelString ($themeArray, $themeArray['currentBlock']."M", ".".$tableName."menu_lvl_", "_link:visited" );
				}
				$css_menu_div = substr ( $css_menu_div , 0 , -2 ) . " ";
				$css_menu_lnn = substr ( $css_menu_lnn , 0 , -2 ) . " ";
				$css_menu_lnh = substr ( $css_menu_lnh , 0 , -2 ) . " ";
				$css_menu_lna = substr ( $css_menu_lna , 0 , -2 ) . " ";
				$css_menu_lnv = substr ( $css_menu_lnv , 0 , -2 ) . " ";
				
				$Content .= $css_menu_div . " { position: absolute; margin: 0px; padding: 0px ; border: 0px; }\r";
				$Content .= $css_menu_lnn . " { ";
				$maybeMoreContent = "";
				if ( strlen($p['txt_font_family'] ?? '') > 0 )		{ $Content .= "font-family:".		$p['txt_font_family']	.";	"; }
				if ( strlen($p['a_fg_col'] ?? '') > 0 )				{ $Content .= "color:".				$p['a_fg_col']			.";	"; }
				if ( strlen($p['a_bg_col'] ?? '') > 0 )				{ $Content .= "background-color:".	$p['a_bg_col']			.";	"; }
				if ( strlen($p['a_decoration'] ?? '') > 0 )			{ $Content .= "text-decoration:".	$p['a_decoration']		.";	"; }
				if ( strlen($p['a_special'] ?? '') > 0 )			{ $Content .= 						$p['a_special']; }
				$Content .= "}\r";
				
				$maybeMoreContent = "";
				if ( strlen($p['a_hover_fg_col'] ?? '') > 0 )		{ $maybeMoreContent .= "color:".			$p['a_hover_fg_col']		.";	"; }
				if ( strlen($p['a_hover_bg_col'] ?? '') > 0 )		{ $maybeMoreContent .= "background-color: ".$p['a_hover_bg_col']		.";	"; }
				if ( strlen($p['a_hover_decoration'] ?? '') > 0 )	{ $maybeMoreContent .= "text-decoration:".	$p['a_hover_decoration']	.";	"; }
				if ( strlen($p['a_hover_special'] ?? '') > 0 )		{ $maybeMoreContent .=						$p['a_hover_special']; }
				if ( strlen( $maybeMoreContent ?? '') > 0 )			{ $Content .= $css_menu_lnh ." { ".$maybeMoreContent." }\r"; }
				
				$maybeMoreContent = "";
				if ( strlen($p['a_active_fg_col'] ?? '') > 0 )		{ $maybeMoreContent .= "color:".			$p['a_active_fg_col']		.";	"; }
				if ( strlen($p['a_active_bg_col'] ?? '') > 0 )		{ $maybeMoreContent .= "background-color:".	$p['a_active_bg_col']		.";	"; }
				if ( strlen($p['a_active_decoration'] ?? '') > 0 )	{ $maybeMoreContent .= "text-decoration:".	$p['a_active_decoration']	.";	"; }
				if ( strlen($p['a_active_special'] ?? '') > 0 )		{ $maybeMoreContent .= 						$p['a_active_special']; }
				if ( strlen( $maybeMoreContent ?? '') > 0 )			{ $Content .= $css_menu_lna ." { ".$maybeMoreContent." }\r"; }
				
				$maybeMoreContent = "";
				if ( strlen($p['a_visited_fg_col'] ?? '') > 0 )		{ $maybeMoreContent .= "color:".			$p['a_visited_fg_col']		.";	"; }
				if ( strlen($p['a_visited_bg_col'] ?? '') > 0 )		{ $maybeMoreContent .= "background-color:".	$p['a_visited_bg_col']		.";	"; }
				if ( strlen($p['a_visited_decoration'] ?? '') > 0 )	{ $maybeMoreContent .= "text-decoration:".	$p['a_visited_decoration']	.";	"; }
				if ( strlen($p['a_visited_special'] ?? '') > 0 )	{ $maybeMoreContent .= 						$p['a_visited_special']; }
				if ( strlen( $maybeMoreContent ?? '') > 0 )			{ $Content .= $css_menu_lnv ." { ".$maybeMoreContent." }\r"; }
				
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
	// top: ". floor( $themeArray['theme_admctrl_width']/ 2 )."px; 
	// left: ".floor( $themeArray['theme_admctrl_height']/ 2 )."px; 
	$Content .= "
	.centered { text-align: center; }\r"
	
	.".".$tableName."bareTable			{background-color:transparent; border-spacing:0px; border-collapse:collapse; border-width:0px; border-style:none; margin:0px; padding:0px;}\r"
	.".".$tableName."bareTable tr		{background-color:transparent !important; margin:0px; padding:0px;}\r"
	.".".$tableName."bareTable td		{background-color:transparent; margin:0px !important; padding:0px !important;}\r"
	.".".$tableName."bareTable:hover	{background-color:transparent}\r"
	.".".$tableName."bareTable tr:hover {background-color:transparent}\r"
	.".".$tableName."bareTable td:hover	{background-color:transparent}\r"

	.".".$tableName."modif_article	{ height:512px ; overflow:auto }\r"
	.".".$tableName."modif_menu		{ height:512px ; overflow:auto }\r"

	.".".$tableName._CLASS_ADM_CTRL_SWITCH_." {	
		width: ". $this->ThemeDataObj->getDefinitionValue("admctrl_width") ."px; 
		height: ". $this->ThemeDataObj->getDefinitionValue("admctrl_height") ."px; 
		background-image: url(".$baseUrl."media/theme/".$this->ThemeDataObj->getDefinitionValue("directory")."/". $this->ThemeDataObj->getDefinitionValue("admctrl_switch_bg")."); 
		left: 0px;
		top: 0px;
		display: block;
		visibility: visible;
		background-position: center;
		background-repeat: repeat;
		position: fixed;
	}\r
	.".$tableName._CLASS_ADM_CTRL_PANEL_." {
		position: absolute; 
		width: 90%;
		height: 90%;
		border-style: solid; 
		border-width: 8px; 
		border-color: ".$themeArray['B01T']['txt_warning_col']."; 
		margin : auto;
		padding : 0px;
		background-image: url(".$baseUrl."media/theme/".$this->ThemeDataObj->getDefinitionValue("directory")."/".$this->ThemeDataObj->getDefinitionValue("admctrl_panel_bg").");
		visibility: hidden; 
	}
	
	.".$tableName._CLASS_FILE_SELECTOR_CONTAINER_." {
		position: absolute; 
		border-style: solid; 
		border-width: 0px; 
		border-color: #000000; 
		margin : 0mm;
		padding : 0mm;
		background-image: url(".$baseUrl."media/img/universal/noir_50prct.png);
		visibility: hidden; display : none;
	}
	.".$tableName._CLASS_FILE_SELECTOR_." {
		position: absolute; 
		border-style: solid; 
		border-width: 2.5mm; 
		border-color: ".$themeArray['B01T']['txt_warning_col']."; 
		margin : 0mm;
		padding : 0.5mm;".
		((strlen($themeArray['B01T']['txt_font_family']		?? '')>0) ? "font-family:".$themeArray['B01T']['txt_font_family'].";":"").
		((strlen($themeArray['B01T']['txt_font_size']		?? '')>0) ? "font-size:".$themeArray['B01T']['txt_font_size']."px;":"").
		((strlen($themeArray['B01T']['txt_col']				?? '')>0) ? "color:".$themeArray['B01T']['txt_col'].";":"").
		((strlen($themeArray['B01T']['tab_frame_bg_img']	?? '')>0) ? "background-image: url(".$baseUrl."media/theme/".$this->ThemeDataObj->getDefinitionValue("directory")."/".$themeArray['B01T']['tab_frame_bg_img'].");":"").
		((strlen($themeArray['B01T']['tab_frame_bg_col']	?? '')>0) ? "background-color: ".$themeArray['B01T']['tab_frame_bg_col'].";":"")."
		visibility: hidden; display : none; 
		cursor: pointer;
	}
	
	.div_std {
	font-family: ".$themeArray['B01T']['txt_font_family'].";
	font-weight: normal;
	line-height: normal;
	color: ".$themeArray['B01T']['txt_col'].";
	text-align: left;
	letter-spacing : 0px;
	word-spacing : 0px;
	overflow: auto;
	}\r
	
	\r	/* Media screen */


	@media print { BODY { font-size: 10pt; } }\r\r-->\r</style>\r";

	return $Content;
		
	}
	
	/**
	 * Render the deco_20 stylesheet
	 * @param Array $infos
	 * @return string
	 */
	private function renderStylesheetDeco20 (&$infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ServerInfosObj = $CurrentSetObj->ServerInfosObj;
		$p = &$infos[$infos['currentBlock']."T"];
		$dir = $this->ThemeDataObj->getDefinitionValue("directory");

		// $bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " P = " . $bts->StringFormatObj->arrayToString($p)));
		// https://www.w3.org/Style/Examples/007/units.fr.html
		// The choice is made as 'everything' is bound to a main unit (mostly mm).
		// Font are the exeption as it can be tricky sometimes depending on browsers.
		$mainUnit = $p['main_unit'];
		$fontUnit = $p['txt_font_unit'];
		$baseUrl  = $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url');
		
		$Content = "";
		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_ft",					" { border-spacing: 0px; border: 0px;	empty-cells: show; vertical-align: middle; } \r");
		// If no background image is defined the style isn't rendered.
		if ( strlen($p['ft1_bg'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_ft1",				" { padding: 0px;	border: 0px;	width: ".$p['ft1_width']."px;	max-width: ".$p['ft1_width']."px;	height: ".$p['ft_height']."px;	".((strlen($p['ft1_bg'] ?? '')>0)? "background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ft1_bg'].");" :"")."	".$p['ft1_special']. " } \r");																												}
		if ( strlen($p['ft2_bg'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_ft2",				" { padding: 0px;	border: 0px;																		height: ".$p['ft_height']."px;	".((strlen($p['ft2_bg'] ?? '')>0)? "background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ft2_bg'].");" :"")."	".$p['ft2_special']. " 	color: ".$p['ft2_fg_col']."; font-size:".$p['ft2_font_size'].$fontUnit."; } \r");									}
		if ( strlen($p['ft3_bg'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_ft3",				" { padding: 0px;	border: 0px;	width: ".$p['ft3_width']."px;	max-width: ".$p['ft1_width']."px;	height: ".$p['ft_height']."px;	".((strlen($p['ft3_bg'] ?? '')>0)? "background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ft3_bg'].");" :"")."	".$p['ft3_special']. " } \r");																												}

		if ( strlen($p['s1_a'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s1_n01",		" { width: ".$p['s1_01_width']."px;	height: ".$p['s1_01_height']."px; 								background-image: url(".$baseUrl."media/theme/".$dir."/".$p['s1_a'].");	background-position: 0px 0px;											border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s1_txt_col'].";}\r");																																		}
		if ( strlen($p['s1_b'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s1_n02",		" { 								height: ".$p['s1_01_height']."px; background: transparent;		background-image: url(".$baseUrl."media/theme/".$dir."/".$p['s1_b'].");	background-position: 0px 0px;											border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s1_txt_col'].	";		font-weight:".$p['s1_txt_weight'].";		".$p['s1_txt_special'].";		font-size:".$p['txt_font_size']."px;	font-family: '".$p['txt_font_family']."';}\r");	}
		if ( strlen($p['s1_c'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s1_n03",		" { width: ".$p['s1_03_width']."px;	height: ".$p['s1_01_height']."px; 								background-image: url(".$baseUrl."media/theme/".$dir."/".$p['s1_c'].");	background-position: 0px 0px;											border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s1_txt_col'].";}\r");																																		}
		if ( strlen($p['s1_a'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s1_h01",		" { width: ".$p['s1_01_width']."px;	height: ".$p['s1_01_height']."px; 								background-image: url(".$baseUrl."media/theme/".$dir."/".$p['s1_a'].");	background-position: ".$p['s1_offset_x']."px -".$p['s1_offset_y']."px;	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s1_txt_hover_col'].";}\r");																																}
		if ( strlen($p['s1_b'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s1_h02",		" { 								height: ".$p['s1_01_height']."px; background: transparent;		background-image: url(".$baseUrl."media/theme/".$dir."/".$p['s1_b'].");	background-position: ".$p['s1_offset_x']."px -".$p['s1_offset_y']."px;	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s1_txt_hover_col'].";	font-weight:".$p['s1_txt_hover_weight'].";	".$p['s1_txt_hover_special'].";	font-size:".$p['txt_font_size']."px;	font-family: '".$p['txt_font_family']."';}\r");	}
		if ( strlen($p['s1_c'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s1_h03",		" { width: ".$p['s1_03_width']."px;	height: ".$p['s1_01_height']."px; 								background-image: url(".$baseUrl."media/theme/".$dir."/".$p['s1_c'].");	background-position: ".$p['s1_offset_x']."px -".$p['s1_offset_y']."px;	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s1_txt_hover_col'].";}\r");																																}

		if ( strlen($p['s2_a'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s2_n01",		" { width: ".$p['s2_01_width']."px;	height: ".$p['s2_01_height']."px; 								background-image: url(".$baseUrl."media/theme/".$dir."/".$p['s2_a'].");	background-position: 0px 0px;											border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s2_txt_col'].";}\r");																																		}
		if ( strlen($p['s2_b'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s2_n02",		" { 								height: ".$p['s2_01_height']."px; background: transparent;		background-image: url(".$baseUrl."media/theme/".$dir."/".$p['s2_b'].");	background-position: 0px 0px;											border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s2_txt_col'].";		font-weight:".$p['s2_txt_weight'].";		".$p['s2_txt_special'].";		font-size:".$p['txt_font_size']."px;	font-family: '".$p['txt_font_family']."';}\r");	}
		if ( strlen($p['s2_c'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s2_n03",		" { width: ".$p['s2_03_width']."px;	height: ".$p['s2_01_height']."px; 								background-image: url(".$baseUrl."media/theme/".$dir."/".$p['s2_c'].");	background-position: 0px 0px;											border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s2_txt_col'].";}\r");																																		}
		if ( strlen($p['s2_a'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s2_h01",		" { width: ".$p['s2_01_width']."px;	height: ".$p['s2_01_height']."px; 								background-image: url(".$baseUrl."media/theme/".$dir."/".$p['s2_a'].");	background-position: ".$p['s2_offset_x']."px -".$p['s2_offset_y']."px;	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s2_txt_hover_col'].";}\r");																																}
		if ( strlen($p['s2_b'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s2_h02",		" { 								height: ".$p['s2_01_height']."px; background: transparent;		background-image: url(".$baseUrl."media/theme/".$dir."/".$p['s2_b'].");	background-position: ".$p['s2_offset_x']."px -".$p['s2_offset_y']."px;	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s2_txt_hover_col'].";	font-weight:".$p['s2_txt_hover_weight'].";	".$p['s2_txt_hover_special'].";	font-size:".$p['txt_font_size']."px;	font-family: '".$p['txt_font_family']."';}\r");	}
		if ( strlen($p['s2_c'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s2_h03",		" { width: ".$p['s2_03_width']."px;	height: ".$p['s2_01_height']."px; 								background-image: url(".$baseUrl."media/theme/".$dir."/".$p['s2_c'].");	background-position: ".$p['s2_offset_x']."px -".$p['s2_offset_y']."px;	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s2_txt_hover_col'].";}\r");																																}

		if ( strlen($p['s3_a'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s3_n01",		" { width: ".$p['s3_01_width']."px;	height: ".$p['s3_01_height']."px; 								background-image: url(".$baseUrl."media/theme/".$dir."/".$p['s3_a'].");	background-position: 0px 0px;											border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s3_txt_col'].";}\r");																																		}
		if ( strlen($p['s3_b'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s3_n02",		" { 								height: ".$p['s3_01_height']."px; background: transparent;		background-image: url(".$baseUrl."media/theme/".$dir."/".$p['s3_b'].");	background-position: 0px 0px;											border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s3_txt_col'].";		font-weight:".$p['s3_txt_weight'].";		".$p['s3_txt_special'].";		font-size:".$p['txt_font_size']."px;	font-family: '".$p['txt_font_family']."';}\r");	 }
		if ( strlen($p['s3_c'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s3_n03",		" { width: ".$p['s3_03_width']."px;	height: ".$p['s3_01_height']."px; 								background-image: url(".$baseUrl."media/theme/".$dir."/".$p['s3_c'].");	background-position: 0px 0px;											border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s3_txt_col'].";}\r");																																		}
		if ( strlen($p['s3_a'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s3_h01",		" { width: ".$p['s3_01_width']."px;	height: ".$p['s3_01_height']."px; 								background-image: url(".$baseUrl."media/theme/".$dir."/".$p['s3_a'].");	background-position: ".$p['s3_offset_x']."px -".$p['s3_offset_y']."px;	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s3_txt_hover_col'].";}\r");																																}
		if ( strlen($p['s3_b'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s3_h02",		" { 								height: ".$p['s3_01_height']."px; background: transparent;		background-image: url(".$baseUrl."media/theme/".$dir."/".$p['s3_b'].");	background-position: ".$p['s3_offset_x']."px -".$p['s3_offset_y']."px;	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s3_txt_hover_col'].";	font-weight:".$p['s3_txt_hover_weight'].";	".$p['s3_txt_hover_special'].";	font-size:".$p['txt_font_size']."px;	font-family: '".$p['txt_font_family']."';}\r");	}
		if ( strlen($p['s3_c'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_submit_s3_h03",		" { width: ".$p['s3_03_width']."px;	height: ".$p['s3_01_height']."px; 								background-image: url(".$baseUrl."media/theme/".$dir."/".$p['s3_c'].");	background-position: ".$p['s3_offset_x']."px -".$p['s3_offset_y']."px;	border-width : 0px; 	padding: 0px;	border-style: none;	color: ".$p['s3_txt_hover_col'].";}\r\r");																																}

		if ( strlen($p['tab_a'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_down_a",		" { background-image: url(".$baseUrl."media/theme/".$dir."/".$p['tab_a'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;	width: ".$p['tab_a_width']."px;	height: ".$p['tab_height']."px;	background-position: ".($p['tab_offset_x']*0)."px -".($p['tab_offset_y']*0)."px;	background-repeat : no-repeat;	overflow:hidden;	text-align: center;	color: ".$p['tab_down_txt_col'].";																											".((strlen($p['tab_down_txt_bg_col']  ?? ''	)>0) ? "background-color:".$p['tab_down_txt_bg_col']	:""		)."; }\r");										}
		if ( strlen($p['tab_b'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_down_b",		" { background-image: url(".$baseUrl."media/theme/".$dir."/".$p['tab_b'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;									height: ".$p['tab_height']."px;	background-position: ".($p['tab_offset_x']*0)."px -".($p['tab_offset_y']*0)."px;	background-repeat : repeat-x;	overflow:hidden;	text-align: center;	color: ".$p['tab_down_txt_col'].";	".((strlen($p['tab_down_txt_weight'] ?? '')>0) ? "font-weight:".$p['tab_down_txt_weight'].";":"")."		".((strlen($p['tab_down_txt_bg_col']  ?? ''	)>0) ? "background-color:".$p['tab_down_txt_bg_col']	:""		).";	".$p['tab_down_txt_special']."	}\r");	}
		if ( strlen($p['tab_c'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_down_c",		" { background-image: url(".$baseUrl."media/theme/".$dir."/".$p['tab_c'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;	width: ".$p['tab_c_width']."px;	height: ".$p['tab_height']."px;	background-position: ".($p['tab_offset_x']*0)."px -".($p['tab_offset_y']*0)."px;	background-repeat : no-repeat;	overflow:hidden;	text-align: center;	color: ".$p['tab_down_txt_col'].";																											".((strlen($p['tab_down_txt_bg_col']  ?? ''	)>0) ? "background-color:".$p['tab_down_txt_bg_col']	: ""	)."; }\r");										}
		if ( strlen($p['tab_a'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_up_a",		" { background-image: url(".$baseUrl."media/theme/".$dir."/".$p['tab_a'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;	width: ".$p['tab_a_width']."px;	height: ".$p['tab_height']."px;	background-position: ".($p['tab_offset_x']*1)."px -".($p['tab_offset_y']*1)."px;	background-repeat : no-repeat;	overflow:hidden;	text-align: center;	color: ".$p['tab_up_txt_col'].";																											".((strlen($p['tab_up_txt_bg_col']  ?? ''	)>0) ? "background-color:".$p['tab_up_txt_bg_col']		: ""	)."; }\r");										}
		if ( strlen($p['tab_b'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_up_b",		" { background-image: url(".$baseUrl."media/theme/".$dir."/".$p['tab_b'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;									height: ".$p['tab_height']."px;	background-position: ".($p['tab_offset_x']*1)."px -".($p['tab_offset_y']*1)."px;	background-repeat : repeat-x;	overflow:hidden;	text-align: center;	color: ".$p['tab_up_txt_col'].";	".((strlen($p['tab_up_txt_weight'] ?? '')>0) ? "font-weight:".$p['tab_up_txt_weight'].";":"")."			".((strlen($p['tab_up_txt_bg_col']  ?? ''	)>0) ? "background-color:".$p['tab_up_txt_bg_col']		: ""	).";	".$p['tab_up_txt_special']."	}\r" );	}
		if ( strlen($p['tab_c'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_up_c",		" { background-image: url(".$baseUrl."media/theme/".$dir."/".$p['tab_c'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;	width: ".$p['tab_c_width']."px;	height: ".$p['tab_height']."px;	background-position: ".($p['tab_offset_x']*1)."px -".($p['tab_offset_y']*1)."px;	background-repeat : no-repeat;	overflow:hidden;	text-align: center;	color: ".$p['tab_up_txt_col'].";																											".((strlen($p['tab_up_txt_bg_col']  ?? ''	)>0) ? "background-color:".$p['tab_up_txt_bg_col']		: ""	)."; }\r" );									}
		if ( strlen($p['tab_a'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_hover_a",	" { background-image: url(".$baseUrl."media/theme/".$dir."/".$p['tab_a'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;	width: ".$p['tab_a_width']."px;	height: ".$p['tab_height']."px;	background-position: ".($p['tab_offset_x']*2)."px -".($p['tab_offset_y']*2)."px;	background-repeat : no-repeat;	overflow:hidden;	text-align: center;	color: ".$p['tab_hover_txt_col'].";																											".((strlen($p['tab_hover_txt_bg_col']  ?? '')>0) ? "background-color:".$p['tab_hover_txt_bg_col']	: ""	)."; }\r");										}
		if ( strlen($p['tab_b'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_hover_b",	" { background-image: url(".$baseUrl."media/theme/".$dir."/".$p['tab_b'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;									height: ".$p['tab_height']."px;	background-position: ".($p['tab_offset_x']*2)."px -".($p['tab_offset_y']*2)."px;	background-repeat : repeat-x;	overflow:hidden;	text-align: center;	color: ".$p['tab_hover_txt_col'].";	".((strlen($p['tab_hover_txt_weight'] ?? '')>0) ? "font-weight:".$p['tab_hover_txt_weight'].";":"")."	".((strlen($p['tab_hover_txt_bg_col']  ?? '')>0) ? "background-color:".$p['tab_hover_txt_bg_col']	: ""	).";	".$p['tab_hover_txt_special']."	}\r");	}
		if ( strlen($p['tab_c'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tab_hover_c",	" { background-image: url(".$baseUrl."media/theme/".$dir."/".$p['tab_c'].");	padding-top: 0px;	padding-left: 0px;	vertical-align: bottom;	width: ".$p['tab_c_width']."px;	height: ".$p['tab_height']."px;	background-position: ".($p['tab_offset_x']*2)."px -".($p['tab_offset_y']*2)."px;	background-repeat : no-repeat;	overflow:hidden;	text-align: center;	color: ".$p['tab_hover_txt_col'].";																											".((strlen($p['tab_hover_txt_bg_col']  ?? '')>0) ? "background-color:".$p['tab_hover_txt_bg_col']	: ""	)."; }\r");										}

		$Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_tabFrame",			" { padding: 5px ; vertical-align: top; ".((strlen($p['tab_frame_bg_img'] ?? '')>0) ? "background-image: url(".$baseUrl."media/theme/".$dir."/".$p['tab_frame_bg_img'].");" : "")."  ".((strlen($p['tab_frame_bg_col'] ?? '')>0) ? "background-color: ".$p['tab_frame_bg_col'].";":"")." }\r\r");

		$protocol = ( $ServerInfosObj->getServerInfosEntry('sslState') == 1) ? "https://" : "http://" ;
			
		$rootPath = $CurrentSetObj->ServerInfosObj->getServerInfosEntry('DOCUMENT_ROOT')."/media/theme/".$dir."/";

		if ( 
			isset($p['txt_font_name_normal']) 
			&& isset($p['txt_font_filename_normal']) 
			// && file_exists($rootPath.$p['txt_font_filename_normal'])
			) {
				$Content .= "@font-face {	font-family: '".$p['txt_font_name_normal']."'; src: url('".$protocol.$ServerInfosObj->getServerInfosEntry('srv_host')."/media/theme/".$dir."/".$p['txt_font_filename_normal']."');}\r";
		}

		if ( 
			isset($p['txt_font_name_bold']) 
			&& isset($p['txt_font_filename_bold'])
			// && file_exists($rootPath.$p['txt_font_filename_bold'])
			) {
				$Content .= "@font-face {	font-family: '".$p['txt_font_name_bold']."'; font-weight:bold; src: url('".$protocol.$ServerInfosObj->getServerInfosEntry('srv_host')."/media/theme/".$dir."/".$p['txt_font_filename_bold']."');}\r";
		}

		if ( 
			isset($p['txt_font_name_italic'])  
			&& isset($p['txt_font_filename_italic'])
			// && file_exists($rootPath.$p['txt_font_filename_bold'])
			) {
				$Content .= "@font-face {	font-family: '".$p['txt_font_name_italic']."'; font-style:italic; src: url('".$protocol.$ServerInfosObj->getServerInfosEntry('srv_host')."/media/theme/".$dir."/".$p['txt_font_filename_italic']."');}\r";
		}
		
		// Main module class
		$list= array( "font_family",	"font_dl_url",	"font_size",	"col");
		$str = $this->testAndRenderCssStyle("txt", $list, $p);
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	"",				"",			"{".$str."}");}

		$list= array( "ok_col",	);
		$str = $this->testAndRenderCssStyle("txt", $list, $p);
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	"_ok",				"",			"{".$str."}");}
		$list= array( "warning_col",	);
		$str = $this->testAndRenderCssStyle("txt", $list, $p);
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	"_warning",				"",			"{".$str."}");}
		$list= array( "error_col",	);
		$str = $this->testAndRenderCssStyle("txt", $list, $p);
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	"_error",				"",			"{".$str."}");}
		$list= array( "fade_col",	);
		$str = $this->testAndRenderCssStyle("txt", $list, $p);
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	"_fade",				"",			"{".$str."}");}
		$list= array( "highlight_col",	);
		$str = $this->testAndRenderCssStyle("txt", $list, $p);
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	"_highlight",				"",			"{".$str."}");}
		
		// Hx
		$list= array( "font_family",	"font_size",	"txt_col",	"special" );
		for ( $hx=1; $hx<=7; $hx++) {
			$str = $this->testAndRenderCssStyle("h".$hx, $list, $p);
			if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	"",				"h".$hx,			"{".$str."}");}
		}
		// P
		$list= array( "txt_indent",	"txt_align",	"font",	"fg_col",	"bg_col",	"mrg_top",	"mrg_bottom",	"mrg_left",	"mrg_right",	"pad_top",	"pad_bottom",	"pad_left",	"pad_right" );
		$str = $this->testAndRenderCssStyle("p", $list, $p);
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	"",				"p",			"{".$str."}");}
		// a
		$list= array( "font",	"fg_col",	"bg_col",	"decoration",	"special");
		$str = $this->testAndRenderCssStyle("a", $list, $p);
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	"",				"a",			"{".$str."}");}
		// a:visited
		$list= array( "font",	"fg_col",	"bg_col",	"decoration",	"special");
		$str = $this->testAndRenderCssStyle("a_visited", $list, $p);
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	"",				"a:visited",	"{".$str."}");}
		// a:hover
		$list= array( "font",	"fg_col",	"bg_col",	"decoration",	"special");
		$str = $this->testAndRenderCssStyle("a_hover", $list, $p);
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	"",				"a:hover",		"{".$str."}");}
		// a:active
		$list= array( "font",	"fg_col",	"bg_col",	"decoration",	"special");
		$str = $this->testAndRenderCssStyle("a_active", $list, $p);
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	"",				"a:active",		"{".$str." color: inherit;}");}
		
		//form
		$list= array( "fg_col",	"bg_col",	"special");
		$str = $this->testAndRenderCssStyle("input", $list, $p);
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	"",				"input[type=text]",	"{font-family:".$p['txt_font_family']."; ".$str."}");}
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	"",				"input[type=password]",	"{font-family:".$p['txt_font_family']."; ".$str."}");}
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	"",				"select",	"{".$str."}");}
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	"",				"textarea",	"{".$str."}");}
		
		// code
		$list= array( "font",	"fg_col",	"bg_col",	"mrg_top",	"mrg_bottom",	"mrg_left",	"mrg_right",	"pad_top",	"pad_bottom",	"pad_left",	"pad_right", "special" ); 
		$str = $this->testAndRenderCssStyle("code", $list, $p);
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	"",				"code",			"{".$str."}");}
		
		
		// Table with no background. Usually used to align elements like images.
		$Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TABLE_STD_,		"",				"{ border-spacing:0px; width:100%; margin-left:0px; margin-right:auto;}");
		$Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TABLE_STD_,		"td",			"{ text-align:center; background-color:transparent;}");
		
		// Table01
		if ( strlen($p['table_rules'] ?? '')	> 0 )	{ $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TABLE01_,		"",				"{ ".$p['table_rules']." }"); }
		$valTest = 0;
		$sv = array();
		if ( strlen( $p['t01_caption_bg_col'] ?? '')	> 0 )	{ $valTest++; $sv['a'] = "background-color:".$p['t01_caption_bg_col'].";";}
		if ( strlen( $p['t01_caption_fg_col'] ?? '')	> 0 )	{ $valTest++; $sv['b'] = "color: ".$p['t01_caption_fg_col'].";";}
		if ( strlen( $p['t01_caption_special'] ?? '')	> 0 )	{ $valTest++; $sv['c'] = $p['t01_caption_special'];}
		if ( $valTest > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TABLE01_,		"caption",				"{".$sv['a']." ".$sv['b']." ".$sv['c']."}");}
		
		// TR
		$valTest = 0;
		$sv = array();
		if ( strlen( $p['t01_tr_bg_col'] ?? '')		> 0 )	{ $valTest++; $sv['a'] = "background-color:".$p['t01_tr_bg_col'].";";}
		if ( strlen( $p['t01_txt_col'] ?? '')		> 0 )	{ $valTest++; $sv['b'] = "color:".$p['t01_txt_col']."; "; }
		if ( strlen( $p['t01_tr_special'] ?? '')	> 0 )	{ $valTest++; $sv['c'] = $p['t01_tr_special'].";";}
		if ( $valTest > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TABLE01_,		"tr",	"{ ".$sv['a']." ".$sv['b']." ".$sv['c']."}"); }
		
		// TR specific
		if ( strlen( $p['t01_tr_bg_odd_col'] ?? '')		>0 )	{ $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TABLE01_,		"tr:nth-child(2n+1)",	"{ background-color:".$p['t01_tr_bg_odd_col'].";	}");	}
		if ( strlen( $p['t01_tr_bg_even_col'] ?? '')	>0 )	{ $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TABLE01_,		"tr:nth-child(2n)",		"{ background-color:".$p['t01_tr_bg_even_col'].";	}");	}
		if ( strlen( $p['t01_tr_bg_hover_col'] ?? '')	>0 )	{ $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TABLE01_,		"tr:hover",				"{ background-color:".$p['t01_tr_bg_hover_col'].";	}");	}
		if ( strlen( $p['t01_td_special'] ?? '')		>0 )	{ $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TABLE01_,		"td",					"{ ".$p['t01_td_special'].";						}"); 	}
		if ( strlen( $p['t01_td_bg_odd_col'] ?? '')		>0 )	{ $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TABLE01_,		"td:nth-child(2n+1)",	"{ background-color:".$p['t01_td_bg_odd_col'].";	}"); 	}
		if ( strlen( $p['t01_td_bg_even_col'] ?? '')	>0 )	{ $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TABLE01_,		"td:nth-child(2n)",		"{ background-color:".$p['t01_td_bg_even_col'].";	}");	}
		
		// td a
		$list= array( "font",	"fg_col",	"bg_col",	"decoration",	"special");
		$str = $this->testAndRenderCssStyle("td_a", $list, $p);
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TABLE01_,				"a",			"{".$str."}");}
		// td a:hover
		$list= array( "font",	"fg_col",	"bg_col",	"decoration",	"special");
		$str = $this->testAndRenderCssStyle("td_a_hover", $list, $p);
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TABLE01_,				"a:hover",		"{".$str."}");}
		// td a:active
		$list= array( "font",	"fg_col",	"bg_col",	"decoration",	"special");
		$str = $this->testAndRenderCssStyle("td_a_active", $list, $p);
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TABLE01_,				"a:active",		"{".$str."}");}
		// td a:visited
		$list= array( "font",	"fg_col",	"td_bg_col",	"decoration",	"special");
		$str = $this->testAndRenderCssStyle("a_visited", $list, $p);
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TABLE01_,				"a:visited",	"{".$str."}");}
		//td form
		$list= array( "fg_col",	"bg_col",	"special");
		$str = $this->testAndRenderCssStyle("td_input", $list, $p);
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TABLE01_,				"input[type=text]",	"{".$str."}");}
		if ( strlen($str ?? '') > 0 ) { $Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TABLE01_,				"select",			"{".$str."}");}
		
		// Table01 legend 
		$list= array( "txt_col",	"bg_col",	"special");
		$str = $this->testAndRenderCssStyle("t01_legend", $list, $p);
		if ( strlen($str ?? '') > 0 ) { 
			$Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TBL_LGND_TOP_,			"tr:first-child",	"{".$str."}");
			$Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TBL_LGND_BOTTOM_,		"tr:last-child",	"{".$str."}");
			$Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TBL_LGND_LEFT_,			"td:first-child",	"{".$str."}");
			$Content .= $this->makeCssSelectorList ($infos, $infos['currentBlock'],	"T",	_CLASS_TBL_LGND_RIGHT_,			"td:last-child",	"{".$str."}");
		}
		
		// Icons
		if ( strlen($p['icon_directory'] ?? '')>0)		{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_icon_directory",		" { background-size: contain;	background-image: url(".$baseUrl."media/theme/".$dir."/".$p['icon_directory']."); }\r");		}
		if ( strlen($p['icon_erase'] ?? '')>0)			{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_icon_erase",			" { background-size: contain;	background-image: url(".$baseUrl."media/theme/".$dir."/".$p['icon_erase']."); }\r");			}
		if ( strlen($p['icon_ok'] ?? '')>0)				{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_icon_ok",			" { background-size: contain;	background-image: url(".$baseUrl."media/theme/".$dir."/".$p['icon_ok']."); }\r");				}
		if ( strlen($p['icon_nok'] ?? '')>0)			{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_icon_nok",			" { background-size: contain;	background-image: url(".$baseUrl."media/theme/".$dir."/".$p['icon_nok']."); }\r");				}
		if ( strlen($p['icon_left'] ?? '')>0)			{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_icon_left",			" { background-size: contain;	background-image: url(".$baseUrl."media/theme/".$dir."/".$p['icon_left']."); }\r");			}
		if ( strlen($p['icon_right'] ?? '')>0)			{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_icon_right",			" { background-size: contain;	background-image: url(".$baseUrl."media/theme/".$dir."/".$p['icon_right']."); }\r");			}
		if ( strlen($p['icon_top'] ?? '')>0)			{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_icon_top",			" { background-size: contain;	background-image: url(".$baseUrl."media/theme/".$dir."/".$p['icon_top']."); }\r");				}
		if ( strlen($p['icon_bottom'] ?? '')>0)			{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_icon_bottom",		" { background-size: contain;	background-image: url(".$baseUrl."media/theme/".$dir."/".$p['icon_bottom']."); }\r");			}
		if ( strlen($p['icon_question'] ?? '')>0)		{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_icon_question",		" { background-size: contain;	background-image: url(".$baseUrl."media/theme/".$dir."/".$p['icon_question']."); }\r");		}
		if ( strlen($p['icon_notification'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_icon_notification",	" { background-size: contain;	background-image: url(".$baseUrl."media/theme/".$dir."/".$p['icon_notification']."); }\r");	}

		if ( strlen($p['page_selector'] ?? '')>0)			{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_page_selector",				" { ".$p['page_selector']." }\r");		}
		if ( strlen($p['page_selector_highlight'] ?? '')>0)	{ $Content .= $this->makeCssIdString ($infos, ".",		$infos['currentBlock'], "T", "_page_selector_highlight",	" { ".$p['page_selector_highlight']." }\r");		}

		// Add title lines (first/last line +  first/last column)
		return "\r".$Content;
	}
	
	
	
	private function renderStylesheetDeco30 (&$infos) {
		$Content = "";
		return $Content;
	}
	
	private function renderStylesheetDeco40 (&$infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$type = $infos['currentBlockType'];
		$p = &$infos[$infos['currentBlock'].$type];
		$baseUrl  = $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url');

		$Content = "";
		$dir = $this->ThemeDataObj->getDefinitionValue("directory");
		if ( strlen($p['repertoire'] ?? '') != 0 ) { $dir = $p['repertoire']; }
		if ( $p['a_line_height'] > 0 ) { $supLH = "; line-height: ". $p['a_line_height']."px;"; }
	
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex11", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex11'].");	background-position:".str_replace('-', ' ', $p['ex11_bgp']).";	vertical-align: bottom;	width: ".$p['ex11_x']."px;	height: ".$p['ex11_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex12", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex12'].");	background-position:".str_replace('-', ' ', $p['ex12_bgp']).";	vertical-align: bottom;	width: ".$p['ex12_x']."px;	height: ".$p['ex12_y']."px;		background-repeat : repeat-x;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex13", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex13'].");	background-position:".str_replace('-', ' ', $p['ex13_bgp']).";	vertical-align: bottom;								height: ".$p['ex13_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex21", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex21'].");	background-position:".str_replace('-', ' ', $p['ex21_bgp']).";	vertical-align: bottom;	width: ".$p['ex21_x']."px;	height: ".$p['ex21_y']."px;		background-repeat : repeat-y;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex22", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex22'].");	background-position:".str_replace('-', ' ', $p['ex22_bgp']).";	vertical-align: bottom;	width: ".$p['ex22_x']."px;									background-repeat : repeat;		overflow:hidden".$supLH."}\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex23", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex23'].");	background-position:".str_replace('-', ' ', $p['ex23_bgp']).";	vertical-align: bottom;	width: ".$p['ex23_x']."px;	height: ".$p['ex23_y']."px;		background-repeat : repeat-y;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex31", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex31'].");	background-position:".str_replace('-', ' ', $p['ex31_bgp']).";	vertical-align: bottom;	width: ".$p['ex31_x']."px;	height: ".$p['ex31_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex32", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex32'].");	background-position:".str_replace('-', ' ', $p['ex32_bgp']).";	vertical-align: bottom;	width: ".$p['ex32_x']."px;	height: ".$p['ex32_y']."px;		background-repeat : repeat-x;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex33", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex33'].");	background-position:".str_replace('-', ' ', $p['ex33_bgp']).";	vertical-align: bottom;	width: ".$p['ex33_x']."px;	height: ".$p['ex33_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		return "\r".$Content;
	}
	
	private function renderStylesheetDeco50 (&$infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$type = $infos['currentBlockType'];
		$p = &$infos[$infos['currentBlock'].$type];
		$baseUrl  = $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url');

		$Content = "";
		$dir = $this->ThemeDataObj->getDefinitionValue("directory");
		if ( strlen($p['repertoire'] ?? '') != 0 ) { $dir = $p['repertoire']; }
		if ( $p['a_line_height'] > 0 ) { $supLH = "; line-height: ". $p['a_line_height']."px;"; }
		
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex11", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex11'].");	background-position:".str_replace('-', ' ', $p['ex11_bgp']).";	vertical-align: bottom;	width: ".$p['ex11_x']."px;	height: ".$p['ex11_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex12", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex12'].");	background-position:".str_replace('-', ' ', $p['ex12_bgp']).";	vertical-align: bottom;	width: ".$p['ex12_x']."px;	height: ".$p['ex12_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex13", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex13'].");	background-position:".str_replace('-', ' ', $p['ex13_bgp']).";	vertical-align: bottom;								height: ".$p['ex13_y']."px;		background-repeat : repeat-x;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex14", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex14'].");	background-position:".str_replace('-', ' ', $p['ex14_bgp']).";	vertical-align: bottom;	width: ".$p['ex14_x']."px;	height: ".$p['ex14_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex15", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex15'].");	background-position:".str_replace('-', ' ', $p['ex15_bgp']).";	vertical-align: bottom;	width: ".$p['ex15_x']."px;	height: ".$p['ex15_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex21", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex21'].");	background-position:".str_replace('-', ' ', $p['ex21_bgp']).";	vertical-align: bottom;	width: ".$p['ex21_x']."px;	height: ".$p['ex21_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex22", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex22'].");	background-position:".str_replace('-', ' ', $p['ex22_bgp']).";	vertical-align: bottom;	width: ".$p['ex22_x']."px;									background-repeat : repeat;		overflow:hidden".$supLH."}\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex25", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex25'].");	background-position:".str_replace('-', ' ', $p['ex25_bgp']).";	vertical-align: bottom;	width: ".$p['ex25_x']."px;	height: ".$p['ex25_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex31", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex31'].");	background-position:".str_replace('-', ' ', $p['ex31_bgp']).";	vertical-align: bottom;	width: ".$p['ex31_x']."px;	height: ".$p['ex31_y']."px;		background-repeat : repeat-y;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex35", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex35'].");	background-position:".str_replace('-', ' ', $p['ex35_bgp']).";	vertical-align: bottom;	width: ".$p['ex35_x']."px;	height: ".$p['ex35_y']."px;		background-repeat : repeat-y;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex41", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex41'].");	background-position:".str_replace('-', ' ', $p['ex41_bgp']).";	vertical-align: bottom;	width: ".$p['ex41_x']."px;	height: ".$p['ex41_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex45", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex45'].");	background-position:".str_replace('-', ' ', $p['ex45_bgp']).";	vertical-align: bottom;	width: ".$p['ex45_x']."px;	height: ".$p['ex45_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex51", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex51'].");	background-position:".str_replace('-', ' ', $p['ex51_bgp']).";	vertical-align: bottom;	width: ".$p['ex51_x']."px;	height: ".$p['ex51_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex52", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex52'].");	background-position:".str_replace('-', ' ', $p['ex52_bgp']).";	vertical-align: bottom;	width: ".$p['ex52_x']."px;	height: ".$p['ex52_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex53", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex53'].");	background-position:".str_replace('-', ' ', $p['ex53_bgp']).";	vertical-align: bottom;								height: ".$p['ex53_y']."px;		background-repeat : repeat-x;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex54", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex54'].");	background-position:".str_replace('-', ' ', $p['ex54_bgp']).";	vertical-align: bottom;	width: ".$p['ex54_x']."px;	height: ".$p['ex54_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex55", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex55'].");	background-position:".str_replace('-', ' ', $p['ex55_bgp']).";	vertical-align: bottom;	width: ".$p['ex55_x']."px;	height: ".$p['ex55_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		return "\r".$Content;
	}
	
	private function renderStylesheetDeco60 (&$infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$type = $infos['currentBlockType'];
		$p = &$infos[$infos['currentBlock'].$type];
		$baseUrl  = $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url');

		$Content = "";
		$dir = $this->ThemeDataObj->getDefinitionValue("directory");
		if ( strlen($p['repertoire'] ?? '') != 0 ) { $dir = $p['repertoire']; }
		if ( $p['a_line_height'] > 0 ) { $supLH = "; line-height: ". $p['a_line_height']."px;"; }
		
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex11", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex11'].");	background-position:".str_replace('-', ' ', $p['ex11_bgp']).";	vertical-align: bottom;	width: ".$p['ex11_x']."px;	height: ".$p['ex11_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex12", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex12'].");	background-position:".str_replace('-', ' ', $p['ex12_bgp']).";	vertical-align: bottom;	width: ".$p['ex12_x']."px;	height: ".$p['ex12_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex13", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex13'].");	background-position:".str_replace('-', ' ', $p['ex13_bgp']).";	vertical-align: bottom;								height: ".$p['ex13_y']."px;		background-repeat : repeat-x;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex14", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex14'].");	background-position:".str_replace('-', ' ', $p['ex14_bgp']).";	vertical-align: bottom;	width: ".$p['ex14_x']."px;	height: ".$p['ex14_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex15", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex15'].");	background-position:".str_replace('-', ' ', $p['ex15_bgp']).";	vertical-align: bottom;	width: ".$p['ex15_x']."px;	height: ".$p['ex15_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex21", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex21'].");	background-position:".str_replace('-', ' ', $p['ex21_bgp']).";	vertical-align: bottom;	width: ".$p['ex21_x']."px;	height: ".$p['ex21_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex22", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex22'].");	background-position:".str_replace('-', ' ', $p['ex22_bgp']).";	vertical-align: bottom;	width: ".$p['ex22_x']."px;									background-repeat : repeat;		overflow:hidden".$supLH."}\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex25", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex25'].");	background-position:".str_replace('-', ' ', $p['ex25_bgp']).";	vertical-align: bottom;	width: ".$p['ex25_x']."px;	height: ".$p['ex25_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex31", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex31'].");	background-position:".str_replace('-', ' ', $p['ex31_bgp']).";	vertical-align: bottom;	width: ".$p['ex31_x']."px;	height: ".$p['ex31_y']."px;		background-repeat : repeat-y;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex35", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex35'].");	background-position:".str_replace('-', ' ', $p['ex35_bgp']).";	vertical-align: bottom;	width: ".$p['ex35_x']."px;	height: ".$p['ex35_y']."px;		background-repeat : repeat-y;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex41", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex41'].");	background-position:".str_replace('-', ' ', $p['ex41_bgp']).";	vertical-align: bottom;	width: ".$p['ex41_x']."px;	height: ".$p['ex41_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex45", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex45'].");	background-position:".str_replace('-', ' ', $p['ex45_bgp']).";	vertical-align: bottom;	width: ".$p['ex45_x']."px;	height: ".$p['ex45_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex51", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex51'].");	background-position:".str_replace('-', ' ', $p['ex51_bgp']).";	vertical-align: bottom;	width: ".$p['ex51_x']."px;	height: ".$p['ex51_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex52", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex52'].");	background-position:".str_replace('-', ' ', $p['ex52_bgp']).";	vertical-align: bottom;	width: ".$p['ex52_x']."px;	height: ".$p['ex52_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex53", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex53'].");	background-position:".str_replace('-', ' ', $p['ex53_bgp']).";	vertical-align: bottom;								height: ".$p['ex53_y']."px;		background-repeat : repeat-x;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex54", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex54'].");	background-position:".str_replace('-', ' ', $p['ex54_bgp']).";	vertical-align: bottom;	width: ".$p['ex54_x']."px;	height: ".$p['ex54_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_ex55", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['ex55'].");	background-position:".str_replace('-', ' ', $p['ex55_bgp']).";	vertical-align: bottom;	width: ".$p['ex55_x']."px;	height: ".$p['ex55_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");

		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in11", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['in11'].");	background-position:".str_replace('-', ' ', $p['in11_bgp']).";	vertical-align: bottom;	width: ".$p['in11_x']."px;	height: ".$p['in11_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in12", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['in12'].");	background-position:".str_replace('-', ' ', $p['in12_bgp']).";	vertical-align: bottom;	width: ".$p['in12_x']."px;	height: ".$p['in12_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in13", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['in13'].");	background-position:".str_replace('-', ' ', $p['in13_bgp']).";	vertical-align: bottom;	width: ".$p['in13_x']."px;	height: ".$p['in13_y']."px;		background-repeat : repeat-x;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in14", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['in14'].");	background-position:".str_replace('-', ' ', $p['in14_bgp']).";	vertical-align: bottom;	width: ".$p['in14_x']."px;	height: ".$p['in14_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in15", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['in15'].");	background-position:".str_replace('-', ' ', $p['in15_bgp']).";	vertical-align: bottom;	width: ".$p['in15_x']."px;	height: ".$p['in15_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in21", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['in21'].");	background-position:".str_replace('-', ' ', $p['in21_bgp']).";	vertical-align: bottom;	width: ".$p['in21_x']."px;	height: ".$p['in21_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in25", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['in25'].");	background-position:".str_replace('-', ' ', $p['in25_bgp']).";	vertical-align: bottom;	width: ".$p['in25_x']."px;	height: ".$p['in25_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in31", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['in31'].");	background-position:".str_replace('-', ' ', $p['in31_bgp']).";	vertical-align: bottom;	width: ".$p['in31_x']."px;	height: ".$p['in31_y']."px;		background-repeat : repeat-y;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in35", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['in35'].");	background-position:".str_replace('-', ' ', $p['in35_bgp']).";	vertical-align: bottom;	width: ".$p['in35_x']."px;	height: ".$p['in35_y']."px;		background-repeat : repeat-y;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in41", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['in41'].");	background-position:".str_replace('-', ' ', $p['in41_bgp']).";	vertical-align: bottom;	width: ".$p['in41_x']."px;	height: ".$p['in41_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in45", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['in45'].");	background-position:".str_replace('-', ' ', $p['in45_bgp']).";	vertical-align: bottom;	width: ".$p['in45_x']."px;	height: ".$p['in45_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in51", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['in51'].");	background-position:".str_replace('-', ' ', $p['in51_bgp']).";	vertical-align: bottom;	width: ".$p['in51_x']."px;	height: ".$p['in51_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in52", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['in52'].");	background-position:".str_replace('-', ' ', $p['in52_bgp']).";	vertical-align: bottom;	width: ".$p['in52_x']."px;	height: ".$p['in52_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in53", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['in53'].");	background-position:".str_replace('-', ' ', $p['in53_bgp']).";	vertical-align: bottom;	width: ".$p['in53_x']."px;	height: ".$p['in53_y']."px;		background-repeat : repeat-x;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in54", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['in54'].");	background-position:".str_replace('-', ' ', $p['in54_bgp']).";	vertical-align: bottom;	width: ".$p['in54_x']."px;	height: ".$p['in54_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		$Content .= $this->makeCssIdString ($infos, ".", $infos['currentBlock'], $type, "_in55", " { position: absolute; background-image: url(".$baseUrl."media/theme/".$dir."/".$p['in55'].");	background-position:".str_replace('-', ' ', $p['in55_bgp']).";	vertical-align: bottom;	width: ".$p['in55_x']."px;	height: ".$p['in55_y']."px;		background-repeat : no-repeat;	overflow:hidden }\r");
		return "\r".$Content;
	}
	
	private function makeCssIdString (&$infos, $prefix, $block, $type, $suffix, $css) {
		$p = explode( " ", trim($block." ".$infos[$block.$type]['blockList']) ); // trim removes the last space in the string
		$str = "";
		if ($type != "M") { $type = "";}
		foreach ($p as $A) { $str .= $prefix.$infos['tableName'].$A.$type.$suffix.", ";}
		$str = substr ( $str , 0 , -2 )." ".$css;
		return $str;
	}

	private function makeCssLevelString(&$infos, $block, $prefix, $suffix) {
		$p = explode( " ", trim($infos[$block]['levelList']) ); // trim removes the last space in the string
		$str = "";
		foreach ($p as $A) { $str .= $prefix.$A.$suffix.", "; }
		return $str;
		
	}
	
	private function makeCssSelectorList (&$infos, $block, $type, $id, $item, $css ) {
		$p = explode( " ", trim($block." ".$infos[$block.$type]['blockList']) ); // trim removes the last space in the string
		$str = "";
		foreach ($p as $A) { $str .= ".".$infos['tableName'].$A.$id. ((strlen($item ?? '') > 0) ? " ".$item : "") .", ";}
		$str = substr ( $str , 0 , -2 )." ".$css."\r";
		return $str;
	}
	
	/**
	 * 
	 * @param String $elm
	 * @param Array $infos
	 * @param Array $p
	 * @return string
	 * txt_h1_font	=>	"font-family",
	 * txt_h1_size	=>	"font-size"
	 * txt_h1_col	=>	"color",
	 * txt_h1_special	"special"		=>	"",

	 */
	private function testAndRenderCssStyle ( $elm, $infos, &$p) {
		$str = "";
		$tab = array(
				"bg_col"		=>	"background-color",
				"col"			=>	"color",
				"txt_col"		=>	"color",
				"decoration"	=>	"text-decoration",
				"error_col"		=>	"color",
				"fade_col"		=>	"color",
				"font_family"	=>	"font-family",
				"fonte"			=>	"font-family",
				"font_size"		=>	"font-size",
				"fg_col"		=>	"color",
				"highlight_col" =>	"color",
				"mrg_top"		=>	"margin-top",
				"mrg_bottom"	=>	"margin-bottom",
				"mrg_left"		=>	"margin-left",
				"mrg_right"		=>	"margin-right",
				"pad_top"		=>	"padding-top",
				"pad_bottom"	=>	"padding-bottom",
				"pad_left"		=>	"padding-left",
				"pad_right"		=>	"padding-right",
				"ok_col"		=>	"color",
				"special"		=>	"",
				"txt_align"		=>	"text-align",
				"txt_indent"	=>	"text-indent",
				"warning_col"	=>	"color",
		);
		foreach ($infos as $A) {
			$mainUnit = $p['main_unit'];
			$fontUnit = $p['txt_font_unit'];
			
			switch ($A) {
				case "mrg_top":
				case "mrg_bottom":
				case "mrg_left":
				case "mrg_right":
				case "pad_top":
				case "pad_bottom":
				case "pad_left":
				case "pad_right":
				case "txt_indent":
					if ( $p[$elm.'_'.$A] != 0 )	{ 
						$str .= $tab[$A] .":".$p[$elm.'_'.$A];
						if ( strpos($p[$elm.'_'.$A], 'auto') === false ) { $str .= $mainUnit;}
						$str .= "; ";
					}
					break;
				case "fonte_size":
				case "font_size":
					if ( $p[$elm.'_'.$A] != 0 )	{ $str .= $tab[$A] .":".$p[$elm.'_'.$A].$fontUnit."; ";}
					break;
				case "bg_col":
				case "col":
				case "txt_col":
				case "decoration":
				case "error_col":
				case "fade_col":
				case "fg_col":
				case "font_family":
				case "fonte":
				case "highlight_col":
				case "ok_col":
				case "txt_align":
				case "warning_col":
					if ( strlen( $p[$elm.'_'.$A] ?? '')> 0 )	{ $str .= $tab[$A] .":".$p[$elm.'_'.$A]."; ";}
					break;
				case "special":
					if ( strlen( $p[$elm.'_'.$A] ?? '')> 0 )	{ $str .= $p[$elm.'_'.$A]."; ";}
					break;
			}
		}
		return $str;
	}

}
?>
