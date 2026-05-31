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