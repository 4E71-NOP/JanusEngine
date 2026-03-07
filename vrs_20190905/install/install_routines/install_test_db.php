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
//	Test DB cnx
// --------------------------------------------------------------------------------------------

class InstallTestDb
{
	private static $Instance = null;
	private $debug = true;
	private $displayDebug = 0;
	private $db_ = array();
	private $messageLog = array();
	private $jsonApiResponse = array(
		"cnxToDB" => false,
		"JnsEngDBAlreadyExists" => false,
		"JnsEngUserAlreadyExists" => false,
		"JnsEngBDDuserPermission" => false,
		"JnsEngDBInstallTableExists" => false,
		"installationLocked" => false,
	);
	private $actionsOn = array();
	private $queryCatalog = array();

	private $currentDbObj = null;

	public function __construct()
	{
		if ($this->debug) {
			// error_reporting(E_ERROR);
			error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
			ini_set('display_errors', 'On');
		} else {
			error_reporting(0);
		}
	}

	/**
	 * Singleton : Will return the instance of this class.
	 * @return InstallTestDb
	 */
	public static function getInstance()
	{
		if (self::$Instance == null) {
			self::$Instance = new InstallTestDb();
		}
		return self::$Instance;
	}

	public function render()
	{
		$this->db_['dal'] = $_REQUEST['form']['dal'];
		$this->db_['type'] = $_REQUEST['form']['selectedDataBaseType'];
		$this->db_['host'] = $_REQUEST['form']['host'];
		$this->db_['port'] = $_REQUEST['form']['port'];
		$this->db_['user_login'] = $_REQUEST['form']['dataBaseHostingPrefix'] . $_REQUEST['form']['dataBaseAdminUser'];
		$this->db_['user_password'] = $_REQUEST['form']['dataBaseAdminPassword'];
		$this->db_['tabprefix'] = $_REQUEST['form']['tabprefix'];
		$this->db_['dataBaseUserLogin'] = $_REQUEST['form']['dataBaseHostingPrefix'] . $_REQUEST['form']['dataBaseUserLogin'];
		$this->db_['dataBaseUserPassword'] = $_REQUEST['form']['dataBaseUserPassword'];
		$this->db_['dbprefix'] = $_REQUEST['form']['dataBaseHostingPrefix'] . $_REQUEST['form']['dbprefix'];
		$this->db_['firstMysqlDb'] = "mysql";

		// --------------------------------------------------------------------------------------------
		if (strlen(($this->db_['port'] ?? '')) == 0) {
			switch ($this->db_['type']) {
				case "mysql":
					$this->db_['port'] = 3306;
					break;
				case "sqlite":
					$this->db_['port'] = '';
					break;
				case "pgsql":
					$this->db_['port'] = 5234;
					break;
			}
		}

		// --------------------------------------------------------------------------------------------
		if ($this->debug) {
			$this->messageLog[] = "-----------------------------------------------------------";
			switch ($this->db_['dal']) {
				case "PHP":
					switch ($this->db_['type']) {
						case "mysql":
							$this->messageLog[] = "MYSQLI mysqli(" . $this->db_['host'] . "," . $this->db_['user_login'] . "," . str_repeat("*", strlen($this->db_['user_password'])) . "," . $_REQUEST['form']['dataBaseHostingPrefix'] . $this->db_['dbprefix'] . ") | type = " . $this->db_['type'];
							break;
						case "pgsql":
							$this->messageLog[] = "PGSQL pgsql(" . $this->db_['host'] . ":5432," . $this->db_['user_login'] . "," . str_repeat("*", strlen($this->db_['user_password'])) . "," . $_REQUEST['form']['dataBaseHostingPrefix'] . $this->db_['dbprefix'] . ") | type = " . $this->db_['type'];
							break;
					}
					break;
				case "PDO":
					$this->messageLog[] = "PHPPDO PDO = (" . $this->db_['type'] . ":host=" . $this->db_['host'] . "; port=" . $this->db_['port'] . "; dbname=" . $this->db_['dbprefix'] . ", " . $this->db_['user_login'] . ", " . str_repeat("*", strlen($this->db_['user_password'])) . ")";
					break;
			}
		}

		$this->createQueryCatalog();
		// $this->createActionTable();

		$this->testProcess();

		$this->messageLog[] = "Install_test_db - Ready to send results";

		foreach ($this->messageLog as $m) {
			error_log($m);
		}

		// --------------------------------------------------------------------------------------------
		switch ($this->displayDebug) {
			case 1:
				echo ("<br>\r");
				switch ($this->db_['dal']) {
					case "MYSQLI":
						echo ("MYSQLI mysqli(" . $this->db_['host'] . "," . $this->db_['user_login'] . "," . $this->db_['user_password'] . "," . $_REQUEST['form']['dataBaseHostingPrefix'] . $this->db_['dbprefix'] . ") | type = " . $this->db_['type']);
						break;
					case "PHPPDO":
						echo ("PHPPDO PDO = (" . $this->db_['type'] . ":host=" . $this->db_['host'] . ";dbname=" . $_REQUEST['form']['dataBaseHostingPrefix'] . $this->db_['dbprefix'] . $this->db_['user_login'] . $this->db_['user_password'] . ") | type = " . $this->db_['type']);
						break;
				}
				break;
			default:
				break;
		}

		// --------------------------------------------------------------------------------------------
		header('Content-Type: application/json');
		echo json_encode($this->jsonApiResponse);
		// echo ( $reponse );

	}


	/**
	 * 
	 */
	private function genericQuery($dbObj, $q)
	{
		$table = "f";
		return $table;
	}


	/**
	 * 
	 */
	private function genericCount($dbObj, $q)
	{
		// $this->messageLog[] = $q;
		// error_log($q);
		$n = 0;

		switch ($this->db_['dal']) {
			case "PHP":
				switch ($this->db_['type']) {
					case "mysql":
						$dbquery = $dbObj->query($q);
						while ($dbp = $dbquery->fetch_assoc()) {
							$n = $dbp['nbr'];
						}
						break;
					case "pgsql":
						$dbquery = pg_query($dbObj, $q);
						while ($dbp = pg_fetch_assoc($dbquery)) {
							$n = $dbp['nbr'];
						}
						break;
				}
				break;

			case "PDO":
				$dbquery = $dbObj->query($q);
				while ($dbp = $dbquery->fetch(PDO::FETCH_ASSOC)) {
					$n = $dbp['nbr'];
				}
				break;
		}

		return $n;
	}


	/**
	 * 
	 */
	private function createQueryCatalog()
	{
		switch ($this->db_['type']) {
			case "mysql":
				$this->queryCatalog = array(
					"cnxToService" => array(
						"testName" => "cnxToService",
						"query" => "",
						"successMsg" => "database service connection succeeded",
						"failMsg" => "database service connection failed"
					),
					"cnxToDb" => array(
						"testName" => "CnxToDb",
						"query" => "",
						"successMsg" => "database connection succeeded",
						"failMsg" => "database connection failed"
					),
					"findUser" => array(
						"testName" => "findUser",
						"query" => "SELECT COUNT(*) AS nbr FROM mysql.user WHERE User = '<dataBaseUserLogin>';",
						"successMsg" => "User '<dataBaseUserLogin>' found",
						"failMsg" => "User '<dataBaseUserLogin>' not found"
					),
					"findTable" => array(
						"testName" => "findTable",
						"query" => "SELECT COUNT(*) AS nbr FROM information_schema.tables WHERE table_schema = '" . $this->db_['dbprefix'] . "' AND table_name = '" . $this->db_['tabprefix'] . "installation' LIMIT 1",
						"successMsg" => "Janus engine installation table found",
						"failMsg" => "Janus engine installation table not found"
					),
					"findLock" => array(
						"testName" => "findLock",
						"query" => "SELECT * FROM " . $this->db_['dbprefix'] . "." . $this->db_['tabprefix'] . "installation WHERE inst_name = 'installationLocked' LIMIT 1;",
						"successMsg" => "No installation lock was found",
						"failMsg" => "An installation lock has been found",
					),
				);
				break;

			case "pgsql":
				$this->queryCatalog = array(
					"cnxToService" => array(
						"testName" => "cnxToService",
						"query" => "",
						"successMsg" => "database service connection succeeded",
						"failMsg" => "database service connection failed"
					),
					"cnxToDb" => array(
						"testName" => "CnxToDb",
						"query" => "SELECT COUNT(*) AS nbr FROM information_schema.schemata WHERE schema_name = '" . strtolower($this->db_['dbprefix']) . "';",
						"successMsg" => "database connection succeeded",
						"failMsg" => "database connection failed"
					),
					"findUser" => array(
						"testName" => "findUser",
						"query" => "SELECT COUNT(*) AS nbr FROM pg_catalog.pg_user WHERE usename = '<dataBaseUserLogin>';",
						"successMsg" => "User '<dataBaseUserLogin>' found",
						"failMsg" => "User '<dataBaseUserLogin>' not found"
					),
					"findTable" => array(
						"testName" => "findTable",
						"query" => "SELECT COUNT(*) AS nbr FROM information_schema.tables WHERE table_catalog LIKE '%JnsEng%' AND table_name LIKE '" . $this->db_['tabprefix'] . "_installation' LIMIT 1",
						"successMsg" => "Janus engine installation table found",
						"failMsg" => "Janus engine installation table not found"
					),
					"findLock" => array(
						"testName" => "findLock",
						"query" => "SELECT * FROM " . $this->db_['dbprefix'] . "." . $this->db_['tabprefix'] . "installation WHERE inst_name = 'installationLocked' LIMIT 1;",
						"successMsg" => "No installation lock was found",
						"failMsg" => "An installation lock has been found",
					),
				);
				break;
		}
	}

	/**
	 * 
	 */
	private function testProcess()
	{

		$currentTest = $this->queryCatalog['cnxToService'];
		$this->jsonApiResponse['cnxToService'] = $this->cnxToServiceTest($this->queryCatalog['cnxToService']);
		$respValue = ($this->jsonApiResponse['cnxToService']) ? "successMsg" : "failMsg";
		$this->messageLog[] = "Install_test_db - " . $currentTest['testName'] . " - " . $currentTest[$respValue];

		if ($this->jsonApiResponse['cnxToService']) {

			$currentTest = $this->queryCatalog['cnxToDb'];
			$this->jsonApiResponse['cnxToDB'] = $this->cnxToDbTest($currentTest);
			$respValue = ($this->jsonApiResponse['cnxToDB']) ? "successMsg" : "failMsg";
			$this->messageLog[] = "Install_test_db - " . $currentTest['testName'] . " - " . $currentTest[$respValue];

			if ($this->jsonApiResponse['cnxToDB']) {
				$this->findUserTest($this->currentDbObj);
				$this->findTableTest($this->currentDbObj);


				if ($this->jsonApiResponse['JnsEngDBInstallTableExists']) {
					$currentTest = $this->queryCatalog['findLock'];
					$this->findLockTest($currentTest);
					$respValue = ($this->jsonApiResponse['installationLocked']) ? "failMsg" : "successMsg";
					$this->messageLog[] = "Install_test_db - " . $currentTest['testName'] . " - " . $currentTest[$respValue];
				}
			}

			if ($this->debug) {
				$str = "jsonApiResponse : ";
				foreach ($this->jsonApiResponse as $k => $v) {
					$str .= "'" . $k . "'='" . $v . "',";
				}

				$this->messageLog[] = $str;
			}

		}

	}


	private function cnxToServiceTest($currentTest)
	{
		$retResp = false;
		switch ($this->db_['type']) {
			case "mysql":
				$dsn = $this->db_['type'] . ":host=" . $this->db_['host'] . "; port=" . $this->db_['port'];
				break;
			case "pgsql":
				$dsn = $this->db_['type'] . ":host=" . $this->db_['host'] . "; dbname=postgres";
				break;
		}
		$this->messageLog[] = "Install_test_db - " . $currentTest['testName'] . " - " . "Trying : '" . $dsn . " / " . $this->db_['user_login'] . ",******PWD******'";

		switch ($this->db_['dal']) {
			case "PHP":
				switch ($this->db_['type']) {
					case "mysql":
						try {
							$db = new mysqli($this->db_['host'], $this->db_['user_login'], $this->db_['user_password'], $this->db_['firstMysqlDb'], $this->db_['port']);
							// If it fails, it raises an Exception and go no further
							$retResp = true;
						} catch (Exception $e) { // nothing to do
						}
						break;
					case "pgsql":
						$dsn = "host=" . $this->db_['host'] . " dbname=postgres user=" . $this->db_['user_login'] . " password=" . $this->db_['user_password'];
						$db = pg_connect($dsn);
						$retResp = ($db !== false) ? true : false;
						break;
				}
				break;

			case "PDO":
				try {
					$db = new PDO($dsn, $this->db_['user_login'], $this->db_['user_password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
					// If it fails, it raises an Exception and go no further
					$retResp = true;
				} catch (PDOException $e) {
				}
				break;
		}
		$this->currentDbObj = $db;
		return $retResp;
	}

	/**
	 * 

	 * @param mixed $currentTest
	 * @return bool
	 */
	private function cnxToDbTest($currentTest)
	{
		$retResp = false;
		switch ($this->db_['type']) {
			case "mysql":
				$this->messageLog[] = ($this->debug == true) ? "cnxToDbTest Mysql selected" : "";
				$dsn = $this->db_['type'] . ":host=" . $this->db_['host'] . "; port=" . $this->db_['port'] . "; dbname=" . $this->db_['dbprefix'];
				break;
			case "pgsql":
				$this->messageLog[] = ($this->debug == true) ? "cnxToDbTest Postgres selected" : "";
				$dsn = $this->db_['type'] . ":host=" . $this->db_['host'] . "; dbname=postgres";
				break;
		}
		$this->messageLog[] = "Install_test_db - " . $currentTest['testName'] . " - " . "Trying : '" . $dsn . " / " . $this->db_['user_login'] . ",******PWD******'";

		switch ($this->db_['dal']) {
			case "PHP":
				$this->messageLog[] = ($this->debug == true) ? "PHP functions selected" : "";
				switch ($this->db_['type']) {
					case "mysql":
						try {
							$db = new mysqli($this->db_['host'], $this->db_['user_login'], $this->db_['user_password'], $this->db_['dbprefix'], $this->db_['port']);
							// If it fails, it raises an Exception and go no further
							$retResp = true;
						} catch (Exception $e) {
							$this->messageLog[] = ($this->debug == true) ? "Exception in cnxToDbTest PHP function / Mysql" : "";
						}
						break;
					case "pgsql":
						// specific php pgsql function dsn synstax
						$dsn = "host=" . $this->db_['host'] . " dbname=postgres" . " user=" . $this->db_['user_login'] . " password=" . $this->db_['user_password'];
						$db = pg_connect($dsn);
						if ($db !== false) {
							if ($this->genericCount($db, $currentTest['query']) > 0) {
								$retResp = true;
							}
						}
						break;
				}
				break;

			case "PDO":
				$this->messageLog[] = ($this->debug == true) ? "PDO selected with dsn :'" . $dsn . "'" : "";
				try {
					$db = new PDO($dsn, $this->db_['user_login'], $this->db_['user_password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
					$retResp = true;
					if ($this->db_['type'] == "pgsql") {
						$retResp = ($this->genericCount($db, $currentTest['query']) > 0) ? true : false;
					}
				} catch (PDOException $e) {
					$this->messageLog[] = ($this->debug == true) ? "Exception in cnxToDbTest PDO" : "";
				}
				break;
		}

		return $retResp;
	}

	private function findUserTest($dbObj)
	{
		$currentTest = $this->queryCatalog['findUser'];
		$q = str_replace("<dataBaseUserLogin>", $this->db_['dataBaseUserLogin'], $currentTest['query']);
		$this->jsonApiResponse['JnsEngUserAlreadyExists'] = ($this->genericCount($dbObj, $q) > 0);
		$respValue = ($this->jsonApiResponse['JnsEngUserAlreadyExists']) ? "successMsg" : "failMsg";
		$this->messageLog[] = "Install_test_db - " . $currentTest['testName'] . " - " . str_replace("<dataBaseUserLogin>", $this->db_['user_login'], $currentTest[$respValue]);

	}

	private function findTableTest($dbObj)
	{
		$currentTest = $this->queryCatalog['findTable'];
		$this->jsonApiResponse['JnsEngDBInstallTableExists'] = ($this->genericCount($dbObj, $currentTest['query']) > 0);
		$respValue = ($this->jsonApiResponse['JnsEngDBInstallTableExists']) ? "successMsg" : "failMsg";
		$this->messageLog[] = "Install_test_db - " . $currentTest['testName'] . " - " . $currentTest[$respValue];
	}


	private function findLockTest($currentTest)
	{
		switch ($this->db_['dal']) {

			case "PHP":
				switch ($this->db_['type']) {
					case "mysql":
						$dbquery = $this->currentDbObj->query($currentTest['query']);
						while ($dbp = $dbquery->fetch_assoc()) {
							$this->jsonApiResponse['installationLocked'] = ($dbp['inst_nbr'] == 1) ? true : false;
						}
						break;

					case "pgsql":
						$dbquery = pg_query($this->currentDbObj, $currentTest['query']);
						while ($dbp = pg_fetch_assoc($dbquery)) {
							$this->jsonApiResponse['installationLocked'] = ($dbp['inst_nbr'] == 1) ? true : false;
						}
						break;
				}
				break;

			case "PDO":
				$dbquery = $this->currentDbObj->query($currentTest['query']);
				while ($dbp = $dbquery->fetch(PDO::FETCH_ASSOC)) {
					$this->jsonApiResponse['installationLocked'] = ($dbp['inst_nbr'] == 1) ? true : false;
				}
				break;
		}

	}

}

$installTestDbObj = InstallTestDb::getInstance();
$installTestDbObj->render();

// --------------------------------------------------------------------------------------------
?>