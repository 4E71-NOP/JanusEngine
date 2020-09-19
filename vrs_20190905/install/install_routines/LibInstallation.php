<?php 
/*Hydre-licence-debut*/
// --------------------------------------------------------------------------------------------
//
//	Hydre - Le petit moteur de web
//	Sous licence Creative Common
//	Under Creative Common licence	CC-by-nc-sa (http://creativecommons.org)
//	CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
//	(c)Faust MARIA DE AREVALO faust@club-internet.fr
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
	 * @param array $infos
	 */
	public function scanDirectories ( &$infos ) {
// 		$LMObj = LogManagement::getInstance();
		
		foreach ( $infos['directory_list'] as &$A ) {
			$currentDir = $A['name'];
			$dirFileList = array();
			$handle = opendir( $infos['path'].$currentDir."/".$infos['section']."/" );
// 			$LMObj->logDebug($infos['path'].$currentDir."/".$infos['section']."/<br>\r",0);

			$infos['opendir'] = $handle;
			if ( $A['state'] == "on" && $handle != null ) {
				while (false !== ($file = readdir($handle))) {
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
	}

	/**
	 * Execute the commands found in each file listed in the array. 
	 * @param array $infos
	 * @param array $list
	 */
	public function executeContent (&$infos, &$list) {
		$CMobj = ConfigurationManagement::getInstance();
		foreach ( $list['filelist'] as $A ) {
			$infos['currentFileName'] = $A;
			$path = $infos['path'].$list['name']."/".$infos['section']."/".$A;
			$infos['currentTableName']= $CMobj->getConfigurationEntry('tabprefix') . str_replace(".sql" , "" , $A );
			$infos['currentFileStat'] = stat($path);
			$infos['currentFileContent'] = file($path);
			$infos['TabAnalyse'] = array();
			
			$this->report[$infos['section']][$infos['currentFileName']]['file'] = $list['name'] ."/".$infos['currentFileName'];
			$this->report[$infos['section']][$infos['currentFileName']]['OK']	= 0;	
			$this->report[$infos['section']][$infos['currentFileName']]['WARN']	= 0;	
			$this->report[$infos['section']][$infos['currentFileName']]['ERR']	= 0;	
			
			unset ( $infos['FormattedCommand']);
			switch ( $infos['method'] ) {
				case "namedTable":
				case "filename":
					$this->methodFilename($infos);
					break;
				case "commandConsole":
					$this->methodCommand($infos);
					break;
			}
		}
	}

	/**
	 * Load a file, call for formatting methods and execute the SQL commands.
	 * @param array $infos
	*/
	private function methodFilename (&$infos) {
		$SDDMObj = DalFacade::getInstance()->getDALInstance();
		$LMObj = LogManagement::getInstance();
		
		$Tmp = "";
		foreach ( $infos['currentFileContent'] as $L => $C ) { $Tmp .= $C; }
		$infos['currentFileContent'] = $Tmp;
		
		$TabSrch = array ( "!table!",							"!IdxNom!",					"\n",	"	",	"*/",	chr(13) );	//
		$TabRpl = array ( "`".$infos['currentTableName']."`",	$infos['currentTableName'],	"",		" ",	"*/\n",	" " );		// "`" est utilisé pour le fichier "tl_--.sql" Le nom de table doit être encadré.
		$infos['currentFileContent'] = str_replace ($TabSrch,$TabRpl,$infos['currentFileContent']);
		unset ( $TabSrch, $TabRpl );
		
		$this->createMap($infos);
		$this->commandFormatting ($infos);
		
		foreach ( $infos['FormattedCommand'] as $C ) {
			if ( !isset($C['ordre']) ) {
				$SDDMObj->query($C['cont']);
				$res = $LMObj->getLastSQLDetails();
				switch ( $res['signal'] ) {
					case "OK" :			$this->report[$infos['section']][$infos['currentFileName']]['OK']++;	break;
					case "WARN" :		$this->report[$infos['section']][$infos['currentFileName']]['WARN']++;	break;
					case "ERR" :		$this->report[$infos['section']][$infos['currentFileName']]['ERR']++;	break;
				}
				$this->report['lastReportExecution'] = time();
				if ( $infos['updateInsdtallationMonitor'] == 1 ) { $this->updateInsdtallationMonitor(); }
			}
		}
		$SDDMObj->query("FLUSH TABLES;");
		$SDDMObj->query("COMMIT;");
	}
	
	/**
	 * Load a file, call for formatting methods and execute the Hydr commands.
	 * @param array $infos
	 */
	private function methodCommand (&$infos) {
// 		$SDDMObj = DalFacade::getInstance()->getDALInstance();
		$CommandConsole = CommandConsole::getInstance();
		
		foreach ( $infos['currentFileContent'] as $L => $C ) { $Tmp .= $C; }
		$infos['currentFileContent'] = $Tmp;
		
		$this->createMap($infos);
		$this->commandFormatting ($infos);
		
		foreach ( $infos['FormattedCommand'] as $C ) {
			// the space case happens when some tab & spaces are after a ";" and no command is found before EOF.
			if ( !isset($C['ordre']) && $C['cont'] != " " ) {
				$CommandConsole->executeCommand($C['cont']);

				switch ( $CommandConsole->getReportEntry('signal') ) {
					case "OK" :			$this->report[$infos['section']][$infos['currentFileName']]['OK']++;	break;
					case "WARN" :		$this->report[$infos['section']][$infos['currentFileName']]['WARN']++;	break;
					case "ERR" :		$this->report[$infos['section']][$infos['currentFileName']]['ERR']++;	break;
				}
// 				error_log ( "executeCommand: signal=".$CommandConsole->getReportEntry('signal').";section=".$infos['section']."; currentFileName=".$infos['currentFileName']."; OK=" .$this->report[$infos['section']][$infos['currentFileName']]['OK']. "; WARN=" .$this->report[$infos['section']][$infos['currentFileName']]['WARN']. "; ERR=" . $this->report[$infos['section']][$infos['currentFileName']]['ERR'] );
				$this->report['lastReportExecution'] = time();
				$this->updateInsdtallationMonitor();
				
				$CurrentSetObj= CurrentSet::getInstance();
				if ( $CurrentSetObj->getDataSubEntry('cli', 'websiteCreation') == 1) {
					$SpecialCommandBuffer = $CurrentSetObj->getDataSubEntry('cli', 'websiteCreationCmd');
					foreach ( $SpecialCommandBuffer as $S ) { 
						$CommandConsole->executeCommand($S);
						switch ( $CommandConsole->getReportEntry('signal') ) {
							case "OK" :			$this->report[$infos['section']][$infos['currentFileName']]['OK']++;	break;
							case "WARN" :		$this->report[$infos['section']][$infos['currentFileName']]['WARN']++;	break;
							case "ERR" :		$this->report[$infos['section']][$infos['currentFileName']]['ERR']++;	break;
						}
						$this->report['lastReportExecution'] = time();
						if ( $infos['updateInsdtallationMonitor'] == 1 ) { $this->updateInsdtallationMonitor(); }
					}
					$CurrentSetObj->setDataSubEntry('cli', 'websiteCreation', 0);
				}
			}
		}
	}

	/**
	 * 
	 */
	private function updateInsdtallationMonitor(){
		$SDDMObj = DalFacade::getInstance()->getDALInstance();
		$SqlTableListObj = SqlTableList::getInstance(null, null);
		
		if ( ($this->report['lastReportExecution'] - $this->report['lastReportExecutionSaved']) > 3 ) {
			$CommandConsole = CommandConsole::getInstance();
			$SDDMObj->query("UPDATE ".$SqlTableListObj->getSQLTableName('installation')." SET inst_nbr = '".$CommandConsole->getReportEntry('executionPerformed')."' WHERE inst_name = 'command_count';" );
			$this->report['lastReportExecutionSaved'] = $this->report['lastReportExecution'];

			$LMObj = LogManagement::getInstance();
			$SDDMObj->query("UPDATE ".$SqlTableListObj->getSQLTableName('installation')." SET inst_nbr = '".$LMObj->getSqlQueryNumber()."' WHERE inst_name = 'SQL_query_count';" );
			$this->report['lastSQLExecutionSaved'] = $this->report['lastSQLExecution'];
		}
		$SDDMObj->query("UPDATE ".$SqlTableListObj->getSQLTableName('installation')." SET inst_nbr = '".time()."' WHERE inst_name = 'last_activity';" );
	}

	/**
	 * Create a map of several patterns found in the command string.
	 * 
	 * @param array $infos
	 */
	private function createMap ( &$infos){
// 		We create a map to ease the command processing.
		$this->mapPattern ( "//" , 1 , 99999 , $infos );
		$this->mapPattern ( "\n" , 2 , 99998 , $infos );
		$this->mapPattern ( "/*" , 3 , 99997 , $infos );
		$this->mapPattern ( "*/" , 4 , 99996 , $infos );
		$this->mapPattern ( "'"  , 5 , 99995 , $infos );
		$this->mapPattern ( "\"" , 6 , 99994 , $infos );
		$this->mapPattern ( ";"  , 7 , 99993 , $infos );
		
		ksort ($infos['TabAnalyse']);
		reset ($infos['TabAnalyse']);
	}

	/**
	 * Create a map of a specific pattenr in the command string.
	 * 
	 * @param String $pattern
	 * @param Number $code
	 * @param Number $poserr
	 * @param array $infos
	 */	
	private function mapPattern ( $pattern , $code, $poserr, &$infos ) {
		$increment = strlen($pattern);
		$ptr = $stop = 0;
		while ( $stop == 0 ) {
			$x = strpos( $infos['currentFileContent'] , $pattern , $ptr );
			if ( $x === FALSE ) {
				$infos['TabAnalyse'][$poserr] = $code;
				$stop = 1;
			}
			else {
				$infos['TabAnalyse'][$x] = $code;
				$ptr = $x+$increment;
			}
		}
		$infos['TabAnalyse']['99990'] = 8;				// EOF
	}
	
	/**
	 * Format the command string by removing comments, unnecessary spaces etc.
	 * @param array $infos
	 */
	private function commandFormatting (&$infos) {
		$TabRch01 = array ( "\n",	"\r",	"\t",	"    ",	"   ",	"  " );
		$TabRpl01 = array ( " ",	" ",	" ",	" ",	" ",	" ");
		$TabRpl02 = array ( "",		"",		"",		"",		"",		"");
// 		$strRch02 = array ( "",		"",		" ",	" " );
		$err = 0;
		
		$Map = &$infos['TabAnalyse'];
		$Buffer = &$infos['currentFileContent'];
		$Dest = &$infos['FormattedCommand'];
		
		$CaseMatrix = array (
				0 => array (	0,	1,	0,	3,	4,	5,	6,	98,	99	),
				1 => array (	0,	0,	12,	0,	0,	0,	0,	0,	99	),
				2 => array (	0,	0,	0,	0,	24,	0,	0,	0,	99	),
				3 => array (	0,	0,	0,	0,	0,	35,	0,	0,	99	),
				4 => array (	0,	0,	0,	0,	0,	0,	46,	0,	99	),
		);
		$compilation = "";
		$FCMode = $Ptr = $idx = 0;
		
		foreach ( $Map as $K => $A ) {
			if ( $K <= 99990 ) {
				$directive = $CaseMatrix[$FCMode][$A];
				switch ( $directive ) {
					case 1:		$FCMode = 1;	$compilation .= substr($Buffer, $Ptr, ($K-$Ptr));		$Ptr = $K;		break;		// set comment mode
					case 3:		$FCMode = 2;	$compilation .= substr($Buffer, $Ptr, ($K-$Ptr));		$Ptr = $K;		break;		// set multiline comment mode
					case 4:		$err = 1;																				break;		// error
					case 5:		$FCMode = 3;	$compilation .= substr($Buffer, $Ptr, ($K-$Ptr));		$Ptr = $K;		break;		// set citation1  mode
					case 6:		$FCMode = 4;	$compilation .= substr($Buffer, $Ptr, ($K-$Ptr));		$Ptr = $K;		break;		// set citation2 mode
					case 12:	$FCMode = 0;															$Ptr = $K+1;	break;		// set initial mode
					case 24:	$FCMode = 0;															$Ptr = $K+2;	break;		// set initial mode
					case 35:
					case 46:	$FCMode = 0;																			break;		// set initial mode
					case 98:
						$FCMode = 0;																								// set initial mode
						$compilation .= substr($Buffer, $Ptr, ($K-$Ptr));															// Copy last valid segment.
						$compilation = str_replace ( $TabRch01 , $TabRpl01 , $compilation );										//
						$Dest[$idx]['cont'] = $compilation;																			//
						$compilation = "";																							//
						$Ptr = $K+1;																								// Align pointers
						$idx++;
						break;
					case 99:
						$FCMode = 0;												// Back to initial mode
						$compilation .= substr($Buffer, $Ptr, ($K-$Ptr));			// Copy last valid segment
						$Ptr = $K+1;												// Align pointers
						$EOF = 1;
						break;
				}
			}
		}
		if ( isset($EOF) ) {
			$compilation = str_replace ( $TabRch01 , $TabRpl02 , $compilation );
			if ( $compilation != " " ) { $OEFspurt = 1; }
		}
		if ( strlen($compilation) > 0 ) {
			$Dest[$idx]['cont'] = $compilation;
			if ($OEFspurt == 1) { $Dest[$idx]['Ordre'] = 1; }
		}
		$compilation = "";
		if ($err == 1) { $Dest[$idx]['Ordre'] = 1; }
	}
	
	
	/**
	 * Return a template of a config file. 
	 * @param array $infos
	 * @return string
	 */
	public function renderConfigFile (&$infos) {
// 		$CLassLoaderObj = ClassLoader::getInstance();
// 		$ClassLoaderObj->provisionClass('StringFormat');
// 		$ClassLoaderObj->provisionClass('Time');
// 		$StringFormatObj = StringFormat::getInstance();
		$TimeObj = Time::getInstance();
		$CMObj = ConfigurationManagement::getInstance();

		$Content = "
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
//	This config file has been generated.
//	Date		:	".$TimeObj->timestampToDate($TimeObj->microtime_chrono())."
//	Filename	:	site_".$infos['n']."_config.php
//	
//	
// You may need to insert the 'account prefix' depending on web hosters.
// ex DB = <user>_yourdatabase

if ( \$pv['ObjectMode'] == 1 ) {
	function returnConfig () {
		\$tab = array();
		\$tab['type']				= \"".$CMObj->getConfigurationSubEntry('db', 'type')."\";
		\$tab['host']				= \"".$CMObj->getConfigurationSubEntry('db', 'host')."\";
		\$tab['dal']				= \"".$CMObj->getConfigurationSubEntry('db', 'dal')."\";
		\$tab['db_user_login']		= \"".$CMObj->getConfigurationSubEntry('db', 'database_user_login')."\";
		\$tab['db_user_password']	= \"".$CMObj->getConfigurationSubEntry('db', 'database_user_password')."\";
		\$tab['dbprefix']			= \"".$CMObj->getConfigurationSubEntry('db', 'dbprefix')."\";
		\$tab['tabprefix']			= \"".$CMObj->getConfigurationSubEntry('db', 'tabprefix')."\";
		\$tab['maid_stats_nombre_de_couleurs'] = 5;
		\$tab['SessionMaxAge']	= (60*60*24);
		\$tab['pde_img_aff']	= 1;
		\$tab['pde_img_h']		= 32;					//height
		\$tab['pde_img_l']		= 32;					//width
		
		\$tab['DebugLevel_SQL']	= 1;					// Préparatif_sql.php
		\$tab['DebugLevel_CC']	= 1;					// Manipulation_<element>.php
		\$tab['DebugLevel_PHP']	= 1;					// PHP original debug level
		\$tab['DebugLevel_JS']	= 1;					// JavaScript
		\$tab['LogTarget']		= \"internal\";			// 'systeme' (apache log), 'echo' (affichage erreur sur l'ecran), 'aucun' (conserve la comptabilité des états)
		
		\$tab['contexte_d_execution']	= \"render\";			//deprecated
		\$tab['execution_context']		= \"render\";
		\$tab['mode_operatoire']		= \"connexion_directe\";
		\$tab['InsertStatistics']		= 1;
		
		\$tab['commandLineEngine'] = array(
				\"state\"		=>	\"enabled\",
		);
		return \$tab;
	}
}
?>
";
	
	return $Content;
	}
	
	
	
	//@formatter:off
	public function getReport() { return $this->report; }
	public function setReport($report) { $this->report = $report; }
	//@formatter:on
	
	
}
?>