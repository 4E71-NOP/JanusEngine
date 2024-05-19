<?php
/*Hydre-licence-begin*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	licence Creative Common licence, CC-by-nc-sa (http://creativecommons.org)
//	Author : Faust MARIA DE AREVALO, mailto:faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

/*Hydre-IDE-begin*/
// Some definitions in order to ease the IDE work and to provide information about what is already available in this context.
/* @var $bts BaseToolSet                            */
/* @var $CurrentSetObj CurrentSet                   */
/* @var $ClassLoaderObj ClassLoader                 */

/* @var $SqlTableListObj SqlTableList               */
/* @var $UserObj User                               */
/* @var $WebSiteObj WebSite                         */
/* @var $DocumentDataObj DocumentData               */
/* @var $ThemeDataObj ThemeData                     */

/* @var $Content String                             */
/* @var $Block String                               */
/* @var $infos Array                                */
/* @var $l String                                   */
/*Hydre-IDE-end*/

// --------------------------------------------------------------------------------------------
//		Installation page 02
// --------------------------------------------------------------------------------------------
class InstallPage02
{
	private static $Instance = null;
	private $form = array();
	private $createScript = array();
	private $installationStartTime = 0;
	private $errorRaised;

	public function __construct()
	{
		$this->installationStartTime = time();
	}

	/**
	 * Singleton : Will return the instance of this class.
	 * @return InstallPage02
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new InstallPage02();
		}
		return self::$Instance;
	}

	/**
	 * Renders the page 02 content
	 */
	public function render($infos)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->ThemeDataObj;

		// We make sure '00_hydre' directory is the first in the list.
		$dl = $bts->RequestDataObj->getRequestDataEntry('directory_list');
		ksort($dl);
		$bts->RequestDataObj->setRequestDataEntry('directory_list', $dl);
		unset($dl);

		$langFile = $infos['module']['module_directory'] . "i18n/" . $CurrentSetObj->getDataEntry('language') . ".php";
		$bts->I18nTransObj->apply(array("type" => "file", "file" => $langFile, "format" => "php"));

		// Initialisation script to create DB and 1 user
		$this->initSDDM();
		$qs = $this->databaseInitialization();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : databaseInitialization() completed"));


		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . "cfg/db/type=" . $bts->CMObj->getConfigurationSubEntry('db', 'type')));
		$SqlSequence = array();
		switch ($bts->CMObj->getConfigurationSubEntry('db', 'type')) {
			case "mysql":
			default:
				$SqlSequence = array(
					"COMMIT;",
					"USE " . $bts->CMObj->getConfigurationSubEntry('db', 'dbprefix') . ";"
				);
				break;
			case "pgsql":
				$SqlSequence = array(
					"COMMIT;",
					"SET SCHEMA '" . $bts->CMObj->getConfigurationSubEntry('db', 'dbprefix') . "';"
				);
				break;
		}

		$qs = array_merge($qs, $this->databaseUserConfiguration(), $SqlSequence);
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . "Query list:" . $bts->StringFormatObj->arrayToString($qs)));

		if ($this->processQueryScript($qs) == false) {
			$this->errorRaised = true;
		};

		$bts->InitCommandConsole();

		$ClassLoaderObj = ClassLoader::getInstance();
		$ClassLoaderObj->provisionClass('LibInstallation');
		$LibInstallationObj = LibInstallation::getInstance();
		$t = time();
		$LibInstallationObj->setReport(array(
			"lastReportExecution" => $t,
			"lastReportExecutionSaved" => $t,
		));

		$this->processFileCreateTable();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : processFileCreateTable() completed"));

		// We could not store into DB informations about table creation. Now we can.
		$tab = $LibInstallationObj->getReport();
		foreach ($tab['tables_creation'] as $k => $v) {
			$bts->SDDMObj->query(
				"INSERT INTO " . $CurrentSetObj->SqlTableListObj->getSQLTableName('installation_report') . " VALUES ("
					. "'" . $bts->SDDMObj->createUniqueId() . "', "
					. "'tables_creation', "
					. "'" . $k . "', "
					. "'" . $v['OK'] . "', "
					. "'" . $v['WARN'] . "', "
					. "'" . $v['ERR'] . "', "
					. "'" . $v['start'] . "', "
					. "'" . $v['end'] . "', "
					. "'" . $v['sqlCount'] . "',"
					. "'0'"
					. ");"
			);
		}
		unset($tab);

		// Back to business
		$this->processFileTableData();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : processFileTableData() completed"));
		$this->installTableInitialization();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : installTableInitialization() completed"));
		$this->processFileCommandConsole();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : processFileCommandConsole() completed"));
		$this->processFileTablePostInstall();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : processFileTablePostInstall() completed"));
		$this->processFileRawSQL();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : processFileRawSQL() completed"));

		$bts->SDDMObj->query("UPDATE " . $CurrentSetObj->SqlTableListObj->getSQLTableName('installation') . " SET inst_nbr = '" . time() . "' WHERE inst_name = 'end_date';");
		$bts->SDDMObj->query("UPDATE " . $CurrentSetObj->SqlTableListObj->getSQLTableName('installation') . " SET inst_nbr = '1' WHERE inst_name = 'installationFinished';");
		$bts->SDDMObj->query("INSERT INTO " . $CurrentSetObj->SqlTableListObj->getSQLTableName('installation') . " VALUES ( 100, 0, 'installationLocked', '1', '');");
	}


	/**
	 * Initialization SDDM
	 */
	private function initSDDM()
	{
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$CurrentSetObj = CurrentSet::getInstance();

		$this->form = $bts->RequestDataObj->getRequestDataEntry('form');
		$bts->CMObj->setConfigurationEntry('operatingMode', $this->form['operatingMode']);

		// ***quality*** Revoir ce bout de tableau... n'a pas l'air de servir 
		$bts->CMObj->setConfigurationEntry(
			'db',
			array(
				"type"						=> $this->form['selectedDataBaseType'],
				"dal"						=> $this->form['dal'],
				"host"						=> $this->form['host'],
				"port"						=> $this->form['port'],
				"charset"					=> "utf8mb4",
				"user_login"				=> $this->form['dataBaseHostingPrefix'] . $this->form['dataBaseAdminUser'],
				"user_password"				=> $this->form['dataBaseAdminPassword'],
				"hosting_prefix"			=> $this->form['dataBaseHostingPrefix'],
				"dbprefix"					=> $this->form['dbprefix'],
				"tabprefix"					=> $this->form['tabprefix'],
				"dataBaseUserLogin"			=> $this->form['dataBaseHostingPrefix'] . $this->form['dataBaseUserLogin'],
				"dataBaseUserPassword"		=> $this->form['dataBaseUserPassword'],
				"websiteUserPassword"		=> $this->form['websiteUserPassword'],
				"dataBaseHostingProfile"	=> $this->form['dataBaseHostingProfile'],
				"dataBaseUserRecreate"		=> $this->form['dataBaseUserRecreate'],
				"HydrUserAlreadyExists"		=> $this->form['HydrUserAlreadyExists'],
			)
		);

		// What the configuration file would look like with the posted data.
		$bts->CMObj->setConfigurationEntry('type',					$this->form['selectedDataBaseType']);
		$bts->CMObj->setConfigurationEntry('dal',					$this->form['dal']);
		$bts->CMObj->setConfigurationEntry('host',					$this->form['host']);
		$bts->CMObj->setConfigurationEntry('port',					$this->form['port']);
		$bts->CMObj->setConfigurationEntry('charset',				"utf8mb4");
		$bts->CMObj->setConfigurationEntry('db_user_login',			$this->form['dataBaseHostingPrefix'] . $this->form['dataBaseAdminUser']);
		$bts->CMObj->setConfigurationEntry('db_user_password',		$this->form['dataBaseAdminPassword']);
		$bts->CMObj->setConfigurationEntry('dbprefix',				$this->form['dbprefix']);
		$bts->CMObj->setConfigurationEntry('tabprefix',				$this->form['tabprefix']);
		$bts->CMObj->setConfigurationEntry('execution_context',		'installation');
		$bts->CMObj->setConfigurationEntry('HydrUserAlreadyExists',	$this->form['HydrUserAlreadyExists']);


		if ($this->form['dataBaseLogErr'] == "on") {
			$bts->CMObj->setConfigurationSubEntry('debug_option', 'SQL_debug_level', 1);
		}
		if ($this->form['dataBaseLogError'] == "on") {
			$bts->CMObj->setConfigurationSubEntry('debug_option', 'SQL_debug_level', 2);
		}

		$CurrentSetObj->setSqlTableListObj(SqlTableList::getInstance($bts->CMObj->getConfigurationSubEntry('db', 'dbprefix'), $bts->CMObj->getConfigurationSubEntry('db', 'tabprefix')));

		$bts->CMObj->setConfigurationEntry('dal', $bts->CMObj->getConfigurationSubEntry('db', 'dal')); //internal copy to prepare for DAL 
		$bts->initSddmObj();

		$CurrentSetObj->SqlTableListObj->makeSqlTableList($bts->CMObj->getConfigurationSubEntry('db', 'dbprefix'), $bts->CMObj->getConfigurationSubEntry('db', 'tabprefix'));

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}

	/**
	 * Initialization of the database data
	 */
	private function databaseInitialization()
	{
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$CurrentSetObj = CurrentSet::getInstance();

		$r = array();
		switch ($bts->CMObj->getConfigurationSubEntry('db', 'dataBaseHostingProfile')) {
			case "hostplan":
				switch ($bts->CMObj->getConfigurationEntry('dal')) {
					case "PHP":
						break;	//Nothing to do : PHP
					case "PDO":
						break;	//Nothing to do : PDO
					case "SQLITE":
						break;
						// case "ADODB":
						// 	break;
						// case "PEARDB":
						// case "PEARSQLITE":
						// $r[] = "SET SESSION query_cache_type = OFF;";				// forbids cache usage
						// $r[] = "USE ".$bts->CMObj->getConfigurationEntry('dbprefix').";";
						// unset ( $A );
						// $db->loadModule('Manager');
						// foreach ( $db->listTables( $bts->CMObj->getConfigurationEntry('dbprefix') ) as $A ) { $r[] = "DROP TABLE ". $A .";"; }
						// $r[] = "FLUSH TABLES;";										// clean query_cache
						// $db->loadModule('Native');
						// break;
				}
				break;
			case "absolute":
				switch ($bts->CMObj->getConfigurationSubEntry('db', 'type')) {
					case "pgsql":
						// The chosen method for Postgres is to have a database in witch the schema is named with the forms database name
						$r[] = "DROP SCHEMA IF EXISTS " . $bts->CMObj->getConfigurationSubEntry('db', 'dbprefix') . " CASCADE;";
						$r[] = "CREATE SCHEMA " . $bts->CMObj->getConfigurationSubEntry('db', 'dbprefix') . ";";
						$r[] = "SET SCHEMA '" . $bts->CMObj->getConfigurationSubEntry('db', 'dbprefix') . "';";
						break;
					case "mysql":
					default:
						// Mysql "CHARACTER SET utf8mb4 COLLATE utf8mb4_bin" so 'é' is not equal to 'e'.
						$r[] = "DROP DATABASE IF EXISTS " . $bts->CMObj->getConfigurationSubEntry('db', 'dbprefix') . ";";	// Kill database
						$r[] = "FLUSH TABLES;";																				// clean query_cache
						$r[] = "FLUSH PRIVILEGES;";
						$r[] = "CREATE DATABASE " . $bts->CMObj->getConfigurationSubEntry('db', 'dbprefix')
							. " CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;";	// Create DB
						$r[] = "USE " . $bts->CMObj->getConfigurationSubEntry('db', 'dbprefix') . ";";						// Use it
						$r[] = "SET GLOBAL tmp_table_size = 67108864;";				// 16 777 216;
						$r[] = "SET GLOBAL max_heap_table_size = 67108864;";		// 16 777 216;
						// $r[] = "SET SESSION query_cache_type = ON;";				// clean query_cache
						// $r[] = "SET GLOBAL query_cache_size = 67108864;";		// 16 777 216;
						break;
				}

				break;
		}
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
		return ($r);
	}

	/**
	 * databaseUserConfiguration
	 */
	private function databaseUserConfiguration()
	{
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$CurrentSetObj = CurrentSet::getInstance();

		$r = array();

		// Should we recreate the user (default no) ?
		// user doesn't exist				->	0	-> create
		// user exists						->	1	-> nothing
		// Recreate / user doesn't exist 	->	2	-> drop and create
		// Recreate / user exists 			->	3	-> drop and create
		$score = 0;
		if ($bts->CMObj->getConfigurationSubEntry('db', 'HydrUserAlreadyExists') == "on") {
			$score += 1;
		}
		if ($bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserRecreate') == "yes") {
			$score += 2;
		}

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " Soring - "
		. "HydrUserAlreadyExists=" . $bts->CMObj->getConfigurationSubEntry('db', 'HydrUserAlreadyExists')
		. "; dataBaseUserRecreate=" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserRecreate')
		. "-> score=" . $score
		));

		

		switch ($bts->CMObj->getConfigurationSubEntry('db', 'type')) {
			case "mysql":
			default:
				switch ($score) {
					case 0:
						$r[] = "CREATE USER '" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserLogin') . "'@'%' IDENTIFIED BY '" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserPassword') . "';";
						$r[] = "CREATE USER '" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserLogin') . "'@'localhost' IDENTIFIED BY '" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserPassword') . "';";
						break;
					case 1:
						break;
					case 2:
					case 3:
						$r[] = "DROP USER IF EXISTS '" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserLogin') . "'@'%';";
						$r[] = "DROP USER IF EXISTS '" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserLogin') . "'@'localhost';";
						$r[] = "CREATE USER '" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserLogin') . "'@'%' IDENTIFIED BY '" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserPassword') . "';";
						$r[] = "CREATE USER '" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserLogin') . "'@'localhost' IDENTIFIED BY '" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserPassword') . "';";
						break;
				}

				$r[] = "GRANT CREATE, DROP, SELECT, INSERT, UPDATE, DELETE ON " . $bts->CMObj->getConfigurationSubEntry('db', 'dbprefix') . ".* TO '" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserLogin') . "'@'%' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;";
				$r[] = "GRANT CREATE, DROP, SELECT, INSERT, UPDATE, DELETE ON " . $bts->CMObj->getConfigurationSubEntry('db', 'dbprefix') . ".* TO '" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserLogin') . "'@'localhost' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;";
				$r[] = "FLUSH TABLES;";										// clean query_cache 
				$r[] = "FLUSH PRIVILEGES;";
				break;
			case "pgsql":
				switch ($score) {
					case 0:
						$r[] = "CREATE USER \"" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserLogin') . "\" WITH PASSWORD '" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserPassword') . "';";
						break;
					case 1:
						break;
					case 2:
					case 3:
						$r[] = "REASSIGN OWNED BY \"" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserLogin') . "\" TO pg_database_owner;"; // trusted role
						$r[] = "DROP OWNED BY \"" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserLogin') . "\";";
						$r[] = "DROP USER IF EXISTS \"" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserLogin') . "\";";
						$r[] = "CREATE USER \"" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserLogin') . "\" WITH PASSWORD '" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserPassword') . "';";
						break;
				}

				$r[] = "GRANT ALL PRIVILEGES ON DATABASE \"" . $bts->CMObj->getConfigurationSubEntry('db', 'dbprefix') . "\" TO \"" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserLogin') . "\";";
				$r[] = "GRANT ALL ON SCHEMA " . $bts->CMObj->getConfigurationSubEntry('db', 'dbprefix') . " TO \"" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserLogin') . "\";";
				$r[] = "ALTER DEFAULT PRIVILEGES IN SCHEMA " . $bts->CMObj->getConfigurationSubEntry('db', 'dbprefix') . " GRANT ALL ON TABLES TO \"" . $bts->CMObj->getConfigurationSubEntry('db', 'dataBaseUserLogin') . "\";";
				break;
		}

		// 	$monSQLn += 8;
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
		return ($r);
	}

	/**
	 * processQueryScript
	 */
	private function processQueryScript($qs)
	{
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));

		switch ($this->form['operatingMode']) {
			case 'directCnx':
				foreach ($qs as $q) {
					$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' =>  __METHOD__ . " Processing query -> '" . $q . "'."));
					$bts->SDDMObj->query($q);
				}
				break;
			case 'createScript':
				$this->createScript = array_merge($this->createScript, $qs);
				break;
		}

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}


	/**
	 * processFileCreateTable
	 */
	private function processFileCreateTable()
	{
		$CurrentSetObj = CurrentSet::getInstance();
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$LibInstallationObj = LibInstallation::getInstance();
		$infos = array(
			"path" => "websites-data/",
			"method" =>  "filename",
			"section" => "tables_creation",
			"sectionPath" => "tables_creation/" . $bts->CMObj->getConfigurationSubEntry('db', 'type'),
			"directory_list" => $bts->RequestDataObj->getRequestDataEntry('directory_list'),
			"updateInstallationMonitor" => 0
		);

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . "Scan target = '" . $infos['sectionPath'] . "'."));

		$LibInstallationObj->scanDirectories($infos);
		foreach ($infos['directory_list'] as $A) {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Processing : " . $A['name']));
			if (isset($A['filesFound'])) {
				$LibInstallationObj->executeContent($infos, $A);
			}
		}
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}

	/**
	 * processFileTableData
	 */
	private function processFileTableData()
	{
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$LibInstallationObj = LibInstallation::getInstance();

		// --------------------------------------------------------------------------------------------
		$infos = array(
			"path" => "websites-data/",
			"method" =>  "filename",
			"section" => "tables_data",
			"sectionPath" => "tables_data/" . $bts->CMObj->getConfigurationSubEntry('db', 'type'),
			"directory_list" => $bts->RequestDataObj->getRequestDataEntry('directory_list'),
			"updateInstallationMonitor" => 0
		);

		$LibInstallationObj->scanDirectories($infos);
		foreach ($infos['directory_list'] as $A) {
			if (isset($A['filesFound'])) {
				$LibInstallationObj->executeContent($infos, $A);
			}
		}
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}

	/**
	 * installTableInitialization
	 */
	private function installTableInitialization()
	{
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$LibInstallationObj = LibInstallation::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		// --------------------------------------------------------------------------------------------
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => "install_page_p02 : Initialization of table installation"));
		$SqlTableListObj = $CurrentSetObj->SqlTableListObj;
		$r = array(
			"COMMIT;",
			// "FLUSH TABLES;",
			"UPDATE " . $SqlTableListObj->getSQLTableName('installation') . " SET inst_nbr = '" . $this->installationStartTime . "' WHERE inst_name = 'start_date';",
			"UPDATE " . $SqlTableListObj->getSQLTableName('installation') . " SET inst_nbr = '" . time() . "' WHERE inst_name = 'last_activity';",
			"UPDATE " . $SqlTableListObj->getSQLTableName('installation') . " SET inst_nbr = '" . $bts->RequestDataObj->getRequestDataEntry('installToken') . "' WHERE inst_name = 'installToken';",
			"UPDATE " . $SqlTableListObj->getSQLTableName('installation') . " SET inst_nbr = '1' WHERE inst_name = 'display';",
			"COMMIT;",
		);
		$this->processQueryScript($r);
		unset($r);
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}

	/**
	 * processFileCommandConsole
	 */
	private function processFileCommandConsole()
	{
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$LibInstallationObj = LibInstallation::getInstance();
		// --------------------------------------------------------------------------------------------
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => "install_page_p02 : commandConsole"));
		$infos = array(
			"path" => "websites-data/",
			"method" =>  "commandConsole",
			"section" => "script",
			"sectionPath" => "script",
			"directory_list" => $bts->RequestDataObj->getRequestDataEntry('directory_list'),
			"updateInstallationMonitor" => 1
		);
		// error_log($bts->StringFormatObj->arrayToString($infos));
		$LibInstallationObj->scanDirectories($infos);
		foreach ($infos['directory_list'] as $A) {
			if (isset($A['filesFound'])) {
				$LibInstallationObj->executeContent($infos, $A);
			}
		}
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}


	/**
	 * processFileTablePostInstall
	 */
	private function processFileTablePostInstall()
	{
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$LibInstallationObj = LibInstallation::getInstance();
		// --------------------------------------------------------------------------------------------
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => "install_page_p02 : tables_post_install"));
		$infos = array(
			"path" => "websites-data/",
			"method" =>  "filename",
			"section" => "tables_post_install",
			"sectionPath" => "tables_post_install/" . $bts->CMObj->getConfigurationSubEntry('db', 'type'),
			"directory_list" => $bts->RequestDataObj->getRequestDataEntry('directory_list'),
			"updateInstallationMonitor" => 1
		);
		$LibInstallationObj->scanDirectories($infos);
		// error_log($bts->StringFormatObj->arrayToString($infos));
		foreach ($infos['directory_list'] as $A) {
			if (isset($A['filesFound'])) {
				$LibInstallationObj->executeContent($infos, $A);
			}
		}
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}

	/**
	 * processFileRawSQL
	 */
	private function processFileRawSQL()
	{
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$LibInstallationObj = LibInstallation::getInstance();
		// --------------------------------------------------------------------------------------------
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => "install_page_p02 : raw_sql"));
		$infos = array(
			"path" => "websites-data/",
			"method" =>  "raw_sql",
			"section" => "raw_sql",
			"sectionPath" => "raw_sql/" . $bts->CMObj->getConfigurationSubEntry('db', 'type'),
			"directory_list" => $bts->RequestDataObj->getRequestDataEntry('directory_list'),
			"updateInstallationMonitor" => 0
		);
		$LibInstallationObj->scanDirectories($infos);
		foreach ($infos['directory_list'] as $A) {
			if (isset($A['filesFound'])) {
				$LibInstallationObj->executeContent($infos, $A);
			}
		}
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}
}
