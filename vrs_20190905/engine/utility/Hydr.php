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
	private $authentificationMode;
	private $authentificationAction;
	private $SqlTableListObj;
	private $GeneratedScript;
	private $ThemeDataObj;
	private $WebSiteObj;

	private function __construct() {}
	
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
		// error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );
		// error_reporting ( E_ALL ^ E_NOTICE );
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
		// CurrentSet
		//
		$ClassLoaderObj->provisionClass( 'ServerInfos' );
		$ClassLoaderObj->provisionClass( 'CurrentSet' );
		$CurrentSetObj = CurrentSet::getInstance();
		$CurrentSetObj->setInstanceOfServerInfosObj( new ServerInfos() );
		$CurrentSetObj->getInstanceOfServerInfosObj()->getInfosFromServer();
		$CurrentSetObj->setDataEntry( 'fsIdx', 0 );		// Useful for FileSelector
		// --------------------------------------------------------------------------------------------
		// Session management
		//
		$CurrentSetObj->setDataEntry ( 'sessionName', 'HydrWebsiteSessionId' );
		$bts->initSmObj();
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . $bts->SMObj->getInfoSessionState()));
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : \$_SESSION :" . $bts->StringFormatObj->arrayToString ( $_SESSION ) . " *** \$bts->SMObj->getSession() = " . $bts->StringFormatObj->arrayToString ( $bts->SMObj->getSession () ) . " *** EOL") );
		
		// Scoring on what we recieved (or what's at disposal)
		$this->prepareAuthProcess();

		// Loading the configuration file associated with this website
		$this->loadConfigFile();

		// Creating the necessary arrays for Sql Db Dialog Management
		if ( $this->initializeSDDM() == true ) {
			$bts->CMObj->PopulateLanguageList (); // Not before we have access to the DB. Better isn't it?
			
			$this->initializeWebsite();

			// Authentification
			$this->authentificationCheck();

			// Language selection
			$this->languageSelection();
	
			// Form Management for commandLine interface
			// Do we have a user submitting from the auth form ?
			// if ($bts->RequestDataObj->getRequestDataSubEntry ( 'formGenericData', 'modification' ) == 'on' || $bts->RequestDataObj->getRequestDataSubEntry ( 'formGenericData', 'deletion' ) == 'on' && $UserObj->getUserEntry ( 'user_login' ) != 'anonymous') {
			if (
					$bts->RequestDataObj->getRequestDataEntry ( 'formSubmitted' ) == 1 && 
					$CurrentSetObj->getInstanceOfUserObj()->getUserEntry ( 'user_login' ) != 'anonymous') 
			{ $this->formManagement();	}
			
			// Router : What was called ? (slug/form etc..) and storing information in the session
			$bts->Router->manageNavigation();
			
			// Article
			$this->initializeArticle();
			
			// --------------------------------------------------------------------------------------------
			$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'post_hidden_ws', "<input type='hidden'	name='ws'					value='" . $this->WebSiteObj->getWebSiteEntry ( 'ws_short' ) . "'>\r" );
			$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'post_hidden_l', "<input type='hidden'	name='l'					value='" . $CurrentSetObj->getDataEntry ( 'language' ) . "'>\r" );
			$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'post_hidden_user_login', "<input type='hidden'	name='user_login'	value='" . $bts->SMObj->getSessionEntry ( 'user_login' ) . "'>\r" );
			$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'post_hidden_user_pass', "<input type='hidden'	name='user_pass'	value='" . $bts->SMObj->getSessionEntry ( 'user_password' ) . "'>\r" );
			$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'post_hidden_arti_ref', "<input type='hidden'	name='arti_ref'		value='" . $CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref' ) . "'>\r" );
			$CurrentSetObj->setDataSubEntry ( 'block_HTML', 'post_hidden_arti_page', "<input type='hidden'	name='arti_page'	value='" . $CurrentSetObj->getDataSubEntry ( 'article', 'arti_page' ) . "'>\r" );
			
			$urlUsrPass = "";
			if ($bts->SMObj->getSessionEntry ( 'sessionMode' ) != 1) {
				$urlUsrPass = "&amp;user_login=" . $bts->SMObj->getSessionEntry ( 'user_login' );
			}
			// $CurrentSetObj->setDataSubEntry ( 'block_HTML', 'url_slup', "" ); // Site Lang User Pass
			// $CurrentSetObj->setDataSubEntry ( 'block_HTML', 'url_sldup', "&sw=" . $this->WebSiteObj->getWebSiteEntry ( 'ws_id' ) . "&l=" . $CurrentSetObj->getDataEntry ( 'language' ) . "&arti_ref=" . $CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref' ) . "&arti_page=" . $CurrentSetObj->getDataSubEntry ( 'article', 'arti_page' ) . $urlUsrPass ); // Site Lang Article User Pass
			// $CurrentSetObj->setDataSubEntry ( 'block_HTML', 'url_sdup', "&sw=" . $this->WebSiteObj->getWebSiteEntry ( 'ws_id' ) . "&arti_ref=" . $CurrentSetObj->getDataSubEntry ( 'article', 'arti_ref' ) . "&arti_page=" . $CurrentSetObj->getDataSubEntry ( 'article', 'arti_page' ) . $urlUsrPass ); // Site Article User Pass
			
			// JavaScript Object
			$this->initializeJavascript();
			
			// theme and layout
			$this->initializeTheme();
			// Initialize Layout
			$this->initializeLayout();
			
			// --------------------------------------------------------------------------------------------
			//
			// Module 
			//
			//
			$localisation = " / Modules";
			$bts->MapperObj->AddAnotherLevel ( $localisation );
			$bts->LMObj->logCheckpoint ( "Module Processing" );
			$bts->MapperObj->RemoveThisLevel ( $localisation );
			$bts->MapperObj->setSqlApplicant ( "Module Processing" );
			
			$ClassLoaderObj->provisionClass ( 'InteractiveElements' ); // Responsible for rendering buttons
			
			// StyleSheet
			$this->renderStylsheet();
			// Build document
			$Content = $this->buildDocument();
			// Checkpoint ("index_before_stat");
			$Content .= $this->buidAdminDashboard();	
			// File selector if necessary
			$Content .= $this->buildFileSelector();
			
			// --------------------------------------------------------------------------------------------
			// Rendering of the CSS
			//
			// --------------------------------------------------------------------------------------------
			$CssContent  ="<!-- Extra CSS -->\r";
			$CssContent .= $this->GeneratedScript->renderScriptFileWithBaseURL ( "Css-File", "<link rel='stylesheet' href='", "'>\r" );
	
			// --------------------------------------------------------------------------------------------
			// Rendering of the JavaScript
			//
			// --------------------------------------------------------------------------------------------
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : About to render javascript"));
			$this->GeneratedScript->insertString('JavaScript-OnLoad', "\tconsole.log ( TabInfoModule );" );
			$this->GeneratedScript->insertString('JavaScript-OnLoad', "\telm.Gebi('HydrBody').style.visibility = 'visible';" );
			$this->GeneratedScript->insertString('JavaScript-File', 'current/engine/javascript/lib_DecorationManagement.js' );
			$this->GeneratedScript->insertString('JavaScript-Init', 'var dm = new DecorationManagement();');
	
			$JavaScriptContent = "<!-- JavaScript -->\r\r";
			$JavaScriptContent .= $this->GeneratedScript->renderScriptFileWithBaseURL ( "JavaScript-File", "<script type='text/javascript' src='", "'></script>\r" );
			$JavaScriptContent .= $this->GeneratedScript->renderExternalRessourceScript ( "JavaScript-ExternalRessource", "<script type='text/javascript' src='", "'></script>\r" );
			$JavaScriptContent .= "<script type='text/javascript'>\r";
			
			$JavaScriptContent .= "// ----------------------------------------\r//\r// Data segment\r//\r//\r";
			$JavaScriptContent .= $this->GeneratedScript->renderScriptCrudeMode ( "JavaScript-Data" );
			$JavaScriptContent .= "// ----------------------------------------\r//\r// Data (Flexible) \r//\r//\r";
			$JavaScriptContent .= $this->GeneratedScript->renderJavaScriptObjects();
			$JavaScriptContent .= "// ----------------------------------------\r//\r// Init segment\r//\r//\r";
			$JavaScriptContent .= $this->GeneratedScript->renderScriptCrudeMode ( "JavaScript-Init" );
			$JavaScriptContent .= "// ----------------------------------------\r//\r// Command segment\r//\r//\r";
			$JavaScriptContent .= $this->GeneratedScript->renderScriptCrudeMode ( "JavaScript-Command" );
			$JavaScriptContent .= "// ----------------------------------------\r//\r// OnLoad segment\r//\r//\r";
			$JavaScriptContent .= "function WindowOnResize (){\r";
			$JavaScriptContent .= $this->GeneratedScript->renderScriptCrudeMode ( "JavaScript-OnResize" );
			$JavaScriptContent .= "}\r";
			$JavaScriptContent .= "function WindowOnLoad () {\r";
			$JavaScriptContent .= $this->GeneratedScript->renderScriptCrudeMode ( "JavaScript-OnLoad" );
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
	
			$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT,	'msg' => __METHOD__ ." : Test logging with levels (Between parenthesis) `Citation` array( \$PhpVariable ) \$Php_Variable array([module_id]=`5387701299386917658`, [index]=`1`, [index]=`1`) ." ));
			$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_BREAKPOINT,	'msg' => __METHOD__ ." : Test logging with levels (Between parenthesis) `Citation` array( \$PhpVariable ) \$Php_Variable array([module_id]=`5387701299386917658`, [index]=`1`, [index]=`1`) ." ));
			$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_INFORMATION,	'msg' => __METHOD__ ." : Test logging with levels (Between parenthesis) `Citation` array( \$PhpVariable ) \$Php_Variable array([module_id]=`5387701299386917658`, [index]=`1`, [index]=`1`) ." ));
			$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_WARNING,		'msg' => __METHOD__ ." : Test logging with levels (Between parenthesis) `Citation` array( \$PhpVariable ) \$Php_Variable array([module_id]=`5387701299386917658`, [index]=`1`, [index]=`1`) ." ));
			$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_ERROR,		'msg' => __METHOD__ ." : Test logging with levels (Between parenthesis) `Citation` array( \$PhpVariable ) \$Php_Variable array([module_id]=`5387701299386917658`, [index]=`1`, [index]=`1`) ." ));
	
			// --------------------------------------------------------------------------------------------
			$bts->SDDMObj->disconnect_sql ();
			return ($Content . $CssContent . $JavaScriptContent . $licence . "</body>\r</html>\r");
				
		}

	}

	/**
	 * 
	 */
	private function prepareAuthProcess(){
		$bts = BaseToolSet::getInstance();

		$localisation = " / prepareAuthProcess";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "prepareAuthProcess" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "prepareAuthProcess" );
		
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
		$this->authentificationMode = "session";
		$this->authentificationAction = USER_ACTION_SIGN_IN;
		
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
				$this->authentificationMode = "form";
				break;
			case 8 :
			case 9 :
			case 10 :
			case 11 :
			case 12 :
			case 13 :
			case 14 :
			case 15 :
				$this->authentificationMode = "form";
				$this->authentificationAction = USER_ACTION_DISCONNECT;
				break;
		}
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . $bts->SMObj->getInfoSessionState(). ", \$this->authentificationMode=".$this->authentificationMode."; \$this->authentificationAction=".$this->authentificationAction));
	}
	
	/**
	 * Load the config file
	 */
	private function loadConfigFile(){
		$bts = BaseToolSet::getInstance();

		$localisation = " loadConfigFile";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "loadConfigFile" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "loadConfigFile" );

		// A this point we have a ws in the session so we don't use the URI parameter anymore.
		$bts->CMObj->LoadConfigFile ();
		$bts->CMObj->setConfigurationEntry ( 'execution_context', "render" );
		$bts->LMObj->setDebugLogEcho ( 0 );
	}

	/**
	 * Initializes the necessary sql connexion assets
	 */
	private function initializeSDDM() {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance ();

		$localisation = " initializeSDDM";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "initializeSDDM" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "initializeSDDM" );

		
		$ClassLoaderObj->provisionClass ( 'SqlTableList' );
		$CurrentSetObj->setInstanceOfSqlTableListObj ( SqlTableList::getInstance ( $bts->CMObj->getConfigurationEntry ( 'dbprefix' ), $bts->CMObj->getConfigurationEntry ( 'tabprefix' ) ) );
		$this->SqlTableListObj = $CurrentSetObj->getInstanceOfSqlTableListObj ();
	
		// --------------------------------------------------------------------------------------------
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
			return (false);
		}
		return (true);

	}
	
	/**
	 * Initializes the wesite instance and load data
	 */
	private function initializeWebsite(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance ();

		$localisation = " initializeWebsite";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "initializeWebsite" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "initializeWebsite" );
		
		$ClassLoaderObj->provisionClass ( 'WebSite' );
		$CurrentSetObj->setInstanceOfWebSiteObj ( new WebSite () );
		$this->WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj ();
		$this->WebSiteObj->getDataFromDBUsingShort();
		
		switch ($this->WebSiteObj->getWebSiteEntry ( 'ws_state' )) {
			case 0 : // Offline
			case 3 : // Maintenance
			case 99 : // Verouillé
				$this->WebSiteObj->setWebSiteEntry ( 'banner_offline', 1 );
				include ("modules/initial/OfflineMessage/OfflineMessage.php");
				break;
		}
		$bts->CMObj->setLangSupport (); // will set support=1 in the languagelist if website supports the language.
	}

	/**
	 * Authentification
	 */
	private function authentificationCheck(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance ();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj ();

		$localisation = " authentificationCheck";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "authentificationCheck" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "authentificationCheck" );
		
		$ClassLoaderObj->provisionClass ( 'AuthenticateUser' );
		$ClassLoaderObj->provisionClass ( 'User' );
		
		$CurrentSetObj->setInstanceOfUserObj ( new User () );
		$UserObj = $CurrentSetObj->getInstanceOfUserObj ();
		
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : \$WebSiteObj" . $bts->StringFormatObj->arrayToString($WebSiteObj->getWebSite())) );
		
		// 		We have 2 variables used to drive the authentification process.
		switch ($this->authentificationMode) {
			case "form" :
				$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : Authentification with form mode") );
				switch ($this->authentificationAction) {
					case USER_ACTION_DISCONNECT :
						$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : disconnect submitted") );
						 $bts->SMObj->InitializeSession();
						$userName = ANONYMOUS_USER_NAME;
						break;
					case USER_ACTION_SIGN_IN :
						$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : Connection attempt") );
						$userName = $bts->RequestDataObj->getRequestDataSubEntry ( 'authentificationForm', 'user_login' );
						break;
				}
				$bts->SMObj->InitializeSession(); // If a login comes from a form. The session object must be reset!
				$UserObj->getDataFromDB ( $userName, $WebSiteObj );
				$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : user_login=" . $UserObj->getUserEntry ( 'user_login' )) );
				$bts->AUObj->checkUserCredential ( $UserObj, 'form' );
				$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : Connection attempt end") );
				break;
			case "session" :
				$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : Authentification with session mode. user_login='" . $bts->SMObj->getSessionEntry ( 'user_login' ) . "'") );
				
		// 		Assuming a session is valid (whatever it's 'anonymous' or someone else).
				if (strlen ( $bts->SMObj->getSessionEntry ( 'user_login' ) ) == 0) {
					$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : \$_SESSION strlen(user_login)=0") );
				}
				$UserObj->getDataFromDB ( $bts->SMObj->getSessionEntry ( 'user_login' ), $WebSiteObj );
				if ($UserObj->getUserEntry ( 'error_login_not_found' ) != 1) {
					$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : session mode : " . $bts->StringFormatObj->arrayToString ( $bts->SMObj->getSession () )) );
					$bts->AUObj->checkUserCredential ( $UserObj, 'session' );
				} else {
		// 			No form then no user found it's defintely an anonymous user
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
		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : checkUserCredential end") );

	}		

	/**
	 * Sets the language for the page. It chooses by priority.
	 * 
	 */
	private function languageSelection(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance ();
		$UserObj = $CurrentSetObj->getInstanceOfUserObj ();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj ();

		$localisation = " languageSelection";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "languageSelection" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "languageSelection" );

		$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : Language selection start") );
		$scoreLang = 0;
		
		if (strlen ( $bts->RequestDataObj->getRequestDataEntry ( 'l' ) ) != 0 && $bts->RequestDataObj->getRequestDataEntry ( 'l' ) != 0) {
			$scoreLang += 4;
		}
		if (strlen ( $UserObj->getUserEntry ( 'user_lang' ) ) != 0 ) {
			$scoreLang += 2;
		}
		if (strlen ( $WebSiteObj->getWebSiteEntry ( 'fk_lang_id' ) ) != 0 && $WebSiteObj->getWebSiteEntry ( 'fk_lang_id' ) != 0) {
			$scoreLang += 1;
		}
		
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
		
	}

	/**
	 * 
	 */
	private function formManagement() {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance ();
		$UserObj = $CurrentSetObj->getInstanceOfUserObj ();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj ();

		$localisation = " formManagement";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "formManagement" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "formManagement" );
		
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
						// We have to reload website and user in case of one of them was updated was updated.
						$WebSiteObj->getDataFromDBUsingShort();
						$UserObj->getDataFromDB ( $bts->SMObj->getSessionEntry ( 'user_login' ), $WebSiteObj );
						$this->languageSelection();
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

	/**
	 * Initialize Article
	 */
	private function initializeArticle(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance ();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj ();
		$UserObj = $CurrentSetObj->getInstanceOfUserObj ();

		$localisation = " initializeArticle";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "initializeArticle" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "initializeArticle" );
		
		if (strlen ( $bts->SMObj->getSessionSubEntry('currentRoute', 'target') ) == 0) {
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : There is no viable route in the session. Back to home."));
			$sqlQuery = "
				SELECT mnu.menu_id, mnu.menu_name, mnu.fk_arti_ref
				FROM " . $this->SqlTableListObj->getSQLTableName ( 'menu' ) . " mnu, " . $this->SqlTableListObj->getSQLTableName ( 'deadline' ) . " bcl
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
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." `". $bts->StringFormatObj->formatToLog($sqlQuery)."`."));
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
					SELECT * FROM ". $this->SqlTableListObj->getSQLTableName ( 'article' ) . " art
					WHERE art.arti_slug = '".$bts->SMObj->getSessionSubEntry('currentRoute', 'target')."'
					AND art.arti_page = '1';
					;";
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." `". $bts->StringFormatObj->formatToLog($sqlQuery)."`."));
				$dbquery = $bts->SDDMObj->query ($sqlQuery);
			}
			else {
				// Normal case
				$sqlQuery = "
					SELECT * 
					FROM " 
					. $this->SqlTableListObj->getSQLTableName ( 'menu' ) . " mnu, " 
					. $this->SqlTableListObj->getSQLTableName ( 'article' ) . " art
					WHERE mnu.fk_ws_id IN ('" . $WebSiteObj->getWebSiteEntry ('ws_id') . "')
					AND mnu.fk_lang_id = '" . $CurrentSetObj->getDataEntry ( 'language_id') . "' 
					AND mnu.fk_perm_id " . $UserObj->getUserEntry ('clause_in_perm') . " 
					AND mnu.menu_state = '1'
					AND mnu.fk_arti_ref = art.arti_ref
					AND art.arti_slug = '".$bts->SMObj->getSessionSubEntry('currentRoute', 'target')."'
					AND art.arti_page = '".$bts->SMObj->getSessionSubEntry('currentRoute', 'page')."';
					;";
				$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " `".$bts->StringFormatObj->formatToLog($sqlQuery)."`."));
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
				$CurrentSetObj->setDataSubEntry ( 'article', 'menu_id', "" );
				$CurrentSetObj->setDataSubEntry ( 'article', 'arti_id', "" );
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

	}

	/**
	 * Initializes Javascript
	 */
	private function initializeJavascript() {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance ();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj ();

		$localisation = " initializeJavascript";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "initializeJavascript" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "initializeJavascript" );
		
		$ClassLoaderObj->provisionClass ( 'GeneratedScript' );
		$CurrentSetObj->setInstanceOfGeneratedScriptObj ( new GeneratedScript () );
		$this->GeneratedScript = $CurrentSetObj->getInstanceOfGeneratedScriptObj();
		$this->GeneratedScript->insertString('JavaScript-File', 'current/engine/javascript/lib_HydrCore.js' );
		
		// $this->GeneratedScript->insertString('JavaScript-File', 'current/engine/javascript_lib_calculs_decoration.js');
		// We got the route definition in the $CurrentSet and the session.
		// Inserting the URL in the browser bar.
		$urlBar = $CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url'). $CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug')."/".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_page')."/";
		$this->GeneratedScript->insertString('JavaScript-OnLoad', "	window.history.pushState( null , '".$WebSiteObj->getWebSiteEntry ( 'ws_title' )."', '".$urlBar."');" );
		$this->GeneratedScript->insertString('JavaScript-OnLoad', "	document.title = '".$WebSiteObj->getWebSiteEntry ( 'ws_title' )." - ".$CurrentSetObj->getDataSubEntry ( 'article', 'arti_slug')."';");
		
		$this->GeneratedScript->insertString('JavaScript-OnResize', "\telm.UpdateWindowSize ('');");
	}

	/**
	 * initialize Theme
	 */
	private function initializeTheme() {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance ();

		$localisation = " initializeTheme";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "initializeTheme" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "initializeTheme" );
		
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
		$this->ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj ();
		$this->ThemeDataObj->setThemeData ( $ThemeDescriptorObj->getThemeDescriptor () ); // Better to give an array than the object itself.
		$this->ThemeDataObj->setThemeName ( $ThemeDescriptorObj->getCssPrefix() );
		$this->ThemeDataObj->setDecorationListFromDB ();
		$this->ThemeDataObj->renderBlockData ();
	}

	/**
	 * Initialize Layout
	 */
	private function initializeLayout(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance ();

		$localisation = " initializeLayout";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "initializeLayout" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "initializeLayout" );

		$ClassLoaderObj->provisionClass ('ModuleList');
		$CurrentSetObj->setInstanceOfModuleListObj(new ModuleList());
		$ModuleLisObj = $CurrentSetObj->getInstanceOfModuleListObj();
		$ModuleLisObj->makeModuleList();
		
		$ClassLoaderObj->provisionClass ('LayoutProcessor');
		$LayoutProcessorObj = LayoutProcessor::getInstance();
		$ClassLoaderObj->provisionClass ( 'RenderModule' );
		$RenderModuleObj = RenderModule::getInstance ();
		
		$this->ContentFragments = $LayoutProcessorObj->render();
		
		$LayoutCommands = array(
			0 => array( "regex"	=> "/{{\s*get_header\s*\(\s*\)\s*}}/", "command"	=> 'get_header'),
			1 => array( "regex"	=> "/{{\s*render_module\s*\(\s*('|\"|`)\w*('|\"|`)\s*\)\s*}}/", "command"	=> 'render_module'),
		);
		
		// We know there's only one command per entry
		$insertJavascriptDecorationMgmt = false;
		foreach ( $this->ContentFragments as &$A ) {
			foreach ( $LayoutCommands as $B) {
				if ( $A['type'] == "command" && preg_match($B['regex'],$A['data'],$match) === 1 ) {
					// We got the match so it's...
					switch ($B['command']) {
						case "get_header":
							break;
						case "render_module":
							// Module it is.
							if ( $insertJavascriptDecorationMgmt == false) {
								$this->GeneratedScript->insertString('JavaScript-OnLoad', "\tdm.UpdateAllDecoModule(TabInfoModule);" );
								$this->GeneratedScript->insertString('JavaScript-OnResize', "\tdm.UpdateAllDecoModule(TabInfoModule);");
								$this->GeneratedScript->insertString("JavaScript-Data", "var TabInfoModule = new Array();\r");
								$insertJavascriptDecorationMgmt = true;
							}
							$bts->LMObj->InternalLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : `". $A['type'] ."`; for `". $A['module_name'] ."` and data ". $A['data'] ) );
							$A['content'] = $RenderModuleObj->render($A['module_name']);
							break;
					}
				}
			}
		}

	}

	/**
	 * 
	 */
	private function renderStylsheet() {
		$bts = BaseToolSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance ();
		$ClassLoaderObj->provisionClass ( 'RenderStylesheet' );

		$localisation = " renderStylsheet";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "renderStylsheet" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "renderStylsheet" );

		$RenderStylesheetObj = RenderStylesheet::getInstance ();
		$this->stylesheet = $RenderStylesheetObj->render ( "mt_", $this->ThemeDataObj );
	}

	/**
	 * Builds the main document
	 * @return string
	 */
	private function buildDocument() {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$localisation = " buildDocument";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "buildDocument" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "buildDocument" );

		$Content = "<!DOCTYPE html>\r<html>";
		switch ($this->WebSiteObj->getWebSiteEntry ( 'ws_stylesheet' )) {
			case 1 : // dynamic
				$Content .= "
				<head>\r
				<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>\r
				<title>" . $this->WebSiteObj->getWebSiteEntry ( 'ws_title' ) . "</title>\r
			";
				$Content .= $this->stylesheet . "</head>\r";
				unset ( $this->stylesheet );
				break;
			case 0 : // statique
				$Content .= "
					<head>\r
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>\r
					<link rel='stylesheet' href='".$CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url')."stylesheets/".$this->ThemeDataObj->getThemeDataEntry('theme_stylesheet_1')."'>
					</head>\r
					";
				break;
		}
		$Content .= "<body id='HydrBody' ";
		$Content .= "style='";

		if (strlen ( $this->ThemeDataObj->getThemeDataEntry ( 'theme_width' ) ) > 0)		{ $Content .= "width:".			$this->ThemeDataObj->getThemeDataEntry ( 'theme_width' ) . "; "; }
		if (strlen ( $this->ThemeDataObj->getThemeDataEntry ( 'theme_heigth' ) ) > 0)		{ $Content .= "height:".		$this->ThemeDataObj->getThemeDataEntry ( 'theme_height' ) . "; "; }
		if (strlen ( $this->ThemeDataObj->getThemeDataEntry ( 'theme_min_width' ) ) > 0)	{ $Content .= "min-width:".		$this->ThemeDataObj->getThemeDataEntry ( 'theme_min_width' ) . "; "; }
		if (strlen ( $this->ThemeDataObj->getThemeDataEntry ( 'theme_min_height' ) ) > 0)	{ $Content .= "min-height:".	$this->ThemeDataObj->getThemeDataEntry ( 'theme_min_height' ) . "; "; }
		if (strlen ( $this->ThemeDataObj->getThemeDataEntry ( 'theme_max_width' ) ) > 0)	{ $Content .= "max-width:".		$this->ThemeDataObj->getThemeDataEntry ( 'theme_max_width' ) . "; "; }
		if (strlen ( $this->ThemeDataObj->getThemeDataEntry ( 'theme_max_height' ) ) > 0)	{ $Content .= "max-height:".	$this->ThemeDataObj->getThemeDataEntry ( 'theme_max_height' ) . "; "; }

		if (strlen ( $this->ThemeDataObj->getThemeDataEntry ( 'theme_bg' ) ) > 0) {
			$Content .= "background-image: url("
			.$CurrentSetObj->getInstanceOfServerInfosObj()->getServerInfosEntry('base_url')
			."media/theme/" . $this->ThemeDataObj->getThemeDataEntry ( 'theme_directory' ) . "/" . $this->ThemeDataObj->getThemeDataEntry ( 'theme_bg' ) . "); ";
		}

		if (strlen ( $this->ThemeDataObj->getThemeDataEntry ( 'theme_bg_position' ) ) > 0)	{ $Content .= "background-position:".	$this->ThemeDataObj->getThemeDataEntry ( 'theme_bg_position' ) . "; "; }
		if (strlen ( $this->ThemeDataObj->getThemeDataEntry ( 'theme_bg_repeat' ) ) > 0)	{ $Content .= "background-repeat:".		$this->ThemeDataObj->getThemeDataEntry ( 'theme_bg_repeat' ) . "; "; }
		if (strlen ( $this->ThemeDataObj->getThemeDataEntry ( 'theme_bg_color' ) ) > 0)		{ $Content .= "background-color:#".		$this->ThemeDataObj->getThemeDataEntry ( 'theme_bg_color' ) . "; "; }
		$Content .= "'\r";

		if (strlen ( $this->ThemeDataObj->getThemeBlockEntry ( 'B01T', 'txt_col' ) ) > 0) {
			$Content .= "text='" . $this->ThemeDataObj->getThemeBlockEntry ( 'B01T', 'txt_col' ) . 
			"' link='" . $this->ThemeDataObj->getThemeBlockEntry ( 'B01T', 'txt_col' ) . 
			"' vlink='" . $this->ThemeDataObj->getThemeBlockEntry ( 'B01T', 'txt_col' ) . 
			"' alink='" . $this->ThemeDataObj->getThemeBlockEntry ( 'B01T', 'txt_col' ) . "' ";
		}	
		$Content .= ">\r ";

		foreach ( $this->ContentFragments as &$A ) { $Content .= $A['content']; }
		return ($Content);
	}

	/**
	 * Builds the admin dashboard content
	 * @return string
	 */
	private function buidAdminDashboard() {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance ();

		$localisation = " buidAdminDashboard";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "buidAdminDashboard" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "buidAdminDashboard" );
		
		$bts->LMObj->logCheckpoint ( "index_before_stat" );
		$bts->MapperObj->RemoveThisLevel ( "/ idx" );
		$CurrentSetObj->setDataSubEntry ( 'timeStat', 'end', $bts->TimeObj->microtime_chrono () ); // We get time for later use in the stats.
		
		$bts->LMObj->setStoreStatisticsStateOff ();
		// --------------------------------------------------------------------------------------------
		$ClassLoaderObj->provisionClass ( 'RenderAdmDashboard' );
		$RenderAdmDashboardObj = RenderAdmDashboard::getInstance ();
		return ($RenderAdmDashboardObj->render ());
	}

	/**
	 * Builds the file selector content
	 * @return string
	 */
	private function buildFileSelector(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance ();
	
		$localisation = " buildFileSelector";
		$bts->MapperObj->AddAnotherLevel ( $localisation );
		$bts->LMObj->logCheckpoint ( "buildFileSelector" );
		$bts->MapperObj->RemoveThisLevel ( $localisation );
		$bts->MapperObj->setSqlApplicant ( "buildFileSelector" );

		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : About to process file selector"));
		
		$Content = "";
		if ($CurrentSetObj->getDataEntry ( 'fsIdx' ) > 0) {
			$ClassLoaderObj->provisionClass ( 'FileSelector' );
			$FileSelectorObj = FileSelector::getInstance ();
			$infos ['block'] = $this->ThemeDataObj->getThemeName () . "B01";
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
			$this->GeneratedScript->insertString('JavaScript-Data', $str );
		}
		return ($Content);
	}


}
?>
