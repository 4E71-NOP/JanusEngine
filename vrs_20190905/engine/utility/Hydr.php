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
		include ("define.php");

		// --------------------------------------------------------------------------------------------

		/*
		 * Good practice for the main script when it's ready to think about saving memory... more.
		 * $varsStart = array_keys(get_defined_vars());
		 * [...]
		 * $varsEnd = array_keys(get_defined_vars());
		 * $varsSum = array_diff ($varsEnd, $varsStart);
		 * foreach ( $varsSum as $B => $C ) { if ( $C != 'infos' && $C != 'Content' && !is_object($$C) ) { unset ($$C); } }
		 */
		include ("engine/utility/ClassLoader.php");
		$ClassLoaderObj = ClassLoader::getInstance ();
		
		$ClassLoaderObj->provisionClass ( 'CommonSystem' ); // First of them all as it is extended by others.
		$cs = CommonSystem::getInstance ();
		
		// --------------------------------------------------------------------------------------------
		$Content = "";
		// --------------------------------------------------------------------------------------------
		$cs->LMObj->setStoreStatisticsStateOn ();
		$cs->LMObj->logCheckpoint ( "Index" );
		
		// --------------------------------------------------------------------------------------------
		error_reporting ( E_ALL ^ E_NOTICE );
		ini_set ( 'log_errors', "On" );
		ini_set ( 'error_log', "/var/log/apache2/error.log" );
		
		// --------------------------------------------------------------------------------------------
		// MSIE must die!!! Still thinking about Edge
		$Navigator = getenv ( "HTTP_USER_AGENT" );
		if (strpos ( $Navigator, "MSIE" ) !== FALSE) {
			if (strpos ( $Navigator, "DOM" ) !== FALSE) {
				include ("engine/staticPages/UnsupportedBrowserBanner.php");
				exit ();
			}
		}
		unset ( $Navigator );
		
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
		$CurrentSetObj->setDataEntry ( 'fsIdx', 0 ); // Useful for FileSelector
		
		// --------------------------------------------------------------------------------------------
		//
		// Session management
		//
		//
		$CurrentSetObj->setDataEntry ( 'sessionName', 'HydrWebsiteSessionId' );
		session_name ( $CurrentSetObj->getDataEntry ( 'sessionName' ) );
		session_start ();
		$cs->initSmObj ();

		$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : \$_SESSION :" . $cs->StringFormatObj->arrayToString ( $_SESSION ) . " *** \$cs->SMObj->getSession() = " . $cs->StringFormatObj->arrayToString ( $cs->SMObj->getSession () ) . " *** EOL") );

		// --------------------------------------------------------------------------------------------
		//
		// Scoring on what we recieved (or what's at disposal)
		//
		$firstContactScore = 0;

		if (session_status () === PHP_SESSION_ACTIVE) {
			$firstContactScore ++;
		}
		if (strlen ( $cs->RequestDataObj->getRequestDataEntry ( 'ws' ) ) != 0) {
			$firstContactScore += 2;
		}
		if (strlen ( $cs->RequestDataObj->getRequestDataEntry ( 'formSubmitted' ) ) == 1 && $cs->RequestDataObj->getRequestDataSubEntry ( 'formGenericData', 'origin' ) == "ModuleAuthentification") {
			$firstContactScore += 4;
		}
		if (strlen ( $cs->RequestDataObj->getRequestDataSubEntry ( 'formGenericData', 'action' ) == "disconnection" )) {
			$firstContactScore += 8;
		}

		$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : \$firstContactScore='" . $firstContactScore . "'") );
		$authentificationMode = "session";
		$authentificationAction = USER_ACTION_SIGN_IN;
		switch ($firstContactScore) {
			case 0 :
				$cs->SMObj->ResetSession ();
				break;
			case 6 :
			case 7 :
				$authentificationMode = "form";
			case 2 :
			case 3 :
				$cs->SMObj->ResetSession ();
				$cs->SMObj->setSessionEntry ( 'ws', $cs->RequestDataObj->getRequestDataEntry ( 'ws' ) );
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
			case 1 :
				$cs->SMObj->CheckSession ();
				break;
		}

		// --------------------------------------------------------------------------------------------
		//
		// Loading the configuration file associated with this website
		//
		$localisation = " (Start)";
		$cs->MapperObj->AddAnotherLevel ( $localisation );
		$cs->LMObj->logCheckpoint ( "Start" );
		$cs->MapperObj->RemoveThisLevel ( $localisation );
		$cs->MapperObj->setSqlApplicant ( "Loading website data" );

		// A this point we have a ws in the session so we don't use the URI parameter anymore.
		$cs->CMObj->LoadConfigFile ();
		$cs->CMObj->setConfigurationEntry ( 'execution_context', "render" );
		$cs->LMObj->setDebugLogEcho ( 0 );

		// --------------------------------------------------------------------------------------------
		//
		// Creating the necessary arrays for Sql Db Dialog Management
		//
		$ClassLoaderObj->provisionClass ( 'SqlTableList' );
		$CurrentSetObj->setInstanceOfSqlTableListObj ( SqlTableList::getInstance ( $cs->CMObj->getConfigurationEntry ( 'dbprefix' ), $cs->CMObj->getConfigurationEntry ( 'tabprefix' ) ) );
		$SqlTableListObj = $CurrentSetObj->getInstanceOfSqlTableListObj ();

		// --------------------------------------------------------------------------------------------
		//
		// SQL DB dialog Management.
		//
		//
		$ClassLoaderObj->provisionClass ( 'SddmTools' );
		$ClassLoaderObj->provisionClass ( 'DalFacade' );
		$cs->initSddmObj ();

		if ($cs->SDDMObj->getReportEntry ( 'cnxErr' ) == 1) {
			include ("../modules/initial/OfflineMessage/OfflineMessage.php");
			$ModuleOffLineMessageObj = new ModuleOffLineMessage ();
			$ModuleOffLineMessageObj->render ( array (
					"SQLFatalError" => 1,
					"bannerOffline" => 0
			) );
		}

		$cs->CMObj->PopulateLanguageList (); // Not before we have access to the DB. Better isn't it?

		// --------------------------------------------------------------------------------------------
		//
		// WebSite initialization
		//
		//
		$localisation = " (Initialization)";
		$cs->MapperObj->AddAnotherLevel ( $localisation );
		$cs->LMObj->logCheckpoint ( "WebSite initialization" );
		$cs->MapperObj->RemoveThisLevel ( $localisation );
		$cs->MapperObj->setSqlApplicant ( "WebSite initialization" );

		// $theme_tableau = "theme_princ_";
		$ClassLoaderObj->provisionClass ( 'WebSite' );
		$CurrentSetObj->setInstanceOfWebSiteObj ( new WebSite () );
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj ();
		$WebSiteObj->getWebSiteDataFromDB ();

		switch ($WebSiteObj->getWebSiteEntry ( 'ws_state' )) {
			case 0 : // Offline
			case 3 : // Maintenance
			case 99 : // Verouillé
				$WebSiteObj->setWebSiteEntry ( 'banner_offline', 1 );
				include ("../modules/initial/OfflineMessage/OfflineMessage.php");
				break;
		}
		$cs->CMObj->setLangSupport (); // will set support=1 in the languagelist if website supports the language.

		// --------------------------------------------------------------------------------------------
		//
		// Authentification
		//
		//
		$localisation = " (Authentification)";
		$cs->MapperObj->AddAnotherLevel ( $localisation );
		$cs->LMObj->logCheckpoint ( "Authentification" );
		$cs->MapperObj->RemoveThisLevel ( $localisation );
		$cs->MapperObj->setSqlApplicant ( "Authentification" );

		$ClassLoaderObj->provisionClass ( 'AuthenticateUser' );
		$ClassLoaderObj->provisionClass ( 'User' );

		$CurrentSetObj->setInstanceOfUserObj ( new User () );
		$UserObj = $CurrentSetObj->getInstanceOfUserObj ();

		$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : \$WebSiteObj" . $cs->StringFormatObj->arrayToString($WebSiteObj->getWebSite())) );
		
		// we have 2 variables used to drive the authentification process.
		switch ($authentificationMode) {
			case "form" :
				$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : Authentification with form mode") );
				switch ($authentificationAction) {
					case USER_ACTION_DISCONNECT :
						$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : disconnect submitted") );
						$cs->SMObj->ResetSession ();
						$userName = ANONYMOUS_USER_NAME;
						break;
					case USER_ACTION_SIGN_IN :
						$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : Connection attempt") );
						$userName = $cs->RequestDataObj->getRequestDataSubEntry ( 'authentificationForm', 'user_login' );
						break;
				}
				$cs->SMObj->ResetSession (); // If a login comes from a form. The session object must be reset!
				$UserObj->getUserDataFromDB ( $userName, $WebSiteObj );
				$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : user_login=" . $UserObj->getUserEntry ( 'user_login' )) );
				$cs->AUObj->checkUserCredential ( $UserObj, 'form' );
				$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : Connection attempt end") );
				break;
			case "session" :
				$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : Authentification with session mode. user_login='" . $cs->SMObj->getSessionEntry ( 'user_login' ) . "'") );
				
				// Assuming a session is valid (whatever it's 'anonymous' or someone else).
				if (strlen ( $cs->SMObj->getSessionEntry ( 'user_login' ) ) == 0) {
					$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : \$_SESSION strlen(user_login)=0") );
					$cs->SMObj->ResetSession ();
				}
				$UserObj->getUserDataFromDB ( $cs->SMObj->getSessionEntry ( 'user_login' ), $WebSiteObj );
				if ($UserObj->getUserEntry ( 'error_login_not_found' ) != 1) {
					$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : session mode : " . $cs->StringFormatObj->arrayToString ( $cs->SMObj->getSession () )) );
					$cs->AUObj->checkUserCredential ( $UserObj, 'session' );
				} else {
					// No form then no user found it's defintely an anonymous user
					$cs->SMObj->ResetSession ();
					$UserObj->resetUser ();
					$UserObj->getUserDataFromDB ( 'anonymous', $WebSiteObj );
				}
				break;
		}

		$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : \$SMObj->getSession() :" . $cs->StringFormatObj->arrayToString ( $cs->SMObj->getSession () )) );
		$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : \$_SESSION :" . $cs->StringFormatObj->arrayToString ( $_SESSION )) );
		if ($cs->AUObj->getDataEntry ( 'error' ) === TRUE) {
			$UserObj->getUserDataFromDB ( "anonymous", $WebSiteObj );
		}
		// $cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : UserObj = " . $cs->StringFormatObj->arrayToString($UserObj->getUser())));
		$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : checkUserCredential end") );

		// --------------------------------------------------------------------------------------------
		//
		// Language selection
		//
		//
		$localisation = " (Language selection)";
		$cs->MapperObj->AddAnotherLevel ( $localisation );
		$cs->LMObj->logCheckpoint ( "Language selection" );
		$cs->MapperObj->RemoveThisLevel ( $localisation );
		$cs->MapperObj->setSqlApplicant ( "Language selection" );

		$scoreLang = 0;

		if (strlen ( $cs->RequestDataObj->getRequestDataEntry ( 'l' ) ) != 0 && $cs->RequestDataObj->getRequestDataEntry ( 'l' ) != 0) {
			$scoreLang += 4;
		}
		if (strlen ( $UserObj->getUserEntry ( 'lang' ) ) != 0 && $UserObj->getUserEntry ( 'lang' ) != 0) {
			$scoreLang += 2;
		}
		if (strlen ( $WebSiteObj->getWebSiteEntry ( 'ws_lang' ) ) != 0 && $WebSiteObj->getWebSiteEntry ( 'ws_lang' ) != 0) {
			$scoreLang += 1;
		}
		
		// $cs->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "Language list: ". $cs->StringFormatObj->arrayToString($cs->CMObj->getLanguageList())));
		$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : ws_lang='" . $WebSiteObj->getWebSiteEntry ( 'ws_lang' ) . "'") );
		
		switch ($scoreLang) {
			case 0 :
				$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Language selection Error. Something wrong happened") );
				break;
			case 1 :
				$tmp = $cs->CMObj->getLanguageListSubEntry ( $WebSiteObj->getWebSiteEntry ( 'ws_lang' ), 'lang_639_3' );
				$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Language selection says Website priority (Case=" . $scoreLang . "; " . $WebSiteObj->getWebSiteEntry ( 'ws_lang' ) . "->" . $tmp . ")") );
				$CurrentSetObj->setDataEntry ( 'language', $tmp );
				$CurrentSetObj->setDataEntry ( 'language_id', $cs->CMObj->getLanguageListSubEntry ( $WebSiteObj->getWebSiteEntry ( 'ws_lang' ), 'lang_id' ) );
				break;
			case 2 :
			case 3 :
				$tmp = $cs->CMObj->getLanguageListSubEntry ( $UserObj->getUserEntry ( 'lang' ), 'lang_639_3' );
				$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Language selection says User priority (Case=" . $scoreLang . "; " . $UserObj->getUserEntry ( 'lang' ) . "->" . $tmp . ")") );
				$CurrentSetObj->setDataEntry ( 'language', $tmp );
				$CurrentSetObj->setDataEntry ( 'language_id', $cs->CMObj->getLanguageListSubEntry ( $UserObj->getUserEntry ( 'lang' ), 'lang_id' ) );
				break;
			case 4 :
			case 5 :
			case 6 :
			case 7 :
				$tmp = strtolower ( $cs->RequestDataObj->getRequestDataEntry ( 'l' ) );
				$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Language selection says URL priority (Case=" . $scoreLang . "; " . $cs->RequestDataObj->getRequestDataEntry ( 'l' ) . "->" . $tmp . ")") );
				$CurrentSetObj->setDataEntry ( 'language', $tmp ); // URl/form asked, the king must be served!
				$CurrentSetObj->setDataEntry ( 'language_id', strtolower ( $cs->RequestDataObj->getRequestDataEntry ( 'l' ) ) );
				break;
		}

		$ClassLoaderObj->provisionClass ( 'I18n' );
		$I18nObj = I18n::getInstance ();
		$I18nObj->getI18nFromDB ();

		$cs->LMObj->restoreLastInternalLogTarget ();

		// --------------------------------------------------------------------------------------------
		//
		// Form Management for commandLine interface
		//
		//

		// Do we have a user submitting from the auth form ?
		if ($cs->RequestDataObj->getRequestDataSubEntry ( 'formGenericData', 'modification' ) == 'on' || $cs->RequestDataObj->getRequestDataSubEntry ( 'formGenericData', 'deletion' ) == 'on' && $UserObj->getUserEntry ( 'user_login' ) != 'anonymous') {
			$localisation = " (CLI)";
			$cs->MapperObj->AddAnotherLevel ( $localisation );
			$cs->LMObj->logCheckpoint ( "CLI" );
			$cs->MapperObj->RemoveThisLevel ( $localisation );
			$cs->MapperObj->setSqlApplicant ( "CLI" );

			$ClassLoaderObj->provisionClass ( 'FormToCommandLine' );
			$FormToCommandLineObj = FormToCommandLine::getInstance ();
			$FormToCommandLineObj->analysis ();

			$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : FormToCommandLineObj->getCommandLineNbr() =" . $FormToCommandLineObj->getCommandLineNbr ()) );

			if ($FormToCommandLineObj->getCommandLineNbr () > 0) {
				$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : A script is on the bench :") );
				$ClassLoaderObj->provisionClass ( 'CommandConsole' );

				$CurrentSetObj->setInstanceOfWebSiteContextObj ( $WebSiteObj ); // Set an initial website context.
				$CommandConsole = CommandConsole::getInstance ();

				$cs->CMObj->setConfigurationSubEntry ( 'commandLineEngine', 'state', 'enabled' ); // 20200205 - For now we only log the command line in the logs.
				                                                                                  // $CMObj->setConfigurationSubEntry('commandLineEngine', 'state', 'disabled'); // 20200205 - For now we only log the command line in the logs.
				$Script = $FormToCommandLineObj->getCommandLineScript ();
				switch ($cs->CMObj->getConfigurationSubEntry ( 'commandLineEngine', 'state' )) {
					case "enabled" :
						foreach ( $Script as $A ) {
							$CommandConsole->executeCommand ( $A );
						}
						break;
					case "disabled" :
					default :
						foreach ( $Script as $A ) {
							$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . $A) );
						}
						break;
				}
			}

			switch ($cs->RequestDataObj->getRequestDataSubEntry ( 'formGenericData', 'origin' ) . $cs->RequestDataObj->getRequestDataSubEntry ( 'formGenericData', 'section' )) {
				case "ModuleQuickSkin" :
					$UserObj->getUserDataFromDB ( $UserObj->getUserEntry ( 'user_login' ), $WebSiteObj ); // We need to reload the user data in order to update the current user_pref_theme variable.
					break;
				case "AdminDashboardWebsiteManagementP01" :
					// refresh with updated data
					$id = $WebSiteObj->getWebSiteEntry ( 'ws_id' );
					$WebSiteObj->getWebSiteDataFromDB ( $id );
					break;
			}
		}

		// --------------------------------------------------------------------------------------------
		//
		//
		// Start of the module display
		// The so called route is based on the arti_ref transmitted
		//
		$localisation = " (CurrentSet)";
		$cs->MapperObj->AddAnotherLevel ( $localisation );
		$cs->LMObj->logCheckpoint ( "Prepare CurrentSet" );
		$cs->MapperObj->RemoveThisLevel ( $localisation );
		$cs->MapperObj->setSqlApplicant ( "Prepare CurrentSet" );

		// --------------------------------------------------------------------------------------------
		// Checking the article call
		// If no article reference is given we take the first article of the current website.
		//
		if (strlen ( $cs->RequestDataObj->getRequestDataEntry ( 'arti_ref' ) ) == 0) {
			$dbquery = $cs->SDDMObj->query ( "
				SELECT cat.cate_id, cat.cate_name, cat.arti_ref
				FROM " . $SqlTableListObj->getSQLTableName ( 'category' ) . " cat, " . $SqlTableListObj->getSQLTableName ( 'deadline' ) . " bcl
				WHERE cat.ws_id = '" . $WebSiteObj->getWebSiteEntry ( 'ws_id' ) . "'
				AND cat.cate_lang = '" . $WebSiteObj->getWebSiteEntry ( 'ws_lang' ) . "'
				AND cat.deadline_id = bcl.deadline_id
				AND bcl.deadline_state = '1'
				AND cat.cate_type IN ('0','1')
				AND cat.group_id " . $UserObj->getUserEntry ( 'clause_in_group' ) . "
				AND cat.cate_state = '1'
				AND cate_initial_document = '1'
				ORDER BY cat.cate_parent,cat.cate_position
				;" );
			while ( $dbp = $cs->SDDMObj->fetch_array_sql ( $dbquery ) ) {
				$CurrentSetObj->setDataSubEntry ( 'article', 'arti_ref', $dbp ['arti_ref'] );
			}
			$CurrentSetObj->setDataSubEntry ( 'article', 'arti_page', 1 );
		} else {
			// Is the user can read this article ?
			$dbquery = $cs->SDDMObj->query ( "
				SELECT *
				FROM " . $SqlTableListObj->getSQLTableName ( 'category' ) . "
				WHERE ws_id IN ('1', '" . $WebSiteObj->getWebSiteEntry ( 'ws_id' ) . "')
				AND cate_lang = '" . $WebSiteObj->getWebSiteEntry ( 'ws_lang' ) . "'
				AND group_id " . $UserObj->getUserEntry ( 'clause_in_group' ) . "
				AND cate_state = '1'
				AND arti_ref = '" . $cs->RequestDataObj->getRequestDataEntry ( 'arti_ref' ) . "'
				;" );
			if ($cs->SDDMObj->num_row_sql ( $dbquery ) > 0) {
				$CurrentSetObj->setDataSubEntry ( 'article', 'arti_ref', $cs->RequestDataObj->getRequestDataEntry ( 'arti_ref' ) );
				$CurrentSetObj->setDataSubEntry ( 'article', 'arti_page', $cs->RequestDataObj->getRequestDataEntry ( 'arti_page' ) );
			} else {
				$CurrentSetObj->setDataSubEntry ( 'article', 'arti_ref', $CurrentSetObj->getDataEntry ( 'language' ) . '_article_not_found' );
				$cs->RequestDataObj->setRequestDataEntry ( 'arti_ref', $CurrentSetObj->getDataEntry ( 'language' ) . '_article_not_found' );
				$CurrentSetObj->setDataSubEntry ( 'article', 'arti_page', $cs->RequestDataObj->getRequestDataEntry ( 'arti_page' ) );
			}
		}

		// --------------------------------------------------------------------------------------------
		$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'post_hidden_ws', "<input type='hidden'	name='ws'			value='" . $WebSiteObj->getWebSiteEntry ( 'ws_id' ) . "'>\r" );
		$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'post_hidden_l', "<input type='hidden'	name='l'			value='" . $CurrentSetObj->getDataEntry ( 'language' ) . "'>\r" );
		$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'post_hidden_user_login', "<input type='hidden'	name='user_login'	value='" . $cs->SMObj->getSessionEntry ( 'user_login' ) . "'>\r" );
		$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'post_hidden_user_pass', "<input type='hidden'	name='user_pass'	value='" . $cs->SMObj->getSessionEntry ( 'user_password' ) . "'>\r" );
		$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'post_hidden_arti_ref', "<input type='hidden'	name='arti_ref'		value='" . $CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref' ) . "'>\r" );
		$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'post_hidden_arti_page', "<input type='hidden'	name='arti_page'	value='" . $CurrentSetObj->getDataSubEntry ( 'article', 'arti_page' ) . "'>\r" );

		$urlUsrPass = "";
		if ($cs->SMObj->getSessionEntry ( 'sessionMode' ) != 1) {
			$urlUsrPass = "&amp;user_login=" . $cs->SMObj->getSessionEntry ( 'user_login' );
		}
		$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'url_slup', "" ); // Site Lang User Pass
		$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'url_sldup', "&sw=" . $WebSiteObj->getWebSiteEntry ( 'ws_id' ) . "&l=" . $CurrentSetObj->getDataEntry ( 'language' ) . "&arti_ref=" . $CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref' ) . "&arti_page=" . $CurrentSetObj->getDataSubEntry ( 'article', 'arti_page' ) . $urlUsrPass ); // Site Lang Article User Pass
		$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'url_sdup', "&sw=" . $WebSiteObj->getWebSiteEntry ( 'ws_id' ) . "&arti_ref=" . $CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref' ) . "&arti_page=" . $CurrentSetObj->getDataSubEntry ( 'article', 'arti_page' ) . $urlUsrPass ); // Site Article User Pass

		// --------------------------------------------------------------------------------------------
		//
		// Prepare data for theme and layout
		//
		//
		$localisation = " (Theme&Layout)";
		$cs->MapperObj->AddAnotherLevel ( $localisation );
		$cs->LMObj->logCheckpoint ( "Prepare Theme & Layout" );
		$cs->MapperObj->RemoveThisLevel ( $localisation );
		$cs->MapperObj->setSqlApplicant ( "Prepare Theme & Layout" );

		// Those are ENTITY (DAO) classes, they're not UTILITY classes.
		$ClassLoaderObj->provisionClass ( 'Deco10_Menu' );
		$ClassLoaderObj->provisionClass ( 'Deco20_Caligraph' );
		$ClassLoaderObj->provisionClass ( 'Deco30_1Div' );
		$ClassLoaderObj->provisionClass ( 'Deco40_Elegance' );
		$ClassLoaderObj->provisionClass ( 'Deco50_Exquisite' );
		$ClassLoaderObj->provisionClass ( 'Deco60_Elysion' );
		$ClassLoaderObj->provisionClass ( 'ThemeDescriptor' );

		$CurrentSetObj->setInstanceOfThemeDescriptorObj ( new ThemeDescriptor () );
		$ThemeDescriptorObj = $CurrentSetObj->getInstanceOfThemeDescriptorObj ();

		$ThemeDescriptorObj->getThemeDescriptorDataFromDB ( "mt_", $UserObj, $WebSiteObj );

		$ClassLoaderObj->provisionClass ( 'ThemeData' );
		$CurrentSetObj->setInstanceOfThemeDataObj ( new ThemeData () );
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj ();
		$ThemeDataObj->setThemeData ( $ThemeDescriptorObj->getThemeDescriptor () ); // Better to give an array than the object itself.
		$ThemeDataObj->setThemeName ( 'mt_' );
		$ThemeDataObj->setDecorationListFromDB ();
		$ThemeDataObj->renderBlockData ();

		// --------------------------------------------------------------------------------------------
		//
		// JavaScript Object
		//
		//
		$localisation = " (JavaScript)";
		$cs->MapperObj->AddAnotherLevel ( $localisation );
		$cs->LMObj->logCheckpoint ( "Prepare JavaScript Object" );
		$cs->MapperObj->RemoveThisLevel ( $localisation );
		$cs->MapperObj->setSqlApplicant ( "Prepare JavaScript Object" );

		$ClassLoaderObj->provisionClass ( 'GeneratedJavaScript' );
		$CurrentSetObj->setInstanceOfGeneratedJavaScriptObj ( new GeneratedJavaScript () );
		$GeneratedJavaScriptObj = $CurrentSetObj->getInstanceOfGeneratedJavaScriptObj ();
		$GeneratedJavaScriptObj->insertJavaScript ( 'File', 'engine/javascript/lib_HydrCore.js' );
		// $GeneratedJavaScriptObj->insertJavaScript('File', 'engine/javascript_lib_calculs_decoration.js');
		$GeneratedJavaScriptObj->insertJavaScript ( 'Onload', "\telm.Gebi('HydrBody').style.visibility = 'visible';" );

		// --------------------------------------------------------------------------------------------
		//
		// Affichage
		//
		//
		$localisation = " / Modules";
		$cs->MapperObj->AddAnotherLevel ( $localisation );
		$cs->LMObj->logCheckpoint ( "Module Processing" );
		$cs->MapperObj->RemoveThisLevel ( $localisation );
		$cs->MapperObj->setSqlApplicant ( "Module Processing" );

		$ClassLoaderObj->provisionClass ( 'InteractiveElements' ); // Responsible for rendering buttons
		$ClassLoaderObj->provisionClass ( 'RenderLayout' );

		$RenderLayoutObj = RenderLayout::getInstance ();
		$RenderLayoutObj->render ( $UserObj, $WebSiteObj, $ThemeDescriptorObj );

		// --------------------------------------------------------------------------------------------
		// StyleSheet

		$ClassLoaderObj->provisionClass ( 'RenderStylesheet' );
		$RenderStylesheetObj = RenderStylesheet::getInstance ();
		$stylesheet = $RenderStylesheetObj->render ( "mt_", $ThemeDataObj );

		$Content .= "<!DOCTYPE html>\r";
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
					<title>" . $WebSiteObj->getWebSiteEntry ( 'ws_title' ) . "</title>\r
				";
				break;
		}
		$Content .= "<body id='HydrBody' ";
		if (strlen ( $ThemeDataObj->getThemeBlockEntry ( 'B01T', 'txt_col' ) ) > 0) {
			$html_body .= "text='" . $ThemeDataObj->getThemeBlockEntry ( 'B01T', 'txt_col' ) . "' link='" . ${$theme_tableau} ['B01T'] ['txt_col'] . "' vlink='" . ${$theme_tableau} ['B01T'] ['txt_col'] . "' alink='" . $ThemeDataObj->getThemeBlockEntry ( 'B01T', 'txt_col' ) . "' ";
		}
		$Content .= "style='";
		if (strlen ( $ThemeDataObj->getThemeDataEntry ( 'theme_bg' ) ) > 0) {
			$Content .= "background-image: url(../gfx/" . $ThemeDataObj->getThemeDataEntry ( 'theme_directory' ) . "/" . $ThemeDataObj->getThemeDataEntry ( 'theme_bg' ) . "); background-repeat: " . $ThemeDataObj->getThemeDataEntry ( 'theme_bg_repeat' ) . "; ";
		}
		if (strlen ( $ThemeDataObj->getThemeDataEntry ( 'theme_bg_color' ) ) > 0) {
			$Content .= "background-color: #" . $ThemeDataObj->getThemeDataEntry ( 'theme_bg_color' ) . ";";
		}
		$Content .= " visibility: hidden;'>\r ";

		// --------------------------------------------------------------------------------------------
		//
		// Modules
		//
		//
		$ClassLoaderObj->provisionClass ( 'RenderModule' );
		$RenderModuleObj = RenderModule::getInstance ();
		$directives = array (
				'mode' => 1,
				'affiche_module_mode' => "normal",
				'module_z_index' => 0
		);
		$Content .= $RenderModuleObj->render ( $directives );

		// --------------------------------------------------------------------------------------------
		//
		// Checkpoint ("index_before_stat");
		//
		//
		$localisation = " (Stats)";
		$cs->MapperObj->AddAnotherLevel ( $localisation );
		$cs->LMObj->logCheckpoint ( "Stats" );
		$cs->MapperObj->RemoveThisLevel ( $localisation );
		$cs->MapperObj->setSqlApplicant ( "Stats" );

		$cs->LMObj->logCheckpoint ( "index_before_stat" );
		$cs->MapperObj->RemoveThisLevel ( "/ idx" );
		$CurrentSetObj->setDataSubEntry ( 'timeStat', 'end', $cs->TimeObj->microtime_chrono () ); // We get time for later use in the stats.

		$cs->LMObj->setStoreStatisticsStateOff ();
		// --------------------------------------------------------------------------------------------
		$ClassLoaderObj->provisionClass ( 'RenderAdmDashboard' );
		$RenderAdmDashboardObj = RenderAdmDashboard::getInstance ();
		$Content .= $RenderAdmDashboardObj->render ();

		// --------------------------------------------------------------------------------------------
		// creating file selector if necessary
		// $module_z_index['compteur'] = 500; //bypass Z-index from layout
		// $pv['sdftotal'] = $_REQUEST['FS_index'];

		$sdftotal = $CurrentSetObj->getDataEntry ( 'fsIdx' );
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
			$GeneratedJavaScriptObj->insertJavaScript ( 'Data', $str );
		}

		// --------------------------------------------------------------------------------------------
		//
		// Rendering of the JavaScript
		//
		//
		// --------------------------------------------------------------------------------------------
		$GeneratedJavaScriptObj->insertJavaScript ( 'Onload', "console.log ( TabInfoModule );" );

		$JavaScriptContent = "<!-- JavaScript -->\r\r";
		$JavaScriptContent .= $GeneratedJavaScriptObj->renderJavaScriptDecoratedMode ( "File", "<script type='text/javascript' src='", "'></script>\r" );
		$JavaScriptContent .= "<script type='text/javascript'>\r";

		$JavaScriptContent .= "// ----------------------------------------\r//\r// Data segment\r//\r//\r";
		$JavaScriptContent .= $GeneratedJavaScriptObj->renderJavaScriptCrudeMode ( "Data" );
		$JavaScriptContent .= "// ----------------------------------------\r//\r// Init segment\r//\r//\r";
		$JavaScriptContent .= $GeneratedJavaScriptObj->renderJavaScriptCrudeMode ( "Init" );
		$JavaScriptContent .= "// ----------------------------------------\r//\r// Command segment\r//\r//\r";
		$JavaScriptContent .= $GeneratedJavaScriptObj->renderJavaScriptCrudeMode ( "Command" );
		$JavaScriptContent .= "// ----------------------------------------\r//\r// Onload segment\r//\r//\r";
		$JavaScriptContent .= "function WindowOnload () {\r";
		$JavaScriptContent .= $GeneratedJavaScriptObj->renderJavaScriptCrudeMode ( "Onload" );
		$JavaScriptContent .= "
			}\r
			window.onload = WindowOnload;\r\r
			</script>\r";

		$licence = "
			<!--
			Author : FMA - 2005 ~ " . date ( "Y", time () ) . "
			Licence : Creative commons CC-by-nc-sa (http://www.creativecommons.org/)
			-->
			";

		$cs->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : \$_SESSION :" . $cs->StringFormatObj->arrayToString ( $_SESSION )) );

		// --------------------------------------------------------------------------------------------
		$cs->SDDMObj->disconnect_sql ();
		session_write_close ();

		return ($Content . $JavaScriptContent . $licence . "</body>\r</html>\r");
	}
}

?>
