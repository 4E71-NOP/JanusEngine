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

class RenderDeco40Elegance {
	private static $Instance = null;
	
	private function __construct(){}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return RenderDeco40Elegance
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new RenderDeco40Elegance();
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
		if ( $L['lyoc_module_zindex'] != 0 ) { $infos['module_z_index'] = $L['lyoc_module_zindex']; }
		// --------------------------------------------------------------------------------------------
		
// 		$L['pos_x1_ex22'] = $L['px'] + max ( $B['ex11_x'] , $B['ex21_x'] , $B['ex31_x'] );
// 		$L['pos_y1_ex22'] = $L['py'] + max ( $B['ex11_y'] , $B['ex12_y'] , $B['ex13_y'] );
		$L['pos_x1_ex22'] = max ( $B['ex11_x'] , $B['ex21_x'] , $B['ex31_x'] );
		$L['pos_y1_ex22'] = max ( $B['ex11_y'] , $B['ex12_y'] , $B['ex13_y'] );
// 		$L['pos_x2_ex22'] = $L['px'] + $L['dx'] - max ( $B['ex13_x'] , $B['ex23_x'] , $B['ex33_x'] );
		$L['pos_x2_ex22'] = $L['dx'] - max ( $B['ex13_x'] , $B['ex23_x'] , $B['ex33_x'] );
		$L['pos_y2_ex22'] = &$L['pos_y1_ex22'];
		$L['pos_x3_ex22'] = &$L['pos_x1_ex22'];
// 		$L['pos_y3_ex22'] = $L['py'] + $L['dy'] - max ( $B['ex31_y'] , $B['ex32_y'] , $B['ex33_y'] );
		$L['pos_y3_ex22'] = $L['dy'] - max ( $B['ex31_y'] , $B['ex32_y'] , $B['ex33_y'] );
		$L['pos_x4_ex22'] = &$L['pos_x2_ex22'];
		$L['pos_y4_ex22'] = &$L['pos_y3_ex22'];
		
		$L['dim_x_ex22'] = $L['pos_x2_ex22'] - $L['pos_x1_ex22'];
		$L['dim_y_ex22'] = $L['pos_y3_ex22'] - $L['pos_y1_ex22'];
		
		// Adjust values depending on decoration 
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " mn=".$mn."; B['ex11_x']=".$B['ex11_x']."; B['ex21_x']=".$B['ex21_x']."; B['ex31_x']=".$B['ex31_x']."; L['px']=".$L['px']."; infos['block']=".$infos['block']."; L['dim_x_ex22']=".$L['pos_x2_ex22']." - ".$L['pos_x1_ex22']." = ".$L['dim_x_ex22']));
		
		$CV = ($L['dim_x_ex22'] );	if ( $CV <= 0 ) { $CV = abs($CV) + 8; $L['dim_x_ex22'] += $CV; $L['dx'] += $CV; $L['pos_x2_ex22'] += $CV; $L['pos_x4_ex22'] = &$L['pos_x2_ex22']; }
		$CV = ($L['dim_x_ex22'] );	if ( $CV <= 0 ) { $CV = abs($CV) + 8; $L['dim_x_ex22'] += $CV; $L['dx'] += $CV; $L['pos_x2_ex22'] += $CV; $L['pos_x4_ex22'] = &$L['pos_x2_ex22']; }
		$CV = ($L['dim_y_ex22'] );	if ( $CV <= 0 ) { $CV = abs($CV) + 8; $L['dim_y_ex22'] += $CV; $L['dy'] += $CV; $L['pos_y3_ex22'] += $CV; $L['pos_y4_ex22'] = &$L['pos_y3_ex22']; }
		$CV = ($L['dim_y_ex22'] );	if ( $CV <= 0 ) { $CV = abs($CV) + 8; $L['dim_y_ex22'] += $CV; $L['dy'] += $CV; $L['pos_y3_ex22'] += $CV; $L['pos_y4_ex22'] = &$L['pos_y3_ex22']; }
		
		$L['dim_x_ex12'] = $L['dim_x_ex22'] - $B['ex11_x'] - $B['ex13_x'] ;
		$L['dim_x_ex32'] = $L['dim_x_ex22'] - $B['ex31_x'] - $B['ex33_x'] ;
		$L['dim_y_ex21'] = $L['dim_y_ex22'] - $B['ex12_y'] - $B['ex41_y'] ;
		$L['dim_y_ex23'] = $L['dim_y_ex22'] - $B['ex31_y'] - $B['ex45_y'] ;
		
		// --------------------------------------------------------------------------------------------
		$L['pos_x_ex11'] = $L['pos_x1_ex22'] - $B['ex11_x'];	$L['pos_y_ex11'] = $L['pos_y1_ex22'] - $B['ex11_y'];
		$L['pos_x_ex12'] = $L['pos_x1_ex22'];					$L['pos_y_ex12'] = $L['pos_y1_ex22'] - $B['ex12_y'];
		$L['pos_x_ex13'] = $L['pos_x2_ex22'];					$L['pos_y_ex13'] = $L['pos_y1_ex22'] - $B['ex13_y'];
		
		$L['pos_x_ex21'] = $L['pos_x1_ex22'] - $B['ex21_x'];	$L['pos_y_ex21'] = $L['pos_y1_ex22'];
		$L['pos_x_ex22'] = $L['pos_x1_ex22'];					$L['pos_y_ex22'] = $L['pos_y1_ex22'];
		$L['pos_x_ex23'] = $L['pos_x2_ex22'];					$L['pos_y_ex23'] = $L['pos_y1_ex22'];
		
		$L['pos_x_ex31'] = $L['pos_x1_ex22'] - $B['ex31_x'];	$L['pos_y_ex31'] = $L['pos_y3_ex22'];
		$L['pos_x_ex32'] = $L['pos_x1_ex22'];					$L['pos_y_ex32'] = $L['pos_y3_ex22'];
		$L['pos_x_ex33'] = $L['pos_x2_ex22'];					$L['pos_y_ex33'] = $L['pos_y3_ex22'];
		
		// --------------------------------------------------------------------------------------------
		$ThemeDataObj->setThemeDataEntry('theme_module_internal_width', $L['dim_x_ex22'] - 16);
		$ThemeDataObj->setThemeDataEntry('theme_module_internal_height', $L['dim_y_ex22'] - 16);
		$DivIdList = array();
		$DivList = array ( "ex11", "ex12", "ex13", "ex21", "ex22", "ex23", "ex31", "ex32", "ex33" );
		foreach ( $DivList as $A ) { $DivIdList[$A] = "id='" . $mn . "_".$A."' "; }
		
		$Content .= "
		<!-- _______________________________________ Decoration of module ".$mn." (Begin) _______________________________________ -->\r
		";
		$containerStyle = (strlen($infos['module']['module_container_style']) > 0 ) ? " ".$infos['module']['module_container_style'].";" : "";
		$Content .= "
		<div id='".$mcn."' style='position:absolute; left:".$L['px']."px; top:".$L['py']."px; width:".$L['dx']."px; height:".$L['dy']."px; ".$containerStyle ."' class='".$TN . $infos['block']."'>\r
		<div ".$DivIdList['ex11']." class='".$TN . $Block."_ex11' style='left: ".$L['pos_x_ex11']."px;	top: ".$L['pos_y_ex11']."px; z-index: ".$infos['module_z_index']."; width: ".$B['ex11_x']."px; 			height:".$B['ex11_y']."px;'></div>\r
		<div ".$DivIdList['ex12']." class='".$TN . $Block."_ex12' style='left: ".$L['pos_x_ex12']."px;	top: ".$L['pos_y_ex12']."px; z-index: ".$infos['module_z_index']."; width: ".$L['dim_x_ex22']."px;		height:".$B['ex12_y']."px;'></div>\r
		<div ".$DivIdList['ex13']." class='".$TN . $Block."_ex13' style='left: ".$L['pos_x_ex13']."px;	top: ".$L['pos_y_ex13']."px; z-index: ".$infos['module_z_index']."; width: ".$B['ex13_x']."px;			height:".$B['ex13_y']."px;'></div>\r
		<div ".$DivIdList['ex21']." class='".$TN . $Block."_ex21' style='left: ".$L['pos_x_ex21']."px;	top: ".$L['pos_y_ex21']."px; z-index: ".$infos['module_z_index']."; width: ".$B['ex21_x']."px;			height:".$L['dim_y_ex22']."px;'></div>\r
		<div ".$DivIdList['ex23']." class='".$TN . $Block."_ex23' style='left: ".$L['pos_x_ex23']."px;	top: ".$L['pos_y_ex23']."px; z-index: ".$infos['module_z_index']."; width: ".$B['ex23_x']."px;			height:".$L['dim_y_ex22']."px;'></div>\r
		<div ".$DivIdList['ex31']." class='".$TN . $Block."_ex31' style='left: ".$L['pos_x_ex31']."px;	top: ".$L['pos_y_ex31']."px; z-index: ".$infos['module_z_index']."; width: ".$B['ex31_x']."px; 			height:".$B['ex31_y']."px;'></div>\r
		<div ".$DivIdList['ex32']." class='".$TN . $Block."_ex32' style='left: ".$L['pos_x_ex32']."px;	top: ".$L['pos_y_ex32']."px; z-index: ".$infos['module_z_index']."; width: ".$L['dim_x_ex22']."px;		height:".$B['ex32_y']."px;'></div>\r
		<div ".$DivIdList['ex33']." class='".$TN . $Block."_ex33' style='left: ".$L['pos_x_ex33']."px;	top: ".$L['pos_y_ex33']."px; z-index: ".$infos['module_z_index']."; width: ".$B['ex33_x']."px; 			height:".$B['ex33_y']."px;'></div>\r
		<div ".$DivIdList['ex22']." class='".$TN . $Block."_ex22' style='left: ".$L['pos_x_ex22']."px;	top: ".$L['pos_y_ex22']."px; width: ".$L['dim_x_ex22']."px ; height: ".$L['dim_y_ex22']."px; overflow: auto; z-index: ".$infos['module_z_index'].";'>\r
		<!-- _______________________________________ Decoration of module ".$mn." (end)_______________________________________ -->\r
		";
		$CurrentSetObj->getInstanceOfGeneratedJavaScriptObj()->insertJavaScript('Command', "mod.AddModule ( '".$mn."' , 40 );");
		$RenderLayoutObj->setLayoutEntry($mn, $L);		// Saving the updated dataset
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " End"), false );
		
		switch ( $infos['mode'] ) {
			case 0 :	echo $Content;		break;
			case 1 :	return $Content;	break;
		}

	}
}