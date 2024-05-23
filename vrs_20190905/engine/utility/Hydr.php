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
/*Hydre-IDE-begin*/
// Some definitions in order to ease the IDE work and to provide information about what is already available in this context.
/* @var $CurrentSetObj CurrentSet                   */
/* @var $Block String                               */
/* @var $infos Array                                */
/* @var $l String                                   */
/*Hydre-IDE-end*/

class Hydr
{
	private static $Instance = null;
	private $authentificationMode;
	private $authentificationAction;
	// private $SqlTableListObj;
	private $GeneratedScript;
	private $ThemeDataObj;
	private $WebSiteObj;
	private $ContentFragments;
	private $stylesheet;

	private function __construct()
	{
	}

	/**
	 * Singleton : Will return the instance of this class.
	 * @return Hydr
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new Hydr();
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
		$application = 'website';
		include("current/define.php");

		// --------------------------------------------------------------------------------------------
		/*
		 * Good practice for the main script when it's ready to think about saving memory... more.
		 * $varsStart = array_keys(get_defined_vars());
		 * [...]
		 * $varsEnd = array_keys(get_defined_vars());
		 * $varsSum = array_diff ($varsEnd, $varsStart);
		 * foreach ( $varsSum as $B => $C ) { if ( $C != 'infos' && $C != 'Content' && !is_object($$C) ) { unset ($$C); } }
		 */
		include("current/engine/utility/ClassLoader.php");
		$ClassLoaderObj = ClassLoader::getInstance();

		$ClassLoaderObj->provisionClass('BaseToolSet'); // First of them all as it is used by others.
		$bts = BaseToolSet::getInstance();

		// --------------------------------------------------------------------------------------------
		$Content =  "";
		// --------------------------------------------------------------------------------------------
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => "+--------------------------------------------------------------------------------+"));
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => "|                                                                                |"));
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => "| Begining Hydr page                                                             |"));
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => "|                                                                                |"));
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => "+--------------------------------------------------------------------------------+"));

		$bts->LMObj->setStoreStatisticsStateOn();
		$bts->LMObj->logCheckpoint("Index");

		// --------------------------------------------------------------------------------------------
		// error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );
		// error_reporting ( E_ALL ^ E_NOTICE );
		error_reporting(E_ALL);
		ini_set('log_errors', "On");
		ini_set('error_log', "/var/log/apache2/error.log");
		ini_set('display_errors', 0);

		// --------------------------------------------------------------------------------------------
		// Don't push me cuz i'm close to the edge !!!
		// It’s like a jungle sometimes, it makes me wonder how I keep from going under...
		// MSIE / Edge must die!!! for good this time.
		$Navigator = getenv("HTTP_USER_AGENT");
		if (strpos($Navigator, "MSIE") !== FALSE) {
			if (strpos($Navigator, "DOM") !== FALSE) {
				include("current/engine/staticPages/UnsupportedBrowserBanner.php");
				exit();
			}
		}
		unset($Navigator);

		// --------------------------------------------------------------------------------------------
		// CurrentSet
		//
		$ClassLoaderObj->provisionClass('ServerInfos');
		$ClassLoaderObj->provisionClass('CurrentSet');
		$CurrentSetObj = CurrentSet::getInstance();
		$CurrentSetObj->setServerInfosObj(new ServerInfos());
		$CurrentSetObj->ServerInfosObj->getInfosFromServer();
		$CurrentSetObj->setDataEntry('fsIdx', 0);		// Useful for FileSelector
		// --------------------------------------------------------------------------------------------
		// Session management
		//
		$CurrentSetObj->setDataEntry('sessionName', 'HydrWebsiteSessionId');
		$bts->initSmObj();
		// $bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : \$_SESSION :\n" . $bts->StringFormatObj->arrayToString($_SESSION) . "\n *** \$bts->SMObj->getSession() = " . $bts->StringFormatObj->arrayToString($bts->SMObj->getSession()) . "\n---------------------------------------- *** EOL"));
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => $bts->SMObj->getInfoSessionState()));

		// If $_SESSION sub array is empty we have to check what website is to be selected
		$wsSession = $_SESSION[$_SERVER['HTTP_HOST']];
		if (empty($_SESSION[$wsSession])) {
			// The sub array in the session object is empty. 
			// 1 Checking if the config file exists
			// 2 If it doesn't, getting the default_website definition with the root website
			// 3 Setting the website and loading config (considering default_website is ok)
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : \$_SESSION is empty. Initializing the session for the chosen website : " . $_SERVER['HTTP_HOST'] . "."));
			$configFile = "current/config/current/site_" . $_SERVER['HTTP_HOST'] . "_config.php";
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : config file =`" . $configFile . "`."));

			if (!file_exists($configFile)) {
				// HdrBase config should have the necessary privileges to log to the DB and retrieve the default_website definition.
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Definition is empty. Falling back to 'HdrBase'."));
				$CurrentSetObj->setDataEntry('ws', 'HdrBase');
				$this->loadConfigFile();
				if ($this->initializeSDDM() == true) {
					$ClassLoaderObj->provisionClass('Definition');
					$definitionObj = new Definition();
					$definitionObj->getDataFromDBUsingName('default_website');
					if (strlen($definitionObj->getDefinitionEntry('def_text')) > 0) {
						$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Definition default_website is '" . $definitionObj->getDefinitionEntry('def_text') . "'."));
						$CurrentSetObj->setDataEntry('ws', $definitionObj->getDefinitionEntry('def_text'));
					} else {
						$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Definition default_website is empty... catastrophic failure"));
					}
				} else {
					$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Something went wrong with SDDM initialisation."));
				}
			}

			// Loading the config file
			$this->loadConfigFile();
			if ($this->initializeSDDM() == true) {
				$bts->CMObj->PopulateLanguageList(); // Not before we have access to the DB. Better isn't it?
				$bts->SMObj->setSessionEntry($_SERVER['HTTP_HOST'], $CurrentSetObj->getDataEntry('ws'));
				$CurrentSetObj->setDataEntry('ws', $CurrentSetObj->getDataEntry('ws'));
				$bts->SMObj->InitializeSession();
				$bts->SMObj->syncSuperGlobalSession();
			} else {
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Something went wrong with SDDM initialisation."));
			}
		} else {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Selected session sub array is '" . $wsSession . "'."));
			$CurrentSetObj->setDataEntry('ws', $wsSession);
		}

		// $CurrentSetObj->setDataEntry('ws', $bts->SMObj->getSessionEntry($_SERVER['HTTP_HOST']));

		// --------------------------------------------------------------------------------------------

		// Scoring on what we recieved (or what's at disposal)
		$this->prepareAuthProcess();

		// Loading the configuration file associated with this website
		$this->loadConfigFile();

		// Creating the necessary arrays for Sql Db Dialog Management
		if ($this->initializeSDDM() == true) {
			$bts->CMObj->PopulateLanguageList(); // Not before we have access to the DB. Better isn't it?

			$this->initializeWebsite();

			// Authentification
			$this->authentificationCheck();

			// Language selection
			$this->languageSelection();

			// Form Management for commandLine interface
			// Do we have a user submitting from the auth form ?
			// if ($bts->RequestDataObj->getRequestDataSubEntry ( 'formGenericData', 'modification' ) == 'on' || $bts->RequestDataObj->getRequestDataSubEntry ( 'formGenericData', 'deletion' ) == 'on' && $UserObj->getUserEntry ( 'user_login' ) != 'anonymous') {
			if (
				$bts->RequestDataObj->getRequestDataEntry('formSubmitted') == 1 &&
				$CurrentSetObj->UserObj->getUserEntry('user_login') != 'anonymous'
			) {
				$this->formManagement();
			}

			// Router : What was called ? (slug/form etc..) and storing information in the session
			$bts->Router->manageNavigation();

			// Article
			$this->initializeArticle();

			// --------------------------------------------------------------------------------------------
			$CurrentSetObj->setDataSubEntry('block_HTML', 'post_hidden_ws', "<input type='hidden'	name='ws'					value='" . $this->WebSiteObj->getWebSiteEntry('ws_short') . "'>\r");
			$CurrentSetObj->setDataSubEntry('block_HTML', 'post_hidden_l', "<input type='hidden'	name='l'					value='" . $CurrentSetObj->getDataEntry('language') . "'>\r");
			$CurrentSetObj->setDataSubEntry('block_HTML', 'post_hidden_user_login', "<input type='hidden'	name='user_login'	value='" . $bts->SMObj->getSessionEntry('user_login') . "'>\r");
			$CurrentSetObj->setDataSubEntry('block_HTML', 'post_hidden_user_pass', "<input type='hidden'	name='user_pass'	value='" . $bts->SMObj->getSessionEntry('user_password') . "'>\r");
			$CurrentSetObj->setDataSubEntry('block_HTML', 'post_hidden_arti_ref', "<input type='hidden'	name='arti_ref'		value='" . $CurrentSetObj->getDataSubEntry('article', 'arti_ref') . "'>\r");
			$CurrentSetObj->setDataSubEntry('block_HTML', 'post_hidden_arti_page', "<input type='hidden'	name='arti_page'	value='" . $CurrentSetObj->getDataSubEntry('article', 'arti_page') . "'>\r");

			$urlUsrPass = "";
			if ($bts->SMObj->getSessionEntry('sessionMode') != 1) {
				$urlUsrPass = "&amp;user_login=" . $bts->SMObj->getSessionEntry('user_login');
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

			$bts->mapSegmentLocation(__METHOD__, "Modules");

			$ClassLoaderObj->provisionClass('InteractiveElements'); // Responsible for rendering buttons

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
			$CssContent  = "<!-- Extra CSS -->\r";
			$CssContent .= $this->GeneratedScript->renderScriptFileWithBaseURL("Css-File", "<link rel='stylesheet' href='", "'>\r");

			// --------------------------------------------------------------------------------------------
			// Rendering of the JavaScript
			//
			// --------------------------------------------------------------------------------------------
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : About to render javascript"));
			$this->GeneratedScript->insertString('JavaScript-OnLoad', "\tconsole.log ( TabInfoModule );");
			$this->GeneratedScript->insertString('JavaScript-OnLoad', "\telm.Gebi('HydrBody').style.visibility = 'visible';");
			$this->GeneratedScript->insertString('JavaScript-File', 'current/engine/javascript/lib_DecorationManagement.js');
			$this->GeneratedScript->insertString('JavaScript-Init', 'var dm = new DecorationManagement();');

			$JavaScriptContent = "<!-- JavaScript -->\r\r";
			$JavaScriptContent .= $this->GeneratedScript->renderScriptFileWithBaseURL("JavaScript-File", "<script type='text/javascript' src='", "'></script>\r");
			$JavaScriptContent .= $this->GeneratedScript->renderExternalRessourceScript("JavaScript-ExternalRessource", "<script type='text/javascript' src='", "'></script>\r");
			$JavaScriptContent .= "<script type='text/javascript'>\r";

			$JavaScriptContent .= "// ----------------------------------------\r//\r// Data segment\r//\r//\r";
			$JavaScriptContent .= $this->GeneratedScript->renderScriptCrudeMode("JavaScript-Data");
			$JavaScriptContent .= "// ----------------------------------------\r//\r// Data (Flexible) \r//\r//\r";
			$JavaScriptContent .= $this->GeneratedScript->renderJavaScriptObjects();
			$JavaScriptContent .= "// ----------------------------------------\r//\r// Init segment\r//\r//\r";
			$JavaScriptContent .= $this->GeneratedScript->renderScriptCrudeMode("JavaScript-Init");
			$JavaScriptContent .= "// ----------------------------------------\r//\r// Command segment\r//\r//\r";
			$JavaScriptContent .= $this->GeneratedScript->renderScriptCrudeMode("JavaScript-Command");
			$JavaScriptContent .= "// ----------------------------------------\r//\r// OnLoad segment\r//\r//\r";
			$JavaScriptContent .= "function WindowOnResize (){\r";
			$JavaScriptContent .= $this->GeneratedScript->renderScriptCrudeMode("JavaScript-OnResize");
			$JavaScriptContent .= "}\r";
			$JavaScriptContent .= "function WindowOnLoad () {\r";
			$JavaScriptContent .= $this->GeneratedScript->renderScriptCrudeMode("JavaScript-OnLoad");
			$JavaScriptContent .= "}\r
									window.onresize = WindowOnResize;\r
									window.onload = WindowOnLoad;\r
									</script>\r";

			$licence = "
				<!--
				Author : FMA - 2005 ~ " . date("Y", time()) . "
				Licence : Creative commons CC-by-nc-sa (http://www.creativecommons.org/)
				-->
				";

			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : \$_SESSION :" . $bts->StringFormatObj->arrayToString($_SESSION)));

			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT,	'msg' => __METHOD__ . " : Test logging with levels (Between parenthesis) `Citation` array( \$PhpVariable ) \$Php_Variable array([module_id]=`5387701299386917658`, [index]=`1`, [index]=`1`) ."));
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT,	'msg' => __METHOD__ . " : Test logging with levels (Between parenthesis) `Citation` array( \$PhpVariable ) \$Php_Variable array([module_id]=`5387701299386917658`, [index]=`1`, [index]=`1`) ."));
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_INFORMATION,	'msg' => __METHOD__ . " : Test logging with levels (Between parenthesis) `Citation` array( \$PhpVariable ) \$Php_Variable array([module_id]=`5387701299386917658`, [index]=`1`, [index]=`1`) ."));
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING,		'msg' => __METHOD__ . " : Test logging with levels (Between parenthesis) `Citation` array( \$PhpVariable ) \$Php_Variable array([module_id]=`5387701299386917658`, [index]=`1`, [index]=`1`) ."));
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_ERROR,		'msg' => __METHOD__ . " : Test logging with levels (Between parenthesis) `Citation` array( \$PhpVariable ) \$Php_Variable array([module_id]=`5387701299386917658`, [index]=`1`, [index]=`1`) ."));

			// --------------------------------------------------------------------------------------------
			$bts->SDDMObj->disconnect_sql();
			$bts->SMObj->syncSuperGlobalSession(); // One last time to make sure it's saved
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " :\n \$_SESSION:" . $bts->StringFormatObj->print_r_debug($_SESSION) . "\n \$bts->SMObj->getSession():" . $bts->StringFormatObj->print_r_debug($bts->SMObj->getSession())));
			// return ($Content . $CssContent . $licence . "</body>\r</html>\r");
			return ($Content . $CssContent . $JavaScriptContent . $licence . "</body>\r</html>\r");
		} else {
			$this->WebSiteObj->setWebSiteEntry('banner_offline', 1);
			include("modules/initial/OfflineMessage/OfflineMessage.php");
		}
	}

	/**
	 * prepareAuthProcess
	 */
	private function prepareAuthProcess()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$currentWs = $CurrentSetObj->getDataEntry('ws'); // get the Webite

		$bts->mapSegmentLocation(__METHOD__, "prepareAuthProcess");

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
		if (session_status() === PHP_SESSION_ACTIVE) {
			$firstContactScore++;
		}
		if (strlen($bts->RequestDataObj->getRequestDataEntry('ws') ?? '') != 0) {
			$firstContactScore += 2;
		}
		if (
			strlen(
				$bts->RequestDataObj->getRequestDataEntry('formSubmitted') ?? ''
			) == 1 &&
			$bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'origin') == "ModuleAuthentification"
		) {
			$firstContactScore += 4;
		}
		if (strlen($bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'action') == "disconnection") ?? '') {
			$firstContactScore += 8;
		}

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : \$firstContactScore='" . $firstContactScore . "'"));
		$this->authentificationMode = "session";
		$this->authentificationAction = USER_ACTION_SIGN_IN;

		switch ($firstContactScore) {
			case 0:
				$bts->SMObj->InitializeSession();
				$bts->SMObj->syncSuperGlobalSession();
				break;
			case 1:
				$bts->SMObj->CheckSession();
				break;
			case 2:
			case 3:
				// $bts->SMObj->setSessionEntry('ws', $bts->RequestDataObj->getRequestDataEntry('ws'));
				$bts->SMObj->setSessionSubEntry($bts->RequestDataObj->getRequestDataEntry('ws'), 'ws', $bts->RequestDataObj->getRequestDataEntry('ws'));
				$bts->SMObj->CheckSession();
				break;
			case 4:
			case 5:
			case 6:
			case 7:
				$this->authentificationMode = "form";
				break;
			case 8:
			case 9:
			case 10:
			case 11:
			case 12:
			case 13:
			case 14:
			case 15:
				$this->authentificationMode = "form";
				$this->authentificationAction = USER_ACTION_DISCONNECT;
				break;
		}
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . $bts->SMObj->getInfoSessionState() . ", \$this->authentificationMode=" . $this->authentificationMode . "; \$this->authentificationAction=" . $this->authentificationAction));

		$bts->segmentEnding(__METHOD__);
		return (true);
	}

	/**
	 * Load the config file
	 */
	private function loadConfigFile()
	{
		$bts = BaseToolSet::getInstance();

		$bts->mapSegmentLocation(__METHOD__, "loadConfigFile");

		// A this point we have a ws in the CurrentSet so we don't use the URI parameter anymore.
		$bts->CMObj->LoadConfigFile();
		$bts->CMObj->setConfigurationEntry('execution_context', "render");
		$bts->LMObj->setDebugLogEcho(0);

		$bts->segmentEnding(__METHOD__);
		return (true);
	}

	/**
	 * Initializes the necessary sql connexion assets
	 */
	private function initializeSDDM()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();

		$bts->mapSegmentLocation(__METHOD__, "initializeSDDM");

		$ClassLoaderObj->provisionClass('SqlTableList');
		$CurrentSetObj->setSqlTableListObj(SqlTableList::getInstance());
		$CurrentSetObj->SqlTableListObj->makeSqlTableList($bts->CMObj->getConfigurationEntry('dbprefix'), $bts->CMObj->getConfigurationEntry('tabprefix'));

		switch ($bts->CMObj->getConfigurationSubEntry('db', 'type')) {
			case "mysql":
				$CurrentSetObj->SqlTableListObj->makeSqlTableList($bts->CMObj->getConfigurationEntry('dbprefix'), $bts->CMObj->getConfigurationEntry('tabprefix'));
				break;
			case "pgsql":
				$CurrentSetObj->SqlTableListObj->makeSqlTableList("public", $bts->CMObj->getConfigurationEntry('tabprefix'));
				break;
		}

		// $this->SqlTableListObj = $CurrentSetObj->SqlTableListObj();

		// --------------------------------------------------------------------------------------------
		$ClassLoaderObj->provisionClass('SddmTools');
		$ClassLoaderObj->provisionClass('DalFacade');
		$bts->initSddmObj();

		if ($bts->SDDMObj->getReportEntry('cnxErr') == 1) {
			include("modules/initial/OfflineMessage/OfflineMessage.php");
			$ModuleOffLineMessageObj = new ModuleOffLineMessage();
			$ModuleOffLineMessageObj->render(array(
				"SQLFatalError" => 1,
				"bannerOffline" => 0
			));
			return (false);
		}

		$bts->segmentEnding(__METHOD__);
		return (true);
	}

	/**
	 * Initializes the wesite instance and load data
	 */
	private function initializeWebsite()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();

		$bts->mapSegmentLocation(__METHOD__, "initializeWebsite");

		$ClassLoaderObj->provisionClass('WebSite');
		$CurrentSetObj->setWebSiteObj(new WebSite());
		$this->WebSiteObj = $CurrentSetObj->WebSiteObj;
		$this->WebSiteObj->getDataFromDBUsingShort();

		switch ($this->WebSiteObj->getWebSiteEntry('ws_state')) {
			case 0: // Offline
			case 3: // Maintenance
			case 99: // Verouillé
				$this->WebSiteObj->setWebSiteEntry('banner_offline', 1);
				include("modules/initial/OfflineMessage/OfflineMessage.php");
				break;
		}
		$bts->CMObj->setLangSupport(); // will set support=1 in the languagelist if website supports the language.

		$bts->segmentEnding(__METHOD__);
		return (true);
	}

	/**
	 * Authentification
	 */
	private function authentificationCheck()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();
		/* TODO virer la variable locale */
		$WebSiteObj = $CurrentSetObj->WebSiteObj;

		$bts->mapSegmentLocation(__METHOD__, "authentificationCheck");

		$ClassLoaderObj->provisionClass('AuthenticateUser');
		$ClassLoaderObj->provisionClass('User');

		$CurrentSetObj->setUserObj(new User());
		$UserObj = $CurrentSetObj->UserObj;

		$currentWs = $CurrentSetObj->getDataEntry('ws'); // get the Webite
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : \$WebSiteObj" . $bts->StringFormatObj->arrayToString($WebSiteObj->getWebSite())));

		// 		We have 2 variables used to drive the authentification process.
		switch ($this->authentificationMode) {
			case "form":
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Authentification with form mode"));
				switch ($this->authentificationAction) {
					case USER_ACTION_DISCONNECT:
						$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : disconnect submitted"));
						$bts->SMObj->InitializeSession();
						$userName = ANONYMOUS_USER_NAME;
						break;
					case USER_ACTION_SIGN_IN:
						$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Connection attempt"));
						$userName = $bts->RequestDataObj->getRequestDataSubEntry('authentificationForm', 'user_login');
						break;
				}
				$bts->SMObj->InitializeSession(); // If a login comes from a form. The session object must be reset!
				$UserObj->getDataFromDBUsingLogin($userName, $WebSiteObj);
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : user_login=" . $UserObj->getUserEntry('user_login')));
				$bts->AUObj->checkUserCredential($UserObj, 'form');
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Connection attempt end"));
				break;
			case "session":
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Authentification with session mode. user_login='" . $bts->SMObj->getSessionEntry('user_login') . "'"));

				// Assuming a session is valid (whatever it's 'anonymous' or someone else).
				if (strlen($bts->SMObj->getSessionSubEntry($currentWs, 'user_login') ?? '') == 0) {
					$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : \$_SESSION strlen(user_login)=0"));
				}
				$UserObj->getDataFromDBUsingLogin($bts->SMObj->getSessionSubEntry($currentWs, 'user_login'), $WebSiteObj);
				if ($UserObj->getUserEntry('error_login_not_found') != 1) {
					$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : session mode : " . $bts->StringFormatObj->arrayToString($bts->SMObj->getSession())));
					$bts->AUObj->checkUserCredential($UserObj, 'session');
				} else {
					// No form then no user found it's defintely an anonymous user
					$bts->SMObj->InitializeSession();
					$UserObj->resetUser();
					$UserObj->getDataFromDBUsingLogin('anonymous', $WebSiteObj);
				}
				break;
		}
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : \$SMObj->getSession() :" . $bts->StringFormatObj->arrayToString($bts->SMObj->getSession())));
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : \$_SESSION :" . $bts->StringFormatObj->arrayToString($_SESSION)));
		if ($bts->AUObj->getDataEntry('error') === TRUE) {
			$UserObj->getDataFromDBUsingLogin("anonymous", $WebSiteObj);
		}
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : checkUserCredential end"));

		$bts->segmentEnding(__METHOD__);
		return (true);
	}

	/**
	 * Sets the language for the page. It chooses by priority.
	 * 
	 */
	private function languageSelection()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();
		$UserObj = $CurrentSetObj->UserObj;
		$WebSiteObj = $CurrentSetObj->WebSiteObj;

		$bts->mapSegmentLocation(__METHOD__, "languageSelection");

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Language selection start"));
		$scoreLang = 0;

		if (strlen($bts->RequestDataObj->getRequestDataEntry('l') ?? '') != 0 && $bts->RequestDataObj->getRequestDataEntry('l') != 0) {
			$scoreLang += 4;
		}
		if (strlen($UserObj->getUserEntry('user_lang') ?? '') != 0) {
			$scoreLang += 2;
		}
		if (strlen($WebSiteObj->getWebSiteEntry('fk_lang_id') ?? '') != 0 && $WebSiteObj->getWebSiteEntry('fk_lang_id') != 0) {
			$scoreLang += 1;
		}

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : fk_lang_id='" . $WebSiteObj->getWebSiteEntry('fk_lang_id') . "'"));

		switch ($scoreLang) {
			case 0:
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Language selection Error. Something wrong happened (most likely no data for language in website table). In the mean time back to English as website language."));
				$CurrentSetObj->setDataEntry('language', 'eng');
				$CurrentSetObj->setDataEntry('language_id', '38');
				break;
			case 1:
				$tmp = $bts->CMObj->getLanguageListSubEntry($WebSiteObj->getWebSiteEntry('fk_lang_id'), 'lang_639_3');
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Language selection says Website priority (Case=" . $scoreLang . "; " . $WebSiteObj->getWebSiteEntry('fk_lang_id') . "->" . $tmp . ")"));
				$CurrentSetObj->setDataEntry('language', $tmp);
				$CurrentSetObj->setDataEntry('language_id', $bts->CMObj->getLanguageListSubEntry($WebSiteObj->getWebSiteEntry('fk_lang_id'), 'lang_id'));
				break;
			case 2:
			case 3:
				$tmp = $bts->CMObj->getLanguageListSubEntry($UserObj->getUserEntry('user_lang'), 'lang_639_3');
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Language selection says User priority (Case=" . $scoreLang . "; " . $UserObj->getUserEntry('user_lang') . "->" . $tmp . ")"));
				$CurrentSetObj->setDataEntry('language', $tmp);
				$CurrentSetObj->setDataEntry('language_id', $bts->CMObj->getLanguageListSubEntry($UserObj->getUserEntry('user_lang'), 'lang_id'));
				break;
			case 4:
			case 5:
			case 6:
			case 7:
				$tmp = strtolower($bts->RequestDataObj->getRequestDataEntry('l'));
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Language selection says URL priority (Case=" . $scoreLang . "; " . $bts->RequestDataObj->getRequestDataEntry('l') . "->" . $tmp . ")"));
				$CurrentSetObj->setDataEntry('language', $tmp); // URl/form asked, the king must be served!
				$CurrentSetObj->setDataEntry('language_id', strtolower($bts->RequestDataObj->getRequestDataEntry('l')));
				break;
		}

		$ClassLoaderObj->provisionClass('I18nTrans');
		$I18nObj = I18nTrans::getInstance();
		$I18nObj->getI18nTransFromDB();

		$bts->segmentEnding(__METHOD__);
		return (true);
	}

	/**
	 * 
	 */
	private function formManagement()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();
		$UserObj = $CurrentSetObj->UserObj;
		$WebSiteObj = $CurrentSetObj->WebSiteObj;

		$bts->mapSegmentLocation(__METHOD__, "formManagement");

		$bts->LMObj->saveVectorSystemLogLevel();
		$bts->LMObj->setVectorSystemLogLevel(LOGLEVEL_BREAKPOINT);

		$ClassLoaderObj->provisionClass('CommandConsole');
		$CurrentSetObj->setWebSiteContextObj($WebSiteObj); // Set an initial website context.
		$CommandConsoleObj = CommandConsole::getInstance();

		if ($bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'section') == "CommandConsole") {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Command console - CLiContent"));
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : CLiContent='" . $bts->RequestDataObj->getRequestDataSubEntry('formConsole', 'CLiContent') . "'"));
			// We consider we have a script 
			$bts->CMObj->setConfigurationSubEntry('commandLineEngine', 'state', 'enabled');		// enabled/disabled

			$ClassLoaderObj->provisionClass('ScriptFormatting');
			$ScriptFormattingObj = ScriptFormatting::getInstance();

			$CLiContent['currentFileContent'] = $bts->RequestDataObj->getRequestDataSubEntry('formConsole', 'CLiContent');
			$ScriptFormattingObj->createMap($CLiContent);
			$ScriptFormattingObj->commandFormatting($CLiContent);

			unset($A);
			foreach ($CLiContent['FormattedCommand'] as $A) {
				$Script[] = $A['cont'];
			}
		} else {
			$ClassLoaderObj->provisionClass('FormToCommandLine');
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Command console - FormToCommandLine"));
			$FormToCommandLineObj = FormToCommandLine::getInstance();
			$FormToCommandLineObj->analysis();

			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : FormToCommandLineObj->getCommandLineNbr() =" . $FormToCommandLineObj->getCommandLineNbr()));

			if ($FormToCommandLineObj->getCommandLineNbr() > 0) {
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : A script is on the bench :"));

				$bts->CMObj->setConfigurationSubEntry('commandLineEngine', 'state', 'enabled'); // enabled/disabled
				$Script = $FormToCommandLineObj->getCommandLineScript();
			}
		}
		switch ($bts->CMObj->getConfigurationSubEntry('commandLineEngine', 'state')) {
			case "enabled":
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "+--------------------------------------------------------------------------------+"));
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "| Commande console                                                               |"));
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "+--------------------------------------------------------------------------------+"));
				foreach ($Script as $A) {
					$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : before CommandConsole->ExecuteCommand (`" . $A . "`)"));
					$CommandConsoleObj->executeCommand($A);

					// We have to reload website and user in case of one of them was updated.
					$WebSiteObj->getDataFromDBUsingShort();
					$UserObj->getDataFromDBUsingLogin($bts->SMObj->getSessionSubEntry($CurrentSetObj->getDataEntry('ws'), 'user_login'), $WebSiteObj);

					$this->languageSelection();
				}
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "+--------------------------------------------------------------------------------+"));
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "| Fin Commande console                                                           |"));
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . "+--------------------------------------------------------------------------------+"));
				break;
			case "disabled":
			default:
				foreach ($Script as $A) {
					$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : Logging Command"));
					$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . $A));
				}
				break;
		}
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : End of command execution - " . $A));
		$bts->LMObj->restoreVectorSystemLogLevel();

		switch ($bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'origin') . $bts->RequestDataObj->getRequestDataSubEntry('formGenericData', 'section')) {
			case "AdminDashboardUserProfileForm":
			case "ModuleQuickSkin":
			case "ModuleSelectLanguage":
				$UserObj->getDataFromDBUsingLogin($UserObj->getUserEntry('user_login'), $WebSiteObj); // We need to reload the user data in order to update the current user_pref_theme variable.
				break;
			case "AdminDashboardWebsiteManagementP01":
				// refresh with updated data
				$id = $WebSiteObj->getWebSiteEntry('ws_id');
				$WebSiteObj->getDataFromDB($id);
				break;
		}

		$bts->segmentEnding(__METHOD__);
		return (true);
	}

	/**
	 * Initialize Article
	 */
	private function initializeArticle()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();
		$WebSiteObj = $CurrentSetObj->WebSiteObj;
		$UserObj = $CurrentSetObj->UserObj;

		$bts->mapSegmentLocation(__METHOD__, "initializeArticle");

		$currentWs = $CurrentSetObj->getDataEntry('ws'); // get the Webite

		if (strlen($bts->SMObj->getSession3rdLvlEntry($currentWs, 'currentRoute', 'target') ?? '') == 0) {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : There is no viable route in the session. Back to home."));
			$sqlQuery = "
				SELECT mnu.menu_id, mnu.menu_name, mnu.fk_arti_ref
				FROM " . $CurrentSetObj->SqlTableListObj->getSQLTableName('menu') . " mnu, " . $CurrentSetObj->SqlTableListObj->getSQLTableName('deadline') . " bcl
				WHERE mnu.fk_ws_id = '" . $WebSiteObj->getWebSiteEntry('ws_id') . "'
				AND mnu.fk_lang_id = '" . $CurrentSetObj->getDataEntry('language_id') . "'
				AND mnu.fk_deadline_id = bcl.deadline_id
				AND bcl.deadline_state = '1'
				AND mnu.menu_type IN ('0','1')
				AND mnu.fk_perm_id " . $UserObj->getUserEntry('clause_in_perm') . "
				AND mnu.menu_state = '1'
				AND mnu.menu_initial_document = '1'
				ORDER BY mnu.menu_parent,mnu.menu_position
				;";
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " `" . $bts->StringFormatObj->formatToLog($sqlQuery) . "`."));
			$dbquery = $bts->SDDMObj->query($sqlQuery);
			while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
				$CurrentSetObj->setDataSubEntry('article', 'menu_id', $dbp['menu_id']);
				$CurrentSetObj->setDataSubEntry('article', 'arti_id', $dbp['arti_id']);
				$CurrentSetObj->setDataSubEntry('article', 'arti_ref', $dbp['arti_ref']);
			}
			$CurrentSetObj->setDataSubEntry('article', 'arti_page', 1);
		} else {
			// Is the user can read this article ?
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : A route exists in the session. The target is `" . $bts->SMObj->getSession3rdLvlEntry($currentWs, 'currentRoute', 'target') . "`."));

			// Special case for admin auth 
			if ($bts->SMObj->getSession3rdLvlEntry($currentWs, 'currentRoute', 'target') == "admin-authentification") {
				$sqlQuery = "
					SELECT * FROM " . $$CurrentSetObj->SqlTableListObj->getSQLTableName('article') . " art
					WHERE art.arti_slug = '" . $bts->SMObj->getSession3rdLvlEntry($currentWs, 'currentRoute', 'target') . "'
					AND art.arti_page = '1';
					;";
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " `" . $bts->StringFormatObj->formatToLog($sqlQuery) . "`."));
				$dbquery = $bts->SDDMObj->query($sqlQuery);
			} else {
				// Normal case
				$sqlQuery = "
					SELECT * 
					FROM "
					. $CurrentSetObj->SqlTableListObj->getSQLTableName('menu') . " mnu, "
					. $CurrentSetObj->SqlTableListObj->getSQLTableName('article') . " art
					WHERE mnu.fk_ws_id IN ('" . $WebSiteObj->getWebSiteEntry('ws_id') . "')
					AND mnu.fk_lang_id = '" . $CurrentSetObj->getDataEntry('language_id') . "' 
					AND mnu.fk_perm_id " . $UserObj->getUserEntry('clause_in_perm') . " 
					AND mnu.menu_state = '1'
					AND mnu.fk_arti_ref = art.arti_ref
					AND art.arti_slug = '" . $bts->SMObj->getSession3rdLvlEntry($currentWs, 'currentRoute', 'target') . "'
					AND art.arti_page = '" . $bts->SMObj->getSession3rdLvlEntry($currentWs, 'currentRoute', 'page') . "';
					;";
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " `" . $bts->StringFormatObj->formatToLog($sqlQuery) . "`."));
				$dbquery = $bts->SDDMObj->query($sqlQuery);
			}
			if ($bts->SDDMObj->num_row_sql($dbquery) > 0) {
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : We got SQL rows for `" . $bts->SMObj->getSession3rdLvlEntry($currentWs, 'currentRoute', 'target') . "`."));
				while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) {
					$CurrentSetObj->setDataSubEntry('article', 'menu_id', $dbp['menu_id']);
					$CurrentSetObj->setDataSubEntry('article', 'arti_id', $dbp['arti_id']);
					$CurrentSetObj->setDataSubEntry('article', 'arti_ref', $dbp['arti_ref']);
					$CurrentSetObj->setDataSubEntry('article', 'arti_slug', $dbp['arti_slug']);
					$CurrentSetObj->setDataSubEntry('article', 'arti_page', $dbp['arti_page']);
				}
			} else {
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : No SQL rows for " . $bts->SMObj->getSession3rdLvlEntry($currentWs, 'currentRoute', 'target')));
				$CurrentSetObj->setDataSubEntry('article', 'menu_id', "");
				$CurrentSetObj->setDataSubEntry('article', 'arti_id', "");
				$CurrentSetObj->setDataSubEntry('article', 'arti_ref', $CurrentSetObj->getDataEntry('language') . "_" . 'article_not_found');
				$CurrentSetObj->setDataSubEntry('article', 'arti_slug', 'article_not_found');
				$bts->RequestDataObj->setRequestDataEntry('arti_ref', $CurrentSetObj->getDataEntry('language') . "_" . 'article_not_found');		//deprecated remove when ready
				$bts->RequestDataObj->setRequestDataEntry('arti_page', 1);
				$CurrentSetObj->setDataSubEntry('article', 'arti_page', $bts->RequestDataObj->getRequestDataEntry('arti_page'));
			}
		}

		$ClassLoaderObj->provisionClass('Article');
		$CurrentSetObj->setArticleObj(new Article());
		$CurrentSetObj->ArticleObj->getDataFromDB($CurrentSetObj->getDataSubEntry('article', 'arti_id'));

		$bts->segmentEnding(__METHOD__);
		return (true);
	}

	/**
	 * Initializes Javascript
	 */
	private function initializeJavascript()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();
		$WebSiteObj = $CurrentSetObj->WebSiteObj;

		$bts->mapSegmentLocation(__METHOD__, "initializeJavascript");

		$ClassLoaderObj->provisionClass('GeneratedScript');
		$CurrentSetObj->setGeneratedScriptObj(new GeneratedScript());
		$this->GeneratedScript = $CurrentSetObj->GeneratedScriptObj;
		$this->GeneratedScript->insertString('JavaScript-File', 'current/engine/javascript/lib_HydrCore.js');

		// $this->GeneratedScript->insertString('JavaScript-File', 'current/engine/javascript_lib_calculs_decoration.js');
		// We got the route definition in the $CurrentSet and the session.
		// Inserting the URL in the browser bar.
		$urlBar = $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . $CurrentSetObj->getDataSubEntry('article', 'arti_slug') . "/" . $CurrentSetObj->getDataSubEntry('article', 'arti_page') . "/";
		$this->GeneratedScript->insertString('JavaScript-OnLoad', "	window.history.pushState( null , '" . $WebSiteObj->getWebSiteEntry('ws_title') . "', '" . $urlBar . "');");
		$this->GeneratedScript->insertString('JavaScript-OnLoad', "	document.title = '" . $WebSiteObj->getWebSiteEntry('ws_title') . " - " . $CurrentSetObj->getDataSubEntry('article', 'arti_slug') . "';");

		$this->GeneratedScript->insertString('JavaScript-OnResize', "\telm.UpdateWindowSize ('');");

		$bts->segmentEnding(__METHOD__);
		return (true);
	}

	/**
	 * initialize Theme
	 */
	private function initializeTheme()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();

		$bts->mapSegmentLocation(__METHOD__, "initializeTheme");

		// Those are ENTITIES(DAO), they're not UTILITY classes.
		$ClassLoaderObj->provisionClass('Deco10_Menu');
		$ClassLoaderObj->provisionClass('Deco20_Caligraph');
		$ClassLoaderObj->provisionClass('Deco30_1Div');
		$ClassLoaderObj->provisionClass('Deco40_Elegance');
		$ClassLoaderObj->provisionClass('Deco50_Exquisite');
		$ClassLoaderObj->provisionClass('Deco60_Elysion');
		$ClassLoaderObj->provisionClass('ThemeDescriptor');

		$CurrentSetObj->setThemeDescriptorObj(new ThemeDescriptor());
		$ThemeDescriptorObj = $CurrentSetObj->ThemeDescriptorObj;

		$ThemeDescriptorObj->setCssPrefix("mt_");
		$ThemeDescriptorObj->getDataFromDBByPriority();

		$ClassLoaderObj->provisionClass('ThemeData');
		$CurrentSetObj->setThemeDataObj(new ThemeData());
		$this->ThemeDataObj = $CurrentSetObj->ThemeDataObj;
		$this->ThemeDataObj->setThemeData($ThemeDescriptorObj->getThemeDescriptor()); // Better to give an array than the object itself.
		$this->ThemeDataObj->setThemeDefinition($ThemeDescriptorObj->getThemeDefinition());

		$this->ThemeDataObj->setThemeName($ThemeDescriptorObj->getCssPrefix());
		$this->ThemeDataObj->setDecorationListFromDB();
		$this->ThemeDataObj->renderBlockData();

		$bts->segmentEnding(__METHOD__);
		return (true);
	}

	/**
	 * Initialize Layout
	 */
	private function initializeLayout()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();

		$bts->mapSegmentLocation(__METHOD__, "initializeLayout");

		$ClassLoaderObj->provisionClass('ModuleList');
		$CurrentSetObj->setModuleListObj(new ModuleList());
		$ModuleLisObj = $CurrentSetObj->ModuleListObj;
		$ModuleLisObj->makeModuleList();

		$ClassLoaderObj->provisionClass('LayoutProcessor');
		$LayoutProcessorObj = LayoutProcessor::getInstance();
		$ClassLoaderObj->provisionClass('RenderModule');
		$RenderModuleObj = RenderModule::getInstance();

		$this->ContentFragments = $LayoutProcessorObj->render();

		$LayoutCommands = array(
			0 => array("regex"	=> "/{{\s*get_header\s*\(\s*\)\s*}}/", "command"	=> 'get_header'),
			1 => array("regex"	=> "/{{\s*render_module\s*\(\s*('|\"|`)\w*('|\"|`)\s*\)\s*}}/", "command"	=> 'render_module'),
		);

		// We know there's only one command per entry
		$insertJavascriptDecorationMgmt = false;
		foreach ($this->ContentFragments as &$A) {
			foreach ($LayoutCommands as $B) {
				if ($A['type'] == "command" && preg_match($B['regex'], $A['data'], $match) === 1) {
					// We got the match so it's...
					switch ($B['command']) {
						case "get_header":
							break;
						case "render_module":
							// Module it is.
							if ($insertJavascriptDecorationMgmt == false) {
								$this->GeneratedScript->insertString('JavaScript-OnLoad', "\tdm.UpdateAllDecoModule(TabInfoModule);");
								$this->GeneratedScript->insertString('JavaScript-OnResize', "\tdm.UpdateAllDecoModule(TabInfoModule);");
								$this->GeneratedScript->insertString("JavaScript-Data", "var TabInfoModule = new Array();\r");
								$insertJavascriptDecorationMgmt = true;
							}
							$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : `" . $A['type'] . "`; for `" . $A['module_name'] . "` and data " . $A['data']));
							$A['content'] = $RenderModuleObj->render($A['module_name']);
							break;
					}
				}
			}
		}

		$bts->segmentEnding(__METHOD__);
		return (true);
	}

	/**
	 * 
	 */
	private function renderStylsheet()
	{
		$bts = BaseToolSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();
		$ClassLoaderObj->provisionClass('RenderStylesheet');

		$bts->mapSegmentLocation(__METHOD__, "renderStylsheet");

		$RenderStylesheetObj = RenderStylesheet::getInstance();
		$this->stylesheet = $RenderStylesheetObj->render("mt_", $this->ThemeDataObj);

		$bts->segmentEnding(__METHOD__);
		return (true);
	}

	/**
	 * Builds the main document
	 * @return string
	 */
	private function buildDocument()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();


		$bts->mapSegmentLocation(__METHOD__, "buildDocument");

		$randomNumber = sprintf('%03d', random_int(1, 2));
		$Content = "<!DOCTYPE html>\r<html>";
		switch ($this->WebSiteObj->getWebSiteEntry('ws_stylesheet')) {
			case 1: // dynamic
				$Content .= "
				<head>\r
				<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>\r
				<link rel='icon' type='image/png' href='" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "media/img/favicon/favicon_" . $randomNumber . ".png' sizes='32x32'>\r
				<title>" . $this->WebSiteObj->getWebSiteEntry('ws_title') . "</title>\r
			";
				$Content .= $this->stylesheet . "</head>\r";
				unset($this->stylesheet);
				break;
			case 0: // statique
				$Content .= "
					<head>\r
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>\r
					<link rel='icon' type='image/png' href='" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "media/img/favicon/favicon_" . $randomNumber . ".png' sizes='32x32'>\r
					<link rel='stylesheet' href='" . $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url') . "stylesheets/" . $this->ThemeDataObj->getDefinitionValue('stylesheet_1') . "'>
					</head>\r
					";
				break;
		}
		$Content .= "<body id='HydrBody' ";
		$Content .= "style='";

		if (strlen($this->ThemeDataObj->getDefinitionValue('width') ?? '') > 0) {
			$Content .= "width:" .			$this->ThemeDataObj->getDefinitionValue('width') . "; ";
		}
		if (strlen($this->ThemeDataObj->getDefinitionValue('heigth') ?? '') > 0) {
			$Content .= "height:" .		$this->ThemeDataObj->getDefinitionValue('height') . "; ";
		}
		if (strlen($this->ThemeDataObj->getDefinitionValue('min_width') ?? '') > 0) {
			$Content .= "min-width:" .		$this->ThemeDataObj->getDefinitionValue('min_width') . "; ";
		}
		if (strlen($this->ThemeDataObj->getDefinitionValue('min_height') ?? '') > 0) {
			$Content .= "min-height:" .	$this->ThemeDataObj->getDefinitionValue('min_height') . "; ";
		}
		if (strlen($this->ThemeDataObj->getDefinitionValue('max_width') ?? '') > 0) {
			$Content .= "max-width:" .		$this->ThemeDataObj->getDefinitionValue('max_width') . "; ";
		}
		if (strlen($this->ThemeDataObj->getDefinitionValue('max_height') ?? '') > 0) {
			$Content .= "max-height:" .	$this->ThemeDataObj->getDefinitionValue('max_height') . "; ";
		}

		if (strlen($this->ThemeDataObj->getDefinitionValue('bg') ?? '') > 0) {
			$Content .= "background-image: url("
				. $CurrentSetObj->ServerInfosObj->getServerInfosEntry('base_url')
				. "media/theme/" . $this->ThemeDataObj->getDefinitionValue('directory') . "/" . $this->ThemeDataObj->getDefinitionValue('bg') . "); ";
		}

		if (strlen($this->ThemeDataObj->getDefinitionValue('bg_position') ?? '') > 0) {
			$Content .= "background-position:" .	$this->ThemeDataObj->getDefinitionValue('bg_position') . "; ";
		}
		if (strlen($this->ThemeDataObj->getDefinitionValue('bg_repeat') ?? '') > 0) {
			$Content .= "background-repeat:" .		$this->ThemeDataObj->getDefinitionValue('bg_repeat') . "; ";
		}
		if (strlen($this->ThemeDataObj->getDefinitionValue('bg_color') ?? '') > 0) {
			$Content .= "background-color:#" .		$this->ThemeDataObj->getDefinitionValue('bg_color') . "; ";
		}
		$Content .= "'\r";

		if (strlen($this->ThemeDataObj->getThemeBlockEntry('B01T', 'txt_col') ?? '') > 0) {
			$Content .= "text='" . $this->ThemeDataObj->getThemeBlockEntry('B01T', 'txt_col') .
				"' link='" . $this->ThemeDataObj->getThemeBlockEntry('B01T', 'txt_col') .
				"' vlink='" . $this->ThemeDataObj->getThemeBlockEntry('B01T', 'txt_col') .
				"' alink='" . $this->ThemeDataObj->getThemeBlockEntry('B01T', 'txt_col') . "' ";
		}
		$Content .= ">\r ";

		foreach ($this->ContentFragments as &$A) {
			$Content .= $A['content'];
		}

		$bts->segmentEnding(__METHOD__);
		return ($Content);
	}

	/**
	 * Builds the admin dashboard content
	 * @return string
	 */
	private function buidAdminDashboard()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();

		$bts->mapSegmentLocation(__METHOD__, "buidAdminDashboard");

		$CurrentSetObj->setDataSubEntry('timeStat', 'end', $bts->TimeObj->getMicrotime()); // We get time for later use in the stats.

		$bts->LMObj->setStoreStatisticsStateOff();
		// --------------------------------------------------------------------------------------------
		$ClassLoaderObj->provisionClass('RenderAdmDashboard');
		$RenderAdmDashboardObj = RenderAdmDashboard::getInstance();

		$bts->segmentEnding(__METHOD__);
		return ($RenderAdmDashboardObj->render());
	}

	/**
	 * Builds the file selector content
	 * @return string
	 */
	private function buildFileSelector()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();

		$bts->mapSegmentLocation(__METHOD__, "buildFileSelector");

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : About to process file selector"));

		$Content = "";
		if ($CurrentSetObj->getDataEntry('fsIdx') > 0) {
			$ClassLoaderObj->provisionClass('FileSelector');
			$FileSelectorObj = FileSelector::getInstance();
			$infos['block'] = $this->ThemeDataObj->getThemeName() . "B01";
			$infos['blockG'] = $infos['block'] . "G";
			$infos['blockT'] = $infos['block'] . "T";
			$Content .= $FileSelectorObj->render($infos);

			$fs = $CurrentSetObj->getDataEntry('fs');
			$str = "var tableFileSelector = {\r";
			$i = 0;
			foreach ($fs as $A) {
				$str .= "'" . $i . "':{ 'idx':'" . $i . "',	'width':'" . $A['width'] . "',	'height':'" . $A['height'] . "',	'formName':'" . $A['formName'] . "',	'formTargetId':'" . $A['formTargetId'] . "',	'selectionMode':'" . $A['selectionMode'] . "',	'lastPath':'" . $A['path'] . "',	'restrictTo':'" . $A['restrictTo'] . "',	'strRemove':'" . addslashes($A['strRemove']) . "',	'strAdd':'" . $A['strAdd'] . "',	'displayType':'" . $A['displayType'] . "'	},\r";
				$i++;
			}
			$str = substr($str, 0, -2) . "\r};\r";
			$this->GeneratedScript->insertString('JavaScript-Data', $str);
		}

		$bts->segmentEnding(__METHOD__);
		return ($Content);
	}
}
