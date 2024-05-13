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

class SddmPDO extends SddmCore
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
	 * @return SddmPDO
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new SddmPDO();
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
		$SQL_temps_depart = $bts->TimeObj->getMicrotime();

		$dsn = $TabConfig['type'] . ":host=" . $TabConfig['host'] .
			";dbname=" . $TabConfig['dbprefix'];

		switch ($TabConfig['type']) {
			case "mysql":
				$dsn .= ";charset=" . $TabConfig['charset'];
				break;
			case "pgsql":
				break;
		}
		$options = [
			PDO::ATTR_ERRMODE				=> PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE	=> PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES		=> false,
		];


		$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " PDO Trying : '" . $dsn . "'"));
		try {
			switch ($bts->CMObj->getConfigurationEntry('execution_context')) {
				case "installation":
					$this->DBInstance = new PDO($dsn, $TabConfig['db_user_login'], $TabConfig['db_user_password'], $options);
					break;
				case "render":
				default:
					$this->DBInstance = new PDO($dsn, $TabConfig['db_user_login'], $TabConfig['db_user_password'], $options);
					break;
			}

			switch ($TabConfig['type']) {
				case "mysql":
					break;
				case "pgsql":
					$this->DBInstance->query("SET SCHEMA '" . $TabConfig['dbprefix'] . "';");
					break;
			}
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " : Connected to '" . $TabConfig['dbprefix'] . "'."));
	
		} catch (Exception $e) {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_BREAKPOINT, 'msg' => __METHOD__ . " PDO connection failed"));
			$this->report['cnxErr'] = 1;
		}

	}

	public function disconnect_sql()
	{
		$this->DBInstance = null;		// this is the way PDO works. https://www.php.net/manual/en/pdo.connections.php
	}

	/**
	 * 
	 * @param String $q
	 * @return PDOStatement
	 */
	public function query($q)
	{
		$bts = BaseToolSet::getInstance();
		$timeBegin = $bts->TimeObj->getMicrotime();

		$SQL_temps_depart = $bts->TimeObj->getMicrotime();
		$bts->LMObj->increaseSqlQueryNumber();

		$db_result = $this->DBInstance->query($q);

		$SQLlogEntry = array();
		$SQLlogEntry['err_no'] = $this->DBInstance->errorCode();
		$SQLlogEntry['err_no_expr'] = "PHP PDO Err : " . $SQLlogEntry['err_no'];
		$SQLlogEntry['err_msg'] = $this->DBInstance->errorInfo();
		$SQLlogEntry['signal'] = "OK";

		if ($this->DBInstance->errorCode() != 0) {
			$bts->LMObj->msgLog(array('level' => LOGLEVEL_ERROR, 'msg' => __METHOD__ . " : " . $this->DBInstance->errorCode() . " " . $this->DBInstance->errorInfo() . " Query : `" . $bts->StringFormatObj->formatToLog($q) . "`."));
			$SQLlogEntry['signal'] = "ERR";
		}

		if ($bts->CMObj->getConfigurationEntry('InsertStatistics') == 1) {
			$bts->LMObj->IncreaseSqlQueries();
		}
		$bts->LMObj->logSQLDetails(array($SQL_temps_depart, $bts->LMObj->getSqlQueryNumber(), $bts->MapperObj->getSqlApplicant(), $SQLlogEntry['signal'], $q, $SQLlogEntry['err_no_expr'], $SQLlogEntry['err_msg'], $bts->TimeObj->getMicrotime()));

		switch ($bts->CMObj->getConfigurationEntry('execution_context')) {
			case "installation":
				$StringFormatObj = StringFormat::getInstance();
				$bts->LMObj->increaseSqlQueryNumber();
				$q = $StringFormatObj->shorteningExpression($q, 256);
				$bts->LMObj->logSQLDetails(
					array(
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

	public function num_row_sql($res)
	{
		$nbr = $res->rowCount();			//Only work because we have "PDO::FETCH_ASSOC". Don't change it.
		if ($nbr == 0) {
			$this->SDDMTools->SLMEmptyResult();
		}
		return $nbr;
	}

	public function fetch_array_sql($res)
	{
		return $res->fetch(PDO::FETCH_ASSOC);
	}

	public function escapeString($res)
	{
		// PDO is wonderful...
		// $s = array("\"", "'");
		// $r = array("\\\"", "\\'");
		// $res = str_replace($s, $r, $res);

		$res = $this->DBInstance->quote($res);
		// No need for the first and last quote.
		return substr($res, 1, -1);
		// return $res;
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
