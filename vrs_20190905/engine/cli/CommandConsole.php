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
// 	private static $i18n = array();
	private static $SqlQueryTable = array();

	private static $InitTable = array();
	private static $CheckTable = array();
	private static $PreRequisiteTable = array();
	private static $ActionTable = array();
	
	private static $report = array();
	
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new CommandConsole();
			self::loadI18n();
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
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
// 		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		$l = $bts->CMObj->getLanguageListSubEntry($CurrentSetObj->getInstanceOfWebSiteObj()->getWebSiteEntry('ws_lang'), 'lang_639_3');
		$i18n = array();
		include ("current/engine/cli/i18n/".$l.".php");
		$bts->I18nTransObj->apply($i18n);
		unset ($i18n);
// 		self::$i18n = $i18n;
	}
	
	/**
	 * Initialize the values of the entity.
	 * It helps fill the blanks the user will not provide when creating commands.
	 *
	 */
	private static function makeInitTable () {
		include ("current/engine/cli/InitTable.php");
	}

	/**
	 * 
	 * Feed a table with all the necessary SQL queries and data to do every test we need for a command line
	 *  
	 */
	private static function makeCheckTable () {
		include ("current/engine/cli/CheckTable.php");
	}

	/**
	 * 
	 * Feed a table with the necessary data to do every test we need for a command line
	 * 
	 */
	private static function makePreRequisiteTable () {
		include ("current/engine/cli/PreRequisiteTable.php");
	}

	/**
	 *
	 * Feed a table with the necessary data to do every action we need for a command line
	 *
	 */
	 private static function makeActionTable () {
		include ("current/engine/cli/ActionTable.php");
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
		$tab_rch = array ("\n",	chr(13),	"		",	"			",	"		",	"	",	"      ",	"    ",	"    ",	"   ",	"  ");
		$tab_rpl = array (" ",	" ",		" ",	" ",			" ", 		" ",	" ",		" ",	" ",	" ",	" ");
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
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : Start"));
		
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
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : End"));
		return $assocArray;
	}
	

	/**
	 * Initalize the necessary default values for an entity.
	 */
	private function commandInitialization (&$CCL) {
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : Start"));
		
		$SDDMObj = DalFacade::getInstance()->getDALInstance();
		$af  = self::$InitTable[$CCL['init']['entity']];
		$af($CCL);
		
		switch (strtolower($CCL['init']['cmd'])) {
			case "update":
				foreach ($CCL["params"] as &$C ) { $C = ""; }	// We clear any default value as it's an update command. So we can only select what's necessary to update later. We keep the array so we can check if a given value (by the command) doesn't fit
				break;
			case "add":
			default:
				break;
		}
		foreach ($CCL['incoming'] as $A => $B ) {$CCL['params'][$A] = $SDDMObj->escapeString($B);}
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : End"));
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
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : Start"));
		
		$CCL['sqlTables'] = $CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLWholeTableName();

		//----------------------------------------
		// Execute specific functions
		$execute = &self::$PreRequisiteTable[$CCL['init']['cmd']][$CCL['init']['entity']]['execute'];
		if ( is_callable($execute) ) {
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : Prerequisite execute is a callable function."));
			$execute($CCL); 
		}
		
		$checkPtr = &self::$CheckTable[$CCL['init']['cmd']][$CCL['init']['entity']];
		if (is_array($checkPtr)) {								// Sometimes there is nothing to do
			$idx = 0;
			foreach ($checkPtr as $A ){
				if ($CCL['errFlag'] != 1) {						// Saves time if a previous error occured. We stop at first error.
					$af = $A['f'];
					switch ($A['d']) {
						// Directive = 1 : Return the data in a variable. No error message.
						case 1:
							$CCL['entityCheck'][$idx] = $q = $af($CCL);
							if ( $q != -1 ) {
								$dbquery = $bts->SDDMObj->query($q['0']);
								if ( $bts->SDDMObj->num_row_sql($dbquery) > 0 ) {
									while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { $CCL['params'][$A['v']] = $dbp[$A['c']]; }
								}
							}
							break;
						// Directive = 2 : Return the data in a variable. If an error uccurs, a message is stored and a flag is set.
						case 2:
							$CCL['entityCheck'][$idx] = $q = $af($CCL);
							if ( $q != -1 ) {
								$dbquery = $bts->SDDMObj->query($q['0']);
								if ( $bts->SDDMObj->num_row_sql($dbquery) == 0 ) {
									$msg = str_replace ( '<A1>', $A['p'] , $bts->I18nTransObj->getI18nTransEntry('elementNotFound') );
									$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_ERROR, 'msg' => __METHOD__ ." ".$A['m'].". Finding reference. About '".$A['s']."'. ".$msg." Error at: " . $CCL['CommandString'] ));
									
									$CCL['errFlag'] = 1;
									$CCL['entityCheck'][$idx]['err'] = "<span style='color:#FF0000'>DBG: 0 results</span>";
								}
								else {
									while ($dbp = $bts->SDDMObj->fetch_array_sql($dbquery)) { $CCL['params'][$A['v']] = $dbp[$A['c']]; }
								}
							}
							break;
						// Directive = 3 : Test if a duplicate exists. If 1 line is returned it raises an error.
						case 3:
							$CCL['entityCheck'][$idx] = $q = $af($CCL);
							if ( $q != -1 ) {
								$dbquery = $bts->SDDMObj->query($q['0']);
								if ( $CCL['errFlag'] != 1 && $bts->SDDMObj->num_row_sql($dbquery) > 0 ) {
									$msg = str_replace ( '<A1>', $CCL['params']['name'] , $bts->I18nTransObj->getI18nTransEntry('duplicateFound') );
									// $bts->LMObj->log(array ('i'=>'commandValidation' , 'a'=>$CCL['CommandString'] , 's'=>'ERR', 'm'=>$A['m'] ,'t'=>$msg) );
									$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_ERROR, 'msg' => __METHOD__ ." ".$A['m'].". Finding reference. About '".$CCL['params'][$A['s']]."'. ".$msg." Error at: " . $CCL['CommandString'] ));
									$CCL['errFlag'] = 1;
									$CCL['entityCheck'][$idx]['err'] = "<span style='color:#FF0000'>DBG: Duplicate found</span>";
								}
							}
							break;
						// Directive = 4 : Execute function and behave depending on "0" or "1" return value. 1=OK; 0=NOK
						case 4:
							$result = $af($CCL);
							if ( $result == 0 ) { $CCL['errFlag'] = 1; }
							break;
					}
					$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : ".$q['0']));
				}
				$idx++;
				if ( $CCL['errFlag'] == 1) { $CCL['params'][$A['v']] = "0";}
			}
		}
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : End"));
	}
	
	/**
	 * Prepare the necessary queries to execute next.
	 * @param array $CCL
	 */
	private function prepareSQLStatement (&$CCL) {
		$bts = BaseToolSet::getInstance();
		$CurrentSetObj = CurrentSet::getInstance();
		
		//----------------------------------------
		// Convert selected values to a compatible format with the DB model.
		$ptr = &self::$PreRequisiteTable[$CCL['init']['cmd']][$CCL['init']['entity']];
		// convert ----------------------------------------
		if ( is_array($ptr['convert']) ) {
			foreach ($ptr['convert'] as $A){ $CCL['params'][$A['v']] = $bts->StringFormatObj->conversion_expression($CCL['params'][$A['v']], $A['s']); }
		}
		// Next Id ----------------------------------------
		if ( is_array($ptr['nextId']) && $CCL['init']['cmd'] != 'update') {
			foreach ($ptr['nextId'] as $A ){ $CCL['params'][$A['target']] = $bts->SDDMObj->createUniqueId();}
		}
		// 	foreach ($ptr['nextId'] as $A ){ $CCL['params'][$A['target']] = $bts->SDDMObj->findNextId($CurrentSetObj->getInstanceOfSqlTableListObj()->getSQLTableName($A['table']), $A['column']); }
		//timeCreate ----------------------------------------
		$time = time ();
		if ( is_array($ptr['timeCreate']) ) {
			foreach ($ptr['timeCreate'] as $A) { $CCL['params'][$A] = $time; }
		}
		// timeConvert ----------------------------------------
		if ( is_array($ptr['timeConvert']) && $CCL['init']['cmd'] != 'add') {
			foreach ($ptr['timeConvert'] as $A) { 
				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : time convert : ".$CCL['params'][$A]));
				$CCL['params'][$A] = $bts->TimeObj->mktimeFromCanonical($CCL['params'][$A]);
				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : time convert : ".$CCL['params'][$A]));
 
			}
		}
		// langConvert ----------------------------------------
		if ( is_array($ptr['langConvert'])) {
			foreach ($ptr['langConvert'] as $A) { $CCL['params'][$A['t']] = $bts->CMObj->getLanguageListSubEntry($A['v'], 'lang_id'); }
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
		else { $bts->LMObj->msgLog( array( 'level' => LOGLEVEL_INFORMATION, 'msg' => __METHOD__ ." : ptr['columns'] is not an array.")); }
		
		// Selects and run the function that will return the SQL queries to execute.
		// In case of directive N°4 it will not return an array but execute what's needed.
		$af = self::$ActionTable[$CCL['init']['cmd']][$CCL['init']['entity']];
		$bts->RequestDataObj->setRequestDataSubEntry('formGenericData','selectionId', $CCL['params']['id']); // Saves the ID in case it's a form (AdminDashBoard).

		$CCL['sql'] = $af($CCL);
		
		if ( is_array($CCL['sql']) ) {
			foreach ( $CCL['sql'] as $Q ) {
				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : Query `".$Q."`"));
				$bts->SDDMObj->query($Q);
				// *** Post query processing - AdminDashBoard CLI
				// Mainly storing the results into an array for later processing
				self::$report['executionPerformed']++;
			}
		}
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : End"));
	}
	
	/**
	 *
	 * @param $CommandLine
	 *
	 */
	public function executeCommand ($CommandLine) {
		$bts = BaseToolSet::getInstance();
		self::$report['signal'] = "OK";
		$CurrentSetObj = CurrentSet::getInstance();

		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : Start : " . $CommandLine));
		
		$WebSiteContextObj = $CurrentSetObj->getInstanceOfWebSiteContextObj(); //We consider the website context is already set.
		$UserObj = $CurrentSetObj->getInstanceOfUserObj();
		$TabConfig = $bts->CMObj->getConfiguration();
		
		// CCL  = Current Command line
		// The buffer must NOT contain the end separator ";"
		$CCL = $this->splitIntoArray ($CommandLine);
		$CCL = $this->linkTerms($CCL);
		$CCL['CommandString'] = $CommandLine;	// We save the command string for error messages and debug.

		if ( $CCL['init']['cmd'] == "exit") { 
			error_log("Exit has been called. I'm out!");
			exit(0);
		}

		if ( is_array(self::$ActionTable[$CCL['init']['cmd']]) ) {
			if ( is_callable(self::$ActionTable[$CCL['init']['cmd']][$CCL['init']['entity']])) {
				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : The action table is an array and the command is a callable."));
				$CCL['Context'] = $WebSiteContextObj->getWebSite();
				$CCL['Initiator'] = array (
					"user_id" => $UserObj->getUserEntry('user_id'),
					"user_name" => $UserObj->getUserEntry('user_login'),
					"db_login" => $TabConfig['db_user_login'],
					"db_pass" => $TabConfig['db_user_password'],
				);
				
				$this->commandInitialization($CCL);
				if (!isset($CCL['errFlag'])) {
					$this->commandValidation($CCL);
					if (!isset($CCL['errFlag'])) {
						$this->prepareSQLStatement($CCL);
					}
					if ( $CurrentSetObj->getDataSubEntry('install', 'websitePostCreation') == 1 ) {
						// Special routine for website creation.
						// Adding basic set of users and groups in order to make the website viable.
						// At this point; some data have been converted. In this case user credential given by the "add website" command.
						$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ ." : Website creation"));
						$CurrentSetObj->setDataSubEntry('cli', 'websiteCreation', 1);
						$SpecialCommandBuffer = array(
							"website context name '".$CCL['params']['name']."' user '*user_install*' password '*user_install*'",
							"add group name 'Server_owner' parent origin title ROOT tag SENIOR_STAFF file 'media/img/universal/icon_dev_001.jpg' desc 'Owner'",
							"add group name Reader parent Server_owner title Reader tag READER file 'media/img/universal/icon_dev_001.jpg' desc 'Reader'",
							"add group name Anonymous parent reader title Anonymous tag ANONYMOUS file 'media/img/universal/icon_dev_001.jpg' desc 'Nobody'",
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
				$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : unknown entity :`".$CCL['init']['entity']."`"));
			}
		}
		else {
			// Command not found
			$CCL['errFlag'] = 1;
			$CCL['errMsg'] = "Command not found";
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : Command not found in \$ActionTable['".$CCL['init']['cmd']."']['".$CCL['init']['entity']."']"));
		}
		
		self::$report['signal'] = ( $CCL['errFlag'] == 1 ) ? "ERR" : "OK";
		$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ ." : End"));
		
	}
	
	//@formatter:off
	public static function getReport() {return self::$report;}
	public static function getReportEntry( $a ) {return self::$report[$a];}
	public static function setReport($report) {self::$report = $report;}
	//@formatter:on

}

?>

