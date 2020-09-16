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

class LibInstallationReport {
	private static $Instance = null;
	
	private function __construct() {}
	
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new LibInstallationReport();
		}
		return self::$Instance;
	}
	
	public function renderReport ( &$src , $style ) {
		reset ($src);
		$R = array();
		$counters= array('file' => 0, 'OK' => 0, 'WARN' => 0, 'ERR' => 0, );

		$l = 1;
		foreach ( $src as $A ) {
			$c = 1;
			if ( $l == 1 ) {
				foreach ( $style['titles'] as $B ) {
					$R[$l][$c]['cont']	= $B;
					$R[$l][$c]['tc']	= 4;
					$R[$l][$c]['sc']	= 8;
					$c++;
				}
				$c = 1;
				$l++;
			}
			foreach ( $style['cols'] as $B ) {
				$R[$l][$c]['tc']	= $style['tc'];
				if ( $B == "WARN" && $A[$B] > 0 ) { $R[$l][$c]['class'] = $style['block'] . "_avert" ;	$R[$l][$c]['b'] =1;	$R[$l][$c]['tc'] +=2; }
				if ( $B == "ERR"  && $A[$B] > 0 ) { $R[$l][$c]['class'] = $style['block'] . "_erreur";	$R[$l][$c]['b'] =1;	$R[$l][$c]['tc'] +=2; }
				$R[$l][$c]['cont']	= $A[$B];
				if ($c != 1 ) { $counters[$B] += $A[$B]; }
				$c++;
			}
			$l++;
		}
		// last values of the chart.
		unset ($B);
		$c = 1;
		foreach ( $style['cols'] as $B ) {			
			if ($c != 1 ) {
				$R[$l][$c]['tc']	= $style['tc'];
				if ( $B == "WARN" && $A[$B] > 0 ) { $R[$l][$c]['class'] = $style['block'] . "_avert" ;	$R[$l][$c]['tc'] +=2; }
				if ( $B == "ERR" && $A[$B] > 0 )  { $R[$l][$c]['class'] = $style['block'] . "_erreur";	$R[$l][$c]['tc'] +=2; }
				$R[$l][$c]['cont']	= $counters[$B];
				$R[$l][$c]['b'] =1;
			}
			$c++;
		}
		return $R;
	}


}