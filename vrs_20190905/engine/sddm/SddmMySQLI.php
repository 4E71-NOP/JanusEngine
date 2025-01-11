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
// --------------------------------------------------------------------------------------------

class SddmMySQLI extends SddmCore
{
	private static $Instance = null;
	private $DBInstance = null;
	private $SDDMTools = null;

	private function __construct()
	{
		$this->SDDMTools = SddmTools::getInstance();
	}

	/**
	 * Singleton : Will return the instance of this class.
	 * @return SddmMySQLI
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new SddmMySQLI();
		}
		return self::$Instance;
	}

	/**
	 * Connects to the database.
	 */
	public function connect()
	{
		$bts = BaseToolSet::getInstance();

		$TabConfig = $bts->CMObj->getConfiguration();
		$bts->LMObj->getMsgLog($bts->CMObj->toStringConfiguration());
		$timeBegin = $bts->TimeObj->getMicrotime();

		$bts->LMObj->msgLog(array(
			'level' => LOGLEVEL_BREAKPOINT,
			'msg' => __METHOD__ . " DB connection parameters : '"
				. " host=" . $TabConfig['host']
				. "; db_user_login=" . $TabConfig['db_user_login']
				. "; dbprefix=" . $TabConfig['dbprefix']
				. "; port=" . $TabConfig['port']
		));
		switch ($bts->CMObj->getConfigurationEntry('execution_context')) {
			case "installation":
				$this->DBInstance = new mysqli($TabConfig['host'], $TabConfig['db_user_login'], $TabConfig['db_user_password'], null, (strlen($TabConfig['port'] ?? '') > 0 ? $TabConfig['port'] : null));
				break;
			case "render":
			default:
				$this->DBInstance = new mysqli($TabConfig['host'], $TabConfig['db_user_login'], $TabConfig['db_user_password'], $TabConfig['dbprefix'], (strlen($TabConfig['port'] ?? '') > 0 ? $TabConfig['port'] : null));
				break;
		}
		if ($this->DBInstance->connect_error) {
			$SQLlogEntry = array();
			$SQLlogEntry['err_no'] = $this->DBInstance->connect_error;
			$SQLlogEntry['err_no_expr'] = "PHP MysqlI Err : " . $SQLlogEntry['err_no'];
			$SQLlogEntry['err_msg'] = $this->DBInstance->connect_error;
			$SQLlogEntry['signal'] = "ERR";
			$bts->LMObj->logSQLDetails(array($timeBegin, $bts->LMObj->getSqlQueryNumber(), $bts->MapperObj->getSqlApplicant(), $bts->SQLlogEntry['signal'], "Connexion", $bts->SQLlogEntry['err_no_expr'], $bts->SQLlogEntry['err_msg'], $bts->TimeObj->getMicrotime()));
			// $this->errorMsg();
			$msg = "CONNEXION ERROR / err_msg " . $this->DBInstance->connect_error;
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_ERROR, 'msg' => __METHOD__ . " : " . $msg));
			$this->report['cnxErr'] = 1;
		} else {
			$this->DBInstance->autocommit(TRUE);
		}
	}

	/**
	 * Disconnects from the database.
	 */
	public function disconnect_sql()
	{
		$this->DBInstance->close();
	}

	/**
	 * Sends a query to the database and manage errors
	 * @param String $q
	 * @return mysqli_result|boolean
	 */
	public function query($q)
	{
		$bts = BaseToolSet::getInstance();
		$timeBegin = $bts->TimeObj->getMicrotime();

		$bts->LMObj->increaseSqlQueryNumber();
		$db_result = $this->DBInstance->query($q);
		$SQLlogEntry = array(
			"err_no"		=> $this->DBInstance->errno,
			"err_no_expr"	=> "PHP MysqlI Err : " . $this->DBInstance->errno,
			"err_msg"		=> $this->DBInstance->error,
			"signal"		=> "OK",
		);

		if ($this->DBInstance->errno != 0) {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_ERROR, 'msg' => __METHOD__ . " : " . $this->DBInstance->errno . " " . $this->DBInstance->error . " Query : `" . $bts->StringFormatObj->formatToLog($q) . "`."));
			$SQLlogEntry['signal'] = "ERR";
			return false;
			// error_log ("ERR " . time() . " (" . $this->DBInstance->errno . ") " . $this->DBInstance->error . " Query : " . $q ." ");
		}

		if ($bts->CMObj->getConfigurationEntry('InsertStatistics') == 1) {
			$bts->LMObj->IncreaseSqlQueries();
		}
		$bts->LMObj->logSQLDetails(array($timeBegin, $bts->LMObj->getSqlQueryNumber(), $bts->MapperObj->getSqlApplicant(), $SQLlogEntry['signal'], $q, $SQLlogEntry['err_no_expr'], $SQLlogEntry['err_msg'], $bts->TimeObj->getMicrotime()));

		switch ($bts->CMObj->getConfigurationEntry('execution_context')) {
			case "installation":
				$StringFormatObj = StringFormat::getInstance();
				$bts->LMObj->increaseSqlQueryNumber();
				$q = $StringFormatObj->shorteningExpression($q, 256);
				// $bts->LMObj->logSQLDetails(
				// 	array (
				// 		$timeBegin,
				// 			$bts->LMObj->getSqlQueryNumber(),
				// 			$bts->MapperObj->getWhereWeAreAt(),
				// 		$SQLlogEntry['signal'],
				// 		$q,
				// 		$SQLlogEntry['err_no_expr'],
				// 		$SQLlogEntry['err_msg'],
				// 			$bts->TimeObj->getMicrotime(),
				// 	)
				// );
				break;
		}
		return $db_result;
	}

	public function executeContent($script)
	{
		$bts = BaseToolSet::getInstance();

		$db_result = $this->DBInstance->execute($script);
		$bts->LMObj->msgLog(array('level' => LOGLEVEL_WARNING, 'msg' => __METHOD__ . " Mysqli::execute() returned : '" . $db_result . "'."));
	}

	/**
	 * Returns the number of row from the given resultset. 
	 * @param mysqli_result $data
	 * @return Number
	 */
	public function num_row_sql($data)
	{
		$nbr = $data->num_rows;
		if ($nbr == 0) {
			$this->SDDMTools->SLMEmptyResult();
		}
		return $nbr;
	}

	/**
	 * Returns a row from a the data which is produced by a query. 
	 * @param mysqli_result $data
	 * @return Array
	 */
	public function fetch_array_sql($data)
	{
		return $data->fetch_assoc();
	}

	/**
	 * Returns a escaped string.
	 * @param String $data
	 * @return String
	 */
	public function escapeString($data)
	{
		return $this->DBInstance->real_escape_string($data);
	}

	/**
	 * Returns the err string.
	 * @return string
	 */
	public function getError()
	{
		return $this->DBInstance->error;
	}

	/**
	 * Returns the errno string.
	 * @return string
	 */
	public function getErrno()
	{
		return $this->DBInstance->errno;
	}

	/**
	 * Returns the next (as greater number) ID number of any given table.
	 * It will always add 1. It won't find a free number.
	 * @deprecated
	 * @param string $table
	 * @param string $column
	 * @return number
	 */
	public function findNextId($table, $column)
	{
		$val = 0;
		$dbquery = $this->query("SELECT " . $column . " FROM " . $table . " ORDER BY " . $column . " DESC LIMIT 1;");
		while ($dbp = $this->fetch_array_sql($dbquery)) {
			if ($dbp[$column] > $val) {
				$val = $dbp[$column];
			}
		}
		$val++;
		return $val;
	}
}
