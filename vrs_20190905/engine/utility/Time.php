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

class Time {
	private static $Instance = null;
	
	private function __construct() {}
	
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new Time();
		}
		return self::$Instance;
	}
	
	
	public function microtime_chrono() {
		return microtime ( TRUE );
	}

	public function mktimeFromCanonical($date) {
		$tab_rch = array ("-", ":");		
		$tab_rpl = array (" ", " ");
		$date = str_replace ($tab_rch, $tab_rpl, $date);
		$pv = explode (" ", $date);
		$date = mktime ( intval($pv['3']), intval($pv['4']), intval($pv['5']), intval($pv['1']), intval($pv['2']), intval($pv['0']) );
		return $date;
	}
	
	public function timestampToDate ( $data ) {
		return date ("Y-m-j G:i:s", $data);
	}
}
?>
