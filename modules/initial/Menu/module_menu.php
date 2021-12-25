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
//	Module : ModuleMenu
// --------------------------------------------------------------------------------------------

class ModuleMenu {
	public function __construct(){}

	public function render ($infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$Content = "";
		if ( $CurrentSetObj->getInstanceOfUserObj()->hasReadPermission('group_default_read_permission') === true ) {
			$ClassLoaderObj = ClassLoader::getInstance();
			$ClassLoaderObj->provisionClass('MenuData');

			$MenuDataObj = new MenuData();
			$MenuDataObj->RenderMenuData();

			$CurrentSetObj->setDataEntry('MenuDataTree', $MenuDataObj->getMenuDataTree());		// Good for debug
			
			$JavascriptTreeData = json_encode($MenuDataObj->getMenuDataTree(),JSON_FORCE_OBJECT);
			// $JavascriptTreeData = str_replace("{\"cate_id", "{\r\"cate_id", $JavascriptTreeData);
			$JavascriptTreeData = str_replace("},", "},\r", $JavascriptTreeData);
			$JavascriptTreeData = str_replace(",\"children\":{", ",\r\"children\":{", $JavascriptTreeData);
			$JavascriptData = "var MenuDataTree = { 'EntryPoint':'".$MenuDataObj->getEntryPoint()."',\r"
			.substr( $JavascriptTreeData, 1, strlen( $JavascriptTreeData )-2)
			."};\r\r";
			$CurrentSetObj->getInstanceOfGeneratedScriptObj()->insertString('JavaScript-Data', $JavascriptData);
			$Block = $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName();
			$Content .=  "
			<div id='menuTitle'>\r</div>\r
			<div id='menuSlide' class='menuSlideHost'>\r
				<div id='menuBlock1'	class='menuSlide'></div>\r
				<div id='menuBlock2'	class='menuSlide'></div>\r
				<div id='menuBlock3'	class='menuSlide'></div>\r
				<div id='menuBlock4'	class='menuSlide'></div>\r
				<div id='menuBlock5'	class='menuSlide'></div>\r
				<div id='menuBlock6'	class='menuSlide'></div>\r
				<div id='menuBlock7'	class='menuSlide'></div>\r
				<div id='menuBlock8'	class='menuSlide'></div>\r
				<div id='menuBlock9'	class='menuSlide'></div>\r
			</div>
			";

			$CurrentSetObj->getInstanceOfGeneratedScriptObj()->insertString('JavaScript-File', "modules/initial/Menu/javascript/MenuSlide.js");
			$CurrentSetObj->getInstanceOfGeneratedScriptObj()->insertString('JavaScript-Init', "ms = new MenuSlide();\r");
			$CurrentSetObj->getInstanceOfGeneratedScriptObj()->insertString('JavaScript-OnLoad', "\tms.initialization(MenuDataTree,'menuBlock');");
			$CurrentSetObj->getInstanceOfGeneratedScriptObj()->insertString('JavaScript-OnLoad', "\tms.makeMenu();");

		}
		
		if ( $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_info_debug') < 10 ) {
			unset (
				$i18n,
			);
		}
		return $Content;
	}


	/**
	 * Render the menu and return the HTML content
	 * @param array $infos
	 * @return string
	 */
	// public function renderOld ($infos) {
	// 	$bts = BaseToolSet::getInstance();
	// 	$CurrentSetObj = CurrentSet::getInstance();

	// 	$Content = "";
	// 	if ( $CurrentSetObj->getInstanceOfUserObj()->hasReadPermission('group_default_read_permission') === true ) {

	// 		$localisation = " / ModuleMenu";
	// 		$bts->MapperObj->AddAnotherLevel($localisation );
	// 		$bts->LMObj->logCheckpoint("ModuleMenu");
	// 		$bts->MapperObj->RemoveThisLevel($localisation );
	// 		$bts->MapperObj->setSqlApplicant("ModuleMenu");
			
	// 		//$RenderLayoutObj = RenderLayout::getInstance();
			
	// 		// $l = $bts->CMObj->getLanguageListSubEntry($CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_lang'), 'lang_639_3');
	// 		// $i18n = array();
	// 		// include ($infos['module']['module_directory']."/i18n/".$l.".php");
	// 		$l = $CurrentSetObj->getDataEntry ('language');
	// 		$bts->I18nTransObj->apply(array( "type" => "file", "file" => $infos['module']['module_directory']."/i18n/".$l.".php", "format" => "php" ) );
			
	// 		// 20110131 add a column on tab_deco_10_menu = type
	// 		// the type gives the menu index du menu to find.
	// 		// 00 = no menu / Offline
	// 		// 01 = static
	// 		// 02 = Div Animated
	// 		// 03 = banner style
	// 		// 1xx = Non official
			
	// 		// 2019 09 30 - Create a routine that scans the directory and store the filename in an array.
	// 		// This will allow to add more scripts without modifying the code.  
	// 		$menuTypeTab = array(
	// 				0 => "Offline",
	// 				1 => "modules/initial/Menu/ModuleMenuType01_static.php",
	// 				2 => "modules/initial/Menu/ModuleMenuType02_animation.php",
	// 				3 => "modules/initial/Menu/ModuleMenuType03_banner.php",
	// 		);
	// 		$menuType = $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeBlockEntry('B00M', 'genre');
	// 		$realpath = $CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('repertoire_courant'). "/modules/initial/Menu/";
	// 		$handle = opendir( $realpath );
			
	// 		$tmp = array();
	// 		while (false !== ( $f = readdir($handle))) {
	// 			$f_stat = stat( $realpath."/".$f );
	// 			if ( preg_match('/ModuleMenuType[0-9][0-9]_\w*\.php/', $f) ) {
	// 				if ( !is_dir($realpath."/".$f) && !is_link ($realpath."/".$f) ) {
	// 					$tmp[$f]['filename']	= $f;
	// 					$tmp[$f]['classname']	= substr($f, 0, 16 );
	// 					$tmp[$f]['fullname']	= $realpath.$f;
	// 					$tmp[$f]['size']		= $f_stat['size'];
	// 					$tmp[$f]['date']		= strftime ("%a %d %b %y - %H:%M", $f_stat['mtime'] );
	// 				}
	// 			}
	// 		}
			
	// 		sort  ($tmp);
	// 		reset ($tmp);
			
	// 		$fileList = array(0 => "Offline",);
	// 		$i=1;
	// 		foreach ($tmp as $A => &$B ) {
	// 			$fileList[$i] = $B;
	// 			$i++;
	// 		}

	// 		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "\$fileList" . $bts->StringFormatObj->arrayToString($fileList)));
			
	// 		// --------------------------------------------------------------------------------------------
	// 		// One query to get all the necessary informations for the processing 	
	// 		// --------------------------------------------------------------------------------------------
	// 		$infos['module_menu_requete'] = "
	// 			SELECT cat.* FROM "
	// 			.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('category')." cat, "
	// 			.$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('deadline')." bcl
	// 			WHERE cat.fk_ws_id = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."'
	// 			AND cat.fk_lang_id = '".$CurrentSetObj->getDataEntry ( 'language_id')."'
	// 			AND cat.fk_deadline_id = bcl.deadline_id
	// 			AND bcl.deadline_state = '1'
	// 			AND cat.cate_type IN ('0','1')
	// 			AND cat.fk_group_id ".$CurrentSetObj->getInstanceOfUserObj()->getUserEntry('clause_in_group')."
	// 			AND cat.cate_state = '1'
	// 			ORDER BY cat.cate_parent,cat.cate_position
	// 			;";
	// 		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : Query :" . $infos['module_menu_requete'] ));

	// 		$dbquery = $bts->SDDMObj->query($infos['module_menu_requete']);
	// 		$Content = "";
	// 		$menuData = &$infos['menuData'];
			
	// // 		$bts->StringFormatObj = StringFormat::getInstance();
	// 		if ( $bts->SDDMObj->num_row_sql($dbquery) == 0) { $Content .= "Nothing for the menu says SQL DB"; }
	// 		else {
	// 			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
	// 				$cate_id_index = $infos['cate_id_index'] = $dbp['cate_id'];
	// 				$menuData[$cate_id_index] = array (
	// 					"cate_id"		=> $dbp['cate_id'],
	// 					"cate_type"		=> $dbp['cate_type'],
	// 					"cate_title"	=> $dbp['cate_title'],
	// 					"cate_desc"		=> $dbp['cate_desc'],
	// 					"cate_parent"	=> $dbp['cate_parent'],
	// 					"cate_position"	=> $dbp['cate_position'],
	// 					"fk_group_id" 	=> $dbp['fk_group_id'],
	// 					"fk_arti_ref"	=> $dbp['fk_arti_ref'],
	// 					"fk_arti_slug"	=> $dbp['fk_arti_slug'],
	// 				);
	// 				if ( $dbp['cate_type'] == $menu_racine ) { $racine_menu = $dbp['cate_id']; }
	// 			}
	// 			$infos['FPRM'] = array (
	// 				"arti_request"	=> $CurrentSetObj->getDataSubEntry('article', 'arti_ref'),
	// 				"cate_parent" 	=> $racine_menu,
	// 				"module_z"		=> $infos['module_z_index'] + 1,
	// 				"origine_x"		=> 0,
	// 				"origine_y"		=> 0,
	// 				// "origine_x"		=> $RenderLayoutObj->getLayoutModuleEntry($infos['module']['module_name'], 'pos_x_ex22'),
	// 				// "origine_y"		=> $RenderLayoutObj->getLayoutModuleEntry($infos['module']['module_name'], 'pos_y_ex22'),
	// 				"init_x"		=> 0,
	// 				"init_y"		=> 0
	// 			);
	// 			$pv['menu_niveau'] = 0;
	// 			$pv['menu_JSON'] = array();
	// 			$pv['menu_div'] = array();
				
	// 			$Content .= "<!-- _______________________________________ DIVs menu (Begining) _______________________________________ -->";
	// 			$pv['test_routine'] = 0;
	// 			switch ( $pv['test_routine'] ) {										//M Menu; J Javascript. p parent, i id (en cours) , b bloc, d dossier,
	// 				case 0:
	// 					$execClass = $fileList[$menuType]['classname'];
	// 					if (!class_exists($execClass)) { 
	// 						if (file_exists($fileList[$menuType]['fullname'])) {
	// 							include ( $fileList[$menuType]['fullname'] );	
	// 							$execClassObj = call_user_func ( $execClass.'::getInstance');
	// 							$MenuData = $execClassObj->renderMenu($infos);
	// 						}
	// 					}
	// 					$Content .= "\r" . $MenuData["Content"];
	// 					break;
	// 				case 1:
	// 					$Content .= $i18n['jobless'];
	// 					break;
	// 			}
	// 			if ( isset($MenuData['extraContent'])) {
	// 				$CurrentSetObj->setDataSubEntry('RenderModule', 'extraContent', $MenuData['extraContent'] );
	// 			}
				
	// 			$Content .= "<!-- _______________________________________ DIVs menu (End) _______________________________________ -->";
	// 		}
			
	// // 		$GeneratedScriptObj = $CurrentSetObj->getInstanceOfGeneratedScriptObj();
	// 		$CurrentSetObj->getInstanceOfGeneratedScriptObj()->insertString('JavaScript-File', "modules/initial/Menu/javascript/ModuleMenuType02_animation.js");
	// 		$CurrentSetObj->getInstanceOfGeneratedScriptObj()->insertString('JavaScript-Data', $MenuData['JavaScriptData']. "var ZindexDepart = ".($infos['module_z_index'] + 1).";\r");
	// 		$CurrentSetObj->getInstanceOfGeneratedScriptObj()->insertString('JavaScript-OnLoad', "\tInitMenuDiv ( ".$MenuData['JavaScriptJSONName'].", TabInfoModule );");
	// 	}	
	// 	return $Content;
		
	// 	if ( $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_info_debug') < 10 ) {
	// 		unset (
	// 			$i18n,
	// 			$localisation,
	// 			$CurrentSetObj,
	// 			$menuData,
	// 			$cate_id_index,
	// 			$dbquery,
	// 			$dbp,
	// 			$MenuData
	// 			);
	// 	}

	// }
}
?>