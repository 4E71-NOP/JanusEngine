<?php
 // // @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see       : https://github.com/4E71-NOP/JanusEngine
//
// @license   : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author    : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note      : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//              without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end


//	Module : ModuleAdministration
// --------------------------------------------------------------------------------------------

class ModuleAdministration {
	public function __construct(){}
	
	public function render (&$infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		$Content = "";
		if ( $CurrentSetObj->UserObj->hasPermission('admin_default_write_permission') === true ) {
			$bts->mapSegmentLocation(__METHOD__, "ModuleAdministration");
			
			$Content = "";
			$dbquery = $bts->SDDMObj->query("SELECT "
				. "CONCAT('0x', HEX(menu_id)) AS menu_id, "
				. "menu_name, "
				. "menu_title, "
				. "menu_desc, "
				. "menu_type, "
				. "menu_visibility, "
				. "CONCAT('0x', HEX(fk_ws_id)) AS fk_ws_id, "
				. "CONCAT('0x', HEX(fk_lang_id)) AS fk_lang_id, "
				. "CONCAT('0x', HEX(fk_deadline_id)) AS fk_deadline_id, "
				. "menu_state, "
				. "CONCAT('0x', HEX(menu_parent)) AS menu_parent, "
				. "menu_position, "
				. "CONCAT('0x', HEX(fk_perm_id)) AS fk_perm_id, "
				. "menu_last_update, "
				. "menu_role, "
				. "menu_initial_document, "
				. "fk_arti_slug, "
				. "fk_arti_ref "
				. "FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName('menu') . " "
				. "WHERE menu_type IN ('2', '3')  "
				. "AND fk_lang_id = " . $CurrentSetObj->getDataEntry('language_id') . "  "
				. "AND menu_state = 1  "
				. "ORDER BY menu_name "
				. ";");
				// AND fk_group_id ".$CurrentSetObj->UserObj->getUserEntry('clause_in_group')." 
				// AND fk_ws_id IN ('1', '".$CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_id')."')

			if ( $bts->SDDMObj->num_row_sql($dbquery) == 0) { echo ("Pas de menu afficher."); }
			else {
				$Content .= "<ul id='Admin_Menu_Simple' class='common_content' style='padding-left: 0px; margin-left: 0px; list-style: none outside none;'>\r";
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
				// $Content .= "<!--\r".$StringFormatObj->print_r_debug($infos)."\r-->\r\r";
				$Content .= $this->renderAdminMenu($infos);
				$Content .= "</ul>\r";
			}

			$bts->segmentEnding(__METHOD__);
			}
		if ( $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_info_debug') < 10 ) {
			unset (
					$dbquery ,
					$dbp,
					);
		}
		return $Content;
		
	}
	
	private function renderAdminMenu (&$infos) {
		$CurrentSetObj = CurrentSet::getInstance();
		$Block = $CurrentSetObj->ThemeDataObj->getThemeName().$infos['block'];
		$baseUrl  = $CurrentSetObj->ServerInfosObj->getServerInfosEntry('baseUrl'); 
		$Content = "";
		$tabDecal = str_repeat("\t",$infos['parameters']['level']*2);
		foreach ( $infos['menuData'] as $A ) {
			if ($A['menu_parent'] == $infos['parameters']['menu_parent'] ) {
				if ( $A['fk_arti_ref'] == "0" ) {
					$Content .= $tabDecal."<li class='common_content'><b>".$A['menu_title']."</b>\r".$tabDecal."\t<ul class='common_content' style='list-style-type: none; margin-left: 10px; padding: 0px;'>\r";
					$tmp = $infos['parameters']['menu_parent'];
					$infos['parameters']['menu_parent'] = $A['menu_id'];
					$infos['parameters']['level']++;
					$Content .= $this->renderAdminMenu ($infos);
					$infos['parameters']['level']--;
					$infos['parameters']['menu_parent'] = $tmp;
					$Content .= $tabDecal."\t</ul>\r".$tabDecal."</li>\r";
				}
				elseif ( $A['fk_arti_ref'] == $infos['parameters']['arti_request'] ) {
					$Content .= $tabDecal."<li class='common_content'><span class='".$Block."_fade'><b>*".$A['menu_title']."</b></span></li>\r";
				}
				else {
					$Content .= $tabDecal."<li class='common_content'><a href=\"".$baseUrl.$A['fk_arti_slug']."/1\">".$A['menu_title']."</a></li>\r";
				}
			}
		}
		return $Content;
	}
}


?>