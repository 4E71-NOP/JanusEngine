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
// --------------------------------------------------------------------------------------------

class SddmPDO {
	private static $Instance = null;
	
	private $DBInstance = 0;
	private $SDDMTools = 0;
	
	public function __construct(){
		$this->SDDMTools = SddmTools::getInstance();
	}
	
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new SddmPDO();
		}
		return self::$Instance;
	}
	
	public function connect(){
		$bts = BaseToolSet::getInstance();
		
		$TabConfig = $bts->CMObj->getConfiguration();
		$bts->LMObj->getMsgLog($bts->CMObj->toStringConfiguration());
		$SQL_temps_depart = $bts->TimeObj->getMicrotime ();
		
		$dsn = 
		"mysql:host=".$TabConfig['host'].
		";dbname=".$TabConfig['dbprefix'].
		";charset=".$TabConfig['charset'];
		$options = [
				PDO::ATTR_ERRMODE				=> PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE	=> PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES		=> false,
		];

		switch ( $bts->CMObj->getConfigurationEntry('execution_context')) {
			case "installation":
				$this->DBInstance = new PDO($dsn, $TabConfig['db_user_login'], $TabConfig['db_user_password'], $options);
				break;
			case "render":
			default:
				$this->DBInstance = new PDO($dsn, $TabConfig['db_user_login'], $TabConfig['db_user_password'], $options);
				break;
		}
		// List of error code
		// https://docstore.mik.ua/orelly/java-ent/jenut/ch08_06.htm
		if ( $this->DBInstance->errorCode() != '00000' ) {
			$SQLlogEntry = array();
			$SQLlogEntry['err_no'] = $this->DBInstance->errorCode();
			$SQLlogEntry['err_no_expr'] = "PHP MysqlI Err : " . $SQLlogEntry['err_no'];
			$SQLlogEntry['err_msg'] = $this->DBInstance->errorInfo();
			$SQLlogEntry['signal'] = "ERR";
			$bts->LMObj->logSQLDetails ( array ( $SQL_temps_depart, $bts->LMObj->getSqlQueryNumber(), $bts->MapperObj->getSqlApplicant(), $bts->SQLlogEntry['signal'], "Connexion", $bts->SQLlogEntry['err_no_expr'], $bts->SQLlogEntry['err_msg'], $bts->TimeObj->getMicrotime() ) );
			$this->errorMsg();
			$msg = "CONNEXION ERROR : "."err_no" . $this->DBInstance->errorCode().", err_msg" . $this->DBInstance->errorInfo();
			$bts->LMObj->msgLog( array('level'=> LOGLEVEL_ERROR , 'msg'=> __METHOD__ . " : " . $msg));
			// 			error_log ($msg);
			$this->report['cnxErr'] = 1;
			
		}
	}
	
	public function disconnect_sql () {
		$this->DBInstance = null;		// this is the way PDO works. https://www.php.net/manual/en/pdo.connections.php
	}
	/**
	 * 
	 * @param String $q
	 * @return PDOStatement
	 */
	public function query($q) {
		$bts = BaseToolSet::getInstance();
		$timeBegin = $bts->TimeObj->getMicrotime();
		
		$SQL_temps_depart = $bts->TimeObj->getMicrotime ();
		$bts->LMObj->increaseSqlQueryNumber();
		$db_result = $this->DBInstance->query($q);
		$SQLlogEntry = array();
		$SQLlogEntry['err_no'] = $this->DBInstance->errorCode();
		$SQLlogEntry['err_no_expr'] = "PHP PDO Err : " . $SQLlogEntry['err_no'];
		$SQLlogEntry['err_msg'] = $this->DBInstance->errorInfo();
		$SQLlogEntry['signal'] = "OK";
		
		if ($this->DBInstance->errorCode() != 0) {
			$bts->LMObj->msgLog( array('level'=> LOGLEVEL_ERROR , 'msg'=> __METHOD__ . " : " . $this->DBInstance->errorCode() . " " . $this->DBInstance->errorInfo() . " Query : `" . $bts->StringFormatObj->formatToLog($q)."`." ));
			$SQLlogEntry['signal'] = "ERR";
		}
		
		if ($bts->CMObj->getConfigurationEntry('InsertStatistics') == 1) { $bts->LMObj->IncreaseSqlQueries(); }
		$bts->LMObj->logSQLDetails ( array ( $SQL_temps_depart, $bts->LMObj->getSqlQueryNumber(), $bts->MapperObj->getSqlApplicant(), $SQLlogEntry['signal'], $q, $SQLlogEntry['err_no_expr'], $SQLlogEntry['err_msg'], $bts->TimeObj->getMicrotime () ) );
		
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
								$bts->TimeObj->getMicrotime(),
						)
						);
				
				break;
		}
		return $db_result;
	}

	public function num_row_sql($res) {
		return $res->rowCount();			//Only work because we have "PDO::FETCH_ASSOC". Don't change it.
	}
	public function fetch_array_sql($res) {
		return $res->fetch(PDO::FETCH_ASSOC);
	}
	public function escapeString($res) {
		$this->DBInstance->quote($res);
	}
	
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
	
	/**
	 * Create an UID with random function
	 * @return string
	 */
	public function createUniqueId(){
		return random_bytes(8);
	}

	//@formatter:off
	
	public function getReport() {return $this->report;}
	public function getReportEntry($data) {return $this->report[$data];}
	
	public function setReport($report) {$this->report = $report;}
	//@formatter:on
	
}

?>
