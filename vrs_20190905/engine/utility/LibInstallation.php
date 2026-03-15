<?php
/*JanusEngine-license-start*/
// --------------------------------------------------------------------------------------------
//
//	Janus Engine - Le petit moteur de web
//	Sous licence Creative Common
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@rootwave.net
//
// --------------------------------------------------------------------------------------------
/*JanusEngine-license-end*/

class LibInstallation
{
	private static $Instance = null;

	private $report = array();

	private function __construct()
	{
	}

	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new LibInstallation();
		}
		return self::$Instance;
	}


	/**
	 * Execute the commands found in each file listed in the array.<br>
	 * <br>
	 * The principe is to execute the entire SQL script not one commmand at a time.<br>
	 * 
	 * 
	 * @param array $infos
	 * @param array $list
	 */
	public function executeContent(&$infos, &$list)
	{
		$bts = BaseToolSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();
		$ClassLoaderObj->provisionClass('LibContentExec');
		$LibContentExecObj = LibContentExec::getInstance();

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Begin"));

		foreach ($list['filelist'] as $A) {
			$infos['currentFileName'] = $A;
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Processing : " . $infos['currentFileName']));

			$path = $infos['path'] . $list['name'] . "/" . $infos['sectionPath'] . "/" . $A;
			$infos['currentTableName'] = $bts->CMObj->getConfigurationEntry('tabprefix') . str_replace(".sql", "", $A);
			$infos['currentFileStat'] = stat($path);
			$infos['currentFileContent'] = file($path);
			$infos['currentListFile'] = $list['name'] . "/" . $infos['currentFileName'];
			$infos['TabAnalyse'] = array();

			// TODO Remove when all 3 are migrated
			$this->report[$infos['section']][$infos['currentFileName']]['file'] = $list['name'] . "/" . $infos['currentFileName'];
			$this->report[$infos['section']][$infos['currentFileName']]['OK'] = 0;
			$this->report[$infos['section']][$infos['currentFileName']]['WARN'] = 0;
			$this->report[$infos['section']][$infos['currentFileName']]['ERR'] = 0;

			$bts->LMObj->msgLog(array('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : processing file : `" . $this->report[$infos['section']][$infos['currentFileName']]['file'] . "`"));

			unset($infos['FormattedCommand']);
			switch ($infos['method']) {
				case "namedTable":
				case "filename":
					// SQL script in on the bench
					$this->report[$infos['section']][$infos['currentFileName']] = $LibContentExecObj->methodAssistedSqlFile($infos);
					$this->logExecutionReport($infos);

					break;
				case "commandConsole":
					$this->report[$infos['section']][$infos['currentFileName']] = $LibContentExecObj->methodCommand($infos);
					$this->logExecutionReport($infos);
					break;
				case "raw_sql":
					$this->report[$infos['section']][$infos['currentFileName']] = $LibContentExecObj->methodRawSql($infos);
					$this->logExecutionReport($infos);
					break;
			}
		}
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}

	/**
	 * Insert report data into the table installation_report
	 * 
	 * @param mixed $infos
	 * @return void
	 */
	private function logExecutionReport(&$infos)
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		// If DB is ready we store directly into DB. Thank you captain obvious.
		if (strpos($infos['section'], 'tables_creation') === false) {
			switch ($bts->CMObj->getConfigurationSubEntry('db', 'type')) {
				case "mysql":
				default:
					$queryHeader = "INSERT INTO " . $CurrentSetObj->SqlTableListObj->getSQLTableName('installation_report') . " VALUES (";
					break;
				case "pgsql":
					$queryHeader = "INSERT INTO " . $CurrentSetObj->SqlTableListObj->getSQLTableName('installation_report') . " VALUES (";
					break;
			}

			$q = $queryHeader . " "
				. "'" . $bts->SDDMObj->createUniqueId() . "', "
				. "'" . $infos['section'] . "', "
				. "'" . $this->report[$infos['section']][$infos['currentFileName']]['file'] . "', "
				. "'" . $this->report[$infos['section']][$infos['currentFileName']]['OK'] . "', "
				. "'" . $this->report[$infos['section']][$infos['currentFileName']]['WARN'] . "', "
				. "'" . $this->report[$infos['section']][$infos['currentFileName']]['ERR'] . "', "
				. "'" . $this->report[$infos['section']][$infos['currentFileName']]['start'] . "', "
				. "'" . $this->report[$infos['section']][$infos['currentFileName']]['end'] . "', "
				. "'" . $this->report[$infos['section']][$infos['currentFileName']]['sqlCount'] . "', "
				. "'" . $this->report[$infos['section']][$infos['currentFileName']]['cmdCount'] . "' "
				. ");";
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Query '" . $q . "'"));
			$bts->SDDMObj->query($q);
		}
	}


	/**
	 * Scan directories and store the file list in the passed array.
	 * 
	 * @param array $infos
	 */
	public function scanDirectories(&$infos)
	{
		// $LMObj = LogManagement::getInstance();
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Start"));

		foreach ($infos['directory_list'] as &$A) {
			$currentDir = $A['name'];
			$dirFileList = array();
			$handle = opendir($infos['path'] . $currentDir . "/" . $infos['sectionPath'] . "/");
			// $LMObj->logDebug($infos['path'].$currentDir."/".$infos['section']."/<br>\r",0);
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " Processing : " . $infos['path'] . $currentDir . "/" . $infos['section'] . "/"));

			// $infos['opendir'] = $handle;
			if ($A['state'] == "on" && $handle != null) {
				while (false !== ($file = readdir($handle))) {
					$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " Processing file : " . $file));
					$acd_ERR = 0;
					if ($file == "." || $file == "..") {
						$acd_ERR = 1;
					}
					if (strpos($file, ".save") != FALSE) {
						$acd_ERR = 1;
					}
					if (strpos($file, "*.*~") != FALSE) {
						$acd_ERR = 1;
					}
					if ($acd_ERR == 0) {
						$dirFileList[] = $file;
					}
				}
				closedir($handle);
				sort($dirFileList);
				reset($dirFileList);
				$A['filelist'] = $dirFileList;
				$A['filesFound'] = 1;
			}
		}
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : End"));
	}

	
	// TODO clean up or recycle this method
	/**
	 * Update values in the installation table.
	 */
	private function updateInstallationMonitor()
	{
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		if (($this->report['lastReportExecution'] - $this->report['lastReportExecutionSaved']) > 3) {
			$CommandConsole = CommandConsole::getInstance();
			$bts->SDDMObj->query("UPDATE " . $CurrentSetObj->SqlTableListObj->getSQLTableName('installation') . " SET inst_nbr = '" . $CommandConsole->getReportEntry('executionPerformed') . "' WHERE inst_name = 'command_count';");
			$this->report['lastReportExecutionSaved'] = $this->report['lastReportExecution'];

			$bts->SDDMObj->query("UPDATE " . $CurrentSetObj->SqlTableListObj->getSQLTableName('installation') . " SET inst_nbr = '" . $bts->LMObj->getSqlQueryNumber() . "' WHERE inst_name = 'SQL_query_count';");
			$this->report['lastSQLExecutionSaved'] = $this->report['lastSQLExecution'];
		}
		$bts->SDDMObj->query("UPDATE " . $CurrentSetObj->SqlTableListObj->getSQLTableName('installation') . " SET inst_nbr = '" . time() . "' WHERE inst_name = 'last_activity';");
	}

	//@formatter:off
	public function getReport()	{return $this->report;	}
	public function setReport($report) {$this->report = $report;}
	//@formatter:on


}
