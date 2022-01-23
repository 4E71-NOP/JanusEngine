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
//	Test DB cnx
// --------------------------------------------------------------------------------------------
$debug = 0;
$displayDebug = 0;

switch ( $debug ) {
	case 1:
		error_reporting(E_ERROR);
		ini_set('display_errors','On'); 
	break;
	default :
		error_reporting(0);
	break;
}

$db_ = array();
$db_['dal']						= $_REQUEST['form']['dal'];
$db_['type']					= $_REQUEST['form']['selectedDataBaseType'];
$db_['host']					= $_REQUEST['form']['host'];
$db_['user_login']				= $_REQUEST['form']['dataBaseHostingPrefix'] . $_REQUEST['form']['dataBaseAdminUser'];
$db_['user_password']			= $_REQUEST['form']['dataBaseAdminPassword'];
$db_['tabprefix']				= $_REQUEST['form']['prefix_des_tables'];
$db_['dataBaseUserLogin']		= $_REQUEST['form']['dataBaseHostingPrefix'] . $_REQUEST['form']['dataBaseUserLogin'];
$db_['dataBaseUserPassword']	= $_REQUEST['form']['dataBaseUserPassword'];
$db_['dbprefix']				= $_REQUEST['form']['dataBaseHostingPrefix'] . $_REQUEST['form']['dbprefix'];
$db_['dbprefix2']				= "mysql";

// --------------------------------------------------------------------------------------------
$_REQUEST['SQL_tst']['1'] = $_REQUEST['SQL_tst']['2'] = 1;

switch ( $debug ) {
case 1:
	error_log ("-----------------------------------------------------------");
	switch ( $db_['dal'] ) {
	case "PHP":			error_log ("MYSQLI mysqli(". $db_['host'].",". $db_['user_login'] .",". $db_['user_password'] .",". $_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] .")" . $e ." | type = ". $db_['type']);												break;
	case "PDO":			error_log ("PHPPDO PDO = (".$db_['type'] . ":host=" . $db_['host'] . ";dbname=" . $_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] , $db_['user_login'] , $db_['user_password'] .")" . $e ." | type = ". $db_['type']);					break;
	case "ADODB":		error_log ("ADODB " . $db_['type'] . " -> Connect( ".$db_['host']." , ".$db_['user_login']." , ".$db_['user_password']." , ".$_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] .") | type = ". $db_['type']);								break;
	case "PEARDB":		error_log ("MDB2::connect(".$db_['type']."://".$db_['user_login'].":".$db_['user_password']."@".$db_['host'] . $_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] .") | type = ". $db_['type']);												break;
	}
	error_log ( "fin log : " . $db_['dal'] ."/". $db_['type'] );
}
$dbError = "<hr>\r";

$jsonApiResponse = array(
		"cnxToDB"					=>	true,
		"HydrDBAlreadyExist"		=>	false,
		"HydrBDDuserPermission"		=>	false,
	// 	"HydrBDDuserExists"			=>	false,
);

switch ( $db_['dal'] ) {
//	PHP/Mysqli ------------------------------------------------------------------------------------
	case "PHP":
		switch ( $db_['type'] ) {
			case "mysqli":
				$db1 = new mysqli( $db_['host'] , $db_['user_login'] , $db_['user_password'], $db_['dbprefix2'] );
				if ($db1->connect_error) { 
					$_REQUEST['SQL_tst']['1'] = 0; $dbError .= $db_['dbprefix'] .": ". $db1->connect_error; 
					$jsonApiResponse['cnxToDB']	= false;
				}
				
				$db2 = new mysqli( $db_['host'] , $db_['user_login'] , $db_['user_password'], $db_['dbprefix'] );
				if ($db2->connect_error) { 
					$_REQUEST['SQL_tst']['2'] = 0; $dbError .= "<br>" . $db_['dbprefix2'] .": ".$db2->connect_error;
				}
				else {
					$jsonApiResponse['HydrDBAlreadyExist']	= true;
				}
				break;
			case "pssql":
				$db1 = pg_connect("host=".$db_['host']." user=".$db_['user_login']." password=".$db_['user_password']);
				if ( $db1 == false ) {
					$_REQUEST['SQL_tst']['1'] = 0; $dbError .= $db_['dbprefix'] .": ". $db1; 
					$jsonApiResponse['cnxToDB']	= false;
				}
				$db2 = pg_connect("host=".$db_['host']." user=".$db_['user_login']." password=".$db_['user_password']. " dbname=".$db_['dbprefix'] );
				if ($db2 == false ) { 
					$_REQUEST['SQL_tst']['2'] = 0; $dbError .= "<br>" . $db_['dbprefix2'] .": ".$db2;
				}
				else {
					$jsonApiResponse['HydrDBAlreadyExist']	= true;
				}
				break;
		}
	break;

//	PHP/PDO ------------------------------------------------------------------------------------
	case "PDO":
	try {
	$db = new PDO( $db_['type'] . ":host=" . $db_['host'] . ";dbname=" . $db_['dbprefix2'] , $db_['user_login'] , $db_['user_password'] ); }
	catch (PDOException $e) { $_REQUEST['SQL_tst']['1'] = 0; }

	try {
	$db2 = new PDO( $db_['type'] . ":host=" . $db_['host'] . ";dbname=" . $db_['dbprefix'] , $db_['user_login'] , $db_['user_password'] ); }
	catch (PDOException $e) { $_REQUEST['SQL_tst']['2'] = 0; }
break;

case "ADODB":
	include_once ("/usr/share/php/adodb/adodb.inc.php");
	$db = NewADOConnection($db_['type']);
	$db->Connect( $db_['host'] , $db_['user_login'] , $db_['user_password'] , $db_['dbprefix2'] );
	if ( $db->IsConnected() == FALSE ) { $_REQUEST['SQL_tst']['1'] = 0; }

	$db2 = NewADOConnection($db_['type']);
	$db2->Connect( $db_['host'] , $db_['user_login'] , $db_['user_password'] , $db_['dbprefix'] );
	if ( $db2->IsConnected() == FALSE ) { $_REQUEST['SQL_tst']['2'] = 0; }
break;

case "PEARDB":
	include_once ("MDB2.php");
	if ( isset($db_['dbprefix']) ) { $_REQUEST['form']['dataBaseHostingPrefix'] = "/"; }
	$db = MDB2::connect($db_['type']."://".$db_['user_login'].":".$db_['user_password']."@".$db_['host'] . $_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix2'] ); 
	if ( PEAR::isError($db) ) { $_REQUEST['SQL_tst']['1'] = 0; }

	$db2 = MDB2::connect($db_['type']."://".$db_['user_login'].":".$db_['user_password']."@".$db_['host'] . $_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] ); 
	if ( PEAR::isError($db2) ) { $_REQUEST['SQL_tst']['2'] = 0; }

break;
}

// --------------------------------------------------------------------------------------------


$reponse = "<br>\r";
switch ( $_REQUEST['SQL_tst']['1'] ) {
	case 0 :	$reponse .= "TST1-NOK<br>\r";	break;
	case 1 :	$reponse .= "TST1-OK<br>\r";	break;
	
}
switch ( $_REQUEST['SQL_tst']['2'] ) {
	case 0 :	$reponse .= "TST2-NOK<br>\r";	break;
	case 1 :	$reponse .= "TST2-OK<br>\r";	break;
	
}

// --------------------------------------------------------------------------------------------
header('Content-Type: application/json');
echo json_encode($jsonApiResponse);
// echo ( $reponse );

// --------------------------------------------------------------------------------------------
switch ( $displayDebug ) {
	case 1:
		echo("<br>\r");
		switch ( $db_['dal'] ) {
			case "MYSQLI":	echo ("MYSQLI mysqli(". $db_['host'].",". $db_['user_login'] .",". $db_['user_password'] .",". $_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] .")" . $e ." | type = ". $db_['type'] . $dbError);				break;
		case "PHPPDO":	echo ("PHPPDO PDO = (".$db_['type'] . ":host=" . $db_['host'] . ";dbname=" . $_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] . $db_['user_login'] . $db_['user_password'] .")" . $e ." | type = ". $db_['type']);		break;
		case "ADODB":	echo ("ADODB " . $db_['type'] . " -> Connect( ".$db_['host']." , ".$db_['user_login']." , ".$db_['user_password']." , ".$_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] .") | type = ". $db_['type']);				break;
		case "PEARDB":	echo ("MDB2::connect(".$db_['type']."://".$db_['user_login'].":".$db_['user_password']."@".$db_['host'] . $_REQUEST['form']['dataBaseHostingPrefix'] . $db_['dbprefix'] .") | type = ". $db_['type']);								break;
		}
	break;
	default :
	break;
}
?>
