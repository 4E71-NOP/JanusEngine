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
// 		$GeneratedJavaScriptObj = $CurrentSetObj->getInstanceOfGeneratedJavaScriptObj();
		$RenderLayoutObj = RenderLayout::getInstance();
		
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " Start"), false );
		
		$mn = $infos['module']['module_name'];
		$m = $RenderLayoutObj->getModuleList();
		$TN = $ThemeDataObj->getThemeName();
		$L = $RenderLayoutObj->getLayoutEntry($mn);		// we work locally on the dataset and save it at the end.
		
		$Content = "";
		$L['NomModule'] = $mnd = $mn; // module name (& default)
		
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "Theme name =`".$TN."`"));
		$B = $ThemeDataObj->getThemeDataEntry($infos['block'].'G');
		$mcn = $infos['module']['module_container_name'];
		switch ($infos['affiche_module_mode']) {
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
				break;
		}
		if ( $L['lyoc_module_zindex'] != 0 ) { $infos['module_z_index'] = $L['lyoc_module_zindex']; }
		// --------------------------------------------------------------------------------------------
		// x1 x2
		// x3 x4
		$B = $ThemeDataObj->getThemeDataEntry($infos['block'].'G');
		
		
// 		$L['pos_x1_ex22'] = $L['px'] + max ( $B['ex11_x'], $B['ex21_x'], $B['ex31_x'], $B['ex41_x'], $B['ex51_x']);
// 		$L['pos_y1_ex22'] = $L['py'] + max ( $B['ex11_y'], $B['ex12_y'], $B['ex13_y'], $B['ex14_y'], $B['ex15_y']);
// 		$L['pos_x2_ex22'] = $L['px'] + $L['dx'] - max ( $B['ex15_x'], $B['ex25_x'], $B['ex35_x'], $B['ex45_x'], $B['ex55_x'] );
		$L['pos_x1_ex22'] = max ( $B['ex11_x'], $B['ex21_x'], $B['ex31_x'], $B['ex41_x'], $B['ex51_x']);
		$L['pos_y1_ex22'] = max ( $B['ex11_y'], $B['ex12_y'], $B['ex13_y'], $B['ex14_y'], $B['ex15_y']);
		$L['pos_x2_ex22'] = $L['dx'] - max ( $B['ex15_x'], $B['ex25_x'], $B['ex35_x'], $B['ex45_x'], $B['ex55_x'] );
		$L['pos_y2_ex22'] = &$L['pos_y1_ex22'];
		$L['pos_x3_ex22'] = &$L['pos_x1_ex22'];
// 		$L['pos_y3_ex22'] = $L['py'] + $L['dy'] - max ( $B['ex51_y'], $B['ex52_y'], $B['ex53_y'], $B['ex54_y'], $B['ex55_y'] );
		$L['pos_y3_ex22'] = $L['dy'] - max ( $B['ex51_y'], $B['ex52_y'], $B['ex53_y'], $B['ex54_y'], $B['ex55_y'] );
		$L['pos_x4_ex22'] = &$L['pos_x2_ex22'];
		$L['pos_y4_ex22'] = &$L['pos_y3_ex22'];
		
		$L['dim_x_ex22'] = $L['pos_x2_ex22'] - $L['pos_x1_ex22'];
		$L['dim_y_ex22'] = $L['pos_y3_ex22'] - $L['pos_y1_ex22'];
		
		// Adjust values depending on decoration 
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "mn=".$mn."; B['ex11_x']=".$B['ex11_x']."; B['ex21_x']=".$B['ex21_x']."; B['ex31_x']=".$B['ex31_x']."; L['px']=".$L['px']."; infos['block']=".$infos['block']."; L['dim_x_ex22']=".$L['pos_x2_ex22']." - ".$L['pos_x1_ex22']." = ".$L['dim_x_ex22']));
		
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
		$ThemeDataObj->setThemeDataEntry('theme_module_largeur_interne', $L['dim_x_ex22'] - 16);
		$ThemeDataObj->setThemeDataEntry('theme_module_hauteur_interne', $L['dim_y_ex22'] - 16);
		$DivIdList = array();
		$DivList = array ( "ex11", "ex12", "ex13", "ex21", "ex22", "ex23", "ex31", "ex32", "ex33" );
		foreach ( $DivList as $A ) { $DivIdList[$A] = "id='" . $mn . "_".$A."' "; }
		
		$Content = "
	<!-- _______________________________________ Decoration of module ".$mn." (Begin) _______________________________________ -->\r
	";
		$containerStyle = (strlen($infos['module']['module_container_style']) > 0 ) ? " ".$infos['module']['module_container_style']." " : "";
		$Content .= "
		<div id='".$mcn."' style='position:absolute; left:".$L['px']."px; top:".$L['py']."px; width:".$L['dx']."px; height:".$L['dy']."px; ".$containerStyle .";' class='".$TN . $infos['block']."'>\r
		<div ".$DivIdList['ex11']." class='".$TN . $infos['block']."_ex11' style='left: ".$L['pos_x_ex11']."px;	top: ".$L['pos_y_ex11']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex11_x']."px;		height:".$B['ex11_y']."px;'></div>\r
		<div ".$DivIdList['ex12']." class='".$TN . $infos['block']."_ex12' style='left: ".$L['pos_x_ex12']."px;	top: ".$L['pos_y_ex12']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex12_x']."px;		height:".$B['ex12_y']."px;'></div>\r
		<div ".$DivIdList['ex13']." class='".$TN . $infos['block']."_ex13' style='left: ".$L['pos_x_ex13']."px;	top: ".$L['pos_y_ex13']."px; z-index: ".$infos['module_z_index']."; width:".$L['dim_x_ex13']."px;	height:".$B['ex13_y']."px;'></div>\r
		<div ".$DivIdList['ex14']." class='".$TN . $infos['block']."_ex14' style='left: ".$L['pos_x_ex14']."px;	top: ".$L['pos_y_ex14']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex14_x']."px;		height:".$B['ex14_y']."px;'></div>\r
		<div ".$DivIdList['ex15']." class='".$TN . $infos['block']."_ex15' style='left: ".$L['pos_x_ex15']."px;	top: ".$L['pos_y_ex15']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex15_x']."px;		height:".$B['ex15_y']."px;'></div>\r
		<div ".$DivIdList['ex21']." class='".$TN . $infos['block']."_ex21' style='left: ".$L['pos_x_ex21']."px;	top: ".$L['pos_y_ex21']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex21_x']."px;		height:".$B['ex21_y']."px;'></div>\r
		<div ".$DivIdList['ex25']." class='".$TN . $infos['block']."_ex25' style='left: ".$L['pos_x_ex25']."px;	top: ".$L['pos_y_ex25']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex25_x']."px;		height:".$B['ex25_y']."px;'></div>\r
		<div ".$DivIdList['ex31']." class='".$TN . $infos['block']."_ex31' style='left: ".$L['pos_x_ex31']."px;	top: ".$L['pos_y_ex31']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex31_x']."px;		height:".$L['dim_y_ex31']."px;'></div>\r
		<div ".$DivIdList['ex35']." class='".$TN . $infos['block']."_ex35' style='left: ".$L['pos_x_ex35']."px;	top: ".$L['pos_y_ex35']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex35_x']."px;		height:".$L['dim_y_ex35']."px;'></div>\r
		<div ".$DivIdList['ex41']." class='".$TN . $infos['block']."_ex41' style='left: ".$L['pos_x_ex41']."px;	top: ".$L['pos_y_ex41']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex41_x']."px;		height:".$B['ex41_y']."px;'></div>\r
		<div ".$DivIdList['ex45']." class='".$TN . $infos['block']."_ex45' style='left: ".$L['pos_x_ex45']."px;	top: ".$L['pos_y_ex45']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex45_x']."px;		height:".$B['ex45_y']."px;'></div>\r
		<div ".$DivIdList['ex51']." class='".$TN . $infos['block']."_ex51' style='left: ".$L['pos_x_ex51']."px;	top: ".$L['pos_y_ex51']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex51_x']."px;		height:".$B['ex51_y']."px;'></div>\r
		<div ".$DivIdList['ex52']." class='".$TN . $infos['block']."_ex52' style='left: ".$L['pos_x_ex52']."px;	top: ".$L['pos_y_ex52']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex52_x']."px;		height:".$B['ex52_y']."px;'></div>\r
		<div ".$DivIdList['ex53']." class='".$TN . $infos['block']."_ex53' style='left: ".$L['pos_x_ex53']."px;	top: ".$L['pos_y_ex53']."px; z-index: ".$infos['module_z_index']."; width:".$L['dim_x_ex53']."px;	height:".$B['ex53_y']."px;'></div>\r
		<div ".$DivIdList['ex54']." class='".$TN . $infos['block']."_ex54' style='left: ".$L['pos_x_ex54']."px;	top: ".$L['pos_y_ex54']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex54_x']."px;		height:".$B['ex54_y']."px;'></div>\r
		<div ".$DivIdList['ex55']." class='".$TN . $infos['block']."_ex55' style='left: ".$L['pos_x_ex55']."px;	top: ".$L['pos_y_ex55']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex55_x']."px;		height:".$B['ex55_y']."px;'></div>\r";
		
		$bts->LMObj->logDebug($B, "B in effect");
		if ( $B['in11_e'] == 1 ) { $Content .= "<div ".$DivIdList['in11']." class='".$TN . $infos['block']."_in11' style='left: ".$L['pos_x_in11']."px;	top: ".$L['pos_y_in11']."px; width:".$L['in11_x']."px;		height:".$B['in11_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in12_e'] == 1 ) { $Content .= "<div ".$DivIdList['in12']." class='".$TN . $infos['block']."_in12' style='left: ".$L['pos_x_in12']."px;	top: ".$L['pos_y_in12']."px; width:".$L['in12_x']."px;		height:".$B['in12_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in13_e'] == 1 ) { $Content .= "<div ".$DivIdList['in13']." class='".$TN . $infos['block']."_in13' style='left: ".$L['pos_x_in13']."px;	top: ".$L['pos_y_in13']."px; width:".$L['dim_x_in13']."px;	height:".$B['in13_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in14_e'] == 1 ) { $Content .= "<div ".$DivIdList['in14']." class='".$TN . $infos['block']."_in14' style='left: ".$L['pos_x_in14']."px;	top: ".$L['pos_y_in14']."px; width:".$L['in14_x']."px;		height:".$B['in14_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in15_e'] == 1 ) { $Content .= "<div ".$DivIdList['in15']." class='".$TN . $infos['block']."_in15' style='left: ".$L['pos_x_in15']."px;	top: ".$L['pos_y_in15']."px; width:".$L['in15_x']."px;		height:".$B['in15_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in21_e'] == 1 ) { $Content .= "<div ".$DivIdList['in21']." class='".$TN . $infos['block']."_in21' style='left: ".$L['pos_x_in21']."px;	top: ".$L['pos_y_in21']."px; width:".$L['in21_x']."px;		height:".$B['in21_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in25_e'] == 1 ) { $Content .= "<div ".$DivIdList['in25']." class='".$TN . $infos['block']."_in25' style='left: ".$L['pos_x_in25']."px;	top: ".$L['pos_y_in25']."px; width:".$L['in25_x']."px;		height:".$B['in25_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in31_e'] == 1 ) { $Content .= "<div ".$DivIdList['in31']." class='".$TN . $infos['block']."_in31' style='left: ".$L['pos_x_in31']."px;	top: ".$L['pos_y_in31']."px; width:".$L['in31_x']."px;		height:".$L['dim_y_in31']."px;	z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in35_e'] == 1 ) { $Content .= "<div ".$DivIdList['in35']." class='".$TN . $infos['block']."_in35' style='left: ".$L['pos_x_in35']."px;	top: ".$L['pos_y_in35']."px; width:".$L['in35_x']."px;		height:".$L['dim_y_in35']."px;	z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in41_e'] == 1 ) { $Content .= "<div ".$DivIdList['in41']." class='".$TN . $infos['block']."_in41' style='left: ".$L['pos_x_in41']."px;	top: ".$L['pos_y_in41']."px; width:".$L['in41_x']."px;		height:".$B['in41_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in45_e'] == 1 ) { $Content .= "<div ".$DivIdList['in45']." class='".$TN . $infos['block']."_in45' style='left: ".$L['pos_x_in45']."px;	top: ".$L['pos_y_in45']."px; width:".$L['in45_x']."px;		height:".$B['in45_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in51_e'] == 1 ) { $Content .= "<div ".$DivIdList['in51']." class='".$TN . $infos['block']."_in51' style='left: ".$L['pos_x_in51']."px;	top: ".$L['pos_y_in51']."px; width:".$L['in51_x']."px;		height:".$B['in51_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in52_e'] == 1 ) { $Content .= "<div ".$DivIdList['in52']." class='".$TN . $infos['block']."_in52' style='left: ".$L['pos_x_in52']."px;	top: ".$L['pos_y_in52']."px; width:".$L['in52_x']."px;		height:".$B['in52_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in53_e'] == 1 ) { $Content .= "<div ".$DivIdList['in53']." class='".$TN . $infos['block']."_in53' style='left: ".$L['pos_x_in53']."px;	top: ".$L['pos_y_in53']."px; width:".$L['dim_x_in53']."px;	height:".$B['in53_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in54_e'] == 1 ) { $Content .= "<div ".$DivIdList['in54']." class='".$TN . $infos['block']."_in54' style='left: ".$L['pos_x_in54']."px;	top: ".$L['pos_y_in54']."px; width:".$L['in54_x']."px;		height:".$B['in54_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		if ( $B['in55_e'] == 1 ) { $Content .= "<div ".$DivIdList['in55']." class='".$TN . $infos['block']."_in55' style='left: ".$L['pos_x_in55']."px;	top: ".$L['pos_y_in55']."px; width:".$L['in55_x']."px;		height:".$B['in55_y']."px;		z-index: ".($infos['module_z_index']+1).";'></div>\r"; }
		$Content .= "
		<div ".$DivIdList['ex22']." class='".$TN.$infos['block']."_ex22' style='left: ".$L['pos_x_ex22']."px;	top: ".$L['pos_y_ex22']."px; width: ".$L['dim_x_ex22']."px ; height: ".$L['dim_y_ex22']."px; overflow: auto; z-index: ".$infos['module_z_index'].";'>\r
		<!-- _______________________________________ Decoration of module ".$mn." (end)_______________________________________ -->\r
		";
		// ".$TN.$infos['block']."_t".$m[$mnd]['module_deco_default_text']." ".$TN.$infos['block']."_t_couleur_de_base
		$CurrentSetObj->getInstanceOfGeneratedJavaScriptObj()->insertJavaScript('Command', "mod.AddModule ( '".$mn."' , 60 );");
		$RenderLayoutObj->setLayoutEntry($mn, $L);		// Saving the updated dataset
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " End"), false );
		
		switch ( $infos['mode'] ) {
			case 0 :	echo $Content;		break;
			case 1 :	return $Content;	break;
		}
		
	}
}