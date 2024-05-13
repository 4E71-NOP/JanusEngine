<?php
/*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common	
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/
//	Module : ModuleOffLineMessage
// --------------------------------------------------------------------------------------------

class ModuleOffLineMessage
{
	public function __construct()
	{
	}

	public function render($infos)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();
		$ClassLoaderObj->provisionClass('WebSite');
		$ClassLoaderObj->provisionClass('ThemeData');
		$ClassLoaderObj->provisionClass('GeneratedScript');
		$ClassLoaderObj->provisionClass('RenderDeco40Elegance');

		$localisation = " / ModuleOffLineMessage";
		$bts->MapperObj->AddAnotherLevel($localisation);
		$bts->LMObj->logCheckpoint("ModuleOffLineMessage");
		$bts->MapperObj->RemoveThisLevel($localisation);
		$bts->MapperObj->setSqlApplicant("ModuleOffLineMessage");

		$l = "eng";
		// --------------------------------------------------------------------------------------------
		$WebSiteObj = new WebSite();

		if ($infos['SQLFatalError'] == 1) {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " SQLFatalError=1 The website is offline."));
			$WebSiteObj->setWebSiteEntry('ws_name', "Doh!!!");
			$WebSiteObj->setWebSiteEntry('ws_title', "Doh!!!");
		}

		if ($infos['bannerOffline'] == 1) {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " bannerOffline=1 The website is offline."));
			$WebSiteObj->setWebSiteEntry('ws_message', "FR : Le site est hors ligne.<br><br>ENG: The website is offline.");
		}

		// --------------------------------------------------------------------------------------------
		// echo ("Path : " . getcwd() . " / " . get_include_path());
		include("stylesheets/css_admin_install.php");
		if (is_array($mt_)) {
			$mt_ = array_merge(
				$mt_,
				array(
					'module_internal_width' => 896,
					'module_width' => 896,
				)
			);

			$CurrentSetObj->setThemeDataObj(new ThemeData());
			$ThemeDataObj = $CurrentSetObj->ThemeDataObj;
			$ThemeDataObj->setThemeData($mt_); //Better to give an array than the object itself.
			$ThemeDataObj->setThemeName('mt_');
			$ThemeDataObj->setThemeDefinition($ThemeDefinitionInstall);

			$ClassLoaderObj->provisionClass('GeneratedJavaScript');
			$CurrentSetObj->setGeneratedScriptObj(new GeneratedScript());

			$ThemeDataObj->setThemeDataEntry('divinitial_dx', 512);
			$ThemeDataObj->setThemeDataEntry('divinitial_dy', 1024);
			$ThemeDataObj->setThemetDefinitionEntry("divinitial_dx", "def_number", 1024);
			$ThemeDataObj->setThemetDefinitionEntry("divinitial_dy", "def_number", 512);

			$Content = "<!-- __________ start of modules __________ -->\r
			width:" . $ThemeDataObj->getDefinitionValue('divinitial_dx') . "px;
			height:" . $ThemeDataObj->getDefinitionValue('divinitial_dy') . "px;" .
				"'>\r";

			$infos = array(
				"mode" => 1,
				"module_display_mode" => "normal",
				"module_z_index" => 2,
				"block" => "B01",
				"blockG" => "B01G",
				"blockT" => "B01T",
				"deco_type" => 40,
				"module" => array(
					"module_id" => 11,
					"module_deco" => 1,
					"module_deco_nbr" => 2,
					"module_deco_default_text" => 3,
					"module_name" => "OfflineMessage",
					"module_container_name" => "OfflineMessageContainer",
					"module_classname" => "",
					"module_title" => "",
					"module_file" => "",
					"module_desc" => "",
					// "module_group_allowed_to_see" => 31,
					// "module_group_allowed_to_use" => 31,
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

			$Content = "
				<!DOCTYPE html>
				<html>\r
				<head>\r
				<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>\r
				<title>" . $WebSiteObj->getWebSiteEntry('ws_title') . "</title>\r
				" . $stylesheet . "\r
				</head>\r
				<body id='HydrBody' text='" . $ThemeDataObj->getThemeBlockEntry('B01T', 'deco_txt_col')
				. "' link='" . $ThemeDataObj->getThemeBlockEntry('B01T', 'deco_txt_l_01_fg_col')
				. "' vlink='" . $ThemeDataObj->getThemeBlockEntry('B01T', 'deco_txt_l_01_fg_visite_col')
				. "' alink='" . $ThemeDataObj->getThemeBlockEntry('B01T', 'deco_txt_l_01_fg_active_col')
				. "' background='../media/theme/" . $ThemeDataObj->getDefinitionValue('directory') . "/" . $ThemeDataObj->getDefinitionValue('bg') . "'>\r\r
				<div style='
				width:80%; 
				height:256px;
				margin-left:auto;
				margin-right:auto;
				margin-top:128px;

				'>\r" .
				$RenderDeco->render($infos) .
				"<span style='font-size: 150%; font-weight:bold; text-align:center; margin-top:50px; display:block;'>
				This website is currently offline</span><br>\r" .
				"
				</div>\r
				</div>\r";

			$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-File', 'current/engine/javascript/lib_HydrCore.js');
			$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-File', 'current/engine/javascript/lib_DecorationManagement.js');
			$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-OnLoad', "\telm.Gebi('HydrBody').style.visibility = 'visible';");
			$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-Init', 'var dm = new DecorationManagement();');

			$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-OnLoad', "\tdm.UpdateAllDecoModule(TabInfoModule);");
			$CurrentSetObj->GeneratedScriptObj->insertString('JavaScript-OnResize', "\tdm.UpdateAllDecoModule(TabInfoModule);");
			$CurrentSetObj->GeneratedScriptObj->insertString("JavaScript-Data", "var TabInfoModule = new Array();\r");


			$JavaScriptContent = "<!-- JavaScript -->\r\r";
			$JavaScriptContent .= $CurrentSetObj->GeneratedScriptObj->renderScriptFileWithBaseURL("JavaScript-File", "<script type='text/javascript' src='", "'></script>\r");
			$JavaScriptContent .= $CurrentSetObj->GeneratedScriptObj->renderExternalRessourceScript("JavaScript-ExternalRessource", "<script type='text/javascript' src='", "'></script>\r");
			$JavaScriptContent .= "<script type='text/javascript'>\r";

			$JavaScriptContent .= "// ----------------------------------------\r//\r// Data segment\r//\r//\r";
			$JavaScriptContent .= $CurrentSetObj->GeneratedScriptObj->renderScriptCrudeMode("JavaScript-Data");
			$JavaScriptContent .= "// ----------------------------------------\r//\r// Data (Flexible) \r//\r//\r";
			$JavaScriptContent .= $CurrentSetObj->GeneratedScriptObj->renderJavaScriptObjects();
			$JavaScriptContent .= "// ----------------------------------------\r//\r// Init segment\r//\r//\r";
			$JavaScriptContent .= $CurrentSetObj->GeneratedScriptObj->renderScriptCrudeMode("JavaScript-Init");
			$JavaScriptContent .= "// ----------------------------------------\r//\r// Command segment\r//\r//\r";
			$JavaScriptContent .= $CurrentSetObj->GeneratedScriptObj->renderScriptCrudeMode("JavaScript-Command");
			$JavaScriptContent .= "// ----------------------------------------\r//\r// OnLoad segment\r//\r//\r";
			$JavaScriptContent .= "function WindowOnResize (){\r";
			$JavaScriptContent .= $CurrentSetObj->GeneratedScriptObj->renderScriptCrudeMode("JavaScript-OnResize");
			$JavaScriptContent .= "}\r";
			$JavaScriptContent .= "function WindowOnLoad () {\r";
			$JavaScriptContent .= $CurrentSetObj->GeneratedScriptObj->renderScriptCrudeMode("JavaScript-OnLoad");
			$JavaScriptContent .= "
			}\r
			window.onresize = WindowOnResize;\r
			window.onload = WindowOnLoad;\r
			</script>\r";

			$Content .= $JavaScriptContent . "</body>\r</html>\r";

			echo ($Content);
		} else {
			echo ("Catastrophic failure! Could not read css_admin_install.php. Sorry.");
		}
		exit();
	}
}
