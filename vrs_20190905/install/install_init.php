<?php
/* Hydre-licence-debut */
// --------------------------------------------------------------------------------------------
//
// Hydre - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/* Hydre-licence-fin */
class HydrInstall
{
	private static $Instance = null;
	private function __construct()
	{
	}

	/**
	 * Singleton : Will return the instance of this class.
	 *
	 * @return HydrInstall
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new HydrInstall();
		}
		return self::$Instance;
	}

	/**
	 * Renders the whole thing.
	 * The choice of making a main class is to help IDEs to process sources.
	 *
	 * @return string
	 */
	public function render()
	{
		$application = 'install';
		include("current/define.php");

		include("current/engine/utility/ClassLoader.php");
		$ClassLoaderObj = ClassLoader::getInstance();

		$ClassLoaderObj->provisionClass('BaseToolSet'); // First of them all as it is used by others.
		$bts = BaseToolSet::getInstance();

		$bts->LMObj->setDebugLogEcho(1);
		$bts->LMObj->setVectorInternal(false);
		$bts->LMObj->setVectorSystemLog(true);
		$bts->CMObj->InitBasicSettings();
		
		// --------------------------------------------------------------------------------------------
		//
		// CurrentSet
		//
		//
		$ClassLoaderObj->provisionClass('ServerInfos');
		$ClassLoaderObj->provisionClass('CurrentSet');
		$ClassLoaderObj->provisionClass('WebSite');

		$CurrentSetObj = CurrentSet::getInstance();
		$CurrentSetObj->setServerInfosObj(new ServerInfos());
		$CurrentSetObj->ServerInfosObj->getInfosFromServer();
		
		$CurrentSetObj->setWebSiteObj(new WebSite());
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => "BP01-----------------------------------------"));
		$WebSiteObj = $CurrentSetObj->WebSiteObj;
		$WebSiteObj->setInstallationInstance();
		$CurrentSetObj->setWebSiteContextObj($WebSiteObj);

		// --------------------------------------------------------------------------------------------
		//
		// Session management
		//
		//
		$CurrentSetObj->setDataEntry('ws', 'HdrBase');

		$ClassLoaderObj->provisionClass('SessionManagement');
		$CurrentSetObj->setDataEntry('sessionName', 'HydrWebsiteSessionId');
		$bts->initSmObj();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => "*** index.php : \$_SESSION :" . $bts->StringFormatObj->arrayToString($_SESSION) . " *** \$SMObj->getSession() = " . $bts->StringFormatObj->arrayToString($bts->SMObj->getSession()) . " *** EOL"));
		
		$ClassLoaderObj->provisionClass('WebSite');
		
		// --------------------------------------------------------------------------------------------
		$bts->LMObj->setStoreStatisticsStateOn();
		
		$bts->mapSegmentLocation(__METHOD__, "inst");
		
		// --------------------------------------------------------------------------------------------
		// Install options
		// --------------------------------------------------------------------------------------------
		ini_set('log_errors', "On");
		ini_set('error_log', "/var/log/apache2/error.log");
		ini_set('display_errors', 0);
		error_log("********** Hydr installation Begin **********");
		
		// --------------------------------------------------------------------------------------------
		//
		// SQL DB dialog Management.
		//
		//

		$ClassLoaderObj->provisionClass('SddmTools');
		$ClassLoaderObj->provisionClass('DalFacade');
		$ClassLoaderObj->provisionClass('SqlTableList');

		$form = $bts->RequestDataObj->getRequestDataEntry('form');
		
		// We have a POST so we set RAM and execution time limit immediately.
		if (isset($form['memoryLimit'])) {
			ini_set('memoryLimit', $form['memoryLimit'] . "M");
			ini_set('max_execution_time', $form['execTimeLimit']);
		}

		// --------------------------------------------------------------------------------------------
		//
		// Loading the configuration file associated with this website
		//
		$bts->CMObj->LoadConfigFile();

		$CurrentSetObj->setSqlTableListObj(SqlTableList::getInstance());
		$CurrentSetObj->SqlTableListObj->makeSqlTableList($form['dbprefix'], $form['tabprefix']);

		$bts->CMObj->setExecutionContext("installation");
		$bts->CMObj->PopulateLanguageList();

		// --------------------------------------------------------------------------------------------
		// HTML header and Stylesheet
		// --------------------------------------------------------------------------------------------

		// --------------------------------------------------------------------------------------------
		include("stylesheets/css_admin_install.php");

		// --------------------------------------------------------------------------------------------
		//
		// JavaScript Object
		//
		//

		$bts->mapSegmentLocation(__METHOD__, "Prepare JavaScript Object");

		$ClassLoaderObj->provisionClass('GeneratedScript');
		// include ("engine/entity/others/GeneratedScript.php");
		$CurrentSetObj->setGeneratedScriptObj(new GeneratedScript());
		$GeneratedScriptObj = $CurrentSetObj->GeneratedScriptObj;

		$module_['module_deco'] = 1;

		// --------------------------------------------------------------------------------------------
		$ClassLoaderObj->provisionClass('ThemeData');
		$CurrentSetObj->setThemeDataObj(new ThemeData());
		$ThemeDataObj = $CurrentSetObj->ThemeDataObj;
		// $mt_ & $ThemeDefinitionInstall are arrays for ThemeData
		$ThemeDataObj->setThemeData($mt_); // Better to give an array than the object itself.
		$ThemeDataObj->setThemeDefinition($ThemeDefinitionInstall);
		$ThemeDataObj->setThemeName('mt_');

		$ClassLoaderObj->provisionClass('ThemeDescriptor');
		$CurrentSetObj->setThemeDescriptorObj(new ThemeDescriptor());
		$ThemeDescriptorObj = $CurrentSetObj->ThemeDescriptorObj;

		$ClassLoaderObj->provisionClass('User');
		$CurrentSetObj->setUserObj(new User());
		$UserObj = $CurrentSetObj->UserObj;
		$UserObj->setPermission('group_default_read_permission');


		$ClassLoaderObj->provisionClass('RenderDeco40Elegance');
		$ClassLoaderObj->provisionClass('RenderDeco50Exquisite');


		// --------------------------------------------------------------------------------------------
		// <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>\r
		$randomNumber = sprintf('%03d', random_int(1,2));
		$DocContent = "<!DOCTYPE html>
			<html>\r
			<head>\r
			<title>INSTALL</title>\r
			" . $stylesheet . "\r
			<link rel='icon' type='image/png' href='" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "media/img/favicon/favicon_".$randomNumber.".png' sizes='32x32'>\r
			</head>\r
			<body id='HydrBody' text='" . $ThemeDataObj->getThemeBlockEntry('B01T', 'txt_col') .
			"' link='" . $ThemeDataObj->getThemeBlockEntry('B01T', 'a_fg_col') .
			"' vlink='" . $ThemeDataObj->getThemeBlockEntry('B01T', 'a_fg_visite_col') .
			"' alink='" . $ThemeDataObj->getThemeBlockEntry('B01T', 'a_fg_active_col') .
			"' background='media/theme/" . $ThemeDataObj->getDefinitionValue('directory') .
			"/" . $ThemeDataObj->getDefinitionValue('bg')
			. "' style='height:100%;'>\r\r
			";

		// --------------------------------------------------------------------------------------------
		//
		//
		// Start of the block to be displayed.
		//
		//
		// --------------------------------------------------------------------------------------------
		$bts->mapSegmentLocation(__METHOD__, "Content");

		if (strlen($bts->RequestDataObj->getRequestDataEntry('l') ?? '') != 0) {
			$langComp = array(
				"fra",
				"eng"
			);
			unset($A);
			foreach ($langComp as $A) {
				if ($A == $bts->RequestDataObj->getRequestDataEntry('l')) {
					$langHit = 1;
				}
			}
		}
		if ($langHit == 1) {
			$l = $bts->RequestDataObj->getRequestDataEntry('l');
			$CurrentSetObj->setDataEntry('language', $l);
		} else {
			$l = "eng";
			$CurrentSetObj->setDataEntry('language', "eng");
		}

		// $bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "Loading `current/install/i18n/install_init_" . $l . ".php`"));
		$bts->I18nTransObj->apply(
			array(
				"type"		=> "file",
				"file"		=> "current/install/i18n/install_init_" . $l . ".php",
				"format"	=>	"php"
			)
		);

		$DocContent .= "<!-- __________ start of modules __________ -->\r";

		$ClassLoaderObj->provisionClass('ModuleList');
		$CurrentSetObj->setModuleListObj(new ModuleList());
		$ModuleLisObj = $CurrentSetObj->ModuleListObj;

		$ClassLoaderObj->provisionClass('LayoutProcessor');
		$LayoutProcessorObj = LayoutProcessor::getInstance();
		$ClassLoaderObj->provisionClass('RenderModule');
		$RenderModuleObj = RenderModule::getInstance();

		// Monitor or Install screens
		// if ( $bts->RequestDataObj->getRequestDataEntry ( 'PageInstall' ) != "monitor" ) {
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : This is an install page"));
		$ModuleLisObj->makeInstallModuleList();
		$ContentFragments = $LayoutProcessorObj->installRender('install.lyt.html');
		// }
		// else { 
		// 	$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : This is a monitor page") );
		// 	$ModuleLisObj->makeMonitorModuleList(); 
		// 	$ContentFragments = $LayoutProcessorObj->installRender('install_monitor.lyt.html');
		// }

		$LayoutCommands = array(
			0 => array("regex"	=> "/{{\s*get_header\s*\(\s*\)\s*}}/", "command"	=> 'get_header'),
			1 => array("regex"	=> "/{{\s*render_module\s*\(\s*('|\"|`)\w*('|\"|`)\s*\)\s*}}/", "command"	=> 'render_module'),
		);

		// We know there's only one command per entry
		$insertJavascriptDecorationMgmt = false;
		foreach ($ContentFragments as &$A) {
			foreach ($LayoutCommands as $B) {
				if ($A['type'] == "command" && preg_match($B['regex'], $A['data'], $match) === 1) {
					// We got the match so it's...
					switch ($B['command']) {
						case "get_header":
							break;
						case "render_module":
							// Module it is.
							if ($insertJavascriptDecorationMgmt === false) {
								$GeneratedScriptObj->insertString('JavaScript-OnLoad', "\tdm.UpdateAllDecoModule(TabInfoModule);");
								$GeneratedScriptObj->insertString('JavaScript-OnResize', "\tdm.UpdateAllDecoModule(TabInfoModule);");
								$GeneratedScriptObj->insertString("JavaScript-Data", "var TabInfoModule = new Array();\r");
								$insertJavascriptDecorationMgmt = true;
							}
							$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : `" . $A['type'] . "`; for `" . $A['module_name'] . "` and data " . $A['data']));
							$A['content'] = $RenderModuleObj->render($A['module_name']);
							break;
					}
				}
			}
		}

		foreach ($ContentFragments as &$A) {
			//	$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : ". $C['content']));
			$DocContent .= $A['content'];
		}


		$GeneratedScriptObj->AddObjectEntry('TooltipConfig', "'install' : { 'State':1, 'X':'320', 'Y':'256' }");

		// --------------------------------------------------------------------------------------------
		// Javascript files
		// --------------------------------------------------------------------------------------------
		unset($A);

		$GeneratedScriptObj->insertString('JavaScript-File', 'current/engine/javascript/lib_HydrCore.js');
		// $GeneratedScriptObj->insertString('JavaScript-File', 'current/install/install_routines/install_test_db.js' );
		// $GeneratedScriptObj->insertString('JavaScript-File', 'current/install/install_routines/install_fonctions.js' );
		$GeneratedScriptObj->insertString('JavaScript-File', 'current/engine/javascript/lib_DecorationManagement.js');
		$GeneratedScriptObj->insertString('JavaScript-File', 'current/engine/javascript/lib_ElementAnimation.js');

		$GeneratedScriptObj->insertString('JavaScript-Init', 'var dm = new DecorationManagement();');

		$GeneratedScriptObj->insertString('JavaScript-OnLoad', "\telm.Gebi( 'HydrBody' ).style.visibility = 'visible';");

		$GeneratedScriptObj->insertString('JavaScript-OnLoad', "console.log ( TabInfoModule );");

		$JavaScriptContent = "<!-- JavaScript -->\r\r";
		$JavaScriptContent .= $GeneratedScriptObj->renderScriptFileWithBaseURL("JavaScript-File", "<script type='text/javascript' src='", "'></script>\r");
		$JavaScriptContent .= "<script type='text/javascript'>\r";

		$JavaScriptContent .= "// ----------------------------------------\r//\r// Data segment\r//\r//\r";
		$JavaScriptContent .= $GeneratedScriptObj->renderScriptCrudeMode("JavaScript-Data");
		$JavaScriptContent .= "// ----------------------------------------\r//\r// Data (Flexible) \r//\r//\r";
		$JavaScriptContent .= $GeneratedScriptObj->renderJavaScriptObjects();
		$JavaScriptContent .= "// ----------------------------------------\r//\r// Command segment\r//\r//\r";
		$JavaScriptContent .= $GeneratedScriptObj->renderScriptCrudeMode("JavaScript-Command");
		$JavaScriptContent .= "// ----------------------------------------\r//\r// Init segment\r//\r//\r";
		$JavaScriptContent .= $GeneratedScriptObj->renderScriptCrudeMode("JavaScript-Init");
		$JavaScriptContent .= "// ----------------------------------------\r//\r// OnLoad segment\r//\r//\r";
		$JavaScriptContent .= "function WindowOnResize (){\r";
		$JavaScriptContent .= $GeneratedScriptObj->renderScriptCrudeMode("JavaScript-OnResize");
		$JavaScriptContent .= "\r}\r";
		$JavaScriptContent .= "function WindowOnLoad () {\r";
		$JavaScriptContent .= $GeneratedScriptObj->renderScriptCrudeMode("JavaScript-OnLoad");
		$JavaScriptContent .= "
		}\r
		window.onresize = WindowOnResize;\r
		window.onload = WindowOnLoad;\r\r
		</script>\r";

		$DocContent .= $JavaScriptContent;

		// --------------------------------------------------------------------------------------------
		$DocContent .= "</body>\r</html>\r";

		error_log("> memory_get_peak_usage (real)=" . floor((memory_get_peak_usage($real_usage = TRUE) / 1024)) . "Kb" . "; memory_get_usage (real)=" . floor((memory_get_usage($real_usage = TRUE) / 1024)) . "Kb");
		error_log("> memory_get_peak_usage=" . floor((memory_get_peak_usage() / 1024)) . "Kb" . "; memory_get_usage=" . floor((memory_get_usage() / 1024)) . "Kb");
		error_log("********** Hydr installation End **********");
		// 		session_write_close ();
		return ($DocContent);
	}
}
