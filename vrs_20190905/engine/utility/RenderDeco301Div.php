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
		$ThemeDataObj = $CurrentSetObj->ThemeDataObj;
		
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " Start"), false );
		
		$mn = $infos['module']['module_name'];
		$TN = $ThemeDataObj->getThemeName();
		if (!isset($infos['module_z_index'])) { $infos['module_z_index'] = 1; }
		
		$Content = "";
		$L['NomModule'] = $mnd = $mn; // module name (& default)
		$L['dx'] = $L['dy'] = 160;
		
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "Theme name =`".$TN."`"));
		$B = $ThemeDataObj->getThemeDataEntry($infos['block'].'G');
		$mcn = $infos['module']['module_container_name'];
		$Block = $infos['block'];
		$position = "absolute";
		switch ($infos['module_display_mode']) {
			case "bypass":
				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " display module mode is 'bypass'"));
				$L['px'] = $infos['admin_control']['px'];
				$L['py'] = $infos['admin_control']['py'];
				$position = "relative";
				break;
			case "normal":
				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " display module mode is 'normal'"));
				break;
			case "menu":
				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " display module mode is 'menu' : ".$mn));
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
		
		$L['pos_x1_ex22'] = $L['px'];
		$L['pos_y1_ex22'] = $L['py'];
		$L['pos_x1_ex22'] = max ( $B['ex11_x'] , $B['ex21_x'] , $B['ex31_x'] );
		$L['pos_y1_ex22'] = max ( $B['ex11_y'] , $B['ex12_y'] , $B['ex13_y'] );
		
// 		$L['pos_x2_ex22'] = $L['px'] + $L['dx'];
		$L['pos_x2_ex22'] = $L['dx'];
		$L['pos_y2_ex22'] = &$L['pos_y1_ex22'];
		
		$L['pos_x3_ex22'] = &$L['pos_x1_ex22'];
// 		$L['pos_y3_ex22'] = $L['py'] + $L['dy'];
		$L['pos_y3_ex22'] = $L['dy'];
		
		$L['pos_x4_ex22'] = &$L['pos_x2_ex22'];
		$L['pos_y4_ex22'] = &$L['pos_y3_ex22'];
		
		$L['dim_x_ex22'] = $L['pos_x2_ex22'] - $L['pos_x1_ex22'];
		$L['dim_y_ex22'] = $L['pos_y3_ex22'] - $L['pos_y1_ex22'];
		
		$ThemeDataObj->setThemeDataEntry('module_internal_width', $L['dim_x_ex22'] - 16);
		$ThemeDataObj->setThemeDataEntry('module_internal_height', $L['dim_y_ex22'] - 16);
		
		$DivIdList['one_div'] = "id='" . $mn . "_one_div' ";
		
		$Content = "
		<!-- _______________________________________ Decoration of module ".$mn." (Begin) _______________________________________ -->\r
		";
		$containerStyle 	= (strlen($infos['module']['module_container_style'] ?? '') > 0 ) ? " ".$infos['module']['module_container_style']." " : "";
		$containerWidth		= (isset($infos['forcedWidth'])) ? $infos['forcedWidth'] : $L['dx']."px";
		$containerHeight	= (isset($infos['forcedHeight'])) ? $infos['forcedHeight'] : $L['dy']."px";
		$Content .= "
		<div id='".$mcn."' style='position:".$position."; width:".$containerWidth."; height:".$containerHeight."; ".$containerStyle ."' class='".$TN . $infos['block']."'>\r
		<div ".$DivIdList['one_div']." class='".$TN . $infos['block']."_1_div ".$TN.$infos['block']."_t".$infos['module']['module_deco_default_text']." ".$TN . $infos['block']."_t_couleur_de_base' style='position: absolute; left: ".$L['pos_x1_ex22']."px;	top: ".$L['pos_y1_ex22']."px;  width: ".$L['dim_x_ex22']."px ;	height: ".$L['dim_y_ex22']."px; line-height: normal; overflow: auto; ";
		if ( isset($infos['module_z_index']) ) { $Content .= " z-index: ".$infos['module_z_index']."; "; }
		$Content .= " background-repeat: repeat;'>\r
		<!-- _______________________________________ Decoration of module ".$mn." (end)_______________________________________ -->\r
		";

		$argAddModule = "{ 
			one_div : {	'isEnabled':true,	'DimX':".$B['ex11_x'].",	'DimY':".$B['ex11_y'].",	'PosX':0,	'PosY':0,	'DivObj':0	}
			}";

		$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-Command', "mod.AddModule ( '".$mn."' , 30 , '".$mcn."', ".$argAddModule.");");
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " End"), false );
		
		switch ( $infos['mode'] ) {
			case 0 :	echo $Content;		break;
			case 1 :	return $Content;	break;
		}
		
	}
}