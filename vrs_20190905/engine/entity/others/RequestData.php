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
