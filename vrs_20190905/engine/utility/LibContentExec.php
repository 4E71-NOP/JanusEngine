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

class LibContentExec
{
	private static $Instance = null;

	private $reportTemplate = array(
		"file" => "",
		"OK" => 0,
		"WARN" => 0,
		"ERR" => 0,
		"start" => 0,
		"end" => 0,
		"cmdCount" => 0,
		"sqlCount" => 0,
	);


	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new LibContentExec();
		}
		return self::$Instance;
	}


	/**
	 * Load a file, call for formatting methods and execute the SQL commands.
	 * 
	 * /!\ WARNING. Besides the replacement of '!table!' "!IdxNom!" with contextual values; the file must be a valid SQL script. This method will not fix the SQL code.
	 * 
	 * @param array $infos
	 */
	public function methodAssistedSqlFile(&$infos)
	{
		$bts = BaseToolSet::getInstance();

		$report = $this->reportTemplate;
		$report['start'] = $bts->TimeObj->getHrtime();
		$report['file'] = $infos['currentListFile'];

		$ClassLoaderObj = ClassLoader::getInstance();
		$ClassLoaderObj->provisionClass('ScriptFormatting');
		$ScriptFormattingObj = ScriptFormatting::getInstance();

		$sqlCount = 0;

		$infos['currentFileContent'] = $bts->StringFormatObj->arrayConcatenation($infos['currentFileContent']);

		$TabSrch = array("!table!", "!IdxNom!", "\n", "	", "*/", chr(13));	//
		//@formatter:off
		switch ($bts->CMObj->getConfigurationSubEntry('db', 'type')) {
			default:
			case "mysql":	$TabRpl = array("`" . $infos['currentTableName'] . "`", $infos['currentTableName'], "", " ", "*/\n", " ");															break;
			case "pgsql":	$TabRpl = array($bts->CMObj->getConfigurationSubEntry('db', 'dbprefix') . "." . $infos['currentTableName'], $infos['currentTableName'], "", " ", "*/\n", " ");		break;
		}
		//@formatter:on

		$infos['currentFileContent'] = str_replace($TabSrch, $TabRpl, $infos['currentFileContent']);
		unset($TabSrch, $TabRpl);

		$ScriptFormattingObj->createMap($infos);
		$ScriptFormattingObj->commandFormatting($infos);

		foreach ($infos['FormattedCommand'] as $C) {
			if (!isset($C['ordre'])) {
				$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Query '" . $C['cont'] . "'"));
				$bts->SDDMObj->query($C['cont']);

				$res = $bts->LMObj->getLastSQLDetails();
				$this->updateReport($report, $res['signal']);
				$report['lastReportExecution'] = time();
				$sqlCount++;
			}
		}

		// Completing report
		$report['sqlCount'] = $sqlCount;
		$report['end'] = $bts->TimeObj->getHrtime();

		// Keeping it in a switch for later DB support
		switch ($bts->CMObj->getConfigurationSubEntry('db', 'type')) {
			//@formatter:off
			case "mysql":		$bts->SDDMObj->query("FLUSH TABLES;");		break;
			//@formatter:on
		}

		$bts->SDDMObj->query("COMMIT;");
		return $report;
	}


	/**
	 * Load a file, call for formatting methods and execute the JnsEng commands.
	 * 
	 * @param mixed $infos
	 */
	public function methodCommand(&$infos)
	{
		$bts = BaseToolSet::getInstance();

		$report = $this->reportTemplate;
		$report['start'] = $bts->TimeObj->getHrtime();
		$report['file'] = $infos['currentListFile'];

		$CurrentSetObj = CurrentSet::getInstance();
		$ClassLoaderObj = ClassLoader::getInstance();
		$CommandConsole = CommandConsole::getInstance();
		$ClassLoaderObj->provisionClass('ScriptFormatting');
		$ScriptFormattingObj = ScriptFormatting::getInstance();

		$cmdCount = 0;
		$infos['currentFileContent'] = $bts->StringFormatObj->arrayConcatenation($infos['currentFileContent']);

		$ScriptFormattingObj->createMap($infos);
		$ScriptFormattingObj->commandFormatting($infos);

		foreach ($infos['FormattedCommand'] as $C) {
			// The space case happens when some tab & spaces are after a ";" and no command is found before EOF.
			if (!isset($C['ordre']) && $C['cont'] != " ") {
				$CommandConsole->executeCommand($C['cont']);

				$this->updateReport($report, $CommandConsole->getReportEntry('signal'));
				$report['lastReportExecution'] = time();
				$cmdCount++;
			}

			if ($CurrentSetObj->getDataSubEntry('cli', 'websiteCreation') == 1) {
				$SpecialCommandBuffer = $CurrentSetObj->getDataSubEntry('cli', 'websiteCreationCmd');
				foreach ($SpecialCommandBuffer as $S) {
					$CommandConsole->executeCommand($S);
					$this->updateReport($report, $CommandConsole->getReportEntry('signal'));
				}
				$report['lastReportExecution'] = time();
				$cmdCount++;
				$CurrentSetObj->setDataSubEntry('cli', 'websiteCreation', 0);
			}
		}
		// Completing report
		$report['cmdCount'] = $cmdCount;
		$report['end'] = $bts->TimeObj->getHrtime();
		return $report;
	}


	/**
	 * SQL execution without formating . Especially usuful for tirgger commands which can contain several ';'.
	 * 
	 * @param array $infos
	 */
	public function methodRawSql(&$infos)
	{
		$bts = BaseToolSet::getInstance();

		$report = $this->reportTemplate;
		$report['start'] = $bts->TimeObj->getHrtime();
		$report['file'] = $infos['currentListFile'];

		$CurrentSetObj = CurrentSet::getInstance();

		$cmdCount = 0;

		$tblList = $CurrentSetObj->SqlTableListObj->getTableList();
		foreach ($tblList as $A) {
			$TabSrch[] = "!table_" . $A . "!";
			$TabRpl[] = $CurrentSetObj->SqlTableListObj->getSQLTableName($A);
		}

		$TabConfig = $bts->CMObj->getConfiguration();
		$TabSrch[] = "!db!";
		$TabRpl[] = $bts->CMObj->getConfigurationSubEntry('db', 'dbprefix');

		$TabSrch[] = "*user_install*";
		$TabRpl[] = $TabConfig['db_user_login'];

		$TabSrch[] = "!host!";
		$TabRpl[] = "localhost";

		$infos['currentFileContent'] = $bts->StringFormatObj->arrayConcatenation($infos['currentFileContent']);
		$infos['currentFileContent'] = str_replace($TabSrch, $TabRpl, $infos['currentFileContent']);

		unset($TabSrch, $TabRpl);
		$bts->SDDMObj->executeContent($infos['currentFileContent']);

		$res = $bts->LMObj->getLastSQLDetails();
		$this->updateReport($report, $res['signal']);

		// Completing report
		$report['cmdCount'] = $cmdCount;
		$report['end'] = $bts->TimeObj->getHrtime();

		return $report;
	}


	/**
	 * Updates internal report base on the given signal
	 * 
	 * @param mixed $report
	 * @param mixed $res
	 * @return void
	 */
	private function updateReport(&$report, $res)
	{
		switch ($res) {
		//@formatter:off
			case "OK":		$report['OK']++;	break;
			case "WARN":	$report['WARN']++;	break;
			case "ERR":		$report['ERR']++;	break;
		//@formatter:on
		}

	}




}