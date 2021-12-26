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

class ModuleMenuType01 {
	private static $Instance = null;
	
	public function __construct() {}
	
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new ModuleMenuType01 ();
		}
		return self::$Instance;
	}
	
	public function renderMenu(&$infos){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		echo ("plop");
		
		$Content ="";
		$menu_racine=0;
		$menu_principal = array();
		$dbquery = $bts->SDDMObj->query($infos['module_menu_requete'] );
		$Content .= "<ul id='Admin_Menu_' style='padding-left: 0px; margin-left: 0px; list-style: none;'>\r";

		if ( $bts->SDDMObj->num_row_sql($dbquery) == 0) { $Content .= "Pas de menu afficher."; }
		else {
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				$menu_id_index = $dbp['menu_id'];
				$menu_principal[$menu_id_index] = array (
						"menu_id"		=> $dbp['menu_id'],
						"menu_type"		=> $dbp['menu_type'],
						"menu_title"	=> $dbp['menu_title'],
						"menu_desc"		=> $dbp['menu_desc'],
						"menu_parent"	=> $dbp['menu_parent'],
						"menu_position"	=> $dbp['menu_position'],
						"fk_group_id" 	=> $dbp['fk_group_id'],
						"fk_arti_ref"	=> $dbp['fk_arti_ref']
				);
				if ( $dbp['menu_type'] == $menu_racine ) { $racine_menu = $dbp['menu_id']; }
			}
			
			$infos['function_parameters'] = array (
					"arti_request"	=> $CurrentSetObj->getInstanceOfDocumentDataObj()->getDocumentData('arti_ref'),
					"menu_parent" 	=> $racine_menu,
					"espacement" 	=> 0
			);
			$infos['menu_principal'] = $menu_principal;
			$Content .= $this->menu_affichage_statique ($infos);
		}
		$Content .= "</ul>";
		
		if ( $CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_info_debug') < 10 ) {
			unset (
					$menu_principal ,
					$dbquery ,
					$dbp,
					);
		}
// 		$LMObj->logDebug($infos, "\$infos");
		
		return $Content;
	}
	
	private function menu_affichage_statique (&$infos) {
		$LMObj = LogManagement::getInstance();
		$CurrentSet = CurrentSet::getInstance();
// 		$WebSiteObj = $CurrentSet->getInstanceOfWebSiteObj();
// 		$UserObj = $CurrentSet->getInstanceOfUserObj();
		$ThemeDataObj = $CurrentSet->getInstanceOfThemeDataObj();
// 		$GeneratedScriptObj = $CurrentSet->getInstanceOfGeneratedScriptObj();
		$ThemeDataObj = $CurrentSet->getInstanceOfThemeDataObj();
		
		$Content = "";
		$Block = $ThemeDataObj->getThemeName().$infos['block'];
		$menu_principal = &$infos['menu_principal'];
		$function_parameters = &$infos['function_parameters'];
		
		foreach ( $menu_principal as $A ) {
			if ($A['menu_parent'] == $function_parameters['menu_parent'] ) {
				if ( $A['fk_arti_ref'] == "0" ) {
					$Content .= "<li><a  class='" . $Block."_lien ".$Block."_tb3' href=\"#\">".$A['menu_title']."</a>\r<ul style='padding-left: 5px; list-style: none;'>\r";
					$function_parametres_save = $function_parameters['menu_parent'];
					$function_parameters['menu_parent'] = $A['menu_id'];
					$this->menu_affichage_statique();
					$function_parameters['menu_parent'] = $function_parametres_save;
					$Content .= "</ul>\r</li>\r";
				}
				elseif ( $A['fk_arti_ref'] == $function_parameters['arti_request'] ) {
					$Content .= "<li><a  class='" . $Block."_lien ".$Block."_t3' href=\"#\">".$A['menu_title']."</a></li>\r";
				}
				else {
					$Content .= "<li>	<a  class='" . $Block."_lien ".$Block."_t3' href=\"index.php?arti_ref=".$A['fk_arti_ref']."&amp;arti_page=1".$bloc_html['url_slup']."\">".$A['menu_title']."</a></li>\r";
				}
			}
		}
		$LMObj->logDebug($infos, "\$infos");
		
		return $Content;
	}
	
	
}

?>
