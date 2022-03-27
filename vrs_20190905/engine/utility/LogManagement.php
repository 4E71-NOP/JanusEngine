<?php
/* Hydre-licence-debut */
// --------------------------------------------------------------------------------------------
//
// Hydre - Le petit moteur de web
// Sous licence Creative Common
// Under Creative Common licence CC-by-nc-sa (http://creativecommons.org)
// CC by = Attribution; CC NC = Non commercial; CC SA = Share Alike
//
// (c)Faust MARIA DE AREVALO faust@club-internet.fr
//
// --------------------------------------------------------------------------------------------
/* Hydre-licence-fin */
class LogManagement {
	private static $Instance = null;


	private $vectorSystemLog			= true;
	private $vectorSystemLogLevel		= SYSTEM_LOG_LEVEL;
	private $vectorSystemLogLevelSave	= SYSTEM_LOG_LEVEL;

	private $vectorInternal				= true;
	private $vectorInternalLevel		= INTERNAL_LOG_LEVEL;
	private $msgLogIdx = 0;
	private $msgLog = array ();

	private $StoreStatisticsState = true;
	private $StatisticsIndex = -1;
	private $StatisticsLog = array ();

	private $SqlQueryNumber = 0;
	private $SlmSqlIdx = 0;
	private $SqlQueryLog = array ();

	private $DebugLogIdx = 0;
	private $DebugLogEcho = 0;
	private $DebugLog = array ();


	// private static $logFunctions = array ();
	// private $TagList = array(0=> "", 1 => "[ERR]", 2 => "[WRN]", 3 => "[INF]", 4 => "[STM]", 5 => "[BKP]");
	
	private function __construct() {
	}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return LogManagement
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new LogManagement ();
			// self::makeLogFunctions ();
		}
		return self::$Instance;
	}

	/**
	 * Log message into system log facility or into internal table (or both)
	 */
	public function msgLog($log, $origin=false) {
		error_reporting(0);
		$dbg = debug_backtrace ( DEBUG_BACKTRACE_IGNORE_ARGS, 20 );
		$originStr = "";
		$i = 0;
		foreach ( $dbg as $A ) {
			if ($i > 0) { $originStr .= $A['class'].$A['type'].$A['function']."()@".$A['line'] . " "; }
			$i ++;
		}
		
		if (isset($log['level'])) { $msgFlag=1; $logLevel = $log['level']; }
		else { $msgFlag=0; $logLevel=0; $origin = true; }
		
		$data = array (
				"nbr" => $this->msgLogIdx,
				"origin" => ( $origin === false ) ? "": $originStr,
				"message" => ($msgFlag == 1) ? $log['msg']: "EMPTY LOG !!!!",
		);


		if ( $this->vectorInternal == true && $logLevel <= $this->vectorInternalLevel ) {
			$this->msgLog [$this->msgLogIdx] = $data;
			$this->msgLogIdx ++;
		}
		if ( $this->vectorSystemLog == true && $logLevel <= $this->vectorSystemLogLevel ) {
			error_log ( $log['level']."<=".$this->vectorInternalLevel."; InternalLog N " . $data['nbr'] . "; " . $data['message'] . "; " . $data['origin'] );
		}
		error_reporting(DEFAULT_ERROR_REPORTING);
	}


	/**
	 * Stores several informations in the purpose of evaluating the performances at a later moment
	 */
	public function logCheckpoint($routine) {
		if ($this->StoreStatisticsState == true) {
			$bts = BaseToolSet::getInstance();
			$this->StatisticsIndex ++;
			
// 			error_log ("inserting ".$bts->MapperObj->getWhereWeAreAt() . " at position :" . $this->StatisticsIndex);
			$bts->LMObj->msgLog( array( 'level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ . " : inserting ".$bts->MapperObj->getWhereWeAreAt() . " at position :" . $this->StatisticsIndex));
			
			$this->StatisticsLog [$this->StatisticsIndex] ['position'] = $this->StatisticsIndex;
			$this->StatisticsLog [$this->StatisticsIndex] ['context'] = $bts->MapperObj->getWhereWeAreAt ();
			$this->StatisticsLog [$this->StatisticsIndex] ['routine'] = $routine;
			$this->StatisticsLog [$this->StatisticsIndex] ['temps'] = $bts->TimeObj->getMicrotime ();
			$this->StatisticsLog [$this->StatisticsIndex] ['memoire'] = memory_get_usage ();
			$this->StatisticsLog [$this->StatisticsIndex] ['SQL_err'] = 0;
			$this->StatisticsLog [$this->StatisticsIndex] ['SQL_queries'] = 0;
		}
	}
	
	/**
	 * Returns an entry from the StatisticsLog table
	 */
	public function getStatisticsEntry($data) {
		return $this->StatisticsLog [$data];
	}
	
	/**
	 * Increase number of SQL queries in the log array
	 */
	public function IncreaseSqlQueries() {
		$this->StatisticsLog [$this->StatisticsIndex] ['SQL_queries'] ++;
	}
	
	/**
	 * Inserts an entry in the SqlQueryLog array
	 */
	public function logSQLDetails($data) {
		$this->SqlQueryLog [$this->SlmSqlIdx] ['temps_debut'] = $data [0];
		$this->SqlQueryLog [$this->SlmSqlIdx] ['nbr'] = $data [1];
		$this->SqlQueryLog [$this->SlmSqlIdx] ['nom'] = $data [2];
		$this->SqlQueryLog [$this->SlmSqlIdx] ['signal'] = $data [3];
		$this->SqlQueryLog [$this->SlmSqlIdx] ['requete'] = $data [4];
		$this->SqlQueryLog [$this->SlmSqlIdx] ['err_no'] = $data [5];
		$this->SqlQueryLog [$this->SlmSqlIdx] ['err_msg'] = $data [6];
		$this->SqlQueryLog [$this->SlmSqlIdx] ['temps_fin'] = $data [7];
		$this->SlmSqlIdx ++;
	}
	
	/**
	 * Change the last entry in the SqlQueryLog array
	 */
	public function logSQLMoreDetailsOnLast($data) {
		$idx = $this->SlmSqlIdx - 1;
		
		$this->SqlQueryLog [$idx] ['signal'] = $data [3];
		$this->SqlQueryLog [$idx] ['err_no'] = $data [5];
		$this->SqlQueryLog [$idx] ['err_msg'] = ". " . $data [6];
	}
	
	public function getLastSQLDetails() {
		return $this->SqlQueryLog [($this->SlmSqlIdx - 1)];
	}
	
	public function increaseSqlQueryNumber() {
		$this->SqlQueryNumber ++;
	}
	
	public function getSqlQueryLogEntry($data) {
		return $this->SqlQueryLog [$data];
	}
	
	/**
	 * Inserts into the $this->DebugLog array a new line.
	 *
	 * @param array $data
	 * @param string $name
	 */
	public function logDebug($data, $name) {
		$bts = BaseToolSet::getInstance();
// 		$CMobj = ConfigurationManagement::getInstance ();
		switch ($bts->CMObj->getExecutionContext ()) {
			case "render" :
				$dbg = debug_backtrace ( DEBUG_BACKTRACE_IGNORE_ARGS, 5 );
				$bts->MapperObj = Mapper::getInstance ();
				$dbgString = "";
				foreach ( $dbg as $A ) {
					$dbgString .= $A ['function'] . "() from " . substr ( $A ['file'], strrpos ( $A ['file'], "/" ) + 1 ) . "<br>\r";
				}
				
				$this->DebugLog [$this->DebugLogIdx] ['name'] = str_replace ( "->", "<br>->\r", $name ) . "<br>\r" . $bts->MapperObj->getWhereWeAreAt() . "<br>\r" . $dbgString;
				$this->DebugLog [$this->DebugLogIdx] ['data'] = $data;
				$this->DebugLogIdx ++;
				break;
			case "installation" :
				if ($this->DebugLogEcho == 1) {
					echo ($data);
				} // School of hard knocks debug.
				break;
		}
	}


	//@formatter:off
	public function getStoreStatisticsState() { return $this->StoreStatisticsState; }

	public function getStatisticsIndex() { return $this->StatisticsIndex; }
	public function getDebugLogEcho() { return $this->DebugLogEcho; }
	public function getStatisticsLog() { return $this->StatisticsLog; }

	
	public function getSqlQueryNumber() { return $this->SqlQueryNumber; }
	public function getSlmSqlIdx() { return $this->SlmSqlIdx; }
	public function getSqlQueryLog() { return $this->SqlQueryLog; }

	public function getDebugLog() { return $this->DebugLog; }
	
	public function getMsgLog() { return $this->msgLog; }
	//--------------------------------------------------------------------------------
	public function setVectorSystemLog		($data) { $this->vectorSystemLog = $data;}
	public function setVectorSystemLogLevel	($data) { $this->vectorSystemLogLevel = $data;}
	public function setVectorInternal		($data) { $this->vectorInternal = $data;}
	public function setVectorInternalLevel	($data) { $this->vectorInternalLevel = $data;}

	public function setStoreStatisticsStateOn() { $this->StoreStatisticsState = true; }
	public function setStoreStatisticsStateOff () { $this->StoreStatisticsState = false; }

	public function setStatisticsIndex($StatisticsIndex) { $this->StatisticsIndex = $StatisticsIndex; }
	public function setStatisticsLog($StatisticsLog) { $this->StatisticsLog = $StatisticsLog; }
	
	public function setSlmSqlIdx($SlmSqlIdx) { $this->SlmSqlIdx = $SlmSqlIdx; }
	public function setDebugLogEcho($DebugLogEcho) { $this->DebugLogEcho = $DebugLogEcho; }
	public function setSqlQueryLog($SqlQueryLog) { $this->SqlQueryLog = $SqlQueryLog;}

	public function setMsgLog($msgLog) { $this->msgLog = $msgLog; }
	//--------------------------------------------------------------------------------
	public function saveVectorSystemLogLevel () { $this->vectorSystemLogLevelSave = $this->vectorSystemLogLevel; }
	public function restoreVectorSystemLogLevel () { $this->vectorSystemLogLevel = $this->vectorSystemLogLevelSave; }
	

	// @formatter:on
}

?>
