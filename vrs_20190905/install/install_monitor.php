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
include ("define.php");

include ("engine/utility/ClassLoader.php");
$ClassLoaderObj = ClassLoader::getInstance();
$ClassLoaderObj->provisionClass('Time');
$ClassLoaderObj->provisionClass('LogManagement');
$ClassLoaderObj->provisionClass('Mapper');
$ClassLoaderObj->provisionClass('RequestData');


$TimeObj = Time::getInstance();

$LMObj = LogManagement::getInstance();
$LMObj->setDebugLogEcho(1);
$LMObj->setInternalLogTarget(logTarget);

$RequestDataObj = RequestData::getInstance();
$MapperObj = Mapper::getInstance();

$ClassLoaderObj->provisionClass('ConfigurationManagement');
$CMObj = ConfigurationManagement::getInstance();
$CMObj->InitBasicSettings();

$ClassLoaderObj->provisionClass('StringFormat');
$StringFormatObj = StringFormat::getInstance();


$ClassLoaderObj->provisionClass('SessionManagement');
session_name("HydrInstallMonitorSessionId");
session_start();
$SMObj = SessionManagement::getInstance($CMObj);
$LMObj->InternalLog( array( 'level' => loglevelStatement, 'msg' => "Install_monitor : \$_SESSION :" . $StringFormatObj->arrayToString($_SESSION)." *** \$SMObj->getSession() = ".$StringFormatObj->arrayToString($SMObj->getSession()). " *** EOL" ));

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

$ClassLoaderObj->provisionClass('StringFormat');
$StringFormatObj = StringFormat::getInstance();

// --------------------------------------------------------------------------------------------
//
//	Loading the configuration file associated with this website
//
$CMObj->LoadConfigFile();
$CMObj->setExecutionContext("installation");
$CMObj->PopulateLanguageList();

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
// form[database_type_choix]=mysql
// &form[database_dal_choix]=MYSQLI
// &form[host]=localhost
// &form[db_hosting_prefix]=
// &form[db_admin_user]=dbadmin
// &form[db_admin_password]=nimdabd
// &form[dbprefix]=HdrTst
// &form[prefix_des_tables]=HtTst_
// &l=eng
// &SessionID=1576417445

$form = $RequestDataObj->getRequestDataEntry('form');
$CurrentSetObj->setInstanceOfSqlTableListObj( SqlTableList::getInstance($form['dbprefix'],$form['tabprefix']) );

$CMObj->setConfigurationEntry('dal', $form['database_dal_choix']);
$CMObj->setConfigurationEntry('host', $form['host']);
$CMObj->setConfigurationEntry('db_user_login', $form['db_admin_user']);
$CMObj->setConfigurationEntry('db_user_password', $form['db_admin_password']);

$DALFacade = DalFacade::getInstance();
$DALFacade->createDALInstance();		// It connects too.

// --------------------------------------------------------------------------------------------

$SqlTableListObj = $CurrentSetObj->getInstanceOfSqlTableListObj();
$SDDMObj = DalFacade::getInstance()->getDALInstance();

$itd = array();											// ITD for Installation Table Data
$tmp = array();
$itd['end_date']['inst_nbr'] = 0;
$dbquery = $SDDMObj->query("SELECT * FROM ".$SqlTableListObj->getSQLTableName('installation'). ";");
if ( $SDDMObj->num_row_sql($dbquery) > 0 ) { 
	while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) {
		$tmp[$dbp['inst_name']]['inst_display']		= $dbp['inst_display'];
		$tmp[$dbp['inst_name']]['inst_name']		= $dbp['inst_name'];
		$tmp[$dbp['inst_name']]['inst_nbr']			= $dbp['inst_nbr'];
		$tmp[$dbp['inst_name']]['inst_txt']			= $dbp['inst_txt'];
	}
	if ( $RequestDataObj->getRequestDataEntry('SessionID') == $tmp['SessionID']['inst_nbr'] ) {
		$itd = $tmp; 
	}
}

// --------------------------------------------------------------------------------------------
include ("../stylesheets/css_admin_install.php");
$theme_tableau = "theme_princ_";
${$theme_tableau}['theme_module_largeur_interne'] = 512;
${$theme_tableau}['theme_module_largeur'] = 512;

$ClassLoaderObj->provisionClass('ThemeData');
$CurrentSetObj->setInstanceOfThemeDataObj(new ThemeData());
$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
$ThemeDataObj->setThemeData($theme_princ_);					//Better to give an array than the object itself.
$ThemeDataObj->setThemeName('theme_princ_');

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
$CurrentSetObj->setInstanceOfGeneratedJavaScriptObj(new GeneratedJavaScript());
$GeneratedJavaScriptObj = $CurrentSetObj->getInstanceOfGeneratedJavaScriptObj();

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
"<title>".$WebSiteObj->getWebSiteEntry('sw_title')."</title>\r
".$stylesheet."\r
</head>\r
<body id='MWMbody' text='".$ThemeDataObj->getThemeBlockEntry('B01T', 'deco_txt_col')."' link='".$ThemeDataObj->getThemeBlockEntry('B01T', 'deco_txt_l_01_fg_col')."' vlink='".$ThemeDataObj->getThemeBlockEntry('B01T', 'deco_txt_l_01_fg_visite_col')."' alink='".$ThemeDataObj->getThemeBlockEntry('B01T', 'deco_txt_l_01_fg_active_col')."' background='../graph/".${$theme_tableau}['theme_directory']."/".${$theme_tableau}['theme_bg']."'>\r\r
";

// --------------------------------------------------------------------------------------------

if ( strlen($RequestDataObj->getRequestDataEntry('l')) != 0){
	$langComp = array ("fra" ,"eng");
	unset ( $A );
	foreach ( $langComp as $A ) { if ( $A == $RequestDataObj->getRequestDataEntry('l')) { $langHit = 1; } }
}
if ( $langHit == 1 ) { $l = $RequestDataObj->getRequestDataEntry('l'); }
else { $l = "eng"; }

include ("install/i18n/install_monitor_".$l.".php");

// --------------------------------------------------------------------------------------------
$div_initial_bg = "";
if ( strlen($ThemeDataObj->getThemeDataEntry('theme_divinitial_bg') ) > 0 ) { $div_initial_bg = "background-image: url(../graph/".$ThemeDataObj->getThemeDataEntry('theme_directory')."/".$ThemeDataObj->getThemeDataEntry('theme_divinitial_bg')."); background-repeat: ".$ThemeDataObj->getThemeDataEntry('theme_divinitial_repeat').";" ;}
if ( $ThemeDataObj->getThemeDataEntry('theme_divinitial_dx') == 0 ) { $ThemeDataObj->setThemeDataEntry('theme_divinitial_dx', $ThemeDataObj->getThemeDataEntry('theme_module_largeur') + 16); }
if ( $ThemeDataObj->getThemeDataEntry('theme_divinitial_dy') == 0 ) { $ThemeDataObj->setThemeDataEntry('theme_divinitial_dy', $ThemeDataObj->getThemeDataEntry('theme_module_largeur') + 16); }


$DocContent .= "<!-- __________ start of modules __________ -->\r
<div id='initial_div' style='position:relative; margin-left: auto; margin-right: auto; visibility: hidden;
width:".$ThemeDataObj->getThemeDataEntry('theme_divinitial_dx')."px;
height:".$ThemeDataObj->getThemeDataEntry('theme_divinitial_dy')."px;" .
$div_initial_bg.
"'>\r";

$infos = array(
		"mode" => 1,
		"affiche_module_mode" => "normal",
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

$block = $ThemeDataObj->getThemeName().$infos['block'];

$RenderLayoutObj->setLayoutModuleEntry($infos['module']['module_name'], "px", 0 );
$RenderLayoutObj->setLayoutModuleEntry($infos['module']['module_name'], "py", 0 );
$RenderLayoutObj->setLayoutModuleEntry($infos['module']['module_name'], "dx", $ThemeDataObj->getThemeDataEntry("theme_module_largeur"));
$RenderLayoutObj->setLayoutModuleEntry($infos['module']['module_name'], "dy", 320 );

$RenderDeco = RenderDeco50Exquisite::getInstance();

$DocContent .= $RenderDeco->render($infos);
// $Content .= "<p class='".$block."_tb7' style='text-align: center;'>".$i18n['b01Invite']."</p>

// --------------------------------------------------------------------------------------------
$DocContent .= "<p class='".$block."_tb7' style='text-align: center;'>".$i18n['title']."</p>\r";

// --------------------------------------------------------------------------------------------
$CurrentTab = 1;
$lt = 1;

$T['tab_infos']['EnableTabs']		= 0;
$T['tab_infos']['NbrOfTabs']		= 1;
$T['tab_infos']['TabBehavior']		= 1;
$T['tab_infos']['RenderMode']		= 1;
$T['tab_infos']['HighLightType']	= 0; // 1:ligne, 2:cellule
$T['tab_infos']['Height']			= 380;
$T['tab_infos']['Width']			= $ThemeDataObj->getThemeDataEntry('theme_module_largeur_interne') -24;  
$T['tab_infos']['GroupName']		= "inst1";
$T['tab_infos']['CellName']			= "frame01";
$T['tab_infos']['DocumentName']		= "doc";


//	Choice matrix 
//	session				Finished?
// 0 Wut!?				not finished
// 1 SessionID ok		not finished
// 2 SessionID nok		finished
// 3 SessionID ok		finished

if ( $RequestDataObj->getRequestDataEntry('SessionID') == $itd['SessionID']['inst_nbr'] ) {
	$score = 0;
	if ( $RequestDataObj->getRequestDataEntry('SessionID') == $itd['SessionID']['inst_nbr'] ) { $score +=1; }
	if ( $itd['end_date']['inst_nbr'] > 0 ) { $score +=2; }
	
	switch ($score) {
		case 0: 	
		case 2: 
			$status = "?????";
			break;
		case 1: 
			$time = (time() - $itd['last_activity']['inst_nbr']);
			if ( $time > 60 ) { $status = "<span class='".$block."_erreur ".$block."_tb4'>" .$i18n['inactive'] . ": " . $time . "s.</span>"; }
			else { $status = $i18n['installState1']; }
			break;	
		case 3: $status = $i18n['installState2'];	break;
	}
	
	$T['AD'][$CurrentTab][$lt]['1']['cont'] = $i18n['status'];												$T['AD'][$CurrentTab][$lt]['1']['tc'] = 4;	$T['AD'][$CurrentTab][$lt]['1']['sc'] = 1;
	$T['AD'][$CurrentTab][$lt]['2']['cont'] = $status;														$T['AD'][$CurrentTab][$lt]['2']['tc'] = 4;	$T['AD'][$CurrentTab][$lt]['2']['sc'] = 1;
	$lt++;
	
	$T['AD'][$CurrentTab][$lt]['1']['cont'] = $i18n['SQL_query_count'];										$T['AD'][$CurrentTab][$lt]['1']['tc'] = 4;	$T['AD'][$CurrentTab][$lt]['1']['sc'] = 1;
	$T['AD'][$CurrentTab][$lt]['2']['cont'] = $itd['SQL_query_count']['inst_nbr'];							$T['AD'][$CurrentTab][$lt]['2']['tc'] = 4;	$T['AD'][$CurrentTab][$lt]['2']['sc'] = 1;
	$lt++;
	
	$T['AD'][$CurrentTab][$lt]['1']['cont'] = $i18n['command_count'];										$T['AD'][$CurrentTab][$lt]['1']['tc'] = 4;	$T['AD'][$CurrentTab][$lt]['1']['sc'] = 1;
	$T['AD'][$CurrentTab][$lt]['2']['cont'] = $itd['command_count']['inst_nbr'];							$T['AD'][$CurrentTab][$lt]['2']['tc'] = 4;	$T['AD'][$CurrentTab][$lt]['2']['sc'] = 1;
	$lt++;
	
	$T['AD'][$CurrentTab][$lt]['1']['cont'] = $i18n['start_date'];											$T['AD'][$CurrentTab][$lt]['1']['tc'] = 4;	$T['AD'][$CurrentTab][$lt]['1']['sc'] = 1;
	$T['AD'][$CurrentTab][$lt]['2']['cont'] = $TimeObj->timestampToDate($itd['start_date']['inst_nbr']);	$T['AD'][$CurrentTab][$lt]['2']['tc'] = 4;	$T['AD'][$CurrentTab][$lt]['2']['sc'] = 1;
	
	$isInactive = time() - $itd['last_activity']['inst_nbr'];
	if ( $isInactive > 10 ) {
		$lt++;
		$T['AD'][$CurrentTab][$lt]['1']['cont'] = $i18n['inactive'];										$T['AD'][$CurrentTab][$lt]['1']['tc'] = 4;	$T['AD'][$CurrentTab][$lt]['1']['sc'] = 1;
		$T['AD'][$CurrentTab][$lt]['2']['cont'] = $isInactive;												$T['AD'][$CurrentTab][$lt]['2']['tc'] = 4;	$T['AD'][$CurrentTab][$lt]['2']['sc'] = 1;
	}
	
	if ($itd['end_date']['inst_nbr'] != 0 ) {
		$lt++;
		$T['AD'][$CurrentTab][$lt]['1']['cont'] = $i18n['end_date'];										$T['AD'][$CurrentTab][$lt]['1']['tc'] = 4;	$T['AD'][$CurrentTab][$lt]['1']['sc'] = 1;
		$T['AD'][$CurrentTab][$lt]['2']['cont'] = $TimeObj->timestampToDate($itd['end_date']['inst_nbr']);	$T['AD'][$CurrentTab][$lt]['2']['tc'] = 4;	$T['AD'][$CurrentTab][$lt]['2']['sc'] = 1;
	}
	
	$T['ADC']['onglet'][$CurrentTab]['nbr_ligne'] = $lt;	$T['ADC']['onglet'][$CurrentTab]['nbr_cellule'] = 2;	$T['ADC']['onglet'][$CurrentTab]['legende'] = 1;
	
	$ClassLoaderObj->provisionClass('RenderTables');
	$RenderTablesObj = RenderTables::getInstance();
	$DocContent .= $RenderTablesObj->render($infos, $T)."</div>\r";
}

// --------------------------------------------------------------------------------------------
$DocContent .= "</div>\r";

// --------------------------------------------------------------------------------------------
// Javascript files
// --------------------------------------------------------------------------------------------
$GeneratedJavaScriptObj->insertJavaScript('File', 'engine/javascript/lib_HydrCore.js');
// $GeneratedJavaScriptObj->insertJavaScript('File', 'engine/javascript_statique.js');
$GeneratedJavaScriptObj->insertJavaScript('Onload', "\telm.Gebi( 'initial_div' ).style.visibility = 'visible';");
$GeneratedJavaScriptObj->insertJavaScript('Onload', "\telm.Gebi( 'MWMbody' ).style.visibility = 'visible';");

$JavaScriptContent .= $GeneratedJavaScriptObj->renderJavaScriptDecoratedMode("File", "<script type='text/javascript' src='", "'></script>\r");
$JavaScriptContent .= "<script type='text/javascript'>\r";
$JavaScriptContent .= "function WindowOnload () {\r";
$JavaScriptContent .= $GeneratedJavaScriptObj->renderJavaScriptCrudeMode("Onload");
$JavaScriptContent .= "
}\r
window.onload = WindowOnload;\r\r
</script>\r";

$DocContent .= $JavaScriptContent;


// --------------------------------------------------------------------------------------------
$DocContent .= "</body>\r</html>\r";
echo ($DocContent);
// echo ($StringFormatObj->print_r_html($ThemeDataObj->getThemeDataEntry('B02G')));

$SDDMObj->disconnect_sql();

session_write_close();

?>
