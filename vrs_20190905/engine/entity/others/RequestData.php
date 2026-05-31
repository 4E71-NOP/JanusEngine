<?php
 // @JanusEngine:license-start
// --------------------------------------------------------------------------------------------
// Janus Engine 
//
// This file file is part of the Janus-Engine project.
// @see      : https://github.com/4E71-NOP/JanusEngine
//
// @license  : Creative Commons licence CC-by-nc-sa (https://creativecommons.org/licenses/by-nc-sa/4.0/)
// @author   : Faust MARIA DE AREVALO (original founder) <faust@rootwave.com>
// @copyright : 2005 - ∞ Faust MARIA DE AREVALO
//
// @note     : This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY; 
//             without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
//
// Check README.md for more details
// --------------------------------------------------------------------------------------------
// @JanusEngine:license-end


class RequestData {
	private static $Instance = null;
	
	private $RequestDataArray = array(
			"ws" => null,
			"formSubmitted" => null,
			"formGenericData" => null,
	);

	private function __construct(){
		foreach ( $_REQUEST as $A => $B ) {
			$this->RequestDataArray[$A] = $B;
		}
	}
	
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new RequestData();
		}
		return self::$Instance;
	}
	
	//@formatter:off
	public function getRequestData () { return $this->RequestDataArray; }

	public function getRequestDataEntry ($data) { return $this->RequestDataArray[$data]; }
	public function getRequestDataSubEntry ($lvl1, $lvl2) { return $this->RequestDataArray[$lvl1][$lvl2]; }
	
	public function setRequestDataEntry ($entry, $data) { $this->RequestDataArray[$entry] = $data; }
	public function setRequestDataSubEntry ($lvl1, $lvl2, $data) { $this->RequestDataArray[$lvl1][$lvl2] = $data; }
	
	public function getRequestDataArray() { return $this->RequestDataArray; }
	public function setRequestData ($data, $val) { return $this->RequestDataArray[$data] = $val; }
	//@formatter:on
	
}

?>
