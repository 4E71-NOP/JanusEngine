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

class CommandConsole {
	private static $Instance = null;
	private static $i18n = array();
	private static $SqlQueryTable = array();

	private static $InitTable = array();
	private static $CheckTable = array();
	private static $PreRequisiteTable = array();
	private static $ActionTable = array();
	
	private static $report = array();
	
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new CommandConsole ();
			self::loadI18n();

			self::makeQueryTable();

			self::makeInitTable();
			self::makeCheckTable();
			self::makePreRequisiteTable();
			self::makeActionTable();
			
			self::$report['executionPerformed'] = 0;
		}
		return self::$Instance;
	}

	/**
	 * Load the I18n file and fill the array.
	 * 
	 */
	private static function loadI18n () {
		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		$CMObj = ConfigurationManagement::getInstance();
		$l = $CMObj->getLanguageListSubEntry($WebSiteObj->getWebSiteEntry('sw_lang'), 'langue_639_3');
		$i18n = array();
		include ("routines/website/cli/i18n/".$l.".php");
		self::$i18n = $i18n;
	}
	

	/**
	 * 2020 02 26 - DEPRECATED
	 * Artefact from the old system. Kept here for migration purposes 
	 * Fill the $SqlQueryTable with all the necessary assets to test if a command can be executed or not.
	 * 
	 */
	private static function makeQueryTable () {
		$SqlTableListObj = SqlTableList::getInstance(null, null);

		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteContextObj = $CurrentSetObj->getInstanceOfWebSiteContextObj(); //We consider the website context is already set.
		$webSiteId = $WebSiteContextObj->getWebSiteEntry('sw_id');

		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		$CMObj = ConfigurationManagement::getInstance();
		$l = $CMObj->getLanguageListSubEntry($WebSiteObj->getWebSiteEntry('sw_lang'), 'langue_639_3');

		include ("routines/website/cli/SqlQueryTable.php");
	
	}
	
	/**
	 * Initialize the values of the entity.
	 * It helps fill the blanks the user will not provide when creating commands.
	 *
	 */
	private static function makeInitTable () {
		include ("routines/website/cli/InitTable.php");
	}

	/**
	 * 
	 * Feed a table with all the necessary SQL queries and data to do every test we need for a command line
	 *  
	 */
	private static function makeCheckTable () {
		include ("routines/website/cli/CheckTable.php");
	}

	/**
	 * 
	 * Feed a table with the necessary data to do every test we need for a command line
	 * 
	 */
	private static function makePreRequisiteTable () {
		include ("routines/website/cli/PreRequisiteTable.php");
	}

	/**
	 *
	 * Feed a table with the necessary data to do every action we need for a command line
	 *
	 */
	 private static function makeActionTable () {
		include ("routines/website/cli/ActionTable.php");
		
	}
	
	/**
	 *
	 * Split the command line string into a linear array.
	 *
	 * @param $CommandLine
	 * @return string[]
	 *
	 */
	private function splitIntoArray ( $CommandLine ) {
		$tab_rch = array ("\n",	chr(13),	"				",	"			",	"		",	"	",	"      ",	"     ",	"    ",	"   ",	"  ");
		$tab_rpl = array (" ",	" ",		" ",				" ",			" ", 		" ",	" ",		" ",		" ",	" ",	" ");
		$CommandLine = trim($CommandLine);
		$CommandLine = str_replace ($tab_rch,$tab_rpl,$CommandLine);
		
		$length = strlen($CommandLine);
		$retArray = array();
		$retArrayPtr= $ptrBegin = $ptrEnd = 0;
		
		while ( $ptrBegin < $length ) {
			$next = substr ( $CommandLine , $ptrBegin , 1 );
			switch ($next) {
				case "'":
				case '"':
					$ptrBegin++;
					$quote = $next;
					$ptrEnd = strpos($CommandLine, $quote , $ptrBegin );
					$retArray[$retArrayPtr] = substr($CommandLine , $ptrBegin , $ptrEnd - $ptrBegin );
					break;
				case " ":	$retArrayPtr--;		break;
				default:
					$ptrEnd = strpos($CommandLine, " ", $ptrBegin );
					if ( $ptrEnd !== FALSE && $ptrBegin < $length) {
						$retArray[$retArrayPtr] = substr($CommandLine , $ptrBegin , $ptrEnd - $ptrBegin );
					}
					if ( $ptrEnd === FALSE ) {
						$retArray[$retArrayPtr] = substr($CommandLine , $ptrBegin , $length - $ptrBegin );
						$ptrBegin = $ptrEnd = $length;
					}
					break;
			}
			$ptrEnd++;
			$ptrBegin = $ptrEnd;
			$retArrayPtr++;
		}
		return $retArray;
	}

	/**
	 *
	 * Returns an "associative array" based on the provided array.
	 * This will allow control of parameters in the future.
	 * We know that arguments come in pairs.
	 * The first 2 are 'command' followed by 'entity' (group, user, etc.).
	 * 
	 * @param $Commandline
	 * @return string[] 
	 *        
	 */
	private function linkTerms($CCL) {
		$LMObj = LogManagement::getInstance();
		$LMObj->InternalLog("CommandConsole:linkTerms - Start");
		
		$assocArray = array ();
		$ptr = 0;
		$entry = "";
		foreach ( $CCL as $A ) {
			switch ($ptr) {
				case 0 :
					$assocArray['init']['cmd'] = strtolower($A);
					break;
				case 1 :
					$assocArray['init']['entity'] = strtolower($A);
					break;
				default :
					if ($ptr & 1) { 
						$assocArray['incoming'][$entry] = $A;
					} 
					else { $entry = $A; }
					break;
			}
			$ptr ++;
		}
		$LMObj->InternalLog("CommandConsole:linkTerms - End");
		return $assocArray;
	}
	

	/**
	 * Initalize the necessary default values for an entity.
	 */
	private function commandInitialization (&$CCL) {
		$LMObj = LogManagement::getInstance();
		$LMObj->InternalLog("CommandConsole:commandInitialization - Start");
		
		$SDDMObj = DalFacade::getInstance()->getDALInstance();
		$af  = self::$InitTable[$CCL['init']['entity']];
		$af($CCL);
		
		switch (strtolower($CCL['init']['cmd'])) {
			case "update":
				foreach ($CCL["params"] as &$C ) { $C = ""; }		// We clear any default value as it's an update command. So we can only select what's necessary to update later. We keep the array so we can check if a value given by the command doesn't fit
				break;
			case "add":
			default:
				break;
		}
		foreach ($CCL['incoming'] as $A => $B ) {$CCL['params'][$A] = $SDDMObj->escapeString($B);}
		$LMObj->InternalLog("CommandConsole:commandInitialization - End");
	}
	
	/**
	 * Do tests based on a specific list chosen with the type of command and entity (article, group, etc.).
	 * 
	 * Directive = 1 : Return the data in a variable. No error message.
	 * Directive = 2 : Return the data in a variable. If an error uccurs, a message is stored and a flag is set.
	 * Directive = 3 : Test if a duplicate exists. If 1 line is returned it raises an error.
	 * Directive = 4 : Execute function and behave depending on "0" or "1" return value. 1=OK; 0=NOK
	 * 
	 * Info on directive 1,2,3 : $af returning -1 means the called function tells us there is nothing relevant to do.
	 * 
	 * @param array $CCL
	 */	
	private function commandValidation (&$CCL) {
		$LMObj = LogManagement::getInstance();
		$SDDMObj = DalFacade::getInstance()->getDALInstance();
		$LMObj->InternalLog("CommandConsole:commandValidation - Start");
		
		$SqlTableListObj = SqlTableList::getInstance(null, null);
		$CCL['sqlTables'] = $SqlTableListObj->getSQLWholeTableName();

		//----------------------------------------
		// Execute specific functions
		$execute = &self::$PreRequisiteTable[$CCL['init']['cmd']][$CCL['init']['entity']]['execute'];
		if ( is_callable($execute) ) {
			$LMObj->InternalLog("CommandConsole:commandValidation - prerequisite execute is a callable function.");
			$execute($CCL); 
		}
		
		$checkPtr = &self::$CheckTable[$CCL['init']['cmd']][$CCL['init']['entity']];
		
		if (is_array($checkPtr)) {								// Sometimes there is nothing to do
			$idx = 0;
			foreach ($checkPtr as $A ){
				if ($CCL['errFlag'] != 1) {						// Saves time if a previous error occured. We stop at first error.
					$af = $A['f'];
					switch ($A['d']) {
						case 1:
							$CCL['entityCheck'][$idx] = $q = $af($CCL);
							if ( $q != -1 ) {
								$dbquery = $SDDMObj->query($q['0']);
								if ( $SDDMObj->num_row_sql($dbquery) > 0 ) {
									while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { $CCL['params'][$A['v']] = $dbp[$A['c']]; }
								}
							}
							break;
						case 2:
							$CCL['entityCheck'][$idx] = $q = $af($CCL);
							if ( $q != -1 ) {
								$dbquery = $SDDMObj->query($q['0']);
								if ( $SDDMObj->num_row_sql($dbquery) == 0 ) {
									$msg = str_replace ( '<A1>', $A['p'] , self::$i18n['elementNotFound'] );
									$LMObj->log(array ('i'=>'commandValidation' , 'a'=>$CCL['CommandString'] , 's'=>'ERR', 'm'=>$A['m'] ,'t'=>$msg) );
									$CCL['errFlag'] = 1;
									$CCL['entityCheck'][$idx]['err'] = "<span style='color:#FF0000'>DBG: 0 results</span>";
								}
								else {
									while ($dbp = $SDDMObj->fetch_array_sql($dbquery)) { $CCL['params'][$A['v']] = $dbp[$A['c']]; }
								}
							}
							break;
						case 3:
							$CCL['entityCheck'][$idx] = $q = $af($CCL);
							if ( $q != -1 ) {
								$dbquery = $SDDMObj->query($q['0']);
								if ( $CCL['errFlag'] != 1 && $SDDMObj->num_row_sql($dbquery) > 0 ) {
									$msg = str_replace ( '<A1>', $CCL['target'] , self::$i18n['duplicateFound'] );
									$LMObj->log(array ('i'=>'commandValidation' , 'a'=>$CCL['CommandString'] , 's'=>'ERR', 'm'=>$A['m'] ,'t'=>$msg) );
									$CCL['errFlag'] = 1;
									$CCL['entityCheck'][$idx]['err'] = "<span style='color:#FF0000'>DBG: Duplicate found</span>";
								}
							}
							break;
						case 4:
							$result = $af($CCL);
							if ( $result == 0 ) { $CCL['errFlag'] = 1; }
							break;
					}
// 					$LMObj->InternalLog("CommandConsole:commandValidation - ".$q['0']);
				}
				$idx++;
				if ( $CCL['errFlag'] == 1) { $CCL['params'][$A['v']] = "0";}
			}
		}
		$LMObj->InternalLog("CommandConsole:commandValidation - End");
	}
	
	/**
	 * Prepare the necessary queries to execute next.
	 * @param array $CCL
	 */
	private function prepareSQLStatement (&$CCL) {
		$SqlTableListObj = SqlTableList::getInstance(null, null);
		$StringFormatObj = StringFormat::getInstance();

		$CMobj = ConfigurationManagement::getInstance();
		$LMObj = LogManagement::getInstance();
		$TimeObj = Time::getInstance();
		
		$LMObj->InternalLog("CommandConsole:prepareSQLStatement - Start");
		
		$SDDMObj = DalFacade::getInstance()->getDALInstance();

		//----------------------------------------
		// Convert selected values to a compatible format with the DB model.
		$ptr = &self::$PreRequisiteTable[$CCL['init']['cmd']][$CCL['init']['entity']];
		// convert ----------------------------------------
		if ( is_array($ptr['convert']) ) {
			foreach ($ptr['convert'] as $A){ $CCL['params'][$A['v']] = $StringFormatObj->conversion_expression($CCL['params'][$A['v']], $A['s']); }
		}
		// Next Id ----------------------------------------
		if ( is_array($ptr['nextId']) ) {
			foreach ($ptr['nextId'] as $A ){ $CCL['params'][$A['target']] = $SDDMObj->findNextId($SqlTableListObj->getSQLTableName($A['table']), $A['column']); }
		}
		//timeCreate ----------------------------------------
		$time = time ();
		if ( is_array($ptr['timeCreate']) ) {
			foreach ($ptr['timeCreate'] as $A) { $CCL['params'][$A] = $time; }
		}
		// timeConvert ----------------------------------------
		if ( is_array($ptr['timeConvert']) ) {
			foreach ($ptr['timeConvert'] as $A) { $CCL['params'][$A] = $TimeObj->mktimeFromCanonical($CCL['params'][$A]); }
		}
		// langConvert ----------------------------------------
		if ( is_array($ptr['langConvert']) ) {
			foreach ($ptr['langConvert'] as $A) { $CCL['params'][$A['t']] = $CMobj->getLanguageListSubEntry($A['v'], 'langue_id'); }
		}
		//----------------------------------------
		// Associate columns in a compatible syntax to use with SQL statements.
		$equality = $columns = $values = "";
		if ( is_array($ptr['columns']) ) {
			foreach ($ptr['columns'] as $A) {
				if ( strlen($CCL['params'][$A['v']]) != 0 ) {
					$equality .= $A['t']. "='".$CCL['params'][$A['v']]."', ";
					$columns .= $A['t']. ", ";
					$values .= "'".$CCL['params'][$A['v']]."', ";
					$CCL['params']['updateGO'] = 1;
				}
			}
			$CCL['equalities'] = substr ( $equality , 0 , -2 );
			$CCL['columns'] = substr ( $columns , 0 , -2 );
			$CCL['values'] = substr ( $values , 0 , -2 );
		}
		else { $LMObj->InternalLog("CommandConsole:prepareSQLStatement - ptr['columns'] is not an array."); }
		
		// Selects and run the function that will return the SQL queries to execute.
		// In case of directive N°4 it will not return an array but execute what's needed.
		$af = self::$ActionTable[$CCL['init']['cmd']][$CCL['init']['entity']];
		$CCL['sql'] = $af($CCL);
		
		if ( is_array($CCL['sql']) ) {
			foreach ( $CCL['sql'] as $Q ) {
				$SDDMObj->query($Q);
				self::$report['executionPerformed']++;
			}
		}
		$LMObj->InternalLog("CommandConsole:prepareSQLStatement - End");
	}
	
	/**
	 *
	 * @param $CommandLine
	 *
	 */
	public function executeCommand ($CommandLine) {
		self::$report['signal'] = "OK";
		
		$LMObj = LogManagement::getInstance();
		$CMobj = ConfigurationManagement::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();

		$LMObj->InternalLog("CommandConsole:executeCommand - Start : " . $CommandLine);
		
		$WebSiteContextObj = $CurrentSetObj->getInstanceOfWebSiteContextObj(); //We consider the website context is already set.
		$UserObj = $CurrentSetObj->getInstanceOfUserObj();
		$TabConfig = $CMobj->getConfiguration();
		
		// CCL  = Current Command line
		// The buffer must NOT contain the end separator ";"
		$CCL = $this->splitIntoArray ($CommandLine);
		$CCL = $this->linkTerms($CCL);
		$CCL['CommandString'] = $CommandLine;	// We save the command string for error messages and debug.

		if ( is_array(self::$ActionTable[$CCL['init']['cmd']]) ) {
			if ( is_callable(self::$ActionTable[$CCL['init']['cmd']][$CCL['init']['entity']])) {
				$LMObj->InternalLog("CommandConsole:executeCommand - The action table is an array and the command is a callable.");
				$CCL['Context'] = $WebSiteContextObj->getWebSite();
				$CCL['Initiator'] = array (
					"user_id" => $UserObj->getUserEntry('id'),
					"user_nom" => $UserObj->getUserEntry('nom'),				// 2020 01 06 - Change this by user_login
					"db_login" => $TabConfig['db_user_login'],
					"db_pass" => $TabConfig['db_user_password'],
				);
				
				$this->commandInitialization($CCL);
				if (!isset($CCL['errFlag'])) {
					$this->commandValidation($CCL);
					if (!isset($CCL['errFlag'])) {
						$this->prepareSQLStatement($CCL);
					}
// 					else {
// 						foreach ($CCL['entityCheck'] as $EC ) { 
// 							$LMObj->logDebug($EC['0']."<br>".$EC['err']."<br><br>", 0);
// 						}
// 					}
					
					if ( $CurrentSetObj->getDataSubEntry('install', 'websitePostCreation') == 1 ) {
						// Special routine for website creation.
						// Adding basic set of users and groups in order to make the website viable.
						// At this point; some data have been converted. In this case user credential given by the "add website" command.
						$CurrentSetObj->setDataSubEntry('cli', 'websiteCreation', 1);
						$SpecialCommandBuffer = array(
							"website context name '".$CCL['params']['name']."' user '*user_install*' password '*user_install*'",
							"add group name 'Server_owner' parent origin title ROOT tag SENIOR_STAFF file 'graph/universal/icone_developpeur_001.jpg' desc 'Owner'",
							"add group name Reader parent Server_owner title Reader tag READER file 'graph/universal/icone_developpeur_001.jpg' desc 'Reader'",
							"add group name Anonymous parent reader title Anonymous tag ANONYMOUS file 'graph/universal/icone_developpeur_001.jpg' desc 'Nobody'",
							"add user name \"".   $CCL['params']['user']."\" login \"".$CCL['params']['user']."\" perso_name \"".$CCL['params']['user']."\" password \"".$CCL['params']['password']."\" status ACTIVE role_function PRIVATE",
							"assign user name \"".$CCL['params']['user']."\" to_group 'Server_owner' primary_group YES"
						);
						$CurrentSetObj->setDataSubEntry('cli', 'websiteCreationCmd', $SpecialCommandBuffer);
						$CurrentSetObj->setDataSubEntry('install', 'websitePostCreation', 0);
					}
				}
			}
			else {
				// Entity not found
				$CCL['errFlag'] = 1;
				$CCL['errMsg'] = "unknown entity for that command";
			}
		}
		else {
			// Command not found
			$CCL['errFlag'] = 1;
			$CCL['errMsg'] = "Command not found";
		}
		
		self::$report['signal'] = ( $CCL['errFlag'] == 1 ) ? "ERR" : "OK";
		$LMObj->InternalLog("CommandConsole:executeCommand - End");
		
	}
	
	//@formatter:off
	public static function getReport() {return self::$report;}
	public static function getReportEntry( $a ) {return self::$report[$a];}
	public static function setReport($report) {self::$report = $report;}
	//@formatter:on

}

?>

