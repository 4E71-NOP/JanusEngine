<?php
 /*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/

class ModuleMenuType02 {
	private static $Instance = null;
	
	public function __construct() {}
	
	public static function getInstance() {
		if (ModuleMenuType02::$Instance == null) {
			ModuleMenuType02::$Instance = new ModuleMenuType02 ();
		}
		return ModuleMenuType02::$Instance;
	}
	
	public function renderMenu(&$infos){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();
		$RenderLayoutObj = RenderLayout::getInstance();
		$ThemeDataObj = $CurrentSetObj->ThemeDataObj();
		
		$menuData = &$infos['menuData'];
		$FPRM = &$infos['FPRM'];
		
		// --------------------------------------------------------------------------------------------
		//
		//	Analyse $menu_principal which contains information abous the menus
		//
		// --------------------------------------------------------------------------------------------
		$pv = array();
		$menuDiv = array();
		$renderJSON = array();
		// unset ( $A );
		// Mp = Menu Parent
		// Mi = Menu Index (the current one)
		foreach ( $menuData as $A ) {
			if ( $A['menu_parent'] != 0 ) {
// 				if ( $A['fk_arti_ref'] == "0" ) {									// folder
				if ( $A['fk_arti_ref'] == "0" ) {									// folder
					$Mi = &$menuDiv[$A['menu_id']];
					$Mp = &$menuDiv[$A['menu_parent']];
					$Mi['niv']		= ( $Mp['niv'] + 1 );
					$Mi['id']		= "d_menu_".$A['menu_id'];
					$Mi['nf']		= $this->menuNumberOfSons($menuData, $A['menu_id'] );
					$Mi['idx']		= 0;
					$Mi['width']	= $A['div_width'];
					$Mp['entree'][$Mp['idx']]['deco_type'] = 1;
				}
// 				elseif ( $A['fk_arti_ref'] == $FPRM['arti_request'] ) {
				elseif ( $A['fk_arti_ref'] == $FPRM['arti_request'] ) {
					$Mp = &$menuDiv[$A['menu_parent']];
					$Mp['entree'][$Mp['idx']]['deco_type'] = 3;
				}
				else {
					$Mp = &$menuDiv[$A['menu_parent']];
					$Mp['entree'][$Mp['idx']]['deco_type'] = 2;
// 					$Mp['entree'][$Mp['idx']]['ref'] = $A['fk_arti_ref'];
					$Mp['entree'][$Mp['idx']]['ref'] = $A['fk_arti_slug'];
				}
				$Mp['entree'][$Mp['idx']]['nom'] = $A['menu_title'];
				$Mp['entree'][$Mp['idx']]['id'] = $A['menu_id'];
				
				// --------------------------------------------------------------------------------------------
				//JSON
				// Jbn "Json block number" -> "BxxM"
				// Jb "Json block"
				// Jd "Json directory"
				// Jp "Json Parent"
				// --------------------------------------------------------------------------------------------
				if ( $A['menu_type'] != 0 ) {									// avoid root menu
					$J = &$renderJSON['a_menu_'.$A['menu_id']];					// section 'a'
					
					$J['menu'] 		= $J['id'] = 'a_menu_'.$A['menu_id'];
					$J['par']		= $Mp['id'];								// Parent
					$J['niv']		= $Mp['niv'];								// Level in the tree (deep)
					if ( $J['niv'] > 0 ) { $J['deco'] = $bts->StringFormatObj->getDecorationBlockName("B", $ThemeDataObj->getThemeBlockEntry($J['niv'], 'deco_type'), "M"); }
					
					// $J['animation']	= $Spb['menu_anim'];						// Animation type
					$J['entree']	= $A['menu_position'];						// Position amongst other
					$J['typ']		= "a";										// Type
					$J['dos']		= 0;										// Folder
					
					$Jbn = $bts->StringFormatObj->getDecorationBlockName("B", $J['niv'], "M");
					$Jb = $ThemeDataObj->getThemeDataEntry($Jbn);
					$J['animation'] = $Jb['animation'];
					$J['le'] = ( $Jb['txt_l_01_margin_top'] + $Jb['txt_l_01_margin_bottom'] + $Jb['a_line_height'] );
					
					if ( $A['menu_parent'] != 0 ) {								// Avoid to set a reference to root
						$Jp = &$renderJSON['d_menu_'.$A['menu_parent']];		// add a children to it
						$Jp['fils'][] = "a_menu_" . $A['menu_id'];
						$Jp['nf']++;
					}
					
// 					if ( $A['fk_arti_ref'] == "0" ) {								// folder, creation of d_menu
					if ( $A['fk_arti_slug'] == "0" ) {								// folder, creation of d_menu
						$J['dos'] = 1;
						$Jd = &$renderJSON['d_menu_'.$A['menu_id']];
						$Jd['menu'] 			= $Jd['id'] = "d_menu_".$A['menu_id'];
						$Jd['par']				= $J['id'];								// Parent
						$Jd['niv']				= ( $J['niv'] + 1 );					// Level in the tree (deep)
						if ( $Jd['niv'] > 0 ) { $Jd['deco'] = $bts->StringFormatObj->getDecorationBlockName("B", $ThemeDataObj->getThemeBlockEntry($Jd['niv'], 'deco_type'), "M"); }
						$Jd['entree']			= $A['menu_position'];					// Position amongst other
						$Jd['typ']				= "div";								// Type
						$Jbn = $bts->StringFormatObj->getDecorationBlockName("B", $Jd['niv'], "M");
						$Jb = $ThemeDataObj->getThemeDataEntry($Jbn);
						$Jd['animation']		= $Jb['animation'];						// Animation type
						$Jd['width']			= $Jb['div_width'];
						$Jd['target_dock']		= $Jb['target_dock'];
						$Jd['dock_decal_x']		= $Jb['dock_decal_x'];
						$Jd['dock_decal_y']		= $Jb['dock_decal_y'];
						$Jd['div_height']		= $Mi['div_height'] = $Jb['div_height'];
						$Jp = &$renderJSON[$Jd['par']];
						$Jd['le']				= $Jp['le'];
						$Jp['fils'][]			= "d_menu_" . $A['menu_id'];
						$Jp['nf']++;
					}
				}
				$Mp['idx']++;
			}
			else {
				$Mi = &$menuDiv[$A['menu_id']];
				$Mi['niv']			= 0;
				$Mi['id']			= "d_menu_".$A['menu_id'];
				$Mi['idx'] 			= 0;
				
				$J = &$renderJSON['d_menu_'.$A['menu_id']];
				$J['menu']			= $J['id'] = "d_menu_".$A['menu_id'];
				$J['par']			= "root";										// Parent
				$J['niv']			= 0;											// Level in the tree (deep)
				$J['entree']		= $A['menu_position'];							// Position amongst other
				$J['typ']			= "div";										// Type
				$J['dos']			= 0;											// Folder
				$Jbn = $bts->StringFormatObj->getDecorationBlockName("B", $J['niv'], "M");
				$Jb = $ThemeDataObj->getThemeDataEntry($Jbn);
				$J['animation']		= $Jb['animation'];								// Animation type
				$J['width']			= $Jb['div_width'];
				$J['le']			= ( $Jb['a_line_height'] + $Jb['a_margin_bottom'] );
			}
		}
		// --------------------------------------------------------------------------------------------
		//	Prepare a table allowing to calculate the position of the many different div and menus
		// target
		// 0  8  4
		// 2  10 6
		// 1  9  5
		$PositionMenuTable = array(); 
		for ( $i = 0 ; $i < 10 ; $i++) {
			$lvl = $bts->StringFormatObj->getDecorationBlockName("B", $i, "M");
			$Pm = $ThemeDataObj->getThemeDataEntry($lvl);
			
			$PMT = &$PositionMenuTable[$lvl];
			$PMT['div_width']		= $Pm['div_width'];
			$PMT['target_dock']		= $Pm['target_dock'];
			$PMT['dock_decal_x']	= $Pm['dock_decal_x'];
			$PMT['dock_decal_y']	= $Pm['dock_decal_y'];
			
			$PMT['txt_l_01_size']			= $Pm['txt_l_01_size'];
			$PMT['txt_l_01_margin_top']		= $Pm['txt_l_01_margin_top'];
			$PMT['txt_l_01_margin_bottom']	= $Pm['txt_l_01_margin_bottom'];
			$PMT['txt_l_01_margin_left']	= $Pm['txt_l_01_margin_left'];
			$PMT['txt_l_01_margin_right']	= $Pm['txt_l_01_margin_right'];
			$PMT['a_line_height']			= $Pm['a_line_height'];
			
			switch ( $Pm['deco_type'] ) {
				case 40:
					$PMT['ex11_y']				= $Pm['ex11_y'];
					$PMT['exF1_y']				= $Pm['ex31_y'];
					break;
				case 50:
				case 60:
					$PMT['ex11_y']				= $Pm['ex11_y'];
					$PMT['exF1_y']				= $Pm['ex51_y'];
					break;
			}
		}
		
		// Default values in case of a problem.
		unset ( $A );
		foreach ( $renderJSON as $A ) {
			if ( $A['typ'] == "div" ) {
				$pv['coef'] = 1;
				if ( $A['par'] == "root" ) { $pv['coef'] = 0; }
				
				$RenderLayoutObj->setLayoutModuleEntry($A['id'], 'px', ( 160 * $pv['coef'] ));
				$RenderLayoutObj->setLayoutModuleEntry($A['id'], 'py', ( 160 * $pv['coef'] ));
				$RenderLayoutObj->setLayoutModuleEntry($A['id'], 'dx', ( $A['width'] * $pv['coef'] ));
				$RenderLayoutObj->setLayoutModuleEntry($A['id'], 'dy', ( 256 * $pv['coef'] ));
				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' =>  __METHOD__ .
					" Situation A / id=".$A['id']. "; par=". $A['par'].
					"; px=". ( 160 * $pv['coef'] ).
					"; py=". ( 160 * $pv['coef'] ).
					"; dx=". ( $A['width'] * $pv['coef'] ).
					"; dy=". ( 256 * $pv['coef'] ).
					"*"
				));
			}
		}
		
		// Find the div size containing the decoration and the menus
		// It's better to do it here than in JavaScript who will produce some kind of flickering effect
		unset ( $A );
		foreach ( $renderJSON as $A ) {
			$lvl = $bts->StringFormatObj->getDecorationBlockName("B", $A['niv'], "M");
			
			$PMT = &$PositionMenuTable[$lvl];
			$RenderLayoutObj->setLayoutModuleEntry($A['id'], 'dx', $PMT['div_width']);
			$RenderLayoutObj->setLayoutModuleEntry($A['id'], 'dy', (( $PMT['txt_l_01_margin_top'] + $PMT['txt_l_01_margin_bottom'] + $PMT['a_line_height'] ) * ($A['nf']+1) ) + $PMT['ex11_y'] + $PMT['exF1_y']);
			
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => 
				__METHOD__ .
				" Situation B / id=".$A['id'].
				"; px=". $RenderLayoutObj->getLayoutModuleEntry($A['id'],'px').
				"; py=". $RenderLayoutObj->getLayoutModuleEntry($A['id'],'py').
				"; dx=". $RenderLayoutObj->getLayoutModuleEntry($A['id'],'dx').
				"; dy=". $RenderLayoutObj->getLayoutModuleEntry($A['id'],'dy').
				"*"
			));
		}
		
		unset ( $A );
		reset ( $menuDiv );
		$infos['backup']['module_name']		= $infos['module']['module_name'];
		$infos['backup']['module_z_index']	= $infos['module']['module_z_index'];
		$level = 0;
		
		$moduleContent = $extraContent = "";
		$contentTarget = &$moduleContent;
		
		foreach ( $menuDiv as $A ) {
			$Abn = $bts->StringFormatObj->getDecorationBlockName("B", $A['niv'], "M");
			$Ab = $ThemeDataObj->getThemeDataEntry($Abn);
			
			$visibility = "hidden";
			if ( $A['niv'] == 0 ) {
				$CurrentSetObj->GeneratedScriptObj->insertString("JavaScript-OnLoad" , "\telm.Gebi( '".$A['id']."' ).style.visibility = 'visible';");
			}
			if ( $Ab['display_icons'] == 1 ) {
				if ( strlen ($Ab['icone_directory_01']) > 0 ) { $Micone_rep =		"<img src='".$CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url')."/media/theme/".$Ab['directory']."/".$Ab['icone_directory']."'	width='".$Ab['icons_width']."' height='".$Ab['icons_height']."' border='0'>"; }
				if ( strlen ($Ab['icone_file_01']) > 0 ) { $Micone_fichier =	"<img src='".$CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url')."/media/theme/".$Ab['directory']."/".$Ab['icone_file']."'			width='".$Ab['icons_width']."' height='".$Ab['icons_height']."' border='0'>"; }
			}
			
			$infos['backup']['module_display_mode']	= $infos['module_display_mode'];
			$infos['backup']['block']				= $infos['block'];
			$infos['backup']['module_z_index']		= $infos['module_z_index'];
			
			$pv['NiveauZero'] = "";
			if ( $A['niv'] != 0 ) {
				$infos['module']['module_name'] = $A['id'];
				$infos['module_display_mode'] = 'menu';
				$infos['module_z_index'] = $A['niv'] + 100;
				
				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " Processing ".$infos['module']['module_name']." with mode " . $infos['module_display_mode'] . " and deco type is ". $Ab['deco_type']));
				
				switch ( $Ab['deco_type'] ) {
					case 30:
					case "1_div":
						$ClassLoaderObj->provisionClass("RenderDeco301Div");
						$MenuRenderer = RenderDeco301Div::getInstance();
						break;
					case 40:
					case "elegance":
						$ClassLoaderObj->provisionClass("RenderDeco40Elegance");
						$MenuRenderer = RenderDeco40Elegance::getInstance();
						break;
					case 50:
					case "exquisite":
						$ClassLoaderObj->provisionClass("RenderDeco50Exquisite");
						$MenuRenderer = RenderDeco50Exquisite::getInstance();
						break;
					case 60:
					case "elysion":
						$ClassLoaderObj->provisionClass("RenderDeco60Elysion");
						$MenuRenderer = RenderDeco60Elysion::getInstance();
						break;
				}
				
				$ModuleDecoration = "";
				if ( is_callable(array($MenuRenderer, 'render') , TRUE )) {
					$ModuleDecoration = $MenuRenderer->render($infos);
				}
				
				$CurrentSetObj->GeneratedScriptObj->insertString("JavaScript-Command", "dm.UpdateAllDecoModule ( TabInfoModule , '".$A['id']."' );");
			}
			
			$A['div_height_calc'] = (( $PMT['txt_l_01_margin_top'] + $PMT['txt_l_01_margin_bottom'] + $PMT['a_line_height'] ) * ($A['nf']) ) + $PMT['ex11_y'] + $PMT['exF1_y'];
			$A['div_height_calc'] = max ( $A['div_height'] , $A['div_height_calc'] );
			
			if ( $Ab['a_line_height'] > 0 ) { $pv['supLH'] = "; line-height:". $Ab['a_line_height']."px;"; }
			
// 			position: absolute; is necessary otherwise the DIVs will be located on top left.
// 			$infos['module']['module_container_style'] = "style='position: absolute; z-index: ".$infos['module_z_index']."; left: ".
			$pv['style_niveau_en_cours'] = "style='position: absolute; z-index: ".$infos['module_z_index']."; "
			// ."left: ".$RenderLayoutObj->getLayoutModuleEntry($A['id'], 'px')."px; "
			// ."top: ".$RenderLayoutObj->getLayoutModuleEntry($A['id'], 'py')."px; "
			."width: ".$RenderLayoutObj->getLayoutModuleEntry($A['id'], 'dx')."px; "
			."height: ". $A['div_height_calc'] . "px;"
			."visibility: ".$visibility."; ".$pv['supLH']."'";
			
			// $contentTarget .= "<div id='".$A['id']."' class='".$ThemeDataObj->getThemeName()."menu_lvl_".$A['niv']."' " . $pv['style_niveau_en_cours'] . " ".$pv['NiveauZero']." >\r" . $ModuleDecoration ;
			$contentTarget .= "<div id='".$A['id']."' class='".$ThemeDataObj->getThemeName()."menu_lvl_".$A['niv']."' " . $pv['style_niveau_en_cours'] . " ".$pv['NiveauZero']." >\r" . $ModuleDecoration ;
			
			if ( is_array ( $A['entree'] ) ) {
				unset ( $B );
				foreach ( $A['entree'] as $B ) {
					switch ( $B['deco_type'] ) {
						case 1: $contentTarget .= "<span	id='a_menu_".$B['id']."' class='".$ThemeDataObj->getThemeName()."menu_lvl_".$A['niv']."_link' >".$Micone_rep." ".$B['nom']."</span>\r";											break;
// 						case 2: $contentTarget .= "<a		id='a_menu_".$B['id']."' class='".$ThemeDataObj->getThemeName()."menu_lvl_".$A['niv']."_link' href=\"index.php?arti_ref=".$B['ref']."&amp;arti_page=1\" >".$Micone_fichier.$B['nom']."</a>\r";			break;
						case 2: $contentTarget .= "<a		id='a_menu_".$B['id']."' class='".$ThemeDataObj->getThemeName()."menu_lvl_".$A['niv']."_link' href=\"/".$B['ref']."/1\" >".$Micone_fichier.$B['nom']."</a>\r";			break;
						case 3: $contentTarget .= "<span	id='a_menu_".$B['id']."' class='".$ThemeDataObj->getThemeName()."menu_lvl_".$A['niv']."_link' >".$Micone_fichier." ".$B['nom']."</span>\r";										break;
					}
				}
			}
			$contentTarget .= "\r</div>\r";
			
			$infos['module_display_mode']	= $infos['backup']['module_display_mode'];
			$infos['block']					= $infos['backup']['block'];
			$infos['module_z_index']		= $infos['backup']['module_z_index'];
			
			if ( $A['niv'] != 0 ) { $contentTarget .= "\r</div>\r</div>\r"; }
			$level++;
			if ($level != 0) { $contentTarget = &$extraContent; }
			
		}
		
		$infos['module']['module_name'] = $infos['backup']['module_name'];
		$infos['module']['module_z_index'] = $infos['backup']['module_z_index'];
		
		$name = "TabMenuArbre";
		$ContentJSON = "var ".$name." = {\r";
		foreach ( $renderJSON as &$A ) {
			$ContentJSON .= "\t'".$A['menu']."':	{ 'id':'".$A['id']."',	'p':'".$A['par']."',	'niv':'".$A['niv']."',	'deco':'".$A['deco']."',	'anim':'".$A['animation']."',	'ent':'".$A['entree']."',	'nbent':'".$A['nf']."',	'width':'".$A['width']."',	'cible':'".$A['target_dock']."',	'decal_x':'".$A['dock_decal_x']."',	'decal_y':'".$A['dock_decal_y']."',	'le':'".$A['le']."', 'dos':'".$A['dos']."',	'typ':'".$A['typ']."',	'min_height':'" .$A['div_height'] ."'";
			if ( $A['nf'] > 0 ) {
				$ContentJSON .= ",	f:{ ";
				foreach ( $A['fils'] as $B => &$C ) { $ContentJSON .= "'a".( $B + 1 )."':'".$C."',	"; } // par reference obligatoire
				$ContentJSON = substr ( $ContentJSON , 0 , -2 ) . "} ";
			}
			$ContentJSON .= "},\r";
		}
		$ContentJSON = substr ( $ContentJSON , 0 , -2 ) . "\r};\r\r";

		$ReturnObject = array ( 
			"Content"				=> $moduleContent,
			"extraContent"			=> $extraContent,
			"JavaScriptJSONName"	=> $name,
			"JavaScriptData"		=> $ContentJSON
		);
		
		unset (
			$A,
			$B,
			$C,
			$Abn,
			$Ab,
			$Mi,
			$Mp,
			$J,
			$Jb,
			$Jd,
			$Jp,
			$Jbn,
			$Pm,
			$PMT
		);
		return $ReturnObject;
		
	}
	
	private function menuNumberOfSons ( $menu_principal, $menu_parent ) {
		$nbr = 0;
		foreach ( $menu_principal as $A ) {
			if ( $A['menu_parent'] == $menu_parent ) { $nbr++; }
		}
		return $nbr;
	}
	
}