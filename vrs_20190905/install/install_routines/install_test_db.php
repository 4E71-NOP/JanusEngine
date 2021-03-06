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
$db_['type']					= $_REQUEST['form']['database_type_choix'];
$db_['host']					= $_REQUEST['form']['host'];
$db_['user_login']				= $_REQUEST['form']['db_hosting_prefix'] . $_REQUEST['form']['db_admin_user'];
$db_['user_password']			= $_REQUEST['form']['db_admin_password'];
$db_['tabprefix']				= $_REQUEST['form']['prefix_des_tables'];
$db_['database_user_login']		= $_REQUEST['form']['db_hosting_prefix'] . $_REQUEST['form']['database_user_login'];
$db_['database_user_password']	= $_REQUEST['form']['database_user_password'];
$db_['dbprefix']				= $_REQUEST['form']['db_hosting_prefix'] . $_REQUEST['form']['dbprefix'];
$db_['dbprefix2']				= "mysql";

// --------------------------------------------------------------------------------------------
$_REQUEST['SQL_tst']['1'] = $_REQUEST['SQL_tst']['2'] = 1;

switch ( $debug ) {
case 1:
	error_log ("-----------------------------------------------------------");
	switch ( $db_['dal'] ) {
	case "MYSQLI":		error_log ("MYSQLI mysqli(". $db_['host'].",". $db_['user_login'] .",". $db_['user_password'] .",". $_REQUEST['form']['db_hosting_prefix'] . $db_['dbprefix'] .")" . $e ." | type = ". $db_['type']);												break;
	case "PHPPDO":		error_log ("PHPPDO PDO = (".$db_['type'] . ":host=" . $db_['host'] . ";dbname=" . $_REQUEST['form']['db_hosting_prefix'] . $db_['dbprefix'] , $db_['user_login'] , $db_['user_password'] .")" . $e ." | type = ". $db_['type']);					break;
	case "ADODB":		error_log ("ADODB " . $db_['type'] . " -> Connect( ".$db_['host']." , ".$db_['user_login']." , ".$db_['user_password']." , ".$_REQUEST['form']['db_hosting_prefix'] . $db_['dbprefix'] .") | type = ". $db_['type']);								break;
	case "PEARDB":		error_log ("MDB2::connect(".$db_['type']."://".$db_['user_login'].":".$db_['user_password']."@".$db_['host'] . $_REQUEST['form']['db_hosting_prefix'] . $db_['dbprefix'] .") | type = ". $db_['type']);												break;
	}
	error_log ( "fin log : " . $db_['dal'] ."/". $db_['type'] );
}
$dbError = "<hr>\r";
switch ( $db_['dal'] ) {
case "MYSQLI":
	$db1 = new mysqli( $db_['host'] , $db_['user_login'] , $db_['user_password'], $db_['dbprefix2'] );
	if ($db1->connect_error) { $_REQUEST['SQL_tst']['1'] = 0; $dbError .= $db_['dbprefix'] .": ". $db1->connect_error; }

	$db2 = new mysqli( $db_['host'] , $db_['user_login'] , $db_['user_password'], $db_['dbprefix'] );
	if ($db2->connect_error) { $_REQUEST['SQL_tst']['2'] = 0; $dbError .= "<br>" . $db_['dbprefix2'] .": ".$db2->connect_error; }
break;

case "PHPPDO":
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
	if ( isset($db_['dbprefix']) ) { $_REQUEST['form']['db_hosting_prefix'] = "/"; }
	$db = MDB2::connect($db_['type']."://".$db_['user_login'].":".$db_['user_password']."@".$db_['host'] . $_REQUEST['form']['db_hosting_prefix'] . $db_['dbprefix2'] ); 
	if ( PEAR::isError($db) ) { $_REQUEST['SQL_tst']['1'] = 0; }

	$db2 = MDB2::connect($db_['type']."://".$db_['user_login'].":".$db_['user_password']."@".$db_['host'] . $_REQUEST['form']['db_hosting_prefix'] . $db_['dbprefix'] ); 
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
echo ( $reponse );

// --------------------------------------------------------------------------------------------
switch ( $displayDebug ) {
	case 1:
		echo("<br>\r");
		switch ( $db_['dal'] ) {
			case "MYSQLI":	echo ("MYSQLI mysqli(". $db_['host'].",". $db_['user_login'] .",". $db_['user_password'] .",". $_REQUEST['form']['db_hosting_prefix'] . $db_['dbprefix'] .")" . $e ." | type = ". $db_['type'] . $dbError);				break;
		case "PHPPDO":	echo ("PHPPDO PDO = (".$db_['type'] . ":host=" . $db_['host'] . ";dbname=" . $_REQUEST['form']['db_hosting_prefix'] . $db_['dbprefix'] . $db_['user_login'] . $db_['user_password'] .")" . $e ." | type = ". $db_['type']);		break;
		case "ADODB":	echo ("ADODB " . $db_['type'] . " -> Connect( ".$db_['host']." , ".$db_['user_login']." , ".$db_['user_password']." , ".$_REQUEST['form']['db_hosting_prefix'] . $db_['dbprefix'] .") | type = ". $db_['type']);				break;
		case "PEARDB":	echo ("MDB2::connect(".$db_['type']."://".$db_['user_login'].":".$db_['user_password']."@".$db_['host'] . $_REQUEST['form']['db_hosting_prefix'] . $db_['dbprefix'] .") | type = ". $db_['type']);								break;
		}
	break;
	default :
	break;
}
?>
