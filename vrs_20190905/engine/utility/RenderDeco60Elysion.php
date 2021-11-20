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

class RenderDeco60Elysion {
	private static $Instance = null;
	
	private function __construct(){}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return RenderDeco60Elysion
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new RenderDeco60Elysion();
		}
		return self::$Instance;
	}

	public function render ( $infos ){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		// $GeneratedJavaScriptObj = $CurrentSetObj->getInstanceOfGeneratedJavaScriptObj();
		// $RenderLayoutObj = RenderLayout::getInstance();
		
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " Start"), false );
		
		$mn = $infos['module']['module_name'];
		// $m = $RenderLayoutObj->getModuleList();
		$TN = $ThemeDataObj->getThemeName();
		// $L = $RenderLayoutObj->getLayoutEntry($mn);		// we work locally on the dataset and save it at the end.
		
		$Content = "";
		$L['NomModule'] = $mnd = $mn; // module name (& default)
		$L['dx'] = $L['dy'] = 160;
		
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "Theme name =`".$TN."`"));
		$B = $ThemeDataObj->getThemeDataEntry($infos['block'].'G');
		$mcn = $infos['module']['module_container_name'];
		$Block = $infos['block'];
		switch ($infos['module_display_mode']) {
			case "bypass":
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " display module mode is 'bypass'"));
				$L['px'] = $infos['admin_control']['px'];
				$L['py'] = $infos['admin_control']['py'];
				break;
			case "normal":
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " display module mode is 'normal'"));
				break;
			case "menu":
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " display module mode is 'menu' : ".$mn));
				$mnd = $infos['backup']['module_name'];
				$B = $ThemeDataObj->getThemeDataEntry($infos['block'].'M');
				$L['px'] = 0;
				$L['py'] = 0;
				$mcn .= "_" . $infos['module']['module_name'];
				$Block .= "M";
				break;
		}
		// if ( $L['lyoc_module_zindex'] != 0 ) { $infos['module_z_index'] = $L['lyoc_module_zindex']; }
		// --------------------------------------------------------------------------------------------
		// x1 x2
		// x3 x4
		// $B = $ThemeDataObj->getThemeDataEntry($infos['block'].'G');		
		// $L['pos_x1_ex22'] = $L['px'] + max ( $B['ex11_x'], $B['ex21_x'], $B['ex31_x'], $B['ex41_x'], $B['ex51_x']);
		// $L['pos_y1_ex22'] = $L['py'] + max ( $B['ex11_y'], $B['ex12_y'], $B['ex13_y'], $B['ex14_y'], $B['ex15_y']);
		// $L['pos_x2_ex22'] = $L['px'] + $L['dx'] - max ( $B['ex15_x'], $B['ex25_x'], $B['ex35_x'], $B['ex45_x'], $B['ex55_x'] );
		$L['pos_x1_ex22'] = max ( $B['ex11_x'], $B['ex21_x'], $B['ex31_x'], $B['ex41_x'], $B['ex51_x']);
		$L['pos_y1_ex22'] = max ( $B['ex11_y'], $B['ex12_y'], $B['ex13_y'], $B['ex14_y'], $B['ex15_y']);
		$L['pos_x2_ex22'] = $L['dx'] - max ( $B['ex15_x'], $B['ex25_x'], $B['ex35_x'], $B['ex45_x'], $B['ex55_x'] );
		$L['pos_y2_ex22'] = &$L['pos_y1_ex22'];
		$L['pos_x3_ex22'] = &$L['pos_x1_ex22'];
		// $L['pos_y3_ex22'] = $L['py'] + $L['dy'] - max ( $B['ex51_y'], $B['ex52_y'], $B['ex53_y'], $B['ex54_y'], $B['ex55_y'] );
		$L['pos_y3_ex22'] = $L['dy'] - max ( $B['ex51_y'], $B['ex52_y'], $B['ex53_y'], $B['ex54_y'], $B['ex55_y'] );
		$L['pos_x4_ex22'] = &$L['pos_x2_ex22'];
		$L['pos_y4_ex22'] = &$L['pos_y3_ex22'];
		
		$L['dim_x_ex22'] = $L['pos_x2_ex22'] - $L['pos_x1_ex22'];
		$L['dim_y_ex22'] = $L['pos_y3_ex22'] - $L['pos_y1_ex22'];
		
		// Adjust values depending on decoration 
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " mn=".$mn."; B['ex11_x']=".$B['ex11_x']."; B['ex21_x']=".$B['ex21_x']."; B['ex31_x']=".$B['ex31_x']."; L['px']=".$L['px']."; infos['block']=".$infos['block']."; L['dim_x_ex22']=".$L['pos_x2_ex22']." - ".$L['pos_x1_ex22']." = ".$L['dim_x_ex22']));
		
		$CV = ($L['dim_x_ex22'] - $B['ex12_x'] - $B['ex14_x']);	if ( $CV <= 0 ) { $CV = abs($CV) + 8; $L['dim_x_ex22'] += $CV; $L['dx'] += $CV; $L['pos_x2_ex22'] += $CV; $L['pos_x4_ex22'] = &$L['pos_x2_ex22']; }
		$CV = ($L['dim_x_ex22'] - $B['ex52_x'] - $B['ex54_x']);	if ( $CV <= 0 ) { $CV = abs($CV) + 8; $L['dim_x_ex22'] += $CV; $L['dx'] += $CV; $L['pos_x2_ex22'] += $CV; $L['pos_x4_ex22'] = &$L['pos_x2_ex22']; }
		$CV = ($L['dim_y_ex22'] - $B['ex21_y'] - $B['ex41_y']);	if ( $CV <= 0 ) { $CV = abs($CV) + 8; $L['dim_y_ex22'] += $CV; $L['dy'] += $CV; $L['pos_y3_ex22'] += $CV; $L['pos_y4_ex22'] = &$L['pos_y3_ex22']; }
		$CV = ($L['dim_y_ex22'] - $B['ex25_y'] - $B['ex45_y']);	if ( $CV <= 0 ) { $CV = abs($CV) + 8; $L['dim_y_ex22'] += $CV; $L['dy'] += $CV; $L['pos_y3_ex22'] += $CV; $L['pos_y4_ex22'] = &$L['pos_y3_ex22']; }
		
		$L['dim_x_ex13'] = $L['dim_x_ex22'] - $B['ex12_x'] - $B['ex14_x'] ;
		$L['dim_x_ex53'] = $L['dim_x_ex22'] - $B['ex52_x'] - $B['ex54_x'] ;
		$L['dim_y_ex31'] = $L['dim_y_ex22'] - $B['ex21_y'] - $B['ex41_y'] ;
		$L['dim_y_ex35'] = $L['dim_y_ex22'] - $B['ex25_y'] - $B['ex45_y'] ;
		
		// --------------------------------------------------------------------------------------------
		$L['pos_x_ex11'] = $L['pos_x1_ex22'] - $B['ex11_x'];	$L['pos_y_ex11'] = $L['pos_y1_ex22'] - $B['ex11_y'];
		$L['pos_x_ex12'] = &$L['pos_x1_ex22']; 					$L['pos_y_ex12'] = $L['pos_y1_ex22'] - $B['ex12_y'];
		$L['pos_x_ex13'] = $L['pos_x1_ex22'] + $B['ex12_x'];	$L['pos_y_ex13'] = $L['pos_y1_ex22'] - $B['ex13_y'];
		$L['pos_x_ex14'] = $L['pos_x2_ex22'] - $B['ex14_x'];	$L['pos_y_ex14'] = $L['pos_y1_ex22'] - $B['ex14_y'];
		$L['pos_x_ex15'] = &$L['pos_x2_ex22'];					$L['pos_y_ex15'] = $L['pos_y1_ex22'] - $B['ex15_y'];
		
		$L['pos_x_ex21'] = $L['pos_x1_ex22'] - $B['ex21_x'];	$L['pos_y_ex21'] = &$L['pos_y1_ex22'];
		$L['pos_x_ex22'] = &$L['pos_x1_ex22'];					$L['pos_y_ex22'] = &$L['pos_y1_ex22'];
		$L['pos_x_ex25'] = &$L['pos_x2_ex22']; 					$L['pos_y_ex25'] = &$L['pos_y1_ex22'];
		
		$L['pos_x_ex31'] = $L['pos_x1_ex22'] - $B['ex31_x'];	$L['pos_y_ex31'] = $L['pos_y1_ex22'] + $B['ex21_y'];
		$L['pos_x_ex35'] = &$L['pos_x2_ex22'];					$L['pos_y_ex35'] = $L['pos_y1_ex22'] + $B['ex25_y'];
		
		$L['pos_x_ex41'] = $L['pos_x1_ex22'] - $B['ex41_x'];	$L['pos_y_ex41'] = $L['pos_y3_ex22'] - $B['ex41_y'];
		$L['pos_x_ex45'] = &$L['pos_x2_ex22']; 					$L['pos_y_ex45'] = $L['pos_y3_ex22'] - $B['ex45_y'];
		
		$L['pos_x_ex51'] = $L['pos_x1_ex22'] - $B['ex51_x'];	$L['pos_y_ex51'] = &$L['pos_y3_ex22'];
		$L['pos_x_ex52'] = &$L['pos_x1_ex22']; 					$L['pos_y_ex52'] = &$L['pos_y3_ex22'];
		$L['pos_x_ex53'] = $L['pos_x1_ex22'] + $B['ex52_x'];	$L['pos_y_ex53'] = &$L['pos_y3_ex22'];
		$L['pos_x_ex54'] = $L['pos_x2_ex22'] - $B['ex54_x'];	$L['pos_y_ex54'] = &$L['pos_y3_ex22'];
		$L['pos_x_ex55'] = &$L['pos_x2_ex22'];					$L['pos_y_ex55'] = &$L['pos_y3_ex22'];
		
		// --------------------------------------------------------------------------------------------
		$L['pos_x_in11'] = &$L['pos_x1_ex22'];								$L['pos_y_in11'] = &$L['pos_y1_ex22'];
		$L['pos_x_in12'] = $L['pos_x1_ex22'] + $B['in11_x']; 				$L['pos_y_in12'] = &$L['pos_y1_ex22'];
		$L['pos_x_in13'] = $L['pos_x1_ex22'] + $B['in11_x']+ $B['in12_x'];	$L['pos_y_in13'] = &$L['pos_y1_ex22'];
		$L['pos_x_in14'] = $L['pos_x2_ex22'] - $B['in14_x']- $B['in15_x'];	$L['pos_y_in14'] = &$L['pos_y1_ex22'];
		$L['pos_x_in15'] = $L['pos_x2_ex22'] - $B['in15_x'];				$L['pos_y_in15'] = &$L['pos_y1_ex22'];
		
		$L['pos_x_in21'] = &$L['pos_x1_ex22'];					$L['pos_y_in21'] = $L['pos_y1_ex22'] + $B['in11_y'];
		$L['pos_x_in25'] = $L['pos_x2_ex22'] - $B['in25_x']; 	$L['pos_y_in25'] = $L['pos_y1_ex22'] + $B['in15_y'];
		
		$L['pos_x_in31'] = &$L['pos_x1_ex22'];					$L['pos_y_in31'] = $L['pos_y1_ex22'] + $B['in11_y'] + $B['in21_y'];
		$L['pos_x_in35'] = $L['pos_x2_ex22'] - $B['in35_x'];	$L['pos_y_in35'] = $L['pos_y1_ex22'] + $B['in15_y'] + $B['in25_y'];
		
		$L['pos_x_in41'] = &$L['pos_x1_ex22'];					$L['pos_y_in41'] = $L['pos_y3_ex22'] - $B['in41_y'] - $B['in51_y'];
		$L['pos_x_in45'] = $L['pos_x2_ex22'] - $B['in45_x']; 	$L['pos_y_in45'] = $L['pos_y3_ex22'] - $B['in45_y'] - $B['in55_y'];
		
		$L['pos_x_in51'] = &$L['pos_x1_ex22'];					$L['pos_y_in51'] = $L['pos_y3_ex22'] - $B['in51_y'];
		$L['pos_x_in52'] = $L['pos_x1_ex22'] + $B['in51_x'];	$L['pos_y_in52'] = $L['pos_y3_ex22'] - $B['in52_y'];
		$L['pos_x_in53'] = $L['pos_x1_ex22'] + $B['in52_x'];	$L['pos_y_in53'] = $L['pos_y3_ex22'] - $B['in53_y'];
		$L['pos_x_in54'] = $L['pos_x2_ex22'] - $B['in54_x'];	$L['pos_y_in54'] = $L['pos_y3_ex22'] - $B['in54_y'];
		$L['pos_x_in55'] = $L['pos_x2_ex22'] - $B['in55_x'];	$L['pos_y_in55'] = $L['pos_y3_ex22'] - $B['in55_y'];
		
		// --------------------------------------------------------------------------------------------
		
		$L['dim_x_in13'] = $L['dim_x_ex22'] - $B['in11_x'] - $B['in12_x'] - $B['in14_x'] - $B['in15_x'];
		$L['dim_x_in53'] = $L['dim_x_ex22'] - $B['in51_x'] - $B['in52_x'] - $B['in54_x'] - $B['in55_x'];
		$L['dim_y_in31'] = $L['dim_y_ex22'] - $B['in11_y'] - $B['in21_y'] - $B['in41_y'] - $B['in51_y'];
		$L['dim_y_in35'] = $L['dim_y_ex22'] - $B['in15_y'] - $B['in25_y'] - $B['in45_y'] - $B['in55_y'];
		
		// --------------------------------------------------------------------------------------------
		$ThemeDataObj->setThemeDataEntry('theme_module_internal_width', $L['dim_x_ex22'] - 16);
		$ThemeDataObj->setThemeDataEntry('theme_module_internal_height', $L['dim_y_ex22'] - 16);
		$DivIdList = array();
		$DivList = array (
			"ex11", "ex12", "ex13", "ex14", "ex15", "ex21", "ex22", "ex25", "ex31", "ex35", "ex41", "ex45",	"ex51", "ex52", "ex53", "ex54", "ex55",
			"in11", "in12", "in13", "in14", "in15", "in21", "in25", "in31", "in35", "in41", "in45", "in51", "in52", "in53", "in54", "in55"
		);
		foreach ( $DivList as $A ) { $DivIdList[$A] = "id='" . $mn . "_".$A."' "; }
		
		$Content = "
	<!-- _______________________________________ Decoration of module ".$mn." (Begin) _______________________________________ -->\r
	";
		$containerStyle = (strlen($infos['module']['module_container_style']) > 0 ) ? " ".$infos['module']['module_container_style']." " : "";
		$Content .= "
		<div id='".$mcn."' style='position:absolute; left:".$L['px']."px; top:".$L['py']."px; width:".$L['dx']."px; height:".$L['dy']."px; ".$containerStyle .";' class='".$TN . $infos['block']."'>\r
		<div ".$DivIdList['ex11']." class='".$TN . $Block."_ex11' style='left: ".$L['pos_x_ex11']."px;	top: ".$L['pos_y_ex11']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex11_x']."px;		height:".$B['ex11_y']."px;'></div>\r
		<div ".$DivIdList['ex12']." class='".$TN . $Block."_ex12' style='left: ".$L['pos_x_ex12']."px;	top: ".$L['pos_y_ex12']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex12_x']."px;		height:".$B['ex12_y']."px;'></div>\r
		<div ".$DivIdList['ex13']." class='".$TN . $Block."_ex13' style='left: ".$L['pos_x_ex13']."px;	top: ".$L['pos_y_ex13']."px; z-index: ".$infos['module_z_index']."; width:".$L['dim_x_ex13']."px;	height:".$B['ex13_y']."px;'></div>\r
		<div ".$DivIdList['ex14']." class='".$TN . $Block."_ex14' style='left: ".$L['pos_x_ex14']."px;	top: ".$L['pos_y_ex14']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex14_x']."px;		height:".$B['ex14_y']."px;'></div>\r
		<div ".$DivIdList['ex15']." class='".$TN . $Block."_ex15' style='left: ".$L['pos_x_ex15']."px;	top: ".$L['pos_y_ex15']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex15_x']."px;		height:".$B['ex15_y']."px;'></div>\r
		<div ".$DivIdList['ex21']." class='".$TN . $Block."_ex21' style='left: ".$L['pos_x_ex21']."px;	top: ".$L['pos_y_ex21']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex21_x']."px;		height:".$B['ex21_y']."px;'></div>\r
		<div ".$DivIdList['ex25']." class='".$TN . $Block."_ex25' style='left: ".$L['pos_x_ex25']."px;	top: ".$L['pos_y_ex25']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex25_x']."px;		height:".$B['ex25_y']."px;'></div>\r
		<div ".$DivIdList['ex31']." class='".$TN . $Block."_ex31' style='left: ".$L['pos_x_ex31']."px;	top: ".$L['pos_y_ex31']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex31_x']."px;		height:".$L['dim_y_ex31']."px;'></div>\r
		<div ".$DivIdList['ex35']." class='".$TN . $Block."_ex35' style='left: ".$L['pos_x_ex35']."px;	top: ".$L['pos_y_ex35']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex35_x']."px;		height:".$L['dim_y_ex35']."px;'></div>\r
		<div ".$DivIdList['ex41']." class='".$TN . $Block."_ex41' style='left: ".$L['pos_x_ex41']."px;	top: ".$L['pos_y_ex41']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex41_x']."px;		height:".$B['ex41_y']."px;'></div>\r
		<div ".$DivIdList['ex45']." class='".$TN . $Block."_ex45' style='left: ".$L['pos_x_ex45']."px;	top: ".$L['pos_y_ex45']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex45_x']."px;		height:".$B['ex45_y']."px;'></div>\r
		<div ".$DivIdList['ex51']." class='".$TN . $Block."_ex51' style='left: ".$L['pos_x_ex51']."px;	top: ".$L['pos_y_ex51']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex51_x']."px;		height:".$B['ex51_y']."px;'></div>\r
		<div ".$DivIdList['ex52']." class='".$TN . $Block."_ex52' style='left: ".$L['pos_x_ex52']."px;	top: ".$L['pos_y_ex52']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex52_x']."px;		height:".$B['ex52_y']."px;'></div>\r
		<div ".$DivIdList['ex53']." class='".$TN . $Block."_ex53' style='left: ".$L['pos_x_ex53']."px;	top: ".$L['pos_y_ex53']."px; z-index: ".$infos['module_z_index']."; width:".$L['dim_x_ex53']."px;	height:".$B['ex53_y']."px;'></div>\r
		<div ".$DivIdList['ex54']." class='".$TN . $Block."_ex54' style='left: ".$L['pos_x_ex54']."px;	top: ".$L['pos_y_ex54']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex54_x']."px;		height:".$B['ex54_y']."px;'></div>\r
		<div ".$DivIdList['ex55']." class='".$TN . $Block."_ex55' style='left: ".$L['pos_x_ex55']."px;	top: ".$L['pos_y_ex55']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex55_x']."px;		height:".$B['ex55_y']."px;'></div>\r";
		
		// $bts->LMObj->logDebug($B, "B in effect");
		if ( $B['in11_e'] == 1 ) { $Content .= "<div ".$DivIdList['in11']." class='".$TN . $Block."_in11' style='left: ".$L['pos_x_in11']."px;	top: ".$L['pos_y_in11']."px; width:".$L['in11_x']."px;		height:".$B['in11_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in12_e'] == 1 ) { $Content .= "<div ".$DivIdList['in12']." class='".$TN . $Block."_in12' style='left: ".$L['pos_x_in12']."px;	top: ".$L['pos_y_in12']."px; width:".$L['in12_x']."px;		height:".$B['in12_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in13_e'] == 1 ) { $Content .= "<div ".$DivIdList['in13']." class='".$TN . $Block."_in13' style='left: ".$L['pos_x_in13']."px;	top: ".$L['pos_y_in13']."px; width:".$L['dim_x_in13']."px;	height:".$B['in13_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in14_e'] == 1 ) { $Content .= "<div ".$DivIdList['in14']." class='".$TN . $Block."_in14' style='left: ".$L['pos_x_in14']."px;	top: ".$L['pos_y_in14']."px; width:".$L['in14_x']."px;		height:".$B['in14_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in15_e'] == 1 ) { $Content .= "<div ".$DivIdList['in15']." class='".$TN . $Block."_in15' style='left: ".$L['pos_x_in15']."px;	top: ".$L['pos_y_in15']."px; width:".$L['in15_x']."px;		height:".$B['in15_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in21_e'] == 1 ) { $Content .= "<div ".$DivIdList['in21']." class='".$TN . $Block."_in21' style='left: ".$L['pos_x_in21']."px;	top: ".$L['pos_y_in21']."px; width:".$L['in21_x']."px;		height:".$B['in21_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in25_e'] == 1 ) { $Content .= "<div ".$DivIdList['in25']." class='".$TN . $Block."_in25' style='left: ".$L['pos_x_in25']."px;	top: ".$L['pos_y_in25']."px; width:".$L['in25_x']."px;		height:".$B['in25_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in31_e'] == 1 ) { $Content .= "<div ".$DivIdList['in31']." class='".$TN . $Block."_in31' style='left: ".$L['pos_x_in31']."px;	top: ".$L['pos_y_in31']."px; width:".$L['in31_x']."px;		height:".$L['dim_y_in31']."px;	z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in35_e'] == 1 ) { $Content .= "<div ".$DivIdList['in35']." class='".$TN . $Block."_in35' style='left: ".$L['pos_x_in35']."px;	top: ".$L['pos_y_in35']."px; width:".$L['in35_x']."px;		height:".$L['dim_y_in35']."px;	z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in41_e'] == 1 ) { $Content .= "<div ".$DivIdList['in41']." class='".$TN . $Block."_in41' style='left: ".$L['pos_x_in41']."px;	top: ".$L['pos_y_in41']."px; width:".$L['in41_x']."px;		height:".$B['in41_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in45_e'] == 1 ) { $Content .= "<div ".$DivIdList['in45']." class='".$TN . $Block."_in45' style='left: ".$L['pos_x_in45']."px;	top: ".$L['pos_y_in45']."px; width:".$L['in45_x']."px;		height:".$B['in45_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in51_e'] == 1 ) { $Content .= "<div ".$DivIdList['in51']." class='".$TN . $Block."_in51' style='left: ".$L['pos_x_in51']."px;	top: ".$L['pos_y_in51']."px; width:".$L['in51_x']."px;		height:".$B['in51_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in52_e'] == 1 ) { $Content .= "<div ".$DivIdList['in52']." class='".$TN . $Block."_in52' style='left: ".$L['pos_x_in52']."px;	top: ".$L['pos_y_in52']."px; width:".$L['in52_x']."px;		height:".$B['in52_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in53_e'] == 1 ) { $Content .= "<div ".$DivIdList['in53']." class='".$TN . $Block."_in53' style='left: ".$L['pos_x_in53']."px;	top: ".$L['pos_y_in53']."px; width:".$L['dim_x_in53']."px;	height:".$B['in53_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in54_e'] == 1 ) { $Content .= "<div ".$DivIdList['in54']." class='".$TN . $Block."_in54' style='left: ".$L['pos_x_in54']."px;	top: ".$L['pos_y_in54']."px; width:".$L['in54_x']."px;		height:".$B['in54_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in55_e'] == 1 ) { $Content .= "<div ".$DivIdList['in55']." class='".$TN . $Block."_in55' style='left: ".$L['pos_x_in55']."px;	top: ".$L['pos_y_in55']."px; width:".$L['in55_x']."px;		height:".$B['in55_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }

		$Content .= "
		<div ".$DivIdList['ex22']." class='".$TN.$Block."_ex22' style='left: ".$L['pos_x_ex22']."px;	top: ".$L['pos_y_ex22']."px; width: ".$L['dim_x_ex22']."px ; height: ".$L['dim_y_ex22']."px; overflow: auto; z-index: ".$infos['module_z_index'].";'>\r
		<!-- _______________________________________ Decoration of module ".$mn." (end)_______________________________________ -->\r
		";

		$argAddModule = "{
			ex11 : {	'isEnabled':1,	'DimX':".$B['ex11_x'].",	'DimY':".$B['ex11_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex12 : {	'isEnabled':1,	'DimX':".$B['ex12_x'].",	'DimY':".$B['ex12_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex13 : {	'isEnabled':1,	'DimX':".$B['ex13_x'].",	'DimY':".$B['ex13_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex14 : {	'isEnabled':1,	'DimX':".$B['ex14_x'].",	'DimY':".$B['ex14_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex15 : {	'isEnabled':1,	'DimX':".$B['ex15_x'].",	'DimY':".$B['ex15_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex21 : {	'isEnabled':1,	'DimX':".$B['ex21_x'].",	'DimY':".$B['ex21_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex22 : {	'isEnabled':1,	'DimX':".$B['ex22_x'].",	'DimY':".$B['ex22_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex25 : {	'isEnabled':1,	'DimX':".$B['ex25_x'].",	'DimY':".$B['ex25_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex31 : {	'isEnabled':1,	'DimX':".$B['ex31_x'].",	'DimY':".$B['ex31_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex35 : {	'isEnabled':1,	'DimX':".$B['ex35_x'].",	'DimY':".$B['ex35_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex41 : {	'isEnabled':1,	'DimX':".$B['ex41_x'].",	'DimY':".$B['ex41_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex45 : {	'isEnabled':1,	'DimX':".$B['ex45_x'].",	'DimY':".$B['ex45_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex51 : {	'isEnabled':1,	'DimX':".$B['ex51_x'].",	'DimY':".$B['ex51_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex52 : {	'isEnabled':1,	'DimX':".$B['ex52_x'].",	'DimY':".$B['ex52_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex53 : {	'isEnabled':1,	'DimX':".$B['ex53_x'].",	'DimY':".$B['ex53_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex54 : {	'isEnabled':1,	'DimX':".$B['ex54_x'].",	'DimY':".$B['ex54_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex55 : {	'isEnabled':1,	'DimX':".$B['ex55_x'].",	'DimY':".$B['ex55_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			";
			$argAddModuleIn = "";
			$argAddModuleIn .= ( $B['in11_e'] == 1 ) ? "in11 : {	'isEnabled':1,	'DimX':".$B['in11_x'].",	'DimY':".$B['in11_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	}," : "in11 : {	'isEnabled':false },";
			$argAddModuleIn .= ( $B['in12_e'] == 1 ) ? "in12 : {	'isEnabled':1,	'DimX':".$B['in12_x'].",	'DimY':".$B['in12_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	}," : "in12 : {	'isEnabled':false },";
			$argAddModuleIn .= ( $B['in13_e'] == 1 ) ? "in13 : {	'isEnabled':1,	'DimX':".$B['in13_x'].",	'DimY':".$B['in13_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	}," : "in13 : {	'isEnabled':false },";
			$argAddModuleIn .= ( $B['in14_e'] == 1 ) ? "in14 : {	'isEnabled':1,	'DimX':".$B['in14_x'].",	'DimY':".$B['in14_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	}," : "in14 : {	'isEnabled':false },";
			$argAddModuleIn .= ( $B['in15_e'] == 1 ) ? "in15 : {	'isEnabled':1,	'DimX':".$B['in15_x'].",	'DimY':".$B['in15_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	}," : "in15 : {	'isEnabled':false },";
			$argAddModuleIn .= ( $B['in21_e'] == 1 ) ? "in21 : {	'isEnabled':1,	'DimX':".$B['in21_x'].",	'DimY':".$B['in21_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	}," : "in21 : {	'isEnabled':false },";
			$argAddModuleIn .= ( $B['in22_e'] == 1 ) ? "in22 : {	'isEnabled':1,	'DimX':".$B['in22_x'].",	'DimY':".$B['in22_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	}," : "in22 : {	'isEnabled':false },";
			$argAddModuleIn .= ( $B['in25_e'] == 1 ) ? "in25 : {	'isEnabled':1,	'DimX':".$B['in25_x'].",	'DimY':".$B['in25_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	}," : "in25 : {	'isEnabled':false },";
			$argAddModuleIn .= ( $B['in31_e'] == 1 ) ? "in31 : {	'isEnabled':1,	'DimX':".$B['in31_x'].",	'DimY':".$B['in31_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	}," : "in31 : {	'isEnabled':false },";
			$argAddModuleIn .= ( $B['in35_e'] == 1 ) ? "in35 : {	'isEnabled':1,	'DimX':".$B['in35_x'].",	'DimY':".$B['in35_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	}," : "in35 : {	'isEnabled':false },";
			$argAddModuleIn .= ( $B['in41_e'] == 1 ) ? "in41 : {	'isEnabled':1,	'DimX':".$B['in41_x'].",	'DimY':".$B['in41_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	}," : "in41 : {	'isEnabled':false },";
			$argAddModuleIn .= ( $B['in45_e'] == 1 ) ? "in45 : {	'isEnabled':1,	'DimX':".$B['in45_x'].",	'DimY':".$B['in45_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	}," : "in45 : {	'isEnabled':false },";
			$argAddModuleIn .= ( $B['in51_e'] == 1 ) ? "in51 : {	'isEnabled':1,	'DimX':".$B['in51_x'].",	'DimY':".$B['in51_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	}," : "in51 : {	'isEnabled':false },";
			$argAddModuleIn .= ( $B['in52_e'] == 1 ) ? "in52 : {	'isEnabled':1,	'DimX':".$B['in52_x'].",	'DimY':".$B['in52_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	}," : "in52 : {	'isEnabled':false },";
			$argAddModuleIn .= ( $B['in53_e'] == 1 ) ? "in53 : {	'isEnabled':1,	'DimX':".$B['in53_x'].",	'DimY':".$B['in53_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	}," : "in53 : {	'isEnabled':false },";
			$argAddModuleIn .= ( $B['in54_e'] == 1 ) ? "in54 : {	'isEnabled':1,	'DimX':".$B['in54_x'].",	'DimY':".$B['in54_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	}," : "in54 : {	'isEnabled':false },";
			$argAddModuleIn .= ( $B['in55_e'] == 1 ) ? "in55 : {	'isEnabled':1,	'DimX':".$B['in55_x'].",	'DimY':".$B['in55_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	}," : "in55 : {	'isEnabled':false },";

			$argAddModule .= "}";
		$CurrentSetObj->getInstanceOfGeneratedJavaScriptObj()->insertJavaScript('Command', "mod.AddModule ( '".$mn."' , 60 , '".$mcn."', ".$argAddModule.");");
//		$RenderLayoutObj->setLayoutEntry($mn, $L);		// Saving the updated dataset
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " End"), false );
		
		switch ( $infos['mode'] ) {
			case 0 :	echo $Content;		break;
			case 1 :	return $Content;	break;
		}
		
	}
}