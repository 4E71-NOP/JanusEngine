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
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$RenderLayoutObj = RenderLayout::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " Start"));
		
		$Content = "";
		$ModuleTable = $RenderLayoutObj->getModuleList();
		$CurrentSetObj->getInstanceOfGeneratedJavaScriptObj()->insertJavaScript("Data", "var TabInfoModule = new Array();\r");

		if ( strlen( $ThemeDataObj->getThemeDataEntry('theme_divinitial_bg') ) > 0 ) { $pv['div_initial_bg'] = "background-image: url(".$CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url')."media/theme/".$ThemeDataObj->getThemeDataEntry('theme_directory')."/".$ThemeDataObj->getThemeDataEntry('theme_divinitial_bg')."); background-repeat: ".$ThemeDataObj->getThemeDataEntry('theme_divinitial_repeat').";" ; }
		if ( $ThemeDataObj->getThemeDataEntry('theme_divinitial_dx') == 0 ) { $ThemeDataObj->setThemeDataEntry('theme_divinitial_dx', $_REQUEST['document_dx']); }
		if ( $ThemeDataObj->getThemeDataEntry('theme_divinitial_dy') == 0 ) { $ThemeDataObj->setThemeDataEntry('theme_divinitial_dy', $_REQUEST['document_dy']); }

		$pv['initial_div_vis'] = "hidden";
		$pv['initial_div_vis'] = "visible";
		if ( $_REQUEST['debug_special'] == 1 ) { $pv['initial_div_vis'] = "visible"; }
		
		$Content .= "<!-- __________ Modules begining __________ -->\r
				<div id='initial_div' style='position:relative; margin-left: auto; margin-right: auto; visibility:" . $pv ['initial_div_vis'] . ";
				width:" . $ThemeDataObj->getThemeDataEntry('theme_divinitial_dx') . "px;
				height:" . $ThemeDataObj->getThemeDataEntry('theme_divinitial_dy') . "px;"
				.$pv['div_initial_bg'] . "'>\r"; // width = Always define otherwise it won't work..
		
		$CurrentSetObj->getInstanceOfGeneratedJavaScriptObj()->insertJavaScript("Onload", "\telm.Gebi( 'initial_div' ).style.visibility = 'visible';");
		
		$pv ['i'] = 1;
		
		foreach ( $ModuleTable as $m ) {
			$_REQUEST['module_nbr'] = 1; // <-- A virer
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "+--------------------------------------------------------------------------------+"));
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "| Rendering module '".$m['module_name']. "'" . str_repeat(" ",(63 - (strlen($m['module_name'])+3))) . "|" ));
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "|                                                                                |"));
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "+--------------------------------------------------------------------------------+"));
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." " . $bts->StringFormatObj->arrayToString($m)));
			$Content .= "<!-- __________ Module '".$m['module_name']."' start __________ -->\r";
			
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "\$m['module_group_allowed_to_see'] = " . $m['module_group_allowed_to_see'] ." and usergroup is " .$bts->StringFormatObj->arrayToString($CurrentSetObj->getInstanceOfUserObj()->getUserEntry('group'))));
			if ( $CurrentSetObj->getInstanceOfUserObj()->getUserGroupEntry('group', $m['module_group_allowed_to_see']) == 1 ) {
				$nbr = $m['module_deco_nbr'];
				$Block = $bts->StringFormatObj->getDecorationBlockName( "B", $nbr , "");
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
					$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "module file is : " . $m['module_directory'].$m['module_file']));
					include ($m['module_directory'].$m['module_file']);
				} else { $Content .= "!! !! !! !!"; }
				
				if (class_exists($ModuleRendererName)) { 
					$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "module class name is : ". $ModuleRendererName));
					$ModuleRenderer = new $ModuleRendererName(); 
				}
				else {
					$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_WARNING , 'msg' => "Module classname doesn't exist. Something went wrong"));
					$infos['ModuleRendererName'] = $m['module_classname'];
					$ModuleRenderer = new ModuleNotFound(); 
				}
				
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
			
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " >> END rendering of '".$m['module_name']. "' module is done"));
			
		}
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." All module rendered. Getting out of foreach"));
		
		
		$Content .= "</div>\r
			<!-- __________ Modules end __________ -->\r
			";
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " End"));
		
		switch ( $infos['mode'] ) {
			case 0 :	echo $Content;		break;
			case 1 :	return $Content;	break;
		}
	}
	
	public function selectDecoration ($infos) {
		$bts = BaseToolSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();
		$RenderLayoutObj = RenderLayout::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " Start"));
		$Content = "";
		if ( $infos['module']['module_deco'] != 1 ) { $infos['deco_type'] = 10000; }
		
		$err = FALSE;
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " '".$infos['deco_type']."' selected"));
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
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Decoration number:'".$infos['deco_type']."' (if == 10000 then it's ok)"));
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
				$ThemeDataObj->setThemeDataEntry('theme_module_internal_width', $RenderLayoutObj->getLayoutModuleEntry($mn, 'dx'));
				$ThemeDataObj->setThemeDataEntry('theme_module_internal_height', $RenderLayoutObj->getLayoutModuleEntry($mn, 'dy'));
				$err = TRUE;		// Most likely no decoration. Or something went wrong. So the system use a default behavior.
				break;
		}
		if ( $err == FALSE ) {
			$Content .= $RenderDeco->render($infos);
			unset ($RenderDeco);
		}
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " End"));
		
		return $Content;
	}
	
}

// --------------------------------------------------------------------------------------------
class ModuleNotFound {
	public function __construct(){}
	public function render ($infos) {
		$bts = BaseToolSet::getInstance();
		// $bts->LMObj->log(array(
		// 		"i"=>"ModuleNotFound",
		// 		"a"=>"render()",
		// 		"s"=>"ERR",
		// 		"m"=>"RenderModule001",
		// 		"t"=>"No class found for this module",
		// ));
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . " : No class found for module " . $infos['module_name'] . "; ClassName : `". $infos['ModuleRendererName']."`"));
		
// 		error_log ("No class found for module " . $infos['module_name'] . "; ClassName : ");
	}
}

