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
//	Module : ModuleOffLineMessage
// --------------------------------------------------------------------------------------------

class ModuleOffLineMessage {
	public function __construct(){}
	
	public function render ($infos) {
		$ClassLoaderObj = ClassLoader::getInstance();
		$ClassLoaderObj->provisionClass('ThemeData');
		$ClassLoaderObj->provisionClass('RenderDeco40Elegance');
		$ClassLoaderObj->provisionClass('RenderLayout');
		$ClassLoaderObj->provisionClass('WebSite');
		
		
		$MapperObj = Mapper::getInstance();
		$LMObj = LogManagement::getInstance();
		$CMObj = ConfigurationManagement::getInstance();
		
		$localisation = " / ModuleOffLineMessage";
		$MapperObj->AddAnotherLevel($localisation );
		$LMObj->logCheckpoint("ModuleOffLineMessage");
		$MapperObj->RemoveThisLevel($localisation );
		$MapperObj->setSqlApplicant("ModuleOffLineMessage");
		
		$CurrentSetObj = CurrentSet::getInstance();
		$l = "eng";
		// --------------------------------------------------------------------------------------------
		$WebSiteObj = new WebSite();
		if ( $infos['SQLFatalError'] == 1 ) {
			$ClassLoaderObj->provisionClass('WebSite');
			$WebSiteObj->setWebSiteEntry('ws_name', "Doh!!!");
			$WebSiteObj->setWebSiteEntry('sw_message', "Database connexion error!");
			$WebSiteObj->setWebSiteEntry('ws_title', "Doh!!!");
		}
		
		if ( $infos['bannerOffline'] == 1 ) {
			$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
			$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
			$WebSiteObj->setWebSiteEntry('sw_message', "FR : Le site est hors ligne.<br><br>ENG: The website is offline.");
		}
		
		// --------------------------------------------------------------------------------------------
		
		include ("../stylesheets/css_admin_install.php");
		$theme_tableau = "theme_princ_";
		${$theme_tableau}['theme_module_largeur_interne'] = 896;
		${$theme_tableau}['theme_module_largeur'] = 896;
		
		$CurrentSetObj->setInstanceOfThemeDataObj(new ThemeData());
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$ThemeDataObj->setThemeData($theme_princ_); //Better to give an array than the object itself.
		$ThemeDataObj->setThemeName('theme_princ_');
		
		$RenderLayoutObj = RenderLayout::getInstance();

		$ClassLoaderObj->provisionClass('GeneratedJavaScript');
		$CurrentSetObj->setInstanceOfGeneratedJavaScriptObj(new GeneratedJavaScript());
		
		
		$ThemeDataObj->setThemeDataEntry('theme_divinitial_dx', 512);
		$ThemeDataObj->setThemeDataEntry('theme_divinitial_dy', 1024);
		
		
		$Content = "<!-- __________ start of modules __________ -->\r
		<div id='initial_div' style='position:relative; margin-left: auto; margin-right: auto; visibility: hidden;
		width:".$ThemeDataObj->getThemeDataEntry('theme_divinitial_dx')."px;
		height:".$ThemeDataObj->getThemeDataEntry('theme_divinitial_dy')."px;".
		"'>\r";

		$infos = array(
			"mode" => 1,
			"affiche_module_mode" => "normal",
			"module_z_index" => 2,
			"block" => "B01",
			"blockG" => "B01G",
			"blockT" => "B01T",
			"deco_type" => 40,
			"module" => Array
			(
				"module_id" => 11,
				"module_deco" => 1,
				"module_deco_nbr" => 2,
				"module_deco_txt_defaut" => 3,
				"module_nom" => "OfflineMessage",
				"module_classname" => "",
				"module_titre" => "",
				"module_fichier" => "",
				"module_desc" => "",
				"module_conteneur_nom" => "",
				"module_groupe_pour_voir" => 31,
				"module_groupe_pour_utiliser" => 31,
				"module_adm_control" => 0,
				"module_execution" => 0,
				"site_module_id" => 11,
				"site_id" => 2,
				"module_etat" => 1,
				"module_position" => 2,
			)
		);
		
		$RenderDeco = RenderDeco40Elegance::getInstance();
		
		// --------------------------------------------------------------------------------------------
		
		$RenderLayoutObj->setLayoutModuleEntry($infos['module']['module_nom'], "px", 0 );
		$RenderLayoutObj->setLayoutModuleEntry($infos['module']['module_nom'], "py", 128 );
		$RenderLayoutObj->setLayoutModuleEntry($infos['module']['module_nom'], "dx", 512 );
		$RenderLayoutObj->setLayoutModuleEntry($infos['module']['module_nom'], "dy", 256 );
		
		$RenderLayoutObj->setModuleList(
			array(
				$infos['module']['module_nom'] => array ('module_deco_txt_defaut'	=>	6 ),
			)
		);
		
		$Content = "
			<!DOCTYPE html>
			<html>\r
			<head>\r
			<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>\r
			<title>".$WebSiteObj->getWebSiteEntry('sw_title')."</title>\r
			".$stylesheet."\r
			</head>\r
			<body id='MWMbody' text='".$ThemeDataObj->getThemeBlockEntry('B01T', 'deco_txt_col')."' link='".$ThemeDataObj->getThemeBlockEntry('B01T', 'deco_txt_l_01_fg_col')."' vlink='".$ThemeDataObj->getThemeBlockEntry('B01T', 'deco_txt_l_01_fg_visite_col')."' alink='".$ThemeDataObj->getThemeBlockEntry('B01T', 'deco_txt_l_01_fg_active_col')."' background='../graph/".${$theme_tableau}['theme_repertoire']."/".${$theme_tableau}['theme_bg']."'>\r\r
			<!-- __________ start of modules __________ -->\r
			<div id='initial_div' style='position:relative; margin-left: auto; margin-right: auto; visibility: visible;
			width:".$ThemeDataObj->getThemeDataEntry('theme_divinitial_dx')."px; 
			height:".$ThemeDataObj->getThemeDataEntry('theme_divinitial_dy')."px;".
			"'>\r".
			$RenderDeco->render($infos).
			$WebSiteObj->getWebSiteEntry('sw_message')."<br>\r".
			$RenderLayoutObj->getLayoutModuleEntry($infos['module']['module_nom'], 'module_deco_txt_defaut')."<br>\r".
			"
			</div>\r
			</div>\r
			</body>\r
			</html>\r
			";
			
		echo ($Content);
		exit ();
	
	}
}
?>