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
//	Module : ModuleAdministration
// --------------------------------------------------------------------------------------------

class ModuleAdministration {
	public function __construct(){}
	
	public function render (&$infos) {
		$MapperObj = Mapper::getInstance();
		$LMObj = LogManagement::getInstance();
// 		$CMObj = ConfigurationManagement::getInstance();
		$SDDMObj = DalFacade::getInstance()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance(null, null);
		$StringFormatObj = StringFormat::getInstance();
		
		$CurrentSetObj = CurrentSet::getInstance();
		
		$localisation = " / ModuleAdministration";
		$MapperObj->AddAnotherLevel($localisation );
		$LMObj->logCheckpoint("ModuleAdministration");
		$MapperObj->RemoveThisLevel($localisation );
		$MapperObj->setSqlApplicant("ModuleAdministration");
		
		$UserObj = $CurrentSetObj->getInstanceOfUserObj();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
// 		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
// 		$l = $CurrentSetObj->getDataEntry('language');
		
// 		$i18n = array();
// 		include ("../modules/initial/Authentification/i18n/".$l.".php");
		
		$Content = "";
		$dbquery = $SDDMObj->query ("
			SELECT * 
			FROM ".$SqlTableListObj->getSQLTableName('categorie')." 
			WHERE cate_type IN ('2', '3') 
			AND site_id IN ('1', '".$WebSiteObj->getWebSiteEntry('sw_id')."') 
			AND cate_lang = '".$WebSiteObj->getWebSiteEntry('sw_lang')."' 
			AND groupe_id ".$UserObj->getUserEntry('clause_in_groupe')." 
			AND cate_etat = '1' 
			;");
// 		$Content .= "<!--
// 			ModuleAdministration:\r
// 			SELECT * 
// 			FROM ".$SqlTableListObj->getSQLTableName('categorie')." 
// 			WHERE cate_type IN ('2', '3') 
// 			AND site_id IN ('1', '".$WebSiteObj->getWebSiteEntry('sw_id')."') 
// 			AND cate_lang = '".$WebSiteObj->getWebSiteEntry('sw_lang')."' 
// 			AND groupe_id ".$UserObj->getUserEntry('clause_in_groupe')." 
// 			AND cate_etat = '1' 
// 			;
// 			-->";
		
		if ( $SDDMObj->num_row_sql($dbquery) == 0) { echo ("Pas de menu afficher."); }
		else {
			$Content .= "<ul id='Admin_Menu_Simple' style='padding-left: 0px; margin-left: 0px; list-style: none outside none;'>\r";
			$infos['menuData'] = array();
			while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
				$cateIdIndex = $dbp['cate_id'];
				$infos['menuData'][$cateIdIndex] = array (
					"cate_id"		=> $dbp['cate_id'],
					"cate_type"		=> $dbp['cate_type'],
					"cate_titre"	=> $dbp['cate_titre'],
					"cate_desc"		=> $dbp['cate_desc'],
					"cate_parent"	=> $dbp['cate_parent'],
					"cate_position"	=> $dbp['cate_position'],
					"groupe_id" 	=> $dbp['groupe_id'],
					"arti_ref"		=> $dbp['arti_ref']
				);
				if ( $dbp['cate_type'] == 2 ) { $rootMenu = $dbp['cate_id']; }
			}
			
			$infos['parameters'] = array (
				"cate_parent" 	=> $rootMenu,
				"spaceSize" 	=> 0,
				"level" 		=> 0,
				"arti_request"	=> $CurrentSetObj->getDataSubEntry('article', 'arti_ref'),
			);
// 			$Content .= "<!--\r".$StringFormatObj->print_r_debug($infos)."\r-->\r\r";
			$Content .= $this->renderAdminMenu($infos);
			$Content .= "</ul>\r</ul>\r";
		}
		
		if ( $WebSiteObj->getWebSiteEntry('sw_info_debug') < 10 ) {
			unset (
					$menu_principal ,
					$function_parametres ,
					$dbquery ,
					$dbp,
					$pv
					);
		}
		return $Content;
		
	}
	
	private function renderAdminMenu (&$infos) {
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$block = $ThemeDataObj->getThemeName().$infos['block'];
		
		foreach ( $infos['menuData'] as $A ) {
			if ($A['cate_parent'] == $infos['parameters']['cate_parent'] ) {
				if ( $A['arti_ref'] == "0" ) {
					$Content .= "<li><a class='".$block."_lien ".$block."_tb".$infos['module']['module_deco_txt_defaut']."' href=\"#\">".$A['cate_titre']."</a>\r<ul style='list-style-type: none; margin-left: 10px; padding: 0px;'>\r";
					$tmp = $infos['parameters']['cate_parent'];
					$infos['parameters']['cate_parent'] = $A['cate_id'];
					$infos['parameters']['level']++;
					$Content .= $this->renderAdminMenu ($infos);
					$infos['parameters']['level']--;
					$infos['parameters']['cate_parent'] = $tmp;
					$Content .= "</ul>\r</li>\r";
				}
				elseif ( $A['arti_ref'] == $infos['parameters']['arti_request'] ) {
					$Content .= "<li><a class='".$block."_lien ".$block."_t".$infos['module']['module_deco_txt_defaut']."' href=\"#\"><b>*</b>".$A['cate_titre']."</a></li>\r";
				}
				else {
					$Content .= "<li><a class='".$block."_lien ".$block."_t".$infos['module']['module_deco_txt_defaut']."' href=\"index.php?arti_ref=".$A['arti_ref']."&amp;arti_page=1".$CurrentSetObj->getDataSubEntry('block_HTML', 'url_slup')."\">".$A['cate_titre']."</a></li>\r";
				}
			}
		}
		return $Content;
	}
}


?>