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
$application = 'monitor';
include ("current/define.php");

include ("current/engine/utility/ClassLoader.php");
$ClassLoaderObj = ClassLoader::getInstance();

$ClassLoaderObj->provisionClass('BaseToolSet');		// First of them all as it is used by others.
$bts = BaseToolSet::getInstance();
$bts->LMObj->setDebugLogEcho(1);
$bts->LMObj->setInternalLogTarget(LOG_TARGET);
$bts->CMObj->InitBasicSettings();

session_name("HydrInstallMonitorSessionId");
// session_start();
$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => "Install_monitor : **!!** Break **!!**"));
$bts->initSmObj();
$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "Install_monitor : \$_SESSION :" . $bts->StringFormatObj->arrayToString($_SESSION)." *** \$bts->SMObj->getSession() = ".$bts->StringFormatObj->arrayToString($bts->SMObj->getSession()). " *** EOL" ));

$ClassLoaderObj->provisionClass('WebSite');

// --------------------------------------------------------------------------------------------
error_reporting(E_ALL ^ E_NOTICE);
ini_set('log_errors', "On");
ini_set('error_log' , "/var/log/apache2/error.log");

// --------------------------------------------------------------------------------------------
//
//	CurrentSet
//
//

$ClassLoaderObj->provisionClass('ServerInfos');
$ClassLoaderObj->provisionClass('CurrentSet');

$CurrentSetObj = CurrentSet::getInstance();
$CurrentSetObj->setInstanceOfServerInfosObj(new ServerInfos() );
$CurrentSetObj->getInstanceOfServerInfosObj()->getInfosFromServer();

$CurrentSetObj->setInstanceOfWebSiteObj(new WebSite());
$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
$WebSiteObj->setInstallationInstance();
$CurrentSetObj->setInstanceOfWebSiteContextObj($WebSiteObj);

// --------------------------------------------------------------------------------------------
//
//	Loading the configuration file associated with this website
//
$bts->CMObj->LoadConfigFile();
$bts->CMObj->setExecutionContext("installation");
$bts->CMObj->PopulateLanguageList();

// --------------------------------------------------------------------------------------------
//
// SQL DB dialog Management.
//
//
$ClassLoaderObj->provisionClass('SddmTools');
$ClassLoaderObj->provisionClass('DalFacade');
$ClassLoaderObj->provisionClass('SqlTableList');

// URL example
// http://www.multiweb-manager.local/Hydr/current/install_monitor.php?
// form[selectedDataBaseType]=mysql
// &form[database_dal_choix]=MYSQLI
// &form[host]=localhost
// &form[dataBaseHostingPrefix]=
// &form[dataBaseAdminUser]=dbadmin
// &form[dataBaseAdminPassword]=nimdabd
// &form[dbprefix]=Hdr
// &form[prefix_des_tables]=HtTst_
// &l=eng
// &SessionID=1576417445

$form = $bts->RequestDataObj->getRequestDataEntry('form');
$CurrentSetObj->setInstanceOfSqlTableListObj( SqlTableList::getInstance($form['dbprefix'],$form['tabprefix']) );

$bts->CMObj->setConfigurationEntry('dal', $form['database_dal_choix']);
$bts->CMObj->setConfigurationEntry('host', $form['host']);
$bts->CMObj->setConfigurationEntry('db_user_login', $form['dataBaseAdminUser']);
$bts->CMObj->setConfigurationEntry('db_user_password', $form['dataBaseAdminPassword']);

$DALFacade = DalFacade::getInstance();
$DALFacade->createDALInstance();		// It connects too.

// --------------------------------------------------------------------------------------------

$SqlTableListObj = $CurrentSetObj->getInstanceOfSqlTableListObj();
$SDDMObj = DalFacade::getInstance()->getDALInstance();

$itd = array();											// ITD for Installation Table Data
$tmp = array();
$itd['end_date']['inst_nbr'] = 0;
$dbquery = $SDDMObj->query("SELECT * FROM ".$SqlTableListObj->getSQLTableName('installation'). ";");
if ( $dbquery != false && $SDDMObj->num_row_sql($dbquery) > 0 ) { 
	while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
		$tmp[$dbp['inst_name']]['inst_display']		= $dbp['inst_display'];
		$tmp[$dbp['inst_name']]['inst_name']		= $dbp['inst_name'];
		$tmp[$dbp['inst_name']]['inst_nbr']			= $dbp['inst_nbr'];
		$tmp[$dbp['inst_name']]['inst_txt']			= $dbp['inst_txt'];
	}
	if ( $bts->RequestDataObj->getRequestDataEntry('InstallToken') == $tmp['InstallToken']['inst_nbr'] ) {
		$itd = $tmp; 
	}
}

// --------------------------------------------------------------------------------------------
include ("stylesheets/css_admin_install.php");
$mt_ = array_merge(
		$mt_,
		array(
				'theme_module_internal_width'=> 512,
				'theme_module_width' => 512,)
		);

$ClassLoaderObj->provisionClass('ThemeData');
$CurrentSetObj->setInstanceOfThemeDataObj(new ThemeData());
$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
$ThemeDataObj->setThemeData($mt_);					//Better to give an array than the object itself.
$ThemeDataObj->setThemeName('mt_');

$ClassLoaderObj->provisionClass('ThemeDescriptor');
$CurrentSetObj->setInstanceOfThemeDescriptorObj(new ThemeDescriptor());
$ThemeDescriptorObj = $CurrentSetObj->getInstanceOfThemeDescriptorObj();

$ClassLoaderObj->provisionClass('User');
$CurrentSetObj->setInstanceOfUserObj(new User());
$UserObj = $CurrentSetObj->getInstanceOfUserObj();

$ClassLoaderObj->provisionClass('RenderLayout');
$RenderLayoutObj = RenderLayout::getInstance();

$ClassLoaderObj->provisionClass('RenderDeco40Elegance');
$ClassLoaderObj->provisionClass('RenderDeco50Exquisite');

// --------------------------------------------------------------------------------------------
//
//	JavaScript Object
//
//


$ClassLoaderObj->provisionClass('GeneratedJavaScript');
$CurrentSetObj->setInstanceOfGeneratedScriptObj(new GeneratedJavaScript());
$GeneratedScriptObj = $CurrentSetObj->getInstanceOfGeneratedScriptObj();

// --------------------------------------------------------------------------------------------
// refresh  = <meta http-equiv='refresh' content='5'>\r
$refresh = "";
if ( $itd['end_date']['inst_nbr'] == 0 ) { $refresh = "<meta http-equiv='refresh' content='5'>\r"; }

$module_['module_deco'] = 1;
$DocContent = "<!DOCTYPE html>
<html>\r
<head>\r
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>\r".
$refresh.
"<title>".$WebSiteObj->getWebSiteEntry('ws_title')."</title>\r
".$stylesheet."\r
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

if ( strlen($bts->RequestDataObj->getRequestDataEntry('l')) != 0){
	$langComp = array ("fra" ,"eng");
	unset ( $A );
	foreach ( $langComp as $A ) { if ( $A == $bts->RequestDataObj->getRequestDataEntry('l')) { $langHit = 1; } }
}
if ($langHit == 1) {
	$l = $bts->RequestDataObj->getRequestDataEntry ( 'l' );
	$CurrentSetObj->setDataEntry('language', $l);
} else {
	$l = "eng";
	$CurrentSetObj->setDataEntry('language', "eng");
}
// $i18n ="";
// include ("current/install/i18n/install_monitor_".$l.".php");
// $bts->I18nTransObj->apply($i18n);
// unset ($i18n);

$bts->I18nTransObj->apply(array( "type" => "file", "file" => "current/install/i18n/install_monitor_".$l.".php", "format" => "php" ) );

// --------------------------------------------------------------------------------------------
$div_initial_bg = "";
if ( strlen($ThemeDataObj->getThemeDataEntry('theme_divinitial_bg') ) > 0 ) { $div_initial_bg = "background-image: url(media/theme/".$ThemeDataObj->getThemeDataEntry('theme_directory')."/".$ThemeDataObj->getThemeDataEntry('theme_divinitial_bg')."); background-repeat: ".$ThemeDataObj->getThemeDataEntry('theme_divinitial_repeat').";" ;}
if ( $ThemeDataObj->getThemeDataEntry('theme_divinitial_dx') == 0 ) { $ThemeDataObj->setThemeDataEntry('theme_divinitial_dx', $ThemeDataObj->getThemeDataEntry('theme_module_width') + 16); }
if ( $ThemeDataObj->getThemeDataEntry('theme_divinitial_dy') == 0 ) { $ThemeDataObj->setThemeDataEntry('theme_divinitial_dy', $ThemeDataObj->getThemeDataEntry('theme_module_width') + 16); }


$DocContent .= "<!-- __________ start of modules __________ -->\r
<div id='initial_div' style='position:relative; margin-left: auto; margin-right: auto; visibility: hidden;
width:".$ThemeDataObj->getThemeDataEntry('theme_divinitial_dx')."px;
height:".$ThemeDataObj->getThemeDataEntry('theme_divinitial_dy')."px;" .
$div_initial_bg.
"'>\r";

$infos = array(
		"mode" => 1,
		"module_display_mode" => "normal",
		"module_z_index" => 2,
		"block" => "B02",
		"blockG" => "B02G",
		"blockT" => "B02T",
		"deco_type" => 50,
		"module" => Array (
			"module_id" => 11,
			"module_deco" => 1,
			"module_deco_nbr" => 2,
			"module_deco_default_text" => 3,
			"module_name" => "Admin_install_B2",
			"module_classname" => "",
			"module_title" => "",
			"module_file" => "",
			"module_desc" => "",
			"module_container_name" => "",
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

$Block = $ThemeDataObj->getThemeName().$infos['block'];

$RenderLayoutObj->setLayoutModuleEntry($infos['module']['module_name'], "px", 0 );
$RenderLayoutObj->setLayoutModuleEntry($infos['module']['module_name'], "py", 0 );
$RenderLayoutObj->setLayoutModuleEntry($infos['module']['module_name'], "dx", $ThemeDataObj->getThemeDataEntry("theme_module_width"));
$RenderLayoutObj->setLayoutModuleEntry($infos['module']['module_name'], "dy", 320 );

$RenderDeco = RenderDeco50Exquisite::getInstance();

$DocContent .= $RenderDeco->render($infos);
// $Content .= "<p class='".$Block."_tb7' style='text-align: center;'>".$bts->I18nTransObj->getI18nTransEntry('b01Invite']."</p>

// --------------------------------------------------------------------------------------------
$DocContent .= "<h1 style='text-align: center;'>".$bts->I18nTransObj->getI18nTransEntry('title')."</h1>\r";

// --------------------------------------------------------------------------------------------
$CurrentTab = 1;
$lt = 1;

$T['ContentInfos']['EnableTabs']	= 0;
$T['ContentInfos']['NbrOfTabs']		= 1;
$T['ContentInfos']['TabBehavior']	= 1;
$T['ContentInfos']['RenderMode']	= 1;
$T['ContentInfos']['HighLightType']	= 0; // 1:ligne, 2:cellule
$T['ContentInfos']['Height']		= 380;
$T['ContentInfos']['Width']			= $ThemeDataObj->getThemeDataEntry('theme_module_internal_width') -24;  
$T['ContentInfos']['GroupName']		= "inst1";
$T['ContentInfos']['CellName']		= "frame01";
$T['ContentInfos']['DocumentName']	= "doc";


//	Choice matrix 
//	session				Finished?
// 0 Wut!?				not finished
// 1 SessionID ok		not finished
// 2 SessionID nok		finished
// 3 SessionID ok		finished

if ( $bts->RequestDataObj->getRequestDataEntry('InstallToken') == $itd['InstallToken']['inst_nbr'] ) {
	$score = 0;
	if ( $bts->RequestDataObj->getRequestDataEntry('InstallToken') == $itd['InstallToken']['inst_nbr'] ) { $score +=1; }
	if ( $itd['end_date']['inst_nbr'] > 0 ) { $score +=2; }
	
	switch ($score) {
		case 0: 	
		case 2: 
			$status = "?????";
			break;
		case 1: 
			$time = (time() - $itd['last_activity']['inst_nbr']);
			if ( $time > 60 ) { $status = "<span class='".$Block."_error'>" .$bts->I18nTransObj->getI18nTransEntry('inactive') . ": " . $time . "s.</span>"; }
			else { $status = $bts->I18nTransObj->getI18nTransEntry('installState1'); }
			break;	
		case 3: $status = $bts->I18nTransObj->getI18nTransEntry('installState2');	break;
	}
	
	$T['Content'][$CurrentTab][$lt]['1']['cont'] = "<b>".$bts->I18nTransObj->getI18nTransEntry('status')."</b>";				
	$T['Content'][$CurrentTab][$lt]['2']['cont'] = "<b>".$status."</b>";												
	$lt++;
	
	$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('SQL_query_count');					
	$T['Content'][$CurrentTab][$lt]['2']['cont'] = $itd['SQL_query_count']['inst_nbr'];								
	$lt++;
	
	$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('command_count');						
	$T['Content'][$CurrentTab][$lt]['2']['cont'] = $itd['command_count']['inst_nbr'];								
	$lt++;
	
	$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('start_date');							
	$T['Content'][$CurrentTab][$lt]['2']['cont'] = $bts->TimeObj->timestampToDate($itd['start_date']['inst_nbr']);	
	
	$isInactive = time() - $itd['last_activity']['inst_nbr'];
	if ( $isInactive > 10 ) {
		$lt++;
		$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('inactive');		$T['Content'][$CurrentTab][$lt]['1']['class'] = $Block."_error";
		$T['Content'][$CurrentTab][$lt]['2']['cont'] = $isInactive." s";										$T['Content'][$CurrentTab][$lt]['2']['class'] = $Block."_error"; 
	}
	
	if ($itd['end_date']['inst_nbr'] != 0 ) {
		$lt++;
		$T['Content'][$CurrentTab][$lt]['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('end_date');						
		$T['Content'][$CurrentTab][$lt]['2']['cont'] = $bts->TimeObj->timestampToDate($itd['end_date']['inst_nbr']);	
	}
	
	$T['ContentCfg']['tabs'][$CurrentTab]['NbrOfLines'] = $lt;	$T['ContentCfg']['tabs'][$CurrentTab]['NbrOfCells'] = 2;	$T['ContentCfg']['tabs'][$CurrentTab]['TableCaptionPos'] = 1;
	
	$DocContent .= $bts->RenderTablesObj->render($infos, $T)."</div>\r";
}

// --------------------------------------------------------------------------------------------
$DocContent .= "</div>\r";

// --------------------------------------------------------------------------------------------
// Javascript files
// --------------------------------------------------------------------------------------------
$GeneratedScriptObj->insertString('JavaScript-File', 'current/engine/javascript/lib_HydrCore.js');
// $GeneratedScriptObj->insertString('JavaScript-File', 'engine/javascript_statique.js');
$GeneratedScriptObj->insertString('JavaScript-OnLoad', "\telm.Gebi( 'initial_div' ).style.visibility = 'visible';");
$GeneratedScriptObj->insertString('JavaScript-OnLoad', "\telm.Gebi( 'HydrBody' ).style.visibility = 'visible';");

$JavaScriptContent .= $GeneratedScriptObj->renderScriptFileWithBaseURL("File", "<script type='text/javascript' src='", "'></script>\r");
$JavaScriptContent .= "<script type='text/javascript'>\r";
$JavaScriptContent .= "function WindowOnLoad () {\r";
$JavaScriptContent .= $GeneratedScriptObj->renderScriptCrudeMode("OnLoad");
$JavaScriptContent .= "
}\r
window.OnLoad = WindowOnLoad;\r\r
</script>\r";

$DocContent .= $JavaScriptContent;


// --------------------------------------------------------------------------------------------
$DocContent .= "</body>\r</html>\r";
echo ($DocContent);
// echo ($bts->StringFormatObj->print_r_html($ThemeDataObj->getThemeDataEntry('B02G')));

$SDDMObj->disconnect_sql();

// session_write_close();

?>
