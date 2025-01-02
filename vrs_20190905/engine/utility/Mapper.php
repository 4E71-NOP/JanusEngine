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

class Mapper {
	private static $Instance = null;
	
	private $WhereWeAreAt = "Index";
	private $SqlApplicant = "Index";
	
	private function __construct(){}
	
	/**
	 * Singleton : Will return the instance of this class.
	 * @return Mapper
	 */
	public static function getInstance() {
		if (self::$Instance == null) {
			self::$Instance = new Mapper();
		}
		return self::$Instance;
	}
	
	/**
	 * Insert in the WhereWeAreAt array a breakpoint.
	 * @param String $data
	 */
	public function AddAnotherLevel ( $data ) {
		$this->WhereWeAreAt .= $data; 
	}

	/**
	 * Removes a breakpoint from the WhereWeAreAt array.
	 * @param String $data
	 */
	public function RemoveThisLevel ( $data ) {
		$this->WhereWeAreAt = substr ( $this->WhereWeAreAt , 0 , (0 - strlen( $data)) );
	}

	//@formatter:off
	public function getWhereWeAreAt() { return $this->WhereWeAreAt; }
	public function setWhereWeAreAt($WhereAreWeAt) { $this->WhereWeAreAt = $WhereAreWeAt; }

	public function getSqlApplicant() { return $this->SqlApplicant; }
	public function setSqlApplicant($SqlApplicant) { $this->SqlApplicant = $SqlApplicant; }
	//@formatter:on
	
}



?>