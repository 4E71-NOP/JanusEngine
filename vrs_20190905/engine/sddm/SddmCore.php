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
// --------------------------------------------------------------------------------------------

class SddmCore
{
	protected $report;

	public function __construct(){}

	/**
	 * Create an UID with random function
	 * @return string
	 */
	public function createUniqueId(){ 
		return random_int(1, 9223372036854775807); 
	}

	//@formatter:off
	public function getReport()	{ return $this->report;	}
	public function getReportEntry($data) { return $this->report[$data]; }
	public function setReport($report) { $this->report = $report; }
	//@formatter:on
}
