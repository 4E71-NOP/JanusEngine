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
// Some definitions in order to ease the IDE work.
/* $CMObj ConfigurationManagement              */
/* $LMObj LogManagement                        */
/* $MapperObj Mapper                           */
/* $InteractiveElementsObj InteractiveElements */
/* $RenderTablesObj RenderTables               */
/* $RequestDataObj RequestData                 */
/* $SDDMObj DalFacade                          */
/* $StringFormatObj StringFormat               */

/*Hydre-IDE-end*/

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
	private $T = array();
	private $form = array();
	private $createScript= array();
	private $errorRaised = false;
	private $installationStartTime = 0;
	private $tabConfigFile = array();

	public function __construct() {
		$this->installationStartTime = time();
	}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return InstallPage01
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
		$ThemeDataObj = $CurrentSetObj->getInstanceOfThemeDataObj ();
		$GeneratedScriptObj = $CurrentSetObj->getInstanceOfGeneratedScriptObj ();
		$Block = $ThemeDataObj->getThemeName().$infos['block'];
		$Content = "";

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

		// $Content  = $bts->StringFormatObj->print_r_html($qs);
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
			$bts->SDDMObj->query("INSERT INTO ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('installation_report'). " VALUES ("
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
		$this->processFileRenderConfigFile();

		$bts->SDDMObj->query("UPDATE ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('installation')." SET inst_nbr = '".time()."' WHERE inst_name = 'end_date';");
		$bts->SDDMObj->query("UPDATE ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('installation')." SET inst_nbr = '1' WHERE inst_name = 'installationFinished';");
		
		// --------------------------------------------------------------------------------------------
		$CurrentTab = 1;
		$lt = 1;
		$ClassLoaderObj->provisionClass('LibInstallationReport');
		$LibInstallationReportObj = LibInstallationReport::getInstance();
		$installationReport = $LibInstallationObj->getReport();
		
		sort ( $installationReport['tables_creation']);
		sort ( $installationReport['tables_data']);
		sort ( $installationReport['script']);
		sort ( $installationReport['tables_post_install']);
		
		$style1 = array (
			"block" => $Block,
			"titles" => array(
				$bts->I18nTransObj->getI18nTransEntry('t1c1'),	
				$bts->I18nTransObj->getI18nTransEntry('t1c2'),	
				$bts->I18nTransObj->getI18nTransEntry('t1c3'),
				$bts->I18nTransObj->getI18nTransEntry('t1c4'),
				$bts->I18nTransObj->getI18nTransEntry('t1c5'),
				$bts->I18nTransObj->getI18nTransEntry('t1c6'),
				$bts->I18nTransObj->getI18nTransEntry('t1c7'),
			),
			"cols" => array( 'file', 'OK', 'WARN', 'ERR'),
		);
		$style2 = array (
			"block" => $Block,
			"tc"=>1,
			"titles" => array($bts->I18nTransObj->getI18nTransEntry('t9c1'),	$bts->I18nTransObj->getI18nTransEntry('t9c2'),	$bts->I18nTransObj->getI18nTransEntry('t9c3'),	$bts->I18nTransObj->getI18nTransEntry('t9c4'),	$bts->I18nTransObj->getI18nTransEntry('t9c5'),	),
			"cols" => array('temps_debut', 'nbr', 'nom', 'signal', 'err_no', 'err_msg', 'temps_fin'),
		);
		
		// --------------------------------------------------------------------------------------------
		$this->T['ContentCfg']['tabs'] = array();
		
		// --------------------------------------------------------------------------------------------
		$this->T['ContentCfg']['tabs'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig($LibInstallationReportObj->getInstallSectionLineCount('tables_creation')+2,7,1);
		$this->T['Content'][$CurrentTab] = $LibInstallationReportObj->renderReport( 'tables_creation'		, $style1 );
		$CurrentTab++;
		
		// --------------------------------------------------------------------------------------------
		$this->T['ContentCfg']['tabs'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig($LibInstallationReportObj->getInstallSectionLineCount('tables_data')+2,7,1);
		$this->T['Content'][$CurrentTab] = $LibInstallationReportObj->renderReport( 'tables_data'			, $style1 );
		$CurrentTab++;
		
		// --------------------------------------------------------------------------------------------
		$this->T['ContentCfg']['tabs'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig($LibInstallationReportObj->getInstallSectionLineCount('script')+2,7,1);
		$this->T['Content'][$CurrentTab] = $LibInstallationReportObj->renderReport( 'script'				, $style1 );
		$CurrentTab++;
		
		// --------------------------------------------------------------------------------------------
		$this->T['ContentCfg']['tabs'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig($LibInstallationReportObj->getInstallSectionLineCount('tables_post_install')+2,7,1);
		$this->T['Content'][$CurrentTab] = $LibInstallationReportObj->renderReport( 'tables_post_install'	, $style1 );
		$CurrentTab++;
		
		// --------------------------------------------------------------------------------------------
		$this->T['ContentCfg']['tabs'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig($LibInstallationReportObj->getInstallSectionLineCount('raw_sql')+2,7,1);
		$this->T['Content'][$CurrentTab] = $LibInstallationReportObj->renderReport( 'raw_sql'				, $style1 );
		$CurrentTab++;
		
		// --------------------------------------------------------------------------------------------
		$tmp = $LibInstallationReportObj->renderPerfomanceReport();
		$this->T['Content'][$CurrentTab] = $tmp['content'];
		$this->T['ContentCfg']['tabs'] [$CurrentTab]= $tmp['config'];
		unset ($tmp);
		
		// error_log ("adcTab06: " . $bts->StringFormatObj->arrayToString($adcTab06));
		// error_log ("\$this->T['Content'][\$CurrentTab]: " . $bts->StringFormatObj->arrayToString($this->T['Content'][$CurrentTab]));
		$CurrentTab++;
		// --------------------------------------------------------------------------------------------
		$SB = array();
		$SB['id']				= "SelectBtn";
		$SB['type']				= "button";
		$SB['initialStyle']		= $Block."_tb3 ".$Block."_submit_s1_n";
		$SB['hoverStyle']		= $Block."_tb3 ".$Block."_submit_s2_h";
		$SB['onclick']			= "";
		$SB['message']			= $bts->I18nTransObj->getI18nTransEntry('BtnSelect');
		$SB['mode']				= 1;
		$SB['size'] 			= 92;
		$SB['lastSize']			= 92;
		
		$this->T['ContentCfg']['tabs'][$CurrentTab] = $bts->RenderTablesObj->getDefaultTableConfig(count($this->tabConfigFile)+1 ,4,6);
		$this->T['Content'][$CurrentTab]['1']['1']['cont'] = $bts->I18nTransObj->getI18nTransEntry('t5c1');
		$Cl = 2;
		foreach ($this->tabConfigFile as $A ) {
			$SB['id']		=	"SelectBtn".$A['name'];
			$SB['onclick']	=	"elm.Gebi('txtConfig_".$A['name']."').select()";
			$this->T['Content'][$CurrentTab][$Cl]['1']['cont'] = 
					"
					<table style=' width:100%; border-spacing: 4px;'>\r
					<tr>\r
					<td colspan='2'>\rcurrent/config/current/site_".$A['n']."_config.php (for ".$A['name'].")</td>\r
					</tr>\r
		
					<tr>\r
					<td colspan='2'>\r
					<textarea id='txtConfig_".$A['name']."' cols='100' rows='10'>".$A['cont']."</textarea>
					</td>\r
					</tr>\r
		
					<tr>\r
					<td style='width:80%'>&nbsp;</td>\r
					<td>\r".$bts->InteractiveElementsObj->renderSubmitButton($SB)."</td>\r
					</tr>\r
					</table>\r
					"
					;
			$Cl++;
		}
		$ADC['tabs'][$CurrentTab]['NbrOfLines'] = $Cl-1;
		$CurrentTab++;
		
		
		// --------------------------------------------------------------------------------------------
		//
		//	Display
		//
		//
		// --------------------------------------------------------------------------------------------
		// $fontSizeRange = $ThemeDataObj->getThemeBlockEntry($infos['blockT'],'txt_fonte_size_max') - $ThemeDataObj->getThemeBlockEntry($infos['blockT'],'txt_fonte_size_min');
		
		$infos = array(
				"mode" => 1,
				"module_display_mode" => "normal",
				"module_z_index" => 2,
				"block" => "B02",
				"blockG" => "B02G",
				"blockT" => "B02T",
				"deco_type" => 50,
				"fontSizeMin" => 10,
				"fontCoef" => 2,
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
		
		$this->T['ContentInfos'] = $bts->RenderTablesObj->getDefaultDocumentConfig($infos, 25, $CurrentTab-1);
		$this->T['ContentInfos']['tabTxt1']			= $bts->I18nTransObj->getI18nTransEntry('tab_1');
		$this->T['ContentInfos']['tabTxt2']			= $bts->I18nTransObj->getI18nTransEntry('tab_2');
		$this->T['ContentInfos']['tabTxt3']			= $bts->I18nTransObj->getI18nTransEntry('tab_3');
		$this->T['ContentInfos']['tabTxt4']			= $bts->I18nTransObj->getI18nTransEntry('tab_4');
		$this->T['ContentInfos']['tabTxt5']			= $bts->I18nTransObj->getI18nTransEntry('tab_5');
		$this->T['ContentInfos']['tabTxt6']			= $bts->I18nTransObj->getI18nTransEntry('tab_6');
		$this->T['ContentInfos']['tabTxt7']			= $bts->I18nTransObj->getI18nTransEntry('tab_7');
		$this->T['ContentInfos']['tabTxt8']			= $bts->I18nTransObj->getI18nTransEntry('tab_8');
		
		$Content .= $bts->RenderTablesObj->render($infos, $this->T);
		return ($Content);
	}


	/**
	 * Initialization SDDM
	 */
	private function initSDDM() {
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
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

		$CurrentSetObj->setInstanceOfSqlTableListObj( SqlTableList::getInstance( $bts->CMObj->getConfigurationSubEntry('db','dbprefix'), $bts->CMObj->getConfigurationSubEntry('db', 'tabprefix') ));

		$bts->CMObj->setConfigurationEntry('dal', $bts->CMObj->getConfigurationSubEntry('db', 'dal') ); //internal copy to prepare for DAL 
		$bts->initSddmObj();

		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}

	/**
	 * Initialization of the database data
	 */
	private function databaseInitialization() {
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
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
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
		return ($r);
	}

	/**
	 * databaseUserRecreate
	 */
	private function databaseUserRecreate(){
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
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
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
		return ($r);
	}

	/**
	 * processQueryScript
	 */
	private function processQueryScript($qs) {
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));

		switch ( $this->form['operantingMode']) {
			case 'directCnx':
				foreach ( $qs as $q ){ $bts->SDDMObj->query($q); }
				break;
			case 'createScript':
				$this->createScript = array_merge($this->createScript, $qs);
				break;
		}
		
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}


	/**
	 * processFileCreateTable
	 */
	private function processFileCreateTable(){
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
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
			$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Processing : " .$A['name']));
			if ( isset ($A['filesFound'] ) ) {
				$LibInstallationObj->executeContent($infos, $A);
			}
		}
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}

	/**
	 * processFileTableData
	 */
	private function processFileTableData(){
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
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
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}

	/**
	 * installTableInitialization
	 */
	private function installTableInitialization(){
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$LibInstallationObj = LibInstallation::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		// --------------------------------------------------------------------------------------------
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => "install_page_p02 : Initialization of table installation"));
		$SqlTableListObj = $CurrentSetObj->getInstanceOfSqlTableListObj();
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
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}
	
	/**
	 * processFileCommandConsole
	 */
	private function processFileCommandConsole(){
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$LibInstallationObj = LibInstallation::getInstance();
		// --------------------------------------------------------------------------------------------
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "install_page_p02 : commandConsole"));
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
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}


	/**
	 * processFileTablePostInstall
	 */
	private function processFileTablePostInstall(){
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$LibInstallationObj = LibInstallation::getInstance();
		// --------------------------------------------------------------------------------------------
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "install_page_p02 : tables_post_install"));
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
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}
	
	/**
	 * processFileRawSQL
	 */
	private function processFileRawSQL(){
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$LibInstallationObj = LibInstallation::getInstance();
		// --------------------------------------------------------------------------------------------
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => "install_page_p02 : raw_sql"));
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
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}	

	/**
	 * processFileRenderConfigFile
	 */
	private function processFileRenderConfigFile(){
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		$LibInstallationObj = LibInstallation::getInstance();
		// --------------------------------------------------------------------------------------------
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => "install_page_p02 : renderConfigFile"));
		$this->tabConfigFile = array();
		$i=0;
		$infos = array (
			"path" => "websites-data/",
			"method" =>  "",
			"section" => "",
			"directory_list" => $bts->RequestDataObj->getRequestDataEntry('directory_list'),
			"updateInsdtallationMonitor" => 0
		);
		$LibInstallationObj->scanDirectories($infos);

		foreach ( $infos['directory_list'] as $k => $v ) {
			// if ( isset ($A['filesFound'] ) ) {
				$infos = array ( "n" => $i, );
				$this->tabConfigFile[$i]['n'] = $i;
				$this->tabConfigFile[$i]['name'] = $k;
				$this->tabConfigFile[$i]['cont'] = $LibInstallationObj->renderConfigFile($infos);
			// }
			$i++;
		}
		$bts->LMObj->InternalLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}
		

}
?>
