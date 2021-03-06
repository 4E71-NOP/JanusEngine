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
		$cs = CommonSystem::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$localisation = " / ModuleAdministration";
		$cs->MapperObj->AddAnotherLevel($localisation );
		$cs->LMObj->logCheckpoint("ModuleAdministration");
		$cs->MapperObj->RemoveThisLevel($localisation );
		$cs->MapperObj->setSqlApplicant("ModuleAdministration");
		
		$Content = "";
		$dbquery = $cs->SDDMObj->query ("
			SELECT * 
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('category')." 
			WHERE cate_type IN ('2', '3') 
			AND ws_id IN ('1', '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."') 
			AND cate_lang = '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_lang')."' 
			AND group_id ".$CurrentSetObj->getInstanceOfUserObj()->getUserEntry('clause_in_group')." 
			AND cate_state = '1' 
			;");
		
		if ( $cs->SDDMObj->num_row_sql($dbquery) == 0) { echo ("Pas de menu afficher."); }
		else {
			$Content .= "<ul id='Admin_Menu_Simple' style='padding-left: 0px; margin-left: 0px; list-style: none outside none;'>\r";
			$infos['menuData'] = array();
			while ($dbp = $cs->SDDMObj->fetch_array_sql($dbquery)) {
				$cateIdIndex = $dbp['cate_id'];
				$infos['menuData'][$cateIdIndex] = array (
					"cate_id"		=> $dbp['cate_id'],
					"cate_type"		=> $dbp['cate_type'],
					"cate_title"	=> $dbp['cate_title'],
					"cate_desc"		=> $dbp['cate_desc'],
					"cate_parent"	=> $dbp['cate_parent'],
					"cate_position"	=> $dbp['cate_position'],
					"group_id" 	=> $dbp['group_id'],
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
		
		if ( $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_info_debug') < 10 ) {
			unset (
					$dbquery ,
					$dbp,
					);
		}
		return $Content;
		
	}
	
	private function renderAdminMenu (&$infos) {
		$CurrentSetObj = CurrentSet::getInstance();
		$block = $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName().$infos['block'];
		
		foreach ( $infos['menuData'] as $A ) {
			if ($A['cate_parent'] == $infos['parameters']['cate_parent'] ) {
				if ( $A['arti_ref'] == "0" ) {
					$Content .= "<li><a class='".$block."_lien ".$block."_tb".$infos['module']['module_deco_default_text']."' href=\"#\">".$A['cate_title']."</a>\r<ul style='list-style-type: none; margin-left: 10px; padding: 0px;'>\r";
					$tmp = $infos['parameters']['cate_parent'];
					$infos['parameters']['cate_parent'] = $A['cate_id'];
					$infos['parameters']['level']++;
					$Content .= $this->renderAdminMenu ($infos);
					$infos['parameters']['level']--;
					$infos['parameters']['cate_parent'] = $tmp;
					$Content .= "</ul>\r</li>\r";
				}
				elseif ( $A['arti_ref'] == $infos['parameters']['arti_request'] ) {
					$Content .= "<li><a class='".$block."_lien ".$block."_t".$infos['module']['module_deco_default_text']."' href=\"#\"><b>*</b>".$A['cate_title']."</a></li>\r";
				}
				else {
					$Content .= "<li><a class='".$block."_lien ".$block."_t".$infos['module']['module_deco_default_text']."' href=\"index.php?arti_ref=".$A['arti_ref']."&amp;arti_page=1".$CurrentSetObj->getDataSubEntry('block_HTML', 'url_slup')."\">".$A['cate_title']."</a></li>\r";
				}
			}
		}
		return $Content;
	}
}


?>