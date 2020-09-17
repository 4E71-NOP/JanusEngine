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

class LogManagement {
	private static $Instance = null;
	
	private $StoreStatisticsState = 1;
	
	private $StatisticsIndex = -1;
	private $StatisticsLog = array();

	private $SqlQueryNumber = 0;
	private $SlmSqlIdx = 0;
	private $SqlQueryLog = array();
	
	private $DebugLogIdx = 0;
	private $DebugLogEcho = 0;
	private $DebugLog = array();
	
	private $LastInternalLogTarget = "both";
	private $InternalLogTarget = "both";
	private $InternalLogIdx = 0;
	private $InternalLog = array();
	
	
	private static $logFunctions = array();
	
	
	private function __construct() {}

	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new LogManagement();
			self::makeLogFunctions();
		}
		return self::$Instance;
	}

	private static function makeLogFunctions() {
		self::$logFunctions['default']['internal']		= function ($data) {
			$CurrentSetObj = CurrentSet::getInstance();
			$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
			$SqlTableListObj = SqlTableList::getInstance('','');
			
			$SDDMObj = DalFacade::getInstance()->getDALInstance();
			$data['i'] = $SDDMObj->escapeString($data['i']);
			$data['a'] = $SDDMObj->escapeString($data['a']);
			$data['t'] = $SDDMObj->escapeString($data['t']);
			$id	= $SDDMObj->findNextId($SqlTableListObj->getSQLTableName('historique'), "historique_id" );
			$SDDMObj->query("INSERT INTO ".$SqlTableListObj->getSQLTableName('historique')." VALUES (
						'".$id."', '".$WebSiteObj->getWebSiteEntry('ws_id')."', '".time ()."', '".$data['i']."',
						'".$data['a']."', '".$data['s']."', '".$data['m']."', '".$data['t']."') ;");
			};
		self::$logFunctions['default']['system']		= function ($a) { error_log ( html_entity_decode ( $a ) ,0 );};
		self::$logFunctions['default']['echo']			= function ($a) { echo ($a); };

		self::$logFunctions['installation']['internal']	= function ($a) {};
		self::$logFunctions['installation']['system']	= &self::$logFunctions['default']['system'];
		self::$logFunctions['installation']['echo']		= &self::$logFunctions['default']['echo'];

		self::$logFunctions['render']['internal']		= function ($a) {};
		self::$logFunctions['render']['system']			= &self::$logFunctions['default']['system'];
		self::$logFunctions['render']['echo']			= &self::$logFunctions['default']['echo'];
		
		self::$logFunctions['adminMenu']['']			= function ($a) {};
		self::$logFunctions['adminMenu']['system']		= &self::$logFunctions['default']['system'];
		self::$logFunctions['adminMenu']['echo']		= &self::$logFunctions['default']['echo'];		
		
		self::$logFunctions['extenssion']['']			= function ($a) {};
		self::$logFunctions['extenssion']['system']		= &self::$logFunctions['default']['system'];
		self::$logFunctions['extenssion']['echo']		= &self::$logFunctions['default']['echo'];		
	}
	
	
	public function logCheckpoint( $routine ) {
// 		if ($_REQUEST ['StatistiqueInsertion'] == 1) {
		if ($this->StoreStatisticsState == 1) {
			$TimeObj = Time::getInstance();
			$MapperObj = Mapper::getInstance();
			
			// Deprecated begin
			global $statistiques_, $statistiques_index;
			$statistiques_index ++;
			$i = &$statistiques_index;
			$statistiques_ [$i] ['position'] = $i;
			$statistiques_ [$i] ['context'] = $MapperObj->getWhereWeAreAt();
			$statistiques_ [$i] ['routine'] = $routine;
			$statistiques_ [$i] ['temps'] = $TimeObj->microtime_chrono ();
			$statistiques_ [$i] ['memoire'] = memory_get_usage ();
			$statistiques_ [$i] ['SQL_err'] = 0;
			$statistiques_ [$i] ['SQL_queries'] = 0;
			// Deprecated end 
			
			$this->StatisticsIndex++;
			$this->StatisticsLog[$this->StatisticsIndex]['position'] = $this->StatisticsIndex;
			$this->StatisticsLog[$this->StatisticsIndex]['context'] = $MapperObj->getWhereWeAreAt();
			$this->StatisticsLog[$this->StatisticsIndex]['routine'] = $routine;
			$this->StatisticsLog[$this->StatisticsIndex]['temps'] = $TimeObj->microtime_chrono ();
			$this->StatisticsLog[$this->StatisticsIndex]['memoire'] = memory_get_usage ();
			$this->StatisticsLog[$this->StatisticsIndex]['SQL_err'] = 0;
			$this->StatisticsLog[$this->StatisticsIndex]['SQL_queries'] = 0;
		}
	}

	public function getStatisticsEntry ( $data ) {
		return $this->StatisticsLog[$data];
	}
	
	public function IncreaseSqlQueries () {
		$this->StatisticsLog[$this->StatisticsIndex]['SQL_queries']++;

		// Deprecated begin
		global $statistiques_, $statistiques_index;
		$i = &$statistiques_index;
		$statistiques_ [$i] ['SQL_queries']++;
		// Deprecated end
		
	}
	
	public function logSQLDetails($data) {
		// Deprecated begin
		global $SQL_requete;
		$idx = $this->SlmSqlIdx;
		$SQL_requete [$idx] ['temps_debut'] = $data [0];
		$SQL_requete [$idx] ['nbr'] = $data [1];
		$SQL_requete [$idx] ['nom'] = $data [2];
		$SQL_requete [$idx] ['signal'] = $data [3];
		$SQL_requete [$idx] ['requete'] = $data [4];
		$SQL_requete [$idx] ['err_no'] = $data [5];
		$SQL_requete [$idx] ['err_msg'] = $data [6];
		$SQL_requete [$idx] ['temps_fin'] = $data [7];
		$SQL_requete [$idx]++;
		// Deprecated end
		
		$this->SqlQueryLog[$this->SlmSqlIdx]['temps_debut'] = $data [0]; 
		$this->SqlQueryLog[$this->SlmSqlIdx]['nbr'] = $data [1];
		$this->SqlQueryLog[$this->SlmSqlIdx]['nom'] = $data [2];
		$this->SqlQueryLog[$this->SlmSqlIdx]['signal'] = $data [3];
		$this->SqlQueryLog[$this->SlmSqlIdx]['requete'] = $data [4];
		$this->SqlQueryLog[$this->SlmSqlIdx]['err_no'] = $data [5];
		$this->SqlQueryLog[$this->SlmSqlIdx]['err_msg'] = $data [6];
		$this->SqlQueryLog[$this->SlmSqlIdx]['temps_fin'] = $data [7];
		$this->SlmSqlIdx ++;
	}

	public function logSQLMoreDetailsOnLast($data) {
		global $SQL_requete;
		$idx = $this->SlmSqlIdx - 1;
		// Deprecated begin
		$SQL_requete [$idx] ['signal'] = $data [3];
		$SQL_requete [$idx] ['err_no'] = $data [5];
		$SQL_requete [$idx] ['err_msg'] .= ". " . $data [6];
		// Deprecated end
		
		$this->SqlQueryLog[$idx]['signal'] = $data [3];
		$this->SqlQueryLog[$idx]['err_no'] = $data [5];
		$this->SqlQueryLog[$idx]['err_msg'] = ". " . $data [6];
	}
	
	public function getLastSQLDetails () {
		return $this->SqlQueryLog[($this->SlmSqlIdx-1)];
	}

	public function increaseSqlQueryNumber () {
		$this->SqlQueryNumber++;
	}
	
	public function getSqlQueryLogEntry ( $data ) {
		return $this->SqlQueryLog[$data];
	}

	/**
	 * Inserts into the $this->InternalLog array a new line.
	 * @param array $data
	 */
	public function InternalLog ($msg) {
		$dbg = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 4);
		$i = 0;
		foreach ( $dbg as $A ) {
			if ( $i > 0 ) {
				$dbgString .= $A['function']."() <-";
// 				$dbgString .= $A['function']."() from ".substr($A['file'], strrpos($A['file'], "/" )+1)."\r";
			}
			$i++;
		}
		$data = array (
			"nbr" => $this->InternalLogIdx,
			"origin" => $dbgString,
			"message" => $msg,
		);
		
		$src = array("<b>", "</b>", "<br>", "\r");
		$rpl = array("", "", " <- ", "");
		switch ( $this->InternalLogTarget ) {
			case 'internal':
				$this->InternalLog[$this->InternalLogIdx] = $data;
				$this->InternalLogIdx++;
				break;
			case 'system':
				error_log("InternalLog N " . $data['nbr']. "; ". $data['message']. "; " . str_replace ($src, $rpl, $data['origin']) );
			break;
			case 'both':
				$this->InternalLog[$this->InternalLogIdx] = $data;
				$this->InternalLogIdx++;
				error_log("InternalLog N " . $data['nbr']. "; ". $data['message']. "; " . str_replace ($src, $rpl, $data['origin']) );
				break;
			case "none":
			default:
				break;
		}
		
	}

	
	/**
	 * Inserts into the $this->DebugLog array a new line.
	 * @param array $data
	 * @param string $name
	 */
	public function logDebug ( $data , $name ) {
		$CMobj = ConfigurationManagement::getInstance();
		switch ($CMobj->getExecutionContext()) {
			case "render":
				$dbg = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5);
				$MapperObj = Mapper::getInstance();
				$dbgString = "";
				foreach ( $dbg as $A ) {
					$dbgString .= $A['function']. "() from ". substr ( $A['file'], strrpos($A['file'], "/" )+1 ) . "<br>\r";
				}
				
				$this->DebugLog[$this->DebugLogIdx]['name'] = str_replace("->", "<br>->\r", $name) ."<br>\r".$MapperObj->getWhereWeAreAt()."<br>\r".$dbgString;
				$this->DebugLog[$this->DebugLogIdx]['data'] = $data;
				$this->DebugLogIdx++;
				break;
			case "installation" : 
					if ( $this->DebugLogEcho == 1 ) { echo ($data);	}	// School of hard knocks debug.
				break;
		}
	}

	/**
	 * Log the messages depending on the configuration and context (install, render, etc.).
	 * 
	 * i=Initiator
	 * a=Action
	 * s=Signal
	 * m=msgCode
	 * t=Text
	 * 
	 * @param array $data
	 */
	public function log ($data) {
		$CMobj = ConfigurationManagement::getInstance();
		$SqlTableListObj = SqlTableList::getInstance('','');

		$CurrentSetObj = CurrentSet::getInstance();
		$WebSiteObj = $CurrentSetObj->getInstanceOfWebSiteObj();
		
// 		$this->logDebug($CMobj->getConfigurationEntry('contexte_d_execution'), "Context d'execution");
// 		$this->logDebug($CMobj->getConfigurationEntry('LogTarget'), "LogTarget");

		$tabSignal = array ("ERR"=>1,"WARN"=>2,"INFO"=>3);
		$data['s'] = $tabSignal[$data['s']];
		
		switch ( $CMobj->getConfigurationEntry('execution_context') ) {
			case 'installation':
			switch ($CMobj->getConfigurationEntry('LogTarget')) {
				case "system" :
					$A = "MWM_Engine_log: ".$WebSiteObj->getWebSiteEntry('ws_id')."|".time ()."|".$data['i']."|".$data['a']."|".$data['s']."|".$data['m']."|".$data['t'];
					error_log ( html_entity_decode ( $A ) ,0 );
				break;
				case "echo" :
				break;
					
			}
			break;

			case "admin_menu":
			case "Admin_menu":
			case "Extension_installation":
			case "Rendu":
			case "render":
			default:
				$SDDMObj = DalFacade::getInstance()->getDALInstance();
				$data['i'] = $SDDMObj->escapeString($data['i']);
				$data['a'] = $SDDMObj->escapeString($data['a']);
				$data['t'] = $SDDMObj->escapeString($data['t']);
				switch ( $CMobj->getConfigurationEntry('LogTarget') ) {
					case "systeme" :
					case "system" :
						$A = "MWM_Engine_log: ".$WebSiteObj->getWebSiteEntry('ws_id')."|".time ()."|".$data['i']."|".$data['a']."|".$data['s']."|".$data['m']."|".$data['t'];
						error_log ( html_entity_decode ( $A ) ,0 );
						break;
					case "echo" :
						echo ( "MWM_Engine_log: ".$WebSiteObj->getWebSiteEntry('ws_id')."|".time ()."|".$data['i']."|".$data['a']."|".$data['s']."|".$data['m']."|".$data['t'] ."<br>" );
						break;
					case "internal" :
					default:
						$id	= $SDDMObj->findNextId($SqlTableListObj->getSQLTableName('historique'), "historique_id" );
						$SDDMObj->query("INSERT INTO ".$SqlTableListObj->getSQLTableName('historique')." VALUES (
						'".$id."', '".$WebSiteObj->getWebSiteEntry('ws_id')."', '".time ()."', '".$data['i']."',
						'".$data['a']."', '".$data['s']."', '".$data['m']."', '".$data['t']."') ;");
						break;
				}
		}
	}
	
	//@formatter:off
	public function setStoreStatisticsStateOn() { $this->StoreStatisticsState = 1; }
	public function setStoreStatisticsStateOff () { $this->StoreStatisticsState = 0; }

	public function getStoreStatisticsState() { return $this->StoreStatisticsState; }

	public function getStatisticsIndex() { return $this->StatisticsIndex; }
	public function getDebugLogEcho() { return $this->DebugLogEcho; }
	public function getStatisticsLog() { return $this->StatisticsLog; }

	
	public function getSqlQueryNumber() { return $this->SqlQueryNumber; }
	public function getSlmSqlIdx() { return $this->SlmSqlIdx; }
	public function getSqlQueryLog() { return $this->SqlQueryLog; }

	public function getDebugLog() { return $this->DebugLog; }
	
	public function getInternalLog() { return $this->InternalLog; }
	public function getInternalLogTarget() { return $this->InternalLogTarget; }
	//--------------------------------------------------------------------------------
	public function setStatisticsIndex($StatisticsIndex) { $this->StatisticsIndex = $StatisticsIndex; }
	public function setStatisticsLog($StatisticsLog) { $this->StatisticsLog = $StatisticsLog; }
	
	public function setSlmSqlIdx($SlmSqlIdx) { $this->SlmSqlIdx = $SlmSqlIdx; }
	public function setDebugLogEcho($DebugLogEcho) { $this->DebugLogEcho = $DebugLogEcho; }
	public function setSqlQueryLog($SqlQueryLog) { $this->SqlQueryLog = $SqlQueryLog;}

	public function setInternalLog($InternalLog) { $this->InternalLog = $InternalLog; }
	public function setInternalLogTarget($InternalLogTarget) {
		$this->LastInternalLogTarget = $this->InternalLogTarget; 
		$this->InternalLogTarget = $InternalLogTarget; 
	}
	public function restoreLastInternalLogTarget () {$this->InternalLogTarget = $this->LastInternalLogTarget; }
	
	//@formatter:on



}

?>

