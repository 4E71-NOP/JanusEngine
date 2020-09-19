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
	
	/**
	 * Render the menu and return the HTML content
	 * @param array $infos
	 * @return string
	 */
	public function render ($infos) {
		$MapperObj = Mapper::getInstance();
		$LMObj = LogManagement::getInstance();
		$CMObj = ConfigurationManagement::getInstance();
		$SDDMObj = DalFacade::getInstance()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance(null, null);
		
		$localisation = " / ModuleMenu";
		$MapperObj->AddAnotherLevel($localisation );
		$LMObj->logCheckpoint("ModuleMenu");
		$MapperObj->RemoveThisLevel($localisation );
		$MapperObj->setSqlApplicant("ModuleMenu");
		
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		$UserObj = $CurrentSetObj->getInstanceOfUserObj();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$GeneratedJavaScriptObj = $CurrentSetObj->getInstanceOfGeneratedJavaScriptObj();
		$ServerInfosObj = $CurrentSetObj->getInstanceOfServerInfosObj();
 		$RenderLayoutObj = RenderLayout::getInstance();
 		$StringFormatObj = StringFormat::getInstance();
 		
 		
 		
		$l = $CMObj->getLanguageListSubEntry($WebSiteObj->getWebSiteEntry('ws_lang'), 'lang_639_3');
		$i18n = array();
		include ($infos['module']['module_directory']."/i18n/".$l.".php");
		
		// 20110131 add a column on tab_deco_10_menu = type
		// the type gives the menu index du menu to find.
		// 00 = no menu / Offline
		// 01 = static
		// 02 = Div Animated
		// 03 = banner style
		// 1xx = Non official
		
		// 2019 09 30 - Create a routine that scans the directory and store the filename in an array.
		// This will allow to add more scripts without modifying the code.  
		$menuTypeTab = array(
				0 => "Offline",
				1 => "../modules/initial/Menu/ModuleMenuType01_static.php",
				2 => "../modules/initial/Menu/ModuleMenuType02_animation.php",
				3 => "../modules/initial/Menu/ModuleMenuType03_banner.php",
		);
		$menuType = $ThemeDataObj->getThemeBlockEntry('B00M', 'genre');
		$realpath = $ServerInfosObj->getServerInfosEntry('repertoire_courant'). "/../modules/initial/Menu/";
		$handle = opendir( $realpath );
		
		$tmp = array();
		while (false !== ( $f = readdir($handle))) {
			$f_stat = stat( $realpath."/".$f );
			if ( preg_match('/ModuleMenuType[0-9][0-9]_\w*\.php/', $f) ) {
				if ( !is_dir($realpath."/".$f) && !is_link ($realpath."/".$f) ) {
					$tmp[$f]['filename']	= $f;
					$tmp[$f]['classname']	= substr($f, 0, 16 );
					$tmp[$f]['fullname']	= $realpath.$f;
					$tmp[$f]['size']		= $f_stat['size'];
					$tmp[$f]['date']		= strftime ("%a %d %b %y - %H:%M", $f_stat['mtime'] );
				}
			}
		}
		
		sort  ($tmp);
		reset ($tmp);
		
		$fileList = array(0 => "Offline",);
		$i=1;
		foreach ($tmp as $A => &$B ) {
			$fileList[$i] = $B;
			$i++;
		}

		$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => __METHOD__ . "\$fileList" . $StringFormatObj->arrayToString($fileList)));
		
		// --------------------------------------------------------------------------------------------
		// One query to get all the necessary informations for the processing 	
		// --------------------------------------------------------------------------------------------
		$infos['module_menu_requete'] = "
		SELECT cat.*
		FROM ".$SqlTableListObj->getSQLTableName('category')." cat, ".$SqlTableListObj->getSQLTableName('deadline')." bcl
		WHERE cat.ws_id = '".$WebSiteObj->getWebSiteEntry('ws_id')."'
		AND cat.cate_lang = '".$WebSiteObj->getWebSiteEntry('ws_lang')."'
		AND cat.deadline_id = bcl.deadline_id
		AND bcl.deadline_state = '1'
		AND cat.cate_type IN ('0','1')
		AND cat.group_id ".$UserObj->getUserEntry('clause_in_group')."
		AND cat.cate_state = '1'
		ORDER BY cat.cate_parent,cat.cate_position
		;";
		$dbquery = $SDDMObj->query($infos['module_menu_requete']);
		$Content = "";
		$menuData = &$infos['menuData'];
		
		$StringFormatObj = StringFormat::getInstance();
		if ( $SDDMObj->num_row_sql($dbquery) == 0) { $Content .= "Pas de menu afficher."; }
		else {
			while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
				$cate_id_index = $infos['cate_id_index'] = $dbp['cate_id'];
				$menuData[$cate_id_index] = array (
					"cate_id"		=> $dbp['cate_id'],
					"cate_type"		=> $dbp['cate_type'],
					"cate_title"	=> $dbp['cate_title'],
					"cate_desc"		=> $dbp['cate_desc'],
					"cate_parent"	=> $dbp['cate_parent'],
					"cate_position"	=> $dbp['cate_position'],
					"group_id" 	=> $dbp['group_id'],
					"arti_ref"		=> $dbp['arti_ref']
				);
				if ( $dbp['cate_type'] == $menu_racine ) { $racine_menu = $dbp['cate_id']; }
			}
			$infos['FPRM'] = array (
				"arti_request"	=> $CurrentSetObj->getDataSubEntry('document', 'arti_ref'),
				"cate_parent" 	=> $racine_menu,
				"module_z"		=> $infos['module_z_index'] + 1,
				"origine_x"		=> $RenderLayoutObj->getLayoutModuleEntry($infos['module']['module_name'], 'pos_x_ex22'),
				"origine_y"		=> $RenderLayoutObj->getLayoutModuleEntry($infos['module']['module_name'], 'pos_y_ex22'),
				"init_x"		=> 0,
				"init_y"		=> 0
			);
			$pv['menu_niveau'] = 0;
			$pv['menu_JSON'] = array();
			$pv['menu_div'] = array();
			
			$Content .= "<!-- _______________________________________ DIVs menu (Begining) _______________________________________ -->";
			$pv['test_routine'] = 0;
			switch ( $pv['test_routine'] ) {										//M Menu; J Javascript. p parent, i id (en cours) , b bloc, d dossier,
				case 0:
					$execClass = $fileList[$menuType]['classname'];
					if (!class_exists($execClass)) { 
						if (file_exists($fileList[$menuType]['fullname'])) {
							include ( $fileList[$menuType]['fullname'] );	
							$execClassObj = call_user_func ( $execClass.'::getInstance');
							$MenuData = $execClassObj->renderMenu($infos);
						}
					}
					$Content .= "\r" . $MenuData["Content"];
					break;
				case 1:
					$Content .= $i18n['jobless'];
					break;
			}
			if ( isset($MenuData['extraContent'])) {
				$CurrentSetObj->setDataSubEntry('RenderModule', 'extraContent', $MenuData['extraContent'] );
			}
			
			$Content .= "<!-- _______________________________________ DIVs menu (End) _______________________________________ -->";
		}
		
		$GeneratedJavaScriptObj = $CurrentSetObj->getInstanceOfGeneratedJavaScriptObj();
		$GeneratedJavaScriptObj->insertJavaScript('File', "../modules/initial/Menu/javascript/ModuleMenuType02_animation.js");
		$GeneratedJavaScriptObj->insertJavaScript('Data', $MenuData['JavaScriptData']. "var ZindexDepart = ".($infos['module_z_index'] + 1).";\r");
		$GeneratedJavaScriptObj->insertJavaScript('Onload', "\tInitMenuDiv ( ".$MenuData['JavaScriptJSONName'].", TabInfoModule );");
		
		return $Content;
		
		if ( $WebSiteObj->getWebSiteEntry('ws_info_debug') < 10 ) {
			unset (
				$i18n,
				$localisation,
				$MapperObj,
				$LMObj,
				$MapperObj,
				$CurrentSetObj,
				$WebSiteObj,
				$ThemeDataObj,
				$CMObj,
				$menuData,
				$cate_id_index,
				$FPRM,
				$dbquery,
				$dbp,
				$pv,
				$MenuData
				);
		}

	}
}
?>