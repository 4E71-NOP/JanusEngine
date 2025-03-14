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

class Time {
	private static $Instance = null;
	
	private function __construct() {}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return Time
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new Time();
		}
		return self::$Instance;
	}
	
	/**
	 * Returns the time to the millisecond.
	 * @deprecated
	 * @return mixed
	 */
	public function micro_time_chrono() {
		return microtime ( TRUE );
	}

	/**
	 * Returns the time with millisecond.
	 * @return mixed
	 */
	public function getMicrotime() {
		return microtime(true);
	}

	/**
	 * Returns the hrTime (NanoSecond) as number.
	 * @return mixed
	 */
	public function getHrtime() {
		return hrtime(true);
	}

	/**
	 * Returns a date from a string.
	 * @param String $date
	 * @return number
	 */
	public function mktimeFromCanonical($date) {
		$tab_rch = array ("-", ":");		
		$tab_rpl = array (" ", " ");
		$date = str_replace ($tab_rch, $tab_rpl, $date);
		$pv = explode (" ", $date);
		$date = mktime ( intval($pv['3']), intval($pv['4']), intval($pv['5']), intval($pv['1']), intval($pv['2']), intval($pv['0']) );
		return $date;
	}
	
	/**
	 * Returns a date from a timestamp.
	 * @param Int $data
	 * @return string
	 */
	public function timestampToDate ( $data ) {
		return date ("Y-m-j G:i:s", $data);
	}
}
?>
