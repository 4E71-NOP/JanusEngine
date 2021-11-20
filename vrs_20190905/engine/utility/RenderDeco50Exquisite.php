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

class RenderDeco50Exquisite {
	private static $Instance = null;
	
	private function __construct(){}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return RenderDeco50Exquisite
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new RenderDeco50Exquisite();
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
		$ThemeDataObj->setThemeDataEntry('theme_module_internal_width', $L['dim_x_ex22'] - 16);
		$ThemeDataObj->setThemeDataEntry('theme_module_internal_height', $L['dim_y_ex22'] - 16);
		$DivIdList = array();
		$DivList = array ( "ex11", "ex12", "ex13", "ex14", "ex15", "ex21", "ex22", "ex23", "ex25", "ex31", "ex35", "ex41", "ex45", "ex51", "ex52", "ex53", "ex54", "ex55" );
		foreach ( $DivList as $A ) { $DivIdList[$A] = "id='" . $mn . "_".$A."' "; }
		
		$Content .= "
		<!-- _______________________________________ Decoration of module ".$mn." (Begin) _______________________________________ -->\r
		";
		$containerStyle = (strlen($infos['module']['module_container_style']) > 0 ) ? " ".$infos['module']['module_container_style']." " : "";
		$Content .= "
		<div id='".$mcn."' style='position:absolute; left:".$L['px']."px; top:".$L['py']."px; width:".$L['dx']."px; height:".$L['dy']."px; ".$containerStyle ."' class='".$TN . $infos['block']."'>\r		
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
		<div ".$DivIdList['ex55']." class='".$TN . $Block."_ex55' style='left: ".$L['pos_x_ex55']."px;	top: ".$L['pos_y_ex55']."px; z-index: ".$infos['module_z_index']."; width:".$B['ex55_x']."px;		height:".$B['ex55_y']."px;'></div>\r
		<div ".$DivIdList['ex22']." class='".$TN.$infos['block']."_ex22' style='left: ".$L['pos_x_ex22']."px;	top: ".$L['pos_y_ex22']."px; width: ".$L['dim_x_ex22']."px ; height: ".$L['dim_y_ex22']."px; overflow: auto; z-index: ".$infos['module_z_index'].";'>\r
		<!-- _______________________________________ Decoration of module ".$mn." (end)_______________________________________ -->\r
		";

		$argAddModule = "{
			ex11 : {	'isEnabled':true,	'DimX':".$B['ex11_x'].",	'DimY':".$B['ex11_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex12 : {	'isEnabled':true,	'DimX':".$B['ex12_x'].",	'DimY':".$B['ex12_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex13 : {	'isEnabled':true,	'DimX':".$B['ex13_x'].",	'DimY':".$B['ex13_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex14 : {	'isEnabled':true,	'DimX':".$B['ex14_x'].",	'DimY':".$B['ex14_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex15 : {	'isEnabled':true,	'DimX':".$B['ex15_x'].",	'DimY':".$B['ex15_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex21 : {	'isEnabled':true,	'DimX':".$B['ex21_x'].",	'DimY':".$B['ex21_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex22 : {	'isEnabled':true,	'DimX':".$B['ex22_x'].",	'DimY':".$B['ex22_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex25 : {	'isEnabled':true,	'DimX':".$B['ex25_x'].",	'DimY':".$B['ex25_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex31 : {	'isEnabled':true,	'DimX':".$B['ex31_x'].",	'DimY':".$B['ex31_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex35 : {	'isEnabled':true,	'DimX':".$B['ex35_x'].",	'DimY':".$B['ex35_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex41 : {	'isEnabled':true,	'DimX':".$B['ex41_x'].",	'DimY':".$B['ex41_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex45 : {	'isEnabled':true,	'DimX':".$B['ex45_x'].",	'DimY':".$B['ex45_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex51 : {	'isEnabled':true,	'DimX':".$B['ex51_x'].",	'DimY':".$B['ex51_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex52 : {	'isEnabled':true,	'DimX':".$B['ex52_x'].",	'DimY':".$B['ex52_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex53 : {	'isEnabled':true,	'DimX':".$B['ex53_x'].",	'DimY':".$B['ex53_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex54 : {	'isEnabled':true,	'DimX':".$B['ex54_x'].",	'DimY':".$B['ex54_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			ex55 : {	'isEnabled':true,	'DimX':".$B['ex55_x'].",	'DimY':".$B['ex55_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	},
			}";
	
		$CurrentSetObj->getInstanceOfGeneratedJavaScriptObj()->insertJavaScript('Command', "mod.AddModule ( '".$mn."' , 50, '".$mcn."', ".$argAddModule." );");
		// $RenderLayoutObj->setLayoutEntry($mn, $L);		// Saving the updated dataset
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " End"), false );
		
		switch ( $infos['mode'] ) {
			case 0 :	echo $Content;		break;
			case 1 :	return $Content;	break;
		}
		
	}
}