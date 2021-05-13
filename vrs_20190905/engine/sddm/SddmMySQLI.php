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
// --------------------------------------------------------------------------------------------
// implements iSddm 
class SddmMySQLI {
	private static $Instance = null;

	private $DBInstance = null;
	private $SDDMTools = null;
	private $report;

	private function __construct(){
		$this->SDDMTools = SddmTools::getInstance();
	}

	/**
	 * Singleton : Will return the instance of this class.
	 * @return SddmMySQLI
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new SddmMySQLI();
		}
		return self::$Instance;
	}
	
	/**
	 * Connects to the database.
	 */
	public function connect() {
		$bts = BaseToolSet::getInstance();
		
		$TabConfig = $bts->CMObj->getConfiguration();
		$bts->LMObj->getInternalLog($bts->CMObj->toStringConfiguration());
		$timeBegin = $bts->TimeObj->microtime_chrono ();
		
		switch ( $bts->CMObj->getConfigurationEntry('execution_context')) {
			case "installation":
				$this->DBInstance = new mysqli( $TabConfig['host'] , $TabConfig['db_user_login'] , $TabConfig['db_user_password'] );
				break;
			case "render":
			default:
				$this->DBInstance = new mysqli( $TabConfig['host'] , $TabConfig['db_user_login'] , $TabConfig['db_user_password'] , $TabConfig['dbprefix'] );
				break;
		}
		if ($this->DBInstance->connect_error) {
			$SQLlogEntry = array();
			$SQLlogEntry['err_no'] = $this->DBInstance->connect_error;
			$SQLlogEntry['err_no_expr'] = "PHP MysqlI Err : " . $SQLlogEntry['err_no'];
			$SQLlogEntry['err_msg'] = $this->DBInstance->connect_error;
			$SQLlogEntry['signal'] = "ERR";
			$bts->LMObj->logSQLDetails ( array ( $timeBegin, $bts->LMObj->getSqlQueryNumber(), $bts->MapperObj->getSqlApplicant(), $bts->SQLlogEntry['signal'], "Connexion", $bts->SQLlogEntry['err_no_expr'], $bts->SQLlogEntry['err_msg'], $bts->TimeObj->microtime_chrono() ) );
			$this->errorMsg();
			$msg = "CONNEXION ERROR : err_msg" . $this->DBInstance->connect_error;
			$bts->LMObj->InternalLog( array('level'=> LOGLEVEL_ERROR , 'msg'=> __METHOD__ . " : " . $msg));
// 			error_log ($msg);
			$this->report['cnxErr'] = 1;
			
		}
		else {
			$this->DBInstance->autocommit(TRUE);
		}
	}
	
	/**
	 * Disconnects from the database.
	 */
	public function disconnect_sql () {
		$this->DBInstance->close();
	}
	
	/**
	 * Sends a query to the database and manage errors
	 * @param String $q
	 * @return mysqli_result|boolean
	 */
	public function query($q) {
		$bts = BaseToolSet::getInstance();
		$timeBegin = $bts->TimeObj->microtime_chrono();

		$bts->LMObj->increaseSqlQueryNumber();
		$db_result = $this->DBInstance->query ( $q );
		$SQLlogEntry = array(
			"err_no"		=> $this->DBInstance->errno,
			"err_no_expr"	=> "PHP MysqlI Err : " . $this->DBInstance->errno,
			"err_msg"		=> $this->DBInstance->error,
			"signal"		=> "OK",
		);
		
		// $DebugLevel = $bts->CMObj->getConfigurationEntry('DebugLevel_SQL');
		
		if ($this->DBInstance->errno != 0) {
			$bts->LMObj->InternalLog( array('level'=> LOGLEVEL_ERROR , 'msg'=> __METHOD__ . " : " . $this->DBInstance->errno . " " . $this->DBInstance->error . " Query : " . $q ));
// 			error_log ("ERR " . time() . " (" . $this->DBInstance->errno . ") " . $this->DBInstance->error . " Query : " . $q ." ");
			$SQLlogEntry['signal'] = "ERR";
			// $DebugLevel = 0;
		}
		
		if ($bts->CMObj->getConfigurationEntry('InsertStatistics') == 1) { $bts->LMObj->IncreaseSqlQueries(); }
		// if ($bts->CMObj->getConfigurationEntry('DebugLevel_SQL') >= $DebugLevel) {
			$bts->LMObj->logSQLDetails ( array ( $timeBegin, $bts->LMObj->getSqlQueryNumber(), $bts->MapperObj->getSqlApplicant(), $SQLlogEntry['signal'], $q, $SQLlogEntry['err_no_expr'], $SQLlogEntry['err_msg'], $bts->TimeObj->microtime_chrono () ) );
		// }
		
		switch ($bts->CMObj->getConfigurationEntry('execution_context')) {
			case "installation" :
				$StringFormatObj = StringFormat::getInstance();
				$bts->LMObj->increaseSqlQueryNumber();
				$q = $StringFormatObj->shorteningExpression($q, 256);
				$bts->LMObj->logSQLDetails(
					array (
						$timeBegin,
							$bts->LMObj->getSqlQueryNumber(),
							$bts->MapperObj->getWhereWeAreAt(),
						$SQLlogEntry['signal'],
						$q,
						$SQLlogEntry['err_no_expr'],
						$SQLlogEntry['err_msg'],
							$bts->TimeObj->microtime_chrono(),
					)
				);
				
				break;
		}
		return $db_result;
	}

	/**
	 * Returns the number of row from the given resultset. 
	 * @param mysqli_result $data
	 * @return Number
	 */
	public function num_row_sql($data) {
		$nbr = mysqli_num_rows ($data);
		if ( $nbr == 0 ) { $this->SDDMTools->SLMEmptyResult (); }
		return $nbr;
	}

	/**
	 * Returns the Nth row from a result. 
	 * @param mysqli_result $data
	 * @return Array
	 */
	public function fetch_array_sql($data) {
		return $data->fetch_assoc ();
	}

	/**
	 * Returns a escaped string.
	 * @param String $data
	 * @return String
	 */
	public function escapeString($data) {
		return $this->DBInstance->real_escape_string($data);
	}
	
	/**
	 * Returns the err string.
	 * @return string
	 */
	public function errorMsg() {
		return "err";
	}
	
	
	/**
	 * Returns the next (as greater number) ID number of any given table.
	 * It will always add 1. It won't find a free number.
	 *
	 * @param string $table
	 * @param string $column
	 * @return number
	 */
	public function findNextId ($table , $column ) {
		$val = 0;
		$dbquery = $this->query("SELECT ".$column." FROM ".$table." ORDER BY ".$column." DESC LIMIT 1;");
		while ($dbp = $this->fetch_array_sql($dbquery)) {
			if ( $dbp[$column] > $val ) { $val = $dbp[$column]; }
		}
		$val++;
		return $val;
	}
	
	//@formatter:off
	
	public function getReport() {return $this->report;}
	public function getReportEntry($data) {return $this->report[$data];}

	public function setReport($report) {$this->report = $report;}
	//@formatter:on
	
}

?>