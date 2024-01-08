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

class SddmPEARDB {
	private static $Instance = null;
	
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
	public function query($q) {}
	public function num_row_sql($res) {}
	public function fetch_array_sql($res) {
		return $res->FetchRow();
	}
	public function escapeString($res) {}
}

