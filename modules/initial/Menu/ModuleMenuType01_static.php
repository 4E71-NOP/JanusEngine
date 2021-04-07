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
		
		$menu_principal = array();
		$dbquery = $bts->SDDMObj->query($infos['module_menu_requete'] );
		$Content .= "<ul id='Admin_Menu_' style='padding-left: 0px; margin-left: 0px; list-style: none;'>\r";

		if ( $bts->SDDMObj->num_row_sql($dbquery) == 0) { $Content .= "Pas de menu afficher."; }
		else {
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				$cate_id_index = $dbp['cate_id'];
				$menu_principal[$cate_id_index] = array (
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
			
			$infos['function_parameters'] = array (
					"arti_request"	=> $CurrentSetObj->getInstanceOfDocumentDataObj()->getDocumentData('arti_ref'),
					"cate_parent" 	=> $racine_menu,
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
// 		global $module_, $theme_tableau, ${$theme_tableau}, $bloc_html, $db_, $menu_principal, $function_parametres, $tl_, $l, $pv, $theme_tableau;
		$CurrentSet = CurrentSet::getInstance();
// 		$WebSiteObj = $CurrentSet->getInstanceOfWebSiteObj();
// 		$UserObj = $CurrentSet->getInstanceOfUserObj();
		$ThemeDataObj = $CurrentSet->getInstanceOfThemeDataObj();
// 		$GeneratedJavaScriptObj = $CurrentSet->getInstanceOfGeneratedJavaScriptObj();
		$ThemeDataObj = $CurrentSet->getInstanceOfThemeDataObj();
		
		$Content = "";
		$Block = $ThemeDataObj->getThemeName().$infos['block'];
		$menu_principal = &$infos['menu_principal'];
		$function_parameters = &$infos['function_parameters'];
		
		foreach ( $menu_principal as $A ) {
			if ($A['cate_parent'] == $function_parameters['cate_parent'] ) {
				if ( $A['arti_ref'] == "0" ) {
					$Content .= "<li><a  class='" . $Block."_lien ".$Block."_tb3' href=\"#\">".$A['cate_title']."</a>\r<ul style='padding-left: 5px; list-style: none;'>\r";
					$function_parametres_save = $function_parameters['cate_parent'];
					$function_parameters['cate_parent'] = $A['cate_id'];
					$this->menu_affichage_statique ();
					$function_parameters['cate_parent'] = $function_parametres_save;
					$Content .= "</ul>\r</li>\r";
				}
				elseif ( $A['arti_ref'] == $function_parameters['arti_request'] ) {
					$Content .= "<li><a  class='" . $Block."_lien ".$Block."_t3' href=\"#\">".$A['cate_title']."</a></li>\r";
				}
				else {
					$Content .= "<li>	<a  class='" . $Block."_lien ".$Block."_t3' href=\"index.php?arti_ref=".$A['arti_ref']."&amp;arti_page=1".$bloc_html['url_slup']."\">".$A['cate_title']."</a></li>\r";
				}
			}
		}
		$LMObj->logDebug($infos, "\$infos");
		
		return $Content;
	}
	
	
}

?>
