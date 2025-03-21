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

class SddmPgsql extends SddmCore
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
	 * @return SddmPgsql
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new SddmPgsql();
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

		$dsn = "host=" . $TabConfig['host'] . " dbname=" . $TabConfig['dbprefix'] . (strlen($TabConfig['port'] ?? '') > 0 ? $TabConfig['port'] : '');

		switch ($bts->CMObj->getConfigurationEntry('execution_context')) {
			case "installation":
				$this->DBInstance = pg_connect($dsn . " user=" . $TabConfig['db_user_login'] . " password=" . $TabConfig['db_user_password']);
				break;
			case "render":
			default:
				$this->DBInstance = pg_connect($dsn . " user=" . $TabConfig['db_user_login'] . " password=" . $TabConfig['db_user_password']);
				break;
		}

		if ($this->DBInstance) {
			pg_exec($this->DBInstance, "SET SCHEMA '" . $bts->CMObj->getConfigurationSubEntry('db', 'dbprefix') . "';");
		} else {
			$SQLlogEntry = array();
			// TODO try to complete and get errors.
			$SQLlogEntry['err_no'] = "xxxxx";
			$SQLlogEntry['err_no_expr'] = "PHP PgSql Err : " . $SQLlogEntry['err_no'];
			$SQLlogEntry['err_msg'] = "xxxxxxxxxxxxxxxxxxxxxxx";
			$SQLlogEntry['signal'] = "ERR";
			$bts->LMObj->logSQLDetails(array($timeBegin, $bts->LMObj->getSqlQueryNumber(), $bts->MapperObj->getSqlApplicant(), $bts->SQLlogEntry['signal'], "Connexion", $bts->SQLlogEntry['err_no_expr'], $bts->SQLlogEntry['err_msg'], $bts->TimeObj->getMicrotime()));
			$this->getError();
			$msg = "CONNEXION ERROR : err_msg" . "*********************************";
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_ERROR, 'msg' => __METHOD__ . " : " . $msg));
			$this->report['cnxErr'] = 1;
		}
	}

	/**
	 * Disconnects from the database.
	 */
	public function disconnect_sql()
	{
		pg_close($this->DBInstance);
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
		$db_result = pg_execute($this->DBInstance, $q);
		$SQLlogEntry = array(
			"err_no"		=> $this->DBInstance->errno,
			"err_no_expr"	=> "PHP Pgsql Err : " . $this->DBInstance->errno,
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
				$this->logToSqlDetails($q, $SQLlogEntry, $timeBegin);
				break;
		}
		return $db_result;
	}


	public function executeContent($script)
	{

		$bts = BaseToolSet::getInstance();
		$timeBegin = $bts->TimeObj->getMicrotime();

		$db_result = pg_execute($this->DBInstance, $script);

		switch ($bts->CMObj->getConfigurationEntry('execution_context')) {
			case "installation":
				$SQLlogEntry = array(
					"err_no"		=> 0,
					"err_no_expr"	=> "PHP PgSql Err : " . 0,
					"err_msg"		=> "",
					"signal"		=> ($db_result == true) ? "OK" : "ERR",
				);

				$this->logToSqlDetails($script, $SQLlogEntry, $timeBegin);
				break;
			default:
				if ($this->DBInstance->errno != 0) {
					$bts->LMObj->msgLog(array('level' => LOGLEVEL_ERROR, 'msg' => __METHOD__ . " : " . $this->DBInstance->errno . " " . $this->DBInstance->error . " Query : `" . $bts->StringFormatObj->formatToLog($script) . "`."));
					return false;
				}
				break;
		}
	}


	/**
	 * Returns the number of row from the given resultset. 
	 * @param PgSql\Result $data
	 * @return Number
	 */
	public function num_row_sql($data)
	{
		$nbr = pg_num_rows($data);
		if ($nbr == 0) {
			$this->SDDMTools->SLMEmptyResult();
		}
		return $nbr;
	}

	/**
	 * Returns the Nth row from a result. 
	 * @param PgSql\Result $data
	 * @return Array
	 */
	public function fetch_array_sql($data)
	{
		return pg_fetch_assoc($data);
	}

	/**
	 * Returns a escaped string.
	 * @param String $data
	 * @return String
	 */
	public function escapeString($data)
	{
		return pg_escape_string($this->DBInstance, $data);
	}

	/**
	 * Returns the err string.
	 * @return string
	 */
	public function getError()
	{
		return pg_last_error($this->DBInstance);
	}

	/**
	 * Returns the errno string.
	 * @return string
	 */
	public function getErrno()
	{
		return pg_last_error($this->DBInstance);
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
