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

/**
 * Library designed for script formatting (prepare the command lines)
 */
class ScriptFormatting {
	private static $Instance = null;
	
	private function __construct() {}
	
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new ScriptFormatting();
		}
		return self::$Instance;
	}
	
	/**
	 * Create a map of several patterns found in the command string.
	 * 
	 * @param array $infos
	 */
	public function createMap ( &$infos){
// 		We create a map to ease the command processing.
		$endline = ( isset($infos['endline'])) ? $infos['endline'] : ";";
		$this->mapPattern ( "//" , 1 , 99999 , $infos );
		$this->mapPattern ( "\n" , 2 , 99998 , $infos );
		$this->mapPattern ( "/*" , 3 , 99997 , $infos );
		$this->mapPattern ( "*/" , 4 , 99996 , $infos );
		$this->mapPattern ( "'"  , 5 , 99995 , $infos );
		$this->mapPattern ( "\"" , 6 , 99994 , $infos );
		$this->mapPattern ( $endline  , 7 , 99993 , $infos );
		
		ksort ($infos['TabAnalyse']);
		reset ($infos['TabAnalyse']);
	}

	/**
	 * Create a map of a specific pattern in the command string.
	 * 
	 * @param String $pattern
	 * @param Number $code
	 * @param Number $poserr
	 * @param array $infos
	 */	
	private function mapPattern ( $pattern , $code, $poserr, &$infos ) {
		$increment = strlen($pattern);
		$ptr = $stop = 0;
		while ( $stop == 0 ) {
			$x = strpos( $infos['currentFileContent'] , $pattern , $ptr );
			if ( $x === FALSE ) {
				$infos['TabAnalyse'][$poserr] = $code;
				$stop = 1;
			}
			else {
				$infos['TabAnalyse'][$x] = $code;
				$ptr = $x+$increment;
			}
		}
		$infos['TabAnalyse']['99990'] = 8;				// EOF
	}
	
	/**
	 * Format the command string by removing comments, unnecessary spaces etc.
	 * @param array $infos
	 */
	public function commandFormatting (&$infos) {
		$TabRch01 = array ( "\n",	"\r",	"\t",	"    ",	"   ",	"  " );
		$TabRpl01 = array ( " ",	" ",	" ",	" ",	" ",	" ");
		$TabRpl02 = array ( "",		"",		" ",	" ",	" ",	" ");
// 		$strRch02 = array ( "",		"",		" ",	" " );
		$err = 0;
		
		$Map = &$infos['TabAnalyse'];
		$Buffer = &$infos['currentFileContent'];
		$Dest = &$infos['FormattedCommand'];
		
		$CaseMatrix = array (
				0 => array (	0,	1,	0,	3,	4,	5,	6,	98,	99	),
				1 => array (	0,	0,	12,	0,	0,	0,	0,	0,	99	),
				2 => array (	0,	0,	0,	0,	24,	0,	0,	0,	99	),
				3 => array (	0,	0,	0,	0,	0,	35,	0,	0,	99	),
				4 => array (	0,	0,	0,	0,	0,	0,	46,	0,	99	),
		);
		$compilation = "";
		$FCMode = $Ptr = $idx = 0;
		
		foreach ( $Map as $K => $A ) {
			if ( $K <= 99990 ) {
				$directive = $CaseMatrix[$FCMode][$A];
				switch ( $directive ) {
					case 1:		$FCMode = 1;	$compilation .= substr($Buffer, $Ptr, ($K-$Ptr));		$Ptr = $K;		break;		// set comment mode
					case 3:		$FCMode = 2;	$compilation .= substr($Buffer, $Ptr, ($K-$Ptr));		$Ptr = $K;		break;		// set multiline comment mode
					case 4:		$err = 1;																				break;		// error
					case 5:		$FCMode = 3;	$compilation .= substr($Buffer, $Ptr, ($K-$Ptr));		$Ptr = $K;		break;		// set citation1 mode
					case 6:		$FCMode = 4;	$compilation .= substr($Buffer, $Ptr, ($K-$Ptr));		$Ptr = $K;		break;		// set citation2 mode
					case 12:	$FCMode = 0;															$Ptr = $K+1;	break;		// set initial mode
					case 24:	$FCMode = 0;															$Ptr = $K+2;	break;		// set initial mode
					case 35:
					case 46:	$FCMode = 0;																			break;		// set initial mode
					case 98:
						$FCMode = 0;																								// set initial mode
						$compilation .= substr($Buffer, $Ptr, ($K-$Ptr));															// Copy last valid segment.
						$compilation = str_replace ( $TabRch01 , $TabRpl01 , $compilation );										//
						$Dest[$idx]['cont'] = $compilation;																			//
						$compilation = "";																							//
						$Ptr = $K+1;																								// Align pointers
						$idx++;
						break;
					case 99:
						$FCMode = 0;												// Back to initial mode
						$compilation .= substr($Buffer, $Ptr, ($K-$Ptr));			// Copy last valid segment
						$Ptr = $K+1;												// Align pointers
						$EOF = 1;
						break;
				}
			}
		}
		if ( isset($EOF) ) {
			$compilation = str_replace ( $TabRch01 , $TabRpl02 , $compilation );
			if ( $compilation != " " ) { $OEFspurt = 1; }
		}
		if ( strlen($compilation) > 0 ) {
			$Dest[$idx]['cont'] = $compilation;
			if ($OEFspurt == 1) { $Dest[$idx]['Ordre'] = 1; }
		}
		$compilation = "";
		if ($err == 1) { $Dest[$idx]['Ordre'] = 1; }
	}
	
	/**
	 * 
	 * Extract sql commands
	 * 
	 */
	// private function rawSqlExtraction (&$infos) {
	// 	$Map = &$infos['TabAnalyse'];
	// 	$Buffer = &$infos['currentFileContent'];
	// 	$Dest = &$infos['FormattedCommand'];

	// 	// 99993
	// 	foreach ( $Map as $K => $A ) {
	// 	}
	// }
	
	//@formatter:off
	//@formatter:on
	
	
}
?>