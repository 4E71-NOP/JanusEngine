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

class LayoutParser {
	private static $Instance = null;

	/**
	 * Singleton : Will return the instance of this class.
	 * @return LayoutParser
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new LayoutParser();
		}
		return self::$Instance;
	}

	/**
	 * Analyze the data and returns an array
	 * @param string $layout
	 * 
	 * @return array
	 */
	public function getFragments($layout) {
		$bts = BaseToolSet::getInstance();
//		$CurrentSetObj = CurrentSet::getInstance();
		
		$Result = $map = array();
		preg_match_all( "/{{\s*\w*\s*\(\s*[('|\"|`)\w*('|\"|`)\s*]*\)\s*}}/", $layout, $Result, PREG_OFFSET_CAPTURE );
		$i = 0;
		$ptrStart = 0;
		foreach( $Result['0'] as $A ) {
			$bts->LMObj->msgLog ( array ('level' => LOGLEVEL_STATEMENT, 'msg' => __METHOD__ ." : Match! :`". $A['0'] ."` at position ". $A['1'] ) );
			
			// Match N°1 maybe is at position 0 so...
			// This case always is a command
			if ( $A['1'] == 0 ) { 
				$map[$i] = array(
					"type"	=> "Command",
					"data"	=> $A['0'],
				);
				$ptrStart = strlen($A['0']);
				$i++;
			}
			else {
				// Copy preceeding string
				$map[$i] = array(
					"type"	=> "string",
					"content"	=> substr($layout, $ptrStart, ($A['1'] - $ptrStart) ),
				);
				$i++;
				// Now the command
				$extract = array();
				$extract= array();
				preg_match ( "/('|\"|`)\w*('|\"|`)/", strtolower($A['0']), $extract);
				$map[$i] = array(
					"type"		=> "command",
					"data"		=> strtolower($A['0']),
					"module_name"	=> substr( $extract['0'] , 1 , -1),
				);
				$i++;
				$ptrStart = $A['1'] + strlen($A['0']);
			}
		}
		// Copying the last string
		if ( $ptrStart < strlen($layout) ) {
			$map[$i] = array(
				"type"	=> "string",
				"content"	=> substr($layout, $ptrStart, (strlen($layout) - $ptrStart ) ),
			);
		}
		return ($map);
	}

	//@formatter:off
	//@formatter:on

}
?>
