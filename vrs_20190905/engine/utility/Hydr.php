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
/*Hydre-IDE-begin*/
// Some definitions in order to ease the IDE work and to provide information about what is already available in this context.
/* @var $CurrentSetObj CurrentSet                   */
/* @var $Block String                               */
/* @var $infos Array                                */
/* @var $l String                                   */
/*Hydre-IDE-end*/

class Hydr {
	private static $Instance = null;
	private function __construct() {
	}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return Hydr
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new Hydr ();
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
		$application = 'website';
		include ("current/define.php");
		
		// --------------------------------------------------------------------------------------------
		
		/*
		 * Good practice for the main script when it's ready to think about saving memory... more.
		 * $varsStart = array_keys(get_defined_vars());
		 * [...]
		 * $varsEnd = array_keys(get_defined_vars());
		 * $varsSum = array_diff ($varsEnd, $varsStart);
		 * foreach ( $varsSum as $B => $C ) { if ( $C != 'infos' && $C != 'Content' && !is_object($$C) ) { unset ($$C); } }
		 */
		include ("current/engine/utility/ClassLoader.php");
		$ClassLoaderObj = ClassLoader::getInstance ();
		
		$ClassLoaderObj->provisionClass ( 'BaseToolSet' ); // First of them all as it is used by others.
		$bts = BaseToolSet::getInstance();

		// --------------------------------------------------------------------------------------------
		$Content =  "";
		// --------------------------------------------------------------------------------------------
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "+--------------------------------------------------------------------------------+"));
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "|                                                                                |"));
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "| Begining Hydr page                                                             |"));
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "|                                                                                |"));
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "+--------------------------------------------------------------------------------+"));
		
		
		$bts->LMObj->setStoreStatisticsStateOn ();
		$bts->LMObj->logCheckpoint ( "Index" );
		
		// --------------------------------------------------------------------------------------------
// 		error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );
// 		error_reporting ( E_ALL ^ E_NOTICE );
		error_reporting ( E_ALL  );
		ini_set ( 'log_errors', "On" );
		ini_set ( 'error_log', "/var/log/apache2/error.log" );
		ini_set ( 'display_errors', 0 );
		
		// --------------------------------------------------------------------------------------------
		// MSIE/edge/newEdge must die!!! Still thinking about Edge
		$Navigator = getenv ( "HTTP_USER_AGENT" );
		if (strpos ( $Navigator, "MSIE" ) !== FALSE) {
			if (strpos ( $Navigator, "DOM" ) !== FALSE) {
				include ("current/engine/staticPages/UnsupportedBrowserBanner.php");
				exit ();
			}
		}
		unset ( $Navigator );
		
		// --------------------------------------------------------------------------------------------
		//
		// CurrentSet
		//
		//
		$ClassLoaderObj->provisionClass( 'ServerInfos' );
		$ClassLoaderObj->provisionClass( 'CurrentSet' );
		$CurrentSetObj = CurrentSet::getInstance();
		$CurrentSetObj->setInstanceOfServerInfosObj( new ServerInfos() );
		$CurrentSetObj->getInstanceOfServerInfosObj()->getInfosFromServer();
		$CurrentSetObj->setDataEntry( 'fsIdx', 0 );		// Useful for FileSelector
		// --------------------------------------------------------------------------------------------
		//
		// Session management
		//
		//
		$CurrentSetObj->setDataEntry ( 'sessionName', 'HydrWebsiteSessionId' );
		
		$bts->initSmObj();
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . $bts->SMObj->getInfoSessionState()));
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : \$_SESSION :" . $bts->StringFormatObj->arrayToString ( $_SESSION ) . " *** \$bts->SMObj->getSession() = " . $bts->StringFormatObj->arrayToString ( $bts->SMObj->getSession () ) . " *** EOL") );
		
		// --------------------------------------------------------------------------------------------
		//
		// Scoring on what we recieved (or what's at disposal)
		//
		
		// case matrix  
		//	0	Reset session (anonymous user)
		//	1	Check session, Authentification mode = session
		//	2	sw has been submitted (this is a first contact case)
		//	3	sw has been submitted, update session with new sw,  check session
		//	4x	If an auth form is submitted a session is active unless « big problem » – unused case.
		//	5	A user is trying to authenticate. Great !
		//	6x	We have a form and a URI and no session at the same time. Unused case
		//	7x	We have a form and a URI at the same time. Unused case
		//	8	We recieved a « disconnect » directive. → disconnect, reset session
		// ...
		//	15	We recieved a « disconnect » directive. → disconnect, reset session
		
		$firstContactScore = 0;
		if (session_status () === PHP_SESSION_ACTIVE) { $firstContactScore ++; }
		if (strlen ( $bts->RequestDataObj->getRequestDataEntry ('ws') ) != 0) { $firstContactScore += 2; }
		if (strlen ( 
				$bts->RequestDataObj->getRequestDataEntry ( 'formSubmitted' ) ) == 1 && 
				$bts->RequestDataObj->getRequestDataSubEntry ( 'formGenericData', 'origin' ) == "ModuleAuthentification") { $firstContactScore += 4; }
		if (strlen ( $bts->RequestDataObj->getRequestDataSubEntry ( 'formGenericData', 'action' ) == "disconnection" )) { $firstContactScore += 8; }
		
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : \$firstContactScore='" . $firstContactScore . "'") );
		$authentificationMode = "session";
		$authentificationAction = USER_ACTION_SIGN_IN;
		
		switch ($firstContactScore) {
			case 0 :
				$bts->SMObj->InitializeSession();
				$bts->SMObj->UpdatePhpSession();
				break;
			case 1 :
				$bts->SMObj->CheckSession ();
				break;
			case 2 :
			case 3 :
				$bts->SMObj->setSessionEntry ( 'ws', $bts->RequestDataObj->getRequestDataEntry ( 'ws' ) );
				$bts->SMObj->CheckSession ();
				break;
			case 4 :
			case 5 :
			case 6 :
			case 7 :
				$authentificationMode = "form";
				break;
			case 8 :
			case 9 :
			case 10 :
			case 11 :
			case 12 :
			case 13 :
			case 14 :
			case 15 :
				$authentificationMode = "form";
				$authentificationAction = USER_ACTION_DISCONNECT;
				break;
		}
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . $bts->SMObj->getInfoSessionState(). ", \$authentificationMode=".$authentificationMode."; \$authentificationAction=".$authentificationAction));
		
		// --------------------------------------------------------------------------------------------
		//
		// Loading the configuration file associated with this website
		//
		$localisation = " (Start)";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "Start" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "Loading website data" );

		// A this point we have a ws in the session so we don't use the URI parameter anymore.
		$bts->CMObj->LoadConfigFile ();
		$bts->CMObj->setConfigurationEntry ( 'execution_context', "render" );
		$bts->LMObj->setDebugLogEcho ( 0 );

		// --------------------------------------------------------------------------------------------
		//
		// Creating the necessary arrays for Sql Db Dialog Management
		//
		$ClassLoaderObj->provisionClass ( 'SqlTableList' );
		$CurrentSetObj->setInstanceOfSqlTableListObj ( SqlTableList::getInstance ( $bts->CMObj->getConfigurationEntry ( 'dbprefix' ), $bts->CMObj->getConfigurationEntry ( 'tabprefix' ) ) );
		$SqlTableListObj = $CurrentSetObj->getInstanceOfSqlTableListObj ();

		// --------------------------------------------------------------------------------------------
		//
		// SQL DB dialog Management.
		//
		//
		$ClassLoaderObj->provisionClass ( 'SddmTools' );
		$ClassLoaderObj->provisionClass ( 'DalFacade' );
		$bts->initSddmObj ();
		
		if ($bts->SDDMObj->getReportEntry ( 'cnxErr' ) == 1) {
			include ("modules/initial/OfflineMessage/OfflineMessage.php");
			$ModuleOffLineMessageObj = new ModuleOffLineMessage ();
			$ModuleOffLineMessageObj->render ( array (
					"SQLFatalError" => 1,
					"bannerOffline" => 0
			) );
		}
		
		$bts->CMObj->PopulateLanguageList (); // Not before we have access to the DB. Better isn't it?
		
		// --------------------------------------------------------------------------------------------
		//
		// WebSite initialization
		//
		//
		$localisation = " (Initialization)";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "WebSite initialization" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "WebSite initialization" );
		
		$ClassLoaderObj->provisionClass ( 'WebSite' );
		$CurrentSetObj->setInstanceOfWebSiteObj ( new WebSite () );
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj ();
		$WebSiteObj->getDataFromDBUsingShort();
		
		switch ($WebSiteObj->getWebSiteEntry ( 'ws_state' )) {
			case 0 : // Offline
			case 3 : // Maintenance
			case 99 : // Verouillé
				$WebSiteObj->setWebSiteEntry ( 'banner_offline', 1 );
				include ("modules/initial/OfflineMessage/OfflineMessage.php");
				break;
		}
		$bts->CMObj->setLangSupport (); // will set support=1 in the languagelist if website supports the language.
		
		// --------------------------------------------------------------------------------------------
		//
		// Authentification
		//
		//
		$localisation = " (Authentification)";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "Authentification" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "Authentification" );

		$ClassLoaderObj->provisionClass ( 'AuthenticateUser' );
		$ClassLoaderObj->provisionClass ( 'User' );

		$CurrentSetObj->setInstanceOfUserObj ( new User () );
		$UserObj = $CurrentSetObj->getInstanceOfUserObj ();

		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : \$WebSiteObj" . $bts->StringFormatObj->arrayToString($WebSiteObj->getWebSite())) );
		
// 		We have 2 variables used to drive the authentification process.
		switch ($authentificationMode) {
			case "form" :
				$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : Authentification with form mode") );
				switch ($authentificationAction) {
					case USER_ACTION_DISCONNECT :
						$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : disconnect submitted") );
// 						$bts->SMObj->ResetSession ();
 						$bts->SMObj->InitializeSession();
						$userName = ANONYMOUS_USER_NAME;
						break;
					case USER_ACTION_SIGN_IN :
						$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : Connection attempt") );
						$userName = $bts->RequestDataObj->getRequestDataSubEntry ( 'authentificationForm', 'user_login' );
						break;
				}
// 				$bts->SMObj->ResetSession (); // If a login comes from a form. The session object must be reset!
				$bts->SMObj->InitializeSession(); // If a login comes from a form. The session object must be reset!
				$UserObj->getDataFromDB ( $userName, $WebSiteObj );
				$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : user_login=" . $UserObj->getUserEntry ( 'user_login' )) );
				$bts->AUObj->checkUserCredential ( $UserObj, 'form' );
				$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : Connection attempt end") );
				break;
			case "session" :
				$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : Authentification with session mode. user_login='" . $bts->SMObj->getSessionEntry ( 'user_login' ) . "'") );
				
// 				Assuming a session is valid (whatever it's 'anonymous' or someone else).
				if (strlen ( $bts->SMObj->getSessionEntry ( 'user_login' ) ) == 0) {
					$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : \$_SESSION strlen(user_login)=0") );
				}
				$UserObj->getDataFromDB ( $bts->SMObj->getSessionEntry ( 'user_login' ), $WebSiteObj );
				if ($UserObj->getUserEntry ( 'error_login_not_found' ) != 1) {
					$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : session mode : " . $bts->StringFormatObj->arrayToString ( $bts->SMObj->getSession () )) );
					$bts->AUObj->checkUserCredential ( $UserObj, 'session' );
				} else {
// 					No form then no user found it's defintely an anonymous user
					$bts->SMObj->InitializeSession();
					$UserObj->resetUser ();
					$UserObj->getDataFromDB ( 'anonymous', $WebSiteObj );
				}
				break;
		}
		
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : \$SMObj->getSession() :" . $bts->StringFormatObj->arrayToString ( $bts->SMObj->getSession () )) );
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : \$_SESSION :" . $bts->StringFormatObj->arrayToString ( $_SESSION )) );
		if ($bts->AUObj->getDataEntry ( 'error' ) === TRUE) {
			$UserObj->getDataFromDB ( "anonymous", $WebSiteObj );
		}
// 		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : UserObj = " . $bts->StringFormatObj->arrayToString($UserObj->getUser())));
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : checkUserCredential end") );
		
		// --------------------------------------------------------------------------------------------
		//
		// Language selection
		//
		//
		$localisation = " (Language selection)";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "Language selection" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "Language selection" );

		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : Language selection start") );
		
		$scoreLang = 0;
		
		if (strlen ( $bts->RequestDataObj->getRequestDataEntry ( 'l' ) ) != 0 && $bts->RequestDataObj->getRequestDataEntry ( 'l' ) != 0) {
			$scoreLang += 4;
		}
// 		if (strlen ( $UserObj->getUserEntry ( 'lang' ) ) != 0 && $UserObj->getUserEntry ( 'lang' ) != 0) {
		if (strlen ( $UserObj->getUserEntry ( 'user_lang' ) ) != 0 ) {
			$scoreLang += 2;
		}
		if (strlen ( $WebSiteObj->getWebSiteEntry ( 'fk_lang_id' ) ) != 0 && $WebSiteObj->getWebSiteEntry ( 'fk_lang_id' ) != 0) {
			$scoreLang += 1;
		}
		
		// $bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "Language list: ". $bts->StringFormatObj->arrayToString($bts->CMObj->getLanguageList())));
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : fk_lang_id='" . $WebSiteObj->getWebSiteEntry ( 'fk_lang_id' ) . "'") );
		
		switch ($scoreLang) {
			case 0 :
				$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Language selection Error. Something wrong happened (most likely no data for language in website table). In the mean time back to English as website language.") );
				$CurrentSetObj->setDataEntry ( 'language', 'eng' );
				$CurrentSetObj->setDataEntry ( 'language_id', '38' );
				break;
			case 1 :
				$tmp = $bts->CMObj->getLanguageListSubEntry ( $WebSiteObj->getWebSiteEntry ( 'fk_lang_id' ), 'lang_639_3' );
				$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Language selection says Website priority (Case=" . $scoreLang . "; " . $WebSiteObj->getWebSiteEntry ( 'fk_lang_id' ) . "->" . $tmp . ")") );
				$CurrentSetObj->setDataEntry ( 'language', $tmp );
				$CurrentSetObj->setDataEntry ( 'language_id', $bts->CMObj->getLanguageListSubEntry ( $WebSiteObj->getWebSiteEntry ( 'fk_lang_id' ), 'lang_id' ) );
				break;
			case 2 :
			case 3 :
				$tmp = $bts->CMObj->getLanguageListSubEntry ( $UserObj->getUserEntry ( 'user_lang' ), 'lang_639_3' );
				$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Language selection says User priority (Case=" . $scoreLang . "; " . $UserObj->getUserEntry ( 'user_lang' ) . "->" . $tmp . ")") );
				$CurrentSetObj->setDataEntry ( 'language', $tmp );
				$CurrentSetObj->setDataEntry ( 'language_id', $bts->CMObj->getLanguageListSubEntry ( $UserObj->getUserEntry ( 'user_lang' ), 'lang_id' ) );
				break;
			case 4 :
			case 5 :
			case 6 :
			case 7 :
				$tmp = strtolower ( $bts->RequestDataObj->getRequestDataEntry ( 'l' ) );
				$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Language selection says URL priority (Case=" . $scoreLang . "; " . $bts->RequestDataObj->getRequestDataEntry ( 'l' ) . "->" . $tmp . ")") );
				$CurrentSetObj->setDataEntry ( 'language', $tmp ); // URl/form asked, the king must be served!
				$CurrentSetObj->setDataEntry ( 'language_id', strtolower ( $bts->RequestDataObj->getRequestDataEntry ( 'l' ) ) );
				break;
		}
		
		$ClassLoaderObj->provisionClass ( 'I18nTrans' );
		$I18nObj = I18nTrans::getInstance ();
		$I18nObj->getI18nTransFromDB();
		
		$bts->LMObj->restoreLastInternalLogTarget ();
		
		// --------------------------------------------------------------------------------------------
		//
		// Form Management for commandLine interface
		//
		//
		
		// Do we have a user submitting from the auth form ?
		if ($bts->RequestDataObj->getRequestDataSubEntry ( 'formGenericData', 'modification' ) == 'on' || $bts->RequestDataObj->getRequestDataSubEntry ( 'formGenericData', 'deletion' ) == 'on' && $UserObj->getUserEntry ( 'user_login' ) != 'anonymous') {
			$localisation = " (CLI)";
			$bts->MapperObj->AddAnotherLevel ( $localisation );
			$bts->LMObj->logCheckpoint ( "CLI" );
			$bts->MapperObj->RemoveThisLevel ( $localisation );
			$bts->MapperObj->setSqlApplicant ( "CLI" );
			
			$ClassLoaderObj->provisionClass ( 'FormToCommandLine' );
			$FormToCommandLineObj = FormToCommandLine::getInstance ();
			$FormToCommandLineObj->analysis ();
			
			$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : FormToCommandLineObj->getCommandLineNbr() =" . $FormToCommandLineObj->getCommandLineNbr ()) );
			
			if ($FormToCommandLineObj->getCommandLineNbr () > 0) {
				$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : A script is on the bench :") );
				
				$ClassLoaderObj->provisionClass ( 'CommandConsole' );
				$CurrentSetObj->setInstanceOfWebSiteContextObj ( $WebSiteObj ); // Set an initial website context.
				$CommandConsole = CommandConsole::getInstance ();
				
				$bts->CMObj->setConfigurationSubEntry ( 'commandLineEngine', 'state', 'enabled' ); // enabled/disabled
				$Script = $FormToCommandLineObj->getCommandLineScript ();
				switch ($bts->CMObj->getConfigurationSubEntry ( 'commandLineEngine', 'state' )) {
					case "enabled" :
						foreach ( $Script as $A ) {
							$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : ExecuteCommand - ".$A) );
							$CommandConsole->executeCommand ( $A );
						}
						break;
					case "disabled" :
					default :
						foreach ( $Script as $A ) {
							$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Logging Command") );
							$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . $A) );
						}
						break;
				}
				$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End of command execution - ".$A) );
			}
			
			switch ($bts->RequestDataObj->getRequestDataSubEntry ( 'formGenericData', 'origin' ) . $bts->RequestDataObj->getRequestDataSubEntry ( 'formGenericData', 'section' )) {
				case "AdminDashboardUserProfileForm" :
				case "ModuleQuickSkin" :
				case "ModuleSelectLanguage" :
					$UserObj->getDataFromDB ( $UserObj->getUserEntry ( 'user_login' ), $WebSiteObj ); // We need to reload the user data in order to update the current user_pref_theme variable.
					break;
				case "AdminDashboardWebsiteManagementP01" :
					// refresh with updated data
					$id = $WebSiteObj->getWebSiteEntry ( 'ws_id' );
					$WebSiteObj->getDataFromDB ( $id );
					break;
			}
		}
		
		// --------------------------------------------------------------------------------------------
		//
		// Start of the module display
		// The so called route is based on the arti_ref transmitted
		//
		//
		$localisation = " (CurrentSet)";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "Prepare CurrentSet" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "Prepare CurrentSet" );
		
		// --------------------------------------------------------------------------------------------
		// Router
		// What was called ? (slug/form etc..) and storing information in the session
		$bts->Router->manageNavigation ();
		
		if (strlen ( $bts->SMObj->getSessionSubEntry('currentRoute', 'target') ) == 0) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : There is no viable route in the session. Back to home."));
			$sqlQuery = "
				SELECT mnu.menu_id, mnu.menu_name, mnu.fk_arti_ref
				FROM " . $SqlTableListObj->getSQLTableName ( 'menu' ) . " mnu, " . $SqlTableListObj->getSQLTableName ( 'deadline' ) . " bcl
				WHERE mnu.fk_ws_id = '" . $WebSiteObj->getWebSiteEntry ( 'ws_id' ) . "'
				AND mnu.fk_lang_id = '" . $CurrentSetObj->getDataEntry ( 'language_id') . "'
				AND mnu.fk_deadline_id = bcl.deadline_id
				AND bcl.deadline_state = '1'
				AND mnu.menu_type IN ('0','1')
				AND mnu.fk_perm_id " . $UserObj->getUserEntry ( 'clause_in_perm' ) . "
				AND mnu.menu_state = '1'
				AND mnu.menu_initial_document = '1'
				ORDER BY mnu.menu_parent,mnu.menu_position
				;";
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . $sqlQuery));
			$dbquery = $bts->SDDMObj->query ($sqlQuery);
			while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$CurrentSetObj->setDataSubEntry ( 'article', 'menu_id', $dbp ['menu_id'] );
				$CurrentSetObj->setDataSubEntry ( 'article', 'arti_id', $dbp ['arti_id'] );
				$CurrentSetObj->setDataSubEntry ( 'article', 'arti_ref', $dbp ['arti_ref'] );
			}
			$CurrentSetObj->setDataSubEntry ( 'article', 'arti_page', 1 );
		} else {
			// Is the user can read this article ?
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : A route exists in the session. The target is `".$bts->SMObj->getSessionSubEntry('currentRoute', 'target')."`."));

			// Special case for admin auth 
			if ( $bts->SMObj->getSessionSubEntry('currentRoute', 'target') == "admin-authentification") {
				$sqlQuery = "
					SELECT * FROM ". $SqlTableListObj->getSQLTableName ( 'article' ) . " art
					WHERE art.arti_slug = '".$bts->SMObj->getSessionSubEntry('currentRoute', 'target')."'
					AND art.arti_page = '1';
					;";
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . $sqlQuery));
				$dbquery = $bts->SDDMObj->query ($sqlQuery);
			}
			else {
				// Normal case
				$sqlQuery = "
					SELECT * 
					FROM " 
					. $SqlTableListObj->getSQLTableName ( 'menu' ) . " mnu, " 
					. $SqlTableListObj->getSQLTableName ( 'article' ) . " art
					WHERE mnu.fk_ws_id IN ('" . $WebSiteObj->getWebSiteEntry ('ws_id') . "')
					AND mnu.fk_lang_id = '" . $CurrentSetObj->getDataEntry ( 'language_id') . "' 
					AND mnu.fk_perm_id " . $UserObj->getUserEntry ('clause_in_perm') . " 
					AND mnu.menu_state = '1'
					AND mnu.fk_arti_ref = art.arti_ref
					AND art.arti_slug = '".$bts->SMObj->getSessionSubEntry('currentRoute', 'target')."'
					AND art.arti_page = '".$bts->SMObj->getSessionSubEntry('currentRoute', 'page')."';
					;";
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . $sqlQuery));
				$dbquery = $bts->SDDMObj->query ($sqlQuery);
			}
			if ($bts->SDDMObj->num_row_sql ( $dbquery ) > 0) {
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : We got SQL rows for `".$bts->SMObj->getSessionSubEntry('currentRoute', 'target')."`."));
				while ( $dbp = $bts->SDDMObj->fetch_array_sql ( $dbquery ) ) {
					$CurrentSetObj->setDataSubEntry ( 'article', 'menu_id', $dbp ['menu_id'] );
					$CurrentSetObj->setDataSubEntry ( 'article', 'arti_id', $dbp ['arti_id'] );
					$CurrentSetObj->setDataSubEntry ( 'article', 'arti_ref', $dbp ['arti_ref'] );
					$CurrentSetObj->setDataSubEntry ( 'article', 'arti_slug', $dbp ['arti_slug'] );
					$CurrentSetObj->setDataSubEntry ( 'article', 'arti_page', $dbp ['arti_page'] );
				}
			} else {
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No SQL rows for ".$bts->SMObj->getSessionSubEntry('currentRoute', 'target')));
				$CurrentSetObj->setDataSubEntry ( 'article', 'menu_id', $dbp ['menu_id'] );
				$CurrentSetObj->setDataSubEntry ( 'article', 'arti_id', $dbp ['arti_id'] );
				$CurrentSetObj->setDataSubEntry ( 'article', 'arti_ref', $CurrentSetObj->getDataEntry ( 'language' ) ."_". 'article_not_found' );
				$CurrentSetObj->setDataSubEntry ( 'article', 'arti_slug', 'article_not_found' );
				$bts->RequestDataObj->setRequestDataEntry ( 'arti_ref', $CurrentSetObj->getDataEntry ( 'language' ) ."_". 'article_not_found' );		//deprecated remove when ready
				$bts->RequestDataObj->setRequestDataEntry ( 'arti_page', 1 );
				$CurrentSetObj->setDataSubEntry ( 'article', 'arti_page', $bts->RequestDataObj->getRequestDataEntry ( 'arti_page' ) );
			}
		}
		
		$ClassLoaderObj->provisionClass ( 'Article' );
		$CurrentSetObj->setInstanceOfArticleObj(new Article());
		$CurrentSetObj->getInstanceOfArticleObj()->getDataFromDB($CurrentSetObj->getDataSubEntry( 'article', 'arti_id'));

		// --------------------------------------------------------------------------------------------
		$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'post_hidden_ws', "<input type='hidden'	name='ws'					value='" . $WebSiteObj->getWebSiteEntry ( 'ws_short' ) . "'>\r" );
		$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'post_hidden_l', "<input type='hidden'	name='l'					value='" . $CurrentSetObj->getDataEntry ( 'language' ) . "'>\r" );
		$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'post_hidden_user_login', "<input type='hidden'	name='user_login'	value='" . $bts->SMObj->getSessionEntry ( 'user_login' ) . "'>\r" );
		$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'post_hidden_user_pass', "<input type='hidden'	name='user_pass'	value='" . $bts->SMObj->getSessionEntry ( 'user_password' ) . "'>\r" );
		$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'post_hidden_arti_ref', "<input type='hidden'	name='arti_ref'		value='" . $CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref' ) . "'>\r" );
		$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'post_hidden_arti_page', "<input type='hidden'	name='arti_page'	value='" . $CurrentSetObj->getDataSubEntry ( 'article', 'arti_page' ) . "'>\r" );
		
		$urlUsrPass = "";
		if ($bts->SMObj->getSessionEntry ( 'sessionMode' ) != 1) {
			$urlUsrPass = "&amp;user_login=" . $bts->SMObj->getSessionEntry ( 'user_login' );
		}
		$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'url_slup', "" ); // Site Lang User Pass
		$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'url_sldup', "&sw=" . $WebSiteObj->getWebSiteEntry ( 'ws_id' ) . "&l=" . $CurrentSetObj->getDataEntry ( 'language' ) . "&arti_ref=" . $CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref' ) . "&arti_page=" . $CurrentSetObj->getDataSubEntry ( 'article', 'arti_page' ) . $urlUsrPass ); // Site Lang Article User Pass
		$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'url_sdup', "&sw=" . $WebSiteObj->getWebSiteEntry ( 'ws_id' ) . "&arti_ref=" . $CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref' ) . "&arti_page=" . $CurrentSetObj->getDataSubEntry ( 'article', 'arti_page' ) . $urlUsrPass ); // Site Article User Pass
		
		// --------------------------------------------------------------------------------------------
		//
		// JavaScript Object
		//
		//
		$localisation = " (JavaScript)";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "Prepare JavaScript Object" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "Prepare JavaScript Object" );
		
		$ClassLoaderObj->provisionClass ( 'GeneratedScript' );
		$CurrentSetObj->setInstanceOfGeneratedScriptObj ( new GeneratedScript () );
		$GeneratedScript = $CurrentSetObj->getInstanceOfGeneratedScriptObj();
		$GeneratedScript->insertString('JavaScript-File', 'current/engine/javascript/lib_HydrCore.js' );
		
		// $GeneratedScript->insertString('JavaScript-File', 'current/engine/javascript_lib_calculs_decoration.js');
		// We got the route definition in the $CurrentSet and the session.
		// Inserting the URL in the browser bar.
		$urlBar = $CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url'). $CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug')."/".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_page')."/";
		$GeneratedScript->insertString('JavaScript-OnLoad', "	window.history.pushState( null , '".$WebSiteObj->getWebSiteEntry ( 'ws_title' )."', '".$urlBar."');" );
		$GeneratedScript->insertString('JavaScript-OnLoad', "	document.title = '".$WebSiteObj->getWebSiteEntry ( 'ws_title' )." - ".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug')."';");
		
		$GeneratedScript->insertString('JavaScript-OnResize', "\telm.UpdateWindowSize ('');");

		// --------------------------------------------------------------------------------------------
		//
		// Prepare data for theme and layout
		//
		//
		$localisation = " (Theme&Layout)";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "Prepare Theme & Layout" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "Prepare Theme & Layout" );
		
		// Those are ENTITIES(DAO), they're not UTILITY classes.
		$ClassLoaderObj->provisionClass ( 'Deco10_Menu' );
		$ClassLoaderObj->provisionClass ( 'Deco20_Caligraph' );
		$ClassLoaderObj->provisionClass ( 'Deco30_1Div' );
		$ClassLoaderObj->provisionClass ( 'Deco40_Elegance' );
		$ClassLoaderObj->provisionClass ( 'Deco50_Exquisite' );
		$ClassLoaderObj->provisionClass ( 'Deco60_Elysion' );
		$ClassLoaderObj->provisionClass ( 'ThemeDescriptor' );
		
		$CurrentSetObj->setInstanceOfThemeDescriptorObj ( new ThemeDescriptor () );
		$ThemeDescriptorObj = $CurrentSetObj->getInstanceOfThemeDescriptorObj ();
		
		$ThemeDescriptorObj->setCssPrefix("mt_");
		$ThemeDescriptorObj->getDataFromDBByPriority ();
		
		$ClassLoaderObj->provisionClass ( 'ThemeData' );
		$CurrentSetObj->setInstanceOfThemeDataObj ( new ThemeData () );
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj ();
		$ThemeDataObj->setThemeData ( $ThemeDescriptorObj->getThemeDescriptor () ); // Better to give an array than the object itself.
		$ThemeDataObj->setThemeName ( $ThemeDescriptorObj->getCssPrefix() );
		$ThemeDataObj->setDecorationListFromDB ();
		$ThemeDataObj->renderBlockData ();
		
		// --------------------------------------------------------------------------------------------
		$ClassLoaderObj->provisionClass ('ModuleList');
		$CurrentSetObj->setInstanceOfModuleListObj(new ModuleList());
		$ModuleLisObj = $CurrentSetObj->getInstanceOfModuleListObj();
		$ModuleLisObj->makeModuleList();
		
		$ClassLoaderObj->provisionClass ('LayoutProcessor');
		$LayoutProcessorObj = LayoutProcessor::getInstance();
		$ClassLoaderObj->provisionClass ( 'RenderModule' );
		$RenderModuleObj = RenderModule::getInstance ();
		
		$ContentFragments = $LayoutProcessorObj->render();
		
		$LayoutCommands = array(
			0 => array( "regex"	=> "/{{\s*get_header\s*\(\s*\)\s*}}/", "command"	=> 'get_header'),
			1 => array( "regex"	=> "/{{\s*render_module\s*\(\s*('|\"|`)\w*('|\"|`)\s*\)\s*}}/", "command"	=> 'render_module'),
		);
		
		// We know there's only one command per entry
		$insertJavascriptDecorationMgmt = false;
		foreach ( $ContentFragments as &$A ) {
			foreach ( $LayoutCommands as $B) {
				if ( $A['type'] == "command" && preg_match($B['regex'],$A['data'],$match) === 1 ) {
					// We got the match so it's...
					switch ($B['command']) {
						case "get_header":
							break;
						case "render_module":
							// Module it is.
							if ( $insertJavascriptDecorationMgmt == false) {
								$GeneratedScript->insertString('JavaScript-OnLoad', "\tdm.UpdateAllDecoModule(TabInfoModule);" );
								$GeneratedScript->insertString('JavaScript-OnResize', "\tdm.UpdateAllDecoModule(TabInfoModule);");
								$GeneratedScript->insertString("JavaScript-Data", "var TabInfoModule = new Array();\r");
								$insertJavascriptDecorationMgmt = true;
							}
							$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : `". $A['type'] ."`; for `". $A['module_name'] ."` and data ". $A['data'] ) );
							$A['content'] = $RenderModuleObj->render($A['module_name']);
							break;
					}
				}
			}
		}

		// --------------------------------------------------------------------------------------------
		//
		// Display
		//
		//
		$localisation = " / Modules";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "Module Processing" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "Module Processing" );
		
		$ClassLoaderObj->provisionClass ( 'InteractiveElements' ); // Responsible for rendering buttons
		
		// --------------------------------------------------------------------------------------------
		// StyleSheet
		
		$ClassLoaderObj->provisionClass ( 'RenderStylesheet' );
		$RenderStylesheetObj = RenderStylesheet::getInstance ();
		$stylesheet = $RenderStylesheetObj->render ( "mt_", $ThemeDataObj );
		
		$Content .= "<!DOCTYPE html>\r<html>";
		switch ($WebSiteObj->getWebSiteEntry ( 'ws_stylesheet' )) {
			case 1 : // dynamic
				$Content .= "
				<head>\r
				<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>\r
				<title>" . $WebSiteObj->getWebSiteEntry ( 'ws_title' ) . "</title>\r
			";
				$Content .= $stylesheet . "</head>\r" . $html_body;
				unset ( $stylesheet );
				break;
			case 0 : // statique
				$Content .= "
					<head>\r
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>\r
					<link rel='stylesheet' href='".$CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url')."stylesheets/".$ThemeDataObj->getThemeDataEntry('theme_stylesheet_1')."'>
					</head>\r
					";
				break;
		}
		$Content .= "<body id='HydrBody' ";
		if (strlen ( $ThemeDataObj->getThemeBlockEntry ( 'B01T', 'txt_col' ) ) > 0) {
			$html_body .= "text='" . $ThemeDataObj->getThemeBlockEntry ( 'B01T', 'txt_col' ) . 
			"' link='" . $ThemeDataObj->getThemeBlockEntry ( 'B01T', 'txt_col' ) . 
			"' vlink='" . $ThemeDataObj->getThemeBlockEntry ( 'B01T', 'txt_col' ) . 
			"' alink='" . $ThemeDataObj->getThemeBlockEntry ( 'B01T', 'txt_col' ) . "' ";
		}
		$Content .= "style='
		height:100%;";
		if (strlen ( $ThemeDataObj->getThemeDataEntry ( 'theme_bg' ) ) > 0) {
			$Content .= "background-image: url(".
				$CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url').
				"media/theme/" . $ThemeDataObj->getThemeDataEntry ( 'theme_directory' ) . "/" . $ThemeDataObj->getThemeDataEntry ( 'theme_bg' ) . "); 
				background-repeat: " . $ThemeDataObj->getThemeDataEntry ( 'theme_bg_repeat' ) . "; ";
		}
		if (strlen ( $ThemeDataObj->getThemeDataEntry ( 'theme_bg_color' ) ) > 0) {
			$Content .= "background-color: #" . $ThemeDataObj->getThemeDataEntry ( 'theme_bg_color' ) . ";";
		}
		$Content .= "'>\r ";
		// --------------------------------------------------------------------------------------------
		foreach ( $ContentFragments as &$A ) {
//			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : ". $C['content']));
			$Content .= $A['content'];
		}

		// --------------------------------------------------------------------------------------------
		//
		// Checkpoint ("index_before_stat");
		//
		//
		$localisation = " (Stats)";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "Stats" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "Stats" );
		
		$bts->LMObj->logCheckpoint ( "index_before_stat" );
		$bts->MapperObj->RemoveThisLevel ( "/ idx" );
		$CurrentSetObj->setDataSubEntry ( 'timeStat', 'end', $bts->TimeObj->microtime_chrono () ); // We get time for later use in the stats.
		
		$bts->LMObj->setStoreStatisticsStateOff ();
		// --------------------------------------------------------------------------------------------
		$ClassLoaderObj->provisionClass ( 'RenderAdmDashboard' );
		$RenderAdmDashboardObj = RenderAdmDashboard::getInstance ();
		$Content .= $RenderAdmDashboardObj->render ();
		
		// --------------------------------------------------------------------------------------------
		// creating file selector if necessary
		// $module_z_index['compteur'] = 500; //bypass Z-index from layout
		// $pv['sdftotal'] = $_REQUEST['FS_index'];
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : About to process file selector"));
		
		// $sdftotal = $CurrentSetObj->getDataEntry ( 'fsIdx' );
		if ($CurrentSetObj->getDataEntry ( 'fsIdx' ) > 0) {
		
			$ClassLoaderObj->provisionClass ( 'FileSelector' );
			$FileSelectorObj = FileSelector::getInstance ();
			$infos ['block'] = $ThemeDataObj->getThemeName () . "B01";
			$infos ['blockG'] = $infos ['block'] . "G";
			$infos ['blockT'] = $infos ['block'] . "T";
			$Content .= $FileSelectorObj->render ( $infos );
			
			$fs = $CurrentSetObj->getDataEntry ( 'fs' );
			$str = "var tableFileSelector = {\r";
			$i = 0;
			foreach ( $fs as $A ) {
				$str .= "'" . $i . "':{ 'idx':'" . $i . "',	'width':'" . $A ['width'] . "',	'height':'" . $A ['height'] . "',	'formName':'" . $A ['formName'] . "',	'formTargetId':'" . $A ['formTargetId'] . "',	'selectionMode':'" . $A ['selectionMode'] . "',	'lastPath':'" . $A ['path'] . "',	'restrictTo':'" . $A ['restrictTo'] . "',	'strRemove':'" . addslashes ( $A ['strRemove'] ) . "',	'strAdd':'" . $A ['strAdd'] . "',	'displayType':'" . $A ['displayType'] . "'	},\r";
				$i ++;
			}
			$str = substr ( $str, 0, - 2 ) . "\r};\r";
			$GeneratedScript->insertString('JavaScript-Data', $str );
		}
		
		// --------------------------------------------------------------------------------------------
		// Rendering of the CSS
		//
		// --------------------------------------------------------------------------------------------
		$CssContent  ="<!-- Extra CSS -->\r";
		$CssContent .= $GeneratedScript->renderScriptFileWithBaseURL ( "Css-File", "<link rel='stylesheet' href='", "'>\r" );

		// --------------------------------------------------------------------------------------------
		// Rendering of the JavaScript
		//
		// --------------------------------------------------------------------------------------------
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : About to render javascript"));
		$GeneratedScript->insertString('JavaScript-OnLoad', "\tconsole.log ( TabInfoModule );" );
		$GeneratedScript->insertString('JavaScript-OnLoad', "\telm.Gebi('HydrBody').style.visibility = 'visible';" );
		$GeneratedScript->insertString('JavaScript-File', 'current/engine/javascript/lib_DecorationManagement.js' );
		$GeneratedScript->insertString('JavaScript-Init', 'var dm = new DecorationManagement();');

		$JavaScriptContent = "<!-- JavaScript -->\r\r";
		$JavaScriptContent .= $GeneratedScript->renderScriptFileWithBaseURL ( "JavaScript-File", "<script type='text/javascript' src='", "'></script>\r" );
		$JavaScriptContent .= $GeneratedScript->renderExternalRessourceScript ( "JavaScript-ExternalRessource", "<script type='text/javascript' src='", "'></script>\r" );
		$JavaScriptContent .= "<script type='text/javascript'>\r";
		
		$JavaScriptContent .= "// ----------------------------------------\r//\r// Data segment\r//\r//\r";
		$JavaScriptContent .= $GeneratedScript->renderScriptCrudeMode ( "JavaScript-Data" );
		$JavaScriptContent .= "// ----------------------------------------\r//\r// Data (Flexible) \r//\r//\r";
		$JavaScriptContent .= $GeneratedScript->renderJavaScriptObjects();
		$JavaScriptContent .= "// ----------------------------------------\r//\r// Init segment\r//\r//\r";
		$JavaScriptContent .= $GeneratedScript->renderScriptCrudeMode ( "JavaScript-Init" );
		$JavaScriptContent .= "// ----------------------------------------\r//\r// Command segment\r//\r//\r";
		$JavaScriptContent .= $GeneratedScript->renderScriptCrudeMode ( "JavaScript-Command" );
		$JavaScriptContent .= "// ----------------------------------------\r//\r// OnLoad segment\r//\r//\r";
		$JavaScriptContent .= "function WindowOnResize (){\r";
		$JavaScriptContent .= $GeneratedScript->renderScriptCrudeMode ( "JavaScript-OnResize" );
		$JavaScriptContent .= "}\r";
		$JavaScriptContent .= "function WindowOnLoad () {\r";
		$JavaScriptContent .= $GeneratedScript->renderScriptCrudeMode ( "JavaScript-OnLoad" );
		$JavaScriptContent .= "
	}\r
	window.onresize = WindowOnResize;\r
	window.onload = WindowOnLoad;\r
	</script>\r";

		$licence = "
			<!--
			Author : FMA - 2005 ~ " . date ( "Y", time () ) . "
			Licence : Creative commons CC-by-nc-sa (http://www.creativecommons.org/)
			-->
			";
		
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : \$_SESSION :" . $bts->StringFormatObj->arrayToString ( $_SESSION )) );

		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT,	'msg' => __METHOD__ ." : Test logging with levels (lalalalala)" ));
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_BREAKPOINT,	'msg' => __METHOD__ ." : Test logging with levels (lalalalala)" ));
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_INFORMATION,	'msg' => __METHOD__ ." : Test logging with levels (lalalalala)" ));
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_WARNING,		'msg' => __METHOD__ ." : Test logging with levels (lalalalala)" ));
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_ERROR,		'msg' => __METHOD__ ." : Test logging with levels (lalalalala)" ));

		// --------------------------------------------------------------------------------------------
		$bts->SDDMObj->disconnect_sql ();
		return ($Content . $CssContent . $JavaScriptContent . $licence . "</body>\r</html>\r");
	}
}

?>
