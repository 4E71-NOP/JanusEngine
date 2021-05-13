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
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$localisation = " / ModuleAdministration";
		$bts->MapperObj->AddAnotherLevel($localisation );
		$bts->LMObj->logCheckpoint("ModuleAdministration");
		$bts->MapperObj->RemoveThisLevel($localisation );
		$bts->MapperObj->setSqlApplicant("ModuleAdministration");
		
		$Content = "";
		$dbquery = $bts->SDDMObj->query ("
			SELECT * 
			FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('category')." 
			WHERE cate_type IN ('2', '3') 
			AND fk_ws_id IN ('1', '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."')
			AND fk_lang_id = '".$CurrentSetObj->getDataEntry ( 'language_id')."' 
			AND fk_group_id ".$CurrentSetObj->getInstanceOfUserObj()->getUserEntry('clause_in_group')." 
			AND cate_state = '1' 
			ORDER BY cate_id 
			;");
		
		if ( $bts->SDDMObj->num_row_sql($dbquery) == 0) { echo ("Pas de menu afficher."); }
		else {
			$Content .= "<ul id='Admin_Menu_Simple' style='padding-left: 0px; margin-left: 0px; list-style: none outside none;'>\r";
			$infos['menuData'] = array();
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				$cateIdIndex = $dbp['cate_id'];
				$infos['menuData'][$cateIdIndex] = array (
					"cate_id"		=> $dbp['cate_id'],
					"cate_type"		=> $dbp['cate_type'],
					"cate_title"	=> $dbp['cate_title'],
					"cate_desc"		=> $dbp['cate_desc'],
					"cate_parent"	=> $dbp['cate_parent'],
					"cate_position"	=> $dbp['cate_position'],
					"fk_group_id" 	=> $dbp['fk_group_id'],
					"fk_arti_ref"	=> $dbp['fk_arti_ref'],
					"fk_arti_slug"	=> $dbp['fk_arti_slug'],
				);
				if ( $dbp['cate_type'] == 2 ) { $rootMenu = $dbp['cate_id']; }
			}
			
			$infos['parameters'] = array (
				"cate_parent"	=> $rootMenu,
				"spaceSize"		=> 0,
				"level"			=> 0,
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
		$Block = $CurrentSetObj->getInstanceOfThemeDataObj()->getThemeName().$infos['block'];
		$baseUrl  = $CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url'); 
		$Content = "";
		foreach ( $infos['menuData'] as $A ) {
			if ($A['cate_parent'] == $infos['parameters']['cate_parent'] ) {
				if ( $A['fk_arti_ref'] == "0" ) {
					$Content .= "<li><b>".$A['cate_title']."</b>\r<ul style='list-style-type: none; margin-left: 10px; padding: 0px;'>\r";
					$tmp = $infos['parameters']['cate_parent'];
					$infos['parameters']['cate_parent'] = $A['cate_id'];
					$infos['parameters']['level']++;
					$Content .= $this->renderAdminMenu ($infos);
					$infos['parameters']['level']--;
					$infos['parameters']['cate_parent'] = $tmp;
					$Content .= "</ul>\r</li>\r";
				}
				elseif ( $A['fk_arti_ref'] == $infos['parameters']['arti_request'] ) {
					$Content .= "<li><span class='".$Block."_fade'><b>*".$A['cate_title']."</b></li>\r";
				}
				else {
					$Content .= "<li><a href=\"".$baseUrl.$A['fk_arti_slug']."/1\">".$A['cate_title']."</a></li>\r";
				}
			}
		}
		return $Content;
	}
}


?>