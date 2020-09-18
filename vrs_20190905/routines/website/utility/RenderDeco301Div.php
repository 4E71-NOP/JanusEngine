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

class RenderDeco301Div {
	private static $Instance = null;
	
	private function __construct(){}

	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new RenderDeco301Div();
		}
		return self::$Instance;
	}

	public function render ( $infos ){
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$GeneratedJavaScriptObj = $CurrentSetObj->getInstanceOfGeneratedJavaScriptObj();
		$RenderLayoutObj = RenderLayout::getInstance();
		
		$mn = $infos['module']['module_nom'];
		$m = $RenderLayoutObj->getModuleList();
		$L = $RenderLayoutObj->getLayoutEntry($mn);		// we work locally on the dataset and save it at the end.
		$TN = $ThemeDataObj->getThemeName();
		
		$module_deco_stat = $mn . "_deco_a";
		
		$L['NomModule'] = $mn;
		switch ($infos['affiche_module_mode']) {
			case "bypass":
				$L['px'] = $infos['admin_control']['px'];
				$L['py'] = $infos['admin_control']['py'];
				break;
			case "normal":
				break;
			case "menu":
				$L['px'] = 0;
				$L['py'] = 0;
				break;
		}
		if ( $L['lyoc_module_zindex'] != 0 ) { $infos['module_z_index'] = $L['lyoc_module_zindex']; }
		// --------------------------------------------------------------------------------------------
		
		$L['pos_x1_22'] = $L['px'];
		$L['pos_y1_22'] = $L['py'];
		
		$L['pos_x2_22'] = $L['px'] + $L['dx'];
		$L['pos_y2_22'] = &$L['pos_y1_22'];
		
		$L['pos_x3_22'] = &$L['pos_x1_22'];
		$L['pos_y3_22'] = $L['py'] + $L['dy'];
		
		$L['pos_x4_22'] = &$L['pos_x2_22'];
		$L['pos_y4_22'] = &$L['pos_y3_22'];
		
		$L['dim_x_22'] = $L['pos_x2_22'] - $L['pos_x1_22'];
		$L['dim_y_22'] = $L['pos_y3_22'] - $L['pos_y1_22'];
		
		$ThemeDataObj->setThemeDataEntry('theme_module_largeur_interne', $L['dim_x_ex22'] - 16);
		$ThemeDataObj->setThemeDataEntry('theme_module_hauteur_interne', $L['dim_y_ex22'] - 16);
		
		$DivIdList['un_div'] = "id='" . $mn . "_un_div' ";
		
		$Content = "
	<!-- _______________________________________ Decoration of module ".$mn." (Begin) _______________________________________ -->\r
	";
		if ( isset($m['module_conteneur_nom']) && strlen($m['module_conteneur_nom']) > 0 ) { $Content .= "<div id='".$m['module_conteneur_nom']."' style='visibility: hidden; position: absolute; top: 0px; left: 0px;'>\r"; }
		$Content .= "<div ".$DivIdList['un_div']." class='".$TN . $infos['block']."_1_div ".$TN . $infos['block']."_t".$m['module_deco_txt_defaut']." ".$TN . $infos['block']."_t_couleur_de_base' style='position: absolute; left: ".$L['pos_x1_22']."px;	top: ".$L['pos_y1_22']."px;  width: ".$L['dim_x_22']."px ;	height: ".$L['dim_y_22']."px; line-height: normal; overflow: auto; ";
		if ( isset($infos['module_z_index']) ) { $Content .= " z-index: ".$infos['module_z_index']."; "; }
		$Content .= "
	background-repeat: repeat;'>\r
	<!-- _______________________________________ Decoration of module ".$mn." (end)_______________________________________ -->\r
	";
		
		$GeneratedJavaScriptObj->insertJavaScript('Command', "mod.AddModule ( '".$mn."' , 30 );");
		$RenderLayoutObj->setLayoutEntry($mn, $L);		// Saving the updated dataset
		
		switch ( $infos['mode'] ) {
			case 0 :	echo $Content;		break;
			case 1 :	return $Content;	break;
		}
		
	}
}