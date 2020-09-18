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

	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new RenderDeco40Elegance();
		}
		return self::$Instance;
	}
	
	public function render($infos){
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$GeneratedJavaScriptObj = $CurrentSetObj->getInstanceOfGeneratedJavaScriptObj();
		$RenderLayoutObj = RenderLayout::getInstance();
		$LMObj = LogManagement::getInstance();

		$LMObj->InternalLog("********** RenderDeco40Elegance Start **********");
		
		$mn = $infos['module']['module_name'];
		$m = $RenderLayoutObj->getModuleList();
		$TN = $ThemeDataObj->getThemeName();
		$L = $RenderLayoutObj->getLayoutEntry($mn);		// we work locally on the dataset and save it at the end.
		
		$Content = "";
		$L['NomModule'] = $mnd = $mn; // module name (& default)
		
		$LMObj->InternalLog("Theme name =`".$TN."`");
		$B = $ThemeDataObj->getThemeDataEntry($infos['block'].'G');
		switch ($infos['affiche_module_mode']) {
			case "bypass":
				$LMObj->InternalLog("display module mode is 'bypass'");
				$L['px'] = $infos['admin_control']['px'];
				$L['py'] = $infos['admin_control']['py'];
// 				$Content .= "<!-- Module ".$mn." px=".$infos['admin_control']['px']."; py=" . $infos['admin_control']['py']."-->\r";
				break;
			case "normal":
				$LMObj->InternalLog("display module mode is 'normal'");
				break;
			case "menu":
// 				$StringFormatObj = StringFormat::getInstance();
// 				$LMObj->InternalLog("display module mode is 'menu' : ".$mn."<br>m=".$StringFormatObj->arrayToString($m));
				$LMObj->InternalLog("display module mode is 'menu' : ".$mn);
				$mnd = $infos['backup']['module_name'];
				$B = $ThemeDataObj->getThemeDataEntry($infos['block'].'M');
				$L['px'] = 0;
				$L['py'] = 0;
				break;
		}
		if ( $L['lyoc_module_zindex'] != 0 ) { $infos['module_z_index'] = $L['lyoc_module_zindex']; }
		// --------------------------------------------------------------------------------------------
// 		$B = &$S[$_REQUEST['blocG']];
		
		$L['pos_x1_ex22'] = $L['px'] + max ( $B['ex11_x'] , $B['ex21_x'] , $B['ex31_x'] );
		$L['pos_y1_ex22'] = $L['py'] + max ( $B['ex11_y'] , $B['ex12_y'] , $B['ex13_y'] );
		$L['pos_x2_ex22'] = $L['px'] + $L['dx'] - max ( $B['ex13_x'] , $B['ex23_x'] , $B['ex33_x'] );
		$L['pos_y2_ex22'] = &$L['pos_y1_ex22'];
		$L['pos_x3_ex22'] = &$L['pos_x1_ex22'];
		$L['pos_y3_ex22'] = $L['py'] + $L['dy'] - max ( $B['ex31_y'] , $B['ex32_y'] , $B['ex33_y'] );
		$L['pos_x4_ex22'] = &$L['pos_x2_ex22'];
		$L['pos_y4_ex22'] = &$L['pos_y3_ex22'];
		
		$L['dim_x_ex22'] = $L['pos_x2_ex22'] - $L['pos_x1_ex22'];
		$L['dim_y_ex22'] = $L['pos_y3_ex22'] - $L['pos_y1_ex22'];
		
		// Correction des valeurs en fonction des gabarits des elements de la décoration.
		$LMObj->InternalLog("mn=".$mn."; B['ex11_x']=".$B['ex11_x']."; B['ex21_x']=".$B['ex21_x']."; B['ex31_x']=".$B['ex31_x']."; L['px']=".$L['px']."; infos['block']=".$infos['block']."; L['dim_x_ex22']=".$L['pos_x2_ex22']." - ".$L['pos_x1_ex22']." = ".$L['dim_x_ex22']);
		
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
		$ThemeDataObj->setThemeDataEntry('theme_module_largeur_interne', $L['dim_x_ex22'] - 16);
		$ThemeDataObj->setThemeDataEntry('theme_module_hauteur_interne', $L['dim_y_ex22'] - 16);
		$DivIdList = array();
		$DivList = array ( "ex11", "ex12", "ex13", "ex21", "ex22", "ex23", "ex31", "ex32", "ex33" );
		foreach ( $DivList as $A ) { $DivIdList[$A] = "id='" . $mn . "_".$A."' "; }
		
		$Content .= "
	<!-- _______________________________________ Decoration of module ".$mn." (Begin) _______________________________________ -->\r
	";
		if ( isset($infos['module']['module_container_name'] ) && strlen($infos['module']['module_container_name']) > 0 ) { 
			$LMObj->InternalLog("Adding a container DIV: ". $infos['module']['module_container_name']);
			$Content .= "<div id='".$infos['module']['module_container_name']."' style='visibility: hidden; position:absolute; top: 0px; left: 0px;'>\r";
		}
		$Content .= "
		<div ".$DivIdList['ex11']." class='".$TN . $infos['block']."_ex11' style='left: ".$L['pos_x_ex11']."px;	top: ".$L['pos_y_ex11']."px; z-index: ".$infos['module_z_index']."; width: ".$B['ex11_x']."px; 			height:".$B['ex11_y']."px;'></div>\r
		<div ".$DivIdList['ex12']." class='".$TN . $infos['block']."_ex12' style='left: ".$L['pos_x_ex12']."px;	top: ".$L['pos_y_ex12']."px; z-index: ".$infos['module_z_index']."; width: ".$L['dim_x_ex22']."px;		height:".$B['ex12_y']."px;'></div>\r
		<div ".$DivIdList['ex13']." class='".$TN . $infos['block']."_ex13' style='left: ".$L['pos_x_ex13']."px;	top: ".$L['pos_y_ex13']."px; z-index: ".$infos['module_z_index']."; width: ".$B['ex13_x']."px;			height:".$B['ex13_y']."px;'></div>\r
		<div ".$DivIdList['ex21']." class='".$TN . $infos['block']."_ex21' style='left: ".$L['pos_x_ex21']."px;	top: ".$L['pos_y_ex21']."px; z-index: ".$infos['module_z_index']."; width: ".$B['ex21_x']."px;			height:".$L['dim_y_ex22']."px;'></div>\r
		<div ".$DivIdList['ex23']." class='".$TN . $infos['block']."_ex23' style='left: ".$L['pos_x_ex23']."px;	top: ".$L['pos_y_ex23']."px; z-index: ".$infos['module_z_index']."; width: ".$B['ex23_x']."px;			height:".$L['dim_y_ex22']."px;'></div>\r
		<div ".$DivIdList['ex31']." class='".$TN . $infos['block']."_ex31' style='left: ".$L['pos_x_ex31']."px;	top: ".$L['pos_y_ex31']."px; z-index: ".$infos['module_z_index']."; width: ".$B['ex31_x']."px; 			height:".$B['ex31_y']."px;'></div>\r
		<div ".$DivIdList['ex32']." class='".$TN . $infos['block']."_ex32' style='left: ".$L['pos_x_ex32']."px;	top: ".$L['pos_y_ex32']."px; z-index: ".$infos['module_z_index']."; width: ".$L['dim_x_ex22']."px;		height:".$B['ex32_y']."px;'></div>\r
		<div ".$DivIdList['ex33']." class='".$TN . $infos['block']."_ex33' style='left: ".$L['pos_x_ex33']."px;	top: ".$L['pos_y_ex33']."px; z-index: ".$infos['module_z_index']."; width: ".$B['ex33_x']."px; 			height:".$B['ex33_y']."px;'></div>\r
		<div ".$DivIdList['ex22']." class='".$TN . $infos['block']."_ex22 ".$TN.$infos['block']."_t".$m[$mnd]['module_deco_default_text']." ".$TN.$infos['block']."_t_couleur_de_base' style='left: ".$L['pos_x_ex22']."px;	top: ".$L['pos_y_ex22']."px; width: ".$L['dim_x_ex22']."px ; height: ".$L['dim_y_ex22']."px; overflow: auto; z-index: ".$infos['module_z_index'].";'>\r
		<!-- _______________________________________ Decoration of module ".$mn." (end)_______________________________________ -->\r
		";

		$GeneratedJavaScriptObj->insertJavaScript('Command', "mod.AddModule ( '".$mn."' , 40 );");
		$RenderLayoutObj->setLayoutEntry($mn, $L);		// Saving the updated dataset
		$LMObj->InternalLog("____________________ End");
		
		switch ( $infos['mode'] ) {
			case 0 :	echo $Content;		break;
			case 1 :	return $Content;	break;
		}

	}
}