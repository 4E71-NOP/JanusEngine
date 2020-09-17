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
include ("define.php");

// --------------------------------------------------------------------------------------------

include ("routines/website/utility/ClassLoader.php");
$ClassLoaderObj = ClassLoader::getInstance();

$ClassLoaderObj->provisionClass('Time');
$ClassLoaderObj->provisionClass('LogManagement');
$ClassLoaderObj->provisionClass('Mapper');
$ClassLoaderObj->provisionClass('RequestData');

// Time and memory measurment (with checkpoints)
$TimeObj = Time::getInstance();
$LMObj = LogManagement::getInstance();
$LMObj->setInternalLogTarget(logTarget);
$MapperObj = Mapper::getInstance();
$RequestDataObj = RequestData::getInstance();
// --------------------------------------------------------------------------------------------
$Content = "";
// --------------------------------------------------------------------------------------------

$LMObj->setStoreStatisticsStateOn();
// $_REQUEST['StatistiqueInsertion'] = 1;
// $statistiques_index = -1;
// $localisation = " / idx";
// $_REQUEST['localisation'] .= $localisation;
// statistique_checkpoint ("Index");

// $MapperObj->AddAnotherLevel(" / idx");
$LMObj->logCheckpoint( "Index" );

// --------------------------------------------------------------------------------------------
error_reporting(E_ALL ^ E_NOTICE);
ini_set('log_errors', "On");
ini_set('error_log' , "/var/log/apache2/error.log");

// --------------------------------------------------------------------------------------------
// MSIE must die!!! Still thinking about Edge
$Navigator = getenv("HTTP_USER_AGENT");

if ( strpos($Navigator, "MSIE" ) !== FALSE ) {
	if ( strpos($Navigator, "MSIE 5" )	!== FALSE )	{ $obsoleteBrowser = 1; }
	if ( strpos($Navigator, "MSIE 6" )	!== FALSE )	{ $obsoleteBrowser = 1; }
	if ( strpos($Navigator, "MSIE 7" )	!== FALSE )	{ $obsoleteBrowser = 1; }
	if ( strpos($Navigator, "MSIE 8" )	!== FALSE )	{ $obsoleteBrowser = 1; }
	if ( strpos($Navigator, "MSIE 9" )	!== FALSE )	{ $obsoleteBrowser = 1; }
	if ( strpos($Navigator, "MSIE 10" )	!== FALSE )	{ $obsoleteBrowser = 1; }
	if ( strpos($Navigator, "MSIE 11" )	!== FALSE )	{ $obsoleteBrowser = 1; }
}

if ( $obsoleteBrowser == 1 ) {
	include ( "routines/website/staticPages/UnsupportedBrowserBanner.php");
	exit();
}
unset ( $Navigator );

// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('StringFormat');
$StringFormatObj = StringFormat::getInstance();

// --------------------------------------------------------------------------------------------
//
//	CurrentSet
//
//
$ClassLoaderObj->provisionClass('ServerInfos');
$ClassLoaderObj->provisionClass('CurrentSet');
$CurrentSetObj = CurrentSet::getInstance();
$CurrentSetObj->setInstanceOfServerInfosObj(new ServerInfos());
$CurrentSetObj->getInstanceOfServerInfosObj()->getInfosFromServer();
$CurrentSetObj->setDataEntry('fsIdx', 0);								//Useful for FileSelector

// --------------------------------------------------------------------------------------------
//
//	Session management
//
//
$ClassLoaderObj->provisionClass('SessionManagement');
$ClassLoaderObj->provisionClass('ConfigurationManagement');
$CMObj = ConfigurationManagement::getInstance();
$CMObj->InitBasicSettings();

$CurrentSetObj->setDataEntry('sessionName', 'HydrWebsiteSessionId');
session_name($CurrentSetObj->getDataEntry('sessionName'));
session_start();
$SMObj = SessionManagement::getInstance($CMObj);
// $LMObj->InternalLog("*** index.php : \$_SESSION :" . $StringFormatObj->arrayToString($_SESSION)." *** \$SMObj->getSession() = ".$StringFormatObj->arrayToString($SMObj->getSession()). " *** EOL" );

// --------------------------------------------------------------------------------------------
//
//	Scoring on what we recieved (or what's at disposal)
//

$firstContactScore = 0;

if ( session_status() === PHP_SESSION_ACTIVE ) { $firstContactScore++; }
if ( strlen($RequestDataObj->getRequestDataEntry('ws')) != 0 ) { $firstContactScore += 2;}
if ( strlen($RequestDataObj->getRequestDataEntry('formSubmitted')) == 1 && $RequestDataObj->getRequestDataSubEntry('formGenericData', 'origin') == "ModuleAuthentification" ) {
	$firstContactScore += 4;
}
if ( strlen($RequestDataObj->getRequestDataSubEntry('formGenericData', 'action') == "disconnection")) { $firstContactScore += 8; }

$LMObj->InternalLog("index.php : \$firstContactScore='". $firstContactScore ."'");
$authentificationMode = "session";
$authentificationAction = userActionSingIn;
switch ( $firstContactScore ) {
	case 0:
		$SMObj->ResetSession();
		break;
	case 6:
	case 7:
		$authentificationMode = "form";
	case 2:
	case 3:
		$SMObj->ResetSession();
		$SMObj->setSessionEntry('ws', $RequestDataObj->getRequestDataEntry('ws'));
	break;
	
	case 8:
	case 9:
	case 10:
	case 11:
	case 12:
	case 13:
	case 14:
	case 15:
		$authentificationMode = "form";
		$authentificationAction = userActionDisconnect;
		break;
	case 1:
		$SMObj->CheckSession();
		break;
}

// --------------------------------------------------------------------------------------------
//
//	Loading the configuration file associated with this website
//
$localisation = " (Start)";
$MapperObj->AddAnotherLevel($localisation);
$LMObj->logCheckpoint("Start");
$MapperObj->RemoveThisLevel($localisation);
$MapperObj->setSqlApplicant("Loading website data");

// $fichier_config = "config/current/site_" . $_REQUEST['ws'] . "_config.php";
// include ($fichier_config);
// $SQL_tab = array();
// $SQL_tab_abrege = array();

// A this point we have a ws in the session so we don't use the URI parameter anymore.
$CMObj->LoadConfigFile();
$CMObj->setConfigurationEntry('execution_context',		"render");
$LMObj->setDebugLogEcho(0);


// --------------------------------------------------------------------------------------------
//
//	Creating the necessary arrays for Sql Db Dialog Management
//
$ClassLoaderObj->provisionClass('SqlTableList');
$CurrentSetObj->setInstanceOfSqlTableListObj( SqlTableList::getInstance( $CMObj->getConfigurationEntry('dbprefix'), $CMObj->getConfigurationEntry('tabprefix') ));
$SqlTableListObj = $CurrentSetObj->getInstanceOfSqlTableListObj();

// --------------------------------------------------------------------------------------------
//
// SQL DB dialog Management.
//
//
$ClassLoaderObj->provisionClass('SddmTools');
$ClassLoaderObj->provisionClass('DalFacade');

$DALFacade = DalFacade::getInstance();
$DALFacade->createDALInstance();		// It connects too.
$SDDMObj = DalFacade::getInstance()->getDALInstance();
if ( $SDDMObj->getReportEntry('cnxErr') == 1 ) { 
	include ("../modules/initial/OfflineMessage/OfflineMessage.php");
	$ModuleOffLineMessageObj = new ModuleOffLineMessage();
	$ModuleOffLineMessageObj->render(
		array(
			"SQLFatalError"		=>	1,
			"bannerOffline"		=>	0,
		)
	);
}

$CMObj->PopulateLanguageList();		// Not before we have access to the DB. Better isn't it?

// --------------------------------------------------------------------------------------------
//
//	WebSite initialization
//
//
$localisation = " (Initialization)";
$MapperObj->AddAnotherLevel($localisation);
$LMObj->logCheckpoint("WebSite initialization");
$MapperObj->RemoveThisLevel($localisation);
$MapperObj->setSqlApplicant("WebSite initialization");

// $theme_tableau = "theme_princ_";
$ClassLoaderObj->provisionClass('WebSite');
$CurrentSetObj->setInstanceOfWebSiteObj(new WebSite());
$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
$WebSiteObj->getWebSiteDataFromDB();

switch ( $WebSiteObj->getWebSiteEntry ('ws_state') ) {
case 0:			//	Offline
case 3:			//	Maintenance
case 99:		//	Verouillé
	$WebSiteObj->setWebSiteEntry('banner_offline', 1); include ("../modules/initial/OfflineMessage/OfflineMessage.php");
break;
}
$CMObj->setLangSupport();			// will set support=1 in the languagelist if website supports the language.  

// --------------------------------------------------------------------------------------------
//
//	Authentification
//
//
$localisation = " (Authentification)";
$MapperObj->AddAnotherLevel($localisation);
$LMObj->logCheckpoint("Authentification");
$MapperObj->RemoveThisLevel($localisation);
$MapperObj->setSqlApplicant("Authentification");

$ClassLoaderObj->provisionClass('AuthenticateUser');
$ClassLoaderObj->provisionClass('User');

$AUObj = AuthenticateUser::getInstance();
$CurrentSetObj->setInstanceOfUserObj(new User());
$UserObj = $CurrentSetObj->getInstanceOfUserObj();

// we have 2 variables used drive the authentification process.
switch ( $authentificationMode ){
	case "form":
		$LMObj->InternalLog("index.php : Authentification with form mode");
		switch ( $authentificationAction ) {
			case userActionDisconnect:
				$LMObj->InternalLog("index.php : disconnect submitted");
				$SMObj->ResetSession();
				$userName = anonymousUserName;
				break;
			case userActionSingIn:
				$LMObj->InternalLog("index.php : Connection attempt");
				$userName = $RequestDataObj->getRequestDataSubEntry('authentificationForm', 'user_login');
				break;
				
		}
		$SMObj->ResetSession();				// If a login comes from a form. The session object must be reset!
		$UserObj->getUserDataFromDB($userName, $WebSiteObj );
		$LMObj->InternalLog("index.php : user_login=" . $UserObj->getUserEntry('user_login'));
		$AUObj->checkUserCredential($UserObj, 'form');
		$LMObj->InternalLog("index.php : Connection attempt end");
		break;
	case "session":
		$LMObj->InternalLog("index.php : Authentification with session mode. user_login='" . $SMObj->getSessionEntry('user_login')."'");
		
		// Assuming a session is valid (whatever it's 'anonymous' or someone else).
		if ( strlen($SMObj->getSessionEntry('user_login')) == 0 ) {
			$LMObj->InternalLog("index.php : \$_SESSION strlen(user_login)=0");
			$SMObj->ResetSession();
		}
		$UserObj->getUserDataFromDB( $SMObj->getSessionEntry('user_login'), $WebSiteObj );
		if ( $UserObj->getUserEntry('error_login_not_found') != 1 ) {
			$LMObj->InternalLog("index.php : session mode : ".$StringFormatObj->arrayToString( $SMObj->getSession()));
			$AUObj->checkUserCredential($UserObj, 'session');
		}
		else {
			// No form then no user found it's defintely an anonymous user
			$SMObj->ResetSession();
			$UserObj->resetUser();
			$UserObj->getUserDataFromDB('anonymous', $WebSiteObj);
		}
		break;
}

$LMObj->InternalLog("index.php : \$SMObj->getSession() :" . $StringFormatObj->arrayToString($SMObj->getSession()));
$LMObj->InternalLog("index.php : \$_SESSION :" . $StringFormatObj->arrayToString($_SESSION));
if ( $AUObj->getDataEntry('error') === TRUE ) { $UserObj->getUserDataFromDB("anonymous", $WebSiteObj); }
// $LMObj->InternalLog("index.php : UserObj = " . $StringFormatObj->arrayToString($UserObj->getUser()));
$LMObj->InternalLog("index.php : checkUserCredential end");

// --------------------------------------------------------------------------------------------
//	
//	Language selection
//	
//	
$localisation = " (Language selection)";
$MapperObj->AddAnotherLevel($localisation);
$LMObj->logCheckpoint("Language selection");
$MapperObj->RemoveThisLevel($localisation);
$MapperObj->setSqlApplicant("Language selection");

$scoreLang = 0;

if ( strlen($RequestDataObj->getRequestDataEntry('l')) != 0 && $RequestDataObj->getRequestDataEntry('l') != 0 ) { $scoreLang += 4; }
if ( strlen($UserObj->getUserEntry('lang')) != 0 && $UserObj->getUserEntry('lang') != 0 ) { $scoreLang += 2; }
if ( strlen($WebSiteObj->getWebSiteEntry('ws_lang')) != 0 && $WebSiteObj->getWebSiteEntry('ws_lang') != 0 ) { $scoreLang += 1; }

// $LMObj->InternalLog("Language list: ". $StringFormatObj->arrayToString($CMObj->getLanguageList()));
$LMObj->InternalLog("Website : ws_lang='". $WebSiteObj->getWebSiteEntry('ws_lang')."'");

switch ($scoreLang) {
	case 0:
		$LMObj->InternalLog("Language selection : Error on Language");
		break;
	case 1:
		$tmp = $CMObj->getLanguageListSubEntry($WebSiteObj->getWebSiteEntry('ws_lang'),'langue_639_3');
		$LMObj->InternalLog("Language selection : Website priority (Case=".$scoreLang."; ".$WebSiteObj->getWebSiteEntry('ws_lang')."->".$tmp.")");
		$CurrentSetObj->setDataEntry('language', $tmp);
		$CurrentSetObj->setDataEntry('language_id', $CMObj->getLanguageListSubEntry($WebSiteObj->getWebSiteEntry('ws_lang'),'langue_id') );
		break;
	case 2:
	case 3:
		$tmp = $CMObj->getLanguageListSubEntry($UserObj->getUserEntry('lang'),'langue_639_3');
		$LMObj->InternalLog("Language selection : User priority (Case=".$scoreLang."; ".$UserObj->getUserEntry('lang')."->".$tmp.")");
		$CurrentSetObj->setDataEntry('language', $tmp);
		$CurrentSetObj->setDataEntry('language_id', $CMObj->getLanguageListSubEntry($UserObj->getUserEntry('lang'),'langue_id'));
		break;
	case 4:
	case 5:
	case 6:
	case 7:
		$tmp = strtolower($RequestDataObj->getRequestDataEntry('l'));
		$LMObj->InternalLog("Language selection : URL priority (Case=".$scoreLang."; ".$RequestDataObj->getRequestDataEntry('l') . "->" . $tmp . ")");
		$CurrentSetObj->setDataEntry('language', $tmp); // URl/form asked, the king must be served!
		$CurrentSetObj->setDataEntry('language_id', strtolower($RequestDataObj->getRequestDataEntry('l')));
		break;
}

$ClassLoaderObj->provisionClass('I18n');
$I18nObj = I18n::getInstance();
$I18nObj->getI18nFromDB();

$LMObj->restoreLastInternalLogTarget();
// --------------------------------------------------------------------------------------------
//
//	Form Management for commandLine interface
//
//

// Do we have a user submitting from the auth form ?
if ( $RequestDataObj->getRequestDataSubEntry('formGenericData','modification' ) == 'on' || $RequestDataObj->getRequestDataSubEntry('formGenericData','deletion' ) == 'on' ) {
	$localisation = " (CLI)";
	$MapperObj->AddAnotherLevel($localisation);
	$LMObj->logCheckpoint("CLI");
	$MapperObj->RemoveThisLevel($localisation);
	$MapperObj->setSqlApplicant("CLI");
	
	
	$ClassLoaderObj->provisionClass('FormToCommandLine');
	$FormToCommandLineObj = FormToCommandLine::getInstance();
	$FormToCommandLineObj->analysis();

	
	$LMObj->InternalLog("FormToCommandLineObj->getCommandLineNbr() =".$FormToCommandLineObj->getCommandLineNbr());
	
	if ( $FormToCommandLineObj->getCommandLineNbr() > 0 ) {
		$LMObj->InternalLog("index.php script is on the bench :");
		$ClassLoaderObj->provisionClass('CommandConsole');

		$CurrentSetObj->setInstanceOfWebSiteContextObj($WebSiteObj); // Set an initial website context.
		$CommandConsole = CommandConsole::getInstance();
		
		$CMObj->setConfigurationSubEntry('commandLineEngine', 'state', 'enabled');		// 20200205 - For now we only log the command line in the logs.
// 		$CMObj->setConfigurationSubEntry('commandLineEngine', 'state', 'disabled');		// 20200205 - For now we only log the command line in the logs.
		$Script = $FormToCommandLineObj->getCommandLineScript();
		switch ($CMObj->getConfigurationSubEntry('commandLineEngine', 'state')) {
			case "enabled":
				foreach ($Script as $A ) { $CommandConsole->executeCommand($A); }
				break;
			case "disabled":	
			default:
				foreach ($Script as $A ) { $LMObj->InternalLog($A); }
				break;
		}
	}
	
	switch ($RequestDataObj->getRequestDataSubEntry('formGenericData', 'origin').$RequestDataObj->getRequestDataSubEntry('formGenericData', 'section')) {
		case "ModuleQuickSkin":
			$UserObj->getUserDataFromDB( $UserObj->getUserEntry('user_login'), $WebSiteObj);	//We need to reload the user data in order to update the current user_pref_theme variable. 
			break;
		case "AdminDashboardWebsiteManagementP01":
			// refresh with updated data
			$id = $WebSiteObj->getWebSiteEntry('ws_id');
			$WebSiteObj->getWebSiteDataFromDB($id);
			break;
	}
}

// --------------------------------------------------------------------------------------------
//
//
//	Start of the module display
//	The so called route is based on the arti_ref transmitted 
//
$localisation = " (CurrentSet)";
$MapperObj->AddAnotherLevel($localisation);
$LMObj->logCheckpoint("Prepare CurrentSet");
$MapperObj->RemoveThisLevel($localisation);
$MapperObj->setSqlApplicant("Prepare CurrentSet");

// $_REQUEST['contexte_d_execution']	= "Rendu";

//	Special block HTML >> ne pas etre autre part<<
// $document_tableau = "DP_";

// --------------------------------------------------------------------------------------------
// If no article reference is given we take the first article of the current website. 
if ( strlen($RequestDataObj->getRequestDataEntry('arti_ref')) == 0 ) {
	$dbquery = $SDDMObj->query ( "
		SELECT cat.cate_id, cat.cate_nom, cat.arti_ref
		FROM " . $SqlTableListObj->getSQLTableName('categorie') . " cat, " . $SqlTableListObj->getSQLTableName('bouclage') . " bcl
		WHERE cat.site_id = '" . $WebSiteObj->getWebSiteEntry ('ws_id'). "'
		AND cat.cate_lang = '" . $WebSiteObj->getWebSiteEntry ('ws_lang'). "'
		AND cat.bouclage_id = bcl.bouclage_id
		AND bcl.bouclage_etat = '1'
		AND cat.cate_type IN ('0','1')
		AND cat.groupe_id " . $UserObj->getUserEntry('clause_in_groupe')."
		AND cat.cate_etat = '1'
		AND cate_doc_premier = '1'
		ORDER BY cat.cate_parent,cat.cate_position
		;");
	while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { 
		$CurrentSetObj->setDataSubEntry('article', 'arti_ref',$dbp['arti_ref']);
	}
	$CurrentSetObj->setDataSubEntry('article', 'arti_page',1);
}
else {
	$CurrentSetObj->setDataSubEntry('article', 'arti_ref',$RequestDataObj->getRequestDataEntry('arti_ref'));
	$CurrentSetObj->setDataSubEntry('article', 'arti_page',$RequestDataObj->getRequestDataEntry('arti_page'));
}

// --------------------------------------------------------------------------------------------


$CurrentSetObj->setDataSubEntry('block_HTML', 'post_hidden_ws',				"<input type='hidden'	name='ws'			value='".$WebSiteObj->getWebSiteEntry('ws_id')."'>\r");
$CurrentSetObj->setDataSubEntry('block_HTML', 'post_hidden_l',				"<input type='hidden'	name='l'			value='".$CurrentSetObj->getDataEntry('language')."'>\r");
$CurrentSetObj->setDataSubEntry('block_HTML', 'post_hidden_user_login',		"<input type='hidden'	name='user_login'	value='".$SMObj->getSessionEntry('user_login')."'>\r");
$CurrentSetObj->setDataSubEntry('block_HTML', 'post_hidden_user_pass',		"<input type='hidden'	name='user_pass'	value='".$SMObj->getSessionEntry('user_password')."'>\r");
$CurrentSetObj->setDataSubEntry('block_HTML', 'post_hidden_arti_ref',		"<input type='hidden'	name='arti_ref'		value='".$CurrentSetObj->getDataSubEntry('article','arti_ref')."'>\r");
$CurrentSetObj->setDataSubEntry('block_HTML', 'post_hidden_arti_page',		"<input type='hidden'	name='arti_page'	value='".$CurrentSetObj->getDataSubEntry('article','arti_page')."'>\r");

$urlUsrPass = "";
// if ( $SMObj->getSessionEntry('sessionMode') != 1 ) { $urlUsrPass = "&amp;user_login=".$SMObj->getSessionEntry('user_login')."&amp;user_pass=".$SMObj->getSessionEntry('user_password'); }
// $CurrentSetObj->setDataSubEntry('block_HTML', 'url_slup',		"&sw=".$WebSiteObj->getWebSiteEntry('ws_id')."&l=".$CurrentSetObj->getDataEntry('language').$urlUsrPass );																			// Site Lang User Pass
if ( $SMObj->getSessionEntry('sessionMode') != 1 ) { $urlUsrPass = "&amp;user_login=".$SMObj->getSessionEntry('user_login'); }
$CurrentSetObj->setDataSubEntry('block_HTML', 'url_slup',		"");																			// Site Lang User Pass
$CurrentSetObj->setDataSubEntry('block_HTML', 'url_sldup',		"&sw=".$WebSiteObj->getWebSiteEntry('ws_id')."&l=".$CurrentSetObj->getDataEntry('language')."&arti_ref=".$CurrentSetObj->getDataSubEntry('article','arti_ref')."&arti_page=".$CurrentSetObj->getDataSubEntry('article','arti_page').$urlUsrPass);		// Site Lang Article User Pass
$CurrentSetObj->setDataSubEntry('block_HTML', 'url_sdup',		"&sw=".$WebSiteObj->getWebSiteEntry('ws_id')."&arti_ref=".$CurrentSetObj->getDataSubEntry('article','arti_ref')."&arti_page=".$CurrentSetObj->getDataSubEntry('article','arti_page'). $urlUsrPass);							// Site Article User Pass


// $_REQUEST['FS_index'] = 0;
// $_REQUEST['FS_table'] = array();

// --------------------------------------------------------------------------------------------
//	
//	Prepare data for theme and layout
//	
//	
$localisation = " (Them&Layout)";
$MapperObj->AddAnotherLevel($localisation);
$LMObj->logCheckpoint("Prepare Theme & Layout");
$MapperObj->RemoveThisLevel($localisation);
$MapperObj->setSqlApplicant("Prepare Theme & Layout");

// Those are ENTITY (DAO) classes, they're not UTILITY classes.
$ClassLoaderObj->provisionClass('Deco10_Menu');
$ClassLoaderObj->provisionClass('Deco20_Caligraph');
$ClassLoaderObj->provisionClass('Deco30_1Div');
$ClassLoaderObj->provisionClass('Deco40_Elegance');
$ClassLoaderObj->provisionClass('Deco50_Exquisite');
$ClassLoaderObj->provisionClass('Deco60_Elysion');
$ClassLoaderObj->provisionClass('ThemeDescriptor');

$CurrentSetObj->setInstanceOfThemeDescriptorObj(new ThemeDescriptor());
$ThemeDescriptorObj = $CurrentSetObj->getInstanceOfThemeDescriptorObj();

$ThemeDescriptorObj->getThemeDescriptorDataFromDB("mt_", $UserObj, $WebSiteObj);

$ClassLoaderObj->provisionClass('ThemeData');
$CurrentSetObj->setInstanceOfThemeDataObj(new ThemeData());
$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj();
$ThemeDataObj->setThemeData($ThemeDescriptorObj->getThemeDescriptor()); //Better to give an array than the object itself.
$ThemeDataObj->setThemeName('mt_');
$ThemeDataObj->setDecorationListFromDB();
$ThemeDataObj->renderBlockData();

// --------------------------------------------------------------------------------------------
//
//	JavaScript Object
//
//
$localisation = " (JavaScript)";
$MapperObj->AddAnotherLevel($localisation);
$LMObj->logCheckpoint("Prepare JavaScript Object");
$MapperObj->RemoveThisLevel($localisation);
$MapperObj->setSqlApplicant("Prepare JavaScript Object");

$ClassLoaderObj->provisionClass('GeneratedJavaScript');
$CurrentSetObj->setInstanceOfGeneratedJavaScriptObj(new GeneratedJavaScript());
$GeneratedJavaScriptObj = $CurrentSetObj->getInstanceOfGeneratedJavaScriptObj();
$GeneratedJavaScriptObj->insertJavaScript('File', 'routines/website/javascript/lib_HydrCore.js');
// $GeneratedJavaScriptObj->insertJavaScript('File', 'routines/website/javascript_lib_calculs_decoration.js');
$GeneratedJavaScriptObj->insertJavaScript('Onload', "\telm.Gebi('HydrBody').style.visibility = 'visible';");


// --------------------------------------------------------------------------------------------
//
//	Affichage
//
//
$localisation = " / Modules";
$MapperObj->AddAnotherLevel($localisation);
$LMObj->logCheckpoint("Module Processing");
$MapperObj->RemoveThisLevel($localisation);
$MapperObj->setSqlApplicant("Module Processing");

$ClassLoaderObj->provisionClass('InteractiveElements');			// Responsible for rendering buttons
$ClassLoaderObj->provisionClass('RenderLayout');

$RenderLayoutObj = RenderLayout::getInstance();
$RenderLayoutObj->render($UserObj, $WebSiteObj, $ThemeDescriptorObj);

// --------------------------------------------------------------------------------------------
//	StyleSheet

$ClassLoaderObj->provisionClass('RenderStylesheet');
$RenderStylesheetObj = RenderStylesheet::getInstance();
$stylesheet = $RenderStylesheetObj->render("mt_", $ThemeDataObj );

$Content .= "<!DOCTYPE html>\r";
switch ( $WebSiteObj->getWebSiteEntry('sw_stylesheet') ) {
	case 1: // dynamique
		$Content .= "
			<head>\r
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>\r
			<title>".$WebSiteObj->getWebSiteEntry('sw_titre')."</title>\r
		";
		$Content .= $stylesheet."</head>\r" . $html_body ;
		unset (	$stylesheet );
		break;
	case 0: // statique
		$Content .= "
			<head>\r
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>\r
			<title>".$WebSiteObj->getWebSiteEntry('ws_title')."</title>\r
		";
		break;
}
$Content .= "<body id='HydrBody' ";
if ( strlen ($ThemeDataObj->getThemeBlockEntry('B01T','txt_col')) > 0 ) { $html_body .= "text='".$ThemeDataObj->getThemeBlockEntry('B01T','txt_col')."' link='".${$theme_tableau}['B01T']['txt_col']."' vlink='".${$theme_tableau}['B01T']['txt_col']."' alink='".$ThemeDataObj->getThemeBlockEntry('B01T','txt_col')."' "; }
$Content .= "style='";
if ( strlen ($ThemeDataObj->getThemeDataEntry('theme_bg')) > 0 ) { $Content .= "background-image: url(../graph/".$ThemeDataObj->getThemeDataEntry('theme_repertoire')."/".$ThemeDataObj->getThemeDataEntry('theme_bg')."); background-repeat: ".$ThemeDataObj->getThemeDataEntry('theme_bg_repeat')."; "; }
if ( strlen ($ThemeDataObj->getThemeDataEntry('theme_bg_color')) > 0 ) { $Content .= "background-color: #".$ThemeDataObj->getThemeDataEntry('theme_bg_color').";"; }
$Content .= " visibility: hidden;'>\r ";


// --------------------------------------------------------------------------------------------
//	Modules

$ClassLoaderObj->provisionClass('RenderModule');
$RenderModuleObj = RenderModule::getInstance();
$directives = array ( 
	'mode' => 1,
	'affiche_module_mode' => "normal",
	'module_z_index' => 0
);


$Content.= $RenderModuleObj->render($directives);

// $module_['compteur'] = 1;

// --------------------------------------------------------------------------------------------
// 
// statistique_checkpoint ("index_avant_stat");
// 
// 
$localisation = " (Stats)";
$MapperObj->AddAnotherLevel($localisation);
$LMObj->logCheckpoint("Stats");
$MapperObj->RemoveThisLevel($localisation);
$MapperObj->setSqlApplicant("Stats");

$LMObj->logCheckpoint("index_avant_stats");
$MapperObj->RemoveThisLevel( "/ idx" );


// $localisation = " / idx";
// $_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );
// $_REQUEST['StatistiqueInsertion'] = 0;
$LMObj->setStoreStatisticsStateOff();
// --------------------------------------------------------------------------------------------
$ClassLoaderObj->provisionClass('RenderAdmDashboard');
$RenderAdmDashboardObj = RenderAdmDashboard::getInstance();
$Content .= $RenderAdmDashboardObj->render();


// --------------------------------------------------------------------------------------------
//	Affichage des selecteurs de fichier si necessaire
// $module_z_index['compteur'] = 500;		//Contourne les Z-index venant de la présentation
// $pv['sdftotal'] = $_REQUEST['FS_index'];

$sdftotal = $CurrentSetObj->getDataEntry('fsIdx');
if ( $CurrentSetObj->getDataEntry('fsIdx') > 0 ) {
	
	$ClassLoaderObj->provisionClass('FileSelector');
	$FileSelectorObj = FileSelector::getInstance();
	$infos['block']		= $ThemeDataObj->getThemeName()."B01";
	$infos['blockG']	= $infos['block']."G";
	$infos['blockT']	= $infos['block']."T";
	$Content .= $FileSelectorObj->render($infos);
	
	$fs = $CurrentSetObj->getDataEntry('fs');
	$str = "var tableFileSelector = {\r";
	$i = 0;
	foreach ($fs as $A) {
		$str .= "'".$i."':{ 'idx':'".$i."',	'width':'".$A['width']."',	'height':'".$A['height']."',	'formName':'".$A['formName']."',	'formTargetId':'".$A['formTargetId']."',	'selectionMode':'".$A['selectionMode']."',	'lastPath':'".$A['path']."',	'restrictTo':'".$A['restrictTo']."',	'strRemove':'".addslashes($A['strRemove'])."',	'strAdd':'".$A['strAdd']."',	'displayType':'".$A['displayType']."'	},\r";
		$i++;
	}
	$str = substr($str, 0, -2) . "\r};\r";
	$GeneratedJavaScriptObj->insertJavaScript('Data' , $str);
}

// --------------------------------------------------------------------------------------------
//	
//	Rendering of the JavaScript
//	
//	
// --------------------------------------------------------------------------------------------

$GeneratedJavaScriptObj->insertJavaScript('Onload', "console.log ( TabInfoModule );");

$JavaScriptContent = "<!-- JavaScript -->\r\r";
$JavaScriptContent .= $GeneratedJavaScriptObj->renderJavaScriptDecoratedMode("File", "<script type='text/javascript' src='", "'></script>\r");
$JavaScriptContent .= "<script type='text/javascript'>\r";

$JavaScriptContent .= "// ----------------------------------------\r//\r// Data segment\r//\r//\r";
$JavaScriptContent .= $GeneratedJavaScriptObj->renderJavaScriptCrudeMode("Data");
$JavaScriptContent .= "// ----------------------------------------\r//\r// Init segment\r//\r//\r";
$JavaScriptContent .= $GeneratedJavaScriptObj->renderJavaScriptCrudeMode("Init");
$JavaScriptContent .= "// ----------------------------------------\r//\r// Command segment\r//\r//\r";
$JavaScriptContent .= $GeneratedJavaScriptObj->renderJavaScriptCrudeMode("Command");
$JavaScriptContent .= "// ----------------------------------------\r//\r// Onload segment\r//\r//\r";
$JavaScriptContent .= "function WindowOnload () {\r";
$JavaScriptContent .= $GeneratedJavaScriptObj->renderJavaScriptCrudeMode("Onload");
$JavaScriptContent .= "		
}\r
window.onload = WindowOnload;\r\r
</script>\r";


$licence = "
<!--
Author : FMA - 2005 ~ ".date("Y", time())."
Licence : Creative commons CC-by-nc-sa (http://www.creativecommons.org/)
-->
";

$LMObj->InternalLog("index.php : \$_SESSION :" . $StringFormatObj->arrayToString($_SESSION));

// --------------------------------------------------------------------------------------------
$SDDMObj->disconnect_sql();
session_write_close();

echo ( $Content . $JavaScriptContent . $licence . "</body>\r</html>\r");

?>
