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

class RenderModule {
	private static $Instance = null;

	public function __construct() {}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return RenderModule
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new RenderModule ();
		}
		return self::$Instance;
	}
	
	public function render($infos) {
		$cs = CommonSystem::getInstance();
		$RenderLayoutObj = RenderLayout::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		$UserObj = $CurrentSetObj->getInstanceOfUserObj();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$GeneratedJavaScriptObj = $CurrentSetObj->getInstanceOfGeneratedJavaScriptObj();

		$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " Start"));
		
		$Content = "";
		$ModuleTable = $RenderLayoutObj->getModuleList();

		$GeneratedJavaScriptObj->insertJavaScript("Data", "var TabInfoModule = new Array();\r");

		if ( strlen( $ThemeDataObj->getThemeDataEntry('theme_divinitial_bg') ) > 0 ) { $pv['div_initial_bg'] = "background-image: url(../gfx/".$ThemeDataObj->getThemeDataEntry('theme_directory')."/".$ThemeDataObj->getThemeDataEntry('theme_divinitial_bg')."); background-repeat: ".$ThemeDataObj->getThemeDataEntry('theme_divinitial_repeat').";" ; }
		if ( $ThemeDataObj->getThemeDataEntry('theme_divinitial_dx') == 0 ) { $ThemeDataObj->setThemeDataEntry('theme_divinitial_dx', $_REQUEST['document_dx']); }
		if ( $ThemeDataObj->getThemeDataEntry('theme_divinitial_dy') == 0 ) { $ThemeDataObj->setThemeDataEntry('theme_divinitial_dy', $_REQUEST['document_dy']); }

		$pv['initial_div_vis'] = "hidden";
		if ( $_REQUEST['debug_special'] == 1 ) { $pv['initial_div_vis'] = "visible"; }
		
		$Content .= "<!-- __________ Modules begining __________ -->\r
				<div id='initial_div' style='position:relative; margin-left: auto; margin-right: auto; visibility:" . $pv ['initial_div_vis'] . ";
				width:" . $ThemeDataObj->getThemeDataEntry('theme_divinitial_dx') . "px;
				height:" . $ThemeDataObj->getThemeDataEntry('theme_divinitial_dy') . "px;" . $pv ['div_initial_bg'] . "'>\r"; // width = Always define otherwise it won't work..

		$GeneratedJavaScriptObj->insertJavaScript("Onload", "\telm.Gebi( 'initial_div' ).style.visibility = 'visible';");

		$pv ['i'] = 1;
		
// 		$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => $cs->StringFormatObj->arrayToString($ModuleTable)));
		foreach ( $ModuleTable as $m ) {
			$_REQUEST['module_nbr'] = 1;
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "+--------------------------------------------------------------------------------+"));
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "| Rendering module '".$m['module_name']. "'" . str_repeat(" ",(63 - (strlen($m['module_name'])+3))) . "|" ));
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "|                                                                                |"));
			$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "+--------------------------------------------------------------------------------+"));
			$Content .= "<!-- __________ Module '".$m['module_name']."' start __________ -->\r";
			
			if ( $UserObj->getUserGroupEntry('group', $m['module_group_allowed_to_see']) == 1 ) {
				$nbr = $m['module_deco_nbr'];
				$Block = $cs->StringFormatObj->getDecorationBlockName( "B", $nbr , "");
				$infos['module_name'] = $m['module_name'];
				$infos['block'] = $Block;
				$infos['blockG'] = $Block . "G";
				$infos['blockT'] = $Block . "T";
				$infos['deco_type'] = $ThemeDataObj->getThemeBlockEntry($infos['blockG'], 'deco_type');
				$infos['module'] = $m;
				$fontSizeRange= $ThemeDataObj->getThemeBlockEntry($infos['blockT'],'txt_fonte_size_max') - $ThemeDataObj->getThemeBlockEntry($infos['blockT'],'txt_fonte_size_min');
				$infos['fontSizeMin'] = $ThemeDataObj->getThemeBlockEntry($infos['blockT'],'txt_fonte_size_min');
				$infos['fontCoef'] = $fontSizeRange / 6;
				
				$ModuleRendererName = $m['module_classname'];
				
				if (!class_exists($ModuleRendererName)) {
					include ( $m['module_directory'].str_replace(".php", "_Obj.php",$m['module_file'] ) ); //	str_replace used during migration so we can use both files.
				} else { $Content .= "!! !! !! !!"; }
				
				if (class_exists($ModuleRendererName)) { $ModuleRenderer = new $ModuleRendererName(); }
				else { $ModuleRenderer = new ModuleNotFound(); }
				
// 				Execution modes are : 0 during, 1 Before, 2 After
				switch ( $m['module_execution'] ) {
					case 0:
						$Content .= $this->selectDecoration($infos);
						
						$Content .= $ModuleRenderer->render($infos);
						$Content .= "</div>\r</div>\r";
						break;
					case 1:
						$Content .= $ModuleRenderer->render($infos);
						$Content .= $this->selectDecoration($infos);
						$Content .= "</div>\r</div>\r";
						break;
					case 2:
						$Content .= $this->selectDecoration($infos);
						$Content .= "</div>\r</div>\r";
						
						$Content .= $ModuleRenderer->render($infos);
						break;
				}
			}
			
			$Content .= "<!-- __________ Module '".$m['module_name']."' end __________ -->\r\r\r\r\r";
			$pv['i']++;
			$infos['module_z_index'] += 2;

			$extraContent = $CurrentSetObj->getDataSubEntry('RenderModule', 'extraContent' );
			if (strlen($extraContent)>0) { $Content .= $extraContent; }
			$CurrentSetObj->setDataSubEntry('RenderModule', 'extraContent', '' );		//Whatever happens we reset the extra content delivered by a module.
		}
		
		$Content .= "</div>\r
			<!-- __________ Modules end __________ -->\r
			";
		$cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " End"));
		
		switch ( $infos['mode'] ) {
			case 0 :	echo $Content;		break;
			case 1 :	return $Content;	break;
		}
	}
	
	public function selectDecoration ($infos) {
		$ClassLoaderObj = ClassLoader::getInstance();
		$LMObj = LogManagement::getInstance();
		$RenderLayoutObj = RenderLayout::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		
		$LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " Start"));
		$Content = "";
		if ( $infos['module']['module_deco'] != 1 ) { $infos['deco_type'] = 10000; }
		
		$err = FALSE;
		$LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " '".$infos['deco_type']."' selected"));
		switch ( $infos['deco_type'] ) {
			case 30:	
			case "1_div":
				$ClassLoaderObj->provisionClass("RenderDeco301Div");
				$RenderDeco = RenderDeco301Div::getInstance();
				break;
			case 40:	
			case "elegance":
				$ClassLoaderObj->provisionClass("RenderDeco40Elegance");
				$RenderDeco = RenderDeco40Elegance::getInstance();
				break;
			case 50:	
			case "exquise":	
				$ClassLoaderObj->provisionClass("RenderDeco50Exquisite");
				$RenderDeco = RenderDeco50Exquisite::getInstance();
				break;
			case 60:	
			case "elysion":
				$ClassLoaderObj->provisionClass("RenderDeco60Elysion");
				$RenderDeco = RenderDeco60Elysion::getInstance();
				break;
			default:
				$mn = $infos['module_name'];
				$LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "Decoration number:'".$infos['deco_type']."' (if == 10000 then it's ok)"));
				$Content .= "
					<div class='".$ThemeDataObj->getThemeName().$infos['block']."'>\r
					<div id='".$mn."' class='".$ThemeDataObj->getThemeName().$infos['block']."_div_std' style='position: absolute; left:
					".
					$RenderLayoutObj->getLayoutModuleEntry($mn, 'px')."px; top:".
					$RenderLayoutObj->getLayoutModuleEntry($mn, 'py')."px; width:".
					$RenderLayoutObj->getLayoutModuleEntry($mn, 'dx')."px; height:".
					$RenderLayoutObj->getLayoutModuleEntry($mn, 'dy')."px;' 
					>\r
					"
					;
				$ThemeDataObj->setThemeDataEntry('theme_module_largeur_interne', $RenderLayoutObj->getLayoutModuleEntry($mn, 'dx'));
				$ThemeDataObj->setThemeDataEntry('theme_module_hauteur_interne', $RenderLayoutObj->getLayoutModuleEntry($mn, 'dy'));
				$err = TRUE;		// Most likely no decoration. Or something went wrong. So the system use a default behavior.
				break;
		}
		if ( $err == FALSE ) {
			$Content .= $RenderDeco->render($infos);
			unset ($RenderDeco);
		}
		$LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " End"));
		
		return $Content;
	}
	
}

// --------------------------------------------------------------------------------------------
class ModuleNotFound {
	public function __construct(){}
	public function render ($infos) {
		$LMObj = LogManagement::getInstance();
		$LMObj->log(array(
				"i"=>"ModuleNotFound",
				"a"=>"render()",
				"s"=>"ERR",
				"m"=>"RenderModule001",
				"t"=>"No class found for this module",
		));
		error_log ("No class found for module " . $infos['module_name'] . "; ClassName : ");
	}
}

