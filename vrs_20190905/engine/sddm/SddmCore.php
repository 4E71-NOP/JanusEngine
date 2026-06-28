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
		// 1782596073
		// 17825934884004        = Timestamp microsecond 14 digits
		// 92233720368547 75807	 = max int length int 19 digits
		// 9 223 372 036 854 775 807 - BIGINT max


class SddmCore
{
	protected $report;

	public function __construct() {}

	/**
	 * Create an UID with random function
	 * 
	 * This is not UUIDv7. It's stong enough to prevent any collision though.
	 * 
	 * This system has been elected as the different DB systems (one or all) do NOT 
	 *  - support the UUIDv7 natively
	 *  - support dedicated data type (so we don't have to play with BINARY(16))
	 *  - provide similar syntax environement, needs and solutions to handle this. (it's painful at best).
	 * 
	 * @return string
	 */
	public function createUniqueId()
	{
		$m = _ID_CREATION_METHOD_;
		switch ($m) {
			case _RANDOM_INT_:
				return random_int(1, 9223372036854775807);
				break;
			case _MICROTIME_RAND_:
				return (substr((microtime(true) * 10000),-9) . random_int(1, 9999999999));
				break;
		}
	}


	protected function logToSqlDetails($q, $SQLlogEntry, $timeBegin)
	{
		$bts = BaseToolSet::getInstance();
		$bts->LMObj->increaseSqlQueryNumber();
		$q = $bts->StringFormatObj->shorteningExpression($q, 256);
		$bts->LMObj->logSQLDetails(
			array(
				$timeBegin,
				$bts->LMObj->getSqlQueryNumber(),
				$bts->MapperObj->getWhereWeAreAt(),
				$SQLlogEntry['signal'],
				$q,
				$SQLlogEntry['err_no_expr'],
				$SQLlogEntry['err_msg'],
				$bts->TimeObj->getMicrotime(),
			)
		);

		$bts->LMObj->msgLog(array('level' => LOGLEVEL_DEBUG_LVL0, 'msg' => __METHOD__ . " : " . $bts->StringFormatObj->print_r_debug($SQLlogEntry) . "`."));
	}

	//@formatter:off
	public function getReport()	{ return $this->report;	}
	public function getReportEntry($data) { return $this->report[$data]; }
	public function setReport($report) { $this->report = $report; }
	//@formatter:on

}
