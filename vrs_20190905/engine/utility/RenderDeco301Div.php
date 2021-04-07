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
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return RenderDeco301Div
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new RenderDeco301Div();
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
				break;
		}
		
		if ( $L['lyoc_module_zindex'] != 0 ) { $infos['module_z_index'] = $L['lyoc_module_zindex']; }
		// --------------------------------------------------------------------------------------------
		
		$L['pos_x1_22'] = $L['px'];
		$L['pos_y1_22'] = $L['py'];
		
// 		$L['pos_x2_22'] = $L['px'] + $L['dx'];
		$L['pos_x2_22'] = $L['dx'];
		$L['pos_y2_22'] = &$L['pos_y1_22'];
		
		$L['pos_x3_22'] = &$L['pos_x1_22'];
// 		$L['pos_y3_22'] = $L['py'] + $L['dy'];
		$L['pos_y3_22'] = $L['dy'];
		
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
		$containerStyle = (strlen($infos['module']['module_container_style']) > 0 ) ? " ".$infos['module']['module_container_style']." " : "";
		$Content .= "
		<div id='".$infos['module']['module_container_name']."' style='position:absolute; left:".$L['px']."px; top:".$L['py']."px; width:".$L['dx']."px; height:".$L['dy']."px; ".$containerStyle .";' class='".$TN . $infos['block']."'>\r
		<div ".$DivIdList['un_div']." class='".$TN . $infos['block']."_1_div ".$TN.$infos['block']."_t".$m[$mnd]['module_deco_default_text']." ".$TN . $infos['block']."_t_couleur_de_base' style='position: absolute; left: ".$L['pos_x1_22']."px;	top: ".$L['pos_y1_22']."px;  width: ".$L['dim_x_22']."px ;	height: ".$L['dim_y_22']."px; line-height: normal; overflow: auto; ";
		if ( isset($infos['module_z_index']) ) { $Content .= " z-index: ".$infos['module_z_index']."; "; }
		$Content .= "
	background-repeat: repeat;'>\r

	<!-- _______________________________________ Decoration of module ".$mn." (end)_______________________________________ -->\r
	";
		
		$CurrentSetObj->getInstanceOfGeneratedJavaScriptObj()->insertJavaScript('Command', "mod.AddModule ( '".$mn."' , 30 );");
		$RenderLayoutObj->setLayoutEntry($mn, $L);		// Saving the updated dataset
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " End"), false );
		
		switch ( $infos['mode'] ) {
			case 0 :	echo $Content;		break;
			case 1 :	return $Content;	break;
		}
		
	}
}