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
	private $debug = 1;
	private $displayDebug = 0;
	private $db_ = array();
	private $messageLog = array();
	private $jsonApiResponse = array(
		"cnxToDB"					=>	false,
		"JnsEngDBAlreadyExists"		=>	false,
		"JnsEngUserAlreadyExists"		=>	false,
		"JnsEngBDDuserPermission"		=>	false,
		"JnsEngDBInstallTableExists"	=>	false,
		"installationLocked"		=>	false,
	);
	private $actionsOn = array();
	private $queryCatalog = array();


	public function __construct()
	{

		switch ($this->debug) {
			case 1:
				error_reporting(E_ERROR);
				ini_set('display_errors', 'On');
				break;
			default:
				error_reporting(0);
				break;
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
		$this->db_['dal']					= $_REQUEST['form']['dal'];
		$this->db_['type']					= $_REQUEST['form']['selectedDataBaseType'];
		$this->db_['host']					= $_REQUEST['form']['host'];
		$this->db_['port']					= $_REQUEST['form']['port'];
		$this->db_['user_login']			= $_REQUEST['form']['dataBaseHostingPrefix'] . $_REQUEST['form']['dataBaseAdminUser'];
		$this->db_['user_password']			= $_REQUEST['form']['dataBaseAdminPassword'];
		$this->db_['tabprefix']				= $_REQUEST['form']['tabprefix'];
		$this->db_['dataBaseUserLogin']		= $_REQUEST['form']['dataBaseHostingPrefix'] . $_REQUEST['form']['dataBaseUserLogin'];
		$this->db_['dataBaseUserPassword']	= $_REQUEST['form']['dataBaseUserPassword'];
		$this->db_['dbprefix']				= $_REQUEST['form']['dataBaseHostingPrefix'] . $_REQUEST['form']['dbprefix'];
		$this->db_['firstMysqlDb']			= "mysql";

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
		switch ($this->debug) {
			case 1:
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
						// case "ADODB":
						// 	$this->messageLog[] = "ADODB " . $this->db_['type'] . " -> Connect( " . $this->db_['host'] . " , " . $this->db_['user_login'] . " , " . str_repeat("*", strlen($this->db_['user_password'])) . " , " . $this->_REQUEST['form']['dataBaseHostingPrefix'] . $this->db_['dbprefix'] . ") | type = " . $this->db_['type'];
						// 	break;
						// case "PEARDB":
						// 	$this->messageLog[] = "MDB2::connect(" . $this->db_['type'] . "://" . $this->db_['user_login'] . ":" . str_repeat("*", strlen($this->db_['user_password'])) . "@" . $this->db_['host'] . $this->_REQUEST['form']['dataBaseHostingPrefix'] . $this->db_['dbprefix'] . ") | type = " . $this->db_['type'];
						// 	break;
				}
		}

		$this->createQueryCatalog();
		$this->createActionTable();

		switch ($this->db_['dal']) {
				//	PHP internal functions ------------------------------------------------------------------------------------
			case "PHP":
				switch ($this->db_['type']) {
					case "mysql":
						$this->phpMysqlTestdb();
						break;
					case "pgsql":
						$this->phpPostgresTestdb();
						break;
				}
				break;

			case "PDO":
				//	PHP/PDO ------------------------------------------------------------------------------------
				//	PDO does not require a specific set of functions
				// 	Ex : $myPDO = new PDO('pgsql:host=localhost;dbname=dbname', 'username', 'password');
				$this->pdoTestdb();
				break;

				// case "ADODB":
				// $this->adodbTestdb();
				// break;

		}


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
						// case "ADODB":	echo ("ADODB " . $db_['type'] . " -> Connect( ".$db_['host']." , ".$db_['user_login']." , ".$db_['user_password']." , ".$_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] .") | type = ". $db_['type']);				break;
						// case "PEARDB":	echo ("MDB2::connect(".$db_['type']."://".$db_['user_login'].":".$db_['user_password']."@".$db_['host'] . $_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] .") | type = ". $db_['type']);								break;
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
		$this->queryCatalog = array(
			"mysql_find_table" => "SELECT * FROM information_schema.tables WHERE table_schema = '" . $this->db_['dbprefix'] . "' AND table_name = '" . $this->db_['tabprefix'] . "installation' LIMIT 1",
			"mysql_find_lock" => "SELECT * FROM " . $this->db_['dbprefix'] . "." . $this->db_['tabprefix'] . "installation WHERE inst_name = 'installationLocked' LIMIT 1;",

			"pgsql_find_table" => "SELECT * FROM information_schema.tables WHERE table_catalog like '%JnsEng%' AND table_name like 'Ht_inst%' LIMIT 1",
			"pgsql_find_lock" => "SELECT * FROM " . $this->db_['dbprefix'] . "." . $this->db_['tabprefix'] . "installation WHERE inst_name = 'installationLocked' LIMIT 1;",

			"mysql_find_user" => "SELECT COUNT(*) AS nbr FROM mysql.user WHERE User = '<dataBaseUserLogin>';",
			"pgsql_find_user" => "SELECT COUNT(*) AS nbr FROM pg_catalog.pg_user WHERE usename = '<dataBaseUserLogin>';",
		);
	}

	/**
	 * 
	 */
	private function createActionTable()
	{
		$this->actionsOn = array(
			"test_1_cnx_failed" => function ($obj, $err) {
				$obj->jsonApiResponse['cnxToDB']	= false;
				$obj->messageLog[] = "Install_test_db - Exception on test #1 (cnxToDB) to " . $obj->db_['host'] . ":" . $obj->db_['port'] . ". Error : " . $err;
			},
			"test_1_cnx_Ok" => function ($obj) {
				$obj->jsonApiResponse['cnxToDB']	= true;
				$obj->messageLog[] = "Install_test_db - test #1 (cnxToDB) succeeded " . $obj->db_['host'] . ":" . $obj->db_['port'] . ". ";
			},

			"test_2_db_not_found" => function ($obj, $err) {
				$obj->jsonApiResponse['JnsEngDBAlreadyExists']	= false;
				$obj->messageLog[] = "Install_test_db - Exception on test #2 (JnsEngDBAlreadyExists) '" . $obj->db_['host'] . ":" . $obj->db_['port'] . "' doesn't exist. Error : " . $err;
			},
			"test_2_db_found" => function ($obj) {
				$obj->jsonApiResponse['JnsEngDBAlreadyExists']	= true;
				$obj->messageLog[] = "Install_test_db - test #2 (JnsEngDBAlreadyExists) '" . $obj->db_['dbprefix'] . "' already exists.";
			},

			"test_3_table_not_found" => function ($obj) {
				$obj->jsonApiResponse['JnsEngDBInstallTableExists']	= false;
				$obj->messageLog[] = "Install_test_db - test #3 Table not found (JnsEngDBInstallTableExists) '" . $obj->db_['host'] . ":" . $obj->db_['port'] . "'";
			},
			"test_3_table_found" => function ($obj) {
				$obj->jsonApiResponse['JnsEngDBInstallTableExists']	= true;
				$obj->messageLog[] = "Install_test_db - test #3 Table found (JnsEngDBInstallTableExists) '" . $obj->db_['host'] . ":" . $obj->db_['port'] . "'.";
			},

			"test_4_lock_not_found" => function ($obj) {
				$obj->jsonApiResponse['installationLocked']	= false;
				$obj->messageLog[] = "Install_test_db - test #4 Lock not found (JnsEngDBInstallTableExists) '" . $obj->db_['host'] . ":" . $obj->db_['port'] . "'";
			},
			"test_4_lock_found" => function ($obj) {
				$obj->jsonApiResponse['installationLocked']	= true;
				$obj->messageLog[] = "Install_test_db - test #4 Lock found (installationLocked) '" . $obj->db_['host'] . ":" . $obj->db_['port'] . "'.";
			},

			"test_5_results" => function ($obj) {
				$b = $obj->jsonApiResponse['JnsEngUserAlreadyExists'];
				$obj->messageLog[] = "Install_test_db - test #5 User '" . $obj->db_['dataBaseUserLogin'] . "'" .
					(($b) ? " not" : "")
					. " found (JnsEngUserAlreadyExists).";
			},
		);
	}


	/**
	 * 
	 */
	private function phpMysqlTestdb()
	{
		try {
			$db1 = new mysqli($this->db_['host'], $this->db_['user_login'], $this->db_['user_password'], $this->db_['firstMysqlDb'], $this->db_['port']);
			// If it fails it raises an Exception.
			$this->actionsOn['test_1_cnx_Ok']($this);

			try {
				$db2 = new mysqli($this->db_['host'], $this->db_['user_login'], $this->db_['user_password'], $this->db_['dbprefix'], $this->db_['port']);
				// If it fails it raises an Exception.
				$jsonApiResponse['JnsEngDBAlreadyExists'] = true;
				$this->actionsOn['test_2_db_found']($this);

				$q = str_replace("<dataBaseUserLogin>", $this->db_['dataBaseUserLogin'], $this->queryCatalog['mysql_find_user']);
				$this->jsonApiResponse['JnsEngUserAlreadyExists'] = ($this->genericCount($db2, $q) > 0);

				$dbquery = $db2->query($this->queryCatalog['mysql_find_table']);
				if ($dbquery->num_rows > 0) {
					$this->actionsOn['test_3_table_found']($this);

					$dbquery = $db2->query($this->queryCatalog['mysql_find_lock']);
					while ($dbp = $dbquery->fetch_assoc()) {
						if ($dbp['inst_nbr'] == 1) {
							$this->actionsOn['test_4_lock_found']($this);
						} else {
							$this->actionsOn['test_4_lock_not_found']($this);
						}
					}
				} else {
					$this->actionsOn['test_3_table_not_found']($this);
				}

			} catch (Exception $e) {
				$this->actionsOn['test_2_db_not_found']($this, $e->getMessage());
			}
		} catch (Exception $e) {
			$this->actionsOn['test_1_cnx_failed']($this, $e->getMessage());
		}
	}

	/**
	 * 
	 */
	private function phpPostgresTestdb()
	{
		// port is not tolerated ..; maybe docker ??
		// $strCnx = "host=".$this->db_['host']." port=".$this->db_['port']." dbname=postgres" /*.$this->db_['dbprefix']*/." user=".$this->db_['user_login']." password=".$this->db_['user_password'];
		$strCnx1 = "host=" . $this->db_['host'] . " dbname=postgres user=" . $this->db_['user_login'] . " password=" . $this->db_['user_password'];
		$db1 = pg_connect($strCnx1);

		if ($db1 !== false) {
			$this->actionsOn['test_1_cnx_Ok']($this);

			// $strCnx = "host=".$this->db_['host']." port=".$this->db_['port']." user=".$this->db_['user_login']." password=".$this->db_['user_password']. " dbname=".$this->db_['dbprefix'];
			$strCnx2 = "host=" . $this->db_['host'] . " user=" . $this->db_['user_login'] . " password=" . $this->db_['user_password'] . " dbname=" . $this->db_['dbprefix'];
			$db2 = pg_connect($strCnx2);
			if ($db2 !== false) {
				$this->actionsOn['test_2_db_found']($this);

				$q = str_replace("<dataBaseUserLogin>", $this->db_['dataBaseUserLogin'], $this->queryCatalog['pgsql_find_user']);
				$this->jsonApiResponse['JnsEngUserAlreadyExists'] = ($this->genericCount($db2, $q) > 0);
	
					$dbquery = pg_query($db2, $this->queryCatalog['pgsql_find_table']);
				if (!$dbquery) {
					$this->actionsOn['test_3_table_not_found']($this);
				} else {
					$this->actionsOn['test_3_table_found']($this);

					$dbquery = pg_query($db2, $this->queryCatalog['pgsql_find_lock']);
					while ($dbp = pg_fetch_assoc($dbquery)) {
						if ($dbp['inst_nbr'] == 1) {
							$this->actionsOn['test_4_lock_found']($this);
						} else {
							$this->actionsOn['test_4_lock_not_found']($this);
						}
					}
				}
			} else {
				$this->actionsOn['test_2_db_not_found']($this, "pg_connect returned false.");
			}

			if ($dbquery) {
				while ($dbp = pg_fetch_assoc($dbquery)) {
					$this->jsonApiResponse['JnsEngUserAlreadyExists'] = ($dbp['nbr'] > 0);
				}
			} else {
				$this->messageLog[] = "Null returned upon query : '" . $q . "'.";
			}
		} else {
			$this->actionsOn['test_1_cnx_failed']($this, $this->db_['host'] . ":" . $this->db_['port'], "pg_connect returned false.");
		}
	}


	/**
	 * 
	 */
	private function pdoTestdb()
	{
		switch ($this->db_['type']) {
			case "mysql":
				$strCnx1 = $this->db_['type'] . ":host=" . $this->db_['host'] . "; port=" . $this->db_['port'];
				$strCnx2 = $this->db_['type'] . ":host=" . $this->db_['host'] . "; port=" . $this->db_['port'] . "; dbname=" . $this->db_['dbprefix'];
				break;
			case "pgsql":
				$strCnx1 = $this->db_['type'] . ":host=" . $this->db_['host'] . "; dbname=postgres";
				$strCnx2 = $this->db_['type'] . ":host=" . $this->db_['host'] . "; dbname=" . $this->db_['dbprefix'];
				break;
		}

		try {
			$this->messageLog[] = "Install_test_db - Connexion #1 Trying : '" . $strCnx1 . " / " . $this->db_['user_login'] . ",******PWD******'";
			$db = new PDO($strCnx1, $this->db_['user_login'], $this->db_['user_password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
			// If it fails it raises an Exception.
			$this->actionsOn['test_1_cnx_Ok']($this);

			try {
				$db = null; // cleaning
				$this->messageLog[] = "Install_test_db - Connexion #2 Trying : '" . $strCnx2 . " / " . $this->db_['user_login'] . ",******PWD******'";
				$db2 = new PDO($strCnx2, $this->db_['user_login'], $this->db_['user_password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
				// If it fails it raises an Exception.
				$this->actionsOn['test_2_db_found']($this);


				switch ($this->db_['type']) {
					case "mysql":
						$q = str_replace("<dataBaseUserLogin>", $this->db_['dataBaseUserLogin'], $this->queryCatalog['mysql_find_user']);
						$this->jsonApiResponse['JnsEngUserAlreadyExists'] = ($this->genericCount($db2, $q) > 0);
						break;
					case "pgsql":
						$q = str_replace("<dataBaseUserLogin>", $this->db_['dataBaseUserLogin'], $this->queryCatalog['pgsql_find_user']);
						$this->jsonApiResponse['JnsEngUserAlreadyExists'] = ($this->genericCount($db2, $q) > 0);
						break;
				}
				$this->actionsOn['test_5_results']($this);



				$dbquery =  $db2->query($this->queryCatalog['pgsql_find_lock']);
				while ($dbp = $dbquery->fetch(PDO::FETCH_ASSOC)) {
					if ($dbp['inst_nbr'] == 1) {
						$this->actionsOn['test_4_lock_found']($this);
					} else {
						$this->actionsOn['test_4_lock_not_found']($this);
					}
				}
			} catch (PDOException $e) {
				$this->actionsOn['test_2_db_not_found']($this, $e->getMessage());
			}
		} catch (PDOException $e) {
			error_log("test bp");
			$this->actionsOn['test_1_cnx_failed']($this, $e->getMessage());
		}
	}

	/**
	 * 
	 */
	// private function adodbTestdb(){
	// 	include_once ("/usr/share/php/adodb/adodb.inc.php");
	// 	$db = NewADOConnection($this->db_['type']);
	// 	$db->Connect( $this->db_['host'] , $this->db_['user_login'] , $this->db_['user_password'] , $this->db_['firstMysqlDb'] );
	// 	if ( $db->IsConnected() == FALSE ) {  }

	// 	$db2 = NewADOConnection($this->db_['type']);
	// 	$db2->Connect( $this->db_['host'] , $this->db_['user_login'] , $this->db_['user_password'] , $this->db_['dbprefix'] );
	// 	if ( $db2->IsConnected() == FALSE ) {  }
	// break;

	// case "PEARDB":
	// 	include_once ("MDB2.php");
	// 	if ( isset($this->db_['dbprefix']) ) { $_REQUEST['form']['dataBaseHostingPrefix'] = "/"; }
	// 	$db = MDB2::connect($this->db_['type']."://".$this->db_['user_login'].":".$this->db_['user_password']."@".$this->db_['host'] . $_REQUEST['form']['dataBaseHostingPrefix'] . $this->db_['firstMysqlDb'] ); 
	// 	if ( PEAR::isError($db) ) {  }

	// 	$db2 = MDB2::connect($this->db_['type']."://".$this->db_['user_login'].":".$this->db_['user_password']."@".$this->db_['host'] . $_REQUEST['form']['dataBaseHostingPrefix'] . $this->db_['dbprefix'] ); 
	// 	if ( PEAR::isError($db2) ) {  }
	// }





}

$installTestDbObj = InstallTestDb::getInstance();
$installTestDbObj->render();




// --------------------------------------------------------------------------------------------
