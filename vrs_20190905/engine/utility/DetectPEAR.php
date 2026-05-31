<?php
// // @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see       : https://github.com/4E71-NOP/JanusEngine
//
// @license   : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author    : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note      : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//              without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end



class DetectPEAR {
	private static $Instance = null;
	
	private function __construct(){}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return DetectPEAR
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new DetectPEAR();
		}
		return self::$Instance;
	}
	
	//  sudo pear list
	//  sudo pear install MDB2_Driver_sqlite
	//  sudo pear list
	//  sudo pear upgrade-all
	//
	//xxxxx@xxxxx:/usr/share/php$ pear list
	//Installed packages, channel pear.php.net:
	//=========================================
	//Package            Version State
	//Archive_Tar        1.3.3   stable
	//Console_Getopt     1.2.3   stable
	//DB                 1.7.13  stable
	//MDB2               2.4.1   stable
	//MDB2_Driver_mysql  1.4.1   stable
	//MDB2_Driver_sqlite 1.4.1   stable
	//PEAR               1.8.1   stable
	//Structures_Graph   1.0.2   stable
	//XML_Util           1.2.1   stable
	
	// Doctrine = /usr/share/php/Doctrine/lib/Doctrine
	
	public function detectSupport () {
		$B = "EXECNOTFOUND: The exec function isn't available. The test will not be performed.";
		if ( function_exists( 'exec' ) ) {
			$pv['exec_state'] = 1;
			exec ( "/usr/bin/pear list" , $PEAR , $pv['exec_state'] );
			if ( $pv['exec_state'] == 0 ) {
				foreach ( $PEAR as $A ) {
					if ( strpos ( $A , "MDB2_Driver_mysql" ) !== FALSE ) { $B .= $A; }
					if ( strpos ( $A , "MDB2_Driver_mysqli" ) !== FALSE ) { $B .= $A; }
					if ( strpos ( $A , "MDB2_Driver_sqlite" ) !== FALSE  ) { $B .= $A; }
				}
			}
		}
		return ( $B );
	}
}

?>