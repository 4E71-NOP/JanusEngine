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
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();
		$ClassLoaderObj->provisionClass('RenderDeco40Elegance');
		$ClassLoaderObj->provisionClass('RenderLayout');
		$ClassLoaderObj->provisionClass('ThemeData');
		$ClassLoaderObj->provisionClass('WebSite');
		
		$localisation = " / ModuleOffLineMessage";
		$bts->MapperObj->AddAnotherLevel($localisation );
		$bts->LMObj->logCheckpoint("ModuleOffLineMessage");
		$bts->MapperObj->RemoveThisLevel($localisation );
		$bts->MapperObj->setSqlApplicant("ModuleOffLineMessage");
		
		$l = "eng";
		// --------------------------------------------------------------------------------------------
		$WebSiteObj = new WebSite();
		
		if ( $infos['SQLFatalError'] == 1 ) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " SQLFatalError=1 The website is offline."));
			$WebSiteObj->setWebSiteEntry('ws_name', "Doh!!!");
			$WebSiteObj->setWebSiteEntry('ws_message', "Database connexion error!");
			$WebSiteObj->setWebSiteEntry('ws_title', "Doh!!!");
		}
		
		if ( $infos['bannerOffline'] == 1 ) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " bannerOffline=1 The website is offline."));
// 			$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
// 			$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
			$WebSiteObj->setWebSiteEntry('ws_message', "FR : Le site est hors ligne.<br><br>ENG: The website is offline.");
		}
		
		// --------------------------------------------------------------------------------------------
		
		include ("../stylesheets/css_admin_install.php");
		$mt_ = array_merge(
				$mt_,
				array(
					'theme_module_internal_width'=> 896,
					'theme_module_width' => 896,)
		);
		
		$CurrentSetObj->setInstanceOfThemeDataObj(new ThemeData());
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
		$ThemeDataObj->setThemeData($mt_); //Better to give an array than the object itself.
		$ThemeDataObj->setThemeName('mt_');
		
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
			"module_display_mode" => "normal",
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
				"module_deco_default_text" => 3,
				"module_name" => "OfflineMessage",
				"module_classname" => "",
				"module_title" => "",
				"module_file" => "",
				"module_desc" => "",
				"module_container_name" => "",
				"module_group_allowed_to_see" => 31,
				"module_group_allowed_to_use" => 31,
				"module_adm_control" => 0,
				"module_execution" => 0,
				"module_website_id" => 11,
				"ws_id" => 2,
				"module_state" => 1,
				"module_position" => 2,
			)
		);
		
		$RenderDeco = RenderDeco40Elegance::getInstance();
		
		// --------------------------------------------------------------------------------------------
		
		$RenderLayoutObj->setLayoutModuleEntry($infos['module']['module_name'], "px", 0 );
		$RenderLayoutObj->setLayoutModuleEntry($infos['module']['module_name'], "py", 128 );
		$RenderLayoutObj->setLayoutModuleEntry($infos['module']['module_name'], "dx", 512 );
		$RenderLayoutObj->setLayoutModuleEntry($infos['module']['module_name'], "dy", 256 );
		
		$RenderLayoutObj->setModuleList(
			array(
				$infos['module']['module_name'] => array ('module_deco_default_text'	=>	6 ),
			)
		);
		
		$Content = "
			<!DOCTYPE html>
			<html>\r
			<head>\r
			<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>\r
			<title>".$WebSiteObj->getWebSiteEntry('ws_title')."</title>\r
			".$stylesheet."\r
			</head>\r
			<body id='HydrBody' text='".$ThemeDataObj->getThemeBlockEntry('B01T', 'deco_txt_col')."' link='".$ThemeDataObj->getThemeBlockEntry('B01T', 'deco_txt_l_01_fg_col')."' vlink='".$ThemeDataObj->getThemeBlockEntry('B01T', 'deco_txt_l_01_fg_visite_col')."' alink='".$ThemeDataObj->getThemeBlockEntry('B01T', 'deco_txt_l_01_fg_active_col')."' background='../media/theme/".$ThemeDataObj->getThemeDataEntry ( 'theme_directory' ) . "/" . $ThemeDataObj->getThemeDataEntry ( 'theme_bg' )."'>\r\r
			<!-- __________ start of modules __________ -->\r
			<div id='initial_div' style='position:relative; margin-left: auto; margin-right: auto; visibility: visible;
			width:".$ThemeDataObj->getThemeDataEntry('theme_divinitial_dx')."px; 
			height:".$ThemeDataObj->getThemeDataEntry('theme_divinitial_dy')."px;
			'>\r".
			$RenderDeco->render($infos).
			"<span style='font-size: 150%; font-weight:bold; text-align:center; margin-top:50px; display:block;'>".
			$WebSiteObj->getWebSiteEntry('ws_message')."</span><br>\r".
			$RenderLayoutObj->getLayoutModuleEntry($infos['module']['module_name'], 'module_deco_default_text')."<br>\r".
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