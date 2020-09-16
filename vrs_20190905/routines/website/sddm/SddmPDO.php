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

class SddmPDO {
	private static $Instance = null;
	
	private $DBInstance = 0;
	private $SDDMTools = 0;
	
	public function __construct(){
		$this->SDDMTools = new SddmTools();
	}
	
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new SddmMySQLI();
		}
		return self::$Instance;
	}
	
	public function connect(){}
	
	public function query($q) {
		global $SQL_requete, $db, $db_, $statistiques_, $statistiques_index, $LMObj, $TimeObj;
		$SQL_temps_depart = $TimeObj->microtime_chrono ();
		
		$SQL_index = $SQL_requete['nbr'];
		$db_result = $db->prepare($q); $db_result->execute();
		$SQLlog['err_no'] = $db->errorCode();
		$SQLlog['err_no_expr'] = "PHP PDO Err : " . $SQLlog['err_no'];
		$SQLlog['err_msg'] = $db->errorInfo();
		
		$SQLlog['signal'] = "OK";
		$Niveau = $_REQUEST['debug_option']['SQL_debug_level'];
		if ( $db->errorCode() != 0 )			{ $SQLlog['signal'] = "ERR"; $Niveau = 0; };
		
		if ( $_REQUEST['StatistiqueInsertion'] == 1 ) { $statistiques_[$statistiques_index]['SQL_queries']++; }
		
		if ( $_REQUEST['debug_option']['SQL_debug_level'] >= $Niveau ) {
			$LMObj->logSQLDetails ( array ( $SQL_temps_depart, $SQL_requete ['nbr'], $i, $SQLlog ['signal'], $q, $SQLlog ['err_no_expr'], $SQLlog ['err_msg'], $TimeObj->microtime_chrono () ) );
		}
		
		switch ( $_REQUEST['contexte_d_execution'] ) {
			case "Installation":
				$_REQUEST['moniteur']['SQL_requete_nbr']++;
				$q = tronquage_expression ( $q , 256 );
				journalisation_evenement ( 2 , $i , $q , $SQLlog['signal'] , $SQLlog['err_no'] , $SQL_requete[$SQL_index]['err_msg'] );
				break;
		}
		return $db_result;
		
	}
	public function num_row_sql($res) {
		return $res->rowCount();
	}
	public function fetch_array_sql($res) {
		return $res->fetch(PDO::FETCH_ASSOC);
	}
	public function escapeString($res) {
		global  $db;
		$db->real_escape_string($res);
	}
	
}

?>
