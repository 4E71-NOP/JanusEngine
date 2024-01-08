<?php 
/*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*Hydre-licence-fin*/

class LibInstallation {
	private static $Instance = null;
	
	private $report = array();
	
	private function __construct() {}
	
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new LibInstallation();
		}
		return self::$Instance;
	}
	
	/**
	 * Scan directories and store the file list in the passed array.
	 * 
	 * @param array $infos
	 */
	public function scanDirectories ( &$infos ) {
		// $LMObj = LogManagement::getInstance();
		$bts = BaseToolSet::getInstance(); 
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));
		
		foreach ( $infos['directory_list'] as &$A ) {
			$currentDir = $A['name'];
			$dirFileList = array();
			$handle = opendir( $infos['path'].$currentDir."/".$infos['section']."/" );
			// $LMObj->logDebug($infos['path'].$currentDir."/".$infos['section']."/<br>\r",0);
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " Processing : ".$infos['path'].$currentDir."/".$infos['section']."/"));
			
			// $infos['opendir'] = $handle;
			if ( $A['state'] == "on" && $handle != null ) {
				while (false !== ($file = readdir($handle))) {
					$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " Processing file : ".$file));
					$acd_ERR = 0;
					if ( $file == "." || $file == ".." ) { $acd_ERR = 1; }
					if ( strpos($file, ".save" ) != FALSE ) { $acd_ERR = 1; }
					if ( strpos($file, "*.*~" ) != FALSE ) { $acd_ERR = 1; }
					if ( $acd_ERR == 0 ) { $dirFileList[] = $file; }
				}
				closedir($handle);
				sort ($dirFileList);
				reset ($dirFileList);
				$A['filelist'] = $dirFileList;
				$A['filesFound'] = 1;
			}
		}
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}

	/**
	 * Execute the commands found in each file listed in the array. 
	 * 
	 * @param array $infos
	 * @param array $list
	 */
	public function executeContent (&$infos, &$list) {
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Begin"));

		foreach ( $list['filelist'] as $A ) {
			$infos['currentFileName'] = $A;
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Processing : " .$infos['currentFileName']));
			
			$path = $infos['path'].$list['name']."/".$infos['section']."/".$A;
			$infos['currentTableName']= $bts->CMObj->getConfigurationEntry('tabprefix') . str_replace(".sql" , "" , $A );
			$infos['currentFileStat'] = stat($path);
			$infos['currentFileContent'] = file($path);
			$infos['TabAnalyse'] = array();
			
			$this->report[$infos['section']][$infos['currentFileName']]['file'] = $list['name'] ."/".$infos['currentFileName'];
			$this->report[$infos['section']][$infos['currentFileName']]['OK']	= 0;	
			$this->report[$infos['section']][$infos['currentFileName']]['WARN']	= 0;	
			$this->report[$infos['section']][$infos['currentFileName']]['ERR']	= 0;	
			
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : processing file : `".$this->report[$infos['section']][$infos['currentFileName']]['file']."`"));
			
			unset ( $infos['FormattedCommand']);
			switch ( $infos['method'] ) {
				case "namedTable":
				case "filename":
					$this->methodFilename($infos);
					break;
				case "commandConsole":
					$this->methodCommand($infos);
					break;
				case "raw_sql":
					$this->methodRawSql($infos);
					break;
			}
		}
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}

	/**
	 * Load a file, call for formatting methods and execute the SQL commands.
	 * 
	 * @param array $infos
	*/
	private function methodFilename (&$infos) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance ();
		$ClassLoaderObj->provisionClass ('ScriptFormatting');
		$ScriptFormattingObj = ScriptFormatting::getInstance();

		$Tmp = "";
		foreach ( $infos['currentFileContent'] as $L => $C ) { $Tmp .= $C; }
		$infos['currentFileContent'] = $Tmp;
		
		$TabSrch = array ( "!table!",							"!IdxNom!",					"\n",	"	",	"*/",	chr(13) );	//
		$TabRpl = array ( "`".$infos['currentTableName']."`",	$infos['currentTableName'],	"",		" ",	"*/\n",	" " );		// "`" est utilisé pour le fichier "tl_--.sql" Le nom de table doit être encadré.
		$infos['currentFileContent'] = str_replace ($TabSrch,$TabRpl,$infos['currentFileContent']);
		unset ( $TabSrch, $TabRpl );
		
		$ScriptFormattingObj->createMap($infos);
		$ScriptFormattingObj->commandFormatting ($infos);
		$timeStart = $bts->TimeObj->getHrtime();
		$sqlCount = 0;
		foreach ( $infos['FormattedCommand'] as $C ) {
			if ( !isset($C['ordre']) ) {
				$bts->SDDMObj->query($C['cont']);
				$res = $bts->LMObj->getLastSQLDetails();
				switch ( $res['signal'] ) {
					case "OK" :			$this->report[$infos['section']][$infos['currentFileName']]['OK']++;	break;
					case "WARN" :		$this->report[$infos['section']][$infos['currentFileName']]['WARN']++;	break;
					case "ERR" :		$this->report[$infos['section']][$infos['currentFileName']]['ERR']++;	break;
				}
				$this->report['lastReportExecution'] = time();
				if ( $infos['updateInsdtallationMonitor'] == 1 ) { $this->updateInsdtallationMonitor(); }
				$sqlCount++;
			}
		}

		// Store data for later use
		$this->report[$infos['section']][$infos['currentFileName']]['sqlCount'] = $sqlCount;
		$this->report[$infos['section']][$infos['currentFileName']]['start'] = $timeStart;
		$this->report[$infos['section']][$infos['currentFileName']]['end'] = $bts->TimeObj->getHrtime();

		$bts->SDDMObj->query("FLUSH TABLES;");
		$bts->SDDMObj->query("COMMIT;");

		// If DB is ready we store directly into DB. Thank you captain obvious.
		if ( $infos['section'] != 'tables_creation' ) { 
			$bts->SDDMObj->query("INSERT INTO ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('installation_report'). " VALUES ("
			."'".$bts->SDDMObj->createUniqueId()."', "
			."'".$infos['section']."', "
			."'".$this->report[$infos['section']][$infos['currentFileName']]['file']."', "
			."'".$this->report[$infos['section']][$infos['currentFileName']]['OK']."', "
			."'".$this->report[$infos['section']][$infos['currentFileName']]['WARN']."', "
			."'".$this->report[$infos['section']][$infos['currentFileName']]['ERR']."', "
			."'".$timeStart."', "
			."'".$bts->TimeObj->getHrtime()."', "
			."'".$sqlCount."',"
			."'0'"
			.");"
			);	
		}
	}
	
	/**
	 * Load a file, call for formatting methods and execute the Hydr commands.
	 * 
	 * @param array $infos
	 */
	private function methodCommand (&$infos) {
		$CommandConsole = CommandConsole::getInstance();
		$bts = BaseToolSet::getInstance(); 
		$ClassLoaderObj = ClassLoader::getInstance ();
		$ClassLoaderObj->provisionClass ('ScriptFormatting');
		$ScriptFormattingObj = ScriptFormatting::getInstance();
		
		$Tmp = '';
		foreach ( $infos['currentFileContent'] as $L => $C ) { $Tmp .= $C; }
		$infos['currentFileContent'] = $Tmp;
		
		$ScriptFormattingObj->createMap($infos);
		$ScriptFormattingObj->commandFormatting ($infos);
		
		$timeStart = $bts->TimeObj->getHrtime();
		$sqlCount = $CommandConsole->getReportEntry('executionPerformed');
		$commandCount = 0;
		foreach ( $infos['FormattedCommand'] as $C ) {
			// The space case happens when some tab & spaces are after a ";" and no command is found before EOF.
			if ( !isset($C['ordre']) && $C['cont'] != " " ) {
				$CommandConsole->executeCommand($C['cont']);
				
				switch ( $CommandConsole->getReportEntry('signal') ) {
					case "OK" :		$this->report[$infos['section']][$infos['currentFileName']]['OK']++;	break;
					case "WARN" :	$this->report[$infos['section']][$infos['currentFileName']]['WARN']++;	break;
					case "ERR" :	$this->report[$infos['section']][$infos['currentFileName']]['ERR']++;	break;
				}
				// error_log ( "executeCommand: signal=".$CommandConsole->getReportEntry('signal').";section=".$infos['section']."; currentFileName=".$infos['currentFileName']."; OK=" .$this->report[$infos['section']][$infos['currentFileName']]['OK']. "; WARN=" .$this->report[$infos['section']][$infos['currentFileName']]['WARN']. "; ERR=" . $this->report[$infos['section']][$infos['currentFileName']]['ERR'] );
				$this->report['lastReportExecution'] = time();
				$this->updateInsdtallationMonitor();
				
				$CurrentSetObj= CurrentSet::getInstance();
				if ( $CurrentSetObj->getDataSubEntry('cli', 'websiteCreation') == 1) {
					$SpecialCommandBuffer = $CurrentSetObj->getDataSubEntry('cli', 'websiteCreationCmd');
					foreach ( $SpecialCommandBuffer as $S ) { 
						$CommandConsole->executeCommand($S);
						switch ( $CommandConsole->getReportEntry('signal') ) {
							case "OK" :		$this->report[$infos['section']][$infos['currentFileName']]['OK']++;	break;
							case "WARN" :	$this->report[$infos['section']][$infos['currentFileName']]['WARN']++;	break;
							case "ERR" :	$this->report[$infos['section']][$infos['currentFileName']]['ERR']++;	break;
						}
						$this->report['lastReportExecution'] = time();
						if ( $infos['updateInsdtallationMonitor'] == 1 ) { $this->updateInsdtallationMonitor(); }
					}
					$CurrentSetObj->setDataSubEntry('cli', 'websiteCreation', 0);
				}
				$commandCount++;
			}
		}

		$bts->SDDMObj->query("INSERT INTO ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('installation_report'). " VALUES ("
		."'".$bts->SDDMObj->createUniqueId()."', "
		."'".$infos['section']."', "
		."'".$this->report[$infos['section']][$infos['currentFileName']]['file']."', "
		."'".$this->report[$infos['section']][$infos['currentFileName']]['OK']."', "
		."'".$this->report[$infos['section']][$infos['currentFileName']]['WARN']."', "
		."'".$this->report[$infos['section']][$infos['currentFileName']]['ERR']."', "
		."'".$timeStart."', "
		."'".$bts->TimeObj->getHrtime()."', "
		."'".($CommandConsole->getReportEntry('executionPerformed') - $sqlCount )."', "
		."'".$commandCount."'"
		.");"
		);	
	}

	/**
	 * SQL execution without formating . Especially usuful for tirgger commands which can contain several ';'.
	 * Disabled for now as it's not critical and need more time to work on a proper solution
	 * 
	 * @param array $infos
	 */
	public function methodRawSql(&$infos) {
		// $bts = BaseToolSet::getInstance();
		// $SqlTableListObj = CurrentSet::getInstance()->getInstanceOfSqlTableListObj();

		// $TabSrch = array();
		// $TabRpl = array();
		// $tblList = $SqlTableListObj->getTableList();
		// foreach ( $tblList as $A ) {
		// 	$TabSrch[] = "!table_".$A."!";
		// 	$TabRpl[] = $SqlTableListObj->getSQLTableName($A);
		// }
		// // $TabSrch	= array_merge ( $TabSrch,	array ( "\n",	"	",	chr(13) ));
		// // $TabRpl		= array_merge ( $TabRpl,	array ( " ",	" ",	" " ));

		// $Tmp = "";
		// foreach ( $infos['currentFileContent'] as $L => $C ) { $Tmp .= $C; }
		// $infos['currentFileContent'] = $Tmp;
	
		// $infos['currentFileContent'] = str_replace ($TabSrch,$TabRpl,$infos['currentFileContent']);
		// unset ( $TabSrch, $TabRpl );

		// $this->createMap($infos);

		// $bts->SDDMObj->query($infos['currentFileContent']);

		// $res = $bts->LMObj->getLastSQLDetails();
		// switch ( $res['signal'] ) {
		// 	case "OK" :			$this->report[$infos['section']][$infos['currentFileName']]['OK']++;	break;
		// 	case "WARN" :		$this->report[$infos['section']][$infos['currentFileName']]['WARN']++;	break;
		// 	case "ERR" :		$this->report[$infos['section']][$infos['currentFileName']]['ERR']++;	break;
		// }
		// $this->report['lastReportExecution'] = time();
		// if ( $infos['updateInsdtallationMonitor'] == 1 ) { $this->updateInsdtallationMonitor(); }
	}

	/**
	 * Update values in the installation table.
	 */
	private function updateInsdtallationMonitor(){
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		if ( ($this->report['lastReportExecution'] - $this->report['lastReportExecutionSaved']) > 3 ) {
			$CommandConsole = CommandConsole::getInstance();
			$bts->SDDMObj->query("UPDATE ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('installation')." SET inst_nbr = '".$CommandConsole->getReportEntry('executionPerformed')."' WHERE inst_name = 'command_count';" );
			$this->report['lastReportExecutionSaved'] = $this->report['lastReportExecution'];

			$bts->SDDMObj->query("UPDATE ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('installation')." SET inst_nbr = '".$bts->LMObj->getSqlQueryNumber()."' WHERE inst_name = 'SQL_query_count';" );
			$this->report['lastSQLExecutionSaved'] = $this->report['lastSQLExecution'];
		}
		$bts->SDDMObj->query("UPDATE ".$CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName('installation')." SET inst_nbr = '".time()."' WHERE inst_name = 'last_activity';" );
	}
	
	//@formatter:off
	public function getReport() { return $this->report; }
	public function setReport($report) { $this->report = $report; }
	//@formatter:on
	
	
}
?>