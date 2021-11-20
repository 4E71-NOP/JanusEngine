<?php
/* Hydre-licence-debut */
// --------------------------------------------------------------------------------------------
//
// Hydre - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@club-internet.fr
//
// --------------------------------------------------------------------------------------------
/* Hydre-licence-fin */
class HydrInstall {
	private static $Instance = null;
	private function __construct() {
	}

	/**
	 * Singleton : Will return the instance of this class.
	 *
	 * @return HydrInstall
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new HydrInstall ();
		}
		return self::$Instance;
	}

	/**
	 * Renders the whole thing.
	 * The choice of making a main class is to help IDEs to process sources.
	 *
	 * @return string
	 */
	public function render() {
		$application = 'install';
		include ("current/define.php");
		
		include ("current/engine/utility/ClassLoader.php");
		$ClassLoaderObj = ClassLoader::getInstance ();
		
		$ClassLoaderObj->provisionClass ( 'BaseToolSet' ); // First of them all as it is used by others.
		$bts = BaseToolSet::getInstance();
		
		$bts->LMObj->setDebugLogEcho ( 1 );
		$bts->LMObj->setInternalLogTarget ( INSTALL_LOG_TARGET );
		$bts->CMObj->InitBasicSettings ();
		
		$ClassLoaderObj->provisionClass ( 'SessionManagement' );
		$bts->initSmObj ();
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => "*** index.php : \$_SESSION :" . $bts->StringFormatObj->arrayToString ( $_SESSION ) . " *** \$SMObj->getSession() = " . $bts->StringFormatObj->arrayToString ( $bts->SMObj->getSession () ) . " *** EOL") );
		
		$ClassLoaderObj->provisionClass ( 'WebSite' );
		
		// --------------------------------------------------------------------------------------------
		$bts->LMObj->setStoreStatisticsStateOn ();
		
		$localisation = " / inst";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "Install Init" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "Install Init" );
		
		// --------------------------------------------------------------------------------------------
		// Install options
		// --------------------------------------------------------------------------------------------
		
		ini_set ( 'log_errors', "On" );
		ini_set ( 'error_log', "/var/log/apache2/error.log" );
		ini_set ( 'display_errors', 0 );
		error_log ( "********** Hydr installation Begin **********" );
		
		// --------------------------------------------------------------------------------------------
		//
		// CurrentSet
		//
		//

		$ClassLoaderObj->provisionClass ( 'ServerInfos' );
		$ClassLoaderObj->provisionClass ( 'CurrentSet' );

		$CurrentSetObj = CurrentSet::getInstance ();
		$CurrentSetObj->setInstanceOfServerInfosObj ( new ServerInfos () );
		$CurrentSetObj->getInstanceOfServerInfosObj ()->getInfosFromServer ();

		$CurrentSetObj->setInstanceOfWebSiteObj ( new WebSite () );
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj ();
		$WebSiteObj->setInstallationInstance ();
		$CurrentSetObj->setInstanceOfWebSiteContextObj ( $WebSiteObj );

		// --------------------------------------------------------------------------------------------
		//
		// SQL DB dialog Management.
		//
		//

		$ClassLoaderObj->provisionClass ( 'SddmTools' );
		$ClassLoaderObj->provisionClass ( 'DalFacade' );
		$ClassLoaderObj->provisionClass ( 'SqlTableList' );

		$form = $bts->RequestDataObj->getRequestDataEntry ( 'form' );
		$CurrentSetObj->setInstanceOfSqlTableListObj ( SqlTableList::getInstance ( $form ['dbprefix'], $form ['tabprefix'] ) );

		// We have a POST so we set RAM and execution time limit immediately.
		if (isset ( $form ['memory_limit'] )) {
			ini_set ( 'memory_limit', $form ['memory_limit'] . "M" );
			ini_set ( 'max_execution_time', $form ['time_limit'] );
		}

		// --------------------------------------------------------------------------------------------
		//
		// Loading the configuration file associated with this website
		//
		$bts->CMObj->LoadConfigFile ();
		$bts->CMObj->setExecutionContext ( "installation" );
		$bts->CMObj->PopulateLanguageList ();

		// --------------------------------------------------------------------------------------------
		// HTML header and Stylesheet
		// --------------------------------------------------------------------------------------------

		// --------------------------------------------------------------------------------------------
		include ("stylesheets/css_admin_install.php");
		$mt_ = array_merge(
				$mt_,
				array(
						'theme_module_internal_width'=> 896,
						'theme_module_width' => 896,)
				);
		
		// ******************************************************************************
		// 2021 layout process
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>") );
		$ClassLoaderObj->provisionClass ('ModuleList');
		$CurrentSetObj->setInstanceOfModuleLisObj(new ModuleList());
		$ModuleLisObj = $CurrentSetObj->getInstanceOfModuleLisObj();
		$ModuleLisObj->makeInstallModuleList();

		$ClassLoaderObj->provisionClass ('LayoutProcessor');
		$LayoutProcessorObj = LayoutProcessor::getInstance();
		$ClassLoaderObj->provisionClass ( 'RenderModule2' );
		$RenderModule2Obj = RenderModule2::getInstance ();

		$ContentFragments = $LayoutProcessorObj->render(); // attendre la sélection automatique du layout par le document

		$LayoutCommands = array(
			0 => array( "regex"	=> "/{{\s*get_header\s*\(\s*\)\s*}}/", "command"	=> 'get_header'),
			1 => array( "regex"	=> "/{{\s*render_module\s*\(\s*('|\"|`)\w*('|\"|`)\s*\)\s*}}/", "command"	=> 'render_module'),
		);
		
		// We know there's only one command per entry
		foreach ( $ContentFragments as &$A ) {
			foreach ( $LayoutCommands as $B) {
				if ( $A['type'] == "command" && preg_match($B['regex'],$A['data'],$match) === 1 ) {
					// We got the match so it's...
					switch ($B['command']) {
						case "get_header":
							break;
						case "render_module":
							// Module it is.
							$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : `". $A['type'] ."`; for `". $A['module_name'] ."` and data ". $A['data'] ) );
							$A['content'] = $RenderModule2Obj->render($A['module_name']);
							break;
					}
				}
			}
		}
		$CurrentSetObj->getInstanceOfGeneratedJavaScriptObj()->insertJavaScript("Data", "var TabInfoModule = new Array();\r");
		$CurrentSetObj->getInstanceOfGeneratedJavaScriptObj()->insertJavaScript("Onload", "\telm.Gebi( 'initial_div' ).style.visibility = 'visible';");

		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>") );
		
		// 2021 layout process
		// ******************************************************************************


		$ClassLoaderObj->provisionClass ( 'ThemeData' );
		$CurrentSetObj->setInstanceOfThemeDataObj ( new ThemeData () );
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj ();
		$ThemeDataObj->setThemeData ( $mt_ ); // Better to give an array than the object itself.
		$ThemeDataObj->setThemeName ( 'mt_' );

		$ClassLoaderObj->provisionClass ( 'ThemeDescriptor' );
		$CurrentSetObj->setInstanceOfThemeDescriptorObj ( new ThemeDescriptor () );
		$ThemeDescriptorObj = $CurrentSetObj->getInstanceOfThemeDescriptorObj ();

		$ClassLoaderObj->provisionClass ( 'User' );
		$CurrentSetObj->setInstanceOfUserObj ( new User () );
		$UserObj = $CurrentSetObj->getInstanceOfUserObj ();

		// $ClassLoaderObj->provisionClass ( 'RenderLayout' );
		// $RenderLayoutObj = RenderLayout::getInstance ();

		$ClassLoaderObj->provisionClass ( 'RenderDeco40Elegance' );
		$ClassLoaderObj->provisionClass ( 'RenderDeco50Exquisite' );

		// --------------------------------------------------------------------------------------------
		//
		// JavaScript Object
		//
		//
		$localisation = "Prepare JavaScript Object";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "Prepare JavaScript Object" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "Prepare JavaScript Object" );

		$ClassLoaderObj->provisionClass ( 'GeneratedJavaScript' );
		// include ("engine/entity/others/GeneratedJavaScript.php");
		$CurrentSetObj->setInstanceOfGeneratedJavaScriptObj ( new GeneratedJavaScript () );
		$GeneratedJavaScriptObj = $CurrentSetObj->getInstanceOfGeneratedJavaScriptObj ();

		$module_ ['module_deco'] = 1;

		// --------------------------------------------------------------------------------------------
		// <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>\r

		$DocContent = "<!DOCTYPE html>
			<html>\r
			<head>\r
			<title>INSTALL</title>\r
			" . $stylesheet . "\r
			</head>\r
			<body id='HydrBody' text='" . $ThemeDataObj->getThemeBlockEntry ( 'B01T', 'txt_col' ) . 
			"' link='" . $ThemeDataObj->getThemeBlockEntry ( 'B01T', 'a_fg_col' ) . 
			"' vlink='" . $ThemeDataObj->getThemeBlockEntry ( 'B01T', 'a_fg_visite_col' ) . 
			"' alink='" . $ThemeDataObj->getThemeBlockEntry ( 'B01T', 'a_fg_active_col' ) . 
			"' background='media/theme/" . $ThemeDataObj->getThemeDataEntry('theme_directory') . 
			"/" . $ThemeDataObj->getThemeDataEntry('theme_bg') 
			. "'>\r\r
			";

		// --------------------------------------------------------------------------------------------
		//
		//
		// Start of the block to be displayed.
		//
		//
		// --------------------------------------------------------------------------------------------
		$localisation = "Content";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "Content" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "Content" );

		if (strlen ( $bts->RequestDataObj->getRequestDataEntry ( 'l' ) ) != 0) {
			$langComp = array (
					"fra",
					"eng"
			);
			unset ( $A );
			foreach ( $langComp as $A ) {
				if ($A == $bts->RequestDataObj->getRequestDataEntry ( 'l' )) {
					$langHit = 1;
				}
			}
		}
		if ($langHit == 1) {
			$l = $bts->RequestDataObj->getRequestDataEntry ( 'l' );
			$CurrentSetObj->setDataEntry('language', $l);
		} else {
			$l = "eng";
			$CurrentSetObj->setDataEntry('language', "eng");
		}

		// $bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "Loading `current/install/i18n/install_init_" . $l . ".php`"));
		$bts->I18nTransObj->apply (
			array(
				"type"		=> "file", 
				"file"		=> "current/install/i18n/install_init_" . $l . ".php",
				"format"	=>	"php"
			 ));
		// --------------------------------------------------------------------------------------------
		if (strlen ( $ThemeDataObj->getThemeDataEntry ( 'theme_divinitial_bg' ) ) > 0) {
			$div_initial_bg = "background-image: url(media/theme/" . $ThemeDataObj->getThemeDataEntry ( 'theme_directory' ) . "/" . $ThemeDataObj->getThemeDataEntry ( 'theme_divinitial_bg' ) . "); background-repeat: " . $ThemeDataObj->getThemeDataEntry ( 'theme_divinitial_repeat' ) . ";";
		}
		if ($ThemeDataObj->getThemeDataEntry ( 'theme_divinitial_dx' ) == 0) {
			$ThemeDataObj->setThemeDataEntry ( 'theme_divinitial_dx', $ThemeDataObj->getThemeDataEntry ( 'theme_module_width' ) + 16 );
		}
		if ($ThemeDataObj->getThemeDataEntry ( 'theme_divinitial_dy' ) == 0) {
			$ThemeDataObj->setThemeDataEntry ( 'theme_divinitial_dy', $ThemeDataObj->getThemeDataEntry ( 'theme_module_width' ) + 16 );
		}

		$DocContent .= "<!-- __________ start of modules __________ -->\r
			<div id='initial_div' style='position:relative; margin-left: auto; margin-right: auto; visibility: hidden;
			width:" . $ThemeDataObj->getThemeDataEntry ( 'theme_divinitial_dx' ) . "px;
			height:" . $ThemeDataObj->getThemeDataEntry ( 'theme_divinitial_dy' ) . "px;" . $div_initial_bg . "'>\r";

		$infos = array (
				"mode" => 1,
				"module_display_mode" => "normal",
				"module_z_index" => 2,
				"block" => "B02",
				"blockG" => "B02G",
				"blockT" => "B02T",
				"deco_type" => 50,
				"fontSizeMin" => 10,
				"fontCoef" => 1.3,
				"module" => Array (
						"module_id" => 11,
						"module_deco" => 1,
						"module_deco_nbr" => 2,
						"module_deco_default_text" => 3,
						"module_name" => "Admin_install_B1",
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
						"module_position" => 2
				)
		);

		$Block = $ThemeDataObj->getThemeName () . $infos ['block'];

		$RenderLayoutObj->setLayoutModuleEntry ( $infos ['module'] ['module_name'], "px", 0 );
		$RenderLayoutObj->setLayoutModuleEntry ( $infos ['module'] ['module_name'], "py", 0 );
		$RenderLayoutObj->setLayoutModuleEntry ( $infos ['module'] ['module_name'], "dx", $ThemeDataObj->getThemeDataEntry ( "theme_module_width" ) );
		$RenderLayoutObj->setLayoutModuleEntry ( $infos ['module'] ['module_name'], "dy", 112 );

		$RenderDeco = RenderDeco50Exquisite::getInstance ();
		$DocContent .= $RenderDeco->render ( $infos );
		$DocContent .= "<h1 style='text-align: center;'>" . $bts->I18nTransObj->getI18nTransEntry ( 'b01Invite' ) . "</h1></div>\r";

		// --------------------------------------------------------------------------------------------

		$infos ['module'] ['module_name'] = "Admin_install_B2";
		$infos ['block'] = "B01";
		$infos ['blockG'] = "B01G";
		$infos ['blockT'] = "B01T";
		$infos ['deco_type'] = 40;

		$RenderLayoutObj->setLayoutModuleEntry ( $infos ['module'] ['module_name'], "px", 0 );
		$RenderLayoutObj->setLayoutModuleEntry ( $infos ['module'] ['module_name'], "py", 120 );
		$RenderLayoutObj->setLayoutModuleEntry ( $infos ['module'] ['module_name'], "dx", $ThemeDataObj->getThemeDataEntry ( "theme_module_width" ) );
		$RenderLayoutObj->setLayoutModuleEntry ( $infos ['module'] ['module_name'], "dy", 816 + 64 );

		$RenderDeco = RenderDeco40Elegance::getInstance ();
		$DocContent .= $RenderDeco->render ($infos);

		// --------------------------------------------------------------------------------------------
		//
		// Pages - Diplaying informations
		//
		// --------------------------------------------------------------------------------------------
		$localisation = "Page";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "Page" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "Page" );

		$T = array ();

		if ($bts->RequestDataObj->getRequestDataEntry ( 'PageInstall' ) == null) {
			$bts->RequestDataObj->setRequestData ( 'PageInstall', 1 );
		}

		switch ($bts->RequestDataObj->getRequestDataEntry ( 'PageInstall' )) {
			case "1" :
				include ("current/install/install_page_01.php");
				break;
			case "2" :
				include ("current/install/install_page_02.php");
				break;
		}
		$DocContent .= "</div>\r</div>\r";

		// --------------------------------------------------------------------------------------------
		// Tooltip
		// --------------------------------------------------------------------------------------------
		$infos ['module'] ['module_container_name'] = "tooltipContainer";
		$infos ['module'] ['module_name'] = "tooltip";
		$infos ['module'] ['module_deco_nbr'] = 20;
		$infos ['module_z_index'] = 99;
		$infos ['block'] = "B20";
		$infos ['blockG'] = "B20G";
		$infos ['blockT'] = "B20T";
		$infos ['deco_type'] = 40;

		$RenderLayoutObj->setLayoutModuleEntry ( $infos ['module'] ['module_name'], "px", 8 );
		$RenderLayoutObj->setLayoutModuleEntry ( $infos ['module'] ['module_name'], "py", 4 );
		$RenderLayoutObj->setLayoutModuleEntry ( $infos ['module'] ['module_name'], "dx", 320 );
		$RenderLayoutObj->setLayoutModuleEntry ( $infos ['module'] ['module_name'], "dy", 192 );

		$RenderDeco = RenderDeco40Elegance::getInstance ();
		$DocContent .= $RenderDeco->render ( $infos ) . "</div>\r</div>\r";

		require_once "modules/initial/Tooltip/module_tooltip.php";
		$tooltip = new ModuleTooltip();
		$tooltip->render($infos);
		$GeneratedJavaScriptObj->insertJavaScript ( "Data", "var TabInfoModule = new Array();\r");

		// --------------------------------------------------------------------------------------------
		// Javascript files
		// --------------------------------------------------------------------------------------------
		unset ( $A );

		$GeneratedJavaScriptObj->insertJavaScript ( 'File', 'current/engine/javascript/lib_HydrCore.js' );
		$GeneratedJavaScriptObj->insertJavaScript ( 'File', 'current/install/install_routines/install_test_db.js' );
		$GeneratedJavaScriptObj->insertJavaScript ( 'File', 'current/install/install_routines/install_fonctions.js' );
		$GeneratedJavaScriptObj->insertJavaScript ( 'File', 'current/engine/javascript/lib_ElementAnimation.js' );

		$GeneratedJavaScriptObj->insertJavaScript ( 'Onload', "\telm.Gebi( 'initial_div' ).style.visibility = 'visible';" );
		$GeneratedJavaScriptObj->insertJavaScript ( 'Onload', "\telm.Gebi( 'HydrBody' ).style.visibility = 'visible';" );

		$GeneratedJavaScriptObj->insertJavaScript ( 'Onload', "console.log ( TabInfoModule );" );

		$JavaScriptContent = "<!-- JavaScript -->\r\r";
		$JavaScriptContent .= $GeneratedJavaScriptObj->renderJavaScriptFile( "File", "<script type='text/javascript' src='", "'></script>\r" );
		$JavaScriptContent .= "<script type='text/javascript'>\r";

		$JavaScriptContent .= "// ----------------------------------------\r//\r// Data segment\r//\r//\r";
		$JavaScriptContent .= $GeneratedJavaScriptObj->renderJavaScriptCrudeMode ( "Data" );
		$JavaScriptContent .= "// ----------------------------------------\r//\r// Data (Flexible) \r//\r//\r";
		$JavaScriptContent .= $GeneratedJavaScriptObj->renderJavaScriptObjects();
		$JavaScriptContent .= "// ----------------------------------------\r//\r// Command segment\r//\r//\r";
		$JavaScriptContent .= $GeneratedJavaScriptObj->renderJavaScriptCrudeMode ( "Command" );
		$JavaScriptContent .= "// ----------------------------------------\r//\r// Init segment\r//\r//\r";
		$JavaScriptContent .= $GeneratedJavaScriptObj->renderJavaScriptCrudeMode ( "Init" );
		$JavaScriptContent .= "// ----------------------------------------\r//\r// Onload segment\r//\r//\r";
		$JavaScriptContent .= "function WindowOnload () {\r";
		$JavaScriptContent .= $GeneratedJavaScriptObj->renderJavaScriptCrudeMode ( "Onload" );
		$JavaScriptContent .= "
		}\r
		window.onload = WindowOnload;\r\r
		</script>\r";

		$DocContent .= $JavaScriptContent;

		// --------------------------------------------------------------------------------------------
		$DocContent .= "</body>\r</html>\r";

		error_log ( "> memory_get_peak_usage (real)=" . floor ( (memory_get_peak_usage ( $real_usage = TRUE ) / 1024) ) . "Kb" . "; memory_get_usage (real)=" . floor ( (memory_get_usage ( $real_usage = TRUE ) / 1024) ) . "Kb" );
		error_log ( "> memory_get_peak_usage=" . floor ( (memory_get_peak_usage () / 1024) ) . "Kb" . "; memory_get_usage=" . floor ( (memory_get_usage () / 1024) ) . "Kb" );
		error_log ( "********** Hydr installation End **********" );
// 		session_write_close ();
		return ($DocContent);
	}
}
?>
