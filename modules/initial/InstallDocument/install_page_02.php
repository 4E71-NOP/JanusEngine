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
class InstallPage02 {
	private static $Instance = null;
	private $form = array();
	private $createScript= array();
	private $installationStartTime = 0;
	private $errorRaised;

	public function __construct() {
		$this->installationStartTime = time();
	}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return InstallPage02
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new InstallPage02 ();
		}
		return self::$Instance;
	}

	/**
	 * Renders the page 02 content
	 */
	public function render($infos) {
		$bts = BaseToolSet::getInstance(); 
		$CurrentSetObj = CurrentSet::getInstance();
		$ThemeDataObj = $CurrentSetObj->ThemeDataObj;

		// We make sure '00_hydre' directory is the first in the list.
		$dl = $bts->RequestDataObj->getRequestDataEntry('directory_list');
		ksort($dl);
		$bts->RequestDataObj->setRequestDataEntry('directory_list', $dl);
		unset ($dl);

		$langFile = $infos['module']['module_directory']."i18n/".$CurrentSetObj->getDataEntry ('language').".php";
		$bts->I18nTransObj->apply(array( "type" => "file", "file" => $langFile , "format" => "php" ));

		// Initialisation script to create DB and 1 user
		$this->initSDDM();
		$qs = $this->databaseInitialization();
		$qs = array_merge(
			$qs , 
			$this->databaseUserRecreate(), 
			array (
				"COMMIT;",
				"USE ".$bts->CMObj->getConfigurationSubEntry('db','dbprefix').";"
			)
		);

		if ( $this->processQueryScript($qs) == false)  { $this->errorRaised = true;	};

		$bts->InitCommandConsole();

		$ClassLoaderObj = ClassLoader::getInstance ();
		$ClassLoaderObj->provisionClass('LibInstallation');
		$LibInstallationObj = LibInstallation::getInstance();
		$t = time();
		$LibInstallationObj->setReport(array(
			"lastReportExecution"=> $t,
			"lastReportExecutionSaved"=> $t,
		));
		
		$this->processFileCreateTable();

		// We could not store into DB informations about table creation. Now we can.
		$tab = $LibInstallationObj->getReport();
		foreach ( $tab['tables_creation'] as $k => $v )  {
			$bts->SDDMObj->query("INSERT INTO ".$CurrentSetObj->SqlTableListObj->getSQLTableName('installation_report'). " VALUES ("
			."'".$bts->SDDMObj->createUniqueId()."', "
			."'tables_creation', "
			."'".$k."', "
			."'".$v['OK']."', "
			."'".$v['WARN']."', "
			."'".$v['ERR']."', "
			."'".$v['start']."', "
			."'".$v['end']."', "
			."'".$v['sqlCount']."',"
			."'0'"
			.");"
			);
		}
		unset ($tab);

		// Back to business
		$this->processFileTableData();
		$this->installTableInitialization();
		$this->processFileCommandConsole();
		$this->processFileTablePostInstall();
		$this->processFileRawSQL();

		$bts->SDDMObj->query("UPDATE ".$CurrentSetObj->SqlTableListObj->getSQLTableName('installation')." SET inst_nbr = '".time()."' WHERE inst_name = 'end_date';");
		$bts->SDDMObj->query("UPDATE ".$CurrentSetObj->SqlTableListObj->getSQLTableName('installation')." SET inst_nbr = '1' WHERE inst_name = 'installationFinished';");
		$bts->SDDMObj->query("INSERT INTO ".$CurrentSetObj->SqlTableListObj->getSQLTableName('installation')." VALUES ( 100, 0, 'installationLocked', '1', '');");

	}


	/**
	 * Initialization SDDM
	 */
	private function initSDDM() {
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$CurrentSetObj = CurrentSet::getInstance();
		
		$this->form = $bts->RequestDataObj->getRequestDataEntry('form');
		$bts->CMObj->setConfigurationEntry('operantingMode', $this->form['operantingMode'] );

		// ***quality*** Revoir ce bout de tableau... n'a pas l'air de servir 
		$bts->CMObj->setConfigurationEntry('db',
			array(
				"type"						=> $this->form['selectedDataBaseType'],
				"dal"						=> $this->form['dal'],
				"host"						=> $this->form['host'],
				"user_login"				=> $this->form['dataBaseHostingPrefix'].$this->form['dataBaseAdminUser'],
				"user_password"				=> $this->form['dataBaseAdminPassword'],
				"hosting_prefix"			=> $this->form['dataBaseHostingPrefix'],
				"dbprefix"					=> $this->form['dbprefix'],
				"tabprefix"					=> $this->form['tabprefix'],
				"dataBaseUserLogin"			=> $this->form['dataBaseHostingPrefix'].$this->form['dataBaseUserLogin'],
				"dataBaseUserPassword"		=> $this->form['dataBaseUserPassword'],
				"websiteUserPassword"		=> $this->form['websiteUserPassword'],
				"dataBaseHostingProfile"	=> $this->form['dataBaseHostingProfile'],
				"dataBaseUserRecreate"		=> $this->form['dataBaseUserRecreate'],
			)
		);

		$bts->CMObj->setConfigurationEntry('type',					$this->form['selectedDataBaseType']);
		$bts->CMObj->setConfigurationEntry('host',					$this->form['host']);
		$bts->CMObj->setConfigurationEntry('dal',					$this->form['dal']);
		$bts->CMObj->setConfigurationEntry('db_user_login',			$this->form['dataBaseHostingPrefix'].$this->form['dataBaseAdminUser'] );
		$bts->CMObj->setConfigurationEntry('db_user_password',		$this->form['dataBaseAdminPassword']);
		$bts->CMObj->setConfigurationEntry('dbprefix',				$this->form['dbprefix']);
		$bts->CMObj->setConfigurationEntry('tabprefix',				$this->form['tabprefix']);

		$bts->CMObj->setConfigurationEntry('execution_context',		'installation');


		if ( $this->form['dataBaseLogErr'] == "on" )	{ $bts->CMObj->setConfigurationSubEntry('debug_option', 'SQL_debug_level', 1); }
		if ( $this->form['dataBaseLogError'] == "on" )	{ $bts->CMObj->setConfigurationSubEntry('debug_option', 'SQL_debug_level', 2); }

		$CurrentSetObj->setSqlTableListObj( SqlTableList::getInstance( $bts->CMObj->getConfigurationSubEntry('db','dbprefix'), $bts->CMObj->getConfigurationSubEntry('db', 'tabprefix') ));

		$bts->CMObj->setConfigurationEntry('dal', $bts->CMObj->getConfigurationSubEntry('db', 'dal') ); //internal copy to prepare for DAL 
		$bts->initSddmObj();

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}

	/**
	 * Initialization of the database data
	 */
	private function databaseInitialization() {
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$CurrentSetObj = CurrentSet::getInstance();

		$r = array();
		switch ( $bts->CMObj->getConfigurationSubEntry('db','dataBaseHostingProfile') ) {
		case "hostplan":
			switch ( $bts->CMObj->getConfigurationEntry('dal') ) {
			case "MYSQLI":		break;	//Nothing to do : PHP
			case "PDOMYSQL":	break;	//Nothing to do : PHP
			case "SQLITE":		break;
			case "ADODB":		break;
			case "PEARDB":			
			case "PEARSQLITE":
				// $r[] = "SET SESSION query_cache_type = OFF;";				// forbids cache usage
				// $r[] = "USE ".$bts->CMObj->getConfigurationEntry('dbprefix').";";
				// unset ( $A );
				// $db->loadModule('Manager');
				// foreach ( $db->listTables( $bts->CMObj->getConfigurationEntry('dbprefix') ) as $A ) { $r[] = "DROP TABLE ". $A .";"; }
				// $r[] = "FLUSH TABLES;";										// clean query_cache
				// $db->loadModule('Native');
			break;
			}
		break; 
		case "absolute":
			$r[] = "DROP DATABASE IF EXISTS ".$bts->CMObj->getConfigurationSubEntry('db','dbprefix').";";	// Kill database
			$r[] = "FLUSH TABLES;";										// clean query_cache
			$r[] = "FLUSH PRIVILEGES;";
			$r[] = "CREATE DATABASE ".$bts->CMObj->getConfigurationSubEntry('db','dbprefix').";";				// Create DB
			$r[] = "USE ".$bts->CMObj->getConfigurationSubEntry('db','dbprefix').";";							// Use it
			// $r[] = "SET SESSION query_cache_type = ON;";				// clean query_cache
			// $r[] = "SET GLOBAL query_cache_size = 67108864;";			// 16 777 216;
			$r[] = "SET GLOBAL tmp_table_size = 67108864;";				// 16 777 216;
			$r[] = "SET GLOBAL max_heap_table_size = 67108864;";		// 16 777 216;

		// 	$monSQLn += 9;
		break;
		}
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
		return ($r);
	}

	/**
	 * databaseUserRecreate
	 */
	private function databaseUserRecreate(){
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$CurrentSetObj = CurrentSet::getInstance();
		$r = array();
		switch ( $bts->CMObj->getConfigurationSubEntry('db','dataBaseUserRecreate') ) {
			case "yes":
				$r[] = "DROP USER IF EXISTS '".$bts->CMObj->getConfigurationSubEntry('db','dataBaseUserLogin')."'@'%';";
				$r[] = "DROP USER IF EXISTS '".$bts->CMObj->getConfigurationSubEntry('db','dataBaseUserLogin')."'@'localhost';";
				$r[] = "CREATE USER '".$bts->CMObj->getConfigurationSubEntry('db','dataBaseUserLogin')."'@'%' IDENTIFIED BY '".$bts->CMObj->getConfigurationSubEntry('db','dataBaseUserPassword')."';";
				$r[] = "CREATE USER '".$bts->CMObj->getConfigurationSubEntry('db','dataBaseUserLogin')."'@'localhost' IDENTIFIED BY '".$bts->CMObj->getConfigurationSubEntry('db','dataBaseUserPassword')."';";
				$r[] = "GRANT CREATE, DROP, SELECT, INSERT, UPDATE, DELETE ON ".$bts->CMObj->getConfigurationSubEntry('db','dbprefix').".* TO '".$bts->CMObj->getConfigurationSubEntry('db','dataBaseUserLogin')."'@'%' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;";
				$r[] = "GRANT CREATE, DROP, SELECT, INSERT, UPDATE, DELETE ON ".$bts->CMObj->getConfigurationSubEntry('db','dbprefix').".* TO '".$bts->CMObj->getConfigurationSubEntry('db','dataBaseUserLogin')."'@'localhost' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;";
				$r[] = "FLUSH TABLES;";										// clean query_cache 
				$r[] = "FLUSH PRIVILEGES;";
			// 	$monSQLn += 8;
			break;
		}
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
		return ($r);
	}

	/**
	 * processQueryScript
	 */
	private function processQueryScript($qs) {
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));

		switch ( $this->form['operantingMode']) {
			case 'directCnx':
				foreach ( $qs as $q ){ $bts->SDDMObj->query($q); }
				break;
			case 'createScript':
				$this->createScript = array_merge($this->createScript, $qs);
				break;
		}
		
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}


	/**
	 * processFileCreateTable
	 */
	private function processFileCreateTable(){
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$LibInstallationObj = LibInstallation::getInstance();
		$infos = array (
				"path" => "websites-data/",
				"method" =>  "filename",
				"section" => "tables_creation",
				"directory_list" => $bts->RequestDataObj->getRequestDataEntry('directory_list'),
				"updateInsdtallationMonitor" => 0
		);
		
		$LibInstallationObj->scanDirectories($infos);
		foreach ( $infos['directory_list'] as $A ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Processing : " .$A['name']));
			if ( isset ($A['filesFound'] ) ) {
				$LibInstallationObj->executeContent($infos, $A);
			}
		}
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}

	/**
	 * processFileTableData
	 */
	private function processFileTableData(){
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$LibInstallationObj = LibInstallation::getInstance();

		// --------------------------------------------------------------------------------------------
		$infos = array (
				"path" => "websites-data/",
				"method" =>  "filename",
				"section" => "tables_data",
				"directory_list" => $bts->RequestDataObj->getRequestDataEntry('directory_list'),
				"updateInsdtallationMonitor" => 0
		);
		
		$LibInstallationObj->scanDirectories($infos);
		foreach ( $infos['directory_list'] as $A ) {
			if ( isset ($A['filesFound'] ) ) { $LibInstallationObj->executeContent($infos, $A);	}
		}
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}

	/**
	 * installTableInitialization
	 */
	private function installTableInitialization(){
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$LibInstallationObj = LibInstallation::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		// --------------------------------------------------------------------------------------------
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => "install_page_p02 : Initialization of table installation"));
		$SqlTableListObj = $CurrentSetObj->SqlTableListObj;
		$r = array(
				"COMMIT;",
				"FLUSH TABLES;",
				"UPDATE ".$SqlTableListObj->getSQLTableName('installation')." SET inst_nbr = '".$this->installationStartTime."' WHERE inst_name = 'start_date';",
				"UPDATE ".$SqlTableListObj->getSQLTableName('installation')." SET inst_nbr = '".time()."' WHERE inst_name = 'last_activity';",
				"UPDATE ".$SqlTableListObj->getSQLTableName('installation')." SET inst_nbr = '".$bts->RequestDataObj->getRequestDataEntry('installToken')."' WHERE inst_name = 'installToken';",
				"UPDATE ".$SqlTableListObj->getSQLTableName('installation')." SET inst_nbr = '1' WHERE inst_name = 'display';",
				"COMMIT;",
		);
		$this->processQueryScript($r);
		unset ($r);
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}
	
	/**
	 * processFileCommandConsole
	 */
	private function processFileCommandConsole(){
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$LibInstallationObj = LibInstallation::getInstance();
		// --------------------------------------------------------------------------------------------
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "install_page_p02 : commandConsole"));
		$infos = array (
				"path" => "websites-data/",
				"method" =>  "commandConsole",
				"section" => "script",
				"directory_list" => $bts->RequestDataObj->getRequestDataEntry('directory_list'),
				"updateInsdtallationMonitor" => 1
		);
		error_log($bts->StringFormatObj->arrayToString($infos));
		$LibInstallationObj->scanDirectories($infos);
		foreach ( $infos['directory_list'] as $A ) {
			if ( isset ($A['filesFound'] ) ) {
				$LibInstallationObj->executeContent($infos, $A);
			}
		}
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}


	/**
	 * processFileTablePostInstall
	 */
	private function processFileTablePostInstall(){
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$LibInstallationObj = LibInstallation::getInstance();
		// --------------------------------------------------------------------------------------------
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "install_page_p02 : tables_post_install"));
		$infos = array (
				"path" => "websites-data/",
				"method" =>  "filename",
				"section" => "tables_post_install",
				"directory_list" => $bts->RequestDataObj->getRequestDataEntry('directory_list'),
				"updateInsdtallationMonitor" => 1
		);
		$LibInstallationObj->scanDirectories($infos);
		error_log($bts->StringFormatObj->arrayToString($infos));
		foreach ( $infos['directory_list'] as $A ) {
			if ( isset ($A['filesFound'] ) ) {
				$LibInstallationObj->executeContent($infos, $A);
			}
		}
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}
	
	/**
	 * processFileRawSQL
	 */
	private function processFileRawSQL(){
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$LibInstallationObj = LibInstallation::getInstance();
		// --------------------------------------------------------------------------------------------
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => "install_page_p02 : raw_sql"));
		$infos = array (
				"path" => "websites-data/",
				"method" =>  "raw_sql",
				"section" => "raw_sql",
				"directory_list" => $bts->RequestDataObj->getRequestDataEntry('directory_list'),
				"updateInsdtallationMonitor" => 0
		);
		$LibInstallationObj->scanDirectories($infos);
		foreach ( $infos['directory_list'] as $A ) {
			if ( isset ($A['filesFound'] ) ) {
				$LibInstallationObj->executeContent($infos, $A);
			}
		}
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}	
		

}
?>
