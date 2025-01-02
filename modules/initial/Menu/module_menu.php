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
//	Module : ModuleMenu
// --------------------------------------------------------------------------------------------

class ModuleMenu {
	public function __construct(){}

	/**
	 * Renders the menu and sets the necessary assets (javascript, etc.)
	 * 
	 * @param array
	 * @return string
	 */
	public function render ($infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$Content = "";
		if ( $CurrentSetObj->UserObj->hasPermission('group_default_read_permission') === true ) {
			$ClassLoaderObj = ClassLoader::getInstance();
			$ClassLoaderObj->provisionClass('MenuData');

			$MenuDataObj = new MenuData();
			$MenuDataObj->RenderMenuData();

			$JavaScriptData = "var MenuData = {\r
				'EntryPoint':'m".$MenuDataObj->getEntryPoint()."',\r
				'theme_name':'".$CurrentSetObj->ThemeDataObj->getThemeName()."',\r
				'menu_id':'m".$CurrentSetObj->getDataSubEntry ( 'article', 'menu_id')."',\r
				'block':'".$infos['block']."',\r
				'Payload':{\r";
			$RawData = $MenuDataObj->getMenuDataRaw();
			foreach ( $RawData as $A ) { 
				$A['menu_id'] = "m".$A['menu_id'];				// Javascript does store numbers compliant to IEEE 754 
				$A['menu_parent'] = "m".$A['menu_parent'];		// Big number can be outside the max...
				$JavaScriptData .= "'".$A['menu_id']."':".json_encode($A,JSON_FORCE_OBJECT).",\r"; 
			}
			$JavaScriptData .= "}\r}\r";
			$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-Data', $JavaScriptData);
			
			$Content .= "
			<div id='menuTitle' class='menuSlideTitle' >\r</div>\r
			<div id='menuSlide' class='menuSlideHost'>\r
			";

			$maxMenuLevel=10;
			$first=" moveIn";
			for ( $i=1; $i<=$maxMenuLevel; $i++) {
				$Content .= "<div id='menuBlock".$i."'	class='menuSlide".$first."'></div>\r";
				$first="";
			}
			$Content .= "</div>\r";

			$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-File', $infos['module']['module_directory'].'javascript/MenuSlide.js');
			$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-Init', "ms = new MenuSlide();\r");
			$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-OnLoad', "\tms.initialization(MenuData,'menuBlock');");
			$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-OnLoad', "\tms.makeMenu();");
			$CurrentSetObj->GeneratedScriptObj->insertString('Css-File', $infos['module']['module_directory'].'css/MenuSlide.css');
		}
		
		if ( $CurrentSetObj->WebSiteObj->getWebSiteEntry('ws_info_debug') < 10 ) {
			unset (
				$i18n,
			);
		}
		return $Content;
	}
}
?>