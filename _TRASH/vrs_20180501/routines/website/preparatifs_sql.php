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
$localisation = " / preparatif_sql";
$_REQUEST['localisation'] .= $localisation;
statistique_checkpoint ("preparatif_sql");
$_REQUEST['localisation'] = substr ( $_REQUEST['localisation'] , 0 , (0 - strlen( $localisation )) );

/*
switch ( $db_['dal'] ) {
case "MYSQLI":									break;
case "PDOMYSQL":								break;
case "SQLITE":									break;
case "ADODB":									break;
case "PEARDB":									break;
case "PEARSQLITE":								break;
}
*/

$SQL_requete['nbr'] = 1;

// --------------------------------------------------------------------------------------------
// Connexion
// --------------------------------------------------------------------------------------------
switch ( $db_['dal'] ) {
case "MYSQLI":
	//if ( $db_['host'] == "localhost" ) { $db_['host'] = "127.0.0.1"; }
	$db = new mysqli( $db_['host'] , $db_['user_login'] , $db_['user_password'] , $b4dbprefix . $db_['dbprefix'] );
	if ($db->connect_error) {
		$_REQUEST['SQL_fatal_error'] = 1;
			$db_msg = $db->ErrorMsg();
			journalisation_evenement ( 2 , $_REQUEST['sql_initiateur'] , "MWM : ".$_REQUEST['tampon_commande'] , "ERR" , "PS_0_0001" , "connect_string = ".$db_['type']."://".$db_['user_login'].":***PASSWORD***@".$db_['host'] . $b4dbprefix . $db_['dbprefix'] );
	}
	else {
		$db->autocommit(TRUE);
		function disconnect_sql () {
			global $db;
			$db->close();
		}
	}
break;

case "PHPPDO":
	try { $db = new PDO( $db_['type'] . ":host=" . $db_['host'] . ";dbname=" . $b4dbprefix . $db_['dbprefix'] , $db_['user_login'] , $db_['user_password'] ); }
	catch (PDOException $e) { 
		$_REQUEST['SQL_fatal_error'] = 1;
			$db_msg = $db->ErrorMsg();
			journalisation_evenement ( 2 , $_REQUEST['sql_initiateur'] , "MWM : ".$_REQUEST['tampon_commande'] , "ERR" , "PS_0_0001" , "connect_string = ".$db_['type']."://".$db_['user_login'].":***PASSWORD***@".$db_['host'] . $b4dbprefix . $db_['dbprefix'] );
	}
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	function disconnect_sql () {
		global $db;
		$db->Close();
	}
break;

case "SQLITE":
	$db = MDB2::connect ("sqlite:///:memory:",NULL);
break;

case "ADODB":
	include_once ("/usr/share/php/adodb/adodb.inc.php");
	$db = NewADOConnection($db_['type']);
	$db->Connect( $db_['host'] , $db_['user_login'] , $db_['user_password'] , $b4dbprefix . $db_['dbprefix'] );
	if ( $db->IsConnected() == FALSE ) {
		$_REQUEST['SQL_fatal_error'] = 1;
			$db_msg = $db->ErrorMsg();
			journalisation_evenement ( 2 , $_REQUEST['sql_initiateur'] , "MWM : ".$_REQUEST['tampon_commande'] , "ERR" , "PS_0_0001" , "connect_string = ".$db_['type']."://".$db_['user_login'].":***PASSWORD***@".$db_['host'] . $b4dbprefix . $db_['dbprefix'] );
	}
	else { 
		$db->SetFetchMode(ADODB_FETCH_NUM);
		function disconnect_sql () {
			global $db;
			$db->Close();
		}
	}
break;

case "PEARDB":
	include_once ("MDB2.php");
	if ( isset($db_['dbprefix']) ) { $b4dbprefix = "/"; }
	$db = MDB2::connect($db_['type']."://".$db_['user_login'].":".$db_['user_password']."@".$db_['host'] . $b4dbprefix . $db_['dbprefix'] ); 
	if ( PEAR::isError($db) ) { $_REQUEST['SQL_tst_ok'] = 0; }

	if ( isset($db_['dbprefix']) ) { $b4dbprefix = "/"; }
	$db = MDB2::connect($db_['type']."://".$db_['user_login'].":".$db_['user_password']."@".$db_['host'] . $b4dbprefix . $db_['dbprefix'] );
	if ( PEAR::isError($db) ) {
		$_REQUEST['SQL_fatal_error'] = 1;
			$db_msg = $db->getMessage();
			$db_user = $db->getUserInfo();
			$db_debug = $db->getDebugInfo();
			journalisation_evenement ( 2 , $_REQUEST['sql_initiateur'] , "MWM : ".$_REQUEST['tampon_commande'] , "ERR" , "PS_0_0001" , "connect_string = ".$db_['type']."://".$db_['user_login'].":***PASSWORD***@".$db_['host'] . $b4dbprefix . $db_['dbprefix'] );
	}
	else {
		$db->setFetchMode(MDB2_FETCHMODE_ASSOC);
		$db->setErrorHandling(PEAR_ERROR_TRIGGER, E_USER_WARNING); //http://pear.php.net/manual/en/core.pear.pear.seterrorhandling.php
		function disconnect_sql () {
			global $db;
			$db->disconnect();
		}
	}
break;

case "PEARSQLITE":
	$db = MDB2::connect ("sqlite:///:memory:",NULL);
break;
}

//PDO		$db_result = $db->query($requete);

function requete_sql ( $initiateur , $requete ) {
	$SQL_temps_depart = microtime_chrono();
	global $SQL_requete , $db, $db_ , $statistiques_ , $statistiques_index;

	$SQL_index = $SQL_requete['nbr'];

	switch ( $db_['dal'] ) {
	case "MYSQLI":		$db_result = $db->query($requete);										break;
	case "PDOMYSQL":	$db_result = $db->prepare($requete); $db_result->execute();				break;
	case "SQLITE":																				break;
	case "ADODB":		$db_result = $db->Execute($requete);									break;
	case "PEARDB":		$db_result = $db->query($requete);										break;
	case "PEARSQLITE":																			break;
	}

	switch ( $db_['dal'] ) {
	case "MYSQLI":		$SQLlog['err_no'] = $db->errno;					$SQLlog['err_no_expr'] = "PHP MysqlI Err : " . $SQLlog['err_no'];	$SQLlog['err_msg'] = $db->error;						break;
	case "PDOMYSQL":	$SQLlog['err_no'] = $db->errorCode();			$SQLlog['err_no_expr'] = "PHP PDO Err : " . $SQLlog['err_no'];		$SQLlog['err_msg'] = $db->errorInfo();					break;
	case "SQLITE":																																													break;
	case "ADODB":		$SQLlog['err_no'] = $db->ErrorNo();				$SQLlog['err_no_expr'] = "ADOdb Err : " . $SQLlog['err_no']; 		$SQLlog['err_msg']	= $db->ErrorMsg();					break;
	case "PEARDB":
	case "PEARSQLITE":	$SQLlog['err_no'] = $db_result->getDebugInfo();	$SQLlog['err_no_expr'] = "PEAR DB err : " . $SQLlog['err_no']; 		$SQLlog['err_msg']	= $db_result->getMessage();			break;
	}

	$SQLlog['signal'] = "OK"; 
	$Niveau = $_REQUEST['debug_option']['SQL_debug_level'];

	switch ( $db_['dal'] ) {
	case "MYSQLI":		if ( $db->errno != 0 )					{ $SQLlog['signal'] = "ERR"; $Niveau = 0; };		break;
	case "PDOMYSQL":	if ( $db->errorCode() != 0 )			{ $SQLlog['signal'] = "ERR"; $Niveau = 0; };		break;
	case "SQLITE":																						break;
	case "ADODB":		if ( $db->ErrorNo() != 0 )				{ $SQLlog['signal'] = "ERR"; $Niveau = 0; };		break;
	case "PEARDB":
	case "PEARSQLITE":	if ( $db_result->getDebugInfo() != 0 )	{ $SQLlog['signal'] = "ERR"; $Niveau = 0; }; 		break;
	}

	if ( $_REQUEST['StatistiqueInsertion'] == 1 ) { $statistiques_[$statistiques_index]['SQL_queries']++; }

	if ( $_REQUEST['debug_option']['SQL_debug_level'] >= $Niveau ) {
		$SQL_requete[$SQL_index]['temps_debut'] = $SQL_temps_depart;
		$SQL_requete[$SQL_index]['nbr']			= $SQL_requete['nbr'];
		$SQL_requete[$SQL_index]['nom']			= $initiateur;
		$SQL_requete[$SQL_index]['signal']		= $SQLlog['signal'];
		$SQL_requete[$SQL_index]['requete']		= $requete;
		$SQL_requete[$SQL_index]['err_no']		= $SQLlog['err_no_expr'];
		$SQL_requete[$SQL_index]['err_msg']		= $SQLlog['err_msg'];
		$SQL_requete[$SQL_index]['temps_fin']	= microtime_chrono();
		$SQL_requete['nbr']++;
	}

	switch ( $_REQUEST['contexte_d_execution'] ) {	
	case "Installation":
		$_REQUEST['moniteur']['SQL_requete_nbr']++;
		$requete = tronquage_expression ( $requete , 256 ); 			
		journalisation_evenement ( 2 , $initiateur , $requete , $SQLlog['signal'] , $SQLlog['err_no'] , $SQL_requete[$SQL_index]['err_msg'] );
	break;
	}
	return $db_result;
}

function num_row_sql ($db_resultat_requete) {
	global $SQL_requete, $l, $db_;
	switch ( $db_['dal'] ) {
	case "MYSQLI":		$db_result = mysqli_num_rows($db_resultat_requete);		break;
	case "PDOMYSQL":	$db_result = $db_resultat_requete->rowCount();			break;
	case "SQLITE":																break;
	case "ADODB":		$db_result = $db_resultat_requete->RecordCount();		break;
	case "PEARDB":		$db_result = $db_resultat_requete->numRows();			break;
	case "PEARSQLITE":															break;
	}

	if ( $db_result == 0 ) {
		switch ( $_REQUEST['contexte_d_execution'] ) {	
		case "admin_menu":
		case "Admin_menu":
		case "Extension_installation":
		case "Rendu":
		default:
			$tl_['eng']['err_no']	= "Empty result";
			$tl_['fra']['err_no']	= "Pas de ligne retourn&eacute;e";
			$tl_['eng']['requete']	= "No result for this query.";
			$tl_['fra']['requete']	= "Aucune ligne retourn&eacute;e pour cette requete.";
			$SQL_index = $SQL_requete['nbr'] - 1;
			$SQL_requete[$SQL_index]['signal']	= "WARN";
			$SQL_requete[$SQL_index]['err_no']	= $tl_[$l]['err_no'];
			$SQL_requete[$SQL_index]['err_msg']	= $tl_[$l]['requete'];
			$SQL_requete[$SQL_index]['requete']	= $SQL_requete[$SQL_index]['requete'];
		break;
		}
	}
	return $db_result;
}


function fetch_array_sql ($db_resultat_requete) {
	global $db_;
	switch ( $db_['dal'] ) {
	case "MYSQLI":		$db_result = $db_resultat_requete->fetch_assoc();					break;
	case "PDOMYSQL":	$db_result = $db_resultat_requete->fetch(PDO::FETCH_ASSOC);			break;
	case "SQLITE":																			break;
	case "ADODB":		$db_result = $db_resultat_requete->fields;							break;
	case "PEARDB":		$db_result = $db_resultat_requete->FetchRow();						break;
	case "PEARSQLITE":																		break;
	}
	return $db_result;
}

?>
