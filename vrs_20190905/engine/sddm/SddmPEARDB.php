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


// --------------------------------------------------------------------------------------------

/**
 * PEAR seems to be abandonned at the time
 * 
 * @deprecated
 */
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
	public function query($q, $log = SDDM_QUERY_DEFAULT_LOG) {}
	public function num_row_sql($res) {}
	public function fetch_array_sql($res) {
		return $res->FetchRow();
	}
	public function escapeString($res) {}
}

