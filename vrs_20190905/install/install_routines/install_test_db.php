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
//	Test DB cnx
// --------------------------------------------------------------------------------------------
$debug = 1;
$displayDebug = 0;

switch ($debug) {
	case 1:
		error_reporting(E_ERROR);
		ini_set('display_errors', 'On');
		break;
	default:
		error_reporting(0);
		break;
}

$messageLog = array();

$db_ = array();
$db_['dal']						= $_REQUEST['form']['dal'];
$db_['type']					= $_REQUEST['form']['selectedDataBaseType'];
$db_['host']					= $_REQUEST['form']['host'];
$db_['port']					= $_REQUEST['form']['port'];
$db_['user_login']				= $_REQUEST['form']['dataBaseHostingPrefix'] . $_REQUEST['form']['dataBaseAdminUser'];
$db_['user_password']			= $_REQUEST['form']['dataBaseAdminPassword'];
$db_['tabprefix']				= $_REQUEST['form']['tabprefix'];
$db_['dataBaseUserLogin']		= $_REQUEST['form']['dataBaseHostingPrefix'] . $_REQUEST['form']['dataBaseUserLogin'];
$db_['dataBaseUserPassword']	= $_REQUEST['form']['dataBaseUserPassword'];
$db_['dbprefix']				= $_REQUEST['form']['dataBaseHostingPrefix'] . $_REQUEST['form']['dbprefix'];
$db_['firstMysqlDb']			= "mysql";



// --------------------------------------------------------------------------------------------
if (strlen(($db_['port'] ?? '')) == 0) {
	switch ($db_['type']) {
		case "mysql":
			$db_['port'] = 3306;
			break;
		case "sqlite":
			$db_['port'] = '';
			break;
		case "pgsql":
			$db_['port'] = 5234;
			break;
	}
}

switch ($debug) {
	case 1:
		$messageLog[] = "-----------------------------------------------------------";
		switch ($db_['dal']) {
			case "PHP":
				switch ($db_['type']) {
					case "mysql":
						$messageLog[] = "MYSQLI mysqli(" . $db_['host'] . "," . $db_['user_login'] . "," . str_repeat("*", strlen($db_['user_password'])) . "," . $_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] . ")" . $e . " | type = " . $db_['type'];
						break;
					case "pgsql":
						$messageLog[] = "PGSQL pgsql(" . $db_['host'] . ":5432," . $db_['user_login'] . "," . str_repeat("*", strlen($db_['user_password'])) . "," . $_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] . ")" . $e . " | type = " . $db_['type'];
						break;
				}
				break;
			case "PDO":
				$messageLog[] = "PHPPDO PDO = (" . $db_['type'] . ":host=" . $db_['host'] . "; port=" . $db_['port'] . "; dbname=" . $db_['dbprefix'] . ", " . $db_['user_login'] . ", " . str_repeat("*", strlen($db_['user_password'])) . ")";
				break;
			// case "ADODB":
			// 	$messageLog[] = "ADODB " . $db_['type'] . " -> Connect( " . $db_['host'] . " , " . $db_['user_login'] . " , " . str_repeat("*", strlen($db_['user_password'])) . " , " . $_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] . ") | type = " . $db_['type'];
			// 	break;
			// case "PEARDB":
			// 	$messageLog[] = "MDB2::connect(" . $db_['type'] . "://" . $db_['user_login'] . ":" . str_repeat("*", strlen($db_['user_password'])) . "@" . $db_['host'] . $_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] . ") | type = " . $db_['type'];
			// 	break;
		}
}

$jsonApiResponse = array(
	"cnxToDB"					=>	true,
	"HydrDBAlreadyExist"		=>	false,
	"HydrBDDuserPermission"		=>	false,
	"HydrDBInstallTableExists"	=>	false,
	"installationLocked"		=>	false,
);


$actionsOn = array(
	"test_1_cnx_failed" => function ($hostPort, $err) {
		global $jsonApiResponse, $messageLog;
		$jsonApiResponse['cnxToDB']	= false;
		$messageLog[] = "Install_test_db - Exception on test #1 (cnxToDB) to " . $hostPort . ". Error : " . $err;
	},
	"test_1_cnx_Ok" => function ($hostPort) {
		global $messageLog;
		$messageLog[] = "Install_test_db - test #1 (cnxToDB) succeeded " . $hostPort . ". ";
	},

	"test_2_db_not_found" => function ($target, $err) {
		global $messageLog;
		$messageLog[] = "Install_test_db - Exception on test #2 (HydrDBAlreadyExist) '" . $target . "' doesn't exist. Error : " . $err;
	},
	"test_2_db_found" => function ($target) {
		global $jsonApiResponse, $messageLog;
		$jsonApiResponse['HydrDBAlreadyExist']	= true;
		$messageLog[] = "Install_test_db - test #2 (HydrDBAlreadyExist) '" . $target . "' already exists.";
	},

	"test_3_table_not_found" => function ($target) {
		global $messageLog;
		$messageLog[] = "Install_test_db - Table not found (HydrDBInstallTableExists) '" . $target . "'";
	},
	"test_3_table_found" => function ($target) {
		global $jsonApiResponse, $messageLog;
		$jsonApiResponse['HydrDBInstallTableExists']	= true;
		$messageLog[] = "Install_test_db - Table found (HydrDBInstallTableExists) '" . $target . "'.";
	},

	"test_4_lock_not_found" => function ($target) {
		global $messageLog;
		$messageLog[] = "Install_test_db - Lock not found (HydrDBInstallTableExists) '" . $target . "'";
	},
	"test_4_lock_found" => function ($target) {
		global $jsonApiResponse, $messageLog;
		$jsonApiResponse['installationLocked']	= true;
		$messageLog[] = "Install_test_db - Lock found (installationLocked) '" . $target . "'.";
	},
);


$queryCatalog = array(
	"mysql_find_table" => "SELECT * FROM information_schema.tables WHERE table_schema = '" . $db_['dbprefix'] . "' AND table_name = '" . $db_['tabprefix'] . "installation' LIMIT 1",
	"mysql_find_lock" => "SELECT * FROM " . $db_['dbprefix'] . "." . $db_['tabprefix'] . "installation WHERE inst_name = 'installationLocked' LIMIT 1;",

	"pgsql_find_table" => "SELECT * FROM information_schema.tables WHERE table_catalog like '%Hdr%' AND table_name like 'Ht_inst%' LIMIT 1",
	"pgsql_find_lock" => "SELECT * FROM " . $db_['dbprefix'] . "." . $db_['tabprefix'] . "installation WHERE inst_name = 'installationLocked' LIMIT 1;",
);

switch ($db_['dal']) {
		//	PHP internal functions ------------------------------------------------------------------------------------
	case "PHP":
		switch ($db_['type']) {
			case "mysql":
				try {
					$db1 = new mysqli($db_['host'], $db_['user_login'], $db_['user_password'], $db_['firstMysqlDb'], $db_['port']);
					// If it fails it raises an Exception.
					$actionsOn['test_1_cnx_Ok']($db_['host'] . ":" . $db_['port']);

					try {
						$db2 = new mysqli($db_['host'], $db_['user_login'], $db_['user_password'], $db_['dbprefix'], $db_['port']);
						// If it fails it raises an Exception.
						$jsonApiResponse['HydrDBAlreadyExist'] = true;
						$actionsOn['test_2_db_found']($db_['host'] . ":" . $db_['port']);

						$dbquery = $db2->query($queryCatalog['mysql_find_table']);
						if ($dbquery->num_rows > 0) {
							$actionsOn['test_3_table_found']($db_['host'] . ":" . $db_['port']);

							$dbquery = $db2->query($queryCatalog['mysql_find_lock']);
							while ($dbp = $dbquery->fetch_assoc()) {
								if ($dbp['inst_nbr'] == 1) {
									$actionsOn['test_4_lock_found']($db_['host'] . ":" . $db_['port']);
								} else {
									$actionsOn['test_4_lock_not_found']($db_['host'] . ":" . $db_['port']);
								}
							}
						} else {
							$actionsOn['test_3_table_not_found']($db_['host'] . ":" . $db_['port']);
						}
					} catch (Exception $e) {
						$actionsOn['test_2_db_not_found']($db_['dbprefix'], $e->getMessage());
					}
				} catch (Exception $e) {
					$actionsOn['test_1_cnx_failed']($db_['host'] . ":" . $db_['port'], $e->getMessage());
				}
				break;

			case "pgsql":
				// port is not tolerated ..; maybe docker ??
				// $strCnx = "host=".$db_['host']." port=".$db_['port']." dbname=postgres" /*.$db_['dbprefix']*/." user=".$db_['user_login']." password=".$db_['user_password'];
				$strCnx1 = "host=" . $db_['host'] . " dbname=postgres user=" . $db_['user_login'] . " password=" . $db_['user_password'];
				$db1 = pg_connect($strCnx1);

				if ($db1 !== false) {
					$actionsOn['test_1_cnx_Ok']($db_['host'] . ":" . $db_['port']);

					// $strCnx = "host=".$db_['host']." port=".$db_['port']." user=".$db_['user_login']." password=".$db_['user_password']. " dbname=".$db_['dbprefix'];
					$strCnx2 = "host=" . $db_['host'] . " user=" . $db_['user_login'] . " password=" . $db_['user_password'] . " dbname=" . $db_['dbprefix'];
					$db2 = pg_connect($strCnx2);
					if ($db2 !== false) {
						$actionsOn['test_2_db_found']($db_['host'] . ":" . $db_['port']);

						$dbquery = pg_query($db2, $queryCatalog['pgsql_find_table']);
						if (!$dbquery) {
							$actionsOn['test_3_table_not_found']($db_['host'] . ":" . $db_['port']);
						} else {
							$actionsOn['test_3_table_found']($db_['host'] . ":" . $db_['port']);

							$dbquery = pg_query($db2, $queryCatalog['pgsql_find_lock']);
							while ($dbp = pg_fetch_assoc($dbquery)) {
								if ($dbp['inst_nbr'] == 1) {
									$actionsOn['test_4_lock_found']($db_['host'] . ":" . $db_['port']);
								} else {
									$actionsOn['test_4_lock_not_found']($db_['host'] . ":" . $db_['port']);
								}
							}
						}
					} else {
						$actionsOn['test_2_db_not_found']($db_['host'] . ":" . $db_['port'], "pg_connect returned false.");
					}
				} else {
					$actionsOn['test_1_cnx_failed']($db_['host'] . ":" . $db_['port'], "pg_connect returned false.");
				}
				break;
		}
		break;

		//	PHP/PDO ------------------------------------------------------------------------------------
		//	PDO does not require a specific set of functions
		// 	Ex : $myPDO = new PDO('pgsql:host=localhost;dbname=dbname', 'username', 'password');
	case "PDO":
		switch ($db_['type']) {
			case "mysql":
				$strCnx1 = $db_['type'] . ":host=" . $db_['host'] . "; port=" . $db_['port'];
				$strCnx2 = $db_['type'] . ":host=" . $db_['host'] . "; port=" . $db_['port'] . "; dbname=" . $db_['dbprefix'];
				break;
			case "pgsql":
				$strCnx1 = $db_['type'] . ":host=" . $db_['host'] . "; dbname=postgres";
				$strCnx2 = $db_['type'] . ":host=" . $db_['host'] . "; dbname=" . $db_['dbprefix'];
				break;
		}

		$messageLog[] = "Trying : '" . $strCnx1 . "," . $db_['user_login'] . ",******PWD******'";
		try {
			$db = new PDO($strCnx1, $db_['user_login'], $db_['user_password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
			$messageLog[] = "Install_test_db - Connexion state = " . (($jsonApiResponse['cnxToDB']) ? "True" : "False");
			try {
				$db2 = new PDO($strCnx2, $db_['user_login'], $db_['user_password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
				$jsonApiResponse['HydrDBAlreadyExist']	= true;
				$messageLog[] = "Install_test_db - Connexion #2 HydrDBAlreadyExist = " . (($jsonApiResponse['HydrDBAlreadyExist']) ? "True" : "False") . " | " . $strCnx2 . ", state = " . (($jsonApiResponse['cnxToDB']) ? "True" : "False") . "";

				$dbquery =  $db2->query($queryCatalog['pgsql_find_lock']);
				while ($dbp = $dbquery->fetch(PDO::FETCH_ASSOC)) {
					if ($dbp['inst_nbr'] == 1) {
						$actionsOn['test_4_lock_found']($db_['host'] . ":" . $db_['port']);
					} else {
						$actionsOn['test_4_lock_not_found']($db_['host'] . ":" . $db_['port']);
					}
				}

			} catch (PDOException $e) {
				$actionsOn['test_2_db_not_found']($db_['dbprefix'], $e->getMessage());
			}
		} catch (PDOException $e) {
			$actionsOn['test_1_cnx_failed']($db_['host'] . ":" . $db_['port'], $e->getMessage());
		}

		break;

		// case "ADODB":
		// 	include_once ("/usr/share/php/adodb/adodb.inc.php");
		// 	$db = NewADOConnection($db_['type']);
		// 	$db->Connect( $db_['host'] , $db_['user_login'] , $db_['user_password'] , $db_['firstMysqlDb'] );
		// 	if ( $db->IsConnected() == FALSE ) {  }

		// 	$db2 = NewADOConnection($db_['type']);
		// 	$db2->Connect( $db_['host'] , $db_['user_login'] , $db_['user_password'] , $db_['dbprefix'] );
		// 	if ( $db2->IsConnected() == FALSE ) {  }
		// break;

		// case "PEARDB":
		// 	include_once ("MDB2.php");
		// 	if ( isset($db_['dbprefix']) ) { $_REQUEST['form']['dataBaseHostingPrefix'] = "/"; }
		// 	$db = MDB2::connect($db_['type']."://".$db_['user_login'].":".$db_['user_password']."@".$db_['host'] . $_REQUEST['form']['dataBaseHostingPrefix'] . $db_['firstMysqlDb'] ); 
		// 	if ( PEAR::isError($db) ) {  }

		// 	$db2 = MDB2::connect($db_['type']."://".$db_['user_login'].":".$db_['user_password']."@".$db_['host'] . $_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] ); 
		// 	if ( PEAR::isError($db2) ) {  }

		// break;

}

// --------------------------------------------------------------------------------------------



// --------------------------------------------------------------------------------------------
$messageLog[] = "Install_test_db - Ready to send results";

foreach ($messageLog as $m) {
	error_log($m);
}

header('Content-Type: application/json');
echo json_encode($jsonApiResponse);
// echo ( $reponse );

// --------------------------------------------------------------------------------------------
switch ($displayDebug) {
	case 1:
		echo ("<br>\r");
		switch ($db_['dal']) {
			case "MYSQLI":
				echo ("MYSQLI mysqli(" . $db_['host'] . "," . $db_['user_login'] . "," . $db_['user_password'] . "," . $_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] . ")" . $e . " | type = " . $db_['type'] . $dbError);
				break;
			case "PHPPDO":
				echo ("PHPPDO PDO = (" . $db_['type'] . ":host=" . $db_['host'] . ";dbname=" . $_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] . $db_['user_login'] . $db_['user_password'] . ")" . $e . " | type = " . $db_['type']);
				break;
				// case "ADODB":	echo ("ADODB " . $db_['type'] . " -> Connect( ".$db_['host']." , ".$db_['user_login']." , ".$db_['user_password']." , ".$_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] .") | type = ". $db_['type']);				break;
				// case "PEARDB":	echo ("MDB2::connect(".$db_['type']."://".$db_['user_login'].":".$db_['user_password']."@".$db_['host'] . $_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] .") | type = ". $db_['type']);								break;
		}
		break;
	default:
		break;
}
