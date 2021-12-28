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
		
		$Content = "";
		if ( $CurrentSetObj->getInstanceOfUserObj()->hasPermission('admin_default_write_permission') === true ) {

			$localisation = " / ModuleAdministration";
			$bts->MapperObj->AddAnotherLevel($localisation );
			$bts->LMObj->logCheckpoint("ModuleAdministration");
			$bts->MapperObj->RemoveThisLevel($localisation );
			$bts->MapperObj->setSqlApplicant("ModuleAdministration");
			
			$Content = "";
			$dbquery = $bts->SDDMObj->query ("
				SELECT * 
				FROM ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('menu')." 
				WHERE menu_type IN ('2', '3') 
				AND fk_lang_id = '".$CurrentSetObj->getDataEntry ('language_id')."' 
				AND menu_state = '1' 
				ORDER BY menu_position , menu_name
				;");
				// AND fk_group_id ".$CurrentSetObj->getInstanceOfUserObj()->getUserEntry('clause_in_group')." 
				// AND fk_ws_id IN ('1', '".$CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_id')."')

			if ( $bts->SDDMObj->num_row_sql($dbquery) == 0) { echo ("Pas de menu afficher."); }
			else {
				$Content .= "<ul id='Admin_Menu_Simple' style='padding-left: 0px; margin-left: 0px; list-style: none outside none;'>\r";
				$infos['menuData'] = array();
				while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
					$cateIdIndex = $dbp['menu_id'];
					$infos['menuData'][$cateIdIndex] = array (
						"menu_id"		=> $dbp['menu_id'],
						"menu_type"		=> $dbp['menu_type'],
						"menu_title"	=> $dbp['menu_title'],
						"menu_desc"		=> $dbp['menu_desc'],
						"menu_parent"	=> $dbp['menu_parent'],
						"menu_position"	=> $dbp['menu_position'],
						"fk_group_id" 	=> $dbp['fk_group_id'],
						"fk_arti_ref"	=> $dbp['fk_arti_ref'],
						"fk_arti_slug"	=> $dbp['fk_arti_slug'],
					);
					if ( $dbp['menu_type'] == 2 ) { $rootMenu = $dbp['menu_id']; }
				}
				
				$infos['parameters'] = array (
					"menu_parent"	=> $rootMenu,
					"spaceSize"		=> 0,
					"level"			=> 0,
					"arti_request"	=> $CurrentSetObj->getDataSubEntry('article', 'arti_ref'),
				);
	// 			$Content .= "<!--\r".$StringFormatObj->print_r_debug($infos)."\r-->\r\r";
				$Content .= $this->renderAdminMenu($infos);
				$Content .= "</ul>\r";
			}
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
		$tabDecal = str_repeat("\t",$infos['parameters']['level']*2);
		foreach ( $infos['menuData'] as $A ) {
			if ($A['menu_parent'] == $infos['parameters']['menu_parent'] ) {
				if ( $A['fk_arti_ref'] == "0" ) {
					$Content .= $tabDecal."<li><b>".$A['menu_title']."</b>\r".$tabDecal."\t<ul style='list-style-type: none; margin-left: 10px; padding: 0px;'>\r";
					$tmp = $infos['parameters']['menu_parent'];
					$infos['parameters']['menu_parent'] = $A['menu_id'];
					$infos['parameters']['level']++;
					$Content .= $this->renderAdminMenu ($infos);
					$infos['parameters']['level']--;
					$infos['parameters']['menu_parent'] = $tmp;
					$Content .= $tabDecal."\t</ul>\r".$tabDecal."</li>\r";
				}
				elseif ( $A['fk_arti_ref'] == $infos['parameters']['arti_request'] ) {
					$Content .= $tabDecal."<li><span class='".$Block."_fade'><b>*".$A['menu_title']."</b></span></li>\r";
				}
				else {
					$Content .= $tabDecal."<li><a href=\"".$baseUrl.$A['fk_arti_slug']."/1\">".$A['menu_title']."</a></li>\r";
				}
			}
		}
		return $Content;
	}
}


?>